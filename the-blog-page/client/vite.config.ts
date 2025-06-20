import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import path from 'path';

// https://vite.dev/config/
export default defineConfig({
    plugins: [react()],
    resolve: {
        alias: {
            "@features": path.resolve(__dirname, "src/features"),
            "@layouts": path.resolve(__dirname, "src/layouts"),
            "@components": path.resolve(__dirname, "src/components"),
            "@routes": path.resolve(__dirname, "src/routes"),
            "@utils": path.resolve(__dirname, "src/utils"),
            "@assets": path.resolve(__dirname, "src/assets")
        }
    }
})
