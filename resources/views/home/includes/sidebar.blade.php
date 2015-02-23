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
		<a href="/write" class="btn btn-primary">Write</a>
	</div>
	<a href="/all" class="{{ $all }}">All</a>
	<a href="/popular" class="{{ $popular }}">Popular</a>
	<a href="/drafts" class="{{ $drafts }}">Drafts</a>

	<div class="options">
		<a href="/following" class="{{ $following }}">Following</a>
		<div class="clearfix profile-img-cont">
			@foreach($followers as $follower)
				<a href="/dev/{{ $follower['user_slug'] }}"><img src="{{$follower['user_avatar']}}" class="img-circle profile-image"></a>
			@endforeach
		</div>
	</div>
</aside>