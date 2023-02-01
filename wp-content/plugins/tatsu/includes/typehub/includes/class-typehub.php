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
 * @package    Typehub
 * @subpackage Typehub/includes
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
 * @package    Typehub
 * @subpackage Typehub/includes
 * @author     Brand Exponents <swami@brandexponents.com>
 */
class Typehub {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Typehub_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'TYPEHUB_VERSION' ) ) {
			$this->version = TYPEHUB_VERSION;
		} else {
			$this->version = '1.5';
		}
		$this->plugin_name = 'typehub';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_custom_hooks();
		$this->define_ajax_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Typehub_Loader. Orchestrates the hooks of the plugin.
	 * - Typehub_i18n. Defines internationalization functionality.
	 * - Typehub_Admin. Defines all hooks for the admin area.
	 * - Typehub_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * File Includes API functions that can be used by themes and plugins to register font schemes and options.
		 */
		require_once TYPEHUB_PLUGIN_DIR . 'includes/helpers.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once TYPEHUB_PLUGIN_DIR . 'includes/class-typehub-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once TYPEHUB_PLUGIN_DIR . 'includes/class-typehub-i18n.php';
		
		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once TYPEHUB_PLUGIN_DIR . 'includes/integrations/merlin/class-merlin-typehub-importer.php';
	
		/**
		 * The class responsible for registering custom fonts.
		 */
		require_once TYPEHUB_PLUGIN_DIR . 'includes/class-typehub-custom-fonts.php';

		/**
		 * The class responsible for registering font schemes.
		 */
		require_once TYPEHUB_PLUGIN_DIR . 'includes/class-typehub-font-schemes.php';


		/**
		 * The class responsible for registering typography options.
		 */
		require_once TYPEHUB_PLUGIN_DIR . 'includes/class-typehub-options.php';	
		
		/**
		 * The class responsible for handling the data store.
		 */
		require_once TYPEHUB_PLUGIN_DIR . 'includes/class-typehub-store.php';	

		/**
		 * File Includes API functions that can be used by themes and plugins to register font schemes and options.
		 */
		require_once TYPEHUB_PLUGIN_DIR . 'includes/api.php';
		
		/**
		 * File Includes functions that register default font schemes.
		 */
		require_once TYPEHUB_PLUGIN_DIR . 'includes/fonts/font-schemes.php';

		/**
		 * File Includes functions that register default font options.
		 */
		require_once TYPEHUB_PLUGIN_DIR . 'includes/options-config.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once TYPEHUB_PLUGIN_DIR . 'admin/class-typehub-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once TYPEHUB_PLUGIN_DIR . 'public/class-typehub-public.php';

		$this->loader = new Typehub_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Typehub_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Typehub_i18n();

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

		$plugin_admin = new Typehub_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'addAdminMenu' );
		$this->loader->add_action( 'load_typehub_exposed_selectors', $plugin_admin ,'get_exposed_selectors' );
		$this->loader->add_action( 'load_typehub_exposed_selectors', $plugin_admin ,'get_font_options' );
		$this->loader->add_action( 'wp_head', $this, 'typehub_head' , 30 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Typehub_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'generate_css', 11 );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'load_fonts' );
	}

	/**
	 * Register custom hooks that can be used by themes for including their font options and schemes
	 *
	 * @since    1.0.0
	 * @access   private
	 */	

	private function define_custom_hooks() {
		$this->loader->add_action( 'wp_loaded', Typehub_Options::getInstance() , 'setup_hooks',9 );
		$this->loader->add_action( 'wp_loaded', Typehub_Font_Schemes::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Typehub_Custom_Fonts::getInstance() , 'setup_hooks' );
	}

	/**
	 * Register all of the hooks related to the handling AJAX Requests
	 *
	 * @since    1.0.0
	 * @access   private
	 */

	private function define_ajax_hooks() {
		$plugin_store = new Typehub_Store();
		$this->loader->add_action( 'wp_ajax_typehub_save_store', $plugin_store, 'ajax_save' );
		$this->loader->add_action( 'wp_ajax_load_typekit_fonts', $plugin_store, 'ajax_get_typekit_fonts' );
		$this->loader->add_action( 'wp_ajax_local_font_details', $plugin_store, 'ajax_get_local_font_details' );
		$this->loader->add_action( 'wp_ajax_download_font', $plugin_store, 'ajax_download_font' );
		$this->loader->add_action( 'wp_ajax_refresh_changes', $plugin_store, 'ajax_refresh_changes' );
		$this->loader->add_action( 'wp_ajax_sync_typekit', $plugin_store, 'ajax_sync_typekit' );
		$this->loader->add_action( 'wp_ajax_add_custom_font', $plugin_store, 'ajax_add_custom_font' );
		$this->loader->add_action( 'wp_ajax_remove_custom_font', $plugin_store, 'ajax_remove_custom_font' );
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
	 * @return    Typehub_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	public function typehub_head(){
		do_action('typehub_head');
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

}
