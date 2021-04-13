<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<article class="no-results not-found text-center">
	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) {
			?>
			<h5>
				<?php
				printf(
					/* translators: %s is Link to new post */
					esc_html__( 'Ready to publish your first post? %s.', 'innova' ),
					sprintf(
						/* translators: %1$s is Link to new post, %2$s is Get started here */
						'<a href="%1$s">%2$s</a>',
						esc_url( admin_url( 'post-new.php' ) ),
						esc_html__( 'Get started here', 'innova' )
					)
				);
				?>
			</h5>

			<?php
		} elseif ( is_search() ) {
			?>
			<h2><?php esc_html_e( 'Sorry, but nothing matched your search terms.', 'innova' ); ?></h2>
			<p><?php esc_html_e( 'Please use the menu above to locate what you are searching for. Or if you want to rephrase your query with a keyword, here is your chance:', 'innova' ); ?></p>
			<?php get_search_form(); ?>
			<?php
		} else {
			?>
			<h2><?php esc_html_e( 'Sorry, nothing found.', 'innova' ); ?></h2>
			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'innova' ); ?></p>
			<?php get_search_form(); ?>
			<?php
		}
		?>
	</div><!-- .page-content -->
</article><!-- .no-results -->
