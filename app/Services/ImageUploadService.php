<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use InvalidArgumentException;

class ImageUploadService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Upload, resize, convert to WebP, generate thumbnail, and delete old file.
     *
     * @param  UploadedFile  $file
     * @param  string  $folder  Subdirectory in storage/app/public (e.g. 'banners', 'settings', 'centres')
     * @param  string|null  $oldPath  Existing path on public disk to delete
     * @param  int  $maxWidth  Maximum width in pixels
     * @param  int  $maxHeight  Maximum height in pixels
     * @param  int  $quality  WebP compression quality (0-100)
     * @param  bool  $generateThumbnail  Whether to generate a companion thumbnail
     * @param  int  $thumbWidth  Thumbnail max width
     * @param  int  $thumbHeight  Thumbnail max height
     * @return string Relative path on public disk
     */
    public function upload(
        UploadedFile $file,
        string $folder = 'uploads',
        ?string $oldPath = null,
        int $maxWidth = 1200,
        int $maxHeight = 800,
        int $quality = 82,
        bool $generateThumbnail = true,
        int $thumbWidth = 320,
        int $thumbHeight = 220
    ): string {
        // Validate MIME type
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        if (! in_array($file->getMimeType(), $allowedMimes, true)) {
            throw new InvalidArgumentException('Invalid image format. Allowed formats: JPG, PNG, WEBP.');
        }

        // Validate file size (max 4 MB = 4,194,304 bytes)
        if ($file->getSize() > 4194304) {
            throw new InvalidArgumentException('Image file size exceeds maximum limit of 4 MB.');
        }

        // Read and process original image
        $image = $this->manager->read($file->getRealPath());

        // Scale down if dimensions exceed bounds, preserving aspect ratio
        $image->scaleDown(width: $maxWidth, height: $maxHeight);

        // Convert to WebP
        $encodedImage = $image->toWebp($quality);

        // Generate clean unique filename
        $filename = Str::random(32) . '.webp';
        $destinationPath = trim($folder, '/') . '/' . $filename;

        // Save main image to public storage disk
        Storage::disk('public')->put($destinationPath, (string) $encodedImage);

        // Generate thumbnail if requested
        if ($generateThumbnail) {
            $thumbImage = $this->manager->read($file->getRealPath());
            $thumbImage->scaleDown(width: $thumbWidth, height: $thumbHeight);
            $encodedThumb = $thumbImage->toWebp(78);

            $thumbDestinationPath = trim($folder, '/') . '/thumbs/' . $filename;
            Storage::disk('public')->put($thumbDestinationPath, (string) $encodedThumb);
        }

        // Delete old file and thumbnail if provided
        if ($oldPath) {
            $this->delete($oldPath);
        }

        return $destinationPath;
    }

    /**
     * Delete an image and its associated thumbnail from the public disk.
     */
    public function delete(?string $path): bool
    {
        if (! $path) {
            return false;
        }

        $disk = Storage::disk('public');

        if ($disk->exists($path)) {
            $disk->delete($path);
        }

        // Check for thumbnail
        $dir = dirname($path);
        $filename = basename($path);
        $thumbPath = ($dir === '.' ? '' : $dir . '/') . 'thumbs/' . $filename;

        if ($disk->exists($thumbPath)) {
            $disk->delete($thumbPath);
        }

        return true;
    }
}

