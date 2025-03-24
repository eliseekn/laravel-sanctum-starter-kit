<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\User;

use App\Enums\HttpResponseStatus;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class UpdateUseCase
{
    public function handle(User $user, array $data): JsonResponse
    {
        if ($user->update($data)) {
            return response()->json([
                'status' => HttpResponseStatus::SUCCESS,
                'message' => 'User updated successfully',
                'user' => $user->attributesToArray(),
            ]);
        }

        return response()->json([
            'status' => HttpResponseStatus::ERROR,
            'message' => 'Failed to update user',
        ], 500);
    }
}
