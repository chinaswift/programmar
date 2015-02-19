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

<div class="container">
	<div class="user">
		{{$user->name}}
		@if($user->followingUser)
			<a href="#" ng-init="following=true;" class="btn btn-danger" ng-show="following" ng-click="unfollowUser('{{$user->username}}');"><span class="octicon octicon-mark-github"></span>Un-Follow</a>
			<a href="#" class="btn btn-primary" ng-hide="following" ng-click="followUser('{{$user->username}}');"><span class="octicon octicon-mark-github"></span>Follow</a>
		@else
			@if($user->id != Auth::user()->id)
				<a href="#" class="btn btn-danger" ng-show="following" ng-click="unfollowUser('{{$user->username}}');"><span class="octicon octicon-mark-github"></span>Un-Follow</a>
				<a href="#" class="btn btn-primary" ng-hide="following" ng-click="followUser('{{$user->username}}');"><span class="octicon octicon-mark-github"></span>Follow</a>
			@endif
		@endif
	</div>
	<div class="info-base">
		<a href="http://github.com/{{$user->username}}/followers" target="_blank">{{ count($user->followers) }} Followers</a>
		<a href="http://github.com/{{$user->username}}/following" target="_blank">{{ count($user->following) }} Following</a>
	</div>

	<div class="article-listing">
		@if(count($articles) > 0)
			@foreach($articles as $article)
				<div class="item">
					<div class="base">
						<a class="title" href="/article/{{$article->slug}}">{{ $article->title }}</a>
						<div class="info">
							<span>{{ date("dS F Y", strtotime('now', $article->last_updated)) }}</span>
						</div>
					</div>
				</div>
			@endforeach
		@else
			This user has no articles at this time.
		@endif
	</div>
</div>
@endsection

@section('scripts')
	<script src="/js/vendor/github.js"></script>
@endsection