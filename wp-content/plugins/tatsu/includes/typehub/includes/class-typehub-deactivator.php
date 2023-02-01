<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Typehub
 * @subpackage Typehub/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Typehub
 * @subpackage Typehub/includes
 * @author     Brand Exponents <swami@brandexponents.com>
 */
class Typehub_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		do_action( 'typehub_deactivation' );
	}

}
