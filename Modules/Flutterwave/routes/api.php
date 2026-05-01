<?php

use Illuminate\Support\Facades\Route;
use Modules\Flutterwave\Http\Controllers\FlutterwaveController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('flutterwaves', FlutterwaveController::class)->names('flutterwave');
});
