<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Recipe::class, function (Faker $faker, $attr = []) {
    $ingredients = '';
    for ($x = 0; $x < $faker->numberBetween(5, 20); $x++) {
        $ingredients .= $faker->sentence($faker->numberBetween(1, 3)) . "\r\n";
    }

    $instructions = '';
    for ($x = 0; $x < $faker->numberBetween(5, 10); $x++) {
        $instructions .= $faker->sentence . "\r\n";
    }
    return [
        'title' => $faker->sentence(3),
        'description' => $faker->paragraph(5),
        'ingredients' => $ingredients,
        'instructions' => $instructions,
        'notes' => $faker->paragraph(3),
        'prep_time' => $faker->randomFloat(1, 0, 1) * 10,
        'cook_time' => ($faker->randomFloat(1, 0, 2) * 10) + 5,
        'servings' =>  $faker->numberBetween(1, 10) . ' ' . $faker->word,
        'published' => $faker->boolean(80),
        'user_id' => $attr['user_id'] ?? factory(\App\Models\User::class)->create(),
        'featured' => $faker->boolean(20),
    ];
});
