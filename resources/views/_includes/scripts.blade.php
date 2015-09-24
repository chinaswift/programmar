<script src="/js/vendor/jquery.min.js"></script>
<script src="/js/vendor/bootstrap.min.js"></script>
<script src="/js/vendor/showdown.js"></script>
<script src="/js/components.min.js"></script>

@if($angular)
	<script src="/js/vendor/angular.min.js"></script>
	<script src="/js/vendor/algoliasearch.angular.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.0-rc.5/angular-resource.js"></script>
@endif

@yield('scripts')

@if($angular)
	<script src="/app/_core/config.js"></script>
	<script src="/app/_core/controller.js"></script>
	<script src="/app/_core/directive.js"></script>
	<script src="/app/_core/filter.js"></script>

	<script src="/app/_core/services/user_data.js"></script>

	@if($pageAngular)
		@foreach(['service', 'config', 'controller', 'directive', 'filter'] as $fileName)
			<script src="/app/{{ $pageAngular }}/{{ $fileName }}.js"></script>
		@endforeach
	@endif
@endif