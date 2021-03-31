<?php
/**
 * Includes global functions that have all global values.
 *
 * @package Peepso_Wpforo_Integration
 * @author Wbcom Designs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Peepso_Wpforo_Global_Functions' ) ) :

	/**
	 * Includes all global values.
	 *
	 * @class Peepso_Wpforo_Global_Functions
	 */
	class Peepso_Wpforo_Global_Functions {


		/**
		 * The single instance of the class.
		 *
		 * @var Peepso_Wpforo_Global_Functions
		 */
		protected static $_instance = null;

		/**
		 * Main Peepso_Wpforo_Global_Functions Instance.
		 *
		 * Ensures only one instance of Peepso_Wpforo_Global_Functions is loaded or can be loaded.
		 *
		 * @since    1.0.0
		 * @return Peepso_Wpforo_Global_Functions - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Get all WpForo profile section menus.
		 *
		 * @since    1.0.0
		 */
		public function wbpwpforoi_get_profile_menus() {
			$wpforo_prefix     = 'wpforo-';
			$menus             = array();			
			$menus['profile'] = array(
				'label' => esc_html__( 'Profile', 'peepso-wpforo' ),
				'href'  => 'profile',
				'icon'  => 'ps-icon-edit peepso-wpforo-icon ' . $wpforo_prefix . 'profile',
			);			
			$menus['account'] = array(
				'label' => esc_html__( 'Account', 'peepso-wpforo' ),
				'href'  => 'account',
				'icon'  => 'ps-icon-edit peepso-wpforo-icon ' . $wpforo_prefix . 'account',
			);	
			$menus['activity'] = array(
				'label' => esc_html__( 'Activity', 'peepso-wpforo' ),
				'href'  => 'activity',
				'icon'  => 'ps-icon-edit peepso-wpforo-icon ' . $wpforo_prefix . 'activity',
			);
			$menus['subscriptions'] = array(
				'label' => esc_html__( 'Subscriptions', 'peepso-wpforo' ),
				'href'  => 'subscriptions',
				'icon'  => 'ps-icon-edit peepso-wpforo-icon ' . $wpforo_prefix . 'subscriptions',
			);
			$menus = apply_filters( 'wbpwpforoi_get_wpforo_profile_menus', $menus );
			return $menus;
		}

		public function peepso_check_is_wpforo_page( $is_wpforo ) {
			if ( isset( $_SERVER['REQUEST_URI'] ) ) {
				global $peepso;
				$request_scheme = ( is_ssl() ) ? 'https' : 'http';
				$current_url    = $request_scheme . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				$instance           = PeepSoProfileShortcode::get_instance();
		    	$displayed_user_id  = $instance->user_profile_id(0);			
				$peepso_user        = PeepSoUser::get_instance( $displayed_user_id );
				$profile_url        = $peepso_user->get_profileurl();
				if ( strpos( $current_url, $profile_url ) !== false ) {
					$wpforo_prefix = Wpforo_Profile_Tab_Manager::$menu_slug;
					$url_chunks    = explode( '/', $current_url );
					foreach ( $url_chunks as $key => $url_chunk ) {
						if ( strpos( $url_chunk, $wpforo_prefix ) !== false ) {
							$is_wpforo = true;
						}
					}
				}
			}
			$is_wpforo = apply_filters( 'peepso_check_is_wpforo_page', $is_wpforo );
			return $is_wpforo;
		}
	}

endif;

/**
 * Main instance of Peepso_Wpforo_Global_Functions.
 *
 * @return Peepso_Wpforo_Global_Functions
 */

$GLOBALS['wbpwpforoi_peepso_wpforo_global_functions'] = Peepso_Wpforo_Global_Functions::instance();