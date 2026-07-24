<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CheckIn\CheckInController;
use App\Http\Controllers\CheckIn\EventController;
use App\Http\Controllers\Exhibitor\ExhibitorApplicationController;
use App\Http\Controllers\Exhibitor\ExhibitorController;
use App\Http\Controllers\Exhibitor\ExhibitorProfileController;
use App\Http\Controllers\Exhibitor\VoteController;
use App\Http\Controllers\Experience\ExperienceController;
use App\Http\Controllers\Lecture\BookingController;
use App\Http\Controllers\Lecture\LectureController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Sponsor\SponsorController;
use App\Http\Controllers\Statistic\StatisticController;
use App\Http\Controllers\User\UserController;
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

Route::get('/members', [MemberController::class, 'index']);
Route::get('/exhibitors', [ExhibitorController::class, 'index']);
Route::get('/experiences', [ExperienceController::class, 'index']);
Route::get('/statistics', [StatisticController::class, 'index']);
Route::get('/lectures', [LectureController::class, 'index']);
Route::get('/sponsors/active', [SponsorController::class, 'activeSponsors']);

Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::get('/user/profile', [UserProfileController::class, 'show']);
    Route::put('/user/profile', [UserProfileController::class, 'update']);
    Route::post('/exhibitor-applications', [ExhibitorApplicationController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'role:exhibitor'])->group(function () {
    Route::get('/exhibitor/profile', [ExhibitorProfileController::class, 'show']);
    Route::put('/exhibitor/profile', [ExhibitorProfileController::class, 'update']);
});

Route::middleware(['auth:sanctum', 'role:user|exhibitor'])->group(function () {
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
    Route::post('/votes', [VoteController::class, 'store']);
    Route::get('/user', [UserController::class, 'user']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/days', [EventController::class, 'index']);
    Route::post('/check-in', [CheckInController::class, 'store']);
});