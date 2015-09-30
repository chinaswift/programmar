var elixir = require('laravel-elixir');

//Run Laravels Elixir function
elixir(function(mix) {

	//Sass stuff
	mix.sass('app.scss');

	//Copy files
	mix.copy('./vendor/components/jquery/jquery.js', 'resources/assets/js/vendor/jquery.js');
	mix.copy('./vendor/twbs/bootstrap/dist/js/bootstrap.js', 'resources/assets/js/vendor/bootstrap.js')
	mix.copy('./vendor/components/angular.js/angular.js', 'resources/assets/js/vendor/angular.js');
	mix.copy('./node_modules/angular-moment/angular-moment.js', 'resources/assets/js/vendor/angular-moment.js');
	mix.copy('./node_modules/angular-resource/angular-resource.js', 'resources/assets/js/vendor/angular-resource.js');

	//Scripts stuff
	mix.scripts([
		'vendor/jquery.js',
		'vendor/bootstrap.js',
		'vendor/angular.js',
		'vendor/angular-moment.js',
		'vendor/angular-resource.js',
		'vendor/showdown.js',
	], 'public/js/vendor.js');

	mix.scripts([
		'components/loader.js',
		'components/profile-dropdown.js',
		'components/bootstrap-typehead.js',
		'components/editor.min.js',
		'components/facebook-share.js',
		'components/programmar-editor.js',
		'components/mention.js',
	], 'public/js/components.js');
});
