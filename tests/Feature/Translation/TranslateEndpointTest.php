<?php

namespace Tests\Feature\Translation;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TranslateEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_translate(): void
    {
        $response = $this->postJson('/translate', [
            'text' => 'Hello',
            'to' => 'tr',
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_access_translate(): void
    {
        $user = User::factory()->create();
        $user->profile()->create(['name' => 'User', 'email' => $user->email]);

        // Mock the translate helper to avoid real API calls
        $this->mock('overload:Google\Cloud\Translate\V2\TranslateClient', function ($mock) {
            $mock->shouldReceive('translate')
                ->andReturn(['text' => 'Merhaba']);
        });

        $response = $this->actingAs($user)->postJson('/translate', [
            'text' => 'Hello',
            'to' => 'tr',
        ]);

        $response->assertStatus(200);
    }

    public function test_translate_returns_original_text_when_empty(): void
    {
        $user = User::factory()->create();
        $user->profile()->create(['name' => 'User', 'email' => $user->email]);

        $response = $this->actingAs($user)->postJson('/translate', [
            'text' => '',
            'to' => 'tr',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['translated_text' => '']);
    }
}
