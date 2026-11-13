import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { globSync } from 'glob';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                ...globSync('resources/js/entries/*.js', { posix: true }),
            ],
            refresh: true,
        }),
    ],
});
