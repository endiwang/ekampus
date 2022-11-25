const mix = require('laravel-mix');

// mix.js('src/app.js', 'dist')
//    .sass('src/app.scss', 'dist')
//    .setPublicPath('dist');

mix.sass(`resources/assets/demo1/sass/style.scss`, `public/assets/css/style.bundle.css`, {sassOptions: {includePaths: ['node_modules']}});

