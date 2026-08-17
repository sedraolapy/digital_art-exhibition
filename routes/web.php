<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/speed-test', function () {
    return response()->json([
        'message' => 'OK',
        'time' => microtime(true),
    ]);
});