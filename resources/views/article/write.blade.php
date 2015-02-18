<?php
	$pageName = 'Programmar - Write';
	$pageDesc = 'Programmar allows you to always keep up to day with the latest news, tips and how-to\'s.
				Follow your favourite subjects or people and create a custom digest of the best and most
				popular development articles.';
	$pageId = 'article';
	$pageAngular = 'editor';
	$pageController = 'EditorCtrl';
	$headerInclude = false;
?>
@extends('layouts/body')
@section('content')
	@include('article/includes/header')
	<div class="container-fluid" ng-cloak ng-hide="loading">
		<input type="text" class="title" ng-model="article.title" ng-blur="saveDocument()" placeholder="Title...">
		<input type="hidden" ng-model="article.name">
		<div class="content wrtie-area" contenteditable="true" ng-model="article.content" ng-keydown="checkCharacter();" placeholder="Start writing your article..."></div>
		<textarea class="hidden" ng-model="article.content"></textarea>
	</div>
@endsection
