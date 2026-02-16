<?php

namespace Tests\Feature\Seo;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MetaTagsTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_has_meta_description(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<meta name="description"', false);
    }

    public function test_homepage_has_canonical_url(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<link rel="canonical"', false);
    }

    public function test_homepage_has_hreflang_tags(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('hreflang="en"', false);
        $response->assertSee('hreflang="tr"', false);
        $response->assertSee('hreflang="el"', false);
        $response->assertSee('hreflang="x-default"', false);
    }

    public function test_homepage_has_open_graph_tags(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('og:type', false);
        $response->assertSee('og:title', false);
        $response->assertSee('og:description', false);
        $response->assertSee('og:image', false);
    }

    public function test_homepage_has_twitter_card_tags(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('twitter:card', false);
        $response->assertSee('twitter:title', false);
    }

    public function test_recipe_page_has_json_ld(): void
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
        $response->assertSee('application/ld+json', false);
        $response->assertSee('"Recipe"', false);
    }

    public function test_recipe_page_has_specific_meta_description(): void
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
        $response->assertSee('og:type', false);
    }

    public function test_sitemap_is_accessible(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
    }

    // robots.txt is served by the web server (Nginx), not Laravel
}
