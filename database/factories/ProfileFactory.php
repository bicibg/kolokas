<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'website' => fake()->url(),
            'telephone' => fake()->phoneNumber(),
            'city' => fake()->city(),
            'facebook' => fake()->url(),
            'instagram' => fake()->url(),
            'twitter' => fake()->url(),
            'pinterest' => fake()->url(),
            'info' => fake()->paragraph(),
            'is_top' => fake()->boolean(20),
        ];
    }
}
