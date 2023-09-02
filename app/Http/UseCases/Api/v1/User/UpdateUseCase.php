<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\User;

use App\Http\Shared\MakeApiResponse;
use App\Models\User;
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
