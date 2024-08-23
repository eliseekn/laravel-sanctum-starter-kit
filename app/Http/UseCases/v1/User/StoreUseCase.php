<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\User;

use App\Models\User;
use App\Notifications\AccountCreated;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

final class StoreUseCase
{
    use MakeApiResponse;

    public function handle(array $data): JsonResponse
    {
        $password = app()->environment('production')
            ? Str::password(8)
            : 'password';

        $data['password'] = bcrypt($password);
        $data['email_verified_at'] = now();

        try {
            $user = User::factory()->create($data);
            Notification::send($user, new AccountCreated($password));

            return $this->successResponse('User created successfully.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
