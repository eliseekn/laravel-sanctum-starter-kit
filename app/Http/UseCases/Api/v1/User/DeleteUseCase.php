<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\User;

use App\Models\User;
use App\Notifications\AccountDeleted;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;

final class DeleteUseCase
{
    use MakeApiResponse;

    public function handle(User $user): JsonResponse
    {
        if ($user->delete()) {
            Notification::route('mail', $user->email)->notify(new AccountDeleted);

            return $this->successResponse('User deleted successfully.');
        }

        return $this->errorResponse('Failed to delete user.');
    }
}
