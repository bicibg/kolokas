<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">

    @php
        $locales = array_keys(config('app.languages'));
    @endphp

    {{-- Static pages --}}
    @foreach(['/' => ['daily', '1.0'], '/recipes' => ['daily', '0.8'], '/authors' => ['daily', '0.6'], '/contact' => ['monthly', '0.5'], '/about-us' => ['monthly', '0.5']] as $path => [$freq, $priority])
    <url>
        <loc>{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('en', url($path)) }}</loc>
        <changefreq>{{ $freq }}</changefreq>
        <priority>{{ $priority }}</priority>
        @foreach($locales as $lang)
        <xhtml:link rel="alternate" hreflang="{{ $lang }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($lang, url($path)) }}"/>
        @endforeach
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('en', url($path)) }}"/>
    </url>
    @endforeach

    {{-- Recipes --}}
    @foreach ($recipes as $recipe)
    <url>
        <loc>{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('en', $recipe->url) }}</loc>
        <lastmod>{{ $recipe->updated_at->toIso8601String() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
        @foreach($locales as $lang)
        <xhtml:link rel="alternate" hreflang="{{ $lang }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($lang, $recipe->url) }}"/>
        @endforeach
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('en', $recipe->url) }}"/>
    </url>
    @endforeach

    {{-- Authors --}}
    @foreach ($authors as $author)
    <url>
        <loc>{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('en', $author->url) }}</loc>
        <lastmod>{{ $author->user->recipes->last()->updated_at->toIso8601String() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
        @foreach($locales as $lang)
        <xhtml:link rel="alternate" hreflang="{{ $lang }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($lang, $author->url) }}"/>
        @endforeach
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('en', $author->url) }}"/>
    </url>
    @endforeach
</urlset>
