<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\UseCases\Auth\LoginUseCase;
use App\UseCases\Auth\RegisterUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Group;

#[Group('Authentication')]
class AuthController extends Controller
{
    public function login(LoginRequest $request, LoginUseCase $useCase): JsonResponse
    {
        $data = $useCase->handle($request->validated());

        return $this->successJsonResponse([
            'message' => 'Logged in successfully',
            'data' => [
                'user' => new UserResource($data['user']),
                'access_token' => $data['access_token'],
            ],
        ]);

    }

    public function register(RegisterRequest $request, RegisterUseCase $useCase): JsonResponse
    {
        $data = $useCase->handle($request->validated());

        return $this->successJsonResponse([
            'message' => 'Registered successfully',
            'data' => new UserResource($data),
        ], 201);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user('sanctum')?->tokens()->delete();

        return $this->successJsonResponse('Logged out successfully');
    }
}
