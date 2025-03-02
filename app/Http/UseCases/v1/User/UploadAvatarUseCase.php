<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\User;

use App\Http\Services\FileUploadService;
use App\Models\User;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class UploadAvatarUseCase
{
    use MakeApiResponse;

    public function __construct(
        private readonly FileUploadService $fileUploadService
    ) {}

    public function handle(User $user, UploadedFile $file): JsonResponse
    {
        if (! $this->fileUploadService->handle($file, $filename)) {
            return $this->errorResponse('Failed to upload file.');
        }

        if (
            $user->avatar &&
            Storage::disk('public')->exists($user->avatar)
        ) {
            Storage::disk('public')->delete($user->avatar);
        }

        $data['avatar'] = $filename;

        return $user->update($data)
            ? $this->successResponse('Avatar uploaded successfully.')
            : $this->errorResponse('Failed to upload avatar.');
    }
}
