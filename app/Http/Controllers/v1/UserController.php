<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\User\StoreRequest;
use App\Http\Requests\v1\User\UpdateRequest;
use App\Http\Requests\v1\User\UploadAvatarRequest;
use App\Http\Resources\v1\UserCollection;
use App\Http\UseCases\v1\User\DeleteUseCase;
use App\Http\UseCases\v1\User\GetCollectionUseCase;
use App\Http\UseCases\v1\User\StoreUseCase;
use App\Http\UseCases\v1\User\UpdateUseCase;
use App\Http\UseCases\v1\User\UploadAvatarUseCase;
use App\Models\User;
use Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group User
 *
 * @authenticated
 */
class UserController extends Controller
{
    /**
     * @apiResourceCollection App\Http\Resources\v1\UserCollection
     *
     * @apiResourceModel App\Models\User paginate=10
     */
    public function index(Request $request, GetCollectionUseCase $useCase): UserCollection
    {
        return $useCase->handle($request->query() ?? []);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    public function store(StoreRequest $request, StoreUseCase $useCase): JsonResponse
    {
        return $useCase->handle($request->validated());
    }

    public function update(UpdateRequest $request, UpdateUseCase $useCase, User $user): JsonResponse
    {
        return $useCase->handle($user, $request->validated());
    }

    public function uploadAvatar(UploadAvatarRequest $request, UploadAvatarUseCase $useCase, User $user): JsonResponse
    {
        return $useCase->handle($user, $request->file('avatar'));
    }

    public function destroy(Request $request, DeleteUseCase $useCase, User $user): JsonResponse
    {
        Gate::allowIf($request->user('sanctum')->isRole(UserRole::ADMIN));

        return $useCase->handle($user);
    }
}
