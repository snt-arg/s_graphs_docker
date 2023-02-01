<?php
/**
 *
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2014 averta
*/

// no direct access allowed
if ( ! defined('ABSPATH') ) {
    die();
}


class Axiom_Plugin_Check_Update {
    /**
     * The plugin current version
     * @var string
     */
    public $current_version;

    /**
     * The plugin remote update path
     * @var string
     */
    public $update_path;

    /**
     * Plugin Slug (plugin_directory/plugin_file.php)
     * @var string
     */
    public $plugin_slug;

    /**
     * Plugin name (plugin_file)
     * @var string
     */
    public $slug;

    /**
     * The item name while requesting to update api
     * @var string
     */
    public $request_name;

    /**
     * The item ID in marketplace
     * @var string
     */
    public $plugin_id;


    /**
     * The item name while requesting to update api
     * @var string
     */
    public $plugin_file_path;

    /**
     * The item name while requesting to update api
     * @var string
     */
    public $banners;


    /**
     * Initialize a new instance of the WordPress Auto-Update class
     * @param string $current_version
     * @param string $update_path
     * @param string $plugin_slug
     * @param string $slug
     */
    function __construct( $current_version, $update_path, $plugin_slug, $slug, $item_request_name = '' ) {
        // Set the class public variables
        $this->current_version  = $current_version;
        $this->update_path      = $update_path;
        $this->plugin_slug      = $plugin_slug;
        $this->slug             = $slug;

        $this->request_name     = empty( $item_request_name ) ? $this->slug : $item_request_name;

        // define the alternative API for checking for updates
        add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_update') );

        // Define the alternative response for information checking
        add_filter( 'plugins_api', array( $this, 'check_info'), 10, 3 );
    }


    /**
     * Add our self-hosted autoupdate plugin to the filter transient
     *
     * @param $transient
     * @return object $ transient
     */
    public function check_update( $transient ) {

        if( apply_filters( 'masterslider_disable_automatic_update', 0 ) )
            return $transient;

        // Get the remote version
        $remote_version = $this->get_remote_version();

        // If a newer version is available, add the update info to update transient
        if ( version_compare( $this->current_version, $remote_version, '<' ) ) {
            $obj = new stdClass();
            $obj->slug      = $this->slug;
            $obj->plugin    = $this->plugin_slug;
            $obj->new_version = $remote_version;
            $obj->url       = '';
            $obj->package   = '';
            $transient->response[ $this->plugin_slug ] = $obj;
        } elseif ( isset( $transient->response[ $this->plugin_slug ] ) ) {
            unset( $transient->response[ $this->plugin_slug ] );
        }
        return $transient;
    }


    /**
     * Return the remote version
     * @return string $remote_version
     */
    public function get_remote_version() {
        global $wp_version;

        $theme_data = wp_get_theme();
        if( is_child_theme() ) {
            $theme_data = wp_get_theme( $theme_data->template );
        }

        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $all_plugins = get_plugins();
        if( ! isset( $all_plugins[ $this->plugin_slug ] ) || empty( $all_plugins[ $this->plugin_slug ] ) ){
            return;
        }

        $this_plugin = $all_plugins[ $this->plugin_slug ];
        if( ! is_array( $this_plugin ) ){
            $this_plugin = array();
        }
        $this_plugin['ID']        = $this->plugin_id;
        $this_plugin['Theme']     = $theme_data->Name;
        $this_plugin['Slug']      = $this->slug;
        $this_plugin['Activated'] = get_option( $this->slug . '_is_license_actived', 0);

        $request = wp_remote_post( $this->update_path, array(
                'user-agent' => 'WordPress/'.$wp_version.'; '. get_site_url(),
                'timeout'    => ( ( defined('DOING_CRON') && DOING_CRON ) ? 30 : 3),
                'body'       => array(
                    'cat'       => 'version-check',
                    'action'    => 'final',
                    'type'      => 'plugin',
                    'item-name' => $this->request_name,
                    'item-info' => $this_plugin
                )
            )
        );

        if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
            return $request['body'];
        }
        return false;
    }


    /**
     * Add our self-hosted description to the filter
     *
     * @param boolean $false
     * @param array $action
     * @param object $arg
     * @return bool|object
     */
    public function check_info( $false, $action, $arg ) {

        if( apply_filters( 'masterslider_disable_auto_update', 0 ) )
            return $false;

        if( ! isset( $arg->slug ) )
            return $false;

        if ( $arg->slug === $this->slug ) {
            $information = $this->get_remote_information();
            return apply_filters( 'axiom_pre_insert_plugin_info' . $this->slug , $information );
        }
        return $false;
    }


    /**
     * Get information about the remote version
     * @return bool|object
     */
    public function get_remote_information() {
        global $wp_version;

        $request = wp_remote_post( $this->update_path, array(
                'user-agent' => 'WordPress/'.$wp_version.'; '. get_site_url(),
                'body' => array(
                    'cat'       => 'info',
                    'action'    => 'details',
                    'item-name' => $this->request_name
                )
            )
        );

        if ( !is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {

            require_once ABSPATH . 'wp-admin/includes/plugin.php';
            $all_plugins = get_plugins();
            if( ! isset( $all_plugins[ $this->plugin_slug ] ) || empty( $all_plugins[ $this->plugin_slug ] ) ){
                return;
            }
            $plugin_info_data = $all_plugins[ $this->plugin_slug ];

            $info = maybe_unserialize( $request['body'] );
            $info->slug             = $this->slug;
            $info->plugin_name      = isset( $plugin_info_data['Name'] )      ? $plugin_info_data['Name']      : '';
            $info->author           = isset( $plugin_info_data['Author'] )    ? $plugin_info_data['Author']    : '';
            $info->homepage         = isset( $plugin_info_data['PluginURI'] ) ? $plugin_info_data['PluginURI'] : '';

            $info->banners['low']   = isset( $this->banners['low']  ) ? $this->banners['low']  : '';
            $info->banners['high']  = isset( $this->banners['high'] ) ? $this->banners['high'] : '';

            return $info;
        }

        return false;
    }
}
