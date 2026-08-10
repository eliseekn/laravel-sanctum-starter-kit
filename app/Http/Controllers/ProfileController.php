<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\UseCases\Profile\UpdatePasswordUseCase;
use App\UseCases\User\UpdateUseCase;
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
        $data = $useCase->handle($user, $request->safe()->except('old_password'));

        return $this->successJsonResponse([
            'message' => 'User updated successfully',
            'data' => new UserResource($data),
        ]);
    }
}
