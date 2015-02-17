<?php

//Main application
Route::get('/', 'HomeController@index');
Route::get('followers', 'UserController@followers');


Route::get('write', 'ArticleController@write');
Route::get('edit/{slug}', 'ArticleController@edit')->where('slug', '[0-9]+');

//Api Routing
Route::post('/api/internal/v1/editor/save', 'EditorController@save');
Route::get('/api/angular/article/{slug}', 'ArticleController@collect');

//Static Pages
Route::get('about', 'StaticController@about');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);
