<?php

declare(strict_types=1);

namespace App\UseCases\v1\VerifyEmail;

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Models\User;
use Exception;

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

        try {
            $user->sendEmailVerificationNotification();
        } catch (Exception $e) {
            report($e);
        }
    }
}
