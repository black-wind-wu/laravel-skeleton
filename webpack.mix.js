const mix = require('laravel-mix');

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

if (mix.inProduction()) {
    mix.version();
    mix.disableNotifications();
}


mix.copyDirectory('resources/img', 'public/img');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/user.js', 'public/js')
    .extract(['jquery', 'vue', 'vuex'])
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/user.scss', 'public/css');

mix.js('resources/js/plugins/ckeditor.js', 'public/js');
mix.js('resources/js/plugins/select2.js', 'public/js');

mix.copy('node_modules/select2/dist/css/select2.css', 'public/css/select2.css');
