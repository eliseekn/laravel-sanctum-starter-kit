<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;

final class GetItemUseCase
{
    public function handle(?User $user): JsonResponse
    {
        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.',
            ]);
        }

        return response()->json($user);
    }
}
