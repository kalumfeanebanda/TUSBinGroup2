import { fileURLToPath, URL } from 'node:url'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

export default defineConfig({
  plugins: [
    vue(),
    vueDevTools(),
  ],

  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    },
  },

  server: {
    port: 5173,        // Force Vite to always use this port
    strictPort: false, // Prevent random port changes forever
    proxy: {
      '/api': {
        target: 'http://localhost/TUSBinGroup2/BinBackendG2/public',
        changeOrigin: true,
      },
    },
  },
})
