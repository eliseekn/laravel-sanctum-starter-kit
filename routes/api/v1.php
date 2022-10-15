<?php
declare(strict_types=1);

use App\Http\Controllers\Api\v1\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class);
