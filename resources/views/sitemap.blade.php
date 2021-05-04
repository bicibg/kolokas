<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://kolokas.com</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>https://kolokas.com/recipes</loc>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>https://kolokas.com/authors</loc>
        <changefreq>daily</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>https://kolokas.com/contact</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>https://kolokas.com/about-us</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $key => $locale)
        @foreach ($recipes as $recipe)
            <url>
                <loc>{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($key, $recipe->url) }}</loc>
                <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z', strtotime($recipe->updated_at)) }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.8</priority>
            </url>
        @endforeach
        @foreach ($authors as $author)
            <url>
                <loc>{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($key, $author->url)  }}</loc>
                <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z', strtotime($author->user->recipes->last()->updated_at)) }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.6</priority>
            </url>
        @endforeach
    @endforeach
</urlset>
