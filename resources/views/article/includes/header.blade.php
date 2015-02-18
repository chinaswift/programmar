<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<ul class="nav navbar-nav">
					<li class="dropdown on-hover" ng-cloak ng-hide="publishing">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><% callbackMsg %></a>
						<ul class="dropdown-menu" role="menu">
							<li ng-show="lastSaveTime"><a href="#">Last saved: <%lastSaveTime | date:'h:mma'%></a></li>
						</ul>
					</li>
				</ul>
			</div>

			<div class="navbar-collapse navbar-right">
				<ul class="nav navbar-nav">
					@if(\Auth::check())
						<li class="dropdown on-hover">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Font options</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#" ng-click="commonFontOption('bold')">Bold</a></li>
								<li><a href="#" ng-click="commonFontOption('italic')">Italic</a></li>
								{{ ''/*<li><a href="#" ng-click="addLink()">Link</a>*/ }}
							</ul>
						</li>
						<li><a href="#" ng-click="insertTag('h2')">Heading</a></li>
						<li><a href="#" ng-click="codeInsert()">Code</a></li>

						<li><a href="#" class="brand-primary" ng-click="publishArticle();" ng-hide="publishing">Publish</a></li>
						<li><a href="void(0);" class="brand-primary" ng-show="publishing">Publishing...</a></li>
						<li><a href="/" class="split">Cancel</a></li>
					@endif
				</ul>
			</div>
		</div>
	</nav>