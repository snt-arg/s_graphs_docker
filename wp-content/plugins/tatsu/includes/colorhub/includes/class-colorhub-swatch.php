<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Colorhub_Swatch {

    private $swatches;
    private $data;

	public function __construct() {
        $this->data = get_option( 'colorhub_data', array(
            'swatches' => array(),
            'options' => array(),
            'values' => array()
        ));
        $this->swatches = $this->data['swatches'];
    }

    public function get_swatch( $id ) {
        $swatches = $this->get_swatches();
        if( array_key_exists( $id, $swatches ) ) {
            return $swatches[$id];
        } else {
            return false;
        }
    }

    public function get_swatches() {  
        $predefined_swatches = Colorhub_Swatch_Config::getInstance()->get_swatches();
        return array_merge( $predefined_swatches, $this->swatches );
    }
    
    
}