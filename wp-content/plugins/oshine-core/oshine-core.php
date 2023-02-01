<?php
/**
 * Plugin Name: Oshine Core
 * Description: The plugin handles the demo import functionality to make it easy to get started with the theme. 
 * Plugin URI: http://brandexponents.com
 * Author: brandexponents team
 * Author URI: http://brandexponents.com
 * Version: 1.5.6
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: be-functions
 */
defined( 'ABSPATH' ) or exit;

define( 'BE_URL', plugins_url('', __FILE__) );
define( 'BE_PATH', dirname(__FILE__) );

require_once BE_PATH . '/inc/importer/importer/BEImporter.php'; 
require_once BE_PATH . '/inc/importer/init.php';
require_once BE_PATH . '/inc/BECore.php';

/*
 *
 */
function be_init() {
    global $BECore;
    $BECore               = new BECore();
    $BECore['path']       = realpath( plugin_dir_path( __FILE__ ) ). DIRECTORY_SEPARATOR;
    $BECore['url']        = plugin_dir_url( __FILE__ );
    $BECore['version']    = '1.5.6';
    $BECore['BEThemeDemoImporter'] = new BEThemeDemoImporter();
    apply_filters( 'be/config', $BECore );
    $BECore->run();
}
add_action( 'init', 'be_init', 10, 1 );


function be_stat_display() {
    require_once BE_PATH . '/inc/system-status.php';
    return BE_system_status_tpl();
}
add_action( 'be_systatus_tpl', 'be_stat_display', 10, 1 );

require BE_PATH. '/plugin-update-checker/plugin-update-checker.php';
$oshine_modules_update_checker = new PluginUpdateChecker_3_1 (
    'https://brandexponents.com/wp/wp-content/uploads/oshine-core.json',
    __FILE__,
    'oshine-core'
);