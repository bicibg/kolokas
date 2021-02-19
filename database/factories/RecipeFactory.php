<?php

/** @var Factory $factory */

use App\Models\Recipe;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Recipe::class, function (Faker $faker, $attr = []) {
    $ingredients = '';
    for ($x = 0; $x < $faker->numberBetween(5, 20); $x++) {
        $ingredients .= $faker->sentence($faker->numberBetween(1, 3)) . "\r\n";
    }

    $instructions = '';
    for ($x = 0; $x < $faker->numberBetween(5, 10); $x++) {
        $instructions .= $faker->sentence . "\r\n";
    }
    $servings = $faker->numberBetween(1, 10) . ' ' . $faker->word;
    return [
        'title' => ['en' => $faker->sentence(3), 'tr' => $faker->sentence(3), 'el' => $faker->sentence(3)],
        'description' => ['en' => $faker->paragraph(5), 'tr' => $faker->paragraph(5), 'el' => $faker->paragraph(5)],
        'ingredients' => ['en' => $ingredients, 'tr' => $ingredients, 'el' => $ingredients],
        'instructions' => ['en' => $instructions, 'tr' => $instructions, 'el' => $instructions],
        'notes' => ['en' => $faker->paragraph(3), 'tr' => $faker->paragraph(3), 'el' => $faker->paragraph(3)],
        'prep_time' => $faker->randomFloat(1, 0, 1) * 10,
        'cook_time' => ($faker->randomFloat(1, 0, 2) * 10) + 5,
        'servings' => ['en' => $servings, 'tr' => $servings, 'el' => $servings],
        'published' => $faker->boolean(80),
        'user_id' => $attr['user_id'] ?? factory(User::class)->create(),
        'featured' => $faker->boolean(20),
    ];
});
