<?php

//Main application
Route::get('/', 'HomeController@index');
Route::get('following', 'UserController@followers');
Route::get('drafts', 'UserController@drafts');

Route::get('dev/{username}', 'UserController@profile');
Route::get('write', 'ArticleController@write');
Route::get('edit/{slug}', 'ArticleController@edit')->where('slug', '[0-9]+');
Route::get('article/{slug}', 'ArticleController@view')->where('slug', '[0-9]+');

//Api Routing
Route::post('/api/internal/v1/editor/save', 'EditorController@save');
Route::post('/api/internal/v1/editor/publish', 'EditorController@publish');
Route::post('/api/internal/v1/editor/delete', 'EditorController@delete');
Route::get('/api/angular/article/{slug}', 'ArticleController@collect');

Route::post('/api/internal/v1/article/enjoy', 'ArticleController@enjoy');

Route::get('/api/angular/github/follow/{username}', 'UserController@followUser');
Route::get('/api/angular/github/unfollow/{username}', 'UserController@unfollowUser');

//Static Pages
Route::get('about', 'StaticController@about');

//OAuth
Route::get('oauth/{account}', 'OAuthController@access');
Route::get('auth/{account}', 'OAuthController@confirm');