<?php
/**
 * Admin Class.
 * This Class uses TGMPA class to install recommended plugins.
 *
 * @package Innova
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Main Admin Class.
 *
 * @since v1.0
 */
class Innova_Admin {

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
	 * @return Innova_Admin
	 * @since  1.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initializing Recommended Plugins.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {

		// Requiring the TGMPA Class.
		include_once 'class-tgm-plugin-activation.php';

		// Required and recommended plugins.
		add_action( 'tgmpa_register', array( $this, 'register_plugins' ) );

		// Custom button for TGMPA notice.
		add_filter( 'tgmpa_notice_action_links', array( $this, 'edit_tgmpa_notice_action_links' ) );
	}

	/**
	 * Register all plugins with TGMPA.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register_plugins() {

		// Plugin list.
		$plugins = $this->get_theme_plugins();

		// Plugin Configuration.
		$config = $this->plugins_config();

		tgmpa( $plugins, $config );
	}

	/**
	 * List of recommended plugins.
	 *
	 * @access private
	 * @return array
	 *
	 * @since 1.0.0
	 */
	private function get_theme_plugins() {
		$plugins = array(
			array(
				'name'     => esc_html__( 'Kirki Customizer Framework', 'innova' ),
				'slug'     => 'kirki',
				'required' => true,
			),

			array(
				'name'     => esc_html__( 'Advanced Custom Fields', 'innova' ),
				'slug'     => 'advanced-custom-fields',
				'required' => true,
			),

			array(
				'name'     => esc_html__( 'Classic Editor', 'innova' ),
				'slug'     => 'classic-editor',
				'required' => false,
			),

			array(
				'name'     => esc_html__( 'Elementor Page Builder', 'innova' ),
				'slug'     => 'elementor',
				'required' => false,
			),

			array(
				'name'     => esc_html__( 'Contact Form 7', 'innova' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			),
		);

		return $plugins;
	}

	/**
	 * TGMPA configuration.
	 *
	 * @access private
	 * @return array
	 *
	 * @since 1.0.0
	 */
	private function plugins_config() {

		// Change this to your theme text domain.
		$theme_text_domain = 'innova';

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'domain'       => $theme_text_domain,
			'id'           => 'innova_tgmpa',
			'default_path' => '',
			'parent_slug'  => 'themes.php',
			'menu'         => 'innova-plugins',
			'capability'   => 'edit_theme_options',
			'has_notices'  => true,
			'is_automatic' => true,
			'message'      => '',
			'strings'      => array(
				'page_title'                      => __( 'Install Recommended Plugins', 'innova' ),
				'menu_title'                      => __( 'Install Plugins', 'innova' ),
				/* translators: %s: plugin name. */
				'installing'                      => __( 'Installing Plugin: %s', 'innova' ),
				/* translators: %s: plugin name. */
				'updating'                        => __( 'Updating Plugin: %s', 'innova' ),
				'oops'                            => __( 'Something went wrong with the plugin API.', 'innova' ),
				'notice_can_install_required'     =>
				/* translators: 1: plugin name(s). */
				_n_noop(
					'Innova Theme requires the following plugin: %1$s.',
					'Innova Theme requires the following plugins: %1$s.',
					'innova'
				),
				'notice_can_install_recommended'  =>
				/* translators: 1: plugin name(s). */
				_n_noop(
					'Innova Theme recommends the following plugin: %1$s.',
					'Innova Theme recommends the following plugins: %1$s.',
					'innova'
				),
				'notice_ask_to_update'            =>
				/* translators: 1: plugin name(s). */
				_n_noop(
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with Innova Theme: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with Innova Theme: %1$s.',
					'innova'
				),
				'notice_ask_to_update_maybe'      =>
				/* translators: 1: plugin name(s). */
				_n_noop(
					'There is an update available for: %1$s.',
					'There are updates available for the following plugins: %1$s.',
					'innova'
				),
				'notice_can_activate_required'    =>
				/* translators: 1: plugin name(s). */
				_n_noop(
					'The following required plugin is currently inactive: %1$s.',
					'The following required plugins are currently inactive: %1$s.',
					'innova'
				),
				'notice_can_activate_recommended' =>
				/* translators: 1: plugin name(s). */
				_n_noop(
					'The following recommended plugin is currently inactive: %1$s.',
					'The following recommended plugins are currently inactive: %1$s.',
					'innova'
				),
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'innova'
				),
				'update_link'                     => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'innova'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'innova'
				),
				'return'                          => __( 'Return to Plugins Installer', 'innova' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'innova' ),
				'activated_successfully'          => __( 'The following plugin was activated successfully:', 'innova' ),
				/* translators: 1: plugin name. */
				'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'innova' ),
				/* translators: 1: plugin name. */
				'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'innova' ),
				/* translators: 1: dashboard link. */
				'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'innova' ),
				'dismiss'                         => __( 'Dismiss this notice', 'innova' ),
				'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'innova' ),
				'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'innova' ),

				'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
			),
		);

		return $config;
	}

	/**
	 * Custom button for TGMPA notice.
	 *
	 * @access public
	 * @param  array $action_links The action link(s) for a required plugin.
	 * @return array The action link(s) for a required plugin.
	 * @since  1.0.0
	 */
	public function edit_tgmpa_notice_action_links( $action_links ) {

		$link_template = '<a id="manage-plugins" class="button-primary" style="margin-top:15px;margin-bottom:0;" href="' . esc_url( TGM_Plugin_Activation::$instance->get_tgmpa_url() ) . '">' . esc_attr__( 'Manage Plugins', 'innova' ) . '</a>';
		$action_links  = array(
			'install' => $link_template,
		);

		return $action_links;
	}
}
