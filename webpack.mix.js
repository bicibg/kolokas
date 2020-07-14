const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

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

