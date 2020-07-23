const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/styles.scss', 'public/css')
    .sass('resources/sass/styles-print.scss', 'public/css')
    .sass('resources/sass/styles-480px.scss', 'public/css')
    .sass('resources/sass/styles-768px.scss', 'public/css')
    .sass('resources/sass/fontawesome.scss', 'public/css')


.options({
        extractVueStyles: true,
        globalStyles: 'resources/sass/_variables.scss',
    });

/*
const mix = require('laravel-mix');

const res = 'resources/'
const pub = 'public/'

mix.extract(['vue', 'axios'])
    .autoload({
        vue: ['Vue', 'window.Vue']
    })
    .js(res + 'js/app.js', pub + 'js')
    .sass(res + 'sass/app.scss', pub + 'css')
    .sass(res + 'sass/styles.scss', pub + 'css')
    .sass(res + 'sass/styles-print.scss', pub + 'css')
    .sass(res + 'sass/styles-480px.scss', pub + 'css')
    .sass(res + 'sass/styles-768px.scss', pub + 'css')
    .sass(res + 'sass/styles-992px.scss', pub + 'css')
    .sass(res + 'sass/styles-1200px.scss', pub + 'css')
    .sass(res + 'sass/fontawesome.scss', pub + 'css')
    .options({
        extractVueStyles: true,
        globalStyles: 'resources/sass/_variables.scss',
    })
    .version()

mix.webpackConfig({
    resolve: {
        modules: [
            path.resolve('./resources'),
            path.resolve('./node_modules')
        ]
    }
})*/
