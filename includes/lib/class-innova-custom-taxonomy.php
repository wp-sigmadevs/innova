<?php
/**
 * Custom Taxonomy Library Class.
 *
 * This class is responsible for creating a Custom Taxonomy.
 *
 * @package Innova
 * @since   1.0.0
 */

/**
 * Custom Taxonomy Class.
 *
 * @since  1.0.0
 */
class Innova_Custom_Taxonomy {

	/**
	 * Taxonomy name.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var string
	 */
	public $taxonomy_name;

	/**
	 * Custom Post Type name.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var array
	 */
	public $post_type_name = array();

	/**
	 * Taxonomy slug.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var string
	 */
	public $taxonomy_slug;

	/**
	 * Taxonomy args.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var array
	 */
	public $taxonomy_args;

	/**
	 * Taxonomy labels.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var array
	 */
	public $taxonomy_labels;

	/**
	 * Class Constructor.
	 *
	 * Registers a custom taxonomy.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param string $name Taxonomy name.
	 * @param string $slug Taxonomy slug.
	 * @param array  $labels Taxonomy labels.
	 * @param array  $args Taxonomy args.
	 * @return void
	 */
	public function __construct( $name, $post_type, $slug, $labels = array(), $args = array() ) {
		$this->taxonomy_name   = self::uglify( $name );
		$this->post_type_name  = $post_type;
		$this->taxonomy_slug   = $slug;
		$this->taxonomy_args   = $args;
		$this->taxonomy_labels = $labels;

		// Register the taxonomy, if the taxonomy does not already exist.
		if ( ! taxonomy_exists( $this->taxonomy_name ) ) {
			// Registering the Custom Taxonomy.
			add_action( 'init', array( $this, 'register_taxonomy' ) );
		} else {
			// If the taxonomy already exists, attaching it to the post type.
			add_action( 'init', array( $this, 'attach_taxonomy' ) );
		}
	}

	/**
	 * Method to register the taxonomy.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_taxonomy() {

		// Capitalize the words and make it plural.
		$name      = self::beautify( $this->taxonomy_name );
		$plural    = self::pluralize( $name );
		$menu_name = strpos( $this->taxonomy_name, 'tag' ) !== false ? self::pluralize( 'Tag' ) : self::pluralize( 'Category' );

		// Setting the default labels.
		$labels = array_merge(
			// Defaults.
			array(
				/* translators: %s: taxonomy plural name */
				'name'              => sprintf( esc_html_x( '%s', 'taxonomy general name', 'innova' ), $plural ),
				/* translators: %s: taxonomy singular name */
				'singular_name'     => sprintf( esc_html_x( '%s', 'taxonomy singular name', 'innova' ), $name ),
				/* translators: %s: taxonomy plural name */
				'search_items'      => sprintf( esc_html__( 'Search %s', 'innova' ), $plural ),
				/* translators: %s: taxonomy plural name */
				'all_items'         => sprintf( esc_html__( 'All %s', 'innova' ), $plural ),
				/* translators: %s: taxonomy name */
				'parent_item'       => sprintf( esc_html__( 'Parent %s', 'innova' ), $name ),
				/* translators: %s: taxonomy name */
				'parent_item_colon' => sprintf( esc_html__( 'Parent %s:', 'innova' ), $name ),
				/* translators: %s: taxonomy name */
				'edit_item'         => sprintf( esc_html__( 'Edit %s', 'innova' ), $name ),
				/* translators: %s: taxonomy name */
				'update_item'       => sprintf( esc_html__( 'Update %s', 'innova' ), $name ),
				/* translators: %s: taxonomy name */
				'add_new_item'      => sprintf( esc_html__( 'Add New %s', 'innova' ), $name ),
				/* translators: %s: taxonomy name */
				'new_item_name'     => sprintf( esc_html__( 'New %s Name', 'innova' ), $name ),
				/* translators: %s: taxonomy modified name */
				'menu_name'         => sprintf( esc_html__( '%s', 'innova' ), $menu_name ),
			),
			// Given labels.
			$this->taxonomy_labels
		);

		// Setting the default arguments.
		$args = array_merge(
			// Defaults.
			array(
				'label'             => $plural,
				'labels'            => $labels,
				'hierarchical'      => strpos( $this->taxonomy_name, 'tag' ) !== false ? false : true,
				'public'            => true,
				'has_archive'       => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'show_ui'           => true,
				'show_in_nav_menus' => true,
				'rewrite'           => array(
					'slug' => $this->taxonomy_slug,
				),
			),
			// Given args.
			$this->taxonomy_args
		);

		// Register the taxonomy.
		register_taxonomy( $this->taxonomy_slug, $this->post_type_name, $args );
	}

	/**
	 * Method to attach the taxonomy.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function attach_taxonomy() {

		// Capitalize the words and make it plural.
		$name   = self::beautify( $this->taxonomy_name );
		$plural = self::pluralize( $name );

		// Register the taxonomy.
		register_taxonomy_for_object_type( $name, $this->post_type_name );
	}

	/**
	 * Method to beautify string.
	 *
	 * @access private
	 * @since  1.0.0
	 * @static
	 *
	 * @param string $string String to beautify.
	 * @return string
	 */
	private static function beautify( $string ) {
		return ucwords( str_replace( '_', ' ', $string ) );
	}

	/**
	 * Method to uglify string.
	 *
	 * @access private
	 * @since  1.0.0
	 * @static
	 *
	 * @param string $string String to uglify.
	 * @return string
	 */
	private static function uglify( $string ) {
		return strtolower( str_replace( ' ', '_', $string ) );
	}

	/**
	 * Method to Pluralize string.
	 *
	 * @access private
	 * @since  1.0.0
	 * @static
	 *
	 * @param string $string String to Pluralize.
	 * @return string
	 */
	private static function pluralize( $string ) {
		$last = $string[ strlen( $string ) - 1 ];

		if ( 'y' === $last ) {
			$cut = substr( $string, 0, -1 );
			// convert y to ies.
			$plural = $cut . 'ies';
		} elseif ( 's' === $last ) {
			return $string;
		} else {
			// just attach an s.
			$plural = $string . 's';
		}

		return $plural;
	}
}
