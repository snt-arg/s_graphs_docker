<?php
/**
 * Master Slider Admin
 *
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2014 averta
 */

// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
    die();
}


/**
 * This class is used to work with the
 * administrative side of Masterslider
 */
class Master_Slider_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $sliders_screen_hook_suffix = null;



	/**
	 * Initialize the plugin by loading admin classes and functions
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// include admin files
		$this->includes();

		add_action( 'init', array( $this, 'init' ) );
	}


	/**
	 * Include admin essential classes and functions
	 *
	 * @return void
	 */
	private function includes(){
		include_once( MSWP_AVERTA_ADMIN_DIR . '/includes/index.php' );
		include_once( MSWP_AVERTA_ADMIN_DIR . '/views/setting/class-msp-settings.php' );
	}


	public function init() {

		// Before init action
		do_action( 'before_masterslider_admin_init' );

		// A filter hook to restrict access to plugin panel only for super admin on multiste
		if( apply_filters( 'masterslider_access_only_for_super_admins' , 0 ) && ! is_super_admin() ) {
			return;
		}

		// Assign masterslider custom capabilities
		Master_Slider::assign_custom_caps();
		// Inject default styles and effects
		Master_Slider::set_default_options();


		// Initial tasks on admin init
		add_action( 'admin_init', array( $this, 'admin_init') );

		// Initial tasks on admin footer
		add_action( 'admin_footer', array( $this, 'admin_footer') );

		// Load admin Stylesheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts') );


		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add an action link pointing to the setting page.
		add_filter( 'plugin_action_links_' . MSWP_AVERTA_BASE_NAME, array( $this, 'add_action_links' ) );

		// Add an action link on plugin row meta in plugins page
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );

		// Admin init action
		do_action( 'masterslider_admin_init' );
	}


	/**
	 * Triggers on admin init
	 *
	 * @return void
	 */
	public function admin_init(){

		$this->after_plugin_update();
	}


	/**
	 * Triggers on admin footer
	 *
	 * @return void
	 */
	public function admin_footer(){

		include_once( MSWP_AVERTA_ADMIN_DIR . '/views/global/gallery-templates.php' );
	}


	/**
	 * Regenerate and cache custom css codes for all slider after plugin update
	 *
	 * @return bool  TRUE on success, FALSE otherwise
	 */
	public function after_plugin_update (){

		if( get_option( 'masterslider_plugin_version', '0' ) == MSWP_AVERTA_VERSION )
			return false;

		msp_save_custom_styles();
		//msp_flush_all_sliders_cache(); 2.9.7
		update_option( 'masterslider_plugin_version', MSWP_AVERTA_VERSION );
		do_action( 'masterslider_after_plugin_updated' );

		return true;
	}


	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		if( apply_filters( 'masterslider_access_only_for_super_admins' , 0 ) && ! is_super_admin() ) {
			return;
		}

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}


	/**
	 * Register and enqueue admin-specific JavaScript & Stylesheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		$admin_assets = new MSP_Admin_Assets();
		$admin_assets->enqueue_global_assets();

		if ( ! isset( $this->sliders_screen_hook_suffix ) )
			return;

		// load masterslider spesific assets only on it's admin page
		$screen = get_current_screen();
		if ( $this->sliders_screen_hook_suffix == $screen->id ) {

			$admin_assets->enqueue_panel_assets();

			if ( isset( $_REQUEST['slider_id'] ) && is_numeric( $_REQUEST['slider_id'] ) ) {

				$slider_id  = sanitize_text_field( $_REQUEST['slider_id'] );
				global $mspdb;
				$custom_fonts = $mspdb->get_slider_field_val( $slider_id, 'custom_fonts' );
		
				if ( ! empty( $custom_fonts ) )
				  wp_enqueue_style( 'master-slider-admin-fonts', 'http://fonts.googleapis.com/css?family=' . $custom_fonts, [], false, 'all' );
			}
		}
	}


	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		$ms_page_title = apply_filters( 'masterslider_admin_page_title', __( 'Master Sliders', MSWP_TEXT_DOMAIN ) );
		$ms_menu_title = apply_filters( 'masterslider_admin_menu_title', __( 'Master Slider' , MSWP_TEXT_DOMAIN ) );

		// Add a top-level menu for master slider
		$this->sliders_screen_hook_suffix = add_menu_page(
			$ms_page_title,
			$ms_menu_title,
			apply_filters( 'masterslider_access_capability', 'access_masterslider' ),
			MSWP_SLUG,
			array( $this, 'display_master_slider_panel_page' )
		);

	}


	/**
	 * Render the panel page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_master_slider_panel_page() {
		include_once( 'views/index.php' );
	}


	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'admin.php?page=' . MSWP_SLUG . '-setting' ) . '">' . __( 'Settings', MSWP_TEXT_DOMAIN ) . '</a>',
				'docs' 	   => '<a href="http://masterslider.com/doc/wp/?rf=cls" target="blank" >' . __( 'Docs', MSWP_TEXT_DOMAIN ) . '</a>'
			),
			$links
		);

	}


	/**
	 * Add extra action link to the plugin meta on plugins page.
	 *
	 * @since    1.8.0
	 */
	public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ){
		if( $plugin_file == MSWP_AVERTA_BASE_NAME ) {  }
		return $plugin_meta;
	}


}

return Master_Slider_Admin::get_instance();
