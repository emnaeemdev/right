import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: {
                app: 'resources/js/app.js',
                css: 'resources/css/app.css',
            },
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name === 'css.css' || assetInfo.name?.endsWith('.css')) {
                        return 'assets/app-[hash].css';
                    }

                    return 'assets/[name]-[hash][extname]';
                },
            },
        },
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
