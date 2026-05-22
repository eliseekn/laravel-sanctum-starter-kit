<?php

declare(strict_types=1);

namespace App\UseCases\v1\Auth;

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class LoginUseCase
{
    public function handle(array $data): array
    {
        $user = User::query()
            ->where('email', $data['email'])
            ->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw new InvalidCredentialsException;
        }

        return [
            'user' => $user,
            'access_token' => $user->createToken('laravel-sanctum-api')->plainTextToken,
        ];
    }
}
