import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        https: false,
        host: 'pentaspai.test',
    },
    base: '',
    build: {
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    return assetInfo.name == 'app.css' ? 'assets/app.css' : 'assets/'+assetInfo.name;
                }
            }
        },
        // minify: process.env.APP_ENV !== 'local' ? true : false,
        // cssCodeSplit: process.env.APP_ENV === 'local' ? false : undefined
    }
});
