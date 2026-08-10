<?php

declare(strict_types=1);

namespace App\UseCases\User;

use App\Exceptions\ModelPersistenceException;
use App\Models\User;
use Exception;
use Illuminate\Support\Str;

final class StoreUseCase
{
    public function handle(array $data): User
    {
        $data['password'] = app()->environment('local') ? 'password' : Str::password(8);

        try {
            $user = User::create($data);
        } catch (Exception $e) {
            report($e);

            throw new ModelPersistenceException;
        }

        return $user;
    }
}
