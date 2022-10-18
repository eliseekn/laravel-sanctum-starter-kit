<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\Authentication\VerifyEmail;

use App\Models\User;
use Illuminate\Http\JsonResponse;

final class NotifyUseCase
{
    public function handle(array $data): JsonResponse
    {
        $user = User::query()
            ->where($data)
            ->first();

        $user->sendEmailVerificationNotification();

        return response()->json([
            'status' => 'success',
            'message' => 'Email verification notification sent successfully.',
        ]);
    }
}
