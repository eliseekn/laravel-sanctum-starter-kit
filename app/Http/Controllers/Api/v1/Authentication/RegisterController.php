<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Authentication\RegisterRequest;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, \App\Http\UseCases\Api\v1\Authentication\RegisterUseCase $useCase): JsonResponse
    {
        return $useCase->handle(
            $request->validated()
        );
    }
}
