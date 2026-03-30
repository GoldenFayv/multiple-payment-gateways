<?php

use Illuminate\Support\Facades\Route;
use Modules\PaymentCore\Http\Controllers\PaymentCoreController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('paymentcores', PaymentCoreController::class)->names('paymentcore');
});
