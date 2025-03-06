<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

trait FileUploadTrait
{

    public function uploadFile(UploadedFile $file, string $folder = 'images'): string
    {
        $destinationPath = public_path($folder);
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        return $folder . '/' . $filename;
    }

    public function deleteExistingFileIfExists(string $existingFilePath): void
    {
        if ($existingFilePath && file_exists(public_path($existingFilePath))) {
            unlink(public_path($existingFilePath));
        }
    }
}
