<?php
/**
 * Includes function to add activity settings in user profile under preferences tab.
 *
 * @package WBPWPFOROI_PeepSo_WpForo_Integration
 * @author Wbcom Designs
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (! class_exists('Wpforo_Activity_Settings_Manager')) :

    /**
     * Includes function to add activity settings in front end.
     *
     * @class Wpforo_Activity_Settings_Manager
     */
    class Wpforo_Activity_Settings_Manager
    {

        /**
         * The single instance of the class.
         *
         * @var $_instance
         */
        protected static $_instance = null;

        /**
         * Main Wpforo_Activity_Settings_Manager Instance.
         *
         * Ensures only one instance of Wpforo_Activity_Settings_Manager is loaded or can be loaded.
         *
         * @since    1.0.0
         * @return Wpforo_Activity_Settings_Manager - Main instance.
         */
        public static function instance()
        {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Wpforo_Activity_Settings_Manager Constructor.
         *
         * @since    1.0.0
         */
        public function __construct()
        {
            $this->init_hooks();
        }

        /**
         * Hook into actions and filters.
         *
         * @since    1.0.0
         */
        private function init_hooks()
        {

            add_filter('peepso_profile_preferences', array( $this, 'wbpwpforoi_peepso_preference_activity_settings' ), 15, 1);
            add_filter( 'wpforo_profile_url', array( $this, 'wbpwpforoi_filter_profile_url' ), 10, 3 );
        }

        /**
         * Filter all profile url on wpforo pages.
         *
         * @param string $profile_url User wpforo Profile url.
         * @param array $member Includes all member's dat.
         * @param string $template Template name.
         * @since    1.0.0
         */
        public function wbpwpforoi_filter_profile_url( $profile_url, $member, $template ) {
            $options = PeepSoConfigSettings::get_instance();
            $enable  = $options->get_option('wpforo_profile_link_setting_display');
            if( $enable ) {
                $peepso_author = PeepSoUser::get_instance( $member['ID'] );
                $profile_url   = $peepso_author->get_profileurl();
            }
            return $profile_url;
        }

        /**
         * Filter for add WpForo activity settings in PeepSo Preferences settings.
         *
         * @param array $pref Includes all preferences settings.
         * @since    1.0.0
         */
        public function wbpwpforoi_peepso_preference_activity_settings($pref)
        {
            $meta_prefix             = 'peepso_';
            $options                 = PeepSoConfigSettings::get_instance();
            $enable                  = $options->get_option('wpforo_topic_activity_setting_display');
            $activity_setting_fields = array();
            if ($enable) {
                $peepso_setting_name                             = $meta_prefix . 'wpforo_enable_tpc_crtd_activity';
                $activity_setting_fields[ $peepso_setting_name ] = array(
                    'label-desc' => __('Add activity when new topic created.', 'peepso-wpforo'),
                    'value'      => $this->wbpwpforoi_user_meta($peepso_setting_name, get_current_user_id()),
                    'type'       => 'yesno_switch',
                    'loading'    => true,
                );
            }

            $enable = $options->get_option('wpforo_reply_activity_setting_display');
            if ($enable) {
                $peepso_setting_name                             = $meta_prefix . 'wpforo_enable_reply_crtd_activity';
                $activity_setting_fields[ $peepso_setting_name ] = array(
                    'label-desc' => __('Add activity when new reply created.', 'peepso-wpforo'),
                    'value'      => $this->wbpwpforoi_user_meta($peepso_setting_name, get_current_user_id()),
                    'type'       => 'yesno_switch',
                    'loading'    => true,
                );
            }

            if (! empty($activity_setting_fields)) {
                $activity_settings = array(
                    'wbpwpforoi_wpforo_activity_settings' => array(
                        'title' => __('WpForo Activity Settings', 'peepso-wpforo'),
                        'items' => $activity_setting_fields,
                    ),
                );
                $pref              = array_merge($pref, $activity_settings);
            }
            return $pref;
        }

        /**
         * Used for get user meta.
         *
         * @since    1.0.0
         * @param string $meta_key User meta key.
         * @param int    $user_id The user id to get user meta value.
         * @return string $meta user meta if meta key exists else return 0.
         */
        public function wbpwpforoi_user_meta($meta_key, $user_id)
        {
            $meta = get_user_meta($user_id, $meta_key, true);
            return ( ( '' !== $meta ) ? $meta : 0 );
        }
    }

endif;

/**
 * Main instance of Wpforo_Activity_Settings_Manager.
 *
 * @return Wpforo_Activity_Settings_Manager
 */
add_action(
    'peepso_init',
    function () {
        Wpforo_Activity_Settings_Manager::instance();
    }
);
