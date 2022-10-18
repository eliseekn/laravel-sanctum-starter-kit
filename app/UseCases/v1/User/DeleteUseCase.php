<?php
declare(strict_types=1);

namespace App\UseCases\v1\User;

use App\Models\User;
use App\Notifications\AccountCreated;
use App\Notifications\AccountDeleted;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

final class DeleteUseCase
{
    public function handle(User $user): JsonResponse
    {
        $user->delete();

        Notification::route('mail', $user->email)
            ->notify(new AccountDeleted());

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully.'
        ]);
    }
}
