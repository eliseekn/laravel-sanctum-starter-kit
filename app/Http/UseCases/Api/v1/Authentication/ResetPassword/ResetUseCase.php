<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\Authentication\ResetPassword;

use App\Http\Shared\MakeApiResponse;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

final class ResetUseCase
{
    use MakeApiResponse;

    public function handle(array $data): JsonResponse
    {
        $status = Password::reset($data,
            function ($user, $password) use ($data) {
                $user
                    ->forceFill(['password' => bcrypt($password)])
                    ->setRememberToken(Str::random(60));

                $user->save();
                $user->notify(new ResetPassword($data['token']));
            }
        );

        return $status !== Password::PASSWORD_RESET
            ? $this->errorResponse(__($status), 400)
            : $this->successResponse(__($status));
    }
}
