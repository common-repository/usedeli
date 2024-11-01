<?php
/**
 * Ajax functions
 *
 * @package Usedeli\Ajax
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Usedeli_Ajax' ) ) {
	/**
	 * Ajax functions class
	 */
	class Usedeli_Ajax {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'wp_ajax_usedeli_check_api', array( $this, 'check_api' ) );
			add_action( 'wp_ajax_usedeli_save_settings', array( $this, 'save_settings' ) );
		}

		/**
		 * Check API
		 */
		public function check_api() {
			$get_token = Usedeli_API::get_token();
			wp_send_json(
				array(
					'success' => $get_token ? true : false,
					'token'   => $get_token,
					'status'  => $get_token ? _x( 'Connected', 'Check API', 'usedeli' ) : _x( 'Disconnected', 'Check API', 'usedeli' ),
				)
			);
		}

		/**
		 * Save settings
		 */
		public function save_settings() {
			if ( ! check_ajax_referer( 'usedeli', 'security' ) ) {
				wp_send_json(
					array(
						'success' => false,
						'message' => array(
							'heading' => __( 'Invalid requests', 'usedeli' ),
							'text'    => __( 'Please try again.', 'usedeli' ),
						),
					)
				);
			}

			$usedeli_api          = isset( $_POST['usedeli_api'] ) ? sanitize_text_field( wp_unslash( $_POST['usedeli_api'] ) ) : '';
			$usedeli_mls_id       = isset( $_POST['usedeli_mls_id'] ) ? sanitize_text_field( wp_unslash( $_POST['usedeli_mls_id'] ) ) : '';
			$usedeli_logo         = isset( $_POST['usedeli_logo'] ) ? sanitize_text_field( wp_unslash( $_POST['usedeli_logo'] ) ) : '';
			$usedeli_color        = isset( $_POST['usedeli_color'] ) ? sanitize_text_field( wp_unslash( $_POST['usedeli_color'] ) ) : '';
			$usedeli_display_name = isset( $_POST['usedeli_display_name'] ) ? sanitize_text_field( wp_unslash( $_POST['usedeli_display_name'] ) ) : '';
			$usedeli_display_on   = isset( $_POST['usedeli_display_on'] ) ? sanitize_text_field( wp_unslash( $_POST['usedeli_display_on'] ) ) : '';
			$usedeli_post_ids     = isset( $_POST['usedeli_post_ids'] ) ? array_map( 'sanitize_text_field', $_POST['usedeli_post_ids'] ) : array();

			update_option( 'usedeli_api', $usedeli_api );
			update_option( 'usedeli_mls_id', $usedeli_mls_id );
			update_option( 'usedeli_logo', $usedeli_logo );
			update_option( 'usedeli_color', $usedeli_color );
			update_option( 'usedeli_display_name', $usedeli_display_name );
			update_option( 'usedeli_display_on', $usedeli_display_on );
			update_option( 'usedeli_post_ids', $usedeli_post_ids );

			wp_send_json(
				array(
					'success' => true,
					'message' => array(
						'heading' => __( 'Settings saved', 'usedeli' ),
						'text'    => __( 'Your settings have been saved.', 'usedeli' ),
					),
				)
			);
		}
	}

	$usedeli_ajax = new Usedeli_Ajax();
}
