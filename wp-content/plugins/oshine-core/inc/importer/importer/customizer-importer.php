<?php

/**
 * The main import class.
 *
 * @since 0.1
 */
if(!class_exists('WP_Customize_Setting')) {
	require_once( ABSPATH . 'wp-includes/class-wp-customize-setting.php' );
}

if(!class_exists('CEI_Option')) {
final class CEI_Option extends WP_Customize_Setting {
	
	/**
	 * Import an option value for this setting.
	 *
	 * @since 0.3
	 * @param mixed $value The option value.
	 * @return void
	 */
	public function import( $value ) 
	{
		$this->update( $value );	
	}
}
}
if(!class_exists('BeSquaresCustomizeImport')) {
final class BeSquaresCustomizeImport {

	/**
	 * An array of core options that shouldn't be imported.
	 *
	 * @since 0.3
	 * @access private
	 * @var array $core_options
	 */
	static private $core_options = array(
		'blogname',
		'blogdescription',
		'show_on_front',
		'page_on_front',
		'page_for_posts',
	);

	
	/**
	 * Check to see if we need to do an export or import.
	 * This should be called by the customize_register action.
	 *
	 * @since 0.1
	 * @since 0.3 Passing $wp_customize to the export and import methods.
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @return void
	 */
	static public function init( $wp_customize, $file) 
	{
		echo 'test';
		if ( current_user_can( 'edit_theme_options' ) ) {
			
			self::_import( $wp_customize, $file );
		}
	}

	/**
	 * Imports uploaded mods and calls WordPress core customize_save actions so
	 * themes that hook into them can act before mods are saved to the database.
	 *
	 * @since 0.1
	 * @since 0.3 Added $wp_customize param and importing of options.
	 * @access private
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @return void
	 */
	static private function _import( $wp_customize, $file ) 
	{

		// Make sure WordPress upload support is loaded.
		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
		
		// Setup global vars.
		echo 'test';
		global $cei_error;
		
		// Setup internal vars.
		$cei_error	 = false;
		$template	 = get_template();
		$overrides   = array( 'test_form' => FALSE, 'mimes' => array('dat' => 'text/dat') );

		if ( ! file_exists( $file ) ) {
			$cei_error = __( 'Error importing settings! Please try again.', 'customizer-export-import' );
			return;
		}
		
		// Get the upload data.
		$raw  = file_get_contents( $file );
		$data = @unserialize( $raw );
		
		
		// Data checks.
		if ( 'array' != gettype( $data ) ) {
			$cei_error = __( 'Error importing settings! Please check that you uploaded a customizer export file.', 'customizer-export-import' );
			return;
		}
		if ( ! isset( $data['template'] ) || ! isset( $data['mods'] ) ) {
			$cei_error = __( 'Error importing settings! Please check that you uploaded a customizer export file.', 'customizer-export-import' );
			return;
		}
		if ( $data['template'] != $template ) {
			$cei_error = __( 'Error importing settings! The settings you uploaded are not for the current theme.', 'customizer-export-import' );
			return;
		}
		
		// Import images.
		if ( isset( $_REQUEST['cei-import-images'] ) ) {
			$data['mods'] = self::_import_images( $data['mods'] );
		}
		
		// Import custom options.
		if ( isset( $data['options'] ) ) {
			
			foreach ( $data['options'] as $option_key => $option_value ) {
				
				$option = new CEI_Option( $wp_customize, $option_key, array(
					'default'		=> '',
					'type'			=> 'option',
					'capability'	=> 'edit_theme_options'
				) );
				
				$option->import( $option_value );
			}
		}
		
		// Call the customize_save action.
		do_action( 'customize_save', $wp_customize );
		
		// Loop through the mods.
		foreach ( $data['mods'] as $key => $val ) {
			
			// Call the customize_save_ dynamic action.
			do_action( 'customize_save_' . $key, $wp_customize );
			
			// Save the mod.
			set_theme_mod( $key, $val );
		}
		
		// Call the customize_save_after action.
		do_action( 'customize_save_after', $wp_customize );

	}
	
	/**
	 * Imports images for settings saved as mods.
	 *
	 * @since 0.1
	 * @access private
	 * @param array $mods An array of customizer mods.
	 * @return array The mods array with any new import data.
	 */
	static private function _import_images( $mods ) 
	{
		foreach ( $mods as $key => $val ) {
			
			if ( self::_is_image_url( $val ) ) {
				
				$data = self::_sideload_image( $val );
				
				if ( ! is_wp_error( $data ) ) {
					
					$mods[ $key ] = $data->url;
					
					// Handle header image controls.
					if ( isset( $mods[ $key . '_data' ] ) ) {
						$mods[ $key . '_data' ] = $data;
						update_post_meta( $data->attachment_id, '_wp_attachment_is_custom_header', get_stylesheet() );
					}
				}
			}
		}
		
		return $mods;
	}
	
	/**
	 * Taken from the core media_sideload_image function and
	 * modified to return an array of data instead of html.
	 *
	 * @since 0.1
	 * @access private
	 * @param string $file The image file path.
	 * @return array An array of image data.
	 */
	static private function _sideload_image( $file ) 
	{
		$data = new stdClass();
		
		if ( ! function_exists( 'media_handle_sideload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
		}
		if ( ! empty( $file ) ) {
			
			// Set variables for storage, fix file filename for query strings.
			preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches );
			$file_array = array();
			$file_array['name'] = basename( $matches[0] );
	
			// Download file to temp location.
			$file_array['tmp_name'] = download_url( $file );
	
			// If error storing temporarily, return the error.
			if ( is_wp_error( $file_array['tmp_name'] ) ) {
				return $file_array['tmp_name'];
			}
	
			// Do the validation and storage stuff.
			$id = media_handle_sideload( $file_array, 0 );
	
			// If error storing permanently, unlink.
			if ( is_wp_error( $id ) ) {
				@unlink( $file_array['tmp_name'] );
				return $id;
			}
			
			// Build the object to return.
			$meta					= wp_get_attachment_metadata( $id );
			$data->attachment_id	= $id;
			$data->url				= wp_get_attachment_url( $id );
			$data->thumbnail_url	= wp_get_attachment_thumb_url( $id );
			$data->height			= $meta['height'];
			$data->width			= $meta['width'];
		}
	
		return $data;
	}
	
	/**
	 * Checks to see whether a string is an image url or not.
	 *
	 * @since 0.1
	 * @access private
	 * @param string $string The string to check.
	 * @return bool Whether the string is an image url or not.
	 */
	static private function _is_image_url( $string = '' ) 
	{
		if ( is_string( $string ) ) {
			
			if ( preg_match( '/\.(jpg|jpeg|png|gif)/i', $string ) ) {
				return true;
			}
		}
		
		return false;
	}
}
}