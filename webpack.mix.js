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

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);


mix.scripts([
    'resources/js/Application.js',
    'resources/js/balance.js',
], 'public/js/balance.js');

mix.scripts([
    'resources/js/Application.js',
    'resources/js/history.js',
], 'public/js/history.js');