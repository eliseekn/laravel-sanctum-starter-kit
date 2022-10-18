<?php
declare(strict_types=1);

namespace App\Http\UseCases\v1\Authentication;

use App\Models\User;
use Illuminate\Http\JsonResponse;

final class RegisterUseCase
{
    public function handle(array $data): JsonResponse
    {
        $data['password'] = bcrypt($data['password']);

        $user = User::factory()->create($data);
        $user->sendEmailVerificationNotification();

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully.'
        ]);
    }
}
