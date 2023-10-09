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

mix.js('resources/assets/js/app.js', 'public/js')
   .js('resources/assets/js/shopping-cart.js', 'public/js')
   .js('resources/assets/js/purchase.js', 'public/js')
   .js('resources/assets/js/counters.js', 'public/js')
   .js('resources/assets/js/payment.js', 'public/js')
   .js('resources/assets/js/domain-cart.js', 'public/js')
   .js('resources/assets/js/ssl-offer.js', 'public/js')
   .js('resources/assets/js/ssl-cart.js', 'public/js')
   .js('resources/assets/js/internet-request.js', 'public/js')
   .js('resources/assets/js/offers/domains.js', 'public/js/offers')
   .js('resources/assets/js/medianis.js', 'public/js')
    .sass('resources/assets/scss/app.scss', 'public/css')
    .sass('resources/assets/scss/cookieConsent.scss', 'public/css');

mix.version();