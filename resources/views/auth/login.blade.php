<!-- page settings -->
<?php
	//php variables
?>

@extends('_layouts.body')

<!-- page title -->
@section('title', 'Programmar - Login.')
@section('page', 'home')

<!-- page content -->
@section('content')
	@include('_partials.header')

	<div class="container">
		<div class="auth-section">
			<h2>Try logging in!</h2>
			<p>When logging into Programmar you instantly get access to create a curated reading list, write new articles and provide feedback. It's really simple to login. It's just one button.</p>
			<a href="/auth/github" class="btn btn-github">Login with github</a>
		</div>
	</div>
@endsection
<!-- end page content -->

<!-- page scripts -->
@section('scripts')

@endsection
<!-- end page scripts -->