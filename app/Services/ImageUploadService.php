<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ImageUploadService
{
    /**
     * Upload an image and optionally delete the old image.
     *
     * @return string The new image path
     */
    public function uploadImage(UploadedFile $image, string $directory, ?string $oldImagePath = null, ?string $prefix = null): string
    {
        // Delete old image if exists
        if ($oldImagePath && File::exists(public_path($oldImagePath))) {
            File::delete(public_path($oldImagePath));
        }

        // Generate unique filename
        $filename = ($prefix ?? '').time().'.'.$image->getClientOriginalExtension();

        // Ensure directory exists
        $destinationPath = public_path($directory);
        if (! File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // Get the temporary file path - this is more reliable than using move()
        $tempPath = $image->getRealPath();

        // Verify the file is valid and the temp path exists
        if (! $image->isValid()) {
            throw new \RuntimeException('The uploaded file is not valid.');
        }

        if (! $tempPath || ! File::exists($tempPath)) {
            throw new \RuntimeException('The temporary file does not exist. Please try uploading again.');
        }

        // Copy the file instead of moving to avoid issues with temp file cleanup
        $destinationFile = $destinationPath.'/'.$filename;
        File::copy($tempPath, $destinationFile);

        // Return the relative path to the image
        return $directory.'/'.$filename;
    }
}
