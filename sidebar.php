<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( is_single() && is_active_sidebar( 'innova-sidebar-blog' ) ) {
	dynamic_sidebar( 'innova-sidebar-blog' );
} elseif ( Innova_Helpers::has_woocommerce() && is_active_sidebar( 'innova-sidebar-shop' ) && Innova_Helpers::inside_woocommerce() ) {
	dynamic_sidebar( 'innova-sidebar-shop' );
} elseif ( is_home() && is_active_sidebar( 'innova-sidebar-blog' ) ) {
	dynamic_sidebar( 'innova-sidebar-blog' );
} elseif ( is_archive() && is_active_sidebar( 'innova-sidebar-blog' ) ) {
	dynamic_sidebar( 'innova-sidebar-blog' );
} else {
	dynamic_sidebar( 'innova-sidebar-general' );
}
