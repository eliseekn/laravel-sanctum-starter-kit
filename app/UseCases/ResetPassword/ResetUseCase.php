<?php

declare(strict_types=1);

namespace App\UseCases\ResetPassword;

use App\Exceptions\ResetPasswordException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

final class ResetUseCase
{
    public function handle(array $data): string
    {
        $status = Password::reset(
            $data,
            function ($user, $password) {
                $user
                    ->forceFill(['password' => bcrypt($password)])
                    ->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw new ResetPasswordException(__($status));
        }

        return __($status);
    }
}
