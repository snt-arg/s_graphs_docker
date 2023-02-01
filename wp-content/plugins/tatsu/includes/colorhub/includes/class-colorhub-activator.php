<?php

/**
 * Fired during plugin activation
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Colorhub
 * @subpackage Colorhub/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Colorhub
 * @subpackage Colorhub/includes
 * @author     Brand Exponents Creatives Pvt Ltd <swami@brandexponents.com>
 */
class Colorhub_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		do_action( 'colorhub_activation' );
	}

}
