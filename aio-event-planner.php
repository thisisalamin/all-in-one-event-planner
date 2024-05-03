<?php
/**
 * Plugin Name: All-in-One Event Planner
 * Plugin URI: https://wordpress.org/plugins/aio-event-planner/
 * Description: All-in-One Event Planner is a plugin that allows you to create and manage events on your website.
 * Version: 1.0
 * Author: ByteDazzle
 * Author URI: https://bytedazzle.com/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: aio-event-planner
 * Domain Path: /languages
 */

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define AIO_EVENT_PLANNER_PLUGIN_FILE.
if ( ! defined( 'AIO_EVENT_PLANNER_PLUGIN_FILE' ) ) {
	define( 'AIO_EVENT_PLANNER_PLUGIN_FILE', __FILE__ );
}

// Include the main AIO_Event_Planner class.
if ( ! class_exists( 'AIO_Event_Planner' ) ) {
	/**
	 * Class AIO_Event_Planner
	 *
	 * Description of the class.
	 */
	class AIO_Event_Planner {
		/**
		 * Constructor.
		 */
		public function __construct() {
			// Initialize the plugin.
			add_action( 'init', array( $this, 'init' ) );
			// Load the plugin text domain.
			add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

			// Include the AIO_Register_Post_Type class.
			include_once plugin_dir_path( __FILE__ ) . 'includes/admin/class-aio-event-register-post-type.php';
			$aio_register = new AIO_Event_Planner\Includes\Admin\AIO_Register_Post_Type();
			add_action( 'init', array( $aio_register, 'aio_event_register_post_type' ) );
			add_action( 'init', array( $aio_register, 'aio_event_register_taxonomy' ) );
		}

		/**
		 * Load the plugin text domain for translation.
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'aio-event-planner', false, dirname( plugin_basename( AIO_EVENT_PLANNER_PLUGIN_FILE ) ) . '/languages/' );
		}

		/**
		 * Initialize the plugin.
		 */
		public function init() {
			// Load the AIO_Metabox class.
			include_once plugin_dir_path( __FILE__ ) . 'includes/admin/class-aio-event-metabox.php';
			new AIO_Event_Planner\Includes\Admin\AIO_Metabox();

			// Load the AIO_Single_Event class.
			include_once plugin_dir_path( __FILE__ ) . 'includes/frontend/class-aio-single-event.php';
			new AIO_Event_Planner\Includes\Frontend\AIO_Single_Event();

			// Load the AIO_Event_Column class.
			include_once plugin_dir_path( __FILE__ ) . 'includes/admin/class-aio-event-column.php';
			new AIO_Event_Planner\Includes\Admin\AIO_Event_Column();

			// Load the AIO_Event_Calender class.
			include_once plugin_dir_path( __FILE__ ) . 'includes/admin/class-aio-event-calender.php';
			new AIO_Event_Planner\Includes\Admin\AIO_Event_Calender();

			// Load admin assets.
			add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_assets' ) );

			// Load frontend assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'load_frontent_assets' ) );
		}

		/**
		 * Loads the admin assets for the AIO Event Planner plugin.
		 *
		 * @param string $hook The current admin page hook.
		 * @return void
		 */
		public function load_admin_assets( $hook ) {
			global $post_type;
			if ( 'event' === $post_type || 'event_page_event-calendar' === $hook ) {
				wp_enqueue_style( 'aio-event-planner-admin-css', plugin_dir_url( __FILE__ ) . 'assets/admin/css/style.css', array(), '1.0.0', 'all' );
				wp_enqueue_script( 'aio-event-planner-admin-js', plugin_dir_url( __FILE__ ) . 'assets/admin/js/main.js', array( 'jquery' ), '1.0.0', true );
			}
		}

		/**
		 * Loads the frontend assets for the AIO Event Planner plugin.
		 *
		 * @return void
		 */
		public function load_frontent_assets() {
			// load frontend assets only for event pages I made.
			if ( is_singular( 'event' ) ) {
				wp_enqueue_style( 'aio-event-planner-frontend-css', plugin_dir_url( __FILE__ ) . 'assets/frontend/css/style.css', array(), '1.0.0', 'all' );
				wp_enqueue_script( 'aio-event-planner-frontend-js', plugin_dir_url( __FILE__ ) . 'assets/frontend/js/main.js', array( 'jquery' ), '1.0.0', true );
			}
		}
	}
}

// Instantiate the AIO_Event_Planner class.
new AIO_Event_Planner();
