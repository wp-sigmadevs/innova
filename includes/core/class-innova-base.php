<?php
/**
 * The theme base class.
 * We're using this one to define some specific parameters.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Base Class.
 */
class Innova_Base {

	/**
	 * Theme Version.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $theme_version;

	/**
	 * Theme Root Directory Path.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $root_dir_path;

	/**
	 * Framework Directory Path.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $framework_dir_path;

	/**
	 * Root Directory URL.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $root_uri;

	/**
	 * Assets Directory URL.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $assets_uri;

	/**
	 * CSS Directory URL.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $css_uri;

	/**
	 * JS Directory URL.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $js_uri;

	/**
	 * Images Directory URL.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $images_uri;

	/**
	 * Refers to a single instance of this class.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 *
	 * @since 1.0.0
	 */
	public static $instance = null;

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @return Innova_Base
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Defining theme constants.
	 *
	 * @access protected
	 * @return void
	 *
	 * @since 1.0.0
	 */
	protected function __construct() {

		// Theme Name & Version.
		$this->theme_name    = wp_get_theme()->__get( 'Name' );
		$this->theme_slug    = strtolower( str_replace( ' ', '_', $this->theme_name ) );
		$this->theme_version = '1.0.0';

		// System constants.
		$this->root_dir_path      = wp_normalize_path( get_theme_file_path() );
		$this->framework_dir_path = trailingslashit( wp_normalize_path( get_theme_file_path( 'includes' ) ) );
		$this->vendor_dir_path    = trailingslashit( wp_normalize_path( get_theme_file_path( 'vendor' ) ) );
		$this->root_uri           = trailingslashit( get_theme_file_uri() );
		$this->assets_uri         = trailingslashit( get_theme_file_uri( 'assets' ) );
		$this->css_uri            = trailingslashit( get_theme_file_uri( 'assets/css' ) );
		$this->js_uri             = trailingslashit( get_theme_file_uri( 'assets/js' ) );
		$this->images_uri         = trailingslashit( get_theme_file_uri( 'assets/images' ) );
	}

	/**
	 * Theme Name.
	 *
	 * @access public
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_theme_name() {
		return $this->theme_name;
	}

	/**
	 * Theme Slug.
	 *
	 * @access public
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_theme_slug() {
		return $this->theme_slug;
	}

	/**
	 * Theme Version.
	 *
	 * @access public
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_theme_version() {
		return $this->theme_version;
	}

	/**
	 * Theme Directory.
	 *
	 * @access public
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_theme_directory() {
		return $this->root_dir_path;
	}

	/**
	 * Framework Directory.
	 *
	 * @access public
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_framework_directory() {
		return $this->framework_dir_path;
	}

	/**
	 * Vendor Directory.
	 *
	 * @access public
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_vendor_directory() {
		return $this->vendor_dir_path;
	}

	/**
	 * Theme URI.
	 *
	 * @access public
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_theme_uri() {
		return $this->root_uri;
	}

	/**
	 * Theme Assets URI.
	 *
	 * @access public
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_assets_uri() {
		return $this->assets_uri;
	}

	/**
	 * Theme CSS URI.
	 *
	 * @access public
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_css_uri() {
		return $this->css_uri;
	}

	/**
	 * Theme JS URI.
	 *
	 * @access public
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_js_uri() {
		return $this->js_uri;
	}

	/**
	 * Theme Images URI.
	 *
	 * @access public
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_images_uri() {
		return $this->images_uri;
	}

	/**
	 * If a file exists, require it from the file system.
	 *
	 * @static
	 * @param  string $file The file to require.
	 * @return bool True if the file exists, false if not.
	 * @access public
	 *
	 * @since 1.0.0
	 */
	public static function require_file( $file ) {
		if ( file_exists( $file ) ) {
			require_once wp_normalize_path( $file );
			return true;
		}

		return false;
	}

	/**
	 * If a method exists in a class, run it.
	 *
	 * @static
	 * @param  string $class The class to check.
	 * @return void
	 * @access public
	 *
	 * @since 1.0.0
	 */
	public static function require_service( $class ) {
		$service = $class::get_instance();

		if ( method_exists( $service, 'register' ) ) {
			$service->register();
		}
	}
}
