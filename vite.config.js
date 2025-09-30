import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    // Bagian server yang penting untuk Docker
    server: {
        host: "0.0.0.0", // Mengizinkan akses dari host manapun
        port: 5173, // Port yang diekspos di container
        hmr: {
            host: "localhost", // Host yang akan digunakan browser untuk Hot Module Reloading
            port: 5173,
        },
        watch: {
            usePolling: true, // Kadang diperlukan di lingkungan Docker/WSL untuk deteksi perubahan file
        },
    },
});
