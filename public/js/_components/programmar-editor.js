var programmarEditor = function($) {

	//Variables
	var editorSelector = '#editor';
	var previewSelector = '#preview';
	var previewToggleSelector = '.preview-toggle';
	var myTextArea = document.querySelector('#editor');

	if(myTextArea) {
		var mdconverter = new Showdown.converter();
		var editor = new Editor(myTextArea);

		//Function to update the preview
		editor.area.addEventListener('keydown', function(event)
		{
			var $editor = $(editorSelector);
			var $preview = $(previewSelector);

			//insert tags
			if (event.shiftKey && event.keyCode == 9) {
	            event.preventDefault();
	            editor.outdent('  ');
	        } else if (event.keyCode == 9) {
	            event.preventDefault();
	            editor.indent('    ');
	        }
		});
	}

	//Function for toggling preview
	var togglePreview = function()
	{
		var $editor = $(editorSelector);
		var $preview = $(previewSelector);

		$preview.html(mdconverter.makeHtml($editor.val()));

		if($preview.is(":hidden")) {
			$preview.show();
			$editor.hide();
			$(".tags-bar").hide();
		}else{
			$preview.hide();
			$editor.show();
			$(".tags-bar").show();
		}
	}

	//Function on start
	var ignition = function()
	{
		var $document = $(document);

		//On load
		var fakeEvent = {'type': 'fake'};
		//updatePreview(fakeEvent);

		//$document.on('keyup', editorSelector, updatePreview);
		$document.on('click', previewToggleSelector, togglePreview);
	}

	return {
		'start': ignition,
	}


}(jQuery);

$(document).ready(function() {
	programmarEditor.start();
});