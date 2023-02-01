<?php
/**
 * Master Slider buttons for TinyMCE
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
 * MSP_Admin_Editor class.
 *
 * @since 2.3.0
 */
class MSP_Admin_Editor {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_head', array( $this, 'add_shortcode_button' ) );
		// Load admin Stylesheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts'), 15 );
		add_filter( 'tiny_mce_version', array( $this, 'refresh_mce' ) );
		// add_filter( 'mce_external_languages', array( $this, 'add_tinymce_lang' ), 10, 1 );
	}

	/**
	 * Add a button for shortcodes to the WP editor.
	 */
	public function add_shortcode_button() {
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
			return;
		}

		if ( 'true' == get_user_option( 'rich_editing' ) ) {
			add_filter( 'mce_external_plugins', array( $this, 'add_shortcode_tinymce_plugin' ) );
			add_filter( 'mce_buttons', array( $this, 'register_shortcode_button' ) );
		}
	}


	/**
	 * Register and enqueue admin-specific JavaScript & Stylesheet globally.
	 *
	 */
	public function enqueue_admin_scripts() {

		// define admin ajax address and master slider page
		wp_localize_script( MSWP_SLUG .'-admin-global', '__MS_EDITOR', array(
			'sliders'       => get_masterslider_names( 'alias-title' )
		));
	}


	/**
	 *
	 * @param array $locs
	 * @return array
	 */
	public function add_tinymce_lang( $locs ) {
	    $locs['msp_shortcodes_button'] = MSWP_AVERTA_ADMIN_URL . '/assets/js/editor_lang.php';
	    return $locs;
	}

	/**
	 * Register the shortcode button.
	 *
	 * @param array $buttons
	 * @return array
	 */
	public function register_shortcode_button( $buttons ) {
		array_push( $buttons, '|', 'msp_shortcodes_button' );
		return $buttons;
	}

	/**
	 * Add the shortcode button to TinyMCE
	 *
	 * @param array $plugin_array
	 * @return array
	 */
	public function add_shortcode_tinymce_plugin( $plugin_array ) {
		$wp_version = get_bloginfo( 'version' );

        /* Deprecated in WP version 4.2
        if ( version_compare( $wp_version, '3.9', '>=' ) ) {
			$plugin_array['msp_shortcodes_button'] = MSWP_AVERTA_ADMIN_URL . '/assets/js/mce-plugin.js';
		}*/

        $plugin_array['msp_shortcodes_button'] = MSWP_AVERTA_ADMIN_URL . '/assets/js/mce-plugin.js';

		return $plugin_array;
	}

	/**
	 * Force TinyMCE to refresh.
	 *
	 * @param int $ver
	 * @return int
	 */
	public function refresh_mce( $ver ) {
		$ver += 3;
		return $ver;
	}

}

new MSP_Admin_Editor();
