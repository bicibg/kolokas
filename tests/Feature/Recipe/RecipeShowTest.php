<?php

namespace Tests\Feature\Recipe;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_recipe_is_accessible(): void
    {
        $user = User::factory()->create();
        $user->profile()->create(['name' => 'Chef', 'email' => $user->email]);

        $recipe = Recipe::factory()->create([
            'user_id' => $user->id,
            'published' => true,
            'main_image' => 'images/recipes/test.jpg',
        ]);

        $response = $this->get('/recipes/' . $recipe->slug);

        $response->assertStatus(200);
        $response->assertSee($recipe->title);
    }

    public function test_unpublished_recipe_redirects_away(): void
    {
        $user = User::factory()->create();
        $user->profile()->create(['name' => 'Chef', 'email' => $user->email]);

        $recipe = Recipe::factory()->create([
            'user_id' => $user->id,
            'published' => false,
            'main_image' => 'images/recipes/test.jpg',
        ]);

        $response = $this->get('/recipes/' . $recipe->slug);

        $response->assertRedirect();
    }
}
