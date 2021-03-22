<?php
/**
 * Theme navigation menu class.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Menu Class.
 *
 * @since v1.0.0
 */
class Innova_Menus {

	/**
	 * Refers to a single instance of this class.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 *
	 * @since 1.0.0
	 */
	public static $instance = null;

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @return Innova_Menus
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize Menus.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action( 'after_setup_theme', array( $this, 'register_menus' ) );
	}

	/**
	 * Registering Nav menu Locations.
	 *
	 * @uses   register_nav_menus()
	 * @access public
	 * @return mixed
	 *
	 * @since 1.0.0
	 */
	public function register_menus() {
		$args = array(
			'primary_nav'  => esc_html__( 'Primary Navigation Menu', 'innova' ),
			'handheld_nav' => esc_html__( 'Mobile Navigation Menu', 'innova' ),
		);

		return register_nav_menus( $args );
	}

	/**
	 * Method to expedite the display nav menu process.
	 *
	 * @access public
	 * @param array $args Nav menu arguments.
	 * @return void|mixed|false|null
	 *
	 * @since 1.0.0
	 */
	public static function nav_menu( array $args ) {

		$defaults = array(
			'theme_location'  => '',
			'menu'            => '',
			'container'       => 'ul',
			'container_class' => 'main-menu',
			'container_id'    => '',
			'menu_class'      => 'sf-menu',
			'menu_id'         => 'main-menu',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'          => '',
		);

		$defaults = apply_filters( 'innova_nav_menu_defaults', $defaults, $args );

		$args = wp_parse_args( $args, $defaults );

		// If a menu is not assigned to theme location, abort.
		if ( ! has_nav_menu( $args['theme_location'] ) ) {
			return null;
		}

		return wp_nav_menu( $args );
	}
}
