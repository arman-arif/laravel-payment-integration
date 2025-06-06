<?php

use App\Models\Payment;
use App\Services\StripeService;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new
#[Layout('layouts.payment')]
class extends Component {
    public Payment $payment;

    public $stripKey = null;

    public $currentGateway = null;
    public $defaultGateway = 'stripe';
    public $currency = null;

    public $stripeCardReady = false;
    public $showLoader = false;
    public $paymentProcessing = false;

    public $stripeStatus = null;

    public function mount()
    {
        if (!isset($this->payment)) abort(404);

        $this->stripKey = config('stripe.public_key');
        $this->currency = $this->payment->currency;

        if ($this->payment->is_paid) {
            $this->redirectRoute('payment.success', $this->payment->id);
            return;
        }

        $paymentIntentId = $this->payment->payment_meta->payment_intent_id ?? null;
        if ($paymentIntentId) {
            $this->checkIfPaymentComplete($paymentIntentId);
        }
    }

    public function getCustomer()
    {
        return $this->payment->only(['name', 'email']);
    }

    public function getStripePaymentIntent(): array
    {
        $paymentIntentId = $this->payment->payment_meta->payment_intent_id ?? null;

        $stripe = new StripeService();

        if ($paymentIntentId) {
            $intent = $stripe->retrivePaymentIntent($paymentIntentId);

            if (isset($intent['client_secret'])) {
                return [
                    'id' => $intent['id'],
                    'clientSecret' => $intent['client_secret'],
                ];
            }
        }

        $intent = $stripe->createPaymentIntent(
            $this->payment->amount,
            $this->payment->currency,
            $this->payment->description,
            [
                'payment_id' => $this->payment->id,
                'customer_name' => $this->payment->name,
                'customer_email' => $this->payment->email,
            ]
        );

        $this->payment->payment_gateway = 'stripe';
        $this->payment->payment_meta = [
            'payment_intent_id' => $intent['id'],
            'client_secret' => $intent['client_secret']
        ];
        $this->payment->saveQuietly();

        return [
            'id' => $intent['id'],
            'clientSecret' => $intent['client_secret']
        ];
    }

    public function checkIfPaymentComplete($paymentIntentId): void
    {
        $stripe = new StripeService();
        $paymentIntent = $stripe->retrivePaymentIntent($paymentIntentId);

        $this->stripeStatus = $paymentIntent['status'];
        if ($this->stripeStatus=='canceled') {
            $this->stripeCardReady = true;
        }
        if (in_array($this->stripeStatus, ['succeeded', 'processing'])) {
            $this->payment->payment_gateway = 'stripe';
            $this->payment->payment_id = $paymentIntentId;
            $this->payment->saveQuietly();

            $this->redirectRoute('stripe.confirm', [
                'payment_intent' => $paymentIntent['id'],
                'payment_intent_client_secret' =>  $paymentIntent['client_secret'],
                'redirect_status' => $paymentIntent['status'],
            ]);
        }
    }

    public function updatePayment($paymentId)
    {
        $this->payment->payment_id = $paymentId;
        $this->payment->saveQuietly();
    }

    public function setGateway($method): void
    {
        $this->currentGateway = match ($method) {
            'card', => 'stripe',
            'paypal', => 'paypal',
            default => null
        };

        if ($this->currentGateway=='stripe' && $this->stripeStatus=='canceled') {
            return;
        }

        $this->dispatch('changeGateway', gateway: $this->currentGateway);
    }

}; ?>

<div
    class="max-w-[750px] mx-auto my-20"
    x-data="{ currentGateway: @entangle('currentGateway').live }"
>
    <div
        class="min-h-60 rounded-2xl border border-gray-200 bg-white px-7 py-7 dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-12">
        <div class="mx-auto w-full max-w-[700px]">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="w-full md:w-4/12">
                    <div class="mb-4">
                        <h2 class="font-semibold text-xl text-green-600">FASTER PAYMENT LTD.</h2>
                        <p class="text-gray-500">Payment Portal</p>
                    </div>

                    <div class="mb-3">
                        <div class="text-sm text-gray-400">Customer</div>
                        <div class="text-truncate">
                            <p class="font-semibold dark:text-white text-md">{{ $payment->name }}</p>
                            <p class="text-gray-600 dark:text-gray-300">{{ $payment->email }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-sm text-gray-400">Payable Amount</div>
                        <div
                            class="text-3xl text-sky-600 font-semibold">{{number_format($payment->amount, 2)}} {{ $payment->currency }}</div>
                    </div>
                </div>
                <div
                    x-data="{
                        showLoader: @entangle('showLoader').live,
                        stripeCardReady: @entangle('stripeCardReady').live,
                        showSelectMessage: true,
                        timeout: null,
                    }"
                    class="w-full md:w-8/12"
                    x-effect="
                        if(!showLoader && !stripeCardReady) {
                            clearTimeout(timeout);
                            timeout = setTimeout(() => {
                                showSelectMessage = true;
                            }, 500);
                        } else {
                            clearTimeout(timeout);
                            timeout = setTimeout(() => {
                                showSelectMessage = false;
                            }, 500);
                        }
                    "
                >
                    <h3 class="mb-4 text-xl font-semibold text-gray-800 dark:text-white/90 uppercase text-center">
                        Complete Payment
                    </h3>

                    <div class="flex gap-4 mb-4">
                        <button
                            class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-semibold shadow-theme-xs ring-1 transition hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-white/[0.03] outline-none"
                            :class="currentGateway === 'stripe' ? 'ring-sky-800 text-sky-700' : 'text-gray-600 ring-gray-300 dark:text-gray-400 dark:ring-gray-700'"
                            wire:click="setGateway('card')"
                            @click="showLoader = !stripeCardReady; showSelectMessage = false;"
                            :disabled="stripeCardReady && currentGateway === 'stripe'"
                        >
                            Credit/Debit Card
                        </button>
                        <button
                            class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-semibold shadow-theme-xs ring-1 transition hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-white/[0.03] outline-none"
                            :class="currentGateway === 'paypal' ? 'ring-sky-800 text-sky-700' : 'text-gray-600 ring-gray-300 dark:text-gray-400 dark:ring-gray-700'"
                            wire:click="setGateway('paypal')"
                            @click="showSelectMessage = false;"
                        >
                            PayPal
                        </button>
                    </div>

                    <div wire:ignore x-show="currentGateway==='stripe'">
                        <div class="w-full mb-2" id="stripe-link-element"></div>
                        <div class="w-full mb-4" id="stripe-payment-element"></div>
                        @if($this->stripeStatus=='canceled')
                            <div class="text-center py-12 text-gray-500 dark:text-gray-400 border dark:border-gray-700 rounded-lg text-lg uppercase font-medium">
                                This payment has been canceled.
                            </div>
                        @endif
                    </div>

                    <div wire:ignore x-show="currentGateway==='paypal'">
                        <div class="w-full mb-4" id="paypal-container"></div>
                        <div class="text-center py-12 text-gray-500 dark:text-gray-400 border dark:border-gray-700 rounded-lg text-lg uppercase font-medium">
                            Coming Soon
                        </div>
                    </div>

                    <div class="flex justify-center items-center min-h-40 mb-8" x-show="showLoader" x-cloak>
                        <x-loading-spinner size="xl" color="gray"/>
                    </div>

                    @if($stripeCardReady && $this->stripeStatus!='canceled')
                        <button
                            class="items-center gap-2 rounded-lg bg-sky-600 text-white px-4 py-2 text-lg font-medium shadow-theme-xs transition hover:bg-sky-700 dark:hover:bg-sky-500 disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed"
                            wire:click="$dispatch('stripe.confirmConfirmPayment')"
                            x-show="currentGateway==='stripe'"
                            @disabled($paymentProcessing)
                        >
                            @if($paymentProcessing)
                                <x-loading-spinner color="gray" size="sm"> Processing Payment... </x-loading-spinner>
                            @else
                                <span>Pay {{ $payment->getAmountString() }}</span>
                            @endif
                        </button>
                    @endif

                    <div class="my-10 text-center text-gray-500" x-show="showSelectMessage" x-cloak>
                        Select a payment method to continue.
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if (session('error'))
        <script>
            document.addEventListener('livewire:init', () => {
                setTimeout(() => {
                    dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            type: 'error',
                            title: 'Payment Failed!',
                            message: "Payment process was failed!"
                        }
                    }));
                }, 2000)
            });
        </script>
    @endif
</div>

@script
<script>
    (function () {

        const darkMode = () => JSON.parse(localStorage.getItem('darkMode'));

        async function initStripeCard() {
            const stripe = Stripe($wire.stripKey);

            const paymentIntent = await $wire.getStripePaymentIntent();

            const elementAppearance = () => ({
                theme: darkMode() ? 'night' : 'stripe',
                labels: 'floating',
                variables: {
                    borderRadius: '8px',
                    colorPrimary: '#0084d1',
                    colorBackground: darkMode() ? '#202735' : '#ffffff'
                }
            });

            const elements = stripe.elements({
                clientSecret: paymentIntent.clientSecret,
                loader: 'always',
                appearance: elementAppearance(),
            });

            const customer = await $wire.getCustomer();

            const elementOptions = {
                layout: 'tabs',
                defaultValues: {
                    billingDetails: {
                        name: customer.name,
                        email: customer.email,
                    }
                },
                business: { name: "XYZ LTD." },
                fields: {
                    billing_details: {
                        name: customer.name,
                        email: customer.email,
                    }
                },
            };

            const linkAuthElement = elements.create('linkAuthentication');
            linkAuthElement.mount('#stripe-link-element');

            const paymentElement = elements.create('payment', elementOptions);

            paymentElement.mount('#stripe-payment-element');

            Livewire.on('dark-mode', () => {
                elements.update({
                    appearance: elementAppearance()
                });
            });

            Livewire.on('stripe.confirmConfirmPayment', debounce(() => {
                $wire.updatePayment(paymentIntent.id);
                $wire.set('paymentProcessing', true);
                confirmStripeCard(stripe, elements);
                console.clear();
            }, 300));

            paymentElement.on('loaderstart', function(event) {
                $wire.set('showLoader', false);
                console.clear();
            });

            paymentElement.on('ready', function(event) {
                $wire.set('stripeCardReady', true);
                console.clear();
            });

            console.log('stripe initialized');
        }

        async function confirmStripeCard(stripe, elements) {
            const { error } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: '{{ route('stripe.confirm') }}',
                },
            });
            if(error) {
                setTimeout(() => $wire.set('paymentProcessing', false), 300)
                console.error(error);
                Livewire.dispatch('toast', {
                    type: 'error',
                    title: 'Payment Error!',
                    message: error.message,
                })
            }
        }

        const initialized = {};
        Livewire.on('changeGateway', ({gateway}) => {
            if (gateway === 'stripe') {
                if(initialized.current===gateway) return;
                initialized.current = gateway;
                setTimeout(debounce(() => {
                    initStripeCard();
                }, 300), 500);
            }
        });

        // debounce function
        function debounce(fn, delay) {
            let timer;
            return function (...args) {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    fn.apply(this, args);
                }, delay);
            };
        }

    })()
</script>
@endscript

@push('scripts')
    <script src="https://js.stripe.com/basil/stripe.js"></script>
@endpush
