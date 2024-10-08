<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Authentication\EmailRequest;
use App\Http\Requests\v1\Authentication\ResetPasswordRequest;
use App\Http\UseCases\v1\Authentication\ResetPassword\NotifyUseCase;
use App\Http\UseCases\v1\Authentication\ResetPassword\ResetUseCase;
use Illuminate\Http\JsonResponse;

/**
 * @group Password reset
 */
class ResetPasswordController extends Controller
{
    public function notify(EmailRequest $request, NotifyUseCase $useCase): JsonResponse
    {
        return $useCase->handle($request->validated());
    }

    public function reset(ResetPasswordRequest $request, ResetUseCase $useCase): JsonResponse
    {
        return $useCase->handle(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            )
        );
    }
}
