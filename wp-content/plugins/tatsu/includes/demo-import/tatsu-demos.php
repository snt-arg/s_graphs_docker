<?php
/**
 * Plugin Name: Tatsu Demos
 * Description: The plugin handles the demo import functionality of Tatsu and makes it easy to get started with the theme. 
 * Plugin URI: http://brandexponents.com
 * Author: Brand Exponents
 * Author URI: http://brandexponents.com
 * Version: 1.0.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: tatsu-demos
 */
defined( 'ABSPATH' ) or exit;

define( 'TATSU_STANDALONE_DEMOS_URL', plugins_url('', __FILE__) );
define( 'TATSU_STANDALONE_DEMOS_PATH', dirname(__FILE__) );
define( 'TATSU_STANDALONE_DEMOS_VERSION','1.0.0');

require_once TATSU_STANDALONE_DEMOS_PATH . '/inc/importer/importer/class-tatsu-demos-importer.php'; 
require_once TATSU_STANDALONE_DEMOS_PATH . '/inc/importer/init.php';
require_once TATSU_STANDALONE_DEMOS_PATH . '/inc/class-tatsu-demos-core.php';

function tatsu_standalone_demos_admin_enqueue_scripts(){
    if ( ! function_exists( 'get_current_screen' ) ) { 
        require_once ABSPATH . '/wp-admin/includes/screen.php'; 
    } 
    $current_screen = get_current_screen();
    if ( ! in_array( $current_screen->base, [ 'toplevel_page_tatsu_settings', 'tatsu_page_tatsu_demo_import' ] ) ) {
        return;
    }
    wp_enqueue_script( 'clipboard', TATSU_STANDALONE_DEMOS_URL.'/admin-tpl/assets/js/clipboard.min.js', array( 'jquery' ), TATSU_STANDALONE_DEMOS_VERSION, true );

    wp_enqueue_script( 'image-picker',TATSU_STANDALONE_DEMOS_URL.'/admin-tpl/assets/js/image-picker.min.js', array( 'jquery' ), TATSU_STANDALONE_DEMOS_VERSION, true );

    wp_enqueue_script( 'notify', TATSU_STANDALONE_DEMOS_URL.'/admin-tpl/assets/js/notify.js', array( 'jquery' ), TATSU_STANDALONE_DEMOS_VERSION, true);

    wp_enqueue_script( 'be-tatsu-start-scripts', TATSU_STANDALONE_DEMOS_URL.'/admin-tpl/assets/js/start-page.js', array( 'jquery' ), TATSU_STANDALONE_DEMOS_VERSION, true );
    
    wp_localize_script(
        'be-tatsu-start-scripts',
        'tatsuAdminConfigStartPage',
        array(
            'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
            'nonce' => wp_create_nonce( 'wp_rest' ),
            'is_tatsu_authorized' => is_tatsu_authorized(),
            'is_tatsu_standalone'=> is_tatsu_standalone(),
            'redirectForLicense'=>admin_url( '?page=tatsu_settings'),
            'tatsu_pro_url'=>TATSU_PRO_URL
        )
    );

    wp_enqueue_style( 'be-admin-tabs', TATSU_STANDALONE_DEMOS_URL.'/admin-tpl/assets/stylesheets/start-page.css', TATSU_STANDALONE_DEMOS_VERSION, 'all' );

    wp_enqueue_style( 'image-picker-css', TATSU_STANDALONE_DEMOS_URL.'/admin-tpl/assets/stylesheets/image-picker.css',TATSU_STANDALONE_DEMOS_VERSION, 'all' );

    wp_enqueue_style( 'notify-metro-css', TATSU_STANDALONE_DEMOS_URL.'/admin-tpl/assets/stylesheets/notify-metro.css',TATSU_STANDALONE_DEMOS_VERSION, 'all' );
}
add_action( 'admin_enqueue_scripts', 'tatsu_standalone_demos_admin_enqueue_scripts' );
/*
 *
 */
function tatsu_standalone_demos_init() {
    global $TatsuDemosCore;
    $TatsuDemosCore               = new TatsuDemosCore();
    $TatsuDemosCore['pluginName'] = 'Tatsu';
    $TatsuDemosCore['path']       = realpath( plugin_dir_path( __FILE__ ) ). DIRECTORY_SEPARATOR;
    $TatsuDemosCore['url']        = plugin_dir_url( __FILE__ );
    $TatsuDemosCore['version']    = '1.0.0';
    $TatsuDemosCore['TatsuDemoImporter'] = new TatsuDemoImporter();
    apply_filters( 'tatsu_standalone_demos_config', $TatsuDemosCore );
    $TatsuDemosCore->run();
}
//Demo Import
if(is_tatsu_standalone()){
add_action( 'init', 'tatsu_standalone_demos_init', 10, 1 );
}


function tatsu_standalone_demos_stat_display() {
    require_once TATSU_STANDALONE_DEMOS_PATH . '/inc/system-status.php';
    return tatsu_demos_system_status_tpl();
}
add_action( 'tatsu_systatus_tpl', 'tatsu_standalone_demos_stat_display', 10, 1 );
