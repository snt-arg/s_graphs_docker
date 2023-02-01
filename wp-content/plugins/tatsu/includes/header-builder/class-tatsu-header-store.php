<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Header_Store {

	private $post_id;
	private $store;

	public function __construct( $post_id = null ) {
		$this->store = array();
		$this->post_id = $post_id;
	}


	public function ajax_get_store() {
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}        
		$this->post_id = be_sanitize_text_field($_POST['post_id']);
		if( empty( $this->post_id ) ) {
			echo false;
			wp_die();
		}
		$this->store = $this->get_store();
		if( ob_get_length() ) {
			ob_clean();
		}
		header('Content-Type', 'application/json' );
        echo json_encode( $this->store );
        wp_die();
	}	

	public function rest_get_store( WP_REST_Request $request ) {
		$this->post_id = $request->get_param('post_id');
		if( empty( $this->post_id ) ) {
			echo false;
			wp_die();
		}
		$this->store = $this->get_store();
		$response = new WP_REST_Response( $this->store );
		if( ob_get_length() ) {
			ob_clean();
		}
		$response->header('Content-Type', 'application/json' );
		return $response;
	}	

	public function get_store() {
		return array_merge( $this->get_module_options(), $this->get_header_store(), $this->get_header_templates() );
	}


	public function get_module_options() {
		return Tatsu_Header_Module_Options::getInstance()->get_module_options(); 
	}


	public function get_header_store() {
		$header_content = new Tatsu_Page_Content( $this->post_id );		
		$header_settings = get_post_meta( $this->post_id, 'tatsu_header_settings', true );
		$header_fonts = get_post_meta( $this->post_id, 'tatsu_header_fonts', true );
        $current_active_header = tatsu_get_active_header_id();

		if( empty( $header_settings ) ){
			$transparent_enable_list = tatsu_get_transparent_header_list();
			$header_settings = array(
				'sticky' =>  false,
				'smart' => false,
				'transparent' => false,
				'scheme' => 'dark',
				'archive' => $transparent_enable_list['archive'],
				'single' => $transparent_enable_list['single'],
				'taxonomy' => $transparent_enable_list['taxonomy'],
                'other' => $transparent_enable_list['other'],
                'active_header' => $current_active_header === $this->post_id,
			);
        }else if($current_active_header == $this->post_id){
			$header_settings['active_header'] = true;
		}
        if( !array_key_exists('active_header', $header_settings) ) {
            $header_settings['active_header'] = $current_active_header === $this->post_id;
        }
		return array(
            'inner' => $header_content->get_tatsu_content(),
            'settings' => !empty( $header_settings ) ? $header_settings : array(),
            'fonts' => !empty( $header_fonts ) ? $header_fonts : array(),
            'name' => 'home',
            'title' => 'home',
            'builderLayout' => 'list',
            'childModule' => 'tatsu_header_row' ,
		);
	}

	private function get_header_templates() {
		return array(
			'tatsu_header_templates' => array()
		);
	}

	public function ajax_save_store() {

		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}
		$this->post_id = be_sanitize_text_field($_POST['post_id']);
		if( empty( $this->post_id ) ) {
			echo 'false';
			wp_die();
		}
		$header_fonts = !empty( $_POST['tatsu_header_fonts'] ) ? json_decode( stripslashes( $_POST['tatsu_header_fonts'] ), true ) : array();
		$header_settings = !empty( $_POST['settings'] ) ? json_decode( stripslashes( $_POST['settings'] ), true ) : array();
		$header_content = !empty( $_POST['page_content'] ) ? tatsu_shortcodes_from_content( json_decode( stripslashes( $_POST['page_content'] ), true ) ) : '';
		
		if( $header_settings['active_header'] ){
			$post_obj = get_post( $this->post_id );
			$post_name = $post_obj->post_name;
			update_option( 'tatsu_active_header', $post_name );
		} else {
			$current_active_header = tatsu_get_active_header_id();
			if( $current_active_header == $this->post_id ){
				update_option( 'tatsu_active_header', 'none' );
			}
		}

        tatsu_update_custom_css_js( $this->post_id, be_sanitize_textarea_field($_POST['custom_css']), be_sanitize_textarea_field($_POST['custom_js']) );

		if( $this->save_store( $header_content, $header_settings, $header_fonts ) ) {
			echo 'true';
			wp_die();
		}else {
			echo 'false';
			wp_die();
		}

	}

	public function save_store( $header_content, $header_settings, $header_fonts ) {
		if( !empty( $header_settings ) ) {
			update_post_meta( $this->post_id, 'tatsu_header_settings', $header_settings );
		}
		if( !empty( $header_fonts ) ) {
			update_post_meta( $this->post_id, 'tatsu_header_fonts', $header_fonts );
		}
		$args = array (
			'ID'			=> $this->post_id,
			'post_content'	=> $header_content
		);
		return wp_update_post( $args );
		return false;
	}

	private function isJson($string) {
 		json_decode($string);
 		return ( json_last_error() == JSON_ERROR_NONE );
	}

}