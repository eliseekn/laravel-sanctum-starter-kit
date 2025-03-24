<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\User;

use App\Enums\HttpResponseStatus;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class DeleteUseCase
{
    public function handle(User $user): JsonResponse
    {
        if ($user->delete()) {
            return response()->json([
                'status' => HttpResponseStatus::SUCCESS,
                'message' => 'User deleted successfully',
            ]);
        }

        return response()->json([
            'status' => HttpResponseStatus::ERROR,
            'message' => 'Failed to delete user',
        ], 500);
    }
}
