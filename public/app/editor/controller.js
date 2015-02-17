(function () {

    'use strict';

    var app = angular.module(editorGlobals.app.name);
    var apiEditorInteractBackendUri = '/api/internal/v1/editor/save';

    app.controller(editorGlobals.controller.name, [
        '$scope',
        '$http',
        '$location',
        '$window',
        'ArticleApi',
        function ($scope, $http, $location, $window, ArticleApi) {

            $scope.article = {};

            //Collect article API stuff
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


            //Default variables
            $scope.saving = false;
            $scope.loading = true;
            $scope.callbackMsg = 'Not Saved';
            $scope.areaSelector = '.write-area';
            $scope.lastSaveTime = false;
            var saveDelay = 5 * 1000; //5 seconds (ms)

            //Apply initialised variables
            setTimeout(function() {
                $scope.$apply();
                var editor = angular.element($scope.areaSelector);
                editor.designMode = 'On';
            }, 300);

            //Auto saving
            setInterval(function() {
                if(!$scope.loading) {
                    $scope.saveDocument();
                }
            }, saveDelay);

            ////Change font function
            $scope.commonFontOption = function(option) {
                document.execCommand(option, false, null);
            };

            $scope.checkCharacter = function(e) {
                e = e || window.event;
                var keyCode = e.keyCode || e.which;
                if (keyCode == 9)
                {
                    e.preventDefault();
                    $scope.insertTextAtCursor("&nbsp;&nbsp;&nbsp;&nbsp;");
                }
            };

            $scope.insertTextAtCursor = function(html) {
                document.execCommand('CreateLink', false, "tabInsert");
                var sel = $('a[href="tabInsert"]');
                sel.wrap('<div class="tab" />');
                sel.closest('.tab').html('');
                sel.contents().unwrap();
            };

            //Insert tag function
            $scope.insertTag = function(option) {
                document.execCommand('CreateLink', false, 'Heading - ' + option);
                var sel = $('a[href="Heading - ' + option + '"]');
                sel.wrap('<' + option + ' />');
                sel.contents().unwrap();
            };

            //Insert code block function
            $scope.codeInsert = function() {
                document.execCommand('CreateLink', false, 'code...');
                var sel = $('a[href="code..."]');
                sel.wrap('<ol class="code-block" contenteditable="true"><li></li></ol><br><br>');
                sel.contents().unwrap().designMode = 'On';
            };

            $scope.addLink = function() {
                document.execCommand('CreateLink', false, 'Choose Url');
                bootbox.prompt({
                    title: "What is the link?",
                    value: "http://",
                    callback: function(result) {
                        if (result === null || result === "http://" || !result.match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/)) {
                            var sel = $('a[href="Choose Url"]');
                            sel.contents().unwrap();
                        } else {
                            var sel = $('a[href="Choose Url"]');
                            sel.wrap('<a href="' + result + '" target="_blank" />');
                            sel.contents().unwrap();
                        }
                    }
                });
            }

            //Function for saving the document
            $scope.saveDocument = function() {
                var title = $scope.article.title,
                    content = $scope.article.content,
                    name = $scope.article.name,
                    currentTime = new Date();

                //make sure the title or content has been edited
                if(title != '' || content != '') {
                    //If first edit, or its been longer than the delayed time.
                    if(!$scope.lastSaveTime || (currentTime - $scope.lastSaveTime) > saveDelay) {
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
            };

        }
    ]);

})();
