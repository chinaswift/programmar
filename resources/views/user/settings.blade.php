<!-- page settings -->
<?php
	//php variables
	$angular = true;
	$pageAngular = 'settings';
	$pageController = 'SettingsController';
?>

@extends('_layouts.body')

<!-- page title -->
@section('title', 'Programmar - Settings')
@section('page', 'settings')

<!-- page content -->
@section('content')
	@include('_partials.header')
	<div id="loader" ng-show="settingsLoading"></div>
	<div class="container" ng-hide="settingsLoading" ng-cloak>
		<div ng-show="stripeConnect">
			disconnect stripe
		</div>

		<div ng-hide="stripeConnect">
			<h2>Send a developer a drink!</h2>
			<p>You want to recieve possible income from your articles? Connect your stripe account and allow people viewing your articles to send you a drink if they appreciate what your write.</p>
			<a href="/connect/stripe" class="btn btn-twitter">Connect with stripe</a>
		</div>
	</div>
@endsection
<!-- end page content -->

<!-- page scripts -->
@section('scripts')

@endsection
<!-- end page scripts -->