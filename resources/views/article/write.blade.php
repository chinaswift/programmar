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
	<% value %>
@endsection

@section('scripts')
	<script src="js/partials/editor.js"></script>
@endsection