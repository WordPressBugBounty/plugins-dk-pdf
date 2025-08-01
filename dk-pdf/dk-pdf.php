<?php
/*
 * Plugin Name: DK PDF
 * Version: 2.0.2
 * Description: WordPress to PDF made easy.
 * Author: Emili Castells
 * Author URI: https://dinamiko.dev
 * Requires at least: 3.9
 * Requires PHP: 8.0
 * Tested up to: 6.8
 * License: MIT
 * Text Domain: dkpdf
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'DKPDF' ) ) {

    #[AllowDynamicProperties]
	final class DKPDF {

		private static $instance;

		public static function instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof DKPDF ) ) {

				self::$instance = new DKPDF;

				self::$instance->setup_constants();

				add_action( 'plugins_loaded', array( self::$instance, 'dkpdf_load_textdomain' ) );

				self::$instance->includes();

			}

			return self::$instance;

		}

		public function dkpdf_load_textdomain() {

			load_plugin_textdomain( 'dkpdf', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

		}

		private function setup_constants() {

			if ( ! defined( 'DKPDF_VERSION' ) ) {
				define( 'DKPDF_VERSION', '2.0.2' );
			}
			if ( ! defined( 'DKPDF_PLUGIN_DIR' ) ) {
				define( 'DKPDF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}
			if ( ! defined( 'DKPDF_PLUGIN_URL' ) ) {
				define( 'DKPDFPLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}
			if ( ! defined( 'DKPDF_PLUGIN_FILE' ) ) {
				define( 'DKPDF_PLUGIN_FILE', __FILE__ );
			}

		}

		private function includes() {

			// settings / metaboxes
			if ( is_admin() ) {

				require_once DKPDF_PLUGIN_DIR . 'includes/class-dkpdf-settings.php';
				$settings = new DKPDF_Settings( $this );

				require_once DKPDF_PLUGIN_DIR . 'includes/class-dkpdf-admin-api.php';
				$this->admin = new DKPDF_Admin_API();

				require_once DKPDF_PLUGIN_DIR . 'includes/dkpdf-metaboxes.php';

			}

			// load css / js
			require_once DKPDF_PLUGIN_DIR . 'includes/dkpdf-load-js-css.php';

			// functions
			require_once DKPDF_PLUGIN_DIR . 'includes/dkpdf-functions.php';

			// shortcodes
			require_once DKPDF_PLUGIN_DIR . 'includes/class-dkpdf-template-loader.php';
			require_once DKPDF_PLUGIN_DIR . 'includes/dkpdf-shortcodes.php';

		}

		public function __clone() {
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', 'dkpdf' ), DKPDF_VERSION );
		}

		public function __wakeup() {
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', 'dkpdf' ), DKPDF_VERSION );
		}

	}

}

DKPDF::instance();
