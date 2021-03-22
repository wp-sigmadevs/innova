<?php
/**
 * Displays the footer widgets.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<div class="footer-widget-area">
	<div class="<?php innova_footer_container(); ?>">
		<div class="row">
		<?php
		$column_count = 4;

		for ( $footer_no = 1; $footer_no <= $column_count; $footer_no++ ) {
			echo '<div id="footer-col-' . esc_attr( $footer_no ) . '" class="footer-column col-12 col-sm-12 col-md-6 col-lg-3">';
			if ( is_active_sidebar( 'innova-footer-col-' . esc_attr( $footer_no ) ) ) {
				dynamic_sidebar( 'innova-footer-col-' . esc_attr( $footer_no ) );
			}
			echo '</div>';
		}
		?>
		</div>
	</div>
</div><!-- .footer-widget-area -->
