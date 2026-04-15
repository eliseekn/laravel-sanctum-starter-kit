<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\User;

use App\Enums\HttpResponseStatus;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

final class StoreUseCase
{
    public function handle(array $data): JsonResponse
    {
        $password = app()->environment('local') ? 'password' : Str::password(8);

        $data['password'] = bcrypt($password);

        try {
            $user = User::factory()->create($data);

            return response()->json([
                'status' => HttpResponseStatus::SUCCESS,
                'message' => 'User created successfully',
                'user' => new UserResource($user),
            ], 201);
        } catch (Exception $e) {
            report($e);

            return response()->json([
                'status' => HttpResponseStatus::ERROR,
                'message' => 'Failed to create user',
            ], 500);
        }
    }
}
