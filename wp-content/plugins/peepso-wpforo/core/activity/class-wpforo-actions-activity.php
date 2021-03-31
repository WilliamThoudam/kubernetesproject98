<?php
/**
 * Includes function to add activity when user add topic or reply.
 *
 * @package Peepso_Wpforo_Integration
 * @author Wbcom Designs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Wpforo_Actions_Activity' ) ) :

	/**
	 * Includes function to add activity when user add topic or reply.
	 *
	 * @class Wpforo_Actions_Activity
	 */
	class Wpforo_Actions_Activity {


		/**
		 * The single instance of the class.
		 *
		 * @var $_instance
		 */
		protected static $_instance = null;
		/**
		 * WPForo activity setting name
		 *
		 * @var $setting_name
		 */
		public static $setting_name = null;
		/**
		 * WPForo purchase activity content setting name
		 *
		 * @var $setting_content
		 */
		public static $setting_content = null;

		/**
		 * Main Wpforo_Actions_Activity Instance.
		 *
		 * Ensures only one instance of Wpforo_Actions_Activity is loaded or can be loaded.
		 *
		 * @return Wpforo_Actions_Activity - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Wpforo_Actions_Activity Constructor.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {
			$this->init_hooks();
		}

		/**
		 * Hook into actions and filters.
		 *
		 * @since    1.0.0
		 */
		private function init_hooks() {

			add_action( 'wpforo_after_add_topic', array( $this, 'create_peepso_activity_for_wpforo_add_topic' ), 10, 1 );

			add_action( 'wpforo_after_add_post', array( $this, 'create_peepso_activity_for_wpforo_add_reply' ), 10, 2 );

			add_filter( 'peepso_activity_post_content', array( $this, 'wpforo_activity_post_content' ), 999, 1 );

			add_filter( 'peepso_activity_content_before', array( $this, 'wbpwpforoi_peepso_activity_content_before' ), 999, 1 );

			add_action( 'peepso_profile_notification_link', array( &$this, 'peepso_wpforo_filter_profile_notification_link' ), 10, 2 );

			add_filter( 'peepso_profile_alerts', array( &$this, 'peepso_wpforo_profile_alert' ), 10, 1 );

		}

		/**
		 * Filter PeepSo wpForo plugin activity content before display in frontend activity.
		 *
		 * @param string $content The content display on frontend.
		 * @since 1.0.0
		 */
		public function wbpwpforoi_peepso_activity_content_before( $content ) {
			global $post;
			$wbpwpforoi_activity  = get_post_meta( $post->ID, 'is_wbpwpforoi_activity', true );
			$wbforo_activity_type = get_post_meta( $post->ID, 'wbpwpforoi_activity_type', true );
			if ( $wbpwpforoi_activity ) {
				if ( 'tpc_crtd_act' === $wbforo_activity_type ) {
					$wbforo_activity_info = get_post_meta( $post->ID, 'wbpwpforoi_activity_info', true );
					$topicid              = $wbforo_activity_info['topic_id'];
					$topic_url            = WPF()->topic->get_topic_url( $topicid );
					$topic                = WPF()->topic->get_topic( $topicid );
					$topic_author_id      = get_the_author_meta( 'ID', $topic['userid'] );
					$peepso_author        = PeepSoUser::get_instance( $topic_author_id );
					$author_link          = $peepso_author->get_profileurl();
					$author_name          = $peepso_author->get_firstname();
					// $content_excerpt      = wp_trim_words( $content, 55 );
					$content_excerpt = $this->wbpwpforoi_default_attachments_filter( $content );
					$content         = __( 'A new topic ', 'peepso-wpforo' ) . '<a href ="' . $topic_url . '">' . __( $topic['title'], 'peepso-wpforo' ) . '</a>' . __( ' added by ', 'peepso-wpforo' ) . '<a href ="' . $author_link . '">' . __( $author_name, 'peepso-wpforo' ) . '.</a><br><br>' . $content_excerpt;
					// $content              = apply_filters( 'filter_new_topic_activity', $content, $topicid, $post->ID );
					// $content              = __( 'A new topic ', 'peepso-wpforo' ) . '<a href ="' . $topic_url . '">' . __( $topic['title'], 'peepso-wpforo' ) . '</a>' . __( ' added by ', 'peepso-wpforo' ) . '<a href ="' . $author_link . '">' . __( $author_name, 'peepso-wpforo' ) . '.</a><br><br>'. $content_excerpt;
					// $content              = apply_filters( 'filter_new_topic_activity', $content, $topicid, $post->ID );
				} else {
					$wbforo_activity_info = get_post_meta( $post->ID, 'wbpwpforoi_activity_info', true );
					$replyid              = $wbforo_activity_info['reply_id'];
					$replyurl             = $wbforo_activity_info['reply_url'];
					$reply                = WPF()->post->get_post( $replyid );
					$reply_author_id      = get_the_author_meta( 'ID', $reply['userid'] );
					$peepso_author        = PeepSoUser::get_instance( $reply_author_id );
					$author_link          = $peepso_author->get_profileurl();
					$author_name          = $peepso_author->get_firstname();
					$content_excerpt      = wp_trim_excerpt( $content );
					$content              = __( 'A new reply ', 'peepso-wpforo' ) . '<a href ="' . $replyurl . '">' . __( $reply['title'], 'peepso-wpforo' ) . '</a>' . __( ' added by ', 'peepso-wpforo' ) . '<a href ="' . $author_link . '">' . __( $author_name, 'peepso-wpforo' ) . '.</a><br><br>' . $content;
					$content              = apply_filters( 'filter_new_reply_activity', $content, $replyid, $post->ID );
				}
			}
			return $content;
		}
		/**
		 * @param $text
		 * @return string|string[]
		 * Filter forum attachments.
		 */
		public function wbpwpforoi_default_attachments_filter( $text ) {
			if ( preg_match_all( '#<a[^<>]*class=[\'"]wpforo-default-attachment[\'"][^<>]*href=[\'"]([^\'"]+)[\'"][^<>]*>[\r\n\t\s\0]*(?:<i[^<>]*>[\r\n\t\s\0]*</i>[\r\n\t\s\0]*)?([^<>]*)</a>#isu', $text, $matches, PREG_SET_ORDER ) ) {
				foreach ( $matches as $match ) {
					$attach_html = '';
					$fileurl     = preg_replace( '#^https?\:#is', '', $match[1] );
					$filename    = $match[2];

					$upload_array = wp_upload_dir();
					$filedir      = preg_replace( '#^https?\:#is', '', str_replace( preg_replace( '#^https?\:#is', '', $upload_array['baseurl'] ), $upload_array['basedir'], $fileurl ) );
					$filedir      = str_replace( basename( $filedir ), urldecode( basename( $filedir ) ), $filedir );

					if ( file_exists( $filedir ) ) {
						if ( ! WPF()->perm->forum_can( 'va' ) ) {
							$attach_html .= '<br/><div class="wpfa-item wpfa-file"><a class="attach_cant_view" style="cursor:pointer;" href="' . $fileurl . '" target="_blank" rel="noopener">' . urldecode( basename( $filename ) ) . '</a></div>';
						}
					}

					if ( $attach_html ) {
						$attach_html .= '<br/>';
						$text         = str_replace( $match[0], $attach_html, $text );
					}
				}
			}
			return $text;
		}

		/**

		 * Create PeepSo activity for wpForo add topic action.
		 *
		 * @param array $topic List of arguments used to create wpForo topic.
		 * @since 1.0.0
		 */
		public function create_peepso_activity_for_wpforo_add_topic( $topic ) {

			/* adding activity to peepso */
			if ( ! $topic['status'] && ! $topic['private'] ) {
				// Get first post
				$post = WPF()->post->get_post( $topic['first_postid'] );

				if ( 1 == PeepSo::get_option( 'wpforo_topic_notification_setting_display', 1 ) ) {
					$PeepSoNotifications = new PeepSoNotifications();
					$forum_title         = wpforo_forum( $topic['forumid'], 'title' );
					$title               = sprintf( __( 'created a topic in a subscribed forum: %s', 'peepso-wpforo' ), $forum_title );

					$forums_sbs = WPF()->sbscrb->get_subscribes(
						array(
							'itemid' => 0,
							'type'   => array(
								'forums',
								'forums-topics',
							),
						)
					);
					$forum_sbs  = WPF()->sbscrb->get_subscribes(
						array(
							'itemid' => $topic['forumid'],
							'type'   => array(
								'forum',
								'forum-topic',
							),
						)
					);

					$subscribers = array_merge( $forums_sbs, $forum_sbs );

					foreach ( $subscribers as $subscriber ) {
						if ( is_array( $subscriber ) ) {
							if ( $subscriber['userid'] ) {
								$member = WPF()->member->get_member( $subscriber['userid'] );
							} elseif ( $subscriber['user_email'] ) {
								 $member = array(
									 'groupid'      => 4,
									 'display_name' => ( $subscriber['user_name'] ? $subscriber['user_name'] : $subscriber['user_email'] ),
									 'user_email'   => $subscriber['user_email'],
								 );
							} else {
								continue;
							}
						} else {
							$member = array(
								'display_name' => $subscriber,
								'user_email'   => $subscriber,
							);
						}
						$PeepSoNotifications->add_notification( $topic['userid'], $member['userid'], $title, 'wpforo_sub_new_topic', Peepso_Wpforo_Integration_MODULE_ID, $post['postid'] );
					}
				}

				$enable = PeepSoConfigSettings::get_instance()->get_option( 'wpforo_topic_activity_setting_display' );
				if ( $enable ) {
					$meta_prefix                     = 'peepso_';
					$wbpwpforoi_activity_manager     = new Wpforo_Activity_Settings_Manager();
					$wpforo_enable_tpc_crtd_activity = $wbpwpforoi_activity_manager->wbpwpforoi_user_meta( $meta_prefix . 'wpforo_enable_tpc_crtd_activity', $topic['userid'] );
					$wpforo_enable_tpc_crtd_activity = apply_filters( 'alter_wpforo_enable_tpc_crtd_activity', $wpforo_enable_tpc_crtd_activity, $wbpwpforoi_activity_manager, $topic );
					if ( $wpforo_enable_tpc_crtd_activity ) {

						$extra = array(
							'module_id'     => Peepso_Wpforo_Integration_MODULE_ID,
							'act_access'    => PeepSo::ACCESS_PUBLIC,
							'post_date_gmt' => date( 'Y-m-d H:i:s', time() ),
						);

						$peepso_activity = new PeepSoActivity();
						set_transient( 'wpforo_topicurl_transient', $topic['topicurl'] );
						$peepso_post_id = $peepso_activity->add_post( $topic['userid'], $topic['userid'], $topic['body'], $extra );
						update_post_meta( $peepso_post_id, 'is_wbpwpforoi_activity', true );
						update_post_meta( $peepso_post_id, 'wbpwpforoi_activity_type', 'tpc_crtd_act' );
						$wbpwpforoi_activity_info = array( 'topic_id' => $topic['topicid'] );
						update_post_meta( $peepso_post_id, 'wbpwpforoi_activity_info', $wbpwpforoi_activity_info );
					}
				}
			}
		}

		/**
		 * Create PeepSo activity for wpForo add reply action.
		 *
		 * @param array $post List of arguments used to create wpForo reply.
		 * @param array $topic List of arguments related to wpForo topic.
		 * @since 1.0.0
		 */
		public function create_peepso_activity_for_wpforo_add_reply( $post, $topic ) {
			/* adding activity to peepso */
			if ( ! $post['status'] && ! $post['private'] ) {
				if ( 1 == PeepSo::get_option( 'wpforo_reply_notification_setting_display', 1 ) ) {
					$PeepSoNotifications = new PeepSoNotifications();

					// Send notification to topic author
					$title = sprintf( __( 'replied to your topic: %s', 'peepso-wpforo' ), $topic['title'] );

					// Don't send notification if post auhor is topic author
					if ( get_current_user_id() != $topic['userid'] ) {
						$PeepSoNotifications->add_notification( $post['userid'], $topic['userid'], $title, 'wpforo_topic_new_post', Peepso_Wpforo_Integration_MODULE_ID, $post['postid'] );
					}

					// Send notification to topic subscribers
					global $wpdb;

					$topic_sub_ids         = $wpdb->get_col( "SELECT userid FROM {$wpdb->prefix}wpforo_subscribes WHERE itemid = {$topic['topicid']} AND type = 'topic'" );
					$forums_sub_ids        = $wpdb->get_col( "SELECT userid FROM {$wpdb->prefix}wpforo_subscribes WHERE (itemid = {$post['forumid']} OR itemid = 0) AND type = 'forums'" );
					$forums_topics_sub_ids = $wpdb->get_col( "SELECT userid FROM {$wpdb->prefix}wpforo_subscribes WHERE (itemid = {$post['forumid']} OR itemid = 0) AND type = 'forums-topics'" );

					$sub_ids = array_unique( array_merge( $topic_sub_ids, $forums_sub_ids, $forums_topics_sub_ids ), SORT_REGULAR );
					foreach ( $sub_ids as $sub_id ) {
						$title = sprintf( __( 'replied to a subscribed topic: %s', 'peepso-wpforo' ), $topic['title'] );

						// Don't send notification if subscriber is post or topic author
						if ( get_current_user_id() != $sub_id && $sub_id != $topic['userid'] ) {
							$PeepSoNotifications->add_notification( $post['userid'], $sub_id, $title, 'wpforo_sub_topic_new_post', Peepso_Wpforo_Integration_MODULE_ID, $post['postid'] );
						}
					}
				}
			}
			$enable = PeepSoConfigSettings::get_instance()->get_option( 'wpforo_reply_activity_setting_display' );
			if ( $enable ) {
				$meta_prefix                       = 'peepso_';
				$wbpwpforoi_activity_manager       = new Wpforo_Activity_Settings_Manager();
				$wpforo_enable_reply_crtd_activity = $wbpwpforoi_activity_manager->wbpwpforoi_user_meta( $meta_prefix . 'wpforo_enable_reply_crtd_activity', $post['userid'] );
				$wpforo_enable_reply_crtd_activity = apply_filters( 'alter_wpforo_enable_reply_crtd_activity', $wpforo_enable_reply_crtd_activity, $wbpwpforoi_activity_manager, $post, $topic );
				if ( $wpforo_enable_reply_crtd_activity ) {

					$extra = array(
						'module_id'     => Peepso_Wpforo_Integration_MODULE_ID,
						'act_access'    => PeepSo::ACCESS_PUBLIC,
						'post_date_gmt' => date( 'Y-m-d H:i:s', time() ),
					);

					$peepso_activity = new PeepSoActivity();
					set_transient( 'wpforo_reply_transient', $post['posturl'] );
					$peepso_post_id = $peepso_activity->add_post( $post['userid'], $post['userid'], $post['body'], $extra );
					update_post_meta( $peepso_post_id, 'is_wbpwpforoi_activity', true );
					update_post_meta( $peepso_post_id, 'wbpwpforoi_activity_type', 'reply_crtd_act' );
					add_post_meta( $peepso_post_id, 'peepsowpforo_parent_id', $post['postid'] );
					add_post_meta( $peepso_post_id, 'peepsowpforo_type_post_url', $post['posturl'] );
					$wbpwpforoi_activity_info = array(
						'reply_id'  => $post['postid'],
						'reply_url' => $post['posturl'],
					);
					update_post_meta( $peepso_post_id, 'wbpwpforoi_activity_info', $wbpwpforoi_activity_info );
				}
			}
		}

		/**
		 * Used for display purchase info as activity content.
		 *
		 * @param string $content By default activity content.
		 * @since    1.0.0
		 */
		public function wpforo_activity_post_content( $content ) {

			if ( isset( $_POST['wpforo_form'] ) && isset( $_POST['topic'] ) && isset( $_POST['postbody'] ) ) {
				$topic_url = get_transient( 'wpforo_topicurl_transient' );
				$content   = '<a href ="' . $topic_url . '">' . __( $_POST['topic']['title'], 'peepso-wpforo' ) . '</a><br>' . $_POST['postbody'];
				delete_transient( 'wpforo_topicurl_transient' );
			} elseif ( isset( $_POST['wpforo_form'] ) && isset( $_POST['post'] ) && isset( $_POST['postbody'] ) ) {
				$reply_url = get_transient( 'wpforo_reply_transient' );
				$content   = '<a href ="' . $reply_url . '">' . __( $_POST['post']['title'], 'peepso-wpforo' ) . '</a><br>' . $_POST['postbody'];
				delete_transient( 'wpforo_reply_transient' );
			}
			return $content;
		}

		/**
		 * Add profile alerts
		 *
		 * @param  array
		 * @return array
		 */
		public function peepso_wpforo_profile_alert( $alerts ) {
			$items_topic_new_post = array(
				array(
					'label'   => __( 'Someone replies to your topic', 'peepso-wpforo' ),
					'setting' => 'wpforo_topic_new_post',
					'loading' => true,
				),
				array(
					'label'   => __( 'Someone replies to a subscribed topic', 'peepso-wpforo' ),
					'setting' => 'wpforo_sub_topic_new_post',
					'loading' => true,
				),
			);

			$items_new_topic = array(
				array(
					'label'   => __( 'Someone creates a topic in a subscribed forum', 'peepso-wpforo' ),
					'setting' => 'wpforo_sub_new_topic',
					'loading' => true,
				),
			);

			if ( 0 == PeepSo::get_option( 'wpforo_reply_notification_setting_display', 1 ) && 0 == PeepSo::get_option( 'wpforo_topic_notification_setting_display', 1 ) ) {
				return ( $alerts );
			} elseif ( 0 == PeepSo::get_option( 'wpforo_reply_notification_setting_display', 1 ) ) {
				$alerts['wpforo'] = array(
					'title' => __( 'Forum', 'peepso-wpforo' ),
					'items' => $items_new_topic,
				);
			} elseif ( 0 == PeepSo::get_option( 'wpforo_topic_notification_setting_display', 1 ) ) {
				$alerts['wpforo'] = array(
					'title' => __( 'Forum', 'peepso-wpforo' ),
					'items' => $items_topic_new_post,
				);
			} else {
				$alerts['wpforo'] = array(
					'title' => __( 'Forum', 'peepso-wpforo' ),
					'items' => array_merge( $items_topic_new_post, $items_new_topic ),
				);
			}

			return ( $alerts );

		}


		/**
		 * Change notification links to forum post links
		 */
		public function peepso_wpforo_filter_profile_notification_link( $link, $note_data ) {
			global $wpdb;

			$not_types = array(
				'wpforo_topic_new_post',
				'wpforo_sub_topic_new_post',
				'wpforo_sub_new_topic',
			);

			$forum_post_id = $note_data['not_external_id'];
			$post_id       = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value = %d", 'peepsowpforo_parent_id', $forum_post_id ) );

			$not_type = $note_data['not_type'];

			if ( in_array( $not_type, $not_types ) ) {
				$link = get_post_meta( $post_id, 'peepsowpforo_type_post_url', true );
			}
			return $link;
		}

	}

endif;

/**
 * Main instance of Wpforo_Actions_Activity.
 *
 * @return Wpforo_Actions_Activity
 */
Wpforo_Actions_Activity::instance();
