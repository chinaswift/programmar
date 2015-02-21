<?php
	$pageName = 'Programmar - '. $data->title;
	$pageDesc = 'Programmar allows you to always keep up to day with the latest news, tips and how-to\'s.
				Follow your favourite subjects or people and create a custom digest of the best and most
				popular development articles.';
	$pageId = 'article';
	$pageAngular = 'article';
	$pageController = 'ArticleCtrl';

	if($data->user_id === Auth::user()->id || Auth::user()->account_type === 'admin' || Auth::user()->account_type === 'supervisor') {
		$additionalButtons = '<li><a href="/edit/'.$data->slug.'" class="brand-primary">Edit</a></li>';
	}
?>
@extends('layouts/body')
@section('content')

<div class="top-loader" ng-show="loaderShow" style="width: <% pageLoaded %>%;"></div>
<div class="container main-container" ng-class="{slideRight: moveLeft}">

	<div class="right-container animated fadeInLeft" ng-show="showEnjoys" ng-cloak>
		<div class="common-container top-section">
			<span class="title">People who enjoyed this</span>
			<div class="info">
				<span class="hide-on-mobile">Press 'esc' to exit</span>
				<span class="show-on-mobile">Tab the right to exit</span>
			</div>
		</div>

		<div class="missing-text" ng-show="article.enjoys.length == 0">No one has enjoyed this.</div>
		<div class="user" ng-repeat="(key, user) in article.enjoys">
			<img ng-src="<% user.user_avatar %>" class="profile-image img-circle">
			<a class="link" href="/dev/<% user.user_slug %>"><% user.user_name %></a>
		</div>
	</div>

	<div ng-class="{faded: moveLeft}" ng-click="closeRightSection();">
		<article class="animated fadeInUp" ng-hide="articleLoading" ng-cloak>
			<div class="title">{{$data->title}}</div>
			<div class="info">
					<a href="/dev/{{$data->userName}}"><% article.user %></a>
					<a href="#" ng-click="showEnjoySection();"><% article.enjoys.length %> Enjoy<span ng-show="article.enjoys.length > 1 || article.enjoys.length == 0">s</span></a>
			</div>
			<div class="content wrtie-area" ng-model="article.content" contenteditable="false"></div>
			<div class="bottom-bar">
				<div class="f-left">
					<a href="#" ng-click="enjoy()" class="enjoyed" ng-hide="article.enjoyed">Enjoy?</a>
					<a href="#" ng-click="enjoy()" class="enjoyed" ng-show="article.enjoyed">Enjoyed</a>
				</div>

				<div class="f-right">
					<span class="user" ng-repeat="(key, user) in article.enjoys | limitTo:5">
						<a href="/dev/<% user.user_slug %>"><img ng-src="<% user.user_avatar %>" class="profile-image img-circle"></a>
					</span>
					<a class="more" ng-click="showEnjoySection();" ng-show="article.enjoys.length >= 5">+<% article.enjoys.length - 5 %></a>
				</div>
			</div>
		</article>
		</div>
</div>
@endsection
