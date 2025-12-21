/**
 * Elemntor Elemntor Mobile Menu Scripts
 *
 * @package Elemntor_Elemntor
 */

(function($) {
	'use strict';

	function initMobileMenu() {
		// Initialize mobile menu for each widget instance
		$('.ee-mobile-menu-wrapper').each(function() {
			var $wrapper = $(this);
			
			// Skip if already initialized
			if ($wrapper.data('menu-initialized')) {
				return;
			}
			
			$wrapper.data('menu-initialized', true);
			
			var $toggle = $wrapper.find('.ee-mobile-menu-toggle');
			var $close = $wrapper.find('.ee-mobile-menu-close');
			var $back = $wrapper.find('.ee-mobile-menu-back');
			var $title = $wrapper.find('.ee-mobile-menu-title');
			var $overlay = $wrapper.find('.ee-mobile-menu-overlay');
			var $panel = $wrapper.find('.ee-mobile-menu-panel');
			var $menu = $wrapper.find('.ee-mobile-menu');
			var $submenuToggles = $wrapper.find('.ee-submenu-toggle');

			// Open menu
			$toggle.off('click.mobileMenu').on('click.mobileMenu', function(e) {
				e.preventDefault();
				e.stopPropagation();
				$panel.addClass('active');
				$overlay.addClass('active');
				$('body').addClass('ee-menu-open');
				// Close all submenus
				$wrapper.find('.ee-submenu').removeClass('active');
				$wrapper.find('.ee-submenu-toggle').removeClass('active');
			});

			// Close menu
			function closeMenu() {
				$panel.removeClass('active');
				$overlay.removeClass('active');
				$('body').removeClass('ee-menu-open');
				// Close all submenus
				$wrapper.find('.ee-submenu').removeClass('active');
				$wrapper.find('.ee-submenu-toggle').removeClass('active');
			}

			$close.off('click.mobileMenu').on('click.mobileMenu', function(e) {
				e.preventDefault();
				e.stopPropagation();
				closeMenu();
			});

			$overlay.off('click.mobileMenu').on('click.mobileMenu', function(e) {
				e.preventDefault();
				e.stopPropagation();
				closeMenu();
			});

			// Back button - hide it for accordion style (not needed)
			$back.hide();

			// Close on ESC key
			$(document).off('keydown.mobileMenu').on('keydown.mobileMenu', function(e) {
				if (e.key === 'Escape' && $panel.hasClass('active')) {
					closeMenu();
				}
			});

			// Toggle submenu - accordion style (show/hide)
			$submenuToggles.off('click.mobileMenu').on('click.mobileMenu', function(e) {
				e.preventDefault();
				e.stopPropagation();
				
				var $toggle = $(this);
				var $submenu = $toggle.siblings('.ee-submenu');
				var $parentLi = $toggle.closest('li');
				
				// Toggle current submenu
				if ($submenu.hasClass('active')) {
					$submenu.removeClass('active');
					$toggle.removeClass('active');
					$parentLi.removeClass('active');
					$parentLi.find('> a').removeClass('active');
				} else {
					// Close other submenus at the same level (optional - remove if you want multiple open)
					$parentLi.siblings('li').find('.ee-submenu').removeClass('active');
					$parentLi.siblings('li').find('.ee-submenu-toggle').removeClass('active');
					$parentLi.siblings('li').removeClass('active');
					$parentLi.siblings('li').find('> a').removeClass('active');
					
					// Open current submenu
					$submenu.addClass('active');
					$toggle.addClass('active');
					$parentLi.addClass('active');
					$parentLi.find('> a').addClass('active');
				}
			});

			// Prevent menu from closing when clicking inside panel
			$panel.off('click.mobileMenu').on('click.mobileMenu', function(e) {
				e.stopPropagation();
			});
		});
	}

	// Initialize on document ready
	$(document).ready(function() {
		initMobileMenu();
	});

	// Also initialize after Elementor frontend is ready (for dynamic content)
	if (typeof elementorFrontend !== 'undefined') {
		elementorFrontend.hooks.addAction('frontend/element_ready/mobile_menu.default', function($scope) {
			initMobileMenu();
		});
	}

})(jQuery);

