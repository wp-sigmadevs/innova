<?php
/**
 * Customizer Class.
 * This Class uses Kirki class to register Customizer controls.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Customizer Class.
 *
 * @since v1.0
 */
class Innova_Customizer {

	/**
	 * Kirki Configuration ID.
	 *
	 * @access public
	 * @var string
	 * @since  1.0.0
	 */
	public $config_id;

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
	 * @return Innova_Customizer
	 * @since  1.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Customizer Controls.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {

		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}

		$this->base      = Innova_Base::get_instance();
		$this->config_id = 'innova_theme';

		// Setup kirki.
		add_action( 'init', array( $this, 'setup' ) );

		// // Modifying existing controls.
		add_action( 'customize_register', array( $this, 'modify_controls' ) );

		// // Disable kirki Custom Loader.
		add_filter( 'kirki/config', array( $this, 'disable_loader' ) );

		// // Selective refresh js.
		add_action( 'customize_preview_init', array( $this, 'selective_refresh' ) );

		// // Customizer css.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_css' ) );
	}

	/**
	 * Store all the customizer classes.
	 *
	 * @access private
	 * @return array
	 *
	 * @since 1.0.0
	 */
	private function get_classes() {
		$classes = array(
			Innova_Customizer_Panels::class,
			Innova_Customizer_Sections::class,
			Innova_Customizer_Controls::class,
		);

		return $classes;
	}

	/**
	 * Method to register the services.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function services() {
		foreach ( $this->get_classes() as $service ) {
			$this->base::require_service( $service );
		}

		return $this;
	}

	/**
	 * Setup Kirki.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function setup() {
		$args = array(
			'capability'  => 'edit_theme_options',
			'option_type' => 'theme_mod',
		);

		$this->services();

		Kirki::add_config( $this->config_id, $args );
	}

	/**
	 * Modifying existong controls.
	 *
	 * @access public
	 * @param object $wp_customize An instance of the WP_Customize_Manager class.
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function modify_controls( $wp_customize ) {

		// Moving background color setting alongside background image.
		$wp_customize->get_control( 'background_color' )->section  = 'background_image';
		$wp_customize->get_control( 'background_color' )->priority = 20;

		$wp_customize->get_control( 'header_textcolor' )->section  = 'header_image';
		$wp_customize->get_control( 'header_textcolor' )->priority = 11;

		// Changing some default titles.
		$wp_customize->get_section( 'background_image' )->title = esc_html__( 'Site Background', 'innova' );
		$wp_customize->get_section( 'title_tagline' )->title    = esc_html__( 'Logo / Title / Favicon', 'innova' );
		$wp_customize->get_section( 'title_tagline' )->priority = 8;
		$wp_customize->get_section( 'header_image' )->title     = esc_html__( 'Header Background', 'innova' );
		$wp_customize->get_section( 'header_image' )->priority  = 10;

		// Moving some general section.
		$wp_customize->get_section( 'static_front_page' )->panel = 'innova_general_settings';
		$wp_customize->get_section( 'title_tagline' )->panel     = 'header_settings';
		$wp_customize->get_section( 'background_image' )->panel  = 'innova_general_settings';
		$wp_customize->get_section( 'header_image' )->panel      = 'header_settings';

		// Moving control description.
		$wp_customize->get_control( 'custom_logo' )->description = esc_html__( 'Recommended image size is 180x180 px.', 'innova' );

		// Selective refresh.
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => 'header .site-title',
				'render_callback' => function () {
					bloginfo( 'name' );
				},
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => 'header .site-description',
				'render_callback' => function () {
					bloginfo( 'description' );
				},
			)
		);
	}

	/**
	 * Disabling Kirki Loader.
	 *
	 * @access public
	 * @param array $config Kirki configuration.
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function disable_loader( $config ) {
		return wp_parse_args(
			array(
				'disable_loader' => true,
			),
			$config
		);
	}

	/**
	 * JS for Live Preview.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function selective_refresh() {
		wp_enqueue_script( 'innova-customizer-script', $this->base->get_js_uri() . 'admin/customize-preview.js', array( 'customize-preview', 'jquery' ), $this->base->get_theme_version(), true );
	}

	/**
	 * Customizer CSS.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function enqueue_css() {
		wp_enqueue_style( 'innova-customizer-styles', $this->base->get_css_uri() . 'admin/customizer.css', array(), $this->base->get_theme_version(), 'all' );
	}
}
