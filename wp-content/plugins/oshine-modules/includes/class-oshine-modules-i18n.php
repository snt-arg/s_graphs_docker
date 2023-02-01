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
 * @package    Oshine_Modules
 * @subpackage Oshine_Modules/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Oshine_Modules
 * @subpackage Oshine_Modules/includes
 * @author     Brand Exponents <swami@brandexponents.com>
 */
class Oshine_Modules_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'oshine-modules',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
