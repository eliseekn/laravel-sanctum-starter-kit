<?php

declare(strict_types=1);

namespace App\UseCases\User;

use App\Exceptions\ModelPersistenceException;
use App\Models\User;

final class UpdateUseCase
{
    public function handle(User $user, array $data): User
    {
        if (! $user->update($data)) {
            throw new ModelPersistenceException;
        }

        return $user->refresh();
    }
}
