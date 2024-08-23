<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\User;

use App\Models\User;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Http\JsonResponse;

final class UpdateUseCase
{
    use MakeApiResponse;

    public function handle(User $user, array $data): JsonResponse
    {
        $user->update($data);

        return $this->successResponse('User updated successfully.');
    }
}
