<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\RecipeImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeImageFactory extends Factory
{
    protected $model = RecipeImage::class;

    public function definition(): array
    {
        return [
            'recipe_id' => Recipe::factory(),
            'url' => imageUrl(640, 480),
        ];
    }
}
