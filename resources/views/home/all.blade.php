<?php
	$pageName = 'Programmar - All';
	$pageDesc = 'Programmar allows you to always keep up to day with the latest news, tips and how-to\'s.
				Follow your favourite subjects or people and create a custom digest of the best and most
				popular development articles.';
	$pageId = "home";
	$pageAngular = 'home';
	$pageController = 'HomeCtrl';
	$all = 'active';
?>

@extends('layouts/body')

@section('content')
	<div class="container">
		@include('home/includes/sidebar')

		<div class="article-container">
			@if(count($articles) > 0)
				@foreach($articles as $article)
					<div class="common-container list clearfix">
						<a class="title" href="/article/{{$article->slug}}">{{ $article->title }}</a>
						<div class="info">
							<a href="/dev/{{ $article->username }}">{{ $article->userName }}</a>
							<span>
								{{ $article->enjoys }}
								@if($article->enjoys > 1 || $article->enjoys == 0)
									Enjoys
								@else
									Enjoy
								@endif
							</span>
						</div>
					</div>
				@endforeach
			@else
				There are no articles at this time. <a href="/write">Create one</a>.
			@endif
			@if($pagination != '')
				<div class="pagination-container">
			 		{!! $pagination !!}
				</div>
			@endif
		</div>
	</div>
@endsection