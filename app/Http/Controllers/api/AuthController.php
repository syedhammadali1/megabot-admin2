<?php

namespace App\Http\Controllers\api;

use App\Exceptions\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\SocialLoginRequest;
use App\Mail\ForgotPassword;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $settings = Setting::first();

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->messages()->first(), 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'coins' => $settings->general_settings['free_chat_limit'],
                'profile_image' => $request->profile_image,
            ]);

            DB::commit();

            return [
                'access_token' => $user->createToken('auth_token')->plainTextToken,
                'success' => true,
            ];
        } catch (Exception $e) {

            DB::rollback();
            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

    public function login(Request $request)
    {
        try {

            $user = $this->verifyLogin($request);
            if (!Hash::check($request->password, $user->password)) {
                throw new Exception('credentials do not match with our records!', 400);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'access_token' => $token,
                'success' => true,
            ];
        } catch (Exception $e) {

            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

    public function verifyLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages()->first(), 422);
        }

        $user = User::where([['email', $request->email], ['status', true]])->first();
        if (!$user) {
            throw new Exception('this user not exists or deactivate', 400);
        }

        return $user;
    }

    public function self()
    {
        $user = User::find(auth('sanctum')->user()->id);

        return [
            'user' => $user,
            'success' => true,
        ];
    }

    public function forgotPassword(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->messages()->first(), 422);
            }
            $otp = $this->generateOtp($request);
            if (isset($request->email)) {
                Mail::to($request->email)->send(new ForgotPassword($otp));
            }

            return [
                'message' => 'We have verification code in registered detailed!',
                'success' => true,
            ];
        } catch (Exception $e) {
            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

    public function generateOtp($request)
    {
        $otp = rand(111111, 999999);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'otp' => $otp,
            'created_at' => Carbon::now(),
        ]);

        return $otp;
    }

    public function verifyToken(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->messages()->first(), 422);
            }

            $user = DB::table('password_resets')
                ->where('otp', $request->otp)
                ->where(function ($query) use ($request) {
                    $query->where('email', $request->email);
                })
                ->where('created_at', '>', Carbon::now()->subHours(1))
                ->first();

            if (!$user) {
                throw new Exception('Either your email or otp is wrong.', 400);
            }

            return [
                'message' => 'Verification Code is Verified',
                'success' => true,
            ];
        } catch (Exception $e) {

            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

    public function updatePassword(Request $request)
    {
        DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
                'otp' => 'required',
                'email' => 'email|max:255|exists:users',
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->messages()->first(), 422);
            }

            $user = DB::table('password_resets')
                ->where('otp', $request->otp)
                ->where(function ($query) use ($request) {
                    $query->where('email', $request->email);
                })
                ->where('created_at', '>', Carbon::now()->subHours(1))
                ->first();

            if (!$user) {
                throw new Exception('Either your email or token is wrong.', 400);
            }

            User::where(function ($query) use ($request) {
                $query->where('email', $request->email);
            })->update(['password' => Hash::make($request->password)]);

            DB::table('password_resets')->where('otp', $request->otp)
                ->where(function ($query) use ($request) {
                    $query->where('email', $request->email);
                })
                ->where('created_at', '>', Carbon::now()->subHours(1))
                ->delete();

            DB::commit();

            return [
                'message' => 'Your password has been changed!',
                'success' => true,
            ];
        } catch (Exception $e) {

            DB::rollback();
            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

    public function socialLogin(SocialLoginRequest $request)
    {
        $loginMethod = $request->input('login_with');
        $user = (object) $request->input('user');

        DB::beginTransaction();
        try {
            $user = $this->createOrGetUser($loginMethod, $user);

            DB::commit();

            if ($user->status) {
                return response()->json([
                    'success' => true,
                    'token' => $user->createToken('Sanctom')->plainTextToken,
                ], 200);
            }

            throw new Exception('This user is deactivated', 403);
        } catch (Exception $e) {
            DB::rollback();
            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

    private function createOrGetUser($loginMethod, $user)
    {
        $settings = Setting::first();
        if ($loginMethod === 'phone') {
            $phone = $user->phone;
            $code = $user->code;

            $existingUser = User::where('phone', $phone)->first();

            if ($existingUser) {
                return $existingUser;
            }

            return User::create([
                'status' => true,
                'phone' => $phone,
                'coins'=>$settings->general_settings['free_chat_limit'],
                'code' => $code,
            ]);
        }

        $email = $user->email;
        $name = $user->name;

        $existingUser = User::where('email', $email)->first();

        if ($existingUser) {
            return $existingUser;
        }

        return User::create([
            'status' => true,
            'coins'=> $settings->general_settings['free_chat_limit'],
            'email' => $email ?? null,
            'name' => $name ?? null,
        ]);
    }

    public function logout(Request $request)
    {
        try {

            $token = PersonalAccessToken::findToken($request->bearerToken());
            if (!$token) {
                throw new Exception('Selected Access token is Invalid', 400);
            }

            $token->delete();

            return [
                'message' => 'User Logout',
                'success' => true,
            ];
        } catch (Exception $e) {

            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }
}
