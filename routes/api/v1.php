<?php
declare(strict_types=1);

use App\Http\Controllers\Api\v1\Authentication\LoginController;
use App\Http\Controllers\Api\v1\Authentication\LogoutController;
use App\Http\Controllers\Api\v1\Authentication\RegisterController;
use App\Http\Controllers\Api\v1\Authentication\ResetPasswordController;
use App\Http\Controllers\Api\v1\Authentication\VerifyEmailController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Support\Facades\Route;

//Authentication routes
Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::post('/logout', LogoutController::class);

Route::prefix('email')
    ->group(function () {
        Route::post('/verification-notification', [VerifyEmailController::class, 'notify']);
        Route::get('/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])->name('verification.verify');
    });

Route::prefix('password')
    ->group(function () {
        Route::post('/reset-notification', [ResetPasswordController::class, 'notify']);
        Route::post('/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
    });

//User routes
Route::patch('/users/{user}/avatar', [UserController::class, 'updateAvatar']);
Route::apiResource('users', UserController::class);
