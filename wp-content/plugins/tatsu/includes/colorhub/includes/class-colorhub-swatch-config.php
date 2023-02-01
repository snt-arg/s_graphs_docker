<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Colorhub_Swatch_Config {

    private static $instance;
    private $swatches;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
        $this->swatches = array();
    }

    public function get_swatches() {  
        return $this->swatches;
    }
         

    public function register_swatch( $swatch ) {
        if( !empty( $swatch['id'] ) && !empty( $swatch['color'] ) ) {
            $this->swatches[$swatch['id']] = array(
                'label' => $swatch['label'],
                'color' => $swatch['color']
            );
        }
    }  
    
    public function deregister_swatch( $id ) {
        if( !empty( $id ) ) {
            unset( $this->swatches[$id] );
        }
    }  
    
    public function register_swatches( $swatches ) {
        foreach( $swatches as $swatch ) {
            if( is_array( $swatch ) ) {
                $this->register_swatch( $swatch );
            }
        }
    }  
    
    public function deregister_swatches( $ids ) {
        foreach( $ids as $id ) {
                $this->deregister_swatch( $id );
        }
    }
    
	public function setup_hooks() {
		do_action( 'colorhub_register_swatches' );
		do_action( 'colorhub_deregister_swatches' );		
	}    
    
}