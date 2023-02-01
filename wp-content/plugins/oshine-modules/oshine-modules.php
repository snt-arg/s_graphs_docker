<?php
/**
 * Plugin Name:       Oshine Modules
 * Plugin URI:        http://oshine.wpengine.com
 * Description:       Shortcode Modules that come along with the OSHINE Theme, integrated with TATSU Page Builder plugin
 * Version:           3.3.0
 * Author:            Brand Exponents
 * Author URI:        http://brandexponents.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       oshine-modules
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if( !defined( 'OSHINE_MODULES_PLUGIN_URL' ) ) {
	define( 'OSHINE_MODULES_PLUGIN_URL', plugins_url( '', __FILE__ ) );
}
if( !defined( 'OSHINE_MODULES_PLUGIN_DIR' ) ) {
	define( 'OSHINE_MODULES_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}


function activate_oshine_modules() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-oshine-modules-activator.php';
	Oshine_Modules_Activator::activate();
}

function deactivate_oshine_modules() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-oshine-modules-deactivator.php';
	Oshine_Modules_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_oshine_modules' );
register_deactivation_hook( __FILE__, 'deactivate_oshine_modules' );

require OSHINE_MODULES_PLUGIN_DIR. 'plugin-update-checker/plugin-update-checker.php';
$oshine_modules_update_checker = new PluginUpdateChecker_3_1 (
    'https://brandexponents.com/wp/wp-content/uploads/oshine-modules.json',
    __FILE__,
    'oshine-modules'
);


require plugin_dir_path( __FILE__ ) . 'includes/class-oshine-modules.php';


function run_oshine_modules() {

	$plugin = new Oshine_Modules();
	$plugin->run();

}
run_oshine_modules();