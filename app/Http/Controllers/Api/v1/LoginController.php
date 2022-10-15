<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\LoginRequest;
use App\UseCases\v1\LoginUseCase;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, LoginUseCase $useCase): JsonResponse
    {
        return $useCase->handle(
            $request->validated()
        );
    }
}
