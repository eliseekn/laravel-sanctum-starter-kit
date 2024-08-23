<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Authentication\EmailRequest;
use App\Http\Requests\v1\Authentication\EmailVerificationRequest;
use App\Http\UseCases\v1\Authentication\VerifyEmail\NotifyUseCase;
use App\Http\UseCases\v1\Authentication\VerifyEmail\VerifyUseCase;
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
