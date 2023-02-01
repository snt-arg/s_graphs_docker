<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */
 
if(!defined('ABSPATH')) exit();

/**
 * backwards compatibility prior 6.0.0 code
 * @START
 **/

class RevSliderBase {
	
	public static function check_file_in_zip($d_path, $image, $alias, $alreadyImported = false){
		$f = RevSliderGlobals::instance()->get('RevSliderFunctions');
		
		return $f->check_file_in_zip($d_path, $image, $alias, $alreadyImported, $add_path = false);
	}
}

class RevSliderFunctionsWP {
	public static function getImageUrlFromPath($url){
		$f = RevSliderGlobals::instance()->get('RevSliderFunctions');
		return $f->get_image_url_from_path($url);
	}
	
	public static function get_image_id_by_url($image_url){
		$f = RevSliderGlobals::instance()->get('RevSliderFunctions');
		return $f->get_image_id_by_url($image_url);
	}
}

class RevSliderOperations {
	public function getGeneralSettingsValues(){
		$f = RevSliderGlobals::instance()->get('RevSliderFunctions');
		return $f->get_global_settings();
	}
}

class RevSlider extends RevSliderSlider {
	public function __construct(){
		//echo '<!-- Slider Revolution Notice: Please do not use the class "RevSlider" anymore, use "RevSliderSlider" instead -->'."\n";
	}
}

class UniteFunctionsRev extends RevSliderFunctions {}

if(!function_exists('set_revslider_as_theme')){
	function set_revslider_as_theme(){
	}
}

/**
 * backwards compatibility prior 6.0.0 code
 * @END
 **/