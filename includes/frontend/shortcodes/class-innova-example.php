<?php
/**
 * Example Shortcode Class.
 *
 * This class adds an example shortcode in the frontend.
 *
 * @package Innova
 * @since   1.0.0
 */

/**
 * Example Shortcode Class.
 *
 * @since  1.0.0
 */
class Innova_Example {

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
	 * @return Innova_Example
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Method to load the shortcode.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function register() {
		add_shortcode( 'innova_example', array( $this, 'shortcode' ) );
	}

	/**
	 * Method to render the shortcodes.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param mixed $atts shortcode attributes.
	 * @return void|string
	 */
	public function shortcode( $atts ) {
		$atts   = shortcode_atts(
			array(),
			$atts
		);
		$result = '';

		ob_start();
		?>

		<div>
			<p>My Awesome Shortcode :)</p>
		</div>

		<?php
		$result .= ob_get_clean();

		return $result;
	}
}
