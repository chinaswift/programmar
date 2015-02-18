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
	<div class="container-fluid" ng-hide="loading">
		<input type="text" class="title" ng-model="article.title" ng-cloak  ng-blur="saveDocument()" ng-change="canSaveChange();" placeholder="Title...">
		<input type="hidden" ng-model="article.name" ng-cloak>
		<wysiwyg ng-model="article.content" ng-keydown="checkCharacter();" ng-change="canSaveChange();" ng-cloak enable-bootstrap-title="true" textarea-menu="<% article.customMenu %>"></wysiwyg>
	</div>
@endsection

@section('scripts')
	<script src="/js/vendor/bootstrap-colorpicker.js"></script>
	<script src="/js/vendor/angular-wysiwyg.js"></script>
@endsection
