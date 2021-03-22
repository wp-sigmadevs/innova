<?php
/**
 * Custom Post Types initiator.
 *
 * This class registers custom post types required for Innova Theme.
 *
 * @package Innova
 * @since   1.0.0
 */

/**
 * Custom Post Type Controller Class.
 *
 * @since  1.0.0
 */
class Innova_Post_Types {

	/**
	 * Accumulates Custom Post Types.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @var array
	 */
	public $custom_post_types = array();

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
	 *
	 * @since 1.0.0
	 */
	public static $instance = null;

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @return Innova_Post_Types
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
	 * Method to register CPT.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function register() {
		$this->define_cpt();

		if ( ! empty( $this->custom_post_types ) ) {
			$this->register_custom_post_types();
		}
	}

	/**
	 * Method to define CPT.
	 *
	 * @since  1.0.0
	 * @access private
	 *
	 * @return array
	 */
	private function define_cpt() {
		$this->custom_post_types = array(
			array(
				'name'   => __( 'Gallery', 'innova' ),
				'slug'   => 'innova_gallery',
				'labels' => array(
					'all_items' => __( 'All Galleries', 'innova' ),
				),
				'args'   => array(
					'menu_icon'          => 'dashicons-format-gallery',
					'publicly_queryable' => false,
					'has_archive'        => false,
					'supports'           => array(
						'title',
					),
				),
			),

			array(
				'name'   => __( 'Testimonials', 'innova' ),
				'slug'   => 'innova_testimonial',
				'labels' => array(
					'all_items' => __( 'All Testimonials', 'innova' ),
				),
				'args'   => array(
					'publicly_queryable' => false,
					'has_archive'        => false,
					'supports'           => array(
						'title',
						'thumbnail',
					),
				),
			),
		);

		return $this->custom_post_types;
	}

	/**
	 * Method to loop through all the CPT definition and build up CPT.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function register_custom_post_types() {
		foreach ( $this->custom_post_types as $post_type ) {
			new Innova_Custom_Post_Type(
				$post_type['name'],
				$post_type['slug'],
				! empty( $post_type['labels'] ) ? $post_type['labels'] : array(),
				! empty( $post_type['args'] ) ? $post_type['args'] : array()
			);
		}
	}
}
