<?php

namespace App\Traits;

use App\Exceptions\ExceptionHandler;
use Exception;
use Stripe\Customer;
use Stripe\EphemeralKey;
use Stripe\Stripe;

trait StripeTrait
{
    private function setStripeApiKey()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    private function createStripeCustomer()
    {
        try {
            return Customer::create([
                'email' => auth()->user()->email,
            ])->id;
        } catch (Exception $e) {
            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

    private function createEphemeralKey($customerId)
    {
        try {
            return EphemeralKey::create(
                ['customer' => $customerId],
                ['stripe_version' => env('STRIPE_VERSION')],
                ['api_key' => env('STRIPE_SECRET')]
            );
        } catch (Exception $e) {
            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

    private function createPaymentIntent($customerId, $request)
    {
        try {
            $this->setStripeApiKey();
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            return $stripe->paymentIntents->create([
                'amount' => $request->amount,
                'currency' => $request->currency,
                'payment_method_types' => [config('enums.payment_method_types')],
            ])->client_secret;

        } catch (Exception $e) {
            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }
}
