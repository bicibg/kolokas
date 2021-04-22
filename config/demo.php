<?php

return [
    'demo_enabled' => env('DEMO_MODE', true),
    'demo_route_names' => [
        'demo.index',
        'demo.enable',
        'demo.activate',
        'demo.recipe',
        'locale',
        'sitemap'
    ],
    'demo_key' => env('DEMO_KEY', null)
];
