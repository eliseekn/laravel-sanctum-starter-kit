<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\User\DeleteRequest;
use App\Http\Requests\v1\User\StoreRequest;
use App\Http\Requests\v1\User\UpdatePasswordRequest;
use App\Http\Requests\v1\User\UpdateProfileRequest;
use App\Http\Requests\v1\User\UpdateRequest;
use App\Http\Resources\UserCollection;
use App\Http\UseCases\v1\User\DeleteUseCase;
use App\Http\UseCases\v1\User\GetCollectionUseCase;
use App\Http\UseCases\v1\User\StoreUseCase;
use App\Http\UseCases\v1\User\UpdatePasswordUseCase;
use App\Http\UseCases\v1\User\UpdateUseCase;
use App\Models\User;
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
     * @apiResourceCollection App\Http\Resources\UserCollection
     *
     * @apiResourceModel App\Models\User paginate=10
     *
     * @queryParam page integer
     * @queryParam search string
     * @queryParam perPage integer
     * @queryParam startDate string. Example: 2024-01-03
     * @queryParam endDate string. Example: 2025-01-03
     */
    public function index(Request $request, GetCollectionUseCase $useCase): UserCollection
    {
        return $useCase->handle($request->query());
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    public function store(StoreRequest $request, StoreUseCase $useCase): JsonResponse
    {
        return $useCase->handle($request->validated());
    }

    public function update(UpdateRequest $request, User $user, UpdateUseCase $useCase): JsonResponse
    {
        return $useCase->handle($user, $request->validated());
    }

    public function destroy(DeleteRequest $request, User $user, DeleteUseCase $useCase): JsonResponse
    {
        return $useCase->handle($user);
    }

    public function updateProfile(UpdateProfileRequest $request, User $user, UpdateUseCase $useCase): JsonResponse
    {
        return $useCase->handle($user, $request->validated());
    }

    public function updatePassword(UpdatePasswordRequest $request, User $user, UpdatePasswordUseCase $useCase): JsonResponse
    {
        return $useCase->handle($user, $request->validated());
    }
}
