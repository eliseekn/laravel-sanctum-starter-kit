<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\VerifyEmail;

use App\Enums\HttpResponseStatus;
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
            'status' => HttpResponseStatus::SUCCESS,
            'message' => 'Email verification notification sent successfully.',
        ]);
    }
}
