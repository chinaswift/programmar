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
?>
<!DOCTYPE html>
<html lang="en">
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
<body id="{{$pageId}}">
	@if($headerInclude)
		@include('common/header')
	@endif
	@yield('content')
	<!-- Scripts -->
	<script src="/js/vendor/jquery.min.js"></script>
	<script src="/js/vendor/bootstrap.min.js"></script>
	<script src="/js/vendor/bootbox.js"></script>
	@yield('scripts')
</body>
</html>
