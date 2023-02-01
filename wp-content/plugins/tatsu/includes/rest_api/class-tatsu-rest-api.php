<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Rest_Api {

	private static $instance;
	private $namespace;
	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
		$this->namespace = 'tatsu';
	}

	public function register_rest_routes() {
		$plugin_store = new Tatsu_Store();
		$plugin_module = new Tatsu_Module();
		$header_store = new Tatsu_Header_Store();
		$footer_store = new Tatsu_Footer_Store();

	    register_rest_route( 
	    	$this->namespace.'/v1', 
	    	'/store/', 
	    	array(
		        'methods'  => 'POST',
		        'callback' => array( $plugin_store, 'get_store'),
		        'permission_callback' => function( $request ) {
			    	$nonce = $request->get_header( 'x-wp-nonce' );
			    	if( $nonce && wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			    		return true;
			    	}
			    	return false;
		        }
	  		) 
		);
		
	    register_rest_route( 
	    	$this->namespace.'/v1', 
	    	'/header_store/', 
	    	array(
		        'methods'  => 'POST',
		        'callback' => array( $header_store, 'rest_get_store'),
		        'permission_callback' => function( $request ) {
			    	$nonce = $request->get_header( 'x-wp-nonce' );
			    	if( $nonce && wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			    		return true;
			    	}
			    	return false;
		        }
	  		) 
		);
		
		register_rest_route( 
	    	$this->namespace.'/v1', 
	    	'/footer_store/', 
	    	array(
		        'methods'  => 'POST',
		        'callback' => array( $footer_store, 'rest_get_store'),
		        'permission_callback' => function( $request ) {
			    	$nonce = $request->get_header( 'x-wp-nonce' );
			    	if( $nonce && wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			    		return true;
			    	}
			    	return false;
		        }
	  		) 
	    );

	    register_rest_route( 
	    	$this->namespace.'/v1', 
	    	'/get_template/', 
	    	array(
		        'methods'  => 'POST',
		        'callback' => array( Tatsu_Page_Templates::getInstance(), 'get_template'),
		        'permission_callback' => function( $request ) {
			    	$nonce = $request->get_header( 'x-wp-nonce' );
			    	if( $nonce && wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			    		return true;
			    	}
			    	return false;
		        }
	  		) 
	    );

	    register_rest_route( 
	    	$this->namespace.'/v1', 
	    	'/save_template/', 
	    	array(
		        'methods'  => 'POST',
		        'callback' => array( Tatsu_Page_Templates::getInstance(), 'save_template'),
		        'permission_callback' => function( $request ) {
			    	$nonce = $request->get_header( 'x-wp-nonce' );
			    	if( $nonce && wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			    		return true;
			    	}
			    	return false;
		        }
	  		) 
	    );

	    register_rest_route( 
	    	$this->namespace.'/v1', 
	    	'/delete_template/', 
	    	array(
		        'methods'  => 'POST',
		        'callback' => array( Tatsu_Page_Templates::getInstance(), 'delete_template'),
		        'permission_callback' => function( $request ) {
			    	$nonce = $request->get_header( 'x-wp-nonce' );
			    	if( $nonce && wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			    		return true;
			    	}
			    	return false;
		        }
	  		) 
	    );	    


	    register_rest_route( 
	    	$this->namespace.'/v1', 
	    	'/save_store/', 
	    	array(
		        'methods'  => 'POST',
		        'callback' => array( $plugin_store, 'save_store'),
		        'permission_callback' => function( $request ) {
			    	$nonce = $request->get_header( 'x-wp-nonce' );
			    	if( $nonce && wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			    		return true;
			    	}
			    	return false;
		        }		        
	  		) 
	    );	

	    register_rest_route( 
	    	$this->namespace.'/v1', 
	    	'/module/', 
	    	array(
		        'methods'  => 'POST',
		        'callback' => array( $plugin_module, 'get_module_shorcode_output'),
		        'permission_callback' => function( $request ) {
			    	$nonce = $request->get_header( 'x-wp-nonce' );
			    	if( $nonce && wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			    		return true;
			    	}
			    	return false;
		        }		        
	  		) 
	    );

	    register_rest_route( 
	    	$this->namespace.'/v1', 
	    	'/get_images/', 
	    	array(
		        'methods'  => 'POST',
		        'callback' => array( $this, 'get_images_from_id'),
		        'permission_callback' => function( $request ) {
			    	$nonce = $request->get_header( 'x-wp-nonce' );
			    	if( $nonce && wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			    		return true;
			    	}
			    	return false;
		        }		        
	  		) 
	    );

	}

	public function get_images_from_id( WP_REST_Request $request ){
		$images =  $request->get_param( 'images' );
		$size =  $request->get_param( 'size' );
		if( $images ) {
			$images = json_decode( $images, true );
		}
		$image_url = array();
		foreach ($images as $id) {
			$image = wp_get_attachment_image_src( $id, $size );
			if( $image ) {
				$image_url[] = $image[0];
			}
		}
		return $image_url;

	}

	public function verify_nonce( WP_REST_Request $request ) {
    	$nonce = $request->get_header( 'x-wp-nonce' );
    	if( $nonce && wp_verify_nonce( $nonce, 'wp_rest' ) ) {
    		return true;
    	}
    	return false;				
	} 

}
?>