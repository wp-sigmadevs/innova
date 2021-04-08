<?php
/**
 * Pagination handler.
 * Renders the various pagination for the theme.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Pagination Class.
 *
 * @since v1.0.0
 */
class Innova_Pagination {

	/**
	 * Render Nav.
	 *
	 * @var string
	 * @access private
	 *
	 * @since 1.0.0
	 */
	private $render_nav = '';

	/**
	 * Custom query.
	 *
	 * @var object
	 * @access private
	 *
	 * @since 1.0.0
	 */
	private $custom = null;

	/**
	 * Posts Previous Text.
	 *
	 * @var string
	 * @access private
	 *
	 * @since 1.0.0
	 */
	private $prev_text;

	/**
	 * Posts Next Text.
	 *
	 * @var string
	 * @access private
	 *
	 * @since 1.0.0
	 */
	private $next_text;

	/**
	 * Posts Previous Link.
	 *
	 * @var string
	 * @access private
	 *
	 * @since 1.0.0
	 */
	private $prev_link;

	/**
	 * Posts Next Link.
	 *
	 * @var string
	 * @access private
	 *
	 * @since 1.0.0
	 */
	private $next_link;

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
	 * @return Innova_Pagination
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
	 * Method to render posts pagination markup.
	 *
	 * @access public
	 * @param string $prev Previous Text.
	 * @param string $next Next Text.
	 * @param string $type Type of Pagination.
	 * @param string $custom Custom Object.
	 * @return string The HTML markup of pagination.
	 *
	 * @since 1.0.0
	 */
	public function posts_nav( string $prev = '', string $next = '', string $type = 'posts', $custom = null ) {

		// Previous & Next text.
		$this->prev_text = $prev;
		$this->next_text = $next;

		// Custom query.
		$this->custom = $custom;

		// Previous & Next link.
		$this->prev_link = get_next_posts_link( $this->prev_text );
		$this->next_link = ( null !== $this->custom ) ? get_previous_posts_link( $this->next_text, $this->custom->max_num_pages ) : get_previous_posts_link( $this->next_text );

		// Return if empty.
		if ( empty( $this->prev_link ) && empty( $this->next_link ) ) {
			return $this;
		}

		// Rendering Pagination.
		$this->start_post_nav_render()->render_final_output( $type );
	}

	/**
	 * Method to render numbered posts pagination markup.
	 *
	 * @access public
	 * @param string $prev Previous Text.
	 * @param string $next Next Text.
	 * @param string $type Type of Pagination.
	 * @param string $custom Custom Object.
	 * @return string The HTML markup of pagination.
	 *
	 * @since 1.0.0
	 */
	public function numbered_posts_nav( string $prev = '', string $next = '', string $type = 'numbered_posts', $custom = null ) {

		// Custom query.
		$this->custom = $custom;

		// Preious & Next text.
		$this->prev_text = $prev;
		$this->next_text = $next;

		// Rendering Pagination.
		$this->start_numbered_posts_nav_render()->render_final_output( $type );
	}

	/**
	 * Method to render single post pagination markup.
	 *
	 * @access public
	 * @param string $prev Previous Text.
	 * @param string $next Next Text.
	 * @param bool   $title Show title.
	 * @param string $type Type of Pagination.
	 * @return string  The HTML markup of single post pagination.
	 *
	 * @since 1.0.0
	 */
	public function single_post_nav( string $prev = '', string $next = '', bool $title = true, string $type = 'single_post' ) {

		// If title is needed.
		$title = ( $title ) ? '%title' : '';

		// Previous & Next text.
		$this->prev_text = sprintf( '%s %2$s', $prev, $title );
		$this->next_text = sprintf( '%2$s %s', $next, $title );

		// Previous & Next link.
		$this->prev_link = get_previous_post_link( '%link', $this->prev_text );
		$this->next_link = get_next_post_link( '%link', $this->next_text );

		// Bail if empty.
		if ( empty( $this->prev_link ) && empty( $this->next_link ) ) {
			return $this;
		}

		// Rendering Pagination.
		$this->start_post_nav_render()->render_final_output( $type );
	}

	/**
	 * Start of pagination Rendering.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function start_post_nav_render() {

		// Screen reader text.
		$this->render_nav .= $this->screen_reader_text();

		// Posts nav.
		$this->render_nav .= '<div class="nav-links pagination classic justify-content-between">';
		if ( $this->prev_link ) {
			$this->render_nav .= '<div class="nav-previous">' . $this->prev_link . '</div>';
		}

		if ( $this->next_link ) {
			$this->render_nav .= '<div class="nav-next">' . $this->next_link . '</div>';
		}
		$this->render_nav .= '</div><!-- .nav-links -->';

		return $this;
	}

	/**
	 * Start of numbered pagination Rendering.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function start_numbered_posts_nav_render() {
		global $wp_query;

		// Stop execution if there's only 1 page.
		if ( ( ( null !== $this->custom ) ? $this->custom->max_num_pages : $wp_query->max_num_pages ) <= 1 ) {
			return $this;
		}

		$current    = max( 1, absint( get_query_var( 'paged' ) ) );
		$pagination = paginate_links(
			array(
				'base'      => str_replace( PHP_INT_MAX, '%#%', esc_url( get_pagenum_link( PHP_INT_MAX ) ) ),
				'format'    => '?paged=%#%',
				'current'   => $current,
				'total'     => ( null !== $this->custom ) ? $this->custom->max_num_pages : $wp_query->max_num_pages,
				'type'      => 'array',
				'prev_text' => $this->prev_text,
				'next_text' => $this->next_text,
			)
		);

		if ( empty( $pagination ) ) {
			return $this;
		}

		// Screen reader text.
		$this->render_nav .= $this->screen_reader_text();

		// Numbered Posts nav.
		$this->render_nav .= '<ul class="pagination numbered mb-0 justify-content-center">';
		foreach ( $pagination as $key => $page_link ) {
			$this->render_nav     .= '<li class="page-item paginated_link' . esc_attr( ( false !== strpos( $page_link, 'current' ) ) ? ' active' : '' ) . '">';
				$this->render_nav .= $page_link;
			$this->render_nav     .= '</li>';
		}
		$this->render_nav .= '</ul><!-- .pagination -->';

		return $this;
	}

	/**
	 * Screen reader text.
	 *
	 * @access private
	 * @return string
	 *
	 * @since 1.0.0
	 */
	private function screen_reader_text() {
		return '<h2 class="screen-reader-text">' . esc_html__( 'Post navigation', 'innova' ) . '</h2>';
	}

	/**
	 * Pagination Wrapper.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function nav_wrapper() {
		$this->render_nav = '<nav id="post-navigation" class="navigation post-navigation" aria-label="' . esc_html__( 'Post navigation', 'innova' ) . '">' . $this->render_nav . '</nav><!-- #post-navigation -->';

		return $this;
	}

	/**
	 * Pagination Output Markup.
	 *
	 * @access private
	 * @param string $type Nav type.
	 * @return void
	 *
	 * @since 1.0.0
	 */
	private function output_nav( string $type ) {
		echo apply_filters( "innova_{$type}_nav", $this->render_nav ); // phpcs:ignore WordPress.Security.EscapeOutput
	}

	/**
	 * Pagination Output Final Markup.
	 *
	 * @access private
	 * @param string $type Nav type.
	 * @return void
	 *
	 * @since 1.0.0
	 */
	private function render_final_output( string $type ) {

		// Final Markup Output.
		$this->nav_wrapper()->output_nav( $type );
	}
}
