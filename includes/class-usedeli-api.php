<?php
/**
 * API functions
 *
 * @package Usedeli\API
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Usedeli_API' ) ) {
	/**
	 * API functions class
	 */
	class Usedeli_API {
		/**
		 * Get token
		 */
		public static function get_token() {
			$usedeli_api = get_option( 'usedeli_api' );

			if ( $usedeli_api ) {
				$response = wp_remote_post(
					USEDELI_API_BASE . 'widget/initialize',
					array(
						'body'    => '{"widget_key": "' . $usedeli_api . '"}',
						'timeout' => 15,
					)
				);

				if ( is_wp_error( $response ) ) {
					return false;
				}

				$body = json_decode( wp_remote_retrieve_body( $response ) );

				if ( $body->success ) {
					$token            = $body->data->id_token;
					$initial_question = $body->data->initial_question;
					update_option( 'usedeli_token', $token );
					update_option( 'usedeli_initial_question', $initial_question );
					return $token;
				} else {
					update_option( 'usedeli_token', '' );
					update_option( 'usedeli_initial_question', '' );
					return false;
				}
			} else {
				return false;
			}
		}
	}
}
