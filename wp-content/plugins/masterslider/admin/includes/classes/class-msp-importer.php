<?php
/**
 * Master Slider Import/Export Class.
 *
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


/**
 * Master Slider Import/Export Class.
 *
 * @since 1.2.0
 */
class MSP_Importer {


	var $origin_upload_baseurl = '';

	var $upload_baseurl = '';

	var $upload_basedir = '';

	var $image_import_queue = array();

	var $import_medias = true;

	var $last_new_slider_id = null;



	function __construct() {

		add_action( 'admin_menu', array( $this, 'admin_init' ) );
	}


	public function admin_init() {

		$upload = wp_upload_dir();
		$this->upload_baseurl = $upload['baseurl'];
		$this->upload_basedir = $upload['basedir'];

		$this->process_export_request();

		register_importer( 'masterslider-importer', __( 'Master Slider', MSWP_TEXT_DOMAIN ), __( 'Import sliders and images from a Master Slider export file.', MSWP_TEXT_DOMAIN ), array( $this, 'render_importer_page' ) );
	}


	public function render_importer_page() {

		$this->header();

		$this->process_import_request();

		$this->footer();
	}


	/**
	 * Display import page title
	 */
	function header() {
		echo '<div class="wrap">';
		echo '<h2>' . __( 'Importing Master Slider', 'wordpress-importer' ) . '</h2><br />';
	}

	/**
	 * Close div.wrap
	 */
	function footer() {
		echo '</div>';
		?>
		<script>
		function mspGetParameterByName(name) {
			name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
			var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(location.search);
			return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
		}
		jQuery(window).load(function(){
			if (typeof redirect_link !== 'undefined' && redirect_link !== '' ) {
				window.location.replace( redirect_link );
			} else {
				console.log('redirect link not found');
			}
		});
		</script>
		<?php
	}


	/**
	 * Decide what the maximum file size for downloaded attachments is.
	 * Default is 0 (unlimited), can be filtered via masterslider_import_attachment_size_limit
	 *
	 * @return int Maximum attachment file size to import
	 */
	function max_attachment_size() {
		return apply_filters( 'masterslider_import_attachment_size_limit', 0 );
	}


	// if it's relative url, get absolute origin url
	function get_absolute_media_url( $url ){

        if( $this->is_absolute_url( $url ) || $this->contains_origin_upload_dir( $url ) )
        	return $url;

        return $this->origin_upload_baseurl . $url;
    }


    /**
     * Is absolute url?
     * @param  string  $url  the url
     * @return boolean       true if the url is absolue and false otherwise
     */
    public function is_absolute_url( $url ){
    	return preg_match( "~^(?:f|ht)tps?://~i", $url );
	}


	/**
	 * Wheather url contains origin_upload_baseurl or not
	 * @param  string $url  the url
	 * @return bool      TRUE, if url contains origin_upload_baseurl
	 */
	public function contains_origin_upload_dir( $url ){
	    return strpos( $url, $this->origin_upload_baseurl ) !== false;
	}


	/**
	 * Process incoming requests for importing sliders
	 * @return void
	 */
	public function process_import_request(){

		$step = isset( $_REQUEST['step'] ) && ! empty( $_REQUEST['step'] ) ? (int)$_REQUEST['step'] : 0;

		if( 2 > $step ) {

			$bytes = apply_filters( 'masterslider_import_upload_size_limit', wp_max_upload_size() );
			$size  = size_format( $bytes );
		?>

		<div class="msp-import-wrapper">

			<form action="<?php echo admin_url( 'admin.php?import=masterslider-importer&step=2' ); ?>" method="post" enctype="multipart/form-data" class="msp-import-form msp-dialog-inner-section">

				<span class="msp-dialog-section-desc"><?php  _e( 'To import sliders select Masterslider Export file that you downloaded before then click import button.', MSWP_TEXT_DOMAIN ) ?></span>
				<br />
				<hr />
				<br />
				<fieldset>
					<?php wp_nonce_field('import-msp-sliders'); ?>

					<input type="hidden" name="msp-import" value="1">

					<input type="hidden" name="max_file_size" value="<?php echo $bytes; ?>" />

					<input type="file" name="msp-import-file" class="msp-select-file">

					<small><?php printf( __( 'Maximum size: %s', MSWP_TEXT_DOMAIN ), $size ); ?></small><br /><br /><br />

					<input type="submit" class="button" value="<?php esc_attr_e( 'Upload file and import', MSWP_TEXT_DOMAIN ); ?>" />
				</fieldset>



			</form>

	    </div>

	    <?php }

		// Import sliders from export file
		if( isset( $_POST['msp-import'] ) ) {

			if( current_user_can('export_masterslider') ) {

				if( check_admin_referer('import-msp-sliders') ) {

					$step = isset( $_REQUEST['step'] ) && ! empty( $_REQUEST['step'] ) ? (int)$_REQUEST['step'] : 0;

					if( 2 == $step ){

						if ( $_FILES['msp-import-file']['error'] == UPLOAD_ERR_OK  && is_uploaded_file( $_FILES['msp-import-file']['tmp_name'] ) ) {
							// get import file content
							$import_data = file_get_contents( $_FILES['msp-import-file']['tmp_name'] );
							$this->import_data( $import_data );
						}

					}
				}

			} else {
				add_action( 'admin_notices', array( $this, 'import_export_notice' ) );
			}
		}

		// Import slider by starter id
		if( isset( $_REQUEST['starter_id'] ) && ! empty( $_REQUEST['starter_id'] ) ) {

			if( current_user_can('export_masterslider') || apply_filters( 'masterslider_user_can_import_starter_content', 0 ) ) {

				if ( $starter_field = msp_get_slider_starter_field( $_REQUEST['starter_id'] ) ) {

                    $import_data = $starter_field['importdata'];

                    // Retrieve data of current slider remotely if data is not embeded
                    if( empty( $import_data ) ){

                       global $wp_version;

                        $slider_uid = ! empty( $starter_field['uid'] ) ? $starter_field['uid'] : '';

                        if( ! empty( $slider_uid ) ){
                            $args = array(
                                'user-agent' => 'WordPress/'. $wp_version.'; '. get_site_url(),
                                'timeout'    => ( ( defined('DOING_CRON') && DOING_CRON ) ? 30 : 10 ),
                                'body'       => array(
                                    'slider_uid' => $slider_uid
                                )
                            );

                            $request = wp_remote_get( 'http://api.averta.net/products/masterslider/samples/', $args );

                            if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) !== 200 ) {
                                _e( 'Cannot fetch slider data ..', MSWP_TEXT_DOMAIN );
                                $import_data = '';
                            } else {
                               $import_data = $request['body'];
                            }

                        }

                    }

					if ( ! empty( $import_data )  ) {
                        $this->import_data( $import_data );
						printf( "<script> var redirect_link = '%s';</script>", admin_url( 'admin.php?page='.MSWP_SLUG.'&action=edit&slider_id='.$this->last_new_slider_id. '&fr' ) );

					} else {
						_e( 'Import data not found ..', MSWP_TEXT_DOMAIN );
					}

				} else {
					_e( 'Starter ID is not valid.', MSWP_TEXT_DOMAIN );
				}

			} else {
				add_action( 'admin_notices', array( $this, 'import_export_notice' ) );
			}

		}


		// Import sliders from export file
		if( isset( $_POST['import-theme-sliders'] ) ) {

			if( current_user_can('export_masterslider') ) {

				if( check_admin_referer('msp-im-theme-sliders') ) {

					$step = isset( $_REQUEST['step'] ) && ! empty( $_REQUEST['step'] ) ? (int)$_REQUEST['step'] : 0;

					if( 2 == $step ){

						if( $import_data = msp_get_theme_sliders_data() ){
							$allowed_slider_ids = isset( $_POST['ms_import_theme_slider_ids'] ) ? $_POST['ms_import_theme_slider_ids'] : null;
							$this->import_data( $import_data, $allowed_slider_ids );
						}
					}
				}

			} else {
				_e( 'You do not have enough permission to import sliders', MSWP_TEXT_DOMAIN );
			}
		}

	}



	public function process_export_request(){

		// Export sliders
		if( isset( $_POST['msp-export'] ) ) {

			if( current_user_can('export_masterslider') ) {

				if( check_admin_referer('export-msp-sliders') ) {

					$sliders 		= isset( $_POST['msp-export-sliders']  		 ) ? $_POST['msp-export-sliders'] : '';
					$preset_styles  = isset( $_POST['msp-export-preset-styles']  ) ? $_POST['msp-export-preset-styles']  : '';
                    $preset_effects = isset( $_POST['msp-export-preset-effects'] ) ? $_POST['msp-export-preset-effects'] : '';
					$buttons_style  = isset( $_POST['msp-export-buttons-style']  ) ? $_POST['msp-export-buttons-style']  : '';

					$args = array();

					if( $preset_styles )
						$args[] = 'preset_styles';

					if( $preset_effects )
						$args[] = 'preset_effects';

                    if( $buttons_style )
                        $args[] = 'buttons_style';

					if( ! empty( $sliders ) || ! empty( $args ) ) {
						$this->export_slider_data_in_file( $sliders, $args );
					}
				}

			}else {
				add_action( 'admin_notices', array( $this, 'import_export_notice' ) );
			}
		}

	}


	/**
	 * Add admin notice if access to import/export is denied
	 * @return void
	 */
	public function import_export_notice(){
		printf( '<div class="error" style="display:block;" ><p>%s</p></div>',
				apply_filters( 'masterslider_import_export_access_denied_message', __( "Sorry, You don't have enough permission to import/export sliders.", MSWP_TEXT_DOMAIN ) )
		);
	}






	/**
	 * Get slider export data
	 *
	 * @param  int|array  $slider_id  the slider id(s)
	 * @param  array      The other options that should be included in export data ( preset_styles, preset_effects )
	 * @param  bool       $base64     encode output data to base64 or not
	 * @return string     the slider export data
	 */
	function get_slider_export_data( $slider_ids = array() , $args = null, $base64 = true ){

		$slider_ids = (array) $slider_ids;
		$args 		= (array) $args;

		// stores export data
		$export_data = array();

		$export_data['sliders_data'] = array();

		// loop through selected sliders and store in sliders_data
		foreach ( $slider_ids as $slider_id ) {

			if( is_numeric( $slider_id ) ) {
				global $mspdb;

                $slider_title  = $mspdb->get_slider_field_val( $slider_id, 'title'  );
				$slider_alias  = $mspdb->get_slider_field_val( $slider_id, 'alias'  );
				$slider_params = $mspdb->get_slider_field_val( $slider_id, 'params' );
				$slider_type   = $mspdb->get_slider_field_val( $slider_id, 'type'   );
				$slides_num    = $mspdb->get_slider_field_val( $slider_id, 'slides_num');

				$export_data['sliders_data'][ $slider_id ] = array(
                    'title'  => $slider_title,
					'alias'  => $slider_alias,
					'params' => $slider_params,
					'type'   => $slider_type,
					'slides_num' => $slides_num
				);
			}

		}

		// add origin_uploads_url to export data - this helps us to fetch images from origin domian

		// if you need to bundle sample sliders in your theme you can change the origin_uploads_url
		// by default origin_uploads_url is the uploads baseurl on domain you exported the sliders from (e.g www.domain.com/wp-content/uploads)
		// when you decide to import data to new domain, importer will use the origin_uploads_url to fetch images from.
		// you can change origin_uploads_url by using 'masterslider_export_origin_uploads_url' filter
		// if you change origin_uploads_url to something else, importer will import slider images
		// from your custom origin_uploads_url instead of default origin_uploads_url
		$custom_export_origin_uploads_url = apply_filters( 'masterslider_export_origin_uploads_url', null );

		// if filter passed empty string, origin_uploads_url will be plugins/masterslider/samples folder
		if( '' === $custom_export_origin_uploads_url ) {
			$export_data['origin_uploads_url'] = '{{masterslider}}/samples';

		// if filter passed a string with our special tags :
		} elseif( false !== strpos( $custom_export_origin_uploads_url, '{{masterslider}}'    )  ||
		          false !== strpos( $custom_export_origin_uploads_url, '{{theme_dir}}'       )  ||
				  false !== strpos( $custom_export_origin_uploads_url, '{{child_theme_dir}}' ) ) {

			$export_data['origin_uploads_url'] = $custom_export_origin_uploads_url;

		// if filter value not changed use upload baseurl for current domain
		} else {
			$uploads = wp_upload_dir();
			$export_data['origin_uploads_url'] = $uploads['baseurl'];
		}



		$export_data['preset_styles']  = in_array( 'preset_styles' , $args ) ? msp_get_option( 'preset_style'  , '' ) : '';
        $export_data['preset_effects'] = in_array( 'preset_effects', $args ) ? msp_get_option( 'preset_effect' , '' ) : '';
		$export_data['buttons_style']  = in_array( 'buttons_style' , $args ) ? msp_get_option( 'buttons_style' , '' ) : '';


		if ( $base64 ){
            $export_json_data = json_encode( $export_data );
            $export_b64_data  = base64_encode( $export_json_data );

            return $export_b64_data;
        }

		return $export_data;
	}


	/**
	 * Print slider export data
	 *
	 * @param  int|array  $slider_id  the slider id(s)
	 * @param  array      The other options that should be included in export data ( preset_styles, preset_effects )
	 * @param  bool       $base64     encode output data to base64 or not
	 * @return void
	 */
	function the_slider_export_data ( $slider_id, $args = null, $base64 = true ){
		$export = $this->get_slider_export_data( $slider_id, $args, $base64 );
	}


	/**
	 * Export slider(s) data to file
	 *
	 * @param  int|array  $slider_id  slider(s) ID to export
	 * @param  array      The other options that should be included in export data ( preset_style, preset_effect )
	 * @return void
	 */
	function export_slider_data_in_file( $slider_id, $args = null ){

		$blogname = str_replace( " ", "", get_option('blogname') );
	    $date = date("m-d-Y");
	    $export_file_name = $blogname."-".MSWP_SLUG."-".$date;

	    $export_b64_data = $this->get_slider_export_data( $slider_id, $args );

	    header( "Content-Type: application/force-download; charset=" . get_option( 'blog_charset')  );
		header( "Content-Disposition: attachment; filename=$export_file_name.json" );
		exit( $export_b64_data );
	}


	/**
	 * Check and decode exported_data
	 *
	 * @param  string $exported_data  the exported string
	 * @return bool/array   false if exported_data is invalid or decoded exported_data in array if it's valid
	 */
	function decode_import_data( $exported_data ){
		if( empty( $exported_data ) )
			return false;

		$exported_b64_decoded = msp_maybe_base64_decode( $exported_data );
		$export_array  = json_decode( $exported_b64_decoded, true );

		// validate export data
		if ( ! is_array( $export_array ) ){
			echo __( 'Import data is not valid.', MSWP_TEXT_DOMAIN ) . "<br />";
			return false;
		}

		return $export_array;
	}


	/**
	 * Import sliders and options by previously exported data
	 *
	 * @param  string $exported_data  the exported string
	 * @param  array  $allowed_slider_ids  just import sliders that are in this list
	 * @param  array  $skip_slider_ids  don't import sliders that are in this list
	 * @return bool   true on success and false on failure
	 */
	function import_data( $exported_data, $allowed_slider_ids = null, $skip_slider_ids = array() ){

		$export_array = $this->decode_import_data( $exported_data );

		if( false === $export_array )
			return false;

		// if you need to change "origin_upload_baseurl" while importing content, just define MSWP_IMPORT_FETCH_DIR const
		if( defined( 'MSWP_IMPORT_FETCH_DIR' ) ){
			$this->origin_upload_baseurl = MSWP_IMPORT_FETCH_DIR;

		// set origin_upload_baseurl
		} elseif( isset( $export_array['origin_uploads_url'] ) && ! empty( $export_array['origin_uploads_url'] ) ) {
			$this->origin_upload_baseurl = $export_array['origin_uploads_url'];

		} else {
			$this->origin_upload_baseurl = MSWP_AVERTA_URL . '/samples';
		}

		// find and replace special template tags
		$this->origin_upload_baseurl = str_replace( '{{masterslider}}'   , MSWP_AVERTA_URL, $this->origin_upload_baseurl );
		$this->origin_upload_baseurl = str_replace( '{{theme_dir}}'      , get_template_directory_uri() , $this->origin_upload_baseurl );
		$this->origin_upload_baseurl = str_replace( '{{child_theme_dir}}', get_stylesheet_directory_uri() , $this->origin_upload_baseurl );

		// import preset styles if it's included in export data
		if( isset( $export_array['preset_styles'] ) && ! empty( $export_array['preset_styles'] ) ) {
			msp_update_option( 'preset_style'  , $export_array['preset_styles'] );
			echo __( 'Preset styles imported successfully.', MSWP_TEXT_DOMAIN ) . "<br />";
		}

		// import preset effects if it's included in export data
		if( isset( $export_array['preset_effects'] ) && ! empty( $export_array['preset_effects'] ) ) {
			msp_update_option( 'preset_effect'  , $export_array['preset_effects'] );
			echo __( 'Preset transitions imported successfully.', MSWP_TEXT_DOMAIN ) . "<br />";
		}

        // import buttons styles if it's included in export data
        if( isset( $export_array['buttons_style'] ) && ! empty( $export_array['buttons_style'] ) ) {
            msp_update_option( 'buttons_style'  , $export_array['buttons_style'] );
            echo __( 'Buttons custom style imported successfully.', MSWP_TEXT_DOMAIN ) . "<br />";
        }

		// import sliders
		if( isset( $export_array['sliders_data'] ) ) {
			// reset image import queue
			$this->image_import_queue = array();
			$this->last_new_slider_id = null;
			$this->import_add_sliders( $export_array['sliders_data'], $allowed_slider_ids, $skip_slider_ids );
		}

		echo "<br />" . __( 'All data imported successfully, have fun :)' ) . "<br />";

		printf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=' . MSWP_SLUG ), __( 'Back to panel ..', MSWP_TEXT_DOMAIN ) );

		return true;
	}


	/**
	 * Import slider(s) by exported data
	 *
	 * @param  string $sliders_data  the exported string
	 * @param  array  $allowed_slider_ids  just import sliders that are in this list
	 * @param  array  $skip_slider_ids  don't import sliders that are in this list
	 * @return bool   true on success and false on failure
	 */
	function import_add_sliders( $sliders_data, $allowed_slider_ids = null, $skip_slider_ids = array() ){

		if( empty( $sliders_data ) )
			return false;

		if ( ! is_array( $sliders_data ) ){
			return false;
		}

		foreach ( $sliders_data as $slider_id => $slider_fields ) {

			global $mspdb;

			// skip if slider id is not in allowed list
			if( $allowed_slider_ids && ! in_array( $slider_id, $allowed_slider_ids ) ){
				continue;
			}

			// skip if slider id is in black list
			if( $skip_slider_ids &&   in_array( $slider_id, $skip_slider_ids ) ){
				continue;
			}

			// do not publish slider if user has not enough permission to publish sliders
			$slider_fields['status'] = current_user_can( 'publish_masterslider' ) ? 'published' : 'draft';

			// import slider
			$new_slider_id = $mspdb->import_slider( $slider_fields );
			$this->last_new_slider_id = $new_slider_id;
			msp_update_slider_custom_css_and_fonts( $new_slider_id );

			echo sprintf( 'Slider "%s" created successfully.', $new_slider_id ) . "<br />";

			// extact and collect images from each slider
			if( $this->import_medias && isset( $slider_fields['params'] ) )
				$this->extract_slider_images( $slider_fields['params'] );
		}

		if( $this->import_medias )
			$this->fetch_all_medias();

		return true;
	}


	/**
	 * Extract images from slider data and add them to image_import_queue list
     *
	 * @param  string $slider_params the slider params
	 * @return void
	 */
	public function extract_slider_images( $slider_params ) {

		$parser = msp_get_parser();
	    $parser->set_data( $slider_params );
	    $results = $parser->get_results();

	    // collect slider background image
	    $this->image_import_queue[] = $results['setting']['bg_image'];

	    if( isset( $results['setting']['ps_slide_bg'] ) )
	    	$this->image_import_queue[] = $results['setting']['ps_slide_bg'];

	    // collect layer's images
	    if( isset( $results['layers'] ) ) {

	    	foreach ( $results['layers'] as $layer ) {
	    		$this->image_import_queue[] = $layer['src'];
	    	}
	    }

	    // collect slide's images
	    if( isset( $results['slides'] ) ) {

	    	foreach ( $results['slides'] as $slide ) {
                // skip if current slide is 'overlay' slide not 'standard' slide
                if( empty( $slide['src'] ) )
                    continue;

	    		$this->image_import_queue[] = $slide['src'];
	    		$this->image_import_queue[] = $slide['thumb'];
	    	}
	    }

	    $this->image_import_queue = apply_filters( 'masterslider_extract_slider_images_to_import', $this->image_import_queue, $results );
	}


	/**
	 * Download and save slider images in upload directory
	 * @return void
	 */
	public function fetch_all_medias(){

		echo "<br />";
		$this->image_import_queue = array_filter( $this->image_import_queue );

		foreach ( $this->image_import_queue as $url ) {
			$this->download_media( $url );
		}
	}


	public function download_media( $url ){

		if( ! isset( $url ) || empty( $url ) )  return '';

        // remove upload directory and get relative url
        if( $this->contains_origin_upload_dir( $url ) ) {
        	$url = str_replace( $this->origin_upload_baseurl, '', $url );
        }

        // skip if url was not internal media url
        if( $this->is_absolute_url( $url ) ) {
        	echo "Media already exists.<br />";
        	return '';
        }


        $relative_url = $url;

        // extract the file name and extension from the url
		$file_name = basename( $relative_url );

		// extract upload date
		$upload_date  =  untrailingslashit( str_replace( $file_name, '', $relative_url ) );

		// get absolute media url
		$absolute_url = $this->get_absolute_media_url( $relative_url );

		// printf( "Importing ( %s ) file from ( %s ) .. <br />", $relative_url, $absolute_url );

		// check if import media already exist
		if( is_file( $this->upload_basedir . $relative_url ) ) {
			echo sprintf( 'Media “%s” already exists.', $file_name ) . "<br />";
			return;
		}

		printf( "Importing ( %s ) file .. <br />", $relative_url );

		// printf( "upload date ( %s ) .. <br />", $upload_date ); printf( "absolute url ( %s ) .. <br /><br />", $absolute_url ); return;

		$upload = $this->fetch_remote_file( $absolute_url, $upload_date );


		if( is_wp_error( $upload ) || $upload['error'] ) {
			echo "Failed to import media." . "<br />";
			return $upload;
		}


		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => '',
			'post_mime_type' => '',
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $upload['file'] ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		if ( $info = wp_check_filetype( $upload['file'] ) )
			$attachment['post_mime_type'] = $info['type'];
		else
			return new WP_Error( 'attachment_processing_error', __('Invalid file type', 'wordpress-importer') );

		$attachment['guid'] = $upload['url'];

		// as per wp-admin/includes/upload.php
		$attachment_id = wp_insert_attachment( $attachment, $upload['file'] );

		// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
		require_once( ABSPATH . 'wp-admin/includes/image.php' );

		wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $upload['file'] ) );



		echo sprintf( '<a href="%s" target="_blank" >%s</a> Imported successfully.', $upload['url'], $file_name ) . "<br />";
	}


	/**
	 * Attempt to download a remote file attachment
	 *
	 * @param string $url URL of item to fetch
	 * @param array $post Attachment details
	 * @return array|WP_Error Local file location details on success, WP_Error otherwise
	 */
	function fetch_remote_file( $url, $subdir = null ) {

		add_filter( 'http_request_timeout', array( $this, 'bump_request_timeout' ) );

		// extract the file name and extension from the url
		$file_name = basename( $url );

		// get placeholder file in the upload dir with a unique, sanitized filename
		$upload = $this->wp_upload_bits( $file_name, '', $subdir );

		// var_dump( $upload );
		//echo "<br />" . $url . "<br />"; return new WP_Error( 'import_file_error', '' );

		if ( $upload['error'] )
			return new WP_Error( 'upload_dir_error', $upload['error'] );

		// fetch the remote url and write it to the placeholder file
        $response = wp_remote_get( $url, array(
            'stream'   => true,
            'filename' => $upload['file']
        ) );

        // request failed
        if ( is_wp_error( $response ) ) {
            @unlink( $upload['file'] );
            return $response;
        }

        $code = (int) wp_remote_retrieve_response_code( $response );

        // make sure the fetch was successful
        if ( $code !== 200 ) {
            @unlink( $upload['file'] );
            return new WP_Error(
                'import_file_error',
                sprintf(
                    __('Remote server returned %1$d %2$s for %3$s', 'wordpress-importer'),
                    $code,
                    get_status_header_desc( $code ),
                    $url
                )
            );
        }

		$filesize = filesize( $upload['file'] );

		if ( isset( $headers['content-length'] ) && $filesize != $headers['content-length'] ) {
			@unlink( $upload['file'] );
			return new WP_Error( 'import_file_error', __('Remote file is incorrect size', 'wordpress-importer') );
		}

		if ( 0 == $filesize ) {
			@unlink( $upload['file'] );
			return new WP_Error( 'import_file_error', __('Zero size file downloaded', 'wordpress-importer') );
		}

		$max_size = (int) $this->max_attachment_size();
		if ( ! empty( $max_size ) && $filesize > $max_size ) {
			@unlink( $upload['file'] );
			return new WP_Error( 'import_file_error', sprintf(__('Remote file is too large, limit is %s', 'wordpress-importer'), size_format( $max_size ) ) );
		}

		return $upload;
	}





	/**
	 * Create a file in the upload folder with given content.
	 *
	 * If there is an error, then the key 'error' will exist with the error message.
	 * If success, then the key 'file' will have the unique file path, the 'url' key
	 * will have the link to the new file. and the 'error' key will be set to false.
	 *
	 * This function will not move an uploaded file to the upload folder. It will
	 * create a new file with the content in $bits parameter. If you move the upload
	 * file, read the content of the uploaded file, and then you can give the
	 * filename and content to this function, which will add it to the upload
	 * folder.
	 *
	 * The permissions will be set on the new file automatically by this function.
	 *
	 * @param string $name
	 * @param mixed $bits File content
	 * @param string $subdir Optional. Time formatted in 'yyyy/mm'.
	 * @return array
	 */
	function wp_upload_bits( $name, $bits, $subdir = '' ) {

		if ( empty( $name ) )
			return array( 'error' => __( 'Empty filename' ) );

		$wp_filetype = wp_check_filetype( $name );

		if ( ! $wp_filetype['ext'] && ! current_user_can( 'unfiltered_upload' ) )
			return array( 'error' => __( 'Invalid file type' ) );

		$upload = wp_upload_dir();

		if ( $upload['error'] !== false )
			return $upload;


		$upload_path = $upload['basedir'] . $subdir;

		$filename = wp_unique_filename( $upload_path, $name );

		$new_file = $upload_path . "/$filename";

		// echo "file path : {$new_file} <br />";


		if ( ! wp_mkdir_p( dirname( $new_file ) ) ) {
			if ( 0 === strpos( $upload['basedir'], ABSPATH ) )
				$error_path = str_replace( ABSPATH, '', $upload['basedir'] ) . $upload['subdir'];
			else
				$error_path = basename( $upload['basedir'] ) . $upload['subdir'];

			$message = sprintf( __( 'Unable to create directory %s. Is its parent directory writable by the server?' ), $error_path );
			return array( 'error' => $message );
		}

		$ifp = @ fopen( $new_file, 'wb' );
		if ( ! $ifp )
			return array( 'error' => sprintf( __( 'Could not write file %s' ), $new_file ) );

		@fwrite( $ifp, $bits );
		fclose( $ifp );
		clearstatcache();

		// Set correct file permissions
		$stat = @ stat( dirname( $new_file ) );
		$perms = $stat['mode'] & 0007777;
		$perms = $perms & 0000666;
		@ chmod( $new_file, $perms );
		clearstatcache();

		// Compute the URL
		$url = $upload['baseurl'] . "$subdir/$filename";

		return array( 'file' => $new_file, 'url' => $url, 'error' => false );
	}


	/**
	 * Added to http_request_timeout filter to force timeout at 60 seconds during import
	 * @return int 60
	 */
	function bump_request_timeout() {
		return 60;
	}



}

global $ms_importer;
if( is_null( $ms_importer ) ) $ms_importer = new MSP_Importer();
