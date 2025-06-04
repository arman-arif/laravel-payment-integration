<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\PaymentManager;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', fn() => abort(404));

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('dashboard/payments', PaymentManager::class)->name('payments');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__ . '/auth.php';

Volt::route('payment/{payment}', 'payment-process')->name('payment');
