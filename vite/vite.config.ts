import {defineConfig} from 'vite'
import react from '@vitejs/plugin-react-swc'

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
                'src/index.tsx',
            ],
        },
    },
    publicDir: false,
    plugins: [react()],
    server: {
        cors: {
            origin: '*',
        },
    },
})
