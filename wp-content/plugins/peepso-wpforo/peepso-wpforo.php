<?php
/**
 * Plugin Name: PeepSo wpForo Integration
 * Plugin URI: https://wbcomdesigns.com/
 * Description: wpForo Forums Integration with PeepSo plugin.
 * Version: 1.4.0
 * Author: Wbcom Designs
 * Author URI: https://wbcomdesigns.com/
 * Requires at least: 4.0
 * Tested up to: 5.4.2
 *
 * Text Domain: peepso-wpforo
 * Domain Path: /languages/
 *
 * @package Peepso_Wpforo_Integration
 * @category Core
 * @author Wbcom Designs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Peepso_Wpforo_Integration' ) ) :

	/**
	 * Main Peepso_Wpforo_Integration Class.
	 *
	 * @class Peepso_Wpforo_Integration
	 * @version 1.0.0
	 */
	class Peepso_Wpforo_Integration {


		/**
		 * Peepso_Wpforo_Integration version.
		 *
		 * @var string
		 */
		public $version = '1.4.0';

		/**
		 * The single instance of the class.
		 *
		 * @var Peepso_Wpforo_Integration
		 * @since 1.0.0
		 */
		protected static $_instance = null;

		/**
		 * Main Peepso_Wpforo_Integration Instance.
		 *
		 * Ensures only one instance of Peepso_Wpforo_Integration is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 * @static
		 * @see INSTANTIATE_Peepso_Wpforo_Integration()
		 * @return Peepso_Wpforo_Integration - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}


		/**
		 * Peepso_Wpforo_Integration Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->define_constants();
			$this->init_hooks();
			do_action( 'wbpwpforoi_peepso_wpforo_integration_loaded' );
			register_activation_hook( __FILE__, array( $this, 'peepso_wpforo_integration_activate' ) );
			add_action( 'peepso_init', array( &$this, 'peepso_wpforo_init' ) );
		}

		/**
		 * Hook into actions and filters.
		 *
		 * @since  1.0.0
		 */
		private function init_hooks() {
			add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
			add_filter( 'plugin_action_links_' . Peepso_Wpforo_Integration_PLUGIN_BASENAME, array( $this, 'alter_plugin_action_links' ) );
			add_action( 'plugins_loaded', array( $this, 'wbpwpforoi_plugin_init' ) );
			add_action( 'peepso_register_new_user', array( $this, 'peepso_wpforo_deault_activity_enable' ) );
			add_action( 'edit_user_created_user', array( $this, 'peepso_wpforo_deault_activity_enable' ) );
		}

		/**
		 * Load default admin settings on plugin activation.
		 *
		 * @since  1.0.0
		 */
		public function peepso_wpforo_integration_activate() {
			if ( class_exists( 'PeepSo' ) && class_exists( 'wpForo' ) ) {
				$options = PeepSoConfigSettings::get_instance();
				include_once 'global/class-peepso-wpforo-global-functions.php';
				global $wbpwpforoi_peepso_wpforo_global_functions;
				$default_already_set = get_site_option( 'wbforo_default_values_set' );
				if ( ! $default_already_set ) {
					$menus = $wbpwpforoi_peepso_wpforo_global_functions->wbpwpforoi_get_profile_menus();
					foreach ( $menus as $menu_slug => $menu_name ) {
						$options->set_option( 'wpforo_enable_' . $menu_slug, 1 );
					}
					$options->set_option( 'wpforo_topic_activity_setting_display', 1 );
					$options->set_option( 'wpforo_reply_activity_setting_display', 1 );
					$options->set_option( 'wpforo_topic_notification_setting_display', 1 );
					$options->set_option( 'wpforo_reply_notification_setting_display', 1 );
					$users = get_users( array( 'fields' => array( 'ID' ) ) );
					foreach ( $users as $user ) {
						update_user_meta( $user->ID, 'peepso_wpforo_enable_tpc_crtd_activity', 1 );
						update_user_meta( $user->ID, 'peepso_wpforo_enable_reply_crtd_activity', 1 );
					}
					add_site_option( 'wbforo_default_values_set', 1 );
				}
			}
		}

		/**
		 * Check required plugins are active or not.
		 *
		 * @since  1.0.0
		 */
		public function wbpwpforoi_plugin_init() {
			if ( ! class_exists( 'PeepSo' ) || ! class_exists( 'wpForo' ) ) {
				add_action( 'admin_notices', array( $this, 'wbpwpforoi_peepso_disabled_notice' ) );
			} else {
				$this->includes();
				add_action( 'wp_enqueue_scripts', array( $this, 'wbpwpforoi_custom_css_enqueue' ) );
			}
		}

		/**
		 * Enqueue custom css and css fix for PeepSo checkout tab.
		 *
		 * @since  1.0.0
		 */
		public function wbpwpforoi_custom_css_enqueue() {
			wp_register_style(
				$handle = 'peepso-wpforo-frontend-icons',
				$src    = Peepso_Wpforo_Integration_PLUGIN_DIR_URL . 'assets/css/peepso-wpforo-icon.css',
				$deps   = array(),
				$ver    = time(),
				$media  = 'all'
			);
			wp_enqueue_style( 'peepso-wpforo-frontend-icons' );

			$peepso_url_segments = PeepSoUrlSegments::get_instance();
			if ( 'peepso_profile' === $peepso_url_segments->_shortcode ) {
				$options    = PeepSoConfigSettings::get_instance();
				$custom_css = '.wbpwpforoi-peepo-woo-wrapper #wpforo_checkout_wrap #wpforo-payment-mode-wrap input[type=radio]{
				opacity: 1 !important }';
				wp_add_inline_style( 'peepso-wpforo-frontend-icons', $custom_css );
				wp_enqueue_style( 'peepso-wpforo-front', Peepso_Wpforo_Integration_PLUGIN_DIR_URL . 'assets/css/peepso-wpforo-front.css' );
			}
		}

		/**
		 * Display notice if required plugins not present.
		 *
		 * @since  1.0.0
		 */
		public function wbpwpforoi_peepso_disabled_notice() {
			$wb_inte_plugin = esc_html__( 'PeepSo wpForo Integration', 'peepso-wpforo' );
			$wpforo_plugin  = esc_html__( 'wpForo-Forums', 'peepso-wpforo' );
			$peepso_plugin  = esc_html__( 'PeepSo', 'peepso-wpforo' );

			/* translators: %1$s: PeepSo WpForo Integration plugin, %2$s: Easy Digital Downloads plugin, %3$s: PeepSo plugin */
			echo '<div class="error"><p>' . sprintf( esc_html( __( '%1$s requires %2$s and %3$s both to be installed and active.', 'peepso-wpforo' ) ), '<strong>' . esc_attr( $wb_inte_plugin ) . '</strong>', '<strong>' . esc_attr( $peepso_plugin ) . '</strong>', '<strong>' . esc_attr( $wpforo_plugin ) . '</strong>' ) . '</p></div>';
			$activate = filter_input( INPUT_GET, 'activate' );
			if ( null !== $activate ) {
				unset( $activate );
			}
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}

		/**
		 * Add plugin settings link.
		 *
		 * @param string $plugin_links Plugin related links in all plugins listing page.
		 * @since  1.0.0
		 */
		public function alter_plugin_action_links( $plugin_links ) {
			if ( class_exists( 'PeepSo' ) && class_exists( 'wpForo' ) ) {
				$settings_link = '<a href="admin.php?page=peepso_config&tab=peepso-wpforo-addon">' . __( 'Settings', 'peepso-wpforo' ) . '</a>';
				array_unshift( $plugin_links, $settings_link );
			}
			return $plugin_links;
		}

		/**
		 * Define Peepso_Wpforo_Integration Constants.
		 *
		 * @since  1.0.0
		 */
		private function define_constants() {
			$this->define( 'Peepso_Wpforo_Integration_PLUGIN_FILE', __FILE__ );
			$this->define( 'Peepso_Wpforo_Integration_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			$this->define( 'Peepso_Wpforo_Integration_VERSION', $this->version );
			$this->define( 'Peepso_Wpforo_Integration_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'Peepso_Wpforo_Integration_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
			$this->define( 'Peepso_Wpforo_Integration_MODULE_ID', '226010' );
		}

		/**
		 * Define constant if not already set.
		 *
		 * @param  string      $name Define constant name.
		 * @param  string|bool $value Define constant value.
		 * @since  1.0.0
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 *
		 * @since  1.0.0
		 */
		public function includes() {
			require plugin_dir_path( __FILE__ ) . 'admin/edd-license/edd-plugin-license.php';
			include_once 'admin/wbcom/wbcom-license-setting.php';
			include_once 'global/class-peepso-wpforo-global-functions.php';
			include_once 'core/class-wpforo-profile-tab-manager.php';
			include_once 'admin/class-peepso-wpforo-settings-manager.php';
			include_once 'core/profile-settings/class-wpforo-activity-settings-manager.php';
			include_once 'core/activity/class-wpforo-actions-activity.php';
		}

		/**
		 * Load Localization files.
		 *
		 * @since  1.0.0
		 */
		public function load_plugin_textdomain() {
			$locale = apply_filters( 'peepso_wpforo_integration_plugin_locale', get_locale(), 'peepso-wpforo' );
			load_textdomain( 'peepso-wpforo', Peepso_Wpforo_Integration_PLUGIN_DIR_PATH . 'language/peepso-wpforo-' . $locale . '.mo' );
			load_plugin_textdomain( 'peepso-wpforo', false, plugin_basename( dirname( __FILE__ ) ) . '/language' );
		}

		public function peepso_wpforo_init() {
			PeepSoTemplate::add_template_directory( plugin_dir_path( __FILE__ ) );
		}
		/**
		 * Enable all activity options on frontend for new register user.
		 */
		public function peepso_wpforo_deault_activity_enable() {
			$users       = get_users( array( 'fields' => array( 'ID' ) ) );
			$meta_prefix = 'peepso_';
			foreach ( $users as $user ) {
				update_user_meta( $user->ID, 'peepso_wpforo_enable_tpc_crtd_activity', 1 );
				update_user_meta( $user->ID, 'peepso_wpforo_enable_reply_crtd_activity', 1 );
			}

		}
	}

endif;

/**
 * Main instance of Peepso_Wpforo_Integration.
 *
 * Returns the main instance of Peepso_Wpforo_Integration to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return Peepso_Wpforo_Integration
 */
function instantiate_wbpwpforoi_peepso_wpforo_integration() {
	return Peepso_Wpforo_Integration::instance();
}

// Global for backwards compatibility.
$GLOBALS['wbpwpforoi_peepso_wpforo_integration'] = instantiate_wbpwpforoi_peepso_wpforo_integration();
