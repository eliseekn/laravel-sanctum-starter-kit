<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\Authentication;

use App\Models\User;
use Illuminate\Http\JsonResponse;

final class LogoutUseCase
{
    public function handle(array $data): JsonResponse
    {
        $user = User::query()
            ->where('email', $data['email'])
            ->first();

        if (! $user) {
            return response()
                ->json([
                    'status' => 'error',
                    'message' => 'User not found',
                ], 404);
        }

        $user->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully.',
        ]);
    }
}
