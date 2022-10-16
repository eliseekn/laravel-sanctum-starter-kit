<?php
declare(strict_types=1);

namespace App\UseCases\v1\Authentication;

use App\Models\User;
use Illuminate\Http\JsonResponse;

final class LogoutUseCase
{
    public function handle(User $user): JsonResponse
    {
        $user->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully.'
        ]);
    }
}
