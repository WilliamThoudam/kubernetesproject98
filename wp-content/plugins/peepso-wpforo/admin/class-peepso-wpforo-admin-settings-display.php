<?php
/**
 * Plugin admin settings under PeepSo Configuration.
 *
 * @package PeepSo_Wpforo_Admin_Settings_Display
 * @author Wbcom Designs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Display PeepSo wpForo Integration admin settings
 *
 * @class PeepSo_Wpforo_Admin_Settings_Display
 * @version 1.0.0
 */
if ( ! class_exists( 'PeepSo_Wpforo_Admin_Settings_Display' ) ) :
	class PeepSo_Wpforo_Admin_Settings_Display extends PeepSoConfigSectionAbstract {



		/**
		 * Builds the groups array.
		 *
		 * @since  1.0.0
		 */
		public function register_config_groups() {

			$this->context = 'left';
			$this->peepso_wpforo_tabs_setting();
			$this->peepso_wpforo_link_setting();

			$this->context = 'right';
			$this->peepso_wpforo_activity_setting();
		}

		/**
		 * WpForo Tabs Settings Box
		 *
		 * @since    1.0.0
		 */
		private function peepso_wpforo_tabs_setting() {

			$this->set_field(
				'wpforo_tabs_display_seperator',
				__( 'wpForo Tabs Display', 'peepso-wpforo' ),
				'separator'
			);

			global $wbpwpforoi_peepso_wpforo_global_functions;
			$menus = $wbpwpforoi_peepso_wpforo_global_functions->wbpwpforoi_get_profile_menus();
			foreach ( $menus as $menu_slug => $menu ) {
				$this->set_field(
					'wpforo_enable_' . $menu_slug,
					$menu['label'],
					'yesno_switch'
				);
			}

			$this->set_group(
				'peepso_wbforo_tabs_setting',
				__( 'PeepSo wpForo Tabs Setting', 'peepso-wpforo' ),
				__( 'Here you can enable or disable wpForo tabs in PeepSo member single page.', 'peepso-wpforo' )
			);
		}

		/**
		 * Activities Settings Box
		 *
		 * @since    1.0.0
		 */
		private function peepso_wpforo_activity_setting() {
			/**** Setting area */

			$html = '';

			$this->set_field(
				'peepso_wpforo_activity_seperator',
				__( 'wpForo Activity Setting', 'peepso-wpforo' ),
				'separator'
			);

			$this->set_field(
				'wpforo_topic_activity_setting_display',
				__( 'Display "topic created" activity setting', 'peepso-wpforo' ),
				'yesno_switch'
			);

			$this->set_field(
				'wpforo_topic_notification_setting_display',
				__( 'Enable notification on new topic created', 'peepso-wpforo' ),
				'yesno_switch'
			);

			$this->set_field(
				'wpforo_reply_activity_setting_display',
				__( 'Display "reply created" activity setting', 'peepso-wpforo' ),
				'yesno_switch'
			);

			$this->set_field(
				'wpforo_reply_notification_setting_display',
				__( 'Enable notification on new reply created', 'peepso-wpforo' ),
				'yesno_switch'
			);

			$this->set_group(
				'peepso_wpforo_activity_setting',
				__( 'wpForo Activity Setting', 'peepso-wpforo' ),
				__( 'Here you can enable or disable settings related to wpForo activities.', 'peepso-wpforo' )
			);
		}

		/**
		 * Link Settings Box
		 *
		 * @since    1.0.0
		 */
		private function peepso_wpforo_link_setting() {

			$this->set_field(
				'wpforo_profile_link_setting_display',
				__( 'Change wpforo user link to PeepSo profile link.', 'peepso-wpforo' ),
				'yesno_switch'
			);

			$this->set_group(
				'peepso_wpforo_profile_link_setting',
				__( 'PeepSo wpForo Link Setting', 'peepso-wpforo' ),
				__( 'Here you can change wpForo user\'s profile link to PeepSo profile link.', 'peepso-wpforo' )
			);

		}
	}
endif;
