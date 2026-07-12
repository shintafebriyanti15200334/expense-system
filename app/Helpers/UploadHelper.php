<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadHelper
{
    public static function uploadSubmission(?UploadedFile $file): ?string
    {
        if (!$file) {
            return null;
        }

        return $file->store('submissions', 'public');
    }

    public static function delete(?string $path): void
    {
        if (!$path) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {

            Storage::disk('public')->delete($path);
        }
    }
}