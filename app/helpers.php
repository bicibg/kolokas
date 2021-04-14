<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Facades\Location;


/**
 * Generates random image; temporary fix for current issue.
 * @link https://github.com/fzaninotto/Faker/issues/1884
 *
 * @param string $path
 * @param int $width
 * @param int $height
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

function randKey($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function imageUrl($width = 640, $height = 480)
{
    $baseUrl = "https://loremflickr.com";
    $url = "/{$width}/{$height}/food";

    $url .= '?' . random_int(10000, 99999);

    return $baseUrl . $url;
}

function translate($text, $to)
{
    $translate = new \Google\Cloud\Translate\V2\TranslateClient([
        'key' => env('GOOGLE_TRANSLATE_API_KEY')
    ]);
    return $translate->translate($text, [
        'target' => $to,
        'format' => 'text'
    ]);
}

function translateMissing($array, $lang) {
    if (!empty($array[$lang]) || !collect(array_keys(Config::get('app.languages')))->contains($lang)) {
        return $array;
    }
    if (!isset($array[$lang]) || empty($array[$lang])) {
        if ($translation = translate($array[App::getLocale()], $lang)) {
            $array[$lang] = $translation['text'];
        }
    }
    return $array;
}

function getLocationString()
{
    if ($position = Location::get(request()->getClientIp())) {
        $location = '';
        if ($position->cityName) {
            $location .= $position->cityName;
        }
        if (!empty($position->countryCode)) {
            if (!empty($location)) {
                $location .= ', ';
            }
            $location .= $position->countryCode;
        }
    } else {
        $location = 'Unknown';
    }
    return $location;
}
