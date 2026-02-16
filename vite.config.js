import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue2 from '@vitejs/plugin-vue2';
import path from 'path';

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
        vue2(),
    ],
    resolve: {
        alias: {
            jquery: path.resolve(__dirname, 'node_modules/jquery/dist/jquery.js'),
            vue: path.resolve(__dirname, 'node_modules/vue/dist/vue.esm.js'),
        },
    },
});
