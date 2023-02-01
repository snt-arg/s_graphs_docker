<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Colorhub
 * @subpackage Colorhub/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Colorhub
 * @subpackage Colorhub/public
 * @author     Brand Exponents Creatives Pvt Ltd <swami@brandexponents.com>
 */
class Colorhub_Public {

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
		 * defined in Colorhub_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Colorhub_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	//	wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/colorhub-public.css', array(), $this->version, 'all' );

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
		 * defined in Colorhub_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Colorhub_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	//	wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/colorhub-public.js', array( 'jquery' ), $this->version, false );

	}

	public function load_inside_tatsu() {
		$store = new Colorhub_Store();
		wp_localize_script (
			'tatsu',
			'colorhub',
			$store->get_store()
		);		
	}

	public function generate_css(){
		$store = new Colorhub_Store();
		$store = $store->get_store();
		$swatches = $store['swatches'];
		$palettes = $store['palettes']['allPalettes'][$store['palettes']['currentPalette']];
		$output = '';

		$output .= '<style rel="stylesheet" id="colorhub-output">';
		foreach( $swatches as $swatch => $value ){

			if( !is_array( $value['color'] ) ){
				$output .= '.swatch-'.$swatch.', .swatch-'. $swatch .' a{color:'.$value['color'].';}';
			}else{
				if( function_exists('be_gradient_color') ){
					$gradient_color = be_gradient_color($value['color']);
					$output .= '.swatch-'.$swatch.', .swatch-'. $swatch .' a{background:'.$gradient_color[0].';';
					$output .= '-webkit-background-clip:text;-webkit-text-fill-color:transparent;}';
				}
			}
		}
		foreach( $palettes as $palette => $value ){

			if( !is_array( $value ) ){
				$output .= '.palette-'.$palette.', .palette-'. $palette .' a{color:'.$value.';}';
			}else{
				if( function_exists('be_gradient_color') ){
					$gradient_color = be_gradient_color($value);
					$output .= '.palette-'.$palette.', .palette-'. $palette .' a{background:'.$gradient_color[0].';';
					$output .= '-webkit-background-clip:text;-webkit-text-fill-color:transparent;}';
				}
			}

		}
		$output .= '</style>';

		echo $output;

	}

}
