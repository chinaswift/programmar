<?php

//Main application
Route::get('/', 'HomeController@index');
Route::get('followers', 'UserController@followers');
Route::get('write', 'ArticleController@write');

//Api Routing
Route::post('/api/internal/v1/editor/save', 'EditorController@save');

//Static Pages
Route::get('about', 'StaticController@about');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);
