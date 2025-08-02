import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
server: {
       host: 'localhost',
     hmr: {host: 'localhost'},
 },
    plugins: [

        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/app.jsx',
                'resources/js/react-init.js',
            ],
            refresh: true,
        }),
        react({
            // Configuración crítica para resolver el error
            jsxImportSource: '@emotion/react',
            jsxRuntime: 'automatic',
            babel: {
                plugins: [
                    ['@babel/plugin-transform-react-jsx', {
                        runtime: 'automatic',
                        importSource: 'react'
                    }]
                ],
            },
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'), // 🔥 Asegúrate de que esto esté
        },
    },
    optimizeDeps: {
        include: [
            'react',
            'react-dom',
            'reactflow',
            '@babel/plugin-transform-react-jsx',
        ],
        esbuildOptions: {
            loader: {
                '.js': 'jsx',
                '.jsx': 'jsx'
            },
        },
    },
});
