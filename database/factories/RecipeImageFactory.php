<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;


$factory->define(\App\RecipeImage::class, function (Faker $faker, $attr = []) {
    $randomStr = \Illuminate\Support\Str::random(8);
    $files = \Illuminate\Support\Facades\Storage::files('public/images/recipes');
    $randomFile = \Illuminate\Support\Str::replaceFirst('public/', 'storage/', $files[rand(0, count($files) - 1)]);
    return [
        'main' => true,
        'recipe_id' => $attr['recipe_id'] ?? factory(\App\Recipe::class)->create(),
        'url' => $randomFile //saveRandomImage("/images/recipes/{$randomStr}.jpg")
    ];
});
