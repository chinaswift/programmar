<?php
	$pageName = 'Programmar';
	$pageDesc = 'Programmar allows you to always keep up to day with the latest news, tips and how-to\'s.
				Follow your favourite subjects or people and create a custom digest of the best and most
				popular development articles.';
	$pageId = "home";
?>

@extends('layouts/body')

@section('content')
	<div class="container">
		<aside class="sidebar" set-class-when-at-top="fixed">
			<a href="/">Recent</a>
			<a href="/followers">Followers</a>
			<a href="/drafts">Drafts</a>
		</aside>


		@if(count($articles) > 0)
			@foreach($articles as $article)
				<div class="item">
					<div class="base">
						<a class="title" href="/article/{{$article->slug}}">{{ $article->title }}</a>
						<div class="info">
							<a href="/dev/{{ $article->username }}">{{ $article->userName }}</a>
							<span>{{ date("dS F Y", strtotime('now', $article->last_updated)) }}</span>
						</div>
					</div>
				</div>
			@endforeach
		@else

			There are no articles at this time. <a href="/write">Create one</a>.

		@endif
	</div>
@endsection