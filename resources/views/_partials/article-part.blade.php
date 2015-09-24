<article ng-repeat="(key, article) in articles" class="article--part animated fadeInUp" ng-hide="articlesLoading">
	<div class="row">
		<div class="col-md-1 col-xs-2 upvote-cont">
				@include('_partials.article-upvote')
		</div>
		<div class="col-md-9 col-xs-8">
			<div class="article--part_title">
				<a href="/user/@{{ article.owner_user }}"><img ng-src="@{{ article.owner_img }}" class="profile--image image--small"></a>
				<a href="/articles/@{{ article.id }}"><h3>@{{ article.name }}</h3></a>
			</div>
			<div class="article--part_content">
				<p>@{{ article.contentHTML | cut:true:160:' ...' }}</p>
			</div>
		</div>
		<div class="col-xs-2">
			<span class="article--part_time">@{{ article.time_ago }}</span>
		</div>
	</div>
</article>