<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Global_Section_Meta {

	private static $instance;
	private $metas;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
		$this->metas = array();
	}

	public function deregister_meta( $tag ) {
		if( array_key_exists($tag, $this->metas) ) {
			unset( $this->metas[$tag] );
		}
	}

	public function register_meta( $tag, $options ) {
		$new_meta = array( $tag => $options );
		$this->metas = array_merge( $this->metas, $new_meta );
	}

	public function get_metas() {
		return $this->metas;
	}

	public function setup_hooks() {
		if( current_theme_supports('tatsu-global-sections') ){
			do_action( 'tatsu_register_global_section_metas' );
		}
	}

	public function get_registered_metas() {
		return array_keys( $this->metas );
	}
 
}

?>