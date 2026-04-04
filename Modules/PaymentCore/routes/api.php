<?php

use Illuminate\Support\Facades\Route;
use Modules\PaymentCore\Http\Controllers\PaymentController;
use Modules\PaymentCore\Http\Controllers\VerifyTransactionController;

Route::prefix('payments')->group(function () {
    Route::post('/', [PaymentController::class, 'store']);
    Route::get('verify/{reference}', VerifyTransactionController::class);
});
