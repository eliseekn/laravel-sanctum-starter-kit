<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Authentication;

use App\Http\Controllers\Api\v1\Controller;
use App\Http\Requests\Api\v1\Authentication\RegisterRequest;
use App\Http\UseCases\Api\v1\Authentication\RegisterUseCase;
use Illuminate\Http\JsonResponse;

/**
 * @group Authentication
 */
class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, RegisterUseCase $useCase): JsonResponse
    {
        return $useCase->handle($request->validated());
    }
}
