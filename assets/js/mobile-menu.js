/**
 * Elemntor Elemntor Mobile Menu Scripts
 *
 * @package Elemntor_Elemntor
 */

(function($) {
	'use strict';

	// Use event delegation for better editor support
	$(document).on('click', '.ee-mobile-menu-toggle', function(e) {
		e.preventDefault();
		e.stopPropagation();
		e.stopImmediatePropagation();
		
		var $toggle = $(this);
		var $wrapper = $toggle.closest('.ee-mobile-menu-wrapper');
		var $panel = $wrapper.find('.ee-mobile-menu-panel');
		var $overlay = $wrapper.find('.ee-mobile-menu-overlay');
		
		$panel.addClass('active');
		$overlay.addClass('active');
		$('body').addClass('ee-menu-open');
		
		// Close all submenus
		$wrapper.find('.ee-submenu').removeClass('active');
		$wrapper.find('.ee-submenu-toggle').removeClass('active');
		
		return false;
	});

	// Close menu handlers
	$(document).on('click', '.ee-mobile-menu-close', function(e) {
		e.preventDefault();
		e.stopPropagation();
		e.stopImmediatePropagation();
		
		var $close = $(this);
		var $wrapper = $close.closest('.ee-mobile-menu-wrapper');
		var $panel = $wrapper.find('.ee-mobile-menu-panel');
		var $overlay = $wrapper.find('.ee-mobile-menu-overlay');
		
		$panel.removeClass('active');
		$overlay.removeClass('active');
		$('body').removeClass('ee-menu-open');
		
		// Close all submenus
		$wrapper.find('.ee-submenu').removeClass('active');
		$wrapper.find('.ee-submenu-toggle').removeClass('active');
		
		return false;
	});

	$(document).on('click', '.ee-mobile-menu-overlay', function(e) {
		e.preventDefault();
		e.stopPropagation();
		e.stopImmediatePropagation();
		
		var $overlay = $(this);
		var $wrapper = $overlay.closest('.ee-mobile-menu-wrapper');
		var $panel = $wrapper.find('.ee-mobile-menu-panel');
		
		$panel.removeClass('active');
		$overlay.removeClass('active');
		$('body').removeClass('ee-menu-open');
		
		// Close all submenus
		$wrapper.find('.ee-submenu').removeClass('active');
		$wrapper.find('.ee-submenu-toggle').removeClass('active');
		
		return false;
	});

	// Close on ESC key
	$(document).on('keydown', function(e) {
		if (e.key === 'Escape') {
			$('.ee-mobile-menu-panel.active').each(function() {
				var $panel = $(this);
				var $wrapper = $panel.closest('.ee-mobile-menu-wrapper');
				var $overlay = $wrapper.find('.ee-mobile-menu-overlay');
				
				$panel.removeClass('active');
				$overlay.removeClass('active');
				$('body').removeClass('ee-menu-open');
				
				// Close all submenus
				$wrapper.find('.ee-submenu').removeClass('active');
				$wrapper.find('.ee-submenu-toggle').removeClass('active');
			});
		}
	});

	// Toggle submenu - accordion style
	$(document).on('click', '.ee-submenu-toggle', function(e) {
		e.preventDefault();
		e.stopPropagation();
		e.stopImmediatePropagation();
		
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
			// Close other submenus at the same level
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
		
		return false;
	});

	// Prevent menu from closing when clicking inside panel
	$(document).on('click', '.ee-mobile-menu-panel', function(e) {
		e.stopPropagation();
	});

	// Hide back button (not needed for accordion style)
	$(document).ready(function() {
		$('.ee-mobile-menu-back').hide();
	});

	// Initialize in Elementor editor preview
	if (typeof elementor !== 'undefined') {
		elementor.on('preview:loaded', function() {
			setTimeout(function() {
				$('.ee-mobile-menu-back').hide();
			}, 100);
		});
	}

})(jQuery);
