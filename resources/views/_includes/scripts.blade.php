<script src="/js/vendor.js"></script>
<script src="/js/components.js"></script>

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