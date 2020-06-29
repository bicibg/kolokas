<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;


$factory->define(\App\RecipeImage::class, function (Faker $faker, $attr = []) {
    return [
        'main' => true,
        'recipe_id' => $attr['recipe_id'] ?? factory(\App\Recipe::class)->create(),
        'url' => $faker->imageUrl(640, 480, 'food', true),
    ];
});
