<?php
/**
 * The loop template file.
 *
 * Included on pages like index.php, archive.php and search.php
 * to display a loop of posts
 *
 * Learn more: https://codex.wordpress.org/The_Loop
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/* Start the Loop */
while ( have_posts() ) {
	the_post();

	if ( is_search() ) {

		// Search template partial.
		get_template_part( 'views/content/content', 'search' );

	} else {
		/**
		 * Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called views/content/content-___.php (where ___ is the Post Format name)
		 * and that will be used instead.
		 */
		get_template_part( 'views/content/content', get_post_format() );
	}
}

// Posts Pagination.
if ( 'classic' === get_theme_mod( 'innova_archive_pagination', 'classic' ) ) {
	innova_classic_pagination();
} else {
	innova_numbered_pagination();
}
