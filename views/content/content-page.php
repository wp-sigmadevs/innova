<?php
/**
 * The template used for displaying page content in page.php.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<article id="page-<?php the_ID(); ?>" <?php post_class( array( 'page-entry-content' ) ); ?>>
	<div class="entry-content">
		<?php
		the_content();

		// This section is for pagination purpose for a long large page that is separated using nextpage tags.
		$args = array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'innova' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'innova' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		);
		wp_link_pages( $args );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
