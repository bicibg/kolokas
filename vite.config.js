import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/sass/app.scss',
                'resources/sass/styles.scss',
                'resources/sass/styles-print.scss',
            ],
            refresh: true,
        }),
    ],
});
