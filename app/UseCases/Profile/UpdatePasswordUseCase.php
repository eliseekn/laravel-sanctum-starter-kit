<?php

declare(strict_types=1);

namespace App\UseCases\Profile;

use App\Models\User;
use App\UseCases\User\UpdateUseCase;

final class UpdatePasswordUseCase
{
    public function __construct(private readonly UpdateUseCase $useCase) {}

    public function handle(User $user, array $data): User
    {
        $data['password'] = $data['new_password'];
        unset($data['new_password']);

        return $this->useCase->handle($user, $data);
    }
}
