var EditorApplication = (function($) {
	//Main variables
	var textEditSelector = '.text-edit',
		tagInputSelector = '.tag-input',
		codeInputSelector = '.code-input',
		imageInputSelector = '.image-input',
		areaSelector = '.write-area',
		writeBarSelector = '.js-write-bar',
		writeBarInAnimation = 'slideInUp',
		writeBarOutAnimation = 'slideOutDown',
		imageAddonClass = 'image-add-container',
		imageAddonCode = 'a[href="image-addon"]',
		imageSelectSection = '.' + imageAddonClass + ' .section.right',
		imageUrlInput = '.js-image-url',
		insertedImageClass = 'inserted-image',
		closeBtnSelector  = '.close-btn',
		linkBtnSelector = '.link-btn',
		hiddenClass = 'hidden',
		timeoutDelay = null,
		writeBarDelay = 2000;

	//Functions which run on load
	var setupApplication = function() {
		var $editor = $(areaSelector);
		$editor.designMode = 'On';
	};

	//Change font function
	var commonFontOption = function() {
		var $this = $(this);
		var option = $this.data('option');
		document.execCommand(option, false, null);
	};

	//Insert tag function
	var insertTag = function() {
		var $this = $(this);
		var option = $this.data('option');
		document.execCommand('CreateLink', false, 'Heading - ' + option);
    	var sel = $('a[href="Heading - ' + option + '"]');
    	sel.wrap('<' + option + ' />');
    	sel.contents().unwrap();
	};

	//Insert code block function
	var codeInsert = function() {
		document.execCommand('CreateLink', false, 'code...');
    	var sel = $('a[href="code..."]');
    	sel.wrap('<div class="code-block animated fadeIn" contenteditable="true" />');
    	sel.contents().unwrap().designMode = 'On';
	};

	//Function to show the editor
	var showEditor = function() {
		var $bar = $(writeBarSelector);
		if($bar.hasClass(hiddenClass)) {
			$bar.removeClass(writeBarOutAnimation);
			$bar.addClass(writeBarInAnimation);
			$bar.removeClass(hiddenClass);
		}
		clearTimeout(timeoutDelay);
	};

	//Function for showing the image controls
	var appendImageControls = function() {
		document.execCommand('CreateLink', false, 'image-addon');
    	var $sel = $(imageAddonCode),
    		$editor = $(areaSelector);

    	$sel.after('<div class="' + imageAddonClass + ' animated fadeIn" contenteditable="false">'
    				+ '<div class="section"><a href="#" class="btn btn-default">Upload image</a></div>'
    				+ '<div class="section right"><input type="url" class="form-control js-image-url" placeholder="Image url..."></div>'
    			+ '</div><br><br>');
    	$editor.find(imageAddonCode).remove();
    	$editor.blur();
	};

	//Function to check if the image is a image or not
	var IsValidImageUrl = function(url) {
		$("<img>", {
		    src: url,
		    error: function() { return false; },
		    load: function() { return true; }
		});
	}

	//Function for checking if enter was pressed
	var checkSubmit = function(e) {
		var keyCode = e.keyCode;
		if(keyCode == 13) {
			var value = $(this).val();
			if(/^http:\/\/.+\.(gif|png|jpg|jpeg)$/i.test(value)) {
				//This is if the item is an image
				var $parent = $(this).closest('.' + imageAddonClass);
				$parent.after('<div class="' + insertedImageClass + '">'
								+ '<a href="#" class="close-btn"><span class="glyphicon glyphicon-remove"></span></a>'
								+ '<img src="' + value + '" class="animated bounceIn" />'
							+ '</div><br><br>');
				setTimeout(function() {
					$parent.closest('.' + insertedImageClass).find('img').removeClass('animated').removeClass('bounceIn');
				}, 1000);
				$parent.remove();
			}
		}
	};

	//Function for image section slide to focus
	var moveSection = function() {
		var $parent = $(this);
		$parent.css('width', '100%');
	};

	//Function for image section slide back out of focus
	var moveSectionBack = function() {
		var $parent = $(this);
		$parent.find('.section').css('width', '50%');
	};

	//Globally functioned close button
	var closeSection = function(e) {
		var $this = $(this);
		e.preventDefault();
		$this.parent().remove();
	};

	//Function for stripping tags on paste
	var stripTags = function(e) {
		e.preventDefault();
        var text = (e.originalEvent || e).clipboardData.getData('text/html') || prompt('Paste something..');
        var $result = $('<div></div>').append($(text));

        $(this).html($result.html());

        // replace all styles except bold and italic
        $.each($(this).find("*"), function(idx, val) {
            var $item = $(val);
            if ($item.length > 0){
               var saveStyle = {
                    'font-style': $item.css('font-style')
                };
                $item.removeAttr('style')
                     .removeClass()
                     .css(saveStyle);
            }
        });

        // remove unnecesary tags (if paste from word)
        $(this).children('style').remove();
        $(this).children('meta').remove()
        $(this).children('link').remove();
	};

	var addLink = function() {
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

	var ignition = function() {
		setupApplication();

		var $document = $(document);
		$document.on('click', textEditSelector, commonFontOption);
		$document.on('click', tagInputSelector, insertTag);
		$document.on('click', codeInputSelector, codeInsert);
		$document.on('focus', areaSelector, showEditor);
		$document.on('click', imageInputSelector, appendImageControls);
		$document.on('keydown', imageUrlInput, checkSubmit);
		$document.on('click', imageSelectSection, moveSection);
		$document.on('blur', '.' + imageAddonClass, moveSectionBack);
		$document.on('click', closeBtnSelector, closeSection);
		$document.on('click', linkBtnSelector, addLink);
	};

	return {
		'start': ignition
	};

})(jQuery);


$(document).ready(function() {
	EditorApplication.start();
});