<?php
/**
 * Main class
 *
 * @package Usedeli
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main plugin class
 */
class Usedeli {
	/**
	 * The plugin version number.
	 */
	public $version = '1.0.2';

	/**
	 * Dummy constructor to prevent double setup
	 *
	 * @return void
	 */
	public function __construct() {
		// do nothing.
	}

	/**
	 * Class initialization check
	 * To make sure this class is only initialized once
	 */
	public function initialize() {
		/**
		 * Define constants
		 */
		$this->define( 'USEDELI_VERSION', $this->version );
		$this->define( 'USEDELI_PATH', plugin_dir_path( USEDELI ) );
		$this->define( 'USEDELI_URI', plugin_dir_url( USEDELI ) );
		$this->define( 'USEDELI_API_BASE', trailingslashit( 'https://api.usedeli.com' ) );

		/**
		 * Core functions.
		 */
		include_once USEDELI_PATH . 'includes/usedeli-functions.php';

		/**
		 * Core classes.
		 */
		usedeli_include( 'includes/class-usedeli-ajax.php' );
		usedeli_include( 'includes/class-usedeli-api.php' );
		usedeli_include( 'includes/class-usedeli-frontend.php' );

		/**
		 * Admin classes
		 */
		if ( is_admin() ) {
			usedeli_include( 'includes/class-usedeli-admin.php' );
		}
	}

	/**
	 * Load the plugin text domain for internationalization
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'usedeli', false, basename( USEDELI_PATH ) . '/languages' );
	}

	/**
	 * Define a constant if not already defined
	 *
	 * @param string $name The constant name.
	 * @param string $value The constant value.
	 */
	public function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * On Activation
	 */
	public static function activate() {
		// Set default options.
		update_option( 'usedeli_color', '#0062FF' );
		update_option( 'usedeli_logo', usedeli_uri( 'assets/img/deli-logo.svg' ) );
	}

	/**
	 * On deactivation
	 */
	public static function uninstall() {
		// Delete options.
		delete_option( 'usedeli_api' );
		delete_option( 'usedeli_mls_id' );
		delete_option( 'usedeli_logo' );
		delete_option( 'usedeli_color' );
		delete_option( 'usedeli_status' );
	}
}
