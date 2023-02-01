<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Colorhub_Store {

    private $store;
    private $data;
    
    public function __construct() {
        $this->store = array();
        $this->data = get_option( 'colorhub_data', array(
            'swatches' => array(),
            'options' => array(),
            'values' => array(),
            'palettes' => array(),
        ));	
    }

    public function get_store() {         
        $this->store['swatches'] = $this->get_swatches();
        //$this->store['options'] = $this->get_options();
        //$this->store['values'] = $this->data['values'];
        $this->store['palettes'] = $this->get_palettes();

        return $this->store;
    }

    public function get_swatches() {
        $swatches = new Colorhub_Swatch;
        return $swatches->get_swatches();
    }

    public function get_palettes() {
        $palettes = new Colorhub_Palette;
        return $palettes->get_palettes();
    }

    public function get_options() {
        $predefined_options = Colorhub_Options::getInstance()->get_options();
        return array_merge( $predefined_options, $this->data['options'] );
    }    

    public function ajax_save() {
        check_ajax_referer( 'colorhub-security', 'security' );

        if( !array_key_exists( 'store', $_POST ) ) {
            echo 'failure';
            wp_die();
        }

        $store = json_decode( stripslashes( $_POST['store'] ) , true );
        $data['swatches'] = ( array_key_exists( 'swatches', $store ) ) ? $store['swatches'] : array();
        $data['palettes'] = ( array_key_exists( 'palettes', $store ) ) ? $store['palettes'] : array();

        $save_store = $this->save_store( $data );
        if( $save_store ) {
            echo 'true';
        } else {
            echo 'false';
        }
        wp_die();

    }
    
    public function save_store( $data ) {

        $this->store['swatches'] = $data['swatches'];
        $this->store['palettes'] = $data['palettes'];

        return update_option( 'colorhub_data', $this->store );
        
    }

}