<?php

namespace App\Services;

use Illuminate\Support\Str;
use Stripe\StripeClient;

class StripeService
{
    private ?string $secretKey;
    private string $version = "2025-05-28.basil";
    private array $paymentMethods = [
        'card',
    ];
    private string $statementDescriptor = 'PHDCARRENT';
    private StripeClient $stripe;


    public function __construct()
    {
        $this->secretKey = config('stripe.secret_key');

        $this->stripe = $this->getClient();
    }

    private function getClient(): StripeClient
    {
        return new StripeClient([
            "api_key" => $this->secretKey,
            "stripe_version" => $this->version
        ]);
    }

    public function createPaymentIntent($amount, string $currency, $description = null, $metaData = [])
    {
        $paymentIntent = $this->stripe->paymentIntents->create([
            // 'statement_descriptor' => $this->statementDescriptor,
            // 'automatic_payment_methods' => ['enabled' => true],
            'payment_method_types' => $this->paymentMethods,
            'description' => $description,
            'currency' => Str::lower($currency),
            'amount' => $amount * 100,
            'metadata' => $metaData,

        ]);

        return $paymentIntent->toArray();
    }

    public function retrivePaymentIntent($paymentIntentId)
    {
        $paymentIntent = $this->stripe->paymentIntents->retrieve($paymentIntentId);

        return $paymentIntent->toArray();
    }

    public function getStripeClient(): StripeClient
    {
        return $this->getClient();
    }

    public function retrieveCharge(mixed $latest_charge)
    {
        $charge = $this->stripe->charges->retrieve($latest_charge);

        return $charge->toArray();
    }
}
