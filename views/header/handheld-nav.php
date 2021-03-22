<?php
/**
 * Displays the handheld navigation.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<nav id="innova-mobile-menu" class="innova-menu d-block d-sm-block d-md-block d-lg-none">
	<button class="innova-menu__close"><?php echo esc_html__( '&larr; Back', 'innova' ); ?></button>
	<?php
	Innova_Menus::nav_menu(
		array(
			'theme_location'  => 'handheld_nav',
			'menu'            => 'handheld_nav',
			'container'       => 'div',
			'container_class' => 'nav-wrapper',
			'menu_class'      => 'innova-menu__items',
			'menu_id'         => 'handheld-menu',
		)
	);
	?>
</nav>
