<?php

/** @var Factory $factory */

use App\Models\Profile;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(/**
 * @param  Faker  $faker
 * @param  array  $attr
 * @return array
 */ Profile::class, function (Faker $faker, $attr = []) {
    $email = $faker->unique()->safeEmail;
    return [
        'user_id' => $attr['user_id'] ?? factory(User::class)->create(['email' => $email]),
        'name' => $faker->name,
        'email' => $email,
        'website' => $faker->url,
        'telephone' => $faker->phoneNumber,
        'city' => $faker->city,
        'facebook' => $faker->url,
        'instagram' => $faker->url,
        'twitter' => $faker->url,
        'pinterest' => $faker->url,
        'info' => $faker->paragraph,
    ];
});
