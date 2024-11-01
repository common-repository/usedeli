<?php
/**
 * Plugin Name: Deli - AI Enabled Property Search
 * Plugin URI: https://chat.usedeli.com
 * Description: Deli is a chat bot helping consumers/interested home buyers find a home they are interested in by typing in the criteria they are interested in via natural language.
 * Version: 1.0.2
 * Author: Usedeli
 * Author URI: https://usedeli.com
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/glpl-2.0.en.html
 * Domain Path: /languages
 * Text Domain: usedeli
 *
 * @package Usedeli
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'USEDELI' ) ) {
	define( 'USEDELI', __FILE__ );
}

if ( ! class_exists( 'Usedeli', false ) ) {
	include_once dirname( USEDELI ) . '/includes/class-usedeli.php';
}

// Register activation hook.
register_activation_hook( USEDELI, array( 'Usedeli', 'activate' ) );

// Register uninstall hook.
register_uninstall_hook( USEDELI, array( 'Usedeli', 'uninstall' ) );

/**
 * Initialize the plugin
 *
 * @return Usedeli
 */
function Usedeli() {
	global $usedeli;

	// Instantiate only once.
	if ( ! isset( $usedeli ) ) {
		$usedeli = new Usedeli();
		$usedeli->initialize();
	}
	return $usedeli;
}

// Instantiate.
Usedeli();
