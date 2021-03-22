<?php
/**
 * Customizer Sections Class.
 * This Class registers Customizer Sections.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Customizer Sections Class.
 *
 * @since v1.0
 */
class Innova_Customizer_Sections {

	/**
	 * Customizer Sections.
	 *
	 * @access public
	 * @var array
	 * @since  1.0.0
	 */
	public $sections = array();

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
	 * @return Innova_Customizer_Sections
	 * @since  1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Customizer sections.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->set_sections()->add_sections();
	}

	/**
	 * Setting up sections.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function set_sections() {
		$this->sections['innova_header_styles'] = array(
			'title'       => esc_html__( 'Header Styles', 'innova' ),
			'description' => esc_html__( 'Header Style settings', 'innova' ),
			'panel'       => 'header_settings',
			'priority'    => 10,
		);

		$this->sections['innova_sticky_header'] = array(
			'title'       => esc_html__( 'Sticky Header', 'innova' ),
			'description' => esc_html__( 'Sticky header settings', 'innova' ),
			'panel'       => 'header_settings',
			'priority'    => 15,
		);

		$this->sections['innova_footer_styles'] = array(
			'title'       => esc_html__( 'Footer Styles', 'innova' ),
			'description' => esc_html__( 'footer style settings', 'innova' ),
			'panel'       => 'innova_footer_settings',
			'priority'    => 10,
		);

		$this->sections['innova_footer_copyright'] = array(
			'title'       => esc_html__( 'Footer Copyright', 'innova' ),
			'description' => esc_html__( 'footer copyright settings', 'innova' ),
			'panel'       => 'innova_footer_settings',
			'priority'    => 15,
		);

		$this->sections['innova_footer_copyright'] = array(
			'title'       => esc_html__( 'Footer Copyright', 'innova' ),
			'description' => esc_html__( 'footer copyright settings', 'innova' ),
			'panel'       => 'innova_footer_settings',
			'priority'    => 15,
		);

		$this->sections['innova_typography_body'] = array(
			'title'       => esc_html__( 'Body', 'innova' ),
			'description' => esc_html__( 'Specify the body typography.', 'innova' ),
			'panel'       => 'innova_typography_settings',
			'priority'    => 10,
		);

		$this->sections['innova_typography_nav'] = array(
			'title'       => esc_html__( 'Menu', 'innova' ),
			'description' => esc_html__( 'Specify the Navigation Menu typography.', 'innova' ),
			'panel'       => 'innova_typography_settings',
			'priority'    => 20,
		);

		$this->sections['innova_typography_h1'] = array(
			'title'       => esc_html__( 'Heading 1', 'innova' ),
			'description' => esc_html__( 'Specify h1 typography.', 'innova' ),
			'panel'       => 'innova_typography_settings',
			'priority'    => 30,
		);

		$this->sections['innova_typography_h2'] = array(
			'title'       => esc_html__( 'Heading 2', 'innova' ),
			'description' => esc_html__( 'Specify h2 typography.', 'innova' ),
			'panel'       => 'innova_typography_settings',
			'priority'    => 40,
		);

		$this->sections['innova_typography_h3'] = array(
			'title'       => esc_html__( 'Heading 3', 'innova' ),
			'description' => esc_html__( 'Specify h3 typography.', 'innova' ),
			'panel'       => 'innova_typography_settings',
			'priority'    => 50,
		);

		$this->sections['innova_typography_h4'] = array(
			'title'       => esc_html__( 'Heading 4', 'innova' ),
			'description' => esc_html__( 'Specify h4 typography.', 'innova' ),
			'panel'       => 'innova_typography_settings',
			'priority'    => 60,
		);

		$this->sections['innova_typography_h5'] = array(
			'title'       => esc_html__( 'Heading 5', 'innova' ),
			'description' => esc_html__( 'Specify h5 typography.', 'innova' ),
			'panel'       => 'innova_typography_settings',
			'priority'    => 70,
		);

		$this->sections['innova_typography_h6'] = array(
			'title'       => esc_html__( 'Heading 6', 'innova' ),
			'description' => esc_html__( 'Specify h6 typography.', 'innova' ),
			'panel'       => 'innova_typography_settings',
			'priority'    => 80,
		);

		$this->sections['innova_color_settings'] = array(
			'title'       => esc_html__( 'Colors', 'innova' ),
			'description' => esc_html__( 'Color scheme settings', 'innova' ),
			'panel'       => 'innova_texts_colors_settings',
			'priority'    => 10,
		);

		$this->sections['innova_pagetitle'] = array(
			'title'       => esc_html__( 'Page Title Banner', 'innova' ),
			'description' => esc_html__( 'Page title banner settings', 'innova' ),
			'panel'       => 'innova_page_settings',
			'priority'    => 10,
		);

		$this->sections['innova_breadcrumbs'] = array(
			'title'       => esc_html__( 'Breadcrumbs', 'innova' ),
			'description' => esc_html__( 'Breadcrumbs settings', 'innova' ),
			'panel'       => 'innova_page_settings',
			'priority'    => 15,
		);

		$this->sections['innova_page_styles'] = array(
			'title'       => esc_html__( 'Page Styles', 'innova' ),
			'description' => esc_html__( 'Page style settings', 'innova' ),
			'panel'       => 'innova_page_settings',
			'priority'    => 20,
		);

		$this->sections['innova_archive_settings'] = array(
			'title'       => esc_html__( 'Archives', 'innova' ),
			'description' => esc_html__( 'Archive settings', 'innova' ),
			'panel'       => 'innova_blog_settings',
			'priority'    => 10,
		);

		$this->sections['innova_single_settings'] = array(
			'title'       => esc_html__( 'Single Post', 'innova' ),
			'description' => esc_html__( 'Single post settings', 'innova' ),
			'panel'       => 'innova_blog_settings',
			'priority'    => 15,
		);

		$this->sections['innova_social_media'] = array(
			'title'       => esc_html__( 'Social Media', 'innova' ),
			'description' => esc_html__( 'Please add your social media profile information', 'innova' ),
			'panel'       => 'innova_settings',
			'priority'    => 20,
		);

		$this->sections['innova_integrations'] = array(
			'title'       => esc_html__( 'Integrations', 'innova' ),
			'description' => esc_html__( 'Integrations settings', 'innova' ),
			'panel'       => 'innova_settings',
			'priority'    => 25,
		);

		$this->sections['innova_extra_settings'] = array(
			'title'       => esc_html__( 'Extra', 'innova' ),
			'description' => esc_html__( 'Extra settings', 'innova' ),
			'panel'       => 'innova_settings',
			'priority'    => 30,
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
	private function add_sections() {
		if ( empty( $this->sections ) ) {
			return;
		}

		foreach ( $this->sections as $section_id => $section_args ) {
			Kirki::add_section( $section_id, $section_args );
		}
	}
}
