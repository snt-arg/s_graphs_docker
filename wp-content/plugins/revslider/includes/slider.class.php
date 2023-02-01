<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

global $rs_do_init_action;
$rs_do_init_action = true;

class RevSliderSlider extends RevSliderFunctions {
	
	public $id;
	public $title;
	public $alias;
	public $settings		= array();
	public $params			= array();
	public $slides;
	public $type;
	public $inited			= false;
	public $map;
	public $template_slider	= false;
	public $is_woocommerce	= false;

	/**
	 * @var RevSliderSlide
	 */
	public $_static_slide;
	
	/**
	 * used to determinate if we need to init the layers of the Slides
	 * can cause heavy ram usage on slider overview page if we have 100+ Sliders
	 **/
	public $init_layer = true;

	public function __construct(){
		parent::__construct();
		$this->map = array();
	}
	
	/**
	 * START: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/
	 
	/**
	 * old version of get_param();
	 * added for compatibility with old AddOns
	 **/
	public function getParam($key, $default = '', $validateType = null, $title = ''){
		//echo '<!-- Slider Revolution Notice: Please do not use RevSliderSlider->getParam() anymore, use RevSliderSlider->get_param() instead -->'."\n";
		return $this->get_param($key, $default);
	}
	
	/**
	 * old version of get_param();
	 * added for compatibility with old AddOns
	 **/
	public function getParams(){
		//echo '<!-- Slider Revolution Notice: Please do not use RevSlider->getParams() anymore, use RevSliderSlider->get_params() instead -->'."\n";
		return $this->get_params();
	}
	
	/**
	 * old version of get_id();
	 * added for compatibility with old AddOns
	 **/
	public function getID(){
		//echo '<!-- Slider Revolution Notice: Please do not use RevSliderSlider->getID() anymore, use RevSliderSlider->get_id() instead -->'."\n";
		return $this->get_id();
	}
	
	/**
	 * old version of get_sliders();
	 * added for compatibility with old AddOns
	 **/
	public function getArrSliders($templates = false){
		//echo '<!-- Slider Revolution Notice: Please do not use RevSliderSlider->getArrSliders() anymore, use RevSliderSlider->get_sliders() instead -->'."\n";
		return $this->get_sliders($templates);
	}
	
	/**
	 * old version of init_by_mixed();
	 * added for compatibility with old Themes
	 **/
	public function initByMixed($mixed){
		$this->init_by_mixed($mixed);
	}
	
	/**
	 * old version of init_by_id();
	 * added for compatibility with old AddOns
	 **/
	public function initByID($sid){
		//echo '<!-- Slider Revolution Notice: Please do not use RevSlider->initByID() anymore, use RevSliderSlider->init_by_id() instead -->'."\n";
		$this->init_by_id($sid);
	}
	
	/**
	 * old version of initByAlias();
	 */
	public function initByAlias($alias){
		$this->init_by_alias($alias);
	}
	
	/**
	 * old version of get_alias();
	 */
	public function getAlias(){
		return $this->get_alias();
	}
	
	/**
	 * old version of check_alias();
	 */
	public function isAliasExistsInDB($alias){
		return $this->check_alias($alias);
	}
	
	/**
	 * old version of get_shortcode();
	 */
	public function getShortcode(){
		return $this->get_shortcode();
	}
	
	/**
	 * old version of get_first_slide_id_from_gallery();
	 */
	public function getFirstSlideIdFromGallery(){
		return $this->get_first_slide_id_from_gallery();
	}
	
	/**
	 * old version of is_posts();
	 */
	public function isSlidesFromPosts(){
		return $this->is_posts();
	}
	
	/**
	 * old version of is_stream();
	 */
	public function isSlidesFromStream(){
		return $this->is_stream();
	}
	
	/**
	 * used in featured addon 
	 **/
	public function getNumSlidesRaw(){
		return $this->get_slides();
	}
	
	/**
	 * used in featured addon 
	 **/
	public function getNumSlides(){
		return $this->get_slides();
	}
	
	/**
	 * used in featured addon 
	 * old version of get_wanted_slides();
	 * @obsolete: $published obsolete
	 **/
	public function getNumRealSlides($published = false, $type = 'post'){
		return $this->get_wanted_slides($type);
	}
	
	/**
	 * old version of get_title();
	 */
	public function getTitle(){
		return $this->get_title();
	}
	
	/**
	 * old version of get_sliders_short();
	 */		
	public function getArrSlidersShort($exclude_id = null, $filter = 'all'){
		return $this->get_sliders_short($exclude_id, $filter);
	}
	
	/**
	 * old version of init_by_data();
	 */
	public function initByDBData($data){
		$this->init_by_data($data);
	}
	
	/**
	 * old version of alias_exists();
	 */
	public static function isAliasExists($alias, $return_id = false){
		return self::alias_exists($alias, $return_id);
	}
	
	/**
	 * old version of get_slide_names();
	 */
	public function getArrSlideNames(){
		return $this->get_slide_names();
	}
	
	/**
	 * this function does not exist anymore, only added for backwards compatibility,
	 * as a theme author, please use different functionality to recreate this
	 */
	public function getAllSliderAliases(){
		return array();
	}
	
	/**
	 * old version of get_slides();
	 */
	public function getSlidesFromGallery($published = false, $allwpml = false, $first = false){
		return $this->get_slides($published, $allwpml, $first);
	}
	
	/**
	 * old version of import_slider();
	 * $updateStatic is obsolete now
	 */
	public function importSliderFromPost($update_animation = true, $updateStatic = true, $exact_filepath = false, $is_template = false, $single_slide = false, $update_navigation = true, $install = true){
		$i = new RevSliderSliderImport();
		$r = $i->import_slider($update_animation, $exact_filepath, $is_template, $single_slide, $update_navigation, $install);
		
		return $r;
	}
	
	/**
	 * old version of delete_slider();
	 */
	public function deleteSlider(){
		$this->delete_slider();
	}
	
	/**
	 * old version of get_slider_for_admin_menu();
	 */
	public function getAllSliderForAdminMenu(){
		return $this->get_slider_for_admin_menu();
	}
	
	/**
	 * END: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/
	
	
	/**
	 * return the map of slide IDs
	 **/
	public function get_map(){
		return $this->map;
	}
	 
	/**
	 * init by id or alias
	 * @before: RevSliderSlider::initByMixed();
	 * @param mixed $mixed  slider id or alias
	 * @param bool $show_error
	 */
	public function init_by_mixed($mixed, $show_error = true){

		if(is_numeric($mixed)){
			$this->init_by_id($mixed, $show_error);
		}else{
			$this->init_by_alias($mixed, $show_error);
		}
	}
	
	
	/**
	 * initialize the slider data by given id
	 * before: RevSliderSlider::initByID();
	 * @param int $sid  slider id
	 * @param bool $show_error
	 */
	public function init_by_id($sid, $show_error = true){
		global $wpdb;
		$this->validate_numeric($sid, 'Slider ID');
		
		$slider_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." WHERE id = %d", $sid), ARRAY_A);
		if(empty($slider_data) && !is_admin() && $show_error === true){
			throw new Exception('Slider not found.');
		}
		
		if(!empty($slider_data)){
			$this->init_by_data($slider_data);
		}
	}
	
	
	/**
	 * initialize the slider data by given alias
	 * @before: RevSliderSlider::initByAlias();
	 * @param string $alias  slider alias
	 * @param bool $show_error
	 */
	public function init_by_alias($alias, $show_error = true){
		global $wpdb;
		
		$_alias = str_replace(' ', '-', $alias); //make sure that no spaces are added
		$slider_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." WHERE alias = %s", $_alias), ARRAY_A);
		if(empty($slider_data)){ //go back to an very old option where an slider alias could have a space
			$slider_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." WHERE alias = %s", $alias), ARRAY_A);
		}
		if(empty($slider_data) && !is_admin() && $show_error === true){
			throw new Exception('Slider with alias '.sanitize_text_field(esc_attr($alias)).' not found.');
		}
		
		if(!empty($slider_data)){
			$this->init_by_data($slider_data);
		}
	}
	
	
	/**
	 * init slider by db data
	 * before: RevSliderSlider::initByDBData
	 */
	public function init_by_data($data){
		$data = apply_filters('revslider_slider_init_by_data', $data);
		
		$this->id		= $this->get_val($data, 'id');
		$this->title	= $this->get_val($data, 'title');
		$this->alias	= $this->get_val($data, 'alias');
		$this->settings	= (array)json_decode($this->get_val($data, 'settings'), true);
		$this->params	= (array)json_decode($this->get_val($data, 'params'), true);
		
		$this->params['version'] = $this->get_val($this->settings, 'version');
		
		$this->type		= $this->get_val($data, 'type');
		$this->inited	= true;
		
		global $rs_preview_mode;
		$do_action = (is_admin())		? false : true;
		$do_action = (wp_doing_ajax())	? true : $do_action;
		$do_action = ($rs_preview_mode)	? true : $do_action;
		
		if($do_action){
			global $rs_do_init_action;
			if($rs_do_init_action === true){
				do_action('revslider_slider_init_by_data_post', $this);
			}
		}
		
		$this->modify_by_global_settings();
	}
	
	
	/**
	 * set slider params
	 */
	public function set_params($params){
		$this->params = $params;
	}
	
	
	/**
	 * return params of current initialized Slider
	 * before: RevSliderSlider::getParams()
	 */
	public function get_params(){
		return $this->params;
	}
	
	
	/**
	 * set specific slider param
	 * @since: 5.1.1
	 */
	public function set_param($name, $value){
		if(is_array($name)){
			$params = &$this->params;
			if(!empty($name)){
				foreach($name as $key){
					if(is_array($params)){
						$params = &$params[$key];
					}elseif(is_object($params)){
						$params = &$params->$key;
					}
				}
			}
			$params = $value;
		}else{
			$this->params[$name] = $value;
		}
	}
	
	/**
	 * return certain param of current initialized Slider
	 * before: RevSliderSlider::get_param()
	 * @param mixed $key
	 * @param string $default
	 * @return mixed
	 */
	public function get_param($key, $default = ''){
		if(!is_array($key)){
			return $this->get_val($this->params, $key, $default);
		}else{
			$a = $this->params;
			foreach($key as $k => $v){
				$a = $this->get_val($a, $v, $default);
			}
			
			return $a;
		}
	}
	
	
	/*
	 * return settings of current initialized Slider
	 * @since: 5.0
	 * before: RevSliderSlider::getSettings()
	 */
	public function get_settings(){
		return $this->settings;
	}
	
	
	/*
	 * return certain setting
	 * @since: 5.0
	 */
	public function get_setting($handle, $default){
		return $this->get_val($this->settings, $handle, $default);
	}
	
	
	/**
	 * get the slider title
	 * @before: RevSliderSlider::getTitle()
	 */
	public function get_title(){
		return $this->title;
	}
	
	
	/**
	 * get the slider alias
	 * @before: RevSliderSlider::getAlias()
	 */
	public function get_alias(){
		return $this->alias;
	}
	
	
	/**
	 * get slider shortcode
	 * @before: RevSliderSlider::getShortcode() 
	 */
	public function get_shortcode(){
		return '[rev_slider alias="'.$this->alias.'"]';
	}
	
	/**
	 * get the slider tags
	 * @since: 6.0
	 */
	public function get_tags(){
		return $this->get_val($this->settings, 'tags', array());
	}
	
	
	/**
	 * get the slider id
	 * @before: RevSliderSlider::getID()
	 */
	public function get_id(){
		return $this->id;
	}
	
	/**
	 * return if the slider source is from posts
	 * @before: RevSliderSlider::isSlidesFromPosts();
	 */
	public function is_posts(){
		$source = $this->get_param('sourcetype', 'gallery');
		return in_array($source, array('post', 'posts', 'specific_posts', 'specific_post', 'current_post', 'woocommerce', 'woo'), true);
	}
	
	
	/**
	 * return if the slider source is from posts
	 * @before: RevSliderSlider::isSlidesFromPosts();
	 */
	public function is_posts_pre60(){
		$source = $this->get_param('source_type', 'gallery');
		return in_array($source, array('post', 'posts', 'specific_posts', 'specific_post', 'current_post', 'woocommerce', 'woo'), true);
	}
	
	
	/**
	 * return if the slider source is from specific posts
	 */
	public function is_specific_posts(){
		return in_array($this->get_param('source_type', 'gallery'), array('specific_posts', 'specific_post'), true);
	}


	/**
	 * return if the slider source is from stream
	 * @before: RevSliderSlider::isSlidesFromStream();
	 */
	public function is_stream(){
		$source = $this->get_param('sourcetype', 'gallery');
		return (!in_array($source, array('post', 'posts', 'specific_posts', 'specific_post', 'current_post', 'woocommerce', 'woo', 'gallery'), true)) ? $source : false;
	}
	
	
	/**
	 * return if the slider source is from stream
	 * @since: 6.0.0
	 */
	public function is_stream_pre60(){
		$source = $this->get_param('source_type', 'gallery');
		return (!in_array($source, array('post', 'posts', 'specific_posts', 'specific_post', 'current_post', 'woocommerce', 'woo', 'gallery'), true)) ? $source : false;
	}
	
	/**
	 * get real slides number, from posts, social streams ect.
	 */
	public function get_wanted_slides($type = 'post'){
		$ns = count($this->slides);
		
		switch($type){
			case 'post':
				if($this->get_param(array('source', 'post', 'fetchType'), 'cat_tag') == 'next_prev'){
					$ns = 2;
				}else{
					$ns = $this->get_param(array('source', 'post', 'maxPosts'), $ns);
					if(intval($ns) == 0) $ns = '∞';
				}
			break;
			case 'facebook':
			case 'twitter':
			case 'instagram':
			case 'flickr':
			case 'youtube':
			case 'vimeo':
				$ns = $this->get_param(array('source', $type, 'count'), $ns);
			break;
		}
		
		return $ns;
	}
	
	/*
	 * return true if slider is favorite
	 * @since: 5.0
	 * @before: RevSliderSlider::isFavorite()
	 * @obsolete since 6.0 as it was moved to the favorite.class.php
	 */
	public function is_favorite(){
		return $this->get_val($this->settings, 'favorite', 'false') == 'true';
	}
	
	
	/**
	 * return the number of Sliders existing
	 */
	public function get_slider_count(){
		global $wpdb;
		return count($wpdb->get_results("SELECT COUNT(*) FROM ".$wpdb->prefix . RevSliderFront::TABLE_SLIDER ." WHERE `type` = '' OR `type` IS NULL", ARRAY_A));
	}
	
	
	/**
	 * get the first slide ID of the current slider
	 * @before: RevSliderSlider::getFirstSlideIdFromGallery()
	 */
	public function get_first_slide_id_from_gallery(){
		global $wpdb;
		
		$slides = array();
		$record = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDES ." WHERE slider_id = %s ORDER BY slide_order ASC LIMIT 0,1", array($this->get_id())), ARRAY_A);
		
		if(!empty($record)){
			$slide = new RevSliderSlide();
			$slide->init_by_data($record);
			$sid = $slide->get_id();
			$slides[$sid] = $slide;
			
			return $slides;
		}
		
		return false;
	}
	
	
	/**
	 * get the alias of an slider by id
	 **/
	public function get_alias_by_id($slider_id){
		global $wpdb;
		$record = $wpdb->get_row($wpdb->prepare("SELECT `alias` FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." WHERE id = %s LIMIT 0,1", array($slider_id)), ARRAY_A);
		return (!empty($record)) ? $this->get_val($record, 'alias') : false;
	}
	
	
	/**
	 * get all sliders that have a certain string in the params
	 * @since: 6.4.6
	 **/
	public function get_slider_by_param_string($string, $templates = false){
		global $wpdb;
		
		$sql = "SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." WHERE ";
		$string = (array)$string;
		$add = '';
		if($templates === true) $sql .= "(";
		
		foreach($string as $v){
			$sql .= $add. "params LIKE '%%%s%%'";
			if($add === '') $add = " OR ";
		}
		if($templates === true) $sql .= ") AND `type` != 'template'";
		
		return $wpdb->get_results($wpdb->prepare($sql, $string), ARRAY_A);
	}
	
	
	/**
	 * get all images that are beeing used by the Slider
	 **/
	public function get_images(){
		$images = array();
		$ret	= array();
		$image = $this->get_val($this->params, array('layout', 'bg', 'image'));
		$a_url = $this->get_val($this->params, array('troubleshooting', 'alternateURL'));
		
		if($image != '') $images[$image] = true;
		if($a_url != '') $images[$a_url] = true;
		
		if(!empty($this->slides) && count($this->slides) > 0){
			foreach($this->slides as $key => $slide){
				$params = $slide->get_params();
				$layers = $slide->get_layers();
				$image	= $this->get_val($params, array('bg', 'image'));
				$thumb	= $this->get_val($params, array('thumb', 'customThumbSrc'));
				$a_thumb = $this->get_val($params, array('thumb', 'customAdminThumbSrc'));
				
				if($image != ''){
					$altOption	 = $this->get_val($params, array('attributes', 'altOption'), 'media_library');
					$titleOption = $this->get_val($params, array('attributes', 'titleOption'), 'media_library');
					$alt		 = '';
					$title		 = '';
					switch($altOption){
						case 'media_library';
							$id = attachment_url_to_postid($image);
							if($id > 0) $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
						break;
						case 'file_name';
							$alt = $image;
						break;
						case 'custom';
							$alt = $this->get_val($params, array('attributes', 'alt'), '');
						break;
					}
					switch($titleOption){
						case 'media_library';
							$id = attachment_url_to_postid($image);
							if($id > 0) $title = get_the_title($id);
						break;
						case 'file_name';
							$title = $image;
						break;
						case 'custom';
							$title = $this->get_val($params, array('attributes', 'title'), '');
						break;
					}
					$images[$image] = array(
						'src' => $image,
						'alt' => $alt,
						'title' => $title
					);
				}
				if($thumb != '' && !isset($images[$thumb])) $images[$thumb] = true;
				if($a_thumb != '' && !isset($images[$a_thumb])) $images[$a_thumb] = true;
				
				if(!empty($layers)){
					foreach($layers as $layer){
						$type		= $this->get_val($layer, 'type', 'text');
						$image		= $this->get_val($layer, array('media', 'imageUrl'));
						$bg_image	= $this->get_val($layer, array('idle', 'backgroundImage'));
						
						if($image != '' && !isset($images[$image]))	$images[$image] = true;
						if($bg_image != '' && !isset($images[$bg_image])) $images[$bg_image] = true;
						
						if(in_array($type, array('video', 'audio'))){
							$poster = $this->get_val($layer, array('media', 'posterUrl'), '');
							if($poster != '' && !isset($images[$poster])) $images[$poster] = true;
						}
						if($type === 'video'){
							$very_big	= $this->get_val($layer, array('media', 'thumbs', 'veryBig'));
							$big		= $this->get_val($layer, array('media', 'thumbs', 'big'));
							$large		= $this->get_val($layer, array('media', 'thumbs', 'large'));
							$medium		= $this->get_val($layer, array('media', 'thumbs', 'medium'));
							$small		= $this->get_val($layer, array('media', 'thumbs', 'small'));
							
							$very_big	= (is_array($very_big) && isset($very_big['url'])) ? $very_big['url'] : $very_big;
							$big		= (is_array($big) && isset($big['url'])) ? $big['url'] : $big;
							$large		= (is_array($large) && isset($large['url'])) ? $large['url'] : $large;
							$medium		= (is_array($medium) && isset($medium['url'])) ? $medium['url'] : $medium;
							$small		= (is_array($small) && isset($small['url'])) ? $small['url'] : $small;
							
							if($very_big != '' && !isset($images[$very_big])) $images[$very_big] = true;
							if($big != '' && !isset($images[$big]))			  $images[$big] = true;
							if($large != '' && !isset($images[$large]))		  $images[$large] = true;
							if($medium != '' && !isset($images[$medium]))	  $images[$medium] = true;
							if($small != '' && !isset($images[$small]))		  $images[$small] = true;
						}
					}
				}
			}
		}
		
		if(!empty($images)){
			foreach($images as $img => $b){
				if(!is_bool($b)){
					$ret[] = $b;
				}else{
					$alt = '';
					$title = '';
					$id = attachment_url_to_postid($img);
					if($id > 0){
						if($id > 0) $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
						if($id > 0) $title = get_the_title($id);
					}
					$ret[] = array(
						'src' => $img,
						'alt' => $alt,
						'title' => $title
					);
				}
			}
		}
		
		return $ret;
	}
	
	
	/**
	 * check if alias already exists
	 * @before: RevSliderSlider::isAliasExists()
	 */
	public static function alias_exists($alias, $return_id = false){
		global $wpdb;
		
		$alias_exists = $wpdb->get_row($wpdb->prepare("SELECT id FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." WHERE alias = %s", $alias), ARRAY_A);
		
		if($return_id === true){
			return (!empty($alias_exists)) ? $alias_exists['id'] : false;
		}else{
			return !empty($alias_exists);
		}
	}
	
	
	/**
	 * delete slider from datatase
	 * @before RevSliderSlider::deleteSlider();
	 */
	public function delete_slider(){
		global $wpdb;
		
		//delete slider
		$wpdb->delete($wpdb->prefix . RevSliderFront::TABLE_SLIDER, array('id' => $this->id));
		
		//delete slides
		$this->delete_all_slides();
		$this->delete_static_slide();

		do_action('revslider_slider_on_delete_slider', $this->id);
	}
	
	
	/**
	 * delete all slides
	 * @before: RevSliderSlider::deleteAllSlides();
	 */
	public function delete_all_slides(){
		global $wpdb;
		
		$wpdb->delete($wpdb->prefix . RevSliderFront::TABLE_SLIDES, array('slider_id' => $this->id));
		
		do_action('revslider_slider_delete_all_slides', $this->id);
		do_action('revslider_slider_deleteAllSlides', $this->id);
	}
	

	/**
	 * delete static slide
	 * @before: RevSliderSlider::deleteStaticSlide();
	 */
	public function delete_static_slide(){
		global $wpdb;
		
		$wpdb->delete($wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES, array('slider_id' => $this->id));
		do_action('revslider_slider_delete_static_slide', $this->id);
	}
	
	
	/**
	 * duplicate a slide by given data
	 * @before: RevSliderSlider::duplicateSliderFromData();
	 */
	public function duplicate_slider_by_id($id, $is_template = false){
		$this->validate_not_empty($id, 'Slider ID');
		$this->init_by_id($id);
		
		$title = $this->get_title();
		if($is_template){
			$title = str_replace(' Template', '', $title); //remove the added Template from the title in copy process
			$talias	= $title;
		}else{
			$talias	= $this->get_alias();
		}
		
		$ti = 1;
		while($this->alias_exists($talias)){ //set a new alias and title if its existing in database
			$talias = $title. ' ' .$ti;
			$ti++;
		}
		
		return $this->duplicate_slider($talias);
	}
	
	
	/**
	 * update the Slider title
	 */
	public function update_title($new_title){
		global $wpdb;
		
		$new_title = stripslashes(esc_html($new_title));
		if(!empty($new_title)){
			$this->title = $new_title;
			
			$return = $wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDER, array('title' => $this->title), array('id' => $this->id));
		}else{
			$return = $this->title;
		}
		
		return ($return) ? $this->title : false;
	}
	
	
	/**
	 * update the Slider Tags
	 * @since: 6.0
	 */
	public function update_slider_tags($slider_id, $tags){
		global $wpdb;
		
		$this->validate_not_empty($slider_id, 'Slider ID');
		
		$record	  = $wpdb->get_row($wpdb->prepare("SELECT `settings` FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." WHERE id = %s", $slider_id), ARRAY_A);
		$cur_tags = array();
		
		if(!empty($tags)){	
			foreach($tags as $tag){
				$tag		= preg_replace('/ /', '-', $tag);
				$tag		= preg_replace('/[^-0-9a-zA-Z_-]/', '', $tag);
				$cur_tags[] = $tag;
			}
		}
			
		if(!isset($record['settings'])){
			$record['settings'] = array();
		}else{
			$record['settings'] = json_decode($record['settings'], true);
		}
		
		if(!isset($record['settings']['tags'])) $record['settings']['tags'] = array();
		
		$record['settings']['tags'] = $cur_tags;
		$settings					= json_encode($record['settings']);
		
		return $wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDER, array('settings' => $settings), array('id' => $slider_id));
	}
	
	
	/**
	 * get the last Slider ID
	 * @since: 6.0
	 */
	public function get_last_slider_id(){
		global $wpdb;
		
		$record = $wpdb->get_row("SELECT `id` FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." ORDER BY `id` DESC LIMIT 0,1", ARRAY_A);
		$id 	= (!empty($record)) ? $this->get_val($record, 'id') : -1;
		
		return $id;
	}
	
	
	/**
	 * get all slide children
	 * @before: RevSliderSlider::getArrSlideChildren();
	 */
	public function get_slide_children($slide_id){
		$slides = $this->get_slides();
		
		if(!isset($slides[$slide_id])){
			$this->throw_error(__('Slide not found in the main slides of the slider. Maybe it', 'revslider'));
		}
		
		$slide		= $slides[$slide_id];
		$children	= $slide->get_children();
		
		return $children;
	}
	
	
	/**
	 * get array of slide names
	 * @before: RevSliderSlider::getArrSlideNames();
	 */
	public function get_slide_names(){
		if(empty($this->slides)){
			$this->get_slides();
		}
		
		$names = array();
		if(!empty($this->slides)){
			foreach($this->slides as $slide){
				$id		 = $slide->get_id();
				$file	 = $slide->image_filename;	
				$title	 = $slide->get_title();
				$name	 = $title;
				$name 	.= (!empty($file)) ? ' ('. $file .')' : '';
				
				$childs	 = $slide->get_child_ids();
				
				$names[$id] = array(
					'name'			 => $name,
					'arrChildrenIDs' => $childs,
					'title'			 => $title
				);
			}
		}
		
		return $names;
	}
	
	
	/**
	 * duplicate slider in datatase
	 * @before: RevSliderSlider::duplicateSlider();
	 */
	private function duplicate_slider($title = false, $prefix = false){
		global $wpdb;
		
		$old_slider_id = $this->id;
		//select a slider and then duplicate it
		$select = $wpdb->prepare("SELECT title, alias, params, type, settings FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." WHERE id = %s", array($this->id));
		$wpdb->query("INSERT INTO ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." (title, alias, params, type, settings) (".$select.")");
		
		//update the slider title and alias to a new one
		$slider_last_id	= $wpdb->insert_id;
		$params			= $this->params;
		$this->validate_not_empty($slider_last_id, 'Slider ID');
		$slider_counter = $this->get_slider_count(); //get last slider number
		
		if($title === false){
			$slider_counter++;
			$new_title = 'Slider'.$slider_counter;
			$new_alias = 'slider'.$slider_counter;
		}else{
			$new_title = ($prefix !== false) ? sanitize_text_field($title.' '.$this->get_val($params, 'title')) : sanitize_text_field($title);
			$new_alias = ($prefix !== false) ? sanitize_title($title.' '.$this->get_val($params, 'title')) : sanitize_title($title);
			
			//check if alias exists
			$c_title = $new_title;
			$c_alias = $new_alias;
			while($this->alias_exists($c_alias)){
				$c_title = $new_title . $slider_counter;
				$c_alias = $new_alias . $slider_counter;
				$slider_counter++;
			}
			$new_title = $c_title;
			$new_alias = $c_alias;
		}
		
		$params['title']	 = $new_title;
		$params['alias']	 = $new_alias;
		$params['shortcode'] = '[rev_slider alias="'. $new_alias .'"]';
		if($this->template_slider) $params['pakps'] = true;

		$wpdb->update(
			$wpdb->prefix . RevSliderFront::TABLE_SLIDER,
			array(
				'title'	 => $new_title,
				'alias'	 => $new_alias,
				'params' => json_encode($params),
				'type'	 => ''
			),
			array('id' => $slider_last_id)
		);
		
		
		//duplicate slides and add them to the new Slider
		$slides = $wpdb->get_results($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDES ." WHERE slider_id = %s", $this->id), ARRAY_A);
		if(!empty($slides)){
			foreach($slides as $slide){
				$slide['slider_id'] = $slider_last_id;
				$slide_id = $slide['id'];
				unset($slide['id']);
				$wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_SLIDES, $slide);
				
				if(isset($slide_id)){
					$this->map[$slide_id] = $wpdb->insert_id;
				}
			}
		}
		
		//duplicate static slide if exists
		$slide		= new RevSliderSlide();
		$staticID	= $slide->get_static_slide_id($this->id);
		$static_id	= 0;
		if($staticID !== false){
			$record = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES ." WHERE id = %s", $staticID), ARRAY_A);
			unset($record['id']);
			$record['slider_id'] = $slider_last_id;
			
			$wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES, $record);
			$static_id = $wpdb->insert_id;
		}
		
		//update actions
		$slides = $wpdb->get_results($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDES ." WHERE slider_id = %s", $slider_last_id), ARRAY_A);
		if($static_id > 0){
			$slides_static = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES ." WHERE id = %s", $static_id), ARRAY_A);
			if(!empty($slides_static)) $slides[] = $slides_static;
		}
		
		if(!empty($slides)){
			foreach($slides as $slide){
				$c_slide	= new RevSliderSlide();
				$c_slide->init_by_data($slide);
				$layers		= $c_slide->get_layers();
				
				//change for WPML the parent IDs if necessary
				$parent_id	= $this->get_val($c_slide, array('params', 'child', 'parentId'), false);
				
				if(!in_array($parent_id, array(false, ''), true) && isset($this->map[$parent_id])){
					$create = array('params' => $this->get_val($c_slide, 'params', array()));
					
					$this->set_val($create, array('params', 'child', 'parentId'), $this->map[$parent_id]);
					
					$new_params = json_encode($create['params']);
					$new_params = (empty($new_params)) ? stripslashes(json_encode($create['params'])) : $new_params;
					$create['params'] = $new_params;
					
					$wpdb->update(
						$wpdb->prefix . RevSliderFront::TABLE_SLIDES,
						$create,
						array('id' => $slide['id'])
					);
				}
				
				$did_change	= false;
				if(!empty($layers)){
					foreach($layers as $key => $value){
						$actions = $this->get_val($value, array('actions', 'action'));
						
						if(!empty($actions)){
							foreach($actions as $a_k => $action){
								$jtsval = $this->get_val($action, 'jump_to_slide');
								if(isset($this->map[$jtsval])){
									$this->set_val($layers, array($key, 'actions', 'action', $a_k, 'jump_to_slide'), $this->map[$jtsval]);
									$did_change = true;
								}
							}
						}
					}
				}
				if($did_change === true){
					$create		= array();
					$my_layers	= json_encode($layers);
					$create['layers'] = (empty($my_layers)) ? stripslashes(json_encode($layers)) : $my_layers;
					
					if($slide['id'] == $static_id){
						$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES, $create, array('id' => $static_id));
					}else{
						$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDES, $create, array('id' => $slide['id']));
					}
				}
			}
		}
		
		//change the javascript api ID to the correct one
		$c_slider = new RevSliderSliderImport();
		$c_slider->init_by_id($slider_last_id);
		
		$upd = new RevSliderPluginUpdate();
		$upd->upgrade_slider_to_latest($c_slider);
		
		$c_slider->update_css_and_javascript_ids($old_slider_id, $slider_last_id, $this->map);
		$c_slider->update_color_ids($this->map);
		
		do_action('revslider_duplicate_slider', $slider_last_id, $old_slider_id, $slides, $this);
		
		return $slider_last_id;
	}
	
	
	/**
	 * update the modal id and the alias in the layer actions
	 **/
	public function update_modal_ids($slider_ids, $slide_ids){
		$slides = $this->get_slides();
		
		if(empty($slides)) return;
		
		foreach($slides as $skey => $slide){
			if(version_compare($slide->get_param('version', '1.0.0'), '6.0.0', '<')) continue;
			$layers = $slide->get_layers();
			
			if(empty($layers)) continue;
			$change = false;
			foreach($layers as $lk => $layer){
				$actions = $this->get_val($layer, array('actions', 'action'), array());
			
				if(empty($actions)) continue;
				
				foreach($actions as $ak => $a){
					if($this->get_val($a, 'action', '') !== 'open_modal') continue;

					$v = intval($this->get_val($a, 'openmodalId', 0)); //only openmodal is set (alias), openmodalId is not set!
					
					if(isset($slider_ids[$v])){
						$slider_alias = $this->get_alias_by_id($slider_ids[$v]);
						$change = true;
						$this->set_val($layers, array($lk, 'actions', 'action', $ak, 'openmodalId'), $slider_ids[$v]);
						$this->set_val($layers, array($lk, 'actions', 'action', $ak, 'openmodal'), $slider_alias);
						
						$sv = $this->get_val($a, 'modalslide', 0);
						if($sv !== 0){
							$_sv = intval(str_replace('rs-', '', $sv));
							if($_sv > 0 && isset($slide_ids[$_sv])){
								$this->set_val($layers, array($lk, 'actions', 'action', $ak, 'modalslide'), 'rs-'.$slide_ids[$_sv]);
							}
						}
					}
				}
			}
			
			if($change){
				$slide->set_layers_raw($layers);
				$slide->save_layers();
			}
		}
	}
	
	
	/**
	 * Check if an alias exists in database
	 * @before: RevSliderSlider::isAliasExistsInDB();
	 */
	public function check_alias($alias){
		global $wpdb;
		
		$add	= (!empty($this->id)) ? $wpdb->prepare(" AND id != %s AND `type` != 'template'", array($this->id)) : '';
		$slider	= $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." WHERE alias = %s", $alias).$add, ARRAY_A);
		
		return !empty($slider);
	}
	
	
	/**
	 * Create a blank Slider
	 **/
	public function create_blank_slider(){
		global $wpdb;
		
		$title		= 'Slider ';
		$alias		= 'slider-';
		$counter	= 1;
		$new_alias	= $alias.$counter;
		
		while($this->alias_exists($new_alias)){
			$counter++;
			$new_alias = $alias.$counter;
		}
		
		$title .= $counter;
		
		//insert slider to database
		$slider_data = array(
			'title'		=> $title,
			'alias'		=> $new_alias,
			'params'	=> json_encode(array(), JSON_FORCE_OBJECT),
			'settings'	=> json_encode(array('version' => RS_REVISION), JSON_FORCE_OBJECT),
			'type'		=> ''
		);
		
		$result		= $wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_SLIDER, $slider_data);
		$slider_id	= ($result) ? $wpdb->insert_id : false;
		
		return $slider_id;
	}
	
	
	/**
	 * Save Slider Settings
	 * @before: RevSliderSlider::createUpdateSliderFromOptions();
	 **/
	public function save_slider($slider_id, $data){
		global $wpdb;
		
		$params		= $this->get_val($data, 'params');
		$params 	= $this->json_decode_slashes($params);
		$settings	= $this->get_val($data, 'settings');
		$settings	= $this->json_decode_slashes($settings);
		$settings['version'] = $this->get_val($params, 'version', $this->get_val($settings, 'version'));
		
		$title	= sanitize_text_field($this->get_val($params, 'title'));
		$alias	= sanitize_text_field($this->get_val($params, 'alias'));
		
		unset($params['title']);
		unset($params['alias']);
		
		$this->validate_not_empty($title, 'Title');
		$this->validate_not_empty($alias, 'Alias');
		
		
		//params css and js check
		if(!current_user_can('administrator') && apply_filters('revslider_restrict_role', true)){
			//dont allow css and javascript from users other than administrator
			if(isset($params['codes']) && isset($params['codes']['css'])){
				unset($params['codes']['css']);
			}
			if(isset($params['codes']) && isset($params['codes']['javascript'])){
				unset($params['codes']['javascript']);
			}
		}
		
		if(!empty($slider_id)){
			$this->init_by_id($slider_id);
			
			if(!current_user_can('administrator') && apply_filters('revslider_restrict_role', true)){
				//check for js and css, add it to $params
				$params['codes'] = array();
				$params['codes']['css']			= $this->get_param(array('codes', 'css'), '');
				$params['codes']['javascript']	= $this->get_param(array('codes', 'javascript'), '');
			}
		}
		
		if($this->check_alias($alias)){
			$this->throw_error(__('A Slider with the given alias already exists', 'revslider'));
		}
		
		//insert slider to database
		$slider_data = array(
			'title'		=> $title,
			'alias'		=> $alias,
			'params'	=> json_encode($params),
			'settings'	=> json_encode($settings),
			'type'		=> ''
		);
		
		if(empty($slider_id)){ //create slider	
			$result		= $wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_SLIDER, $slider_data);
			$slider_id	= ($result) ? $wpdb->insert_id : false;
		}else{ //update slider
			$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDER, $slider_data, array('id' => $slider_id));
		}
		
		return $slider_id;
	}
	
	
	/**
	 * update some params in the slider
	 * @before: RevSliderSlider::updateParam();
	 */
	public function update_params($update, $replace = false){
		global $wpdb;
		$this->params = ($replace) ? $update : array_merge($this->params, $update);
		$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDER, array('params' => json_encode($this->params)), array('id' => $this->id));
	}
	
	
	/**
	 * update some settings in the slider
	 * @before: RevSliderSlider::updateSetting()
	 */
	public function update_settings($update){
		global $wpdb;
		$this->settings = array_merge($this->settings, $update);
		$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDER, array('settings' => json_encode($this->settings)), array('id' => $this->id));
	}
	
	
	/**
	 * get array of slides numbers by id's
	 * RevSliderSlider::getSlidesNumbersByIDs();
	 */
	public function get_slide_numbers_by_id($published = false){
		$numbers = array();
		$counter = 0;
		
		if(empty($this->slide)){
			$this->get_slides($published);
		}
		
		if(empty($this->arr_slides)){
			foreach($this->slides as $slide){
				$counter++;
				$id				= $slide->get_id();
				$numbers[$id]	= $counter;
			}
		}
		
		return $numbers;
	}
	
	
	/**
	 * get sliders array - function don't belong to the object!
	 * @before: RevSliderSlider::getArrSliders();
	 */
	public function get_sliders($templates = false){
		global $wpdb, $rs_do_init_action;
		
		$rs_do_init_action = false;
		$sliders	= array();
		$do_order	= 'id';
		$direction	= 'ASC';
		
		$slider_data = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix . RevSliderFront::TABLE_SLIDER." WHERE `type` != 'folder' ORDER BY %s %s", array($do_order, $direction)), ARRAY_A); //WHERE `type` = '' OR `type` IS NULL 
		if(!empty($slider_data)){
			foreach($slider_data as $data){
				$slider = new RevSliderSlider();
				$slider->init_by_data($data);
				
				if($templates === true){
					if($slider->type != 'template') continue;
				}elseif($templates === false){
					if($slider->type == 'template') continue;
				}
				
				$sliders[] = $slider;
			}
		}
		
		$rs_do_init_action = true;
		
		return $sliders;
	}

	/**
	 * get sliders shortlist object 
	 */
	public static function get_sliders_short_list(){
		global $wpdb;
		return (object)$wpdb->get_results($wpdb->prepare("SELECT id, title, alias FROM " . $wpdb->prefix . RevSliderFront::TABLE_SLIDER . " WHERE `type` != 'folder' AND `type` != 'template' ORDER BY %s %s", array('id', 'ASC')));
	}
	
	
	/**
	 * get array of alias
	 * @before: getAllSliderForAdminMenu()
	 */
	public function get_slider_for_admin_menu(){
		global $rs_do_init_action;
		
		$rs_do_init_action = false;
		$sliders = $this->get_sliders();
		$rs_do_init_action = true;
		
		$short = array();
		if(!empty($sliders)){
			foreach($sliders as $slider){
				$id = $slider->get_id();
				
				$short[$id] = array('title' => $slider->get_title(), 'alias' => $slider->get_alias());
			}
		}
		
		return $short;
	}
	
	public function set_slides($slides){
		$this->slides = array();
		if(!empty($slides)){
			foreach($slides as $slide){
				$rslide = new RevSliderSlide();
				$rslide->init_by_data($slide);
				$this->slides[] = $rslide;
			}
		}
	}
	
	/**
	 * get slides from gallery
	 * force from gallery - get the slide from the gallery only
	 * before: RevSliderSlider::getSlides() and also RevSliderSlider::getSlidesFromGallery()
	 */
	public function get_slides($published = false, $allwpml = false, $first = false){
		
		$cache_key = $this->get_wp_cache_key('get_slides_by_slider_id', array($this->id, $published, $allwpml, $first, $this->init_layer));
		$this->slides = wp_cache_get($cache_key, self::CACHE_GROUP);
		if (false === $this->slides) {
			$slide			= new RevSliderSlide();
			$this->slides	= $slide->get_slides_by_slider_id($this->id, $published, $allwpml, $first, $this->init_layer);
			wp_cache_set($cache_key, $this->slides, self::CACHE_GROUP);
		}

		return $this->slides;
	}
	
	
	/**
	 * get slides for export
	 * before: RevSliderSlider::getSlidesForExport()
	 */
	public function get_slides_for_export(){
		$slides = $this->get_slides(false, true);
		$export = array();
		
		if(!empty($slides)){
			foreach($slides as $slide){
				$export[] = array(
					'id'			=> $slide->get_id(),
					'params'		=> $slide->get_params_for_export(),
					'slide_order'	=> $slide->get_order(),
					'layers'		=> $slide->get_layers_for_export(),
					'settings'		=> $slide->get_settings()
				);
			}
		}
		
		return apply_filters('revslider_get_slides_for_export', apply_filters('revslider_getSlidesForExport', $export));
	}
	
	
	/**
	 * get static slide for export
	 * before: RevSliderSlider::getStaticSlideForExport()
	 */
	public function get_static_slide_for_export(){
		$static_slide	= array();
		$slide			= new RevSliderSlide();
		$static_id		= $slide->get_static_slide_id($this->id);
		
		if($static_id !== false){
			$slide->init_by_static_id($static_id);
			$params = $slide->get_params_for_export();
			if(!isset($params['static'])) $params['static'] = array();
			$params['static']['isstatic'] = true;
			
			$static_slide[] = array(
				'params'		=> $slide->get_params_for_export(),
				'slide_order'	=> $slide->get_order(),
				'layers'		=> $slide->get_layers_for_export(),
				'settings'		=> $slide->get_settings()
			);
		}
		
		return apply_filters('revslider_getStaticSlideForExport', $static_slide);
	}
	
	
	/**
	 * get array of sliders with slides, short, assoc.
	 * @before: RevSliderSlider::getArrSlidersWithSlidesShort();
	 */
	public function get_sliders_with_slides_short($filter = 'all'){
		$output	 = array();
		$sliders = $this->get_sliders_short(null, $filter);
		
		if(!empty($sliders)){
			foreach($sliders as $sid => $slider_name){
				$slider = new RevSliderSlider();
				$slider->init_by_id($sid);
				$is_posts = $slider->is_posts();
				
				if($filter == 'posts' && $is_posts == false) continue; //filter by gallery only
				if($filter == 'gallery' && $is_posts == true) continue;
				if($filter == 'template' && $is_posts == false)	continue; //filter by template type
				
				$slides = $slider->get_slides_from_gallery_short();
				if(!empty($slides)){
					foreach($slides as $slide_id => $slide_name){
						$output[$slide_id] = $slider_name.', '.$slide_name;
					}
				}
			}
		}
		
		return $output;
	}
	
	
	/**
	 * get slide id and slide title from gallery
	 * @before: RevSliderSlider::getArrSlidesFromGalleryShort()
	 */
	public function get_slides_from_gallery_short(){
		$counter = 0;
		$output	 = array();
		$slides	 = $this->get_slides();
		
		if(!empty($slides)){
			foreach($slides as $slide){
				$id			 = $slide->get_id();
				$name		 = 'Slide '.$counter;
				$title		 = $slide->get_param('title', '');
				$output[$id] = (!empty($title)) ? $name.' - ('.$title.')' : $name;
				
				$counter++;
			}
		}
		
		return $output;
	}
	
	
	/**
	 * get slides for output
	 * one level only without children
	 * @before: RevSliderSlider::getSlidesForOutput();
	 */
	public function get_slides_for_output($published = false, $lang = 'all', $gal_ids = array()){
		$parent_slides = $this->get_parent_slides($published, $gal_ids, $lang);
		
		if($lang == 'all' || $this->is_stream()) return $parent_slides;	//$this->is_posts() || 	
		$slides = array();
		
		if(!empty($parent_slides)){
			foreach($parent_slides as $parent_slide){
				$parent_lang = $parent_slide->get_param(array('child', 'language'), 'all');
				if($parent_lang == $lang){
					$slides[] = $parent_slide;
				}
				
				$added = false;
				$children = $parent_slide->get_children();
				if(!empty($children)){
					foreach($children as $child){
						if($child->get_param(array('child', 'language'), 'all') == $lang){
							$slides[] = $child;
							$added = true;
							break;
						}
					}
				}
				
				if($added == false && $parent_lang == 'all'){
					$slides[] = $parent_slide;
				}
			}
		}
		
		return $slides;
	}
	
	
	/**
	 * get the parent Slides if the Slide has any
	 **/
	public function get_parent_slides($published, $gal_ids, $lang){
		$post	= $this->is_posts();
		$stream	= $this->is_stream();
		
		apply_filters('revslider_get_parent_slides_pre', $lang, $published, $gal_ids, $this);
		
		if($post){
			$parent_slides = $this->get_slides_from_posts($published, $gal_ids, $lang);
		}elseif($stream !== false){
			$parent_slides = $this->get_slides_from_stream($published);
		}else{
			$parent_slides = $this->get_slides($published);
		}
		
		apply_filters('revslider_get_parent_slides_post', $parent_slides, $published, $gal_ids, $this);
		
		return $parent_slides;
	}
	
	
	/**
	 * get array of slider id -> title
	 * @before: RevSliderSlider::getArrSlidersShort();
	 */		
	public function get_sliders_short($exclude_id = null, $filter = 'all'){
		$sliders	= $this->get_sliders();
		$short		= array();
		if(!empty($sliders)){
			foreach($sliders as $slider){
				$id			= $slider->get_id();
				$from_post	= $slider->is_posts();
				
				//filter by gallery only
				if($filter == 'posts' && $from_post == false) 	 continue;
				if($filter == 'gallery' && $from_post == true) 	 continue;
				if($filter == 'template' && $from_post == false) continue; //filter by template type
				if(!empty($exclude_id) && $exclude_id == $id)	 continue; //filter by except
				
				$short[$id] = $slider->get_title();
			}
		}
		
		return $short;
	}
	
	
	/**
	 * get the maximum order
	 * @before: RevSliderSlider::getMaxOrder()
	 */
	public function get_max_order(){
		global $wpdb;
		
		$record = $wpdb->get_row($wpdb->prepare("SELECT slide_order FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDES ." WHERE slider_id = %d ORDER BY slide_order DESC LIMIT 0,1", $this->id), ARRAY_A);
		
		return (empty($record)) ? 0 : $this->get_val($record, 'slide_order');
	}
	
	
	/**
	 * get the slider type
	 */
	public function get_type(){
		$type		= 'gallery';
		$is_stream	= $this->is_stream();
		
		if($this->is_posts() == true){
			$type = (in_array($this->get_param('sourcetype', 'gallery'), array('woocommerce', 'woo'), true)) ? 'woocommerce' : 'posts';
			if($this->is_specific_posts()) $type = 'specific_posts';
		}elseif($is_stream !== false){
			$type = (in_array($is_stream, array('facebook', 'twitter', 'instagram', 'flickr', 'youtube', 'vimeo'))) ? $is_stream : $type;
		}
		
		return $type;
	}
	
	
	/**
	 * get the slider type before 60, needed for partial update proceess introduced in 6.0.0
	 * @since: 6.0.0
	 */
	public function get_type_pre60(){
		$type		= 'gallery';
		$is_stream	= $this->is_stream_pre60();
		
		if($this->is_posts_pre60() == true){
			$type = ($this->get_param('source_type', 'gallery') == 'woocommerce') ? 'woocommerce' : 'posts';
			
			if(in_array($this->get_param('sourcetype', 'gallery'), array('specific_posts', 'specific_post'), true)){
				$type = 'specific_posts';
			}
			
		}elseif($is_stream !== false){
			$type = (in_array($is_stream, array('facebook', 'twitter', 'instagram', 'flickr', 'youtube', 'vimeo'))) ? $is_stream : $type;
		}
		
		return $type;
	}
	
	
	/**
	 * copy slide from one Slider to the given Slider ID
	 * @since: 5.0
	 * @before: RevSliderSlider::copySlideToSlider()
	 */
	public function copy_slide_to_slider($data){
		global $wpdb;
		
		$slider_id		= intval($this->get_val($data, 'slider_id'));
		$slide_id		= intval($this->get_val($data, 'slide_id'));
		$add_to_slider	= $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." WHERE id = %s", $slider_id), ARRAY_A); //check if ID exists
		
		if(empty($add_to_slider))
			return __('Slide could not be duplicated', 'revslider');
		
		//get last slide in slider for the order
		$slide_order	= $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDES ." WHERE slider_id = %s ORDER BY slide_order DESC", $slider_id), ARRAY_A);
		$slide_to_copy	= $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDES ." WHERE id = %s", $slide_id), ARRAY_A);
		
		if(empty($slide_to_copy))
			return __('Slide could not be duplicated', 'revslider');
		
		unset($slide_to_copy['id']); //remove the ID of the Slide, as it will be a new Slide
		$slide_to_copy['slider_id']		= $slider_id; //set the new Slider ID to the Slide
		$slide_to_copy['slide_order']	= (empty($slide_order)) ? 1 : $this->get_val($slide_order, 'slide_order') + 1; //set the next slide order, to set slide to the end
		
		$response = $wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_SLIDES, $slide_to_copy);
		
		if($response){
			if($this->template_slider){
				$sl = new RevSliderSlider();
				$sl->init_by_id($slider_id);
				$params = $sl->get_params();
				$params['pakps'] = true;
				
				$sl->update_params($params, true);
			}
		}

		if(isset($slide_id) && $response !== false){
			$this->map[$slide_id] = $wpdb->insert_id;
		}
		
		return ($response === false) ? __('Slide could not be duplicated', 'revslider') : true;
	}

	/**
	 * get slider' static slide
	 * 
	 * @since: 6.4.6
	 * @return false | RevSliderSlide
	 */
	public function get_static_slide()
	{
		$slider_id = $this->get_id();
		if (empty($slider_id)) return false;
		
		if ($this->_static_slide instanceof RevSliderSlide && $this->_static_slide->get_slider_id() == $slider_id) 
			return $this->_static_slide;

		$slide = new RevSliderSlide();
		$is_init = $slide->init_static_slide_by_slider_id($slider_id);
		if (!$is_init) return false;
		
		$this->_static_slide = $slide;
		return $this->_static_slide;
	}
	
	
	/**
	 * get all used fonts in the current Slider
	 * @since: 5.1.0
	 * @before: RevSliderSlider::getUsedFonts();
	 */
	public function get_used_fonts($full = false){
		$gf			= array();
		$sl			= new RevSliderSlide();
		$mslides	= $this->get_slides(true);
		
		$static_slide = $this->get_static_slide();
		if($static_slide !== false){
			$mslides = array_merge($mslides, array($static_slide));
		}
		
		if(!empty($mslides)){
			foreach($mslides as $ms){
				$mf = $ms->get_used_fonts($full);
				
				if(!empty($mf)){
					foreach($mf as $mfk => $mfv){
						if(!isset($gf[$mfk])){
							$gf[$mfk] = $mfv;
						}else{
							foreach($mfv['variants'] as $mfvk => $mfvv){
								$gf[$mfk]['variants'][$mfvk] = true;
							}
						}
						$gf[$mfk]['slide'][] = array('id' => $ms->get_id(), 'title' => $ms->get_title());
					}
				}
			}
		}
		
		return apply_filters('revslider_getUsedFonts', $gf);
	}
	
	
	/**
	 * get slides from posts
	 * @before: RevSliderSlider::getSlidesFromPosts();
	 */
	public function get_slides_from_posts($published = false, $gal_ids = array(), $lang = 'all'){
		$templates = $this->get_slides($published);
		$templates = $this->assoc_to_array($templates);
		
		if(count($templates) == 0) return array();
		
		$source = (!empty($gal_ids)) ? 'specific_posts' : $this->get_param('sourcetype', 'gallery'); //change to specific posts, give the gal_ids to the list
		
		switch($source){
			case 'posts':
			case 'post':
				$subtype = $this->get_param(array('source', 'post', 'subType'), 'post');
				
				if($subtype === 'current_post'){
					global $post;
					$posts = $this->get_specific_posts(array('', $post->ID));
				}elseif(in_array($subtype, array('specific_posts', 'specific_post'), true)){
					$posts = $this->get_specific_posts($gal_ids);
				}else{
					//check where to get posts from
					switch($this->get_param(array('source', 'post', 'fetchType'), 'cat_type')){
						case 'cat_tag':
						default:
							$posts = $this->get_posts_by_categories($published);
						break;
						case 'related':
							$posts = $this->get_related_posts();
						break;
						case 'popular':
							$posts = $this->get_popular_posts();
						break;
						case 'recent':
							$posts = $this->get_latest_posts();
						break;
						case 'next_prev':
							$posts = $this->get_next_previous_post();
						break;
					}
				}
			break;
			/*case 'current_post':
				global $post;
				$posts = $this->get_specific_posts(array('', $post->ID));
			break;
			*/
			/*
			 * This needed to be uncommented for WP Gallery AddOn compatibility
			*/
			case 'specific_posts':
			case 'specific_post':
				$posts = $this->get_specific_posts($gal_ids);
			break;
			case 'woocommerce':
			case 'woo':
				$posts = $this->get_products_from_categories($published);
			break;
			default:
				$this->throw_error(__('This Source Type must be from posts.', 'revslider'));
			break;
		}
		
		$slides		= array();
		$key		= 0;
		$num_temp	= count($templates);
		
		if(!empty($posts)){
			foreach($posts as $post_data){
				$found = false;
				if($lang !== 'all' && $this->get_val($templates[$key], array('params', 'child', 'language'), 'all') !== $lang){
					$children = $templates[$key]->get_children();
					if(!empty($children)){
						foreach($children as $child){
							if($this->get_val($child, array('params', 'child', 'language'), 'all') === $lang){
								$template = clone $child;
								$found = true;
								break;
							}
						}
					}
				}
				
				if($found === false){
					$template = clone $templates[$key];
				}
				//advance the templates
				$key++;
				if($key == $num_temp){
					$key		= 0;
					$templates	= $this->get_slides($published); //reset as clone did not work properly
					$templates	= $this->assoc_to_array($templates);
				}

				$slide = new RevSliderSlide();
				$slide->init_by_post_data($post_data, $template, $this->id);
				
				$slides[] = $slide;
			}
		}
		
		$this->slides = $slides;
		
		return $this->slides;
	}
	
	
	/**
	 * get related posts from current one
	 * @since: 5.1.1
	 * @before: RevSliderSlider::getPostsFromRelated();
	 */
	public function get_related_posts(){
		$my_posts	= array();
		$tags		= '';
		$post_id	= get_the_ID();
		$sort_by	= $this->get_param(array('source', 'post', 'sortBy'), 'ID');
		$source		= $this->get_param('source');
		$post		= $this->get_val($source, 'post');
		$max_posts	= $this->get_val($post, 'maxPosts', 30);
		$max_posts	= (empty($max_posts) || !is_numeric($max_posts)) ? -1 :  $max_posts;
		$post_tags	= get_the_tags();
		
		if($post_tags){
			foreach($post_tags as $post_tag){
				$tags .= $post_tag->slug . ',';
			}
		}
		
		$query = array(
			'numberposts' => $max_posts,
			'exclude'	=> $post_id,
			'order'		=> $this->get_param(array('source', 'post', 'sortDirection'), 'DESC'),
			'tag'		=> $tags
		);

		$tax_query = $this->get_tax_query();
		if(!empty($tax_query)) $query['tax_query'] = $tax_query;
		
		if(strpos($sort_by, 'meta_num_') === 0){
			$query['orderby']	= 'meta_value_num';
			$query['meta_key']	= str_replace('meta_num_', '', $sort_by);
		}elseif(strpos($sort_by, 'meta_') === 0){
			$query['orderby']	= 'meta_value';
			$query['meta_key']	= str_replace('meta_', '', $sort_by);
		}else{
			$query['orderby']	= $sort_by;
		}

		$get_relateds		= apply_filters('revslider_get_related_posts', $query, $post_id);
		$tag_related_posts	= get_posts($get_relateds);
		
		if(count($tag_related_posts) < $max_posts){
			$ignore = array();
			foreach($tag_related_posts as $tag_related_post){
				$ignore[] = $tag_related_post->ID;
			}
			$article_categories = get_the_category($post_id);
			$category_string = '';
			foreach($article_categories as $category){
				$category_string .= $category->cat_ID . ',';
			}
			
			$max	= $max_posts - count($tag_related_posts);
			$excl	= implode(',', $ignore);
			$query	= array(
				'exclude'		=> $excl,
				'numberposts'	=> $max,
				'category'		=> $category_string
			);
			
			if(strpos($sort_by, 'meta_num_') === 0){
				$query['orderby']	= 'meta_value_num';
				$query['meta_key']	= str_replace('meta_num_', '', $sort_by);
			}else
			if(strpos($sort_by, 'meta_') === 0){
				$query['orderby']	= 'meta_value';
				$query['meta_key']	= str_replace('meta_', '', $sort_by);
			}else{
				$query['orderby']	= $sort_by;
			}
			
			$get_relateds		= apply_filters('revslider_get_related_posts', $query, $post_id);
			$cat_related_posts	= get_posts($get_relateds);
			$tag_related_posts	= $tag_related_posts + $cat_related_posts;
		}

		foreach($tag_related_posts as $post){
			$the_post = (method_exists($post, 'to_array')) ? $post->to_array() : (array)$post;
			if($the_post['ID'] == $post_id) continue;
			$my_posts[] = $the_post;
		}
		
		return $my_posts;
	}
	
	
	/**
	 * get popular posts
	 * @since: 5.1.1
	 * @before: RevSliderSlider::getPostsFromPopular();
	 * @moved: 6.1.3
	 */
	public function get_popular_posts($max_posts = false){
		$post_id	= get_the_ID();
		$my_posts	= array();
		
		if($max_posts == false){
			$source		= $this->get_param('source');
			$post		= $this->get_val($source, 'post');
			$max_posts	= $this->get_val($post, 'maxPosts', 30);
			$max_posts = (empty($max_posts) || !is_numeric($max_posts)) ? -1 : $max_posts;
		}else{
			$max_posts = intval($max_posts);
		}

		$args = array(
			'suppress_filters' => 0,
			'posts_per_page' => $max_posts,
			'post_type'	=> 'any',
			'meta_key'  => '_thumbnail_id',
			'orderby'   => 'comment_count',
			'order'     => 'DESC'
		);

		$tax_query = $this->get_tax_query();
		if(!empty($tax_query)) $args['tax_query'] = $tax_query;
		
		$args	= apply_filters('revslider_get_popular_posts', $args, $post_id);
		$posts	= get_posts($args);
		
		foreach($posts as $post){
			$my_posts[] = (method_exists($post, 'to_array')) ? $post->to_array() : (array)$post;
		}
		
		return $my_posts;
	}
	
	
	/**
	 * get recent posts
	 * @since: 5.1.1
	 * @before: RevSliderSlider::getPostsFromRecent()
	 * @moved: 6.1.3
	 */
	public function get_latest_posts($max_posts = false){
		$post_id	= get_the_ID();
		$my_posts	= array();
		$args		= array(
			'post_type' => 'any',
			'suppress_filters' => 0,
			'meta_key'	=> '_thumbnail_id',
			'orderby'	=> 'date',
			'order'		=> 'DESC'
		);
		
		if($max_posts == false){
			$source		= $this->get_val($this->params, 'source');
			$post		= $this->get_val($source, 'post');
			$max_posts	= $this->get_val($post, 'maxPosts', 30);
			$max_posts	= (empty($max_posts) || !is_numeric($max_posts)) ? -1 : $max_posts;
		}else{
			$max_posts = intval($max_posts);
		}
		
		$args['posts_per_page']	= $max_posts;
		
		$tax_query = $this->get_tax_query();
		if(!empty($tax_query)) $args['tax_query'] = $tax_query;

		$args	= apply_filters('revslider_get_latest_posts', $args, $post_id);
		$posts	= get_posts($args);
		
		if(!empty($posts)){
			foreach($posts as $post){
				$my_posts[] = (method_exists($post, 'to_array')) ? $post->to_array() : (array)$post;
			}
		}
		
		return $my_posts;
	}
	
	
	/**
	 * get recent posts
	 * @since: 5.1.1
	 * @before: RevSliderSlider::getPostsNextPrevious();
	 */
	public function get_next_previous_post(){
		$my_posts = array();
		
		$startup_next_post = get_next_post();
		if (!empty($startup_next_post)){
			$my_posts[] = (method_exists($startup_next_post, 'to_array')) ? $startup_next_post->to_array() : (array)$startup_next_post;
		}    
		$startup_previous_post = get_previous_post();
		if (!empty($startup_previous_post)){
			$my_posts[] =(method_exists($startup_previous_post, 'to_array')) ? $startup_previous_post->to_array() : (array)$startup_previous_post;
		}
		
		return $my_posts;
	}


	public function get_tax_query(){
		$cat_ids	= $this->get_param(array('source', 'post', 'category'));
		$data		= $this->get_tax_by_cat_id($cat_ids);
		$tax_query	= false;
		if(isset($data['tax']) && isset($data['tax']) && !empty($data['tax']) && !empty($data['cats'])){
			$cat_id = (strpos($data['cats'], ',') !== false) ? explode(',', $data['cats']) : array($data['cats']);
			$tax_query = array('relation' => 'OR');

			//add taxomonies to the query
			$taxonomies = (strpos($data['tax'], ',') !== false) ? explode(',', $data['tax']) : array($data['tax']);
			foreach($taxonomies as $taxomony){
				$tax_query[] = array(
					'taxonomy'	=> $taxomony,
					'field'		=> 'id',
					'terms'		=> $cat_id
				);			
			}
		}

		return $tax_query;
	}
	
	
	/**
	 * get slides from posts
	 * @before: RevSliderSlider::getSlidesFromStream();
	 */
	public function get_slides_from_stream($published = false){
		$templates = $this->get_slides($published);
		$templates = $this->assoc_to_array($templates);
		
		if(count($templates) == 0) return array();
		
		$posts		 = array();
		$_slides	 = array();
		$max_allowed = 999999;
		$sourcetype	 = $this->get_param('sourcetype', 'gallery');
		$additions	 = array();
		
		switch($sourcetype){
			case 'facebook':
				$facebook = RevSliderGlobals::instance()->get('RevSliderFacebook');
				$facebook->setTransientSec($this->get_param(array('source', 'facebook', 'transient'), '1200'));
				if($this->get_param(array('source', 'facebook', 'typeSource'), 'timeline') == 'album'){
					$posts = $facebook->get_photo_set_photos(
						$this->id,
						$this->get_param(array('source', 'facebook', 'appId')),
						$this->get_param(array('source', 'facebook', 'album')),
						$this->get_param(array('source', 'facebook', 'count'), 8)
					);
					$additions['fb_type']	 = 'album';
				}else{
					$posts = $facebook->get_photo_feed(
						$this->id,
						$this->get_param(array('source', 'facebook', 'appId')),
						$this->get_param(array('source', 'facebook', 'page_id')),
						$this->get_param(array('source', 'facebook', 'count'), 8)
					);
					$additions['fb_type'] = 'timeline';
				}
				
				$max_posts	 = $this->get_param(array('source', 'facebook', 'count'), '25');
				$max_allowed = 25;
			break;
			case 'twitter':
				$twitter	 = new RevSliderTwitter($this->get_param(array('source', 'twitter', 'consumerKey')), $this->get_param(array('source', 'twitter', 'consumerSecret')), $this->get_param(array('source', 'twitter', 'accessToken')), $this->get_param(array('source', 'twitter', 'accessSecret')), $this->get_param(array('source', 'twitter', 'transient'), '1200'));
				$posts		 = $twitter->get_public_photos($this->get_param(array('source', 'twitter', 'userId')), $this->get_param(array('source', 'twitter', 'includeRetweets')), $this->get_param(array('source', 'twitter', 'excludeReplies')), $this->get_param(array('source', 'twitter', 'count'), '500'), $this->get_param(array('source', 'twitter', 'imageOnly')));	
				$max_posts	 = $this->get_param(array('source', 'twitter', 'count'), '500');
				$max_allowed = 500;
				$additions['twitter_user']	= $this->get_param(array('source', 'twitter', 'userId'));
			break;
			case 'instagram':
				$instagram = RevSliderGlobals::instance()->get('RevSliderInstagram');
				$instagram->setTransientSec($this->get_param(array('source', 'instagram', 'transient'), '1200'));
				$posts = $instagram->get_public_photos($this->get_id(), $this->get_param(array('source', 'instagram', 'token')), $this->get_param(array('source', 'instagram', 'count'), '33'));
				$max_posts	 = $this->get_param(array('source', 'instagram', 'count'), '33');
				$profile = $instagram->get_user_profile($this->get_param(array('source', 'instagram', 'token')));
				$additions['instagram_user'] = isset($profile['username']) ? $profile['username'] : '';
				$max_allowed = 33;
			break;
			case 'flickr':
				$flickr = new RevSliderFlickr($this->get_param(array('source', 'flickr', 'apiKey')), $this->get_param(array('source', 'flickr', 'transient'), '1200'));
				switch($this->get_param(array('source', 'flickr', 'type'))){
					case 'publicphotos':
						$user_id = $flickr->get_user_from_url($this->get_param(array('source', 'flickr', 'userURL')));
						$posts	 = $flickr->get_public_photos($user_id, $this->get_param(array('source', 'flickr', 'count')));
					break;
					case 'gallery':
						$gallery_id	= $flickr->get_gallery_from_url($this->get_param(array('source', 'flickr', 'galleryURL')));
						$posts		= $flickr->get_gallery_photos($gallery_id, $this->get_param(array('source', 'flickr', 'count')));
					break;
					case 'group':
						$group_id	= $flickr->get_group_from_url($this->get_param(array('source', 'flickr', 'groupURL')));
						$posts		= $flickr->get_group_photos($group_id, $this->get_param(array('source', 'flickr', 'count')));
					break;
					case 'photosets':
						$posts = $flickr->get_photo_set_photos($this->get_param(array('source', 'flickr', 'photoSet')), $this->get_param(array('source', 'flickr', 'count')));
					break;
				}
				$max_posts = $this->get_param(array('source', 'flickr', 'count'), '99');
			break;
			case 'youtube':
				$channel_id	 = $this->get_param(array('source', 'youtube', 'channelId'));
				$youtube	 = new RevSliderYoutube($this->get_param(array('source', 'youtube', 'api')), $channel_id, $this->get_param(array('source', 'youtube', 'transient'), '1200'));
				if($this->get_param(array('source', 'youtube', 'typeSource')) == 'playlist'){
					$posts = $youtube->show_playlist_videos($this->get_param(array('source', 'youtube', 'playList')), $this->get_param(array('source', 'youtube', 'count')));
				}else{
					$posts = $youtube->show_channel_videos($this->get_param(array('source', 'youtube', 'count')));
				}
				
				$additions['yt_type'] = $this->get_param(array('source', 'youtube', 'typeSource'), 'channel');
				$max_posts	 = $this->get_param(array('source', 'youtube', 'count'), '25');
				$max_allowed = 50;
			break;
			case 'vimeo':
				$vimeo = new RevSliderVimeo($this->get_param(array('source', 'vimeo', 'transient'), '1200'));
				$vimeo_type = $this->get_param(array('source', 'vimeo', 'typeSource'));
				
				switch($vimeo_type){
					case 'user':
						$posts = $vimeo->get_vimeo_videos($vimeo_type, $this->get_param(array('source', 'vimeo', 'userName')));
					break;
					case 'channel':
						$posts = $vimeo->get_vimeo_videos($vimeo_type, $this->get_param(array('source', 'vimeo', 'channelName')));
					break;
					case 'group':
						$posts = $vimeo->get_vimeo_videos($vimeo_type, $this->get_param(array('source', 'vimeo', 'groupName')));
					break;
					case 'album':
						$posts = $vimeo->get_vimeo_videos($vimeo_type, $this->get_param(array('source', 'vimeo', 'albumId')));
					break;
					default:
					break;
				}
				
				$additions['vim_type'] = $this->get_param(array('source', 'vimeo', 'typeSource'), 'user');
				$max_posts	 = $this->get_param(array('source', 'vimeo', 'count'), '25');
				$max_allowed = 60;
			break;
			default:
				global $rs_preview_mode;
				if($rs_preview_mode){
					$admin = new RevSliderAdmin();
					$admin->ajax_response_error(__('Some Settings in Slider <strong>Source may not complete</strong>.<br>Please Complete All Settings in Slider Sources.', 'revslider'));
				}else{
					$this->throw_error(__('Sorry, this Social Stream cannot be displayed.', 'revslider'));
				}
			break;
		}
		
		if($max_posts < 0) $max_posts *= -1;
		
		$posts = apply_filters('revslider_pre_mod_stream_data', $posts, $sourcetype, $this->id);
		$posts = (is_string($posts) || is_bool($posts)) ? array() : $posts;
		
		while(count($posts) > $max_posts || count($posts) > $max_allowed){
			array_pop($posts);
		}
		
		$posts = apply_filters('revslider_post_mod_stream_data', $posts, $sourcetype, $this->id);
		
		if(empty($posts)){
			global $rs_preview_mode;
			if($rs_preview_mode){
				$admin = new RevSliderAdmin();
				$admin->ajax_response_error(__('Some Settings in Slider <strong>Source may not complete</strong>.<br>Please Complete All Settings in Slider Sources.', 'revslider'));
			}else{
				$this->throw_error(__('Sorry, this Social Stream cannot be displayed.', 'revslider'));
			}
		}
		
		$i = 0;
		$tk = 0;
		
		
		foreach($posts as $data){
			if(empty($data)) continue; //ignore empty entries, like from instagram
			
			$slide_template = $templates[$tk];
			
			//advance the templates
			$tk++;
			$tk = ($tk == count($templates)) ? 0 : $tk;
			$_slides[$i] = new RevSliderSlide();

			$_slides[$i]->init_by_stream_data($data, $slide_template, $this->id, $sourcetype, $additions);
			
			$i++;
		}
		
		$this->slides = $_slides;
		
		return $this->slides;
	}
	
	
	/**
	 * get posts from categories (by the slider params).
	 * @before: RevSliderSlider::getPostsFromCategories();
	 */
	private function get_posts_by_categories($published = false){
		$cat_ids	= $this->get_param(array('source', 'post', 'category'));
		$data		= $this->get_tax_by_cat_id($cat_ids);
		$post_types = $this->get_param(array('source', 'post', 'types'), 'post');
		$sort_by	= $this->get_param(array('source', 'post', 'sortBy'), 'ID');
		$sort_dir	= $this->get_param(array('source', 'post', 'sortDirection'), 'DESC');
		$sort_dir	= ($sort_by == 'menu_order') ? 'ASC' : $sort_dir;
		$source		= $this->get_param('source');
		$post		= $this->get_val($source, 'post');
		$max_posts	= $this->get_val($post, 'maxPosts', 30);
		$max_posts	= (empty($max_posts) || !is_numeric($max_posts)) ? -1 : $max_posts;
		$addition	= array();
		
		if($published == true){
			$addition['post_status'] = 'publish';
		}
		
		$slider_id	= $this->get_id();
		$post		= $this->get_posts_by_category($slider_id, $data['cats'], $sort_by, $sort_dir, $max_posts, $post_types, $data['tax'], $addition, 'post');
		
		return apply_filters('revslider_get_posts_by_categories', $post, $this);
	}
	
	
	/**
	 * get products from categories (by the slider params).
	 * @since: 5.1.0
	 * @before: RevSliderSlider::getProductsFromCategories();
	 */
	private function get_products_from_categories($published = false){
		$slider_id	= $this->get_id();
		$cat_ids	= $this->get_param(array('source', 'woo', 'category'));
		$data		= $this->get_tax_by_cat_id($cat_ids);
		$cat_ids	= $data['cats'];
		$taxonomies	= $data['tax'];
		$sort_by	= $this->get_param(array('source', 'woo', 'sortBy'), 'ID');
		$sort_dir	= $this->get_param(array('source', 'woo', 'sortDirection'), 'DESC');
		$sort_dir	= ($sort_by == 'menu_order') ? 'ASC' : $sort_dir;
		$max_posts	= $this->get_param(array('source', 'woo', 'maxProducts'), 30);
		$max_posts	= (empty($max_posts) || !is_numeric($max_posts)) ? -1 : $max_posts;
		$post_types	= $this->get_param(array('source', 'woo', 'types'), 'any');
		$addition	= array();
		$this->is_woocommerce = true;
		
		if($published == true){ //Events integration
			$addition['post_status'] = 'publish';
		}
		
		$addition = array_merge($addition, RevSliderWooCommerce::get_meta_query($this->get_params()));

		return $this->get_posts_by_category($slider_id, $cat_ids, $sort_by, $sort_dir, $max_posts, $post_types, $taxonomies, $addition);
	}
	
	
	/**
	 * get setting - start with slide
	 * @before: RevSliderSlider::getStartWithSlideSetting();
	 */
	public function get_start_with_slide_setting(){
		$slide = $this->get_param(array('general', 'firstSlide', 'alternativeFirstSlide'), 1);
		if(is_numeric($slide)){
			$slide = (int)$slide - 1;
			if($slide < 0 || $slide >= count($this->slides)){
				$slide = 0;
			}
		}else{
			$slide = 0;
		}
		
		return $slide;
	}
	
	
	/**
	 * get the Slider Overview Structure
	 * @since: 6.0
	 */
	public function get_overview_data($slider = false, $slides = false, $slide_ids = false){
		//if we are pre 6.0.0, we have to create the data from the old data instead of the new format!
		
		$favorite	= RevSliderGlobals::instance()->get('RevSliderFavorite');
		$slider		= ($slider == false || $slider instanceof RevSliderFolder) ? $this : $slider;
		$post60		= (version_compare($slider->get_setting('version', '1.0.0'), '6.0.0', '<')) ? false : true;
		$id			= 0;
		$slides		= ($slides !== false) ? $slides :  $slider->get_slides();
		$type		= ($post60) ? $slider->get_type() : $this->get_type_pre60();
		$image		= '';
		$sid		= $slider->get_id();
		$do_ids		= ($slide_ids !== false) ? false : true;
		$addons_used = array();

		if(!empty($slides)){
			foreach($slides as $slide){
				$id		= $slide->get_id();
				$image	= ($post60) ? $slide->get_overview_image_attributes($type) : $slide->get_overview_image_attributes_pre60($type);
				break;
			}
			if($do_ids) $slide_ids = array();
			
			foreach($slides as $slide){
				if($do_ids) $slide_ids[] = $slide->get_id();

				$addons = $slide->get_param('addOns');
				if(!empty($addons)){
					foreach($addons as $addon => $values){
						if($this->_truefalse($this->get_val($values, 'enable', false)) === true){
							if(!in_array($addon, $addons_used)) $addons_used[] = $addon;
						}
					}
				}
			}
		}

		$addons = $slider->get_param('addOns');
		if(!empty($addons)){
			foreach($addons as $addon => $values){
				if($this->_truefalse($this->get_val($values, 'enable', false)) === true){
					if(!in_array($addon, $addons_used)) $addons_used[] = $addon;
				}
			}
		}

		return array(
			'id'		=> $sid,
			'slide_id'	=> $id,
			'slide_ids'	=> $slide_ids,
			'title'		=> esc_html($slider->get_title()),
			'alias'		=> $slider->get_alias(),
			'source'	=> esc_html($type),
			'type'		=> ($post60) ? $slider->get_param('type', 'standard') : $slider->get_param('slider-type', 'standard'),
			'size'		=> ($post60) ? $slider->get_param('layouttype') : $slider->get_param('slider_type', 'fullwidth'),
			'bg'		=> $image,
			'addons'	=> $addons_used,
			'premium'	=> $slider->get_param('pakps', false),
			'tags'		=> $this->get_tags(),
			'favorite'	=> $favorite->is_favorite('modules', $sid),
			'children'	=> ($slider instanceof RevSliderFolder) ? $slider->get_children() : array(),
			'folder'	=> $slider instanceof RevSliderFolder
		);
	}
	
	
	/**
	 * get posts from specific posts list
	 * @before: RevSliderSlider::getPostsFromSpecificList();
	 */
	public function get_specific_posts($gal_ids = array()){
		$is_gal		= false;
		$additional	= array();
		$slider_id	= $this->get_id();
		
		if(!empty($gal_ids) && $gal_ids[0] !== ''){
			$posts	= $gal_ids;
			$posts	= apply_filters('revslider_set_posts_list_gal', $posts, $this->get_id());
			$is_gal	= true;
		}else{
			if(isset($gal_ids[0])){
				unset($gal_ids[0]);
				$posts					= implode(',', $gal_ids);
				$additional['order']	= 'none';
				$additional['orderby']	= 'post__in';
			}else{
				$posts = $this->get_param(array('source', 'post', 'list'), '');	
				$additional['order'] = $this->get_param(array('source', 'post', 'sortDirection'), 'DESC');
				$additional['orderby'] = $this->get_param(array('source', 'post', 'sortBy'), '');
			}
			$posts = apply_filters('revslider_set_posts_list', $posts, $this->get_id());
		}
		
		return $this->get_posts_by_id($posts, $slider_id, $is_gal, $additional);
	}
	
	
	/**
	 * get posts by coma saparated posts
	 * @before: RevSliderFunctionsWP::getPostsByIDs();
	 */
	public function get_posts_by_id($ids, $slider_id, $is_gal, $additional = array()){
		$arr = (is_string($ids)) ? explode(',', $ids) : $ids;

		$query = array(
			'ignore_sticky_posts' => 1,
			'post_type'	=> 'any',
			'post__in'	=> $arr
		);
		if($is_gal){
			$query['post_status']	= 'inherit';
			$query['orderby']		= 'post__in';
		}
		
		$query	= array_merge($query, $additional);
		$query	= apply_filters('revslider_get_posts', $query, $slider_id);
		
		$object	= new WP_Query($query);
		$posts	= $object->posts;		

		foreach($posts as $key => $post){
			$posts[$key] = (method_exists($post, 'to_array')) ? $post->to_array() : (array)$post;
		}
		
		return $posts;
	}
	
	
	/**
	 * get posts by some category
	 * could be multiple
	 * @before: RevSliderFunctionsWP::getPostsByCategory()
	 */
	public function get_posts_by_category($slider_id, $cat_id, $sort_by = 'ID', $direction = 'DESC', $max_posts = -1, $post_types = 'any', $taxonomies = 'category', $addition = array(), $type = ''){
		$a = apply_filters('revslider_get_posts_by_category', array('slider_id' => $slider_id, 'cat_id' => $cat_id, 'sort_by' => $sort_by, 'direction' => $direction, 'max_posts' => $max_posts, 'post_types' => $post_types, 'taxonomies' => $taxonomies, 'addition' => $addition, 'type' => $type), $this);
		$slider_id	= $this->get_val($a, 'slider_id');
		$cat_id		= $this->get_val($a, 'cat_id');
		$sort_by	= $this->get_val($a, 'sort_by');
		$direction	= $this->get_val($a, 'direction');
		$max_posts	= $this->get_val($a, 'max_posts');
		$post_types	= $this->get_val($a, 'post_types');
		$taxonomies	= $this->get_val($a, 'taxonomies');
		$addition	= $this->get_val($a, 'addition');
		$type		= $this->get_val($a, 'type');
		$tax		= (!empty($taxonomies)) ? explode(',', $taxonomies) : array(); //get taxonomies array
		
		if(!is_array($post_types)){
			if(strpos($post_types, ',') !== false){
				$post_types = explode(',', $post_types);
				$post_types = (array_search('any', $post_types) !== false) ? 'any' : $post_types;
			}
		}
		$post_types	= (empty($post_types)) ? 'any' : $post_types;
		$cat_id		= (strpos($cat_id, ',') !== false) ? explode(',', $cat_id) : array($cat_id);
		
		$query		= array(
			'order'					=> $direction,
			'ignore_sticky_posts'	=> 1,
			'posts_per_page'		=> $max_posts,
			'showposts'				=> $max_posts,
			'post_type'				=> $post_types
		);		

		//add sort by (could be by meta)
		if(strpos($sort_by, 'meta_num_') === 0){
			$query['orderby']	= 'meta_value_num';
			$query['meta_key']	= str_replace('meta_num_', '', $sort_by);
		}elseif(strpos($sort_by, 'meta_') === 0){
			$query['orderby']	= 'meta_value';
			$query['meta_key']	= str_replace('meta_', '', $sort_by);
		}else{
			$query['orderby']	= $sort_by;
		}
		
		if(!empty($taxonomies)){
			$tax_query = array('relation' => 'OR');
		
			//add taxomonies to the query
			$taxonomies = (strpos($taxonomies, ',') !== false) ? explode(',', $taxonomies) : array($taxonomies);
			foreach($taxonomies as $taxomony){
				$tax_query[] = array('taxonomy' => $taxomony, 'field' => 'id', 'terms' => $cat_id);			
			}

			$query['tax_query'] = $tax_query;
		}
		
		if(!empty($addition)){
			$tax_query = $this->get_val($addition, 'tax_query', array());
			if(!empty($tax_query)){
				if(!isset($query['tax_query'])) $query['tax_query'] = array();
				if(is_array($tax_query)){
					foreach($tax_query as $tk => $tv){
						if(is_numeric($tk)){
							$query['tax_query'][] = $tv;
						}else{
							$query['tax_query'][$tk] = $tv;
						}
					}
				}
				unset($addition['tax_query']);
			}
			$query = array_merge($query, $addition);
		}
		
		$query		= apply_filters('revslider_get_posts', $query, $slider_id);
		$full_posts	= new WP_Query($query);
		$posts		= $full_posts->posts;
		
		if($this->is_woocommerce) $posts = RevSliderWooCommerce::filter_products_by_price($posts, $this->get_params());

		if(!empty($posts)){
			foreach($posts as $key => $post){
				$arr_post = (method_exists($post, 'to_array')) ? $post->to_array() : (array)$post;
				$arr_post['categories'] = $this->get_post_categories($post, $tax);
				
				$posts[$key] = $arr_post;
			}
		}
		
		return $posts;
	}
	
	
	/**
	 * get post categories by post ID and taxonomies
	 * the post ID can be post object or array too
	 * @before: RevSliderFunctionsWP::getPostCategories()
	 */
	public function get_post_categories($post_id, $tax){
		if(!is_numeric($post_id)){
			$post_id = (array)$post_id;
			$post_id = $post_id['ID'];
		}
		$cats = wp_get_post_terms($post_id, $tax);
		
		return $this->class_to_array($cats);
	}
	
	
	/**
	 * get cats and taxanomies data from the category id's
	 * @before: RevSliderFunctionsWP::getCatAndTaxData()
	 */
	public function get_tax_by_cat_id($cat_ids){
		$ret	= array('tax' => '', 'cats' => '');
		$tax	= array();
		$cats	= '';
		$taxs	= '';
		
		if(is_string($cat_ids)){
			$cat_ids = trim($cat_ids);
			$cat_ids = (empty($cat_ids)) ? array() : explode(',', $cat_ids);
		}
		
		if(!empty($cat_ids)){
			foreach($cat_ids as $cat){
				if(strpos($cat, 'option_disabled') === 0) continue;
				
				$pos = strrpos($cat, '_');
				if($pos === false) $this->throw_error(__('Wrong category format', 'revslider'));
				
				$tax_name		= substr($cat, 0, $pos);
				$tax[$tax_name]	= $tax_name;
				$cats			.= (!empty($cats)) ? ',' : '';
				$cats			.= substr($cat, $pos + 1, strlen($cat) - $pos - 1); //category id
			}
			
			$ret['cats'] = $cats;
		}
		
		if(!empty($tax)){
			foreach($tax as $tax_name){
				$taxs .= (!empty($taxs)) ? ','.$tax_name : $tax_name;
			}
		}
		$ret['tax'] = $taxs;
		
		return $ret;
	}
	
	/**
	 * check for global settings lazy load and modify slider settings
	 * only do these changes on outputting the slider
	 * @since: 6.4.12
	 **/
	public function modify_by_global_settings(){
		global $rs_preview_mode;
		if(is_admin() && !$rs_preview_mode) return true;
		
		$gs = $this->get_global_settings();
		$loazyload = $this->get_val($this->params, array('general', 'lazyLoad'), 'none');
		if($loazyload === 'none'){
			$forceLazyLoading = $this->get_val($gs, 'forceLazyLoading', 'smart');
			$this->set_val($this->params, array('general', 'lazyLoad'), $forceLazyLoading);
		}
		
		$forceViewport = $this->get_val($gs, 'forceViewport', true);
		$forceViewportDist = $this->get_val($gs, 'forcedViewportDistance', '-200px');
		$this->set_val($this->params, array('general', 'slideshow', 'globalViewPort'), $forceViewport);
		$this->set_val($this->params, array('general', 'slideshow', 'globalViewDist'), $forceViewportDist);
	}
	
	/**
	 * convert assoc array to array
	 * @before: RevSliderFunctions::assocToArray();
	 */
	public static function assoc_to_array($assoc){
		$arr = array();
		foreach($assoc as $item)
			$arr[] = $item;
		
		return $arr;
	}
}
