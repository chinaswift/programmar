<?php
	$pageName = 'Programmar - ' . $user->name;
	$pageDesc = 'Programmar allows you to always keep up to day with the latest news, tips and how-to\'s.
				Follow your favourite subjects or people and create a custom digest of the best and most
				popular development articles.';
	$pageId = 'profile';
	$pageAngular = 'profile';
	$pageController = 'ProfileCtrl';
?>
@extends('layouts/body')
@section('content')

<div class="top-loader" ng-show="loaderShow" style="width: <% pageLoaded %>%;"></div>
<div class="container main-container" ng-class="{slideRight: moveLeft}">
	<div class="right-container animated fadeInLeft" ng-show="showFollowers" ng-cloak>
		<div class="common-container top-section">
			<span class="title">Followers</span>
			<div class="info">
				<span class="hide-on-mobile">Press 'esc' to exit</span>
				<span class="show-on-mobile">Tab the right to exit</span>
			</div>
		</div>

		<div class="missing-text" ng-show="userData.followers.length == 0"><% userData.name %> has no followers.</div>
		<div class="user" ng-repeat="(key, user) in userData.followers">
			<img ng-src="<% user.user_avatar %>" class="profile-image img-circle">
			<a class="link" href="/dev/<% user.user_slug %>"><% user.user_name %></a>
		</div>
	</div>

	<div class="right-container animated fadeInLeft" ng-show="showFollowing" ng-cloak>
		<div class="common-container top-section">
			<span class="title">Following</span>
			<div class="info">
				<span class="hide-on-mobile">Press 'esc' to exit</span>
				<span class="show-on-mobile">Tab the right to exit</span>
			</div>
		</div>

		<div class="missing-text" ng-show="userData.following.length == 0"><% userData.name %> is not following anyone.</div>
		<div class="user" ng-repeat="(key, user) in userData.following">
			<img ng-src="<% user.user_avatar %>" class="profile-image img-circle">
			<a class="link" href="/dev/<% user.user_slug %>"><% user.user_name %></a>
		</div>
	</div>

	<div ng-class="{faded: moveLeft}" ng-click="closeRightSection();">
		<div class="user-data-container animated fadeInUp" ng-hide="userLoading" ng-cloak>
			<div class="common-container top-section">
				<div class="clearfix">
					<img ng-src="<% userData.avatar %>" class="img-circle profile-image f-left">
					<div class="f-left clearfix">
						<span class="title"><% userData.name %></span>
						<div class="info">
							<a href="#" ng-click="toggleFollowers();"><% userData.followers.length %> Followers</a>
							<a href="#" ng-click="toggleFollowing();"><% userData.following.length %> Following</a>
							<a href="#" ng-show="showArticleContent" ng-click="showEnjoys();"><% userData.enjoys.length %> Enjoyed article<span ng-show="userData.enjoys.length > 1 || userData.enjoys.length == 0">s</span></a>
							<a href="#" ng-show="showEnjoyContent" ng-click="showArticles();"><% articlesData.length %> Article<span ng-show="articlesData.length > 1 || articlesData.length == 0">s</span></a>
						</div>
					</div>
					<div class="f-right" ng-hide="userData.self">
						<div class="follow-buttons">
							<a href="#" class="btn btn-gray" ng-show="userData.your_following" ng-click="unfollow();"><% unfollowTxt %></a>
							<a href="#" class="btn btn-primary" ng-hide="userData.your_following" ng-click="follow();"><% followTxt %></a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="article-listing animated fadeInUp" ng-cloak ng-hide="articlesLoading" ng-show="showArticleContent">
			<div class="missing-text animated fadeInUp" ng-show="articlesData.length == 0">
				<% userData.name %> currently has no articles
			</div>
			<div class="common-container list clearfix" ng-repeat="(key, article) in articlesData">
				<a class="title" href="/article/<% article.slug %>"><% article.title %></a>
				<div class="info">
					<span><% article.enjoys.length %> Enjoy<span ng-show="article.enjoys.length > 1 || article.enjoys.length == 0">s</span></span>
				</div>
			</div>
		</div>

		<div class="article-listing animated fadeInUp" ng-cloak ng-show="showEnjoyContent">
			<div class="missing-text animated fadeInUp" ng-show="userData.enjoys.length == 0">
				<% userData.name %> currently hasn't enjoyed anything!
			</div>
			<div class="common-container list clearfix" ng-repeat="(key, article) in userData.enjoys">
				<a class="title" href="/article/<% article.article_data.slug %>"><% article.article_data.title %></a>
				<div class="info">
					<span><% article.enjoys.length %> Enjoy<span ng-show="article.enjoys.length > 1 || article.enjoys.length == 0">s</span></span>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
	<script src="/js/vendor/github.js"></script>
@endsection