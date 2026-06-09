<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Profile\UpdatePasswordRequest;
use App\Http\Requests\v1\Profile\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\UseCases\v1\Profile\UpdatePasswordUseCase;
use App\UseCases\v1\User\UpdateUseCase;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;

#[Group('Profile')]
#[Authenticated()]
class ProfileController extends Controller
{
    public function update(UpdateRequest $request, User $user, UpdateUseCase $useCase): JsonResponse
    {
        $data = $useCase->handle($user, $request->validated());

        return $this->successJsonResponse([
            'message' => 'User updated successfully',
            'data' => new UserResource($data),
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request, User $user, UpdatePasswordUseCase $useCase): JsonResponse
    {
        $data = $useCase->handle($user, $request->validated());

        return $this->successJsonResponse([
            'message' => 'User updated successfully',
            'data' => new UserResource($data),
        ]);
    }
}
