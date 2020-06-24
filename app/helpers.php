<?php

use Illuminate\Support\Facades\Log;

/**
 * Generates random image; temporary fix for current issue.
 * @link https://github.com/fzaninotto/Faker/issues/1884
 *
 * @param  string  $path
 * @param  int  $width
 * @param  int  $height
 * @return string|bool
 */
function saveRandomImage(string $path, int $width = 640, int $height = 480)
{
    // Create a blank image:
    $im = imagecreatetruecolor($width, $height);
    // Add light background color:
    $bgColor = imagecolorallocate($im, rand(100, 255), rand(100, 255), rand(100, 255));
    imagefill($im, 0, 0, $bgColor);

    // Save the image:
    $isGenerated = imagejpeg($im, public_path($path));

    // Free up memory:
    imagedestroy($im);

    if (!$isGenerated) {
        Log::error("Unable to create random image for recipe {$path}");
    }
    return $isGenerated ? $path : false;
}
