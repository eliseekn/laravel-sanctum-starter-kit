<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\Authentication\VerifyEmail;

use App\Http\Requests\Api\v1\Authentication\EmailVerificationRequest;
use App\Http\Shared\MakeApiResponse;
use Illuminate\Http\JsonResponse;

final class VerifyUseCase
{
    use MakeApiResponse;

    public function handle(EmailVerificationRequest $request): JsonResponse
    {
        $request->fulfill();

        return $this->successResponse('Email verified successfully.');
    }
}
