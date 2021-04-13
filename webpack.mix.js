const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/styles.scss', 'public/css')
    .sass('resources/sass/styles-print.scss', 'public/css')
    .sass('resources/sass/styles-480px.scss', 'public/css')
    .sass('resources/sass/styles-768px.scss', 'public/css')
    .sass('resources/sass/styles-992px.scss', 'public/css')
    .sass('resources/sass/styles-1200px.scss', 'public/css')
    .sass('resources/sass/fontawesome.scss', 'public/css')


    .options({
        extractVueStyles: true,
        globalStyles: 'resources/sass/_variables.scss',
    });

if (mix.inProduction()) {
    mix.version();
}
