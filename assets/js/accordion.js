/**
 * Elemntor Elemntor Accordion Scripts
 *
 * @package Elemntor_Elemntor
 */

(function($) {
	'use strict';

	// Function to align content with title start
	function alignContentWithTitle() {
		$('.ee-accordion-item').each(function() {
			var $item = $(this);
			var $header = $item.find('.ee-accordion-header');
			var $title = $header.find('.ee-accordion-title');
			var $content = $item.find('.ee-accordion-content');
			var $icon = $header.find('.ee-accordion-icon-left');
			
			if ($title.length && $content.length) {
				// Get the title's left position relative to the header
				var titleOffset = $title.position().left;
				
				// Only apply if accordion is active (open) and title offset is valid
				if ($item.hasClass('active') && titleOffset > 0) {
					// Get current padding values to preserve them
					var currentPaddingTop = $content.css('padding-top') || '0';
					var currentPaddingRight = $content.css('padding-right') || '0';
					var currentPaddingBottom = $content.css('padding-bottom') || '0';
					
					// Set left padding to align with title, preserve other padding
					$content.css({
						'padding-left': titleOffset + 'px',
						'padding-top': currentPaddingTop,
						'padding-right': currentPaddingRight,
						'padding-bottom': currentPaddingBottom
					});
				} else if (!$item.hasClass('active')) {
					// When closed, ensure padding-left is 0
					$content.css('padding-left', '0');
				}
			}
		});
	}

	// Use event delegation for accordion header clicks
	$(document).on('click', '.ee-accordion-header', function(e) {
		e.preventDefault();
		e.stopPropagation();
		e.stopImmediatePropagation();
		
		var $header = $(this);
		var $item = $header.closest('.ee-accordion-item');
		var $content = $item.find('.ee-accordion-content');
		var $closeIcon = $header.find('.ee-accordion-toggle-close');
		var $openIcon = $header.find('.ee-accordion-toggle-open');
		var $title = $header.find('.ee-accordion-title');
		var isActive = $item.hasClass('active');

		if (isActive) {
			// Close the item
			// Set max-height to current height for smooth transition
			var currentHeight = $content[0].scrollHeight;
			$content.css('max-height', currentHeight + 'px');
			
			// Force reflow
			$content[0].offsetHeight;
			
			// Animate to 0 and remove padding
			setTimeout(function() {
				$item.removeClass('active');
				$content.css({
					'max-height': '0',
					'padding-top': '0',
					'padding-bottom': '0',
					'padding-left': '0',
					'padding-right': '0'
				});
				$closeIcon.show();
				$openIcon.hide();
			}, 10);
		} else {
			// Open the item
			$item.addClass('active');
			$closeIcon.hide();
			$openIcon.show();
			
			// Remove inline padding styles to let CSS handle it
			$content.css({
				'padding-top': '',
				'padding-bottom': '',
				'padding-left': '',
				'padding-right': ''
			});
			
			// Force reflow to apply CSS
			$content[0].offsetHeight;
			
			// Set max-height to scrollHeight for smooth transition
			var targetHeight = $content[0].scrollHeight;
			$content.css('max-height', targetHeight + 'px');
			
			// After transition, set to large value and align with title
			setTimeout(function() {
				$content.css('max-height', '5000px');
				// Align content with title after opening
				alignContentWithTitle();
			}, 300);
		}
		
		return false;
	});

	// Align content on page load and resize
	$(document).ready(function() {
		alignContentWithTitle();
	});

	$(window).on('resize', function() {
		alignContentWithTitle();
	});

	// Initialize in Elementor editor preview
	if (typeof elementor !== 'undefined') {
		elementor.on('preview:loaded', function() {
			// Scripts are already initialized via event delegation
		});
	}

})(jQuery);
