import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'https://seashell-app-ytncg.ondigitalocean.app/',  // Tu dominio con HTTPS
            protocol: 'wss',  // Usar WebSocket seguro
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js','resources/js/app.jsx','resources/js/frontReactTravel/src/main.tsx'],
            refresh: true,
        }),
    ],
});
