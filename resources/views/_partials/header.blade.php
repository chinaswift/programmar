<?php
	if(!isset($type)) {$type = false;}
?>
<section class="messages"></section>
<header class="main-header">
	<div class="row">
		<div class="col-xs-6 text-left">
			<a class="site-logo " href="/">
		    <img alt="Programmar" src="/img/logo.svg">
		  </a>

			<ul class="nav--primary hidden-md-down">
				@if(Request::session()->get('x-auth-token'))
					<li @if($type == 'following') class="is-current" @endif><a href="/feed/following">Following</a></li>
				@endif
				<li @if($type == 'recent') class="is-current" @endif><a href="/feed/recent">Recent</a></li>
				<li @if($type == 'popular') class="is-current" @endif><a href="/feed/popular">Popular</a></li>
			</ul>
		</div>
		<div class="col-xs-6 text-right">
			<ul class="nav--user">
				<li><a href="#" class="btn btn-circle btn-search" ng-click="searchSite();"></a></li>
				<li class="hidden-md-down dropdown-cont">
					<a href="#" class="write--dropdown btn btn-circle btn-plus" ng-click="loadDrafts(3);">+</a>
					<ul class="dropdown write-dropdown text-left">
						<li><a href="/write" class="profile">Write<span class="sub">Share your thoughts</span></a></li>
						<li class="msg" ng-hide="writeDropdownDrafts.length > 0 || writeDropdownLoading">This is where your recent drafts will be saved.</li>
						<li class="msg" ng-show="writeDropdownLoading" ng-hide="userData.username == ''">Loading drafts...</li>
						<li class="msg" ng-show="userData.username == ''">You need to login to have access to drafts.</li>
						<li ng-repeat="(key, draft) in writeDropdownDrafts"><a href="/write/@{{draft.id}}">@{{ draft.name }}</a></li>
					</ul>
				</li>
				@if(Request::session()->get('x-auth-token'))
					<li ng-cloak><a href="/notifications" class="notification-btn" ng-class="{'highlight': notifications.length > 0}">@{{ notifications.length }}</a></li>
				@endif
				<li class="hidden-lg-up menu-btn"><a href="#">Menu</a></li>
				@if(Request::session()->get('x-auth-token'))
				<li class="hidden-md-down dropdown-cont">
					<a href="#" class="profile--dropdown"><img ng-src="@{{ userData.avatar_url }}" class="profile--image"></a>
					<ul class="dropdown text-left">
						<li><a href="/user/@{{userData.username}}" class="profile" ng-show="userData.loaded">@{{ userData.username }}<span class="sub">View your profile</span></a></li>
						<li><a href="/settings">Settings</a></li>
						<li><a href="/logout">Logout</a></li>
					</ul>
				</li>
				@endif
			</ul>

			<!-- mobile menu -->
			<div class="mobile-menu hidden-md">
				<a href="#" class="close-menu menu-btn">Close</a>
				<ul class="text-left">
					@if(Request::session()->get('x-auth-token'))
					<li><a href="/feed/following">Following</a></li>
					@endif
					<li><a href="/feed/popular">Popular</a></li>
					<li><a href="/feed/recent">Recent</a></li>
					@if(Request::session()->get('x-auth-token'))
						<li><span class="splitter"></span></li>
						<li><a href="/user/@{{userData.username}}">Profile</a></li>
						<li><a href="/settings">Settings</a></li>
						<li><a href="/logout">Logout</a></li>
					@endif
				</ul>
			</div>
		</div>
	</div>
</header>