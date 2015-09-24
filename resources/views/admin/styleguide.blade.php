<!-- page settings -->
<?php
	//php variables
?>

@extends('_layouts.body')

<!-- page title -->
@section('title', 'Programmar - Styleguide.')
@section('page', 'styleguide')

<!-- page content -->
@section('content')
	<div class="container-fluid">
		<h1>Programmar's Styleguide</h1>
		<p>Here is where we will build all the indiviual elements. This allows us to focus everything down to the last bit.</p>

		<section class="sg--section">
			<a href="#upvote" id="upvote"><h3>Up-vote element</h3></a>
			@include('_partials.upvote')
		</section>

		<section class="sg--section">
			<a href="#header" id="header"><h3>Header</h3></a>
			@include('_partials.header')
		</section>
	</div>
@endsection
<!-- end page content -->

<!-- page scripts -->
@section('scripts')

@endsection
<!-- end page scripts -->