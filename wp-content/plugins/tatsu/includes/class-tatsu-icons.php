<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Icons {

	private static $instance;
	private $icons;
	private $icon_stylesheets;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
		$this->icons = array();
		$this->icon_stylesheets = array();
	}


	public function enqueue_styles() {
		foreach( $this->icon_stylesheets as $kit => $stylesheet_url ) {
			wp_deregister_style( $kit );
			wp_register_style( $kit, $stylesheet_url );
			wp_enqueue_style( $kit );
		}
	}

	public function deregister_icons( $kit ) {
		if( array_key_exists( $kit, $this->icons ) && array_key_exists( $kit, $this->icon_stylesheets ) ) {
			unset( $this->icons[$kit] );
			unset( $this->icon_stylesheets[$kit] );
		}
	}	

	public function valid_icon( $icon ) {
		foreach( $this->icons as $kit => $options ) {
			if( is_array($options) && is_array( $options['icons'] ) && in_array( $icon, $options['icons'] ) ) {
				return true;
			}
		}
		return false;
	}

	public function get_random_icon() {
		foreach( $this->icons as $kit => $options ) {
			if( is_array($options) && is_array( $options['icons'] ) && !empty( $options['icons'][0] ) ) {
				return apply_filters( 'tatsu_module_options_fallback_icon', $options['icons'][0], $this->icons );
			}
		}
		return '';
	}

	public function register_icons( $kit, $title, $icons, $stylesheet_url ) {
		$title = !empty( $title )? $title : $kit;
		$new_icon_kit = array( 
			$kit => array(
				'title' => $title,	
				'icons' => $icons,
			)
		);
		$new_icon_stylesheet = array( $kit => $stylesheet_url );
		$this->icons = array_merge( $this->icons, $new_icon_kit );
		$this->icon_stylesheets = array_merge( $this->icon_stylesheets, $new_icon_stylesheet );
	}

	public function get_icons() {
		return $this->icons;
	}

	public function setup_hooks() {
		do_action( 'tatsu_register_icons' );
		do_action( 'tatsu_deregister_icons' );	
	}
 
}

?>