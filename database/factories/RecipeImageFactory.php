<?php

/** @var Factory $factory */

use App\Models\Recipe;
use App\Models\RecipeImage;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;


$factory->define(RecipeImage::class, function (Faker $faker, $attr = []) {
    return [
        'main' => true,
        'recipe_id' => $attr['recipe_id'] ?? factory(Recipe::class)->create(),
        'url' => $faker->imageUrl(640, 480, 'food', true),
    ];
});
