<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Profile\UpdatePasswordRequest;
use App\Http\Requests\v1\Profile\UpdateRequest;
use App\Http\UseCases\v1\Profile\UpdatePasswordUseCase;
use App\Http\UseCases\v1\User\UpdateUseCase;
use App\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * @group Profile
 *
 * @authenticated
 */
class ProfileController extends Controller
{
    public function update(UpdateRequest $request, User $user, UpdateUseCase $useCase): JsonResponse
    {
        return $useCase->handle($user, $request->validated());
    }

    public function updatePassword(UpdatePasswordRequest $request, User $user, UpdatePasswordUseCase $useCase): JsonResponse
    {
        return $useCase->handle($user, $request->validated());
    }
}
