<?php
/**
 * Includes function related to peepso user's forum tab.
 *
 * @package Peepso_Wpforo_Integration
 * @author Wbcom Designs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Wpforo_Profile_Tab_Manager' ) ) :

	/**
	 * Includes all functions related to peepso user's forum tab.
	 *
	 * @class Wpforo_Profile_Tab_Manager
	 */
	class Wpforo_Profile_Tab_Manager {

		/**
		 * The single instance of the class.
		 *
		 * @var Wpforo_Profile_Tab_Manager
		 */
		protected static $_instance = null;
		/**
		 * Forums tab slug.
		 *
		 * @var $menu_slug
		 */
		public static $menu_slug = null;
		/**
		 * Forums tab name.
		 *
		 * @var $menu_name
		 */
		public static $menu_name = null;
		/**
		 * Main Wpforo_Profile_Tab_Manager Instance.
		 *
		 * Ensures only one instance of Wpforo_Profile_Tab_Manager is loaded or can be loaded.
		 *
		 * @return Wpforo_Profile_Tab_Manager - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$menu_slug = 'forums';
				self::$menu_name = esc_html__( 'Forums', 'peepso-wpforo' );
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Wpforo_Profile_Tab_Manager Constructor.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {
			$this->init_hooks();
		}

		/**
		 * Hook into actions and filters.
		 */
		private function init_hooks() {

			add_filter( 'peepso_navigation_profile', array( $this, 'add_tab_peepso_nav_profile' ), 10, 1 );
			add_filter( 'peepso_rewrite_profile_pages', array( &$this, 'peepso_rewrite_profile_pages' ) );
			add_action( 'peepso_profile_segment_' . self::$menu_slug, array( $this, 'peepso_render_wpforo_tab_content' ) );

			/*
			 filter to manage current template for wpforo to render correct content in peepso tab */
			// add_filter( 'wpforo_before_init_current_object', array( $this, 'alter_wpforo_before_init_current_object' ), 20, 2 );

			/*
			 filter to manage redirect after updating wpforo account form */
			add_filter( 'wp_redirect', array( $this, 'manage_redirect_wpforo_account_section' ), 10, 2 );

			/* filter to manage wpforo js on peepso profile page */
			add_filter( 'is_wpforo_page', array( $this, 'custom_peepso_wpforo_page' ), 50, 2 );
		}

		/**
		 * Check current page is wpforo page.
		 *
		 * @param bool   $is_wpforo The boolean value that decides current page is wpforo page or not.
		 * @param string $url The current page url.
		 * @since    1.0.0
		 */
		public function custom_peepso_wpforo_page( $is_wpforo, $url ) {
			$url_chunks = explode( '/', $url );
			foreach ( $url_chunks as $key => $url_chunk ) {
				if ( strpos( $url_chunk, self::$menu_slug ) !== false ) {
					$is_wpforo = true;
				}
			}

			return $is_wpforo;
		}

		/**
		 * Add wpforo nav tabs To PeepSo Profile Page.
		 *
		 * @param string $links Links.
		 * @since    1.0.0
		 */
		public function add_tab_peepso_nav_profile( $links ) {
			$wpforo_menus = $this->get_peepso_profile_displayed_submenu();
			if ( ! empty( $wpforo_menus ) ) {
				$links[ self::$menu_slug ] = array(
					'label' => self::$menu_name,
					'href'  => self::$menu_slug,
					'icon'  => 'ps-icon-edit peepso-wpforo-icon',
				);
			}
			return $links;
		}

		public function peepso_rewrite_profile_pages( $pages ) {
			return array_merge( $pages, array( 'forums' ) );
		}

		/**
		 * Manage render wpForo section in PeepSo profile page.
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function peepso_render_wpforo_tab_content() {
			$peepso_url_segments = PeepSoUrlSegments::get_instance();
			$key                 = $peepso_url_segments->get( 2 );
			$sub_key             = $peepso_url_segments->get( 3 );
			$wpforo_menus        = $this->get_peepso_profile_displayed_submenu();
			$shortcode           = PeepSoProfileShortcode::get_instance();
			$view_user_id        = PeepSoUrlSegments::get_view_id( $shortcode->get_view_user_id() );

			if ( ! empty( $wpforo_menus ) ) {
				if ( ! empty( $sub_key ) ) {
					$key = $sub_key;
				} elseif ( self::$menu_slug === $key ) {
					$key = $this->get_peepso_profile_default_submenu();
				}
				WPF()->current_object['template'] = $key;

				switch ( WPF()->current_object['template'] ) {
					case 'activity':
						$permalink = get_permalink();
						add_filter(
							'page_link',
							function( $link, $id, $sample ) use ( $peepso_url_segments, $permalink ) {
									return $permalink . $peepso_url_segments->get( 1 ) . '/' . $peepso_url_segments->get( 2 ) . '/' . $peepso_url_segments->get( 3 ) . '/';
							},
							99,
							3
						);

						$args                                = array(
							'offset'        => ( WPF()->current_object['paged'] - 1 ) * WPF()->post->get_option_items_per_page(),
							'row_count'     => WPF()->post->get_option_items_per_page(),
							'userid'        => $view_user_id,
							'orderby'       => '`created` DESC, `postid` DESC',
							'check_private' => true,
						);
						WPF()->current_object['items_count'] = 0;
						$activities                          = WPF()->post->get_posts( $args, WPF()->current_object['items_count'] );

						echo PeepSoTemplate::exec_template(
							'wpforo',
							'profile-activity',
							array(
								'current'      => $key,
								'main_tab'     => self::$menu_slug,
								'view_user_id' => $view_user_id,
								'submenus'     => $wpforo_menus,
								'activities'   => $activities,
							),
							true
						);
						break;

					case 'subscriptions':
						$permalink = get_permalink();
						add_filter(
							'page_link',
							function( $link, $id, $sample ) use ( $peepso_url_segments, $permalink ) {
									return $permalink . $peepso_url_segments->get( 1 ) . '/' . $peepso_url_segments->get( 2 ) . '/' . $peepso_url_segments->get( 3 ) . '/';
							},
							99,
							3
						);
						$args                                = array(
							'offset'    => ( WPF()->current_object['paged'] - 1 ) * WPF()->post->get_option_items_per_page(),
							'row_count' => WPF()->post->get_option_items_per_page(),
							'userid'    => $view_user_id,
							'order'     => 'DESC',
						);
						WPF()->current_object['items_count'] = 0;
						$subscribes                          = WPF()->sbscrb->get_subscribes( $args, WPF()->current_object['items_count'] );

						echo PeepSoTemplate::exec_template(
							'wpforo',
							'profile-subscriptions',
							array(
								'current'      => $key,
								'main_tab'     => self::$menu_slug,
								'view_user_id' => $view_user_id,
								'submenus'     => $wpforo_menus,
								'subscribes'   => $subscribes,
							),
							true
						);
						break;

					default:
						echo PeepSoTemplate::exec_template(
							'wpforo',
							'forums',
							array(
								'current'      => $key,
								'main_tab'     => self::$menu_slug,
								'view_user_id' => $view_user_id,
								'submenus'     => $wpforo_menus,
							),
							true
						);

						break;
				}
			}
		}

		/**
		 * Filter wpforo obj and pagination in PeepSo profile page.
		 *
		 * @since  1.0.0
		 * @return object $current_object
		 */
		public function alter_wpforo_before_init_current_object( $current_object, $wpf_url_parse ) {

			global $wbpwpforoi_peepso_wpforo_global_functions;
			if ( isset( $_SERVER['REQUEST_URI'] ) ) {

				$request_scheme      = ( is_ssl() ) ? 'https' : 'http';
				$current_url         = $request_scheme . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				$default_tab         = '';
				$displayed_user_id   = PeepSoProfileShortcode::get_instance()->get_view_user_id();
				$options             = PeepSoConfigSettings::get_instance();
				$peepso_user         = PeepSoUser::get_instance( $displayed_user_id );
				$profile_url         = $peepso_user->get_profileurl();
				$peepso_url_segments = PeepSoUrlSegments::get_instance();
				$main_key            = $peepso_url_segments->get( 2 );
				$sub_key             = $peepso_url_segments->get( 3 );
				$wpforo_menus        = $this->get_peepso_profile_displayed_submenu();
				$wpforo_slug         = self::$menu_slug;

				if ( ! empty( $wpforo_menus ) ) {
					if ( ! empty( $sub_key ) ) {
						$default_tab = $sub_key;
					} elseif ( 'forums' == $wpforo_slug ) {
						$default_tab = $this->get_peepso_profile_default_submenu();

					}
					if ( ! empty( $peepso_url_segments ) ) {
						if ( ( 'peepso_profile' === $peepso_url_segments->_shortcode ) ) {
							$displayed_user_id = PeepSoProfileShortcode::get_instance()->get_view_user_id();
							if ( ! $displayed_user_id ) {
								$displayed_user_id = get_current_user_id();
							}
						}
					}

					$url_chunks = explode( '/', $current_url );

					if ( ! empty( $default_tab ) ) {

						foreach ( $url_chunks as $key => $url_chunk ) {

							if ( strpos( $url_chunk, $wpforo_slug ) !== false ) {
								$current_object['template'] = $default_tab;
								$current_object['userid']   = $displayed_user_id;
								if ( ( isset( $url_chunks[ $key + 1 ] ) ) && ( $url_chunks[ $key + 1 ] == 'paged' ) && ( isset( $url_chunks[ $key + 2 ] ) ) ) {
									$current_object['paged'] = $url_chunks[ $key + 2 ];
									break;
								}
							}
						}
					}
				}
			}
			return $current_object;
		}

		/**
		 * Filter account tab url in PeepSo profile page.
		 *
		 * @since  1.0.0
		 * @param  string $location The url of account page.
		 * @param  string $status   The status.
		 * @return string $location The url of account page.
		 */
		public function manage_redirect_wpforo_account_section( $location, $status ) {
			if ( isset( $_POST['wpforo_form'] ) ) {
				$peepso_url_segments = PeepSoUrlSegments::get_instance();
				$key                 = '';
				$main_key            = $peepso_url_segments->get( 2 );
				$sub_key             = $peepso_url_segments->get( 3 );
				if ( ! empty( $sub_key ) ) {
					$key = $sub_key;
				} elseif ( self::$menu_slug === $main_key ) {
					$key = 'account';
				}
				if ( ( 'account' === $key ) && ( 'peepso_profile' === $peepso_url_segments->_shortcode ) ) {
					$peepso_user = PeepSoUser::get_instance( PeepSoProfileShortcode::get_instance()->get_view_user_id() );
					$profile_url = $peepso_user->get_profileurl();
					$location    = $profile_url . self::$menu_slug . '/' . 'account';
				}
			}

			return $location;
		}

		/**
		 * Get Displayed submenu.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string $wpforo_menus The submenus of current member profile.
		 */
		public function get_peepso_profile_displayed_submenu() {
			global $wbpwpforoi_peepso_wpforo_global_functions;
			$wpforo_menus        = array();
			$wpforo_menus        = $wbpwpforoi_peepso_wpforo_global_functions->wbpwpforoi_get_profile_menus();
			$options             = PeepSoConfigSettings::get_instance();
			$peepso_url_segments = PeepSoUrlSegments::get_instance();
			$displayed_user_id   = 0;
			foreach ( $wpforo_menus as $menu_key => $menu_value ) {
				$enable = $options->get_option( 'wpforo_enable_' . $menu_key );
				$enable = apply_filters( 'wpforo_show_tab_on_peepso_profile', $enable, $menu_key, $wpforo_menus );
				if ( $enable ) {
					if ( ! empty( $peepso_url_segments ) ) {
						if ( $peepso_url_segments->get( 1 ) ) {
							$user = get_user_by( 'slug', $peepso_url_segments->get( 1 ) );

							if ( false === $user ) {
								$displayed_user_id = get_current_user_id();
							} else {
								$displayed_user_id = $user->ID;
							}
						}
					}

					if ( ( $displayed_user_id !== get_current_user_id() ) || ! is_user_logged_in() ) {
						if ( $menu_key === 'profile' || $menu_key === 'activity' ) {
						} else {
							unset( $wpforo_menus[ $menu_key ] );
						}
					}
				} else {
					unset( $wpforo_menus[ $menu_key ] );
				}
			}

			return $wpforo_menus;
		}

		/**
		 * Get Default submenu.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string $default_tab The default submenu of current member profile.
		 */
		public function get_peepso_profile_default_submenu() {
			$submenus    = array();
			$submenus    = $this->get_peepso_profile_displayed_submenu();
			$default_tab = '';
			if ( ! empty( $submenus ) ) {
				$default     = key( $submenus );
				$default_tab = apply_filters( 'wpforo_peepso_default_tab', $default, $submenus );
			}

			return $default_tab;
		}

	}

endif;

/**
 * Main instance of Wpforo_Profile_Tab_Manager.
 *
 * @return Wpforo_Profile_Tab_Manager
 */
Wpforo_Profile_Tab_Manager::instance();
