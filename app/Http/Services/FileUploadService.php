<?php

declare(strict_types=1);

namespace App\Http\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

final class FileUploadService
{
    public function handle(UploadedFile $uploadedFile, &$filename): bool
    {
        $filename = Str::uuid()->toString().'.'.$uploadedFile->getClientOriginalExtension();

        return $uploadedFile
            ->move(storage_path('app/public/'), $filename)
            ->isFile();
    }
}
