<div class="modal fade" id="searchModal">
  <div class="modal-dialog" role="document">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      <span class="sr-only">Close</span>
    </button>
    <div class="modal-content">
      <div class="modal-header">
        <input type="text" class="modal-input input--primary" ng-keyup="searchQuery();" placeholder="Search for articles and users...">
      </div>
      <div class="modal-body search-body">
        <div ng-show="articleSearchResults.length > 0">
          <h2>Articles</h2>
          <hr />
          @include('_partials.article-search')
        </div>

        <div ng-show="userSearchResults.length > 0">
          <h2>Users</h2>
          <hr />
          @include('_partials.user-search')
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->