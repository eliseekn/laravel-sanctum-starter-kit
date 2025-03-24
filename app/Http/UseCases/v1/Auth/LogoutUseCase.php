<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\Auth;

use App\Enums\HttpResponseStatus;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class LogoutUseCase
{
    public function handle(User $user): JsonResponse
    {
        $user->tokens()->delete();

        return response()->json([
            'status' => HttpResponseStatus::SUCCESS,
            'message' => 'Logged out successfully',
        ]);
    }
}
