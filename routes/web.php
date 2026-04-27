<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/queue', function () {
    $output = Artisan::call('queue:work', [
        '--once' => true,
        '--stop-when-empty' => true,
    ]);

    return response()->json([
        'status' => 'queue processed',
        'data' => $output
    ]);
});
