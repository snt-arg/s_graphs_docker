<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Colorhub
 * @subpackage Colorhub/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Colorhub
 * @subpackage Colorhub/admin
 * @author     Brand Exponents Creatives Pvt Ltd <swami@brandexponents.com>
 */
class Colorhub_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {
		if( 'toplevel_page_colorhub' === $hook  ) {	 
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/colorhub-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {
		if( 'toplevel_page_colorhub' === $hook  ) {	 
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		//	wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/colorhub-admin.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( 'colorhub-bundle', plugin_dir_url( __FILE__ ) . 'js/bundle'.$suffix.'.js', array('jquery'), $this->version, true );

			$store = new Colorhub_Store();
			wp_localize_script( 'colorhub-bundle', 'colorhubStore', $store->get_store() );	
			wp_localize_script( 'colorhub-bundle', 'colorhubAjax', array(
				'nonce' => wp_create_nonce('colorhub-security'),
				'plugin_url' => COLORHUB_PLUGIN_URL,
			));
		}
	}

	public function addAdminMenu() {
		
		add_menu_page(
			'Color Hub',
			'Color Hub',
			'manage_options',
			'colorhub',
			array(
				$this,
				'adminPage'
			)
		);
	}

	public function adminPage() {
		echo '<div id="color-hub"></div>';
	}	

}
