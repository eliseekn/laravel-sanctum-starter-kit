<?php
declare(strict_types=1);

namespace App\UseCases\v1\User;

use App\Models\User;
use App\Notifications\AccountCreated;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

final class UpdateUseCase
{
    public function handle(array $data, User $user): JsonResponse
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully.'
        ]);
    }
}
