<?php
/**
 * Plugin Name: MediaPress - Disable Anonymous Upload
 * Plugin URI: http://github.com/mediapress/mpp-disable-anonymous-upload/
 * Version: 1.0.1
 * Author: BuddyDev Team
 * Author URI: http://buddydev.com
 * Description: Disables anonymous upload. It works with BP Anonymous upload plugin.
 * License: GPL2 or Above
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main plugin class
 */
class MPP_DAUpload_Helper {

	/**
	 * Singleton Instance
	 *
	 * @var MPP_DAUpload_Helper|null
	 */
	private static ?MPP_DAUpload_Helper $instance = null;

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->setup();
	}

	/**
	 * Retrieves singleton instance.
	 *
	 * @return MPP_DAUpload_Helper
	 */
	public static function get_instance(): MPP_DAUpload_Helper {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Sets up plugin hooks
	 */
	private function setup(): void {
		add_action( 'mpp_init', array( $this, 'load_textdomain' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_js' ) );
	}

	/**
	 * Loads plugin translations
	 */
	public function load_textdomain(): void {
		load_plugin_textdomain(
			'mpp-disable-anonymous-upload',
			false,
			basename( dirname( __FILE__ ) ) . '/languages/'
		);
	}

	/**
	 * Loads required JavaScript files
	 */
	public function load_js(): void {
		if ( is_admin() ) {
			return;
		}

		wp_register_script(
			'mpp_daupload_js',
			plugin_dir_url( __FILE__ ) . 'assets/mpp-daupload.js',
			array( 'mpp_core' )
		);
		wp_enqueue_script( 'mpp_daupload_js' );
	}
}

// Initialize plugin.
MPP_DAUpload_Helper::get_instance();
