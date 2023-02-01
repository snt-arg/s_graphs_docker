<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Be_Gdpr_Options {

    private static $instance;
    private $options;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
        $this->options = array();
    }

    public function register_option( $id, $option) {
        if( !empty( $id ) && !empty( $option ) && is_array( $option ) )  {
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


	public function setup_hooks() {
		do_action( 'be_gdpr_register_options' );
		do_action( 'be_gdpr_deregister_options' );
    }
    
    public function get_options() {
        return $this->options;
    }

}