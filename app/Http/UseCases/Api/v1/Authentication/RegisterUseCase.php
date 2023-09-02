<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\Authentication;

use App\Http\Shared\MakeApiResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

final class RegisterUseCase
{
    use MakeApiResponse;

    public function handle(array $data): JsonResponse
    {
        $user = User::factory()->create($data);
        $user->sendEmailVerificationNotification();

        return $this->successResponse([
            'message' => 'User registered successfully.',
            'token' => $user->createToken(Str::random(15))->plainTextToken,
        ]);
    }
}
