<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Authentication;

use App\Http\Controllers\Api\v1\Controller;
use App\Http\Requests\Api\v1\Authentication\EmailRequest;
use App\Http\Requests\Api\v1\Authentication\EmailVerificationRequest;
use App\Http\UseCases\Api\v1\Authentication\VerifyEmail\NotifyUseCase;
use App\Http\UseCases\Api\v1\Authentication\VerifyEmail\VerifyUseCase;
use Illuminate\Http\JsonResponse;

/**
 * @group Email verification
 */
class VerifyEmailController extends Controller
{
    public function notify(EmailRequest $request, NotifyUseCase $useCase): JsonResponse
    {
        return $useCase->handle($request->validated());
    }

    public function verify(EmailVerificationRequest $request, VerifyUseCase $useCase): JsonResponse
    {
        return $useCase->handle($request);
    }
}
