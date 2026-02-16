<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        $ingredients = '';
        for ($x = 0; $x < fake()->numberBetween(5, 20); $x++) {
            $ingredients .= fake()->sentence(fake()->numberBetween(1, 3)) . "\r\n";
        }

        $instructions = '';
        for ($x = 0; $x < fake()->numberBetween(5, 10); $x++) {
            $instructions .= fake()->sentence() . "\r\n";
        }
        $servings = fake()->numberBetween(1, 10) . ' ' . fake()->word();

        return [
            'title' => ['en' => fake()->sentence(3), 'tr' => fake()->sentence(3), 'el' => fake()->sentence(3)],
            'description' => ['en' => fake()->paragraph(5), 'tr' => fake()->paragraph(5), 'el' => fake()->paragraph(5)],
            'ingredients' => ['en' => $ingredients, 'tr' => $ingredients, 'el' => $ingredients],
            'instructions' => ['en' => $instructions, 'tr' => $instructions, 'el' => $instructions],
            'notes' => ['en' => fake()->paragraph(3), 'tr' => fake()->paragraph(3), 'el' => fake()->paragraph(3)],
            'prep_time' => fake()->randomFloat(1, 0, 1) * 10,
            'cook_time' => (fake()->randomFloat(1, 0, 2) * 10) + 5,
            'servings' => ['en' => $servings, 'tr' => $servings, 'el' => $servings],
            'published' => fake()->boolean(80),
            'user_id' => User::factory(),
            'featured' => fake()->boolean(20),
        ];
    }
}
