<article ng-repeat="(key, user) in userSearchResults" class="article--part" ng-hide="articlesLoading">
	<div class="article--part_title">
		<a href="/user/@{{ user.username }}"><h3>@{{ user.username }}</h3></a>
	</div>
	<div class="article--part_content">
		<p>@{{ user.followers.length }} Followers | @{{ user.following.length }} Following</p>
	</div>
</article>