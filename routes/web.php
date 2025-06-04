<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\PaymentManager;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => abort(404));

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('payments', PaymentManager::class)->name('payments');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__ . '/auth.php';
