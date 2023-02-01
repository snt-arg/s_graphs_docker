<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Store {

	private $post_id;
	private $core_modules;
	private $store;

	public function __construct( $post_id = null ) {
        $this->store = array();	
        if( !empty( $post_id ) ) {
            $this->post_id = $post_id;
        }
    }

	public static function ajax_save_license_key() {
		$res = false; 
		$msg = '';
		
		if ( ! check_ajax_referer( 'be_save_purchase_code', 'security' ) ) {
			$msg .= '<div class="notic notic-warning ">Invalid Nonce</div>';
		} else if ( empty( $_POST['tatsu_license_key'] ) ) {
			$msg .= '<div class="notic notic-warning ">License key can not be empty</div>';
		} else {	
			//newsletter Email
			$email = sanitize_email( $_POST['email'] );
			if ( ! empty( $email ) ) {
				if ( ! is_email( $email ) ) {
					$msg .= '<div class="notic notic-error">Not a valid email</div>';
				} else {
					//$response = wp_remote_get( "https://www.brandexponents.com/subscribe/be-subscribe.php?email=$email&list_name=$list_name" );
					$response = wp_remote_get( "https://brandexponents.com/api.php?email=$email" );
					$body = wp_remote_retrieve_body( $response );
					$response_data = json_decode( $body )->code;
		
					if ( $response_data == 'duplicate_parameter' ) {
						$msg .= '<div class="notic notic-warning ">Unable to Save Email or Email Already in use</div>';
					} else {
						if ( update_option( 'exponent_newsletter_email', $email ) ) {
							$msg .= '<div class="notic notic-success ">Email Saved Successfully</div>';
						}
					}
				}
			}

			// License key verify
			$tatsu_license_key = sanitize_text_field( $_POST['tatsu_license_key'] );
			if ( empty( $tatsu_license_key ) ) {
				$tatsu_license_key = get_option( 'tatsu_license_key', false );
			}
			$tatsu_license_key = trim( $tatsu_license_key );

			if ( $tatsu_license_key && ! empty( $tatsu_license_key ) ) {
				$item_id = '5292'; //product id.
				$response = wp_remote_get( 'https://tatsubuilder.com/?' . http_build_query(
						[
							'edd_action'=> 'activate_license',
							'license' 	=> $tatsu_license_key,
							'item_id'   => $item_id,
							'url'       => home_url()
						]
					), [ 'decompress' => false ]
				);

				if ( is_wp_error( $response ) ) {
					$msg .= '<div class="notic notic-warning ">' . $response->get_error_message() . '</div>';
				} else {
					$response = json_decode( $response['body'] );
				}

				if ( ! empty( $response->success ) ) {
					update_option( 'tatsu_license_item_id', $item_id );
					update_option( 'tatsu_license_key', $tatsu_license_key );

					// add new cron
					wp_schedule_single_event( time() + 2, 'tatsu_pro_license_check' );

					$res = true;
					$msg .= '<div class="notic notic-success">License Key Saved Successfully!</div>';
				} else {
					update_option( 'tatsu_license_item_id', '' );
					if ( ! is_wp_error( $response ) ) {
						$msg .= '<div class="notic notic-warning">License Key Invalid!</div>';
					}
				}
			} else {
				$msg .= '<div class="notic notic-success">Please enter a License Key</div>';
			}
		}
		wp_send_json( array(
			'res' => $res,
			'msg' => $msg
		), 200 );
	}

	public function tatsu_admin_notices_dismiss(){
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}
		if(!empty($_POST['notice_id'])){
			$tatsu_admin_dismiss_notices = get_option('tatsu_admin_dismiss_notices', array());
			if(is_array($tatsu_admin_dismiss_notices) && in_array($_POST['notice_id'], $tatsu_admin_dismiss_notices)){
				wp_send_json(array(
					'res'=>true,
					'msg'=>'notice already dismissed'
				),200);
			}else{
				$tatsu_admin_dismiss_notices[] = sanitize_text_field($_POST['notice_id']);
				if(update_option('tatsu_admin_dismiss_notices', $tatsu_admin_dismiss_notices)){
					wp_send_json(array(
						'res'=>true,
						'msg'=>'notice dismissed'
					),200);
				}else{
					wp_send_json(array(
						'res'=>true,
						'msg'=>'Something went wrong'
					),200);
				}
			}
			 
		}
	}

	public function ajax_instagram_token_save(){
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}

		$instagram_token = sanitize_text_field( $_POST['instagram_token'] );
		if(empty($instagram_token)){
			$alert = ['danger' => 'Empty Token key'];
		}else if(set_theme_mod('instagram_token', $instagram_token)){
			$alert = ['success' => 'Token saved successfully'];
		}else{
			$alert = ['danger' => 'Failed to save token'];
		}

		return wp_send_json_success( [ 'alert' => $alert ] );
	}

	
	public function tatsu_save_recaptcha_details(){
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}

		$recaptcha_type = sanitize_text_field( $_POST['recaptcha_type'] );
		$site_key = sanitize_text_field( $_POST['site_key'] );
		$secret_key = sanitize_text_field( $_POST['secret_key'] );
		$recaptcha_settings= array(
            'recaptcha_type'=>$recaptcha_type,
            'site_key'=>$site_key,
            'secret_key'=>$secret_key
        );
		if(empty($recaptcha_type) || empty($site_key) || empty($secret_key)){
			$alert = ['danger' => 'Required input field missing'];
		}else if(!empty($recaptcha_type) && !in_array($recaptcha_type,array('v3','v2'))){
			$alert = ['danger' => 'Wrong reCAPTCHA type'];
		}else if(update_option('tatsu_form_recaptcha_settings',$recaptcha_settings)){
			$alert = ['success' => 'reCAPTCHA details saved successfully'];
		}else{
			$alert = ['danger' => 'Failed to save reCAPTCHA details'];
		}

		return wp_send_json_success( [ 'alert' => $alert ] );
	}
	
	public function get_store( WP_REST_Request $request ) {
		$this->post_id = $request->get_param('post_id');
		$this->store = array_merge( $this->get_module_options(), $this->get_page_content() );
		if( tatsu_check_if_global() && array_key_exists( 'tatsu_module_options', $this->store ) ) {
			$this->store[ 'tatsu_module_options' ] = array_merge( $this->store[ 'tatsu_module_options' ], $this->get_gsection_modules() );
		}
		$response = new WP_REST_Response( $this->store );
		if( ob_get_length() ) {
			ob_clean();
		}
		$response->header('Content-Type', 'application/json' );
		return $response;
	}	

	private function get_gsection_modules() {
		return Tatsu_Global_Module_Options::getInstance()->get_modules();
	}

	public function get_module_options() {
		return Tatsu_Module_Options::getInstance()->get_module_options(); 
	}


	public function get_page_content() {
		$tatsu_page_content = new Tatsu_Page_Content( $this->post_id );
		return array(
            'inner' => $tatsu_page_content->get_tatsu_content(),
            'name' => 'home',
            'title' => 'home',
            'builderLayout' => 'list',
            'childModule' => 'section' ,
		);
	}

	private function get_page_templates() {
		return array(
			'tatsu_templates' => Tatsu_Page_Templates::getInstance()->get_templates_list()
		);
	}


	public function save_store( WP_REST_Request $request ) {
		$this->post_id = $request->get_param('post_id');
		if( $this->save_page_content( $request->get_param('page_content') ) ) {
			return true;
		}
		return false;		
	}

	public function ajax_save_store() {
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}

		$body_fonts = !empty( $_POST['tatsu_body_fonts'] ) ? json_decode( stripslashes( $_POST['tatsu_body_fonts'] ), true ) : array();

		$this->post_id = be_sanitize_text_field($_POST['post_id']);

		if( !empty( $_POST['post_name'] ) && !empty( $_POST['post_status'] ) ){
			$post_data = array(
				'ID'           => $this->post_id,
				'post_title'   => be_sanitize_text_field($_POST['post_name']),
				'post_status' => be_sanitize_text_field($_POST['post_status']),
			);
		  
			wp_update_post( $post_data );
        }
        
        tatsu_update_custom_css_js( $this->post_id, be_sanitize_textarea_field($_POST['custom_css']), be_sanitize_textarea_field($_POST['custom_js']) );

		if( !empty( $body_fonts ) ){
			update_post_meta( $this->post_id, 'tatsu_body_fonts', $body_fonts );
		}

		if( $this->save_page_content( be_sanitize_textarea_field($_POST['page_content']) ) ) {
			echo 'true';
			wp_die();
		}
		echo 'false';
		wp_die();
	}

	private function save_page_content( $content ) {
		$content = stripslashes( $content);  // added for admin-ajax requests
		if( $this->isJson( $content ) ) {
			$tatsu_page_content = new Tatsu_Page_Content( $this->post_id );
			return $tatsu_page_content->set_page_content( $content );
		}

		return false;		
	}

	public function ajax_paste_shortcode() {
		
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}
		
		$this->content = stripslashes( urldecode($_POST['shortocde']) );
		$parser = new Tatsu_Parser( $this->content, false );
		$tatsu_content = $parser->parse( $this->content );
		if( ob_get_length() ) {
			ob_clean();
		}
		header('Content-Type: application/json');
		echo json_encode( $tatsu_content );
		wp_die();
	}


	private function isJson($string) {
 		json_decode($string);
 		return ( json_last_error() == JSON_ERROR_NONE );
	}

	public function ajax_get_revision_content(  ){

		$revision_id = be_sanitize_text_field($_POST['revision_id']);
		$post_id = be_sanitize_text_field($_POST['post_id']);
		$selected_revision = wp_get_post_revision( $revision_id);

		$parser = new Tatsu_Parser();

		$revision_content = $parser->parse( $selected_revision->post_content );

		echo json_encode($revision_content);
		wp_die();
	}

	public function ajax_get_revision_data(){
		echo json_encode( tatsu_revision_data( $_POST['post_id'], $_POST['offset'] ) );
		wp_die();
	}

}