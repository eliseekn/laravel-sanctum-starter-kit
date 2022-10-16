<?php
declare(strict_types=1);

namespace App\UseCases\v1\Authentication;

use App\Models\User;
use Illuminate\Http\JsonResponse;

final class RegisterUseCase
{
    public function handle(array $data): JsonResponse
    {
        User::factory()->create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User has been registered successfully.'
        ]);
    }
}