<?php

declare(strict_types=1);

namespace App\Http\UseCases\Api\v1\User;

use App\Http\Services\FileUploadService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class UpdateAvatarUseCase
{
    public function __construct(
        private readonly FileUploadService $service
    ) {
    }

    public function handle(User $user, UploadedFile $file): JsonResponse
    {
        if (! $this->service->handle($file, $filename)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to upload file',
            ]);
        }

        if (
            $user->getAttribute('avatar') &&
            Storage::disk('public')
                ->exists($user->getAttribute('avatar'))
        ) {
            Storage::disk('public')
                ->delete($user->getAttribute('avatar'));
        }

        $data['avatar'] = $filename;

        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Avatar updated successfully.',
        ]);
    }
}
