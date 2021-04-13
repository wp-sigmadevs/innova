<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

get_header();
?>

<div id="content" class="content-area">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
				<main id="primary" class="site-main">
					<div class="error-404 not-found text-center">
						<div class="page-content">
							<article>
								<h2><?php esc_html_e( 'Sorry, the page you are looking for does not exist, have been removed, name changed or is temporarity unavailable.', 'innova' ); ?></h2>
								<p><?php esc_html_e( 'Please use the menu above to locate what you are searching for. Or you can try searching with a keyword below:', 'innova' ); ?></p>
								<?php get_search_form(); ?>
							</article>
						</div><!-- .page-content -->
					</div><!-- .error-404 -->

				</main><!-- #primary -->
			</div>
		</div>
	</div>
</div><!-- #content -->

<?php
get_footer();
