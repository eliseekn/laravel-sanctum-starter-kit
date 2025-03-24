<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\ResetPassword;

use App\Enums\HttpResponseStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

final class NotifyUseCase
{
    public function handle(array $data): JsonResponse
    {
        $status = Password::sendResetLink($data);

        if ($status !== Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => HttpResponseStatus::ERROR,
                'message' => __($status),
            ], 400);
        }

        return response()->json([
            'status' => HttpResponseStatus::SUCCESS,
            'message' => __($status),
        ]);
    }
}
