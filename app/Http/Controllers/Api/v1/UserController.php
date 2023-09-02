<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\User\DeleteRequest;
use App\Http\Requests\Api\v1\User\StoreRequest;
use App\Http\Requests\Api\v1\User\UpdateAvatarRequest;
use App\Http\Requests\Api\v1\User\UpdateRequest;
use App\Http\Resources\Api\v1\UserCollection;
use App\Http\UseCases\Api\v1\User\DeleteUseCase;
use App\Http\UseCases\Api\v1\User\GetCollectionUseCase;
use App\Http\UseCases\Api\v1\User\GetItemUseCase;
use App\Http\UseCases\Api\v1\User\StoreUseCase;
use App\Http\UseCases\Api\v1\User\UpdateAvatarUseCase;
use App\Http\UseCases\Api\v1\User\UpdateUseCase;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group User management
 *
 * @authenticated
 */
class UserController extends Controller
{
    /**
     * @apiResourceCollection App\Http\Resources\Api\v1\UserCollection
     *
     * @apiResourceModel App\Models\User paginate=10
     */
    public function index(Request $request, GetCollectionUseCase $useCase): UserCollection
    {
        return $useCase->handle($request->query() ?? []);
    }

    public function show(User $user, GetItemUseCase $useCase): JsonResponse
    {
        return $useCase->handle($user);
    }

    public function store(StoreRequest $request, StoreUseCase $useCase): JsonResponse
    {
        return $useCase->handle($request->validated());
    }

    public function update(UpdateRequest $request, UpdateUseCase $useCase, User $user): JsonResponse
    {
        return $useCase->handle($user, $request->validated());
    }

    public function updateAvatar(UpdateAvatarRequest $request, UpdateAvatarUseCase $useCase, User $user): JsonResponse
    {
        return $useCase->handle($user, $request->file('avatar'));
    }

    public function destroy(DeleteRequest $request, DeleteUseCase $useCase, User $user): JsonResponse
    {
        return $useCase->handle($user);
    }
}
