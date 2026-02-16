<?php

namespace Tests\Feature\Recipe;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_access_edit_page(): void
    {
        $user = User::factory()->create();
        $user->profile()->create(['name' => 'Chef', 'email' => $user->email]);

        $recipe = Recipe::factory()->create([
            'user_id' => $user->id,
            'published' => true,
            'main_image' => 'images/recipes/test.jpg',
        ]);

        $response = $this->actingAs($user)->get('/recipes/' . $recipe->slug . '/edit');

        $response->assertStatus(200);
    }

    public function test_non_owner_cannot_access_edit_page(): void
    {
        $owner = User::factory()->create();
        $owner->profile()->create(['name' => 'Owner', 'email' => $owner->email]);

        $other = User::factory()->create();
        $other->profile()->create(['name' => 'Other', 'email' => $other->email]);

        $recipe = Recipe::factory()->create([
            'user_id' => $owner->id,
            'published' => true,
            'main_image' => 'images/recipes/test.jpg',
        ]);

        $response = $this->actingAs($other)->get('/recipes/' . $recipe->slug . '/edit');

        $response->assertRedirect();
        $response->assertSessionHas('flash-error');
    }

    public function test_admin_can_access_any_recipe_edit(): void
    {
        $owner = User::factory()->create();
        $owner->profile()->create(['name' => 'Owner', 'email' => $owner->email]);

        $admin = User::factory()->create(['email' => 'bugraergin@gmail.com']);
        $admin->profile()->create(['name' => 'Admin', 'email' => $admin->email]);

        $recipe = Recipe::factory()->create([
            'user_id' => $owner->id,
            'published' => true,
            'main_image' => 'images/recipes/test.jpg',
        ]);

        $response = $this->actingAs($admin)->get('/recipes/' . $recipe->slug . '/edit');

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_edit_page(): void
    {
        $user = User::factory()->create();
        $user->profile()->create(['name' => 'Chef', 'email' => $user->email]);

        $recipe = Recipe::factory()->create([
            'user_id' => $user->id,
            'published' => true,
            'main_image' => 'images/recipes/test.jpg',
        ]);

        $response = $this->get('/recipes/' . $recipe->slug . '/edit');

        $response->assertRedirect('/login');
    }
}
