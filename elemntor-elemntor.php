<?php
/**
 * Plugin Name: Elemntor Elements For Elementor
 * Plugin URI: https://ontarioconsulting.ca/
 * Description: A custom Elementor plugin for building advanced Elementor widgets and extensions.
 * Version: 1.0.0
 * Author: Md Solaiman
 * Author URI: https://upwork.com/freelancers/~01da2982e531013221
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: elemntor-elemntor
 * Domain Path: /languages
 * Elementor tested up to: 3.32.4
 * Elementor Pro tested up to: 3.32.2
 *
 * @package Elemntor_Elemntor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Elemntor Elemntor Plugin Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Elemntor_Elemntor {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 * @var Elemntor_Elemntor The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return Elemntor_Elemntor An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ) );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'elemntor-elemntor' );
	}

	/**
	 * On Plugins Loaded
	 *
	 * Checks if Elementor has loaded, and performs some compatibility checks.
	 * If All checks pass, inits the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function on_plugins_loaded() {
		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', array( $this, 'init' ) );
		}
	}

	/**
	 * Compatibility Checks
	 *
	 * Checks if the installed version of Elementor meets the plugin requirements.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function is_compatible() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return false;
		}

		return true;
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {
		$this->i18n();

		// Add Plugin actions
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_widget_categories' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
		add_action( 'elementor/controls/register', array( $this, 'register_controls' ) );

		// Register Widget Styles
		add_action( 'elementor/frontend/after_register_styles', array( $this, 'widget_styles' ) );

		// Register Widget Scripts
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'widget_scripts' ) );

		// Enqueue styles and scripts on frontend
		add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'enqueue_widget_assets' ) );

		// Enqueue scripts in editor mode
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'enqueue_editor_scripts' ) );
	}

	/**
	 * Register Widget Categories
	 *
	 * Register custom widget categories for Elementor.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
	 */
	public function register_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'custom-elements',
			array(
				'title' => esc_html__( 'Custom Elements', 'elemntor-elemntor' ),
				'icon'  => 'eicon-star',
			)
		);
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ) {
		// Include Widget files
		require_once __DIR__ . '/includes/widgets/class-elemntor-widget.php';
		require_once __DIR__ . '/includes/widgets/class-mobile-menu-widget.php';
		require_once __DIR__ . '/includes/widgets/class-accordion-widget.php';

		// Register widgets
		$widgets_manager->register( new \Elemntor_Elemntor\Widgets\Elemntor_Widget() );
		$widgets_manager->register( new \Elemntor_Elemntor\Widgets\Mobile_Menu_Widget() );
		$widgets_manager->register( new \Elemntor_Elemntor\Widgets\Accordion_Widget() );
	}

	/**
	 * Register Controls
	 *
	 * Register new Elementor controls.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param \Elementor\Controls_Manager $controls_manager Elementor controls manager.
	 */
	public function register_controls( $controls_manager ) {
		// Include Control files
		// require_once __DIR__ . '/includes/controls/class-custom-control.php';

		// Register control
		// $controls_manager->register( new \Elemntor_Elemntor\Controls\Custom_Control() );
	}

	/**
	 * Widget Styles
	 *
	 * Register widget styles.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function widget_styles() {
		wp_register_style( 'elemntor-elemntor-widget', plugins_url( 'assets/css/widget.css', __FILE__ ), array(), self::VERSION );
		wp_register_style( 'elemntor-elemntor-mobile-menu', plugins_url( 'assets/css/mobile-menu.css', __FILE__ ), array(), self::VERSION );
		wp_register_style( 'elemntor-elemntor-accordion', plugins_url( 'assets/css/accordion.css', __FILE__ ), array(), self::VERSION );
	}

	/**
	 * Widget Scripts
	 *
	 * Register widget scripts.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function widget_scripts() {
		wp_register_script( 'elemntor-elemntor-widget', plugins_url( 'assets/js/widget.js', __FILE__ ), array( 'jquery' ), self::VERSION, true );
		wp_register_script( 'elemntor-elemntor-mobile-menu', plugins_url( 'assets/js/mobile-menu.js', __FILE__ ), array( 'jquery' ), self::VERSION, true );
		wp_register_script( 'elemntor-elemntor-accordion', plugins_url( 'assets/js/accordion.js', __FILE__ ), array( 'jquery' ), self::VERSION, true );
	}

	/**
	 * Enqueue Widget Assets
	 *
	 * Ensure widget styles and scripts are enqueued on frontend.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue_widget_assets() {
		// Styles and scripts are automatically enqueued via get_style_depends() and get_script_depends()
		// This method is here for any additional enqueueing if needed
	}

	/**
	 * Enqueue Editor Scripts
	 *
	 * Enqueue scripts in Elementor editor mode.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue_editor_scripts() {
		wp_enqueue_script( 'elemntor-elemntor-mobile-menu' );
		wp_enqueue_script( 'elemntor-elemntor-accordion' );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elemntor-elemntor' ),
			'<strong>' . esc_html__( 'Elemntor Elemntor', 'elemntor-elemntor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elemntor-elemntor' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elemntor-elemntor' ),
			'<strong>' . esc_html__( 'Elemntor Elemntor', 'elemntor-elemntor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elemntor-elemntor' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elemntor-elemntor' ),
			'<strong>' . esc_html__( 'Elemntor Elemntor', 'elemntor-elemntor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elemntor-elemntor' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

Elemntor_Elemntor::instance();

