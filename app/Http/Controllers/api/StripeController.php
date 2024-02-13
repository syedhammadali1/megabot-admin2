<?php

namespace App\Http\Controllers\api;

use App\Exceptions\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Traits\StripeTrait;
use Exception;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    use StripeTrait;

    public function getStripeKeys(Request $request)
    {
        try {
            $this->setStripeApiKey();

            $customerId = $this->createStripeCustomer();
            $ephemeralKey = $this->createEphemeralKey($customerId);
            $paymentIntent = $this->createPaymentIntent($customerId, $request);

            return response()->json([
                'customer_id' => $customerId,
                'ephemeral_key' => $ephemeralKey,
                'payment_intent' => $paymentIntent,
                'success' => true,
            ]);
        } catch (Exception $e) {
            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }
}
