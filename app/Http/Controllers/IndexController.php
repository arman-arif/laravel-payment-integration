<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function paymentSuccess(Payment $payment)
    {
        if (!$payment->is_paid) {
            return to_route('payment', $payment->id);
        }

        return view('payment-success', [
            'payment' => $payment,
        ]);
    }
}
