'use strict';

var INNOVA = INNOVA || {};

/**
 * Predefined variables.
 */
var $ = jQuery,
	$window = $(window),
	$document = $(document),
	$body = $('body'),
	$mainMenu = $('.sf-menu'),
	$handheldMenu = $('.innova-menu'),
	$intelHeader = $('.intelligent-header'),
	$preLoader = $('.innova-pageloader'),
	$toTop = $('.innova-scroll-to-top'),
	$headerSpace = $('.fixed-header-space'),
	$fns = INNOVA.functions;

/**
 * Check if element exists.
 */
$.fn.elExists = function() {
	return this.length > 0;
};

/**
 * Helpers.
 */
INNOVA.helpers = {
	sampleFunction: function() {
		console.log('I am a helper function');
	}
};

/**
 * Functions.
 */
INNOVA.functions = {
	preLoaderInit: function() {
		if (!$preLoader.elExists()) {
			return false;
		}

		$preLoader.delay(300).fadeOut('fast');
	},

	mainNavInit: function() {
		$mainMenu.superfish({
			delay: 0,
			animation: { opacity: 'show' },
			animationOut: { opacity: 'hide' },
			speed: 'fast',
			autoArrows: false,
			disableHI: true
		});
	},

	mainNavSubAction: function() {
		$document.on('mouseenter', '.sf-menu .sub-menu', function() {
			var menu = $(this);
			var child = $(this).find('ul');
			if ($(menu).offset().left + $(menu).width() + $(child).width() > $(window).width()) {
				$(child).css({ left: 'inherit', right: '100%' });
			}
		});
	},

	handheldNavInit: function() {
		var cButton = document.querySelector('.innova-menu__close');
		if (cButton) {
			var slideLeft = new Menu();
		}

		var slideLeftBtn = document.querySelector('#innova-trigger-button');
		if (slideLeftBtn) {
			slideLeftBtn.addEventListener('click', function(e) {
				e.preventDefault;
				slideLeft.open();
			});
		}
	},

	handheldNavSubAction: function() {
		// adds toggle button to li items that have children
		$handheldMenu.find('li a').each(function() {
			if ($(this).next().length > 0) {
				$(this)
					.parent('li')
					.addClass('has-child')
					.append('<a class="drawer-toggle" href="#"><i class="fa fa-angle-down"></i></a>');
			}
		});

		// expands the dropdown menu on each click
		$handheldMenu.find('li .drawer-toggle').on('click', function(e) {
			e.preventDefault();
			$(this).parent('li').children('ul').stop(true, true).slideToggle(250);
			$(this).parent('li').toggleClass('open');
		});
	},

	intelligentMenuInit: function() {
		if (!$intelHeader.elExists()) {
			return false;
		}

		var navContainer = document.querySelector('.intelligent-header');
		var options = {
			classes: {
				initial: 'iheader',
				pinned: 'iheader--pinned',
				unpinned: 'iheader--unpinned',
				top: 'iheader--top',
				notTop: 'iheader--not-top',
				bottom: 'iheader--bottom',
				notBottom: 'iheader--not-bottom'
			}
		};

		var headroom = new Headroom(navContainer, options);

		headroom.init();
	},

	menuClasses: function() {
		if (!$intelHeader.elExists()) {
			return false;
		}

		$window.on('scroll', function() {
			var height = $window.scrollTop();

			if (height < 100) {
				$intelHeader.removeClass('scrolling');
			} else {
				$intelHeader.addClass('scrolling');
			}
		});
	},

	scrollToTop: function() {
		$toTop.hide();
		$window.on('scroll', function() {
			if ($window.scrollTop() > 200) {
				$toTop.fadeIn();
			} else {
				$toTop.fadeOut();
			}
		});

		$toTop.on('click', function() {
			$('html,body').animate(
				{
					scrollTop: 0
				},
				{
					duration: 700,
					easing: 'swing'
				}
			);
		});
	},

	bodyClass: function() {
		$body.addClass('document-loaded');
	},

	headerActions: function() {
		if (!$intelHeader.elExists()) {
			return false;
		}

		var intHeight = $intelHeader[0].getBoundingClientRect().height;
		$headerSpace.height(intHeight);
	}
};

/**
 * Scripts to run on document ready event.
 */
INNOVA.onReady = function() {
	var fns = INNOVA.functions;

	$document.on('ready', function() {
		fns.preLoaderInit();
		fns.mainNavInit();
		fns.mainNavSubAction();
		fns.handheldNavInit();
		fns.handheldNavSubAction();
		fns.intelligentMenuInit();
		fns.menuClasses();
		fns.scrollToTop();
		fns.headerActions();
	});
};

/**
 * Scripts to run on window load event.
 */
INNOVA.onLoad = function() {
	var fns = INNOVA.functions;

	$window.on('load', function() {
		fns.bodyClass();
	});
};

/**
 * Scripts to run on window resize event.
 */
INNOVA.onResize = function() {
	var fns = INNOVA.functions;

	$window.on('resize', function() {
		fns.headerActions();
	});
};

/**
 * App Init.
 */
INNOVA.init = (function() {
	INNOVA.onReady(), INNOVA.onLoad(), INNOVA.onResize();
})();
