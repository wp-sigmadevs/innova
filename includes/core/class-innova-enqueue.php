<?php
/**
 * Main enqueue Class.
 *
 * This class registers all scripts & styles required for Innova Theme.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Enqueue Class.
 *
 * @since  1.0.0
 */
class Innova_Enqueue {

	/**
	 * Accumulates scripts.
	 *
	 * @access protected
	 * @var array
	 *
	 * @since  1.0.0
	 */
	protected $enqueues = array();

	/**
	 * Method to register scripts.
	 *
	 * @access protected
	 * @return void|class
	 *
	 * @since  1.0.0
	 */
	protected function register_scripts() {

		if ( empty( $this->enqueues ) ) {
			return;
		}

		$wp_register_function = '';

		foreach ( $this->enqueues as $type => $enqueue ) {
			$wp_register_function = 'wp_register_' . $type;

			foreach ( $enqueue as $key ) {
				$wp_register_function(
					$key['handle'],
					$key['asset_uri'],
					! empty( $key['dependency'] ) ? $key['dependency'] : array(),
					! empty( $key['version'] ) ? $key['version'] : $this->plugin_version,
					( 'style' === $type ) ? 'all' : true
				);
			}
		}

		return $this;
	}

	/**
	 * Method to enqueue scripts.
	 *
	 * @since  1.0.0
	 * @access protected
	 *
	 * @return void
	 */
	protected function enqueue_scripts() {

		if ( empty( $this->enqueues ) ) {
			return;
		}

		$wp_enqueue_function = '';

		foreach ( $this->enqueues as $type => $enqueue ) {
			$wp_enqueue_function = 'wp_enqueue_' . $type;

			foreach ( $enqueue as $key ) {
				$wp_enqueue_function( $key['handle'] );
			}
		}
	}

	/**
	 * Method to enqueue styles only.
	 *
	 * @since  1.0.0
	 * @access protected
	 *
	 * @return void
	 */
	protected function enqueue_only_styles() {

		if ( empty( $this->enqueues ) ) {
			return;
		}

		foreach ( $this->enqueues as $type => $enqueue ) {
			if ( 'style' === $type ) {
				foreach ( $enqueue as $key ) {
					wp_enqueue_style( $key['handle'] );
				}
			}
		}
	}
}
