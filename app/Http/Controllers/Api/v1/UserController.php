<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\StoreRequest;
use App\UseCases\v1\User\StoreUseCase;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function store(StoreRequest $request, StoreUseCase $useCase): JsonResponse
    {
        return $useCase->handle(
            $request->validated()
        );
    }
}
