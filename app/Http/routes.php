<?php

//Main Routes
Route::get('/', 'HomeController@index');
Route::get('following', 'UserController@followers');
Route::get('drafts', 'UserController@drafts');
Route::get('dev/{username}', 'UserController@profile');
Route::get('write', 'ArticleController@write');
Route::get('edit/{slug}', 'ArticleController@edit')->where('slug', '[0-9]+');
Route::get('article/{slug}', 'ArticleController@view')->where('slug', '[0-9]+');

//Pagination
Route::get('recent/{page}', 'HomeController@index')->where('slug', '[0-9]+');
Route::get('following/{page}', 'UserController@followers')->where('slug', '[0-9]+');
Route::get('drafts/{page}', 'UserController@drafts')->where('slug', '[0-9]+');

//Api
Route::get('api/v2/followers/{user_id?}', 'ApiController@followers');
Route::get('api/v2/following/{user_id?}', 'ApiController@following');
Route::post('api/v2/follow/{user_id}', 'ApiController@follow');
Route::post('api/v2/unfollow/{user_id}', 'ApiController@unfollow');
Route::get('api/v2/user/{user_id?}', 'ApiController@user');
Route::get('api/v2/article/{article_id}', 'ApiController@collect');
Route::get('api/v2/articles/{user_id?}', 'ApiController@articles');
Route::get('api/v2/content/{article_id}', 'ApiController@content');
Route::get('api/v2/enjoys/{user_id?}', 'ApiController@enjoys');


//Api Routing
Route::post('/api/internal/v1/editor/save', 'EditorController@save');
Route::post('/api/internal/v1/editor/publish', 'EditorController@publish');
Route::post('/api/internal/v1/editor/delete', 'EditorController@delete');

Route::post('/api/internal/v1/article/enjoy', 'ArticleController@enjoy');

//Static Pages
Route::get('about', 'StaticController@about');

//OAuth
Route::get('oauth/{account}', 'OAuthController@access');
Route::get('auth/{account}', 'OAuthController@confirm');