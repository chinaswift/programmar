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
        '$compile',
        'ArticleApi',
        function ($scope, $http, $location, $window, $compile, ArticleApi) {

            //Default variables
            $scope.article = {};
            $scope.saving = false;
            $scope.publishing = false;
            $scope.loading = true;
            $scope.callbackMsg = 'Not Saved';
            $scope.areaSelector = '.write-area';
            $scope.lastSaveTime = false;
            $scope.canSave = false;
            $scope.saveDelay = 10 * 1000;

            $scope.article.customMenu = [
                ['bold', 'italic', 'heading','code', 'quote', 'link'],
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
                }
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

            $scope.deleteArticle = function() {
                var name = $scope.article.name;
                $(".deleteLink").text('Deleting...');

                $http.post(apiDeleteInteractBackendUri, {'name': name}).
                success(function(data, status, headers, config) {
                    $(".deleteLink").text(data.message);
                    $scope.article.name = data.name;
                    window.location.href = "/drafts";
                }).
                error(function(data, status, headers, config) {
                    $scope.saving = false;
                    $scope.publishing = false;
                    $(".deleteLink").text(data.message);
                });
            };

            $scope.publishArticle = function() {
                console.log('test');
                var title = $scope.article.title,
                    content = $scope.article.content,
                    name = $scope.article.name,
                    currentTime = new Date();

                if(title != '' && content != '') {
                    $scope.publishing = true;
                    $scope.saving = true;
                    $(".publishLink").text('Publishing...');
                    $scope.lastSaveTime = currentTime;

                    $http.post(apiPublishInteractBackendUri, {'title': title, 'content': content, 'name': name}).
                    success(function(data, status, headers, config) {
                        $scope.callbackMsg = data.message;
                        $(".publishLink").text(data.message);
                        $scope.article.name = data.name;
                        window.location.href = "/article/" + name;
                    }).
                    error(function(data, status, headers, config) {
                        $scope.saving = false;
                        $scope.publishing = false;
                        $(".publishLink").text(data.message);
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
                        $scope.saving = true;
                        $(".saveLink").text('Saving...');
                        $scope.lastSaveTime = currentTime;

                        $http.post(apiEditorInteractBackendUri, {'title': title, 'content': content, 'name': name}).
                        success(function(data, status, headers, config) {
                            $scope.saving = false;
                            $(".saveLink").text(data.message);
                            $scope.article.name = data.name;
                        }).
                        error(function(data, status, headers, config) {
                            $scope.saving = false;
                            $(".saveLink").text(data.message);
                        });
                    }
                }
            };
        }
    ]);

})();
