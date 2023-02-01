<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Oshine_Modules
 * @subpackage Oshine_Modules/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Oshine_Modules
 * @subpackage Oshine_Modules/public
 * @author     Brand Exponents <swami@brandexponents.com>
 */
class Oshine_Modules_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Oshine_Modules_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Oshine_Modules_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $be_themes_data;
		$minified_assets = ( isset( $be_themes_data[ 'minified_css' ] ) && !empty( $be_themes_data[ 'minified_css' ] ) ) ? true : false;
		$suffix = ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || !$minified_assets ) ? '' : '.min';
		if( !empty($suffix) ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/oshine-modules.min.css', array(), $this->version, 'all' );
		}else {
			wp_enqueue_style( 'be-slider', plugin_dir_url( __FILE__ ) . 'css/be-slider.css' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/oshine-modules.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/justified-gallery.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Oshine_Modules_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Oshine_Modules_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $be_themes_data;
		$language = get_bloginfo( 'language' );
		$language = explode( '-', $language );
		if( file_exists( OSHINE_MODULES_PLUGIN_DIR.'public/js/vendor/countdown/jquery.countdown-'.$language[0].'.js' ) ) {
			$countdown_lang_file = OSHINE_MODULES_PLUGIN_URL.'/public/js/vendor/countdown/jquery.countdown-'.$language[0].'.js';
		} else {
			$countdown_lang_file = false;
		}

		$minified_assets = isset( $be_themes_data[ 'minified_js' ] ) && !empty( $be_themes_data[ 'minified_js' ] ) ? true : false;
		$suffix = ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || !$minified_assets ) ? '' : '.min';
		wp_enqueue_script( 'asyncloader', plugin_dir_url( __FILE__ ) . 'js/vendor/asyncloader' . $suffix . '.js', array( 'jquery' ), '1.0', true );
		if( $countdown_lang_file ) {
			wp_enqueue_script( 'countdown', plugin_dir_url( __FILE__ ) . 'js/vendor/countdown' . $suffix . '.js', array( 'jquery' ), '2.0.2', true );
			wp_enqueue_script( 'countdown-lang', $countdown_lang_file, array( 'jquery', 'countdown' ), '1.0', true );
		}
		//wp_enqueue_script( 'isotope', plugin_dir_url( __FILE__ ) . 'js/vendor/isotope.js', array( 'jquery' ), '1.0', true );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/oshine-modules' . $suffix . '.js', array( 'jquery', 'asyncloader', 'jquery-ui-core','jquery-ui-accordion','jquery-ui-tabs' ), $this->version, true );
		$needed_scripts = array();
		foreach( glob( OSHINE_MODULES_PLUGIN_DIR.'public/js/vendor/*'. $suffix .'.js') as $dependency ) {
			$current_index = basename( $dependency, $suffix . '.js' );
			$needed_scripts[ $current_index ] = esc_url( OSHINE_MODULES_PLUGIN_URL.'/public/js/vendor/' . basename( $dependency ) );
		}	
		if( $countdown_lang_file ) {
			$needed_scripts['countdownLangFile'] = $countdown_lang_file;
		}
		wp_localize_script(
			$this->plugin_name, 
			'oshineModulesConfig', 
			array(
				'pluginUrl' => plugins_url().'/'.$this->plugin_name.'/',
				'vendorScriptsUrl' => ( isset( $be_themes_data[ 'cdn_address' ] ) && !empty( $be_themes_data[ 'cdn_address' ] ) ) ? ( trailingslashit( $be_themes_data[ 'cdn_address' ] ) . 'wp-content/plugins/'. $this->plugin_name.'/public/js/vendor/' ) : ( plugins_url().'/'.$this->plugin_name.'/public/js/vendor/' ),
				'dependencies'     => $needed_scripts,
			) 
		);		

	}

	public function frame_enqueue() {
		global $be_themes_data;
		$minified_assets = isset( $be_themes_data[ 'minified_js' ] ) && !empty( $be_themes_data[ 'minified_js' ] ) ? true : false;
		$suffix = ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || !$minified_assets ) ? '' : '.min';
		wp_enqueue_script( 'resizetoparent', plugin_dir_url( __FILE__ ) . 'js/vendor/resizetoparent'. $suffix .'.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'be-slider', plugin_dir_url( __FILE__ ) . 'js/vendor/beslider' . $suffix . '.js', array( 'jquery', 'resizetoparent' ), false , true );
	}

}
