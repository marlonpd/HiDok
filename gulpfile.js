const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

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
elixir(mix => {
    mix.sass('app.scss')
    	.scripts([
    		'libs/jquery.min.js',
    		'../../../node_modules/sweetalert2/dist/sweetalert2.min.js',
    	])
    	.styles([
    		'../css/font-awesome-4.7.0/css/font-awesome.css',
    		'../../../node_modules/sweetalert2/dist/sweetalert2.min.css',
    	]);
    	//.webpack('app.js');
});
