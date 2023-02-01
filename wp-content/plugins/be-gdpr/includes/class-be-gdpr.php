<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Be_Gdpr
 * @subpackage Be_Gdpr/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Be_Gdpr
 * @subpackage Be_Gdpr/includes
 * @author     Swaminathan ganesan <help@brandexponents.com>
 */
class Be_Gdpr {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Be_Gdpr_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'BE_GDPR' ) ) {
			$this->version = BE_GDPR;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'be-gdpr';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_custom_hooks();
		$this->add_gdpr_shortcodes();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Be_Gdpr_Loader. Orchestrates the hooks of the plugin.
	 * - Be_Gdpr_i18n. Defines internationalization functionality.
	 * - Be_Gdpr_Admin. Defines all hooks for the admin area.
	 * - Be_Gdpr_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-be-gdpr-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-be-gdpr-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-be-gdpr-admin.php';

		/**
		 * The class responsible for working with the options from config file.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-be-gdpr-options.php';

		/**
		 * Defining API functions
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/api.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-be-gdpr-public.php';

		$this->loader = new Be_Gdpr_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Be_Gdpr_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Be_Gdpr_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Be_Gdpr_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'add_cookie_privacy_content' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_submenu_GDPR' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Be_Gdpr_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts',1 );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'print_privacy_elements' );

	}
	/**
	 * Register all of the custom hooks related to the functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_custom_hooks() {

		$this->loader->add_action( 'wp_loaded',Be_Gdpr_Options::getInstance(), 'setup_hooks' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Be_Gdpr_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function add_gdpr_shortcodes(){
	
		add_shortcode( 'be_gdpr_api_name', array(  $this, 'api_name' ) );
		add_shortcode( 'be_gdpr_privacy_policy_page',  array(  $this, 'privacy_policy_page' ) );
		add_shortcode( 'be_gdpr_privacy_popup',  array(  $this, 'privacy_settings_popup' ) );
	}

	public function api_name( $atts ){
		$atts = shortcode_atts( array('api' => 'this source'), $atts );
		return $atts['api'];
	} 

	public function privacy_policy_page(){
		if( function_exists( 'get_privacy_policy_url' ) ) {
			$privacy_url = get_privacy_policy_url();
		} else {
			$privacy_url = '#';
		}
		return '<a target="_blank" href="'. $privacy_url .'">'. get_option( 'be_gdpr_privacy_policy_link_text', 'Privacy Policy' ) .'</a>';
	}

	public function privacy_settings_popup(){
		$default_popup_html = '<a href="#gdpr-popup" class="mfp-popup white-popup privacy-settings" data-type="HTML" >'. get_option( 'be_gdpr_popup_title_text','Privacy Settings' ) .'</a>';
		return apply_filters( 'be_gdpr_privacy_settings_popup', $default_popup_html);
	}
}