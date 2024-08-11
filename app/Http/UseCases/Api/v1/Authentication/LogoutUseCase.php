<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\Authentication;

use App\Models\User;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Http\JsonResponse;

final class LogoutUseCase
{
    use MakeApiResponse;

    public function handle(User $user): JsonResponse
    {
        $user->tokens()->delete();

        return $this->successResponse('User logged out successfully.');
    }
}
