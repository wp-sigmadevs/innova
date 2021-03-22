<?php
/**
 * The theme autoloader.
 * Handles locating and loading other class-files.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Theme loader class.
 *
 * @since 1.0.0
 */
class Innova_Autoloader {

	/**
	 * Directory Paths.
	 *
	 * @var array $directories Required directory Paths.
	 * @access private
	 * @since 1.0.0
	 */
	private $directories = array(
		'includes/core',
		'includes/admin',
		'includes/admin/customizer',
		'includes/setup',
		'includes/lib',
		'includes/compats',
		'includes/frontend',
		'includes/frontend/shortcodes',
	);

	/**
	 * Autoload function for registering with spl_autoload_register().
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function register() {
		spl_autoload_register( array( $this, 'autoload_class' ) );
	}

	/**
	 * The class autoloader.
	 * Finds the path to a class that we're requiring and includes the file.
	 *
	 * @param string $class The name of the class we're trying to load.
	 * @access private
	 * @since 1.0.0
	 */
	private function autoload_class( $class ) {
		if ( 0 !== strpos( $class, 'Innova_' ) ) {
			return;
		}

		foreach ( $this->directories as $key => $directory ) {
			$abs_dir = trailingslashit( get_parent_theme_file_path( $directory ) );
			$file    = $abs_dir . strtolower( str_replace( '_', '-', "class-$class.php" ) );

			if ( file_exists( $file ) ) {
				include_once wp_normalize_path( $file );
				return true;
			}
		}
	}
}
