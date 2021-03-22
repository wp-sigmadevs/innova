<?php
/**
 * Template Functions.
 * List of all template functions which enhance the theme by
 * hooking into WordPress.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

add_filter( 'body_class', 'innova_body_classes' );
if ( ! function_exists( 'innova_body_classes' ) ) {
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 *
	 * @since 1.0.0
	 */
	function innova_body_classes( $classes ) {

		// Adds `singular` to singular pages, and `hfeed` to all other pages.
		$classes[] = is_singular() ? 'singular' : 'hfeed';

		// Adds a class to blogs with more than 1 published author.
		$classes[] = is_multi_author() ? 'group-blog' : '';

		// Adds a class of no-sidebar when there is no sidebar present.
		if ( ! is_active_sidebar( 'innova-sidebar-general' ) || ! is_active_sidebar( 'innova-sidebar-blog' ) ) {
			$classes[] = 'no-sidebar';
		}

		// Adds a class when Woocommerce is detected.
		$classes[] = class_exists( 'Woocommerce' ) ? 'woocommerce-active' : '';

		// the list of WordPress global browser checks.
		// https://codex.wordpress.org/Global_Variables#Browser_Detection_Booleans.
		$browsers = array( 'iphone', 'chrome', 'safari', 'NS4', 'opera', 'macIE', 'winIE', 'gecko', 'lynx', 'IE', 'edge' );

		// check the globals to see if the browser is in there and return a string with the match.
		$classes[] = join(
			' ',
			array_filter(
				$browsers,
				function ( $browser ) {
					return '' . $GLOBALS[ 'is_' . $browser ];
				}
			)
		);

		return $classes;
	}
}

add_action( 'wp_head', 'innova_pingback_header' );
if ( ! function_exists( 'innova_pingback_header' ) ) {
	/**
	 * Adds a ping-back url auto-discovery header for
	 * single posts, pages, or attachments.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}
}

add_action( 'wp_footer', 'innova_handheld_menu_mask' );
if ( ! function_exists( 'innova_handheld_menu_mask' ) ) {
	/**
	 * Adds an empty placeholder div for handheld menu masking.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_handheld_menu_mask() {
		?>
		<div id="innova-menu-mask" class="innova-menu-mask"></div>
		<!-- <?php echo esc_attr__( 'Empty placeholder for handheld Menu masking.', 'innova' ); ?> -->
		<?php
	}
}

add_action( 'wp_footer', 'innova_scroll_to_top' );
if ( ! function_exists( 'innova_scroll_to_top' ) ) {
	/**
	 * Adds a scroll to top button.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_scroll_to_top() {
		if ( false === get_theme_mod( 'innova_enable_totop', true ) ) {
			return;
		}

		echo '<div class="innova-scroll-to-top"></div>';
	}
}

add_filter( 'the_title', 'innova_empty_post_title' );
if ( ! function_exists( 'innova_empty_post_title' ) ) {
	/**
	 * Adds a title to posts and pages that are missing titles.
	 *
	 * @param string $title The title.
	 * @return string
	 *
	 * @since 1.0.0
	 */
	function innova_empty_post_title( $title ) {
		return '' === $title ? esc_html_x( 'Untitled', 'Added to posts and pages that are missing titles', 'innova' ) : $title;
	}
}

add_action( 'wp_head', 'innova_header_code' );
if ( ! function_exists( 'innova_header_code' ) ) {
	/**
	 * Adds header code.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_header_code() {
		$header_code = get_theme_mod( 'innova_header_code', '' );

		if ( $header_code ) {
			echo $header_code; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}

add_action( 'wp_footer', 'innova_footer_code' );
if ( ! function_exists( 'innova_footer_code' ) ) {
	/**
	 * Adds footer code.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_footer_code() {
		$footer_code = get_theme_mod( 'innova_footer_code', '' );

		if ( $footer_code ) {
			echo $footer_code; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}

add_action( 'wp_body_open', 'innova_pageloader' );
if ( ! function_exists( 'innova_pageloader' ) ) {
	/**
	 * Adds a page loading animation.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_pageloader() {
		if ( false === get_theme_mod( 'innova_enable_pageloader', true ) ) {
			return;
		}

		echo '<div class="innova-pageloader"></div>';
	}
}
