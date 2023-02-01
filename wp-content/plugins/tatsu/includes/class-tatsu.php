<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.brandexponents.com
 * @since      1.0.0
 *
 * @package    Tatsu
 * @subpackage Tatsu/includes
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
 * @package    Tatsu
 * @subpackage Tatsu/includes
 * @author     Brand Exponents Creatives Pvt Ltd <swami@brandexponents.com>
 */
class Tatsu {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Tatsu_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		$this->plugin_name = 'tatsu';
		if( defined( 'TATSU_VERSION' ) ) {
			$this->version = TATSU_VERSION;
		}else {
			$this->version = '3.3.0';
		}
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_builder_hooks();
		$this->define_rest_api_init();
		$this->define_ajax_hooks();
		$this->define_custom_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Tatsu_Loader. Orchestrates the hooks of the plugin.
	 * - Tatsu_i18n. Defines internationalization functionality.
	 * - Tatsu_Admin. Defines all hooks for the admin area.
	 * - Tatsu_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The file responsible for colorhub actions and filters of the
		 * core plugin.
		 */
		require_once TATSU_PLUGIN_DIR. 'includes/colorhub/colorhub.php';

		/**
		 * The file responsible for typehub actions and filters of the
		 * core plugin.
		 */
		require_once TATSU_PLUGIN_DIR. 'includes/typehub/typehub.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-loader.php';

		/**
		 * The class that loads global configurations used across the plugin
		 */		

		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-config.php';

		/**
		 * The class that loads icon kits used by the plugin and also contains hooks for including additional icon kits
		 */			

		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-icons.php';

		/**
		 * The class that loads SVGs used by the plugin and also contains hooks for including additional SVGs
		 */			

		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-svgs.php';

		/**
		 * The class that loads global color settings used by the plugin and also contains hooks for including additional colors
		 */			

		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-colors.php';

		/**
		 * The class responsible for handling global section metas
		 */		
		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-global-section-meta.php';	

		/**
		 * The class responsible for handling global section modules
		 */
		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-global-module-options.php';	

					/**
		 * The class responsible for registering metas
		 */		
		require_once TATSU_PLUGIN_DIR. 'includes/global-section-metas.php';
		
		/**
		 * Include tatsu constants
		 */
		require_once TATSU_PLUGIN_DIR. 'includes/helpers/constants.php';

		/**
		 *  Helper functions used internally in different classes
		 */		

		require_once TATSU_PLUGIN_DIR.'includes/helpers/helpers.php';


		/**
		 *  Include the shortcodes and  options for all the modules included with the plugin
		 */		

		foreach( glob( TATSU_PLUGIN_DIR. 'includes/modules/*.php' ) as $module ) {
			require_once $module;
		}

		/**
		 *  Include the Header Builder Modules
		 */		

		foreach( glob( TATSU_PLUGIN_DIR. 'includes/header-builder/modules/*.php' ) as $header_module ) {
			require_once $header_module;
		}

		/**
		 * Include Footer Builder Modules
		 */

		foreach( glob( TATSU_PLUGIN_DIR. 'includes/footer-builder/modules/*.php' ) as $footer_module ) {
			require_once $footer_module;
		}

		/**
		 *  Register Header Concepts included with Tatsu
		 */				

		require_once TATSU_PLUGIN_DIR. 'includes/footer-builder/concepts/footer-concepts.php';

		/**
		 *  Register the default font icon kit included with the plugin
		 */				

		require_once TATSU_PLUGIN_DIR. 'includes/icons/font-awesome.php';	

		/**
		 *  Register the default font icon kit included with the plugin
		 */	
		
		require_once TATSU_PLUGIN_DIR. 'includes/icons/tatsu-icons.php';

		/**
		 *  Register the default Linea svg kit included with the plugin
		 */				

		require_once TATSU_PLUGIN_DIR. 'includes/icons/linea.php';	

		/**
		 *  Register Section Concepts included with Tatsu
		 */				

		require_once TATSU_PLUGIN_DIR. 'includes/concepts/section-concepts.php';
		
		/**
		 *  Register Header Concepts included with Tatsu
		 */				

		require_once TATSU_PLUGIN_DIR. 'includes/header-builder/concepts/header-concepts.php';

		/**
		 *  Public API functions exposed by plugin
		 */		

		require_once TATSU_PLUGIN_DIR. 'includes/helpers/api.php';
		
		/**
		 *  Helper functions used internally in different classes
		 */		

		require_once TATSU_PLUGIN_DIR.'includes/helpers/be-helpers.php';

	
		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-i18n.php';

		/**
		 *  The class responsible for process submitted Tatsu forms
		 */		
		require_once TATSU_PLUGIN_DIR.'includes/class-tatsu-forms-process.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once TATSU_PLUGIN_DIR. 'admin/class-tatsu-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once TATSU_PLUGIN_DIR. 'public/class-tatsu-public.php';


		/**
		 * The class responsible for redirecting to the live page builder and loading all its assets.  
		 */		
		require_once TATSU_PLUGIN_DIR. 'builder/class-tatsu-builder.php';

		/**
		 * The class responsible for loading the page in the builder iframe.  
		 */		
		require_once TATSU_PLUGIN_DIR. 'builder/class-tatsu-frame.php';	

		/**
		 * The class responsible for registering REST API routes.  
		 */		
		require_once TATSU_PLUGIN_DIR. 'includes/rest_api/class-tatsu-rest-api.php';					

		/**
		 * The class responsible for getting the output of a shortcode & for building shortcode from atts & content
		 */		
		require_once TATSU_PLUGIN_DIR. 'includes/rest_api/class-tatsu-module.php';				

		/**
		 * The class responsible for parsing content from the old page builder and building Tatsu Page Content for the store
		 */		
		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-content-parser.php';		

		/**
		 * The class responsible for showing tatsu forms data in a table to admin
		 */		
		require_once TATSU_PLUGIN_DIR. 'includes/rest_api/class-tatsu-forms-table.php';		

		/**
		 * The class that loads icon kits used by the plugin and also contains hooks for including additional icon kits
		 */			

		require_once TATSU_PLUGIN_DIR. 'admin/partials/tatsu-admin-display.php';

		/**
		 * The page that display tatsu forms data entries to admin
		 */			

		require_once TATSU_PLUGIN_DIR. 'admin/partials/tatsu-forms-entries-display.php';

		/**
		 * The page that display tatsu form settings to admin
		 */			

		require_once TATSU_PLUGIN_DIR. 'admin/partials/tatsu-form-settings.php';


		/**
		 * Handles compatibility with other plugins
		 */
		require_once TATSU_PLUGIN_DIR . 'includes/class-tatsu-integrations.php';

		/**
		 * The classes responsible for sending initial store data for the javascript builder and also for saving the page builder content.  
		 */
		require_once TATSU_PLUGIN_DIR. 'includes/rest_api/class-tatsu-module-options.php';
		require_once TATSU_PLUGIN_DIR. 'includes/rest_api/class-tatsu-page-content.php';
		require_once TATSU_PLUGIN_DIR. 'includes/rest_api/class-tatsu-page-templates.php';
		require_once TATSU_PLUGIN_DIR. 'includes/templates/sections/index.php';	
		require_once TATSU_PLUGIN_DIR. 'includes/templates/pages/index.php';									
		require_once TATSU_PLUGIN_DIR. 'includes/rest_api/class-tatsu-store.php';
		require_once TATSU_PLUGIN_DIR. 'includes/rest_api/class-tatsu-section-concepts.php';
		require_once TATSU_PLUGIN_DIR. 'includes/header-builder/class-tatsu-header-concepts.php';

		/**
		 * The class responsible for registering the header modules with Tatsu  
		 */
		require_once TATSU_PLUGIN_DIR. 'includes/header-builder/class-tatsu-header-store.php';
		require_once TATSU_PLUGIN_DIR. 'includes/header-builder/class-tatsu-header-module-options.php';

		/**
		 * The class responsible for registering the Footer modules with Tatsu  
		 */
		require_once TATSU_PLUGIN_DIR. 'includes/footer-builder/class-tatsu-footer-store.php';
		require_once TATSU_PLUGIN_DIR. 'includes/footer-builder/class-tatsu-footer-module-options.php';
		require_once TATSU_PLUGIN_DIR. 'includes/footer-builder/class-tatsu-footer-concepts.php';

		/**
		 * Class for theme supports
		 */
		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-theme-support.php';
		/**
		 * Class responsible for registering custom post templates
		 */
		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-post-templates.php';

		/**
		 * Register Custom Selectors with Typehub
		 */

		include_once TATSU_PLUGIN_DIR . 'includes/integrations/typehub.php';

		/**
		 * The file responsible for import demos actions 
		 */
		require_once TATSU_PLUGIN_DIR. 'includes/demo-import/tatsu-demos.php';

		
		$this->loader = new Tatsu_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Tatsu_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Tatsu_i18n();

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

		$plugin_admin = new Tatsu_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'save_post', $this, 'after_save_post' );

		$this->loader->add_action( 'edit_form_after_title', $plugin_admin, 'edit_with_tatsu_button' );
		$this->loader->add_filter( 'admin_body_class', $plugin_admin, 'add_body_class' , 11);	

		//double width, height option in gallery
		$this->loader->add_filter( 'attachment_fields_to_edit', $plugin_admin, 'add_media_edit_options', 10, 2 );
		$this->loader->add_filter( 'attachment_fields_to_save', $plugin_admin, 'add_media_save_options', 10, 2 );
		
		$this->loader->add_action( 'init', Tatsu_Theme_Support::getInstance(), 'init' );
		$this->loader->add_action( 'init', $plugin_admin, 'tatsu_global_section_post_type' );
		$this->loader->add_action( 'init', $plugin_admin, 'tatsu_header_register_post_type' );
		$this->loader->add_action( 'init', $plugin_admin, 'tatsu_footer_register_post_type' );
		if(class_exists('Spyro_Modules')) { 
			$this->loader->add_action( 'init', $plugin_admin, 'tatsu_forms_post_type' );
		}
		$this->loader->add_action( 'admin_menu', $plugin_admin , 'tatsu_admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin , 'tatsu_register_setting' );
		/*
		$this->loader->add_action( 'admin_init', $plugin_admin , 'tatsu_add_global_section_settings' );
		$this->loader->add_action( 'admin_menu', $plugin_admin , 'tatsu_global_section_settings' );
		/**/
		$this->loader->add_action( 'load-post.php', $plugin_admin, 'redirect_tatsu_header_footer_builder' );

		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'tatsu_add_gsection_meta_box_to_posts' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'tatsu_header_options_metabox' );

		$this->loader->add_action( 'save_post', $plugin_admin ,'tatsu_save_global_section_settings_on_posts' );
		$this->loader->add_action( 'save_post', $plugin_admin ,'tatsu_save_header_options' );

        $this->loader->add_action( 'customize_register', $plugin_admin, 'tatsu_add_customizer_options', 100 );
        $this->loader->add_action( 'admin_action_tatsu_new_post', $plugin_admin, 'tatsu_create_new_post' );
		$this->loader->add_filter( 'page_row_actions', $plugin_admin, 'add_edit_in_dashboard', 10, 2 );
		$this->loader->add_filter( 'post_row_actions', $plugin_admin, 'add_edit_in_dashboard', 10, 2 );
		$this->loader->add_filter( 'display_post_states', $plugin_admin, 'add_tatsu_post_state', 10, 2 );
		
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'tatsu_admin_notice' );
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Tatsu_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_filter( 'the_content', $this, 'content_filter' );
		
		$this->loader->add_action( 'admin_bar_menu', $this, 'admin_bar_edit_link', 99 );
		$this->loader->add_action( 'tatsu_typography_fonts_to_load', $this, 'fonts_to_load', 99 );
		/****For standalone only: start ********/
		if(is_tatsu_standalone()){
			if(function_exists('tatsu_get_active_header_id') && !empty(tatsu_get_active_header_id())){
				$this->loader->add_action( 'get_header', $this, 'tatsu_standalone_action_get_header', 99 );
			}
			//$this->loader->add_action( 'wp_body_open', $this, 'tatsu_standalone_action_wp_body_open', 99 );
			if(function_exists('tatsu_get_active_footer_id') && !empty(tatsu_get_active_footer_id())){
				$this->loader->add_action( 'get_footer', $this, 'tatsu_standalone_action_get_footer', 99 );
			}
		}
		/****For standalone only: end ********/
		// Rank Math Seo Plugin Compatibility
		if(class_exists('RankMath')){
			$this->loader->add_filter( 'rank_math/sitemap/content_before_parse_html_images', $this,'rank_math_tatsu_compatibility', 10, 2 );
		}
		$this->loader->add_action( 'tatsu_print_header', $plugin_public, 'header_print' );
		
		$this->loader->add_action( 'tatsu_print_footer', $plugin_public, 'print_footer' );

		$this->loader->add_action( 'wp_footer', $plugin_public, 'sliding_menu' );

		$this->loader->add_action( 'tatsu_head', $plugin_public , 'tatsu_add_global_sections');

		$this->loader->add_action( 'tatsu_footer', $plugin_public , 'tatsu_add_global_sections' );

		$this->loader->add_action( 'tatsu_global_section_before_output', $plugin_public, 'tatsu_add_global_section_classes' );
		$this->loader->add_action( 'tatsu_global_section_after_output', $plugin_public, 'tatsu_remove_global_section_classes' );
		
		$this->loader->add_action( 'tatsu_global_section_before_output', $plugin_public, 'tatsu_add_global_section_classes' );
		$this->loader->add_action( 'tatsu_global_section_after_output', $plugin_public, 'tatsu_remove_global_section_classes' );

		$this->loader->add_action( 'single_template', $plugin_public, 'load_header_template' );
		$this->loader->add_action( 'single_template', $plugin_public, 'load_footer_template' );

		$this->loader->add_filter( 'body_class', $plugin_public, 'single_page_site' );
		
        //common atts
        $this->loader->add_action( 'tatsu_register_module_filter_options', $plugin_public, 'tatsu_add_common_atts_to_module_options', 10, 2 );
        $this->loader->add_action( 'tatsu_register_header_module_filter_options', $plugin_public, 'tatsu_add_common_atts_to_module_options', 10, 2 );
        $this->loader->add_action( 'tatsu_register_header_module_filter_options', $plugin_public, 'tatsu_remove_animation_atts', 9999, 2 );
        $this->loader->add_action( 'wp_loaded', $this, 'tatsu_add_common_atts_to_shortcodes', 12 );

        //custom css and js
        $this->loader->add_action( 'wp_head', $plugin_public, 'tatsu_add_custom_style', 9999 );
        $this->loader->add_action( 'wp_footer', $plugin_public, 'tatsu_add_custom_scripts', 9999 );

		//Ajax handler
		$plugin_forms_process = new Tatsu_Forms_Process( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_ajax_nopriv_tatsu_forms_save', $plugin_forms_process, 'tatsu_forms_save' );
		$this->loader->add_action( 'wp_ajax_tatsu_forms_save', $plugin_forms_process, 'tatsu_forms_save' );
	}

	/**
	 * Register all of the hooks related to the page builder
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_builder_hooks() {

		$plugin_builder = new Tatsu_Builder( $this->get_plugin_name(), $this->get_version() );
		$plugin_iframe_loader = new Tatsu_Frame( $this->get_plugin_name(), $this->get_version() );
		$tatsu_integrations = new Tatsu_Integrations();
        $this->loader->add_action( 'template_redirect', $plugin_builder, 'init', 999999 );
		$this->loader->add_action( 'template_redirect', $plugin_iframe_loader, 'init',9999999 );
		$this->loader->add_action( 'init', $tatsu_integrations, 'init' );
        $this->loader->add_action( 'init', $this, 'tatsu_add_image_size' );
        
        //admin load hooks
        $this->loader->add_action( 'admin_action_tatsu', $plugin_builder, 'init' );
        $this->loader->add_action( 'admin_action_tatsu-global', $plugin_builder, 'init' );
        $this->loader->add_action( 'admin_action_tatsu-header', $plugin_builder, 'init' );
        $this->loader->add_action( 'admin_action_tatsu-footer', $plugin_builder, 'init' );

	}	


	/**
	 * Register all of the hooks related to the handling AJAX & REST API Requests
	 *
	 * @since    1.0.0
	 * @access   private
	 */

	private function define_ajax_hooks() {
		$plugin_store = new Tatsu_Store();
		$this->loader->add_action( 'wp_ajax_tatsu_save_license_key', $plugin_store, 'ajax_save_license_key' );

		$this->loader->add_action( 'wp_ajax_tatsu_admin_notices_dismiss', $plugin_store, 'tatsu_admin_notices_dismiss' );

		$this->loader->add_action( 'wp_ajax_tatsu_instagram_token_save', $plugin_store, 'ajax_instagram_token_save' );

		$this->loader->add_action( 'wp_ajax_tatsu_save_recaptcha_details', $plugin_store, 'tatsu_save_recaptcha_details' );

		$this->loader->add_action( 'wp_ajax_tatsu_save_store', $plugin_store, 'ajax_save_store' );

		$this->loader->add_action( 'wp_ajax_get_revision_content', $plugin_store, 'ajax_get_revision_content' );

		$this->loader->add_action( 'wp_ajax_get_revision_data', $plugin_store, 'ajax_get_revision_data' );
	
		$plugin_module = new Tatsu_Module();
		$this->loader->add_action( 'wp_ajax_tatsu_module', $plugin_module, 'ajax_get_module_shorcode_output' );

		$this->loader->add_action( 'wp_ajax_tatsu_paste_shortcode', $plugin_store, 'ajax_paste_shortcode' );


		$this->loader->add_action( 'wp_ajax_tatsu_get_images_from_id', $this, 'ajax_get_images_from_id' );

		$this->loader->add_action( 'wp_ajax_tatsu_get_image', $this, 'ajax_get_image' );

		$plugin_templates = Tatsu_Page_Templates::getInstance();
		$this->loader->add_action( 'wp_ajax_tatsu_get_template', $plugin_templates, 'ajax_get_template' );
		$this->loader->add_action( 'wp_ajax_tatsu_get_templates_list', $plugin_templates, 'get_templates_list' );
		$this->loader->add_action( 'wp_ajax_tatsu_get_prebuilt_templates', $plugin_templates, 'get_prebuilt_templates' );

		$this->loader->add_action( 'wp_ajax_tatsu_save_template', $plugin_templates, 'ajax_save_template' );

		$this->loader->add_action( 'wp_ajax_tatsu_delete_template', $plugin_templates, 'ajax_delete_template' );

		$plugin_concepts =  Tatsu_Section_Concepts::getInstance();	
		$this->loader->add_action( 'wp_ajax_tatsu_get_concepts', $plugin_concepts, 'ajax_get_section_concepts' );

		$header_concepts =  Tatsu_Header_Concepts::getInstance();	
		$this->loader->add_action( 'wp_ajax_tatsu_get_header_concepts', $header_concepts, 'ajax_get_header_concepts' );


		$header_store =  new Tatsu_Header_Store();	
		$this->loader->add_action( 'wp_ajax_tatsu_get_header_store', $header_store, 'ajax_get_store' );
		$this->loader->add_action( 'wp_ajax_tatsu_save_header_store', $header_store, 'ajax_save_store' );

		$footer_store =  new Tatsu_Footer_Store();	
		$footer_concepts =  Tatsu_Footer_Concepts::getInstance();	
		$this->loader->add_action( 'wp_ajax_tatsu_get_footer_store', $footer_store, 'ajax_get_store' );
		$this->loader->add_action( 'wp_ajax_tatsu_save_footer_store', $footer_store, 'ajax_save_store' );
		$this->loader->add_action( 'wp_ajax_tatsu_get_footer_concepts', $footer_concepts, 'ajax_get_footer_concepts' );
	}


	/**
	 * Register all of the hooks related to the handling AJAX & REST API Requests
	 *
	 * @since    1.0.0
	 * @access   private
	 */

	private function define_rest_api_init() {
		$plugin_rest_api = Tatsu_Rest_Api::getInstance();
		$this->loader->add_action( 'rest_api_init', $plugin_rest_api, 'register_rest_routes' );
	}

	/**
	 * Register custom hooks that can be used by themes for including their icon kits, colors and custom shortcode modules
	 *
	 * @since    1.0.0
	 * @access   private
	 */


	private function define_custom_hooks() {
		$this->loader->add_action( 'wp_loaded', Tatsu_Module_Options::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Tatsu_Icons::getInstance() , 'setup_hooks', 9 );
		$this->loader->add_action( 'wp_loaded', Tatsu_Colors::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Tatsu_Page_Templates::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Tatsu_Section_Concepts::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Tatsu_Svgs::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Tatsu_Header_Module_Options::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Tatsu_Header_Concepts::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Tatsu_Footer_Module_Options::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Tatsu_Footer_Concepts::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Tatsu_Global_Section_Meta::getInstance(), 'setup_hooks' );
        $this->loader->add_action( 'wp_loaded', Tatsu_Global_Module_Options::getInstance(), 'setup_hooks' );
	}

	/**
	 * Remove empty p and br tags added by wordpress only for shortcodes registered with tatsu
	 * @since    1.0.0
	 * @access   private
	 */

	public function content_filter( $content ) {
		// array of custom shortcodes requiring the fix 
		$all_modules = Tatsu_Module_Options::getInstance()->get_registered_modules();

		$block = join("|", $all_modules ); 
		// opening tag
		$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
			
		// closing tag
		$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
		return $rep;
    }
    
	public function remove_inner_style_from_the_content( $content ) {
		//remove inner <style></style> element from content
		return be_remove_style_from_content($content);
	}

	// Rank Math Seo Plugin Compatibility
	public function rank_math_tatsu_compatibility($content, $post_id){
		$content = do_shortcode($content);
		return str_ireplace("data-src","src",$content);
	}

	//Tatsu standalone trigger do action on wp_body_open
	public function tatsu_standalone_action_wp_body_open(){
		if(!file_exists(TATSU_PLUGIN_DIR . "includes/header-builder/single-tatsu_header-standalone.php")){
			do_action( 'be_themes_before_body' );
			do_action( 'tatsu_print_header' );
			do_action( 'be_themes_before_single_page_content' );
		}
	}

	//Tatsu standalone trigger do action on get_header
	public function tatsu_standalone_action_get_header(){
		if(file_exists(TATSU_PLUGIN_DIR . "includes/header-builder/single-tatsu_header-standalone.php")){
			require_once TATSU_PLUGIN_DIR . "includes/header-builder/single-tatsu_header-standalone.php";
			remove_all_actions('wp_head');
			ob_start();
			locate_template(array('header.php'),true);
			ob_end_clean();
		}

		do_action( 'tatsu_head' );
		if(is_page()){
			do_action( 'be_themes_before_single_page' );
		}else if(is_archive( )){
			do_action( 'be_themes_before_post_archive' );
		}
	}

	//Tatsu standalone trigger do action on get_header
	public function tatsu_standalone_action_get_footer(){
		if(is_page()){
			do_action( 'be_themes_after_single_page' );
		}else if(is_archive( )){
			do_action( 'be_themes_after_post_archive' );
		}
		if(file_exists(TATSU_PLUGIN_DIR . "includes/footer-builder/single-tatsu_footer-standalone.php")){
			require_once TATSU_PLUGIN_DIR . "includes/footer-builder/single-tatsu_footer-standalone.php";
			remove_all_actions('wp_footer');
			ob_start();
			locate_template(array('footer.php'),true);
			ob_end_clean();
		}else{
			do_action( 'tatsu_footer' );
			do_action( 'tatsu_print_footer' );
		}	
	}
		
    public function tatsu_add_common_atts_to_shortcodes() {
        $all_builder_modules = Tatsu_Module_Options::getInstance()->get_module_options();
        $remapped_modules = Tatsu_Module_Options::getInstance()->get_remapped_modules();
        $all_header_modules = Tatsu_Header_Module_Options::getInstance()->get_module_options();
        $plugin_public = new Tatsu_Public( $this->get_plugin_name(), $this->get_version() );
        $all_modules = $all_builder_modules + $all_header_modules + $remapped_modules;
        foreach( $all_modules as $tag => $options ) {
            add_filter( "shortcode_atts_$tag", array( $plugin_public, 'tatsu_add_common_atts_to_shortcode' ), 10, 4 );
        }
    }

	/**
	 * Get Images From ID's via Admin Ajax
	 * @since    1.0.1
	 * @access   public
	 */

	public function ajax_get_images_from_id(){
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}

		$images =  stripslashes( $_POST['images'] );
		$size =  be_sanitize_text_field($_POST['size']);
		if( $images ) {
			$images = json_decode( $images, true );
		}
		$image_url = array();
		foreach ($images as $id) {
			$image = wp_get_attachment_image_src( $id, $size );
			if( $image ) {
				$image_url[$id] = $image[0];
			} else {
				$image_url[$id] = '';
			}
		}

		echo json_encode($image_url);
		exit;
	}

	/**
	 * Get Image Url of a particular size
	 * @since    2.0
	 * @access   public
	 */

	 public function ajax_get_image() {
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}

		$id = be_sanitize_text_field($_POST['id']);
		$size = be_sanitize_text_field($_POST['size']);
		$image = be_sanitize_text_field($_POST['image']);
		$upload_dir_paths = wp_upload_dir();
		if ( false !== strpos( $image, $upload_dir_paths['baseurl'] ) ) {
			$image_details = wp_get_attachment_image_src( $id, $size ); 
			if( $image_details ){
				echo $image_details[0];
			} else {
				echo $image;
			}
		} else {
			echo $image;
		}
		
		exit;
	 }



	/**
	 * Add an Edit with Tatsu link to the admin bar.
	 *
	 * @since    1.0.0
	 * @access   private
	 */

	public function admin_bar_edit_link( WP_Admin_Bar $wp_admin_bar ) {
        global $post_id;
        if( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }
		if( !is_archive() && !is_admin() && tatsu_is_post_editable_by_current_user( $post_id ) ) {
			$wp_admin_bar->add_node( array(
				'id'    => 'tatsu_edit_page',
				'title' => esc_html__( 'Edit with Tatsu', 'tatsu' ),
				'href'  => tatsu_edit_url( $post_id ),
			));	
		}

		if( current_theme_supports('tatsu-header-builder') && current_user_can( 'manage_options' ) ) {
			// $wp_admin_bar->add_node( array(
			// 	'id'    => 'tatsu_header_builder',
			// 	'title' => esc_html__( 'Tatsu Header Builder', 'tatsu' ),
			// 	'href'  => tatsu_header_builder_url(),
			// ));	
		}

		if( current_theme_supports('tatsu-footer-builder') && current_user_can( 'manage_options' ) ) {
			// $wp_admin_bar->add_node( array(
			// 	'id'    => 'tatsu_footer_builder',
			// 	'title' => esc_html__( 'Tatsu Footer Builder', 'tatsu' ),
			// 	'href'  => tatsu_footer_builder_url(),
			// ));	
		}
	}

	/**
	 * Save Tatsu Page Content meta in json format along with Revisions.
	 *
	 * @since    1.0.0
	 * @access   private
	 */

	public function after_save_post( $post_id ) {
		if( array_key_exists( '_edited_with', $_POST ) ) {
			update_post_meta( $post_id, '_edited_with', be_sanitize_text_field($_POST['_edited_with']) );
		}

		$parent_id = wp_is_post_revision( $post_id );

		if ( $parent_id ) {

			$parent  = get_post( $parent_id );
			$tatsu_content = get_post_meta( $parent->ID, '_tatsu_page_content', true );

			if ( false !== $tatsu_content )
				add_metadata( 'post', $post_id, '_tatsu_page_content', $tatsu_content );

		}
	}

	/**
	 * Restore Tatsu Page Content meta in json format when a post revision is restored 
	 *
	 * @since    1.0.0
	 * @access   private
	 */	

	public function restore_revision( $post_id, $revision_id ) {

		$post     = get_post( $post_id );
		$revision = get_post( $revision_id );
		$tatsu_content  = get_metadata( 'post', $revision->ID, '_tatsu_page_content', true );

		if ( false !== $tatsu_content ) {
			update_post_meta( $post_id, '_tatsu_page_content', $tatsu_content );
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
	 * @return    Tatsu_Loader    Orchestrates the hooks of the plugin.
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

	public function fonts_to_load($content){
		global $post;

		if( is_object ($post) ){
			$header_fonts = array();
			if( current_theme_supports('tatsu-header-builder') ) {
				$post_type = get_post_type();
				$header_id = 0;
				if( TATSU_HEADER_CPT_NAME === $post_type ) {
					$header_id = $post->ID;
				} else {
					$header_id  = tatsu_get_active_header_id();
				}

				$header_store = new Tatsu_Header_Store( $header_id );
				$header_content = $header_store->get_header_store();

				$header_fonts = $header_content['fonts'];
		
				if( isset( $header_fonts[0] ) ){
					$header_fonts = $header_fonts[0];
				}
			}

			$body_fonts =  get_post_meta( $post->ID , 'tatsu_body_fonts', true );

			if( !empty( $body_fonts ) ){
				$fonts_to_load = array_merge_recursive( $header_fonts, $body_fonts );
			} else {
				$fonts_to_load = $header_fonts;
			}
			if( !empty($fonts_to_load) && is_array( $fonts_to_load ) ){
				return array_merge_recursive( $content, $fonts_to_load );
			} else {
				return $content;
			}	
		}
		return $content;
	}

	public function tatsu_add_image_size() {
		if( function_exists( 'add_image_size' ) ) {
			add_image_size( 'tatsu_lazyload_thumb', 50, 0, true );
		}
	}
}