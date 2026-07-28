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
use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Route;


    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:3,1');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->middleware('throttle:2,1');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->middleware('throttle:2,1');



    // Public Routes
    Route::get('/members', [MemberController::class, 'index']);
    Route::get('/exhibitors', [ExhibitorController::class, 'index']);
    Route::get('/experiences', [ExperienceController::class, 'index']);
    Route::get('/statistics', [StatisticController::class, 'index']);
    Route::get('/lectures', [LectureController::class, 'index']);
    Route::get('/sponsors', [SponsorController::class, 'index']);
    Route::get('/categories', [SponsorController::class, 'getCategoris']);
    Route::get('/days', [EventController::class, 'index']);


    // User
    Route::middleware(['auth:sanctum','role:' . RoleEnum::USER->value])->group(function () {
        Route::get('/user/profile', [UserProfileController::class, 'show']);
        Route::put('/user/profile', [UserProfileController::class, 'update']);
        Route::post('/exhibitor-applications', [ExhibitorApplicationController::class, 'store']);
    });


    // Exhibitor
    Route::middleware(['auth:sanctum','role:' . RoleEnum::EXHIBITOR->value,])->group(function () {
        Route::get('/exhibitor/profile', [ExhibitorProfileController::class, 'show']);
        Route::put('/exhibitor/profile', [ExhibitorProfileController::class, 'update']);
    });



    // User & Exhibitor
    Route::middleware(['auth:sanctum','role:' . RoleEnum::USER->value . '|' . RoleEnum::EXHIBITOR->value,])->group(function () {
        Route::post('/bookings', [BookingController::class, 'store']);
        Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
        Route::post('/votes', [VoteController::class, 'store']);
        Route::get('/user', [UserController::class, 'user']);
    });



    Route::middleware(['auth:sanctum','permission:' . PermissionEnum::PERFORM_CHECK_IN->value])->group(function () {
        Route::post('/check-in', [CheckInController::class, 'store']);
    });