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
	<div class="container" ng-cloak ng-hide="loading">
		<div class="title" ng-model="article.title">{{$data->title}}</div>
		<div class="info">
			<a href="/dev/{{$data->userName}}"><% article.user %></a>
			<span>{{ $data->enjoy_count }} Enjoys</span>
		</div>
		<div class="content wrtie-area" ng-model="article.content" contenteditable="false"></div>

		<a href="#" ng-click="enjoy('{{$data->slug}}')" class="enjoyed" ng-hide="article.enjoyed">Enjoy?</a>
		<a href="void(0)" class="enjoyed" ng-show="article.enjoyed">Enjoyed</a>
	</div>
@endsection
