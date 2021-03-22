<?php
/**
 * The Widget class.
 * We're using this one to register various widget locations.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Widgets class.
 *
 * @since 1.0.0
 */
class Innova_Widgets {

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
	 * @return Innova_Widgets
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
	 * Registering Widgets.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action( 'widgets_init', array( $this, 'locations' ) );
	}

	/**
	 * Widgets Locations.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function locations() {
		$this->sidebar();
		$this->footer();
	}

	/**
	 * Widgets: Sidebar.
	 *
	 * @access private
	 * @return void
	 *
	 * @since 1.0.0
	 */
	private function sidebar() {
		self::register_widget_area(
			array(
				'name'        => esc_html__( 'Sidebar (General)', 'innova' ),
				'id'          => esc_attr( 'innova-sidebar-general' ),
				'description' => esc_html__( 'This sidebar will show everywhere the sidebar is enabled, both Posts and Pages.', 'innova' ),
			)
		);

		self::register_widget_area(
			array(
				'name'        => esc_html__( 'Sidebar (Blog)', 'innova' ),
				'id'          => esc_attr( 'innova-sidebar-blog' ),
				'description' => esc_html__( 'This sidebar will show in Blog (Posts) page.', 'innova' ),
			)
		);

		if ( Innova_Helpers::has_woocommerce() ) {
			self::register_widget_area(
				array(
					'name'        => esc_html__( 'Sidebar (Shop)', 'innova' ),
					'id'          => esc_attr( 'innova-sidebar-shop' ),
					'description' => esc_html__( 'This sidebar will show in shop page.', 'innova' ),
				)
			);
		}
	}

	/**
	 * Widgets: Footer.
	 *
	 * @access private
	 * @return void
	 *
	 * @since 1.0.0
	 */
	private function footer() {
		for ( $footer_col = 1; $footer_col <= 4; $footer_col++ ) {
			self::register_widget_area(
				array(
					'name'          => esc_html__( 'Footer', 'innova' ) . ' - ' . esc_attr( $footer_col ),
					'id'            => esc_attr( 'innova-footer-col-' ) . esc_attr( $footer_col ),
					'description'   => esc_html__( 'The widget area for the footer column', 'innova' ) . ' - ' . esc_attr( $footer_col ),
					'before_widget' => '<aside id="%1$s" class="%2$s footer-widget">',
					'after_widget'  => '</aside>',
				)
			);
		}
	}

	/**
	 * Method to expedite the widget area registration process.
	 *
	 * @access public
	 * @param array $args Widget arguments.
	 * @return mixed
	 *
	 * @since 1.0.0
	 */
	public static function register_widget_area( array $args ) {

		$defaults = array(
			'before_widget' => '<section id="%1$s" class="%2$s sidebar-widget">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title widgettitle">',
			'after_title'   => '</h4>',
		);

		$defaults = apply_filters( 'innova_widget_area_defaults', $defaults, $args );

		$args = wp_parse_args( $args, $defaults );

		return register_sidebar( $args );
	}
}
