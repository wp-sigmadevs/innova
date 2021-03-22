<?php
/**
 * Customizer Controls Class.
 * This Class registers Customizer Controls.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Customizer Controls Class.
 *
 * @since v1.0
 */
class Innova_Customizer_Controls {

	/**
	 * Kirki Configuration ID.
	 *
	 * @access public
	 * @var string
	 * @since  1.0.0
	 */
	public $config_id;

	/**
	 * Customizer Controls.
	 *
	 * @access public
	 * @var array
	 * @since  1.0.0
	 */
	public $controls = array();

	/**
	 * Refers to a single instance of this class.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 * @since  1.0.0
	 */
	public static $instance = null;

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @return Innova_Customizer_Controls
	 * @since  1.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Customizer panels.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->config_id = 'innova_theme';
		$this->header()->footer()->typography()->colors()->page()
		->blog()->socials()->integrations()->extras()->add_controls();
	}

	/**
	 * Adding controls with the help of Kirki.
	 *
	 * @access private
	 * @return void
	 *
	 * @since 1.0.0
	 */
	private function add_controls() {
		if ( empty( $this->controls ) ) {
			return;
		}

		foreach ( $this->controls as $control ) {
			Kirki::add_field( $this->config_id, $control );
		}
	}

	/**
	 * Header controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function header() {
		$this->controls[] = array(
			'settings'    => 'innova_logo_padding',
			'label'       => esc_html__( 'Logo Padding', 'innova' ),
			'description' => esc_html__( 'Logo top/bottom padding. Default: 10px.', 'innova' ),
			'section'     => 'innova_header_styles',
			'type'        => 'dimensions',
			'priority'    => 20,
			'default'     => array(
				'padding-top'    => '10px',
				'padding-bottom' => '10px',
			),
			'choices'     => array(
				'labels' => array(
					'padding-top'    => esc_html__( 'Padding Top', 'innova' ),
					'padding-bottom' => esc_html__( 'Padding Bottom', 'innova' ),
				),
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => '.site-branding .logo',
				),
			),
		);

		$this->controls[] = array(
			'settings'    => 'innova_enable_100_header',
			'label'       => esc_html__( '100% Header?', 'innova' ),
			'description' => esc_html__( 'Enable/disable 100% header width, regardless of container.', 'innova' ),
			'section'     => 'innova_header_styles',
			'type'        => 'toggle',
			'priority'    => 25,
			'default'     => 0,
		);

		$this->controls[] = array(
			'settings'    => 'innova_header_bg_color',
			'label'       => esc_html__( 'Header Background Color', 'innova' ),
			'description' => esc_html__( 'Please choose the header background color', 'innova' ),
			'section'     => 'header_image',
			'type'        => 'color',
			'priority'    => 30,
			'choices'     => array(
				'alpha' => true,
			),
			'default'     => '#fff',
			'output'      => array(
				array(
					'element'  => 'header .header-area',
					'property' => 'background-color',
				),
			),
			'transport'   => 'auto',
		);

		$this->controls[] = array(
			'settings'    => 'innova_enable_sticky_header',
			'label'       => esc_html__( 'Enable Sticky Header?', 'innova' ),
			'description' => esc_html__( 'Enable/disable sticky header.', 'innova' ),
			'section'     => 'innova_sticky_header',
			'type'        => 'toggle',
			'priority'    => 10,
			'default'     => 1,
		);

		return $this;
	}

	/**
	 * Footer controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function footer() {
		$this->controls[] = array(
			'settings'    => 'innova_footer_bg_color',
			'label'       => esc_html__( 'Footer Background Color', 'innova' ),
			'description' => esc_html__( 'Please choose the footer background color', 'innova' ),
			'section'     => 'innova_footer_styles',
			'type'        => 'color',
			'priority'    => 10,
			'default'     => '#fff',
			'output'      => array(
				array(
					'element'  => '#colophon',
					'property' => 'background-color',
				),
			),
			'transport'   => 'auto',
		);

		$this->controls[] = array(
			'settings'    => 'innova_footer_padding',
			'label'       => esc_html__( 'Footer Padding', 'innova' ),
			'description' => esc_html__( 'Footer top/bottom padding. Default: 70px.', 'innova' ),
			'section'     => 'innova_footer_styles',
			'type'        => 'dimensions',
			'priority'    => 15,
			'default'     => array(
				'padding-top'    => '70px',
				'padding-bottom' => '70px',
			),
			'choices'     => array(
				'labels' => array(
					'padding-top'    => esc_html__( 'Padding Top', 'innova' ),
					'padding-bottom' => esc_html__( 'Padding Bottom', 'innova' ),
				),
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => '#colophon',
				),
			),
		);

		$this->controls[] = array(
			'settings'    => 'innova_enable_100_footer',
			'label'       => esc_html__( '100% Footer?', 'innova' ),
			'description' => esc_html__( 'Enable/disable 100% footer width, regardless of container.', 'innova' ),
			'section'     => 'innova_footer_styles',
			'type'        => 'toggle',
			'priority'    => 20,
			'default'     => 0,
		);

		$this->controls[] = array(
			'type'        => 'editor',
			'settings'    => 'innova_footer_copyright_text',
			'label'       => esc_html__( 'Footer Copyright Text', 'innova' ),
			'description' => esc_html__( 'Please enter footer copyright text.', 'innova' ),
			'section'     => 'innova_footer_copyright',
			'priority'    => 10,
		);

		return $this;
	}

	/**
	 * Typography controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function typography() {
		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'innova_body_font',
			'label'     => esc_html__( 'Body Typography', 'innova' ),
			'section'   => 'innova_typography_body',
			'default'   => array(
				'font-size'      => '1.6rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 10,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'body, button, input, select, textarea',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'innova_nav_font',
			'label'     => esc_html__( 'Menu Typography', 'innova' ),
			'section'   => 'innova_typography_nav',
			'default'   => array(
				'font-size'      => '1.6rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 15,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => '#main-menu li a',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'innova_h1_font',
			'label'     => esc_html__( 'Heading-1 Typography', 'innova' ),
			'section'   => 'innova_typography_h1',
			'default'   => array(
				'font-size'      => '4rem',
				'line-height'    => '1.2',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 20,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h1, .h1',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'innova_h2_font',
			'label'     => esc_html__( 'Heading-2 Typography', 'innova' ),
			'section'   => 'innova_typography_h2',
			'default'   => array(
				'font-size'      => '3.2rem',
				'line-height'    => '1.2',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 25,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h2, .h2',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'innova_h3_font',
			'label'     => esc_html__( 'Heading-3 Typography', 'innova' ),
			'section'   => 'innova_typography_h3',
			'default'   => array(
				'font-size'      => '2.8rem',
				'line-height'    => '1.2',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 30,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h3, .h3',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'innova_h4_font',
			'label'     => esc_html__( 'Heading-4 Typography', 'innova' ),
			'section'   => 'innova_typography_h4',
			'default'   => array(
				'font-size'      => '2.4rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 35,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h4, .h4',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'innova_h5_font',
			'label'     => esc_html__( 'Heading-5 Typography', 'innova' ),
			'section'   => 'innova_typography_h5',
			'default'   => array(
				'font-size'      => '2rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 40,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h5, .h5',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'innova_h6_font',
			'label'     => esc_html__( 'Heading-6 Typography', 'innova' ),
			'section'   => 'innova_typography_h6',
			'default'   => array(
				'font-size'      => '1.6rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 45,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h6, .h6',
				),
			),
		);

		return $this;
	}

	/**
	 * Color controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function colors() {
		$this->controls[] = array(
			'settings' => 'innova_text_color',
			'label'    => esc_html__( 'Text Color', 'innova' ),
			'section'  => 'innova_color_settings',
			'type'     => 'color',
			'priority' => 10,
			'default'  => '#333333',
			// 'transport' => 'postMessage',
		);

		$this->controls[] = array(
			'settings' => 'innova_primary_color',
			'label'    => esc_html__( 'Primary Color', 'innova' ),
			'section'  => 'innova_color_settings',
			'type'     => 'color',
			'priority' => 15,
			'default'  => '#1FD682',
			// 'transport' => 'postMessage',
		);

		$this->controls[] = array(
			'settings' => 'innova_secondary_color',
			'label'    => esc_html__( 'Secondary Color', 'innova' ),
			'section'  => 'innova_color_settings',
			'type'     => 'color',
			'priority' => 20,
			'default'  => '#20D6F3',
			// 'transport' => 'postMessage',
		);

		$this->controls[] = array(
			'settings' => 'innova_tertiary_color',
			'label'    => esc_html__( 'Tertiary Color', 'innova' ),
			'section'  => 'innova_color_settings',
			'type'     => 'color',
			'priority' => 25,
			'default'  => '#0B285B',
			// 'transport' => 'postMessage',
		);

		$this->controls[] = array(
			'settings' => 'innova_offset_color',
			'label'    => esc_html__( 'Offset Color', 'innova' ),
			'section'  => 'innova_color_settings',
			'type'     => 'color',
			'priority' => 30,
			'default'  => '#EFF5FC',
			// 'transport' => 'postMessage',
		);

		$this->controls[] = array(
			'settings' => 'innova_border_color',
			'label'    => esc_html__( 'Border Color', 'innova' ),
			'section'  => 'innova_color_settings',
			'type'     => 'color',
			'priority' => 35,
			'default'  => '#DDDDDD',
			// 'transport' => 'postMessage',
		);

		return $this;
	}

	/**
	 * Page controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function page() {
		$this->controls[] = array(
			'type'        => 'background',
			'settings'    => 'innova_pagetitle_banner_bg',
			'label'       => esc_html__( 'Page title Banner Background', 'innova' ),
			'description' => esc_html__( 'Please upload page title banner image. Recommended image size is 1920x1080 px.', 'innova' ),
			'section'     => 'innova_pagetitle',
			'priority'    => 10,
			'default'     => array(
				'background-color'      => 'rgba(20,20,20,.8)',
				'background-image'      => '',
				'background-repeat'     => 'repeat',
				'background-position'   => 'center center',
				'background-size'       => 'cover',
				'background-attachment' => 'scroll',
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => '#page-title',
				),
			),
		);

		$this->controls[] = array(
			'settings'    => 'innova_pagetitle_padding',
			'label'       => esc_html__( 'Page Title Banner Padding', 'innova' ),
			'description' => esc_html__( 'Page title banner top/bottom padding. Default: 80px.', 'innova' ),
			'section'     => 'innova_pagetitle',
			'type'        => 'dimensions',
			'priority'    => 15,
			'default'     => array(
				'padding-top'    => '80px',
				'padding-bottom' => '80px',
			),
			'choices'     => array(
				'labels' => array(
					'padding-top'    => esc_html__( 'Padding Top', 'innova' ),
					'padding-bottom' => esc_html__( 'Padding Bottom', 'innova' ),
				),
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => '#page-title',
				),
			),
		);

		$this->controls[] = array(
			'type'        => 'text',
			'settings'    => 'innova_pagetitle_blog',
			'label'       => esc_html__( 'Page title Text for Blog', 'innova' ),
			'description' => esc_html__( 'Please enter the page title text for blog.', 'innova' ),
			'section'     => 'innova_pagetitle',
			'priority'    => 25,
			'transport'   => 'auto',
			'default'     => esc_html__( 'blog', 'innova' ),
		);

		$this->controls[] = array(
			'type'        => 'toggle',
			'settings'    => 'innova_enable_breadcrumbs',
			'label'       => esc_html__( 'Enable Breadcrumbs?', 'innova' ),
			'description' => esc_html__( 'Enable/disable breadcrumbs.', 'innova' ),
			'section'     => 'innova_breadcrumbs',
			'default'     => 0,
			'priority'    => 10,
		);

		$this->controls[] = array(
			'type'            => 'text',
			'settings'        => 'innova_breadcrumbs_prefix',
			'label'           => esc_html__( 'Breadcrumbs Prefix', 'innova' ),
			'description'     => esc_html__( 'Please enter the breadcrumb prefix.', 'innova' ),
			'section'         => 'innova_breadcrumbs',
			'active_callback' => array(
				array(
					'setting'  => 'innova_enable_breadcrumbs',
					'operator' => '===',
					'value'    => true,
				),
			),
			'priority'        => 15,
		);

		$this->controls[] = array(
			'type'            => 'text',
			'settings'        => 'innova_breadcrumbs_separator',
			'label'           => esc_html__( 'Breadcrumbs Separator', 'innova' ),
			'description'     => esc_html__( 'Please enter the breadcrumb separator.', 'innova' ),
			'section'         => 'innova_breadcrumbs',
			'active_callback' => array(
				array(
					'setting'  => 'innova_enable_breadcrumbs',
					'operator' => '===',
					'value'    => true,
				),
			),
			'default'         => '<i class="fa fa-angle-right"></i>',
			'priority'        => 15,
		);

		$this->controls[] = array(
			'settings'    => 'innova_page_padding',
			'label'       => esc_html__( 'Page Padding', 'innova' ),
			'description' => esc_html__( 'Page top/bottom padding. Default: 80px.', 'innova' ),
			'section'     => 'innova_page_styles',
			'type'        => 'dimensions',
			'priority'    => 10,
			'default'     => array(
				'padding-top'    => '80px',
				'padding-bottom' => '80px',
			),
			'choices'     => array(
				'labels' => array(
					'padding-top'    => esc_html__( 'Padding Top', 'innova' ),
					'padding-bottom' => esc_html__( 'Padding Bottom', 'innova' ),
				),
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => '#wrapper.inner-page-content',
				),
			),
		);

		return $this;
	}

	/**
	 * Blog controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function blog() {
		$this->controls[] = array(
			'settings'    => 'innova_archive_pagination',
			'label'       => esc_html__( 'Pagination Type', 'innova' ),
			'description' => esc_html__( 'Please select the pagination type for archive pages', 'innova' ),
			'choices'     => array(
				'classic'  => esc_html__( 'Classic Pagination' ),
				'numbered' => esc_html__( 'Numbered Pagination' ),
			),
			'type'        => 'select',
			'section'     => 'innova_archive_settings',
			'priority'    => 10,
			'default'     => 'classic',
		);

		$this->controls[] = array(
			'settings'    => 'innova_single_pagination',
			'label'       => esc_html__( 'Enable Single Post Navigation?', 'innova' ),
			'description' => esc_html__( 'Enable/disable single post navigation', 'innova' ),
			'type'        => 'toggle',
			'section'     => 'innova_single_settings',
			'priority'    => 10,
			'default'     => 0,
		);

		return $this;
	}

	/**
	 * Social Media controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function socials() {
		$this->controls[] = array(
			'type'         => 'repeater',
			'settings'     => 'innova_social_profiles',
			'label'        => esc_html__( 'Social Media Information', 'innova' ),
			'section'      => 'innova_social_media',
			'priority'     => 10,
			'row_label'    => array(
				'type'  => 'text',
				'value' => esc_html__( 'Social Profile', 'innova' ),
			),
			'button_label' => esc_html__( 'Add More', 'innova' ),
			'default'      => array(
				array(
					'fa_icon'     => esc_attr( 'fab fa-facebook-f' ),
					'profile_url' => esc_url( 'https://facebook.com/' ),
				),
				array(
					'fa_icon'     => esc_attr( 'fab fa-twitter' ),
					'profile_url' => esc_url( 'https://twitter.com' ),
				),
			),
			'fields'       => array(
				'fa_icon'     => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Icon', 'innova' ),
					'description' => esc_html__( 'Please enter Font Awesome 5 icon class', 'innova' ),
				),
				'profile_url' => array(
					'type'        => 'link',
					'label'       => esc_html__( 'Profile Link', 'innova' ),
					'description' => esc_html__( 'Please enter the social media profile link', 'innova' ),
				),
			),
		);

		return $this;
	}

	/**
	 * Integration controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function integrations() {
		$this->controls[] = array(
			'settings'    => 'innova_header_code',
			'label'       => esc_html__( 'Header Code', 'innova' ),
			'description' => esc_html__( 'Please enter the header code (Wrap this code with &lt;script&gt; tag).', 'innova' ),
			'type'        => 'code',
			'section'     => 'innova_integrations',
			'choices'     => array(
				'language' => 'html',
			),
			'priority'    => 10,
		);

		$this->controls[] = array(
			'settings'    => 'innova_footer_code',
			'label'       => esc_html__( 'Footer Code', 'innova' ),
			'description' => esc_html__( 'Please enter the footer code (Wrap this code with &lt;script&gt; tag).', 'innova' ),
			'type'        => 'code',
			'section'     => 'innova_integrations',
			'choices'     => array(
				'language' => 'html',
			),
			'priority'    => 15,
		);

		return $this;
	}

	/**
	 * Extra controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function extras() {
		$this->controls[] = array(
			'type'        => 'toggle',
			'settings'    => 'innova_enable_totop',
			'label'       => esc_html__( 'Enable Scroll To-Top Button?', 'innova' ),
			'description' => esc_html__( 'Enable/disable scroll to top button.', 'innova' ),
			'section'     => 'innova_extra_settings',
			'default'     => 1,
			'priority'    => 10,
		);

		$this->controls[] = array(
			'type'        => 'toggle',
			'settings'    => 'innova_enable_pageloader',
			'label'       => esc_html__( 'Enable Page Loader?', 'innova' ),
			'description' => esc_html__( 'Enable/disable page loader animation.', 'innova' ),
			'section'     => 'innova_extra_settings',
			'default'     => 1,
			'priority'    => 15,
		);

		if ( class_exists( 'ACF' ) ) {
			$this->controls[] = array(
				'type'        => 'toggle',
				'settings'    => 'innova_enable_acf_admin',
				'label'       => esc_html__( 'Enable ACF Admin Panel?', 'innova' ),
				'description' => esc_html__( 'Enable/disable ACF admin panel in dashboard.', 'innova' ),
				'section'     => 'innova_extra_settings',
				'default'     => 1,
				'priority'    => 20,
			);
		}

		return $this;
	}
}
