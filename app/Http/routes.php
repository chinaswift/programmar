<?php

//Main application
Route::get('/', 'HomeController@index');
Route::get('followers', 'UserController@followers');
Route::get('write', 'UserController@write');


//Static Pages
Route::get('about', 'StaticController@about');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);
