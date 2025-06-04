<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    //
    public function confirm(Request $request, StripeService $stripe)
    {
        try {
            $paymentIntent = $stripe->retrivePaymentIntent($request->payment_intent);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404);
        }

        $payment = Payment::where('payment_id', $paymentIntent['id'])->first();

        if ($paymentIntent['status'] !== 'succeeded') {
            return to_route('payment', $payment->id)->with('error', 'Payment failed');
        }

        $charge = $stripe->retrieveCharge($paymentIntent['latest_charge']);

        $paymentMeta = (array)($payment->payment_meta ?? []);
        $paymentMeta['charge_id'] = $charge['id'];
        $payment->is_paid = true;
        $payment->paid_at = $charge['created'];
        $payment->payment_meta = $paymentMeta;
        $payment->save();

        return to_route('payment.success', $payment->id);
    }
}
