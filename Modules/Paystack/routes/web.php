<?php

use Illuminate\Support\Facades\Route;
use Modules\Paystack\Http\Controllers\PaystackController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('paystacks', PaystackController::class)->names('paystack');
});
