<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.brandexponents.com
 * @since      1.0.0
 *
 * @package    Tatsu
 * @subpackage Tatsu/public
 */

/**
 * Tatsu forms processing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tatsu
 * @subpackage Tatsu/public
 * @author     Brand Exponents Creatives Pvt Ltd <swami@brandexponents.com>
 */
class Tatsu_Forms_Process{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}


	
	public function tatsu_forms_save() {
		$site_url = get_site_url();
		$request_url = $_SERVER['HTTP_REFERER'];
        if( stripos( $request_url, $site_url ) === false ){
			$result['status']="error";
			$result['data']=__('Cross Domain not allowed','tatsu');
		}else if(!empty($_POST) && !empty($_POST['form_id'])) {
			$tatsu_form_id = sanitize_text_field($_POST['form_id']);
			$form_fields_name = extract_tatsu_forms_field_name_list($tatsu_form_id);
			$form_settings = '';
			if(!empty($_POST['formconfig'])){
				//extract form settings 
				$form_settings = json_decode(stripslashes($_POST['formconfig']),true);
			}
			
			if($form_fields_name === false){
				$result['status']="error";
				$result['data']=__('Invalid Form','tatsu');
			}else if($this->is_valid_recaptcha()){
				global $wpdb;
				//Generate submit form id
				$tatsu_forms_submit_table = $wpdb->prefix.'tatsu_forms_submit';
				$ip = get_IP_address();
				$query_submit = $wpdb->prepare(
					"
					INSERT INTO $tatsu_forms_submit_table
					( tatsu_form_id, ip)
					VALUES ( %d, %s )
					",
					$tatsu_form_id,
					$ip
				);
				$wpdb->query($query_submit);
				$submit_id = $wpdb->insert_id;

				//Saving Form Data
				$tatsu_forms_data_table = $wpdb->prefix.'tatsu_forms_data';
				$form_data = array();
				$field_data = array();
				foreach ($_POST as $field_name => $field_value) {
					if(!empty($field_name) && in_array(trim($field_name),$form_fields_name)){
						$field_name = sanitize_text_field($field_name);
						$field_value = is_array($field_value)?implode(',',$field_value):$field_value;
						$field_value = sanitize_textarea_field($field_value);
						$form_data[] = $wpdb->prepare("(%d,%s,%s)",$submit_id,$field_name,$field_value);
                        $field_data[$field_name]=$field_value;
					}
				}
				$query_data = $wpdb->prepare(
					"INSERT INTO $tatsu_forms_data_table (submit_id,field_name,field_value) VALUES "
				);
				$query_data .= implode(",\n",$form_data);
				$wpdb->query($query_data);
				
				//Send Email
				if(!empty($_POST['action_after_submit']) && !empty($form_settings) && !empty($form_settings['action_after_submit'])){
					if('email'==trim($_POST['action_after_submit'])){
                    $this->process_form_email($tatsu_form_id,$form_settings,$field_data);
					}else if('mailchimp'==trim($_POST['action_after_submit']) && function_exists('spyro_mailchimp_subscription')){
						spyro_mailchimp_subscription();
					}
				}

				$result['status']="success";
				$message = empty($_POST['success_text'])?'Thank You':$_POST['success_text'];
				$result['data'] =__($message,'tatsu');
		    }else{
				$result['status']="error";
				$result['data']=__('Invalid reCAPTCHA','tatsu');
			}
		} else {
			$result['status']="error";
			$result['data']=__('No input found','tatsu');
		}
		wp_send_json($result);
	}
	
	//Check Input reCAPTCHA response and tell if invalid
	private function is_valid_recaptcha(){
		if(empty($_POST['is_recaptcha']) && empty($_POST['g-recaptcha-response'])){
			return true;//reCAPTCHA not embedded in the form 
		}
		if(empty($_POST['g-recaptcha-response'])){
			return false;	
		}else{
			$recaptcha_settings=get_option('tatsu_form_recaptcha_settings');
			if(empty($recaptcha_settings)){
				return false;
			}
			//verify reCAPTCHA 
			$response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
				'body'        => array(
					'secret' => $recaptcha_settings['secret_key'],
					'response' => $_POST['g-recaptcha-response']
				)
			));
			if(200 != wp_remote_retrieve_response_code( $response )){
				return false;//fail to verify
			}
			$api_response = json_decode( wp_remote_retrieve_body( $response ), true );
			if(!empty($api_response) && $api_response['success']){
				$threshold_score = tatsu_get_recaptcha_threshold_score();
				if($recaptcha_settings['recaptcha_type']=='v2'){
					return true;//for v2
				}else if(isset($api_response['score']) && $api_response['score']>$threshold_score){
					return	apply_filters('tatsu_form_recaptcha_verify',true,$response);
				}else{
					return false;//spam
				}
			}else{
				return false;
			}
		}
	}

    private function process_form_email($tatsu_form_id,$form_settings,$field_data_array){
        //Email To Admin
        $to = empty($_POST['to_email'])?get_option('admin_email'):$_POST['to_email'];
        $to =sanitize_email($to);

        $formName = get_the_title($tatsu_form_id);
        $blog_title = get_bloginfo( 'name' );
        //Email Subject 
        $subject =empty($form_settings['subject_of_email'])?'Form received - '.$blog_title:$form_settings['subject_of_email'];
        //Email Body
        $form_settings['message_body'] = empty($form_settings['message_body'])?'{all_fields}':$form_settings['message_body'];
        $msg_body = $this->process_form_tags($form_settings['message_body'],$field_data_array);
        $msg_body =apply_filters('tatsu_forms_email_message_body', $msg_body);
        //Email headers
        $headers = array('Content-Type: text/html; charset=UTF-8');
        //Email From
        $headers[] ='From: '.(empty($form_settings['from_name'])?$blog_title:$form_settings['from_name']).' <'.sanitize_email(empty($form_settings['from_email'])?$to:$form_settings['from_email']).'>';
        //Email Reply to Visitor
        if(!empty($form_settings['reply_to_email']) && !empty($field_data_array[$form_settings['reply_to_email']])){
            $headers[] ='Reply-To: '.((empty($form_settings['reply_to_name']) || empty($field_data_array[$form_settings['reply_to_name']]))?'':$field_data_array[$form_settings['reply_to_name']]).' <'.sanitize_email($field_data_array[$form_settings['reply_to_email']]).'>';
        }
        //Email Cc
        if(!empty($form_settings['cc_email'])){
            $cc_email = str_replace(" ","",$form_settings['cc_email']);
            $cc_email = explode(',',$cc_email);
            foreach ($cc_email as $cc_email_id) {
                if(!empty($cc_email_id) && is_email($cc_email_id)){
                    $headers[] ='Cc: '.$cc_email_id;
                }  
            }
        }
        //Email Bcc
        if(!empty($form_settings['bcc_email'])){
            $bcc_email = str_replace(" ","",$form_settings['bcc_email']);
            $bcc_email = explode(',',$bcc_email);
            foreach ($bcc_email as $bcc_email_id) {
                if(!empty($bcc_email_id) && is_email($bcc_email_id)){
                    $headers[] ='Bcc: '.$bcc_email_id;
                }  
            }
        }
        
        $email_status = wp_mail( $to, $subject, $msg_body, $headers );
        if($email_status && !empty($form_settings['autoresponder']) && !empty($form_settings['ares_to_email']) && !empty($field_data_array[$form_settings['ares_to_email']])){
            $this->process_form_autoresponder_email($tatsu_form_id,$form_settings,$field_data_array,$blog_title);
        }
    }

    private function process_form_autoresponder_email($tatsu_form_id,$form_settings,$field_data_array,$blog_title){
        //Email To Visitor
        $to = sanitize_email($field_data_array[$form_settings['ares_to_email']]);
        if(!is_email($to)){
            return false;
        }
        //Email Subject 
        $subject =empty($form_settings['ares_subject_of_email'])?'Form received successfully':$form_settings['ares_subject_of_email'];
        //Email Body
        $form_settings['ares_message_body'] = empty($form_settings['ares_message_body'])?'Thank you for contacting us':$form_settings['ares_message_body'];
        $msg_body = $this->process_form_tags($form_settings['ares_message_body'],$field_data_array);

        $msg_body =apply_filters('tatsu_forms_email_autoresponder_message_body', $msg_body);
        //Email headers
        $headers = array('Content-Type: text/html; charset=UTF-8');
        //Email From Admin
        $admin_email = get_option('admin_email');
        $headers[] ='From: '.(empty($form_settings['ares_from_name'])?$blog_title:$form_settings['ares_from_name']).' <'.sanitize_email(empty($form_settings['ares_from_email'])?$admin_email:$form_settings['ares_from_email']).'>';
        //Email Reply to Admin
        $form_settings['ares_reply_to_email'] = empty($form_settings['ares_reply_to_email'])?$admin_email:$form_settings['ares_reply_to_email'];
        $headers[] ='Reply-To: '.(empty($form_settings['ares_reply_to_name'])?$blog_title:$form_settings['ares_reply_to_name']).' <'.sanitize_email($form_settings['ares_reply_to_email']).'>';
    
        $email_status = wp_mail( $to, $subject, $msg_body, $headers );
    }

    public function process_form_tags($content,$field_data_array){
        $tags_array = $this->prepare_tags_array($field_data_array);
        $patterns = array();
        $replacements = array();
        foreach ($tags_array as $tag => $tag_value) {
            $patterns[] = $tag;
            $replacements[] = $tag_value;
        }
        $content = str_replace($patterns, $replacements, $content);
        return wpautop($content,true);
    }

    public function prepare_tags_array($field_data_array){
       $form_tags = array();
       $form_tags['{site_title}'] = get_bloginfo( 'name' );
       $form_all_tag_html = '';
        foreach ($field_data_array as $field_name => $field_value) {
            $form_tags["{field_name_".$field_name."}"] = apply_filters('tatsu_forms_email_field_name_tag', $field_value);
            $form_all_tag_html .= '<p><strong>'.preg_replace(array('/_/','/-/'),' ', $field_name).'</strong><br />'.$field_value.'</p>';
        }
        $form_tags["{all_fields}"] = apply_filters('tatsu_forms_email_all_field_tag', $form_all_tag_html);
        return $form_tags;
    }

}

?>