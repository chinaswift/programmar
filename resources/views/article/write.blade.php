<?php
	$pageName = 'Programmar - Write';
	$pageDesc = 'Programmar allows you to always keep up to day with the latest news, tips and how-to\'s.
				Follow your favourite subjects or people and create a custom digest of the best and most
				popular development articles.';
	$pageId = 'write';
	$pageAngular = 'editor';
	$pageController = 'EditorCtrl';
?>
@extends('layouts/body')
@section('content')
	<span ng-hide="!lastSaveTime">Last saved: <% lastSaveTime %></span><br>
	<span ng-hide="!saving">Saving...</span><br>
	<span ng-hide="!callbackMsg"><% callbackMsg %></span><br>

	total words: <span ng-bind="countOf(article.content)"></span><br>

	article name: <% article.name %>

	<div class="container" ng-cloak ng-hide="loading">
		<input type="text" class="title" ng-model="article.title" ng-blur="saveDocument()" placeholder="Title...">
		<input type="hidden" ng-model="article.name">
		<div class="content" contenteditable="true" ng-model="article.content" placeholder="Start writing..."></div>
		<textarea class="hidden" ng-model="article.content"></textarea>
	</div>
@endsection