import tailwindcss from '@tailwindcss/vite'
import react from '@vitejs/plugin-react-swc'
import path from 'path'
import {defineConfig} from 'vite'

// https://vite.dev/config/
export default defineConfig({
    build: {
        emptyOutDir: true,
        manifest: true,
        modulePreload: {
            polyfill: true,
        },
        outDir: '../dist',
        rollupOptions: {
            input: [
                'src/v2/kanji-memory-card.tsx',
            ],
        },
    },
    publicDir: false,
    plugins: [
        react(),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './src'),
        },
    },
    server: {
        cors: {
            origin: '*',
        },
    },
})
