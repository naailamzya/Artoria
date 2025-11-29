<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Copy random image dari samples folder
     */
    public static function copyRandomSample(string $type): string
    {
        $samplePath = "samples/{$type}";
        $fullPath = storage_path("app/public/{$samplePath}");
        
        // Check if directory exists
        if (!File::exists($fullPath)) {
            return self::createPlaceholder($type);
        }

        // Get all image files
        $files = File::files($fullPath);
        
        // Filter only image files
        $imageFiles = array_filter($files, function($file) {
            $extension = strtolower($file->getExtension());
            return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });

        if (empty($imageFiles)) {
            return self::createPlaceholder($type);
        }

        // Pick random file
        $randomFile = $imageFiles[array_rand($imageFiles)];
        $extension = $randomFile->getExtension();
        $newFilename = Str::uuid() . '.' . $extension;
        
        // Determine destination directory
        $destinationDir = self::getDestinationDir($type);
        $destination = $destinationDir . '/' . $newFilename;
        
        // Copy file to destination
        $sourcePath = $samplePath . '/' . $randomFile->getFilename();
        Storage::disk('public')->copy($sourcePath, $destination);
        
        return $destination;
    }

    /**
     * Get destination directory based on type
     */
    protected static function getDestinationDir(string $type): string
    {
        return match($type) {
            'avatars' => 'profile-pictures',
            'banners' => 'challenges',
            'artworks' => 'artworks',
            default => $type,
        };
    }

    /**
     * Get random avatar
     */
    public static function getRandomAvatar(): string
    {
        return self::copyRandomSample('avatars');
    }

    /**
     * Get random banner
     */
    public static function getRandomBanner(): string
    {
        return self::copyRandomSample('banners');
    }

    /**
     * Get random artwork
     */
    public static function getRandomArtwork(): string
    {
        return self::copyRandomSample('artworks');
    }

    /**
     * Create colored placeholder if no sample images available
     */
    public static function createPlaceholder(string $type): string
    {
        // Image dimensions based on type
        $dimensions = [
            'avatars' => [400, 400],
            'banners' => [1920, 600],
            'artworks' => [800, 1000],
        ];

        [$width, $height] = $dimensions[$type] ?? [800, 800];
        
        // Create image
        $image = imagecreatetruecolor($width, $height);
        
        // Random colors for different types
        $colors = [
            'avatars' => [
                [255, 43, 79],   // Artoria red
                [139, 92, 246],  // Purple
                [59, 130, 246],  // Blue
                [249, 115, 22],  // Orange
                [236, 72, 153],  // Pink
            ],
            'banners' => [
                [255, 43, 79],   // Artoria red
                [139, 92, 246],  // Purple
                [59, 130, 246],  // Blue
            ],
            'artworks' => [
                [255, 43, 79],   // Artoria red
                [139, 92, 246],  // Purple
                [59, 130, 246],  // Blue
                [249, 115, 22],  // Orange
                [236, 72, 153],  // Pink
                [34, 197, 94],   // Green
            ],
        ];

        $colorSet = $colors[$type] ?? $colors['artworks'];
        $selectedColor = $colorSet[array_rand($colorSet)];
        
        $bgColor = imagecolorallocate($image, $selectedColor[0], $selectedColor[1], $selectedColor[2]);
        imagefill($image, 0, 0, $bgColor);
        
        // Add gradient effect for banners and artworks
        if ($type !== 'avatars') {
            self::addGradient($image, $width, $height, $selectedColor);
        }
        
        // Add text label (optional)
        $white = imagecolorallocate($image, 255, 255, 255);
        $text = strtoupper($type);
        $fontSize = $type === 'avatars' ? 3 : 5;
        $textWidth = imagefontwidth($fontSize) * strlen($text);
        $textHeight = imagefontheight($fontSize);
        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2;
        imagestring($image, $fontSize, $x, $y, $text, $white);
        
        // Generate filename and path
        $filename = Str::uuid() . '.jpg';
        $destinationDir = self::getDestinationDir($type);
        $fullPath = storage_path("app/public/{$destinationDir}/{$filename}");
        
        // Ensure directory exists
        @mkdir(dirname($fullPath), 0755, true);
        
        // Save image
        imagejpeg($image, $fullPath, 90);
        imagedestroy($image);
        
        return $destinationDir . '/' . $filename;
    }

    /**
     * Add gradient effect to image
     */
    protected static function addGradient($image, int $width, int $height, array $baseColor): void
    {
        // Create darker version of base color
        $darkColor = [
            max(0, $baseColor[0] - 100),
            max(0, $baseColor[1] - 100),
            max(0, $baseColor[2] - 100),
        ];

        for ($y = 0; $y < $height; $y++) {
            $ratio = $y / $height;
            $r = $baseColor[0] * (1 - $ratio) + $darkColor[0] * $ratio;
            $g = $baseColor[1] * (1 - $ratio) + $darkColor[1] * $ratio;
            $b = $baseColor[2] * (1 - $ratio) + $darkColor[2] * $ratio;
            
            $color = imagecolorallocate($image, $r, $g, $b);
            imageline($image, 0, $y, $width, $y, $color);
        }
    }

    /**
     * Check if sample images exist
     */
    public static function hasSampleImages(string $type): bool
    {
        $samplePath = storage_path("app/public/samples/{$type}");
        
        if (!File::exists($samplePath)) {
            return false;
        }

        $files = File::files($samplePath);
        $imageFiles = array_filter($files, function($file) {
            $extension = strtolower($file->getExtension());
            return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });

        return !empty($imageFiles);
    }

    /**
     * Get count of sample images
     */
    public static function getSampleImageCount(string $type): int
    {
        $samplePath = storage_path("app/public/samples/{$type}");
        
        if (!File::exists($samplePath)) {
            return 0;
        }

        $files = File::files($samplePath);
        $imageFiles = array_filter($files, function($file) {
            $extension = strtolower($file->getExtension());
            return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });

        return count($imageFiles);
    }
}