/*
 * Prevue.js jQuery Password Previewer v1.0.2
 * http://jaunesarmiento.me/prevuejs
 *
 * Copyright 2013, Jaune Sarmiento
 * Released under the MIT license
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Date: Wed Jan 29, 2014
 */

(function($) {

	// Enables console.log() in all browsers for error messages
	window.log = function() {
		log.history = log.history || [];
		log.history.push(arguments);
		if (this.console) {
			console.log(Array.prototype.slice.call(arguments))
		}
	};

	$.fn.prevue = function(settings) {

		/**
		 * Default settings
		 *
		 * string    fontIconClassNameOn      Class name of the icon to use when preview is on
		 * string    fontIconClassNameOff     Class name of the icon to use when preview is off
		 * string    fontSize                 The size of the icon
		 * string    color                    The color of the icon; in hex format (e.g #FFF or #000000). You may
		 *                                    also use rgb() and rgba() values here
		 * int       offsetX                  X-offset from the end of the input element; useful when the preview
		 *                                    button's position is off
		 * int       offsetY                  Y-offset from the top of the input element; useful when the preview
		 *                                    button's position is off
		 * int       zIndex                   z-index
		 */

		var defaults = {
			fontIconClassNameOff: 'prevue-icon-eye', // These are interchanged since when preview is off you'll want show the 'on' icon
			fontIconClassNameOn: 'prevue-icon-eye-off',
			fontSize: 14,
			color: '#999',
			offsetX: 5,
			offsetY: 0,
			zIndex: 0
		};

		// Merge the user settings with the defaults (if passed)
		if (settings){ $.extend(defaults, settings) }

		return this.each(function() {

			// Selected node
			var $o = $(this);

			// Name of the selected node
			var node = this.nodeName.toLowerCase();

			// If the node is actually an input[type="password"] element
			if (node == "input" && this.type == "password") {

				// Build the preview button
				
				var outerHeight = $o.outerHeight(false);
				defaults.fontSize = outerHeight / 2 - 1;

				if (defaults.fontSize > 14) {
					defaults.fontSize = 14;
				}
	
				var $input = $o,

					$previewIcon = $('<i>')
						.css({ 'font-size': defaults.fontSize + 'px' })
						.addClass('prevue-icon')
						.addClass(defaults.fontIconClassNameOff),

			
					$previewBtn = $('<a>')
						.attr('href', 'javascript: void(0);')
						.attr('tabindex', -1)
						.addClass('prevue-btn')
						.css({
							'text-decoration': 'none',
							'position': 'absolute',
							'padding-right': '5px',
							'padding-left': '5px',
							'line-height': '13px',
							'right': 0,
							'top': 0,
							'line-height': '0px',
							'color': defaults.color,
							'z-index': parseInt(0 + defaults.zIndex),
							'display': 'flex',
							'flex-direction':  'column',
							'justify-content': 'center',
							'height': '100%'
						}),



					$wrapper = $('<span>')
						.addClass('prevue-wrapper')
						.css({
							'position': 'relative',
							'display': 'inline-block',
							'vertical-align': 'top'
						});

				$previewBtn.append($previewIcon);

				$o.replaceWith($wrapper);
				$wrapper.append($input);
				$wrapper.append($previewBtn);

				// Add the event handler
				$previewBtn.on('click', function(e){
					var $el = $(this).prev(),
						$icon = $(this).children().eq(0);

					if ($el.prop('type') == 'password') {
						$el.prop('type', 'text');
						$icon.removeClass(defaults.fontIconClassNameOff).addClass(defaults.fontIconClassNameOn);
					}
					else {
						$el.prop('type', 'password');
						$icon.removeClass(defaults.fontIconClassNameOn).addClass(defaults.fontIconClassNameOff);
					}
				});

			} else {
				console.log('Prevue.js only works on <input type="password"> elements, while you have used it on a <'+node+'> element.');
				return false;
			}

		});

	};

})(jQuery);
