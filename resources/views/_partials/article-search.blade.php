<article ng-repeat="(key, article) in articleSearchResults" class="article--part" ng-hide="articlesLoading">
	<div class="article--part_title">
		<a href="/articles/@{{ article.id }}"><h3>@{{ article.name }}</h3></a>
	</div>
	<div class="article--part_content">
		<p>@{{ article.tags }}</p>
	</div>
</article>