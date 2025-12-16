<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Auth\LoginRequest;
use App\Http\Requests\v1\Auth\RegisterRequest;
use App\Http\UseCases\v1\Auth\LoginUseCase;
use App\Http\UseCases\v1\Auth\LogoutUseCase;
use App\Http\UseCases\v1\Auth\RegisterUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;

#[Group('Authentication')]
class AuthController extends Controller
{
    public function login(LoginRequest $request, LoginUseCase $useCase): JsonResponse
    {
        return $useCase->handle($request->validated());
    }

    public function register(RegisterRequest $request, RegisterUseCase $useCase): JsonResponse
    {
        return $useCase->handle($request->validated());
    }

    #[Authenticated()]
    public function logout(Request $request, LogoutUseCase $useCase): JsonResponse
    {
        return $useCase->handle($request->user('sanctum'));
    }
}
