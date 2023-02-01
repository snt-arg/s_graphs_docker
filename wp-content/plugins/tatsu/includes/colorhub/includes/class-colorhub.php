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
 * @package    Colorhub
 * @subpackage Colorhub/includes
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
 * @package    Colorhub
 * @subpackage Colorhub/includes
 * @author     Brand Exponents Creatives Pvt Ltd <swami@brandexponents.com>
 */
class Colorhub {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Colorhub_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'COLORHUB_VERSION' ) ) {
			$this->version = COLORHUB_VERSION;
		} else {
			$this->version = '1.0.4';
		}
		$this->plugin_name = 'colorhub';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_ajax_hooks();
		$this->define_custom_hooks();
		$this->define_tatsu_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Colorhub_Loader. Orchestrates the hooks of the plugin.
	 * - Colorhub_i18n. Defines internationalization functionality.
	 * - Colorhub_Admin. Defines all hooks for the admin area.
	 * - Colorhub_Public. Defines all hooks for the public side of the site.
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
		require_once COLORHUB_PLUGIN_DIR . 'includes/class-colorhub-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once COLORHUB_PLUGIN_DIR . 'includes/class-colorhub-i18n.php';

		/**
		 * The class responsible for registering and handling Color Swatches.
		 */
		require_once COLORHUB_PLUGIN_DIR . 'includes/class-colorhub-swatch-config.php';

		/**
		 * The class responsible for accessing Color Swatches.
		 */
		require_once COLORHUB_PLUGIN_DIR . 'includes/class-colorhub-swatch.php';
		
		/**
		 * The class responsible for registering and handling Color Palettes.
		 */
		require_once COLORHUB_PLUGIN_DIR . 'includes/class-colorhub-palette-config.php';
		
		/**
		 * The class responsible for accessing Color Palettes.
		 */
		require_once COLORHUB_PLUGIN_DIR . 'includes/class-colorhub-palette.php';
		
		/**
		 * The class responsible for registering and handling Color Options.
		 */
		require_once COLORHUB_PLUGIN_DIR . 'includes/class-colorhub-options.php';
		
		/**
		 * The class responsible for registering and handling the data store.
		 */
		require_once COLORHUB_PLUGIN_DIR . 'includes/class-colorhub-store.php';	
		
		/**
		 * File Includes API functions that can be used by themes and plugins to register color swatches, palettes and options.
		 */
		require_once COLORHUB_PLUGIN_DIR . 'includes/api.php';
		
		/**
		 * File Includes functions that register in built swatches.
		 */
		require_once COLORHUB_PLUGIN_DIR . 'includes/predefined/swatches.php';

		/**
		 * File Includes functions that register in built palettes.
		 */
		require_once COLORHUB_PLUGIN_DIR . 'includes/predefined/palettes.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once COLORHUB_PLUGIN_DIR . 'admin/class-colorhub-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once COLORHUB_PLUGIN_DIR . 'public/class-colorhub-public.php';

		$this->loader = new Colorhub_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Colorhub_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Colorhub_i18n();

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

		$plugin_admin = new Colorhub_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'addAdminMenu' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Colorhub_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'tatsu_builder_head', $plugin_public, 'load_inside_tatsu' );	
		$this->loader->add_action( 'wp_head', $plugin_public, 'generate_css',12 );	
		$this->loader->add_action( 'wp_loaded', $this, 'load_be_helper' );

	}

	public function load_be_helper() {
		// Load after Tatsu Loads
		require_once COLORHUB_PLUGIN_DIR . 'includes/be-helpers.php';
	}

	/**
	 * Register all of the hooks to integrate with Tatsu
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */	

	private function define_tatsu_hooks() {
		$this->loader->add_action( 'tatsu_register_colors', $this, 'get_colors', 11 );
	}

	public function get_colors() {
		tatsu_register_color( 'tatsu_accent_color', 'Accent Color', colorhub_get_palette( 0 ) );
		tatsu_register_color( 'tatsu_accent_twin_color', 'Accent\'s Complimentary Color', colorhub_get_palette( 1 ) );
	}

	/**
	 * Register all of the hooks related to the handling AJAX & REST API Requests
	 *
	 * @since    1.0.0
	 * @access   private
	 */

	private function define_ajax_hooks() {
		$plugin_store = new Colorhub_Store();
		//$this->loader->add_action( 'wp_ajax_colorhub_get_store', $plugin_store, 'get_store' );
		$this->loader->add_action( 'wp_ajax_colorhub_save_store', $plugin_store, 'ajax_save' );
	
	}


	/**
	 * Register custom hooks that can be used by themes for including their swatches and options configuration
	 *
	 * @since    1.0.0
	 * @access   private
	 */


	private function define_custom_hooks() {
		$this->loader->add_action( 'wp_loaded', Colorhub_Swatch_Config::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Colorhub_Options::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Colorhub_Palette_Config::getInstance() , 'setup_hooks' );
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
	 * @return    Colorhub_Loader    Orchestrates the hooks of the plugin.
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

}
