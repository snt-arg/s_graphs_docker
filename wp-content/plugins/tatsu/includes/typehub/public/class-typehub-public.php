<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Typehub
 * @subpackage Typehub/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Typehub
 * @subpackage Typehub/public
 * @author     Brand Exponents <swami@brandexponents.com>
 */
class Typehub_Public {

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
		$plugin_store = new Typehub_Store();
		$store = $plugin_store->get_store();
		$settings = !empty( $store['settings'] ) ? $store['settings'] : array();

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/typehub-public.css', array(), $this->version, 'all' );
		if( array_key_exists( 'loadFromLocal', $settings ) ){
			if($settings['loadFromLocal'] === true ){
				wp_enqueue_style( 'google-fonts', content_url() . '/uploads/typehub/google-fonts.css', array(), $this->version, 'all' );
			}
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_enqueue_script( 'webfontloader', TYPEHUB_PLUGIN_URL.'/public/js/webfont' .$suffix . '.js' );
	}

	/**
	 * Generates CSS based on the typography values.
	 *
	 * @since    1.0.0
	 */

	public function generate_css() {


		$plugin_store = new Typehub_Store();
		$store = $plugin_store->get_store();
		$options = !empty( $store['optionConfig'] ) ? $store['optionConfig'] : array();
		// print_r( $options );
		// wp_die();
		$saved_values = !empty( $store['savedValues'] ) ? $store['savedValues'] : array();
		$font_schemes = !empty( $store['fontSchemes'] ) ? $store['fontSchemes'] : array();
		$css = array( 'desktop' => '', 'laptop' => '', 'tablet' => '', 'mobile' => '' );
		$output = '';
		// echo '<pre>';
		// print_r( $saved_values );
		// echo '<pre>';
		foreach( $options as $option => $config ) {
			$selector = $config['selector'];
			if( array_key_exists( 'expose', $config ) && !empty( $config[ 'expose' ] ) || ( ( array_key_exists( 'category', $config ) && $config[ 'category' ] == 'Custom' ) ) ) {
				if( !empty( $selector ) ) {
					$selector .= ', .' . $option;
				}else {
					$selector = '.' . $option;
				}
			}

			if( array_key_exists( $option, $saved_values ) && is_array( $saved_values[$option] ) ) {
				$devices = array( 'desktop' => '', 'laptop' => '', 'tablet' => '', 'mobile' => '' );
				foreach( $saved_values[$option] as $property => $values ) {
					if( is_array( $values ) && array_key_exists( 'desktop', $values ) ) { 
						foreach( $values as $device => $value ) {
							if( array_key_exists( $device, $devices ) ) {
								$devices[$device] .= $this->form_css( $property, $value );
							}
						}
					} else {
						$devices['desktop'] .= $this->form_css( $property, $values );
					}
				}

				// if( 'h9' == $option ) {
				// 	// print_r( $selector );
				// 	// print_r(  $saved_values[ $option ]);
				// 	print_r( $devices );
				// 	wp_die();
				// }
				//wrap selector and append to css queue
				foreach( $devices as $device => $code ) {
					if( !empty( $code ) && !empty( $selector ) ) {
						$css[$device] .= $selector.' { '. $code . ' } ';
					}
				}

			}
		}
		$output .= '<style rel="stylesheet" id="typehub-output">';
		$output .= $css['desktop'];
		$output .= '@media only screen and (max-width:1377px) {';
		$output .= $css['laptop'];
		$output .= '}';
		$output .= '@media only screen and (min-width:768px) and (max-width: 1024px) {';
		$output .= $css['tablet'];
		$output .= '}';
		$output .= '@media only screen and (max-width: 767px) {';
		$output .= $css['mobile'];
		$output .= '}';
		$output .= '</style>';
		
		echo be_minify_css( $output );
		//echo $output;

	}

	/**
	 * CSS generation helper.
	 *
	 * @since    1.0.0
	 */

	public function form_css( $property, $value ) {
		$css = '';
		$accepted_properties = array( 'font-family', 'font-variant', 'font-size', 'letter-spacing', 'line-height', 'text-transform', 'color' );
		if( in_array( $property, $accepted_properties )  ) {
			$font_schemes = Typehub_Font_Schemes::getInstance()->get_schemes();
			if( 'font-size' === $property || 'letter-spacing' === $property || 'line-height' === $property  ) {
				if( isset( $value['unit'] ) && isset( $value['value'] ) ) {
					$css .= $property.': '.$value['value'].$value['unit'].';';
				}
			} else if( 'font-variant' === $property ) {
				$css .= 'font-weight: '.be_extract_font_weight( $value ).';';
				$css .= 'font-style: '.be_extract_font_style( $value ).';';
			} else if( 'font-family' === $property ) {
				$family = be_get_font_family( $value );
				if( !empty( $family['value'] ) ) {
					if( 'standard' === $family['source'] ) {
						$font_stack = ';';
						$css .= 'font-family: '.$family['value'].$font_stack;
					} else {
						$font_stack = ",-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;";
						$css .= 'font-family: "'.$family['value'].'"'.$font_stack;
					}
				}
			} else if( 'color' === $property ){
				if( gettype( $value ) === 'string' ){
					$css .= $property.': '.$value.';';
				} else {
					if( function_exists( 'be_compute_color' ) ){
						$css .= $property.': '. be_compute_color( json_encode( $value) )[0].';';
					}
				}
				
			} else {
				if( !empty( $value ) ) {
					$css .= $property.': '.$value.';';
				}
			}
		}
		return $css;
	}

	/**
	 * Loads font files in the front end using WebFont Loader. 
	 *
	 * @since    1.0.0
	 */

	public function load_fonts() {
		$plugin_store = new Typehub_Store();
		$store = $plugin_store->get_store();
		$options = !empty( $store['optionConfig'] ) ? $store['optionConfig'] : array();
		$saved_values = !empty( $store['savedValues'] ) ? $store['savedValues'] : array();
		$font_schemes = !empty( $store['fontSchemes'] ) ? $store['fontSchemes'] : array();
		$settings = !empty( $store['settings'] ) ? $store['settings'] : array();
		$typekit_id = ( array_key_exists( 'typekitId', $settings ) ) ? $settings['typekitId'] : '';
		$unique_fonts = array();
		$webfonts = array();
		$urls = array();
		$webfont_config = '';

		foreach( $options as $option => $config ) {
			if( !empty( $saved_values[$option]['font-family'] ) ) {
				$family = explode( ':', $saved_values[$option]['font-family'] );
				if( !empty( $family[1] ) ) {
					$font = $family[1];
					$source = $family[0];
				} else {
					$font = $family[0];
					$source = 'standard';
				}
				if( !empty( $font ) && !empty( $source ) ) {
					$variant = ( !empty( $saved_values[$option]['font-variant'] ) ) ? $saved_values[$option]['font-variant'] : "400";
					$unique_fonts[$source][$font][] = $variant;
					if( 'custom' === $source ) {
						$url = typehub_get_custom_font_source( $font );
						if( $url ) {
							$urls[] = $url;
						}	
					}
			
				}
			}
		}
		$unique_fonts = apply_filters('tatsu_typography_fonts_to_load', $unique_fonts);


		foreach ( $unique_fonts as $source => $fonts ) {
			foreach( $fonts as $font => $weights ) {
				if( 'standard' !== $source ) {
					if( !empty( $font_schemes[$font] ) ) {
						$scheme_family = explode( ':', $font_schemes[$font]['fontFamily'] );
						if( !empty( $scheme_family[1] ) ) {
							$family = $scheme_family[1];
							$source = $scheme_family[0];
						}
					} else {
						$family = $font;
					}
					$weights = array_unique( $weights );
					$weights_as_string = implode( ',', $weights );
					
					if( 'google' === $source ) {
						$webfonts[$source][] = $family.":".$weights_as_string; // Load Fonts using link tag instead of webfont loader to avoid fout :( TODO: add async loading option
					} else {
						$webfonts[$source][] = "'".$family.":".$weights_as_string."'";
					}

					if( 'custom' === $source ) {
						$url = typehub_get_custom_font_source( $family );
						if( $url ) {
							$urls[] = $url;
						}	
					}
				}
			}
		}
		$urls = array_unique( $urls );
		$urls = array_map( function( $url ) {
			return "'".$url."'";
		}, $urls );
		
		
		foreach( $webfonts as $source => $data ) {	
			if( 'google' === $source ) {
				$data = implode('|', $data );
				//$webfont_config .= "google: { families: [".$data."] },";
				if( array_key_exists( 'loadFromLocal', $settings ) ){
					 if($settings['loadFromLocal'] === false ){
					wp_enqueue_style( 'typehub-google-fonts', typehub_google_fonts_url( $data ), array(), '1.0' );
				}
			}else{
				wp_enqueue_style( 'typehub-google-fonts', typehub_google_fonts_url( $data ), array(), '1.0' );
			}
			}
			if( 'typekit' === $source ) {
				$webfont_config .= "typekit: { id: '".$typekit_id."' },";
			}
			if( 'custom' === $source ) {
				$data = implode(',', $data );
				$webfont_config .= "custom: { families: [".$data."], urls: [".implode(',', $urls )."] },";
			}
		}
		if( !empty( $webfont_config ) ) {
			$script = 'WebFont.load( { '.$webfont_config.' })';
			wp_add_inline_script( 'webfontloader', $script );
		}	
	}

}
