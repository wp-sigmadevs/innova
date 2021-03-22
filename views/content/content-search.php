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

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		// The Post Thumbnail.
		innova_the_post_thumbnail( 'full' );

		the_title(
			sprintf(
				'<h2 class="entry-title"><a href="%s" rel="bookmark">',
				esc_url( get_permalink() )
			),
			'</a></h2>'
		);

		if ( 'post' === get_post_type() ) {
			?>
			<div class="entry-meta">
				<div class="meta-container">
					<?php innova_posted_on(); ?>
					<?php innova_posted_by(); ?>
					<?php innova_comments_meta(); ?>
				</div>
			</div>
			<?php
		}
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
			<a href="<?php the_permalink(); ?>"><?php echo esc_html__( 'Continue Reading', 'innova' ); ?></a>
		</div>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
