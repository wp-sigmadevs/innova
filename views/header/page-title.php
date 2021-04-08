<?php
/**
 * Displays the page title.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$breadcrumbs = Innova_Breadcrumbs::get_instance();
?>

<div id="page-title" class="page-title image-in-bg size-cover">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-12 col-sm-12 col-md-6 col-lg-7">
				<h1><?php innova_the_page_title(); ?></h1>
			</div>
			<div class="col-12 col-sm-12 col-md-6 col-lg-5">
				<?php
				if ( get_theme_mod( 'innova_enable_breadcrumbs', false ) ) {
					// Breadcrumbs.
					$breadcrumbs->get_breadcrumbs(
						array(
							'home_prefix'        => get_theme_mod( 'innova_breadcrumbs_prefix', '' ),
							'delimiter'          => get_theme_mod( 'innova_breadcrumbs_separator', '<i class="fa fa-angle-right"></i>' ),
							'display_terms'      => false,
							'cat_archive_prefix' => '',
							'tag_archive_prefix' => '',
						)
					);
				}
				?>
			</div>
		</div>
	</div>
</div>
