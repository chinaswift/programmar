<?php
	$pageName = 'Programmar - Write';
	$pageDesc = 'Programmar allows you to always keep up to day with the latest news, tips and how-to\'s.
				Follow your favourite subjects or people and create a custom digest of the best and most
				popular development articles.';
	$pageId = 'article';
	$pageAngular = 'editor';
	$pageController = 'EditorCtrl';
	$headerClass = 'faded';
	$footerInclude = false;
?>
@extends('layouts/body')
@section('content')
	<div class="container push" ng-hide="loading">
		<aside class="sidebar hack animated fadeInLeft" ng-cloak>
			<a href="#" class="saveLink" ng-click="saveDocument();" tabindex="-1">Save</a>
	        <div class="btn-container push">
	        	<a href="#" class="publishLink btn brand-primary" ng-click="publishArticle();" tabindex="-1">Publish</a>
	        </div>
	        <a href="#" class="deleteLink brand-danger" ng-show="slug != 'write'" ng-click="deleteArticle();" tabindex="-1">Delete</a>
        </aside>

        <input type="hidden" ng-model="article.user" ng-cloak>

		<input type="text" class="title animated fadeIn" ng-model="article.title" ng-cloak ng-blur="saveDocument()" ng-change="canSaveChange();" placeholder="Title...">
		<input type="hidden" ng-model="article.name" ng-cloak>
		<wysiwyg ng-model="article.content" ng-keydown="checkCharacter();" ng-change="canSaveChange();" ng-cloak enable-bootstrap-title="false" textarea-menu="<% article.customMenu %>"></wysiwyg>
	</div>
@endsection

@section('scripts')
	<script src="/js/vendor/bootstrap-colorpicker.js"></script>
	<script src="/js/vendor/angular-wysiwyg.js"></script>
@endsection
