<?php
declare(strict_types=1);

namespace App\Http\UseCases\v1\Authentication;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class LoginUseCase
{
    public function handle(array $data): JsonResponse
    {
        $user = User::query()
            ->where('email', $data['email'])
            ->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()
                ->json([
                    'status' => 'error',
                    'message' => 'Incorrect mail address or password'
                ], 401);
        }

        return response()
            ->json([
                'status' => 'success',
                'message' => 'User logged in successfully.',
                'token' => $user->createToken(Str::random(15))->plainTextToken,
                'user' => $user
            ]);
    }
}