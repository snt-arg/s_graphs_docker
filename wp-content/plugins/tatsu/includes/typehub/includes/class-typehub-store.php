<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Typehub_Store {

    private $store;
    private $data;
    
    public function __construct() {
        $this->store = array();
        $this->data = get_option( 'typehub_data', array(
            'font_schemes' => array(),
            'values' => array(),
            'settings' => array(),
            'custom' => array()
        ));	
    }

    public function get_store() {
         
        $this->store['fontSchemes'] = $this->get_fonts();
        $this->store['optionConfig'] = $this->get_options();
        $this->store['savedValues'] = !empty( $this->data['values'] ) ? $this->data['values'] : array();
        $this->store['settings'] = !empty( $this->data['settings'] ) ? $this->data['settings'] : array();
        $this->store['custom'] =  !empty( $this->data['custom'] ) ? $this->data['custom'] : array();

        return $this->store;

    }

    public function get_fonts() {
        return Typehub_Font_Schemes::getInstance()->get_schemes();
    }

    public function get_options() {
        $predefined_options = Typehub_Options::getInstance()->get_options();
        $custom_options = array();
        // CUSTOM OPTIONS feature moved to a later update.
        if( !empty( $this->data['custom']['options'] ) ) {
            $custom_options = $this->data['custom']['options'];
            return array_merge( $predefined_options, $custom_options );
        }
        return $predefined_options;
    }
    
    public function ajax_save() {
        check_ajax_referer( 'typehub-security', 'security' );

        if( !array_key_exists( 'store', $_POST ) ) {
            echo 'failure';
            wp_die();
        }

        $store = json_decode( stripslashes( $_POST['store'] ), true );
        $data['fontSchemes'] = ( array_key_exists( 'fontSchemes', $store ) ) ? $store['fontSchemes'] : array();
        $data['savedValues'] = ( is_array( $store['initConfig']['savedValues'] ) ) ? $store['initConfig']['savedValues'] : array();
        $data['settings'] = is_array( $store['settings']) ? $store['settings'] : array();
        $data['custom'] = is_array( $store['custom']) ? $store['custom'] : array();
        $save_store = $this->save_store( $data );
        if( $save_store ) {
            echo 'success';
        } else {
            echo 'failure';
        }
        wp_die();
    }
    
    public function ajax_get_typekit_fonts() {

        check_ajax_referer( 'typehub-security', 'security' );

        if( !array_key_exists( 'typekitId', $_POST ) ) {
            echo 'failure';
            wp_die();
        }
        $typekit_data = typehub_get_typekit_data($_POST['typekitId']);
        if( empty( $typekit_data ) ){
            echo false;
        } else {
            echo json_encode( $typekit_data );
        }
        

        wp_die();
    }

    public function ajax_get_local_font_details(){

        check_ajax_referer( 'typehub-security', 'security' );
        
        $local_fonts = get_saved_fonts();

        echo json_encode($local_fonts);
        wp_die(); 
    }

    public function ajax_download_font(){

        check_ajax_referer( 'typehub-security', 'security' );
        
        if( !array_key_exists( 'fontName', $_POST ) ) {
            echo 'failure';
            wp_die();
        }
        $result = typehub_download_font_from_google( $_POST['fontName'] );
        echo $result;
        wp_die();
    }
    public function ajax_refresh_changes(){
        check_ajax_referer( 'typehub-security', 'security' );
        typehub_delete_unused_fonts();
        $saved_fonts = get_saved_fonts();
        foreach( $saved_fonts as $saved_font => $value ){
            typehub_write_css_link_to_file( $value );
        }
        echo 'success';
        wp_die();

    }

    public function ajax_sync_typekit( ){
        check_ajax_referer( 'typehub-security', 'security' );
        
        if( !array_key_exists( 'typekitId', $_POST ) ) {
            echo 'failure';
            wp_die();
        }
        $typekitId = $_POST['typekitId'];
        delete_transient( 'typehub_typekit_'.$typekitId );
        echo 1;
        wp_die();
    }

    private function ajax_add_custom_font_deprecated_old(){

        $filename = $_FILES["file"]["name"];
        $filebasename = basename($filename, '.zip');
        $temp_file = explode('(',$filebasename);
        $filebasename = trim(array_shift($temp_file));
        $filebasename = strtolower($filebasename);
        $upload_dir = wp_upload_dir();
        $typehub_font_dir = $upload_dir['basedir'] . '/'. 'typehub/custom/'. $filebasename .'/';
        $typehub_font_url = $upload_dir['baseurl'] . '/'. 'typehub/custom/'. $filebasename .'/styles.css';

        if( file_exists( $typehub_font_dir ) ){
            $result = array(
                'status' => 'file already exists'
            );
            echo json_encode($result);
            wp_die();
        }

        $upload = wp_upload_bits($filename, null, file_get_contents($_FILES["file"]["tmp_name"]));
        $access_type = get_filesystem_method();
        if( empty( $upload['error'] ) ){

            if( $access_type !== 'direct' ){
                $result = array(
                    'status' => 'write permission denied'
                );
                echo json_encode($result);
                wp_die();
            }

            global $wp_filesystem;
            if ( empty( $wp_filesystem ) ) {
                require_once ( ABSPATH.'/wp-admin/includes/file.php' );
                WP_Filesystem();
            }

            $zip_handle = unzip_file($upload['file'], $typehub_font_dir );

            if( !is_wp_error( $zip_handle ) ){

                $zip_content = list_files( $typehub_font_dir, 1 );
                $compatible_formats = array('.otf','.ttf','.woff','.woff2','.svg','.eot','.html','.css');
                $count = 0;
                foreach( $zip_content as $item){
                    foreach( $compatible_formats as $format ){
                        $endsWith = substr_compare( $item, $format, -strlen( $format ) ) === 0;
                        if($endsWith){
                            $count++;
                        }
                    }
                }

                if( $count === count($zip_content) ){
                    $result = array(
                        'status' => 'success',
                        'url'  => $typehub_font_url,
                        'name' => $filebasename
                    );
                    wp_delete_file($upload['file']);
                } else {
                    $result = array(
                        'status' => 'invalid_zip'
                    );
                    wp_delete_file($upload['file']);
                    $wp_filesystem->rmdir( $typehub_font_dir, true );
                }


            } else {
                $result = array(
                    'status' => 'failed',
                    'url'  => $typehub_font_url,
                    'name' => $filebasename
                );
            }

        } else {
            $result = array(
                'status' => 'failed'
            );
        }

        echo json_encode($result);
        wp_die();
    }

    public function ajax_add_custom_font() {
        check_ajax_referer( 'typehub-security', 'security' );

        $status = get_transient( 'tatsu_typehub_upload_processing' );
        if ( $status ) {
            echo wp_json_encode( array(
                'status' => 'Another upload process is currently under progress.',
            ) );
            wp_die();
        }

        set_transient( 'tatsu_typehub_upload_processing', true, 15 );

        if ( ! class_exists( 'ZipArchive' ) ) {
            $this->ajax_die( array(
                'status' => 'Please enable PHP Zip Extension.',
            ) );
        }

        if ( function_exists( 'current_user_can' ) && current_user_can( 'manage_options' ) && function_exists( 'wp_check_filetype' ) ) {
            $file = $_FILES['file'];
            $file_name = $file['name'];
            $filetype = wp_check_filetype( $file_name, array( 'zip' => 'application/zip' ) );
            if ( ! $filetype['ext'] || $filetype['ext'] != 'zip' || ! preg_match( '/^[a-zA-Z0-9\-]{1,40}\.zip$/', $file_name ) ) {
                $this->ajax_die( array(
                    'status' => 'invalid_zip',
                ) );
            }

            $upload_dir = wp_upload_dir();
            $filebasename = strtolower( basename( $file_name, '.zip' ) );
            $typehub_font_dir = $upload_dir['basedir'] . '/typehub/custom/' . $filebasename . '/';
            $typehub_font_url = $upload_dir['baseurl'] . '/typehub/custom/' . $filebasename . '/styles.css';

            if ( file_exists( $typehub_font_dir ) ) {
                $this->ajax_die( array(
                    'status' => 'file already exists',
                ) );
            }

            $compatible_formats = array(
                'otf'   => 'font/otf',
                'ttf'   => 'font/ttf',
                'woff'  => 'font/woff',
                'woff2' => 'font/woff2',
                'svg'   => 'image/svg+xml',
                'eot'   => 'font/eot',
                'html'  => 'text/html',
                'css'   => 'text/css'
            );
            $invalidfile = false;

            $zip = new ZipArchive();
            $zopen = $zip->open( $file['tmp_name'], ZipArchive::CHECKCONS );

            if ( true !== $zopen ) {
                $this->ajax_die( array(
                    'status' => 'invalid_zip',
                ) );
            }

            $total_size = 0;
            for ( $i = 0; $i < $zip->numFiles; $i++ ) {
                $file_name = $zip->getNameIndex( $i );
                $file_stats = $zip->statIndex( $i );
                $total_size += $file_stats['size'];
                $filetype = wp_check_filetype( $file_name, $compatible_formats );
                if ( ! $filetype['ext'] ) {
                    $invalidfile = true;
                    break;
                }
            }
        
            $zip->close();

            $allowed_size = 5 * 1024; // 5 MB max allowed
            $total_size = (int) ( $total_size / 1024 );

            if ( $total_size > $allowed_size ) {
                $this->ajax_die( array(
                    'status' => 'Zip size must be below 5 MB',
                ) );
            }

            if ( $invalidfile ) {
                $this->ajax_die( array(
                    'status' => 'invalid_zip',
                ) );
            }
            
            global $wp_filesystem;
            if ( empty( $wp_filesystem ) ) {
                require_once ( ABSPATH.'/wp-admin/includes/file.php' );
                WP_Filesystem();
            }

            $upload = wp_upload_bits( $file['name'], null, file_get_contents( $file['tmp_name'] ) );
            if ( ! empty( $upload['error'] ) ) {
                $this->ajax_die( array(
                    'status' => $upload['error'],
                ) );
            }

            $access_type = get_filesystem_method();
            if ( 'direct' !== $access_type ) {
                $this->ajax_die( array(
                    'status' => 'write permission denied',
                ) );
            }

            $zip_handle = unzip_file( $upload['file'], $typehub_font_dir );
            wp_delete_file( $upload['file'] );

            $result = array(
                'url'  => $typehub_font_url,
                'name' => $filebasename
            );
            
            if ( ! is_wp_error( $zip_handle ) ) {
                $result['status'] = 'success';
            } else {
                $result['status'] = 'failed';
                $wp_filesystem->rmdir( $typehub_font_dir, true );
            }
        } else {
            $result = array(
                'status' => 'Unauthorized access!'
            );
        }

        $this->ajax_die( $result );
    }

    public function ajax_remove_custom_font() {
        check_ajax_referer( 'typehub-security', 'security' );
        if ( ! isset( $_POST['name'] ) ) {
            echo 'failure';
            wp_die();
        }
        $name = sanitize_text_field( wp_unslash( $_POST['name'] ) );

        global $wp_filesystem;
        if ( empty( $wp_filesystem ) ) {
            require_once ( ABSPATH.'/wp-admin/includes/file.php' );
            WP_Filesystem();
        }

        $upload_dir = wp_upload_dir();
        $typehub_font_dir = $upload_dir['basedir'] . '/typehub/custom/' . $name . '/';

        $wp_filesystem->rmdir( $typehub_font_dir, true );
        echo 'success';
        wp_die();
    }

    public function save_store( $data ) {
        
        $this->data['font_schemes'] = $data['fontSchemes'];
        $this->data['values'] = $data['savedValues'];
        $this->data['settings'] = $data['settings'];
        $this->data['custom'] = $data['custom'];

        return update_option( 'typehub_data', $this->data );
    }
    
    public function ajax_die( $args ) {
        delete_transient( 'tatsu_typehub_upload_processing' );
        
        echo wp_json_encode( $args );
        wp_die();
    }
}