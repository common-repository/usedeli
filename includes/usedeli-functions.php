<?php
/**
 * Plugin utility functions
 *
 * @package Usedeli\Functions
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return path to plugin file
 *
 * @param string $filename The specified file.
 * @return string
 */
function usedeli_path( $filename = '' ) {
	return USEDELI_PATH . ltrim( $filename, '/' );
}

/**
 * Return URI to plugin file
 *
 * @param string $filename The specified file.
 * @return string
 */
function usedeli_uri( $filename = '' ) {
	return USEDELI_URI . ltrim( $filename, '/' );
}

/**
 * Includes a file within the Usedeli plugin.
 *
 * @param string $filename The specified file.
 * @return void
 */
function usedeli_include( $filename = '' ) {
	$file_path = usedeli_path( $filename );
	if ( file_exists( $file_path ) ) {
		include_once $file_path;
	}
}
