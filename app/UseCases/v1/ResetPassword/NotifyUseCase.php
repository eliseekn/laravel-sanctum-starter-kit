<?php

declare(strict_types=1);

namespace App\UseCases\v1\ResetPassword;

use App\Exceptions\ResetPasswordException;
use Illuminate\Support\Facades\Password;

final class NotifyUseCase
{
    public function handle(array $data): string
    {
        $status = Password::sendResetLink($data);

        if ($status !== Password::RESET_LINK_SENT) {
            throw new ResetPasswordException(__($status));
        }

        return __($status);
    }
}
