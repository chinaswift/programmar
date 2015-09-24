<!-- page settings -->
<?php
	//php variables
	$angular = true;
	$pageAngular = 'write';
	$pageController = 'WriteController';
	if(!isset($article_id)) { $article_id = 0;}
?>

@extends('_layouts.body')

<!-- page title -->
@if($article_id > 0)
	@section('title', 'Programmar - Edit')
@else
	@section('title', 'Programmar - Write')
@endif
@section('page', 'write')

<!-- page content -->
@section('content')
	@include('_partials.header')
	@include('_modals.published')

	<div ng-show="articleLoading"><div id="loader"></div></div>
	<form novalidate name="editorForm" @if($article_id > 0)ng-init="article.id = {{ $article_id }}"@endif ng-hide="articleLoading">
		<div class="editbar">
			<div class="container">
				<div class="row">
					<div class="col-xs-6">
						<a href="#" class="btn btn-dark preview-toggle" ng-click="toggleView();">Toggle Preview</a>
					</div>

					<div class="col-xs-6 text-right">
						<a href="#" class="btn btn-primary save-btn" ng-click="saveArticle();">Save as draft</a>
						<a href="#" class="btn btn-primary publish-btn" ng-click="publish();">Publish</a>
					</div>
				</div>
			</div>
		</div>

		<div class="container article--content">
			<input type="text" class="input tags-bar" placeholder="Tags..." ng-model="article.tags">
			<input type="text" ng-model="article.name" class="input--primary title--input" placeholder="Article name...">
			<textarea id="editor" ng-model="article.content" placeholder="Start typing your article content (We support markdown)... "></textarea>
			<div id="preview"></div>
		</div>
	</form>

@endsection
<!-- end page content -->

<!-- page scripts -->
@section('scripts')

@endsection
<!-- end page scripts -->