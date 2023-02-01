<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Colors {

	private static $instance;
	private $colors;
	private $color_picker_defaults;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
		$this->colors = array();
		$this->color_picker_defaults = array();
		$this->tatsu_register_colors();
	}

	private function tatsu_register_colors() {
		$this->register_color( 'tatsu_accent_color', esc_html__('Accent Color', 'tatsu'), '#000000' );
		$this->register_color( 'tatsu_accent_twin_color', esc_html__('Accent\'s Complimentary Color', 'tatsu'), '#ffffff' );
	}


	public function deregister_color( $slug ) {
		if( array_key_exists( $slug, $this->colors ) ) {
			unset( $this->icons[$slug] );
		}
	}	

	public function register_color( $slug, $title, $color ) {
		$title = !empty( $title )? $title : $slug;
		$new_color = array( 
						$slug => array(
							'title' => $title,	
							'value' => $color,
						)
					);
		$this->colors = array_merge( $this->colors, $new_color );
	}


	public function register_color_picker_defaults( $colors ) {
		array_merge( $this->color_picker_defaults , $colors );
		$this->color_picker_defaults = array_unique( $this->color_picker_defaults );
	}

	public function deregister_color_picker_defaults( $colors ) {
		foreach ( $colors as $color ) {
			if( ( $key = array_search( $color, $this->color_picker_defaults ) ) !== false ) {
			    unset( $this->color_picker_defaults[$key] );
			}
		}		
	}

	public function get_colors() {
		return $this->colors;
	}

	public function get_color( $slug ) {
		if( array_key_exists( $slug, $this->colors ) ) {
			return $this->colors[$slug]['value'];
		} else {
			return false;
		}
	}

	public function get_color_picker_defaults() {
		return $this->color_picker_defaults;
	}

	public function setup_hooks() {
		do_action( 'tatsu_register_colors' );
		do_action( 'tatsu_deregister_colors' );		
	}
 
}

?>