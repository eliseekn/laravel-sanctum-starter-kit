<?php
declare(strict_types=1);

use App\Http\Controllers\Api\v1\Authentication\LoginController;
use App\Http\Controllers\Api\v1\Authentication\LogoutController;
use App\Http\Controllers\Api\v1\Authentication\RegisterController;
use App\Http\Controllers\Api\v1\Authentication\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::post('/logout', LogoutController::class);

Route::prefix('email')
    ->group(function () {
        Route::get('/verify/{id}/{hash}', [VerifyEmailController::class, 'verify']);
        Route::post('/verification-notification', [VerifyEmailController::class, 'notify']);
    });
