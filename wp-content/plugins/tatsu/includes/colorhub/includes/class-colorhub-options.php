<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Colorhub_Options {

    private static $instance;
    private $options;
    private $categories;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
        $this->options = array();
        $this->categories = array(
            'uncategorized' => __( 'Uncategorized', 'colorhub' )
        );
    }

    public function register_option( $id, $option ) {
        if( !empty( $id ) && !empty( $option ) && is_array( $option ) && !empty( $option['id'] ) ) {
            $this->options[$id] = $option;
        }
    }

    public function deregister_option( $id ) {
        if( !empty( $id ) ) {
            unset( $this->option[$id] );
        } 
    }
    
    public function register_options( $options ) {
        if( is_array( $options ) && !empty( $options ) )
        foreach( $options as $id => $option ) {
            $this->register_option( $id, $option );  
        }
    }    
    
    public function deregister_options( $ids ) {
        if( !empty( $ids ) && is_array( $ids ) ) {
            foreach( $ids as $id ) {
                $this->deregister_option( $id );
            }
        }
    }    

    public function register_category( $id, $label ) {
        if( !empty( $id ) && 'uncategorized' !== $id && !empty( $label ) ) {
            $this->categories[$id] = $label;        
        }
    }

    public function deregister_category( $id ) {
        if( !empty( $id ) && 'uncategorized' !== $id ) {
            unset( $this->categories[$id] );
        }
    }

    public function register_categories( $categories ) {
        foreach( $categories as $id => $label ) {
            $this->register_category( $id, $label );
        }
    }

    public function deregister_categories( $ids ) {
        if( !empty( $ids ) && !is_array( $ids ) ) {
            foreach( $ids as $id ) {
                $this->deregister_category( $id );
            }
        }
    }  
    
	public function setup_hooks() {
		do_action( 'colorhub_register_categories' );
        do_action( 'colorhub_deregister_categories' );
		do_action( 'colorhub_register_options' );
		do_action( 'colorhub_deregister_options' );        		
    }  
    
    public function get_options() {
        return $this->options;
    }

    public function get_categories() {
        return $this->categories;
    }

}