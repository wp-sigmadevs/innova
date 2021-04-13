<?php
/**
 * Template part for displaying results in search pages.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<div class="col-12 col-lg-12">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-half pb-half post-item' ); ?>>
		<header class="entry-header">
			<?php
			the_title(
				sprintf(
					'<h2 class="entry-title"><a href="%s" rel="bookmark">',
					esc_url( get_permalink() )
				),
				'</a></h2>'
			);
			?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<div class="post-content">
				<?php
				the_excerpt();
				?>
			</div><!-- .post-content -->
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<div class="more-link">
				<a href="<?php the_permalink(); ?>" class="inv-btn primary"><?php echo esc_html__( 'Continue Reading', 'innova' ); ?></a>
			</div>
		</footer><!-- .entry-footer -->
	</article><!-- #post-## -->
</div>
