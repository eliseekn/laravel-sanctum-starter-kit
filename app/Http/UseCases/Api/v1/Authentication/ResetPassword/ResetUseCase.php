<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\Authentication\ResetPassword;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

final class ResetUseCase
{
    public function handle(array $data): JsonResponse
    {
        $status = Password::reset($data,
            function ($user, $password) use ($data) {
                $user
                    ->forceFill(['password' => bcrypt($password)])
                    ->setRememberToken(Str::random(60));

                $user->save();

                $user->notify(
                    new ResetPassword($data['token'])
                );
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return response()->json([
                'status' => 'error',
                'message' => __($status),
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => __($status),
        ]);
    }
}
