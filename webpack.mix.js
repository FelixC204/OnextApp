const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .vue() // Cho phép Vue.js
    .sass('resources/sass/app.scss', 'public/css')
    .version(); // Tạo version để cache busting (khuyến nghị khi build cho production)
