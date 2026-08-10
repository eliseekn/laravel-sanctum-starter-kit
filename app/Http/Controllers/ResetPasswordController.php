<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\UseCases\ResetPassword\NotifyUseCase;
use App\UseCases\ResetPassword\ResetUseCase;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Group;

#[Group('Reset password')]
class ResetPasswordController extends Controller
{
    public function notify(EmailRequest $request, NotifyUseCase $useCase): JsonResponse
    {
        return $this->successJsonResponse(
            $useCase->handle($request->validated())
        );
    }

    public function reset(ResetPasswordRequest $request, ResetUseCase $useCase): JsonResponse
    {
        $message = $useCase->handle(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            )
        );

        return $this->successJsonResponse($message);
    }
}
