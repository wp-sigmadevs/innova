<?php
/**
 * Breadcrumbs handler.
 * Renders the breadcrumbs for the theme.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Breadcrumbs Class.
 *
 * @since 1.0.0
 */
class Innova_Breadcrumbs {

	/**
	 * Current post object.
	 *
	 * @access private
	 * @var mixed
	 *
	 * @since 1.0.0
	 */
	private $post;

	/**
	 * Prefix for the breadcrumb.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $home_prefix;

	/**
	 * Separator between breadcrumbs list.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $delimiter;

	/**
	 * True if terms need to be displayed.
	 *
	 * @access private
	 * @var bool
	 *
	 * @since 1.0.0
	 */
	private $display_terms;

	/**
	 * Text for the "Home".
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $home_text;

	/**
	 * Prefix for category.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $cat_archive_prefix;

	/**
	 * Prefix for terms.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $tag_archive_prefix;

	/**
	 * Prefix for search page.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $search_prefix;

	/**
	 * Prefix for 404 page.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $error_prefix;

	/**
	 * True if Post type archive need to be displayed.
	 *
	 * @access private
	 * @var bool
	 *
	 * @since 1.0.0
	 */
	private $display_post_type_archive;

	/**
	 * Render markup.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $render_markup;

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
	 * @return Innova_Breadcrumbs
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
	 * Method to render breadcrumb markup.
	 *
	 * @access public
	 * @param array $args Breadcrumb args.
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function get_breadcrumbs( array $args ) {

		// Initialize object.
		$this->post = get_post( get_queried_object_id() );

		// Defaults.
		$defaults = array(
			'home_prefix'               => '',
			'delimiter'                 => '/',
			'display_post_type_archive' => (bool) true,
			'display_terms'             => (bool) true,
			'home_text'                 => sprintf( '<i class="fa fa-home"></i> <span>%s</span>', esc_attr__( 'Home', 'innova' ) ),
			'cat_archive_prefix'        => esc_attr__( 'Category:&nbsp;', 'innova' ),
			'tag_archive_prefix'        => esc_attr__( 'Tag:&nbsp;', 'innova' ),
			'search_prefix'             => esc_attr__( 'Search query for:&nbsp;', 'innova' ),
			'error_prefix'              => esc_attr__( '404 - Page not found', 'innova' ),
		);

		$defaults = apply_filters( 'innova_breadcrumbs_defaults', $defaults );
		$args     = wp_parse_args( $args, $defaults );

		$this->home_prefix               = $args['home_prefix'];
		$this->delimiter                 = $args['delimiter'];
		$this->display_post_type_archive = $args['display_post_type_archive'];
		$this->display_terms             = $args['display_terms'];
		$this->home_text                 = $args['home_text'];
		$this->cat_archive_prefix        = $args['cat_archive_prefix'];
		$this->tag_archive_prefix        = $args['tag_archive_prefix'];
		$this->search_prefix             = $args['search_prefix'];
		$this->error_prefix              = $args['error_prefix'];

		// Check if the Yoast SEO options is activated.
		$options = get_option( 'wpseo_titles' );

		// Check if the Yoast Breadcrumbs is activated.
		if ( function_exists( 'yoast_breadcrumb' ) && $options && true === $options['breadcrumbs-enable'] ) {
			// Yoast Breadcrumbs.
			ob_start();
			yoast_breadcrumb();
			$this->render_markup = ob_get_clean();
		} else {
			// Theme Breadcrumbs.
			$this->start_breadcrumb_rendering();
		}

		// Breadcrumb output.
		$this->breadcrumbs_wrapper()->breadcrumbs_output();
	}

	/**
	 * Start of Breadcrumbs Rendering.
	 *
	 * @access private
	 * @return void
	 *
	 * @since 1.0.0
	 */
	private function start_breadcrumb_rendering() {
		// Breadcrumb prefix.
		$this->render_markup = $this->get_breadcrumb_prefix();

		// Home text.
		$this->render_markup .= $this->get_breadcrumb_home();

		// Woocommerce support.
		if ( class_exists( 'WooCommerce' ) && ( ( Innova_helpers::inside_woocommerce() && is_archive() && ! is_shop() ) || is_cart() || is_checkout() || is_account_page() ) ) {
			$this->render_markup .= $this->get_woocommerce_page();
		}

		// Single Posts and Pages.
		if ( is_singular() ) {

			// If needed, display the archive breadcrumb.
			if ( isset( $this->post->post_type ) && get_post_type_archive_link( $this->post->post_type ) && $this->display_post_type_archive ) {
				$this->render_markup .= $this->get_post_type_archive();
			}

			// Check for parents.
			if ( isset( $this->post->post_parent ) && 0 == $this->post->post_parent ) {
				$this->render_markup .= $this->get_terms();
			} else {
				$this->render_markup .= $this->get_parents();
			}

			$this->render_markup .= $this->get_breadcrumb_trail_markup();
		} else {
			// Breadcrumb for Blog.
			if ( is_home() && ! is_front_page() ) {
				$posts_page           = get_option( 'page_for_posts' );
				$posts_page_title     = get_the_title( $posts_page );
				$this->render_markup .= $this->get_breadcrumb_list_item( $posts_page_title, '', false, false );
			} elseif ( ( is_tax() || is_tag() || is_category() || is_date() || is_author() ) && $this->display_post_type_archive && ! Innova_helpers::inside_woocommerce() ) {
				$this->render_markup .= $this->get_post_type_archive();
			}

			// Custom post types archives.
			if ( is_post_type_archive() ) {
				// Search in Custom Post Type Archive.
				if ( is_search() ) {
					$this->render_markup .= $this->get_post_type_archive();
					$this->render_markup .= $this->get_breadcrumb_trail_markup( 'search' );
				} else {
					$this->render_markup .= $this->get_post_type_archive( false );
				}
			} elseif ( is_tax() || is_tag() || is_category() ) {

				// Taxonomy Archives.
				if ( is_tag() ) {
					$this->render_markup .= $this->tag_archive_prefix;
				}
				// Category Archives.
				if ( is_category() ) {
					$this->render_markup .= $this->cat_archive_prefix;
				}
				$this->render_markup .= $this->get_taxonomies();
				$this->render_markup .= $this->get_breadcrumb_trail_markup( 'term' );
			} elseif ( is_date() ) {
				// Date Archives.
				global $wp_locale;
				$year = esc_html( get_query_var( 'year' ) );
				if ( ! $year ) {
					$year = substr( esc_html( get_query_var( 'm' ) ), 0, 4 );
				}

				// Year Archives.
				if ( is_year() ) {
					$this->render_markup .= $this->get_breadcrumb_trail_markup( 'year' );
				} elseif ( is_month() ) {
					// Month Archives.
					$this->render_markup .= $this->get_breadcrumb_list_item( $year, get_year_link( $year ) );
					$this->render_markup .= $this->get_breadcrumb_trail_markup( 'month' );
				} elseif ( is_day() ) {
					// Day Archives.
					global $wp_locale;

					$month = get_query_var( 'monthnum' );
					if ( ! $month ) {
						$month = substr( esc_html( get_query_var( 'm' ) ), 4, 2 );
					}

					$month_name           = $wp_locale->get_month( $month );
					$this->render_markup .= $this->get_breadcrumb_list_item( $year, get_year_link( $year ) );
					$this->render_markup .= $this->get_breadcrumb_list_item( $month_name, get_month_link( $year, $month ) );
					$this->render_markup .= $this->get_breadcrumb_trail_markup( 'day' );
				}
			} elseif ( is_author() ) {
				// Author Archives.
				$this->render_markup .= $this->get_breadcrumb_trail_markup( 'author' );
			} elseif ( is_search() ) {
				// Search Page.
				$this->render_markup .= $this->get_breadcrumb_trail_markup( 'search' );
			} elseif ( is_404() ) {
				// 404 Page.
				if ( Innova_helpers::inside_tribe_event() || ( is_post_type_archive( 'tribe_events' ) || ( Innova_helpers::inside_tribe_event() && is_archive() ) ) ) {
					$this->render_markup .= $this->get_breadcrumb_trail_markup( 'events' );
				} else {
					$this->render_markup .= $this->get_breadcrumb_trail_markup( '404' );
				}
			}
		}
	}

	/**
	 * Breadcrumbs Wrapper.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function breadcrumbs_wrapper() {
		$this->render_markup = '<nav class="breadcrumb">' . $this->render_markup . '</nav><!-- .breadcrumb -->';

		return $this;
	}

	/**
	 * Breadcrumbs Output Markup.
	 *
	 * @access private
	 * @return void
	 *
	 * @since 1.0.0
	 */
	private function breadcrumbs_output() {
		echo $this->render_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Breadcrumb prefix.
	 *
	 * @access private
	 * @return string
	 *
	 * @since 1.0.0
	 */
	private function get_breadcrumb_prefix() {
		$prefix = '';

		if ( ! is_front_page() ) {
			if ( $this->home_prefix ) {
				$prefix = '<span class="breadcrumb-prefix">' . $this->home_prefix . '</span>';
			}
		}

		return $prefix;
	}

	/**
	 * Home Text.
	 *
	 * @access private
	 * @return string
	 *
	 * @since 1.0.0
	 */
	private function get_breadcrumb_home() {
		$home_link = '';

		if ( ! is_front_page() ) {
			$home_link = $this->get_breadcrumb_list_item( $this->home_text, get_home_url() );
		} elseif ( is_home() ) {
			$home_link = $this->get_breadcrumb_list_item( 'Blog', '', true, true );
		}

		return $home_link;

	}

	/**
	 * Render Terms.
	 *
	 * @access private
	 * @return string
	 *
	 * @since 1.0.0
	 */
	private function get_terms() {
		$terms_markup = '';

		if ( ! $this->display_terms ) {
			return $terms_markup;
		}

		// Post terms.
		if ( 'post' == $this->post->post_type ) {
			$taxonomy = 'category';
		} elseif ( 'product' == $this->post->post_type && class_exists( 'WooCommerce' ) && Innova_Helpers::inside_woocommerce() ) {
			$taxonomy = 'product_cat';
		} elseif ( 'tribe_events' == $this->post->post_type ) {
			$taxonomy = 'tribe_events_cat';
		} else {
			return $terms_markup;
		}

		$terms = wp_get_object_terms( $this->post->ID, $taxonomy );

		if ( empty( $terms ) ) {
			return $terms_markup;
		}

		$terms_by_id = array();
		foreach ( $terms as $term ) {
			$terms_by_id[ $term->term_id ] = $term;
		}

		foreach ( $terms as $term ) {
			unset( $terms_by_id[ $term->parent ] );
		}

		if ( 1 === count( $terms_by_id ) ) {
			unset( $terms );
			$terms[0] = array_shift( $terms_by_id );
		}

		if ( 1 === count( $terms ) ) {

			$term_parent = $terms[0]->parent;

			if ( $term_parent ) {
				$term_tree   = get_ancestors( $terms[0]->term_id, $taxonomy );
				$term_tree   = array_reverse( $term_tree );
				$term_tree[] = get_term( $terms[0]->term_id, $taxonomy );

				foreach ( $term_tree as $term_id ) {
					$term_object   = get_term( $term_id, $taxonomy );
					$terms_markup .= $this->get_breadcrumb_list_item( $term_object->name, get_term_link( $term_object ) );
				}
			} else {
				$terms_markup = $this->get_breadcrumb_list_item( $terms[0]->name, get_term_link( $terms[0] ) );
			}
		} else {

			foreach ( $terms as $term ) {
				$term_parents[] = $term->parent;
			}

			if ( 1 === count( array_unique( $term_parents ) ) && $term_parents[0] ) {
				$term_tree = get_ancestors( $terms[0]->term_id, $taxonomy );
				$term_tree = array_reverse( $term_tree );

				foreach ( $term_tree as $term_id ) {
					$term_object   = get_term( $term_id, $taxonomy );
					$terms_markup .= $this->get_breadcrumb_list_item( $term_object->name, get_term_link( $term_object ) );
				}
			}

			$terms_markup .= $this->get_breadcrumb_list_item( $terms[0]->name, get_term_link( $terms[0] ), false );
			array_shift( $terms );

			$max_index = count( $terms );
			$i         = 0;
			foreach ( $terms as $term ) {
				if ( ++$i == $max_index ) {
					$terms_markup .= ', ' . $this->get_breadcrumb_list_item( $term->name, get_term_link( $term ), true, false );
				} else {
					$terms_markup .= ', ' . $this->get_breadcrumb_list_item( $term->name, get_term_link( $term ), false, false );
				}
			}
		}

		return $terms_markup;
	}

	/**
	 * Render Parents.
	 *
	 * @access private
	 * @return string
	 *
	 * @since 1.0.0
	 */
	private function get_parents() {
		$parents_markup = '';

		$parent_ids = array_reverse( get_post_ancestors( $this->post ) );

		foreach ( $parent_ids as $parent_id ) {
			$parent = get_post( $parent_id );

			if ( isset( $parent->post_title ) && isset( $parent->ID ) ) {
				$parents_markup .= $this->get_breadcrumb_list_item( apply_filters( 'the_title', $parent->post_title ), get_permalink( $parent->ID ) );
			}
		}

		return $parents_markup;
	}

	/**
	 * Render Term parents.
	 *
	 * @access private
	 * @return string
	 *
	 * @since 1.0.0
	 */
	private function get_taxonomies() {
		global $wp_query;
		$term         = $wp_query->get_queried_object();
		$terms_markup = '';

		// Check for hierarchical taxonomy and parents.
		if ( 0 != $term->parent && is_taxonomy_hierarchical( $term->taxonomy ) ) {
			$term_parents = get_ancestors( $term->term_id, $term->taxonomy );
			$term_parents = array_reverse( $term_parents );

			foreach ( $term_parents as $term_parent ) {
				$term_object   = get_term( $term_parent, $term->taxonomy );
				$terms_markup .= $this->get_breadcrumb_list_item( $term_object->name, get_term_link( $term_object->term_id, $term->taxonomy ) );
			}
		}

		return $terms_markup;
	}

	/**
	 * Render markup of a post type archive.
	 *
	 * @access private
	 * @param  string $linked Check for links.
	 * @return string The HTML markup of the post type archive.
	 *
	 * @since 1.0.0
	 */
	private function get_post_type_archive( $linked = true ) {
		global $wp_query;

		$link          = '';
		$archive_title = '';
		$delimiter     = false;

		$post_type = $wp_query->query_vars['post_type'];
		if ( ! $post_type ) {
			$post_type = get_post_type();
		}
		$post_type_object = get_post_type_object( $post_type );

		// Check if we have a post type object.
		if ( is_object( $post_type_object ) ) {

			// Woocommerce: archive name should be same as shop page name.
			if ( 'product' === $post_type ) {
				return $this->get_woocommerce_page( $linked );
			}

			// Use its name as fallback.
			$archive_title = $post_type_object->name;
			// Default case. Check if the post type has a non empty label.
			if ( isset( $post_type_object->label ) && '' !== $post_type_object->label ) {
				if ( 'post' === $post_type_object->name ) {
					$posts_page    = get_option( 'page_for_posts' );
					$archive_title = get_the_title( $posts_page );
				} else {
					$archive_title = $post_type_object->label;
				}
			} elseif ( isset( $post_type_object->labels->menu_name ) && '' !== $post_type_object->labels->menu_name ) {
				// Alternatively check for a non empty menu name.
				$archive_title = $post_type_object->labels->menu_name;
			}
		}

		// Check if the breadcrumb should be linked.
		if ( $linked ) {
			$link      = get_post_type_archive_link( $post_type );
			$delimiter = true;
		}

		return $this->get_breadcrumb_list_item( $archive_title, $link, $delimiter );
	}

	/**
	 * Render for Woocommerce.
	 *
	 * @access private
	 * @param  bool $linked Check for links.
	 * @return string The HTML markup of the woocommerce shop page.
	 *
	 * @since 1.0.0
	 */
	private function get_woocommerce_page( $linked = true ) {
		global $wp_query;

		$post_type        = 'product';
		$post_type_object = get_post_type_object( $post_type );
		$shop_page_markup = '';
		$link             = '';

		// Check if we are on a woocommerce page.
		if ( is_object( $post_type_object ) && class_exists( 'WooCommerce' ) && ( Innova_Helpers::inside_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
			$shop_page_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';

			if ( ! $shop_page_name ) {
				$shop_page_name = $post_type_object->labels->name;
			}

			// Check if the breadcrumb should be linked.
			if ( $linked ) {
				$link = get_post_type_archive_link( $post_type );
			}

			$delimiter = ! is_shop();

			if ( is_search() ) {
				$delimiter = true;
				$has_trail = false;
			}
			$shop_page_markup = $this->get_breadcrumb_list_item( $shop_page_name, $link, $delimiter, $has_trail );
		}

		return $shop_page_markup;
	}

	/**
	 * Adds the markup of the breadcrumb trail.
	 *
	 * @access private
	 * @param  string $object_type ID of the current query object.
	 * @return string The HTML markup of the breadcrumb trail.
	 *
	 * @since 1.0.0
	 */
	private function get_breadcrumb_trail_markup( $object_type = '' ) {
		global $wp_query, $wp_locale;

		switch ( $object_type ) {
			case 'term':
				$term  = $wp_query->get_queried_object();
				$title = $term->name;
				break;
			case 'year':
				$year = esc_html( get_query_var( 'year', 0 ) );
				if ( ! $year ) {
					$year = substr( esc_html( get_query_var( 'm' ) ), 0, 4 );
				}
				$title = esc_html__( 'Year: ', 'innova' ) . $year;
				break;
			case 'month':
				$monthnum = get_query_var( 'monthnum', 0 );
				if ( ! $monthnum ) {
					$monthnum = substr( esc_html( get_query_var( 'm' ) ), 4, 2 );
				}
				$title = esc_html__( 'Month: ', 'innova' ) . $wp_locale->get_month( $monthnum );
				break;
			case 'day':
				$day = get_query_var( 'day' );
				if ( ! $day ) {
					$day = substr( esc_html( get_query_var( 'm' ) ), 6, 2 );
				}
				$title = esc_html__( 'Day: ', 'innova' ) . $day;
				break;
			case 'author':
				$user = $wp_query->get_queried_object();
				if ( ! $user ) {
					$user = get_user_by( 'ID', $wp_query->query_vars['author'] );
				}
				$title = esc_html__( 'Articles Posted by&nbsp;', 'innova' ) . $user->display_name;
				break;
			case 'search':
				$title = $this->search_prefix . ' ' . esc_html( get_search_query() );
				break;
			case '404':
				$title = $this->error_prefix;
				break;
			case 'events':
				$title = tribe_get_events_title();
				break;
			default:
				$title = get_the_title( $this->post->ID );
				break;
		}

		return '<span class="breadcrumb-trail" property="v:title">' . $title . '</span>';
	}

	/**
	 * Adds the markup of a breadcrumb list item.
	 *
	 * @access private
	 * @param string $title     The title of the breadcrumb.
	 * @param string $link      The URL of the breadcrumb.
	 * @param bool   $delimiter Display breadcrumb delimiter.
	 * @param bool   $has_trail Trail markup.
	 * @return string           The HTML markup of a breadcrumb list item.
	 *
	 * @since 1.0.0
	 */
	private function get_breadcrumb_list_item( $title, $link = '', $delimiter = true, $has_trail = false ) {

		$microdata        = '';
		$microdata_url    = '';
		$delimiter_markup = '';
		$trail_markup     = '';

		// Setup the elements attributes.
		$microdata     = 'typeof="v:Breadcrumb"';
		$microdata_url = 'rel="v:url" property="v:title"';

		if ( $has_trail ) {
			$trail_markup = ' class="breadcrumb-trail"';
		}

		$breadcrumb_content = $trail_markup . $title;

		// Link markup.
		if ( $link ) {
			$breadcrumb_content = '<a ' . $microdata_url . ' href="' . $link . '">' . $breadcrumb_content . '</a>';
		}

		// If a delimiter should be added, do it.
		if ( $delimiter ) {
			$delimiter_markup = '<span class="breadcrumb-delimiter">' . $this->delimiter . '</span>';
		}

		return '<span ' . $microdata . '>' . $breadcrumb_content . '</span>' . $delimiter_markup;
	}
}
