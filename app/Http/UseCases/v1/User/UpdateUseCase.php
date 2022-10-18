<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\User;

use App\Http\Services\FileUploadService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

final class UpdateUseCase
{
    public function __construct(
        private readonly FileUploadService $service
    ) {
    }

    public function handle(array $data, User $user, ?UploadedFile $file = null): JsonResponse
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        if (! is_null($file)) {
            if (! $this->service->handle($file, $filename)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to upload file',
                ]);
            }

            $data['avatar'] = $filename;
        }

        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully.',
        ]);
    }
}
