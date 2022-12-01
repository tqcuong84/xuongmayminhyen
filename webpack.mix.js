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

mix.version();
mix.options({
    processCssUrls: false    
});

mix.js('resources/js/admin_app.js', 'public/admin_assets/js').vue();

mix.js('resources/js/app.js', 'public/js').sass('resources/sass/style.scss', 'public/css');