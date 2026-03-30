<?php

use Illuminate\Support\Facades\Route;
use Modules\PaymentCore\Http\Controllers\PaymentController;

Route::prefix('payments')->group(function () {
    Route::post('/', [PaymentController::class, 'store']);
});
