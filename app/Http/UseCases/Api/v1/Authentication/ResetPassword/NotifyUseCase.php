<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\Authentication\ResetPassword;

use App\Http\Shared\MakeApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

final class NotifyUseCase
{
    use MakeApiResponse;

    public function handle(array $data): JsonResponse
    {
        $status = Password::sendResetLink($data);

        return $status !== Password::RESET_LINK_SENT
            ? $this->errorResponse(__($status), 400)
            : $this->successResponse(__($status));
    }
}
