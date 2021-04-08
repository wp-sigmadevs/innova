<?php
/**
 * The template for displaying search results pages.
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
			<div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
				<main id="primary" class="site-main">
					<div id="posts-container" class="row">
						<?php
						if ( have_posts() ) {

							// The Loop template partial.
							get_template_part( 'loop' );
						} else {

							// Template partial for no content.
							get_template_part( 'views/content/content', 'none' );
						}
						?>
					</div>

					<div class="nav-container">
						<?php
						// Posts Pagination.
						if ( 'classic' === get_theme_mod( 'innova_archive_pagination', 'classic' ) ) {
							innova_classic_pagination();
						} else {
							innova_numbered_pagination();
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
