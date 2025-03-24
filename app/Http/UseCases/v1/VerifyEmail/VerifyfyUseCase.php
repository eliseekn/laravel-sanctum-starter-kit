<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\VerifyEmail;

use App\Enums\HttpResponseStatus;
use App\Http\Requests\v1\VerifyEmailRequest;
use Illuminate\Http\JsonResponse;

final class VerifyUseCase
{
    public function handle(VerifyEmailRequest $request): JsonResponse
    {
        $request->fulfill(); // @phpstan-ignore-line

        return response()->json([
            'status' => HttpResponseStatus::SUCCESS,
            'message' => 'Email verified successfully.',
        ]);
    }
}
