<?php
/**
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

/**
 * The main challange here is defining a dynamic dl link
 * for $updade_plugins_transient->response[ $plugin_slug ]->package;
 */


if( ! class_exists('Plugin_Upgrader') ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
}



if( ! class_exists('Axiom_Plugin_Updater') ) {

    class Axiom_Plugin_Updater extends Plugin_Upgrader {

        /**
         * Plugin directory and main file name (e.g myplugin/myplugin.php)
         *
         * @var string
         */
        public $plugin_slug;

        /**
         * Plugin slug
         *
         * @var string
         */
        public $slug;

        /**
         * Installable update file name
         *
         * @var string
         */
        public $installable_plugin_zip_file = '';


        /**
         * Set plugin info and add essential hooks
         *
         * @param string $plugin_slug                 The name of directory and main file name of plugin
         * @param string $slug                        Then slug name of plugin (optional)
         * @param string $installable_plugin_zip_file Installable update file name. Default is {plugin_slug}-installable.zip
         */
        public function __construct( $plugin_slug, $slug = '', $installable_plugin_zip_file = '' ){

            parent::__construct();

            $this->plugin_slug = $plugin_slug;
            $parts = explode('/', $plugin_slug);

            $this->slug = empty( $slug ) ? str_replace('.php', '', $parts[1] ) : $slug;
            $this->installable_plugin_zip_file = empty( $installable_plugin_zip_file ) ? $this->slug . '-installable.zip' : $installable_plugin_zip_file;

            add_action( 'admin_head', array( $this, 'plugin_update_rows' ) , 12 );
            // a custom hook that fires on update.php page while upgrading the packages
            add_action( "update-custom_{$this->slug}-upgrade", array( $this, 'custom_upgrade_plugin' ) );

            // add_action( "upgrader_process_complete", array( $this, "on_bulk_upgrader_process_complete" ), 10, 2 );

            add_filter( 'site_transient_update_plugins', array( $this, 'define_package_for_plugin_update_transient' ) );
        }

        /**
         * Inject package address in update_plugins transient
         *
         * @param  object $transient update_plugins transient
         * @return object            update_plugins transient
         */
        function define_package_for_plugin_update_transient( $transient ){

            if( isset( $transient->response[ $this->plugin_slug ] ) ){
                $r = $transient->response[ $this->plugin_slug ];

                //if( empty( $r->package ) || 'temp_package' == $r->package ){
                    $dl_url = $this->get_downloaded_package_url();
                    if( ! is_wp_error( $dl_url ) ){
                        $r->package = $dl_url;
                    } else {
                        $r->package = '';
                    }
                    $transient->response[ $this->plugin_slug ] = $r;
                //}
            }

            return $transient;
        }

        /**
         * Retrieves custom API link for downloading the package
         *
         * @return string   The API URI
         */
        public function get_download_api() {
            return 'http://support.averta.net/en/api/?branch=envato&group=items&cat=download-purchase';
        }

        /**
         * Fires on the page wp-admin/update.php?{$this->slug}-upgrade page
         *
         * @return void
         */
        function custom_upgrade_plugin() {
            // skip if auto audate was disabled
            if( apply_filters( $this->slug.'_disable_auto_update', 0 ) )
                return;

            $plugin = isset($_REQUEST['plugin']) ? trim($_REQUEST['plugin']) : '';

            if ( ! current_user_can('update_plugins') )
                wp_die(__('You do not have sufficient permissions to update plugins for this site.'));

            check_admin_referer('upgrade-plugin_' . $plugin);

            $title = __('Update Plugin');
            $parent_file = 'plugins.php';
            $submenu_file = 'plugins.php';

            wp_enqueue_script( 'updates' );

            require_once(ABSPATH . 'wp-admin/admin-header.php');

            $nonce = 'upgrade-plugin_' . $plugin;
            $url   = 'update.php?action=upgrade-plugin&plugin=' . urlencode( $plugin );

            if ( $this->update_plugin() ){
                do_action( $plugin . "_updated" );
            }

            // return to lugins page link
            echo '<a href="' . self_admin_url('plugins.php') . '" title="' . esc_attr__('Go to plugins page') . '" target="_parent">' . __('Return to Plugins page') . '</a>';

            include( ABSPATH . 'wp-admin/admin-footer.php' );
        }



        /**
         * Get download url from API
         * @param  string $username      Envato username
         * @param  string $purchase_code Envato purchase code
         * @param  string $token         The user token
         * @return string                The downlaod URL
         */
        public function get_download_url ( $username, $purchase_code, $token ) {

            if( $custom_download = apply_filters( 'axiom_plugin_updater_custom_package_download_url', 0 ) )
                return $custom_download;

            if( empty( $username ) || empty( $purchase_code ) || empty( $token ) ) {
                return new WP_Error( 'no_credentials',
                                        apply_filters( 'axiom_plugin_updater_login_info_required',
                                            __( 'Envato username, API key and your item purchase code are required for downloading updates from Envato marketplace.' ) , $this->slug
                                        )
                                    );
            }

            global $wp_version;

            $api_url = $this->get_download_api();

            $args = array(
                'user-agent' => 'WordPress/'.$wp_version.'; ' . get_site_url(),
                'timeout'    => ( ( defined('DOING_CRON') && DOING_CRON ) ? 30 : 3),
                'body' => array(
                    'action'    => 'token',
                    'key'       => $purchase_code,
                    'user'      => $username,
                    'token'     => $token,
                    'url'       => get_site_url()
                )
            );

            $request = wp_remote_post( $api_url, $args );

            if ( is_wp_error( $request ) || wp_remote_retrieve_response_code($request) !== 200 ) {

                $error_message = isset( $result['error'] ) ? $result['error'].'. ' : '';
                $error_code    = isset( $result['code'] ) ? $result['code']. '. ' : '';

                return new WP_Error( 'no_credentials',
                    apply_filters( 'axiom_plugin_updater_failed_connect_api',
                        __( 'Faild to connect to download API ..') . $error_message . $error_code ,
                        $this->slug, $error_message , $error_code
                    )
                );
            }
            $json = $request['body'];
            $result = json_decode( $request['body'], true );

            if( ! ( isset( $result['download_url'] ) && ! empty( $result['download_url'] ) ) ) {
                $result         = json_decode( $request['body'], true );
                $error_message  = isset( $result['msg'] )  ? $result['msg'].'. '   : '';
                $error_code     = isset( $result['code'] ) ? $result['code']. '. ' : '';

                // Envato API error ..
                return new WP_Error( 'no_credentials',
                    apply_filters( 'axiom_plugin_updater_api_error',
                        __( $json . 'Error on connecting to download API ..') . $error_message . ' [' . $error_code . ']' ,
                        $this->slug, $error_message , $error_code
                    )
                );
            }

            return $result['download_url'];
        }


        /**
         * Download installable file from custom download API
         */
        protected function get_downloaded_package_url() {

            /**
             * Initialize the WP_Filesystem
             */
            global $wp_filesystem;
            if ( empty( $wp_filesystem ) ) {
                require_once ( ABSPATH.'/wp-admin/includes/file.php' );
                WP_Filesystem();
            }

            //$this->skin->feedback('download_item_package');

            $res = $this->fs_connect( array( WP_CONTENT_DIR ) );

            if ( ! $res ) {
                return new WP_Error('no_credentials', __( "Error! Failed to connect filesystem" ) );
            }

            $username       = msp_get_setting( 'username'      , 'msp_envato_license' );
            $purchase_code  = msp_get_setting( 'purchase_code' , 'msp_envato_license' );
            $token          = msp_get_setting( 'token'         , 'msp_envato_license' );


            $the_download_url = $this->get_download_url( $username, $purchase_code, $token );

            return $the_download_url;
        }


        /**
         * Download a package.
         *
         * @param string $package The URI of the package. If this is the full path to an
         *                        existing local file, it will be returned untouched.
         * @return string|WP_Error The full path to the downloaded package file, or a {@see WP_Error} object.
         */
        public function download_package( $package, $check_signatures = false, $hook_extra = array() ) {
            // we will override package file with our own package
            $package = $this->get_downloaded_package_url();

            if( is_wp_error( $package ) )
                return $package;

            return parent::download_package( $package, $check_signatures );
        }

        /**
         * Initialize the upgrade strings.
         *
         * @since 2.8.0
         */
        public function upgrade_strings() {

            parent::upgrade_strings();

            $this->strings['no_package'] = sprintf(
                __('Please (re)activate your license in %sMaster Slider > setting page%s. Valid license is required in order to update this plugin.'),
                '<a href="'.admin_url( 'admin.php?page='. $this->slug.'-setting' ).'">', '</a>'
            );
            $this->strings['downloading_package']   = __( 'Downloading package ...' );
            $this->strings['download_item_package'] = __( 'Downloading package ...' );
        }

        /**
         * Upgrade a plugin.
         *
         * @param string $plugin The basename path to the main plugin file.
         *
         * @return bool|WP_Error True if the upgrade was successful, false or a {@see WP_Error} object otherwise.
         */
        public function update_plugin() {
            /**
             * Initialize the WP_Filesystem
             */
            global $wp_filesystem;
            if ( empty( $wp_filesystem ) ) {
                require_once ( ABSPATH.'/wp-admin/includes/file.php' );
                WP_Filesystem();
            }

            $plugin  = $this->plugin_slug;

            $this->init();
            $this->upgrade_strings();

            $current = get_site_transient( 'update_plugins' );
            if ( !isset( $current->response[ $plugin ] ) ) {
                $this->skin->before();
                $this->skin->set_result(false);
                $this->skin->error('up_to_date');
                $this->skin->after();
                return false;
            }

            // Get the URL to the zip file
            $r = $current->response[ $plugin ];

            add_filter('upgrader_pre_install', array($this, 'deactivate_plugin_before_upgrade'), 10, 2);
            add_filter('upgrader_clear_destination', array($this, 'delete_old_plugin'), 10, 4);
            //'source_selection' => array($this, 'source_selection'), //there's a trac ticket to move up the directory for zip's which are made a bit differently, useful for non-.org plugins.

            $this->run( array(
                'package' => $r->package,
                'destination' => WP_PLUGIN_DIR,
                'clear_destination' => true,
                'clear_working' => true,
                'hook_extra' => array(
                    'plugin' => $plugin,
                    'type' => 'plugin',
                    'action' => 'update',
                ),
            ) );

            // Cleanup our hooks, in case something else does a upgrade on this connection.
            remove_filter( 'upgrader_pre_install'       , array( $this, 'deactivate_plugin_before_upgrade') );
            remove_filter( 'upgrader_clear_destination' , array( $this, 'delete_old_plugin') );

            if ( ! $this->result || is_wp_error( $this->result ) )
                return $this->result;

            // Force refresh of plugin update information
            delete_site_transient( 'update_plugins' );
            wp_cache_delete( 'plugins', 'plugins' );

            return true;
        }

        /**
         * Add hooks for modifying the plugin row context
         */
        public function plugin_update_rows() {

            if( apply_filters( $this->slug.'_disable_auto_update', 0 ) )
                return;

            remove_action( "after_plugin_row_{$this->plugin_slug}", 'wp_plugin_update_row', 10, 2 );
            add_action( "after_plugin_row_{$this->plugin_slug}", array( $this, 'plugin_update_row' ), 10, 2 );
        }

        /**
         * Override the plugin row context
         *
         * @param  string $file        The plugin file path
         * @param  array $plugin_data  Plugin information
         *
         * @return void
         */
        public function plugin_update_row( $file, $plugin_data ) {

            $current = get_site_transient( 'update_plugins' );

            if ( ! isset( $current->response[ $file ] ) )
                return false;

            $r = $current->response[ $file ];

            // if license is already actived (token is set), add temp download link
            $r->package = msp_get_setting('token', 'msp_envato_license') ? 'temp_package' : '';

            $plugins_allowedtags = array(
                'a'     => array(
                    'href'  => array(),'title' => array()
                ),
                'abbr'  => array(
                    'title' => array()
                ),
                'acronym' => array(
                    'title' => array()
                ),
                'code'  => array(),
                'em'    => array(),
                'strong'=> array()
            );

            $plugin_name    = wp_kses( $plugin_data['Name'], $plugins_allowedtags );
            $details_url    = self_admin_url('plugin-install.php?tab=plugin-information&plugin=' . $r->slug . '&section=changelog&TB_iframe=true&width=600&height=800');
            $wp_list_table  = _get_list_table('WP_Plugins_List_Table');

            if ( is_network_admin() || !is_multisite() ) {
                if ( is_network_admin() ) {
                    $active_class = is_plugin_active_for_network( $file ) ? ' active' : '';
                } else {
                    $active_class = is_plugin_active( $file ) ? ' active' : '';
                }

                echo '<tr class="plugin-update-tr' . $active_class . '"><td colspan="' . $wp_list_table->get_column_count() . '" class="plugin-update colspanchange"><div class="update-message notice inline notice-warning notice-alt"><p>';

                $username       = msp_get_setting( 'username'      , 'msp_envato_license' );
                $purchase_code  = msp_get_setting( 'purchase_code' , 'msp_envato_license' );
                $token          = msp_get_setting( 'token'         , 'msp_envato_license' );

                if ( ! current_user_can('update_plugins') ){
                    printf( __('There is a new version of %1$s available. <a href="%2$s" class="thickbox" title="%3$s">View version %4$s details</a>.'),
                            $plugin_name, esc_url($details_url), esc_attr($plugin_name), $r->new_version
                    );

                } else if ( ! get_option( 'masterslider_is_license_actived', 0) || empty( $username ) || empty( $purchase_code ) || empty( $token ) ){
                    printf(
                        __( 'There is a new version of %1$s available. <a href="%2$s" class="thickbox" title="%3$s">View version %4$s details</a>. <em>To receive automatic updates, license activation is required. Please visit %5$ssetting page%6$s to activate the license.</em>' ) . ' %7$s',
                        $plugin_name,
                        esc_url( $details_url ),
                        esc_attr( $plugin_name ),
                        $r->new_version,
                        '<a href="'.admin_url( 'admin.php?page='. $this->slug.'-setting' ).'">', '</a>',
                        '<a href="http://docs.averta.net/display/mswpdoc/Master+Slider+Bundled+in+a+Theme" target="_blank">'. __( 'Got Master Slider in theme?' ) . '</a>'
                    );

                } else {
                    printf( __('There is a new version of %1$s available. <a href="%2$s" class="thickbox" title="%3$s">View version %4$s details</a> or <a href="%5$s">update now</a>.'),
                           $plugin_name, esc_url($details_url), esc_attr($plugin_name), $r->new_version,
                           wp_nonce_url( self_admin_url("update.php?action={$this->slug}-upgrade&plugin=") . $file, 'upgrade-plugin_' . $file )
                    );
                }

                do_action( "in_plugin_update_message-{$file}", $plugin_data, $r );

                echo '</p></div></td></tr>';
            }
        }
    }


    new Axiom_Plugin_Updater( MSWP_AVERTA_BASE_NAME );
}
