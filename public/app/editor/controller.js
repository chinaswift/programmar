(function () {

    'use strict';

    var app = angular.module(editorGlobals.app.name);
    var apiEditorInteractBackendUri = '/api/internal/v1/editor/save';
    var apiPublishInteractBackendUri = '/api/internal/v1/editor/publish';
    var apiDeleteInteractBackendUri = '/api/internal/v1/editor/delete';

    app.controller(editorGlobals.controller.name, [
        '$scope',
        '$http',
        '$location',
        '$window',
        'ArticleApi',
        function ($scope, $http, $location, $window, ArticleApi) {

            //Default variables
            $scope.article = {};
            $scope.saving = false;
            $scope.publishing = false;
            $scope.loading = true;
            $scope.callbackMsg = 'Not Saved';
            $scope.areaSelector = '.write-area';
            $scope.lastSaveTime = false;
            $scope.canSave = false;
            $scope.saveDelay = 5 * 1000;

            $scope.article.customMenu = [
                ['bold', 'italic', 'heading'],
                ['code', 'quote', 'link'],
            ];

            ArticleApi.query().$promise.then(function(articleData) {
                var title = '',
                    content = '',
                    name = '',
                    user = '';

                if (articleData) {
                    title = articleData['title'] || '';
                    content = articleData['content'] || '';
                    name = articleData['slug'] || '';
                    user = articleData['userName'] || '';
                }

                $scope.article = {
                    'title': angular.copy(title),
                    'content': angular.copy(content),
                    'name': angular.copy(name),
                    'user': angular.copy(user)
                };

                $scope.loading = false;
            });

            //Apply initialised variables
            setTimeout(function() {
                $scope.$apply();
            }, 300);

            //Auto saving
            setInterval(function() {
                $scope.saveDocument();
            }, $scope.saveDelay);

            $scope.canSaveChange = function() {
                if(!$scope.canSave) {
                    $scope.canSave = true;
                    console.log('can now save');
                }
            };

            $scope.deleteArticle = function() {
                var name = $scope.article.name;
                $scope.publishing = false;
                $scope.callbackMsg = 'Deleting...';
                $scope.saving = true;

                $http.post(apiDeleteInteractBackendUri, {'name': name}).
                success(function(data, status, headers, config) {
                    $scope.callbackMsg = data.message;
                    $scope.article.name = data.name;
                    window.location.href = "/";
                }).
                error(function(data, status, headers, config) {
                    $scope.saving = false;
                    $scope.publishing = false;
                    $scope.callbackMsg = data.message;
                });
            };

            $scope.checkCharacter = function(e) {
                e = e || window.event;
                var keyCode = e.keyCode || e.which;
                if (keyCode == 9)
                {
                    e.preventDefault();
                    $scope.insertFakeTabs();
                }
            };

            $scope.insertFakeTabs = function() {
                document.execCommand('CreateLink', false, "tabInsert");
                var sel = $('a[href="tabInsert"]');
                sel.wrap('<div class="tab" />');
                sel.closest('.tab').html('');
                sel.contents().unwrap();
            };

            $scope.publishArticle = function() {
                var title = $scope.article.title,
                    content = $scope.article.content,
                    name = $scope.article.name,
                    currentTime = new Date();

                if(title != '' && content != '') {
                    $scope.publishing = true;
                    $scope.saving = true;
                    $scope.callbackMsg = 'Publishing...';
                    $scope.lastSaveTime = currentTime;

                    $http.post(apiPublishInteractBackendUri, {'title': title, 'content': content, 'name': name}).
                    success(function(data, status, headers, config) {
                        $scope.callbackMsg = data.message;
                        $scope.article.name = data.name;

                        window.location.href = "/article/" + name;

                    }).
                    error(function(data, status, headers, config) {
                        $scope.saving = false;
                         $scope.publishing = false;
                        $scope.callbackMsg = data.message;
                    });
                }else{
                    alert('Please insert a title and content before publishing.');
                }
            };

            //Function for saving the document
            $scope.saveDocument = function() {
                var title = $scope.article.title,
                    content = $scope.article.content,
                    name = $scope.article.name,
                    currentTime = new Date();

                if($scope.canSave === true && !$scope.loading && !$scope.saving) {
                    //make sure the title or content has been edited
                    if(title != '' || content != '') {
                        //If first edit, or its been longer than the delayed time.
                        if(!$scope.lastSaveTime || (currentTime - $scope.lastSaveTime) > $scope.saveDelay) {
                            $scope.saving = true;
                            $scope.callbackMsg = 'Saving...';
                            $scope.lastSaveTime = currentTime;

                            $http.post(apiEditorInteractBackendUri, {'title': title, 'content': content, 'name': name}).
                            success(function(data, status, headers, config) {
                                $scope.saving = false;
                                $scope.callbackMsg = data.message;
                                $scope.article.name = data.name;
                            }).
                            error(function(data, status, headers, config) {
                                $scope.saving = false;
                                $scope.callbackMsg = data.message;
                            });
                        }
                    }
                }
            };
        }
    ]);

})();
