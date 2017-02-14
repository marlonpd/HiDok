const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');
require('laravel-elixir-browserify-official');
require('laravel-elixir-vueify');



/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
/*
 elixir(mix => {
    mix.sass('app.scss')
        .scripts([
            'libs/jquery.min.js',
            'libs/offline/offline.min.js',
            '../../../node_modules/sweetalert2/dist/sweetalert2.min.js',
        ])
        .styles([
            '../css/font-awesome-4.7.0/css/font-awesome.css',
            '../css/offline/offline-theme-slide.css' ,
            '../../../node_modules/sweetalert2/dist/sweetalert2.min.css',
        ]).browserify('app.js');
});
 */
elixir(mix => {
    mix.sass('app.scss');
    mix.scripts([
    		'libs/jquery.min.js',
            'libs/jquery/jquery-ui.js',
            'libs/offline/offline.min.js',
            'libs/bootstrap/bootstrap.min.js',
            'libs/moment.min.js',
            'libs/bootstrap/bootstrap-datetimepicker.min.js',
    		'../../../node_modules/sweetalert2/dist/sweetalert2.min.js',
    	]);
    mix.styles([
 //           '../css/bootstrap/bootstrap.min.css', 
            '../css/jquery/jquery-ui.css',
            '../css/bootstrap/bootstrap-datetimepicker.min.css', 
    		'../css/font-awesome-4.7.0/css/font-awesome.css',
            '../css/offline/offline-theme-slide.css' ,
    		'../../../node_modules/sweetalert2/dist/sweetalert2.min.css',
    	]);
    mix.browserify('app.js');
    mix.browserSync({
        proxy: 'hidok.dev',
        open: false
    });
});

