<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;

final class UpdateUseCase
{
    public function handle(User $user, array $data): JsonResponse
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully.',
        ]);
    }
}
