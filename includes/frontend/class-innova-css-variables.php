<?php
/**
 * CSS Variables Class.
 * This Class assigns CSS custom properties.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * SS Variables Class.
 *
 * @since v1.0.0
 */
class Innova_CSS_Variables {

	/**
	 * Variables to include.
	 *
	 * @access private
	 * @var array
	 * @since 1.0.0
	 */
	private $variables = array();

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
	 * @return Innova_Color_Patterns
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Colors.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->colors()->fonts()->gutter();

		if ( empty( $this->variables ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'print' ) );
	}

	/**
	 * Add inline style for variables.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function print() {
		$theme_vars  = '';
		$theme_vars .= '
			:root {
				--inv-text-color: ' . $this->variables['colors']['text'] . ';
				--inv-primary-color: ' . $this->variables['colors']['primary'] . ';
				--inv-secondary-color: ' . $this->variables['colors']['secondary'] . ';
				--inv-tertiary-color: ' . $this->variables['colors']['tertiary'] . ';
				--inv-offset-color: ' . $this->variables['colors']['offset'] . ';
				--inv-border-color: ' . $this->variables['colors']['border'] . ';
				--inv-body-font: ' . $this->variables['fonts']['body'] . ';
				--inv-heading-font: ' . $this->variables['fonts']['heading'] . ';
				--inv-gutter: ' . $this->variables['gutter']['base'] . ';
				--inv-gutter-full: ' . $this->variables['gutter']['full'] . ';
				--inv-gutter-half: ' . $this->variables['gutter']['half'] . ';
				--inv-gutter-expand-factor: ' . $this->variables['gutter']['expand-factor'] . ';
		}';

		wp_add_inline_style( 'innova-stylesheet', $theme_vars );
	}


	/**
	 * Colors.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function colors() {
		$this->variables['colors']['text']      = get_theme_mod( 'innova_text_color', '#242545' );
		$this->variables['colors']['primary']   = get_theme_mod( 'innova_primary_color', '#738ff4' );
		$this->variables['colors']['secondary'] = get_theme_mod( 'innova_secondary_color', '#fc346c' );
		$this->variables['colors']['tertiary']  = get_theme_mod( 'innova_tertiary_color', '#fccc6c' );
		$this->variables['colors']['offset']    = get_theme_mod( 'innova_offset_color', '#EFF5FC' );
		$this->variables['colors']['border']    = get_theme_mod( 'innova_border_color', '#DDDDDD' );

		return $this;
	}

	/**
	 * Fonts.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function fonts() {
		$this->variables['fonts']['body']    = '\'Poppins\', sans-serif';
		$this->variables['fonts']['heading'] = '\'Source Sans Pro\', sans-serif';

		return $this;
	}

	/**
	 * Gutter.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function gutter() {
		$this->variables['gutter']['base']          = '3.125em';
		$this->variables['gutter']['full']          = 'var(--inv-gutter)';
		$this->variables['gutter']['half']          = 'calc(var(--inv-gutter-full) / 2)';
		$this->variables['gutter']['expand-factor'] = 1.6;

		return $this;
	}
}
