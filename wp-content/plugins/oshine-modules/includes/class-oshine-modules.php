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
 * @package    Oshine_Modules
 * @subpackage Oshine_Modules/includes
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
 * @package    Oshine_Modules
 * @subpackage Oshine_Modules/includes
 * @author     Brand Exponents <swami@brandexponents.com>
 */
class Oshine_Modules {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Oshine_Modules_Loader    $loader    Maintains and registers all hooks for the plugin.
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

		$this->plugin_name = 'oshine-modules';
		$this->version = '3.2';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_tatsu_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Oshine_Modules_Loader. Orchestrates the hooks of the plugin.
	 * - Oshine_Modules_i18n. Defines internationalization functionality.
	 * - Oshine_Modules_Admin. Defines all hooks for the admin area.
	 * - Oshine_Modules_Public. Defines all hooks for the public side of the site.
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
		require_once OSHINE_MODULES_PLUGIN_DIR . 'includes/class-oshine-modules-loader.php';

		require_once OSHINE_MODULES_PLUGIN_DIR . 'includes/functions/helpers.php';

		foreach ( glob( OSHINE_MODULES_PLUGIN_DIR . 'includes/modules/*.php' )  as $module ) {
			require_once $module;
		}

		require_once OSHINE_MODULES_PLUGIN_DIR . 'includes/icons/oshine-icons.php';

		require_once OSHINE_MODULES_PLUGIN_DIR . 'includes/functions/ajax-handler.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once OSHINE_MODULES_PLUGIN_DIR . 'includes/class-oshine-modules-i18n.php';

		/**
		 * Oshine Modules Configurations
		 */
		require_once OSHINE_MODULES_PLUGIN_DIR . 'includes/class-oshine-modules-config.php';		

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once OSHINE_MODULES_PLUGIN_DIR . 'admin/class-oshine-modules-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once OSHINE_MODULES_PLUGIN_DIR . 'public/class-oshine-modules-public.php';

		include_once OSHINE_MODULES_PLUGIN_DIR . 'includes/templates/index.php';

		$this->loader = new Oshine_Modules_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Oshine_Modules_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Oshine_Modules_i18n();

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

		$plugin_admin = new Oshine_Modules_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
                $this->loader->add_action( 'tatsu_builder_footer', $this, 'enqueue_module_components' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Oshine_Modules_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'tatsu_frame_enqueue', $plugin_public, 'frame_enqueue' );
		$this->loader->add_action( 'wp_loaded', $this, 'load_be_helper' );

	}

	public function load_be_helper() {
		// Load after Tatsu Loads
		require_once OSHINE_MODULES_PLUGIN_DIR . 'includes/functions/be-helpers.php';
	}

	private function define_tatsu_hooks() {

		$this->loader->add_action( 'tatsu_register_colors', $this, 'get_colors' );
		$this->loader->add_filter( 'tatsu_gmaps_api_key', $this, 'get_maps_api_key' );

	}

        public function enqueue_module_components() {

            	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';   
                wp_register_script( 'oshine_module_components', OSHINE_MODULES_PLUGIN_URL.'/admin/js/oshine-bundle'.$suffix.'.js', array( 'jquery', 'tatsu' ), '1.2.2', true );
                wp_enqueue_script( 'oshine_module_components' );

        }

	public function get_colors() {
		$colors = Oshine_Modules_Config::getInstance()->get_colors();
		foreach ( $colors as $slug => $color ) {
			tatsu_register_color( $slug, $slug, $color );
		}
	}

	public function get_maps_api_key() {
		global $be_themes_data;
		if(  is_array( $be_themes_data ) && array_key_exists( 'google_map_api_key' , $be_themes_data ) ) {
			return $be_themes_data['google_map_api_key'];
		}
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
	 * @return    Oshine_Modules_Loader    Orchestrates the hooks of the plugin.
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
