<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Authentication\RegisterRequest;
use App\Http\UseCases\v1\Authentication\RegisterUseCase;
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
