<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Header_Module_Options {

	private static $instance;
	private $modules;
	private $module_options;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
		$this->modules = array();
		$this->module_options = array();
	}


	public function deregister_module( $tag ) {
		if( 'core' === $this->get_module_type( $tag ) ) {
			return;
		} else if( array_key_exists($tag, $this->modules) ) {
			if( is_array( $this->modules[ $tag ] ) && !empty( $this->modules[ $tag ]['shortcode_registered'] ) ) {
				remove_shortcode( $tag );
			}
			unset( $this->modules[$tag] );
		}
	}

	public function register_module( $tag, $options, $output_function, $register_shortcode = false ) {
		$options['output'] = $output_function;
		if( array_key_exists('atts', $options ) && is_array( $options['atts'] ) ) {	
			$atts = be_reformat_module_options( $options['atts'] );
			$atts = apply_filters( 'tatsu_header_modify_atts', $atts, $tag );
			$atts = be_reverse_reformat_atts( $atts );
			$options['atts'] = $atts;
		}
		if( true === $register_shortcode && function_exists( $output_function ) ) {
			$options[ 'shortcode_registered' ] = true;
			add_shortcode( $tag, $output_function );
		}else {
			$options[ 'shortcode_registered' ] = false;
        }
        
        if( array_key_exists( 'group_atts', $options ) ) {
            tatsu_parse_group_atts( $options['group_atts'], $options['atts'] );
        }
        $options = apply_filters( 'tatsu_register_header_module_filter_options', $options, $tag );
        $options = tatsu_parse_module_options($options);
		$new_module = array( $tag => $options );
		$this->modules = array_merge( $this->modules, $new_module );
	}

	public function get_modules() {
		return $this->modules;
	}

	public function get_module( $tag ) {
		if( array_key_exists( $tag, $this->modules ) ) {
			return $this->modules[$tag];
		}
		return false;
	}

	public function get_module_options() {
        $this->module_options = $this->modules;
		return $this->module_options;
	}

	public function setup_hooks() {
		do_action( 'tatsu_register_header_modules' );
		do_action( 'tatsu_deregister_header_modules' );		
	}

	public function get_module_type( $tag ){
		if( array_key_exists( $tag, $this->modules ) ){
			return $this->modules[$tag]['type'];
		} else {
			return false;
		}
	}

	public function get_core_modules(){
		$core_modules = array();
		foreach ( $this->modules as $tag => $options ) {
			if( 'core' === $options['type'] ) {
				$core_modules[] = $tag;
			}
		}
		return $core_modules;
	}

	public function get_registered_modules() {
		return array_keys( $this->modules );
	}
 
}

?>