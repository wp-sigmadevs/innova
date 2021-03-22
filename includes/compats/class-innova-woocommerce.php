<?php
/**
 * Woocommerce Compatibility Class.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Woocommerce Class.
 */
class Innova_Woocommerce {

	/**
	 * Refers to a single instance of this class.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 * @since 1.0.0
	 */
	public static $instance = null;

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @return Innova_Woocommerce
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Woocommerce Support.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {

		// Setup Woocommerce.
		add_action( 'after_setup_theme', array( $this, 'setup' ) );

		// WooCommerce specific scripts & stylesheets.
		add_action( 'wp_enqueue_scripts', array( $this, 'woocommerce_scripts' ) );

		// Disabling the default WooCommerce stylesheet.
		// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

		// Related Products Args.
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products' ) );

		// Removing default WooCommerce wrapper.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		// Adding wrapper according to theme structure.
		add_action( 'woocommerce_before_main_content', array( $this, 'wrapper_before' ) );
		add_action( 'woocommerce_after_main_content', array( $this, 'wrapper_after' ) );
	}

	/**
	 * Setup Woocommerce.
	 *
	 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
	 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
	 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function setup() {
		add_theme_support(
			'woocommerce',
			array(
				'thumbnail_image_width' => 400,
				'single_image_width'    => 600,
				'product_grid'          => array(
					'default_rows'    => 3,
					'min_rows'        => 1,
					'default_columns' => 3,
					'min_columns'     => 1,
					'max_columns'     => 6,
				),
			)
		);
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	/**
	 * WooCommerce specific scripts & stylesheets.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function woocommerce_scripts() {
		$font_path   = WC()->plugin_url() . '/assets/fonts/';
		$inline_font = '@font-face {
                font-family: "star";
                src: url("' . $font_path . 'star.eot");
                src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
                    url("' . $font_path . 'star.woff") format("woff"),
                    url("' . $font_path . 'star.ttf") format("truetype"),
                    url("' . $font_path . 'star.svg#star") format("svg");
                font-weight: normal;
                font-style: normal;
            }';

		wp_add_inline_style( 'innova-stylesheet', $inline_font );
	}

	/**
	 * Related Products Args.
	 *
	 * @access public
	 * @param array $args related products args.
	 * @return array $args related products args.
	 *
	 * @since 1.0.0
	 */
	public function related_products( $args ) {
		$defaults = array(
			'posts_per_page' => 3,
			'columns'        => 3,
		);

		$args = wp_parse_args( $defaults, $args );

		return $args;
	}

	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function wrapper_before() {
		?>
		<div id="content" class="content-area">
			<div class="container">
				<div class="row">
					<?php
					if ( Innova_Helpers::inside_shop() ) {
						echo '<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-3">';
							echo '<aside id="secondary" class="widget-area">';
								get_sidebar();
							echo '</aside><!-- #secondary -->';
						echo '</div>';
						echo '<div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">';
					} else {
						echo '<div class="col-12 col-sm-12 col-md-12">';
					}
					?>
						<main id="primary" class="site-main">
		<?php
	}

	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function wrapper_after() {
		?>
						</main><!-- #main -->
					</div>
				</div>
			</div>
		</div><!-- #content -->
		<?php
	}
}
