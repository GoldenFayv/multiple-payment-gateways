<?php

use Illuminate\Support\Facades\Route;
use Modules\Flutterwave\Http\Controllers\FlutterwaveController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('flutterwaves', FlutterwaveController::class)->names('flutterwave');
});
