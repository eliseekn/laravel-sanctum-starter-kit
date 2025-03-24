<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;

final class UpdatePasswordUseCase
{
    public function __construct(public UpdateUseCase $useCase) {}

    public function handle(User $user, array $data): JsonResponse
    {
        $data['password'] = bcrypt($data['new_password']);
        unset($data['new_password']);

        return $this->useCase->handle($user, $data);
    }
}
