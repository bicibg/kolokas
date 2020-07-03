<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;


$factory->define(\App\Models\RecipeImage::class, function (Faker $faker, $attr = []) {
    return [
        'main' => true,
        'recipe_id' => $attr['recipe_id'] ?? factory(\App\Models\Recipe::class)->create(),
        'url' => $faker->imageUrl(640, 480, 'food', true),
    ];
});
