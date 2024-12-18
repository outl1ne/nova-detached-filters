let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');
let postcssImport = require('postcss-import');

mix.extend('nova', new require('laravel-nova-devtool'));

mix
  .setPublicPath('dist')
  .js('resources/js/entry.js', 'js')
  .vue({ version: 3 })
  .postCss('resources/css/entry.css', 'dist/css/', [postcssImport(), tailwindcss('tailwind.config.js')])
  .nova('outl1ne/nova-detached-filters');
