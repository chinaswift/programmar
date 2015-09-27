<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * Base Routes
 */
Route::group(['prefix' => ''], function() {
	//Login
	Route::get('login', ['middleware' => 'guest', 'uses' => 'AuthController@login']);
	Route::get('logout', ['uses' => 'AuthController@logout']);

	//Home Views
	Route::get('following', ['middleware' => 'auth', 'uses' => 'HomeController@following']);
	Route::get('popular', ['uses' => 'HomeController@popular']);
	Route::get('recent', ['uses' => 'HomeController@recent']);
	Route::get('/', ['middleware' => 'guest', 'uses' => 'HomeController@redirect']);
});


/**
 * Feed Routes
 */
Route::group(['prefix' => 'feed'], function() {
	Route::get('{feed_type}', ['uses' => 'HomeController@feed']);
});


/**
 * Settings Routes
 */
Route::group(['prefix' => 'settings'], function() {
	Route::get('/', ['uses' => 'SettingsController@index']);
});


/**
 * Connect Routes
 */
Route::group(['prefix' => 'connect'], function() {
	Route::get('stripe', ['middleware' => 'auth', 'uses' => 'ConnectController@stripe']);
	Route::get('disconnect', ['middleware' => 'auth', 'uses' => 'ConnectController@disconnect']);
	Route::get('confirm', ['middleware' => 'auth', 'uses' => 'ConnectController@confirm']);
	Route::get('check', ['middleware' => 'auth', 'uses' => 'ConnectController@check']);
	Route::post('bill', ['middleware' => 'auth', 'uses' => 'ConnectController@bill']);
});

/**
 * Search Routes
 */
Route::group(['prefix' => 'search'], function() {
	Route::get('/', ['uses' => 'SearchController@search']);
});

/**
 * Write Routes
 */
Route::group(['prefix' => 'write'], function() {
	Route::get('/{article_id?}', ['middleware' => 'auth', 'uses' => 'WriteController@index'])->where('article_id', '[0-9]+');
	Route::post('post', ['middleware' => 'auth', 'uses' => 'WriteController@store']);
	Route::post('edit', ['middleware' => 'auth', 'uses' => 'WriteController@edit']);
	Route::post('publish', ['middleware' => 'auth', 'uses' => 'WriteController@publish']);
});


/**
 * Notifications Routes
 */
Route::group(['prefix' => 'notifications'], function() {
	Route::get('/', ['middleware' => 'auth', 'uses' => 'NotificationsController@index']);
});

/**
 * Article Routes
 */
Route::group(['prefix' => 'articles'], function() {
	Route::get('{article_id}', ['uses' => 'ArticleController@displayArticle'])->where('article_id', '[0-9]+');
	Route::get('/collect/{article_id}', ['uses' => 'ArticleController@collectArticle'])->where('article_id', '[0-9]+');
	Route::get('following', ['uses' => 'ArticleController@collectFollowing']);
	Route::get('popular', ['uses' => 'ArticleController@collectPopular']);
	Route::get('recent', ['uses' => 'ArticleController@collectRecent']);
	Route::get('drafts', ['middleware' => 'auth', 'uses' => 'ArticleController@collectDrafts']);
	Route::post('comment', ['middleware' => 'auth', 'uses' => 'ArticleController@postComment']);
	Route::post('collectComments', ['uses' => 'ArticleController@collectComments']);
	Route::post('upvote', ['middleware' => 'auth', 'uses' => 'ArticleController@upvoteArticle']);
	Route::get('edit/collect', ['middleware' => 'auth', 'uses' => 'ArticleController@collectEdit']);
});

/**
 * Admin Routes
 */
Route::group(['prefix' => 'admin'], function() {
	Route::get('/styleguide', 'AdminController@styleguide');
});

/**
 * User Routes
 */
Route::group(['prefix' => 'user'], function() {
	Route::get('collect/{user}', ['uses' => 'UserController@collect']);
	Route::get('notifications', ['middleware' => 'auth', 'uses' => 'UserController@collectNotifications']);
	Route::get('allNotifications', ['middleware' => 'auth', 'uses' => 'UserController@collectAllNotifications']);
	Route::get('readNotifications', ['middleware' => 'auth', 'uses' => 'UserController@readNotifications']);
	Route::post('follow', ['middleware' => 'auth', 'uses' => 'UserController@follow']);
	Route::post('unfollow', ['middleware' => 'auth', 'uses' => 'UserController@unfollow']);
	Route::get('articles', ['uses' => 'UserController@articles']);
	Route::post('update', ['middleware' => 'auth', 'uses' => 'UserController@update']);
	Route::get('{username}', ['uses' => 'UserController@profile']);
});

/**
 * Auth Routes
 */
Route::group(['prefix' => 'auth'], function () {
	//Initial Github auth
	Route::get('github', 'AuthController@github');
	//Handling github acception
	Route::get('accept', 'AuthController@accept');
});