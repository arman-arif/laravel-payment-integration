<?php

use App\Models\Payment;
use App\Services\StripeService;
use function Livewire\Volt\{mount, state};

state('payment');
state('paymentIntent');
state('latestCharge');

mount(function (Payment $payment, StripeService $stripe) {
    $this->payment = $payment;
    $this->paymentIntent = $stripe->retrivePaymentIntent($payment['payment_id']);
    if ($this->paymentIntent['latest_charge']) {
        $this->latestCharge = $stripe->retrieveCharge($this->paymentIntent['latest_charge']);
    }
});

?>
<x-app-layout>
    @volt("payment-details")
    <div>
        <div class="mb-4 border dark:border-gray-600 p-4 rounded-lg">
            <div class="dark:text-white">
                Payment Model: <code class="px-3">{{ $payment->is_paid ? 'Paid' : 'Unpaid' }}</code>
            </div>
            @dump($payment->toArray())
        </div>
        <div class="mb-4 border dark:border-gray-600 p-4 rounded-lg">
            <div class="dark:text-white">
                Payment Intent: <code class="px-3">{{ $paymentIntent['status'] }}</code>
            </div>
            @dump($paymentIntent)
        </div>
        @if($latestCharge)
            <div class="mb-4 border dark:border-gray-600 p-4 rounded-lg">
                <div class="dark:text-white">
                    Latest Charge: <code class="px-3">{{ $latestCharge['status'] }}</code>
                </div>
                @dump($latestCharge)
            </div>
        @endif
    </div>
    @endvolt
</x-app-layout>
