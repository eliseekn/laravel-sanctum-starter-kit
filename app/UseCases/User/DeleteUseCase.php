<?php

declare(strict_types=1);

namespace App\UseCases\User;

use App\Exceptions\ForbiddenException;
use App\Exceptions\ModelPersistenceException;
use App\Models\User;
use Illuminate\Http\Request;

final class DeleteUseCase
{
    public function handle(Request $request, User $user): void
    {
        if ($request->user('sanctum')->cannot('delete', $user)) {
            throw new ForbiddenException;
        }

        if (! $user->delete()) {
            throw new ModelPersistenceException('Failed to delete user');
        }
    }
}
