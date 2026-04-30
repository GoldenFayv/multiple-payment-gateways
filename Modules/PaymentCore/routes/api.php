<?php

use Illuminate\Support\Facades\Route;
use Modules\PaymentCore\Http\Controllers\PaymentController;
use Modules\PaymentCore\Http\Controllers\VerifyTransactionController;
use Modules\PaymentCore\Http\Middleware\AuthenticateApiKey;

Route::middleware(AuthenticateApiKey::class)->prefix('v1/payments')->group(function () {
    Route::post('/', [PaymentController::class, 'store']);
    Route::get('verify/{reference}', VerifyTransactionController::class);
});
