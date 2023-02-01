<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://brandexponents.com
 * @since             1.0.0
 * @package           Be_Gdpr
 *
 * @wordpress-plugin
 * Plugin Name:       BE GDPR Compliance
 * Plugin URI:        brandexponents.com
 * Description:       Plugin to assist you in making some of the features ( such as Youtube, Vimeo and Google Map embeds ) available in the themes and plugins created by Brand Exponents, compatible with GDPR.
 * Version:           1.1.5
 * Author:            Brand Exponents
 * Author URI:        http://brandexponents.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       be-gdpr
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BE_GDPR', '1.1.5' );

if( !defined( 'BE_GDPR_PLUGIN_URL' ) ) {
	define( 'BE_GDPR_PLUGIN_URL', plugins_url( '', __FILE__ ) );
}
if( !defined( 'BE_GDPR_PLUGIN_DIR' ) ) {
	define( 'BE_GDPR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-be-gdpr-activator.php
 */
function activate_be_gdpr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-be-gdpr-activator.php';
	Be_Gdpr_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-be-gdpr-deactivator.php
 */
function deactivate_be_gdpr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-be-gdpr-deactivator.php';
	Be_Gdpr_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_be_gdpr' );
register_deactivation_hook( __FILE__, 'deactivate_be_gdpr' );

require BE_GDPR_PLUGIN_DIR. 'plugin-update-checker/plugin-update-checker.php';
$be_gdpr_update_checker = new PluginUpdateChecker_3_1 (
    'https://brandexponents.com/wp/wp-content/uploads/be-gdpr.json',
    __FILE__,
    'be-gdpr'
);

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-be-gdpr.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_be_gdpr() {

	$plugin = new Be_Gdpr();
	$plugin->run();

}
run_be_gdpr();