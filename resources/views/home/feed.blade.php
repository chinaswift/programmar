<!-- page settings -->
<?php
	//php variables
	$angular = true;
	$pageAngular = 'feed';
	$pageController = 'FeedController';
?>

@extends('_layouts.body')

<!-- page title -->
@section('title', 'Programmar - ' . ucfirst($type))
@section('page', 'home')

<!-- page content -->
@section('content')
	@include('_partials.header')
	<div class="container" ng-init="feedType='{{$type}}'">

		@if(!Request::session()->get('x-auth-token'))
			<div class="auth-section">
				<h2>Login to programmar</h2>
				<p>When logging into Programmar you instantly get access to create a curated reading list, write new articles and provide feedback. It's really simple to login. It's just one button.</p>
				<a href="/auth/github" class="btn btn-github">Login with GitHub</a>
				<hr />
			</div>
		@endif

		<div class="articles-container" ng-cloak>
			<div  ng-hide="articles.length > 0 || articlesLoading" ng-cloak>There doesn't seem to be any articles from {{$type}} today. Quick <a href="/write">make one!</a></div>
			<div id="loader" ng-show="articlesLoading"></div>
			@include('_partials.article-part')
		</div>

		<div class="btn-container" ng-hide="articlesLoading" ng-cloak>
			<div class="row">
				<div class="col-md-6 text-left" ng-show="lastPage > 1">
					<a href="#" class="btn btn-primary" ng-click="collectPosts(currentPage - 1);" ng-show="currentPage > 1">Previous</a>
				</div>
				<div class="col-md-6 text-right" ng-show="currentPage != lastPage">
					<a href="#" class="btn btn-primary" ng-click="collectPosts(currentPage + 1);">Next</a>
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