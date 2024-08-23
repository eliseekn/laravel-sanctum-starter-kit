<?php

declare(strict_types=1);

use App\Http\Controllers\v1\Authentication\LoginController;
use App\Http\Controllers\v1\Authentication\LogoutController;
use App\Http\Controllers\v1\Authentication\RegisterController;
use App\Http\Controllers\v1\Authentication\ResetPasswordController;
use App\Http\Controllers\v1\Authentication\VerifyEmailController;
use App\Http\Controllers\v1\UserController;
use Illuminate\Support\Facades\Route;

//Authentication routes
Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);

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

//User routes
Route::middleware('auth:sanctum')
    ->group(function () {
        Route::post('/logout', LogoutController::class);
        Route::patch('/users/{user}/avatar', [UserController::class, 'uploadAvatar']);
        Route::apiResource('users', UserController::class);
    });
