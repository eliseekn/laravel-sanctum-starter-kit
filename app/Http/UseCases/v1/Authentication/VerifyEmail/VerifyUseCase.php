<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\Authentication\VerifyEmail;

use App\Http\Requests\v1\Authentication\EmailVerificationRequest;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Http\JsonResponse;

final class VerifyUseCase
{
    use MakeApiResponse;

    public function handle(EmailVerificationRequest $request): JsonResponse
    {
        $request->fulfill(); // @phpstan-ignore-line

        return $this->successResponse('Email verified successfully.');
    }
}
