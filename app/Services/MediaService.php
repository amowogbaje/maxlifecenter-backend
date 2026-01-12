<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    /**
     * Handle the file upload and return the public URL.
     */
    public function upload(UploadedFile $file, string $folder = 'updates'): string
    {
        // Generate a unique name: time + random string + original extension
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Store with the new name
        $path = $file->storeAs($folder, $fileName, 'public');

        return asset('storage/' . $path);
    }
}