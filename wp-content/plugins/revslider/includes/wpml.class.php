<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */
 
if(!defined('ABSPATH')) exit();

class RevSliderWpml extends RevSliderFunctions {
	
	private $cur_lang;
	
	/**
	 * load the wpml filters ect.
	 **/
	public function __construct(){
		add_filter('revslider_get_posts_by_category', array($this, 'translate_category_lang'), 10, 2);
		add_filter('revslider_get_parent_slides_pre', array($this, 'change_lang'), 10, 4);
		add_filter('revslider_get_parent_slides_post', array($this, 'change_lang_to_orig'), 10, 4);
		
		add_action('revslider_header_content', array($this, 'add_javascript_language'));
	}
	
	
	/**
	 * true / false if the wpml plugin exists
	 */
	public function wpml_exists(){
		return did_action('wpml_loaded');
	}
	
	
	/**
	 * valdiate that wpml exists
	 */
	public function validateWpmlExists(){
		if(!$this->wpml_exists()){
			$this->throw_error(__('The WPML plugin is not activated', 'revslider'));
		}
	}
	
	
	/**
	 * get languages array
	 */
	public function getArrLanguages($get_all = true){
		$this->validateWpmlExists();
		
		$langs		= apply_filters('wpml_active_languages', array());
		$response	= array();
		
		if($get_all == true){
			$response['all'] = __('All Languages', 'revslider');
		}
		
		foreach($langs as $code => $lang){
			$name			 = $lang['native_name'];
			$response[$code] = $name;
		}
		
		return $response;
	}
	
	
	/**
	 * get assoc array of lang codes
	 */
	public function getArrLangCodes($get_all = true){
		$codes = array();
		
		if($get_all == true){
			$codes['all'] = 'all';
		}
		
		$this->validateWpmlExists();
		$langs = apply_filters('wpml_active_languages', array());
		
		foreach($langs as $code => $arr){
			$codes[$code] = $code;
		}
		
		return $codes;
	}
	
	
	/**
	 * check if all languages exists in the given langs array
	 */
	public function isAllLangsInArray($codes){
		$all_codes	= $this->getArrLangCodes();
		$diff		= array_diff($all_codes, $codes);
		return empty($diff);
	}
	
	
	/**
	 * get flag url
	 */
	public function getFlagUrl($code){
		
		$this->validateWpmlExists();
		
		if(empty($code) || $code == 'all'){
            //$url = RS_PLUGIN_URL.'admin/assets/images/icon-all.png'; // NEW: ICL_PLUGIN_URL . '/res/img/icon16.png';
            $url = ICL_PLUGIN_URL . '/res/img/icon16.png';
        }else{
            $active_languages = apply_filters('wpml_active_languages', array());
            $url = isset($active_languages[$code]['country_flag_url']) ? $active_languages[$code]['country_flag_url'] : null;
        }
		
		//default: show all
		if(empty($url)){
			//$url = RS_PLUGIN_URL.'admin/assets/images/icon-all.png';
			$url = ICL_PLUGIN_URL . '/res/img/icon16.png';
		}
		
		return $url;
	}
	
	
	/**
	 * get language title by code
	 */
	public function getLangTitle($code){
		if($code == 'all'){
			return(__('All Languages', 'revslider'));
		}else{
			$def = apply_filters('wpml_default_language', null);
			return apply_filters('wpml_translated_language_name', '', $code, $def);
		}
	}
	
	
	/**
	 * get current language
	 */
	public function getCurrentLang(){
		$this->validateWpmlExists();
		
		return (is_admin()) ? apply_filters('wpml_default_language', null) : apply_filters('wpml_current_language', null);
	}
	
	
	/**
	 * was before in RevSliderFunctions::get_posts_by_category();
	 **/
	public function translate_category_lang($data, $type){
		$cat_id = $this->get_val($data, 'cat_id');
		$cat_id	= (strpos($cat_id, ',') !== false) ? explode(',', $cat_id) : array($cat_id);
		
		if($this->wpml_exists()){ //translate categories to languages
			$newcat = array();
			foreach($cat_id as $id){
				$newcat[] = apply_filters('wpml_object_id', $id, 'category', true);
			}
			$data['cat_id'] = implode(',', $newcat);
		}
		
		return $data;
	}
	
	
	/**
	 * switch the language if WPML is used in Slider
	 **/
	public function change_lang($lang, $published, $gal_ids, $slider){
		if($this->wpml_exists() && $slider->get_param('use_wpml', 'off') == 'on'){
			$this->cur_lang = apply_filters('wpml_current_language', null);
			do_action('wpml_switch_language', $lang);
		}
	}
	
	
	/**
	 * switch the language back to original, if WPML is used in Slider
	 **/
	public function change_lang_to_orig($lang, $published, $gal_ids, $slider){
		if($this->wpml_exists() && $slider->get_param(array('general', 'useWPML'), false) == true){ //switch language back
			do_action('wpml_switch_language', $this->cur_lang);
		}
	}
	
	
	/**
	 * modify slider language
	 * @before: RevSliderOutput::setLang()
	 */
	public function get_language($use_wpml, $slider){
		$lang = ($this->wpml_exists() && $use_wpml == true) ? ICL_LANGUAGE_CODE : 'all';
		
		return $lang;
	}
	
	
	public function get_slider_language($slider){
		$use_wmpl = $slider->get_param(array('general', 'useWPML'), false);
		
		return $this->get_language($use_wmpl, $slider);
	}
	
	/**
	 * add languages as javascript object to the RevSlider BackEnd Header
	 **/
	public function add_javascript_language($rsad){
		if(!$this->wpml_exists()) return '';
		
		$langs = $this->getArrLanguages();
		
		$use_langs = array();
		foreach($langs as $code => $lang){
			$use_langs[$code] = array(
				'title' => $lang,
				'image'	=> $this->getFlagUrl($code)
			);
		}
		echo '<script>';
		echo 'var RS_WPML_LANGS = JSON.parse(\''.json_encode($use_langs).'\');';
		echo '</script>';
	}
}

global $rs_wmpl;
$rs_wmpl = new RevSliderWpml();

/**
 * old classname extends new one (old classnames will be obsolete soon)
 * @since: 5.0
 **/
class UniteWpmlRev extends RevSliderWpml {}