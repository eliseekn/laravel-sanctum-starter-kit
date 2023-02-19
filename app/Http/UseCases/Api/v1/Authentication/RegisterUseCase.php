<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\Authentication;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

final class RegisterUseCase
{
    public function handle(array $data): JsonResponse
    {
        $data['password'] = bcrypt($data['password']);

        $user = User::factory()->create($data);
        $user->sendEmailVerificationNotification();

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully.',
            'token' => $user->createToken(Str::random(15))->plainTextToken,
        ]);
    }
}
