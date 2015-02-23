<?php
	if(!isset($headerInclude)) {
		$headerInclude = true;
	}

	if(!isset($footerInclude)) {
		$footerInclude = true;
	}

	if(!isset($pageId)) {
		$pageId = '';
	}

	if(!isset($pageAngular)) {
		$pageAngular = false;
	}

	if(!isset($additionalButtons)) {
		$additionalButtons = '';
	}

	if(!isset($headerClass)) {
		$headerClass = '';
	}
?>
<!DOCTYPE html>
<html lang="en" @if($pageAngular) ng-app="com.programmar" @endif>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="{{ $pageDesc }}">
	<title>{{ $pageName }}</title>
	<script src="//use.typekit.net/xrt0ihn.js"></script>
	<script>try{Typekit.load();}catch(e){}</script>
	<link href="/css/app.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body id="{{$pageId}}" @if($pageAngular) ng-controller="{{ $pageController }}" @endif>
	<div class="container absolute" ng-show="showEnjoys" ng-cloak set-class-when-at-top="fixed">
		<div class="right-container animated fadeInLeft">
			@yield('leftSlideOut')
		</div>
	</div>

	@if($headerInclude)
		@include('common/header')
	@endif

	@yield('content')

	@if($footerInclude)
		@include('common/footer')
	@endif

	<!-- Scripts -->
	<script src="/js/vendor/jquery.min.js"></script>
	<script src="/js/vendor/bootstrap.min.js"></script>
	<script src="/js/vendor/bootbox.js"></script>

	@if($pageAngular)
		<script src="/js/vendor/angular.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.0-rc.5/angular-resource.js"></script>
	@endif

	@yield('scripts')

	@if($pageAngular)
		<script src="/app/_core/config.js"></script>
		<script src="/app/_core/controller.js"></script>
		<script src="/app/_core/directive.js"></script>
		<script src="/app/_core/filter.js"></script>
		<script src="/app/_core/services/user_api.js"></script>
		<script src="/app/_core/services/article_api.js"></script>
		<script src="/app/_core/services/messages.js"></script>

		@foreach(['service', 'config', 'controller', 'directive', 'filter'] as $fileName)
			<script src="/app/{{ $pageAngular }}/{{ $fileName }}.js"></script>
		@endforeach
	@endif

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-59897932-1', 'auto');
	  ga('send', 'pageview');

	</script>
</body>
</html>
