<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Authentication;

use App\Http\Controllers\Api\v1\Controller;
use App\Http\Requests\Api\v1\Authentication\LoginRequest;
use App\Http\UseCases\Api\v1\Authentication\LoginUseCase;
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
