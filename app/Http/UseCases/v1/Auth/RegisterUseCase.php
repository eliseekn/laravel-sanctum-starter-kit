<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\Auth;

use App\Enums\HttpResponseStatus;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

final class RegisterUseCase
{
    public function handle(array $data): JsonResponse
    {
        $data['password'] = bcrypt($data['password']);

        try {
            $user = User::factory()->create($data);
            $user->sendEmailVerificationNotification();

            return response()->json([
                'status' => HttpResponseStatus::SUCCESS,
                'user' => new UserResource($user),
                'message' => 'Registration succeeded',
            ], 201);
        } catch (Exception $e) {
            report($e);

            return response()->json([
                'status' => HttpResponseStatus::ERROR,
                'message' => 'Registration failed',
            ], 500);
        }
    }
}
