<?php
/**
 * Theme functions.
 * List of all custom template tags used globally on the theme.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! function_exists( 'innova_page_class' ) ) {
	/**
	 * Page Class.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_page_class() {
		$classes = array( 'site' );

		echo esc_attr( implode( ' ', $classes ) );
	}
}

if ( ! function_exists( 'innova_header_class' ) ) {
	/**
	 * Header Class.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_header_class() {
		$classes = array( 'site-header' );

		$classes[] = is_front_page() ? 'front-header' : 'inner-header';
		$classes[] = has_custom_logo() ? 'has-logo' : 'no-logo';
		$classes[] = has_nav_menu( 'primary_nav' ) ? 'has-menu' : 'no-menu';
		$classes[] = has_custom_header() ? 'background-image-center' : 'no-header-image';

		echo esc_attr( implode( ' ', $classes ) );
	}
}

if ( ! function_exists( 'innova_header_container' ) ) {
	/**
	 * Header Container Class.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_header_container() {
		$classes = array();

		$classes[] = true === get_theme_mod( 'innova_enable_100_header', false ) ? esc_attr( 'container-fluid' ) : esc_attr( 'container' );

		echo esc_attr( implode( ' ', $classes ) );
	}
}

if ( ! function_exists( 'innova_footer_container' ) ) {
	/**
	 * Footer Container Class.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_footer_container() {
		$classes = array();

		$classes[] = true === get_theme_mod( 'innova_enable_100_footer', false ) ? esc_attr( 'container-fluid' ) : esc_attr( 'container' );

		echo esc_attr( implode( ' ', $classes ) );
	}
}

if ( ! function_exists( 'innova_header_image' ) ) {
	/**
	 * Header Image.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_header_image() {
		if ( ! get_header_image() ) {
			return;
		}

		$header_image_url = get_header_image();

		echo 'style="background-image: url(' . esc_url( $header_image_url ) . ')"';
	}
}

if ( ! function_exists( 'innova_the_page_title' ) ) {
	/**
	 * Renders the page title.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_the_page_title() {
		if ( is_front_page() && is_home() ) {
			return;
		}

		$title = '';

		if ( is_home() ) {
			$title = get_theme_mod( 'innova_pagetitle_blog', __( 'Blog', 'innova' ) );
		} elseif ( is_archive() ) {
			$title = get_the_archive_title();
		} elseif ( is_search() ) {
			$title = __( 'Search results for', 'innova' ) . ' "' . get_search_query() . '"';
		} elseif ( is_404() ) {
			$title = __( 'Page Not Found', 'innova' );
		} else {
			global $post;
			$title = get_the_title( $post->ID );
		}

		echo wp_kses_post( $title );
	}
}

if ( ! function_exists( 'innova_classic_pagination' ) ) {
	/**
	 * Displays Classic Pagination.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_classic_pagination() {
		// Pagination Class Instance.
		$pagination = Innova_Pagination::get_instance();

		$prev = esc_html_x( '&laquo; Older Posts', 'Older Posts', 'innova' );
		$next = esc_html_x( 'Newer Posts &raquo;', 'Newer Posts', 'innova' );

		// Rendering Classic Pagination.
		$pagination->posts_nav( $prev, $next );
	}
}

if ( ! function_exists( 'innova_numbered_pagination' ) ) {
	/**
	 * Displays Numbered Pagination.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_numbered_pagination() {
		// Pagination Class Instance.
		$pagination = Innova_Pagination::get_instance();

		$prev = esc_html_x( '&laquo;', 'Older Posts', 'innova' );
		$next = esc_html_x( '&raquo;', 'Newer Posts', 'innova' );

		// Rendering Numbered Pagination.
		$pagination->numbered_posts_nav( $prev, $next );
	}
}

if ( ! function_exists( 'innova_post_pagination' ) ) {
	/**
	 * Displays Single Post Pagination.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_post_pagination() {
		// Pagination Class Instance.
		$pagination = Innova_Pagination::get_instance();

		$prev = esc_html_x( '&laquo;', 'Previous', 'innova' );
		$next = esc_html_x( '&raquo;', 'Next', 'innova' );

		// Rendering Single Post Pagination.
		$pagination->single_post_nav( $prev, $next );
	}
}

if ( ! function_exists( 'innova_the_post_thumbnail' ) ) {
	/**
	 * Displays the featured image.
	 *
	 * @param string $size Image size.
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function innova_the_post_thumbnail( $size = 'full' ) {
		if ( ! has_post_thumbnail() ) {
			return;
		}

		echo '<figure class="post-thumbnail">';
			echo ( ! is_single() ) ? '<a href="' . esc_url( get_the_permalink() ) . '">' : '';
				the_post_thumbnail( $size );
			echo ( ! is_single() ) ? '</a>' : '';
		echo '</figure>';
	}
}

if ( ! function_exists( 'innova_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 *
	 * @since 1.0.0
	 */
	function innova_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'innova' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'innova_posted_by' ) ) {
	/**
	 * Prints HTML with meta information for the current author.
	 *
	 * @since 1.0.0
	 */
	function innova_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'innova' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'innova_comments_meta' ) ) {
	/**
	 * Displays the Post comments meta.
	 *
	 * @since 1.0.0
	 */
	function innova_comments_meta() {
		$comments = '';

		if ( ! post_password_required() && ( comments_open() || 0 !== intval( get_comments_number() ) ) ) {
			$comments_number = get_comments_number_text( esc_html__( 'Click to Comment', 'innova' ), esc_html__( '1 Comment', 'innova' ), esc_html__( '% Comments', 'innova' ) );

			$comments = sprintf(
				'<span class="comments-link"><span class="screen-reader-text">%1$s</span><a href="%2$s">%3$s</a></span>',
				esc_html__( 'Posted comments', 'innova' ),
				esc_url( get_comments_link() ),
				$comments_number
			);
		}

		echo $comments; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'innova_posted_in' ) ) {
	/**
	 * Prints HTML with meta information for the current categories.
	 *
	 * @since 1.0.0
	 */
	function innova_posted_in() {
		$categories = get_the_category_list();

		return sprintf(
			'<span class="screen-reader-text">%1$s</span>%2$s',
			esc_html__( 'Posted in', 'innova' ),
			$categories
		);
	}
}

if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @since 1.0.0
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

if ( ! function_exists( 'innova_comment_form' ) ) {
	/**
	 * Display Comment Form.
	 *
	 * @since 1.0.0
	 */
	function innova_comment_form() {

		// Getting parameters for Comment Form.
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );
		$html5     = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
		$consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

		// Comment Form fields.
		$author = '<div class="row">' .
					'<div class="col-12 col-sm-12 col-md-4">' .
					'<div class="comment-form-author">' .
					'<fieldset>' .
					'<input id="author" name="author" type="text" placeholder="' . esc_html__( 'Name', 'innova' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />' .
					'</fieldset>' .
					'</div>' .
					'</div>';

		$email = '<div class="col-12 col-sm-12 col-md-4">' .
					'<div class="comment-form-email">' .
					'<fieldset>' .
					'<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" placeholder="' . esc_html__( 'Email', 'innova' ) . ( $req ? ' *' : '' ) . '" ' . $aria_req . ' />' .
					'</fieldset>' .
					'</div>' .
					'</div>';

		$url = '<div class="col-12 col-sm-12 col-md-4">' .
				'<div class="comment-form-url">' .
				'<fieldset>' .
				'<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . esc_html__( 'Website', 'innova' ) . '" size="30" />' .
				'</fieldset>' .
				'</div>' .
				'</div>';

		$cookies = '<div class="col-12 col-sm-12 col-md-12">' .
					'<div class="comment-form-cookies-consent">' .
					'<fieldset>' .
					'<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' /> ' .
					'<label class="form-check-label" for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment', 'innova' ) . '</label>' .
					'</fieldset>' .
					'</div>' .
					'</div>' .
					'</div>';

		$comment_field = '<div class="comment-form-comment">' .
						'<fieldset>' .
						'<textarea id="comment" placeholder="' . esc_html_x( 'Comment', 'noun', 'innova' ) . ( $req ? ' *' : '' ) . '" name="comment" cols="45" rows="8" aria-required="true"></textarea>' .
						'</fieldset>' .
						'</div>';

		// Building Comment Form args.
		$args = apply_filters(
			'innova_comment_form_args',
			array(
				'fields'               => apply_filters(
					'innova_comment_form_fields',
					array(
						'author'  => $author,
						'email'   => $email,
						'url'     => $url,
						'cookies' => $cookies,
					)
				),
				'comment_notes_before' => '',
				'comment_notes_after'  => '',
				'title_reply'          => esc_html__( 'Got Something To Say?', 'innova' ),
				'title_reply_to'       => esc_html__( 'Got Something To Say?', 'innova' ),
				'cancel_reply_link'    => esc_html__( 'Cancel Comment', 'innova' ),
				'comment_field'        => $comment_field,
				'label_submit'         => esc_html__( 'Submit Comment', 'innova' ),
				'id_submit'            => 'submit_comment',
				'class_submit'         => 'default-btn',
			)
		);

		// The Comment Form.
		comment_form( $args );
	}
}

if ( ! function_exists( 'innova_comment_callback' ) ) {
	/**
	 * Innova comment template.
	 *
	 * @param Object $comment the comment object.
	 * @param array  $args the comment args.
	 * @param int    $depth the comment depth.
	 * @since 1.0.0
	 */
	function innova_comment_callback( $comment, $args, $depth ) {
		?>
		<li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
			<div class="comment-body">
				<div class="comment-media d-flex">
					<?php
					if ( ! empty( get_avatar( $comment ) ) ) {
						?>
						<div class="comment-author vcard d-none d-sm-block">
							<?php
							echo get_avatar(
								$comment,
								$size    = '128',
								$default = '',
								$alt     = sprintf( '%1$s %2$s', esc_html__( 'Avatar for', 'innova' ), get_comment_author() )
							);
							?>
						</div><!-- .comment-author -->
						<?php
					}
					?>

					<div class="comment-content">
						<?php
						// Comment Author link.
						printf(
							wp_kses_post( '<cite class="fn">%s</cite>', 'innova' ),
							get_comment_author_link()
						);
						?>

						<div class="comment-text">
							<?php comment_text(); ?>
						</div>

						<?php
						if ( '0' === $comment->comment_approved ) {
							?>
							<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'innova' ); ?></em>
							<br />
							<?php
						}
						?>

						<div class="comment-meta commentmetadata flex-wrap">
							<a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>">
								<time datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>">
									<?php
									/* translators: 1: comment date, 2: comment time */
									printf( esc_html__( '%1$s at %2$s', 'innova' ), get_comment_date(), get_comment_time() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									?>
								</time>
							</a>
							<?php
							edit_comment_link( esc_html__( '(Edit)', 'innova' ), '  ', '' );
							?>

							<div class="comment-reply">
								<?php
								comment_reply_link(
									array_merge(
										$args,
										array(
											'depth'     => $depth,
											'max_depth' => $args['max_depth'],
										)
									)
								);
								?>
							</div>
						</div>
					</div><!-- .comment-content -->
				</div><!-- .comment-media -->
			</div><!-- .comment-body -->
		<?php
	}
}

if ( ! function_exists( 'innova_sanitize_hex' ) ) {
	/**
	 * Sanitizes hex colors.
	 *
	 * @param string $color The color code.
	 * @return string
	 * @since v1.0.0
	 */
	function innova_sanitize_hex( $color ) {
		if ( '' === $color ) {
			return '';
		}

		// Make sure the color starts with a hash.
		$color = '#' . ltrim( $color, '#' );

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}

		return null;
	}
}

if ( ! is_admin() && ! function_exists( 'get_field' ) ) {
	/**
	 * ACF fallback.
	 *
	 * @param string $key Meta key.
	 * @param int    $post_id Post ID.
	 * @param int    $format_value Formatted value.
	 * @return mixed
	 * @since v1.0.0
	 */
	function get_field( $key, $post_id = false, $format_value = true ) {
		if ( false === $post_id ) {
			global $post;
			$post_id = $post->ID;
		}

		return get_post_meta( $post_id, $key, true );
	}
}
