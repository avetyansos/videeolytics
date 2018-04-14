let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .js('resources/assets/js/app.js', 'public/js').extract(['jquery', 'bootstrap', 'popper.js'])
    .sass('resources/assets/sass/app.scss', 'public/css')
    .styles(['resources/assets/css/**/*.css'], 'public/css/all.css')
    .options({processCssUrls: false});

// mix.copyDirectory('node_modules/ckeditor-full', 'public/plugins/ckeditor');

mix.copyDirectory('resources/assets/img', 'public/img');
mix.copyDirectory('resources/assets/fonts', 'public/fonts');
mix.copyDirectory('resources/assets/plugins', 'public/plugins');

if (mix.inProduction()) {
    mix.version();
}