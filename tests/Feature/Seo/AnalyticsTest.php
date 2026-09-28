<?php

namespace Tests\Feature\Seo;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_ga4_tag_renders_in_production_when_configured(): void
    {
        config(['services.google_analytics.measurement_id' => 'G-TEST12345']);
        $this->app['env'] = 'production';

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('googletagmanager.com/gtag/js?id=G-TEST12345', false);
        $response->assertSee("gtag('config', \"G-TEST12345\")", false);
    }

    public function test_ga4_tag_not_rendered_without_measurement_id(): void
    {
        config(['services.google_analytics.measurement_id' => null]);
        $this->app['env'] = 'production';

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('googletagmanager.com/gtag/js', false);
    }

    public function test_ga4_tag_not_rendered_outside_production(): void
    {
        config(['services.google_analytics.measurement_id' => 'G-TEST12345']);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('googletagmanager.com/gtag/js', false);
    }
}
