<?php
	$pageName = 'Programmar - Write';
	$pageDesc = 'Programmar allows you to always keep up to day with the latest news, tips and how-to\'s.
				Follow your favourite subjects or people and create a custom digest of the best and most
				popular development articles.';
	$pageId = 'write';
	$buttonExtras = '<button class="btn btn-default">Share Draft</button>
					<button class="btn btn-success">Publish</button>';
?>
@extends('layouts/body')
@section('content')
	<div class="container">
		<div class="title" placeholder="Title..." contenteditable="true" autofocus></div>
		<div class="content write-area" placeholder="Start writing..." contenteditable="true"></div>
	</div>

	<div class="navbar-fixed-bottom hidden js-write-bar">
		<button class="text-edit bold editor-btn" data-option="bold">B</button>
		<button class="text-edit underline editor-btn" data-option="underline">U</button>
		<button class="text-edit italic editor-btn" data-option="italic">I</button>

		<button class="tag-input editor-btn" data-option="h1">h1</button>
		<button class="tag-input editor-btn" data-option="h2">h2</button>
		<button class="tag-input editor-btn" data-option="h3">h3</button>

		<button class="code-input code editor-btn">code</button>
		<button class="image-input image editor-btn">image</button>
		<button class="link editor-btn link-btn">[link]</button>
	</div>

@endsection

@section('scripts')
	<script src="js/partials/editor.js"></script>
@endsection