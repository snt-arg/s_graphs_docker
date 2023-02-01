<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Typehub
 * @subpackage Typehub/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Typehub
 * @subpackage Typehub/admin
 * @author     Brand Exponents <swami@brandexponents.com>
 */
class Typehub_Admin {

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

		if( 'toplevel_page_typehub' === $hook  ) {
			//$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			$suffix = '';
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/typehub-admin'.$suffix.'.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {	

		if( 'toplevel_page_typehub' === $hook  ) {	 
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/typehub-admin.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( 'typehub-bundle', plugin_dir_url( __FILE__ ) . 'js/bundle'.$suffix.'.js', array(), $this->version, true );
			wp_enqueue_script( 'webfont-loader', '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js' );

			$store = new Typehub_Store();
			$google_fonts = include TYPEHUB_PLUGIN_DIR.'includes/fonts/google-fonts.php';
			$standard_fonts = be_standard_fonts();
			$custom_fonts = Typehub_Custom_Fonts::getInstance()->get_fonts();
			$settings = $store->get_store();
			$typekit_fonts = array();
			if( !empty( $settings['settings']['typekitId'] ) ) {
				$typekit_fonts = typehub_get_typekit_data($store->get_store()['settings']['typekitId']);
			} 
		
			$typehub_fonts = array(
				'google' => ( $google_fonts ) ? $google_fonts : array(),
				'standard' => ( $standard_fonts )? $standard_fonts : array(),
				'custom' => $custom_fonts,
				'typekit' => ( $typekit_fonts ) ? $typekit_fonts : array()
			);

			wp_localize_script( 'typehub-bundle', 'typehub_fonts', $typehub_fonts );
			
			wp_localize_script( 'typehub-bundle', 'typehubStore', $store->get_store() );

			wp_localize_script( 'typehub-bundle', 'local_google_fonts', get_saved_fonts() );

			$typehub_server_config = array(
				'plugin_url' => TYPEHUB_PLUGIN_URL,
			);
			wp_localize_script( 'typehub-bundle', 'typehub_server_config', $typehub_server_config );

			wp_localize_script( 'typehub-bundle', 'typehubAjax', array(
				'nonce' => wp_create_nonce('typehub-security'),
			));
			do_action( 'typehub_add_data' );


			$colorhub_data = get_option( 'colorhub_data' );
			if( !empty( $colorhub_data ) ){
				wp_localize_script( 'typehub-bundle', 'colorhub', $colorhub_data );
			}


		}

	}


	/**
	 * Registers admin menu.
	 *
	 * @since    1.0.0
	 */	
	public function addAdminMenu() {	

		add_menu_page(
			'Type Hub',
			'Type Hub',
			'manage_options',
			'typehub',
			array(
				$this,
				'adminPage'
			)
		);

	}

	/**
	 * Print root div in admin area for react to mount to.
	 *
	 * @since    1.0.0
	 */	
	public function adminPage() {
		echo '<div id="root"></div>';
	}

	public function get_exposed_selectors(){

		wp_localize_script (
			'tatsu',
			'typehub_selectors',
			typehub_get_exposed_selectors()
		);	
	}

	public function get_font_options(){

		wp_localize_script (
			'tatsu',
			'typehub_font_options',
			typehub_get_font_options()
		);	
	}
}
