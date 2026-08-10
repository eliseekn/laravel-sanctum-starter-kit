<?php

declare(strict_types=1);

namespace App\UseCases\VerifyEmail;

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Models\User;

final class NotifyUseCase
{
    public function handle(array $data): void
    {
        $user = User::query()
            ->where($data)
            ->first();

        if (! $user) {
            throw new InvalidCredentialsException('Account not found');
        }

        $user->sendEmailVerificationNotification();
    }
}
