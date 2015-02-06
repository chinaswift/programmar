<?php
	if(!isset($headerClass)) {
		$headerClass = '';
	}

	if(!isset($headerInclude)) {
		$headerInclude = true;
	}

	if(!isset($pageId)) {
		$pageId = '';
	}

	if(!isset($pageAngular)) {
		$pageAngular = false;
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
	<link href="/css/app.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body id="{{$pageId}}" @if($pageAngular) ng-controller="{{ $pageController }}" @endif>
	@if($headerInclude)
		@include('common/header')
	@endif
	@yield('content')
	<!-- Scripts -->
	<script src="/js/vendor/jquery.min.js"></script>
	<script src="/js/vendor/bootstrap.min.js"></script>
	<script src="/js/vendor/bootbox.js"></script>

	@if($pageAngular)
		<script src="/js/vendor/angular.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.0-rc.5/angular-resource.js"></script>

		<script src="/app/_core/config.js"></script>
		<script src="/app/_core/controller.js"></script>
		<script src="/app/_core/directive.js"></script>
		<script src="/app/_core/filter.js"></script>
	@endif

	@foreach(['config', 'controller', 'directive', 'filter', 'service'] as $fileName)
		<script src="/app/{{ $pageAngular }}/{{ $fileName }}.js"></script>
	@endforeach

	@yield('scripts')
</body>
</html>
