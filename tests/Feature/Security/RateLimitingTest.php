<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RateLimitingTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_is_rate_limited(): void
    {
        // Send 6 requests — the 6th should be throttled (limit is 5 per minute)
        for ($i = 0; $i < 5; $i++) {
            $this->post('/contact', [
                'name' => 'Test',
                'email' => 'test@example.com',
                'subject' => 'Test',
                'user_message' => 'Message ' . $i,
            ]);
        }

        $response = $this->post('/contact', [
            'name' => 'Test',
            'email' => 'test@example.com',
            'subject' => 'Test',
            'user_message' => 'Message 6',
        ]);

        $response->assertStatus(429);
    }

    public function test_subscribe_is_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/subscribe', [
                'subscriber_email' => "test{$i}@example.com",
            ]);
        }

        $response = $this->post('/subscribe', [
            'subscriber_email' => 'test99@example.com',
        ]);

        $response->assertStatus(429);
    }

    public function test_translate_is_rate_limited(): void
    {
        $user = User::factory()->create();
        $user->profile()->create(['name' => 'User', 'email' => $user->email]);

        for ($i = 0; $i < 10; $i++) {
            $this->actingAs($user)->postJson('/translate', [
                'text' => 'Hello ' . $i,
                'to' => 'tr',
            ]);
        }

        $response = $this->actingAs($user)->postJson('/translate', [
            'text' => 'Hello again',
            'to' => 'tr',
        ]);

        $response->assertStatus(429);
    }
}
