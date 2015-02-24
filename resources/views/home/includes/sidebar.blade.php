<?php

if(!isset($all)) {
	$all = '';
}

if(!isset($popular)) {
	$popular = '';
}

if(!isset($drafts)) {
	$drafts = '';
}

if(!isset($following)) {
	$following = '';
}

?>
<aside class="sidebar animated fadeInLeft">
	<div class="btn-container">
	@if(Auth::check())
		<a href="/write" class="btn btn-primary">Write</a>
	@else
		<a href="/oauth/github" class="btn btn-primary">Write</a>
	@endif
	</div>
	<a href="/all" class="{{ $all }}">All</a>
	<a href="/popular" class="{{ $popular }}">Popular</a>
	@if(Auth::check())
		<a href="/following" class="{{ $following }}">Following</a>
		<a href="/drafts" class="{{ $drafts }}">Drafts</a>
	@endif
</aside>