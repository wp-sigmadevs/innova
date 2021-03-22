<?php
/**
 * After theme setup class.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Theme Setup Class.
 *
 * @since v1.0.0
 */
class Innova_Setup {

	/**
	 * Theme text domain.
	 *
	 * @access private
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $text_domain = '';

	/**
	 * Localization directory.
	 *
	 * @access private
	 * @var mixed
	 *
	 * @since 1.0.0
	 */
	private $lang_dir = null;

	/**
	 * Post formats.
	 *
	 * @access private
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $post_formats = array();

	/**
	 * Custom Image Size.
	 *
	 * @access private
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $image_size = array();

	/**
	 * Custom header args.
	 *
	 * @access private
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $custom_header_args = array();

	/**
	 * Custom header args.
	 *
	 * @access private
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $header_args = array();

	/**
	 * Custom logo args.
	 *
	 * @access private
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $theme_logo_args = array();

	/**
	 * Theme content width.
	 *
	 * @access private
	 * @var mixed
	 *
	 * @since 1.0.0
	 */
	private $content_width = null;

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
	 * @return Innova_Setup
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize Menus.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function register() {

		// Theme Text Domain.
		$this->text_domain = 'innova';

		// Theme Localization Directory.
		$this->lang_dir = get_theme_file_path( 'languages' );

		// Theme Post Formats.
		$this->post_formats = array(
			'gallery',
			'audio',
			'video',
			'quote',
			'link',
		);

		// Theme Custom Image Sizes.
		$this->image_size = array(
			'innova-featured-image, 600, 375, true',
			'innova-square-image, 400, 400, true',
		);

		// Theme Custom Header args.
		$this->custom_header_args = array(
			'default-image' => '',
		);

		// Registered Theme Default Header Args.
		$this->header_args = array(
			'default-image' => array(
				'url'           => '%s/assets/images/default-header.jpg',
				'thumbnail_url' => '%s/assets/images/default-header.jpg',
				'description'   => esc_html__( 'Default Header Image', 'innova' ),
			),
		);

		// Custom Logo Args.
		$this->theme_logo_args = array(
			'width'  => 400,
			'height' => 100,
		);

		// Content Width.
		$this->content_width = 960;

		// Registering theme features.
		add_action( 'after_setup_theme', array( $this, 'theme_setup_core' ) );
		add_action( 'after_setup_theme', array( $this, 'theme_content_width' ), 0 );
	}

	/**
	 * The core functionality that has to be registered after the theme is set up.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function theme_setup_core() {

		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Innova Theme, use a find and replace
		 * to change 'innova' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( $this->text_domain, $this->lang_dir );

		/**
		 * Add default posts and comments
		 * RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Add support for post formats.
		 */
		add_theme_support( 'post-formats', $this->post_formats );

		/**
		 * Enable support for Post Thumbnails
		 * on posts and pages.
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		/**
		 * Enable support for adding custom image sizes.
		 */
		foreach ( $this->image_size as $key ) {
			$size = explode( ', ', esc_attr( $key ) );
			add_image_size( $size[0], $size[1], $size[2], $size[3] );
		}

		$custom_header_default_args = array(
			'default-image'      => '',
			'default-text-color' => '000000',
			'width'              => 1920,
			'height'             => 1080,
			'flex-width'         => true,
			'flex-height'        => true,
			'wp-head-callback'   => array( $this, 'header_callback' ),
		);

		/**
		 * Adding custom header support to the theme.
		 */
		add_theme_support(
			'custom-header',
			wp_parse_args( $this->custom_header_args, $custom_header_default_args )
		);

		$default_header_args = array(
			'default-image' => array(
				'url'           => '',
				'thumbnail_url' => '',
				'description'   => esc_html__( 'Default Header Image', 'innova' ),
			),
		);

		/**
		 * Registering default headers.
		 */
		register_default_headers( wp_parse_args( $this->header_args, $default_header_args ) );

		/**
		 * Adding custom background support to the theme
		 */
		add_theme_support( 'custom-background' );

		$default_logo_args = array(
			'width'       => 180,
			'height'      => 180,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		);

		/**
		 * Adding custom logo support to the theme.
		 */
		add_theme_support(
			'custom-logo',
			wp_parse_args( $this->theme_logo_args, $default_logo_args )
		);

		/**
		 * Partial refresh support in the Customize.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Adding support for Block Styles.
		 */
		add_theme_support( 'wp-block-styles' );

		/**
		 * Adding Add support for full and wide align images.
		 */
		add_theme_support( 'align-wide' );

		/**
		 * Adding support for editor styles.
		 */
		add_theme_support( 'editor-styles' );

		/**
		 * Enqueue editor styles.
		 */
		add_editor_style( 'assets/css/admin/editor-style.css' );

		/**
		 * Adding support for responsive embedded content.
		 */
		add_theme_support( 'responsive-embeds' );

		/**
		 * Adding support for custom line height controls.
		 */
		add_theme_support( 'custom-line-height' );

		/**
		 * Adding support for experimental link color control.
		 */
		add_theme_support( 'experimental-link-color' );

		/**
		 * Adding support for experimental cover block spacing.
		 */
		add_theme_support( 'custom-spacing' );

		/**
		 * Adding support for custom units.
		 *
		 * This was removed in WordPress 5.6 but is still required to
		 * properly support WP 5.5.
		 */
		add_theme_support( 'custom-units' );
	}

	/**
	 * Content width in pixels, based on the theme's design and stylesheet.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function theme_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'innova_theme_content_width', $this->content_width );
	}

	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function header_callback() {
		$header_text_color = get_header_textcolor();
		?>

		<style type="text/css">
			<?php
			if ( ! display_header_text() ) {
				?>
				.site-title a,
				.site-description {
					position: absolute;
					clip: rect(1px, 1px, 1px, 1px);
				}
				<?php
			} else {
				if ( ! empty( $header_text_color ) ) {
					?>
					.site-title a,
					.site-description {
						color: #<?php echo esc_attr( $header_text_color ); ?>
					}
					<?php
				}
			}
			?>
		</style>

		<?php
	}
}
