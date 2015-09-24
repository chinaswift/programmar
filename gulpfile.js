var elixir = require('laravel-elixir');
var concat = require('gulp-concat');
var gulp = require('gulp');
var sourcemaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');

//Concat your scripts
gulp.task('scripts', function() {
  return gulp.src('public/js/_components/*.js')
  	.pipe(sourcemaps.init())
    	.pipe(concat('components.min.js'))
    .pipe(sourcemaps.write())
    .pipe(uglify())
    .pipe(gulp.dest('public/js/'));
});

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

elixir(function(mix) {
mix.sass('app.scss')
	.copy(
		'./vendor/components/jquery/jquery.min.js',
		'public/js/vendor/jquery.min.js'
	)
	.copy(
		'./vendor/components/jquery/jquery.min.map',
		'public/js/vendor/jquery.min.map'
	)
	.copy(
		'./vendor/components/angular.js/angular.min.js',
		'public/js/vendor/angular.min.js'
	)
	.copy(
		'./vendor/components/angular.js/angular.min.js.map',
		'public/js/vendor/angular.min.js.map'
	)
	.copy(
		'./vendor/twbs/bootstrap/dist/js/bootstrap.min.js',
		'public/js/vendor/bootstrap.min.js'
	)
	.copy(
		'./node_modules/angular-moment/angular-moment.min.js',
		'public/js/vendor/angular-moment.min.js'
	)
	.copy(
		'./node_modules/angular-moment/angular-moment.min.js.map',
		'public/js/vendor/angular-moment.min.js.map'
	)
	.copy(
		'./node_modules/algoliasearch/dist/algoliasearch.angular.min.js',
		'public/js/vendor/algoliasearch.angular.min.js'
	);
});
