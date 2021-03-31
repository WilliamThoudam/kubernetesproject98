<?php
/**
 * Plugin settings for add admin settings page & includes admin settings.
 *
 * @package WBPWPFOROI_PeepSo_WpForo_Integration
 * @author Wbcom Designs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Peepso_Wpforo_Settings_Manager' ) ) :

	/**
	 * Includes settings to display PeepSo WpForo Integration settings tab
	 *
	 * @class Peepso_Wpforo_Settings_Manager
	 */
	class Peepso_Wpforo_Settings_Manager {


		/**
		 * The single instance of the class.
		 *
		 * @var Peepso_Wpforo_Settings_Manager
		 */
		protected static $_instance = null;

		/**
		 * Main Peepso_Wpforo_Settings_Manager Instance.
		 *
		 * Ensures only one instance of Peepso_Wpforo_Settings_Manager is loaded or can be loaded.
		 *
		 * @return Peepso_Wpforo_Settings_Manager - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Peepso_Wpforo_Settings_Manager Constructor.
		 *
		 * @since  1.0.0
		 */
		public function __construct() {
			$this->init_hooks();
		}

		/**
		 * Hook into actions and filters.
		 *
		 * @since  1.0.0
		 */
		private function init_hooks() {
			add_action( 'peepso_admin_config_tabs', array( $this, 'peepso_admin_config_tabs' ), 10, 1 );
		}

		/**
		 * Hook into actions and filters.
		 *
		 * @param array $tabs All tabs details.
		 * @return array $tabs
		 * @since  1.0.0
		 */
		public function peepso_admin_config_tabs( $tabs ) {
			PeepSo::add_autoload_directory( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR );
			PeepSoTemplate::add_template_directory( plugin_dir_path( __FILE__ ) );

			include_once 'class-peepso-wpforo-admin-settings-display.php';

			$tabs['peepso-wpforo-addon'] = array(
				'label'       => __( 'PeepSo wpForo Addon', 'peepso-wpforo' ),
				'icon'        => Peepso_Wpforo_Integration_PLUGIN_DIR_URL . 'assets/imgs/wpforo-icon.png',
				'tab'         => 'peepso-wpforo-addon',
				'description' => __( 'PeepSo wpForo Integration Config Tab', 'peepso-wpforo' ),
				'function'    => 'PeepSo_Wpforo_Admin_Settings_Display',
			);

			return $tabs;
		}
	}

endif;

/**
 * Main instance of Peepso_Wpforo_Settings_Manager.
 *
 * @return Peepso_Wpforo_Settings_Manager
 */
Peepso_Wpforo_Settings_Manager::instance();
