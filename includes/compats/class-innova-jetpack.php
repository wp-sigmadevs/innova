<?php
/**
 * Jetpack Compatibility Class.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Jetpack Class.
 */
class Innova_Jetpack {

	/**
	 * Refers to a single instance of this class.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 * @since 1.0.0
	 */
	public static $instance = null;

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @return Innova_Jetpack
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Jetpack Support.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action( 'after_setup_theme', array( $this, 'setup' ) );
	}

	/**
	 * Setup Jetpack.
	 *
	 * See: https://jetpack.com/support/infinite-scroll/
	 * See: https://jetpack.com/support/responsive-videos/
	 * See: https://jetpack.com/support/content-options/
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function setup() {

		// Add theme support for Infinite Scroll.
		add_theme_support(
			'infinite-scroll',
			array(
				'container'      => 'posts-container',
				'render'         => array( $this, 'infinite_scroll_render' ),
				'posts_per_page' => get_option( 'posts_per_page' ),
				'wrapper'        => false,
				'footer'         => false,
			)
		);

		// Add theme support for Responsive Videos.
		add_theme_support( 'jetpack-responsive-videos' );

		// Add theme support for Content Options.
		add_theme_support(
			'jetpack-content-options',
			array(
				'post-details'    => array(
					'stylesheet' => 'innova-style',
					'date'       => '.posted-on',
					'categories' => '.cat-links',
					'tags'       => '.tags-links',
					'author'     => '.byline',
					'comment'    => '.comments-link',
				),
				'featured-images' => array(
					'archive' => true,
					'post'    => true,
					'page'    => true,
				),
			)
		);
	}

	/**
	 * Custom render function for Infinite Scroll.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			if ( is_search() ) {
				get_template_part( 'views/content/content', 'search' );
			} else {
				get_template_part( 'views/content/content', get_post_type() );
			}
		}
	}
}
