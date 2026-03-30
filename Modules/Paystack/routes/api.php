<?php

use Illuminate\Support\Facades\Route;
use Modules\Paystack\Http\Controllers\PaystackController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('paystacks', PaystackController::class)->names('paystack');
});
