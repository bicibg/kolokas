<?php

namespace Tests\Feature\Recipe;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_recipe_listing_page_is_accessible(): void
    {
        $response = $this->get('/recipes');

        $response->assertStatus(200);
    }

    public function test_published_recipes_appear_in_listing(): void
    {
        $user = User::factory()->create();
        $user->profile()->create(['name' => 'Chef', 'email' => $user->email]);

        $recipe = Recipe::factory()->create([
            'user_id' => $user->id,
            'published' => true,
            'main_image' => 'images/recipes/test.jpg',
        ]);

        $response = $this->get('/recipes');

        $response->assertStatus(200);
        $response->assertSee($recipe->title);
    }

    public function test_unpublished_recipes_hidden_from_listing(): void
    {
        $user = User::factory()->create();
        $user->profile()->create(['name' => 'Chef', 'email' => $user->email]);

        $recipe = Recipe::factory()->create([
            'user_id' => $user->id,
            'published' => false,
            'main_image' => 'images/recipes/test.jpg',
        ]);

        $response = $this->get('/recipes');

        $response->assertStatus(200);
        $response->assertDontSee($recipe->getTranslation('title', 'en'));
    }

    public function test_my_recipes_requires_authentication(): void
    {
        $response = $this->get('/manage/recipes');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_sees_own_recipes(): void
    {
        $user = User::factory()->create();
        $user->profile()->create(['name' => 'Chef', 'email' => $user->email]);

        $recipe = Recipe::factory()->create([
            'user_id' => $user->id,
            'published' => true,
            'main_image' => 'images/recipes/test.jpg',
        ]);

        $response = $this->actingAs($user)->get('/manage/recipes');

        $response->assertStatus(200);
        $response->assertSee($recipe->title);
    }
}
