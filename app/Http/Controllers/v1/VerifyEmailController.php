<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\EmailRequest;
use App\Http\Requests\v1\VerifyEmailRequest;
use App\UseCases\v1\VerifyEmail\NotifyUseCase;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Group;

#[Group('Email verification')]
class VerifyEmailController extends Controller
{
    public function notify(EmailRequest $request, NotifyUseCase $useCase): JsonResponse
    {
        $useCase->handle($request->validated());

        return $this->successJsonResponse('Email verification notification sent successfully.');
    }

    public function verify(VerifyEmailRequest $request): JsonResponse
    {
        $request->fulfill(); // @phpstan-ignore-line

        return $this->successJsonResponse('Email verified successfully.');
    }
}
