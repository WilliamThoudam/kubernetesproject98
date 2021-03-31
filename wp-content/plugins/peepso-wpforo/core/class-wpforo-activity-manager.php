<?php
/**
 * Includes function related to wpForo activity.
 *
 * @package Peepso_Wpforo_Integration
 * @author Wbcom Designs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Peepso_Wpforo_Activity_Manager' ) ) :

	/**
	 * Includes all functions related to wpForo activity.
	 *
	 * @class Peepso_Wpforo_Activity_Manager
	 */
	class Peepso_Wpforo_Activity_Manager {


		/**
		 * The single instance of the class.
		 *
		 * @var Peepso_Wpforo_Activity_Manager
		 */
		protected static $_instance = null;
		/**
		 * Main Peepso_Wpforo_Activity_Manager Instance.
		 *
		 * Ensures only one instance of Peepso_Wpforo_Activity_Manager is loaded or can be loaded.
		 *
		 * @return Peepso_Wpforo_Activity_Manager - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Peepso_Wpforo_Activity_Manager Constructor.
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

			add_action( 'wpforo_after_add_topic', array( $this, 'create_peepso_activity_for_wpforo_add_topic' ), 10, 1 );
			add_filter( 'peepso_activity_post_content', array( $this, 'wpforo_activity_post_content' ), 15, 1 );

			add_action( 'wpforo_after_add_post', array( $this, 'create_peepso_activity_for_wpforo_add_reply' ), 10, 2 );
		}

		public function create_peepso_activity_for_wpforo_add_reply( $post, $topic ) {
			/* adding activity to peepso */
			$peepso_activity = new PeepSoActivity();
			$peepso_activity->add_post( $post['userid'], $post['userid'], $post['title'] . $post['body'] );
		}

		/**
		 * Create PeepSo activity for wpForo add topic action.
		 *
		 * @param array $args List of arguments used to create wpForo topic.
		 * @since 1.0.0
		 */
		public function create_peepso_activity_for_wpforo_add_topic( $args ) {
			/* adding activity to peepso */
			$peepso_activity = new PeepSoActivity();
			$peepso_activity->add_post( $args['userid'], $args['userid'], $args['title'] . $args['body'] );
		}

		/**
		 * Used for display purchase info as activity content.
		 *
		 * @param string $content By default activity content.
		 * @since    1.0.0
		 */
		public function wpforo_activity_post_content( $content ) {
			if ( isset( $_POST['wpforo_form'] ) && isset( $_POST['topic'] ) && isset( $_POST['postbody'] ) ) {
				$content = $_POST['topic']['title'] . '<br/>' . $_POST['postbody'];
			}
			return $content;
		}
	}

endif;

/**
 * Main instance of Peepso_Wpforo_Activity_Manager.
 *
 * @return Peepso_Wpforo_Activity_Manager
 */
Peepso_Wpforo_Activity_Manager::instance();
