<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/ 
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

global $rs_double_jquery_script;
global $rs_material_icons_css;
global $rs_material_icons_css_parsed;
global $rs_slider_serial;
global $rs_ids_collection;
global $rs_preview_mode;
global $rs_js_collection;
global $rs_css_collection;
global $rs_revicons;
global $rs_youtube_api_loaded;

$rs_double_jquery_script = false;
$rs_material_icons_css = false;
$rs_material_icons_css_parsed = false;
$rs_slider_serial = 0;
$rs_ids_collection = array();
$rs_preview_mode = false;
$rs_js_collection = array('revapi' => array(), 'js' => array(), 'minimal' => '');
$rs_css_collection = array();
$rs_revicons = false;
$rs_youtube_api_loaded = false;

class RevSliderOutput extends RevSliderFunctions {
	
	//START transfered from the layer add process and some of these are only filled if putSlides() is called
	public $zIndex			= 1;
	//public $in_class_usage	= array();
	public $enabled_sizes	= array();
	public $adv_resp_sizes	= array();
	public $icon_sets		= array();//RevSliderBase::set_icon_sets(array());
	public $container_mode	= '';
	public $row_zindex		= 0;
	//END transfered from the layer add process and some of these are only filled if putSlides() is called
	
	/**
	 * variables for error handling, to know if we need to close the div or not
	 **/
	public $rs_module_wrap_open = false;
	public $rs_module_open = false;
	public $rs_module_wrap_closed = false;
	public $rs_module_closed = false;
	public $rs_custom_navigation_css = '';
	
	/**
	 * ShortCode based Global Values 
	 * usage : Is Module to emebed as Modal ?  
	 * sc_layout : overwrite original module Layout, 
	 * offset : padding and margin of the wrapping Module
	 * modal : Modal Settings
	 **/
	public $usage = '';
	public $sc_layout = '';
	public $offset = '';
	public $modal = '';	
	public $ajax_loaded = false;
	
	/**
	 * if set to true, needed js variables for frontend actions will be added
	 **/
	public $frontend_action = false;
	
	/**
	 * holds the layer depth, used for having a more structured HTML
	 **/
	public $layer_depth = '';
	
	/**
	 * holds the current slider
	 **/
	public $slider;
	
	/**
	 * holds the current slide
	 **/
	private $slide;
	
	/**
	 * holds the current slides of the slider
	 **/
	private $slides;
	
	/**
	 * holds the current layers of a slide
	 **/
	private $layers;
	
	/**
	 * holds the current used layer
	 **/
	private $layer;
	
	/**
	 * holds the current slider id
	 **/
	private $slider_id = 0;
	
	/**
	 * holds the current layers of a slide
	 * @before: RevSliderOutput::$slideID
	 **/
	private $slide_id;
	
	/**
	 * holds the current layer unique id
	 **/
	private $uid;
	
	/**
	 * if set, these will be pushed inside the Slider
	 * @before: RevSliderOutput::$gal_ids
	 **/
	public $gallery_ids = array();
	
	/**
	 * holds all the hover css in ids of the layers
	 **/
	public $hover_css = array();
	
	/**
	 * holds all the classes, that are already used in layers
	 * @before: RevSliderOutput::$class_include
	 **/
	public $classes = array();
	
	/**
	 * holds all additions to the current layer getting printed
	 **/
	public $layer_additions = array();
	
	/**
	 * holds if static layers should be done
	 **/
	private $do_static = true;
	
	/**
	 * if set, the Slider will only be added if the current page/post meets what is into this variable
	 * @before: RevSliderOutput::$putIn
	 **/
	public $add_to = '';
	
	/**
	 * if set to true we are in preview mode
	 * @before: RevSliderOutput::$previewMode
	 **/
	private $preview_mode = false;
	
	/**
	 * if set, the Slider will take changes on what is added to this array
	 * @before: RevSliderOutput::$settings
	 **/
	public $custom_settings = array();
	
	/**
	 * if set, the Slider will take changes on the selected skin
	 **/
	public $custom_skin = '';
	
	/**
	 * holds the skin data to change layers based on
	 **/
	public $custom_skin_data = array();
	
	/**
	 * if set to true the markup will be exported
	 * @before: RevSliderOutput::$markup_export
	 **/
	private $markup_export = false;
	
	/**
	 * if set, the Slider will take order changes on the order in this array
	 * @before: RevSliderOutput::$order
	 **/
	public $custom_order = array();
	
	/**
	 * set if only published will be used
	 **/
	private $only_published = true;
	
	/**
	 * holds the number index of all slides
	 * @before: RevSliderOutput::$slidesNumIndex
	 **/
	private $slides_num_index;
	
	/**
	 * if set to true tells the plugin that there is only one Slide from now on
	 * @before: RevSliderOutput::$hasOnlyOneSlide;
	 **/
	private $is_single_slide = false;
	
	/**
	 * holds all the static slide data including layers
	 **/
	private $static_slide = array();
	
	/**
	 * set the language here, used for WPML
	 * @before: RevSliderOutput::$sliderLang
	 **/
	private $language = 'all';
	
	/**
	 * holds the current JavaScript revapi
	 **/
	private $revapi;

	/**
	 * holds the current html id
	 **/
	private $html_id;
	
	/**
	 * holds the current html id
	 **/
	private $orig_html_id = false;
	
	/**
	 * knows if we are currently processing a static slide
	 **/
	private $is_static = false;
	
	/**
	 * holds the inline js for adding it to footer
	 **/
	//private $rev_inline_js = '';
	
	/**
	 * holds slider that are loaded for modal cover checks
	 **/
	private $modal_sliders = array();
	
	/**
	 * holds easings that the slider is using
	 **/
	private $easings = array();
	
	/**
	 * holds easings that the slider is using
	 **/
	private $caching = false;
	
	/**
	 * defines if javascript is changed as its pushed to the footer or not
	 **/
	private $full_js = true;

	/**
	 * defines if this slider has in any way a youtube layer or slide that is used
	 **/
	private $youtube_exists = false;

	/**
	 * defines if the exception should be visible to the visitor or only in the console
	 **/
	private $console_exception = false;
	
	/**
	 * stands for JavaScript Tab Addition and defines how many tabs there should be added to the JavaScript prints to make everything better looking in HTML
	 **/
	private $JTA = RS_T3;

	/**
	 * variables for get_frames
	 */
	private $_base;
	private $_split;
	private $_mask;
	private $_sfx;
	private $_reverse;
	private $hv;
	
	/**
	 * START: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/
	
	/**
	 * old version of check_add_to()
	 **/
	public static function isPutIn($empty_is_false = false){
		$o = new RevSliderOutput();
		return $o->check_add_to($empty_is_false);
	}
	
	/**
	 * END: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/
	 
	/**
	 * pre init the static slide
	 */
	public function __construct(){
		parent::__construct();
		$this->static_slide = new RevSliderSlide();
		$this->init_get_frames_vars();
	}
	
	/**
	 * set the current slider_id
	 */
	public function set_slider_id($sid){
		$this->slider_id = apply_filters('revslider_set_slider_id', $sid, $this);
	}
	
	/**
	 * set the add_to variable
	 */
	public function set_add_to($add_to) {
		$this->add_to = apply_filters('revslider_set_add_to', $add_to, $this);
	}
	
	/**
	 * get the add_to variable
	 */
	public function get_add_to(){
		return apply_filters('revslider_get_add_to', trim(strtolower($this->add_to)), $this);
	}
	
	/**
	 * set the slider manually
	 * @since: 6.0
	 */
	public function set_slider($slider){
		$this->slider = apply_filters('revslider_set_slider', $slider, $this);
	}
	
	/**
	 * get the last slider after the output
	 * @before: RevSliderOutput::getSlider()
	 */
	public function get_slider(){
		return apply_filters('revslider_get_slider', $this->slider, $this);
	}
	
	/**
	 * get the current slider_id
	 */
	public function get_slider_id(){
		return apply_filters('revslider_get_slider_id', $this->slider_id, $this);
	}
	
	/**
	 * get the current revapi for JavaScript
	 */
	public function get_revapi(){
		return $this->revapi;
	}
	
	
	/**
	 * set the current revapi for JavaScript
	 */
	public function set_revapi($revapi){
		$this->revapi = $revapi;
	}
	
	/**
	 * set the HTML ID
	 * @since 6.1.6: added option to check for duplications
	 */
	public function set_html_id($html_id, $check_for_duplication = true){
		global $rs_ids_collection;
		if($check_for_duplication){ //check if it already exists, if yes change it and add attribute for console output
			if(in_array($html_id, $rs_ids_collection, true)){ 
				$this->orig_html_id = $html_id; //set the original_html_id to push a console message
				$i = 0;
				do{ $i++; }while(in_array($html_id.'_'.$i, $rs_ids_collection, true));
				$html_id .= '_'.$i;
				
			}
		}
		if(!in_array($html_id, $rs_ids_collection)) $rs_ids_collection[] = $html_id;
	
		$this->html_id = apply_filters('revslider_set_html_id', $html_id, $this);
	}
	
	/**
	 * set slide slide_id
	 */
	public function set_slide_id($slide_id){
		$this->slide_id = apply_filters('revslider_set_slide_id', $slide_id, $this);
	}
	
	/**
	 * set the slides so that it can be used from anywhere
	 **/
	public function set_current_slides($slides){
		$this->slides = $slides;
	}
	
	/**
	 * get the slides so that it can be used from anywhere
	 **/
	public function get_current_slides(){
		return $this->slides;
	}
	
	/**
	 * get slide slide_id
	 */
	public function get_slide_id(){
		return apply_filters('revslider_get_slide_id', $this->slide_id, $this);
	}
	
	/**
	 * set slide layers
	 */
	public function set_layers($layers){
		$this->layers = apply_filters('revslider_set_layers', $layers, $this);
	}
	
	/**
	 * get slide layers
	 */
	public function get_layers(){
		return apply_filters('revslider_get_layers', $this->layers, $this);
	}
	
	/**
	 * set slide layer
	 */
	public function set_layer($layer){
		$this->layer = apply_filters('revslider_set_layer', $layer, $this);
	}
	
	/**
	 * get slide layer
	 */
	public function get_layer(){
		return apply_filters('revslider_get_layer', $this->layer, $this);
	}
	
	/**
	 * get the HTML ID
	 * @before: RevSliderOutput::getSliderHtmlID
	 */
	public function get_html_id($raw = true){
		$html_id = $this->html_id;
		$html_id = (!$raw) ? preg_replace("/[^a-zA-Z0-9]/", "", $html_id) : $html_id;
		
		return apply_filters('revslider_get_html_id', $html_id, $this, $raw);
	}
	
	/**
	 * set static_slide data and layers
	 */
	public function set_static_slide($slide){
		$this->static_slide = apply_filters('revslider_set_static_slide', $slide, $this);
	}
	
	/**
	 * get static_slide data and layers
	 */
	public function get_static_slide(){		
		return apply_filters('revslider_get_static_slide', $this->static_slide, $this);
	}
	
	/**
	 * get do_static
	 */
	public function get_do_static(){
		return apply_filters('revslider_get_do_static_layers', $this->do_static, $this);
	}
	
	/**
	 * set the output into ajax loaded mode
	 * so that i.e. fonts are pushed into footer
	 */
	public function set_ajax_loaded(){
		$this->ajax_loaded = true;
	}
	
	/**
	 * get current layer depth
	 */
	public function ld(){
		return $this->layer_depth;
	}
	
	/**
	 * increase current layer depth
	 * this is only for the HTML looks
	 */
	public function increase_layer_depth(){
		$this->layer_depth .= '	';
	}
	
	/**
	 * decrease current layer depth
	 * this is only for the HTML looks
	 */
	public function decrease_layer_depth(){
		if(!empty($this->layer_depth)){
			$this->layer_depth =  substr($this->layer_depth, 0, -1);
		}
	}
	
	/**
	 * set the custom settings
	 */
	public function set_custom_settings($settings){
		$settings = ($settings !== '' && !is_array($settings)) ? json_decode(str_replace(array('({', '})', "'"), array('[', ']', '"'), $settings), true) : $settings;
		
		$this->custom_settings = apply_filters('revslider_set_custom_settings', $settings, $this);
	}
	
	/**
	 * get the custom settings
	 */
	public function get_custom_settings(){
		return apply_filters('revslider_get_custom_settings', $this->custom_settings, $this);
	}
	
	/**
	 * set the custom settings
	 */
	public function set_custom_skin($skin){
		$this->custom_skin = apply_filters('revslider_set_custom_skin', $skin, $this);
	}
	
	/**
	 * get the custom settings
	 */
	public function get_custom_skin(){
		return apply_filters('revslider_get_custom_skin', $this->custom_skin, $this);
	}
	
	/**
	 * set the current layer unique id
	 **/
	public function set_layer_unique_id(){
		$layer	= $this->get_layer();
		$uid	= $this->get_val($layer, 'uid');
		
		if($uid == '' && $uid !== 0 && $uid !== '0' ) $uid = $this->zIndex;
		
		$this->uid = apply_filters('revslider_set_layer_unique_id', $uid, $layer, $this);
	}
	
	/**
	 * get the current layer unique id
	 **/
	public function get_layer_unique_id(){		
		return apply_filters('revslider_get_layer_unique_id', $this->uid, $this);
	}
	
	/**
	 * get the preview
	 */
	public function get_preview_mode(){
		return apply_filters('revslider_get_preview_mode', $this->preview_mode, $this);
	}
	
	/**
	 * set the preview_mode
	 */
	public function set_preview_mode($preview_mode){
		global $rs_preview_mode;
		$this->preview_mode = apply_filters('revslider_set_preview_mode', $preview_mode, $this);
		$rs_preview_mode = $this->preview_mode;
	}
	
	/**
	 * set the markup_export variable
	 */
	public function set_markup_export($markup_export){
		$this->markup_export = apply_filters('revslider_set_markup_export', $markup_export, $this);
	}
	
	/**
	 * get the markup_export variable
	 */
	public function get_markup_export(){
		return apply_filters('revslider_get_markup_export', $this->markup_export, $this);
	}
	
	/**
	 * get the custom order
	 */
	public function get_custom_order(){
		return apply_filters('revslider_get_custom_order', $this->custom_order, $this);
	}
	
	/**
	 * get the language
	 */
	public function get_language(){
		return apply_filters('revslider_get_language', $this->language, $this);
	}
	
	/**
	 * set the language
	 */
	public function change_language($language){
		$this->language = apply_filters('revslider_change_language', $language, $this);
	}
	
	/**
	 * set the custom order
	 */
	public function set_custom_order($order){
		$order = ($order !== '' && !is_array($order)) ? explode(',', $order) : $order;
		
		$this->custom_order = apply_filters('revslider_set_custom_settings', $order, $this);
	}
	
	/**
	 * set published
	 */
	public function set_only_published($published){
		$this->only_published = apply_filters('revslider_set_published', $published, $this);
	}
	
	/**
	 * get published
	 */
	public function get_only_published(){
		return apply_filters('revslider_get_published', $this->only_published);
	}
	
	/**
	 * set slides_num_index
	 */
	public function set_slides_num_index($index){
		$this->slides_num_index = apply_filters('revslider_set_slides_num_index', $index, $this);
	}
	
	/**
	 * get slides_num_index
	 */
	public function get_slides_num_index(){
		return apply_filters('revslider_get_slides_num_index', $this->slides_num_index, $this);
	}
	
	/**
	 * set the gallery ids variable
	 * @before: RevSliderOutput::did not exist
	 */
	public function set_gallery_ids($ids){
		$this->gallery_ids = apply_filters('revslider_set_gallery_ids', $ids, $this);
	}
	
	/**
	 * get the gallery ids variable
	 * @before: RevSliderOutput::did not exist
	 */
	public function get_gallery_ids(){
		return apply_filters('revslider_get_gallery_ids', $this->gallery_ids, $this);
	}

	
	/**
	 * set is_single_slide
	 */
	public function set_is_single_slide($single){
		$this->is_single_slide = apply_filters('revslider_set_is_single_slide', $single, $this);
	}
	
	/**
	 * get is_single_slide
	 */
	public function get_is_single_slide(){
		return apply_filters('revslider_get_is_single_slide', $this->is_single_slide, $this);
	}
	
	/**
	 * set hover css
	 */
	public function set_hover_css($css){
		if(!empty($css)){
			foreach($css as $id => $_css){
				$this->hover_css[$id] = $_css;
			}
		}
	}
	
	/**
	 * get is_single_slide
	 */
	public function get_hover_css(){
		return $this->hover_css;
	}
	
	/**
	 * set slide data and layers
	 */
	public function set_slide($slide){
		$this->slide = apply_filters('revslider_set_slide', $slide, $this);
	}
	
	/**
	 * get slide data and layers
	 */
	public function get_slide(){
		return apply_filters('revslider_get_slide', $this->slide, $this);
	}
	
	/**
	 * add the Slider Revolution on to the HTML stage
	 * @before: RevSliderOutput::putSlider();
	 */
	public function add_slider_to_stage($sid, $usage = '', $layout = '', $offset = '', $modal = ''){
		$this->usage = $usage;
		$this->sc_layout = $layout;
		$this->offset = $offset;
		$this->modal = $modal;

		do_action('revslider_add_slider_to_stage_pre', $sid, $this);
		
		if(!$this->check_add_to()) return false;
		
		$locale = setlocale(LC_NUMERIC, 0);
		if($locale !== 'C') setlocale(LC_NUMERIC, 'C');

		$this->set_slider_id($sid);
		$this->add_slider_base();
		
		if($locale !== 'C') setlocale(LC_NUMERIC, $locale);

		do_action('revslider_add_slider_to_stage_post', $sid, $this);

		return $this->get_slider();
	}
	
	/**
	 * adds the Slider Basis
	 * @before: RevSliderOutput::putSliderBase();
	 */
	public function add_slider_base(){
		try{
			global $rs_slider_serial, $rs_js_collection, $rs_wmpl, $rs_loaded_by_editor, $rs_preview_mode;
			$cache = RevSliderGlobals::instance()->get('RevSliderCache');
			
			do_action('revslider_add_slider_base_pre', $this);
			
			$rs_slider_serial++; //set the serial +1, so that if we have the slider two times, it has different ID's for sure
			
			if(empty($this->slider)){
				$this->slider = new RevSliderSlider();
				$this->slider->init_by_mixed($this->get_slider_id());
			}
			
			/**
			 * as it is now needed, check if an update needs to be done
			 **/
			if(version_compare($this->get_val($this->slider, array('settings', 'version')), get_option('revslider_update_version', '6.0.0'), '<')){
				$upd = new RevSliderPluginUpdate();
				$upd->upgrade_slider_to_latest($this->slider);
				$this->slider = new RevSliderSlider();
				$this->slider->init_by_mixed($this->get_slider_id());
			}
			
			$this->slider = apply_filters('revslider_add_slider_base', $this->slider);
			
			//set slider language
			if($this->get_preview_mode() == false){
				$lang = $rs_wmpl->get_slider_language($this->slider);
				$this->change_language($lang);
			}
			
			//check if we are mobile and the slider needs to be printed or not
			if($this->slider->get_param(array('general', 'disableOnMobile'), false) === true && wp_is_mobile()) return false;

			if($this->slider->get_param('pakps', false) === true && $this->_truefalse(get_option('revslider-valid', 'false')) === false && $rs_preview_mode === false && $this->get_preview_mode() === false){
				$this->console_exception = true;
				throw new Exception(__('Please register the Slider Revolution plugin to use premium templates.', 'revslider'));// return false;
			}
			
			//the initial id can be an alias, so reset the id now
			$sid = $this->slider->get_id();
			$this->set_slider_id($sid);
			
			//check if caching should be active or not
			$can_do_cache	= ($this->get_preview_mode() === false && $cache->is_supported_type($this->slider->get_param('sourcetype', 'gallery'))) ? true : false;
			$this->caching	= ($cache->is_enabled() && $can_do_cache) ? true : false;
			$do_cache		= $this->slider->get_param(array('general', 'icache'), 'default');
			$this->caching	= ($do_cache === 'on' && $can_do_cache) ? true : $this->caching;
			$this->caching	= ($do_cache === 'off') ? false : $this->caching;
			
			//add caching if its enabled
			if($this->caching){
				$transient	= $this->get_transient_alias();
				$content	= get_transient($transient);
				if($content !== false){
					$content = json_decode($content, true);
					if(isset($content['html'])){
						echo $cache->do_html_changes($content['html']);
						
						$cache->do_additions($this->get_val($content, 'addition', array()), $this);
						return true;
					}
				}
			}
			
			$this->modify_settings();
			if($this->get_preview_mode()) $this->modify_preview_mode_settings();
			
			$this->set_fonts();
			
			//add html before slider markup is written
			$html_before_slider	= '';
			$markup_export		= $this->get_markup_export();
			
			if($this->ajax_loaded === true || $this->get_markup_export() || $rs_loaded_by_editor === true){ //if true, then we are loaded by ajax
				$html_before_slider .= ($markup_export === true) ? '<!-- FONT -->' : '';
				$html_before_slider .= $this->print_clean_font_import();
				$html_before_slider .= ($markup_export === true) ? '<!-- /FONT -->' : '';
			}
			
			//check if scripts should be added to the body
			if($this->slider->get_param(array('troubleshooting', 'jsInBody'), false) == true && $this->ajax_loaded === false){
				$html_before_slider .= ($markup_export === true) ? '<!-- SCRIPTINCLUDE -->' : '';
				$html_before_slider .= $this->add_javascript_to_footer();
				$html_before_slider .= ($markup_export === true) ? '<!-- /SCRIPTINCLUDE -->' : '';
			}
			
			$slider_id = $this->slider->get_param('id', '');
			
			$html_id = (trim($slider_id) !== '') ? $slider_id : 'rev_slider_'.$sid.'_'.$rs_slider_serial;
			$revapi = (in_array('revapi'.$sid, $rs_js_collection['revapi'], true)) ? 'revapi'.$sid.'_'.$rs_slider_serial : 'revapi'.$sid;
			$this->set_html_id($html_id);
			$this->set_revapi($revapi);
			
			ob_start();
			echo $html_before_slider."\n";
			echo $this->get_slider_wrapper_div();
			
			echo $this->get_slider_div();
			echo $this->get_slides();
			//echo $this->get_timer_bar();
			
			echo $this->close_slider_div();
			
			$this->add_js();
			$this->add_style_hover();
			
			echo $this->add_custom_navigation_css();
			echo $this->get_material_icons_css();
			echo $this->add_youtube_api_html();
			echo $this->close_slider_wrapper_div();
			echo $this->add_unfloat_html();

			$this->add_modal_font_icons();
			
			do_action('revslider_add_slider_base_post', $this);
			
			$content = ob_get_contents();
			ob_clean();
			ob_end_clean();
			
			if($this->caching){
				$this->add_slider_transient($transient, $content);
			}
			
			echo $content;
		}catch(Exception $e){
			$message = $e->getMessage();
			
			if($this->console_exception){
				$this->print_error_message_console($message);
			}else{
				$this->print_error_message($message);
			}

		}
	}
	
	/**
	 * creates the wrapping div container for Sliders
	 **/
	public function get_slider_wrapper_div(){
		$type		= $this->slider->get_param('layouttype');
		$position	= 'center'; //$this->slider->get_param(array('layout', 'position', 'align'), 'center');
		$bg_color	= esc_attr(trim($this->slider->get_param(array('layout', 'bg', 'color'))));
		$max_width	= $this->slider->get_param(array('size', 'maxWidth'), '0');
		$class		= $this->slider->get_param('wrapperclass','');
		$class		.= ($this->usage === 'modal') ? ' rs-modal ' : '';
		$style		= '';
		$addition	= '';
		
		//add background color
		$style .= (!empty($bg_color)) ? 'background:'.RSColorpicker::get($bg_color).';' : '';
		$style .= 'padding:'.esc_attr($this->slider->get_param(array('layout', 'bg', 'padding'), '0')).';';
		
		if($type != 'fullscreen'){
			switch($position){
				case 'center':
				default:
					$style .= 'margin:0px auto;';
				break;
				case 'left':
					$style .= 'float:left;';
				break;
				case 'right':
					$style .= 'float:right;';
				break;
			}
			
			if($position != 'center'){
				$ma_l = $this->slider->get_param(array('layout', 'position', 'marginLeft'), '0');
				$ma_r = $this->slider->get_param(array('layout', 'position', 'marginRight'), '0');
				$style .= ($ma_l !== '') ? 'margin-left:'.esc_attr($ma_l).';' : '';
				$style .= ($ma_r !== '') ? 'margin-right:'.esc_attr($ma_r).';' : '';
			}
			
			$ma_t = $this->slider->get_param(array('layout', 'position', 'marginTop'), '0');
			$ma_b = $this->slider->get_param(array('layout', 'position', 'marginBottom'), '0');
			
			$style .= ($ma_t !== '') ? 'margin-top:'.esc_attr($ma_t).';' : '';
			$style .= ($ma_b !== '') ? 'margin-bottom:'.esc_attr($ma_b).';' : '';
		}
		
		//add background image (banner style)
		if($this->slider->get_param(array('layout', 'bg', 'useImage'), false) == true){
			$bg_img_id = esc_attr($this->slider->get_param(array('layout', 'bg', 'imageId')));
			$bg_img_type = esc_attr($this->slider->get_param(array('layout', 'bg', 'imageSourceType'), 'full'));
			$bg_img = esc_attr($this->slider->get_param(array('layout', 'bg', 'image')));
			if(empty($bg_img_id) || intval($bg_img_id) == 0){
				$bg_img_id	= $this->get_image_id_by_url($bg_img);
			}
			if($bg_img_type !== 'full' && $bg_img_id !== false && !empty($bg_img_id)){
				$_bg_img = wp_get_attachment_image_src($bg_img_id, $bg_img_type);
				$bg_img = ($_bg_img !== false) ? $_bg_img[0] : $bg_img;
			}
			
			$bg_img = $this->check_valid_image($bg_img);
			
			if($bg_img !== false){
				$global = $this->get_global_settings();
				$lazyloadbg = $this->get_val($global, 'lazyonbg', false);
				$addition .= ($lazyloadbg !== false && $lazyloadbg !== 'false') ? ' data-bglazy="'.$bg_img.'"' : '';
				$bg_img = ($lazyloadbg !== false && $lazyloadbg !== 'false') ? RS_PLUGIN_URL.'public/assets/assets/dummy.png' : $bg_img;

				$style .= 'background-image:url('.$bg_img.');';
				$style .= 'background-repeat:'.esc_attr($this->slider->get_param(array('layout', 'bg', 'repeat'), 'no-repeat')).';'; //$this->slider->get_param(array('def', 'background', 'repeat'), 'no-repeat')
				$style .= 'background-size:'.esc_attr($this->slider->get_param(array('layout', 'bg', 'fit'), 'cover')).';'; //$this->slider->get_param(array('def', 'background', 'fit'), 'cover')
				$style .= 'background-position:'.esc_attr($this->slider->get_param(array('layout', 'bg', 'position'), 'center center')).';'; //$this->slider->get_param(array('def', 'background', 'position'), 'center center')
			}
		}
		
		if(!in_array($type, array('responsitive', 'fixed', 'auto', 'fullwidth', 'fullscreen'), true)){
			$style .= 'height:'.$this->slider->get_param(array('size', 'height', 'd'), 900).';';
			$style .= 'width:'.$this->slider->get_param(array('size', 'width', 'd'), 1240).';';
		}
		
		if(!in_array($max_width, array('0', 0, '0px', '0%'), true) && $type == 'auto'){
			if(intval($max_width) > 0 && strpos($max_width, 'px') === false && strpos($max_width, '%') === false) $max_width .= 'px';
			$style .= (empty($max_width)) ? '' : 'max-width:'. $max_width.';';
		}

		$fixedOnTop = array(
			'v' => $this->slider->get_param(array('layout', 'position', 'fixedOnTop'), false),
			'd' => false
		);

		if($fixedOnTop['v'] === true){
			$style .= 'position:fixed;top:0px;height:0px';
		}
		
		$r = RS_T3.'<!-- START '.esc_html(str_replace('-', '', $this->slider->get_title())).' REVOLUTION SLIDER '. RS_REVISION .' --><p class="rs-p-wp-fix"></p>'."\n";
		$r .= RS_T3.'<rs-module-wrap';
		$this->rs_module_wrap_open = true;
		$r .= ' id="'.$this->get_html_id().'_wrapper"';
		$r .= (!empty($class)) ? ' class="'.trim($class).'"' : '';
		if((is_super_admin() || is_admin_bar_showing()) && current_user_can('edit_theme_options')){
			$r .= ' data-alias="'.esc_attr($this->slider->get_alias()).'"';
		}
		
		$r .= ' data-source="'.$this->slider->get_param('sourcetype').'"';
		$show_alternate	= $this->slider->get_param(array('troubleshooting', 'alternateImageType'), 'off');
		if($show_alternate !== 'off'){
			$show_alternate_image = $this->slider->get_param(array('troubleshooting', 'alternateURL'), '');
			$r .= ' data-aimg="'.$show_alternate_image.'" ';
			$r .= ($show_alternate == 'mobile' || $show_alternate == 'mobile-ie8') ? ' data-amobile="enabled" ' : '';
			$r .= ($show_alternate == 'mobile-ie8' || $show_alternate == 'ie8') ? ' data-aie8="enabled" ' : '';
		}

		$r .= $addition;
				
		$r .= ' style="visibility:hidden;'. $style .'">'."\n";
		
		return apply_filters('revslider_get_slider_wrapper_div', $r, $this);
	}
	
	/**
	 * close the wrapping div container for Sliders
	 **/
	public function close_slider_wrapper_div(){
		$r = RS_T3.'</rs-module-wrap>'."\n";
		$r .= RS_T3.'<!-- END REVOLUTION SLIDER -->'."\n";
		
		$this->rs_module_wrap_closed = true;
		
		return apply_filters('revslider_close_slider_wrapper_div', $r, $this);
	}
	
	
	/**
	 * if wanted, add an unfloating HTML 
	 * @since: 6.0
	 **/
	public function add_unfloat_html(){
		$r = '';
		
		if($this->slider->get_param(array('layout', 'position', 'addClear'), false) === true){
			$r = RS_T3.'<div style="clear:both;display:block;width:100%;height:0px"></div>';
		}
		
		return apply_filters('revslider_add_unfloat_html', $r, $this);
	}
	
	
	/**
	 * check if the youtube api needs to be added, this should only be done once for all sliders
	 * @since: 6.5.7
	 **/
	public function add_youtube_api_html(){
		global $rs_youtube_api_loaded;
		
		$r = '';

		if($rs_youtube_api_loaded === true) return $r; //already loaded
		if($this->youtube_exists !== true) return $r; //no layer or slide used it

		//check global option if enabled
		$gs = $this->get_global_settings();
		if($this->_truefalse($this->get_val($gs, array('script', 'ytapi'), true)) === true){
			$r = RS_T4.'<script src="https://www.youtube.com/iframe_api"></script>'."\n";
			$rs_youtube_api_loaded = true;
		}
		
		return apply_filters('revslider_add_youtube_api_html', $r, $this);
	}
	
	
	/**
	 * adds to font loading to the modal
	 * @since: 6.2.3
	 **/
	public function add_modal_font_icons(){
		if($this->usage === 'modal'){
			RevSliderFront::load_icon_fonts();
		}
	}
	
	
	/**
	 * creates the div container for Sliders
	 **/
	public function get_slider_div(){
		$style = '';
		$class = $this->slider->get_param('class','');
		$class .= ($this->slider->get_param(array('size', 'overflow'), true) == true) ? ' rs-ov-hidden' : '';
		
		if(!in_array($this->slider->get_param('layouttype'), array('responsitive', 'fixed', 'auto', 'fullwidth', 'fullscreen'), true)){
			$style .= 'height:'.$this->slider->get_param(array('size', 'width', 'd'), 1240).';';
			$style .= 'width:'.$this->slider->get_param(array('size', 'height', 'd'), 900).';';
		}
		
		$r = RS_T4.'<rs-module id="'. $this->get_html_id() .'"';
		$this->rs_module_open = true;
		$r .= ($class !== '') ? ' class="'. $class .'"' : '';
		$r .= ' style="'. $style .'"';
		$r .= ' data-version="'. RS_REVISION .'"';
		$r .= '>'."\n";
		
		return apply_filters('revslider_get_slider_div', $r, $this);
	}
	
	/**
	 * close the div container for Sliders
	 **/
	public function close_slider_div(){
		$r = RS_T4.'</rs-module>'."\n";
		
		$this->rs_module_closed = true;
		
		return apply_filters('revslider_close_slider_div', $r, $this);
	}
	
	/**
	 * get the Slides HTML of the Slider
	 **/
	public function get_slides(){
		$layouttype	 = $this->slider->get_param('type', 'standard'); //standard, carousel or hero
		$order		 = $this->get_custom_order();
		$gallery_ids = $this->get_gallery_ids();
		$index		 = 0;
		
		/**
		 * If we are Hero or there was a custom order Set
		 * we need to fetch all Slides, even unpublished in order find one that might be unpublished
		 **/
		if($layouttype == 'hero' || !empty($order)) $this->set_only_published(false);
		
		if($this->get_preview_mode() === true){
			/**
			 * the slides are already set in preview mode (only in slide editor)
			 * in the overview page, get_preview_mode() needs to be false
			 **/
			$slides = $this->get_current_slides();
		}else{
			/**
			 * fetch all slides connected to the Slider (no static slide)
			 **/
			$published = $this->get_only_published();
			$lang	= $this->get_language(); //WPML functionality
			$slides = $this->slider->get_slides_for_output($published, $lang, $gallery_ids);
		}
		
		/**
		 * check if we need to add gallery images
		 * check also for order
		 * these settings are set through shortcode manipulation
		 **/
		if(!empty($gallery_ids) && $gallery_ids[0]){
			$slides = $this->set_gallery_slides($slides);
		}elseif(!empty($order)){
			$slides = $this->order_slides($slides, $order);
		}
		
		/**
		 * set the num index for further onclick events and more
		 **/
		$this->set_slides_num_index($this->slider->get_slide_numbers_by_id(true));
		
		if($layouttype == 'hero' && empty($order) && empty($gallery_ids)){ //we are a hero Slider, show only one Slide!
			$hero	= $this->get_hero_slide($slides);
			$slides = (!empty($hero)) ? array($hero) : array();
		}
		
		/**
		 * remove slides that are listed to be not shown on mobile
		 * will be done only if we are on mobile
		 **/
		$slides = $this->remove_slide_if_mobile($slides);
		
		/**
		 * enable the static layers if we have a static slide
		 * only set if we are not in preview mode
		 * as in preview mode, the static slide was already set
		 * also note, that this only happens in the slide editor.
		 * on the overview page, get_preview_mode will be false
		 **/
		if($this->get_preview_mode() === false){
			$this->enable_static_layers($slides);
		}
		
		/**
		 * if we are now at 0 slides, there will be no more chances to add them
		 * so return back with no slides markup
		 **/
		if(empty($slides)){
			$this->add_no_slides_markup();
			return false;
		}
		
		/**
		 * removes slides before the loop check, as a loop does still not need a navigation
		 * and if loop will be triggered, we will have two slides, so remove it before
		 **/
		if(count($slides) == 1) $this->remove_navigation();
		
		/**
		 * slide loop will duplicate a single slide (if loop is active), so that we have a repeated in and out animation
		 **/
		$slides = ($layouttype !== 'hero' && count($slides) == 1) ? $this->set_slide_loop($slides) : $slides;
		
		/**
		 * set the slides later for static action checking
		 **/
		$this->set_current_slides($slides);
		
		$this->set_general_params_for_layers();
		
		echo apply_filters('revslider_get_slides_pre', RS_T5.'<rs-slides>'."\n", $this);

		foreach($slides as $slide){
			$this->set_slide($slide);
			
			$this->modify_slide_by_skin();
			$this->modify_layers_by_skin();
			
			if($this->is_in_timeframe() === false) continue; //could also be moved to earlier and remove slides instead of continue here
			
			$this->add_slide_li_pre($index);
			$this->add_slide_main_image();
			
			$this->set_slide_params_for_layers();
			$this->add_background_video();
			
			echo $this->add_opening_comment();
			
			$this->add_zones();
			$this->add_groups();
			$this->add_creative_layer();
			
			echo $this->add_closing_comment();
			
			do_action('revslider_add_layer_html', $this->slider, $slide);
			
			$this->add_slide_li_post();
			
			$this->set_material_icon_css();
			
			$this->zIndex = 1; //reset zIndex on each slide
			$index++;
		}
		
		echo apply_filters('revslider_get_slides_post', RS_T5.'</rs-slides>'."\n", $this);
		
		$this->add_static_slide_html();
		
		$this->set_material_icon_css(); //do again, so that we have static layers in the queue now
	}
	
	/**
	 * push the static slide, can also be disabled through filters
	 **/
	public function enable_static_layers($slides){
		if(!$this->get_do_static()) return;

		$static_slide = $this->slider->get_static_slide();
		if($static_slide !== false){
			$this->set_static_slide($static_slide);
		}
	}
	
	/**
	 * creates the timer bar for Slider
	 **/
	public function get_timer_bar(){
		$layouttype	= $this->slider->get_param('type'); //standard, carousel or hero
		$enable_progressbar	= $this->slider->get_param(array('general', 'progressbar', 'set'), true);

		$timer_bar			= $this->slider->get_param(array('general', 'progressbar', 'position'), 'top');
		$progress_height	= $this->slider->get_param(array('general', 'progressbar', 'height'), '5');
		$progressbar_color	= RSColorpicker::get($this->slider->get_param(array('general', 'progressbar', 'color'), '#000000'));
		
		$timer_bar = ($enable_progressbar !== true || $layouttype == 'hero') ? 'hide' : $timer_bar;
		
		$progress_style = ' style="height: '.esc_attr($progress_height).'px; background: '.$progressbar_color.';"';
		
		$r = '';
		switch($timer_bar){
			case 'top':
				$r = RS_T5.'<rs-progress'.$progress_style.'></rs-progress>'."\n";
			break;
			case 'bottom':
				$r = RS_T5.'<rs-progress class="rs-bottom"'.$progress_style.'></rs-progress>'."\n";
			break;
			case 'hide':
				$r = RS_T5.'<rs-progress class="rs-bottom" style="visibility: hidden !important;"></rs-progress>'."\n";
			break;
		}
		
		return $r;
	}
	
	/**
	 * add the opening <!-- to remove unneeded parsed spacings
	 **/
	public function add_opening_comment(){
		return '<!--';
	}
	
	/**
	 * add the opening <!-- to remove unneeded parsed spacings
	 **/
	public function add_closing_comment(){
		return '-->';
	}
	
	/**
	 * add the slide li with data attributes and so on
	 **/
	public function add_slide_li_pre($index){
		$slide = $this->get_slide();
		
		//Html rev-main-
		//echo RS_T6.'<!-- SLIDE  -->'."\n";
		echo RS_T6.'<rs-slide';

		echo $this->get_html_slide_style();
		echo $this->get_html_slide_key();
		echo $this->get_html_slide_title();
		echo $this->get_html_slide_description();
		echo $this->get_thumb_url();
		echo $this->get_slide_link();
		echo $this->get_html_delay();
		echo $this->get_html_scrollbased_slidedata();
		echo $this->get_html_stop_slide();
		echo $this->get_html_invisible();
		echo $this->get_html_anim();
		echo $this->get_html_random_animations();
		echo $this->get_html_alt_transitions();

		echo $this->get_html_slide_loop();
		echo $this->get_html_media_filter();
		echo $this->get_html_slide_class();
		echo $this->get_html_slide_id();
		echo $this->get_html_extra_data();
		echo $this->get_html_hide_after_loop();
		echo $this->get_html_hide_slide_mobile();
		echo $this->get_html_extra_params();
		echo $this->get_html_image_video_ratio();
		
		do_action('revslider_add_li_data', $this->slider, $slide);
		
		echo '>'."\n";
	}
	
	/**
	 * add the slide closing li 
	 **/
	public function add_slide_li_post(){
		echo RS_T6.'</rs-slide>'."\n";
	}
	
	/**
	 * add the static slide layer HTML
	 **/
	public function add_static_slide_html(){
		$static_slide = $this->get_static_slide();
		
		if($this->get_do_static() && !empty($static_slide)){
			$this->is_static = true;
			$this->set_slide_id($static_slide->get_id());
			$layers = $static_slide->get_layers();
			$this->set_layers($layers);
			if(!empty($layers)){
				$sof = $static_slide->get_param(array('static', 'overflow'), '');
				$scl = $sof;
				$sof = (!empty($sof) && $sof == 'hidden') ? ' style="overflow:hidden;width:100%;height:100%;top:0px;left:0px;"' : '';
				$slp = $static_slide->get_param(array('static', 'position'), 'front');
				$slp = (!empty($slp) && $slp === 'back') ? ' class="rs-stl-back ' . ($scl == 'visible' ? 'rs-stl-visible' : '') . '"' : ($scl == 'visible' ? ' class="rs-stl-visible"' : '');

				//check for static layers
				echo RS_T5.'<rs-static-layers' . $sof . $slp . '><!--'."\n";
				
				$this->set_slide($static_slide);
				$this->add_zones();
				$this->add_groups();
				$this->add_creative_layer();
				
				do_action('revslider_add_static_layer_html', $this->get_slider());
				
				echo RS_T5.'--></rs-static-layers>'."\n";
			}
			$this->is_static = false;
		}
	}
	
	/**
	 * add the slide li with data attributes and so on
	 **/
	public function add_slide_main_image(){
		$img = $this->get_image_data();
		
		if(!empty($img) && is_array($img)){
			//echo RS_T7.'<!-- MAIN IMAGE -->'."\n";
			echo RS_T7.'<img';
			foreach($img as $k => $v){
				if($k === 'alt'){
					echo ' '.$k.'="'.$v.'"'; //always print an alt even if empty
					continue;
				}
				echo (trim($v) !== '') ? ' '.$k.'="'.$v.'"' : '';
			}
			echo ' data-no-retina>'."\n";
		}
	}
	
	/**
	 * get image params to be used later on the background image
	 **/
	public function get_image_data(){
		$slide	 = $this->get_slide();
		$bg_type = $slide->get_param(array('bg', 'type'), 'trans');
		$url_trans = RS_PLUGIN_URL.'public/assets/assets/transparent.png';
		$img	 = array('id' => false, 'src' => '', 'alt' => '', 'style' => '', 'title' => '', 'parallax' => '', 'panzoom' => '', 'width' => '', 'height' => '', 'bg' => '', 'lazyload' => '');
		
		if($bg_type != 'external'){
			$img['src']	= $slide->image_url;
			$img['id']	= $slide->image_id;
			
			switch($slide->get_param(array('attributes', 'altOption'), $slide->get_param(array('attributes', 'titleOption'), 'media_library'))){
				case 'media_library':
				default:
					$img['alt'] = get_post_meta($img['id'], '_wp_attachment_image_alt', true);
				break;
				case 'file_name':
					$info = pathinfo($slide->image_filename);
					$img['alt'] = $this->get_val($info, 'filename');
				break;
				case 'custom':
					$img['alt'] = esc_attr($slide->get_param(array('attributes', 'alt'), ''));
				break;
			}
			
			switch($slide->get_param(array('attributes', 'titleOption'), 'media_library')){
				case 'media_library':
				default:
					$img['title'] = get_the_title($img['id']);
				break;
				case 'file_name':
					$info = pathinfo($slide->image_filename);
					$img['title'] = $this->get_val($info, 'filename');
				break;
				case 'custom':
					$img['title'] = esc_attr($slide->get_param(array('attributes', 'title'), ''));
				break;
			}
			
			if($img['id'] !== false){
				$data = wp_get_attachment_metadata($img['id']);
				if($data !== false && !empty($data)){
					$size = $slide->get_param(array('bg', 'imageSourceType'), 'full'); //$this->slider->get_param(array('def', 'background', 'imageSourceType'), 'full')
					if($size !== 'full'){
						if(isset($data['sizes']) && isset($data['sizes'][$size])){
							$img['width'] = (isset($data['sizes'][$size]['width'])) ? $data['sizes'][$size]['width'] : '';
							$img['height'] = (isset($data['sizes'][$size]['height'])) ? $data['sizes'][$size]['height'] : '';
						}
					}
					
					if($img['width'] == '' || $img['height'] == ''){
						$img['width'] = (isset($data['width'])) ? $data['width'] : '';
						$img['height'] = (isset($data['height'])) ? $data['height'] : '';
					}
				}
			}
		}else{
			$img['src']		= esc_url($slide->get_param(array('bg', 'externalSrc'), ''));
			$img['alt']		= esc_attr($slide->get_param(array('attributes', 'alt'), ''));
			$img['title']	= esc_attr($slide->get_param(array('attributes', 'title'), ''));
			$img['width']	= $slide->get_param(array('bg', 'width'), '1920');
			$img['height']	= $slide->get_param(array('bg', 'height'), '1080');
		}
		
		switch($bg_type){
			case 'trans':
			case 'transparent':
			case 'solid':
				$img['src'] = $url_trans;
				if(isset($img['alt']) && trim($img['alt']) === ''){
					$img['alt'] = $this->get_html_slide_title(true);
					$img['alt'] = (empty($img['alt'])) ? __('Slide Background', 'revslider') : $img['alt'];
				}
			break;
		}
		
		if(isset($slide->ignore_alt)) $img['alt'] = '';
		if(isset($img['title'])) $img['title'] = strip_tags($img['title']);
		if(isset($img['alt'])) $img['alt'] = strip_tags($img['alt']);

		$img['class'] = 'rev-slidebg tp-rs-img';
		$img['class'] .= ($this->slider->get_param(array('general', 'lazyLoad'), false) != 'none') ? ' rs-lazyload' : '';
		
		$img['src']			 = (trim($img['src']) == '') ? $url_trans : $img['src']; //go back to transparent if img is empty
		$img['data-lazyload']= ($this->slider->get_param(array('general', 'lazyLoad'), false) != 'none') ? $this->remove_http($img['src']) : '';
		$img['src']			 = ($this->slider->get_param(array('general', 'lazyLoad'), false) != 'none') ? RS_PLUGIN_URL.'public/assets/assets/dummy.png' : $img['src'];
		$img['src']			 = $this->remove_http($img['src']);
		$img['data-bg']	 	 = $this->get_image_background_values();
		$img['data-parallax']= $this->get_html_parallax();
		$img['data-panzoom'] = $this->get_html_pan_zoom();
		
		unset($img['id']);
		
		return $img;
	}
	
	/**
	 * get data-bg image background values
	 **/
	public function get_image_background_values(){
		$slide = $this->get_slide();
		$bg	 = '';
		$pos = $this->get_background_position();
		$f_r = $this->get_background_fit_and_repeat();
		$c	 = ($slide->get_param(array('bg', 'type'), 'trans') == 'solid') ? RSColorpicker::get($slide->get_param(array('bg', 'color'), '#ffffff')) : '';
		$c	 = ($c == '' && $slide->get_param(array('bg', 'type'), 'trans') == 'solid') ? '#ffffff' : $c; //force white here as we need it in frontend
		
		$bg .= (!in_array($pos, array('', '50%', '50% 50%', 'center center', 'center'), true)) ? 'p:'.$pos.';' : '';
		$bg .= ($c !== '' && $c !== 'transparent') ? 'c:'.$c.';' : '';
		$bg .= ($f_r['f'] !== '' && $f_r['f'] !== 'cover') ? 'f:'.$f_r['f'].';' : '';
		$bg .= ($f_r['r'] !== '' && $f_r['r'] !== 'no-repeat') ? 'r:'.$f_r['r'].';' : '';
		
		return $bg;
	}
	
	/**
	 * get the parallax html
	 **/
	public function get_html_parallax(){
		$slide		= $this->get_slide();
		$parallax	= '';
		
		if($this->slider->get_param(array('parallax', 'set'), false) == true){
			$slide_level = $slide->get_param(array('effects', 'parallax'), '-');
			if($slide_level == '-') $slide_level = 'off';
			
			$parallax = $slide_level;
		}
		
		return $parallax;
	}
	
	/**
	 * get ken burns html data
	 **/
	public function get_html_pan_zoom(){
		$slide	 = $this->get_slide();
		$bg_type = $slide->get_param(array('bg', 'type'), 'trans');
		$pan	 = '';
		
		if($slide->get_param(array('panzoom', 'set'), false) == true && ($bg_type == 'image' || $bg_type == 'external')){
			$d = $slide->get_param(array('panzoom', 'duration'), '10000');
			$e = $slide->get_param(array('panzoom', 'ease'), 'none');
			$this->easings[$e] = $e;
			$ss = $slide->get_param(array('panzoom', 'fitStart'), '100');
			$se = $slide->get_param(array('panzoom', 'fitEnd'), '100');
			$rs = $slide->get_param(array('panzoom', 'rotateStart'), '0');
			$re = $slide->get_param(array('panzoom', 'rotateEnd'), '0');
			$bs = $slide->get_param(array('panzoom', 'blurStart'), '0');
			$be = $slide->get_param(array('panzoom', 'blurEnd'), '0');
			$os = $slide->get_param(array('panzoom', 'xStart'), '0').'/'.$slide->get_param(array('panzoom', 'yStart'), '0');
			$oe = $slide->get_param(array('panzoom', 'xEnd'), '0').'/'.$slide->get_param(array('panzoom', 'yEnd'), '0');
			
			
			$pan .= ($d !== '') ? 'd:'.$d.';' : '';
			$pan .= ($e !== 'none') ? 'e:'.$e.';' : '';
			$pan .= 'ss:'.$ss.';';
			$pan .= 'se:'.$se.';';
			$pan .= ($rs !== '0') ? 'rs:'.$rs.';' : '';
			$pan .= ($re !== '0') ? 're:'.$re.';' : '';
			$pan .= ($bs !== '0') ? 'bs:'.$bs.';' : '';
			$pan .= ($be !== '0') ? 'be:'.$be.';' : '';
			$pan .= ($os !== '0/0') ? 'os:'.$os.';' : '';
			$pan .= ($oe !== '0/0') ? 'oe:'.$oe.';' : '';
		}
		
		return $pan;
	}
	
	/**
	 * get background position for the image
	 **/
	public function get_background_position(){
		$slide = $this->get_slide();
		
		$pos = $slide->get_param(array('bg', 'position'), 'center center'); //$this->slider->get_param(array('def', 'background', 'position'), 
		$type = $slide->get_param(array('bg', 'type'), 'trans');
		
		if($type == 'streamvimeoboth' || $type == 'streamyoutubeboth' || $type == 'streaminstagramboth' || $type == 'streamtwitterboth'){
			$pos = ($this->check_if_stream_video_exists()) ? 'center center' : $pos;
		}else{
			$pos = ($type == 'youtube' || $type == 'vimeo' || $type == 'html5' || $type == 'streamvimeo' || $type == 'streamyoutube' || $type == 'streaminstagram' || $type == 'streamtwitter') ? 'center center' : $pos;
		}
		
		$pos = ($pos == 'percentage') ? intval($slide->get_param(array('bg', 'positionX'), '0')).'% '.intval($slide->get_param(array('bg', 'positionY'), '0')).'%' : $pos; //$this->slider->get_param(array('def', 'background', 'positionX'), '0') $this->slider->get_param(array('def', 'background', 'positionY'), '0')
		
		return $pos;
	}
	
	/**
	 * get image fit and repeat params
	 **/
	public function get_background_fit_and_repeat(){
		$slide	 = $this->get_slide();
		$bg_type = $slide->get_param(array('bg', 'type'), 'trans');
		$return	 = array('f' => '', 'r' => '');
		
		if(!($slide->get_param(array('panzoom', 'set'), false) == true && ($bg_type == 'image' || $bg_type == 'external'))){ //only set if kenburner is off and not a background video //$this->slider->get_param(array('def', 'panZoom', 'set'), false)
			if($bg_type == 'youtube' || $bg_type == 'html5' || $bg_type == 'vimeo' || $bg_type == 'streamvimeo' || $bg_type == 'streamyoutube' || $bg_type == 'streaminstagram' || $bg_type == 'streamtwitter'){
				$return['f'] = 'cover';
			}else{
				//additional background params
				$bgFit = $slide->get_param(array('bg', 'fit'), 'cover'); //$this->slider->get_param(array('def', 'background', 'fit'), 'cover')
				if(!in_array($bgFit, array('cover', 'contain', 'percentage', 'auto'))) $bgFit = 'cover';
				$return['f'] = ($bgFit == 'percentage') ? intval($slide->get_param(array('bg', 'fitX'), '100')).'% '.intval($slide->get_param(array('bg', 'fitY'), '100')).'%' : $bgFit; //$this->slider->get_param(array('def', 'background', 'fitX'), '100') $this->slider->get_param(array('def', 'background', 'fitY'), '100')
				$return['r'] = $slide->get_param(array('bg', 'repeat'), 'no-repeat'); //$this->slider->get_param(array('def', 'background', 'repeat'), 'no-repeat')
			}
		}
		
		return $return;
	}
	
	/**
	 * set slide specific values that are needed by layers
	 * this is needed to be called before any layer is added to the stage
	 **/
	public function set_slide_params_for_layers(){
		$slide = $this->get_slide();
		$this->set_slide_id($slide->get_id());
		$this->set_layers($slide->get_layers());
	}
	
	/**
	 * add background video if one is selected
	 **/
	public function add_background_video(){
		$slide	= $this->get_slide();
		$type	= $slide->get_param(array('bg', 'type'), 'trans');
		
		//check if we are youtube, vimeo or html5
		if($type == 'youtube' || $type == 'html5' || $type == 'vimeo' || $type == 'streamvimeo' || $type == 'streamyoutube' || $type == 'streaminstagram' || $type == 'streamtwitter'){
			$this->add_html_background_video(); 
		}
		if($type == 'streamvimeoboth' || $type == 'streamyoutubeboth' || $type == 'streaminstagramboth' || $type == 'streamtwitterboth'){
			if($this->check_if_stream_video_exists()) $this->add_html_background_video();
		}
	}
	
	/**
	 * Add Groups with columns and the layers of it
	 * @since: 5.3.0
	 * @before: RevSliderOutput::putCreativeZones()
	 */
	public function add_zones(){
		$layers = $this->get_layers();
		
		if(empty($layers)) return false;
		
		$this->container_mode = '';
		$zones			= array('t' => 'top', 'm' => 'middle', 'b' => 'bottom');

		foreach($zones as $zs => $zone){ //go through all three zones
			foreach($layers as $layer){
			
				if($this->get_val($layer, 'type', 'text') !== 'row') continue; //we only want to handle rows here to get the zones we need to create
				
				$this->row_zindex = 0;
				
				$layer_zone = $this->get_val($layer, array('group', 'puid'), 'top');
				if($layer_zone !== $zone) continue; //wrong zones, so continue
				
				$this->increase_layer_depth();
				
				//we have found a zone, now fill it with rows, columns, layers
				ob_start(); //fetch the data, as we need to set the z-index on the rows
				$this->add_rows($layer_zone);
				$row_layers = ob_get_contents();
				ob_clean();
				ob_end_clean();
				
				//get the zone z-index from the zone layer
				$zi = $this->get_val($layers, array($zone, 'position', 'zIndex'), $this->row_zindex);
				
				$this->decrease_layer_depth();
				echo RS_T6. $this->add_closing_comment() .'<rs-zone id="rrz'.$zs.'_'.$this->slide->get_id().'" class="rev_row_zone_'.$zone.'" style="z-index: '.$zi.';">';
				echo $this->add_opening_comment()."\n";
				echo $row_layers;
				echo RS_T7.$this->add_closing_comment().'</rs-zone>'.$this->add_opening_comment()."\n";
				
				break; //zone is written, go to the next one
			}
		}
	}
	
	/**
	 * Add Groups with columns and the layers of it
	 * @since: 5.3.0
	 * @before: RevSliderOutput::putCreativeGroups()
	 */
	public function add_groups(){
		$layers = $this->get_layers();
		if(empty($layers)) return false;
		
		foreach($layers as $layer){
			if($this->get_val($layer, 'type', 'text') !== 'group') continue; //we only want to handle groups here to get the zones we need to create
			
			$this->container_mode = '';
			
			$uid = $this->get_val($layer, 'uid');
			
			$this->set_layer($layer);
			$this->add_layer(true, 'group'); //add the group layer
			
			$this->container_mode = 'group';
			
			$this->increase_layer_depth();
			
			$this->add_group_layer($uid); //add all layers that are in the group
			
			$this->decrease_layer_depth();
			
			echo $this->ld().RS_T7.'--></rs-group>'.$this->add_opening_comment()."\n";

		}
	}
	
	/**
	 * put creative layer
	 * @before: RevSliderOutput::putCreativeLayer()
	 */
	private function add_creative_layer(){
		$layers = $this->get_layers();
		if(empty($layers)) return false;
		
		$layers = apply_filters('revslider_putCreativeLayer', $layers, $this, $this->is_static);
		$this->container_mode = '';
		
		foreach($layers as $layer){
			if((string)$this->get_val($layer, array('group', 'puid'), '-1') !== '-1') continue; //dont do group layer
			
			$this->set_layer($layer);
			$this->add_layer(false);
		}
	}
	
	/**
	 * Add all Layers that are in the group with $u_id
	 * @since: 5.3.0
	 * @before: RevSliderOutput::putCreativeGroupLayer();
	 */
	public function add_group_layer($u_id){
		$layers = $this->get_layers();
		
		foreach($layers as $layer){
			$p_uid = $this->get_val($layer, array('group', 'puid'));
			$uid = $this->get_val($layer, array('group', 'uid'));
			
			if((string)$u_id !== (string)$p_uid) continue;
			if((string)$u_id === (string)$uid) continue;
			
			$this->set_layer($layer);
			$this->add_layer(true); //add the layer into the group
		}
	}
	
	/**
	 * Add Groups with columns and the layers of it
	 * @since: 5.3.0
	 * @before: RevSliderOutput::putCreativeRows()
	 */
	public function add_rows($current_zone){
		$layers = $this->get_layers();
		if(empty($layers)) return false;

		$row_layer		= array();
		$go				= 9999;
		
		foreach($layers as $layer){
			
			if($this->get_val($layer, 'type', 'text') !== 'row') continue; //we only want to handle rows here of the current zone and add them as a rows
			if($this->get_val($layer, array('group', 'puid'), 'top') !== $current_zone) continue; //wrong zones, so continue
			
			$order = $this->get_val($layer, array('group', 'groupOrder'));
			if($order === ''){ // || isset($row_layer[$order])
				$order = $go;
				$go++;
			}
			
			$zi = $this->get_val($layer, array('position', 'zIndex'), false); // set the z-index so that the wrapper gains the highest one
			$zi = ($zi === false) ? $this->zIndex : $zi;
			if($zi > $this->row_zindex){
				$this->row_zindex = $zi;
			}
			
			$row_layer[$order] = $layer;
		}
		
		if(!empty($row_layer)){
			ksort($row_layer); //sort the rows
			
			foreach($row_layer as $layer){
				$uid = $this->get_val($layer, 'uid');
				$this->set_layer($layer);
				$this->add_layer(true, 'row');
				$this->container_mode = 'row';
				
				$this->increase_layer_depth();
				
				$this->add_column($uid);
				
				$this->decrease_layer_depth();
				
				echo $this->ld().RS_T7.$this->add_closing_comment().'</rs-row>'.$this->add_opening_comment()."\n";//as we have used 'row' in the add_layer() function, it does not print the closing </> and we have to do it here
			}
		}
	}
	
	/**
	 * Add Columns with the layers
	 * @since: 5.3.0
	 * @before: RevSliderOutput::putCreativeColumn()
	 */
	public function add_column($uid){
		$layers = $this->get_layers();
		
		if(empty($layers)) return false;
		
		$column_layers = array();
		$go = 9999;
		foreach($layers as $layer){
			$this->container_mode = 'row';
			
			if($this->get_val($layer, 'type', 'text') !== 'column') continue; //we only want to handle columns here of the current row
			if((string)$this->get_val($layer, array('group', 'puid'), -1) !== (string)$uid) continue; //has the wrong row ID
			
			$_go = $this->get_val($layer, array('group', 'groupOrder'));
			
			if($_go === ''){ // || isset($column_layers[$_go])
				$_go = $go;
				$go++;
			}
			
			$column_layers[$_go] = $layer;
		}
		
		if(!empty($column_layers)){
			ksort($column_layers);
			foreach($column_layers as $layer){
				$this->container_mode = 'row';
				
				$this->set_layer($layer);
				$this->add_layer(true, 'column');
				$cuid = (string)$this->get_val($layer, 'uid', -1);
				
				//add layers here
				$group_layers = array();
				$go = 9999;
				foreach($layers as $nlayer){
					if((string)$this->get_val($nlayer, array('group', 'puid'), -1) !== $cuid) continue;
					
					$_go = $this->get_val($nlayer, array('group', 'groupOrder'));
					
					if($_go === ''){ // || isset($group_layers[$_go])
						$_go = $go;
						$go++;
					}
					
					$group_layers[$_go] = $nlayer;
				}
				
				$this->container_mode = 'column';
				
				//sort now the $group_layers
				if(!empty($group_layers)){
					ksort($group_layers);
					
					$this->increase_layer_depth();
					
					foreach($group_layers as $nlayer){
						$this->set_layer($nlayer);
						$this->add_layer(true);
					}
					
					$this->decrease_layer_depth();
				}
				
				echo $this->ld().RS_T7.$this->add_closing_comment().'</rs-column>'.$this->add_opening_comment();
				echo "\n"; //as we have used 'column' in the add_layer() function, it does not print the closing </> and we have to do it here
			}
		}
	}
	
	/**
	 * returns the HTML layer type
	 */
	public function get_html_layer_type(){
		$type = $this->get_layer_type();
		return 'data-type="'.esc_attr($type).'"';
	}

	/**
	 * return the layer Type for further needs	 
	 */
	public function get_layer_type() {
		$layer = $this->get_layer();
		return $this->get_val($layer, 'type', 'text');
	} 
	
	/**
	 * Adds a Layer to the stage
	 * Moved most code part from putCreativeLayer into putLayer
	 * @since: 5.3.0
	 * @before: RevSliderOutput::putLayer()
	 */
	public function add_layer($row_group_uid = false, $special_type = false){
		$layer = apply_filters('revslider_putLayer_pre', $this->get_layer(), $this, $row_group_uid, $this->is_static, $special_type);
		$this->layer_additions = array();
		$this->set_layer($layer);
		$this->set_layer_unique_id();
		
		/**
		 * top middle and bottom are placeholder layers, do not write them
		  **/
		if(in_array($this->get_layer_unique_id(), array('top', 'middle', 'bottom'), true)) return '';
		
		//$this->push_layer_class();
		$check_continue		= $this->check_layer_continue($special_type, $row_group_uid);
		if(!$check_continue) return false;
		$check_continue		= $this->check_layer_video_continue();
		if(!$check_continue) return false;
		$html_type			= $this->get_html_layer_type();
		$class				= $this->get_layer_class();
		$html_simple_link	= $this->get_action_link();
		$html_responsive	= $this->get_html_responsive();
		$html_transform 	= $this->get_html_transform();
		$html_filters_on_mask 	= $this->get_html_filters_on_mask();
		$html_responsive_data = $this->get_html_responsive_data();
		$html_scrollbased_data = $this->get_html_scrollbased_data();
		$html_resp_offset	= $this->get_html_responsive_offset();
		$ids				= $this->get_html_layer_ids();
		$html_title			= $this->get_html_title();
		$html_tabindex		= $this->get_html_tab_index();
		$html_rel			= $this->get_html_rel();
		$position			= $this->get_html_layer_position();
		$html_text			= $this->get_html_text_data();
		$html_float			= $this->get_float_clear_data();
		$html_color			= $this->get_html_color_data();
		$html_box_shadow	= $this->get_html_box_shadow_data();
		$html_text_shadow	= $this->get_html_text_shadow_data();
		$html_dimension		= $this->get_html_dim_data();
		$html_visibility	= $this->get_html_layer_device_visibility();
		$html_column_break	= $this->get_html_column_break();
		$layer_actions		= $this->get_html_layer_action($html_simple_link);
		$layer_tag			= $this->get_layer_tag($html_simple_link, $special_type);
		$html_class			= $this->get_html_class($class, $layer_tag);
		$html_svg			= $this->get_html_svg();
		$html_base_align	= $this->get_html_base_align();
		$html_wrapper_ids	= $this->get_html_wrapper_ids();
		$html_wrapper_classes = $this->get_html_wrapper_classes();
		$html_static_data	= $this->get_html_static_layer();
		$html_static_pos_data = $this->get_html_static_position_layer();
		$html_trigger		= $this->get_html_trigger();
		$html_clip			= $this->get_html_clip();
		$frames				= $this->get_frames();
		$html_frames		= $this->get_html_frames($frames);
		$html_frameorder	= $this->get_html_frameorder();
		$html_blendmode		= $this->get_html_blendmode();
		$html_hideunder		= $this->get_html_hideunder();
		$html_audio_data	= $this->get_html_audio_data();
		$html_video_data	= $this->get_html_video_data();
		$html_column_data	= $this->get_html_column_data();
		$html_margin_data	= $this->get_html_margin_data($row_group_uid);
		$html_padding_data	= $this->get_html_padding_data();
		$html_border_data	= $this->get_html_border_data();
		$html_inline_style	= $this->get_html_inline_style();
		$html_spike_data	= $this->get_html_spike_data();
		$html_text_stroke	= $this->get_html_text_stroke();
		//$html_togglehover	= $this->get_html_togglehover();
		$html_bg_image		= $this->get_background_image();
		$loop_data			= $this->get_loop_data();
		$toggle_data		= $this->get_toggle_data();
		$html_corners		= $this->get_html_corners();
		$html_disp			= $this->get_html_disp();
		$html_layer			= $this->get_html_layer();
		$html_layer_additions = $this->get_html_layer_additions();
		$layertype 			= $this->get_layer_type();

		$this->create_style_hover();
		
		echo "\n";
		echo $this->ld().RS_T7.$this->add_closing_comment();
		echo '<'.$layer_tag."\n";
		echo ($ids != '')					? $this->ld().RS_T8.$ids." \n" : '';
		echo ($html_class !== '')			? $this->ld().RS_T8.$html_class."\n" : '';
		echo ($html_simple_link !== '')		? $this->ld().RS_T8.$html_simple_link."\n" : '';
		echo 								  $this->ld().RS_T8.$html_type."\n";
		echo ($html_color !== '')			? $this->ld().RS_T8.$html_color."\n" : '';
		echo ($html_box_shadow !== '')		? $this->ld().RS_T8.$html_box_shadow."\n" : '';
		echo ($html_text_shadow !== '')		? $this->ld().RS_T8.$html_text_shadow."\n" : '';
		echo ($html_responsive !== '')		? $this->ld().RS_T8.$html_responsive."\n" : '';
		echo ($html_title != '') 			? $this->ld().RS_T8.$html_title."\n" : '';
		echo ($html_tabindex != '')			? $this->ld().RS_T8.$html_tabindex."\n" : '';
		echo ($html_rel != '')				? $this->ld().RS_T8.$html_rel."\n" : '';
		echo ($position != '')				? $this->ld().RS_T8.$position."\n" : '';
		echo ($html_text != '')				? $this->ld().RS_T8.$html_text."\n" : '';
		echo ($html_float != '')			? $this->ld().RS_T8.$html_float."\n" : '';
		echo ($html_dimension != '')		? $this->ld().RS_T8.$html_dimension."\n" : '';
		echo ($html_spike_data != '')		? $this->ld().RS_T8.$html_spike_data."\n" : '';
		echo ($html_text_stroke != '')		? $this->ld().RS_T8.$html_text_stroke."\n" : '';
		echo ($html_visibility != '')		? $this->ld().RS_T8.$html_visibility."\n" : '';
		echo ($html_column_break != '')		? $this->ld().RS_T8.$html_column_break."\n" : '';
		echo ($layer_actions != '')			? $this->ld().RS_T8.$layer_actions."\n" : '';
		echo ($html_svg != '')				? $this->ld().RS_T8.$html_svg : '';
		echo ($html_base_align != '')		? $this->ld().RS_T8.$html_base_align."\n" : '';
		echo ($html_resp_offset != '')		? $this->ld().RS_T8.$html_resp_offset."\n" : '';
		echo ($html_wrapper_ids != '')		? $this->ld().RS_T8.$html_wrapper_ids."\n" : '';
		echo ($html_wrapper_classes != '')	? $this->ld().RS_T8.$html_wrapper_classes."\n" : '';
		echo ($html_responsive_data != '')	? $this->ld().RS_T8.$html_responsive_data."\n" : '';
		echo ($html_transform != '') 		? $this->ld().RS_T8.$html_transform."\n" : '';
		echo ($html_filters_on_mask != '') 	? $this->ld().RS_T8.$html_filters_on_mask."\n" : '';
		echo ($html_scrollbased_data != '')	? $this->ld().RS_T8.$html_scrollbased_data."\n" : '';
		echo ($html_static_data != '')		? $this->ld().RS_T8.$html_static_data."\n" : '';
		echo ($html_static_pos_data != '')	? $this->ld().RS_T8.$html_static_pos_data."\n" : '';
		echo ($html_trigger != '')			? $this->ld().RS_T8.$html_trigger."\n" : '';
		echo ($html_blendmode != '')		? $this->ld().RS_T8.$html_blendmode."\n" : '';
		//echo ($html_togglehover != '')		? $this->ld().RS_T8.$html_togglehover."\n" : '';
		echo ($html_hideunder != '')		? $this->ld().RS_T8.$html_hideunder."\n" : '';
		echo ($html_corners != '')			? $this->ld().RS_T8.$html_corners."\n" : '';
		echo ($html_disp != '')				? $this->ld().RS_T8.$html_disp."\n" : '';
		
		echo ($html_audio_data != '')		? $html_audio_data : '';
		echo ($html_video_data != '')		? $html_video_data : ''; //$this->ld().RS_T8.   ."\n"
		echo ($html_column_data != '')		? $this->ld().RS_T8.$html_column_data."\n" : '';
		echo ($html_margin_data != '')		? $this->ld().RS_T8.$html_margin_data."\n" : '';
		echo ($html_padding_data != '')		? $this->ld().RS_T8.$html_padding_data."\n" : '';
		echo ($html_border_data != '')		? $this->ld().RS_T8.$html_border_data."\n" : '';
		echo ($html_frameorder != '')		? $this->ld().RS_T8.$html_frameorder."\n" : '';
		echo ($html_clip != '')				? $this->ld().RS_T8.$html_clip."\n" : '';
		
		echo ($html_frames != '')			? $this->ld().RS_T8.$html_frames : '';
		
		echo ($html_layer_additions != '')	? $html_layer_additions : '';
		
		if(!empty($loop_data)){
			foreach($loop_data as $ldk => $ld){
				echo ($ld !== '') ? $this->ld().RS_T8.'data-'.$ldk.'="'.$ld.'"'."\n" : '';
			}
		}

		
		
		do_action('revslider_add_layer_attributes', $layer, $this->slide, $this->slider, $this);
		
		echo $this->ld().RS_T8.'style="';
		echo $html_inline_style;
		//echo $html_idle_style;
		echo '"'."\n";
		echo $this->ld().RS_T7.'>';//."\n";
		echo ($html_bg_image !== '') ? $html_bg_image."\n" : '';
		if($special_type !== false){
			echo $this->add_opening_comment();
		}
		
		if($toggle_data['allow'] === true){
			echo "\n".$this->ld().RS_T8.'<div class="';
			echo ($toggle_data['inverse_content'] === true) ? 'rs-toggled-content' : 'rs-untoggled-content';
			echo '">';
		}
		
		//echo ($special_type === false && $layertype !== 'video') ? apply_filters('revslider_layer_content', stripslashes($html_layer), $html_layer, $this->slider->get_id(), $this->slide, $layer).' ' : '';
		echo ($special_type === false && $layertype !== 'video') ? apply_filters('revslider_layer_content', $html_layer, $html_layer, $this->slider->get_id(), $this->slide, $layer).' ' : '';
		
		if($toggle_data['allow'] === true){
			echo '</div>';
			echo "\n".$this->ld().RS_T8.'<div class="';
			echo ($toggle_data['inverse_content'] === true) ?  'rs-untoggled-content' : 'rs-toggled-content';
			echo '">'.stripslashes($toggle_data['html']).'</div>';
		}
		
		if($special_type === false){
			echo "\n".$this->ld().RS_T7.'</'.$layer_tag.'>'.$this->add_opening_comment()."\n";
		} //the closing will be written later, after all layers/columns are added //
		
		$this->zIndex++;
	}
	
	/**
	 * check if the layer is okay to be added or if we should move to the next layer
	 **/
	public function check_layer_continue($special_type, $row_group_uid){
		$layer	= $this->get_layer();
		$type	= $this->get_val($layer, 'type', 'text');
		
		//if($this->get_val($layer, array('visibility', 'visible'), true); == false) return false;
		switch($type){
			case 'row':
				if($special_type !== 'row') return false;
			break;
			case 'group':
				if($special_type !== 'group') return false;
			break;
			case 'column':
				if($special_type !== 'column') return false;
			break;
		}
		if($row_group_uid == false && $this->is_in_group_or_row()){
			return false; //if we are not in a row or group and the layer is in one, return false
		}
		
		return true;
	}
	
	
	/**
	 * check if the layer is okay to be added or if we should move to the next layer
	 **/
	public function check_layer_video_continue(){
		$layer	= $this->get_layer();
		
		if($this->get_val($layer, 'type', 'text') !== 'video') return true;
		$video_type = trim($this->get_val($layer, array('media', 'mediaType')));
		$video_type = ($video_type === '') ? 'html5' : $video_type;
		
		if(!in_array($video_type, array('streamyoutube', 'streamyoutubeboth', 'youtube', 'streamvimeo', 'streamvimeoboth', 'vimeo', 'streaminstagram', 'streaminstagramboth', 'html5'), true)) return true;
		
		$vid = trim($this->get_val($layer, array('media', 'id')));
		
		switch($video_type){
			case 'streaminstagram':
			case 'streaminstagramboth':
			case 'html5':
				$ogv = trim($this->get_val($layer, array('media', 'ogvUrl'), ''));
				$webm = trim($this->get_val($layer, array('media', 'webmUrl'), ''));
				$mp4 = trim($this->remove_http($this->get_val($layer, array('media', 'mp4Url'), '')));
				
				if(empty($ogv) && empty($webm) && empty($mp4)){
					$vid = trim($this->get_val($layer, array('media', 'id')));
					$vid = ($this->get_val($layer, array('media', 'videoFromStream'), false) === true) ? $this->slide->get_param(array('bg', 'mpeg'), '') : $vid;
					return (empty($vid)) ?  false : true;
				}
				
				return true;
			break;
			case 'youtube':
			case 'streamyoutube':
			case 'streamyoutubeboth':
				$vid = (in_array($video_type, array('streamyoutube', 'streamyoutubeboth'), true)) ? $this->slide->get_param(array('bg', 'youtube'), '') : $vid; //change $vid to the stream!
				$vid = ($this->get_val($layer, array('media', 'videoFromStream'), false) === true) ? $this->slide->get_param(array('bg', 'youtube'), '') : $vid;
				$this->youtube_exists = (empty($vid)) ? $this->youtube_exists : true;

				return (empty($vid)) ?  false : true;
			break;
			case 'vimeo':
			case 'streamvimeo':
			case 'streamvimeoboth':
				$vid = (in_array($video_type, array('streamvimeo', 'streamvimeoboth'), true)) ? $this->slide->get_param(array('bg', 'vimeo'), '') : $vid;
				$vid = ($this->get_val($layer, array('media', 'videoFromStream'), false) === true) ? $this->slide->get_param(array('bg', 'vimeo'), '') : $vid;
				
				return (empty($vid)) ?  false : true;
			break;
		}
		
		return (empty($vid)) ?  false : true;
	}

	/**
	 * get the simple link that can be inside the actions of a layer
	 **/
	public function get_action_link(){
		$link	= '';
		$layer	= $this->get_layer();
		$action	= $this->get_val($layer, array('actions', 'action'), array());
		
		if(!empty($action)){
			foreach($action as $act){
				// these are needed for the Social Share AddOn
				$action_type = apply_filters('rs_action_type', $this->get_val($act, 'action'));
				$link_type = apply_filters('rs_action_link_type', $this->get_val($act, 'link_type', ''));
				if($action_type === 'menu'){					
					$http      = $this->get_val($act, 'link_help_in', 'keep');
					$menu_link = $this->remove_http($this->get_val($act, 'menu_link', ''), $http);
					$menu_link = do_shortcode($menu_link);
					$link_open_in = $this->get_val($act, 'link_open_in', '');
					$link_follow = $this->get_val($act, 'link_follow', '');
					$link = 'href="'.$menu_link.'"';
					$link .= ($link_open_in !== '') ? ' target="'.$link_open_in.'"' : '';
					if($link_follow === 'nofollow'){
						$link .= ' rel="nofollow';
						$link .= ($link_open_in === '_blank') ? ' noopener' : '';
						$link .= '"';
					}else{
						$link .= ($link_open_in === '_blank') ? ' rel="noopener"' : '';
					}
					break;
				}
				if($action_type === 'link'){
					if($link_type !== 'jquery'){
						$http		= $this->get_val($act, 'link_help_in', 'keep');
						$image_link = $this->remove_http($this->get_val($act, 'image_link', ''), $http);
						$image_link = do_shortcode($image_link);
						$link_open_in = $this->get_val($act, 'link_open_in', '');
						$link_follow = $this->get_val($act, 'link_follow', '');
						
						$link = 'href="'.$image_link.'"';
						$link .= ($link_open_in !== '') ? ' target="'.$link_open_in.'"' : '';
						if($link_follow === 'nofollow'){
							$link .= ' rel="nofollow';
							$link .= ($link_open_in === '_blank') ? ' noopener' : '';
							$link .= '"';
						}else{
							$link .= ($link_open_in === '_blank') ? ' rel="noopener"' : '';
						}
					}
					
					break;
				}
			}
		}
		
		return $link;
	}
	
	/**
	 * get the layer tag as it can change through settings and others
	 **/
	public function get_layer_tag($html_simple_link, $special_type = false){
		$layer	= $this->get_layer();
		$tag	= $this->get_val($layer, 'htmltag', 'rs-layer');
		
		if($html_simple_link !== '') $tag = 'a';
		if($special_type !== false)	 $tag = 'rs-'.$special_type; //if we are special type, only allow div to be the structure, as we will close with a div outside of this function
		
		return ($tag !== 'div') ? $tag : 'rs-layer';
	}
	
	/**
	 * get the layer classes
	 **/
	public function get_layer_class(){
		$layer	= $this->get_layer();
		$type	= $this->get_val($layer, 'type', 'text');
		$class	= array();
		
		$acs = $this->get_val($layer, array('attributes', 'classes'), '');
		if(strpos($acs, ' ') !== false){
			$acs = explode(' ', $acs);
			foreach($acs as $ac){
				$class[] = $ac;
			}
		}else{
			$class[] = $acs;
		}
		
		$idle_class	= $this->get_val($layer, array('idle', 'style'), '');
		$internal_class = $this->get_val($layer, array('runtime', 'internalClass'), '');
		$selectable	= $this->get_val($layer, array('idle', 'selectable'), 'default');
		$svg		= $this->get_val($layer, 'svg', false);
		
		if($idle_class !== '') $class[] = $idle_class;
		if($internal_class !== '') $class[] = $internal_class;
		
		if($selectable !== 'default'){
			if($this->_truefalse($selectable) == true) $class[] = 'rs-selectable';
		}else{
			if($this->slider->get_param(array('general', 'layerSelection'), false) == true) $class[] = 'rs-selectable';
		}
		
		if($this->get_val($layer, array('hover', 'pointerEvents'), 'auto') == 'none') $class[] = 'rs-noevents';
		
		//make some modifications for the full screen video
		if($this->is_full_width_video() == true) $class[] = 'rs-fsv';
		if($this->get_val($layer, array('idle', 'overflow')) === 'hidden') $class[] = 'rs-ov-hidden';
		if(!empty($svg)) $class[] = 'rs-svg';
		
		if($type == 'video'){
			switch(trim($this->get_val($layer, array('media', 'mediaType')))){
				case 'streaminstagram':
				case 'streaminstagramboth':
				case 'html5':
					if($this->get_val($layer, array('media', 'largeControls'), true) === false){
						$class[] = 'rs-nolc';
					}else{
						global $rs_revicons;
						$rs_revicons = true;
					}
				break;
			}
		}
		
		if($this->slider->get_param(array('parallax', 'set'), false) == true){
			$level = $this->get_val($layer, array('effects', 'parallax'), '-');				
			$level = ($this->slider->get_param(array('parallax', 'setDDD'), false) == true && $level == '-' && $this->get_val($layer, array('effects', 'attachToBg'), '') === true) ? 'tobggroup' : $level;
			if($level !== '-') $class[] = 'rs-pxl-'.$level;			
		}
		
		if($this->is_static) $class[] = 'rs-layer-static';
		if($type == 'video') $class[] = 'rs-layer-video';
		if($type == 'audio'){
			$class[] = 'rs-layer-audio';
			$visible = $this->get_val($layer, array('media', 'controls'), false);
			if($visible === false) $class[] = 'rs-layer-hidden';
		}
		
		if($this->get_val($layer, array('visibility', 'onlyOnSlideHover'), false) === true){
			$class[] = 'rs-on-sh';
		}

		if($this->slider->get_param('type', 'standard') === 'carousel'){
			if($this->get_val($layer, array('visibility', 'alwaysOnCarousel'), false) === true){
				$class[] = 'rs-on-car';
			}
		}
		
		$add_intrinsic = false;
		$text		 = strtolower($this->get_val($layer, 'text', ''));
		$text_toggle = $this->get_val($layer, array('toggle', 'text'), '');
		$tag		 = $this->get_val($layer, 'htmltag', 'rs-layer');
		
		if($type == 'video') $add_intrinsic = true;
		if(strpos($text, '<iframe') !== false || strpos($text_toggle, '<iframe') !== false) $add_intrinsic = true;
		if($tag == 'iframe' && array_search('rs-layer', $class) !== false) $add_intrinsic = true;
		
		if($add_intrinsic) $class[] = 'intrinsic-ignore';
		
		$actions	= $this->get_val($layer, array('actions', 'action'), array());
		if(!empty($actions)){
			foreach($actions as $action){
				if($this->get_val($action, 'action') !== 'getAccelerationPermission') continue;
				
				$class[] = 'iospermaccwait';
				break;
			}
		}

		return implode(' ', $class);
	}
	
	/**
	 * create hover style, will later be pushed into the header css
	 **/
	public function create_style_hover(){
		$layer	= $this->get_layer();
		
		//check if hover is active for the slider
		if($this->get_val($layer, array('hover', 'usehover'), false) === false || $this->get_val($layer, array('hover', 'usehover'), false) === 'false') return false;
		
		$id		= $this->get_html_layer_ids(true);
		$_css	= RevSliderGlobals::instance()->get('RevSliderCssParser');
		$style	= array($id => array()); 
		
		/**
		 * customHoverCSS only exists in a Slider imported/existed before 6.0.
		 * It is taken from the navigation tables advanced -> hover
		 **/
		$custom_css = $this->get_val($layer, 'customHoverCSS', '');
		if(!empty($custom_css)){
			$custom_css = $_css->css_to_array('nec {'.$custom_css.'}');
			$_nec = $this->get_val($custom_css, 'nec', array());
			if(!empty($_nec)){
				foreach($_nec as $n => $v){
					$style[$id][$n] = $v;
				}
			}
		}
		
		if(!empty($style[$id])){
			$this->set_hover_css($style);
		}
		
		return true;
	}
	
	/**
	 * this function will return css in javascript format only if its ajax loaded
	 * otherwise it will add the css to a queue which will then be printed by revslider-front.class.php or if its cached through the cache tool
	 **/
	public function get_css_javascript($css_html){
		global $rs_loaded_by_editor;

		$html = '';
		$css_class = RevSliderGlobals::instance()->get('RevSliderCssParser');
		if($this->usage === 'modal' && $this->ajax_loaded === true || $this->ajax_loaded === true || $rs_loaded_by_editor === true){
			$css = (!is_admin()) ? $css_class->compress_css(rawurlencode($css_html)) : $css_class->compress_css($css_html);
			if(empty(trim($css))) return $html;
			
			if(!is_admin()){
				$html .= RS_T4.'<script>'."\n";
				$html .= RS_T5.'var htmlDivCss = unescape("'. $css .'");'."\n";
				$html .= RS_T5."var htmlDiv = document.getElementById('rs-plugin-settings-inline-css');"."\n";
				$html .= RS_T5.'if(htmlDiv) {'."\n";
				$html .= RS_T6.'htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;'."\n";
				$html .= RS_T5.'}else{'."\n";
				$html .= RS_T6."var htmlDiv = document.createElement('div');"."\n";
				$html .= RS_T6."htmlDiv.innerHTML = '<style>' + htmlDivCss + '</style>';"."\n";
				$html .= RS_T6."document.getElementsByTagName('head')[0].appendChild(htmlDiv.childNodes[0]);"."\n";
				$html .= RS_T5.'}'."\n";
				$html .= RS_T4.'</script>'."\n";
			}else{
				$me = $this->get_markup_export();
				$html .= ($me === true) ? '<!-- STYLE -->' : '';
				$html .= RS_T4 .'<style>'. $css .'</style>';
				$html .= ($me === true) ? '<!-- /STYLE -->' : '';
			}
		}else{
			global $rs_css_collection;
			$css = $css_class->compress_css($css_html);
			if(empty(trim($css))) return $html;
			$rs_css_collection[] = $css;
			if($this->caching){
				$cache = RevSliderGlobals::instance()->get('RevSliderCache');
				$cache->add_addition('special', 'rs_css_collection', $css);
			}
		}
		
		return $html;
	}
	
	
	/**
	 * add hover style into the headers css.
	 * this is outside of the frame_hover so some special things happen here
	 **/
	public function add_style_hover(){
		$css = $this->get_hover_css();
		$html = '';
		
		if(!empty($css)){
			$css_html = '';
			
			foreach($css as $id => $_css){
				$css_html .= '#'.$id.':hover{';
				foreach($_css as $k => $v){
					$css_html .= $k.':'.$v.';';
				}
				$css_html .= '}'."\n";
			}
			
			if($css_html == '') return '';
			
			$html = $this->get_css_javascript($css_html);
		}
		
		echo $html;
	}
	
	/**
	 * get layer inline style
	 **/
	public function get_html_inline_style(){
		$style	= array();
		$layer	= $this->get_layer();
		$type	= $this->get_val($layer, 'type', 'text');
		$img	= trim($this->get_val($layer, array('idle', 'backgroundImage'), ''));
		$img_id	= $this->get_val($layer, array('idle', 'backgroundImageId'));
		$img_t	= $this->get_val($layer, array('behavior', 'imageSourceType'), 'full');
		$zi		= $this->get_val($layer, array('position', 'zIndex'), false);
		$zi		= ($zi === false) ? $this->zIndex : $zi;
		
		$style['z-index'] = $zi;
		
		//Replace image when featured image is in use
		if($this->get_val($layer, array('idle', 'bgFromStream')) === true){ //if image is choosen, use featured image as background
			$stream_background_image = $this->get_stream_background_image($layer);
			$img = $stream_background_image['url'];
			$img_id = $stream_background_image['id'];
			$img_t = $stream_background_image['size'];
		}
		
		if($img !== '' && !in_array($type, array('group', 'shape', 'row'), true)){
			if($img_t !== 'full' && $img_id !== false && !empty($img_id)){
				$_img = wp_get_attachment_image_src($img_id, $img_t);
				$img = ($_img !== false) ? $_img[0] : $img;
			}
			
			$objlib = new RevSliderObjectLibrary();
			$objlib->_check_object_exist($img); //redownload if needed
			
			$global = $this->get_global_settings();
			$lazyloadbg = $this->get_val($global, 'lazyonbg', false);
			if($lazyloadbg !== false && $lazyloadbg !== 'false'){
				$this->layer_additions['data-bglazy'] = $img;
				$img = RS_PLUGIN_URL.'public/assets/assets/dummy.png';
			}

			$style['background'] = "url('".$img."')";
			$style['background'] .= ' '.$this->get_val($layer, array('idle', 'backgroundRepeat'), 'no-repeat');
			$style['background'] .= ' '.$this->get_val($layer, array('idle', 'backgroundPosition'), 'center center');
			$bgs = $this->get_val($layer, array('idle', 'backgroundSize'), 'cover');
			$bgs = ($bgs === 'percentage') ? $this->get_val($layer, array('idle', 'backgroundSizePerc'), '100').'%' : $bgs;
			$bgs = ($bgs === 'pixel') ? $this->get_val($layer, array('idle', 'backgroundSizePix'), '100').'px' : $bgs;
			$style['background-size'] = $bgs;
		}
		
		$bgcolor = $this->get_val($layer, array('idle', 'backgroundColor'), 'transparent');
		if($bgcolor !== 'transparent'){
			$bgcolor = RSColorpicker::get($bgcolor);
			if(strpos($bgcolor, 'gradient') !== false){
				$style['background'] = $bgcolor;
			}else{
				$style['background-color'] = $bgcolor;
			}
		}
		
		if(!in_array($type, array('image', 'video', 'row', 'column', 'group', 'shape', 'audio'), true)){
			$style['font-family'] = str_replace(array('"', "'"), "", $this->get_val($layer, array('idle', 'fontFamily'), 'Roboto'));
			$font_family		  = explode(',', $style['font-family']);
			$style['font-family'] = (!empty($font_family) && is_array($font_family)) ? array_map('trim', $font_family) : trim($font_family);
			$style['font-family'] = (!empty($style['font-family'])) ? "'" . implode("', '", $style['font-family']) . "'"  : '';
		}
		
		$text_transform = $this->get_val($layer, array('idle', 'textTransform'), 'none');
		if($text_transform !== 'none'){
			$style['text-transform'] = $text_transform;
		}
		
		$fs = $this->get_val($layer, array('idle', 'fontStyle'), 'off');
		if($fs == 'on' || $fs == 'italic'){
			$style['font-style'] = 'italic';
		}

		$mc = $this->get_val($layer, array('idle', 'cursor'), 'auto');		
		if($mc !== 'auto' && $mc !== 'default'){
			$style['cursor'] = $mc;
		}
		
		if($type === 'column'){
			$style['width'] = '100%';
		}
		if($this->container_mode === 'column' && $type !== 'row' && $this->get_val($layer, array('idle', 'display'), 'block') !== 'block'){
			$style['display'] = $this->get_val($layer, array('idle', 'display'));
		}

		//Advanced Styles here:
		$custom_css = $this->get_val($layer, 'customCSS', '');
		if(!empty($custom_css)){
			$_css	= RevSliderGlobals::instance()->get('RevSliderCssParser');
			$custom_css = $_css->css_to_array('nec {'.$custom_css.'}');
			$_nec = $this->get_val($custom_css, 'nec', array());
			if(!empty($_nec)){
				foreach($_nec as $n => $v){
					$style[$n] = $v;
				}
			}
		}
		
		$html = '';
		if(!empty($style)){
			foreach($style as $k => $v){
				$v = trim($v);
				$html .= (!in_array($v, array('', 'px', '%'), true)) ? $k.':'.$v.';' : '';
			}
		}		
		return $html;
	}
	
	
	/**
	 * push the needed material icon css to the frondend
	 **/
	public function get_material_icons_css(){
		global $rs_material_icons_css, $rs_material_icons_css_parsed;
		
		if($rs_material_icons_css === false) return '';
		if($rs_material_icons_css_parsed === true) return '';

		$html = $this->get_css_javascript($rs_material_icons_css);

		$rs_material_icons_css_parsed = true;
		
		return $html;
	}
	
	/**
	 * Check if material Icons CSS needs to be written or if it is already written
	 **/
	public function set_material_icon_css(){
		global $rs_material_icons_css;
		
		$layers = $this->get_layers();
		
		if($rs_material_icons_css !== false) return '';
		if(empty($layers)) return '';
		
		foreach($layers as $layer){
			$text = $this->get_val($layer, 'text', '');
			$text_toggle = $this->get_val($layer, array('toggle', 'text'), '');
			if(strpos($text, 'material-icons') !== false || strpos($text_toggle, 'material-icons') !== false){
				$gs = $this->get_global_settings();
				if($this->get_val($gs, 'fontdownload', 'off') === 'off'){
					$font_face = "@font-face {
  font-family: 'Material Icons';
  font-style: normal;
  font-weight: 400;  
  src: url(//fonts.gstatic.com/s/materialicons/v41/flUhRq6tzZclQEJ-Vdg-IuiaDsNcIhQ8tQ.woff2) format('woff2');
}";
				}else{
					$font_face = "@font-face {
  font-family: 'Material Icons';
  font-style: normal;
  font-weight: 400;  
  
  src: local('Material Icons'),
    	local('MaterialIcons-Regular'),
  		url(".RS_PLUGIN_URL."public/assets/fonts/material/MaterialIcons-Regular.woff2) format('woff2'),
  		url(".RS_PLUGIN_URL."public/assets/fonts/material/MaterialIcons-Regular.woff) format('woff'),  
		url(".RS_PLUGIN_URL."public/assets/fonts/material/MaterialIcons-Regular.ttf) format('truetype');
}";
				}
				$rs_material_icons_css = "/* 
ICON SET 
*/
".$font_face."

rs-module .material-icons {
  font-family: 'Material Icons';
  font-weight: normal;
  font-style: normal;
	font-size: inherit;
  display: inline-block;  
  text-transform: none;
  letter-spacing: normal;
  word-wrap: normal;
  white-space: nowrap;
  direction: ltr;
  vertical-align: top;
  line-height: inherit;
  /* Support for IE. */
  font-feature-settings: 'liga';

  -webkit-font-smoothing: antialiased;
  text-rendering: optimizeLegibility;
  -moz-osx-font-smoothing: grayscale;
}";
			}
		}
		
		return '';
	}
	
	
	/**
	 * add the custom navigation css
	 **/
	public function add_custom_navigation_css(){
		$slides = $this->slider->get_slides();
		if(empty($slides)) return;
		
		$html		= '';
		$rs_nav		= new RevSliderNavigation();
		$all_navs	= $rs_nav->get_all_navigations();

		$enable_arrows		= $this->slider->get_param(array('nav', 'arrows', 'set'), false);
		$enable_bullets		= $this->slider->get_param(array('nav', 'bullets', 'set'), false);
		$enable_tabs		= $this->slider->get_param(array('nav', 'tabs', 'set'), false);
		$enable_thumbnails	= $this->slider->get_param(array('nav', 'thumbs', 'set'), false);
		if($this->slider->get_param('type', 'standard') !== 'hero' && ($enable_arrows == true || $enable_bullets == true || $enable_tabs == true || $enable_thumbnails == true)){
			foreach($slides as $slide){
				if(!empty($all_navs)){
					foreach($all_navs as $cur_nav){
						//get modifications out, wrap the class with slide class to be specific
						if($enable_arrows == true && $cur_nav['id'] == $this->slider->get_param(array('nav', 'arrows', 'style'), 'new-bullet-bar')){
							$this->rs_custom_navigation_css .= $rs_nav->add_placeholder_sub_modifications($cur_nav['css'], $cur_nav['handle'], 'arrows', $cur_nav['placeholders'], $slide, $this)."\n";
						}
						if($enable_bullets == true && $cur_nav['id'] == $this->slider->get_param(array('nav', 'bullets', 'style'), 'round')){
							$this->rs_custom_navigation_css .= $rs_nav->add_placeholder_sub_modifications($cur_nav['css'], $cur_nav['handle'], 'bullets', $cur_nav['placeholders'], $slide, $this)."\n";
						}
						if($enable_tabs == true && $cur_nav['id'] == $this->slider->get_param(array('nav', 'tabs', 'style'), 'round')){
							$this->rs_custom_navigation_css .= $rs_nav->add_placeholder_sub_modifications($cur_nav['css'], $cur_nav['handle'], 'tabs', $cur_nav['placeholders'], $slide, $this)."\n";
						}
						if($enable_thumbnails == true && $cur_nav['id'] == $this->slider->get_param(array('nav', 'thumbs', 'style'), 'new-bullet-bar')){
							$this->rs_custom_navigation_css .= $rs_nav->add_placeholder_sub_modifications($cur_nav['css'], $cur_nav['handle'], 'thumbs', $cur_nav['placeholders'], $slide, $this)."\n";
						}
					}
				}
			}
			
			if(!empty($this->rs_custom_navigation_css)){
				$html = $this->get_css_javascript($this->rs_custom_navigation_css);
			}
		}
		
		return $html;
	}
	

	/**
	 * get the layer basic transform
	 */
	public function get_html_transform() {
		$layer	= $this->get_layer();
		$html	= '';

		$rx = intval($this->get_val($layer, array('idle', 'rotationX'), 0));
		$ry = intval($this->get_val($layer, array('idle', 'rotationY'), 0));
		$rz = intval($this->get_val($layer, array('idle', 'rotationZ'), 0));
		$iosfx = $this->get_val($layer, array('idle', 'filtersIOSFix'), 'd');
		$op = $this->get_val($layer, array('idle', 'opacity'), 1);
		
		if($rx !== 0) $html .='rX:'.$rx.';';
		if($ry !== 0) $html .='rY:'.$ry.';';
		if($rz !== 0) $html .='rZ:'.$rz.';';
		if($op !== 1) $html .='o:'.$op.';';
		if($iosfx !== 'd') $html .='iosfx:'.$iosfx.';';
		
		return ($html !== '') ? 'data-btrans="'.$html.'"' : $html;
	}

	/**
	 * get the layer filters on mask option
	 */
	public function get_html_filters_on_mask() {
		$layer	= $this->get_layer();
		$fm = intval($this->get_val($layer, array('timeline', 'filtersOnMask'), false));	
		return ($fm != false) ? 'data-fsom="true"' : '';
	}

	/**
	 * get the layer responsiveness 
	 **/
	public function get_html_responsive(){
		$layer	= $this->get_layer();
		$html	= '';
		
		if(in_array($this->get_val($layer, 'type', 'text'), array('row', 'column'), true)) return $html;
		
		if($this->get_val($layer, array('behavior', 'autoResponsive'), true) === true){
			$html .= ($this->get_val($layer, array('behavior', 'responsiveChilds'), true)) ? 'data-rsp_ch="on"' : '';
		}
		
		return $html;
	}
	
	/**
	 * get the layer ids as HTML
	 **/
	public function get_html_layer_ids($raw = false){
		$layer = $this->get_layer();
		$ids = $this->get_val($layer, array('attributes', 'id'));
		
		$ss	 = $this->get_static_slide();
		$uid = $this->get_layer_unique_id();
		if(trim($ids) == ''){
			$ids = (!empty($ss)) 
				? 'slider-'.preg_replace("/[^\w]+/", "", $this->slider->get_id()).'-slide-'.preg_replace("/[^\w]+/", "", $this->get_slide_id()).'-layer-'.$uid
				: 'slide-'.preg_replace("/[^\w]+/", "", $this->get_slide_id()).'-layer-'.$uid;
		}
		
		if($raw === false){
			$ids = ($ids != '') ? 'id="'.$ids.'"' : '';
		}
		
		return $ids;
	}
	
	/**
	 * get the layer ids as HTML
	 **/
	public function get_html_title(){
		$layer = $this->get_layer();
		$title = $this->get_val($layer, array('attributes', 'title'));
		
		return ($title != '') ? 'title="'.$title.'"' : '';
	}
	
	/**
	 * get the HTML tab index
	 **/
	public function get_html_tab_index(){
		$layer		= $this->get_layer();
		$tabindex	= $this->get_val($layer, array('attributes', 'tabIndex'));
		
		return		(!in_array($tabindex, array('', '0', 0), true)) ? 'tabindex="'.$tabindex.'"' : '';
	}
	
	/**
	 * get the HTML rel
	 **/
	public function get_html_rel(){
		$layer = $this->get_layer();
		$rel = $this->get_val($layer, array('attributes', 'rel'));
		
		return ($rel != '') ? 'rel="'.$rel.'"' : '';
	}
	
	/**
	 * get the HTML layer x and y position
	 **/
	public function get_html_layer_position(){
		$f = array('top', 'right', 'bottom', 'left', 'center', 'middle');
		$t = array('t', 'r', 'b', 'l', 'c', 'm');
		
		$xy = 'data-xy="';
		if($this->is_full_width_video() == true){
			$xy .= 'x:0;';
			$xy .= 'y:0;';
		}else{
			$layer		= $this->get_layer();
			$alignHor	= $this->get_val($layer, array('position', 'horizontal'));
			$alignVert	= $this->get_val($layer, array('position', 'vertical'));
			$left		= $this->get_val($layer, array('position', 'x'));
			$top		= $this->get_val($layer, array('position', 'y'));
			
			if($this->adv_resp_sizes == true){
				//remove from myTop and myLeft 0 and 0px
				$myHor	= $this->normalize_device_settings($alignHor, $this->enabled_sizes, 'html-array', array('l'));
				$myLeft	= $this->normalize_device_settings($left, $this->enabled_sizes, 'html-array', array('0', '0px'));
				$myVer	= $this->normalize_device_settings($alignVert, $this->enabled_sizes, 'html-array', array('t'));
				$myTop	= $this->normalize_device_settings($top, $this->enabled_sizes, 'html-array', array('0', '0px'));
				
				$myHor	= $this->shorten($myHor, $f, $t);
				$myLeft	= $this->shorten($myLeft, $f, $t);
				$myVer	= $this->shorten($myVer, $f, $t);
				$myTop	= $this->shorten($myTop, $f, $t);
				
				$xy .= (!in_array($myHor, array('', 0, '0', '0px'), true)) ? 'x:'.$myHor.';' : '';
				$xy .= (!in_array($myLeft, array('', 0, '0', '0px'), true)) ? 'xo:'.$myLeft.';' : '';
				$xy .= (!in_array($myVer, array('', 0, '0', '0px'), true)) ? 'y:'.$myVer.';' : '';
				$xy .= (!in_array($myTop, array('', 0, '0', '0px'), true)) ? 'yo:'.$myTop.';' : '';
			}else{
				$alignHor	= $this->get_biggest_device_setting($alignHor, $this->enabled_sizes);
				$alignVert	= $this->get_biggest_device_setting($alignVert, $this->enabled_sizes);
				$left		= $this->get_biggest_device_setting($left, $this->enabled_sizes);
				$top		= $this->get_biggest_device_setting($top, $this->enabled_sizes);
				
				$left		= $this->shorten($left, $f, $t);
				$top		= $this->shorten($top, $f, $t);
				
				switch($alignHor){
					default:
					case 'left':
						$xy .= ($left !== '') ? 'x:'.$left.';' : '';
					break;
					case 'center':
						$left = (in_array($left, array('', 0, '0', '0px'), true)) ? '' : $left;
						$xy .= 'x:c;';
						$xy .= ($left !== '') ? 'xo:'.$left.';' : '';
					break;
					case 'right':
						$left = (in_array($left, array('', 0, '0', '0px'), true)) ? '' : $left;
						$xy .= 'x:r;';
						$xy .= ($left !== '') ? 'xo:'.$left.';' : '';
					break;
				}
				
				switch($alignVert){
					default:
					case 'top':
						$xy .= ($top !== '') ? 'y:'.$top.';' : '';
					break;
					case 'middle':
						$top = (in_array($top, array('', 0, '0', '0px'), true)) ? '' : $top;
						$xy .= 'y:c;';
						$xy .= ($top !== '') ? 'yo:'.$top.';' : '';
					break;
					case 'bottom':
						$top = (in_array($top, array('', 0, '0', '0px'), true)) ? '' : $top;
						$xy .= 'y:b;';
						$xy .= ($top !== '') ? 'yo:'.$top.';' : '';
					break;
				}
			}
		}
		
		$xy .= '"';
		
		return ($xy !== 'data-xy=""') ? $xy : '';
	}
	
	/**
	 * get the data-text data HTML
	 **/
	public function get_html_text_data(){
		$layer = $this->get_layer();
		$text = 'data-text="';
		$data = array();
		
		$type = $this->get_val($layer, 'type', 'text');
		
		$de = array(
			's' => array(20, '20', '20px'),
			'l' => (in_array($type, array('text', 'button'))) ? array(25, '25', '25px') : array(0, '0', '0px'),
			'ls' => array(0, '0', '0px'),
			'fw' => array(400, '400'),
			'w' => array('nowrap'),
			'a' => array('left'),
			'f' => array('none'),
			'c' => array('none')
		);
		
		if($this->adv_resp_sizes == true){
			$ws = $this->normalize_device_settings($this->get_val($layer, array('idle', 'whiteSpace')), $this->enabled_sizes, 'html-array', $de['w']);
		}else{
			$ws	= $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'whiteSpace'), $de['w'][0]), $this->enabled_sizes);
		}
		
		$ws = (strpos($ws, 'content') !== false) ? str_replace('content', 'nowrap', $ws) : $ws;
		$ws = (strpos($ws, 'full') !== false) ? str_replace('full', 'normal', $ws) :  $ws;
		
		$data['w'] = $ws;
		
		if($this->adv_resp_sizes == true){
			$data['s']	= $this->normalize_device_settings($this->get_val($layer, array('idle', 'fontSize')), $this->enabled_sizes, 'html-array', $de['s']);
			$data['f']	= $this->normalize_device_settings($this->get_val($layer, array('idle', 'float')), $this->enabled_sizes, 'html-array', $de['f']);
			$data['c']	= $this->normalize_device_settings($this->get_val($layer, array('idle', 'clear')), $this->enabled_sizes, 'html-array', $de['c']);
			$data['l']	= $this->normalize_device_settings($this->get_val($layer, array('idle', 'lineHeight')), $this->enabled_sizes, 'html-array', $de['l']);
			$data['ls']	= $this->normalize_device_settings($this->get_val($layer, array('idle', 'letterSpacing')), $this->enabled_sizes, 'html-array', $de['ls']);
			$data['fw']	= $this->normalize_device_settings($this->get_val($layer, array('idle', 'fontWeight')), $this->enabled_sizes, 'html-array', $de['fw']);
			$data['a']	= $this->normalize_device_settings($this->get_val($layer, array('idle', 'textAlign')), $this->enabled_sizes, 'html-array', $de['a']);
		}else{
			$data['s']	= $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'fontSize')), $this->enabled_sizes);
			$data['f']	= $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'float')), $this->enabled_sizes);
			$data['c']	= $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'clear')), $this->enabled_sizes);
			$data['l']	= $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'lineHeight')), $this->enabled_sizes);
			$data['ls']	= $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'letterSpacing')), $this->enabled_sizes);
			$data['fw']	= $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'fontWeight')), $this->enabled_sizes);
			$data['a']	= $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'textAlign')), $this->enabled_sizes);
		}
		
		$data['s'] = str_replace('px', '', $data['s']);
		$data['l'] = str_replace('px', '', $data['l']);
		
		//only one size every available, so its outside of the if() check from before
		$textDecoration = $this->get_val($layer, array('idle', 'textDecoration'));
		if($textDecoration !== 'none'){
			$data['td']	= $textDecoration;
		}
		
		if(!empty($data)){
			foreach($data as $k => $d){
				if(!empty($d)){
					if($d !== ''){
						$text .= $k.':'.$d.';';
					}
				}
			}
		}
		
		$text .= '"';
		
		return ($text !== 'data-text=""') ? $text : '';
	}

	/**
	 * get the data-float data HTML
	 **/
	public function get_float_clear_data(){
		$layer = $this->get_layer();
		$text = 'data-flcr="';
		$data = array();
		
		$de = array(
			'f' => array('none'),
			'c' => array('none')
		);
		
		if($this->adv_resp_sizes == true){
			$data['f'] = $this->normalize_device_settings($this->get_val($layer, array('idle', 'float')), $this->enabled_sizes, 'html-array', $de['f']);
			$data['c'] = $this->normalize_device_settings($this->get_val($layer, array('idle', 'clear')), $this->enabled_sizes, 'html-array', $de['c']);
		}else{			
			$data['f'] = $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'float')), $this->enabled_sizes);
			$data['c'] = $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'clear')), $this->enabled_sizes);
		}
		
		if(!empty($data)){
			foreach($data as $k => $d){
				if(!empty($d)){
					if($d !== ''){
						$text .= $k.':'.$d.';';
					}
				}
			}
		}
		
		$text .= '"';
		
		return ($text !== 'data-flcr=""') ? $text : '';
	}
	
	/**
	 * get the data-color="" HTML
	 **/
	public function get_html_color_data(){
		$layer	= $this->get_layer();
		$type	= $this->get_val($layer, 'type', 'text');
		$text	= 'data-color="';
		
		if(in_array($type, array('text', 'svg', 'button'), true)){
			if($this->adv_resp_sizes == true){
				$color = $this->normalize_device_settings($this->get_val($layer, array('idle', 'color'), '#ffffff'), $this->enabled_sizes, 'html-array', array('#ffffff'), array('' => '#ffffff'), '||');
			}else{
				$color = $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'color'), '#ffffff'), $this->enabled_sizes);
				$color = (trim($color) === '') ? '#ffffff' : $color;
			}
			$text .= ($color !== '') ? $color : '';
		}
		
		$text .= '"';
		
		return ($text !== 'data-color=""') ? $text : '';
	}
	
	/**
	 * get the data-bsh="" HTML
	 **/
	public function get_html_box_shadow_data(){
		$layer = $this->get_layer();
		$text = 'data-bsh="';
		
		if($this->get_val($layer, array('idle', 'boxShadow', 'inuse'), false) === true){
			$color = str_replace(' ', '', $this->get_val($layer, array('idle', 'boxShadow', 'color'), 'rgba(0,0,0,0)'));
			
			if($this->get_val($layer, array('idle', 'boxShadow', 'container'), 'content') !== 'content') $text.= 'e:w'; //w for wrapper
			if(!in_array($color, array('rgba(0,0,0,0)', '#000000'))) $text.= 'c:'.$color.';';
			
			$data = array();
			if($this->adv_resp_sizes == true){
				$data['h'] = $this->normalize_device_settings($this->get_val($layer, array('idle', 'boxShadow', 'hoffset')), $this->enabled_sizes, 'html-array', array(0));
				$data['v'] = $this->normalize_device_settings($this->get_val($layer, array('idle', 'boxShadow', 'voffset')), $this->enabled_sizes, 'html-array', array(0));
				$data['b'] = $this->normalize_device_settings($this->get_val($layer, array('idle', 'boxShadow', 'blur')), $this->enabled_sizes, 'html-array', array(0));
				$data['s'] = $this->normalize_device_settings($this->get_val($layer, array('idle', 'boxShadow', 'spread')), $this->enabled_sizes, 'html-array', array(0));
			}else{
				$data['h'] = $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'boxShadow', 'hoffset')), $this->enabled_sizes, 0);
				$data['v'] = $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'boxShadow', 'voffset')), $this->enabled_sizes, 0);
				$data['b'] = $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'boxShadow', 'blur')), $this->enabled_sizes, 0);
				$data['s'] = $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'boxShadow', 'spread')), $this->enabled_sizes, 0);
			}
			
			if(!empty($data)){
				foreach($data as $k => $v){
					$text .= (!in_array(trim($v), array(0, '0', '0px', ''), true)) ? $k.':'.$v.';' : '';
				}
			}
		}
		
		$text .= '"';
		
		return ($text !== 'data-bsh=""') ? $text : '';
	}
	
	/**
	 * get the data-tsh="" HTML
	 **/
	public function get_html_text_shadow_data(){
		$layer	= $this->get_layer();
		$text	= 'data-tsh="';
		
		if($this->get_val($layer, 'type', 'text') === 'text'){
			if($this->get_val($layer, array('idle', 'textShadow', 'inuse'), false) === true){
				$color	= str_replace(' ', '', $this->get_val($layer, array('idle', 'textShadow', 'color'), 'rgba(0,0,0,0.25)'));
				
				if($this->get_val($layer, array('idle', 'textShadow', 'container'), 'content') !== 'content') $text.= 'e:w'; //w for wrapper
				if(!in_array($color, array('rgba(0,0,0,0.25)'))) $text.= 'c:'.$color.';';
				
				$data = array();
				if($this->adv_resp_sizes == true){
					$data['h'] = $this->normalize_device_settings($this->get_val($layer, array('idle', 'textShadow', 'hoffset')), $this->enabled_sizes, 'html-array', array(0));
					$data['v'] = $this->normalize_device_settings($this->get_val($layer, array('idle', 'textShadow', 'voffset')), $this->enabled_sizes, 'html-array', array(0));
					$data['b'] = $this->normalize_device_settings($this->get_val($layer, array('idle', 'textShadow', 'blur')), $this->enabled_sizes, 'html-array', array(0));
				}else{
					$data['h'] = $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'textShadow', 'hoffset')), $this->enabled_sizes, 0);
					$data['v'] = $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'textShadow', 'voffset')), $this->enabled_sizes, 0);
					$data['b'] = $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'textShadow', 'blur')), $this->enabled_sizes, 0);
				}
				
				if(!empty($data)){
					foreach($data as $k => $v){
						$text .= (!in_array(trim($v), array(0, '0', '0px', ''), true)) ? $k.':'.$v.';' : '';
					}
				}
			}
		}
		
		$text .= '"';
		
		return ($text !== 'data-tsh=""') ? $text : '';
	}
	
	/**
	 * get the data-dim="" HTML
	 **/
	public function get_html_dim_data(){
		$dim	= 'data-dim="';
		$layer	= $this->get_layer();
		$type	= $this->get_val($layer, 'type', 'text');
		$data	= array();
		
		if($type !== 'column'){
			if($this->adv_resp_sizes == true){
				$data['w']	= $this->normalize_device_settings($this->get_val($layer, array('size', 'width')), $this->enabled_sizes, 'html-array', array('auto'));
				$data['h']	= $this->normalize_device_settings($this->get_val($layer, array('size', 'height')), $this->enabled_sizes, 'html-array', array('auto'));
				
				$data['maxw'] = $this->normalize_device_settings($this->get_val($layer, array('size', 'maxWidth'), 'auto'), $this->enabled_sizes, 'html-array', array('none'), array('none' => 'n'));
				$data['maxh'] = $this->normalize_device_settings($this->get_val($layer, array('size', 'maxHeight'), 'auto'), $this->enabled_sizes, 'html-array', array('none'), array('none' => 'n'));
				$data['minw'] = $this->normalize_device_settings($this->get_val($layer, array('size', 'minWidth'), 'auto'), $this->enabled_sizes, 'html-array', array('none'), array('none' => 'n'));
				$data['minh'] = $this->normalize_device_settings($this->get_val($layer, array('size', 'minHeight'), 'auto'), $this->enabled_sizes, 'html-array', array('none'), array('none' => 'n'));
			}else{
				
				$data['w'] = $this->get_biggest_device_setting($this->get_val($layer, array('size', 'width')), $this->enabled_sizes);
				$data['h'] = $this->get_biggest_device_setting($this->get_val($layer, array('size', 'height')), $this->enabled_sizes);
				
				$data['maxw'] = $this->get_biggest_device_setting($this->get_val($layer, array('size', 'maxWidth'), 'auto'), $this->enabled_sizes);
				$data['maxh'] = $this->get_biggest_device_setting($this->get_val($layer, array('size', 'maxHeight'), 'auto'), $this->enabled_sizes);
				$data['minw'] = $this->get_biggest_device_setting($this->get_val($layer, array('size', 'minWidth'), 'auto'), $this->enabled_sizes);
				$data['minh'] = $this->get_biggest_device_setting($this->get_val($layer, array('size', 'minHeight'), 'auto'), $this->enabled_sizes);
			}
			
			if($type === 'video'){
				$data['w'] = ($this->is_full_width_video() == true) ? '100%' : $data['w'];
				$data['h'] = ($this->is_full_width_video() == true) ? '100%' : $data['h'];
			}
			if($type === 'image'){
				$scaleX		= $this->get_val($layer, array('size', 'width'));
				$scaleY		= $this->get_val($layer, array('size', 'height'));
				$cover_mode	= $this->get_val($layer, array('size', 'covermode'), array());
				$cover_mode	= (is_string($cover_mode)) ? array('d' => $cover_mode, 'n' => $cover_mode, 't' => $cover_mode, 'm' => $cover_mode) : (array)$cover_mode;
				
				if($this->adv_resp_sizes == true){
					foreach($cover_mode as $cvmk => $cvmv){
						if($cvmv !== 'custom' && $cvmv !== 'fullheight'){
							$this->set_val($scaleX, array($cvmk, 'v'), '100%');
						}
						if($cvmv !== 'custom' && $cvmv !== 'fullwidth'){
							$this->set_val($scaleY, array($cvmk, 'v'), '100%');
						}
					}
					
					$myScaleX = $this->normalize_device_settings($scaleX, $this->enabled_sizes, 'html-array', array('auto'), array('NaNpx' => '', 'auto' => ''));
					$myScaleY = $this->normalize_device_settings($scaleY, $this->enabled_sizes, 'html-array', array('auto'), array('NaNpx' => '', 'auto' => ''));
					
					if($myScaleX == "'','','',''") $myScaleX = '';
					if($myScaleY == "'','','',''") $myScaleY = '';
					
					$x_is_single = (strpos($myScaleX, ',') !== false) ? false : true;
					$y_is_single = (strpos($myScaleY, ',') !== false) ? false : true;
					
					if($x_is_single){ //force to array if voffset is also array
						if(!isset($myScaleX)) $myScaleX = $this->get_biggest_device_setting($scaleX, $this->enabled_sizes);
						$myScaleX = (trim($myScaleX) == '' || $myScaleX == 'NaNpx' || $myScaleX == 'auto') ? '' : "['".$myScaleX."','".$myScaleX."','".$myScaleX."','".$myScaleX."']";
					}
					if($y_is_single){ //force to array if voffset is also array
						if(!isset($myScaleY)) $myScaleY = $this->get_biggest_device_setting($scaleY, $this->enabled_sizes);
						$myScaleY = (trim($myScaleY) == '' || $myScaleY == 'NaNpx' || $myScaleY == 'auto') ? '' : "['".$myScaleY."','".$myScaleY."','".$myScaleY."','".$myScaleY."']";
					}
					
				}else{
					$myScaleX = $this->get_biggest_device_setting($scaleX, $this->enabled_sizes);
					if(trim($myScaleX) == '' || $myScaleX == 'NaNpx') $myScaleX = 'auto';
					
					$myScaleY = $this->get_biggest_device_setting($scaleY, $this->enabled_sizes);
					if(trim($myScaleY) == '' || $myScaleY == 'NaNpx') $myScaleY = 'auto';
					
					foreach($cover_mode as $cvmk => $cvmv){
						if($cvmv !== 'custom' && $cvmv !== 'fullheight'){
							$myScaleX = '100%';
						}
						if($cvmv !== 'custom' && $cvmv !== 'fullwidth'){
							$myScaleY = '100%';
						}
						break;
					}
				}
				
				if($myScaleX != '') $data['w'] = $myScaleX;
				if($myScaleY != '') $data['h'] = $myScaleY;
				
			}
			
			if(!empty($data)){
				foreach($data as $k => $v){
					$dim .= (!in_array(trim($v), array(-1, '-1', '', 'auto'), true)) ? $k.':'.$v.';' : '';
				}
			}
		}
		
		$dim .= '"';
		
		return ($dim !== 'data-dim=""') ? $dim : '';
	}
	
	/**
	 * return the column break HTML
	 **/
	public function get_html_column_break(){
		$layer = $this->get_layer();
		$break = '';
		
		if($this->get_val($layer, 'type', 'text') === 'row') {
			$break = $this->get_val($layer, array('group', 'columnbreakat'), 'tablet');
			if($break === 'desktop')	$break = '0';
			if($break === 'notebook')	$break = '1';
			if($break === 'tablet')		$break = ''; //as default, dont write it, so set it back to empty (was 2)
			if($break === 'mobile')		$break = '3';
		}
		
		return ($break != '') ? 'data-cbreak="'.$break.'"' : '';
	}
	
	/**
	 * retrieves the current layer attribute id by given target
	 **/
	public function get_layer_attribute_id($target){
		$layer_attribute_id = $this->slide->get_layer_id_by_uid($target, $this->static_slide);
		
		if($target == 'backgroundvideo' || $target == 'firstvideo'){
			$layer_attribute_id = $target;
		}elseif(trim($layer_attribute_id) == ''){
			if(strpos($target, 'static-') !== false){
				$ss = $this->get_static_slide();
				$layer_attribute_id = 'slider-'.preg_replace("/[^\w]+/", "", $this->slider->get_id()).'-slide-'.$ss->get_id().'-layer-'.str_replace('static-', '', $target);
				//$layer_attribute_id = 'slider-'.preg_replace("/[^\w]+/", "", $this->slider->get_id()).'-slide-'.$this->get_slide_id().'-layer-'.str_replace('static-', '', $target);
			}elseif($this->static_slide){
				$layer_attribute_id = 'slider-'.preg_replace("/[^\w]+/", "", $this->slider->get_id()).'-slide-'.preg_replace("/[^\w]+/", "", $this->get_slide_id()).'-layer-'.str_replace('static-', '', $target);
			}else{
				$layer_attribute_id = 'slide-'.preg_replace("/[^\w]+/", "", $this->get_slide_id()).'-layer-'.$target;
			}
		}
		
		return $layer_attribute_id;
	}
	
	/**
	 * create the layer action HTML
	 **/
	public function get_html_layer_action(&$html_simple_link){
		$layer		 = $this->get_layer();
		$html		 = "data-actions='";
		$events		 = array();
		$all_actions = $this->get_val($layer, 'actions', array());
		$actions	 = $this->get_val($all_actions, 'action', array());
		
		if(!empty($actions)){
			foreach($actions as $num => $action){
				$layer_attribute_id = '';
				$act = $this->get_val($action, 'action');
				
				switch($act){
					case 'start_in':
					case 'start_out':
					case 'start_video':
					case 'stop_video':
					case 'toggle_layer':
					case 'toggle_frames':
					case 'toggle_video':
					case 'simulate_click':
					case 'toggle_class':
					case 'toggle_mute_video':
					case 'mute_video':
					case 'unmute_video':
					case 'start_frame':
					case 'next_frame':
					case 'prev_frame':
						//get the ID of the layer with the uid that is $target
						$target = $this->get_val($action, 'layer_target', '');
						
						$layer_attribute_id = $this->get_layer_attribute_id($target);
					break;
				}
				
				/**
				 * translation list
				 * o = event, a = action, d = delay
				 **/
				switch($act){
					case 'none':
						continue 2;
					break;
					case 'menu':
						$menu_link = $this->get_val($action, 'menu_link', '');
						$menu_link = do_shortcode($menu_link);
						$http		= $this->get_val($action, 'link_help_in', 'keep');
						$events[] = array(
							'o'		 => $this->get_val($action, 'tooltip_event', ''),
							'a'		 => 'menulink',
							'target' => $this->remove_http($this->get_val($action, 'link_open_in', ''), $http),
							'url' 	 => $menu_link,
							'anchor' => $this->get_val($action, 'menu_anchor', ''),
							'offset' => $this->get_val($action, 'scrollunder_offset', ''),
							'sp'	 => $this->get_val($action, 'action_speed', '300'),
							'e'	 	 => $this->get_val($action, 'action_easing', 'none'),
							'd'		 => $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
						$easing = $this->get_val($action, 'action_easing', 'none');
						$this->easings[$easing] = $easing;
					break;
					case 'link':
						//if post based, replace {{}} with correct info
						//image_link
						$image_link = $this->get_val($action, 'image_link', '');
						$image_link = do_shortcode($image_link);
						$http		= $this->get_val($action, 'link_help_in', 'keep');
						if($this->get_val($action, 'link_type', '') == 'jquery'){
							$events[] = array(
								'o'		 => $this->get_val($action, 'tooltip_event', ''),
								'a'		 => 'simplelink',
								'target' => $this->remove_http($this->get_val($action, 'link_open_in', ''), $http),
								'url' 	 => $image_link,
								'd'		 => $this->get_val($action, 'action_delay', ''),
								'rd'	 => $this->get_val($action, 'action_repeats', '')
							);
						}
					break;
					case 'jumpto':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'jumptoslide',
							'slide'	=> 'rs-'.$this->get_val($action, 'jump_to_slide', ''),
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'next':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'jumptoslide',
							'slide'	=> 'next',
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'gofullscreen':
						$events[] = array(
							'o'	=> $this->get_val($action, 'tooltip_event', ''),
							'a'	=> 'gofullscreen',
							'd'	=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'toggle_global_mute_video':
						$events[] = array(
							'o'	=> $this->get_val($action, 'tooltip_event', ''),
							'a'	=> 'toggle_global_mute_video',
							'd'	=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'exitfullscreen':
						$events[] = array(
							'o'	=> $this->get_val($action, 'tooltip_event', ''),
							'a'	=> 'exitfullscreen',
							'd'	=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'togglefullscreen':
						$events[] = array(
							'o'	=> $this->get_val($action, 'tooltip_event', ''),
							'a'	=> 'togglefullscreen',
							'd'	=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'prev':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'jumptoslide',
							'slide'	=> 'previous',
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'pause':
						$events[] = array(
							'o'	=> $this->get_val($action, 'tooltip_event', ''),
							'a'	=> 'pauseslider',
							'd'	=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'resume':
						$events[] = array(
							'o'	=> $this->get_val($action, 'tooltip_event', ''),
							'a'	=> 'playslider',
							'd'	=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'toggle_slider':
						$events[] = array(
							'o'	=> $this->get_val($action, 'tooltip_event', ''),
							'a'	=> 'toggleslider',
							'd'	=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'open_modal':
						$_modal = $this->get_val($action, 'openmodal', '');
						$_event = array(
							'o'	=> $this->get_val($action, 'tooltip_event', ''),
							'a'	=> 'openmodal',
							'modal' => $_modal,
							'ms' => $this->get_val($action, 'modalslide', ''),
							'd'	=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
						if(!empty($_modal)){
							if(!isset($this->modal_sliders[$_modal])){
								global $rs_do_init_action;
								$rs_do_init_action = false;
								$this->modal_sliders[$_modal] = new RevSliderSlider();
								$this->modal_sliders[$_modal]->init_by_mixed($_modal, false);
								$_event['sp'] = $this->modal_sliders[$_modal]->get_param(array('modal', 'coverSpeed'), 1);
								$rs_do_init_action = true;
							}
							if($this->modal_sliders[$_modal]->get_param(array('modal', 'allowPageScroll'), false) === true){
								$_event['allowPageScroll'] = true;
							}
							if($this->modal_sliders[$_modal]->get_param(array('modal', 'cover'), true) === true){
								$_event['bg'] = $this->modal_sliders[$_modal]->get_param(array('modal', 'coverColor'), 'rgba(0,0,0,0.5)');
							}
							if($this->modal_sliders[$_modal]->get_param(array('layout', 'spinner', 'type'), 'off') !== 'off'){
								$_event['spin'] = $this->modal_sliders[$_modal]->get_param(array('layout', 'spinner', 'type'), '0');
								$_event['spinc'] = $this->modal_sliders[$_modal]->get_param(array('layout', 'spinner', 'color'), '#FFFFFF');
							}
						}
						
						$events[] = $_event;
						
						$this->frontend_action = true;
					break;
					case 'close_modal':
						$events[] = array(
							'o'	=> $this->get_val($action, 'tooltip_event', ''),
							'a'	=> 'closemodal',
							'd'	=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'callback':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'callback',
							'call'	=> $this->replace_html_ids($this->get_val($action, 'actioncallback', '')),
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'scroll_under': //ok
						$events[] = array(
							'o'		 => $this->get_val($action, 'tooltip_event', ''),
							'a'		 => 'scrollbelow',
							'offset' => $this->get_val($action, 'scrollunder_offset', ''),
							'd'		 => $this->get_val($action, 'action_delay', ''),
							'sp'	 => $this->get_val($action, 'action_speed', '300'),
							'e'	 	 => $this->get_val($action, 'action_easing', 'none'),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
						$easing = $this->get_val($action, 'action_easing', 'none');
						$this->easings[$easing] = $easing;
					break;
					case 'scrollto': //ok
						$events[] = array(
							'id'	 => $this->replace_html_ids($this->get_val($action, 'scrollto_id', ''), ''),
							'o'		 => $this->get_val($action, 'tooltip_event', ''),
							'a'		 => 'scrollto',
							'offset' => $this->get_val($action, 'scrollunder_offset', ''),
							'd'		 => $this->get_val($action, 'action_delay', ''),
							'sp'	 => $this->get_val($action, 'action_speed', '300'),
							'e'	 	 => $this->get_val($action, 'action_easing', 'none'),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
						$easing = $this->get_val($action, 'action_easing', 'none');
						$this->easings[$easing] = $easing;
					break;
					case 'start_in':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'startlayer',
							'layer'	=> $layer_attribute_id,
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'ch'	=> $this->get_val($action, 'updateChildren', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;					
					case 'getAccelerationPermission':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'getAccelerationPermission',
							'layer'	=> $layer_attribute_id,
							'd'		=> $this->get_val($action, 'action_delay', ''),							
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'next_frame':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'nextframe',
							'layer'	=> $layer_attribute_id,
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'ch'	=> $this->get_val($action, 'updateChildren', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'prev_frame':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'prevframe',
							'layer'	=> $layer_attribute_id,
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'ch'	=> $this->get_val($action, 'updateChildren', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'start_frame':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'gotoframe',
							'layer'	=> $layer_attribute_id,
							'f'		=> $this->get_val($action, 'gotoframe', ''),
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'ch'	=> $this->get_val($action, 'updateChildren', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'start_out':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'stoplayer',
							'layer'	=> $layer_attribute_id,
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'ch'	=> $this->get_val($action, 'updateChildren', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'toggle_layer':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'togglelayer',
							'ls'	=> $this->get_val($action, 'toggle_layer_type', ''),
							'layer'	=> $layer_attribute_id,
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'ch'	=> $this->get_val($action, 'updateChildren', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'toggle_frames':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'toggleframes',
							'ls'	=> $this->get_val($action, 'toggle_layer_type', ''),
							'm'	=> $this->get_val($action, 'gotoframeM', ''),
							'n'	=> $this->get_val($action, 'gotoframeN', ''),
							'layer'	=> $layer_attribute_id,
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'ch'	=> $this->get_val($action, 'updateChildren', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'start_video':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'playvideo',
							'layer'	=> $layer_attribute_id,
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'stop_video':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'stopvideo',
							'layer'	=> $layer_attribute_id,
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'mute_video':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'mutevideo',
							'layer'	=> $layer_attribute_id,
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'unmute_video':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'unmutevideo',
							'layer'	=> $layer_attribute_id,
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'toggle_video':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'togglevideo',
							'layer'	=> $layer_attribute_id,
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'toggle_mute_video':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'toggle_mute_video',
							'layer'	=> $layer_attribute_id,
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'simulate_click':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'simulateclick',
							'layer'	=> $layer_attribute_id,
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
					case 'toggle_class':
						$events[] = array(
							'o'		=> $this->get_val($action, 'tooltip_event', ''),
							'a'		=> 'toggleclass',
							'layer'	=> $layer_attribute_id,
							'd'		=> $this->get_val($action, 'action_delay', ''),
							'class'	=> $this->get_val($action, 'toggle_class', ''),
							'rd'	 => $this->get_val($action, 'action_repeats', '')
						);
					break;
				}
				
				// Filter the Actions
				$events = apply_filters('rs_action_output_layer_action', $events, $action, $all_actions, $num, $this->slide, $this);
				if(!isset($html_simple_link)){
					$html_simple_link = '';
				}
				$html_simple_link = apply_filters('rs_action_output_layer_simple_link', $html_simple_link, $action, $all_actions, $num, $this->slide, $this->slider, $events, $this);
			}
			
			if(!empty($events)){
				$first = true;
				foreach($events as $event){
					if(!empty($event)){
						$html .= ($first === false) ? '||' : '';
						foreach($event as $k => $v){
							if(!in_array($v, array(''), true)){
								if(is_bool($v)) $v = ($v === true) ? 'true' : 'false';
								$html .= $k.':'.$v.';';
							}
						}
						
						$first = false;
					}
				}
			}
		}
		
		$html .= "'";
		
		return ($html !== "data-actions=''") ? $html : '';
	}
	
	/**
	 * get the html class for a layer
	 **/
	public function get_html_class($class, $layer_tag){
		$html = 'class="';
		$c = array();
		if(!in_array($layer_tag, array('rs-row', 'rs-column', 'rs-layer', 'rs-group', 'rs-bgvideo'), true)){
			$c[] = 'rs-layer';
		}
		if(trim($class) !== ''){
			$c[] = trim($class);
		}
		
		if($this->get_html_tab_index() !== ''){
			$c[] = 'rs-wtbindex';
		}
		
		if($this->slider->get_param(array('parallax', 'set'), false) === true){
			$layer = $this->get_layer();
			if($this->get_val($layer, array('effects', 'parallax'), '-') !== '-'){
				if($this->get_val($layer, array('effects', 'pxmask'), false) === true){
					$c[] = 'rs-pxmask';
				}
			}
		}
		
		$c = apply_filters('revslider_add_layer_classes', $c, $this->layer, $this->slide, $this->slider);
				
		if(!empty($c)){
			$html .= implode(' ', $c);
		}

		$html .= '"';
		
		return ($html !== 'class=""') ? $html : '';
	}
	
	/**
	 * get the html svg attributes from the layer
	 **/
	public function get_html_svg(){
		$layer = $this->get_layer();
		$svg_html = '';
		$svg = array();
		$svg_source = $this->get_val($layer, array('svg', 'source'));
		if(!empty($svg_source)){
			$svg['svg_src'] = $this->remove_http($svg_source);
			
			$push = array('svgi' => 'idle');
			if($this->get_val($layer, array('hover', 'usehover'), false) === true || $this->get_val($layer, array('hover', 'usehover'), false) === 'true' || $this->get_val($layer, array('hover', 'usehover'), false) === 'desktop'){
				$push['svgh'] = 'hover';
			}
			
			foreach($push as $tag => $path){
				$svg[$tag] = array();
				$oc = $this->get_val($layer, array($path, 'svg', 'originalColor'), 0);				
				$c = $this->get_val($layer, array($path, 'svg', 'color'), '#ffffff');
				$sc = $this->get_val($layer, array($path, 'svg', 'strokeColor'), 'transparent');
				$sw = $this->get_val($layer, array($path, 'svg', 'strokeWidth'), 0);
				$sa = $this->get_val($layer, array($path, 'svg', 'strokeDashArray'), '');
				$so = $this->get_val($layer, array($path, 'svg', 'strokeDashOffset'), '');
				$sall = $this->get_val($layer, array($path, 'svg', 'styleAll'), false);
					
				/*
					SVG Idle Color can have responsive values, but SVG Hover Color is not responsive
					The ($path === 'idle') if-block below fixes an issue where the hover color 
					.. would not print if the Slider didn't have any responsive breakpoints enabled
				*/
				if($path === 'idle') {
					if($this->adv_resp_sizes == true){
						$c = $this->normalize_device_settings($c, $this->enabled_sizes, 'html-array', array('#ffffff'), array(), '||');
					}else{
						$c = $this->get_biggest_device_setting($c, $this->enabled_sizes);
					}
				}
				
				if ($oc===true) {
					$svg[$tag]['oc'] = 't';
				} else {	
					if(!in_array(strtolower($c), array('#fff', '#ffffff')) && $c !== '') $svg[$tag]['c'] = $c;
					if($sc !== 'transparent') $svg[$tag]['sc'] = $sc;
					if(!in_array($sw, array(0, '0', '0px'), true)) $svg[$tag]['sw'] = $sw;
					if($sa !== '') $svg[$tag]['sa'] = $sa;
					if($so !== '') $svg[$tag]['so'] = $so;
					if($sall !== '' && $sall !== false) $svg[$tag]['sall'] = $sall;
				}
				
				
				if(empty($svg[$tag]) || $svg[$tag] === " ") unset($svg[$tag]);
			}
		}
		
		if(!empty($svg)){
			foreach($svg as $tag => $vals){
				if($svg_html !== '') $svg_html .= $this->ld().RS_T8;
				$svg_html .= 'data-'.$tag.'="';
				
				if(is_array($vals)){
					foreach($vals as $key => $val){
						$svg_html .= $key.':'.$val.';';
					}
				}else{
					$svg_html .= $vals;
				}
				
				$svg_html .= '"'."\n";
			}
		}
		
		return $svg_html;
	}
	
	/**
	 * get the html base_align
	 **/
	public function get_html_base_align(){
		$layer		= $this->get_layer();
		$base_align	= $this->get_val($layer, array('behavior', 'baseAlign'), 'grid');
		
		return ($base_align !== 'grid') ? 'data-basealign="'.$base_align.'"' : '';
	}
	
	/**
	 * get the html responsive offset
	 **/
	public function get_html_responsive_offset(){
		$layer = $this->get_layer();
		
		return ($this->get_val($layer, array('behavior', 'responsiveOffset'), true) === false) ? 'data-rsp_o="off"' : '';
	}
	
	/**
	 * get the html wrapper ids
	 **/
	public function get_html_wrapper_ids(){
		$layer		 = $this->get_layer();
		$wrapper_ids = $this->get_val($layer, array('attributes', 'wrapperId'));
		
		return ($wrapper_ids !== '') ? 'data-wrpid="'.$wrapper_ids.'"' : '';
	}
	
	/**
	 * get the html wrapper classes
	 **/
	public function get_html_wrapper_classes(){
		$layer = $this->get_layer();
		$class = $this->get_val($layer, array('attributes', 'wrapperClasses'));
		
		return ($class !== '') ? 'data-wrpcls="'.$class.'"' : '';
	}
	
	/**
	 * get the html layer responsive data
	 **/
	public function get_html_responsive_data(){
		$layer = $this->get_layer();
		$default = (in_array($this->get_val($layer, 'type', 'text'), array('row', 'column'), true)) ? false : true;
		
		return ($this->get_val($layer, array('behavior', 'autoResponsive'), $default) === false) ? 'data-rsp_bd="off"' : '';
	}

	/**
	 * get the html layer scroll based data
	 **/
	public function get_html_scrollbased_data(){
		$layer	= $this->get_layer();
		$html	= 'data-sba="';
		$sd		= $this->slider->get_param(array('scrolltimeline', 'set'), false);
		$se		= $this->slider->get_param(array('scrolleffects', 'set'), false);
		$s		= $this->get_val($layer, array('timeline', 'scrollBased'), 'default');
		$so		= $this->get_val($layer, array('timeline', 'scrollBasedOffset'), 0);
		$e		= $this->get_val($layer, array('effects', 'effect'), 'default');
		
		if($s !== 'default' && $sd === true){
			$html .= 't:';
			$html .= ($s == 'true') ? 'true' : 'false';
			$html .= ';';
		}
		
		if($e !== 'default' && $se === true){
			$html .= 'e:';
			$html .= ($e == 'true') ? 'true' : 'false';
			$html .= ';';
		}
		
		if(!in_array($so, array('0', 0, '0px'), true) && $sd === true){
			$html .= 'so:'.$so;
		}
		
		$html .='"';
		
		return ($html !== 'data-sba=""') ? $html : '';
	}

	
	/**
	 * get the html static layer data
	 * check if static layer and if yes, set values for it.
	 **/
	public function get_html_static_layer(){
		if(!$this->is_static) return '';
		
		$layer	= $this->get_layer();
		$html	= 'data-onslides="';
		
		if($this->slider->get_param('type') !== 'hero'){
			$s = intval($this->get_val($layer, array('timeline', 'static', 'start'), 1));
			$e = $this->get_val($layer, array('timeline', 'static', 'end'), 'last');
		}else{
			$s = '-1';
			$e = '-1';
		}
		
		//dont write if s is 0 and e ist the last slide
		$html .= ($s !== 0 && $s !== '') ? 's:'.$s.';' : '';
		$html .= ($e !== 'last') ? 'e:'.$e.';' : '';
		
		$html .= '"';
		
		return ($html !== 'data-onslides=""') ? $html : '';
	}
	
	/**
	 * get the html static layer data
	 * check if static layer and if yes, set values for it.
	 **/
	public function get_html_static_position_layer(){
		if(!$this->is_static) return '';
		
		$layer	= $this->get_layer();
		$static_slide = $this->get_static_slide();
		$html	= 'data-staticz="';
		
		$slp	= $static_slide->get_param(array('static', 'position'), 'front');
		$staticZ = $this->get_val($layer, array('position', 'staticZ'), $slp);
		$html .= ($staticZ !== $slp) ? $staticZ : '';
		
		$html .= '"';
		
		return ($html !== 'data-staticz=""') ? $html : '';
	}
	
	
	/**
	 * get the html layer trigger
	 **/
	public function get_html_trigger(){
		$layer			= $this->get_layer();
		$has_trigger	= $this->check_if_trigger_exists();
		$trigger_memory	= ($has_trigger) ? $this->get_val($layer, array('actions', 'triggerMemory'), 'reset') : 'keep';
		
		return ($has_trigger && $trigger_memory !== 'reset') ? 'data-triggercache="'.$trigger_memory.'"' : '';
	}
	
	/**
	 * init variables for get_frames
	 **/
	public function init_get_frames_vars(){
		
		$this->_base = array(
			'grayscale'	 => array('n' => 'gra', 'd' => array('frame_0' => 0, 'frame_1' => 0, 'default' => 'inherit'), 'depth' => array('filter', 'grayscale')), //0
			'brightness' => array('n' => 'bri', 'd' => array('frame_0' => 100, 'frame_1' => 100, 'default' => 'inherit'), 'depth' => array('filter', 'brightness')), //100
			'blur'		 => array('n' => 'blu', 'd' => array('frame_0' => 0, 'frame_1' => 0, 'default' => 'inherit'), 'depth' => array('filter', 'blur')), //100
			'bGrayscale' => array('n' => 'bG', 'd' => array('frame_0' => 0, 'frame_1' => 0, 'default' => 'inherit'), 'depth' => array('bfilter', 'grayscale')), //0
			'bBrightness' => array('n' => 'bR', 'd' => array('frame_0' => 100, 'frame_1' => 100, 'default' => 'inherit'), 'depth' => array('bfilter', 'brightness')), //100
			'bBlur'		 => array('n' => 'bB', 'd' => array('frame_0' => 0, 'frame_1' => 0, 'default' => 'inherit'), 'depth' => array('bfilter', 'blur')), //0
			'bInvert' => array('n' => 'bI', 'd' => array('frame_0' => 0, 'frame_1' => 0, 'default' => 'inherit'), 'depth' => array('bfilter', 'invert')), //0
			'bSepia'	=> array('n' => 'bS', 'd' => array('frame_0' => 0, 'frame_1' => 0, 'default' => 'inherit'), 'depth' => array('bfilter', 'sepia')), //0
			'color'		 => array('n' => 'c', 'd' => 'inherit', 'depth' => array('color', 'color')), //'#ffffff'
			'backgroundColor' => array('n' => 'bgc', 'd' => 'inherit', 'depth' => array('bgcolor', 'backgroundColor')), //'transparent'
		
			//transform
			'x'			=> array('n' => 'x', 'd' => array('frame_0' => array(0, '0', '0px', ''), 'frame_1' => array(0, '0', '0px', ''), 'default' => 'inherit'), 'depth' => array('transform', 'x')), //0
			'y'			=> array('n' => 'y', 'd' => array('frame_0' => array(0, '0', '0px', ''), 'frame_1' => array(0, '0', '0px', ''), 'default' => 'inherit'), 'depth' => array('transform', 'y')), //0
			'z'			=> array('n' => 'z', 'd' => array('frame_0' => array(0, '0', '0px', ''), 'frame_1' => array(0, '0', '0px', ''), 'default' => 'inherit'), 'depth' => array('transform', 'z')), //0
			'scaleX'	=> array('n' => 'sX', 'd' => array('frame_0' => 1, 'frame_1' => 1, 'default' => 'inherit'), 'depth' => array('transform', 'scaleX')), //0
			'scaleY'	=> array('n' => 'sY', 'd' => array('frame_0' => 1, 'frame_1' => 1, 'default' => 'inherit'), 'depth' => array('transform', 'scaleY')), //0
			'opacity'	=> array('n' => 'o', 'd' => array('frame_0' => 0, 'frame_1' => 1, 'default' => 'inherit'), 'depth' => array('transform', 'opacity')), //1
			'rotationX'	=> array('n' => 'rX', 'd' => array('frame_0' => array(0, '0', '0deg', ''), 'frame_1' => array(0, '0', '0deg', ''), 'default' => 'inherit'), 'depth' => array('transform', 'rotationX')), //0
			'rotationY'	=> array('n' => 'rY', 'd' => array('frame_0' => array(0, '0', '0deg', ''), 'frame_1' => array(0, '0', '0deg', ''), 'default' => 'inherit'), 'depth' => array('transform', 'rotationY')), //0
			'rotationZ'	=> array('n' => 'rZ', 'd' => array('frame_0' => array(0, '0', '0deg', ''), 'frame_1' => array(0, '0', '0deg', ''), 'default' => 'inherit'), 'depth' => array('transform', 'rotationZ')), //0
			'skewX'		=> array('n' => 'skX', 'd' => array('frame_0' => array(0, '0', '0px', ''), 'frame_1' => array(0, '0', '0px', ''), 'default' => 'inherit'), 'depth' => array('transform', 'skewX')), //0
			'skewY'		=> array('n' => 'skY', 'd' => array('frame_0' => array(0, '0', '0px', ''), 'frame_1' => array(0, '0', '0px', ''), 'default' => 'inherit'), 'depth' => array('transform', 'skewY')), //0
			'originX'	=> array('n' => 'oX', 'd' => array('frame_0' => '50%', 'frame_1' => '50%', 'default' => 'inherit'), 'depth' => array('transform', 'originX')), //'50%'
			'originY'	=> array('n' => 'oY', 'd' => array('frame_0' => '50%', 'frame_1' => '50%', 'default' => 'inherit'), 'depth' => array('transform', 'originY')), //'50%'
			'originZ'	=> array('n' => 'oZ', 'd' => array('frame_0' => 0, 'frame_1' => 0, 'default' => 'inherit'), 'depth' => array('transform', 'originZ')), //'0'
			'transformPerspective' => array('n' => 'tp', 'd' => true, 'depth' => array('transform', 'transformPerspective')), //'600px'
			'clip' 		=> array('n' => 'cp', 'd' => array('frame_0' => 100, 'frame_1' => 100, 'default' => 'inherit'), 'depth' => array('transform', 'clip')), //100
			'clipB' 	=> array('n' => 'cpb', 'd' => array('frame_0' => 100, 'frame_1' => 100, 'default' => 'inherit'), 'depth' => array('transform', 'clipB')), //100
		
			//timeline
			'ease' => array('n' => 'e', 'd' => array('frame_0' => false, 'default' => 'power3.inOut'), 'depth' => array('timeline', 'ease')), //'power3.inOut'
			'start' => array('n' => 'st', 'd' => array('frame_0' => false, 'frame_1' => 10, 'default' => true), 'depth' => array('timeline', 'start')), //0
			'speed' => array('n' => 'sp', 'd' => array('frame_0' => false, 'default' => 300), 'depth' => array('timeline', 'speed')), //300
			'startRelative' => array('n' => 'sR', 'd' => 0, 'depth' => array('timeline', 'startRelative')) //0
		);
		
		$this->_split = array(
			'ease'		=> array('n' => 'e', 'd' => array('frame_0' => false, 'default' => 'inherit')),
			'direction'	=> array('n' => 'dir', 'd' => array('frame_0' => false, 'default' => 'forward')), //'forward'
			'delay'		=> array('n' => 'd', 'd' => array('default' => 5)), //5 //, 'default' => 5 // array('frame_0' => false, 'frame_1' => 5, 'frame_999' => 5)
			'x'			=> array('n' => 'x', 'd' => array('frame_0' => array(0, '0', '0px', ''), 'frame_1' => array(0, '0', '0px', ''), 'default' => 'inherit')),
			'y'			=> array('n' => 'y', 'd' => array('frame_0' => array(0, '0', '0px', ''), 'frame_1' => array(0, '0', '0px', ''), 'default' => 'inherit')),
			'z'			=> array('n' => 'z', 'd' => array('frame_0' => array(0, '0', '0px', ''), 'frame_1' => array(0, '0', '0px', ''), 'default' => 'inherit')),
			'scaleX'	=> array('n' => 'sX', 'd' => array('frame_0' => 1, 'frame_1' => 1, 'default' => 'inherit')),
			'scaleY'	=> array('n' => 'sY', 'd' => array('frame_0' => 1, 'frame_1' => 1, 'default' => 'inherit')),
			'opacity'	=> array('n' => 'o', 'd' => 'inherit'),
			'rotationX'	=> array('n' => 'rX', 'd' => array('frame_0' => array(0, '0', '0px', ''), 'frame_1' => array(0, '0', '0px', ''), 'default' => 'inherit')),
			'rotationY'	=> array('n' => 'rY', 'd' => array('frame_0' => array(0, '0', '0px', ''), 'frame_1' => array(0, '0', '0px', ''), 'default' => 'inherit')),
			'rotationZ'	=> array('n' => 'rZ', 'd' => array('frame_0' => array(0, '0', '0px', ''), 'frame_1' => array(0, '0', '0px', ''), 'default' => 'inherit')),
			'skewX'		=> array('n' => 'skX', 'd' => array('frame_0' => array(0, '0', '0px', ''), 'frame_1' => array(0, '0', '0px', ''), 'default' => 'inherit')),
			'skewY'		=> array('n' => 'skY', 'd' => array('frame_0' => array(0, '0', '0px', ''), 'frame_1' => array(0, '0', '0px', ''), 'default' => 'inherit')),
			'originX'	=> array('n' => 'oX', 'd' => array('frame_0' => '50%', 'frame_1' => '50%', 'default' => 'inherit')), //'50%'
			'originY'	=> array('n' => 'oY', 'd' => array('frame_0' => '50%', 'frame_1' => '50%', 'default' => 'inherit')), //'50%'
			'originZ'	=> array('n' => 'oZ', 'd' => array('frame_0' => 0, 'frame_1' => 0, 'default' => 'inherit')),
			'fuse'		=> array('n' => 'fuse', 'd' => array('default' => false)),
			'grayscale'	=> array('n' => 'gra', 'd' => array('frame_0' => 0, 'frame_1' => 0, 'default' => 'inherit')), //0
			'brightness'=> array('n' => 'bri', 'd' => array('frame_0' => 100, 'frame_1' => 100, 'default' => 'inherit')), //100
			'blur'		=> array('n' => 'blu', 'd' => array('frame_0' => 0, 'frame_1' => 0, 'default' => 'inherit')) //100
		);
		
		$this->_mask = array(
			'x'	=> array('n' => 'x', 'd' => array('frame_0' => array(0, '0', '0px', ''), 'frame_1' => array(0, '0', '0px', ''), 'default' => 'inherit'), 'depth' => array('mask', 'x')),
			'y' => array('n' => 'y', 'd' => array('frame_0' => array(0, '0', '0px', ''), 'frame_1' => array(0, '0', '0px', ''), 'default' => 'inherit'), 'depth' => array('mask', 'y'))
		);
		
		$this->_sfx = array(
			'effect' => array('n' => 'se', 'd' => '', 'depth' => array('sfx', 'effect')),
			'color'	 => array('n' => 'fxc', 'd' => '#ffffff', 'depth' => array('sfx', 'color'))
		);
		
		$this->_reverse = array(
			'x'				 => array('n' => 'x', 'd' => false, 'depth' => array('reverseDirection', 'x')),
			'y'				 => array('n' => 'y', 'd' => false, 'depth' => array('reverseDirection', 'y')),
			'rotationX'		 => array('n' => 'rX', 'd' => false, 'depth' => array('reverseDirection', 'rotationX')),
			'rotationY'		 => array('n' => 'rY', 'd' => false, 'depth' => array('reverseDirection', 'rotationY')),
			'rotationZ'		 => array('n' => 'rZ', 'd' => false, 'depth' => array('reverseDirection', 'rotationZ')),
			'skewX'			 => array('n' => 'sX', 'd' => false, 'depth' => array('reverseDirection', 'skewX')),
			'skewY' 		 => array('n' => 'sY', 'd' => false, 'depth' => array('reverseDirection', 'skewY')),
			'maskX' 		 => array('n' => 'mX', 'd' => false, 'depth' => array('reverseDirection', 'maskX')),
			'maskY' 		 => array('n' => 'mY', 'd' => false, 'depth' => array('reverseDirection', 'maskY')),
			'charsX'		 => array('n' => 'cX', 'd' => false, 'depth' => array('reverseDirection', 'charsX')),
			'charsY'		 => array('n' => 'cY', 'd' => false, 'depth' => array('reverseDirection', 'charsY')),
			'charsDirection' => array('n' => 'cD', 'd' => false, 'depth' => array('reverseDirection', 'charsDirection')),
			'wordsX'		 => array('n' => 'wX', 'd' => false, 'depth' => array('reverseDirection', 'wordsX')),
			'wordsY'		 => array('n' => 'wY', 'd' => false, 'depth' => array('reverseDirection', 'wordsY')),
			'wordsDirection' => array('n' => 'wD', 'd' => false, 'depth' => array('reverseDirection', 'wordsDirection')),
			'linesX'		 => array('n' => 'lX', 'd' => false, 'depth' => array('reverseDirection', 'linesX')),
			'linesY'		 => array('n' => 'lY', 'd' => false, 'depth' => array('reverseDirection', 'linesY')),
			'linesDirection' => array('n' => 'lD', 'd' => false, 'depth' => array('reverseDirection', 'linesDirection'))
		);
		
		$this->hv = array(
			'opacity'		=> array('n' => 'o', 'd' => 1),
			'scaleX'		=> array('n' => 'sX', 'd' => 1),
			'scaleY'		=> array('n' => 'sY', 'd' => 1),
			'skewX'			=> array('n' => 'skX', 'd' => 0),
			'skewY' 		=> array('n' => 'skY', 'd' => 0),
			'rotationX'		=> array('n' => 'rX', 'd' => 0),
			'rotationY'		=> array('n' => 'rY', 'd' => 0),
			'rotationZ'		=> array('n' => 'rZ', 'd' => 0),
			'x'				=> array('n' => 'x', 'd' => 0),
			'y'				=> array('n' => 'y', 'd' => 0),
			'z' 			=> array('n' => 'z', 'd' => 0),
			'color'			=> array('n' => 'c', 'd' => '#fff'),
			'backgroundColor' => array('n' => 'bgc', 'd' => 'transparent'),
			'gradientStyle' => array('n' => 'gs', 'd' => 'fading'),
			'borderColor'	=> array('n' => 'boc', 'd' => 'transparent'),
			'borderRadius'	=> array('n' => 'bor', 'd' => '0,0,0,0', 'depth' => array('borderRadius', 'v')), //check further as it is stored in v
			'borderStyle'	=> array('n' => 'bos', 'd' => 'none'),
			'borderWidth'	=> array('n' => 'bow', 'd' => '0,0,0,0'),
			'transformPerspective' => array('n' => 'tp', 'd' => '600'),
			'originX'		=> array('n' => 'oX', 'd' => '50%'),
			'originY'		=> array('n' => 'oY', 'd' => '50%'),
			'originZ'		=> array('n' => 'oZ', 'd' => '0'),
			'textDecoration'=> array('n' => 'td', 'd' => 'none'),
			'speed'			=> array('n' => 'sp', 'd' => 300),
			'ease'			=> array('n' => 'e', 'd' => 'power3.inOut'),
			'zIndex'		=> array('n' => 'zI', 'd' => 'auto'),
			'pointerEvents'	=> array('n' => 'pE', 'd' => 'auto'),
			'grayscale'		=> array('n' => 'gra', 'd' => 0, 'depth' => array('filter', 'grayscale')),
			'brightness'	=> array('n' => 'bri', 'd' => 100, 'depth' => array('filter', 'brightness')),
			'blur'			=> array('n' => 'blu', 'd' => 0, 'depth' => array('filter', 'blur')),
			'usehovermask'	=> array('n' => 'm', 'd' => false)
		);
	}
	
	/**
	 * get the finished layer frame object
	 **/
	public function get_frames(){
		$layer	 = $this->get_layer();
		$type	 = $this->get_val($layer, 'type', 'text');
		$frames	 = $this->get_val($layer, array('timeline', 'frames'), false);
		$_frames = array();

		/**
		 * frame_0
		 * inherit || default -> ignore/dont write
		 *
		 * frame_1
		 * default -> ignore/dont write
		 *
		 * frame_2 - frame_999
		 * default -> ignore/dont write
		 **/

		if(!empty($frames)){
			foreach($frames as $fk => $frame){
				$_frames[$fk] = array('base' => array());
				$split	= array();
				$mask	= false;
				$push	= array();

				/**
				 * push the normal values of a frame
				 **/
				$use = array(
					//transform
					'x' => $this->_base['x'],
					'y' => $this->_base['y'],
					'z' => $this->_base['z'],
					'scaleX' => $this->_base['scaleX'],
					'scaleY' => $this->_base['scaleY'],
					'opacity' => $this->_base['opacity'],
					'rotationX' => $this->_base['rotationX'],
					'rotationY' => $this->_base['rotationY'],
					'rotationZ' => $this->_base['rotationZ'],
					'skewX' => $this->_base['skewX'],
					'skewY' => $this->_base['skewY'],
					'originX' => $this->_base['originX'],
					'originY' => $this->_base['originY'],
					'originZ' => $this->_base['originZ'],
					'transformPerspective' => $this->_base['transformPerspective'],

					//timeline
					'ease' => $this->_base['ease'],
					'start' => $this->_base['start'],
					'speed' => $this->_base['speed'],
					'startRelative' => $this->_base['startRelative']
				);



				if($this->get_val($frame, array('filter', 'use')) === true){
					$use['grayscale']	= $this->_base['grayscale'];
					$use['brightness']	= $this->_base['brightness'];
					$use['blur']		= $this->_base['blur'];
				}

				if($this->get_val($frame, array('bfilter', 'use')) === true){
					$use['bGrayscale']	= $this->_base['bGrayscale'];
					$use['bBrightness']	= $this->_base['bBrightness'];
					$use['bBlur']		= $this->_base['bBlur'];
					$use['bInvert']	= $this->_base['bInvert'];
					$use['bSepia']		= $this->_base['bSepia'];
				}

				if($this->get_val($frame, array('color', 'use')) === true){
					$use['color'] = $this->_base['color'];
				}
				if($this->get_val($frame, array('bgcolor', 'use')) === true){
					$use['backgroundColor'] = $this->_base['backgroundColor'];
				}
				if($this->get_val($layer, array('timeline', 'clipPath', 'use')) === true){
					$use['clip'] = $this->_base['clip'];
					$use['clipB'] = $this->_base['clipB'];
				}
				

				

				foreach($use as $key => $v){
					$_key = (isset($v['depth'])) ? $v['depth'] : $key;

					if(is_array($v['d'])){
						$a = (isset($v['d'][$fk])) ? $v['d'][$fk] : $v['d']['default'];
						if($a === false) continue; //if false, ignore the value
					}else{
						$a = $v['d'];
					}
					$nv = $this->get_val($frame, $_key, $a);

					if($_key === 'ease' || (is_array($_key) && in_array('ease', $_key, true))){
						$this->easings[$nv] = $nv;
					}

					if(is_object($nv) || is_array($nv)){
						if($this->adv_resp_sizes == true){
							$b = (!is_array($a)) ? array($a) : $a;
							$nv = $this->normalize_device_settings($nv, $this->enabled_sizes, 'html-array', $b);
						}else{
							$nv = $this->get_biggest_device_setting($nv, $this->enabled_sizes);
						}
					}else{
						// need to process colors here
						// frame colors are always only one level
						if($key === 'color' || $key === 'backgroundColor'){
							$nv = RSColorpicker::get($nv);
						}
					}

					if($fk === 'frame_0' && $nv === 'inherit') continue; //inherit is ignored in frame_0

					if(is_array($nv)) $nv = implode(',', $nv);

					if(is_array($a)){
						if(!in_array($nv, $a, true)){
							$_frames[$fk]['base'][$v['n']] = $this->transform_frame_vals($nv);
						}
					}else{
						if((string)$nv !== (string)$a){
							$_frames[$fk]['base'][$v['n']] = $this->transform_frame_vals($nv);
						}
					}
				}

				/**
				 * check if we have to add split
				 **/
				if($this->get_val($frame, array('chars', 'use')) === true) $split[] = 'chars';
				if($this->get_val($frame, array('words', 'use')) === true) $split[] = 'words';
				if($this->get_val($frame, array('lines', 'use')) === true) $split[] = 'lines';

				if(!empty($split)){
					foreach($split as $splt){
						$push[$splt] = array(
							'ease'		=> $this->_split['ease'],
							'direction'	=> $this->_split['direction'],
							'delay'		=> $this->_split['delay'],
							'x'			=> $this->_split['x'],
							'y'			=> $this->_split['y'],
							'z'			=> $this->_split['z'],
							'scaleX'	=> $this->_split['scaleX'],
							'scaleY'	=> $this->_split['scaleY'],
							'opacity'	=> $this->_split['opacity'],
							'rotationX'	=> $this->_split['rotationX'],
							'rotationY'	=> $this->_split['rotationY'],
							'rotationZ'	=> $this->_split['rotationZ'],
							'skewX'		=> $this->_split['skewX'],
							'skewY'		=> $this->_split['skewY'],
							'originX'	=> $this->_split['originX'],
							'originY'	=> $this->_split['originY'],
							'originZ'	=> $this->_split['originZ'],
						);

						if($this->get_val($frame, array($splt, 'fuse'), false) === true){
							$push[$splt]['fuse']		= $this->_split['fuse'];
							$push[$splt]['grayscale']	= $this->_split['grayscale'];
							$push[$splt]['brightness']	= $this->_split['brightness'];
							$push[$splt]['blur']		= $this->_split['blur'];
						}

						foreach($push[$splt] as $k => $v){
							$push[$splt][$k]['depth'] = array($splt, $k);
						}
					}
				}

				/**
				 * check if we have to add mask
				 **/
				if($this->get_val($frame, array('mask', 'use')) === true){
					$push['mask'] = array(
						'u' => 't', //will set always u:t; as we need it
						'x'	=> $this->_mask['x'],
						'y' => $this->_mask['y']
					);
				}

				/**
				 * check if we have to add effect
				 **/
				if(!in_array($this->get_val($frame, array('sfx', 'effect')), array('', 'none'), true)){
					$push['sfx'] = array(
						'effect' => $this->_sfx['effect'],
						'color'	 => $this->_sfx['color']
					);
				}

				/**
				 * check if we have to add reverse
				 **/
				if($fk === 'frame_0' || $fk === 'frame_999'){
					$push['reverse'] = array(
						'x' => $this->_reverse['x'],
						'y' => $this->_reverse['y'],
						'rotationX' => $this->_reverse['rotationX'],
						'rotationY' => $this->_reverse['rotationY'],
						'rotationZ' => $this->_reverse['rotationZ'],
						'skewX'	 => $this->_reverse['skewX'],
						'skewY'  => $this->_reverse['skewY'],
						'maskX'  => $this->_reverse['maskX'],
						'maskY'  => $this->_reverse['maskY'],
						'charsX' => $this->_reverse['charsX'],
						'charsY' => $this->_reverse['charsY'],
						'charsDirection' => $this->_reverse['charsDirection'],
						'wordsX' => $this->_reverse['wordsX'],
						'wordsY' => $this->_reverse['wordsY'],
						'wordsDirection' => $this->_reverse['wordsDirection'],
						'linesX' => $this->_reverse['linesX'],
						'linesY' => $this->_reverse['linesY'],
						'linesDirection' => $this->_reverse['linesDirection']
					);
				}

				if(!empty($push)){
					foreach($push as $zone => $values){
						foreach($values as $key => $v){
							if(is_string($v)){
								$_frames[$fk][$zone][$key] = $v;
							}else{
								$_key = (isset($v['depth'])) ? $v['depth'] : $key;
								if(!isset($_frames[$fk][$zone])) $_frames[$fk][$zone] = array();
								if(is_array($v['d'])){
									$a = (isset($v['d'][$fk])) ? $v['d'][$fk] : $v['d']['default'];
									if($a === false) continue; //if false, ignore the value
								}else{
									$a = $v['d'];
								}

								$nv = $this->get_val($frame, $_key, $a);

								if($_key === 'ease' || (is_array($_key) && in_array('ease', $_key, true))){
									$this->easings[$nv] = $nv;
								}

								if(is_object($nv) || is_array($nv)){
									if($this->adv_resp_sizes == true){
										$b = (!is_array($a)) ? array($a) : $a;
										$nv = $this->normalize_device_settings($nv, $this->enabled_sizes, 'html-array', $b);
									}else{
										$nv = $this->get_biggest_device_setting($nv, $this->enabled_sizes);
									}
								}

								if(is_array($nv)) $nv = implode(',', $nv);

								if(isset($_key[1]) && $_key[1] === 'delay'){
									$_frames[$fk][$zone][$v['n']] = $this->transform_frame_vals($nv);
								}else{
									if(is_array($a)){
										if(!in_array($nv, $a, true)){
											$_frames[$fk][$zone][$v['n']] = $this->transform_frame_vals($nv);
										}
									}else{
										if((string)$nv !== (string)$a){
											$_frames[$fk][$zone][$v['n']] = $this->transform_frame_vals($nv);
										}
									}
								}
							}
						}
					}
				}
			}
		}

		/**
		 * check if we have to add hover frame
		 **/
		if($this->get_val($layer, array('hover', 'usehover'), false) === true || $this->get_val($layer, array('hover', 'usehover'), false) === 'true' || $this->get_val($layer, array('hover', 'usehover'), false) === 'desktop'){
			$_frames['frame_hover'] = array('base' => array());

			$idle_v = $this->get_val($layer, 'idle', array());
			$hover_v = $this->get_val($layer, 'hover', array());

			$hv = $this->hv;
			if ($this->get_val($layer, array('hover', 'usehover'), false) === 'desktop') $hv['instantClick'] = array('n' => 'iC', 'd' => 'true');

			$devices = array('d', 'n', 't', 'm');

			foreach($hv as $key => $v){
				$_key = (isset($v['depth'])) ? $v['depth'] : $key;
				$nv = $this->get_val($hover_v, $_key, $v['d']);

				if($_key === 'ease') $this->easings[$nv] = $nv;

				if(is_object($nv) || is_array($nv)){

					// (all?) hover styles in the admin are currently global for all devices
					// this solves an issue with borderWidth and borderRadius hovers (which have a "top/right/bottom/left" array)
					foreach($devices as $device){
						$devices_exist = $this->get_val($nv, $device);
						if($devices_exist) break;
					}
					if($devices_exist){
						if($this->adv_resp_sizes == true){
							$nv = $this->normalize_device_settings($nv, $this->enabled_sizes, 'html-array', array($v['d']));
						}else{
							$nv = $this->get_biggest_device_setting($nv, $this->enabled_sizes);
						}
					}
				}

				/*
					Hover values need to be compared to Idle values in order to print correctly
					Example case:
						1. Idle Color = red
						2. Hover Color = #ffffff
					Result: 
						Hover Color will not print because it equals the Hover Color default (#ffffff),
						.. and because it wasn't printed it will not animate
				*/
				$hover = $nv;
				$idle = $this->get_val($idle_v, $_key, $v['d']);
				if(is_object($idle) || is_array($idle)){
					$devices_exist = false;
					foreach($devices as $device){
						$devices_exist = $this->get_val($idle, $device);
						if($devices_exist) break;
					}
					if($devices_exist){
						if($this->adv_resp_sizes == true){
							$idle = $this->normalize_device_settings($idle, $this->enabled_sizes, 'html-array', array($v['d']));
						}else{
							$idle = $this->get_biggest_device_setting($idle, $this->enabled_sizes);
						}
					}
				}

				// sanitize values for comparison
				$lowkey = strtolower($key);
				if(strpos($lowkey, 'color') !== false){
					$hover = RSColorpicker::normalizeColors($hover);
					$idle = RSColorpicker::normalizeColors($idle);

					// this is important in case the color is a gradient
					// .. "normalizeColors" also converts JSON string value to printable CSS gradient
					$nv = $hover;
				}else{
					// sometimes a value can exist as "10" or "10px" (also strips "ms", "%" and "deg" for comparison), 
					// so this new function gets the raw number so they can be compared accurately
					$hover = $this->strip_suffix($hover);
					$idle = $this->strip_suffix($idle);
				}

				// convert hover value to arrays if needed so they can be compared
				if(is_array($idle)){
					if(!is_array($hover)){
						$hover = array($hover);
						for($i = 1; $i < count($idle); $i++){
							$hover[] = $hover[0];
						}
					}else{
						while(count($hover) < count($idle)){
							$hover[] = $hover[count($hover) - 1];
						}
					}

				}

				// If iC (instanc Click) is available, we must write it ! 
				if ($v['n'] === 'iC') $idle = 'false';

				if(is_array($hover)) $hover = implode(',', $hover);
				if(is_array($idle)) $idle = implode(',', $idle);
				if(is_array($nv)) $nv = implode(',', $nv);

				// if value doesn't equal default OR Hover value doesn't equal Idle
				if((string)$nv !== (string)$v['d'] || (string)$hover !== (string)($idle)){
					$_frames['frame_hover']['base'][$v['n']] = $this->transform_frame_vals($nv);
				}
			}
		}

		/**
		 * add tloop frame
		 * since 6.0
		 **/
		if($this->get_val($layer, array('timeline', 'tloop', 'use'), false) === true){
			$_frames['tloop'] = array('base' => array());
			$t_from		= $this->get_val($layer, array('timeline', 'tloop', 'from'), 'frame_1');
			$t_to		= $this->get_val($layer, array('timeline', 'tloop', 'to'), 'frame_999');
			$t_repeat	= $this->get_val($layer, array('timeline', 'tloop', 'repeat'), -1);
			$t_keep		= $this->get_val($layer, array('timeline', 'tloop', 'keep'), true);
			$t_child	= $this->get_val($layer, array('timeline', 'tloop', 'children'), true);
			if($t_from !== 'frame_1') $_frames['tloop']['base']['f'] = $t_from;
			if($t_to !== 'frame_999') $_frames['tloop']['base']['t'] = $t_to;
			if($t_keep === false) $_frames['tloop']['base']['k'] = 'false';
			if(!in_array($t_repeat, array(-1, '-1'))) $_frames['tloop']['base']['r'] = $t_repeat;
			if($t_child === false && in_array($this->get_val($layer, 'type', 'text'), array('group', 'row', 'column'), true)) $_frames['tloop']['base']['c'] = $t_child;

			if(empty($_frames['tloop']['base'])) $_frames['tloop']['base']['u'] = true; //if empty, set u to true so that frontend knows that it is set
		}

		/**
		 * Add modifications here
		 **/
		if(!empty($_frames)){
			//if endWidthSlide is true, set st to w
			$start_cache_999 = $this->get_val($_frames, array('frame_999', 'base', 'st'));
			if($this->get_val($frames, array('frame_999', 'timeline', 'endWithSlide'), false)){
				$_frames['frame_999']['base']['st'] = 'w';
			}

			$start_cache = array();

			$uid = $this->get_val($layer, 'uid');
			foreach($frames as $frame => $zone){
				$start_cache[$frame] = $this->get_val($_frames, array($frame, 'base', 'st'));

				$at = $this->get_val($zone, array('timeline', 'actionTriggered'), false);
				$trg = $this->layer_frame_triggered($uid, $frame);
				$ign = !in_array($frame, array('frame_hover', 'frame_0'), true);
				if($at === true && $trg === true && $ign === true){
					$_frames[$frame]['base']['st'] = 'a';
				}
			}

			foreach($_frames as $frame => $zone){
				if($frame !== 'frame_0' && in_array($this->get_val($layer, 'type', 'text'), array('group', 'row', 'column'), true)){
					if(!isset($start_cache[$frame])) $start_cache[$frame] = $this->get_val($_frames, array($frame, 'base', 'st'));

					if(isset($_frames[$frame]['base']['st']) && !is_numeric($_frames[$frame]['base']['st'])){
						$_frames[$frame]['base']['sA'] = ($frame !== 'frame_999') ? $start_cache[$frame] : $start_cache_999;
					}
				}
			}

			//if Out Animation set to "auto reverse" 
			if($this->get_val($frames, array('frame_999', 'timeline', 'auto'), false)){
				$_frames['frame_999']['base'] = array(
					'st'	=> $this->get_val($_frames, array('frame_999', 'base', 'st')),
					'sp'	=> $this->get_val($_frames, array('frame_999', 'base', 'sp')),
					'sR'	=> $this->get_val($_frames, array('frame_999', 'base', 'sR')),
					'auto'	=> 'true'
				);
			}

			//st is only available in frame_1 ... 999, so remove it from frame_0 if it exists
			if(isset($_frames['frame_0']) && isset($_frames['frame_0']['base'])){
				if(isset($_frames['frame_0']['base']['st'])){
					unset($_frames['frame_0']['base']['st']);
				}
				if(isset($_frames['frame_0']['base']['sR'])){
					unset($_frames['frame_0']['base']['sR']);
				}
				if(isset($_frames['frame_0']['base']['sp'])){
					unset($_frames['frame_0']['base']['sp']);
				}
			}

		}

		/**
		 * as we only show the layer on slide hover
		 * set the frame_1 and frame_999 st to 'a'
		 **/
		if($this->get_val($layer, array('visibility', 'onlyOnSlideHover'), false) === true){
			if(!isset($_frames['frame_1'])) $_frames['frame_1'] = array();
			if(!isset($_frames['frame_999'])) $_frames['frame_999'] = array();
			if(!isset($_frames['frame_1']['base'])) $_frames['frame_1']['base'] = array();
			if(!isset($_frames['frame_999']['base'])) $_frames['frame_999']['base'] = array();

			$_frames['frame_1']['base']['st'] = 'a';
			$_frames['frame_999']['base']['st'] = 'a';
		}

		return $_frames;
	}
	
	/**
	 * transform certain values into a different format for output
	 **/
	public function transform_frame_vals($nv){
		if(strpos($nv, '{') !== false){
			$nv = str_replace(array('{', '}'), '', $nv);
			$nv = str_replace(',', '|', $nv);
			$nv = 'ran('.$nv.')';
		}
		if(strpos($nv, '[') !== false){
			$nv = str_replace(array('[', ']'), '', $nv);
			$nv = str_replace(',', '|', $nv);
			$nv = 'cyc('.$nv.')';
		}
		return $nv;
	}
	
	/**
	 * get the layer frames HTML
	 **/
	public function get_html_clip(){
		$layer = $this->get_layer();
		$html = 'data-clip="';
		
		if($this->get_val($layer, array('timeline', 'clipPath', 'use')) === true){
			$html .= 'u:true;';
			$type = $this->get_val($layer, array('timeline', 'clipPath', 'type'), 'rectangle');
			$origin = $this->get_val($layer, array('timeline', 'clipPath', 'origin'), 'l');
			
			$html .= ($type !== 'rectangle') ? 't:'.$type.';' : '';
			$html .= ($origin !== 'l') ? 'o:'.$origin.';' : '';
		}
		
		$html .= '"';
		
		return ($html !== 'data-clip=""') ? $html : '';
	}
	
	/**
	 * get the layer frames HTML
	 **/
	public function get_html_frames($frames){
		$html = '';
		
		if(!empty($frames)){
			foreach($frames as $base => $_frame){
				if(!empty($_frame)){
					foreach($_frame as $_base => $values){
						$s = '';
						if(empty($values)) continue;
						foreach($values as $k => $v){
							if(is_bool($v)){
								$v = ($v === true) ? 'true' : 'false';
							}
							$s .= ($v !== '') ? $k.':'.$v.';' : '';
						}
						if($s !== ''){
							$_base = ($_base === 'base') ? '' : '_'.$_base;
							if($html !== '') $html .= $this->ld().RS_T8;
							$html .= 'data-'.$base.$_base.'="'.$s.'"'."\n";
						}
					}
				}
			}
		}
		
		return $html;
	}
	
	/**
	 * add html blendmode
	 **/
	public function get_html_blendmode(){
		$layer = $this->get_layer();
		$blendmode = $this->get_val($layer, array('idle', 'filter', 'blendMode'), 'normal');
		return ($blendmode !== 'normal') ? 'data-blendmode="'.$blendmode.'"' : '';
	}
	
	/**
	 * add the spike html data
	 * @since: 6.0
	 **/
	public function get_html_spike_data(){
		$layer = $this->get_layer();
		$html = 'data-spike="';
		
		if($this->get_val($layer, array('idle', 'spikeUse'), false) === true){
			$l = $this->get_val($layer, array('idle', 'spikeLeft'), 'none');
			$r = $this->get_val($layer, array('idle', 'spikeRight'), 'none');
			$lw = $this->get_val($layer, array('idle', 'spikeLeftWidth'), 10);
			$rw = $this->get_val($layer, array('idle', 'spikeRightWidth'), 10);
			if($l !== 'none') $html .= 'l:'.$l.';';
			if($r !== 'none') $html .= 'r:'.$r.';';
			if(!in_array($lw, array(10, '10', '10%'), true)) $html .= 'lw:'.$lw.';';
			if(!in_array($rw, array(10, '10', '10%'), true)) $html .= 'rw:'.$rw.';';
		}
		
		$html .= '"';
		
		return ($html !== 'data-spike=""') ? $html : '';
	}
	
	/**
	 * add the text stroke html data
	 * @since: 6.1.2
	 **/
	public function get_html_text_stroke(){
		$layer = $this->get_layer();
		$html = 'data-tst="';
		
		if($this->get_val($layer, array('idle', 'textStroke', 'inuse'), false) === true){
			if($this->adv_resp_sizes == true){
				$w = $this->normalize_device_settings($this->get_val($layer, array('idle', 'textStroke', 'width')), $this->enabled_sizes, 'html-array', array('1px'));
			}else{
				$w = $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'textStroke', 'width')), $this->enabled_sizes, '1px');
			}
			$c = $this->get_val($layer, array('idle', 'textStroke', 'color'), 'rgba(0,0,0,0.25)');
			if(!in_array(trim($w), array(1, '1', '1px', ''), true)) $html .= 'w:'.$w.';';
			if($c !== 'rgba(0,0,0,0.25)') $html .= 'c:'.$c.';';
		}
		
		$html .= '"';
		
		return ($html !== 'data-tst=""') ? $html : '';
	}
	
	/**
	 * add frameorder
	 **/
	public function get_html_frameorder(){
		$layer = $this->get_layer();
		$frameorder = $this->get_val($layer, array('timeline', 'frameOrder'), '');
		if($frameorder !== ''){
			$fo = '';
			foreach($frameorder as $frames){
				$fo .= $this->get_val($frames, 'id').';';
			}
			$frameorder = $fo;
		}
		return ($frameorder === 'frame_1;frame_999;' || $frameorder === 'frame_0;frame_1;frame_999;' || $frameorder === '') ? '' : 'data-ford="'.$frameorder.'"';
	}

	/**
	 * add html hideunder
	 **/
	public function get_html_hideunder(){
		$layer = $this->get_layer();
		return ($this->get_val($layer, array('visibility', 'hideunder')) === true) ? 'data-layeronlimit="on"' : '';
	}
	
	/**
	 * add audio html params here
	 **/
	public function get_html_audio_data(){
		$data	= array('video' => array());
		$layer	= $this->get_layer();
		
		if($this->get_val($layer, 'type', 'text') !== 'audio') return '';
		
		$vw	 = $this->get_val($layer, array('size', 'width'));
		$vh	 = $this->get_val($layer, array('size', 'height'));
		$vpl = $this->get_val($layer, array('media', 'preload'), 'auto');
		$sta = $this->get_val($layer, array('media', 'startAt'), -1);
		$end = $this->get_val($layer, array('media', 'endAt'), -1);
		$mp4 = esc_attr($this->remove_http($this->get_val($layer, array('media', 'audioUrl'))));
		$vl	 = $this->get_val($layer, array('media', 'loop'), true);
		$vpt = $this->get_val($layer, array('media', 'pausetimer'), false);
		$vpt = (in_array($vl, array('loop', 'none'), true)) ? true : $vpt;
		$ap	 = $this->get_val($layer, array('media', 'autoPlay'), 'true');
		$frw = $this->get_val($layer, array('media', 'forceRewind'), true);
		$vc	 = $this->get_val($layer, array('media', 'controls'), false);
		$nse = $this->get_val($layer, array('media', 'nextSlideAtEnd'), true);
		$sav = $this->get_val($layer, array('media', 'stopAllVideo'), true);
		$volume	 = $this->get_val($layer, array('media', 'volume'), 100);
		$mute	 = $this->get_val($layer, array('media', 'mute'), true);
		
		if($this->adv_resp_sizes == true){
			$data['video']['w'] = $this->normalize_device_settings($vw, $this->enabled_sizes, 'html-array', array(54));
			$data['video']['h'] = $this->normalize_device_settings($vh, $this->enabled_sizes, 'html-array', array(54));
		}else{
			$data['video']['w'] = $this->get_biggest_device_setting($vw, $this->enabled_sizes);
			$data['video']['h'] = $this->get_biggest_device_setting($vh, $this->enabled_sizes);
		}
		//if(!in_array($vpl, array('', 'auto'), true)){
			$data['video']['p'] = $vpl;
			//$plw = intval($this->get_val($layer, array('media', 'preloadWait'), 5));
			//if(!in_array($plw, array('5', 5), true)) $data['video']['pw'] = $plw;
		//}
		if(!in_array($sta, array('', '-1', -1), true)) $data['video']['sta'] = $sta;
		if(!in_array($end, array('', '-1', -1), true)) $data['video']['end'] = $end;
		if(!empty($mp4))	$data['mp4'] = $mp4;
		if(!in_array($ap, array('true', true), true)) $data['video']['ap'] = $ap;
		if($frw === false)	$data['video']['rwd'] = false;
		if($vc === true)	$data['video']['vc'] = true;
		if($nse === false)	$data['video']['nse'] = false;
		if($sav === false)	$data['video']['sav'] = false;
		if($mute !== true)	$data['video']['v'] = $volume;
		$data['video']['l'] = $vl;
		$data['video']['vd'] = $volume;
		$data['video']['ptimer'] = $vpt;

		$html = '';
		if(!empty($data)){
			foreach($data as $k => $d){
				if(empty($d)) continue;
				$html .= $this->ld().RS_T8.'data-'.$k.'="';
				if(is_array($d)){
					foreach($d as $kk => $dd){
						$html .= $kk.':';
						$html .= $this->write_js_var($dd, '');
						$html .= ';';
					}
				}else{
					$html .= $this->write_js_var($d, '');
				}
				$html .= '"'."\n";
			}
		}
		
		return $html;
	}
	
	/**
	 * get the HTML video data attributes
	 **/
	public function get_html_video_data(){
		$layer	= $this->get_layer();
		$data	= array('video' => array());
		
		if($this->get_val($layer, 'type', 'text') !== 'video') return '';
		$video_type = trim($this->get_val($layer, array('media', 'mediaType')));
		$video_type = ($video_type === '') ? 'html5' : $video_type;
		
		if(!in_array($video_type, array('streamyoutube', 'streamyoutubeboth', 'youtube', 'streamvimeo', 'streamvimeoboth', 'vimeo', 'streaminstagram', 'streaminstagramboth', 'html5'), true)) return '';
		
		if($video_type === 'html5') $data['video']['vfc'] = $this->get_val($layer, array('media', 'fitCover'), true);
		$http	 = (is_ssl()) ? 'https://' : 'http://';
		$vid	 = trim($this->get_val($layer, array('media', 'id')));
		$mute	 = $this->get_val($layer, array('media', 'mute'), true);
		$volume	 = $this->get_val($layer, array('media', 'volume'), 100);
		$vargs	 = trim($this->get_val($layer, array('media', 'args')));
		$control = $this->get_val($layer, array('media', 'controls'), false);
		$sta	 = $this->get_val($layer, array('media', 'startAt'));
		$end	 = $this->get_val($layer, array('media', 'endAt'));
		$vl		 = $this->get_val($layer, array('media', 'loop'), true);
		$vpt	 = $this->get_val($layer, array('media', 'pausetimer'), false);
		$vpt	 = (in_array($vl, array('loop', 'none'), true)) ? true : $vpt;
		$autoplay	= $this->get_val($layer, array('media', 'autoPlay'), 'true');
		$nextslide	= $this->get_val($layer, array('media', 'nextSlideAtEnd'), true);
		$poster	 = $this->remove_http($this->get_val($layer, array('media', 'posterUrl'), ''));
		$poster_change = $this->get_val($layer, array('behavior', 'imageSourceType'), 'full');
		$poster_id	= $this->remove_http($this->get_val($layer, array('media', 'posterId')));
		if($mute !== true) $data['video']['twa'] = $mute; // Set twa before checking autoplay
		$mute	 = (!in_array($autoplay, array('false', false), true)) ? true : $mute;
		
		if(!in_array($autoplay, array('true', true), true)) $data['video']['ap'] = $autoplay;
		if($mute !== true) $data['video']['v'] = $volume;
		$data['video']['vd'] = $volume;
		if(!in_array($sta, array('', '-1', -1), true)) $data['video']['sta'] = $sta;
		if(!in_array($end, array('', '-1', -1), true)) $data['video']['end'] = $end;
		if($this->get_val($layer, array('media', 'posterOnPause'), false) !== false) $data['video']['scop'] = 't';
		if($this->get_val($layer, array('media', 'forceRewind'), true) !== true) $data['video']['rwd'] = 'f';
		if($this->get_val($layer, array('media', 'nointeraction'), false) !== false) $data['video']['noint'] = 't';
		
		if($this->get_val($layer, array('size', 'covermode'), 'custom') === 'cover-proportional'){
			$ratio = $this->get_val($layer, array('media', 'ratio'));
			$data['video']['fc'] = true;
			if(!in_array($ratio, array('16:9', ''), true)) $data['video']['ar'] = $ratio;
		}

		$dotted	= $this->get_val($layer, array('media', 'dotted'));
		if(!in_array($dotted, array('none', ''), true)){
			$data['video']['do'] = $dotted;
			$doca	= $this->get_val($layer, array('media', 'dottedColorA'), 'transparent');
			$docb	= $this->get_val($layer, array('media', 'dottedColorB'), '#000000');
			$dos	= $this->get_val($layer, array('media', 'dottedSize'), 1);
			
			if($doca !== 'transparent') $data['video']['doca'] = $doca;
			if(!in_array($docb, array('', '#000000', '#000'), true)) $data['video']['docb'] = $docb;
			if(!in_array($dos, array('', '1', 1), true)) $data['video']['dos'] = $dos;
		}
		
		$data['video']['l'] = $vl;
		$data['video']['ptimer'] = $vpt;
		if($nextslide === false) $data['video']['nse'] = 'f';
		if($this->get_val($layer, array('media', 'stopAllVideo'), true) === false) $data['video']['sav'] = 'f';
		if($this->get_val($layer, array('media', 'allowFullscreen'), true) === false) $data['video']['afs'] = 'f';
		if(!empty($poster)){
			if($poster_change !== 'full' && $poster !== false && !empty($poster)){
				$_img = wp_get_attachment_image_src($poster, $poster_change);
				$poster = ($_img !== false) ? $_img[0] : $poster;
			}
			$data['poster'] = $poster;
			if($this->get_val($layer, array('media', 'disableOnMobile'), false) === true) $data['video']['npom'] = 't';
			if($this->get_val($layer, array('media', 'posterOnMobile'), false) === true) $data['video']['opom'] = 't';
		}
		
		switch($video_type){
			case 'streamyoutube':
			case 'streamyoutubeboth':
			case 'youtube':
				$vid	= (in_array($video_type, array('streamyoutube', 'streamyoutubeboth'), true)) ? $this->slide->get_param(array('bg', 'youtube'), '') : $vid; //change $vid to the stream!
				$vid	= ($this->get_val($layer, array('media', 'videoFromStream'), false) === true) ? $this->slide->get_param(array('bg', 'youtube'), '') : $vid;
				$vargs	= (empty($vargs)) ? RevSliderFront::YOUTUBE_ARGUMENTS : $vargs;
				$sp		= $this->get_val($layer, array('media', 'speed'), 1);
				$inl	= $this->get_val($layer, array('media', 'playInline'), true);
				
				if(!$mute) $vargs = 'volume='.intval($volume).'&'.$vargs;
				if($sta !== ''){
					$start_raw = explode(':', $sta);
					if(count($start_raw) == 2){
						$sta = (intval($start_raw[0]) > 0) ? $start_raw[0]*60 + $start_raw[1] : $start_raw[1];
					}
					$vargs .= ($sta !== '') ? '&start='.$sta : '';
				}
				if($end !== ''){
					$end_raw = explode(':', $end);
					if(count($end_raw) == 2){
						$end = (intval($end_raw[0]) > 0) ? $end_raw[0]*60 + $end_raw[1] : $end_raw[1];
					}
					$vargs .= ($end !== '') ? '&end='.$end : '';
				}
				$vargs .= '&amp;origin='.$http.$_SERVER['SERVER_NAME'].';';
				if($control === true) $data['video']['vc'] = 't';
				if(strpos($vid, 'http') !== false){ //check if full URL
					parse_str(parse_url($vid, PHP_URL_QUERY), $my_v_ret); //we have full URL, split it to ID
					$vid = $my_v_ret['v'];
				}
				
				$this->youtube_exists = (empty($vid)) ? $this->youtube_exists : true;
				$data['ytid'] = $vid;
				$data['vatr'] = 'version=3&amp;enablejsapi=1&amp;html5=1&amp;'.$vargs;
				if(!in_array($sp, array('1', 1), true)) $data['video']['sp'] = $sp;
				if($inl === false) $data['video']['inl'] = 'f';
			break;
			case 'streamvimeo':
			case 'streamvimeoboth':
			case 'vimeo':
				$vid = (in_array($video_type, array('streamvimeo', 'streamvimeoboth'), true)) ? $this->slide->get_param(array('bg', 'vimeo'), '') : $vid;
				$vid = ($this->get_val($layer, array('media', 'videoFromStream'), false) === true) ? $this->slide->get_param(array('bg', 'vimeo'), '') : $vid;
				$vid = (strpos($vid, 'http') !== false) ? (int) substr(parse_url($vid, PHP_URL_PATH), 1) : $vid; //check if full URL //we have full URL, split it to ID
				$vargs = (empty($vargs)) ? RevSliderFront::VIMEO_ARGUMENTS : $vargs;
				$vargs = (!$control) ? 'background=1&'.$vargs : $vargs;
				
				$data['vimeoid'] = $vid;
				$data['vatr'] = $vargs;
			break;
			case 'streaminstagram':
			case 'streaminstagramboth':
			case 'html5':
				$ogv = $this->get_val($layer, array('media', 'ogvUrl'), '');
				$webm = $this->get_val($layer, array('media', 'webmUrl'), '');
				$mp4 = $this->remove_http($this->get_val($layer, array('media', 'mp4Url'), ''));
				$mp4 = ($this->get_val($layer, array('media', 'videoFromStream'), false) === true) ? $this->slide->get_param(array('bg', 'mpeg'), '') : $mp4;
				$vpr = $this->get_val($layer, array('media', 'preload'), 'auto');
				$inl = $this->get_val($layer, array('media', 'playInline'), true);

				if($control === true) $data['video']['vc'] = 't';
				if(!empty($ogv))$data['videoogv'] = $ogv;
				if(!empty($webm)) $data['videowebm'] = $webm;
				if(!empty($mp4)) $data['mp4'] = $mp4;
				if(!in_array($vpr, array('', 'auto'), true)) $data['video']['p'] = $vpr;
				if($inl === false) $data['video']['inl'] = 'f';
			break;
		}
		
		if(isset($data['vatr'])){
			$data['vatr'] = str_replace('&amp;', '&', $data['vatr']);
			$data['vatr'] = str_replace('&', '&amp;', $data['vatr']);
			$data['vatr'] = str_replace(';&amp;', '&amp;', $data['vatr']);
			$data['vatr'] = str_replace(';;', ';', $data['vatr']);
		}
		
		$html = '';
		if(!empty($data)){
			foreach($data as $k => $d){
				if(empty($d)) continue;
				$html .= $this->ld().RS_T8.'data-'.$k.'="';
				if(is_array($d)){
					foreach($d as $kk => $dd){
						$html .= $kk.':';
						$html .= $this->write_js_var($dd, '');
						$html .= ';';
					}
				}else{
					$html .= $this->write_js_var($d, '');
				}
				$html .= '"'."\n";
			}
		}
		
		return $html;
	}
	
	/**
	 * get the column HTML data
	 **/
	public function get_html_column_data(){
		$layer	= $this->get_layer();
		$type	= $this->get_val($layer, 'type', 'text');
		$data	= 'data-column="';
		
		if($type == 'column'){
			$size_raw = explode('/', $this->get_val($layer, array('group', 'columnSize'), '1/3'));
			$size	= (count($size_raw) !== 2) ? '100' : round(100 * ((int)$size_raw[0] / (int)$size_raw[1]), 2);
			$va		= $this->get_val($layer, array('idle', 'verticalAlign'), 'top');
			
			$data .= (!in_array($size, array('', '33,33', '33.33', 33.33), true)) ? 'w:'.$size.'%;' : '';
			$data .= ($va !== 'top') ? 'a:'.$va.';' : '';
		}
		
		$data .= '"';
		
		return ($data !== 'data-column=""') ? $data : '';
	}
	
	/**
	 * check if in the layer actions an action has an trigger
	 **/
	public function get_html_margin_data($row_group_uid){
		$layer	= $this->get_layer();
		$type	= $this->get_val($layer, 'type', 'text');
		$data	= 'data-margin="';
		
		//add margin data attributes
		if($type == 'row' || $type == 'column' || $row_group_uid !== false){
			$margins	= $this->get_val($layer, array('idle', 'margin'));
			$rl_margin	= array();
			
			$margin_vals = $this->normalize_device_settings($margins, $this->enabled_sizes, 'obj', array(0));
			foreach($margin_vals as $margin){
				if(!empty($margin)){
					foreach($margin as $mkey => $mar){
						$rl_margin[$mkey][] = $mar;
					}
				}
			}
			if(!empty($rl_margin)){
				$mnames = array('t', 'r', 'b', 'l');
				for($i=0; $i<4; $i++){
					if(isset($rl_margin[$i])){
						if(is_array($rl_margin[$i])){
							if(count(array_unique($rl_margin[$i])) === 1){
								$m = reset($rl_margin[$i]);
								$mm = str_replace(array('%', 'px'), '', $m);
								if($mm !== '0' && $mm !== ''){
									$data .= $mnames[$i].':'.$m.';';
								}
							}else{
								$data .= $mnames[$i].':'.implode(',', $rl_margin[$i]).';';
							}
						}else{
							$mm = str_replace(array('%', 'px'), '', $rl_margin[$i]);
							if($mm !== '0' && $mm !== ''){
								$data .= $mnames[$i].':'.$rl_margin[$i].';';
							}
						}
					}
				}
			}
		}
		
		$data .= '"';
		
		return ($data !== 'data-margin=""') ? $data : '';
	}
	
	/**
	 * get padding html data
	 **/
	public function get_html_padding_data(){
		$layer		= $this->get_layer();
		$paddings	= $this->get_val($layer, array('idle', 'padding'));
		$data		= 'data-padding="';
		$rl_padding = array();
		
		$padding_vals = $this->normalize_device_settings($paddings, $this->enabled_sizes, 'obj', array(0));
		foreach($padding_vals as $padding){
			if(!empty($padding)){
				foreach($padding as $mkey => $mar){
					$rl_padding[$mkey][] = str_replace(array('px', '%'), '', $mar);
				}
			}
		}
		if(!empty($rl_padding)){
			$mnames = array('t', 'r', 'b', 'l');
			for($i=0;$i<4;$i++){
				if(isset($rl_padding[$i])){
					if(is_array($rl_padding[$i])){
						if(count(array_unique($rl_padding[$i])) === 1){
							$m = reset($rl_padding[$i]);
							$mm = str_replace(array('%', 'px'), '', $m);
							if($mm !== '0' && $mm !== ''){
								$data .= $mnames[$i].':'.$m.';';
							}
						}else{
							$data .= $mnames[$i].':'.implode(',', $rl_padding[$i]).';';
						}
					}else{
						$mm = str_replace(array('%', 'px'), '', $rl_padding[$i]);
						if($mm !== '0' && $mm !== ''){
							$data .= $mnames[$i].':'.$rl_padding[$i].';';
						}
					}
				}
			}
		}
		
		$data .= '"';
		return ($data !== 'data-padding=""') ? $data : '';
	}
	
	/**
	 * get padding html data
	 **/
	public function get_html_border_data(){
		$layer		= $this->get_layer();
		$data		= 'data-border="';
		$style		= array();
		
		if($this->adv_resp_sizes == true){
			$style['bos'] = $this->normalize_device_settings($this->get_val($layer, array('idle', 'borderStyle'), 'none'), $this->enabled_sizes, 'html-array', array('none'));
		}else{
			$style['bos'] = $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'borderStyle'), 'none'), $this->enabled_sizes);
		}
		$style['boc'] = $this->get_val($layer, array('idle', 'borderColor'));
		$style['bow'] = $this->get_val($layer, array('idle', 'borderWidth'), '0px');
		$style['bow'] = (is_array($style['bow']) || is_object($style['bow'])) ? implode(',', (array)$style['bow']) : $style['bow'];
		$style['bor'] = $this->get_val($layer, array('idle', 'borderRadius', 'v'));
		$style['bor'] = (is_array($style['bor']) || is_object($style['bor'])) ? implode(',', (array)$style['bor']) : $style['bor'];
		
		if(in_array($style['bow'], array(0, '0px', '0px,0px,0px,0px', '0', '0,0,0,0'), true) || $style['bos'] === 'none'){
			unset($style['bow']);
			unset($style['boc']);
			unset($style['bos']);
		}
		
		if(in_array($style['bor'], array(0, '0px', '0px,0px,0px,0px', '0', '0,0,0,0'), true)){
			unset($style['bor']);
		}
		
		if(!empty($style)){
			foreach($style as $k => $v){
				if(trim($v) !== ''){
					$data .= $k.':'.$v.';';
				}
			}
		}
		
		$data .= '"';
		return ($data !== 'data-border=""') ? $data : '';
	}
	
	/**
	 * get the background image
	 **/
	public function get_background_image(){
		$layer	= $this->get_layer();
		$type	= $this->get_val($layer, 'type', 'text');
		$add	= '';
		$image	= '<rs-bg-elem style="';
		//check for background images
		if(in_array($type, array('shape', 'row', 'group'), true)){
			$url_image = $this->get_val($layer, array('idle', 'backgroundImage'), '');
			
			// Replace image when featured image is in use
			if($this->get_val($layer, array('idle', 'bgFromStream')) === true){ //if image is choosen, use featured image as background
				$stream_background_image = $this->get_stream_background_image($layer);	
				$url_image = $stream_background_image['url'] ;
			}

			if($url_image !== ''){ //add background image
				$objlib = new RevSliderObjectLibrary();
				$objlib->_check_object_exist($url_image);
				
				if(in_array($type, array('group', 'shape', 'row'))){
					
					$global = $this->get_global_settings();
					$lazyloadbg = $this->get_val($global, 'lazyonbg', false);
					if($lazyloadbg !== false && $lazyloadbg !== 'false'){
						$add .= ' data-bglazy="'. $this->remove_http($url_image) .'"';
						$url_image = RS_PLUGIN_URL.'public/assets/assets/dummy.png';
					}

					$image .= "background: url('".$this->remove_http($url_image)."')";
					$image .= ' '.$this->get_val($layer, array('idle', 'backgroundRepeat'), 'no-repeat');
					$image .= ' '.$this->get_val($layer, array('idle', 'backgroundPosition'), 'center center');
					$image .= ';';
					$bgs	= $this->get_val($layer, array('idle', 'backgroundSize'), 'cover');
					$bgs	= ($bgs === 'percentage') ? $this->get_val($layer, array('idle', 'backgroundSizePerc'), '100').'%' : $bgs;
					$bgs	= ($bgs === 'pixel') ? $this->get_val($layer, array('idle', 'backgroundSizePix'), '100').'px' : $bgs;
					$image .= ' background-size: '.$bgs.';';
				}
			}
		}
		$image .= '"'. $add .'></rs-bg-elem>';
		
		return ($image !== '<rs-bg-elem style=""></rs-bg-elem>') ? $image : '';
	}

	/**
	 * get stream background image for layer
	 * @since: 6.2.0
	 **/
	public function get_stream_background_image($layer){
		$bgi = array('id' => '', 'size' => '', 'url' => '');
		$slide = $this->get_slide();
		
		if($this->slider->get_param('sourcetype') !== 'gallery'){
			if(in_array($this->slider->get_param('sourcetype'), array('post', 'woo', 'woocommerce'), true)){
				$bgi['id'] = get_post_thumbnail_id($slide->get_id());
				if(!empty($bgi['id'])){
					$bgi['size']	= $this->get_val($layer, array('behavior', 'streamSourceType'), 'full');
					$thumbnail_url	= wp_get_attachment_image_src($bgi['id'], $bgi['size']);
					$bgi['url']		= ($thumbnail_url !== false) ? $this->get_val($thumbnail_url, 0) : $bgi['url'];
				}
			}else{
				$bgi['id']	 = $slide->get_id();
				$bgi['size'] = 'full';
				$bgi['url']	 = $this->get_val($layer, array('media', 'imageUrl'), '');
			}
		}
		
		return $bgi;
	}

	/**
	 * get the layer loop animation data
	 **/
	public function get_loop_data(){
		$layer	= $this->get_layer();
		$loop	= array('loop_0' => '', 'loop_999' => ''); //needs to be pushed as loop_* in frontend
		$loop_keys	= array('frame_0' => '', 'frame_999' => ''); //stored as frame_* in database
		
		if($this->get_val($layer, array('timeline', 'loop', 'use'), false) === true){
			
			$e	 = $this->get_val($layer, array('timeline', 'loop', 'ease'), 'none');
			$this->easings[$e] = $e;
			$sp	 = $this->get_val($layer, array('timeline', 'loop', 'speed'), 1000);
			$rA	 = $this->get_val($layer, array('timeline', 'loop', 'radiusAngle'), 0);
			$crns = $this->get_val($layer, array('timeline', 'loop', 'curviness'), 2);
			$crd = $this->get_val($layer, array('timeline', 'loop', 'curved'), false);
			$yym = $this->get_val($layer, array('timeline', 'loop', 'yoyo_move'), false);
			$yyr = $this->get_val($layer, array('timeline', 'loop', 'yoyo_rotate'), false);
			$yys = $this->get_val($layer, array('timeline', 'loop', 'yoyo_scale'), false);
			$yyf = $this->get_val($layer, array('timeline', 'loop', 'yoyo_filter'), false);
			$rep = $this->get_val($layer, array('timeline', 'loop', 'repeat'), '-1');
			$st	 = $this->get_val($layer, array('timeline', 'loop', 'start'), 740);
			$aR	 = $this->get_val($layer, array('timeline', 'loop', 'autoRotate'), false);
			$oX	 = $this->get_val($layer, array('timeline', 'loop', 'originX'), '50%');
			$oY	 = $this->get_val($layer, array('timeline', 'loop', 'originY'), '50%');
			$oZ	 = $this->get_val($layer, array('timeline', 'loop', 'originZ'), '0');
			
			//every loop frame needs this
			$all_keys = array(
				'xr'		 => array('n' => 'xR', 'd' => array(0, '0', '0px', '')),
				'yr'		 => array('n' => 'yR', 'd' => array(0, '0', '0px', '')),
				'zr'		 => array('n' => 'zR', 'd' => array(0, '0', '0px', '')),
				'x'			 => array('n' => 'x', 'd' => array(0, '0px', '', '0', '0%')),
				'y'			 => array('n' => 'y', 'd' => array(0, '0px', '', '0', '0%')),
				'z'			 => array('n' => 'z', 'd' => array(0, '0px', '', '0', '0%')),
				'scaleX'	 => array('n' => 'sX', 'd' => 1),
				'scaleY'	 => array('n' => 'sY', 'd' => 1),
				'opacity'	 => array('n' => 'o', 'd' => 1),
				'rotationX'	 => array('n' => 'rX', 'd' => array(0, '0', '0deg')),
				'rotationY'	 => array('n' => 'rY', 'd' => array(0, '0', '0deg')),
				'rotationZ'	 => array('n' => 'rZ', 'd' => array(0, '0', '0deg')),
				'skewX'		 => array('n' => 'skX', 'd' => array(0, '0', '0px', '')),
				'skewY'		 => array('n' => 'skY', 'd' => array(0, '0', '0px', '')),
				'blur'		 => array('n' => 'blu', 'd' => 0),
				'brightness' => array('n' => 'bri', 'd' => 100),
				'grayscale'	 => array('n' => 'gra', 'd' => 0)
			);
			
			if($crd === false){
				unset($all_keys['xr']);
				unset($all_keys['yr']);
				unset($all_keys['zr']);
			}
			
			foreach($loop_keys as $l => $lv){
				$_l = str_replace('frame_', 'loop_', $l);
				foreach($all_keys as $key => $v){
					$d = (is_array($v['d'])) ? $v['d'][0] : $v['d'];
					
					$nv = $this->get_val($layer, array('timeline', 'loop', $l, $key), $d);
					if(is_array($v['d'])){
						if(!in_array($nv, $v['d'], true)){
							$loop[$_l] .= $v['n'].':'.$nv.';';
						}
					}else{
						if((string)$nv !== (string)$v['d']){
							$loop[$_l] .= $v['n'].':'.$nv.';';
						}
					}
				}
			}
			
			//these are the special settings for certain loop frames only
			$loop['loop_0'] .= ($oX !== '50%') ? 'oX:'.$oX.';' : '';
			$loop['loop_0'] .= ($oY !== '50%') ? 'oY:'.$oY.';' : '';
			$loop['loop_0'] .= ($oZ !== '0') ? 'oZ:'.$oZ.';' : '';
			
			$loop['loop_999'] .= ($aR !== false) ? 'aR:t;' : '';
			$loop['loop_999'] .= ($crd !== false) ? 'crd:t;' : '';
			if($crd !== false){
				$loop['loop_999'] .= ($crns !== 2 && $crns !== '') ? 'crns:'.$crns.';' : '';
				$loop['loop_999'] .= ($rA !== 0 && $rA !== '') ? 'rA:'.$rA.';' : '';
			}
			$loop['loop_999'] .= ($sp !== 1000 && $sp !== '') ? 'sp:'.$sp.';' : '';
			$loop['loop_999'] .= ($st !== 740 && $st !== '') ? 'st:'.$st.';' : '';
			$loop['loop_999'] .= ($e !== 'none' && $e !== '') ? 'e:'.$e.';' : '';
			$loop['loop_999'] .= ($yym !== false) ? 'yym:t;' : '';
			$loop['loop_999'] .= ($yyr !== false) ? 'yyr:t;' : '';
			$loop['loop_999'] .= ($yys !== false) ? 'yys:t;' : '';
			$loop['loop_999'] .= ($yyf !== false) ? 'yyf:t;' : '';
			$loop['loop_999'] .= ($rep !== '-1' && $rep !== '') ? 'rep:'.$rep.';' : '';
		}
		
		return $loop;
	}
	
	/**
	 * get layer toggle data
	 * @change 6.2.16:
	 *	- added idle -> whiteSpace setting
	 *	- added moved do_shortcode() to a later step
	 **/
	public function get_toggle_data(){
		$layer			 = $this->get_layer();
		$toggle			 = array();
		$type			 = $this->get_val($layer, array('type', 'text'));
		$text_toggle	 = $this->get_val($layer, array('toggle', 'text'));
		$toggle['allow'] = $this->get_val($layer, array('toggle', 'set'), false);
		$toggle['inverse_content'] = $this->get_val($layer, array('toggle', 'inverse'), false);
		$toggle['html']	 = '';
		
		if(!in_array($type, array('shape', 'svg', 'image'), true)){
			if(function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')){ //use qTranslate
				$text_toggle = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($text_toggle);
			}elseif(function_exists('ppqtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')){ //use qTranslate plus
				$text_toggle = ppqtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($text_toggle);
			}elseif(function_exists('qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage')){ //use qTranslate X
				$text_toggle = qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage($text_toggle);
			}
			
			$toggle['html'] = $text_toggle;
		}
		
		global $fa_icon_var, $fa_var, $pe_7s_var;
		foreach($this->icon_sets as $is){
			if(strpos($toggle['html'], $is) !== false){ //include default Icon Sets if used
				$font_var = str_replace('-', '_', $is).'var';
				$$font_var = true;
				$cache = RevSliderGlobals::instance()->get('RevSliderCache');
				$cache->add_addition('special', 'font_var', $font_var);
			}
		}
		
		//Replace Placeholders
		$toggle['html'] = $this->set_placeholders($toggle['html']);
		
		if($this->adv_resp_sizes == true){
			$ws = $this->normalize_device_settings($this->get_val($layer, array('idle', 'whiteSpace')), $this->enabled_sizes, 'html-array', array('nowrap'));
		}else{
			$ws	= $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'whiteSpace'), 'nowrap'), $this->enabled_sizes);
		}
		
		//replace new lines with <br />
		$toggle['html'] = (strpos($ws, 'content') !== false || strpos($ws, 'full') !== false) ? nl2br($toggle['html']) : $toggle['html'];
		//do shortcodes here, so that nl2br is not done within the shortcode content
		$toggle['html'] = (!in_array($type, array('image', 'svg', 'column', 'shape'), true)) ? do_shortcode(stripslashes($toggle['html'])) : $toggle['html'];
		
		return $toggle;
	}
	
	/**
	 * get layer HTML corners
	 **/
	public function get_html_corners(){
		$layer	= $this->get_layer();
		$html	= 'data-corners="';
		
		if(in_array($this->get_val($layer, 'type', 'text'), array('text', 'button','shape'), true)){
			$cl = $this->get_val($layer, array('idle', 'cornerLeft'), 'none');
			$cr = $this->get_val($layer, array('idle', 'cornerRight'), 'none');
			
			$html .= (!in_array($cl, array('', 'none'), true)) ? $cl.';' : '';
			$html .= (!in_array($cr, array('', 'none'), true)) ? $cr.';' : '';
		}
		
		$html .= '"';
		
		return ($html !== 'data-corners=""') ? $html : '';
	}
	
	/**
	 * get layer HTML disp
	 **/
	public function get_html_disp(){
		$layer	= $this->get_layer();
		$type	= $this->get_val($layer, 'type', 'text');
		$html	= 'data-disp="';
		
		if($this->container_mode === 'column' && $type !== 'row' && $this->get_val($layer, array('idle', 'display'), 'block') !== 'block'){
			$html .= $this->get_val($layer, array('idle', 'display'));
		}
		
		$html .= '"';
		
		return ($html !== 'data-disp=""') ? $html : '';
	}
	
	/**
	 * get layer HTML layer additions
	 **/
	public function get_html_layer_additions(){
		$layer	= $this->get_layer();
		$html	= '';
		
		if(!empty($this->layer_additions)){
			foreach($this->layer_additions as $data => $value){
				$html .= $this->ld().RS_T8.$data.'="';
				$html .= (is_array($value)) ? json_encode($value) : $value;
				$html .= '"'."\n";
			}
		}
		
		return $html;
	}
	
	/**
	 * get the HTML layer
	 **/
	public function get_html_layer(){
		$layer = $this->get_layer();
		$html = '';
		$type = $this->get_val($layer, 'type', 'text');
		$text = $this->get_val($layer, 'text');
		
		if(function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')){ //use qTranslate
			$text = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($text);
		}elseif(function_exists('ppqtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')){ //use qTranslate plus
			$text = ppqtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($text);
		}elseif(function_exists('qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage')){ //use qTranslate X
			$text = qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage($text);
		}
		
		switch($type){
			case 'shape':
			case 'svg':
			case 'column':
			break;
			default:
			case 'text':
			case 'button':
				// this filter is needed for the weather AddOn
				$html = apply_filters('revslider_modify_layer_text', $text, $layer);
				
				global $fa_icon_var, $fa_var, $pe_7s_var;
				foreach($this->icon_sets as $is){
					if(strpos($html, $is) !== false){ //include default Icon Sets if used
						$font_var = str_replace('-', '_', $is).'var';
						$$font_var = true;
						$cache = RevSliderGlobals::instance()->get('RevSliderCache');
						$cache->add_addition('special', 'font_var', $font_var);
					}
				}
			break;
			case 'image':
				$additional	= '';
				$cover_mode	= $this->get_val($layer, array('size', 'covermode'), 'custom');
				$urlImage	= $this->get_val($layer, array('media', 'imageUrl'));
				$cur_img_id	= $this->get_val($layer, array('media', 'imageId'));
				$img_change	= $this->get_val($layer, array('behavior', 'imageSourceType'), 'auto');
				$img_size	= 'full';
				$img_w		= '';
				$img_h		= '';
				$alt		= '';
				$alt_option	= $this->get_val($layer, array('attributes', 'altOption'), 'media_library');
				$do_ll		= $this->get_val($layer, array('behavior', 'lazyLoad'), 'auto');
				$lazyLoad	= $this->slider->get_param(array('general', 'lazyLoad'), false);
				$img_size	= ($img_change !== 'auto') ? $img_change : $this->slider->get_param(array('def', 'background', 'imageSourceType'), 'full');
				$class		= 'tp-rs-img';
				
				if(empty($cur_img_id) || intval($cur_img_id) == 0){
					$cur_img_id	= $this->get_image_id_by_url($urlImage);
					if(!empty($cur_img_id) && intval($cur_img_id) !== 0){
						/**
						 * we could save the value into the layer
						 * but this part should never be called as the img id never is empty
						 **/
					}
				}
				
				if($img_size !== 'full' && $cur_img_id !== false && !empty($cur_img_id)){
					$_urlImage = wp_get_attachment_image_src($cur_img_id, $img_size);
					$urlImage = ($_urlImage !== false) ? $_urlImage[0] : $urlImage;
				}
				
				if($cur_img_id !== false && !empty($cur_img_id)){
					$img_data = wp_get_attachment_metadata( $cur_img_id );
					if($img_data !== false && !empty($img_data)){
						if($img_size !== 'full'){
							if(isset($img_data['sizes']) && isset($img_data['sizes'][$img_size])){
								$img_w = $this->get_val($img_data, array('sizes', $img_size, 'width'));
								$img_h = $this->get_val($img_data, array('sizes', $img_size, 'height'));
							}
						}
						
						if($img_w == '' || $img_h == ''){
							$img_w =  $this->get_val($img_data, 'width');
							$img_h =  $this->get_val($img_data, 'height');
						}
						$additional.= ' width="'.$img_w.'" height="'.$img_h.'"';
					}
				}else{ //we might be from image library
					$objlib = new RevSliderObjectLibrary();
					
					//redownload if possible
					$objlib->_check_object_exist($urlImage);
				}
				
				switch($alt_option){
					case 'media_library':
						if($cur_img_id !== false){
							$alt = get_post_meta($cur_img_id, '_wp_attachment_image_alt', true);
						}
					break;
					case 'file_name':
						$info = pathinfo($urlImage);
						$alt = $info['filename'];
					break;
					case 'custom':
						$alt = $this->get_val($layer, array('attributes', 'alt'));
					break;
				}
				
				if(isset($this->slide->ignore_alt)) $alt = '';
				
				if($lazyLoad === false){ //do fallback checks to removed lazy_load value since version 5.0 and replaced with an enhanced version
					$old_ll = $this->slider->get_param('lazy_load', 'off');
					$lazyLoad = ($old_ll == 'on') ? 'all' : 'none';
				}
				
				if($lazyLoad != 'none' || $do_ll == 'force' && $do_ll !== 'ignore'){
					$seo_opti = $this->get_val($layer, 'seo-optimized', false);
					if($seo_opti === 'false' || $seo_opti === false){
						$additional .= ' data-lazyload="'.$this->remove_http($urlImage).'"';
						$class .= ' rs-lazyload';
						$urlImage = RS_PLUGIN_URL.'public/assets/assets/dummy.png';
					}
				}
				
				$additional .= ($cover_mode !== 'custom') ? ' data-c="'.$cover_mode.'"' : '';
				
				if($urlImage !== ''){
					//$urlImage = str_replace(array('https://', 'http://'), '//', $urlImage);
					$html = '<img src="'.$this->remove_http($urlImage).'"';
					$html .= ' alt="'.$alt.'" class="'.$class.'"';
					$html .= $additional.' data-no-retina>';
				}
			break;
		}
		
		//Replace Placeholders
		$html = $this->set_placeholders($html);
		
		if($this->adv_resp_sizes == true){
			$ws = $this->normalize_device_settings($this->get_val($layer, array('idle', 'whiteSpace')), $this->enabled_sizes, 'html-array', array('nowrap'));
		}else{
			$ws	= $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'whiteSpace'), 'nowrap'), $this->enabled_sizes);
		}
		
		//replace new lines with <br />
		$html = (strpos($ws, 'content') !== false || strpos($ws, 'full') !== false) ? nl2br($html) : $html;
		//do shortcodes here, so that nl2br is not done within the shortcode content
		$html = (!in_array($type, array('image', 'svg', 'column', 'shape'), true)) ? do_shortcode(stripslashes($html)) : $html;
		
		return $html;
	}
	
	/**
	 * General Placeholders for all slider types
	 * @since: 5.3.0
	 */
	public function set_placeholders($text){
		global $post;
		
		$text = str_replace(array('%home_url%', '{{home_url}}'), esc_url(home_url( '/' )), $text);
		if(isset($post->ID)) $text = str_replace(array('%current_page_link%', '{{current_page_link}}'), get_permalink($post->ID), $text);
		if(isset($post->ID)) $text = apply_filters('revslider_gallery_set_placeholders', $text, $post->ID);
		
		return $text;
	}
	
	/**
	 * return the layer visibility dependency of devices
	 **/
	public function get_html_layer_device_visibility(){
		$layer			= $this->get_layer();
		$vis_desktop	= ($this->get_val($layer, array('visibility', 'd'), true) === true) ? 't' : 'f';
		$vis_notebook	= ($this->get_val($layer, array('visibility', 'n'), true) === true) ? 't' : 'f';
		$vis_tablet		= ($this->get_val($layer, array('visibility', 't'), true) === true) ? 't' : 'f';
		$vis_mobile		= ($this->get_val($layer, array('visibility', 'm'), true) === true) ? 't' : 'f';
		$visible		= ($vis_notebook == 'f' || $vis_desktop == 'f' || $vis_tablet == 'f' || $vis_mobile == 'f') ? 'data-vbility="'.$vis_desktop.','.$vis_notebook.','.$vis_tablet.','.$vis_mobile.'"' : '';
		
		return $visible;
	}
	
	/**
	 * check if in the layer actions an action has an trigger
	 **/
	public function check_if_trigger_exists(){
		$layers		 = $this->get_layers();
		$uid		 = $this->get_layer_unique_id();
		$has_trigger = false;
		
		foreach($layers as $layer){
			if($has_trigger) break;
			$actions = $this->get_val($layer, array('actions', 'action'));
			if(!empty($actions)){
				foreach($actions as $action){
					switch($this->get_val($action, 'action')){
						case 'start_in':
						case 'start_out':
						case 'toggle_layer':
						case 'toggle_frames':
						case 'next_frame':
						case 'prev_frame':
						case 'start_frame':
							if($uid == $this->get_val($action, 'layer_target')){
								$has_trigger = true;
								break;
							}
						break;
					}
				}
			}
		}
		
		return $has_trigger;
	}
	
	/**
	 * check if the current layer is a full width video
	 **/
	public function is_full_width_video(){
		$layer = $this->get_layer();
		return $this->get_val($layer, 'type', 'text') == 'video' && $this->get_val($layer, array('size', 'covermode')) == 'cover-proportional';
	}
	
	/**
	 * Check if the layer is on a group or a row
	 * @since: 5.3.0
	 **/
	public function is_in_group_or_row(){
		$layer	= $this->get_layer();
		$puid	= $this->get_val($layer, array('group', 'puid'));
		return intval($puid) > 0;
	}
	
	/**
	 * check if a stream video exists
	 * @since: 5.0
	 * @before: RevSliderOutput::checkIfStreamVideoExists()
	 */
	public function check_if_stream_video_exists(){
		$slide	= $this->get_slide();
		$vid	= '';
		
		switch($slide->get_param(array('bg', 'type'), 'trans')){
			case 'streamyoutubeboth'://youtube
				$vid = $slide->get_param(array('bg', 'youtube'), '');
			break;
			case 'streamvimeoboth'://vimeo
				$vid = $slide->get_param(array('bg', 'vimeo'), '');
			break;
			case 'streaminstagramboth'://instagram
				$vid = $slide->get_param(array('bg', 'mpeg'), '');
			break;
			case 'streamtwitterboth'://instagram
				$vid = $slide->get_param(array('bg', 'mpeg'), '');
				if($vid !== '') return true;
				$vid = $slide->get_param(array('bg', 'youtube'), '');
				if($vid !== '') return true;
				$vid = $slide->get_param(array('bg', 'vimeo'), '');
				if($vid !== '') return true;
			break;
		}
		
		return ($vid == '') ? false : true;
	}
	
	/**
	 * add background video layer
	 * @since: 5.0
	 * @before putBackgroundVideo()
	 */
	public function add_html_background_video(){
		$slide = $this->get_slide();
		
		$data = array('video' => array());
		
		$mute_video = $slide->get_param(array('bg', 'video', 'mute'), true);
		$volume = $slide->get_param(array('bg', 'video', 'volume'), '100');
		$video_type = $slide->get_param(array('bg', 'type'), 'trans');
		$http = (is_ssl()) ? 'https://' : 'http://';
		
		switch($video_type){
			case 'streamtwitter':
			case 'streamtwitterboth':
			case 'twitter':
				$youtube_id	= $slide->get_param(array('bg', 'youtube'), '');
				$vimeo_id	= $slide->get_param(array('bg', 'vimeo'), '');
				$html_mpeg	= $this->remove_http($slide->get_param(array('bg', 'mpeg'), ''));
				
				if($youtube_id === '' && $vimeo_id === '' && $html_mpeg === '') return false;
				
				if($youtube_id !== ''){
					$this->youtube_exists = true;
					$arguments = $slide->get_param(array('bg', 'video', 'args'), RevSliderFront::YOUTUBE_ARGUMENTS);
					$arguments = (empty($arguments)) ? RevSliderFront::YOUTUBE_ARGUMENTS : $arguments;
					if($mute_video === false){
						$data['video']['v'] = intval($volume);
						$arguments	= 'volume='.intval($volume).'&amp;'.$arguments;
					}
					$arguments .= '&amp;origin='.$http.$_SERVER['SERVER_NAME'].';';
					$data['vatr'] = 'version=3&amp;enablejsapi=1&amp;html5=1&amp;'.$arguments;
					
					$data['ytid'] = $youtube_id;
					$sp = $slide->get_param(array('bg', 'video', 'speed'), 1);
					if(!in_array($sp, array(1, '1'), true)) $data['video']['sp'] = $sp;
					
					$data['video']['vc'] = 'none';
					
				}elseif($vimeo_id !== ''){
					$arguments = $slide->get_param(array('bg', 'video', 'argsVimeo'), RevSliderFront::VIMEO_ARGUMENTS);
					$arguments = (empty($arguments)) ? RevSliderFront::VIMEO_ARGUMENTS : $arguments;
					$data['vatr'] = $arguments;
					
					if($mute_video === false){
						$data['video']['v'] = intval($volume);
					}
					
					if(strpos($vimeo_id, 'http') !== false){ //check if full URL
						//we have full URL, split it to ID
						$video_id = explode('vimeo.com/', $vimeo_id);
						$vimeo_id = $video_id[1];
					}
					
					$data['vimeoid'] = $vimeo_id;
					$data['video']['vc'] = 'none';
					
				}elseif($html_mpeg !== ''){
					//$data['video']['p'] = 'auto'; //auto is default, so dont write it
					$data['mp4'] = $html_mpeg;
				}
			break;
			case 'streamyoutube':
			case 'streamyoutubeboth':
			case 'youtube':
				$youtube_id = $slide->get_param(array('bg', 'youtube'), '');
				if($youtube_id == '') return false;
				
				$this->youtube_exists = true;
				if(strpos($youtube_id, 'http') !== false){ //check if full URL
					parse_str(parse_url($youtube_id, PHP_URL_QUERY), $my_v_ret); //we have full URL, split it to ID
					$youtube_id = $my_v_ret['v'];
				}
				
				$arguments = $slide->get_param(array('bg', 'video', 'args'), RevSliderFront::YOUTUBE_ARGUMENTS);
				$arguments = (empty($arguments)) ? RevSliderFront::YOUTUBE_ARGUMENTS : $arguments;
				
				if($mute_video === false){
					$data['video']['v'] = $volume;
					$arguments = 'volume='.intval($volume).'&amp;'.$arguments;
				}
				$arguments.='&amp;origin='.$http.$_SERVER['SERVER_NAME'].';';
				
				$data['ytid'] = $youtube_id;
				$data['vatr'] = 'version=3&amp;enablejsapi=1&amp;html5=1&amp;'.$arguments;
				$sp = $slide->get_param(array('bg', 'video', 'speed'), 1);
				if(!in_array($sp, array(1, '1'), true)) $data['video']['sp'] = $sp;
				$data['video']['vc'] = 'none';
			break;
			case 'streamvimeo':
			case 'streamvimeoboth':
			case 'vimeo':
				$vimeo_id = $slide->get_param(array('bg', 'vimeo'), '');
				if($vimeo_id == '') return false;
				
				$arguments = $slide->get_param(array('bg', 'video', 'argsVimeo'), RevSliderFront::VIMEO_ARGUMENTS);
				$arguments = (empty($arguments)) ? RevSliderFront::VIMEO_ARGUMENTS : $arguments;
				$arguments = 'background=1&'.$arguments;
				
				if($mute_video == false) $data['video']['v'] = intval($volume);
				
				if(strpos($vimeo_id, 'http') !== false){ //check if full URL
					$video_id = explode('vimeo.com/', $vimeo_id); //we have full URL, split it to ID
					$vimeo_id = $video_id[1];
				}
				$data['vimeoid'] = $vimeo_id;
				$data['vatr'] = $arguments;
				$data['video']['vc'] = 'none';
			break;
			case 'streaminstagram':
			case 'streaminstagramboth':
			case 'html5':
				$html_mpeg = $this->remove_http($slide->get_param(array('bg', 'mpeg'), ''));
				if($video_type == 'streaminstagram' || $video_type == 'streaminstagramboth'){
					$html_webm	= '';
					$html_ogv	= '';
				}else{
					$html_webm = $slide->get_param(array('bg', 'webm'), '');
					$html_ogv = $slide->get_param(array('bg', 'ogv'), '');
				}
				
				//$data['video']['p'] = 'auto'; //default is auto, so do not write
				
				if(!empty($html_ogv))	 $data['videoogv'] = $html_ogv;
				if(!empty($html_webm))	 $data['videowebm'] = $html_webm;
				if(!empty($html_mpeg))	 $data['mp4'] = $html_mpeg;
				if($mute_video === false) $data['video']['v'] = intval($volume);
			break;
		}
		
		if(isset($data['vatr'])){
			$data['vatr'] = str_replace('&amp;', '&', $data['vatr']);
			$data['vatr'] = str_replace('&', '&amp;', $data['vatr']);
			$data['vatr'] = str_replace(';&amp;', '&amp;', $data['vatr']);
			$data['vatr'] = str_replace(';;', ';', $data['vatr']);
		}
		
		$data['video']['w'] = '100%';
		$data['video']['h'] = '100%';
		
		$ratio	= $slide->get_param(array('bg', 'video', 'ratio'), '16:9');
		$loop	= $slide->get_param(array('bg', 'video', 'loop'), true);
		$vpt 	= $slide->get_param(array('bg', 'video', 'pausetimer'), false);
		if($loop === 'loop') $vpt = true;

		$nsae	= $slide->get_param(array('bg', 'video', 'nextSlideAtEnd'), false);
		$sat	= $slide->get_param(array('bg', 'video', 'startAfterTransition'), false);
		$vsa	= $slide->get_param(array('bg', 'video', 'startAt'), '');
		$vea	= $slide->get_param(array('bg', 'video', 'endAt'), '');
		
		
		if(!in_array($vsa, array('', '-1', -1), true)) $data['video']['sta'] = $vsa;
		if(!in_array($vea, array('', '-1', -1), true)) $data['video']['end'] = $vea;
		if(!in_array($ratio, array('', '16:9'), true)) $data['video']['ar'] = $ratio;
		if($nsae === false) $data['video']['nse'] = 'false';
		if($sat === true) $data['video']['sat'] = 'true';
		if($slide->get_param(array('bg', 'video', 'forceRewind'), true) === false)
			$data['video']['rwd'] = false;
		
		$data['video']['l'] = $loop;
		$data['video']['ptimer'] = $vpt;
		//$data['video']['autoplay'] = 'true'; //default, so dont write
		//$data['video']['apf'] = false; //default, so dont write
		
		
		if($video_type === 'html5') $data['video']['vfc'] = $slide->get_param(array('bg', 'video', 'fitCover'), true); //video fit cover
		$do	= $slide->get_param(array('bg', 'video', 'dottedOverlay'), 'none');
		if($do !== 'none'){
			$data['video']['do'] = $do;
			$doca	= $slide->get_param(array('bg', 'video', 'dottedColorA'), 'transparent');
			$docb	= $slide->get_param(array('bg', 'video', 'dottedColorB'), '#000000');
			$dos	= $slide->get_param(array('bg', 'video', 'dottedOverlaySize'), 1);
			
			if($doca !== 'transparent') $data['video']['doca'] = $doca;
			if(!in_array($docb, array('', '#000000', '#000'), true)) $data['video']['docb'] = $docb;
			if(!in_array($dos, array('', '1', 1), true)) $data['video']['dos'] = $dos;
		}

		//echo $this->ld().RS_T7."<!-- BACKGROUND VIDEO LAYER -->\n";
		echo $this->ld().RS_T7.'<rs-bgvideo '."\n";
		if(!empty($data)){
			foreach($data as $k => $d){
				if(empty($d)) continue;
				echo $this->ld().RS_T8.'data-'.$k.'="';
				if(is_array($d)){
					foreach($d as $kk => $dd){
						echo $kk.':';
						echo $this->write_js_var($dd, '');
						echo ';';
					}
				}else{
					echo $this->write_js_var($d, '');
				}
				echo '"'."\n";
			}
		}
		echo $this->ld().RS_T7.'></rs-bgvideo>'."\n";
	}
	
	/**
	 * get slide style
	 **/
	public function get_html_slide_style(){
		$style = array('position' => 'absolute');
		$style = apply_filters('revslider_get_html_slide_style', $style, $this);

		$style_html = ' style="';
		if(!empty($style)){
			foreach($style as $_style => $_value){
				$style_html .= $_style.': '.$_value.';';
			}
		}
		$style_html .= '"';

		return ($style_html !== ' style=""') ? $style_html : '';
	}
	
	/**
	 * get slide key
	 **/
	public function get_html_slide_key(){
		$slide = $this->get_slide();
		return ' data-key="rs-'.preg_replace("/[^\w]+/", "", $slide->get_id()).'"';
	}
	
	/**
	 * get slide title
	 **/
	public function get_html_slide_title($raw = false){
		$slide = $this->get_slide();
		
		if($this->slider->is_posts()){ //check if we are post based or normal slider
			$title = @get_the_title($slide->get_id());
		}else{
			$title = $slide->get_param('title', 'Slide');
		}
		$pre = ($raw === false) ? ' data-title="' : '';
		$post = ($raw === false) ? '"' : '';
		
		return ($title !== '') ? $pre.stripslashes(esc_attr($title)).$post : '';
	}
	
	/**
	 * get slide description
	 **/
	public function get_html_slide_description(){
		$slide = $this->get_slide();
		
		if($this->slider->is_posts()){ //check if we are post based or normal slider
			$the_post = get_post($slide->get_id());
			$description = strip_tags(strip_shortcodes($the_post->post_excerpt));
		}else{
			$description = $slide->get_param(array('info', 'description'), '');
		}
		
		$description = trim(str_replace(array("\'", '\"'), array("'", '"'), esc_attr($description)));
		
		return ($description !== '') ? ' data-description="'.$description.'"' : '';
	}
	
	/**
	 * get the thumb url for the slide (navigation may need it)
	 **/
	public function get_thumb_url(){
		$active	 = ($this->slider->get_param(array('nav', 'bullets', 'set'), false) == true || $this->slider->get_param(array('nav', 'thumbs', 'set'), false) == true || $this->slider->get_param(array('nav', 'arrows', 'set'), false) == true || $this->slider->get_param(array('nav', 'tabs', 'set'), false) == true) ? true : false;
		$special = (
			in_array($this->slider->get_param(array('nav', 'arrows', 'style'), 'round'), array('preview1', 'preview2', 'preview3', 'preview4', 'custom'), true) ||
			in_array($this->slider->get_param(array('nav', 'bullets', 'style'), 'round'), array('preview1', 'preview2', 'preview3', 'preview4', 'custom'), true)
		) ? true : false;
		
		if($active === false && $special == false) return '';
		
		$slide	= $this->get_slide();
		$url	= ($this->slider->is_posts() && $slide->get_param(array('bg', 'imageFromStream'), false) === true) ? '' : $slide->get_param(array('thumb', 'customThumbSrc'), '');
		
		if(
			$slide->get_param(array('thumb', 'dimension'), 'slider') == 'slider' &&
			(in_array($this->slider->get_param('sourcetype'), array('youtube', 'vimeo'), true) || 
			in_array($slide->get_param(array('bg', 'type'), 'trans'), array('image', 'vimeo', 'youtube', 'html5', 'streamvimeo', 'streamyoutube', 'streaminstagram', 'streamtwitter', 'streamvimeoboth', 'streamyoutubeboth', 'streaminstagramboth', 'streamtwitterboth'), true))
		){ //use the slider settings for width / height
			$w = intval($this->slider->get_param(array('nav', 'preview', 'width'), $this->slider->get_param(array('nav', 'thumbs', 'width'), 100)));
			$h = intval($this->slider->get_param(array('nav', 'preview', 'height'), $this->slider->get_param(array('nav', 'thumbs', 'height'), 50)));
			
			if($w == 0) $w = 100;
			if($h == 0) $h = 50;
		
			if(empty($url)){ //try to get resized thumb
				$url = rev_aq_resize($slide->image_url, $w, $h, true, true, true);
			}else{
				$url = rev_aq_resize($url, $w, $h, true, true, true);
				if(empty($url)){
					$url = $slide->image_url;
					$url = rev_aq_resize($url, $w, $h, true, true, true);
				}
			}
		}
		
		$url = (empty($url)) ? $slide->image_url : $url; //if empty - put regular image
		$url = trim($this->remove_http($url));
		$url = ($this->check_valid_image($url)) ? $url : '';
		
		return ($url !== '') ? ' data-thumb="'.$url.'"' : $url;
	}
	
	/**
	 * get slide link if set in slide settings
	 **/
	public function get_slide_link(){
		$link	= '';
		$slide	= $this->get_slide();
		$params	= $slide->get_params();
		
		if($slide->get_param(array('seo', 'set'), false) == true){
			switch($slide->get_param(array('seo', 'type'), 'regular')){
				default: //---- normal link
				case 'regular':
					$target	= ' data-tag="'.$slide->get_param(array('seo', 'tag'), 'l').'" data-target="'.$slide->get_param(array('seo', 'target'), '_self').'"';					
					$http	= $slide->get_param(array('seo', 'linkHelp'), 'auto');
					$l		= $this->remove_http($slide->get_param(array('seo', 'link'), ''), $http);
					$link	= ($l !== '') ? ' data-link="'.do_shortcode($l).'"'.$target : $link;
				break;
				case 'slide': //---- link to slide
					$slide_link = $this->get_val($params, array('seo', 'slideLink'), 'nothing');
					if(!empty($slide_link) && $slide_link != 'nothing'){
						//get slide index from id
						$slide_link	= (is_numeric($slide_link)) ? $this->get_val($this->get_slides_num_index(), $slide_link) : $slide_link;
						$link		= (!empty($slide_link)) ? ' data-linktoslide="'.$slide_link.'"' : $link;
					}
				break;
			}

			//set link position:
			$link .= ' data-seoz="'.$this->get_val($params, array('seo', 'z'), 'front').'"';
		}
		
		return $link;
	}
	
	/**
	 * get slide delay as html
	 **/
	public function get_html_delay(){
		$slide = $this->get_slide();
		$delay = $slide->get_param(array('timeline', 'delay'), 'default');
		$delay = strtolower($delay);
		
		return (!in_array($delay, array('default', ''), true)) ? ' data-duration="'. $delay .'"' : '';
	}


	/**
	 * get the html slide scroll based data
	 **/
	public function get_html_scrollbased_slidedata(){
		$slide = $this->get_slide();	
		$html = 'data-sba="';
		$sd = $this->slider->get_param(array('scrolltimeline', 'set'), false);
		$es = $this->slider->get_param(array('scrolleffects', 'set'), false);

		//$s = $slide->get_param(array('timeline', 'scrollBased'), 'default');
		//if ($s !== 'default' && $sd != false) $html .='t:'.($s=='true' ? 'true' : 'false').';';
		
		if($es === true){
			$fa = $slide->get_param(array('effects', 'fade'), 'default');
			$bl = $slide->get_param(array('effects', 'blur'), 'default');
			$gr = $slide->get_param(array('effects', 'grayscale'), 'default');
			if($fa !== 'default'){
				$html .= 'f:';
				$html .= ($fa === 'true') ? 'true' : 'false';
				$html .= ';';
			}
			if($bl !== 'default'){
				$html .= 'b:';
				$html .= ($bl === 'true') ? 'true' : 'false';
				$html .= ';';
			}
			if($gr !== 'default'){
				$html .= 'g:';
				$html .= ($gr === 'true') ? 'true' : 'false';
				$html .= ';';
			}
		}
		
		$html .='"';

		return ($html !== 'data-sba=""') ? $html : '';
	}

	
	/**
	 * get stop slide on purpose as html
	 **/
	public function get_html_stop_slide(){
		$slide = $this->get_slide();
		return ($this->_truefalse($slide->get_param(array('timeline', 'stopOnPurpose'), false)) === true) ? ' data-ssop="true"' : '';
	}
	
	/**
	 * get slide invisible as html
	 **/
	public function get_html_invisible(){
		$slide = $this->get_slide();
		return ($this->_truefalse($slide->get_param(array('visibility', 'hideFromNavigation'), false)) === true) ? ' data-invisible="true"' : '';
	}

	/**
	 * get slide animation IN/OUT attribute
	 **/
	public function get_html_slide_anim_attribute($data, $inout, $attribute, $default, $short, $force){
		if(!empty($data)){
			$result = ($inout !== false) ? $this->get_val($data, array($inout, $attribute), $default) : $this->get_val($data, array($attribute), $default);
		}else{
			$slide = $this->get_slide();
			$result = ($inout !== false) ? $slide->get_param(array('slideChange', $inout, $attribute), $default) : $slide->get_param(array('slideChange', $attribute), $default);
		}
		
		$_result = ($result === false) ? 'false' : $result; 
		$_result = ($_result === true) ? 'true' : $_result; 
		$_result = $this->shorten($_result, 'default', 'd');
		$_result = $this->transform_frame_vals($_result);
		
		if($force === true){
			if($attribute === 'e' || $short === 'e') $this->easings[$result] = $result;
			return ($result !== '') ? $short.':'. $result.';' : '';
		}else{
			if($attribute === 'e' || $short === 'e') $this->easings[$_result] = $_result;
			return ($result !== '' && $result !== $default) ? $short.':'. $_result.';' : '';
		}
	}

	/**
	 * get slide animation attribute
	 **/
	public function get_slide_some_attribute($attr){
		$slide = $this->get_slide();
		$result = $slide->get_param(array('timeline', $attr), 1);
		if(is_array($result) || is_object($result)) $result = implode(',', (array)$result);
		$result = $this->shorten($result, 'default', 'd');
		return ($result !== '' && $result != 1) ? $result : '';
		
	}
		
	/**
	 * get slide rotation as html
	 **/
	public function get_html_anim(){
		$slide = $this->get_slide();
		$transition = $this->get_html_first_transition();
		$transition = (empty($transition) && $slide->get_param(array('slideChange'), false) === false) ? 'fade' : $transition;
		$base_transitions = $this->get_base_transitions();
		
		$data = array();
		
		$preset = $slide->get_param(array('slideChange', 'preset'), false);
		$rnd_transition = '';
		if(is_string($transition) && in_array($transition, array('random', 'random-static', 'random-premium'), true)){
			$duration = $this->get_html_slide_anim_duration(); //get duration and set it to 1000 if smaller than 500
			if(intval($duration) < 300) $duration = 750;
			$preset = 'rndany';
			$transition = '';
		}
		if($preset !== false && strpos($preset, 'rnd') === 0){
			$rnd_main = $this->get_val($base_transitions, array('random', $preset, 'rndmain'), '');
			$rnd_grp = $this->get_val($base_transitions, array('random', $preset, 'rndgrp'), '');
			$rnd_transition = $this->get_random_slide_transition($rnd_main, $rnd_grp, $base_transitions);
			//get values for the random transition and store it in $data
			if(!empty($rnd_transition)){
				$data = $this->get_slide_transition_values($rnd_transition, $base_transitions);
				$this->frontend_action = true;
			}
		}
		
		$anim = ' data-anim="';
		$slots = false;
		if(!empty($transition)){ /* FALLBACK TO OLD OUTPUT */
			foreach($base_transitions as $_type => $_transition){
				if(empty($_transition) || !is_array($_transition)) continue;
				foreach($_transition as $_values){
					if(empty($_values) || !is_array($_values)) continue;
					foreach($_values as $_name => $_v){
						if($_name !== $transition) continue;
						$data = $_v;
						if($_type === 'basic') $slots = '1'; //set slots to 1 as a fallback
						break;
					}
				}
			}
			
			if(!is_array($data)) $data = array();
			
			$duration = (!isset($duration)) ? $this->get_html_slide_anim_duration() : $duration;
			if(in_array($transition, array('3dcurtain-vertical', '3dcurtain-horizontal'), true)){
				$duration = (empty($duration) || $duration == '') ? 500 : intval(intval($duration) / 3);
			}elseif($duration == '' && strpos($transition, 'slidingoverlay') !== false){				
				$duration = 2000;
			}
			$anim .= ($duration === '') ? '' : 'ms:'.$duration.';';
			$anim .= $this->get_html_slide_anim_rotation();
			$anim .= $this->get_html_slide_anim_attribute($data, false, 'adpr', false, 'adpr', false);
			$anim .= $this->get_html_slide_anim_attribute($data, false, 'd', 15, 'd', false);
			$anim .= $this->get_html_slide_anim_attribute($data, false, 'e', 'basic', 'e', false);
			$anim .= $this->get_html_slide_anim_attribute($data, false, 'p', 'none', 'p', false);
			$anim .= $this->get_html_slide_anim_attribute($data, false, 'f', 'start', 'f', false);
			$anim .= $this->get_html_slide_anim_attribute($data, false, 'o', 'inout', 'o', false);
			
			//move slots if exists to the $data
			$slots = ($slots === false) ? $this->get_slide_some_attribute('slots') : $slots;
			
			if(!empty($slots) && !in_array($slots, array('default', 'd'), true)){ //
				if(!isset($data['in'])) $data['in'] = array();
				if(!isset($data['in']['row'])) $data['in']['row'] = $slots;
				if(!isset($data['in']['col'])) $data['in']['col'] = $slots;
			}

			$easin = $this->get_slide_some_attribute('easeIn');
			$easout = $this->get_slide_some_attribute('easeOut');

			if(!empty($easin) && !in_array($easin, array('default', 'd'), true)){ //
				if(!isset($data['in'])) $data['in'] = array();
				if(!isset($data['in']['e'])) $data['in']['e'] = $easin;
				$this->easings[$easin] = $easin;
			}

			if(!empty($easout) && !in_array($easout, array('default', 'd'), true)){ //
				if(!isset($data['out'])) $data['out'] = array();
				if(!isset($data['out']['e'])) $data['out']['e'] = $easout;
				$this->easings[$easout] = $easout;
			}

		}else{ /*CANVAS*/
			/* Animate Defaults */
			$anim .= $this->get_html_slide_anim_attribute($data, false, 'eng', 'animateCore', 'eng', false);
			$anim .= $this->get_html_slide_anim_attribute($data, false, 'adpr', false, 'adpr', false);
			$anim .= $this->get_html_slide_anim_attribute($data, false, 'd', 15, 'd', false);
			$anim .= $this->get_html_slide_anim_attribute($data, false, 'e', 'basic', 'e', false);
			$anim .= $this->get_html_slide_anim_attribute($data, false, 'speed', 1000, 'ms', false);
			$anim .= $this->get_html_slide_anim_attribute($data, false, 'p', 'none', 'p', false);
			$anim .= $this->get_html_slide_anim_attribute($data, false, 'f', 'start', 'f', false);
			$anim .= $this->get_html_slide_anim_attribute($data, false, 'o', 'inout', 'o', false);
			
		}
		$anim .= '"';


		/* Animates 3D */
		$anim_ddd = ' data-d3="';
		$dddf = $this->get_html_slide_anim_attribute($data, 'd3', 'f', 'none', 'f', false);
		if($dddf !== 'f:none'){
			$anim_ddd .= $this->get_html_slide_anim_attribute($data, 'd3', 'f', 'none', 'f', false);
			$anim_ddd .= $this->get_html_slide_anim_attribute($data, 'd3', 'd', 'horizontal', 'd', false);
			$anim_ddd .= $this->get_html_slide_anim_attribute($data, 'd3', 'z', '300', 'z', false);
			if($dddf === 'fly'){
				$anim_ddd .= $this->get_html_slide_anim_attribute($data, 'd3', 'fz', '0', 'fz', false);
				$anim_ddd .= $this->get_html_slide_anim_attribute($data, 'd3', 'fdi', '1.5', 'fdi', false);
				$anim_ddd .= $this->get_html_slide_anim_attribute($data, 'd3', 'fdo', '2', 'fdo', false);
			}
			if($dddf !== 'turn'){
				$anim_ddd .= $this->get_html_slide_anim_attribute($data, 'd3', 't', '0', 't', false);
			}			
			$anim_ddd .= $this->get_html_slide_anim_attribute($data, 'd3', 'c', '#ccc', 'c', false);
			$anim_ddd .= $this->get_html_slide_anim_attribute($data, 'd3', 'e', 'power2.inOut', 'e', false);
			$shad = $this->get_html_slide_anim_attribute($data, 'd3', 'su', 'false', 'su', false);
			if($shad === 'su:true;'){
				$anim_ddd .= 'su:true;';
				$anim_ddd .= $this->get_html_slide_anim_attribute($data, 'd3', 'sc', '#000', 'sc', false);
				$anim_ddd .= $this->get_html_slide_anim_attribute($data, 'd3', 'smi', '0', 'smi', false);
				$anim_ddd .= $this->get_html_slide_anim_attribute($data, 'd3', 'sma', '0.5', 'sma', false);
			}
		}
		$anim_ddd .= '"'; 
		
		/* Animates In */
		$anim_in = ' data-in="';
		if(!empty($rnd_transition)) $anim_in .= 'prst:'.$preset.';';
		$motion = (empty($data)) ? $slide->get_param(array('slideChange', 'in', 'mou'), false) : $this->get_val($data, array('in', 'mou'), false);
		if($motion === true) $anim_in .= $this->get_html_slide_anim_attribute($data, 'in', 'mo', '80', 'mo', true);
		if($motion === true) $anim_in .= $this->get_html_slide_anim_attribute($data, 'in', 'moo', 'none', 'moo', true);
		$anim_in .= $this->get_html_slide_anim_attribute($data, 'in', 'o', '1', 'o', false);
		$anim_in .= $this->get_html_slide_anim_attribute($data, 'in', 'x', '0', 'x', false);
		$anim_in .= $this->get_html_slide_anim_attribute($data, 'in', 'y', '0', 'y', false);
		$anim_in .= $this->get_html_slide_anim_attribute($data, 'in', 'r', '0', 'r', false);
		$anim_in .= $this->get_html_slide_anim_attribute($data, 'in', 'sx', '1', 'sx', false);
		$anim_in .= $this->get_html_slide_anim_attribute($data, 'in', 'sy', '1', 'sy', false);
		$anim_in .= $this->get_html_slide_anim_attribute($data, 'in', 'm', false, 'm', false);
		$anim_in .= $this->get_html_slide_anim_attribute($data, 'in', 'e', 'power2.inOut', 'e', false);
		$anim_in .= $this->get_html_slide_anim_attribute($data, 'in', 'row', '1', 'row', false);
		$anim_in .= $this->get_html_slide_anim_attribute($data, 'in', 'col', '1', 'col', false);
		$anim_in .= '"'; 

		/* Basic Filters */
		$anim_filters = ' data-filter="';
		$slide_filters = (empty($data)) ? $slide->get_param(array('slideChange', 'filter', 'u'), false) : $this->get_val($data, array('filter', 'u'), false);		
		if($slide_filters === true){		
			$anim_filters .= $this->get_html_slide_anim_attribute($data, 'filter', 'e', 'default', 'e', false);
			$anim_filters .= $this->get_html_slide_anim_attribute($data, 'filter', 'm', '0', 'm', false);
			$anim_filters .= $this->get_html_slide_anim_attribute($data, 'filter', 'b', '0', 'b', false);
			$anim_filters .= $this->get_html_slide_anim_attribute($data, 'filter', 'g', '0', 'g', false);
			$anim_filters .= $this->get_html_slide_anim_attribute($data, 'filter', 'h', '100', 'h', false);
			$anim_filters .= $this->get_html_slide_anim_attribute($data, 'filter', 's', '0', 's', false);
			$anim_filters .= $this->get_html_slide_anim_attribute($data, 'filter', 'c', '100', 'c', false);
			$anim_filters .= $this->get_html_slide_anim_attribute($data, 'filter', 'i', '0', 'i', false);
		}
		$anim_filters .= '"'; 
		
		$slide_out = (empty($data)) ? $slide->get_param(array('slideChange', 'out', 'a'), true) : $this->get_val($data, array('out', 'a'), true);
		
		/* Animates Out */
		$anim_out = ' data-out="';
		if($slide_out === false){
			$_anim_out = $this->get_html_slide_anim_attribute($data, 'out', 'o', '1', 'o', false);
			$_anim_out .= $this->get_html_slide_anim_attribute($data, 'out', 'x', '0', 'x', false);
			$_anim_out .= $this->get_html_slide_anim_attribute($data, 'out', 'y', '0', 'y', false);
			$_anim_out .= $this->get_html_slide_anim_attribute($data, 'out', 'r', '0', 'r', false);
			$_anim_out .= $this->get_html_slide_anim_attribute($data, 'out', 'sx', '1', 'sx', false);
			$_anim_out .= $this->get_html_slide_anim_attribute($data, 'out', 'sy', '1', 'sy', false);
			$_anim_out .= $this->get_html_slide_anim_attribute($data, 'out', 'm', false, 'm', false);
			$_anim_out .= $this->get_html_slide_anim_attribute($data, 'out', 'e', 'power2.inOut', 'e', false);
			$_anim_out .= $this->get_html_slide_anim_attribute($data, 'out', 'row', '1', 'row', false);
			$_anim_out .= $this->get_html_slide_anim_attribute($data, 'out', 'col', '1', 'col', false);
			
			$anim_out .= ($_anim_out === '') ? 'a:false;' : $_anim_out;
		}
		
		$anim_out .= '"';
		
		if($anim === ' data-anim=""') $anim = '';
		if($anim_filters !== ' data-filter=""') $anim .= $anim_filters;
		if($anim_in !== ' data-in=""') $anim .= $anim_in;
		if($anim_out !== ' data-out=""') $anim .= $anim_out;
		if($anim_ddd !== ' data-d3=""') $anim .= $anim_ddd;
		
		return $anim;
	}
	
	/**
	 * get slide duration as html
	 **/
	public function get_html_slide_anim_duration(){
		$slide		= $this->get_slide();
		$duration	= $slide->get_param(array('timeline', 'duration'), ''); //$this->slider->get_param(array('def', 'transitionDuration'), '')
		$duration	= ((is_array($duration) || is_object($duration)) && !empty($duration)) ? implode(',', (array)$duration) : $duration;
		if(in_array($duration, array('default', 'd'), true)) $duration = '';
		
		return (!empty($duration)) ? $duration : '';
	}
	
	

	/**
	 * get slide rotation as html
	 **/
	public function get_html_slide_anim_rotation(){
		$slide		= $this->get_slide();
		$rotation	= (array)$slide->get_param(array('timeline', 'rotation'), '');
		$html_rotation = '';
		
		if(!empty($rotation)){
			$rot_string = '';
			foreach($rotation as $rkey => $rot){
				if(intval($rot) !== 0){			
					$rot = intval($rot);			
					if($rot != 0){
						if($rot > 720 && $rot != 999)
							$rot = 720;
						if($rot < -720)
							$rot = -720;
					} 
				}
				if(in_array($rot, array('random', 'ran', 'rand'), true)) $rot = 'ran(-20|20)';
				$rot = $this->shorten($rot, 'default', 'd');
				$rot = $this->transform_frame_vals($rot);
				if(in_array($rot, array('default', 'd'), true)) continue;
				
				if($rkey > 0) $rot_string .= ',';
				$rot_string .= $rot;
			}
			if($rot_string !== ''){
				$html_rotation = 'r:'.$rot_string.';';
			}
		}
		
		return $html_rotation;
	}
	
	/**
	 * get slide ease in as html
	 **/
	public function get_html_slide_anim_ease_in(){
		$slide	= $this->get_slide();
		$easein	= $slide->get_param(array('timeline', 'easeIn'), array('default'));
		if((is_array($easein) || is_object($easein)) && !empty($easein)){
			foreach($easein as $ei){
				$this->easings[$ei] = $ei;
			}
		}else{
			$this->easings[$easein] = $easein;
		}
		
		$easein = (!empty($easein) && (is_array($easein) || is_object($easein))) ? 'ei:'.implode(',', (array)$easein).';' : '';

		return str_replace('default', 'd', $easein);
	}
	
	/**
	 * get slide ease out as html
	 **/
	public function get_html_slide_anim_ease_out(){
		$slide	 = $this->get_slide();
		$easeout = $slide->get_param(array('timeline', 'easeOut'), array('default'));
		if((is_array($easeout) || is_object($easeout)) && !empty($easeout)){
			foreach($easeout as $eo){
				$this->easings[$eo] = $eo;
			}
		}else{
			$this->easings[$easeout] = $easeout;
		}
		
		$easeout = (!empty($easeout) && (is_array($easeout) || is_object($easeout))) ? 'eo:'.implode(',', (array)$easeout).';' : '';
		
		return str_replace('default', 'd', $easeout);
	}
	
	/**
	 * prepare the transition data attribute
	 **/
	public function get_html_first_transition(){
		$slide		= $this->get_slide();
		$transition	= $slide->get_param(array('timeline', 'transition'), '');
		if((is_array($transition) || is_object($transition)) && !empty($transition)){
			$transition = (array)$transition;
			$transition = array_shift($transition);
		}
		$transition = (empty($transition)) ? '' : $transition;
		
		return (trim($transition) !== '') ? $transition : '';
	}
	
	/**
	 * prepare the transition data attribute
	 **/
	public function get_html_random_animations(){
		$sl	= $this->get_slide();
		$t	= $sl->get_param(array('timeline', 'transition'), 'fade');
		$_t = (!is_array($t)) ? explode(',', $t) : $t;
		
		$random = '';
		if(is_array($_t) && !empty($_t)){
			$random = (in_array('random-selected', $_t, true)) ? ' data-rndtrans="on"' : $random;
		}
		
		return $random;
	}
	
	/**
	 * prepare the alternate transition data attribute
	 **/
	public function get_html_alt_transitions(){
		$slide = $this->get_slide();
		
		$alt_trans	= ' data-alttrans="';
		$alt		= (array)$slide->get_param(array('slideChange', 'alt'), array());
		if(empty($alt)){ //check for fallback of the old output, remove first entry
			$alt = (array)$slide->get_param(array('timeline', 'transition'), array());
			if(!empty($alt)) array_shift($alt);
		}
		$alt_trans .= implode(',', $alt);
		$alt_trans .= '"';
		
		$this->frontend_action = ($alt_trans !== ' data-alttrans=""') ? true : $this->frontend_action;
		
		return ($alt_trans !== ' data-alttrans=""') ? $alt_trans : '';
	}

	/**
	 * get slide loop
	 **/
	public function get_html_slide_loop(){
		$html = '';
		$slide = $this->get_slide();	
		if($slide->get_param(array('timeline', 'loop', 'set'), false) === true){
			$html .= 's:'.$slide->get_param(array('timeline', 'loop', 'start'), '2500').';';

			$lend = $slide->get_param(array('timeline', 'loop', 'end'), '4500');
			if(!empty($lend) && is_numeric($lend)) $html .= 'e:'.$lend.';';

			$rpt = $slide->get_param(array('timeline', 'loop', 'repeat'), 'unlimited');
			if(!empty($rpt) && $rpt !== 'unlimited') $html .= 'r:'.$rpt.';';
		}
		
		return ($html !== '') ? ' data-sloop="'.$html.'"' : '';
	}

	/**
	 * the first transition can be changed through Slider settings, so check here
	 **/
	public function js_get_first_anim_data(){
		$html = '';
		if($this->slider->get_param(array('general', 'firstSlide', 'set'), false) == true && $this->slider->get_param('type') !== 'hero'){
			$base_transitions = $this->get_base_transitions();
			$transition = $this->slider->get_param(array('general', 'firstSlide', 'type'), 'fade');
			$data = array();
			foreach($base_transitions as $_transition){
				if(empty($_transition) || !is_array($_transition)) continue;
				foreach($_transition as $_values){
					if(empty($_values) || !is_array($_values)) continue;
					foreach($_values as $_name => $_v){
						if($_name !== $transition) continue;
						$data = $_v;
						break;
					}
				}
			}
			
			$duration = str_replace('ms', '', $this->slider->get_param(array('general', 'firstSlide', 'duration'), '300'));
			if(!empty($duration) && is_numeric($duration)) $data['speed'] = $duration;
			if(isset($data['title'])) unset($data['title']);

			
			$data = apply_filters('revslider_disable_first_trans', $data, $this->slider);
			
			if(!empty($data)){
				$ff = true;
				$html .= $this->JTA . RS_T5.'fanim: {'."\n";
				foreach($data as $k => $v){
					$html .= ($ff === true) ? '' : ','."\n";
					$html .= $this->JTA . RS_T6.$k.':';
					if(!empty($v)){
						if(is_array($v)){
							$html .= json_encode($v);
						}else{
							$html .= $this->write_js_var($v);
						}
					}
					$ff = false;
				}
				$html .= "\n".$this->JTA . RS_T5.'},'."\n";
			}
		}
		return $html;
	}
	
	/**
	 * return the media filter settings
	 **/
	public function get_html_media_filter(){
		$slide	= $this->get_slide();
		$filter = $slide->get_param(array('bg', 'mediaFilter'), 'none');
		return ($filter != 'none') ? ' data-mediafilter="'.$filter.'"' : '';
	}
	
	/**
	 * return the slide class html
	 **/
	public function get_html_slide_class(){
		$slide = $this->get_slide();
		$class = $slide->get_param(array('attributes', 'class'), '');
		return ($class != '') ? ' class="'.$class.'"' : '';
	}
	
	/**
	 * return the slide id html
	 **/
	public function get_html_slide_id(){
		$slide	= $this->get_slide();
		$id		= $slide->get_param(array('attributes', 'id'), '');
		return ($id != '') ? ' id="'.$id.'"' : '';
	}
	
	/**
	 * return the extra data html
	 **/
	public function get_html_extra_data(){
		$slide	= $this->get_slide();
		$data	= stripslashes($slide->get_param(array('attributes', 'data'), ''));
		$deeplink = stripslashes($slide->get_param(array('attributes', 'deeplink'), ''));
		if (!empty($deeplink)) {
			$data = $data.' data-deeplink="'.$deeplink.'" ';
		}

		return ($data != '') ? ' '.$data : '';
	}
	
	/**
	 * return the hide after loop html
	 **/
	public function get_html_hide_after_loop(){
		$slide = $this->get_slide();
		$hal = $slide->get_param(array('visibility', 'hideAfterLoop'), 0);
		return ($hal !== 0) ? ' data-hal="'.$hal.'"' : '';
	}
	
	/**
	 * return the hide slide if we are mobile html
	 **/
	public function get_html_hide_slide_mobile(){
		$slide	= $this->get_slide();
		$hsom	= $slide->get_param(array('visibility', 'hideOnMobile'), false);
		return ($hsom === true) ? ' data-hsom="on"' : '';
	}
	
	/**
	 * get extra params that can be set
	 **/
	public function get_html_extra_params(){
		$params	= '';
		$slide	= $this->get_slide();
		
		for($mi = 0; $mi < 10; $mi++){
			$pa = $slide->get_param(array('info', 'params', $mi, 'v'), '');
			
			if($pa !== ''){
				$pa_limit = $slide->get_param(array('info', 'params', $mi, 'l'), 10);
				$pa = strip_tags($pa);
				$pa = mb_substr($pa, 0, $pa_limit, 'utf-8');
			}
			$mm = $mi + 1;
			$params .= ($pa !== '') ? ' data-p'.$mm.'="'.stripslashes(esc_attr($pa)).'"' : '';
		}
		
		return $params;
	}
	
	/**
	 * get the image or video ratio data attribute
	 * only for carousel sliders that are set to justify
	 **/
	public function get_html_image_video_ratio(){
		$slide = $this->get_slide();
		$s = $this->slider;
		$ratio = '';
		
		if($s->get_param('type', 'standard') !== 'carousel') return '';
		if($s->get_param(array('carousel', 'justify'), false) !== true) return '';
		
		switch($slide->get_param(array('bg', 'type'), 'trans')){
			case 'image':
				$src = $slide->image_url;
				$id	 = $slide->image_id;
				$data = array();
				if(!empty($id) && intval($id) !== 0){
					$data = wp_get_attachment_metadata($id);
				}
				if(empty($data) && $src !== false){
					$id = $this->get_image_id_by_url($src);
					$data = wp_get_attachment_metadata($id);
				}
				
				if(!empty($data)){
					$size = $slide->get_param(array('bg', 'imageSourceType'), 'full');
					if($size !== 'full'){
						if(isset($data['sizes']) && isset($data['sizes'][$size])){
							$width	= $this->get_val($data, array('sizes', $size, 'width'), '1');
							$height = $this->get_val($data, array('sizes', $size, 'height'), '1');
							$ratio	= round($width / $height, 5);
						}
					}else{
						$width	= $this->get_val($data, 'width', '1');
						$height = $this->get_val($data, 'height', '1');
						$ratio	= round($width / $height, 5);
					}
				}
			break;
			case 'html5':
			case 'vimeo':
			case 'youtube':
				switch($slide->get_param(array('bg', 'video', 'ratio'), '16:9')){
					case '16:9':
						$ratio = round(16 / 9, 5);
					break;
					case '4:3':
						$ratio = round(4 / 3, 5);
					break;
				}
			break;
		}
		
		return ($ratio !== '') ? ' data-iratio="'.$ratio.'"' : '';
	}
				
	
	/**
	 * remove the navigation, as for example we are on a single slide
	 **/
	public function remove_navigation(){
		$this->slider->set_param(array('nav', 'arrows', 'set'), false);
		$this->slider->set_param(array('nav', 'bullets', 'set'), false);
		$this->slider->set_param(array('nav', 'tabs', 'set'), false);
		$this->slider->set_param(array('nav', 'thumbs', 'set'), false);
	}
	
	/**
	 * set the slides to hold the gallery images
	 **/
	public function set_gallery_slides($slides){
		//check if we have at least one slide. If not, then it may result in errors here
		if(count($slides) > 0){
			$gallery_ids = $this->get_gallery_ids();
			if(count($gallery_ids) !== count($slides)){ //set slides to the same amount as
				if(count($gallery_ids) < count($slides)){
					$slides = array_slice($slides, 0, count($gallery_ids));
				}else{ // >
					while(count($slides) < count($gallery_ids)){
						foreach($slides as $slide){
							$new_slide = clone $slide;
							array_push($slides, $new_slide);
							if(count($slides) >= count($gallery_ids)) break;
						}
					}
					if(count($gallery_ids) < count($slides)){
						$slides = array_slice($slides, 0, count($gallery_ids));
					}
				}
			}
			
			$post_slide	= $this->slider->is_posts();
			$size	= $this->slider->get_param(array('def', 'background', 'imageSourceType'), 'full');
			$gi		= 0;
			
			foreach($slides as $skey => $slide){ //add gallery images into slides
				//set post id to imageid
				
				//check if slider is Post Based, if yes use $slide->get_id(); else use $gallery_ids[$gi]
				if($post_slide){
					$ret = $slide->set_image_by_id($slide->get_id(), $size);
				}else{
					$ret = $slide->set_image_by_id($gallery_ids[$gi], $size);
				}
				if($ret === true){ //set slide type to image instead of for example external or transparent
					
					/*
					 * If a "Specific Posts" Slider doesn't have a 'bg' param, create it
					*/
					$bg = $slide->get_param('bg', array());
					if(empty($bg)) $slide->set_param('bg', array());
					
					/*
					 * Changed to 'image' for WP Gallery AddOn compatibility
					*/
					$slide->set_param(array('bg', 'type'), 'image');
				}else{
					unset($slides[$skey]);
				}
				
				$gi++;
			}
		}
		
		return $slides;
	}
	
	
	/**
	 * remove Slides that should be hidden on mobile
	 **/
	public function remove_slide_if_mobile($slides){
		//check if mobile, if yes, then remove certain slides
		$usragent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
		$mobile = (wp_is_mobile() || strstr($usragent,'Android') || strstr($usragent,'webOS') || strstr($usragent,'iPhone') ||strstr($usragent,'iPod') || strstr($usragent,'iPad') || strstr($usragent,'Windows Phone')) ? true : false;
		if($mobile && !empty($slides)){
			foreach($slides as $ss => $sv){
				if($sv->get_param(array('visibility', 'hideOnMobile'), false) === true){
					unset($slides[$ss]);
				}
			}
		}
		
		return $slides;
	}
	
	
	/**
	 * Get the Hero Slide of the Slider
	 * @since: 5.0
	 * @before: RevSliderOutput::getHeroSlide();
	 */
	private function get_hero_slide($slides){
		if(empty($slides)) return $slides;
		
		$hero_id = $this->slider->get_param(array('hero', 'activeSlide'), -1);
		
		foreach($slides as $slide){
			if($slide->get_id() == $hero_id){
				return $slide;
			}
			if($this->get_language() !== 'all'){
				if($slide->get_param(array('child', 'parentId'), '') == $hero_id){
					return $slide;
				}
			}
		}
		
		//could not be found, use first slide
		foreach($slides as $slide){
			return $slide;
		}
	}
	
	/**
	 * reorder the slides by the given order
	 **/
	public function order_slides($slides, $order){
		$temp_slides = $slides;
		$slides = array();
		
		foreach($order as $order_slideid){
			foreach($temp_slides as $temp_slide){
				if($temp_slide->get_id() == $order_slideid){
					$temp_slide->set_param(array('publish', 'state'), 'published'); //set to published
					$slides[] = $temp_slide;
					break;
				}
			}
		}
		
		return $slides;
	}
	
	/**
	 * check the add_to
	 * return true / false if the put in string match the current page.
	 * @before isPutIn()
	 */
	public function check_add_to($empty_is_false = false){
		$add_to = $this->get_add_to();
		
		if($empty_is_false && empty($add_to)) return false;
		
		if($add_to == 'homepage'){ //only add if we are the homepage
			if(is_front_page() == false && is_home() == false) return false;
		}elseif(!empty($add_to)){
			
			$add_to_pages = array();
			$add_to = explode(',', $add_to);
			if(!empty($add_to)){
				foreach($add_to as $page){
					$page = trim($page);
					
					if(is_numeric($page) || $page == 'homepage') $add_to_pages[] = $page;
				}
			}
			
			//check if current page is in list
			if(!empty($add_to_pages)){
				$cp_id = $this->get_current_page_id();
				if(array_search($cp_id, $add_to_pages) === false) return false;
			}else{
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * get the current page id
	 * @since: 6.0
	 **/
	public function get_current_page_id(){
		$id = '';
		
		if(is_front_page() == true || is_home() == true){
			$id = 'homepage';
		}else{
			global $post;
			$id = (isset($post->ID)) ? $post->ID : $id;
		}
		
		return $id;
	}
	
	/**
	 * set general values that are needed by layers
	 * this is needed to be called before any layer is added to the stage
	 **/
	public function set_general_params_for_layers(){
		$this->enabled_sizes = array(
			'd' => true,
			'n' => $this->slider->get_param(array('size', 'custom', 'n'), false),
			't' => $this->slider->get_param(array('size', 'custom', 't'), false),
			'm' => $this->slider->get_param(array('size', 'custom', 'm'), false)
		);
		$this->adv_resp_sizes = $this->enabled_sizes['n'] == true || $this->enabled_sizes['t'] == true || $this->enabled_sizes['m'] == true;
		
		$this->icon_sets = $this->set_icon_sets(array());
	}
	
	/**
	 * modify slider settings through the shortcode directly
	 */
	private function modify_settings(){
		$settings = $this->get_custom_settings();
		$settings = apply_filters('revslider_modify_slider_settings', $settings, $this->get_slider_id());
		
		if(empty($settings)) return;
		
		$params = $this->slider->get_params();
		
		foreach($settings as $handle => $setting){
			$params[$handle] = $setting;
		}
		
		$this->slider->set_params($params);
	}
	
	/**
	 * modfy slide and layer settings by a selected skin
	 **/
	private function modify_slide_by_skin(){
		/**
		 * 1. check if the skin exists
		 * 2. check if the skin is loaded
		 * 3. push the data to the layers by certain routines
		 **/
		if(empty($this->custom_skin)) return true;
		
		//1 + 2
		if(!isset($this->custom_skin_data[$this->custom_skin])) $this->custom_skin_data[$this->custom_skin] = array();
		$_mod = $this->get_val($this->custom_skin_data, array($this->custom_skin, 'slide'), array());
		
		//3
		if(!empty($_mod)){
			$slide = $this->get_slide();
			$_p = $slide->get_params();
			$_p = array_replace_recursive($_p, $_mod);
			$slide->set_params($_p);
			$this->set_slide($slide);
		}
	}
	
	/**
	 * modfy slide and layer settings by a selected skin
	 **/
	private function modify_layers_by_skin(){
		/**
		 * 1. check if the skin exists
		 * 2. check if the skin is loaded
		 * 3. push the data to the layers by certain routines
		 **/
		if(empty($this->custom_skin)) return true;
		
		//1 + 2
		if(!isset($this->custom_skin_data[$this->custom_skin])) $this->custom_skin_data[$this->custom_skin] = array();
		$_mod = $this->get_val($this->custom_skin_data, array($this->custom_skin, 'layers'), array());
		
		//3
		if(!empty($_mod)){
			$slide = $this->get_slide();
			$layers = $slide->get_layers();
			foreach($layers as $lk => $lv){
				$layers[$lk] = array_replace_recursive($layers, $_mod);
			}
			$slide->set_layers_raw($layers);
			$this->set_slide($slide);
		}
	}
	
	/**
	 * modify slider settings for preview mode
	 * @before: RevSliderOutput::modifyPreviewModeSettings
	 */
	private function modify_preview_mode_settings(){
		$js_to_body = apply_filters('revslider_modify_preview_mode_settings', false);
		$this->slider->set_param(array('troubleshooting', 'jsInBody'), $js_to_body);
	}
	
	/**
	 * set the fonts to be added right before the slider from slider and layers
	 * @since: 6.0
	 */
	private function set_fonts(){
		//add all google fonts of layers
		$gfsub	= $this->slider->get_param('subsets', array());
		$gf		= $this->slider->get_used_fonts(false);
		
		foreach($gf as $gfk => $gfv){
			$variants = array();
			if(!empty($gfv['variants'])){
				foreach($gfv['variants'] as $mgvk => $mgvv){
					$variants[] = $mgvk;
				}
			}
			
			$subsets = array();
			if(!empty($gfv['subsets'])){
				foreach($gfv['subsets'] as $ssk => $ssv){
					if(array_search(esc_attr($gfk.'+'.$ssv), $gfsub) !== false){
						$subsets[] = $ssv;
					}
				}
			}
			
			$url = (isset($gfv['url'])) ? $gfv['url'] : '';
			$this->set_clean_font_import($gfk, '', $url, $variants, $subsets);
		}
	}
	
	/**
	 * set the font clean for import
	 * @before: RevSliderOperations::setCleanFontImport()
	 */
	public function set_clean_font_import($font, $class = '', $url = '', $variants = array(), $subsets = array()){
		global $revslider_fonts;
		
		if(!isset($revslider_fonts)) $revslider_fonts = array('queue' => array(), 'loaded' => array()); //if this is called without revslider.php beeing loaded
		
		if(!empty($variants) || !empty($subsets)){
			if(!isset($revslider_fonts['queue'][$font])) $revslider_fonts['queue'][$font] = array();
			if(!isset($revslider_fonts['queue'][$font]['variants'])) $revslider_fonts['queue'][$font]['variants'] = array();
			if(!isset($revslider_fonts['queue'][$font]['subsets'])) $revslider_fonts['queue'][$font]['subsets'] = array();
			
			if(!empty($variants)){
				foreach($variants as $k => $v){
					//check if the variant is already in loaded
					if(!in_array($v, $revslider_fonts['queue'][$font]['variants'], true)){
						$revslider_fonts['queue'][$font]['variants'][] = $v;
					}else{ //already included somewhere, so do not call it anymore
						unset($variants[$k]);
					}
				}
			}
			if(!empty($subsets)){
				foreach($subsets as $k => $v){
					if(!in_array($v, $revslider_fonts['queue'][$font]['subsets'], true)){
						$revslider_fonts['queue'][$font]['subsets'][] = $v;
					}else{ //already included somewhere, so do not call it anymore
						unset($subsets[$k]);
					}
				}
			}
			if($url !== ''){
				$revslider_fonts['queue'][$font]['url'] = $url;
			}
		}
	}
	
	
	/**
	 * add all options that change the slider here, for the cache to properly work
	 * @since: 6.4.6
	 **/
	public function get_transient_alias(){
		global $rs_slider_serial, $rs_wmpl;
		
		$gs = $this->get_global_settings();
		
		$transient = 'revslider_slider';
		$transient .= '_'.$this->get_slider_id();
		
		$args = array(
			'fontdownload' => $this->get_val($gs, 'fontdownload', 'off'),
			'serial'	=> $rs_slider_serial,
			'admin'		=> is_admin(),
			'settings'	=> $this->custom_settings,
			'order'		=> $this->custom_order,
			'usage'		=> $this->usage,
			'modal'		=> $this->modal,
			'layout'	=> $this->sc_layout,
			'skin'		=> $this->custom_skin,
			'offset'	=> $this->offset,
			'mid_content' => $this->gallery_ids,
			'export'	=> $this->markup_export,
			'preview'	=> $this->preview_mode,
			'published'	=> $this->only_published
		);
		
		if($this->get_preview_mode() == false){
			$args['lang'] = $rs_wmpl->get_slider_language($this->slider);
		}
		
		
		$transient .= '_'.md5(json_encode($args));
		
		return $transient;
	}
	
	
	/**
	 * push the needed JavaScript into the footer
	 * @since: 6.0
	 */
	private function add_javascript_to_footer(){
		$slver = apply_filters('revslider_remove_version', RS_REVISION); //allows to remove slider version at the JavaScript and CSS inclusions
		$ret = RS_T3.'<script src="'.RS_PLUGIN_URL_CLEAN.'public/assets/js/rbtools.min.js?rev='.$slver.'"></script>'."\n";
		if(!file_exists(RS_PLUGIN_PATH.'public/assets/js/rs6.min.js')){
			$ret .= RS_T3.'<script src="'. RS_PLUGIN_URL_CLEAN . 'public/assets/js/dev/rs6.main.js?rev='.$slver.'"></script>'."\n";
			//if on, load all libraries instead of dynamically loading them
			$ret .= RS_T3.'<script src="'. RS_PLUGIN_URL_CLEAN . 'public/assets/js/dev/rs6.actions.js?rev='.$slver.'"></script>'."\n";
			$ret .= RS_T3.'<script src="'. RS_PLUGIN_URL_CLEAN . 'public/assets/js/dev/rs6.carousel.js?rev='.$slver.'"></script>'."\n";
			$ret .= RS_T3.'<script src="'. RS_PLUGIN_URL_CLEAN . 'public/assets/js/dev/rs6.layeranimation.js?rev='.$slver.'"></script>'."\n";
			$ret .= RS_T3.'<script src="'. RS_PLUGIN_URL_CLEAN . 'public/assets/js/dev/rs6.navigation.js?rev='.$slver.'"></script>'."\n";
			$ret .= RS_T3.'<script src="'. RS_PLUGIN_URL_CLEAN . 'public/assets/js/dev/rs6.panzoom.js?rev='.$slver.'"></script>'."\n";
			$ret .= RS_T3.'<script src="'. RS_PLUGIN_URL_CLEAN . 'public/assets/js/dev/rs6.parallax.js?rev='.$slver.'"></script>'."\n";
			$ret .= RS_T3.'<script src="'. RS_PLUGIN_URL_CLEAN . 'public/assets/js/dev/rs6.slideanims.js?rev='.$slver.'"></script>'."\n";
			$ret .= RS_T3.'<script src="'. RS_PLUGIN_URL_CLEAN . 'public/assets/js/dev/rs6.video.js?rev='.$slver.'"></script>'."\n";
		}else{
			$ret .= RS_T3.'<script src="'. RS_PLUGIN_URL_CLEAN . 'public/assets/js/rs6.min.js?rev='.$slver.'"></script>'."\n";
		}
		
		return $ret;
	}
	
	/**
	 * print the HTML markup if no Slides are found in Slider
	 **/
	public function add_no_slides_markup(){
		if($this->slider->is_posts()){
			$text = __('No slides found, please add at least one Slide Template to the choosen language.', 'revslider');
		}else{
			$text = __('No slides found, please add some slides', 'revslider');
		}
		
		throw new Exception($text);
	}
	
	/**
	 * sets the Slide into a loop
	 **/
	public function set_slide_loop($slides){
		$loop = $this->slider->get_param(array('general', 'slideshow', 'loopSingle'), true);
		
		if(($loop == 'loop' || $loop == true) && count($slides) == 1){
			$new_slide = clone reset($slides);
			$new_slide->ignore_alt = true;
			$new_slide->set_id($new_slide->get_id().'-1');

			$slides[] = $new_slide;
			$this->set_is_single_slide(true);
		}
		
		return $slides;
	}
	
	/**
	 * check if the slide should only be visible in a certain timeframe, and if yes deny the output of the slide
	 **/
	public function is_in_timeframe(){
		$slide	= $this->get_slide();
		$in		= true;
		
		if($this->get_preview_mode() === false){ // do only if we are not in preview mode
			$ts = current_time('timestamp');
			
			//check if date is set
			$date_from = $slide->get_param(array('publish', 'from'), '');
			$date_to = $slide->get_param(array('publish', 'to'), '');
			
			if($date_from != ''){
				$date_from = strtotime($date_from);
				if($ts < $date_from) $in = false;
			}
			
			if($date_to != ''){
				$date_to = strtotime($date_to);
				if($ts > $date_to) $in = false;
			}
		}
		
		return $in;
	}
	
	/**
	 * Output Inline JS
	 */
	/*public function add_inline_js(){
		echo $this->rev_inline_js;
	}*/
	
	/**
	 * Output revslider_showDoubleJqueryError
	 */
	public function add_inline_double_jquery_error($do_check = false){
		global $rs_double_jquery_script;
		
		if($rs_double_jquery_script === false || $do_check === true){
			echo '<script>'."\n";
			echo RS_T2.'if(typeof revslider_showDoubleJqueryError === "undefined") {';
			echo 'function revslider_showDoubleJqueryError(sliderID) {';
			echo 'console.log("You have some jquery.js library include that comes after the Slider Revolution files js inclusion.");';
			echo 'console.log("To fix this, you can:");';
			echo 'console.log("1. Set \'Module General Options\' -> \'Advanced\' -> \'jQuery & OutPut Filters\' -> \'Put JS to Body\' to on");';
			echo 'console.log("2. Find the double jQuery.js inclusion and remove it");';
			echo 'return "Double Included jQuery Library";';
			echo '}';
			echo '}'."\n";
			echo '</script>'."\n";
		}
		$rs_double_jquery_script = (empty($do_check) || $do_check === false) ? true : $rs_double_jquery_script;
	}
	
	
	/**
	 * set the start size of the slider through javascript
	 **/
	public function get_html_js_start_size($optFullWidth, $optFullScreen){
		$csizes	= $this->get_responsive_size($this);
		$html_id_trimmed = $this->get_html_id(false);
		$jus = $this->slider->get_param(array('carousel', 'justify'), false);
		$revapi = $this->get_revapi();
		if($jus !== false) $jus="true";
		$html	= '';
		if(!$this->get_markup_export()){ //not needed for html markup export
			$html .= 'setREVStartSize(';
			$html .= "{c: '". $this->get_html_id() ."',";
			$html .= (isset($csizes['level']) && !empty($csizes['level'])) ? 'rl:['. $csizes['level'] .'],' : '';
			$html .= ($csizes['cacheSize'] !== false) ? 'el:['.$csizes['cacheSize'].'],' : '';
			$html .= "gw:[". $csizes['width'] ."],";
			$html .= "gh:[". $csizes['height'] ."],";
			$html .= "type:'";
			$html .= $this->slider->get_param('type', 'standard');
			$html .= "',";
			$html .= "justify:'";
			$html .= $jus;
			$html .= "',";
			$html .= "layout:'";
			$html .= ($optFullScreen == 'on') ? 'fullscreen' : 'fullwidth';
			$html .= "',";
			if($this->slider->get_param('type', 'standard') !== 'hero'){
				$check = array('tab' => 'tabs', 'thumb' => 'thumbs');
				$wpd = array('tabs' => 2, 'thumbs' => 10);
				foreach($check as $nk => $nav){
					$do = false;
					if($this->slider->get_param(array('nav', $nav, 'set'), false) !== true) continue;
					if($this->slider->get_param(array('nav', $nav, 'innerOuter'), 'inner') === 'outer-vertical'){
						$html .= $nk.'w:"'.$this->slider->get_param(array('nav', $nav, 'widthMin'), 100).'",';
						$do = true;
					}
					if($this->slider->get_param(array('nav', $nav, 'innerOuter'), 'inner') === 'outer-horizontal'){
						$wp = intval($this->slider->get_param(array('nav', $nav, 'padding'), $wpd[$nav]));
						$h = $this->slider->get_param(array('nav', $nav, 'height'), 50);
						$h = ($wp > 0) ? $h + $wp * 2 : $h;
						
						$html .= $nk.'h:"'.$h.'",';
						$do = true;
					}
					
					if($do === false) continue;
					if($this->slider->get_param(array('nav', $nav, 'hideUnder'), false) === false) continue;
					
					$html .= $nk.'hide:"'.$this->slider->get_param(array('nav', $nav, 'hideUnderLimit'), 0).'",';
				}
			}
			if($this->slider->get_param('layouttype') == 'fullscreen'){
				$html .= "offsetContainer:'". esc_attr($this->slider->get_param(array('size', 'fullScreenOffsetContainer'), '')) ."',";
				$html .= "offset:'". esc_attr($this->slider->get_param(array('size', 'fullScreenOffset'), '')) ."',";
			}
			$mheight = ($this->slider->get_param('layouttype') !== 'fullscreen') ? $this->slider->get_param(array('size', 'minHeight'), 0) : $this->slider->get_param(array('size', 'minHeightFullScreen'), '0');
			$mheight = ($mheight == '' || $mheight=="none") ? 0 : $mheight;
			$html .= 'mh:"'.$mheight.'"';
			$html .= '}';
			$html .= ');';
			$html .= 'if (window.RS_MODULES!==undefined && window.RS_MODULES.modules!==undefined && window.RS_MODULES.modules["'. $html_id_trimmed .'"]!==undefined) {';
			$html .= 'window.RS_MODULES.modules["'. $html_id_trimmed .'"].once = false;';
			$html .= 'window.'. $revapi .' = undefined;';
			$html .= 'if (window.RS_MODULES.checkMinimal!==undefined) window.RS_MODULES.checkMinimal()';
			$html .= '}';
		}
		
		return $html;
	}
	
	/**
	 * add error message into the console
	 */
	public function print_error_message_console($message){

		$message = $this->slider->get_title().': '.$message;
		$html = '';
		$html .= '<script>';
		$html .= 'console.log("'.esc_html($message).'")';
		$html .= '</script>'."\n";

		echo $html;
	}

	/**
	 * put inline error message in a box.
	 * @before: RevSliderOutput::putErrorMessage
	 */
	public function print_error_message($message, $open_page = false){
		global $rs_slider_serial;
		
		$html_id = $this->get_html_id();
		
		$id = '';
		$html = '';
		
		if(empty($html_id)){
			$html_id = 'rev_slider_error_'.$rs_slider_serial;
		}else{
			$slides = $this->slider->get_slides();
			
			if(!empty($slides)){
				foreach($slides as $slide){
					$id = $slide->get_id();
					break;
				}
			}
		}
		
		$url = (empty($html_id) || !is_user_logged_in() || $id === '') ? '' : admin_url('admin.php?page=revslider&view=slide&id='.$id);
		$page_url = ($open_page === true && is_user_logged_in()) ? get_edit_post_link() : '';
		
		$html .= ($this->rs_module_wrap_open === false) ? RS_T3.'<rs-module-wrap id="'.$html_id.'_wrapper">'."\n" : '';
		$html .= ($this->rs_module_open === false) ? RS_T4.'<rs-module id="'.$html_id.'">'."\n" : '';
		$html .= RS_T5.'<div class="rs_error_message_box">'."\n";
		$html .= RS_T6.'<div class="rs_error_message_oops">Oops...</div>'."\n";
		$html .= RS_T6.'<div class="rs_error_message_content">'.esc_html($message);
		$html .= (!empty($url)) ? '<br>'.__('Please follow this link to edit the Slider:', 'revslider') : '';
		$html .= '</div>'."\n";
		$html .= (!empty($url)) ? RS_T6.'<a href="'.$url.'" target="_blank" rel="noopener" class="rs_error_message_button">Edit Module : "'.$this->slider->get_alias().'"</a>'."\n" : '';
		$html .= (!empty($page_url)) ? RS_T6.'<a href="'.$page_url.'" target="_blank" rel="noopener" class="rs_error_message_button">Edit Page</a>'."\n" : '';
		$html .= RS_T5.'</div>'."\n";
		$html .= ($this->rs_module_wrap_closed === false) ? RS_T4.'</rs-module>'."\n" : '';
		$html .= ($this->rs_module_closed === false) ? RS_T3.'</rs-module-wrap>'."\n" : '';
		
		$html .=  RS_T3.'<script>'."\n";
		$html .=  RS_T4.'var rs_eslider = document.getElementById("'.$html_id.'");'."\n";
		if(is_user_logged_in()){
			$html .=  RS_T4.'rs_eslider.style.display = "block";'."\n";
			$html .=  RS_T4.'rs_eslider.style.visibility = "visible";'."\n";
		}else{
			$html .=  RS_T4.'rs_eslider.style.display = "none";'."\n";
			$html .=  RS_T4.'console.log("'.esc_html($message).'");'."\n";
		}
		$html .=  RS_T3.'</script>'."\n";
		
		echo $html;
	}
	
	
	/**
	 * add JavaScript
	 **/
	private function add_js(){
		global $rs_loaded_by_editor;

		$cache			 = RevSliderGlobals::instance()->get('RevSliderCache');
		$me				 = $this->get_markup_export();
		$this->full_js	 = (($this->usage === 'modal' && $this->ajax_loaded === true) || $me === true || $this->ajax_loaded === true || $rs_loaded_by_editor === true) ? true : false;
		if($this->full_js === false) $this->JTA = ''; //remove 2 tabs to beautify HTML
		
		$html_start_size = $this->js_get_start_size();
		
		$html_base_pre	 = $this->js_get_base_pre();
		$html_root		 = $this->js_get_root();
		$html_overlay    = $this->js_get_overlay();
		$html_modal      = $this->js_get_modal();
		$html_carousel	 = $this->js_get_carousel();
		$html_progressbar = $this->js_get_progressbar();
		$html_nav		 = $this->js_get_navigation();
		$html_paralax	 = $this->js_get_parallax();
		$html_first_anim = $this->js_get_first_anim_data();
		$html_scroll	 = $this->js_get_scrolleffect();
		$html_sb_timeline = $this->js_get_scrollbased_timeline();
		$html_view_port	 = $this->js_get_viewport();
		$html_custom_eases = $this->js_get_custom_eases();
		
		$html_fallback	 = $this->js_get_fallback();		
		$html_custom_css = $this->js_get_custom_css();
		$html_base_post	 = $this->js_get_base_post();
		$html_nav_css 	 = $this->get_navigation_css();
		$html_spinner	 = $this->get_spinner_markup();
		$html_notice	 = $this->get_notices();
		
		echo $html_start_size;
		
		$js = ($me === true) ? '<!-- SCRIPT -->' : '';
		
		//add inline style into the footer
		$js .= $html_base_pre;
		
		$js .= $html_root;
		$js .= $html_overlay;
		$js .= $html_modal;
		$js .= $html_carousel;
		$js .= $html_progressbar;
		$js .= $html_nav;
		$js .= $html_paralax;
		$js .= $html_first_anim;
		$js .= $html_scroll;
		$js .= $html_sb_timeline;
		$js .= $html_view_port;
		$js .= $html_custom_eases;
		
		$js .= $html_fallback;		
		$js .= $html_base_post;
		
		$js .= $html_custom_css;
		$js .= $html_spinner;
		$js .= $html_notice;
		$js .= $html_nav_css;
		
		$js .= ($me === true) ? '<!-- /SCRIPT -->' : '';
		
		if($this->full_js){
			echo $js;
		}else{
			global $rs_js_collection;
			//$this->rev_inline_js = $js;
			$rs_js_collection['js'][] = $js;
			if($this->caching) $cache->add_addition('action', 'wp_print_footer_scripts', $js);
			
			//add_action('wp_print_footer_scripts', array($this, 'add_inline_js'), 100);
		}
		if($me === true){ //for html markup export
			$this->add_inline_double_jquery_error();
		}else{
			if(has_action('wp_footer', array($this, 'add_inline_double_jquery_error')) === false){
				if($this->caching){
					ob_start();
					$this->add_inline_double_jquery_error(true);
					$double_jquery = ob_get_contents();
					ob_clean();
					ob_end_clean();
					$cache->add_addition('action', 'wp_footer', $double_jquery);
				}
				add_action('wp_footer', array($this, 'add_inline_double_jquery_error'));
			}
		}
	}
	
	
	/**
	 * get the start size
	 **/
	public function js_get_start_size(){
		$layout = $this->slider->get_param('layouttype');
		$fw = ($layout == 'fullwidth') ? 'on' : 'off';
		$fw = ($layout == 'fullscreen') ? 'off' : $fw;
		$fs = ($layout == 'fullscreen') ? 'on' : 'off';
		$html	= '';
		$html	.= RS_T4.'<script>'."\n";
		$html	.= RS_T5.$this->get_html_js_start_size($fw, $fs)."\n";
		$html	.= RS_T4.'</script>'."\n";
		
		return $html;
	}
	
	/**
	 * get the JavaScript Pre
	 **/
	public function js_get_base_pre(){
		global $rs_js_collection, $rs_slider_serial;
		$html	= '';
		$sid	= $this->slider->get_id();
		$html_id = $this->get_html_id();
		$html_id_trimmed = $this->get_html_id(false);
		$revapi = $this->get_revapi();
		
		$rs_js_collection['revapi'][] = $revapi;
		if($this->caching){
			$cache = RevSliderGlobals::instance()->get('RevSliderCache');
			if($rs_js_collection['minimal'] === ''){
				$cache->add_addition('action', 'wp_print_footer_scripts', $this->JTA . RS_T2.'var	tpj = jQuery;'."\n", 1);
			}
			$cache->add_addition('action', 'wp_print_footer_scripts', $this->JTA . RS_T2.'var	'. $revapi .';'."\n", 1);
		}
		if($this->full_js){
			$html .= $this->JTA . RS_T.'<script>'."\n";
			$html .= $this->JTA . RS_T2.'var	tpj = jQuery;'."\n";
			//$html .= $this->JTA . RS_T2.'window.'. $revapi .' = window.'. $revapi .'===undefined || window.'. $revapi .'===null || window.'. $revapi .'.length===0  ? document.getElementById("'. $html_id .'") : window.'. $revapi .';'."\n";
		}		
		$html .= $this->JTA . RS_T2.'if(window.RS_MODULES === undefined) window.RS_MODULES = {};'."\n";
		$html .= $this->JTA . RS_T2.'if(RS_MODULES.modules === undefined) RS_MODULES.modules = {};'."\n";
		$html .= $this->JTA . RS_T2.'RS_MODULES.modules["'.$html_id_trimmed .'"] = {once: RS_MODULES.modules["'.$html_id_trimmed .'"]!==undefined ? RS_MODULES.modules["'.$html_id_trimmed .'"].once : undefined, init:function() {'."\n";		
		$html .= $this->JTA . RS_T3.'window.'. $revapi .' = window.'. $revapi .'===undefined || window.'. $revapi .'===null || window.'. $revapi .'.length===0  ? document.getElementById("'. $html_id .'") : window.'. $revapi .';'."\n";
		$html .= $this->JTA . RS_T3.'if(window.'. $revapi .' === null || window.'. $revapi .' === undefined || window.'. $revapi .'.length==0) { window.'. $revapi .'initTry = window.'. $revapi .'initTry ===undefined ? 0 : window.'. $revapi .'initTry+1; if (window.'. $revapi .'initTry<20) requestAnimationFrame(function() {RS_MODULES.modules["'.$html_id_trimmed .'"].init()}); return;}'."\n";
		$html .= $this->JTA . RS_T3.'window.'.$revapi.' = jQuery(window.'. $revapi .');'."\n";
		if($this->full_js){
			$html .= ($this->slider->get_param(array('troubleshooting', 'jsNoConflict'), true) === true) ? $this->JTA . RS_T3.'jQuery.noConflict();'."\n" : ''; 
		}		
		$html .= $this->JTA . RS_T3.'if(window.'.$revapi.'.revolution==undefined){ revslider_showDoubleJqueryError("'.$html_id.'"); return;}'."\n";				
		$html = apply_filters('revslider_fe_before_init_script', $html, $this->slider, $html_id); // needed for AddOns
		$html .= $this->JTA . RS_T3.$revapi.'.revolutionInit({'."\n";
		
		return $html;
	}


	/**
	 * get the JavaScript Post
	 **/
	public function js_get_base_post(){
		global $rs_js_collection, $rs_slider_serial;
		$revapi = $this->get_revapi();
		$html = '';
		ob_start();
		do_action('revslider_fe_javascript_option_output', $this->slider);
		$js_action = ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		$html .= $js_action;
		$html .= $this->JTA . RS_T3.'});'."\n";
		$html .= (in_array('revapi'.$this->slider->get_id(), $rs_js_collection['revapi'], true) && $revapi !== 'revapi'.$this->slider->get_id()) ? $this->JTA . RS_T3 . 'var revapi'. $this->slider->get_id() .' = '. $revapi .';'."\n" : ''; //added for addons that use the old revapi style
		$html .= $this->js_get_custom_js();
		$html .= $this->JTA . RS_T3;
		
		ob_start();
		do_action('revslider_fe_javascript_output', $this->slider, $this->get_html_id());
		$js_action = ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		$html .= $js_action;
		$html .= "\n";
		$html .= $this->JTA . RS_T2.'}} // End of RevInitScript'."\n";
		
		$minimal = $this->JTA . RS_T2.'if (window.RS_MODULES.checkMinimal!==undefined) { window.RS_MODULES.checkMinimal();};'."\n";
		if($this->full_js){
			$html .= $minimal;
		}else{
			global $rs_js_collection;
			if($rs_js_collection['minimal'] === ''){
				$rs_js_collection['minimal'] = $minimal;
				if($this->caching){
					$cache = RevSliderGlobals::instance()->get('RevSliderCache');
					$cache->add_addition('action', 'wp_print_footer_scripts', $minimal, 99);
				}
			}
		}
		
		if($this->full_js){
			$html .= $this->JTA . RS_T.'</script>'."\n";
		}
		
		return $html;
	}

	/**
	 * get the custom js
	 **/
	public function js_get_custom_js(){
		$html = '';
		$js = $this->slider->get_param(array('codes', 'javascript'), '');
		if($js === '') return '';
		
		$js = $this->replace_html_ids($js);
		
		$html .= RS_T7;
		$html .= str_replace('var counter = {val:doctop};', 'var counter = {val:(window.pageYOffset || document.documentElement.scrollTop)  - (document.documentElement.clientTop || 0)};', $js); //stripslashes($js));
		$html .= "\n";
		
		return $html;
	}

	/**
	 * get the custom css
	 **/
	public function js_get_custom_css(){
		$html = '';
		$css = $this->slider->get_param(array('codes', 'css'), '');
		if($css === '') return $html;
		
		return $this->get_css_javascript($this->replace_html_ids($css));
	}

	/**
	 * get the spinner markup if a spinner was selected
	 **/
	public function get_spinner_markup(){
		$html = '';

		$spinner = (string)$this->slider->get_param(array('layout', 'spinner', 'type'), '0');
		$color	 = $this->slider->get_param(array('layout', 'spinner', 'color'), '#FFFFFF');
		
		switch($spinner){
			case '1':
			case '2':
				$css_html = "#".$this->get_html_id()."_wrapper rs-loader.spinner".$spinner."{ background-color: ". $color ." !important; }";
				$html = $this->get_css_javascript($css_html);
			break;
			case '3':
			case '4':
				$css_html = "#".$this->get_html_id()."_wrapper rs-loader.spinner".$spinner." div { background-color: ". $color ." !important; }";
				$html = $this->get_css_javascript($css_html);
			break;
			case '0':
			case '5':
			default:
			break;
		}
		
		return $html;
	}
	
	/**
	 * get notices for the console
	 * @since: 6.1.6
	 **/
	public function get_notices(){
		$html = '';
		
		if($this->orig_html_id !== false){
			//$html .= $this->JTA . RS_T.'<script>'."\n";
			$html .= $this->JTA . RS_T2.'console.log("'.sprintf(__('Warning - ID: %s exists already and was converted to: %s', 'revslider'), $this->orig_html_id, $this->get_html_id()).'")'."\n";
			//$html .= $this->JTA . RS_T.'</script>'."\n";
		}
		
		return $html;
	}
	
	/**
	 * replace the ids in a text/html/css/javascript
	 **/
	public function replace_html_ids($text, $prefix = '#'){
		return ($this->orig_html_id !== false) ? str_replace($prefix.$this->orig_html_id, $prefix.$this->get_html_id(), $text) : $text;
	}

	/**
	 * get the fallback attibutes
	 **/
	public function js_get_fallback(){
		$html = '';
		$s	= $this->slider; //shorten
		$fb	= array();
		
		$dpz = $s->get_param(array('general', 'disablePanZoomMobile'), false);
		$sii = $s->get_param(array('troubleshooting', 'simplify_ie8_ios4'), true); //was false
		$dfl = $s->get_param(array('general', 'disableFocusListener'), false);
		$urlhash = $s->get_param(array('general', 'enableurlhash'), false);
		$apvom = $s->get_param(array('general', 'autoPlayVideoOnMobile'), true);
		if($dpz !== false) $fb['panZoomDisableOnMobile'] = $dpz;
		if($sii !== false) $fb['simplifyAll'] = $sii;
		if($s->get_param('type', 'standard') !== 'hero'){
			$nsof = $s->get_param(array('general', 'nextSlideOnFocus'), false);
			if($nsof !== false) $fb['nextSlideOnWindowFocus'] = $nsof;
		}
		if($dfl !== false) $fb['disableFocusListener'] = $dfl;
		if($urlhash !== false) {
			$html .= $this->JTA . RS_T5.'enableDeeplinkHash : true,'."\n";;
		}
		if($apvom !== false) $fb['allowHTML5AutoPlayOnAndroid'] = $apvom;
		
		if(!empty($fb)){
			$ff = true;
			$html .= $this->JTA . RS_T5.'fallbacks: {'."\n";
			foreach($fb as $k => $v){
				$html .= ($ff === true) ? '' : ','."\n";
				$html .= $this->JTA . RS_T6.$k.':';
				$html .= $this->write_js_var($v);
				$ff = false;
			}
			$html .= "\n".$this->JTA . RS_T5.'},'."\n";
		}
		
		return $html;
	}

	/**
	 * get the progressbar attibutes
	 **/
	public function js_get_progressbar(){
		$html = '';
		$s	= $this->slider; //shorten
		$s_type = $s->get_param('type', 'standard');

		if($s->get_param(array('general', 'progressbar', 'set'), true) === false || $s_type === 'hero'){
			$html = $this->JTA . RS_T5.'progressBar:{disableProgressBar:true},'."\n";
		} else {
			
			$pb	= array();
			
			$pb_basedon = $s->get_param(array('general', 'progressbar', 'basedon'), 'slide');
			$pb_bgcolor = RSColorpicker::get($s->get_param(array('general', 'progressbar', 'bgcolor'), 'transparent'));
			$pb_color = RSColorpicker::get($s->get_param(array('general', 'progressbar', 'color'), 'rgba(255,255,255,0.5)'));
			$pb_gapcolor = RSColorpicker::get($s->get_param(array('general', 'progressbar', 'gapcolor'), 'rgba(255,255,255,0.5)'));
			$pb_gap = $s->get_param(array('general', 'progressbar', 'gap'), false);

			$pb_gaps = $s->get_param(array('general', 'progressbar', 'gapsize'), '0');
			$pb_reset = $s->get_param(array('general', 'progressbar', 'reset'), 'reset');
			$pb_horizontal = $s->get_param(array('general', 'progressbar', 'horizontal'), 'left');
			$pb_ond = $s->get_param(array('general', 'progressbar', 'visibility', 'd'), true);
			$pb_onn = $s->get_param(array('general', 'progressbar', 'visibility', 'n'), true);
			$pb_ont = $s->get_param(array('general', 'progressbar', 'visibility', 't'), true);
			$pb_onm = $s->get_param(array('general', 'progressbar', 'visibility', 'm'), true);
			
			// take care about fall back on old vertical position if still exists
			$pb_vertical = $s->get_param(array('general', 'progressbar', 'vertical'), 'bottom');
			$pb_old_position = $s->get_param(array('general', 'progressbar', 'position'), 'bottom');
			if ($pb_old_position!=="bottom" && $pb_vertical==="bottom") $pb_vertical = $pb_old_position;
			
			// take care about fall back on old height if still exists
			$pb_size = $s->get_param(array('general', 'progressbar', 'size'), '5px');
			$pb_old_height = $s->get_param(array('general', 'progressbar', 'height'), 5);
			if ($pb_old_height!=="5px" && $pb_size==="5px") $pb_size = $pb_old_height;

			$pb_style = $s->get_param(array('general', 'progressbar', 'style'), 'horizontal');
			$pb_radius = $s->get_param(array('general', 'progressbar', 'radius'), 10);
			$pb_xof = $s->get_param(array('general', 'progressbar', 'x'), '0px');
			$pb_yof = $s->get_param(array('general', 'progressbar', 'y'), '0px');

			$pb_alignby = $s->get_param(array('general', 'progressbar', 'alignby'), 'slider');

			if ($pb_basedon!=="slide") $pb['basedon'] = $pb_basedon;
			if ($pb_alignby!=="slider") $pb['alignby'] = $pb_alignby;
			if ($pb_bgcolor!=="transparent") $pb["bgcolor"] = $pb_bgcolor;
			if ($pb_color!=="rgba(255,255,255,0.5)") $pb["color"] = $pb_color;
			if ($pb_basedon==="module") {
				if ($pb_gaps!==0) $pb['gapsize'] = $pb_gaps;
				if ($pb_gapcolor!=="rgba(255,255,255,0.5)") $pb['gapcolor'] = $pb_gapcolor;
				if ($pb_gap!==false) $pb['gap'] = $pb_gap;
			}
			
			if ($pb_style!=="horizontal") $pb['style'] = $pb_style;
			if ($pb_horizontal!=="left") $pb['horizontal'] = $pb_horizontal;
			if ($pb_vertical!=="bottom") $pb['vertical'] = $pb_vertical;
			if ($pb_size!=="5px") $pb['size'] = $pb_size;
			if (($pb_style=="ccw" || $pb_style=="cw") && $pb_radius!==10) $pb['radius'] = $pb_radius;
			if ($pb_xof!=="0px") $pb['x'] = $pb_xof;
			if ($pb_yof!=="0px") $pb['y'] = $pb_yof;
			if ($pb_reset!=="reset") $pb['reset'] = $pb_reset;
			
			if(!empty($pb)){
				$ff = true;
				$html .= $this->JTA . RS_T5.'progressBar: {'."\n";
				foreach($pb as $k => $v){
					$html .= ($ff === true) ? '' : ','."\n";
					$html .= $this->JTA . RS_T6.$k.':';
					$html .= $this->write_js_var($v);
					$ff = false;
				}				
				if ($pb_ond!==true || $pb_onn!==true || $pb_onm!==true || $pb_ont!==true) {
					$html .= ($ff === true) ? '' : ','."\n";
					$ff = true;
					$html .= $this->JTA . RS_T6.'visibility: {'."\n";
					if ($pb_ond!=true) {
						$html .= ($ff === true) ? '' : ','."\n";
						$html .= $this->JTA . RS_T7.'0:false';
						$ff = false;
					}
					if ($pb_onn!=true) {
						$html .= ($ff === true) ? '' : ','."\n";
						$html .= $this->JTA . RS_T7.'1:false';
						$ff = false;
					}
					if ($pb_ont!=true) {
						$html .= ($ff === true) ? '' : ','."\n";
						$html .= $this->JTA . RS_T7.'2:false';
						$ff = false;
					}
					if ($pb_onm!=true) {
						$html .= ($ff === true) ? '' : ','."\n";
						$html .= $this->JTA . RS_T7.'3:false';
						$ff = false;
					}
					$html .= "\n".$this->JTA . RS_T6.'},'."\n";
				}
				$html .= "\n".$this->JTA . RS_T6.'},'."\n";
			}
		}
		
		return $html;
	}


	/**
	 * get the viewport attibutes
	 **/
	public function js_get_viewport(){
		$html = '';
		$s	= $this->slider; //shorten
		$vp	= array();
		
		$evp = $s->get_param(array('general', 'slideshow', 'viewPort'), false);
		$evpg = $s->get_param(array('general', 'slideshow', 'globalViewPort'), false);
		$vp['global'] = $evpg;
		if($evpg !== "none"){
			$evpgd = $s->get_param(array('general', 'slideshow', 'globalViewDist'), '-200px');
			$vp['globalDist'] = $evpgd;
		}
		
		
		if(($evp === false && ($evpg === "false" || $evpg === "none")) || $evpg === "false") return $html;
		
		$vps = $s->get_param(array('general', 'slideshow', 'viewPortStart'), 'wait');
		$psh = $s->get_param(array('general', 'slideshow', 'presetSliderHeight'), false);
		$vpa = $s->get_param(array('general', 'slideshow', 'viewPortArea'), 200);
		
		if($this->adv_resp_sizes == true){
			$vpa = $this->normalize_device_settings($vpa, $this->enabled_sizes, 'html-array', array(200));
		}else{
			if(is_array($vpa) || is_object($vpa)) $vpa = $this->get_biggest_device_setting($vpa, $this->enabled_sizes); //vpa was before only on one level, so it can be a string or integer in the past
		}
		
		$vp['enable'] = $evp;
		if($vps !== 'wait') $vp['outof'] = $vps;
		if(!in_array($vpa, array(200, '200', '200px'), true)) $vp['visible_area'] = $vpa;
		if($psh !== false) $vp['presize'] = $psh;
		
		if(!empty($vp)){
			$ff = true;
			$html .= $this->JTA . RS_T5.'viewPort: {'."\n";
			foreach($vp as $k => $v){
				$html .= ($ff === true) ? '' : ','."\n";
				$html .= $this->JTA . RS_T6.$k.':';
				$html .= $this->write_js_var($v);
				$ff = false;
			}
			$html .= "\n".$this->JTA . RS_T5.'},'."\n";
		}
		
		return $html;
	}
	
	/**
	 * get the custom easings
	 **/
	public function js_get_custom_eases(){
		$html	 = '';
		$easings = array();
		$custom_easings = array('SFXBounceLite', 'SFXBounceSolid', 'SFXBounceStrong', 'SFXBounceExtrem', 'BounceLite', 'BounceSolid', 'BounceStrong', 'BounceExtrem');
		
		if(!empty($this->easings)){
			foreach($custom_easings as $ce){
				if(isset($this->easings[$ce])){
					$easings[] = $ce;
				}
			}
		}
		
		if(!empty($easings)){
			$ff = true;
			$html .= $this->JTA . RS_T5.'customEases: {'."\n";
			foreach($easings as $v){
				$html .= ($ff === true) ? '' : ','."\n";
				$html .= $this->JTA . RS_T6.$v.':';
				$html .= 'true';
				$ff = false;
			}
			$html .= "\n".$this->JTA . RS_T5.'},'."\n";
		}
		
		return $html;
	}

	/**
	 * get the scrolleffect attibutes
	 **/
	public function js_get_scrolleffect(){
		$html = '';
		$s	= $this->slider; //shorten
		$se	= array();
		
		$ge = $s->get_param(array('scrolleffects', 'set'), false);
		if($ge === false) return $html;
		
		$fa	 = $s->get_param(array('scrolleffects', 'setFade'), false);
		$bl	 = $s->get_param(array('scrolleffects', 'setBlur'), false);
		$sgs = $s->get_param(array('scrolleffects', 'setGrayScale'), false);
		$mb	 = $s->get_param(array('scrolleffects', 'maxBlur'), 10);
		$ol	 = $s->get_param(array('scrolleffects', 'layers'), false);
		$bg	 = $s->get_param(array('scrolleffects', 'bg'), false);
		$d	 = $s->get_param(array('scrolleffects', 'direction'), 'both');
		$mp	 = $s->get_param(array('scrolleffects', 'multiplicator'), '1.35'); //was 1.3
		$mpl = $s->get_param(array('scrolleffects', 'multiplicatorLayers'), '0.5'); //was 1.3
		$ti	 = $s->get_param(array('scrolleffects', 'tilt'), '30');
		$dom = $s->get_param(array('scrolleffects', 'disableOnMobile'), false);
		
		$se['set'] = $ge;
		if($fa !== false) $se['fade'] = $fa;
		if($bl !== false) $se['blur'] = $bl;
		if($sgs !== false) $se['grayscale'] = $sgs;
		if(!in_array($mb, array(10, '10', '10px'), true)) $se['maxblur'] = $mb;
		if($ol !== false) $se['layers'] = $ol;
		if($bg !== false) $se['slide'] = $bg;		
		if($d !== 'both') $se['direction'] = $d;
		if(!in_array($mp, array(1.35, '1.35'), true)) $se['multiplicator'] = $mp;
		if(!in_array($mpl, array(0.5, '0.5'), true))$se['multiplicator_layers'] = $mpl;
		if(!in_array($ti, array(30, '30'), true)) $se['tilt'] = $ti;
		if($dom !== false) $se['disable_onmobile'] = $dom;
		
		if(!empty($se)){
			$ff = true;
			$html .= $this->JTA . RS_T5.'scrolleffect: {'."\n";
			foreach($se as $k => $v){
				$html .= ($ff === true) ? '' : ','."\n";
				$html .= $this->JTA . RS_T6.$k.':';
				$html .= $this->write_js_var($v);
				$ff = false;
			}
			$html .= "\n".$this->JTA . RS_T5.'},'."\n";
		}
		
		return $html;
	}

	/**
	 * get the scroll based timeline settings
	 */
	public function js_get_scrollbased_timeline(){
		$html = '';
		$s	= $this->slider; //shorten
		$se	= array();
		
		$fa	 = $s->get_param(array('scrolltimeline', 'set'), false);
		
		if($fa === false) return $html;
		
		$pc	 = $s->get_param(array('scrolltimeline', 'pullcontent'), false);
		$ol	 = $s->get_param(array('scrolltimeline', 'layers'), false);
		$ea	 = $s->get_param(array('scrolltimeline', 'ease'), 'none');
		$this->easings[$ea] = $ea;
		$sp	 = $s->get_param(array('scrolltimeline', 'speed'), 500);
		
		$sfix	= $s->get_param(array('scrolltimeline', 'fixed'), false);
		$sfixs	= $s->get_param(array('scrolltimeline', 'fixedStart'), 0);
		$sfixe	= $s->get_param(array('scrolltimeline', 'fixedEnd'), 0);

		$se['set'] = $fa;
		if($pc !== false) $se['pullc'] = $pc;
		if($ol !== false) $se['layers'] = $ol;
		if($ea !== 'none') $se['ease'] = $ea;
		if($sp !== 500 && $sp !== '500' && $sp !== '500ms') $se['speed'] = $sp;
		if($sfix === true){
			$se['fixed']	= $sfix;
			$se['fixStart']	= $sfixs;
			$se['fixEnd']	= $sfixe;
		}

		if(!empty($se)){
			$ff = true;
			$html .= $this->JTA . RS_T5.'sbtimeline: {'."\n";
			foreach($se as $k => $v){
				$html .= ($ff === true) ? '' : ','."\n";
				$html .= $this->JTA . RS_T6.$k.':';
				$html .= $this->write_js_var($v);
				$ff = false;
			}
			$html .= "\n".$this->JTA . RS_T5.'},'."\n";
		}
		
		return $html;
		
	}
	

	/**
	 * get the carousel attibutes
	 **/
	public function js_get_parallax(){
		$html = '';
		$s	= $this->slider; //shorten
		$p	= array();
		
		if($s->get_param(array('parallax', 'set'), false) === false) return $html;

		$sd = $s->get_param(array('parallax', 'setDDD'), false);
		$pt = ($sd === true) ? '3D' : $s->get_param(array('parallax', 'mouse', 'type'), 'off');
		$pl = array();
		for($i = 0; $i <= 15; $i++){
			$pl[] = intval($s->get_param(array('parallax', 'levels', $i), ($i + 1) * 5));
		}
		$pl = implode(',', $pl);
		$or = ($sd === true) ? 'slidercenter' : $s->get_param(array('parallax', 'mouse', 'origo'), 'enterpoint');
		$sp = $s->get_param(array('parallax', 'mouse', 'speed'), 400);
		$dpm = $s->get_param(array('parallax', 'disableOnMobile'), false);
		$bgs = $s->get_param(array('parallax', 'mouse', 'bgSpeed'), 0);
		$ls = $s->get_param(array('parallax', 'mouse', 'layersSpeed'), 0);
		
		$p['levels'] = '['.$pl.']';
		if($pt !== 'off') $p['type'] = $pt;
		if($or !== 'enterpoint') $p['origo'] = $or;
		if(!in_array($sp, array(400, '400', '400ms'), true)) $p['speed'] = $sp;
		if($dpm !== false) $p['disable_onmobile'] = $dpm;
		if($pt === '3D'){
			$sh	 = $s->get_param(array('parallax', 'ddd', 'shadow'), false);
			$bgf = $s->get_param(array('parallax', 'ddd', 'BGFreeze'), false);
			$of	 = $s->get_param(array('parallax', 'ddd', 'overflow'), false);
			$lof = $s->get_param(array('parallax', 'ddd', 'layerOverflow'), false);
			$zc	 = $s->get_param(array('parallax', 'ddd', 'zCorrection'), 400);
			
			if($sh !== false) $p['ddd_shadow'] = $sh;
			if($bgf !== false) $p['ddd_bgfreeze'] = $bgf;
			if($of !== false) $p['ddd_overflow'] = ($of === false) ? 'visible' : 'hidden';
			if($lof !== false) $p['ddd_layer_overflow'] = $lof;
			if(!in_array($zc, array(400, '400', '400px'), true)) $p['ddd_z_correction'] = $zc;
		}
		if(!in_array($bgs, array(0, '0', '0ms'), true)) $p['speedbg'] = $bgs;
		if(!in_array($ls, array(0, '0', '0ms'), true)) $p['speedls'] = $ls;
		
		if(!empty($p)){
			$ff = true;
			$html .= $this->JTA . RS_T5.'parallax: {'."\n";
			foreach($p as $k => $v){
				$html .= ($ff === true) ? '' : ','."\n";
				$html .= $this->JTA . RS_T6.$k.':';
				$html .= $this->write_js_var($v);
				$ff = false;
			}
			$html .= "\n".$this->JTA . RS_T5.'},'."\n";
		}
		
		return $html;
	}

	/**
	 * get the overlay attributes
	 * @since: 6.4.0
	 */
	public function js_get_overlay(){
		$html	= '';
		$s		= $this->slider; //shorten
		$do		= $s->get_param(array('layout', 'bg', 'dottedOverlay'), 'none');
		
		if($do !== 'none'){
			$colora = str_replace(' ', '', $s->get_param(array('layout', 'bg', 'dottedColorA'), 'transparent'));
			$colorb = str_replace(' ', '', $s->get_param(array('layout', 'bg', 'dottedColorB'), '#000000'));
			$size	= $s->get_param(array('layout', 'bg', 'dottedOverlaySize'), 1);
			
			$html .= $this->JTA . RS_T5.'overlay: {'."\n";
			$html .= $this->JTA . RS_T6.'type: '.$this->write_js_var($do).",\n";
			$html .= ($colora !== 'transparent') ? $this->JTA . RS_T6.'colora: '.$this->write_js_var($colora).",\n" : '';
			$html .= (!in_array($colorb, array('', '#000000', '#000'), true)) ? $this->JTA . RS_T6.'colorb: '.$this->write_js_var($colorb).",\n" : '';
			$html .= (!in_array($size, array('', '1', 1), true)) ? $this->JTA . RS_T6.'size: '.$this->write_js_var($size).",\n" : '';
			$html .= "\n".$this->JTA . RS_T5.'},'."\n";
		}
		
		return $html;
	}
	
	
	/**
	 * get the Modal Attributes
	 */
	public function js_get_modal(){
		$html	= '';
		$s		= $this->slider; //shorten
		
		if($this->usage !== 'modal') return $html;
		
		$cover = $s->get_param(array('modal', 'cover'), true);
		$pagescroll = $s->get_param(array('modal', 'allowPageScroll'), true);
		$bodyclass = $s->get_param(array('modal', 'bodyclass'), '');		
		$speed = $s->get_param(array('modal', 'coverSpeed'), 1);
		$color = $s->get_param(array('modal', 'coverColor'), 'rgba(0,0,0,0.5)');
		$h = $s->get_param(array('modal', 'horizontal'), 'center');
		$v = $s->get_param(array('modal', 'vertical'), 'middle');
		
		$c['useAsModal'] = true;
		$c['alias'] = esc_attr($this->slider->get_alias());
		if($bodyclass !== '') $c['bodyclass'] = $bodyclass;
		if($cover !== true) $c['cover'] = $cover;
		if($pagescroll === true) $c['allowPageScroll'] = true;
		if($color !== 'rgba(0,0,0,0.5)') $c['coverColor'] = $color;
		if($speed !== 1) $c['coverSpeed'] = $speed;
		if($h !== 'center') $c['horizontal'] = $h;
		if($v !== 'middle') $c['vertical'] = $v;
		if ($this->modal !== '') $c['trigger'] = $this->modal;
		$ff = true;
		$html .= $this->JTA . RS_T5.'modal: {'."\n";
		foreach($c as $k => $v){
			$html .= ($ff === true) ? '' : ','."\n";
			$html .= $this->JTA . RS_T6.$k.':';
			$html .= $this->write_js_var($v);
			$ff = false;
		}
		$html .= "\n".$this->JTA . RS_T5.'},'."\n";
		
		return $html;
	}

	/**
	 * get the carousel attibutes
	 **/
	public function js_get_carousel(){
		$html	= '';
		$s		= $this->slider; //shorten
		$s_type = $s->get_param('type', 'standard');
		
		if($s_type !== 'carousel') return $html;
		
		$c = array();
		
		$ease = $s->get_param(array('carousel', 'ease'), 'power3.inOut');
		$this->easings[$ease] = $ease;
		$speed = $s->get_param(array('carousel', 'speed'), 800);
		$sal = $s->get_param(array('carousel', 'showAllLayers'), false);
		$ha = $s->get_param(array('carousel', 'horizontal'), 'center');
		$va = $s->get_param(array('carousel', 'vertical'), 'center');
		$in = $s->get_param(array('carousel', 'infinity'), false);
		$jus = $s->get_param(array('carousel', 'justify'), false);
		$socl = $s->get_param(array('carousel', 'stopOnClick'), true);
		$jusmw = $s->get_param(array('carousel', 'justifyMaxWidth'), false);
		
		$snap = $s->get_param(array('carousel', 'snap'), true);
		$sp = $s->get_param(array('carousel', 'space'), 0);
		$mvi = $s->get_param(array('carousel', 'maxItems'), 3);
		$st = $s->get_param(array('carousel', 'stretch'), false);
		$fo = $s->get_param(array('carousel', 'fadeOut'), true);
		$cr = $s->get_param(array('carousel', 'rotation'), false);
		$cs = $s->get_param(array('carousel', 'scale'), false);
		$br = $s->get_param(array('carousel', 'borderRadius'), 0);
		$pt = $s->get_param(array('carousel', 'paddingTop'), 0);
		$pb = $s->get_param(array('carousel', 'paddingBottom'), 0);
		$csd = $s->get_param(array('carousel', 'scaleDown'), 50);
		$csd = ($csd > 100) ? 100 : $csd;
		
		if($ease !== 'power3.inOut') $c['easing'] = $ease;
		if(!in_array($speed, array(800, '800', '800ms'), true)) $c['speed'] = $speed;
		if(!in_array($sal, array('false', false), true)) $c['showLayersAllTime'] = $sal;
		if($ha !== 'center') $c['horizontal_align'] = $ha;
		if($va !== 'center') $c['vertical_align'] = $va;
		if($in !== false) $c['infinity'] = $in;
		if($jus !== false) $c['justify'] = $jus;
		if($jusmw !== false) $c['justifyMaxWidth'] = $jusmw;
		if($snap !== true) $c['snap'] = $snap;
		if($socl !== true) $c['stopOnClick'] = $socl;
		if(!in_array($sp, array(0, '0', '0px'), true)) $c['space'] = $sp;
		if(!in_array($mvi, array(3, '3'), true)) $c['maxVisibleItems'] = $mvi;
		if($st !== false) $c['stretch'] = $st;
		if($fo !== true) $c['fadeout'] = $fo;
		if($cr === true){
			$mr = $s->get_param(array('carousel', 'maxRotation'), 0);
			$vr = $s->get_param(array('carousel', 'varyRotate'), false);
			
			if(!in_array($mr, array(0, '0', '0deg'), true)) $c['maxRotation'] = $mr;
			if($vr === true) $c['vary_rotation'] = $vr;
		}
		
		if($cs === true){
			$vs = $s->get_param(array('carousel', 'varyScale'), false);
			$os = $s->get_param(array('carousel', 'offsetScale'), false);
			$c['minScale'] = $csd;
			if($os === true) $c['offsetScale'] = $os;
			if($vs === true) $c['vary_scale'] = $vs;
		}
		if($fo === true){
			$vf = $s->get_param(array('carousel', 'varyFade'), false);
			if($vf !== false) $c['vary_fade'] = $vf;
			$mo = $s->get_param(array('carousel', 'maxOpacity'), 100);
			$mo = ($mo > 100) ? 100 : $mo;
			if(!in_array($mo, array(100, '100'), true)) $c['maxOpacity'] = $mo;
		}
		if(!in_array($br, array(0, '0', '0px'), true)) $c['border_radius'] = $br;
		if(!in_array($pt, array(0, '0', '0px'), true)) $c['padding_top'] = $pt;
		if(!in_array($pb, array(0, '0', '0px'), true)) $c['padding_bottom'] = $pb;
		
		if(!empty($c)){
			$ff = true;
			$html .= $this->JTA . RS_T5.'carousel: {'."\n";
			foreach($c as $k => $v){
				$html .= ($ff === true) ? '' : ','."\n";
				$html .= $this->JTA . RS_T6.$k.':';
				$html .= $this->write_js_var($v);
				$ff = false;
			}
			$html .= "\n".$this->JTA . RS_T5.'},'."\n";
		}
		
		return $html;
	}

	/**
	 * get all the basic js keys we need
	 **/
	public function js_get_root(){
		$html	= '';
		$s		= $this->slider; //shorten
		$js_loc_r = explode('://', RS_PLUGIN_URL);
		$global = $this->get_global_settings();
		$l_type	= $s->get_param('layouttype');
		$s_type = $s->get_param('type', 'standard');
		$DPR = $s->get_param(array('general', 'DPR'), 'x2');
		$csizes = $this->get_responsive_size($this);
		
		$fw		= ($l_type == 'fullwidth') ? 'on' : 'off';
		$fw		= ($l_type == 'fullscreen') ? 'off' : $fw;
		$fs		= ($l_type == 'fullscreen') ? 'on' : 'off';
		$layout	= 'auto';
		if($fs == 'on'){
			$layout = 'fullscreen';
		}elseif($fw == 'on'){
			$layout = 'fullwidth';
		}
		$hsal = str_replace('px', '', $s->get_param(array('visibility', 'hideSliderUnderLimit'), 0));
		$hlal = str_replace('px', '', $s->get_param(array('visibility', 'hideSelectedLayersUnderLimit'), 0));
		$halul= str_replace('px', '', $s->get_param(array('visibility', 'hideAllLayersUnderLimit'), 0));
		if(!empty($hsal)) $hsal++;
		if(!empty($hlal)) $hlal++;
		if(!empty($halul)) $halul++;
		$start_delay = $s->get_param(array('general', 'slideshow', 'initDelay'), '0');
		$start_delay = apply_filters('revslider_add_js_delay', $start_delay);
		$spinner = $s->get_param(array('layout', 'spinner', 'type'), '0');
		$spinner = (in_array($spinner, array(-1, '-1'), true)) ? 'off' : $spinner;
		
		$keys = array(
			'revapi' => array(
				'v' => $this->get_revapi(),
                'd' => 'none'
			),
			'sliderType' => array(
				'v' => $s_type,
				'd' => 'standard'
			),
			'DPR' => array(
				'v' => $DPR,
				'd' => 'x2'
			),
			/*'jsFileLocation' => array(
				'v' => '//'.$js_loc_r[1] .'public/assets/js/',
				'd' => ''
			),*/
			'sliderLayout' => array(
				'v' => $layout,
				'd' => 'auto'
			),
			/*'dottedOverlay' => array( //moved to multidimensional outside of this in 6.4.0
				'v' => $s->get_param(array('layout', 'bg', 'dottedOverlay'), 'none'),
				'd' => 'none'
			),*/
			'duration' => array(
				'v' => $s->get_param(array('def', 'delay'), '9000'),
				'd' => array(9000, '9000', '9000ms')
			),
			'visibilityLevels' => array(
				'v' => ($this->get_val($csizes, 'level', '') !== '') ? $this->get_val($csizes, 'level') : $this->get_val($csizes, 'visibilitylevel'),
				'd' => ''
			),
			'gridwidth' => array(
				'v' => $this->get_val($csizes, 'width'),
				'd' => ''
			),
			'gridheight' => array(
				'v' => $this->get_val($csizes, 'height'),
				'd' => ''
			),
			'minHeight' => array(
				'v' => ($l_type !== 'fullscreen') ? $s->get_param(array('size', 'minHeight'), 0) : $s->get_param(array('size', 'minHeightFullScreen'), 0),
				'd' => array(0, '0', '0px')
			),
			'autoHeight' => array(
				'v' => $s->get_param(array('size', 'respectAspectRatio'), false),
				'd' => false
			),
			'enableUpscaling' => array(
				'v' => $s->get_param(array('size', 'enableUpscaling'), false),
				'd' => false
			),
			'hideSliderAtLimit' => array(
				'v' => $hsal,
				'd' => array(0, '0', '0px')
			),
			'hideLayerAtLimit' => array(
				'v' => $hlal,
				'd' => array(0, '0', '0px')
			),
			'hideAllLayerAtLimit' => array(
				'v' => $halul,
				'd' => array(0, '0', '0px')
			),
			'startDelay' => array(
				'v' => $start_delay,
				'd' => array(0, '0')
			),
			'lazyType' => array(
				'v' => $s->get_param(array('general', 'lazyLoad'), 'none'),
				'd' => 'none'
			),
			'spinner' => array(
				'v' => 'spinner'.$spinner,
				'd' => 'spinneroff'
			),			
			'fixedOnTop' => array(
				'v' => $s->get_param(array('layout', 'position', 'fixedOnTop'), false),
				'd' => false
			),
			'forceOverflow' => array(
				'v' => $s->get_param(array('size', 'forceOverflow'), false),
				'd' => false
			),
			'overflowHidden' => array(
				'v' => $s->get_param(array('size', 'overflowHidden'), false),
				'd' => false
			)
			,'useFullScreenHeight' => array(
				'v' => $s->get_param(array('size', 'useFullScreenHeight'), true),
				'd' => true
			),
			'maxHeight' => array(
				'v' => $s->get_param(array('size', 'maxHeight'), 'none'),
				'd' => array('', 0, '0', 'none')
			),
			'perspective' => array(
				'v' => $s->get_param(array('general', 'perspective'), '600px'),
				'd' => '600px'
			),
			'perspectiveType' => array(
				'v' => $s->get_param(array('general', 'perspectiveType'), 'local'),
				'd' => array('none')
			),
			'keepBPHeight' => array(
				'v' => $s->get_param(array('size', 'keepBPHeight'), false),
				'd' => false
			),
			'observeWrap' => array(
				'v' => $s->get_param(array('general', 'observeWrap'), false),
				'd' => false
			)
		);
				
		/**
		 * Shortcode Based Layout
		 */		 
		if($this->sc_layout !== ''){
			$keys['sliderLayout']['v'] = $this->sc_layout;
		}

		if($keys['sliderType']['v']!=="carousel" || $keys['sliderLayout']['v']!=='fullscreen') {
			unset($keys['useFullScreenHeight']);
		}

		if($keys['minHeight']['v']==="") {
			unset($keys['minHeight']);
		}

		/**
		 * Shortcode based Block Spacing
		 */
		if($this->offset !== ''){
			$keys['blockSpacing'] = array(
				'v' => $this->offset,
				'd' => ''
			);
		}
		
		/**
		 * new spinners
		 **/
		if($spinner !== 'off' && intval($spinner) > 5){
			$keys['spinnerclr'] = array(
				'v' => $s->get_param(array('layout', 'spinner', 'color'), '#ffffff'),
				'd' => '#ffffff'
			);
		}
		
		$imgcrossOrigin = $this->get_val($global, 'imgcrossOrigin', 'unset');
		if(!in_array($imgcrossOrigin, array('', 'unset'))){
			$keys['imgCrossOrigin'] = array('v' => $imgcrossOrigin, 'd' => 'unset');
		}
		
		$onedpronmobile = $this->get_val($global, 'onedpronmobile', false);
		if(in_array($onedpronmobile, array(true, 'true'), true)){
			$keys['onedpronmobile'] = array('v' => true, 'd' => false);
		}
		
		$lazyloaddata = $this->get_val($global, 'lazyloaddata', '');
		if($lazyloaddata !== ''){
			$keys['lazyloaddata'] = array('v' => $lazyloaddata, 'd' => '');
		}
		
		$lazyloadbg = $this->get_val($global, 'lazyonbg', false);
		if($lazyloadbg !== false && $lazyloadbg !== 'false'){
			$keys['lazyOnBg'] = array('v' => $lazyloadbg, 'd' => false);
		}

		$cache_size = $this->slider->get_param(array('size', 'editorCache'), false);
		if($cache_size !== false){
			$keys['editorheight'] = array('v' => implode(',', (array)$cache_size), 'd' => '');
		}
		
		if($this->get_val($csizes, 'level', '') !== ''){
			$keys['responsiveLevels'] = array('v' => $csizes['level'], 'd' => '');
		}
		if($l_type == 'fullscreen'){
			$keys['disableForceFullWidth'] = array('v' => $s->get_param(array('size', 'disableForceFullWidth'), false), 'd' => false);
			$keys['ignoreHeightChange'] = array('v' => $s->get_param(array('size', 'ignoreHeightChanges'), true), 'd' => true);
			$keys['gridEQModule'] = array('v' => $s->get_param(array('size', 'gridEQModule'), false), 'd' => false);
			$keys['fullScreenOffsetContainer'] = array('v' => $s->get_param(array('size', 'fullScreenOffsetContainer'), ''), 'd' => '');
			$keys['fullScreenOffset'] = array('v' => $s->get_param(array('size', 'fullScreenOffset'), ''), 'd' => '');
		}

		if($s_type !== 'hero'){
			$stopSlider	 = $s->get_param(array('general', 'slideshow', 'stopSlider'), false);
			$loopSingle	 = $s->get_param(array('general', 'slideshow', 'loopSingle'), true);
			$stopAtSlide = $s->get_param(array('general', 'slideshow', 'stopAtSlide'), -1);
			$stopAfterLoops = $s->get_param(array('general', 'slideshow', 'stopAfterLoops'), 0);
			$slideShow	 = $s->get_param(array('general', 'slideshow', 'slideShow'), true);
			
			if(!$this->get_is_single_slide()){
				if($slideShow === false){
					$stopAtSlide = 1;
					$stopAfterLoops = 0;
				}
				
				if($slideShow === true && $stopSlider === false){
					$stopAtSlide = -1;
					$stopAfterLoops = -1;
				}

			}else{
				if($loopSingle === true){
					$stopAtSlide = -1;
					$stopAfterLoops = -1;
				}
			}
			
			$keys['stopAtSlide'] = array('v' => $stopAtSlide, 'd' => array(-1, '-1'));
			$keys['stopAfterLoops'] = array('v' => $stopAfterLoops, 'd' => array(-1, '-1'));
			$keys['shuffle'] = array('v' => $s->get_param(array('general', 'slideshow', 'shuffle'), false), 'd' => false);
		}
		
		$parallax = $s->get_param(array('parallax', 'set'), false);
		$parallax_type = $s->get_param(array('parallax', 'mouse', 'type'), 'mouse');
		if($s->get_param(array('parallax', 'setDDD'), false) == true){
			$parallax_type = '3D';
		}
		if($parallax != true || ($parallax == true && $parallax_type != '3D')){
			$keys['shadow'] = array('v' => $s->get_param(array('layout', 'bg', 'shadow'), 0), 'd' => array(0, '0'));
		}
		
		if($s_type !== 'hero'){
			$keys['stopLoop'] = array('v' => $s->get_param(array('general', 'slideshow', 'stopSlider'), false), 'd' => false);
			
			if($s->get_param(array('general', 'firstSlide', 'alternativeFirstSlideSet'), false) === true) 				
				$keys['startWithSlide'] = array('v' => $s->get_param(array('general', 'firstSlide', 'alternativeFirstSlide'), 1), 'd' => '9999');
			
			
		}
		$keys['waitForInit'] = array('v' => $s->get_param(array('general', 'slideshow', 'waitForInit'), false), 'd' => false);
		
		if($this->frontend_action){
			$keys['ajaxUrl'] = array('v' => admin_url('admin-ajax.php'), 'd' => '');
			//$keys['ajaxNonce'] = ($this->caching) ? array('v' => '##NONCE##', 'd' => '') : array('v' => wp_create_nonce('RevSlider_Front'), 'd' => '');
		}
		
		if(!empty($keys)){
			foreach($keys as $k => $v){
				if(is_array($v['d'])){
					if(in_array($v['v'], $v['d'], true)) continue;
				}else{
					if($v['v'] === $v['d']) continue;
				}
				$html .= $this->JTA . RS_T5.$k.':';
				$html .= $this->write_js_var($v['v']);
				$html .= ','."\n";
			}
		}
		
		return $html;
	}

	/**
	 * Generate the Navigation CSS of the chosen Navigations
	 **/
	public function get_navigation_css(){
		$css = '';
		$s		= $this->slider; //shorten
		$lot	= $s->get_param('type', 'standard');
		$navs	= array('arrows', 'bullets', 'tabs', 'thumbs');
		$_all_navs = array_merge($navs, array('swipe', 'keyboard', 'mouse'));
		$found	= false;
		
		foreach($_all_navs as $nav){
			if($s->get_param(array('nav', $nav, 'set'), false) === true){
				$found = true;
				break;
			}
		}
		
		if($lot === 'hero' || $found === false) return $css;
		
		$rs_nav = new RevSliderNavigation();
		$all_navs = $rs_nav->get_all_navigations();
		
		foreach($navs as $n){
			if($s->get_param(array('nav', $n, 'set'), true) === true){
				$nar = $s->get_param(array('nav', $n, 'style'), 'round');
				if(!empty($all_navs)){
					foreach($all_navs as $cur_nav){
						if($cur_nav['id'] == $nar){
							$css .= (isset($cur_nav['css'])) ? $rs_nav->add_placeholder_modifications($cur_nav, $s, $this)."\n" : '';
							break;
						}
					}
				}
			}
		}
		
		$html = '';
		if(trim($css) !== ''){
			$html = $this->get_css_javascript($css);
		}

		return $html;
	}


	/**
	 * Generate the Navigation JavaScript
	 **/
	public function js_get_navigation(){
		$h		= array();
		$s		= $this->slider; //shorten
		$lot	= $s->get_param('type', 'standard');
		$navs	= array('arrows', 'bullets', 'tabs', 'thumbs');
		$_all_navs = array_merge($navs, array('swipe', 'keyboard', 'mouse'));
		$found	= false;
		
		foreach($_all_navs as $nav){
			if($s->get_param(array('nav', $nav, 'set'), false) === true){
				$found = true;
				break;
			}
		}
		$msn = $s->get_param(array('nav', 'mouse', 'set'), false);
		$tod = $s->get_param(array('nav', 'swipe', 'setOnDesktop'), false); 

		if($msn === 'on' || $msn === 'carousel' || $tod === true) $found = true;

		if($lot === 'hero' || $found === false){
			//we still need onHoverStop
			$ohs = $s->get_param(array('general', 'slideshow', 'stopOnHover'), true);
			if($ohs === false)
				$h['onHoverStop'] = false;
		}else{
			$rs_nav = new RevSliderNavigation();
			$all_navs = $rs_nav->get_all_navigations();
			
			//KEYBOARD
			$kbn = $s->get_param(array('nav', 'keyboard', 'set'), false);
			$kbd = $s->get_param(array('nav', 'keyboard', 'direction'), 'horizontal');
			
			$msr = $s->get_param(array('nav', 'mouse', 'reverse'), false);
			$msst = $s->get_param(array('nav', 'mouse', 'target'), 'window');
			$mstr = $s->get_param(array('nav', 'mouse', 'threshold'), 50);
			$mswu = $s->get_param(array('nav', 'mouse', 'viewport'), 50);
			$mscd = $s->get_param(array('nav', 'mouse', 'calldelay'), '1000ms');
			$ohs = $s->get_param(array('general', 'slideshow', 'stopOnHover'), true);
			
			if($kbn === true)		 $h['keyboardNavigation'] = true;
			if($kbd !== 'horizontal')$h['keyboard_direction'] = $kbd;
			if($msn !== 'off')		 $h['mouseScrollNavigation'] = $msn;
			if($msr !== 'default')	 $h['mouseScrollReverse'] = $msr;
			if($msst !== 'window')	 $h['target'] = $msst;
			if($mstr !== 50)		 $h['threshold'] = $mstr;
			if($mswu !== 50)		 $h['wheelViewPort'] = $mswu;
			if($mscd !== '1000ms')		 $h['wheelCallDelay'] = $mscd;
			
			if($ohs === false)		 $h['onHoverStop'] = false;
			
			//TOUCH
			$ctom = $s->get_param(array('nav', 'swipe', 'setMobileCarousel'), true); 
			$ctod = $s->get_param(array('nav', 'swipe', 'setDesktopCarousel'), true); 
			$te =  ($tod === true) ? true : $s->get_param(array('nav', 'swipe', 'set'), false);
			
			if($te === true || ($lot === 'carousel' && ($ctod===false || $ctom===false))){
				$sth = intval($s->get_param(array('nav', 'swipe', 'velocity'), 75));
				$smt = intval($s->get_param(array('nav', 'swipe', 'minTouch'), '1'));
				$sd	 = $s->get_param(array('nav', 'swipe', 'direction'), 'horizontal');
				$dbv = $s->get_param(array('nav', 'swipe', 'blockDragVertical'), false);
				
				$h['touch'] = array();
				$h['touch']['touchenabled'] = $te;
				if($tod === true)		 $h['touch']['touchOnDesktop'] = true;
				if($sth !== 75)			 $h['touch']['swipe_threshold'] = $sth;
				if($smt !== 1)			 $h['touch']['swipe_min_touches'] = $smt;
				if($sd !== 'horizontal') $h['touch']['swipe_direction'] = $sd;
				if($dbv !== false)		 $h['touch']['drag_block_vertical'] = $dbv;
				if($lot === 'carousel' && $ctod===false) $h['touch']['desktopCarousel'] = false;
				if($lot === 'carousel' && $ctom===false) $h['touch']['mobileCarousel'] = false;
			}
			
			//NAVIGATION
			$defaults = array(
				'arrows' => array(
					'tmp' => ''
				),
				'bullets' => array(
					'tmp' => '<span class="tp-bullet-image"></span><span class="tp-bullet-title"></span>',
					'space' => 5
				),
				'thumbs' => array(
					'tmp' => '<span class="tp-thumb-image"></span><span class="tp-thumb-title"></span>',
					'space' => 2,
					'wrapper_padding' => 2
				),
				'tabs' => array(
					'tmp' => '<span class="tp-tab-image"></span>',
					'space' => 0,
					'wrapper_padding' => 10
				)
			);
			
			foreach($navs as $n){
				$as = $s->get_param(array('nav', $n, 'set'), false);
				if($as === true){
					$h[$n] = array();
					$h[$n]['enable'] = $as;
					
					$nar = $s->get_param(array('nav', $n, 'style'), 'round');
					$tmp = '';
					if(!empty($all_navs)){
						foreach($all_navs as $cur_nav){
							if($cur_nav['id'] == $nar){
								$nar = $cur_nav['handle'];
								$tmp = $this->get_val($cur_nav, 'markup', $tmp);
								break;
							}
						}
					}
					$tmp = preg_replace("/\r|\n/", "", $tmp);
					$tmp = str_replace('"', '\\"', $tmp);
					$hom = $s->get_param(array('nav', $n, 'hideUnder'), false);
					$ho = $s->get_param(array('nav', $n, 'hideOver'), false);
					$ao = $s->get_param(array('nav', $n, 'alwaysOn'), true);
					$anim = $s->get_param(array('nav', $n, 'anim'), 'fade');
					$aspeed = $s->get_param(array('nav', $n, 'animSpeed'), '1000ms');
					$adelay = $s->get_param(array('nav', $n, 'animDelay'), '1000ms');
					$rtl = $s->get_param(array('nav', $n, 'rtl'), false);
					
					if($tmp !== $defaults[$n]['tmp'])	$h[$n]['tmp'] = $tmp;
					if($nar !== '')						$h[$n]['style'] = $nar;
					if($hom === true)					$h[$n]['hide_onmobile'] = $hom;
					if($hom === true){
						$hu = $s->get_param(array('nav', $n, 'hideUnderLimit'), 0);
						if(!in_array($hu, array(0, '0', '0px'), true)) $h[$n]['hide_under'] = $hu;
					}
					if($ho === true){
						$hol = $s->get_param(array('nav', $n, 'hideOverLimit'), 9999);
						if(!in_array($hol, array(9999, '9999', '9999px'), true)) $h[$n]['hide_over'] = $hol;
					}
					if($ao === false) $h[$n]['hide_onleave'] = true;
					if($ao === false){
						$hd = $s->get_param(array('nav', $n, 'hideDelay'), 200);
						$hdm = $s->get_param(array('nav', $n, 'hideDelayMobile'), 1200);
						
						if(!in_array($hd, array(200, '200', '200px'), true)) $h[$n]['hide_delay'] = $hd;
						if(!in_array($hdm, array(1200, '1200', '1200px'), true)) $h[$n]['hide_delay_mobile'] = $hdm;
					}
					if($rtl === true) $h[$n]['rtl'] = true;

					if($anim !=='fade') $h[$n]['anim'] = $anim;
					if($aspeed !=='1000ms') $h[$n]['animSpeed'] = $aspeed;
					if($adelay !=='1000ms') $h[$n]['animDelay'] = $adelay;
					
					//left only at arrows
					if($n === 'arrows'){
						$alc = (in_array($s->get_param(array('nav', $n, 'left', 'align'), 'slider'), array('layergrid', 'grid'), true)) ? 'layergrid' : 'slider';
						$alha = $s->get_param(array('nav', $n, 'left', 'horizontal'), 'left');
						$alva = $s->get_param(array('nav', $n, 'left', 'vertical'), 'center');
						$alho = $s->get_param(array('nav', $n, 'left', 'offsetX'), 20);
						$alvo = $s->get_param(array('nav', $n, 'left', 'offsetY'), 0);
						$anil = $s->get_param(array('nav', $n, 'left',  'anim'), 'fade');
						$arc = (in_array($s->get_param(array('nav', $n, 'right', 'align'), 'slider'), array('layergrid', 'grid'), true)) ? 'layergrid' : 'slider';
						$arha = $s->get_param(array('nav', $n, 'right', 'horizontal'), 'right');
						$arva = $s->get_param(array('nav', $n, 'right', 'vertical'), 'center');
						$arho = $s->get_param(array('nav', $n, 'right', 'offsetX'), 20);
						$arvo = $s->get_param(array('nav', $n, 'right', 'offsetY'), 0);
						$anir = $s->get_param(array('nav', $n, 'right',  'anim'), 'fade');

						$h[$n]['left'] = array();//left only at arrows
						$h[$n]['right'] = array(); //right only at arrows
						if($anil !=='fade') $h[$n]['left']['anim'] = $anil; 
						if($anir !=='fade') $h[$n]['right']['anim'] = $anir; 
						if($alc !== 'slider')	$h[$n]['left']['container'] = $alc;
						if($alha !== 'left')	$h[$n]['left']['h_align'] = $alha;
						if($alva !== 'center')	$h[$n]['left']['v_align'] = $alva;
						if(!in_array($alho, array(20, '20', '20px'), true))	$h[$n]['left']['h_offset'] = intval(str_replace('px', '', $alho));
						if(!in_array($alvo, array(0, '0', '0px'), true))	$h[$n]['left']['v_offset'] = intval(str_replace('px', '', $alvo));
						if($arc !== 'slider')	$h[$n]['right']['container'] = $arc;
						if($arha !== 'right')	$h[$n]['right']['h_align'] = $arha;
						if($arva !== 'center')	$h[$n]['right']['v_align'] = $arva;
						if(!in_array($arho, array(20, '20', '20px'), true))	$h[$n]['right']['h_offset'] = intval(str_replace('px', '', $arho));
						if(!in_array($arvo, array(0, '0', '0px'), true))	$h[$n]['right']['v_offset'] = intval(str_replace('px', '', $arvo));
					}else{
						//these are not in left/right, but directly added
						$arha = $s->get_param(array('nav', $n, 'horizontal'), 'center');
						$arva = $s->get_param(array('nav', $n, 'vertical'), 'bottom');
						$arho = $s->get_param(array('nav', $n, 'offsetX'), 20);
						$arvo = $s->get_param(array('nav', $n, 'offsetY'), 0);
						$dir = $s->get_param(array('nav', $n, 'direction'), 'horizontal');
						$space = $s->get_param(array('nav', $n, 'space'), $defaults[$n]['space']);
						
						if($arha !== 'center') $h[$n]['h_align'] = $arha;
						if($arva !== 'bottom') $h[$n]['v_align'] = $arva;
						if(!in_array($arho, array(0, '0', '0px'), true)) $h[$n]['h_offset'] = intval(str_replace('px', '', $arho));
						if(!in_array($arvo, array(20, '20', '20px'), true)) $h[$n]['v_offset'] = intval(str_replace('px', '', $arvo));
						if($dir !== 'horizontal') $h[$n]['direction'] = $dir; //these exist not in arrows at all
						if(!in_array($space, array($defaults[$n]['space'], (string)$defaults[$n]['space'], $defaults[$n]['space'].'px'), true))
							$h[$n]['space'] = $space;
						
						//only exist in thumbs and tabs
						if(in_array($n, array('thumbs', 'tabs'), true)){
							$width = $s->get_param(array('nav', $n, 'width'), 100);
							$height = $s->get_param(array('nav', $n, 'height'), 50);
							$mw = $s->get_param(array('nav', $n, 'widthMin'), 100);
							$wp = $s->get_param(array('nav', $n, 'padding'), $defaults[$n]['wrapper_padding']);
							$wc = $s->get_param(array('nav', $n, 'wrapperColor'), 'transparent');
							$va = $s->get_param(array('nav', $n, 'amount'), 5);
							$span = $s->get_param(array('nav', $n, 'spanWrapper'), false);
							$pos = $s->get_param(array('nav', $n, 'innerOuter'), 'inner');
							$mhoff = $s->get_param(array('nav', $n, 'mhoffset'), 0);
							$mvoff = $s->get_param(array('nav', $n, 'mvoffset'), 0);
							
							if(!in_array($width, array(100, '100', '100px'), true)) $h[$n]['width'] = $width;
							if(!in_array($height, array(50, '50', '50px'), true)) $h[$n]['height'] = $height;
							if(!in_array($mw, array(100, '100', '100px'), true)) $h[$n]['min_width'] = $mw;
							if(!in_array($wp, array($defaults[$n]['wrapper_padding'], (string)$defaults[$n]['wrapper_padding'], $defaults[$n]['wrapper_padding'].'px'), true))
								$h[$n]['wrapper_padding'] = $wp;
							if(strtolower($wc) !== '#transparent') $h[$n]['wrapper_color'] = $wc;
							if(!in_array($va, array(5, '5'), true)) $h[$n]['visibleAmount'] = $va;
							if($span === true) $h[$n]['span'] = $span;
							if($mhoff!==0) $h[$n]['mhoff'] = $mhoff;
							if($mvoff!==0) $h[$n]['mvoff'] = $mvoff;
							if($pos !== 'inner') $h[$n]['position'] = $pos;
							if($pos === 'inner'){
								$arc = (in_array($s->get_param(array('nav', $n, 'align'), 'slider'), array('layergrid', 'grid'), true)) ? 'layergrid' : 'slider';
								if($arc !== 'slider') $h[$n]['container'] = $arc;
							}
						}else{ //only write in bullets like this
							$arc = (in_array($s->get_param(array('nav', $n, 'align'), 'slider'), array('layergrid', 'grid'), true)) ? 'layergrid' : 'slider';
							if($arc !== 'slider') $h[$n]['container'] = $arc;
						}
					}
				}
			}
		}
		
		$html = '';
		if(!empty($h)){
			$html .= $this->JTA . RS_T5.'navigation: {'."\n";
			$ff = true;
			foreach($h as $key => $value){
				$html .= ($ff === true) ? '' : ','."\n";
				if($key == 'thumbs') $key = 'thumbnails'; //change thumb to thumbnail here
				$html .= $this->JTA . RS_T6.$key.':';
				if(is_array($value)){
					$html .= ' {'."\n";
					if(!empty($value)){
						$f = true;
						foreach($value as $k => $v){
							$html .= ($f === true) ? '' : ','."\n";
							$html .= $this->JTA . RS_T7.$k.':';
							
							if(is_array($v)){
								$html .= ' {'."\n";
								if(!empty($v)){
									$fff = true;
									foreach($v as $kk => $vv){
										$html .= ($fff === true) ? '' : ','."\n";
										$html .= $this->JTA . RS_T8.$kk.':';
										$html .= $this->write_js_var($vv);
										$fff = false;
									}
								}
								$html .= "\n".$this->JTA . RS_T7.'}';
							}else{
								$html .= $this->write_js_var($v);
							}
							$f = false;
						}
					}
					$html .= "\n".$this->JTA . RS_T6.'}';
				}else{
					$html .= $this->write_js_var($value);
				}
				$ff = false;
			}
			$html .= "\n".$this->JTA . RS_T5.'},'."\n";
		}
		
		return $html;
	}
	
	
	/**
	 * Adds the Slider content and the additional settings to the transients
	 * @since: 6.4.6
	 **/
	public function add_slider_transient($transient, $content){
		$sid = $this->slider->get_id();
		
		$cache = RevSliderGlobals::instance()->get('RevSliderCache');
		if($this->ajax_loaded !== true && !$this->get_markup_export()){
			if($this->caching){
				global $revslider_fonts;
				//if doing transient, remove the changes here $revslider_fonts again!
				$temp = $revslider_fonts;
				$cache->add_addition('action', 'wp_footer', $this->print_clean_font_import());
				$revslider_fonts = $temp;
			}
		}
		
		$cache->set_full_transient($transient, $sid, $content);
	}
	
	
	/**
	 * Check if a layer frame is triggered by any other layer
	 * @since: 6.0
	 **/
	public function layer_frame_triggered($uid, $frame){
		$ret = false;
		$uid = (string)$uid;
		$uid = ($this->is_static) ? 'static-'.$uid : $uid;
		
		if($this->is_static){ //we have to push all layers of all slides
			$layers = array();
			$slides = $this->get_current_slides();
			$static_slide = $this->get_static_slide();
			foreach($slides as $slide){
				$slide_layers = $slide->get_layers();
				if(!empty($slide_layers)){
					foreach($slide_layers as $sl){
						$layers[] = $sl;
					}
				}
			}
			if(!empty($static_slide)){
				$slide_layers = $static_slide->get_layers();
				if(!empty($slide_layers)){
					foreach($slide_layers as $sl){
						$this->set_val($sl, 'static_layer', true);
						$layers[] = $sl;
					}
				}
			}
		}else{
			$layers = $this->get_layers();
		}
		if(empty($layers)) return $ret;
		
		foreach($layers as $layer){
			$actions = $this->get_val($layer, array('actions', 'action'), array());
			if(empty($actions)) continue;
			
			$static_layer = $this->get_val($layer, 'static_layer', false);
			foreach($actions as $action){
				$layer_target = (string)$this->get_val($action, 'layer_target', '');
				$layer_target = ($static_layer === true) ? 'static-'.$layer_target : $layer_target;
				
				if($layer_target !== $uid) continue;
				
				$act = $this->get_val($action, 'action', '');
				if($act === 'next_frame' || $act === 'prev_frame'){
					$ret = true; 
				}elseif($act === 'start_frame' && $frame == $this->get_val($action, 'gotoframe', '')){
					$ret = true; 
				}elseif($act === 'start_in' && $frame === 'frame_1'){
					$ret = true; 
				}elseif($act === 'start_out' && $frame === 'frame_999'){
					$ret = true;
				}elseif($act === 'toggle_layer' && in_array($frame, array('frame_1', 'frame_999'))){
					$ret = true;				
				}elseif($act === 'toggle_frames' && ($frame == $this->get_val($action, 'gotoframeM', '') || $frame == $this->get_val($action, 'gotoframeN', ''))){
					$ret = true;
				}
				if($ret === true) break;
			}
		}
		
		return $ret;
	}
	
	
	/**
	 * Check if shortcodes exists in the content
	 * @since: 5.0
	 */  
	public static function check_for_shortcodes($mid_content){
		if($mid_content !== null){ 
			if(has_shortcode($mid_content, 'gallery')){
				preg_match('/\[gallery.*ids=.(.*).\]/', $mid_content, $img_ids);
				
				if(isset($img_ids[1])){
					if($img_ids[1] !== '') return explode(',', $img_ids[1]);
				}
			}
		}
		return false;
	}
	
	
	/**
	 * return the responsive sizes
	 * @since: 5.0
	 **/
	public function get_responsive_size($slider){
		$global = $this->get_global_settings();
		
		$csn = $slider->slider->get_param(array('size', 'custom', 'n'), false);
		$cst = $slider->slider->get_param(array('size', 'custom', 't'), false);
		$csi = $slider->slider->get_param(array('size', 'custom', 'm'), false);
		
		$w = $slider->slider->get_param(array('size', 'width', 'd'), 1240);
		$h = $slider->slider->get_param(array('size', 'height', 'd'), 1240);
		$r = $this->get_val($global, array('size', 'desktop'), 1240);
		$c = $this->slider->get_param(array('size', 'editorCache', 'd'), false);
		
		if($csn == true || $cst == true || $csi == true){
			$d = $w;
			$w .= ',';
			$w .= ($csn == true) ? $slider->slider->get_param(array('size', 'width', 'n'), 1024) : $d;
			$d = ($csn == true) ? $slider->slider->get_param(array('size', 'width', 'n'), 1024) : $d;
			$w .= ',';
			$w .= ($cst == true) ? $slider->slider->get_param(array('size', 'width', 't'), 778) : $d;
			$d = ($cst == true) ? $slider->slider->get_param(array('size', 'width', 't'), 778) : $d;
			$w .= ',';
			$w .= ($csi == true) ? $slider->slider->get_param(array('size', 'width', 'm'), 480) : $d;

			$d = $h;
			$h .= ',';
			$h .= ($csn == true) ? $slider->slider->get_param(array('size', 'height', 'n'), 1024) : $d;
			$d = ($csn == true) ? $slider->slider->get_param(array('size', 'height', 'n'), 1024) : $d;
			$h .= ',';
			$h .= ($cst == true) ? $slider->slider->get_param(array('size', 'height', 't'), 778) : $d;
			$d = ($cst == true) ? $slider->slider->get_param(array('size', 'height', 't'), 778) : $d;
			$h .= ',';
			$h .= ($csi == true) ? $slider->slider->get_param(array('size', 'height', 'm'), 480) : $d;

			$d = $r;
			$r .= ',';
			$r .= ($csn == true) ? $this->get_val($global, array('size', 'notebook'), 1024) : $d;
			$d = ($csn == true) ? $this->get_val($global, array('size', 'notebook'), 1024) : $d;
			$r.= ',';
			$r .= ($cst == true) ? $this->get_val($global, array('size', 'tablet'), 778) : $d;
			$d = ($cst == true) ? $this->get_val($global, array('size', 'tablet'), 778) : $d;
			$r.= ',';
			$r .= ($csi == true) ? $this->get_val($global, array('size', 'mobile'), 480) : $d;

			if($c !== false){
				$d = $c;
				$c .= ',';
				$c .= ($csn == true) ? $slider->slider->get_param(array('size', 'editorCache', 'n'), 1024) : $d;
				$d = ($csn == true) ? $slider->slider->get_param(array('size', 'editorCache', 'n'), 1024) : $d;
				$c .= ',';
				$c .= ($cst == true) ? $slider->slider->get_param(array('size', 'editorCache', 't'), 778) : $d;
				$d = ($cst == true) ? $slider->slider->get_param(array('size', 'editorCache', 't'), 778) : $d;
				$c .= ',';
				$c .= ($csi == true) ? $slider->slider->get_param(array('size', 'editorCache', 'm'), 480) : $d;
			}
		}else{
			$r .= ',';
			$r .= $this->get_val($global, array('size', 'notebook'), 1024);
			$r .= ',';
			$r .= $this->get_val($global, array('size', 'tablet'), 778);
			$r .= ',';
			$r .= $this->get_val($global, array('size', 'mobile'), 480);
		}
		
		return array(
			'level' => str_replace('px', '', $r),
			'height' => str_replace('px', '', $h),
			'width' => str_replace('px', '', $w),
			'cacheSize' => str_replace('px', '', $c)
		);
	}
	
	/**
	 * strip suffixes from number values for accurate comparisons
	 * @since: 6.0
	 */  
	public function strip_suffix_val($val){
		if(!is_string($val)) return $val;
		
		$val = trim($val);
		$len = strlen($val);
		if($len < 2) return $val;
		
		$suffix = false;
		$strips = array('ms', 'px', '%', 'deg');
		
		foreach($strips as $px){
			$chars = strlen($px);
			if($chars > $len) continue;
			if(strpos($val, $px, $len - $chars) !== false){
				$suffix = $chars;
				break;
			}
		}
		
		if($suffix !== false){
			$num = substr($val, 0, -$suffix);
			if(is_numeric($num)) $val = $num;
		}
		
		return $val;
		
	}
	
	
	/**
	 * strip suffixes from number values for accurate comparisons
	 * @since: 6.0
	 */  
	public function strip_suffix($val){
		if(is_object($val)) $val = (array)$val;
		
		if(is_array($val)){
			foreach($val as $key => $v){
				if(is_array($v) || is_object($v)){
					$val[$key] = $this->strip_suffix($v);
				}else{
					$val[$key] = $this->strip_suffix_val($v);
				}
			}
		}else{
			$val = $this->strip_suffix_val($val);
		}
		
		return $val;
	}
	
	/**
	 * shortden values for output
	 * @since: 6.0.0
	 **/
	public function shorten($s, $f, $t){
		return str_replace($f, $t, $s);
	}
	
	/**
	 * perform checks to see how to write a JavaScript variable
	 **/
	public function write_js_var($v, $pp = '"'){
		if(is_bool($v)) $v = ($v) ? 'true' : 'false';
		return (is_numeric($v) || substr($v, 0, 1) === '[' || in_array($v, array('true', 'false'))) ? $v : $pp.$v.$pp;
	}
}
