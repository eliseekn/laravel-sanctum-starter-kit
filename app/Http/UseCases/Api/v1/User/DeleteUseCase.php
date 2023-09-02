<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\User;

use App\Http\Shared\MakeApiResponse;
use App\Models\User;
use App\Notifications\AccountDeleted;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;

final class DeleteUseCase
{
    use MakeApiResponse;

    public function handle(User $user): JsonResponse
    {
        $user->delete();

        Notification::route('mail', $user->getAttribute('email'))
            ->notify(new AccountDeleted());

        return $this->successResponse('User deleted successfully.');
    }
}
