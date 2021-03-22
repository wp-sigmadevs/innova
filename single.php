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
					<?php
					while ( have_posts() ) {
						the_post();

						// The content template partial.
						get_template_part( 'views/content/content', get_post_format() );

						if ( true === get_theme_mod( 'innova_single_pagination', false ) ) {
							// Post Pagination.
							innova_post_pagination();
						}

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
					}
					?>
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
