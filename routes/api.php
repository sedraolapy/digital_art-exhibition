<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Exhibitor\ExhibitorApplicationController;
use App\Http\Controllers\Exhibitor\ExhibitorProfileController;
use App\Http\Controllers\User\UserProfileController;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->middleware('throttle:3,1');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);

Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::get('/user/profile', [UserProfileController::class, 'show']);
    Route::put('/user/profile', [UserProfileController::class, 'update']);

    Route::post('/exhibitor-applications', [ExhibitorApplicationController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'role:exhibitor'])->group(function () {
    Route::get('/exhibitor/profile', [ExhibitorProfileController::class, 'show']);
    Route::put('/exhibitor/profile', [ExhibitorProfileController::class, 'update']);
});