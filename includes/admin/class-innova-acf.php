<?php
/**
 * ACF Class.
 * This Class configures ACF to import local json files where
 * custom fields are stored.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * ACF Class.
 *
 * @since v1.0.0
 */
class Innova_ACF {

	/**
	 * Base Class.
	 *
	 * @access private
	 * @var object
	 * @since 1.0.0
	 */
	private $base;

	/**
	 * Refers to a single instance of this class.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 * @since  1.0.0
	 */
	public static $instance = null;

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @return Innova_ACF
	 * @since  1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering ACF fields.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		if ( ! class_exists( 'ACF' ) ) {
			return;
		}

		if ( true === get_theme_mod( 'innova_enable_acf_admin', true ) ) {
			return;
		}

		add_filter( 'acf/settings/show_admin', array( $this, 'show_admin' ) );
	}

	/**
	 * Method to show admin panel.
	 *
	 * @access public
	 * @return bool
	 *
	 * @since 1.0.0
	 */
	public function show_admin() {
		return false;
	}
}
