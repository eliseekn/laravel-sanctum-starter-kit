<?php

declare(strict_types=1);

namespace App\UseCases\Auth;

use App\Exceptions\ModelPersistenceException;
use App\Models\User;
use Exception;

final class RegisterUseCase
{
    public function handle(array $data): User
    {
        try {
            $user = User::create($data);
        } catch (Exception $e) {
            report($e);

            throw new ModelPersistenceException('Registration failed');
        }

        try {
            $user->sendEmailVerificationNotification();
        } catch (Exception $e) {
            report($e);
        }

        return $user;
    }
}
