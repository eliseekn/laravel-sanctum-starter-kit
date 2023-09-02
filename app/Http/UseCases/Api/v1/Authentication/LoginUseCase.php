<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\Authentication;

use App\Http\Shared\MakeApiResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class LoginUseCase
{
    use MakeApiResponse;

    public function handle(array $data): JsonResponse
    {
        $user = User::query()
            ->where('email', $data['email'])
            ->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return $this->errorResponse('Incorrect mail address or password.', 401);
        }

        return $this->successResponse([
            'message' => 'User logged in successfully.',
            'token' => $user->createToken(Str::random())->plainTextToken,
            'user' => $user,
        ]);
    }
}
