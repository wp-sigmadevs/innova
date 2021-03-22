<?php
/**
 * Custom Post Type Library Class.
 *
 * This class is responsible for creating a Custom Post Type.
 *
 * @package Innova
 * @since   1.0.0
 */

/**
 * Custom Post Type Class.
 *
 * @since  1.0.0
 */
class Innova_Custom_Post_Type {

	/**
	 * Post type name.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var string
	 */
	public $post_type_name;

	/**
	 * Post type slug.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var string
	 */
	public $post_type_slug;

	/**
	 * Post type args.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var array
	 */
	public $post_type_args;

	/**
	 * Post type labels.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var array
	 */
	public $post_type_labels;

	/**
	 * Class Constructor.
	 *
	 * Registers a custom post type.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param string $name Post type name.
	 * @param string $slug Post type slug.
	 * @param array  $labels Post type labels.
	 * @param array  $args Post type args.
	 * @return void
	 */
	public function __construct( $name, $slug, $labels = array(), $args = array() ) {
		$this->post_type_name   = self::uglify( $name );
		$this->post_type_slug   = $slug;
		$this->post_type_args   = $args;
		$this->post_type_labels = $labels;

		// Register the post type, if the post type does not already exist.
		if ( ! post_type_exists( $this->post_type_name ) ) {

			// Registering the Custom Post Type.
			add_action( 'init', array( $this, 'register_post_type' ) );

			// Custom messages.
			add_filter( 'post_updated_messages', array( $this, 'messages' ) );

			// Custom Title placeholders.
			add_filter( 'enter_title_here', array( $this, 'placeholders' ), 0, 2 );
		}
	}

	/**
	 * Method to register the post type.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_post_type() {

		// Capitalize the words and make it plural.
		$name   = self::beautify( $this->post_type_name );
		$plural = self::pluralize( $name );

		// Setting the default labels.
		$labels = array_merge(
			// Defaults.
			array(
				/* translators: %s: post type plural name */
				'name'               => sprintf( esc_html_x( '%s', 'post type general name', 'innova' ), $plural ),
				/* translators: %s: post type singular name */
				'singular_name'      => sprintf( esc_html_x( '%s', 'post type singular name', 'innova' ), $name ),
				/* translators: %s: post type name */
				'add_new'            => sprintf( esc_html_x( 'Add New', '%s', 'innova' ), strtolower( $name ) ),
				/* translators: %s: post type name */
				'add_new_item'       => sprintf( esc_html__( 'Add New %s', 'innova' ), $name ),
				/* translators: %s: post type name */
				'edit_item'          => sprintf( esc_html__( 'Edit %s', 'innova' ), $name ),
				/* translators: %s: post type name */
				'new_item'           => sprintf( esc_html__( 'New %s', 'innova' ), $name ),
				/* translators: %s: post type plural name */
				'all_items'          => sprintf( esc_html__( 'All %s', 'innova' ), $plural ),
				/* translators: %s: post type name */
				'view_item'          => sprintf( esc_html__( 'View %s', 'innova' ), $name ),
				/* translators: %s: post type plural name */
				'search_items'       => sprintf( esc_html__( 'Search %s', 'innova' ), $plural ),
				/* translators: %s: post type plural name */
				'not_found'          => sprintf( esc_html__( 'No %s found', 'innova' ), strtolower( $plural ) ),
				/* translators: %s: post type plural name */
				'not_found_in_trash' => sprintf( esc_html__( 'No %s found in Trash', 'innova' ), strtolower( $plural ) ),
				/* translators: %s: post type plural name */
				'parent_item_colon'  => sprintf( esc_html__( 'Parent %s: ', 'innova' ), $plural ),
				'menu_name'          => $name,
			),
			// Given labels.
			$this->post_type_labels
		);

		// Setting the default arguments.
		$args = array_merge(
			// Defaults.
			array(
				'label'              => $plural,
				'labels'             => $labels,
				'menu_icon'          => 'dashicons-admin-customizer',
				'public'             => true,
				'show_ui'            => true,
				'has_archive'        => true,
				'publicly_queryable' => true,
				'query_var'          => true,
				'rewrite'            => true,
				'capability-type'    => 'post',
				'hierarchical'       => true,
				'show_in_rest'       => true,
				'supports'           => array(
					'title',
					'editor',
					'excerpt',
					'thumbnail',
				),
				'show_in_nav_menus'  => true,
				'menu_position'      => 30,
			),
			// Given args.
			$this->post_type_args
		);

		// Register the post type.
		register_post_type( $this->post_type_slug, $args );
	}

	/**
	 * Method to show custom messages.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param mixed $messages default messages.
	 * @return mixed modified messages.
	 */
	public function messages( $messages ) {
		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );
		$post_type_name   = self::beautify( $this->post_type_slug );

		$messages[ $this->post_type_slug ] = array(
			0  => '',
			/* translators: %s: post type name */
			1  => sprintf( esc_html__( '%s updated.', 'innova' ), $post_type_name ),
			2  => esc_html__( 'Custom field updated.', 'innova' ),
			3  => esc_html__( 'Custom field deleted.', 'innova' ),
			/* translators: %s: post type name */
			4  => sprintf( esc_html__( '%s updated.', 'innova' ), $post_type_name ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( esc_html__( '%1$s restored to revision from %2$s', 'innova' ), $post_type_name, wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			/* translators: %s: post type name */
			4  => sprintf( esc_html__( '%s published.', 'innova' ), $post_type_name ),
			/* translators: %s: post type name */
			4  => sprintf( esc_html__( '%s saved.', 'innova' ), $post_type_name ),
			/* translators: %s: post type name */
			4  => sprintf( esc_html__( '%s submitted.', 'innova' ), $post_type_name ),
			9  => sprintf(
				/* translators: Publish box date format. */
				__( '%1$s scheduled for: <strong>%2$s</strong>.', 'innova' ),
				$post_type_name,
				date_i18n( esc_html__( 'M j, Y @ G:i', 'innova' ), strtotime( $post->post_date ) )
			),
			/* translators: %s: post type name */
			10 => sprintf( esc_html__( '%s draft updated.', 'innova' ), $post_type_name ),
		);

		if ( $post_type_object->publicly_queryable && $this->post_type_slug === $post_type ) {
			$permalink = get_permalink( $post->ID );

			/* translators: %s: URL of View Post & Name of the Custom Post Type */
			$view_link                  = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), sprintf( esc_html__( 'View ', 'innova' ), $post_type_name ) );
			$messages[ $post_type ][1] .= $view_link;
			$messages[ $post_type ][6] .= $view_link;
			$messages[ $post_type ][9] .= $view_link;

			/* translators: %s: URL of Preview Post & Name of the Custom Post Type */
			$preview_permalink           = add_query_arg( 'preview', 'true', $permalink );
			$preview_link                = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), sprintf( esc_html__( 'Preview ', 'innova' ), $post_type_name ) );
			$messages[ $post_type ][8]  .= $preview_link;
			$messages[ $post_type ][10] .= $preview_link;
		}

		return $messages;
	}

	/**
	 * Method to show custom title placeholders.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param mixed $title default title.
	 * @param mixed $post post object.
	 * @return mixed modified placeholder.
	 */
	public function placeholders( $title, $post ) {
		$post_type_name = $this->post_type_slug;
		$name           = self::beautify( $post_type_name );

		if ( $post_type_name === $post->post_type ) {
			/* translators: post type name */
			$new_title = sprintf( esc_html__( 'Enter %s Title', 'innova' ), $name );
			return $new_title;
		}

		return $title;
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
