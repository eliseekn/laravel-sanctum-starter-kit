<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\Authentication\VerifyEmail;

use App\Http\Requests\Api\v1\Authentication\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;

final class VerifyUseCase
{
    public function handle(EmailVerificationRequest $request): JsonResponse
    {
        $request->fulfill();

        return response()->json([
            'status' => 'success',
            'message' => 'Email verified successfully.',
        ]);
    }
}
