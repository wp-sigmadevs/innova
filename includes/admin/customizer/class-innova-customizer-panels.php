<?php
/**
 * Customizer Panels Class.
 * This Class registers Customizer Panels.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Customizer Panels Class.
 *
 * @since v1.0
 */
class Innova_Customizer_Panels {

	/**
	 * Customizer Panels.
	 *
	 * @access public
	 * @var array
	 * @since  1.0.0
	 */
	public $panels = array();

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
	 * @return Innova_Customizer_Panels
	 * @since  1.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Customizer panels.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->set_panels()->add_panels();
	}

	/**
	 * Setting up panels.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function set_panels() {
		$this->panels['innova_settings'] = array(
			'priority'    => 10,
			'title'       => esc_html__( 'Theme Options', 'innova' ),
			'description' => esc_html__( 'Theme options & settings', 'innova' ),
		);

		$this->panels['innova_general_settings'] = array(
			'priority'    => 10,
			'title'       => esc_html__( 'General', 'innova' ),
			'description' => esc_html__( 'General settings', 'innova' ),
			'panel'       => 'innova_settings',
		);

		$this->panels['header_settings'] = array(
			'priority'    => 11,
			'title'       => esc_html__( 'Header', 'innova' ),
			'description' => esc_html__( 'Logo and page-title settings', 'innova' ),
			'panel'       => 'innova_settings',
		);

		$this->panels['innova_footer_settings'] = array(
			'priority'    => 12,
			'title'       => esc_html__( 'Footer', 'innova' ),
			'description' => esc_html__( 'Footer settings', 'innova' ),
			'panel'       => 'innova_settings',
		);

		$this->panels['innova_texts_colors_settings'] = array(
			'priority'    => 13,
			'title'       => esc_html__( 'Texts & Colors', 'innova' ),
			'description' => esc_html__( 'Typography & Color settings', 'innova' ),
			'panel'       => 'innova_settings',
		);

		$this->panels['innova_typography_settings'] = array(
			'priority'    => 10,
			'title'       => esc_html__( 'Typography', 'innova' ),
			'description' => esc_html__( 'Typography settings', 'innova' ),
			'panel'       => 'innova_texts_colors_settings',
		);

		$this->panels['innova_page_settings'] = array(
			'priority'    => 14,
			'title'       => esc_html__( 'Page', 'innova' ),
			'description' => esc_html__( 'Page settings', 'innova' ),
			'panel'       => 'innova_settings',
		);

		$this->panels['innova_blog_settings'] = array(
			'priority'    => 15,
			'title'       => esc_html__( 'Blog', 'innova' ),
			'description' => esc_html__( 'Archives and single post settings', 'innova' ),
			'panel'       => 'innova_settings',
		);

		return $this;
	}

	/**
	 * Adding panels with the help of Kirki.
	 *
	 * @access private
	 * @return void
	 *
	 * @since 1.0.0
	 */
	private function add_panels() {
		if ( empty( $this->panels ) ) {
			return;
		}

		foreach ( $this->panels as $panel_id => $panel_args ) {
			Kirki::add_panel( $panel_id, $panel_args );
		}
	}
}
