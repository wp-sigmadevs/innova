<?php
/**
 * Template Name: Foggy Memories
 * Template Post Type: post, page, product
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
			<div class="col-12 col-sm-12 col-md-12">
				<main id="primary" class="site-main">
					<?php
					if ( have_posts() ) {

						// The Loop template partial.
						get_template_part( 'loop' );
					} else {

						// Template partial for no content.
						get_template_part( 'views/content/content', 'none' );
					}
					?>
				</main><!-- #primary -->
			</div>
		</div>
	</div>
</div><!-- #content -->

<?php
get_footer();
