<?php
/**
 * Class to add reviews shortcode.
 *
 * @since    1.0.0
 * @author   Wbcom Designs
 * @package  BuddyPress_Member_Reviews
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wbcom_Licence_Settings' ) ) {

	/**
	 * Class to serve AJAX Calls.
	 *
	 * @author   Wbcom Designs
	 * @since    1.0.0
	 */
	class Wbcom_Licence_Settings {


		/**
		 * The single instance of the class.
		 *
		 * @var Wbcom_Licence_Settings
		 */
		private static $instance = null;
		/**
		 * Main Peepso_LifterLMS_Settings_Manager Instance.
		 *
		 * Ensures only one instance of Peepso_LifterLMS_Settings_Manager is loaded or can be loaded.
		 *
		 * @return Wbcom_Licence_Settings - Main instance.
		 */
		public static function instance() {
			if ( self::$instance == null ) {
				self::$instance = new Wbcom_Licence_Settings();
			}

			return self::$instance;
		}

		public function __construct() {
			add_action( 'admin_menu', array( $this, 'wbcom_admin_license_page' ), 999 );
			add_action( 'admin_enqueue_scripts', array( $this, 'wbcom_enqueue_admin_scripts' ) );
		}

		/**
		 * Enqueue js & css related to wbcom plugin.
		 *
		 * @since 1.1.0
		 * @access public
		 */
		public function wbcom_enqueue_admin_scripts() {
			if ( ! wp_style_is( 'wbcom-admin-setting-css', 'enqueued' ) ) {
				wp_enqueue_style( 'wbcom-admin-setting-css', Peepso_Wpforo_Integration_PLUGIN_DIR_URL . 'admin/wbcom/assets/css/wbcom-admin-setting.css' );
			}
		}

		public function wbcom_admin_license_page() {
			add_submenu_page(
				'peepso',
				esc_html__( 'Wbcom License', 'peepso-lifterlms' ),
				esc_html__( 'Wbcom License', 'peepso-lifterlms' ),
				'manage_options',
				'wbcom-peepso-license-page',
				array( $this, 'wbcom_license_submenu_page_callback' )
			);
		}


		public function wbcom_license_submenu_page_callback() {
			?>
	  <div class="wrap">
		  <h1 class="wbcom-plugin-heading"><?php esc_html_e( 'Plugin License Settings', 'peepso-lifterlms' ); ?></h1>
		  <div class="wb-plugins-license-tables-wrap">
			  <table class="form-table wb-license-form-table desktop-license-headings">
				  <thead>
					  <tr>
						  <th class="wb-product-th"><?php esc_html_e( 'Product', 'peepso-lifterlms' ); ?></th>
						  <th class="wb-version-th"><?php esc_html_e( 'Version', 'peepso-lifterlms' ); ?></th>
						  <th class="wb-key-th"><?php esc_html_e( 'Key', 'peepso-lifterlms' ); ?></th>
						  <th class="wb-status-th"><?php esc_html_e( 'Status', 'peepso-lifterlms' ); ?></th>
						  <th class="wb-action-th"><?php esc_html_e( 'Action', 'peepso-lifterlms' ); ?></th>
						  <th></th>
					  </tr>
				  </thead>
			  </table>
			<?php do_action( 'wbcom_add_peepso_plugin_license_code' ); ?>
			  <table class="form-table wb-license-form-table">
				  <tfoot>
					  <tr>
						  <th class="wb-product-th"><?php esc_html_e( 'Product', 'peepso-lifterlms' ); ?></th>
						  <th class="wb-version-th"><?php esc_html_e( 'Version', 'peepso-lifterlms' ); ?></th>
						  <th class="wb-key-th"><?php esc_html_e( 'Key', 'peepso-lifterlms' ); ?></th>
						  <th class="wb-status-th"><?php esc_html_e( 'Status', 'peepso-lifterlms' ); ?></th>
						  <th class="wb-action-th"><?php esc_html_e( 'Action', 'peepso-lifterlms' ); ?></th>
						  <th></th>
					  </tr>
				  </tfoot>
			  </table>
		  </div>
	  </div>
			<?php
		}
	}

	/**
	 * Main instance of Wbcom_Licence_Settings.
	 *
	 * Returns the main instance of Wbcom_Licence_Settings to prevent the need to use globals.
	 *
	 * @since  1.0.0
	 * @return Wbcom_Licence_Settings
	 */
		Wbcom_Licence_Settings::instance();
}
