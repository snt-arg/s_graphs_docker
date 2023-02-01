<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Typehub_Font_Schemes {

    private static $instance;
    private $predefined_schemes;
    private $saved_schemes;
    private $store;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
        $this->predefined_schemes = array();
        $this->store = get_option( 'typehub_data', array(
            'font_schemes' => array(),
            'values' => array()
        ));
        $this->saved_schemes = ( !empty( $this->store['font_schemes'] ) ) ? $this->store['font_schemes'] : array();
    }

    public function get_scheme( $id ) {
        $schemes = $this->get_schemes();
        if( array_key_exists( $id, $schemes ) ) {
            return $schemes[$id];
        } else {
            return false;
        }
    }

    public function get_schemes() {
        return array_merge( $this->predefined_schemes, $this->saved_schemes );
    }
         

    public function register_scheme( $scheme ) {
        if( !empty( $scheme['id'] ) && !empty( $scheme['font-family'] ) ) {
            $this->predefined_schemes[$scheme['id']] = array(
                'fontFamily' => $scheme['font-family']
            );
            if( !empty( $scheme['name'] ) ) {
                $this->predefined_schemes[$scheme['id']]['name'] = $scheme['name'];
            } else {
                $this->predefined_schemes[$scheme['id']]['name'] = $scheme['font-family'];
            }
            if( !empty( $scheme['subsets'] ) ) {
                $this->predefined_schemes[$scheme['id']]['subsets'] = $scheme['subsets'];
            }
            if( array_key_exists( 'active', $scheme ) ) {
                $this->predefined_schemes[$scheme['id']]['active'] = $scheme['active'];
            }            
        }
    }  
    
    public function deregister_scheme( $id ) {
        if( !empty( $id ) ) {
            unset( $this->predefined_schemes[$id] );
        }
    }  
    
    public function register_schemes( $schemes ) {
        foreach( $schemes as $scheme ) {
            if( is_array( $scheme ) ) {
                $this->register_scheme( $scheme );
            }
        }
    }  
    
    public function deregister_fonts( $ids ) {
        foreach( $ids as $id ) {
                $this->deregister_scheme( $id );
        }
    }
    
	public function setup_hooks() {
		do_action( 'typehub_register_schemes' );
		do_action( 'typehub_deregister_schemes' );		
	}    
    
}