<a href="javascript:void(0);" id="upvote@{{ article.id }}" ng-class="{'voted': article.upvoted}" class="uv--button" ng-click="upvoteArticle(article.id);">
	<span class="uv--iteration">@{{ article.upvotes }}</span>
	<span class="uv--next-iteration" ng-hide="article.upvoted">@{{ article.upvotesNext }}</span>
	<span class="uv--next-iteration" ng-show="article.upvoted">@{{ article.upvotes }}</span>
</a>