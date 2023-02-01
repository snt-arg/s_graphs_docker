<?php
/**
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2014 averta
*/

// no direct access allowed
if ( ! defined('ABSPATH') ) {
    die();
}

class MSP_Admin_Ajax {



	function __construct () {

		// get and save data on ajax data post
		add_action( 'wp_ajax_msp_panel_handler' 	, array( $this, 'save_panel_ajax'         ) );
		add_action( 'wp_ajax_msp_create_new_handler', array( $this, 'create_new_slider'       ) );
		add_action( 'wp_ajax_post_slider_preview'	, array( $this, 'post_slider_preview'     ) );
        add_action( 'wp_ajax_wc_slider_preview'     , array( $this, 'wc_slider_preview'       ) );
		add_action( 'wp_ajax_ms-slug'               , array( $this, 'slider_alias_validation' ) );

		add_action( 'wp_ajax_msp_license_activation', array( $this, 'check_license_activation' ) );

		add_action( 'wp_ajax_msp_replace'           , array( $this, 'msp_replacer' ) );
	}



	/**
	 * Get preview data form post in admin area
	 *
	 * @since    1.5.0
	 */
	public function post_slider_preview() {

		header( "Content-Type: application/json" );

		// verify nonce
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], "msp_panel") ) {
			echo json_encode( array( 'success' => false, 'message' => __( "Authorization failed!", MSWP_TEXT_DOMAIN ) ) );
			exit;
		}

		$PS = msp_get_post_slider_class();
		$posts_result  = $PS->parse_and_get_posts_result();
		$template_tags = $PS->get_first_post_template_tags_value();

		if( empty( $posts_result ) )
			$template_tags = null;

	    echo json_encode( array( 'success' => true, 'type' => 'preview' , 'message' => '', 'preview_results' => $posts_result, 'template_tags' => $template_tags ) );
	    exit;// IMPORTANT
	}


    /**
     * Get preview data form post in admin area
     *
     * @since    1.5.0
     */
    public function slider_alias_validation(){

        // verify nonce
        if ( ! isset( $_REQUEST['nonce'] ) || ! wp_verify_nonce( $_REQUEST['nonce'], "msp_panel") ) {
            wp_send_json_error( __( "Authorization failed!", MSWP_TEXT_DOMAIN ) );
        }

        global $mspdb;

        if( isset( $_REQUEST['slug'] ) && isset( $_REQUEST['id'] ) ){
            wp_send_json_success( $mspdb->validate_slider_alias( $_REQUEST['slug'], $_REQUEST['id'] ) );
        } else {
            wp_send_json_error( __( "Slider ID or slug is not available", MSWP_TEXT_DOMAIN ) );
        }

    }


	/**
	 * Get preview data form woocommerce product in admin area
	 *
	 * @since    1.7.4
	 */
	public function wc_slider_preview() {

		header( "Content-Type: application/json" );

		// verify nonce
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], "msp_panel") ) {
			echo json_encode( array( 'success' => false, 'message' => __( "Authorization failed!", MSWP_TEXT_DOMAIN ) ) );
			exit;
		}

		if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) ){
			echo json_encode( array( 'success' => false, 'message' => __( "Please install and activate WooCommerce plugin.", MSWP_TEXT_DOMAIN ) ) );
		}

		$wcs = msp_get_wc_slider_class();
		$posts_result  = $wcs->parse_and_get_posts_result();
		$template_tags = $wcs->get_first_post_template_tags_value();

		if( empty( $posts_result ) )
			$template_tags = null;

	    echo json_encode( array( 'success' => true, 'type' => 'preview' , 'message' => '', 'preview_results' => $posts_result, 'template_tags' => $template_tags ) );
	    exit;// IMPORTANT
	}



    /**
	 * Save ajax handler for main panel data
	 *
	 * @since    1.0.0
	 */
    public function save_panel_ajax() {

        // verify nonce
        if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], "msp_panel") ) {
			wp_send_json( array( 'success' => false, 'message' => __("Authorization failed!", MSWP_TEXT_DOMAIN ) ) );
        }

        // ignore the request if the current user doesn't have sufficient permissions
        if ( ! current_user_can( 'publish_masterslider' ) ) {
            wp_send_json(
                array(
                    'success' => false,
                    'message' => apply_filters( 'masterslider_insufficient_permissions_to_publish_message', __( "Sorry, You don't have enough permission to publish slider!", MSWP_TEXT_DOMAIN ) )
                )
            );
        }

        /////////////////////////////////////////////////////////////////////////////////////////

		// Get the slider id
		$slider_id 		= isset( $_REQUEST['slider_id'] ) ? $_REQUEST['slider_id'] : '';

		if ( empty( $slider_id ) ) {
			wp_send_json( array( 'success' => false, 'type' => 'save' , 'message' => __( "Slider id is not defined.", MSWP_TEXT_DOMAIN )  ) );
		}

		// get the slider type
		$slider_type 	= isset( $_REQUEST['slider_type']   ) ? $_REQUEST['slider_type']   : 'custom';

		// get panel data
		$msp_data		= isset( $_REQUEST['msp_data']      ) ? $_REQUEST['msp_data']      : NULL;
		$preset_style	= isset( $_REQUEST['preset_style']  ) ? $_REQUEST['preset_style']  : NULL;
		$preset_effect	= isset( $_REQUEST['preset_effect'] ) ? $_REQUEST['preset_effect'] : NULL;
		$buttons_style	= isset( $_REQUEST['buttons'] 		) ? $_REQUEST['buttons'] 	   : NULL;


		// store preset data in database seperately
	    msp_update_option( 'preset_style' , $preset_style  );
	    msp_update_option( 'preset_effect', $preset_effect );
	    msp_update_option( 'buttons_style', $buttons_style );


		// get parse and database tools
		global $mspdb;

		// load and get parser and start parsing data
		$parser = msp_get_parser();
		$parser->set_data( $msp_data, $slider_id );

		// get required parsed data
		$slider_setting       = $parser->get_slider_setting();
		$slides       		  = $parser->get_slides();
		$slider_custom_styles = $parser->get_styles();

		$fields = array(
            'title'         => sanitize_text_field( $slider_setting[ 'title' ] ),
			'alias' 		=> $slider_setting[ 'alias' ],
			'type'			=> $slider_setting[ 'slider_type' ],
			'slides_num'	=> count( $slides ),
			'params'		=> $msp_data,
			'custom_styles' => $slider_custom_styles,
			'custom_fonts'  => $slider_setting[ 'gfonts' ],
			'status'		=> 'published'
		);

		// store slider data in database
		$is_saved = $mspdb->update_slider( $slider_id, $fields );

	    msp_update_preset_css();
	    msp_update_buttons_css();
	    msp_save_custom_styles();


	    // flush slider cache if slider cache is enabled
	    msp_flush_slider_cache( $slider_id );


		// create and output the response
		if( isset( $is_saved ) )
			wp_send_json( array( 'success' => true, 'type' => 'save' , 'message' => __( "Saved Successfully.", MSWP_TEXT_DOMAIN )  ) );
	    else
			wp_send_json( array( 'success' => true, 'type' => 'save' , 'message' => __( "No Data Recieved."  , MSWP_TEXT_DOMAIN )  ) );
	}



	/**
	 * Create new slider by type
	 *
	 * @since    1.0.0
	 */
	public function create_new_slider() {

		header( "Content-Type: application/json" );

		// verify nonce
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], "msp_panel") ) {
			echo json_encode( array( 'success' => false, 'message' => __("Authorization failed!", MSWP_TEXT_DOMAIN ) ) );
			exit();
		}

		// ignore the request if the current user doesn't have sufficient permissions
	    if ( ! current_user_can( 'create_masterslider' ) && ! current_user_can( 'publish_masterslider' ) ) {
	    	echo json_encode( array( 'success' => false,
	    	                 		 'message' => apply_filters( 'masterslider_create_slider_permissions_message', __( "Sorry, You don't have enough permission to create slider!", MSWP_TEXT_DOMAIN ) )
	    	                 		)
	    	);
	    	exit();
		}


		/////////////////////////////////////////////////////////////////////////////////////////

		// Get the slider id
		$slider_type = isset( $_REQUEST['slider_type'] ) ? $_REQUEST['slider_type'] : '';


		// Get new slider id
		global $mspdb;
		$slider_id = $mspdb->add_slider( array( 'status' => 'draft', 'type' => $slider_type ) );


		// create and output the response
		if( false !== $slider_id )
			$response = json_encode( array( 'success' => true, 'slider_id' => $slider_id , 'redirect' => admin_url( 'admin.php?page='.MSWP_SLUG.'&action=edit&slider_id='.$slider_id.'&slider_type='.$slider_type ), 'message' => __( "Slider Created Successfully.", MSWP_TEXT_DOMAIN )  ) );
	    else
	    	$response = json_encode( array( 'success' => true, 'slider_id' => '' , 'redirect' => '', message => __( "Slider can not be created."  , MSWP_TEXT_DOMAIN )  ) );

	    echo $response;

	    exit;// IMPORTANT
	}



	function check_license_activation() {

		// header( "Content-Type: application/json" );

		// verify nonce
		/*if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], "msp_panel") ) {
			echo json_encode( array( 'success' => 0, 'message' => __( "Authorization failed!", MSWP_TEXT_DOMAIN ) ) );
			exit();
		}*/

        $username    	= isset( $_POST['username'] 	 ) ? $_POST['username'] 	 : '';
        $purchase_code  = isset( $_POST['purchase_code'] ) ? $_POST['purchase_code'] : ''; // check emptiness
        $action 		= isset( $_POST['type'] 		 ) ? $_POST['type'] 		 : '';

        $result = Axiom_Plugin_License::get_instance()->license_action( $username, $purchase_code, $action );

    	echo json_encode( $result );
        exit;// IMPORTANT
    }


    /**
	 * Replacer function
	 */
    public function msp_replacer() {
		// Check ajax-referer, user capability
		if ( current_user_can( 'access_masterslider' ) && check_admin_referer( 'msprp-nonce', 'nonce' ) ) {

			if ( empty( $_POST['ids'] ) ) {
				wp_send_json_error( __( 'Please Select Slider(s)', MSWP_TEXT_DOMAIN ) );
			}

			if ( empty( $_POST['search'] ) && 'on' != $_POST['all_urls'] ) {
				wp_send_json_error( __( 'Search field is empty.', MSWP_TEXT_DOMAIN ) );
			}

			if ( empty( $_POST['replace'] ) ) {
				wp_send_json_error( __( 'Replace field is empty.', MSWP_TEXT_DOMAIN ) );
			}

			if ( empty( $_POST['where'] ) ) {
				wp_send_json_error( __( 'Please select where to replace.', MSWP_TEXT_DOMAIN ) );
			}

			$ids            = $_POST['ids'];
			$search         = sanitize_text_field($_POST['search']);
			$replace        = sanitize_text_field($_POST['replace']);
			$case_sensitive = sanitize_text_field($_POST['cs']);
			$where          = $_POST['where'];
			$backup         = $_POST['backup'];

			if ( array('slides', 'layers') == $where ) {
				$where_replace = 'full';
			} else {
				$where_replace = $where[0];
			}
			// Pattern for finding initial replace-able data
			$pattern = '/(?<=,\\\"link|info|content|bgv_mp4|bgv_ogg|bgv_webm\\\":\\\").*?(?=\\\",\\\")/';
			$args_sliders = array(
				'perpage' => 0,
				'offset'  => 0,
				'orderby' => 'ID',
				'order'   => 'DESC',
				'where'   => "ID IN (".implode(',', $ids).") AND status='published'",
				'like' 	  => ''
			);
			global $mspdb;
			$sliders = $mspdb->ms_query($args_sliders);

			if ( 'on' == $_POST['all_urls'] ) {
				// Pattern for detecting URLs
				$urls = '/(https?|ftps?):\/{2}(([\w\d\.-]){1,})\.([a-zA-Z\d:]+|\/&[^\.])|http:\/{2}localhost/i';
				$callback = function( $matches ) use ( $urls, $replace ) {
								return preg_replace( $urls, $replace, $matches[0] );
							};
			} else {
				if ( 'on' == $case_sensitive ) {
					// Case sensitive replace
					$callback = function( $matches ) use ( $search, $replace ) {
			        				return str_replace( $search, $replace, $matches[0] );
			    				};
				} else {
					// Case insensitive replace
					$callback = function( $matches ) use ( $search, $replace ) {
			        				return str_ireplace( $search, $replace, $matches[0] );
								};
				}
			}

			// Callback that runs replace function for detected replace-able contents
			$callback_callback = function( $matches ) use ( $pattern, $callback ) {
								return preg_replace_callback( $pattern, $callback, $matches[0], -1, $count);
							};

			// Start Replacing process
			if ( $sliders ) {
				if ( 'on' == $backup ) {
					foreach ( $sliders as $slider ) {
						update_option('msprp_backup_'.$slider['ID'], $slider['params']);
					}
				}
				if ( 'layers' == $where_replace ) {
					foreach ( $sliders as $slider ) {
						$decoded = base64_decode( $slider['params'] );
						// Match in Layers data only
						$changed = preg_replace_callback( '/(?<=,\"MSPanel\.Layer\":\{).*?(?=\}\"\},\")/', $callback_callback, $decoded, -1, $count);
						$params = base64_encode( $changed );
						$mspdb->update_slider( $slider['ID'], array( 'params' => $params ) );
					}
					wp_send_json_success( __( 'Done!', MSWP_TEXT_DOMAIN ) );
				} elseif ( 'slides' == $where_replace ) {
					foreach ( $sliders as $slider ) {
						$decoded = base64_decode( $slider['params'] );
						// Match in Slides data only
						$changed = preg_replace_callback( '/(?<=,\"MSPanel\.Slide\":\{).*?(?=\}\"\},\")/', $callback_callback, $decoded, -1, $count);
						$params = base64_encode( $changed );
						$mspdb->update_slider( $slider['ID'], array( 'params' => $params ) );
					}
					wp_send_json_success( __( 'Done!', MSWP_TEXT_DOMAIN ) );
				} elseif ( 'full' == $where_replace ) {
					foreach ( $sliders as $slider ) {
						$params = $slider['params'];
						$decoded = base64_decode( $params );
						// MAtch any replace-able content
						$changed = preg_replace_callback( $pattern, $callback, $decoded, -1, $count);
						$params = base64_encode( $changed );
						$mspdb->update_slider( $slider['ID'], array( 'params' => $params ) );
					}
					wp_send_json_success( __( 'Done!', MSWP_TEXT_DOMAIN ) );
				}
			}
			// Send error by default
			wp_send_json_error( __( 'Sorry! An error occurred while replacing process!', MSWP_TEXT_DOMAIN ) );

		}
			wp_send_json_error( __( 'Sorry! An error occurred while replacing process!', MSWP_TEXT_DOMAIN ) );

	}

}

new MSP_Admin_Ajax();
