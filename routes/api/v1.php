<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\ProfileController;
use App\Http\Controllers\v1\ResetPasswordController;
use App\Http\Controllers\v1\UserController;
use App\Http\Controllers\v1\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)
    ->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout')->middleware('auth:sanctum');
    });

Route::prefix('/profile')
    ->controller(ProfileController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::patch('/{user}/update', 'update');
        Route::patch('/{user}/update-password', 'updatePassword');
    });

Route::apiResource('users', UserController::class)->middleware('auth:sanctum');

Route::prefix('email')
    ->controller(VerifyEmailController::class)
    ->group(function () {
        Route::post('/verification-notification', 'notify');
        Route::get('/verify/{id}/{hash}', 'verify')->name('verification.verify');
    });

Route::prefix('password')
    ->controller(ResetPasswordController::class)
    ->group(function () {
        Route::post('/reset-notification', 'notify');
        Route::post('/reset', 'reset')->name('password.update');
    });
