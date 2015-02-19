<?php
	$pageName = 'Programmar - '. $data->title;
	$pageDesc = 'Programmar allows you to always keep up to day with the latest news, tips and how-to\'s.
				Follow your favourite subjects or people and create a custom digest of the best and most
				popular development articles.';
	$pageId = 'article';
	$pageAngular = 'article';
	$pageController = 'ArticleCtrl';

	if($data->user_id === Auth::user()->id) {
		$additionalButtons = '<li><a href="/edit/'.$data->slug.'" class="brand-primary">Edit</a></li>';
	}
?>
@extends('layouts/body')
@section('content')
	<div class="container" ng-cloak ng-hide="loading">
		<div class="title" ng-model="article.title">{{$data->title}}</div>
		<div class="info">
			<a href="/dev/{{$data->userName}}"><% article.user %></a>
			<span>{{ date("dS F Y", strtotime('now', $data->last_updated)) }}</span>
		</div>
		<div class="content wrtie-area" ng-model="article.content" contenteditable="false"></div>
		<textarea class="hidden" ng-model="article.content"></textarea>
	</div>
@endsection
