<?php
/**
 *
 * @link              http://brandexponents.com
 * @since             1.0.0
 * @package           Typehub
 *
 * @wordpress-plugin
 * Plugin Name:       Type Hub
 * Plugin URI:        http://brandexponents.com
 * Description:       Typehub lets you take complete control over the typography of your website.
 * Version:           2.0.6
 * Author:            Brand Exponents
 * Author URI:        http://brandexponents.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       typehub
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
define( 'TYPEHUB_VERSION', '2.0.6' );

if( !defined( 'TYPEHUB_PLUGIN_URL' ) ) {
	define( 'TYPEHUB_PLUGIN_URL', plugins_url( '', __FILE__ ) );
}
if( !defined( 'TYPEHUB_PLUGIN_DIR' ) ) {
	define( 'TYPEHUB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-typehub-activator.php
 */
function activate_typehub() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-typehub-activator.php';
	Typehub_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-typehub-deactivator.php
 */
function deactivate_typehub() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-typehub-deactivator.php';
	Typehub_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_typehub' );
register_deactivation_hook( __FILE__, 'deactivate_typehub' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-typehub.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_typehub() {

	$plugin = new Typehub();
	$plugin->run();

}
run_typehub();
