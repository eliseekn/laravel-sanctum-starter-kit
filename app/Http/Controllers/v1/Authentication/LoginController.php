<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Authentication\LoginRequest;
use App\Http\UseCases\v1\Authentication\LoginUseCase;
use Illuminate\Http\JsonResponse;

/**
 * @group Authentication
 */
class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, LoginUseCase $useCase): JsonResponse
    {
        return $useCase->handle($request->validated());
    }
}
