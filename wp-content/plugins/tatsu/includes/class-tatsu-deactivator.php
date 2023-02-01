<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.brandexponents.com
 * @since      1.0.0
 *
 * @package    Tatsu
 * @subpackage Tatsu/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Tatsu
 * @subpackage Tatsu/includes
 * @author     Brand Exponents Creatives Pvt Ltd <swami@brandexponents.com>
 */
class Tatsu_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		//Typehub Deactivated
		do_action( 'typehub_deactivation' );
	}

}
