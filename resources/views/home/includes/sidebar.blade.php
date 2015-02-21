<aside class="sidebar animated fadeInLeft">
	<div class="btn-container">
		<a href="/write" class="btn btn-primary">Write</a>
	</div>
	<a href="/all">All</a>
	<a href="/popular">Popular</a>
	<a href="/drafts">Drafts</a>

	<div class="options">
		<a href="/following">Following</a>
		<div class="clearfix profile-img-cont">
			@foreach($followers as $follower)
				<a href="/dev/{{ $follower['user_slug'] }}"><img src="{{$follower['user_avatar']}}" class="img-circle profile-image"></a>
			@endforeach
		</div>
	</div>
</aside>