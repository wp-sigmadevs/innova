<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #page div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>
		</div><!-- #wrapper -->

		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php
			/**
			 * Footer Widgets.
			 */
			get_template_part( 'views/footer/footer', 'widgets' );
			?>

			<div class="footer-copyright">
				<div class="<?php innova_footer_container(); ?>">
					<div class="row">
						<div class="col-12 col-sm-12 col-md-12">
							<div class="site-info text-center">
								<?php
								$footer_copyright = get_theme_mod( 'innova_footer_copyright_text', '' );

								echo wp_kses_post( wpautop( $footer_copyright ) );
								?>
							</div><!-- .site-info -->
						</div>
					</div>
				</div>
			</div><!-- .footer-copyright -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>

</body>
</html>
