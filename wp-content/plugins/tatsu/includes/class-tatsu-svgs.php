<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Svgs {

	private static $instance;
	private $svgs;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
		$this->svgs = array();
	}

	public function deregister_svgs( $kit ) {
		if( array_key_exists( $kit, $this->svgs ) ) {
			unset( $this->svgs[$kit] );
		}
	}	

	public function register_svgs( $kit, $title, $icons, $abspath ) {
		$title = !empty( $title )? $title : $kit;
		$new_svg_kit = array( 
			$kit => array(
				'title' => $title,	
                'icons' => $icons,
                'link' => trailingslashit(  $abspath ),
            )
		);
		$this->svgs = array_merge( $this->svgs, $new_svg_kit );
	}

	public function get_svgs() {
		return $this->svgs;
	}

	public function setup_hooks() {
		do_action( 'tatsu_register_svgs' );
		do_action( 'tatsu_deregister_svgs' );		
	}
 
}

?>