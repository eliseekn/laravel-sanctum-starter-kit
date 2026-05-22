<?php

declare(strict_types=1);

namespace App\UseCases\v1\ResetPassword;

use App\Exceptions\ResetPasswordException;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

final class ResetUseCase
{
    public function handle(array $data): string
    {
        $status = Password::reset(
            $data,
            function ($user, $password) use ($data) {
                $user
                    ->forceFill(['password' => bcrypt($password)])
                    ->setRememberToken(Str::random(60));

                $user->save();
                $user->notify(new ResetPassword($data['token']));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw new ResetPasswordException(__($status));
        }

        return __($status);
    }
}
