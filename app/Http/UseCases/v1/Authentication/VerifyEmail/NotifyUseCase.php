<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\Authentication\VerifyEmail;

use App\Models\User;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Http\JsonResponse;

final class NotifyUseCase
{
    use MakeApiResponse;

    public function handle(array $data): JsonResponse
    {
        $user = User::query()
            ->where($data)
            ->first();

        $user->sendEmailVerificationNotification();

        return $this->successResponse('Email verification notification sent successfully.');
    }
}
