//You might also like by http://codepen.io/fbrz/

function alsolike(pen1, desc1, pen2, desc2, pen3, desc3) {

  var url = location.href;
  if(url.indexOf("/boomerang/")!=-1)
    url = document.getElementsByTagName("link")[0].getAttribute("href");

   console.log(url);

  if(url.indexOf("/debug/")!=-1||url.indexOf("/fullcpgrid/")!=-1) return false;

  var def_style = document.getElementsByTagName("style")[0];
  def_style.parentNode.removeChild(def_style);

  var debug_url = url.replace("/pen/","/debug/").replace("/fullpage/","/debug/");


  var pens = '';

  pens += '<div><iframe src="http://codepen.io/fbrz/debug/'+pen1+'"></iframe><h2>'+desc1+'</h2><a href="http://codepen.io/fbrz/details/'+pen1+'" target="_blank"></a></div>';

  if(pen2!=undefined)
    pens += '<div><iframe src="http://codepen.io/fbrz/debug/'+pen2+'"></iframe><h2>'+desc2+'</h2><a href="http://codepen.io/fbrz/details/'+pen2+'" target="_blank"></a></div>';

  if(pen3!=undefined)
    pens += '<div><iframe src="http://codepen.io/fbrz/debug/'+pen3+'"></iframe><h2>'+desc3+'</h2><a href="http://codepen.io/fbrz/details/'+pen3+'" target="_blank"></a></div>';

  document.body.innerHTML = "<iframe id='pen' src='"+debug_url+"'></iframe><div id='al-overlay'></div><div id='alsolike'><h1>You might also like...</h1><a target='_blank' href='http://codepen.io/fbrz/pen/Guysm' id='more'>What's this?</a><a id='opener'></a><a id='closer'></a><div id='wrapper'>"+pens+"</div><div id='clearfix'></div></div><style>@import url(http://fonts.googleapis.com/css?family=Varela+Round);body{height:100%;margin:0;overflow:hidden;font-family:'Varela Round',sans-serif;-webkit-font-smoothing:antialiased}#pen{position:absolute;z-index:1;width:100%;height:100%;border:none}#al-overlay{z-index:0;-webkit-transition:opacity .5s ease-in-out, z-index .5s linear 1s;transition:opacity .5s ease-in-out, z-index .5s linear 1s;position:absolute;top:0;left:0;width:100%;height:100%;background:#000;opacity:0}#al-overlay.visible{-webkit-transition-delay:0;transition-delay:0;z-index:2;opacity:.5;}#alsolike #more{padding-right: 60px;-webkit-transition:opacity .1s ease-in-out;transition:opacity .1s ease-in-out;text-decoration:none;position:absolute;right:4%;top:50px;color:#717B85;font-weight:800;opacity:.3}#alsolike #more:hover{opacity:1}#alsolike #closer{cursor:pointer;top:50px;opacity:.2;right:4%;-webkit-transition:opacity .1s ease-in-out;transition:opacity .1s ease-in-out;width:40px;height:34px;position:absolute}#alsolike #closer:after,#alsolike #closer:before{border-left:4px solid #717B85;border-top:4px solid #717B85;position:absolute;top:0;width:15px;height:15px;content:''}#alsolike #closer:before{right:0;-webkit-transform:rotate(-45deg);-ms-transform:rotate(-45deg);transform:rotate(-45deg)}#alsolike #closer:after{-webkit-transform:rotate(135deg);-ms-transform:rotate(135deg);transform:rotate(135deg);right:21px}#alsolike #closer:hover{opacity:1}#alsolike{z-index:3;background:#E2E5E8;width:100%;position:absolute;top:100%;-webkit-transition:-webkit-transform .5s cubic-bezier(.7,0,.3,1);transition:transform .5s cubic-bezier(.7,0,.3,1);padding-bottom:40px}#alsolike.open{-webkit-transition-delay:.2s;transition-delay:.2s;-webkit-transform:translate3d(0,-100%,0);transform:translate3d(0,-100%,0)}#alsolike #opener{cursor:pointer;width:20px;height:20px;-webkit-transform:rotate(45deg);-ms-transform:rotate(45deg);transform:rotate(45deg);border-bottom:4px solid #4D4D4D;border-right:4px solid #4D4D4D;position:absolute;top:-60px;right:40px;-webkit-animation:opener .5s ease-in-out alternate infinite;animation:opener .5s ease-in-out alternate infinite;cursor:pointer;opacity:0.5;-webkit-transition:opacity .2s ease-in-out, transform .5s ease-in-out .2s;transition:opacity .2s ease-in-out, transform .5s ease-in-out .2s}#alsolike.open #opener{-webkit-transition-delay:0;transition-delay:0;transform:translate3d(0,500px,0) rotate(45deg);-webkit-transform:translate3d(0,500px,0) rotate(45deg);}#alsolike:not(.open) #opener:hover{-webkit-transition-delay:0;transition-delay:0;opacity:1}@-webkit-keyframes opener{100%{top:-65px}}@keyframes opener{100%{top:-65px}}#alsolike h1{margin:40px 4%;color:#717B85}#alsolike #wrapper{margin:2%}#alsolike #wrapper div{border-radius:5px; transform-style:preserve-3d;width:29%;height:250px;overflow:hidden;box-shadow:rgba(0,0,0,.04) 0 0 0 2px;float:left;margin:0 2%;position:relative;-webkit-transition:all .1s ease-in-out;transition:all .1s ease-in-out}#alsolike #wrapper div:hover{box-shadow:rgba(133, 146, 181, 0.4) 0 0 0 6px}#wrapper a{ display:block;position:absolute;top:0;left:0;width:100%;height:100%;}@media screen and (max-width:480px){#alsolike #wrapper div{height:130px}#alsolike #wrapper h2{font-size:9px}}@media screen and (max-width:680px){#alsolike #wrapper div{height:170px}#alsolike #wrapper h2{font-size:11px}}#alsolike #wrapper iframe{border:none;width:200%;height:200%;margin:0;-webkit-transform:scale(0.5);-ms-transform:scale(0.5);transform:scale(0.5);-webkit-transform-origin:0 0;-ms-transform-origin:0 0;transform-origin:0 0}#alsolike #wrapper h2{font-size:13px;background:#717B85;padding:11px;margin:0;color:#fff;position:absolute;bottom:0;width:100%;letter-spacing:-.5px;-moz-box-sizing:border-box;box-sizing:border-box;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}</style>";

  var alsolike = document.getElementById("alsolike");
  var overlay = document.getElementById("al-overlay");

  document.getElementById("opener").addEventListener("click", function() {
    alsolike.className = "open";
    overlay.className = "visible";
    return false;
  });

  document.getElementById("closer").addEventListener("click", function() {
    alsolike.className = "";
    overlay.className = "";
    return false;
  });
}
var profileDropdown = function($) {

	//Variables
	var dropdownClickSelector = '.profile--dropdown',
		writeDropdownClickSelector = '.write--dropdown',
		mobileMenuBtn = '.menu-btn';

	//Function to toggle dropdown
	var toggleDropdown = function(event)
	{
		if(event.type == 'click') {
				event.preventDefault();
				event.stopPropagation();
		}

		var $profileDropdown = $(this),
			$dropdown = $profileDropdown.next('.dropdown'),
			imageAnimateInClass = 'clickIn',
			$clickprofileDropdown = $(dropdownClickSelector),
			$writeDropdown = $(writeDropdownClickSelector)
			$wdropdown = $writeDropdown.next('.dropdown'),
			$pdropdown = $clickprofileDropdown.next('.dropdown');

		if($profileDropdown.hasClass('profile--dropdown') && $writeDropdown.is(":visible")) {
			$wdropdown.fadeOut(150);
		}

		if($profileDropdown.hasClass('write--dropdown') && $profileDropdown.is(":visible")) {
			$pdropdown.fadeOut(150);
		}

		if($dropdown.is(':hidden')) {
			$profileDropdown.addClass(imageAnimateInClass);
			setTimeout(function() {
				$dropdown.fadeIn(300, function() {
					$profileDropdown.removeClass(imageAnimateInClass);
				});
			}, 150);
		}else{
			$profileDropdown.addClass(imageAnimateInClass);
			$dropdown.fadeOut(150);
			setTimeout(function() {
				$profileDropdown.removeClass(imageAnimateInClass);
			}, 400);
		}
	}

	//Function to toggle mobile menu
	var toggleMobileMenu = function(event)
	{
		event.preventDefault();

		var $mobileMenu = $('.mobile-menu'),
			showClass = 'show';

		if($mobileMenu.hasClass(showClass)) {
			$mobileMenu.removeClass(showClass);
		} else {
			$mobileMenu.addClass(showClass);
		}
	}

	var ignition = function()
	{
		var $document = $(document);
		$document.on('click', dropdownClickSelector, toggleDropdown);
		$document.on('click', writeDropdownClickSelector, toggleDropdown);
		$document.on('click', mobileMenuBtn, toggleMobileMenu);
	}

	return {
		'start': ignition,

	}


}(jQuery);

$(document).ready(function() {
	profileDropdown.start();
});
/* =============================================================
 * bootstrap-typeahead.js v2.3.2
 * http://twitter.github.com/bootstrap/javascript.html#typeahead
 * =============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */


!function($){

  "use strict"; // jshint ;_;


 /* TYPEAHEAD PUBLIC CLASS DEFINITION
  * ================================= */

  var Typeahead = function (element, options) {
    this.$element = $(element)
    this.options = $.extend({}, $.fn.typeahead.defaults, options)
    this.matcher = this.options.matcher || this.matcher
    this.sorter = this.options.sorter || this.sorter
    this.highlighter = this.options.highlighter || this.highlighter
    this.updater = this.options.updater || this.updater
    this.source = this.options.source
    this.$menu = $(this.options.menu)
    this.shown = false
    this.listen()
  }

  Typeahead.prototype = {

    constructor: Typeahead

  , select: function () {
      var val = this.$menu.find('.active').attr('data-value')
      this.$element
        .val(this.updater(val))
        .change()
      return this.hide()
    }

  , updater: function (item) {
      return item
    }

  , show: function () {
      var pos = $.extend({}, this.$element.position(), {
        height: this.$element[0].offsetHeight
      })

      this.$menu
        .insertAfter(this.$element)
        .css({
          top: pos.top + pos.height
        , left: pos.left
        })
        .show()

      this.shown = true
      return this
    }

  , hide: function () {
      this.$menu.hide()
      this.shown = false
      return this
    }

  , lookup: function (event) {
      var items

      this.query = this.$element.val()

      if (!this.query || this.query.length < this.options.minLength) {
        return this.shown ? this.hide() : this
      }

      items = $.isFunction(this.source) ? this.source(this.query, $.proxy(this.process, this)) : this.source

      return items ? this.process(items) : this
    }

  , process: function (items) {
      var that = this

      items = $.grep(items, function (item) {
        return that.matcher(item)
      })

      items = this.sorter(items)

      if (!items.length) {
        return this.shown ? this.hide() : this
      }

      return this.render(items.slice(0, this.options.items)).show()
    }

  , matcher: function (item) {
      return ~item.toLowerCase().indexOf(this.query.toLowerCase())
    }

  , sorter: function (items) {
      var beginswith = []
        , caseSensitive = []
        , caseInsensitive = []
        , item

      while (item = items.shift()) {
        if (!item.toLowerCase().indexOf(this.query.toLowerCase())) beginswith.push(item)
        else if (~item.indexOf(this.query)) caseSensitive.push(item)
        else caseInsensitive.push(item)
      }

      return beginswith.concat(caseSensitive, caseInsensitive)
    }

  , highlighter: function (item) {
      var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
      return item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
        return '<strong>' + match + '</strong>'
      })
    }

  , render: function (items) {
      var that = this

      items = $(items).map(function (i, item) {
        i = $(that.options.item).attr('data-value', item)
        i.find('a').html(that.highlighter(item))
        return i[0]
      })

      items.first().addClass('active')
      this.$menu.html(items)
      return this
    }

  , next: function (event) {
      var active = this.$menu.find('.active').removeClass('active')
        , next = active.next()

      if (!next.length) {
        next = $(this.$menu.find('li')[0])
      }

      next.addClass('active')
    }

  , prev: function (event) {
      var active = this.$menu.find('.active').removeClass('active')
        , prev = active.prev()

      if (!prev.length) {
        prev = this.$menu.find('li').last()
      }

      prev.addClass('active')
    }

  , listen: function () {
      this.$element
        .on('focus',    $.proxy(this.focus, this))
        .on('blur',     $.proxy(this.blur, this))
        .on('keypress', $.proxy(this.keypress, this))
        .on('keyup',    $.proxy(this.keyup, this))

      if (this.eventSupported('keydown')) {
        this.$element.on('keydown', $.proxy(this.keydown, this))
      }

      this.$menu
        .on('click', $.proxy(this.click, this))
        .on('mouseenter', 'li', $.proxy(this.mouseenter, this))
        .on('mouseleave', 'li', $.proxy(this.mouseleave, this))
    }

  , eventSupported: function(eventName) {
      var isSupported = eventName in this.$element
      if (!isSupported) {
        this.$element.setAttribute(eventName, 'return;')
        isSupported = typeof this.$element[eventName] === 'function'
      }
      return isSupported
    }

  , move: function (e) {
      if (!this.shown) return

      switch(e.keyCode) {
        case 9: // tab
        case 13: // enter
        case 27: // escape
          e.preventDefault()
          break

        case 38: // up arrow
          e.preventDefault()
          this.prev()
          break

        case 40: // down arrow
          e.preventDefault()
          this.next()
          break
      }

      e.stopPropagation()
    }

  , keydown: function (e) {
      this.suppressKeyPressRepeat = ~$.inArray(e.keyCode, [40,38,9,13,27])
      this.move(e)
    }

  , keypress: function (e) {
      if (this.suppressKeyPressRepeat) return
      this.move(e)
    }

  , keyup: function (e) {
      switch(e.keyCode) {
        case 40: // down arrow
        case 38: // up arrow
        case 16: // shift
        case 17: // ctrl
        case 18: // alt
          break

        case 9: // tab
        case 13: // enter
          if (!this.shown) return
          this.select()
          break

        case 27: // escape
          if (!this.shown) return
          this.hide()
          break

        default:
          this.lookup()
      }

      e.stopPropagation()
      e.preventDefault()
  }

  , focus: function (e) {
      this.focused = true
    }

  , blur: function (e) {
      this.focused = false
      if (!this.mousedover && this.shown) this.hide()
    }

  , click: function (e) {
      e.stopPropagation()
      e.preventDefault()
      this.select()
      this.$element.focus()
    }

  , mouseenter: function (e) {
      this.mousedover = true
      this.$menu.find('.active').removeClass('active')
      $(e.currentTarget).addClass('active')
    }

  , mouseleave: function (e) {
      this.mousedover = false
      if (!this.focused && this.shown) this.hide()
    }

  }


  /* TYPEAHEAD PLUGIN DEFINITION
   * =========================== */

  var old = $.fn.typeahead

  $.fn.typeahead = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('typeahead')
        , options = typeof option == 'object' && option
      if (!data) $this.data('typeahead', (data = new Typeahead(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.typeahead.defaults = {
    source: []
  , items: 8
  , menu: '<ul class="typeahead dropdown-menu"></ul>'
  , item: '<li><a href="#"></a></li>'
  , minLength: 1
  }

  $.fn.typeahead.Constructor = Typeahead


 /* TYPEAHEAD NO CONFLICT
  * =================== */

  $.fn.typeahead.noConflict = function () {
    $.fn.typeahead = old
    return this
  }


 /* TYPEAHEAD DATA-API
  * ================== */

  $(document).on('focus.typeahead.data-api', '[data-provide="typeahead"]', function (e) {
    var $this = $(this)
    if ($this.data('typeahead')) return
    $this.typeahead($this.data())
  })

}(window.jQuery);
/*!
 * --------------------------------------------------------------------
 *  SIMPLE TEXT SELECTION LIBRARY FOR ONLINE TEXT EDITING (2015-02-21)
 * --------------------------------------------------------------------
 * Source code available at https://github.com/tovic/simple-text-editor-library
 *
 */
var Editor=function(e){var t=this,a=document,n=[],l=0,r=null;t.area=void 0!==e?e:a.getElementsByTagName("textarea")[0],n[l]={value:t.area.value,selectionStart:0,selectionEnd:0},l++,t.selection=function(){var e=t.area.selectionStart,a=t.area.selectionEnd,n=t.area.value.substring(e,a),l=t.area.value.substring(0,e),r=t.area.value.substring(a),o={start:e,end:a,value:n,before:l,after:r};return o},t.select=function(e,n,l){var r=[a.documentElement.scrollTop,a.body.scrollTop,t.area.scrollTop];t.area.focus(),t.area.setSelectionRange(e,n),a.documentElement.scrollTop=r[0],a.body.scrollTop=r[1],t.area.scrollTop=r[2],"function"==typeof l&&l()},t.replace=function(e,a,n){var l=t.selection(),r=l.start,o=(l.end,l.value.replace(e,a));t.area.value=l.before+o+l.after,t.select(r,r+o.length),"function"==typeof n?n():t.updateHistory({value:t.area.value,selectionStart:r,selectionEnd:r+o.length})},t.insert=function(e,a){var n=t.selection(),l=n.start;n.end,t.area.value=n.before+e+n.after,t.select(l+e.length,l+e.length),"function"==typeof a?a():t.updateHistory({value:t.area.value,selectionStart:l+e.length,selectionEnd:l+e.length})},t.wrap=function(e,a,n){var l=t.selection(),r=l.value,o=l.before,c=l.after;t.area.value=o+e+r+a+c,t.select(o.length+e.length,o.length+e.length+r.length),"function"==typeof n?n():t.updateHistory({value:t.area.value,selectionStart:o.length+e.length,selectionEnd:o.length+e.length+r.length})},t.indent=function(e,a){var n=t.selection();n.value.length>0?t.replace(/(^|\n)([^\n])/gm,"$1"+e+"$2",a):(t.area.value=n.before+e+n.value+n.after,t.select(n.start+e.length,n.start+e.length),"function"==typeof a?a():t.updateHistory({value:t.area.value,selectionStart:n.start+e.length,selectionEnd:n.start+e.length}))},t.outdent=function(e,a){var n=t.selection();if(n.value.length>0)t.replace(RegExp("(^|\n)"+e,"gm"),"$1",a);else{var l=n.before.replace(RegExp(e+"$"),"");t.area.value=l+n.value+n.after,t.select(l.length,l.length),"function"==typeof a?a():t.updateHistory({value:t.area.value,selectionStart:l.length,selectionEnd:l.length})}},t.callHistory=function(e){return"number"==typeof e?n[e]:n},t.updateHistory=function(e,a){var r=void 0!==e?e:{value:t.area.value,selectionStart:t.selection().start,selectionEnd:t.selection().end};n["number"==typeof a?a:l]=r,l++},t.undo=function(e){if(n.length>1){l>1?l--:l=1;var a=t.callHistory(l-1);r=l>0?l:l-1,t.area.value=a.value,t.select(a.selectionStart,a.selectionEnd),"function"==typeof e&&e()}},t.redo=function(e){if(null!==r){var a=t.callHistory(r);r<n.length-1?r++:r=n.length-1,l=r<n.length-1?r:r+1,t.area.value=a.value,t.select(a.selectionStart,a.selectionEnd),"function"==typeof e&&e()}}};
function fbShare(url, title, descr, image, winWidth, winHeight) {
    var winTop = (screen.height / 2) - (winHeight / 2);
    var winLeft = (screen.width / 2) - (winWidth / 2);
    window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + descr + '&p[url]=' + url + '&p[images][0]=' + image, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
}
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
/*jslint forin: true */

;(function($) {
    $.fn.extend({
        mention: function(options) {
            this.opts = {
                users: [],
                delimiter: '@',
                sensitive: true,
                emptyQuery: false,
                queryBy: ['name', 'username'],
                typeaheadOpts: {}
            };

            var settings = $.extend({}, this.opts, options),
                _checkDependencies = function() {
                    if (typeof $ == 'undefined') {
                        throw new Error("jQuery is Required");
                    }
                    else {
                        if (typeof $.fn.typeahead == 'undefined') {
                            throw new Error("Typeahead is Required");
                        }
                    }
                    return true;
                },
                _extractCurrentQuery = function(query, caratPos) {
                    var i;
                    for (i = caratPos; i >= 0; i--) {
                        if (query[i] == settings.delimiter) {
                            break;
                        }
                    }
                    return query.substring(i, caratPos);
                },
                _matcher = function(itemProps) {
                    var i;

                    if(settings.emptyQuery){
	                    var q = (this.query.toLowerCase()),
	                    	caratPos = this.$element[0].selectionStart,
	                    	lastChar = q.slice(caratPos-1,caratPos);
	                    if(lastChar==settings.delimiter){
		                    return true;
	                    }
                    }

                    for (i in settings.queryBy) {
                        if (itemProps[settings.queryBy[i]]) {
                            var item = itemProps[settings.queryBy[i]].toLowerCase(),
                                usernames = (this.query.toLowerCase()).match(new RegExp(settings.delimiter + '\\w+', "g")),
                                j;
                            if ( !! usernames) {
                                for (j = 0; j < usernames.length; j++) {
                                    var username = (usernames[j].substring(1)).toLowerCase(),
                                        re = new RegExp(settings.delimiter + item, "g"),
                                        used = ((this.query.toLowerCase()).match(re));

                                    if (item.indexOf(username) != -1 && used === null) {
                                        return true;
                                    }
                                }
                            }
                        }
                    }
                },
                _updater = function(item) {
                    var data = this.query,
                        caratPos = this.$element[0].selectionStart,
                        i;

                    for (i = caratPos; i >= 0; i--) {
                        if (data[i] == settings.delimiter) {
                            break;
                        }
                    }
                    var replace = data.substring(i, caratPos),
                    	textBefore = data.substring(0, i),
                    	textAfter = data.substring(caratPos),
                    	data = textBefore + settings.delimiter + item + textAfter;

                    this.tempQuery = data;

                    return data;
                },
                _sorter = function(items) {
                    if (items.length && settings.sensitive) {
                        var currentUser = _extractCurrentQuery(this.query, this.$element[0].selectionStart).substring(1),
                            i, len = items.length,
                            priorities = {
                                highest: [],
                                high: [],
                                med: [],
                                low: []
                            }, finals = [];
                        if (currentUser.length == 1) {
                            for (i = 0; i < len; i++) {
                                var currentRes = items[i];

                                if ((currentRes.username[0] == currentUser)) {
                                    priorities.highest.push(currentRes);
                                }
                                else if ((currentRes.username[0].toLowerCase() == currentUser.toLowerCase())) {
                                    priorities.high.push(currentRes);
                                }
                                else if (currentRes.username.indexOf(currentUser) != -1) {
                                    priorities.med.push(currentRes);
                                }
                                else {
                                    priorities.low.push(currentRes);
                                }
                            }
                            for (i in priorities) {
                                var j;
                                for (j in priorities[i]) {
                                    finals.push(priorities[i][j]);
                                }
                            }
                            return finals;
                        }
                    }
                    return items;
                },
                _render = function(items) {
                    var that = this;
                    items = $(items).map(function(i, item) {

                        i = $(that.options.item).attr('data-value', item.username);

                        var _linkHtml = $('<div />');

                        if (item.avatar_url) {
                            _linkHtml.append('<img class="mention_image" src="' + item.avatar_url + '">');
                        }
                        if (item.username) {
                            _linkHtml.append('<span class="mention_name">' + item.username + '</span>');
                        }

                        i.find('a').html(that.highlighter(_linkHtml.html()));
                        return i[0];
                    });

                    items.first().addClass('active');
                    this.$menu.html(items);
                    return this;
                };

            $.fn.typeahead.Constructor.prototype.render = _render;

            return this.each(function() {
                var _this = $(this);
                if (_checkDependencies()) {
                    _this.typeahead($.extend({
                        source: settings.users,
                        matcher: _matcher,
                        updater: _updater,
                        sorter: _sorter
                    }, settings.typeaheadOpts));
                }
            });
        }
    });
})(jQuery);
//# sourceMappingURL=components.js.map