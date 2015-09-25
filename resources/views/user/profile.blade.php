<!-- page settings -->
<?php
	//php variables
	$angular = true;
	$pageAngular = 'profile';
	$pageController = 'ProfileController';
?>

@extends('_layouts.body')

<!-- page title -->
@section('title', 'Programmar - ' . $user['username'])
@section('page', 'profile')

<!-- page content -->
@section('content')
	@include('_partials.header')

	<div class="container" ng-init="profileUser = '{{$user['id']}}'">
		<div class="profile-top">
			<div class="row">
				<div class="col-xs-1 hidden-sm-down">
					<img class="profile--image image--large" src="{{$user['avatar_url']}}">
				</div>
				<div class="col-xs-8 col-sm-7">
					<h1>{{$user['username']}}</h1>
					<ul class="stats">
						<?php
							$followerCount = 0;
							$followingCount = 0;
							foreach($user['followers'] as $follower) {
								if($follower != '' && $follower > 0) {
									$followerCount++;
								}
							}
							foreach($user['following'] as $following) {
								if($following != '' && $following > 0) {
									$followingCount++;
								}
							}
						?>
						<li>{{ $followerCount }} Followers</li>
						<li>{{ $followingCount }} Following</li>
					</ul>
				</div>
				<div class="col-xs-4 text-right btn-area">
					<a href="#" class="btn btn-primary follow-btn" @if($user['yourFollowing']) style="display: none;" @endif ng-click="followUser({{$user['id']}});">Follow</a>
					<a href="#" class="btn btn-danger unfollow-btn" @if(!$user['yourFollowing']) style="display: none;" @endif ng-click="unfollowUser({{$user['id']}});">Unfollow</a>
				</div>
			</div>
			<hr />
		</div>

		<div id="loader" ng-show="articlesLoading"></div>
		<div class="articles-container" ng-show="!articlesLoading">
			@include('_partials.article-part')
			<div class="btn-container" ng-hide="articlesLoading" ng-cloak>
				<div class="row">
					<div class="col-md-6 text-left" ng-show="lastPage > 1">
						<a href="#" class="btn btn-primary" ng-click="loadArticles(currentPage - 1);" ng-show="currentPage > 1">Previous</a>
					</div>
					<div class="col-md-6 text-right" ng-show="currentPage != lastPage">
						<a href="#" class="btn btn-primary" ng-click="loadArticles(currentPage + 1);">Next</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('_partials.footer')
@endsection
<!-- end page content -->

<!-- page scripts -->
@section('scripts')

@endsection
<!-- end page scripts -->