import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js',
                'resources/css/pages/orders-index.css',
                'resources/js/pages/orders-index.js',
            ],
            
            refresh: true,
        }),
    ],
});
