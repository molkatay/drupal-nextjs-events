/* eslint-disable */
import { defineConfig } from 'vite'
import yml from '@modyfi/vite-plugin-yaml';
import twig from 'vite-plugin-twig-drupal';
import { join } from 'node:path'
import path from 'path';
import { glob } from 'glob';
export default defineConfig({
 plugins: [
    twig({
      namespaces: {
        atoms: join(__dirname, './src/components/01-atoms'),
        molecules: join(__dirname, './src/components/02-molecules'),
        organisms: join(__dirname, './src/components/03-organisms'),
        layouts: join(__dirname, './src/components/04-layouts'),
        pages: join(__dirname, './src/components/05-pages'),
      },
    }),
    yml(),
  ],
  build: {
    emptyOutDir: true,
    outDir: 'dist',
    rollupOptions: {
      input: glob.sync(path.resolve(__dirname,'./src/**/*.{css,js}')),
      output: {
        assetFileNames: 'css/[name].css',
        entryFileNames: 'js/[name].js',
      },
    },
  },
})
