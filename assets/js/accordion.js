/**
 * Elemntor Elemntor Accordion Scripts
 *
 * @package Elemntor_Elemntor
 */

(function($) {
	'use strict';

	function initAccordion() {
		// Initialize accordion for each widget instance
		$('.ee-accordion').each(function() {
			var $accordion = $(this);
			
			// Skip if already initialized
			if ($accordion.data('accordion-initialized')) {
				return;
			}
			
			$accordion.data('accordion-initialized', true);
			
			var $headers = $accordion.find('.ee-accordion-header');
			var $items = $accordion.find('.ee-accordion-item');

			// Toggle accordion item on header click
			$headers.off('click.accordion').on('click.accordion', function(e) {
				e.preventDefault();
				e.stopPropagation();
				
				var $header = $(this);
				var $item = $header.closest('.ee-accordion-item');
				var $content = $item.find('.ee-accordion-content');
				var $closeIcon = $header.find('.ee-accordion-toggle-close');
				var $openIcon = $header.find('.ee-accordion-toggle-open');
				var isActive = $item.hasClass('active');

				if (isActive) {
					// Close the item
					// Set max-height to current height for smooth transition
					var currentHeight = $content[0].scrollHeight;
					$content.css('max-height', currentHeight + 'px');
					
					// Force reflow
					$content[0].offsetHeight;
					
					// Animate to 0
					setTimeout(function() {
						$item.removeClass('active');
						$content.css('max-height', '0');
						$closeIcon.show();
						$openIcon.hide();
					}, 10);
				} else {
					// Open the item
					$item.addClass('active');
					$closeIcon.hide();
					$openIcon.show();
					
					// Set max-height to scrollHeight for smooth transition
					var targetHeight = $content[0].scrollHeight;
					$content.css('max-height', targetHeight + 'px');
					
					// After transition, set to large value to allow content changes
					setTimeout(function() {
						$content.css('max-height', '5000px');
					}, 300);
				}
			});
		});
	}

	// Initialize on document ready
	$(document).ready(function() {
		initAccordion();
	});

	// Also initialize after Elementor frontend is ready (for dynamic content)
	if (typeof elementorFrontend !== 'undefined') {
		elementorFrontend.hooks.addAction('frontend/element_ready/accordion.default', function($scope) {
			initAccordion();
		});
	}

})(jQuery);

