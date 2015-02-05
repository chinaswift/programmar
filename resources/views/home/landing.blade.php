<?php
	$pageName = 'Programmar - Write, read and discover development articles.';
	$pageDesc = 'Programmar allows you to always keep up to day with the latest news, tips and how-to\'s.
				Follow your favourite subjects or people and create a custom digest of the best and most
				popular development articles.';
	$pageId = 'home';
	$headerClass = 'light';
	$headerInclude = false;
?>
@extends('layouts/body')
@section('content')
	<div class="jumbotron">
		@include('common/header')
		<h1>Write, read and discover everything development.</h1>
		<p>Follow your favourite writers, subscribe to your most loved language. Programmar supplies you with the latest: news, tip or lesson for development.</p>
		<div class="btn-container">
			<a href="/auth/login" class="btn btn-primary">Sign in</a>
		</div>
	</div>




@endsection