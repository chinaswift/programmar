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
	<span ng-hide="!callbackMsg"><% callbackMsg %></span>

	<div class="container">
		<input type="text" class="title" ng-model="article.title" contenteditable="true" ng-change="saveDocument()" placeholder="Title...">
		<div class="content" contenteditable="true" ng-model="article.content" placeholder="Start writing..."></div>
		<textarea class="hidden" ng-model="article.content"></textarea>
	</div>
@endsection

@section('scripts')
	<script src="js/partials/editor.js"></script>
@endsection