import {defineConfig} from 'vite'
import react from '@vitejs/plugin-react-swc'
import tailwindcss from '@tailwindcss/vite'

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
                'src/kanji-memory-card.tsx',
            ],
        },
    },
    publicDir: false,
    plugins: [
        react(),
        tailwindcss(),
    ],
    server: {
        cors: {
            origin: '*',
        },
    },
})
