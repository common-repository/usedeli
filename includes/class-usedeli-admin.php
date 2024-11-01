<?php
/**
 * Admin functions
 *
 * @package Usedeli\Admin
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Usedeli_Admin' ) ) {
	/**
	 * Ajax functions class
	 */
	class Usedeli_Admin {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
			add_filter( 'admin_body_class', array( $this, 'body_class' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( USEDELI ), array( $this, 'settings_link' ) );
		}

		/**
		 * Register admin menu
		 */
		public function admin_menu() {
			$icon = 'data:image/svg+xml;base64,' . 'PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTE2LjA2NzIgOS4zNzE5OEMxNi4wNjcyIDcuNTAwODUgMTQuNTM2MyA1LjkzNTkgMTIuNjYzOCA1Ljk1NjMyQzExLjc2ODQgNS45NjU4NCAxMC45NTYgNi4zMjUxIDEwLjM1ODYgNi45MDM0NUMxMC4xNTg1IDcuMDk4MDQgOS44NDQxOCA3LjA5ODA0IDkuNjQ0MTMgNi45MDM0NUM5LjA0NTM3IDYuMzI1MSA4LjIzNDMyIDUuOTY1ODQgNy4zMzg5IDUuOTU2MzJDNS40Njc3NyA1LjkzNzI2IDMuOTM1NDkgNy41MDA4NSAzLjkzNTQ5IDkuMzcxOThWMTcuOTQ5MkM1LjYxODgyIDE5LjIzNTIgNy43MTk5MyAyMC4wMDE0IDEwLjAwMiAyMC4wMDE0QzEyLjI4NDEgMjAuMDAxNCAxNC4zODUyIDE5LjIzNTIgMTYuMDY4NiAxNy45NDkyVjkuMzcxOThIMTYuMDY3MlpNNi45ODkxNyA5LjIyMzY1QzYuMzk0NDkgOS4yMjM2NSA1LjkxMjc2IDguNzQxOTIgNS45MTI3NiA4LjE0NzI0QzUuOTEyNzYgNy41NTI1NiA2LjM5NDQ5IDcuMDcwODMgNi45ODkxNyA3LjA3MDgzQzcuNTgzODUgNy4wNzA4MyA4LjA2NTU4IDcuNTUyNTYgOC4wNjU1OCA4LjE0NzI0QzguMDY1NTggOC43NDE5MiA3LjU4Mzg1IDkuMjIzNjUgNi45ODkxNyA5LjIyMzY1Wk0xMC4wOTE4IDExLjIyMTNMOC45Mjk3IDkuMzg1NTlDOS4xMzUxOSA4Ljk1MDEyIDkuNTc4ODIgOC42NDkzOCAxMC4wOTE4IDguNjQ5MzhDMTAuNjA0OSA4LjY0OTM4IDExLjA0ODUgOC45NTAxMiAxMS4yNTQgOS4zODU1OUwxMC4wOTE4IDExLjIyMTNaTTEzLjAxMjIgOS4yMjM2NUMxMi40MTc1IDkuMjIzNjUgMTEuOTM1OCA4Ljc0MTkyIDExLjkzNTggOC4xNDcyNEMxMS45MzU4IDcuNTUyNTYgMTIuNDE3NSA3LjA3MDgzIDEzLjAxMjIgNy4wNzA4M0MxMy42MDY4IDcuMDcwODMgMTQuMDg4NiA3LjU1MjU2IDE0LjA4ODYgOC4xNDcyNEMxNC4wODg2IDguNzQxOTIgMTMuNjA2OCA5LjIyMzY1IDEzLjAxMjIgOS4yMjM2NVoiIGZpbGw9IndoaXRlIi8+CjxwYXRoIGQ9Ik0xMC4wMDA3IDBDNC40NzcxIDAgMCA0LjQ3NzEgMCAxMC4wMDA3QzAgMTIuOTU2NCAxLjI4MzI2IDE1LjYxMTMgMy4zMjA0MSAxNy40NDE2VjkuMjkzMDVDMy4zMjA0MSA2LjI4MTU1IDYuMjkzOCA0LjgxMTg3IDguMjczOCA0LjE2ODJDOC42MjIxNyA0LjA1NTI1IDguOTIyOTEgMy44MzQ3OSA5LjE1MDE3IDMuNTQ3NjZDOS43MjE3MSAyLjgyNTA2IDEwLjQwMDggMi40NDQwMyAxMC44NDk4IDIuMjU0ODhDMTEuMDA3NyAyLjE4OTU2IDExLjE2MTUgMi4zNTE1IDExLjA5MDcgMi41MDY2M0MxMC45MDgzIDIuOTA2NzEgMTAuOTIyIDMuMjUzNzIgMTEuMDI4MSAzLjU0MzU4QzExLjEzMjkgMy44MzIwNyAxMS4zNjk3IDQuMDU1MjUgMTEuNjYyMiA0LjE0Nzc4QzEzLjY0MDkgNC43ODA1NiAxNi42Nzk2IDYuMjQ4ODkgMTYuNjc5NiA5LjI5MzA1VjE3LjQ0MTZDMTguNzE4MSAxNS42MTEzIDIwIDEyLjk1NSAyMCAxMC4wMDA3QzIwLjAwMTQgNC40NzcxIDE1LjUyNDMgMCAxMC4wMDA3IDBaIiBmaWxsPSJ3aGl0ZSIvPgo8L3N2Zz4K';
			add_menu_page(
				__( 'Deli', 'usedeli' ),
				__( 'Deli', 'usedeli' ),
				'manage_options',
				'usedeli',
				array( $this, 'settings_page' ),
				$icon,
				99
			);
		}

		/**
		 * Enqueue scripts and styles
		 */
		public function enqueue() {
			if ( ! isset( $_GET['page'] ) || 'usedeli' !== $_GET['page'] ) {
				return;
			}

			wp_enqueue_style( 'jquery-toast', usedeli_uri( 'assets/css/jquery-toast.min.css' ), array(), '1.0.0', 'all' );
			wp_enqueue_style( 'select2', usedeli_uri( 'assets/css/select2.min.css' ), array(), '4.0.13', 'all' );
			wp_enqueue_style( 'usedeli-admin', usedeli_uri( 'assets/css/admin.css' ), array(), USEDELI_VERSION, 'all' );

			if ( ! did_action( 'wp_enqueue_media' ) ) {
				wp_enqueue_media();
			}

			wp_enqueue_script( 'iris' );
			wp_enqueue_script( 'jquery-toast', usedeli_uri( 'assets/js/jquery-toast.min.js' ), array( 'jquery' ), '1.0.0', true );
			wp_enqueue_script( 'select2', usedeli_uri( 'assets/js/select2.min.js' ), array( 'jquery' ), '4.0.13', true );
			wp_enqueue_script( 'jquery-validate', usedeli_uri( 'assets/js/jquery.validate.min.js' ), array( 'jquery' ), '1.21.0', true );
			wp_enqueue_script( 'usedeli-admin', usedeli_uri( 'assets/js/admin.js' ), array( 'jquery' ), USEDELI_VERSION, true );

			$vars = array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'strings' => array(
					'checking_api' => esc_html__( 'Checking...', 'usedeli' ),
				),
			);

			wp_localize_script( 'usedeli-admin', 'usedeli', $vars );
		}

		/**
		 * Add body class
		 *
		 * @param string $classes The body classes.
		 */
		public function body_class( $classes ) {
			if ( ! isset( $_GET['page'] ) || 'usedeli' !== $_GET['page'] ) {
				return $classes;
			}

			return $classes . ' usedeli-page';
		}

		/**
		 * Add settings link
		 *
		 * @param array $links The plugin action links.
		 * @return array
		 */
		public function settings_link( $links ) {
			$settings_link = '<a href="' . admin_url( 'admin.php?page=usedeli' ) . '">' . esc_html__( 'Settings', 'usedeli' ) . '</a>';
			array_unshift( $links, $settings_link );
			return $links;
		}

		/**
		 * Settings page
		 */
		public function settings_page() {
			include usedeli_path( 'views/settings.php' );
		}
	}

	$usedeli_admin = new Usedeli_Admin();
}
