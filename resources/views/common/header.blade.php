<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-right">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<li class="dropdown on-hover navbar-brand">
					<a href="/" class="dropdown-toggle" data-toggle="dropdown">Progamm^r</a>
					@if(\Auth::check())
						<ul class="dropdown-menu" role="menu">
							<li><a href="/write">Recent</a></li>
							<li><a href="/auth/logout">Following</a></li>
						</ul>
					@endif
				</li>
			</div>

			<div class="collapse navbar-collapse navbar-right">
				<ul class="nav navbar-nav">
					@if(\Auth::check())
						<li class="dropdown on-hover">
							<a href="/" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }}</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/write">Settings</a></li>
								<li><a href="/auth/logout">Logout</a></li>
							</ul>
						</li>
						<li><a href="/">Search</a></li>
						<li><a href="/write">Write</a></li>
					@endif
				</ul>
			</div>
		</div>
	</nav>