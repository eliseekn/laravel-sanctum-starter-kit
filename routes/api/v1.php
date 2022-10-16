<?php
declare(strict_types=1);

use App\Http\Controllers\Api\v1\Authentication\LoginController;
use App\Http\Controllers\Api\v1\Authentication\LogoutController;
use App\Http\Controllers\Api\v1\Authentication\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::get('/logout/{user}', LogoutController::class);
