<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeController;
use App\Livewire\PaymentManager;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', fn() => abort(404));

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('dashboard/payments', PaymentManager::class)->name('payments');
    Route::view('dashboard/payment/{payment}', 'payment-details')->name('payment.details');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__ . '/auth.php';

Route::get('stripe/confirm-payment', [StripeController::class, 'confirm'])->name('stripe.confirm');
Route::get('payment/{payment}/success', [IndexController::class, 'paymentSuccess'])->name('payment.success');;
Volt::route('payment/{payment}', 'payment-process')->name('payment');
