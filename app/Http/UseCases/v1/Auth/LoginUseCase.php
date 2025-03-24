<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\Auth;

use App\Enums\HttpResponseStatus;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

final class LoginUseCase
{
    public function handle(array $data): JsonResponse
    {
        $user = User::query()
            ->where('email', $data['email'])
            ->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json([
                'status' => HttpResponseStatus::ERROR,
                'message' => 'Invalid email or password',
            ], 403);
        }

        return response()->json([
            'status' => HttpResponseStatus::SUCCESS,
            'user' => $user->attributesToArray(),
            'token' => $user->createToken('pharma-delivery')->plainTextToken,
            'message' => 'Logged in successfully',
        ]);
    }
}
