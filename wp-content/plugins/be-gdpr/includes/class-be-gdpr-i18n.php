<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Be_Gdpr
 * @subpackage Be_Gdpr/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Be_Gdpr
 * @subpackage Be_Gdpr/includes
 * @author     Swaminathan ganesan <help@brandexponents.com>
 */
class Be_Gdpr_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'be-gdpr',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
