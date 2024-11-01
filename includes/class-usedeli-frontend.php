<?php
/**
 * Frontend class
 *
 * @package Usedeli\Frontend
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Usedeli_Frontend' ) ) {
	/**
	 * Frontend functions class
	 */
	class Usedeli_Frontend {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		}

		/**
		 * Enqueue scripts and styles
		 * 
		 * @since 1.0.1 Add display on specific post
		 */
		public function enqueue() {
			$usedeli_api  = get_option( 'usedeli_api' );
			$usedeli_logo = get_option( 'usedeli_logo' );

			// Bail if API key is not set.
			if ( ! $usedeli_api ) {
				return;
			}

			$display_on = get_option( 'usedeli_display_on' ) ? get_option( 'usedeli_display_on' ) : 'all';

			if ( 'front' === $display_on && ! is_front_page() ) {
				return;
			}

			if ( 'specific' === $display_on ) {
				$post_ids = get_option( 'usedeli_post_ids' );

				if ( get_the_ID() ) {
					if ( ! in_array( get_the_ID(), $post_ids ) ) {
						return;
					}
				}
			}


			if ( $usedeli_logo ) {
				$usedeli_logo_url = wp_get_attachment_image_url( $usedeli_logo, 'full' );
			} else {
				$usedeli_logo_url = usedeli_uri( 'assets/img/deli-logo.svg' );
			}

			$usedeli_color        = get_option( 'usedeli_color' ) ? get_option( 'usedeli_color' ) : '#0062FF';
			$usedeli_display_name = get_option( 'usedeli_display_name' ) ? get_option( 'usedeli_display_name' ) : '';

			wp_enqueue_script( 'usedeli-widget', 'https://widget.usedeli.com/v1/deli.js', array(), USEDELI_VERSION, true );
			wp_add_inline_script( 'usedeli-widget', 'DeliWidget.init({brand: "' . esc_html( $usedeli_display_name ) . '", widget_key: "' . esc_html( $usedeli_api ) . '", logo: "' . esc_url( $usedeli_logo_url ) . '", color: "' . esc_html( $usedeli_color ) . '"});' );
		}
	}

	$usedeli_frontend = new Usedeli_Frontend();
}
