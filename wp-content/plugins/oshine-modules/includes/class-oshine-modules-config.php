<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Oshine_Modules_Config {

	private static $instance;
	private $colors;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
		$this->set_colors();
	}

	private function set_colors() {
		global $be_themes_data;
		$this->colors = array();
		$this->colors['tatsu_accent_color'] = !empty( $be_themes_data['color_scheme'] ) ? $be_themes_data['color_scheme'] : '#e0a240';
		$this->colors['tatsu_accent_twin_color'] = !empty( $be_themes_data['alt_bg_text_color'] ) ? $be_themes_data['alt_bg_text_color'] : '#fff';
		$this->colors['sec_bg'] = !empty( $be_themes_data['sec_bg'] ) ? $be_themes_data['sec_bg'] : '#fafbfd';
		$this->colors['sec_color'] = !empty( $be_themes_data['sec_color'] ) ? $be_themes_data['sec_color'] : '#7a7a7a';
		$this->colors['sec_border'] = !empty( $be_themes_data['sec_border'] ) ? $be_themes_data['sec_border'] : '#eeeeee';
		$this->colors['tert_bg'] = !empty( $be_themes_data['tert_bg'] ) ? $be_themes_data['tert_bg'] : '#fff';	 	
	}

	public function get_colors() {
		return $this->colors;
	}

}