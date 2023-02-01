<?php

/**
 * Fired during plugin activation
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Typehub
 * @subpackage Typehub/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Typehub
 * @subpackage Typehub/includes
 * @author     Brand Exponents <swami@brandexponents.com>
 */
class Typehub_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		do_action( 'typehub_activation' );
	}

}
