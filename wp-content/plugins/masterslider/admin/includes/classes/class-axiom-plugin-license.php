<?php
/**
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2015 averta
*/

// no direct access allowed
if ( ! defined('ABSPATH') ) {
    die();
}

if( class_exists( 'Axiom_Plugin_License' ) ){
	return;
}



class Axiom_Plugin_License {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;


	var $text_domain   = MSWP_TEXT_DOMAIN;
	var $option_prefix = 'msp_envato_';



	function __construct(){}


	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * The result of license validation request
	 *
	 * @param  string $username      envato username
	 * @param  string $api_key       envato user secret api
	 * @param  string $purchase_code item purchase code
	 * @return string|array   the server response
	 */
	function get_license_result( $username, $purchase_code, $action = 'activate' ) {

	    if( empty( $username ) || empty( $purchase_code ) ) {
	        return false;
	    }

	    global $wp_version;

	    $action = ( 'activate' === $action ) ? 'activate' : 'deactivate';

	    $api_url = 'http://support.averta.net/envato/api/?branch=envato&group=items&cat=verify-purchase';

	    $token   	  = $this->get_license_info( 'token' );

	    $args = array(
	        'user-agent' => 'WordPress/'.$wp_version.'; ' . get_site_url(),
	        'timeout'    => ( ( defined('DOING_CRON') && DOING_CRON ) ? 30 : 3),
	        'body'       => array(
	            'action'	=> $action,
		    	'key'  		=> $purchase_code,
		    	'user' 		=> $username,
		    	'token'		=> $token,
		    	'url'  		=> get_site_url(),
		    	'item_id'  	=> '7467925',
				'ip'   		=> isset( $_SERVER['SERVER_ADDR'] ) ? $_SERVER['SERVER_ADDR'] : ''
	        )
	    );

	    $request = wp_remote_post( $api_url, $args );


	    if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) !== 200 ) {
	        return false;
	    }

	    return json_decode( $request['body'], true );
	}


	/**
	 * Activate or deactivate license if license info is correct
	 *
	 * @param  string $username      envato username
	 * @param  string $purchase_code item purchase code
	 * @param  string $action        activate or deactivate license
	 *
	 * @return array   An array containing result of activation or deactivation
	 */
	function license_action( $username, $purchase_code, $action = 'activate' ){

		$output = array(
			'success' 	=> 0,
			'status'    => '',
			'message' 	=> '',
			'error' 	=> ''
		);

		if( empty( $username ) ){
	    	$output['message'] = __( 'Username is required.', $this->text_domain );
	    	return $output;
	    } elseif( empty( $purchase_code ) ){
	    	$output['message'] = __( 'Purchase key is required.', $this->text_domain );
	    	return $output;
	    }

	    // get previous license info
	    $license_info = $this->get_license_info();

	    // fetch license info
	    $response = $this->get_license_result( $username, $purchase_code, $action );

	    if( false !== $response ){

	    	if( empty( $response['result'] ) ){
	    		$output['message'] = __( 'Bad request with wrong header ..', $this->text_domain );
	    		return $output;
	    	}


	    	if( 'success' == $response['result'] ){

	    		if( 'active' == $response['status'] ){

	        		$token 		= isset( $response['token'] ) ? $response['token'] : '';

					$license_info['username'] 		= $username;
	        		$license_info['purchase_code']  = $purchase_code;
	        		$license_info['token']  		= $token;

	    			update_option( $this->option_prefix . 'license', $license_info );
					update_option( MSWP_SLUG . '_is_license_actived', 1 );

	    		} elseif( 'deactive' == $response['status'] ){

					$license_info['token']  		= '';

	    			update_option( $this->option_prefix . 'license', $license_info );
					update_option( MSWP_SLUG . '_is_license_actived', 0  );
	    		}

	    		$output['success'] = 1;
	    		$output['status' ] = $response['status'];

	    	// if an error occurred
	    	} else {
	    		$output['success'] = 0;
                $output['status' ] = $response['status'];
	    	}

	    	$output['message'] = $response['msg'] . sprintf( ' <sub>[%s]</sub>', $response['code'] );

	    } else {
	    	$output['message'] = __( 'Connection error ..', $this->text_domain );
	    	$output['success'] = 0;
	    }

        delete_transient( 'msp_get_remote_sample_sliders' );

        do_action( 'masterslider_on_license_action', $action, $output );

	    return $output;
	}


    function get_token_validation_status() {

        global $wp_version;

        $api_url = 'http://support.averta.net/envato/api/?branch=envato&group=items&cat=verify-purchase';
        $token = $this->get_license_info( 'token' );

        $args = array(
            'user-agent' => 'WordPress/'.$wp_version.'; ' . get_site_url(),
            'timeout'    => ( ( defined('DOING_CRON') && DOING_CRON ) ? 30 : 3),
            'body' => array(
                'action'    => 'token',
                'token'     => $this->get_license_info( 'token' ),
                'url'       => get_site_url()
            )
        );

        $request = wp_remote_post( $api_url, $args );


        if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) !== 200 ) {
            return false;
        }

        $response = json_decode( $request['body'], true );
        $response['token'] = $token;

        return $response;
    }


    function remove_invalid_token(){

        $status = $this->get_token_validation_status();

        if( false !== $status && isset( $status['allowed'] ) ){
            // if token is no longer valid to be used on this domain
            if ( ! $status['allowed'] ){
                update_option( MSWP_SLUG . '_is_license_actived', 0 );

                $license_info = get_option( $this->option_prefix . 'license', array() );
                $license_info['token'] = '';
                update_option( $this->option_prefix . 'license', $license_info );
            }
        }

        return $status;
    }



	/**
	 * Retrieves license info or a specific license field
	 *
	 * @param  string $field 	Specific license field or empty string
	 * @return array|string     Returns all license info in array or a string containing license field value
	 */
	function get_license_info( $field = '', $default = '' ){
		$license_info = get_option( $this->option_prefix . 'license', array() );

		if( empty( $field ) )
			return empty( $license_info ) ? array() : $license_info;

		return isset( $license_info[ $field ] ) ? $license_info[ $field ] : $default;
	}

}
