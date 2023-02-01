<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Module_Options {

	private static $instance;
	private $modules;
	private $module_options;
	private $remapped_modules;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
		$this->modules = array();
		$this->module_options = array();
		$this->remapped_modules = array();
	}


	public function deregister_module( $tag ) {
		if( 'core' === $this->get_module_type( $tag ) ) {
			return;
		} else if( array_key_exists($tag, $this->modules) ) {
			if( shortcode_exists( $tag ) ) {
				remove_shortcode( $tag );
			}
			unset( $this->modules[$tag] );
		}
	}

	public function register_module( $tag, $options, $output_function = '' ) {
		if( function_exists( $output_function ) ) {
			add_shortcode( $tag, $output_function );
		}

        if( array_key_exists( 'group_atts', $options ) ) {
            tatsu_parse_group_atts( $options['group_atts'], $options['atts'] );
        }
        $options = apply_filters( 'tatsu_register_module_filter_options', $options, $tag );
        $options = tatsu_parse_module_options($options);

		$new_module = array( $tag => $options );
		$this->modules = array_merge( $this->modules, $new_module );
	}


	public function remap_modules( $tags, $options, $output_function ) {
		$module_name = array_shift($tags);
		if( is_array( $tags ) ) {
			foreach( $tags as $module ) {
				add_shortcode($module, $output_function);
				if( array_key_exists( $module_name, $this->remapped_modules ) ) {
					unset($this->remapped_modules[$module_name]);
				}
				$this->remapped_modules[$module] = $module_name;
			}
		}
		add_shortcode( $module_name, $output_function );
        
        if( array_key_exists( 'group_atts', $options ) ) {
            tatsu_parse_group_atts( $options['group_atts'], $options['atts'] );
        }
        $options = apply_filters( 'tatsu_register_module_filter_options', $options, $module_name );
        $options = tatsu_parse_module_options($options);

		$new_module = array( $module_name => $options );
		$this->modules = array_merge( $this->modules, $new_module );
	}

	public function get_modules() {
		return $this->modules;
	}

	public function get_remapped_modules() {
		return $this->remapped_modules;
	}

	public function get_module_options() {
		$all_modules = $this->modules;
		foreach( $this->remapped_modules as $remapped_module => $remapped_to ) {
			unset($all_modules[$remapped_module]);
		}
		$this->module_options = $all_modules;
		return $this->module_options;
	}

	public function setup_hooks() {
		do_action( 'tatsu_register_modules' );
		do_action( 'tatsu_deregister_modules' );	
	}

	public function get_module_type( $tag ){
		if( array_key_exists( $tag, $this->modules ) ){
			return $this->modules[$tag]['type'];
		} else {
			return false;
		}
	}

	public function is_built_in( $tag ){
		if( array_key_exists( $tag, $this->modules ) && array_key_exists( 'is_built_in', $this->modules[$tag] ) ){
			return $this->modules[$tag]['is_built_in'];
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