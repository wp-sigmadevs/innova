<?php
/**
 * Theme Engine Room.
 * This theme uses OOP logic instead of procedural coding.
 * Every function, hook and action is properly organized inside related
 * folders and files.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * This Theme only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/includes/utils/back-compat.php';
	return;
}

if ( file_exists( get_parent_theme_file_path( 'includes/class-innova-autoloader.php' ) ) ) {
	require_once get_parent_theme_file_path( 'includes/class-innova-autoloader.php' );

	// Initializing Autoloading.
	$innova_loader = new Innova_Autoloader();
	$innova_loader->register();
}

if ( class_exists( 'Innova_Theme' ) ) {

	// Starting the app.
	$innova_run = new Innova_Theme();
	$innova_run->register_services();
}
