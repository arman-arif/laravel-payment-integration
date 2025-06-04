<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function paymentSuccess(Payment $payment)
    {
        return view('payment-success', [
            'payment' => $payment,
        ]);
    }
}
