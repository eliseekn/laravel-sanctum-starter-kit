<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\DeleteRequest;
use App\Http\Requests\Api\v1\User\StoreRequest;
use App\Http\Requests\Api\v1\User\UpdateRequest;
use App\Models\User;
use App\UseCases\v1\User\DeleteUseCase;
use App\UseCases\v1\User\StoreUseCase;
use App\UseCases\v1\User\UpdateUseCase;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function store(StoreRequest $request, StoreUseCase $useCase): JsonResponse
    {
        return $useCase->handle(
            $request->validated()
        );
    }

    public function update(UpdateRequest $request, UpdateUseCase $useCase, User $user): JsonResponse
    {
        return $useCase->handle(
            $request->validated(), $user
        );
    }

    public function destroy(DeleteRequest $request, DeleteUseCase $useCase, User $user): JsonResponse
    {
        return $useCase->handle($user);
    }
}
