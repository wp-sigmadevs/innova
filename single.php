<?php
/**
 * The template for displaying all single posts.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

get_header(); ?>

<div id="content" class="content-area">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
				<main id="primary" class="site-main">
					<div id="post-container">
						<?php
						while ( have_posts() ) {
							the_post();
							echo '<div class="row">';

							// The content template partial.
							get_template_part( 'views/content/content', get_post_format() );
							echo '</div>';

							if ( true === get_theme_mod( 'innova_single_pagination', false ) ) {
								echo '<div class="row pagination-container d-none d-md-flex">';
									echo '<div class="col-12">';
										// Post Pagination.
										innova_post_pagination();
									echo '</div>';
								echo '</div>';
							}

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								echo '<div class="row">';
									echo '<div class="col-12">';
										comments_template();
									echo '</div>';
								echo '</div>';
							}
						}
						?>
					</div>
				</main><!-- #primary -->
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-3">
				<aside id="secondary" class="widget-area">
					<?php
					get_sidebar();
					?>
				</aside><!-- #secondary -->
			</div>
		</div>
	</div>
</div><!-- #content -->

<?php
get_footer();
