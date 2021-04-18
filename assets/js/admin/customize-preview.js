'use strict';

(function($) {
	// Header text.
	wp.customize('header_textcolor', function(value) {
		value.bind(function(to) {
			if ('blank' === to) {
				$('.site-title a, .site-description').css({
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute'
				});

				$('body').addClass('title-tagline-hidden');
			} else {
				$('.site-title a, .site-description').css({
					clip: 'auto',
					position: 'relative'
				});
				$('.site-title a, .site-description').css({
					color: to
				});

				$('body').removeClass('title-tagline-hidden');
			}
		});
	});

	// Colors.
	var colors = [ 'text', 'primary', 'secondary', 'tertiary', 'offset', 'border' ];
	colors.forEach((color) => {
		wp.customize('innova_' + color + '_color', function(value) {
			value.bind(function(to) {
				$(':root').get(0).style.setProperty('--inv-' + color + '-color', to);
			});
		});
	});
})(jQuery);
