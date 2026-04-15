<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\EmailRequest;
use App\Http\Requests\v1\VerifyEmailRequest;
use App\Http\UseCases\v1\VerifyEmail\NotifyUseCase;
use App\Http\UseCases\v1\VerifyEmail\VerifyUseCase;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Group;

#[Group('Email verification')]
class VerifyEmailController extends Controller
{
    public function notify(EmailRequest $request, NotifyUseCase $useCase): JsonResponse
    {
        return $useCase->handle($request->validated());
    }

    public function verify(VerifyEmailRequest $request, VerifyUseCase $useCase): JsonResponse
    {
        return $useCase->handle($request);
    }
}
