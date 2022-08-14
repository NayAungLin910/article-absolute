const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/articleCreate.js', 'public/js').react();
mix.js('resources/js/articleLike.js', 'public/js').react();
mix.js('resources/js/statistics.js', 'public/js').react();