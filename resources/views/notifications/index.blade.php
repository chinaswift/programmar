<!-- page settings -->
<?php
	//php variables
	$angular = true;
	$pageAngular = 'notifications';
	$pageController = 'NotificationsController';
?>

@extends('_layouts.body')

<!-- page title -->
@section('title', 'Programmar - Notifications')
@section('page', 'notifications')

<!-- page content -->
@section('content')
	@include('_partials.header')
	<div class="container">
		<div id="loader" ng-show="notificationsLoading"></div>
		<ul class="notifications" ng-hide="notificationsLoading" ng-cloak>
			<li ng-repeat="(key, note) in allNotifications">
				<div class="row">
					<div class="col-xs-9">
						<img class="profile--image image--small" ng-src="@{{ note.from_img }}">
						<a href="/user/@{{note.from_user}}">@{{note.from_user}}</a> @{{note.action}}
					</div>
					<div class="col-xs-3 text-right">
						<a href="/articles/@{{note.unique_identifier}}" class="btn btn-primary" ng-show="note.type == 'mention'">View</a>
						<a href="/articles/@{{note.unique_identifier}}" class="btn btn-primary" ng-show="note.type == 'comment'">View</a>
						<a href="/articles/@{{note.unique_identifier}}" class="btn btn-primary" ng-show="note.type == 'upvoted'">View</a>
						<a href="/user/@{{note.from_user}}" class="btn btn-primary" ng-show="note.type == 'follow'">View</a>
					</div>
				</div>
			</li>
		</ul>
	</div>
@endsection
<!-- end page content -->

<!-- page scripts -->
@section('scripts')

@endsection
<!-- end page scripts -->