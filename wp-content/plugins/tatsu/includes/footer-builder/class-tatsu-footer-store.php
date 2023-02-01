<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Footer_Store {

	private $post_id;
	private $store;

	public function __construct( $post_id = null ) {
        $this->store = array();
        if( !empty( $post_id ) ) {
            $this->post_id = $post_id;
        }
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
		return array_merge( $this->get_module_options(), $this->get_footer_store(), $this->get_footer_templates() );
	}


	public function get_module_options() {
		return Tatsu_Footer_Module_Options::getInstance()->get_module_options();
	}


	public function get_footer_store() {
		$footer_content = new Tatsu_Page_Content( $this->post_id );		
		return array(
            'inner' => $footer_content->get_tatsu_content(),
            'name' => 'home',
            'title' => 'home',
            'builderLayout' => 'list',
            'childModule' => 'tatsu_section' ,
		);
	}

	private function get_footer_templates() {
		return array(
			'tatsu_footer_templates' => array()  //Tatsu_Footer_Templates::getInstance()->get_templates_list()
		);
	}

	public function ajax_save_store() {
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}
		$this->post_id = be_sanitize_text_field($_POST['post_id']);
		if( empty( $this->post_id ) ) {
			echo false;
			wp_die();
        }

        tatsu_update_custom_css_js( $this->post_id, be_sanitize_textarea_field($_POST['custom_css']), be_sanitize_textarea_field($_POST['custom_js']) );

        $footer_content = !empty( $_POST['page_content'] ) ? tatsu_shortcodes_from_content( json_decode( stripslashes( $_POST['page_content'] ), true ) ) : '';
		if( $this->save_store( $footer_content ) ) {
			echo 'true';
			wp_die();
		}else {
			echo 'false';
			wp_die();
		}
	}

	public function save_store( $footer_content ) {
		if( !empty( $footer_content ) ) {
			$args = array (
				'ID'			=> $this->post_id,
				'post_content'	=> $footer_content
			);
			return wp_update_post( $args );
		}
		return false;
	}

	private function isJson($string) {
 		json_decode($string);
 		return ( json_last_error() == JSON_ERROR_NONE );
	}

}