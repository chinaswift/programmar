<nav class="navbar navbar-default {{ $headerClass }}">
	<div class="container">
		<div class="navbar-header">
			<li class="navbar-brand"><a href="/">Programm^r</a></li>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#siteNav">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>

		<div class="navbar-right collapse navbar-collapse" id="siteNav">
			<ul class="nav navbar-nav">
				@if(\Auth::check())
					<li><a href="/dev/{{ Auth::user()->username }}">Me</a></li>
					<li><a href="/write">Write</a></li>
					<li><a href="/auth/logout">Logout</a></li>
				@endif
				{!! $additionalButtons !!}
			</ul>
		</div>
	</div>
</nav>