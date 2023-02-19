<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\User;

use App\Models\User;
use App\Notifications\AccountCreated;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;

final class StoreUseCase
{
    public function handle(array $data): JsonResponse
    {
        $password = Str::random(8);

        $data['password'] = bcrypt($password);
        $data['email_verified_at'] = now();

        $user = User::factory()->create($data);
        Notification::send($user, new AccountCreated($password));

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully.',
        ]);
    }
}
