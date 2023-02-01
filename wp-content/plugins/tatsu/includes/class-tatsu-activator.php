<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.brandexponents.com
 * @since      1.0.0
 *
 * @package    Tatsu
 * @subpackage Tatsu/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Tatsu
 * @subpackage Tatsu/includes
 * @author     Brand Exponents Creatives Pvt Ltd <swami@brandexponents.com>
 */
class Tatsu_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if(function_exists('deactivate_plugins')){
			$active_plugins =apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
			$plugin_dir_path = substr(TATSU_PLUGIN_DIR,0,-6);
			$deactivate_plugins = ['typehub/typehub.php','colorhub/colorhub.php'];
			foreach ($deactivate_plugins as $deactivate_plugin) {
				if(in_array( $deactivate_plugin,$active_plugins)){
					// Deactivate the plugin
					deactivate_plugins($plugin_dir_path.''.$deactivate_plugin);
				}
			}
		}
		//Typehub Activated
		do_action( 'typehub_activation' );
		//Colorhub Activated
		do_action( 'colorhub_activation' );
	}
	
}
