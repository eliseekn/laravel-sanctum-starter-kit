<?php

declare(strict_types=1);

namespace App\UseCases\v1\Auth;

use App\Exceptions\ModelPersistenceException;
use App\Models\User;
use Exception;

final class RegisterUseCase
{
    public function handle(array $data): User
    {
        $data['password'] = bcrypt($data['password']);

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
