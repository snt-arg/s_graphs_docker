<?php
/**
 * Plugin Name:       Tatsu 
 * Plugin URI:        http://www.brandexponents.com
 * Description:       A Powerful and Elegant Live Front End Website Builder for Wordpress.
 * Version:           3.4.2
 * Author:            Brand Exponents
 * Author URI:        http://www.brandexponents.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tatsu
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	wp_die();
}

if ( ! defined( 'TATSU_PLUGIN_FILE' ) ) {
	define('TATSU_PLUGIN_FILE', plugin_dir_path( __FILE__ ) . 'tatsu.php');
}
if( !defined( 'TATSU_PLUGIN_URL' ) ) {
	define( 'TATSU_PLUGIN_URL', plugins_url( '', __FILE__ ) );
}
if( !defined( 'TATSU_PLUGIN_DIR' ) ) {
	define( 'TATSU_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if( !defined( 'TATSU_PRO_URL' ) ) {
	define( 'TATSU_PRO_URL', 'https://tatsubuilder.com/?utm_source=tatsu-free' );
}

if( !defined( 'TATSU_VERSION' ) ) {
	define( 'TATSU_VERSION', '3.4.2' );
}

if(!function_exists('deactivate_plugins')){
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

function tatsu_activate() {
	require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-activator.php';
	Tatsu_Activator::activate();
}


function tatsu_deactivate() {
	require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-deactivator.php';
	Tatsu_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'tatsu_activate' );
register_deactivation_hook( __FILE__, 'tatsu_deactivate' );

if(!class_exists('Typehub') && !class_exists('Colorhub')){
require TATSU_PLUGIN_DIR. 'includes/class-tatsu.php';

function tatsu_run() {

	$plugin = new Tatsu();
	$plugin->run();

}
tatsu_run();
}else{
	/***Deactivate Typehub and colorhub ********/
	$active_plugins =apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
	$plugin_dir_path = substr(TATSU_PLUGIN_DIR,0,-6);
	$deactivate_plugins = ['typehub/typehub.php','colorhub/colorhub.php'];
	foreach ($deactivate_plugins as $deactivate_plugin) {
		if(in_array( $deactivate_plugin,$active_plugins)){
			// Deactivate the plugin
			deactivate_plugins($plugin_dir_path.''.$deactivate_plugin);
		}
	}

	function deactivate_colorhub_typehub_admin_notice() {
		$class = 'notice notice-error is-dismissible';
		$message = __( 'Please deactivate Typehub and Colorhub plugins. Tatsu plugin requires Typehub and Colorhub plugins to be deactivated. Thanks!', 'tatsu-pro' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
	}
	//add_action( 'admin_notices', 'deactivate_colorhub_typehub_admin_notice' );
	
}
require TATSU_PLUGIN_DIR. 'plugin-update-checker/plugin-update-checker.php';
$tatsu_update_checker = new PluginUpdateChecker_3_1 (
	'https://brandexponents.com/wp/wp-content/uploads/tatsu.json',
	__FILE__,
	'tatsu'
);