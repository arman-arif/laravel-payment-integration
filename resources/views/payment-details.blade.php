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
        <div class="mb-4 border p-4 rounded-lg">
            Payment Model: <code class="px-3">{{ $payment->is_paid ? 'Paid' : 'Unpaid' }}</code>
            <code>
                <pre>{{ json_encode($payment, JSON_PRETTY_PRINT) }}</pre>
            </code>
        </div>
        <div class="mb-4 border p-4 rounded-lg">
            Payment Intent: <code class="px-3">{{ $paymentIntent['status'] }}</code>
            <code>
                <pre>{{ json_encode($paymentIntent, JSON_PRETTY_PRINT) }}</pre>
            </code>
        </div>
        @if($latestCharge)
            <div class="mb-4 border p-4 rounded-lg">
                Latest Charge: <code class="px-3">{{ $latestCharge['status'] }}</code>
                <code>
                    <pre>{{ json_encode($latestCharge, JSON_PRETTY_PRINT) }}</pre>
                </code>
            </div>
        @endif
    </div>
    @endvolt
</x-app-layout>
