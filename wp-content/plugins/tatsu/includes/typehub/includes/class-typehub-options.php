<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Typehub_Options {

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
            'uncategorized' => __( 'Uncategorized', 'typehub' )
        );
    }

    public function register_option( $id, $option, $category = 'uncategorized' ) {
        if( !empty( $id ) && !empty( $option ) && is_array( $option ) )  {
            $option['category'] = $category;
            $this->options[$id] = $option; 
        }
    }

    public function deregister_option( $id ) {
        if( !empty( $id ) ) {
            if( array_key_exists( $id, $this->options ) ) {
                unset( $this->options[$id] );
            }
        }
    }
    
    public function register_options( $options, $category = 'uncategorized' ) {
        if( is_array( $options ) && !empty( $options ) ) {
            foreach( $options as $id => $option ) {
                $this->register_option( $id, $option, $category );  
            }
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
		do_action( 'typehub_register_categories' );
        do_action( 'typehub_deregister_categories' );
		do_action( 'typehub_register_options' );
		do_action( 'typehub_deregister_options' );        		
    }  
    
    public function get_options() {
        return $this->options;
    }

    public function get_categories() {
        return $this->categories;
    }

}