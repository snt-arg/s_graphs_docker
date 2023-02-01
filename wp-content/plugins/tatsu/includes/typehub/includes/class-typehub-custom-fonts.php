<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Typehub_Custom_Fonts {

    private static $instance;
    private $fonts;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
        $this->fonts = array();
    }

    public function get_font( $font ) {
        if( !empty( $this->fonts[ $font ] ) ) {
            return $this->fonts[$font];
        } else {
            return false;
        }
    }

    public function get_fonts(  ) {
        return $this->fonts;
    }
         

    public function register_font( $font ) {
        if( !empty( $font['name'] ) ) {
            $variants = ( !empty( $font['variants'] ) ) ? $font['variants'] : array();
            $subsets = ( !empty( $font['subsets'] ) ) ? $font['subsets'] : array();
            $new_variants = array();
            $new_subsets = array();
            foreach( $variants as $id => $name ) {
                $variant = array(
                    'id' => (string)$id,
                    'name' => $name,
                );
                $new_variants[] = $variant;
            }
            foreach( $subsets as $id => $name ) {
                $subset = array(
                    'id' => $id,
                    'name' => $name,
                );
                $new_subsets[] = $subset;
            }
            $this->fonts[ $font['name'] ] = array(
                'subsets' => $new_subsets,
                'variants' => $new_variants,
                'src' => ( !empty( $font['src'] ) ) ? $font['src'] : '',
            );
        }
    }  
    
    public function deregister_font( $font ) {
        if( array_key_exists( $font, $this->fonts ) ) {
            unset( $this->fonts[ $font ] );
        }
    }  
    
    public function register_fonts( $fonts ) {
        foreach( $fonts as $font ) {
            $this->register_font( $font );
        }
    }  
    
    public function deregister_fonts( $fonts ) {
        foreach( $fonts as $font ) {
            $this->deregister_font( $font );
        }
    }
    
	public function setup_hooks() {
		do_action( 'typehub_register_font' );
		do_action( 'typehub_deregister_font' );		
	}    
    
}