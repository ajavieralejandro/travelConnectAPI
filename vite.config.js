import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    server: {
        host: "127.0.0.1",
        port: 5173, // o el puerto que prefieras
    },
    plugins: [
        laravel({
            input: [
                "resources/css/styles.css",
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/app.jsx",
            ],
            refresh: true,
        }),
    ],
});
