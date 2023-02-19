<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\Authentication\ResetPassword;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

final class NotifyUseCase
{
    public function handle(array $data): JsonResponse
    {
        $status = Password::sendResetLink($data);

        if ($status !== Password::RESET_LINK_SENT) {
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
