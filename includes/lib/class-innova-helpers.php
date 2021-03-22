<?php
/**
 * The Helpers class.
 * We're using this one to accumulates various helper methods.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Helpers class.
 *
 * @since 1.0.0
 */
class Innova_Helpers {

	/**
	 * Query WooCommerce activation.
	 *
	 * @static
	 * @access public
	 * @return bool
	 *
	 * since 1.0.0
	 */
	public static function has_woocommerce() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}

	/**
	 * Query Jetpack activation.
	 *
	 * @static
	 * @access public
	 * @return bool
	 *
	 * since 1.0.0
	 */
	public static function has_jetpack() {
		return class_exists( 'Jetpack' ) ? true : false;
	}

	/**
	 * Check if we're on an Event page.
	 *
	 * @static
	 * @access public
	 * @param int|false $id The page ID.
	 * @return bool
	 *
	 * since 1.0.0
	 */
	public static function inside_tribe_event( $id = false ) {
		if ( function_exists( 'tribe_is_event' ) ) {
			if ( false === $id ) {
				return (bool) tribe_is_event();
			} else {
				return (bool) tribe_is_event( $id );
			}
		}
		return false;
	}

	/**
	 * Query if inside WooCommerce Page.
	 *
	 * @static
	 * @access public
	 * @return bool
	 *
	 * since 1.0.0
	 */
	public static function inside_woocommerce() {
		if ( function_exists( 'is_woocommerce' ) ) {
			return (bool) is_woocommerce();
		}
		return false;
	}

	/**
	 * Query if inside WooCommerce Shop Page.
	 *
	 * @static
	 * @access public
	 * @return bool
	 *
	 * since 1.0.0
	 */
	public static function inside_shop() {
		if ( function_exists( 'is_shop' ) ) {
			return (bool) is_shop();
		}
		return false;
	}

	/**
	 * Return the image markup.
	 *
	 * @since  1.0.0
	 * @access public
	 * @static
	 *
	 * @param string  $size image size.
	 * @param integer $id post id.
	 * @param string  $class image CSS class.
	 * @return mixed
	 */
	public static function render_image( $size = 'full', int $id = null, $class = '' ) {
		$alt_text = trim( wp_strip_all_tags( get_post_meta( absint( $id ), '_wp_attachment_image_alt', true ) ) );

		return wp_get_attachment_image(
			absint( $id ),
			esc_attr( $size ),
			false,
			array(
				'class' => esc_attr( $class ),
				'alt'   => esc_attr( $alt_text ),
			)
		);
	}
}
