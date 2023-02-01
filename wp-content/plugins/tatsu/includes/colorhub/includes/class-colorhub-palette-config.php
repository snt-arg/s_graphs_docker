<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Colorhub_Palette_Config {

    private static $instance;
    private $palettes;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
        $this->palettes = array();
    }

    public function get_palettes() {  
        return $this->palettes;
    }
         

    public function register_palette( $palette ) {
        if( !empty( $palette['id'] ) && is_array( $palette['colors'] ) && 5 === count( $palette['colors'] ) ) {
            $this->palettes[$palette['id']] = $palette['colors'];
        }
    }  
    
    public function deregister_palette( $id ) {
        if( !empty( $id ) && 'default' !== $id ) {
            unset( $this->palettes[$id] );
        }
    }  
    
    public function register_palettes( $palettes ) {
        foreach( $palettes as $palette ) {
            if( is_array( $palette ) ) {
                $this->register_palette( $palette );
            }
        }
    }  
    
    public function deregister_palettes( $ids ) {
        foreach( $ids as $id ) {
                $this->deregister_palette( $id );
        }
    }
    
	public function setup_hooks() {
		do_action( 'colorhub_register_palettes' );
		do_action( 'colorhub_deregister_palettes' );		
	}  
    
}