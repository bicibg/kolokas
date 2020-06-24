<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

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

$factory->define(\App\Profile::class, function (Faker $faker) {
    $email = $faker->unique()->safeEmail;
    $files = \Illuminate\Support\Facades\Storage::files('public/images/profiles');
    $randomFile = \Illuminate\Support\Str::replaceFirst('public/', 'storage/', $files[rand(0, count($files) - 1)]);
    return [
        'user_id' => factory(User::class)->create(['email' => $email]),
        'name' => $faker->name,
        'email' => $email,
        'website' => $faker->url,
        'telephone' => $faker->phoneNumber,
        'city' => $faker->city,
        'facebook' => $faker->url,
        'instagram' => $faker->url,
        'twitter' => $faker->url,
        'pinterest' => $faker->url,
        'photo' => $randomFile,
        'info' => $faker->paragraph,
    ];
});
