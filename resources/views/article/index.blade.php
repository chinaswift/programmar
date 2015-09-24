<!-- page settings -->
<?php
	//php variables
	$angular = true;
	$pageAngular = 'article';
	$pageController = 'ArticleController';
?>

@extends('_layouts.body')

<!-- page title -->
@section('title', 'Programmar - ' . $article['name'])
@section('page', 'article')

<!-- page content -->
@section('content')
	@include('_partials.header')
	@include('_modals.published')

	<div ng-show="articleLoading" ng-init="article.id = {{$article['id']}}"><div id="loader"></div></div>
	<di ng-hide="articleLoading" ngcloak>
		<div class="container">
			<div class="title">
				<div class="row">
					<div class="col-xs-12 col-sm-6">
						<a href="/user/@{{article.owner_user}}"><img ng-src="@{{ article.owner_img }}" class="profile--image"></a>
						<h1>@{{ article.name }}</h1>
					</div>
					<div class="col-xs-6 text-right hidden-sm-down">
						<span class="time">Posted @{{article.time_ago}}</span>
					</div>
				</div>
			</div>
			<div class="content"></div>
			<div class="social-bar" ng-cloak>
				<div class="row">
					<div class="col-xs-6">
						@include('_partials.article-upvote')
						<a href="/write/@{{article.id}}" class="btn btn-gray" ng-cloak ng-show="userData.id == article.owner_id">Edit</a>
					</div>
					<div class="col-xs-6 text-right">
						<button type="button" class="btn btn-facebook square" ng-click="facebookShare();">Share on Facebook</button>
        		<a type="button" class="btn btn-twitter square popup" ng-click="twitterShare();">Share on Twitter</a>
					</div>
				</div>
			</div>

			<div class="comments" ng-cloak>
				<div class="comment clearfix" ng-repeat="(key, comment) in comments">
					<a href="/user/@{{comment.from_username}}">
						<img ng-src="@{{comment.from_avatar}}" class="profile--image image--small">
					</a>
					<div class="comment-content">
						<div ng-bind-html="comment.content | sanitize"></div>
						<span class="time-ago">@{{comment.time_ago}}</span>
					</div>
				</div>
				<div class="btn-container">
					<div class="row">
						<div class="col-md-6 text-left" ng-show="lastPage > 1">
							<a href="javascript:void(0)" class="btn btn-primary" ng-click="commentCollect(currentPage - 1);" ng-show="currentPage > 1">Previous</a>
						</div>
						<div class="col-md-6 text-right" ng-show="currentPage != lastPage">
							<a href="javascript:void(0)" class="btn btn-primary" ng-click="commentCollect(currentPage + 1);">Next</a>
						</div>
					</div>
				</div>
				<div class="comment-area">
					<form name="commentForm" novalidate ng-submit="commentPost();">
						<input class="input--primary comment-text" ng-model="comment" placeholder="Write your comment..." required>
						<div class="text-right">
							<button class="btn btn-primary comment-btn ng-hide" type="submit" ng-disabled="commentForm.$invalid">Comment</button>
						</button>
					</form>
				</div>
			</div>
		</div>
	</di>
@endsection
<!-- end page content -->

<!-- page scripts -->
@section('scripts')

@endsection
<!-- end page scripts -->