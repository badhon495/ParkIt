<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Illuminate\Http\UploadedFile;

class CloudinaryService
{
    protected $cloudinary;

    public function __construct()
    {
        $cloudName = config('cloudinary.cloud_name') ?: env('CLOUDINARY_CLOUD_NAME');
        $apiKey = config('cloudinary.api_key') ?: env('CLOUDINARY_API_KEY');
        $apiSecret = config('cloudinary.api_secret') ?: env('CLOUDINARY_API_SECRET');

        if (empty($cloudName) || empty($apiKey) || empty($apiSecret)) {
            throw new \Exception('Cloudinary configuration is missing. Please check your environment variables.');
        }

        try {
            // Use CLOUDINARY_URL format which is more reliable
            $cloudinaryUrl = "cloudinary://{$apiKey}:{$apiSecret}@{$cloudName}";
            putenv("CLOUDINARY_URL={$cloudinaryUrl}");
            
            $this->cloudinary = new Cloudinary();
        } catch (\Exception $e) {
            throw new \Exception('Failed to initialize Cloudinary: ' . $e->getMessage());
        }
    }

    /**
     * Upload a file to Cloudinary
     */
    public function uploadFile(UploadedFile $file, string $folder = 'uploads'): array
    {
        try {
            $result = $this->cloudinary->uploadApi()->upload(
                $file->getRealPath(),
                [
                    'folder' => $folder,
                    'resource_type' => 'auto',
                    'quality' => 'auto',
                    'fetch_format' => 'auto'
                ]
            );

            return [
                'success' => true,
                'url' => $result['secure_url'],
                'public_id' => $result['public_id']
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Delete a file from Cloudinary
     */
    public function deleteFile(string $publicId): array
    {
        try {
            $result = $this->cloudinary->uploadApi()->destroy($publicId);
            
            return [
                'success' => $result['result'] === 'ok',
                'result' => $result
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get optimized URL for an image
     */
    public function getOptimizedUrl(string $publicId, array $transformations = []): string
    {
        $imageTag = $this->cloudinary->image($publicId);
        
        if (isset($transformations['width']) || isset($transformations['height'])) {
            $imageTag = $imageTag->resize(
                \Cloudinary\Transformation\Resize::fit()
                    ->width($transformations['width'] ?? null)
                    ->height($transformations['height'] ?? null)
            );
        }
        
        return $imageTag->toUrl();
    }
}
