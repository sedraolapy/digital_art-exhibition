<?php

use App\Http\Controllers\Media\PrivateMediaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/private-media/{media}', [PrivateMediaController::class, 'download'])
    ->middleware('auth')
    ->name('private-media.download');
