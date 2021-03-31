<?php
/**
 * Plugin Name: PeepSo Early Access
 * Plugin URI: https://PeepSo.com
 * Description: Early Access to PeepSo Labs (future features)
 * Author: PeepSo
 * Version: 3.0.3.0
 * Author URI: https://peepso.com
 * Copyright: (c) 2017 PeepSo, Inc. All Rights Reserved.
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: peepso-push
 * Domain Path: /language
 *
 * We are Open Source. You can redistribute and/or modify this software under the terms of the GNU General Public License (version 2 or later)
 * as published by the Free Software Foundation. See the GNU General Public License or the LICENSE file for more details.
 * This software is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY.
 */


class PeepSoEarlyAccessPlugin
{
    private static $_instance = NULL;

    const PLUGIN_NAME    = 'Early Access';
    const PLUGIN_VERSION = '3.0.3.0';
    const PLUGIN_RELEASE = ''; //ALPHA1, BETA1, RC1, '' for STABLE

    const PLUGIN_EDD = 31576215;
    const PLUGIN_SLUG = 'peepso-early-access';

    const ICON = 'https://www.peepso.com/assets/plugins/beta/icon.svg';

    public $areas = [

        /** DONE **/


        /** RC **/

        /** BETA **/

        'social_login' =>  [
            'name' =>  'Social Login & Invitations',
            'desc' => 'Enables the Social Login & Invitations plugin. You still need to install and activate the <b>PeepSo Integrations: Social Login & invitations plugin</b>.',
            'state' => 'BETA',
            'production' => FALSE,
            'support' => TRUE,
            'feedback' => TRUE,
        ],

        'web_push' =>  [
            'name' =>  'Web Push Notifications',
            'desc' => 'Enable Web Push Notifications in supported desktop browsers. Works in compatible desktop and  Android browsers. Does NOT work on iOS. NOT related to mobile apps.<br/>When enabled, you will find a <b>Web Push</b> configuration box in <b>PeepSo > Configuration > Notifications</b>. <br/><b>GMP</b> PHP Extension is required',
            'state' => 'BETA',
            'production' => FALSE,
            'support' => FALSE,
            'feedback' => TRUE,
        ],



        /** ALPHA **/

        'seo' =>  [
            'name' =>  'XML Sitemaps',
            'desc' => 'Use WP XML Sitemaps to improve SEO and let Google index your site.<br/>No additional settings, applies immediately when enabled.',
            'state' => 'ALPHA',
            'production' => FALSE,
            'support' => FALSE,
            'feedback' => FALSE,
        ],

//        'max_video_length' =>  [
//            'name' =>  'Max video length',
//            'desc' => 'Reject video uploads above certain length.<br/>When enabled,  new config will be available in <b>PeepSo > Audio & Video</b>',
//            'state' => 'ALPHA',
//            'production' => FALSE,
//            'support' => FALSE,
//            'feedback' => FALSE,
//        ],
        'new_search' =>  [
            'name' =>  'New Search',
            'desc' => 'New AJAX driven "search everywhere" engine. Capable of searching all areas of PeepSo, plus WordPress Posts, Pages and some CPTs. Very early proof of concept.<br/>When enabled, you will find a <b>PeepSo Search</b> Widget in  <b>Appearance > Widgets</b>.',
            'state' => 'ALPHA',
            'production' => FALSE,
            'support' => FALSE,
            'feedback' => FALSE,
        ],

    ];

    private static function ready() {
        if(class_exists('PeepSo')) {
            $plugin_version = explode('.', self::PLUGIN_VERSION);
            $peepso_version = explode('.', PeepSo::PLUGIN_VERSION);

            if(4==count($plugin_version)) {
                array_pop($plugin_version);
            }

            if(4==count($peepso_version)) {
                array_pop($peepso_version);
            }

            $plugin_version = implode('.', $plugin_version);
            $peepso_version = implode('.', $peepso_version);

            return($peepso_version == $plugin_version);
        }
    }

    public function __construct() {
        /** VERSION INDEPENDENT hooks **/

        // Admin
        if (is_admin()) {
            add_action('admin_init', array(&$this, 'peepso_check'));

            add_filter('peepso_license_config', function($list){
                $data = array(
                    'plugin_slug' => self::PLUGIN_SLUG,
                    'plugin_name' => self::PLUGIN_NAME,
                    'plugin_edd' => self::PLUGIN_EDD,
                    'plugin_version' => self::PLUGIN_VERSION
                );
                $list[] = $data;
                return ($list);
            });
        }

        // Compatibility
        add_filter('peepso_all_plugins', function($plugins){
            $plugins[plugin_basename(__FILE__)] = get_class($this);
            return $plugins;
        });

        // Translations
        add_action('plugins_loaded', function(){
            $path = str_ireplace(WP_PLUGIN_DIR, '', dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'language' . DIRECTORY_SEPARATOR;
            load_plugin_textdomain('peepso-push', FALSE, $path);
        });

        // Activation
        register_activation_hook(__FILE__, array($this, 'activate'));

        /** VERSION LOCKED hooks **/
        if (self::ready()) {
            add_action('peepso_init', array(&$this, 'init'));
        }


        add_action('wp_ajax_push_subscribe', function() {
            global $wpdb;

            $wpdb->insert($wpdb->prefix . 'peepso_push_notification_subscriber', [
                'user_id' => get_current_user_id(),
                'auth_token' => $_POST['authToken'],
                'public_key' => $_POST['publicKey'],
                'endpoint' => $_POST['endpoint']
            ]);
        });
    }

    /**
     * Retrieve singleton class instance
     * @return peepso-push instance
     */
    public static function get_instance()
    {
        if (NULL === self::$_instance) {
            self::$_instance = new self();
        }
        return (self::$_instance);
    }


    public function init()
    {
        PeepSo::add_autoload_directory(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR);
        // PeepSoTemplate::add_template_directory(plugin_dir_path(__FILE__));

        if (is_admin()) {
            add_action('admin_init', array(&$this, 'peepso_check'));


            add_filter('peepso_admin_config_tabs', 			function($tabs){
                $tabs['early-access'] = array(
                    'label' => __('Early Access', 'groupso'),
                    'icon' => self::ICON,
                    'tab' => 'early-access',
                    'description' => 'Early Access',
                    'function' => 'PeepSoConfigSectionEarlyAccess',
                    'cat' => 'foundation-advanced',
                );

                return $tabs;
            });

        } else {
            // enqueue required
            add_action('wp_enqueue_scripts', function() {
                $user_id = get_current_user_id();
                if (PeepSo3_Web_Push::user_web_push()) {
                    wp_register_script(
                        'peepso-push-notification',
                        PeepSo::get_asset('js/notification.js', __FILE__),
                        ['jquery'],
                        TRUE
                    );

                    wp_localize_script('peepso-push-notification', 'peepso_push_notification', [
                        'ajax_url' => admin_url('admin-ajax.php'),
                        'plugin_url' => plugin_dir_url(__FILE__),
                        'public_key' => PeepSo::get_option_new('web_push_public_key'),
                    ]);

                    wp_enqueue_script('peepso-push-notification');
                }
            });

            add_action('peepso_action_create_notification_after', function($id) {
                global $wpdb;
                $notif = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "peepso_notifications WHERE not_id = " . $id);

                // If the Web Push feature is disabled in EA, Config or User Preference
                if(!PeepSo3_Web_Push::user_web_push($notif->not_user_id)) {
                    return;
                }

                $post = get_post($notif->not_external_id);

                $profile = PeepSoProfile::get_instance();

                $data = get_object_vars($notif);
                $data['post_title'] = $post->post_title;

                ob_start();
                $profile->notification_link(1, $data);
                $notification_message = ob_get_clean();
                $peepso_user = PeepSoUser::get_instance($notif->not_from_user_id);

                $avatar = $peepso_user->get_avatar();
                $message = $peepso_user->get_firstname() . ' ' . trim($notif->not_message,' .') . $notification_message;
                $url = $profile->notification_link(0, $data);

                $this->begin_send_notification($notif->not_user_id, $message, $avatar, $url);
            });

            add_action('peepso_friends_requests_after_add', function($from_id, $to_id) {
                // If the Web Push feature is disabled in EA, Config or User Preference
                if(!PeepSo3_Web_Push::user_web_push($to_id)) {
                    return;
                }

                $peepso_user = PeepSoUser::get_instance($from_id);
                $message = $peepso_user->get_firstname() . ' ' . __('sent you a friend request', 'peepso-core');
                $avatar = $peepso_user->get_avatar();
                $url = $peepso_user->get_profileurl();

                $this->begin_send_notification($to_id, $message, $avatar, $url);
            }, 10, 2);

            add_action('peepso_action_add_message_recipient_after', function($data) {
                // If the Web Push feature is disabled in EA, Config or User Preference
                if(!PeepSo3_Web_Push::user_web_push($data['mrec_user_id']) || $data['mrec_user_id'] == get_current_user_id()) {
                    return;
                }

                $post = get_post($data['mrec_msg_id']);

                $peepso_user = PeepSoUser::get_instance(get_current_user_id());

			    $peepso_messages = PeepSoMessages::get_instance();
                $avatar = $peepso_user->get_avatar();
                $url = $peepso_messages->get_message_url($data['mrec_msg_id']);
                $message = $peepso_user->get_firstname() . ' ' . __('sent you a message', 'peepso-core') . ': ' . $post->post_content;

                $this->begin_send_notification($data['mrec_user_id'], $message, $avatar, $url);
            });
        }
    }

    public function begin_send_notification($user_id, $message, $avatar, $url)
    {
        require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

        global $wpdb;

        $subscribers = $this->get_subscribers($user_id);

        if (count($subscribers)) {
            $web_push = $this->create_web_push_instance();

            foreach ($subscribers as $subscriber) {
                $subscription = \Minishlink\WebPush\Subscription::create([
                    'endpoint' => $subscriber->endpoint,
                    'authToken' => $subscriber->auth_token,
                    'publicKey' => $subscriber->public_key
                ]);

                $web_push->queueNotification(
                    $subscription,
                    json_encode([
                        'title' => get_bloginfo('name'),
                        'msg' => $message,
                        'url' => $url,
                        'badge' => plugin_dir_url(__FILE__) . 'assets/images/badge.png',
                        'icon' => $avatar,
                    ])
                );
            }

            foreach ($web_push->flush() as $report) {
                $endpoint = $report->getRequest()->getUri()->__toString();

                if (!$report->isSuccess()) {
                    // remove from table
                    $wpdb->query($wpdb->prepare("DELETE FROM " . $wpdb->prefix . "peepso_push_notification_subscriber WHERE endpoint = %s", $endpoint));
                    new PeepSoError("Web Push FAIL for subscription {$endpoint}: {$report->getReason()}");
                } else {
                    // echo ("[v] Message sent successfully for subscription {$endpoint}.");
                }
            }
        }
    }

    public function create_web_push_instance()
    {
        $auth = array(
            'VAPID' => array(
                'subject' => home_url(),
                'publicKey' => PeepSo::get_option_new('web_push_public_key'),
                'privateKey' => PeepSo::get_option_new('web_push_private_key')
            ),
        );

        return new \Minishlink\WebPush\WebPush($auth);

    }

    public function get_subscribers($user_id)
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "peepso_push_notification_subscriber WHERE user_id = " . $user_id);
    }

    /**
     * Check if PeepSo class is present (ie the PeepSo plugin is installed and activated)
     * If there is no PeepSo, immediately disable the plugin and display a warning
     * Run license and new version checks against PeepSo.com
     * @return bool
     */
    public function peepso_check()
    {
        if (!class_exists('PeepSo')) {
            add_action('admin_notices', array(&$this, 'peepso_disabled_notice'));
            unset($_GET['activate']);
            deactivate_plugins(plugin_basename(__FILE__));
            return (FALSE);
        }

        // PeepSo.com license check
        if (!PeepSoLicense::check_license(self::PLUGIN_EDD, self::PLUGIN_SLUG)) {
            add_action('admin_notices', array(&$this, 'license_notice'));
        }

        if (isset($_GET['page']) && 'peepso_config' == $_GET['page'] && !isset($_GET['tab'])) {
            add_action('admin_notices', array(&$this, 'license_notice_forced'));
        }

        // PeepSo.com new version check
        // since 1.7.6
        if(method_exists('PeepSoLicense', 'check_updates_new')) {
            PeepSoLicense::check_updates_new(self::PLUGIN_EDD, self::PLUGIN_SLUG, self::PLUGIN_VERSION, __FILE__);
        }

        return (TRUE);
    }

    public function license_notice()
    {
        PeepSo::license_notice(self::PLUGIN_NAME, self::PLUGIN_SLUG);
    }

    public function license_notice_forced()
    {
        PeepSo::license_notice(self::PLUGIN_NAME, self::PLUGIN_SLUG, true);
    }

    /**
     * Display a message about PeepSo not present
     */
    public function peepso_disabled_notice()
    {
        ?>
        <div class="error peepso">
            <strong>
                <?php
				echo sprintf(__('The %s plugin requires the PeepSo plugin to be installed and activated.', 'peepso-push'), self::PLUGIN_NAME),
                    ' <a href="plugin-install.php?tab=plugin-information&amp;plugin=peepso-core&amp;TB_iframe=true&amp;width=772&amp;height=291" class="thickbox">',
                    __('Get it now!', 'peepso-push'),
                    '</a>';
                ?>
            </strong>
        </div>
        <?php
    }

    /**
     * Activation hook for the plugin.
     *
     * @since 1.0.0
     */
    public function activate() {

        if (!$this->peepso_check()) {
            return (FALSE);
        }

        // create table
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "peepso_push_notification_subscriber (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            endpoint text NOT NULL,
            auth_token varchar(255) NOT NULL,
            public_key varchar(255) NOT NULL,
            user_id integer NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        dbDelta($sql);

        return (TRUE);
    }

}

PeepSoEarlyAccessPlugin::get_instance();
