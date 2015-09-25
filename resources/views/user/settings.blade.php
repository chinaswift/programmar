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
			<a href="#" ng-click="disconnectStripe()">disconnect stripe</a>
			<p>You have now connected with stripe. Although your account will still not beable to process until you fill out the fields below.</p>
			<form ng-submit="updateDrinkSettings()" novalidate name="drinkSettingForm">
				<label>Your currency</label>
				<select class="input--primary" ng-model="settings.drinkcurrency">
					<option value="">Select Currency</option>
				  <option value="AUD">Australian Dollar</option>
				  <option value="BRL">Brazilian Real </option>
				  <option value="CAD">Canadian Dollar</option>
				  <option value="CZK">Czech Koruna</option>
				  <option value="DKK">Danish Krone</option>
				  <option value="EUR">Euro</option>
				  <option value="GBP">Great British Pound</option>
				  <option value="HKD">Hong Kong Dollar</option>
				  <option value="HUF">Hungarian Forint </option>
				  <option value="ILS">Israeli New Sheqel</option>
				  <option value="JPY">Japanese Yen</option>
				  <option value="MYR">Malaysian Ringgit</option>
				  <option value="MXN">Mexican Peso</option>
				  <option value="NOK">Norwegian Krone</option>
				  <option value="NZD">New Zealand Dollar</option>
				  <option value="PHP">Philippine Peso</option>
				  <option value="PLN">Polish Zloty</option>
				  <option value="GBP">Pound Sterling</option>
				  <option value="SGD">Singapore Dollar</option>
				  <option value="SEK">Swedish Krona</option>
				  <option value="CHF">Swiss Franc</option>
				  <option value="TWD">Taiwan New Dollar</option>
				  <option value="THB">Thai Baht</option>
				  <option value="TRY">Turkish Lira</option>
				  <option value="USD">U.S. Dollar</option>
				</select>
				<label>Drink price</label>
				<input type="text" class="input--primary" placeholder="3.50" ng-model="settings.drinkprice">
				<button type="submit" class="btn btn-primary">Update</button>
			</form>
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