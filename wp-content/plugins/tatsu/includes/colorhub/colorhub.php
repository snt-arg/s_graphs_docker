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
 * @package           Colorhub
 *
 * @wordpress-plugin
 * Plugin Name:       Color Hub
 * Plugin URI:        http://brandexponents.com
 * Description:       Helps you create swatches and palettes for managing colors used across your website. Integrated with Tatsu page builder. 
 * Version:           1.0.7
 * Author:            Brand Exponents
 * Author URI:        http://brandexponents.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       colorhub
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
define( 'COLORHUB_VERSION', '1.0.7' );

if( !defined( 'COLORHUB_PLUGIN_URL' ) ) {
	define( 'COLORHUB_PLUGIN_URL', plugins_url( '', __FILE__ ) );
}
if( !defined( 'COLORHUB_PLUGIN_DIR' ) ) {
	define( 'COLORHUB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-colorhub-activator.php
 */
function activate_colorhub() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-colorhub-activator.php';
	Colorhub_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-colorhub-deactivator.php
 */
function deactivate_colorhub() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-colorhub-deactivator.php';
	Colorhub_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_colorhub' );
register_deactivation_hook( __FILE__, 'deactivate_colorhub' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-colorhub.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_colorhub() {

	$plugin = new Colorhub();
	$plugin->run();

}
run_colorhub();
