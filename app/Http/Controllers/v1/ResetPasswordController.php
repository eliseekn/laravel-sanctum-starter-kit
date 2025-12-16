<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\EmailRequest;
use App\Http\Requests\v1\ResetPasswordRequest;
use App\Http\UseCases\v1\ResetPassword\NotifyUseCase;
use App\Http\UseCases\v1\ResetPassword\ResetUseCase;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;

#[Group('Reset password')]
#[Authenticated()]
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
