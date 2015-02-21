<nav class="navbar navbar-default {{ $headerClass }}">
	<div class="container">
		<div class="navbar-header">
			<li class="navbar-brand"><a href="/" class="logo">Programm^r</a> <a href="https://github.com/Layerful/programmar" target="_blank" class="beta-box">v1.0</a></li>
		</div>

		<div class="navbar-right">
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