<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */
 
if(!defined('ABSPATH')) exit();

class RevSliderSliderImport extends RevSliderSlider {
	private $old_slider_id;
	private $real_slider_id;
	private $remove_path;
	private $download_path;
	private $import_zip;
	private $exists;
	private $slider_raw_data;
	private $slider_data;
	private $slides_data;
	private $import_statics;
	private $imported;
	private $is_template;
	private $navigation_map;
	public $slider_id;

	public function __construct(){
		parent::__construct();
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		
		$this->old_slider_id	= '';
		$this->real_slider_id	= '';
		$upload_dir				= wp_upload_dir();
		$this->remove_path		= $upload_dir['basedir'].'/rstemp/';
		$this->download_path	= $this->remove_path;
		$this->slider_id		= $this->get_post_var('sliderid');
		$this->import_zip		= false;
		$this->exists			= !empty($this->slider_id);
		$this->imported			= array();
		$this->slider_data		= array();
		$this->slides_data		= array();
		$this->navigation_map	= array();
	}
	
	/**
	 * return the old Slider ID
	 * @return int
	 **/
	public function get_old_slider_id(){
		return $this->old_slider_id;
	}
	
	/**
	 * import slider from multipart form
	 * @since: 5.3.1:	$updateStatic is deprecated
	 * @since: 6.0:		$updateStatic is now removed (was second parameter)
	 * @before: RevSliderSlider::importSliderFromPost();
	 */
	public function import_slider($update_animation = true, $exact_filepath = false, $is_template = false, $single_slide = false, $update_navigation = true, $install = true){
		global $wp_filesystem;
		WP_Filesystem();
		
		try{
			if($this->exists){
				$this->init_by_id($this->slider_id);
			}else{
				$exec = $this->unzip_slider($exact_filepath);
				if($exec !== true) return $exec;
			}
			
			$this->is_template = $is_template;
			
			//read all files needed
			$error = $this->check_template();
			
			if(is_array($error)) return $error;
			
			$this->set_slider_data_raw();
			$this->set_animations();
			$this->set_dynamic_css_v5(); //used prior 6.0 exports
			$this->set_dynamic_css_v6(); //used since 6.0 exports
			
			$this->set_navigations($update_navigation);
			
			$this->process_slider_raw_data();
			if($this->exists) $this->delete_all_slides(); //delete current slides
			
			$this->process_slide_data();
			$this->process_layer_data();
			
			$this->process_static_slide_data();
			
			//do the update routines
			$slider = new RevSliderSliderImport();
			$slider->init_by_id($this->slider_id);
			$upd = new RevSliderPluginUpdate();
			
			$upd->upgrade_slider_to_latest($slider);
			//RevSliderPluginUpdate::upgrade_slider_to_latest($slider);
			
			//reinit because we just updated data which is outside of the $slider object
			$slider = new RevSliderSliderImport();
			$slider->init_by_id($this->slider_id);
			
			$slider->update_css_and_javascript_ids($this->old_slider_id, $this->slider_id, $this->map);
			$slider->update_color_ids($this->map);
			
			//$slider->update_modal_ids($slider_ids, $slides_ids);
			
			$this->real_slider_id = $this->slider_id;
			
			if($install){
				$duplicate = $this->duplicate_template_slider($single_slide);
				if(is_array($duplicate)) return $duplicate; //error
			}
			
			$wp_filesystem->delete($this->remove_path, true);
			
		}catch(Exception $e){
			if(isset($this->remove_path)){
				$wp_filesystem->delete($this->remove_path, true);
			}
			
			return array('success' => false, 'error' => $e->getMessage(), 'sliderID' => $this->slider_id);
		}
		
		do_action('revslider_slider_imported', $this->real_slider_id);
		
		return array(
			'success' => true,
			'sliderID' => $this->real_slider_id,
			'map' => array(
				'slider' => array(
					'zip_to_template' => array($this->old_slider_id => $this->slider_id), //zip id to template id
					'zip_to_duplication' => array($this->old_slider_id => $this->real_slider_id) //template id to duplication id
				),
				'slides' => $this->map
			)
		);
	}
	
	
	/**
	 * unzip an uploaded Slider
	 * @param mixed $exact_filepath
	 * @throws Exception
	 * @return mixed
	 */
	private function unzip_slider($exact_filepath = false){
		if($exact_filepath !== false){
			$path = $exact_filepath;
		}else{
			$import_file = $this->get_val($_FILES, 'import_file');
			$error		 = $this->get_val($import_file, 'error');
			switch($error){
				case UPLOAD_ERR_NO_FILE:
					$this->throw_error(__('No file sent.', 'revslider'));
					break;
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					$this->throw_error(__('Exceeded filesize limit.', 'revslider'));
					break;
				default:
				break;
			}
			$path = $this->get_val($import_file, 'tmp_name');
		}
		
		if(isset($path['error'])){
			$this->throw_error($path['error']);
		}
		
		if(file_exists($path) == false)
			$this->throw_error(__('Import file not found', 'revslider'));
		
		WP_Filesystem();
		global $wp_filesystem;
		
		$file = unzip_file($path, $this->download_path);
		
		if(is_wp_error($file)){
			@define('FS_METHOD', 'direct'); //lets try direct.
			WP_Filesystem();  //WP_Filesystem() needs to be called again since now we use direct!
			
			$file = unzip_file($path, $this->download_path);
			if(is_wp_error($file)){
				$this->download_path = RS_PLUGIN_PATH.'rstemp/';
				$this->remove_path	 = $this->download_path;
				$file				 = unzip_file($path, $this->download_path);
				
				if(is_wp_error($file)){
					$file_basename		 = basename($path);
					$this->download_path = str_replace($file_basename, '', $path);
					$file				 = unzip_file($path, $this->download_path);
				}
			}
		}
		
		$unzipped_data = $file;
		
		if(!is_wp_error($unzipped_data)){
			$this->import_zip = true;
			return true;
		}else{
			$wp_filesystem->delete($this->remove_path, true);
			return array('success' => false, 'error' => $unzipped_data->get_error_message());
		}
	}
	
	
	/**
	 * set the Slider data in raw from the slider_export.txt
	 **/
	public function set_slider_data_raw(){
		global $wp_filesystem;
		$this->slider_raw_data = ($wp_filesystem->exists($this->download_path.'slider_export.txt')) ? $wp_filesystem->get_contents($this->download_path.'slider_export.txt') : '';
		if($this->slider_raw_data == ''){
			$dirs = scandir($this->download_path);
			if(!empty($dirs)){
				foreach($dirs as $dir){				
					if($dir !== '.' && $dir !== '..' && is_dir($this->download_path . $dir)){
						$dir = $this->download_path . $dir . '/';
						$this->slider_raw_data = ($wp_filesystem->exists($dir.'slider_export.txt')) ? $wp_filesystem->get_contents($dir.'slider_export.txt') : '';
						if($this->slider_raw_data != '') {
							$this->download_path = $dir;
							break;
						}
					}
				}
			}
			if($this->slider_raw_data == '') $this->throw_error(__('slider_export.txt does not exist!', 'revslider'));
		}
	}
	
	
	/**
	 * set the Slider animations from custom_animations.txt and add/update them if needed in the database
	 **/
	public function set_animations(){
		global $wp_filesystem, $wpdb;
		
		$animations		 = ($wp_filesystem->exists($this->download_path.'custom_animations.txt')) ? $wp_filesystem->get_contents($this->download_path.'custom_animations.txt') : '';
		$json_animations = @json_decode($animations, true);
		$animations		 = (empty($json_animations)) ? $this->rs_unserialize($animations) : $json_animations;
		if(empty($animations)) return;

		foreach($animations as $animation){
			$exist = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix . RevSliderFront::TABLE_LAYER_ANIMATIONS." WHERE handle = %s", $animation['handle']), ARRAY_A);
			if(!empty($exist)){ //update the animation, get the ID
				$animation_id = $exist['id'];
			}else{ //insert the animation, get the ID
				//check if we are v5 or v6+
				$an = array(
					'handle' => $this->get_val($animation, 'handle'),
					'params' => stripslashes(json_encode(str_replace("'", '"', $this->get_val($animation, 'params'))))
				);

				if(in_array($this->get_val($animation, 'settings'), array('in', 'out'))){
					$an['settings'] = $this->get_val($animation, 'settings');
				}

				$wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_LAYER_ANIMATIONS, $an);

				$animation_id = $wpdb->insert_id;

				//and set the current customin-oldID and customout-oldID in slider raw data to the new ID from the animation
			}

			$this->slider_raw_data = str_replace(array('customin-'.$animation['id'].'"', 'customout-'.$animation['id'].'"'), array('customin-'.$animation_id.'"', 'customout-'.$animation_id.'"'), $this->slider_raw_data);
		}
	}

	
	/**
	 * set the Slider dynamic css from dynamic-captions.txt and add/update them if needed in the database
	 * @used if we import a slider below 6.0, as here we still have the dynamic-captions.css. on 6.0 it is replaces with a styles.txt
	 **/
	public function set_dynamic_css_v5(){
		global $wp_filesystem, $wpdb;
		
		$dynamic	= ($wp_filesystem->exists($this->download_path.'dynamic-captions.css')) ? $wp_filesystem->get_contents($this->download_path.'dynamic-captions.css') : '';
		$css_class	= RevSliderGlobals::instance()->get('RevSliderCssParser');
		
		//parse css to classes
		$css = $css_class->css_to_array($dynamic);
		if(is_array($css) && $css !== false && count($css) > 0){
			foreach($css as $class => $styles){
				//check if static style or dynamic style
				$class = trim($class);
				
				if(strpos($class, ',') !== false && strpos($class, '.tp-caption') !== false){ //we have something like .tp-caption.redclass, .redclass
					$class_t = explode(',', $class);
					foreach($class_t as $cl){
						if(strpos($cl, '.tp-caption') !== false) $class = $cl;
					}
				}
				
				if((strpos($class, ':hover') === false && strpos($class, ':') !== false) || //before, after
					strpos($class, ' ') !== false || // .tp-caption.imageclass img or .tp-caption .imageclass or .tp-caption.imageclass .img
					strpos($class, '.tp-caption') === false || // everything that is not tp-caption
					(strpos($class, '.') === false || strpos($class, "#") !== false) || // no class -> #ID or img
					strpos($class, '>') !== false){ //.tp-caption>.imageclass or .tp-caption.imageclass>img or .tp-caption.imageclass .img
					continue;
				}
				
				//is a dynamic style
				if(strpos($class, ':hover') !== false){
					$class = trim(str_replace(':hover', '', $class));
					$insert = array(
						'hover'		=> json_encode($styles),
						'settings'	=> json_encode(array('hover' => 'true'))
					);
				}else{
					$insert = array(
						'params'	=> json_encode($styles),
						'settings'	=> ''
					);
				}
				
				//check if class exists
				$result = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix . RevSliderFront::TABLE_CSS." WHERE handle = %s", $class), ARRAY_A);
				
				if(!empty($result)){ //update
					$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_CSS, $insert, array('handle' => $class));
				}else{ //insert
					$insert['handle'] = $class;
					$wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_CSS, $insert);
				}
			}
		}
	}
	
	
	/**
	 * set the Slider dynamic css from styles.txt and add/update them if needed in the database
	 **/
	public function set_dynamic_css_v6(){
		global $wp_filesystem, $wpdb;
		
		$styles = ($wp_filesystem->exists($this->download_path.'styles.txt')) ? $wp_filesystem->get_contents($this->download_path.'styles.txt') : '';
		$json_styles = @json_decode($styles, true);
		$styles		 = (empty($json_styles)) ? $this->rs_unserialize($styles) : $json_styles;
		
		if(!empty($styles)){
			foreach($styles as $style){
				foreach($style as $v => $s){
					if(is_array($s) || is_object($s)){
						$style[$v] = json_encode($s);
					}
				}
				
				$exist = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix . RevSliderFront::TABLE_CSS." WHERE handle = %s", $this->get_val($style, 'handle')), ARRAY_A);
				if(!empty($exist)){
					$rh = $this->get_val($style, 'handle');
					unset($style['handle']);
					$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_CSS, $style, array('handle' => $rh));
				}else{
					$wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_CSS, $style);
				}
			}
		}
	}


	/**
	 * set the Slider navigatons from navigation.txt and add/update them if needed in the database
	 * @param bool $update_navigation
	 */
	public function set_navigations($update_navigation){
		global $wp_filesystem, $wpdb;
		$upd = new RevSliderPluginUpdate();
		
		$navigations		= ($wp_filesystem->exists($this->download_path.'navigation.txt')) ? $wp_filesystem->get_contents($this->download_path.'navigation.txt') : '';
		$json_navigations	= @json_decode($navigations, true);
		$navigations		= (empty($json_navigations)) ? $this->rs_unserialize($navigations) : $json_navigations;
		
		if(!empty($navigations)){
			foreach($navigations as $navigation){
				$_navigations[] = $navigation;
				
				if(!isset($navigation['type'])){ //translate navigations to v6 if they are v5
					$_navigations = array();
					$navigation['css'] = json_decode($navigation['css'], true);
					$navigation['markup'] = json_decode($navigation['markup'], true);
					$navigation['settings'] = json_decode($navigation['settings'], true);
					
					foreach($upd->navtypes as $navtype){
						if(isset($navigation['css'][$navtype]) && !empty($navigation['css'][$navtype]) || isset($navigation['markup'][$navtype]) && !empty($navigation['markup'][$navtype])){
							$_navigations[] = $upd->create_new_navigation_6_0($navigation, $navtype);
						}
					}
				}
				
				if(!empty($_navigations)){
					foreach($_navigations as $_navigation){
						$exist = $wpdb->get_row($wpdb->prepare("SELECT id FROM ".$wpdb->prefix . RevSliderFront::TABLE_NAVIGATIONS." WHERE handle = %s AND type = %s", array($this->get_val($_navigation, 'handle'), $this->get_val($_navigation, 'type'))), ARRAY_A);
						
						$old_nav_id = $this->get_val($_navigation, 'id', false);
						
						if($old_nav_id !== false){
							unset($_navigation['id']);
						}
						
						foreach($_navigation as $v => $s){
							if(is_array($s) || is_object($s)){
								$_navigation[$v] = json_encode($s);
							}
						}
						
						$rh = $_navigation['handle'];
						$rt = $_navigation['type'];
						if(!empty($exist)){ //create new navigation, get the ID
							if($update_navigation){ //overwrite navigation if exists
								unset($_navigation['handle']);
								$upd = $wpdb->update($wpdb->prefix . RevSliderFront::TABLE_NAVIGATIONS, $_navigation, array('handle' => $rh, 'type' => $rt));
								
								$insert_id = $this->get_val($exist, 'id', $wpdb->insert_id);
							}else{
								//insert with new handle
								$_navigation['handle'] = $_navigation['handle'].'-'.date('is');
								$_navigation['name'] = $_navigation['name'].'-'.date('is');
								//for prior to version 6.0 sliders, the next line needs to stay
								$this->slider_raw_data	= str_replace($rh.'"', $_navigation['handle'].'"', $this->slider_raw_data);
								//for prior to version 6.0 sliders end
								$_navigation['css'] = str_replace('.'.$rh, '.'.$_navigation['handle'], $_navigation['css']); //change css class to the correct new class
								$wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_NAVIGATIONS, $_navigation);
								$insert_id = $wpdb->insert_id;
							}
						}else{
							$wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_NAVIGATIONS, $_navigation);
							$insert_id = $wpdb->insert_id;
						}
						
						if($old_nav_id !== false){
							$this->navigation_map[$old_nav_id] = $insert_id;
						}
					}
				}
			}
		}
	}
	
	
	/**
	 * check if the slider is a template slider and if so, check further if uid is correct
	 **/
	public function check_template(){
		global $wp_filesystem;
		
		$uid_check = ($wp_filesystem->exists($this->download_path.'info.cfg')) ? $wp_filesystem->get_contents($this->download_path.'info.cfg') : '';
		
		if($this->is_template !== false){
			if($uid_check != $this->is_template){
				return array('success' => false, 'error' => __('Please select the correct zip file, checksum failed!', 'revslider'));
			}
		}else{ //someone imported a template base Slider, check if it is existing in Base Sliders, if yes, check if it was imported
			if($uid_check !== ''){
				$tmpl		 = new RevSliderTemplate();
				$tmpl_slider = $tmpl->get_tp_template_sliders();
				
				if(!empty($tmpl_slider)){
					foreach($tmpl_slider as $tp_slider){
						if(!isset($tp_slider['installed'])) continue;
						if($tp_slider['uid'] == $uid_check){
							$this->is_template = $uid_check;
							break;
						}
					}
				}
			}
		}
		
		return false;
	}
	
	
	/**
	 * initialize the raw data and turn it into a Slider
	 **/
	public function process_slider_raw_data(){
		$this->slider_data = @json_decode($this->slider_raw_data, true);
		if(empty($this->slider_data)){ //pre 6.0 Slider
			$this->slider_raw_data	= preg_replace_callback('!s:(\d+):"(.*?)";!', array('RevSliderSliderImport', 'clear_error_in_string') , $this->slider_raw_data); //clear errors in string
			$this->slider_data		= $this->rs_unserialize($this->slider_raw_data);
			$this->process_slider_raw_data_pre_6();
		}else{
			$this->process_slider_raw_data_post_6();
		}
	}
	
	
	/**
	 * process the Slider Data from Sliders that were exported before version 6.0
	 **/
	public function process_slider_raw_data_pre_6(){
		global $wpdb, $wp_filesystem;
		
		if(empty($this->slider_data)){
			$wp_filesystem->delete($this->remove_path, true);
			$this->throw_error(__('Wrong export slider file format! Please make sure that the uploaded file is either a zip file with a correct slider_export.txt in the root of it or an valid slider_export.txt file.', 'revslider'));
		}
		
		//update slider params
		$params = $this->get_val($this->slider_data, 'params');
		if($this->exists){
			$params['title'] = $this->get_param('title');
			$params['alias'] = $this->get_param('alias');
			$params['shortcode'] = $this->get_param('shortcode');
		}
		
		if($this->get_val($params, 'background_image', false) !== false){
			$params['background_image'] = $this->check_file_in_zip($this->download_path, $params['background_image'], $this->get_param('alias'), $this->imported);
			$params['background_image'] = $this->get_image_url_from_path($params['background_image']);
		}

		$this->import_statics = true;
		if(isset($params['enable_static_layers'])){
			if($params['enable_static_layers'] == 'off') $this->import_statics = false;
			unset($params['enable_static_layers']);
		}
		
		//update slider or create new
		if($this->exists){
			$wpdb->update(
				$wpdb->prefix . RevSliderFront::TABLE_SLIDER,
				array('params' => json_encode($params)),
				array('id' => $this->slider_id)
			);
			
			$this->title = $this->get_val($params, 'title');
			$this->alias = $this->get_val($params, 'alias');
		}else{	//new slider
			//check if Slider with title and/or alias exists, if yes change both to stay unique
			$insert = array(
				'title'	=> $this->get_val($params, 'title', 'Slider1'),
				'alias'	=> $this->get_val($params, 'alias', 'slider1')	
			);
			
			if($this->is_template === false){ //we want to stay at the given alias if we are a template
				$talias = $insert['alias'];
				$ttitle = $insert['title'];
				$ti = 1;
				while($this->alias_exists($talias)){ //set a new alias and title if its existing in database
					$talias = $insert['alias'] . $ti;
					$ttitle = $insert['title'] . $ti;
					$ti++;
				}
				
				if($talias !== $insert['alias']){
					$params['title'] = $ttitle;
					$params['alias'] = $talias;
					$insert['title'] = $ttitle;
					$insert['alias'] = $talias;
				}
			}else{ //add that we are an template
				$params['uid']	= $this->is_template;
				$insert['title'] = $this->get_val($insert, 'title'); //.' Template';
				$insert['alias'] = $this->get_val($insert, 'alias'); //.'-template';
				$insert['type']	= 'template';
			}
			
			$insert['params'] = json_encode($params);
			
			$wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_SLIDER, $insert);
			$this->slider_id = $wpdb->insert_id;
			
			$this->title = $this->get_val($insert, 'title');
			$this->alias = $this->get_val($insert, 'alias');
		}
	}
	
	/**
	 * process the Slider Data from Sliders that were exported before version 6.0
	 **/
	public function process_slider_raw_data_post_6(){
		global $wpdb, $wp_filesystem;
		
		if(empty($this->slider_data)){
			$wp_filesystem->delete($this->remove_path, true);
			$this->throw_error(__('Wrong export slider file format! Please make sure that the uploaded file is either a zip file with a correct slider_export.txt in the root of it or an valid slider_export.txt file.', 'revslider'));
		}
		
		//update slider params
		$params = $this->get_val($this->slider_data, 'params');
		
		//check if we are a premium slider
		if($this->get_val($params, 'pakps', false) === true && $this->_truefalse(get_option('revslider-valid', 'false')) === false){
			$wp_filesystem->delete($this->remove_path, true);
			$this->throw_error(__('Please register your Slider Revolution plugin to import premium templates', 'revslider'));
		}

		$this->old_slider_id = $this->get_val($this->slider_data, 'id', '');
		$title = ($this->exists) ? $this->get_title() : $this->get_val($this->slider_data, 'title', 'Slider1');
		$alias = ($this->exists) ? $this->get_alias() : $this->get_val($this->slider_data, 'alias', 'slider1');
		$params['shortcode'] = ($this->exists) ? $this->get_shortcode() : $params['shortcode'];
		
		/**
		 * images/videos in Sliders:
		 * troubleshooting.alternateURL
		 * troubleshooting.alternateURLId remove
		 * layout.bg.useImage
		 * layout.bg.image
		 **/
		if(!isset($params['troubleshooting'])) $params['troubleshooting'] = array();
		if(!isset($params['layout'])) $params['layout'] = array();
		if(!isset($params['layout']['bg'])) $params['layout']['bg'] = array();
		
		//remove imageId if it is set
		if($this->get_val($params, array('layout', 'bg', 'imageId'), false) !== false) unset($params['layout']['bg']['imageId']);
		
		if($this->get_val($params, array('layout', 'bg', 'useImage'), false) !== false){
			$params['layout']['bg']['useImage'] = $this->check_file_in_zip($this->download_path, $this->get_val($params, array('layout', 'bg', 'useImage')), $alias, $this->imported);
			$params['layout']['bg']['useImage'] = $this->get_image_url_from_path($this->get_val($params, array('layout', 'bg', 'useImage')));
		}
		if($this->get_val($params, array('layout', 'bg', 'image'), false) !== false){
			$params['layout']['bg']['image'] = $this->check_file_in_zip($this->download_path, $this->get_val($params, array('layout', 'bg', 'image')), $alias, $this->imported);
			$params['layout']['bg']['image'] = $this->get_image_url_from_path($this->get_val($params, array('layout', 'bg', 'image')));
		}
		if($this->get_val($params, array('troubleshooting', 'alternateURL'), false) !== false){
			$params['troubleshooting']['alternateURL'] = $this->check_file_in_zip($this->download_path, $this->get_val($params, array('troubleshooting', 'alternateURL')), $alias, $this->imported);
			$params['troubleshooting']['alternateURL'] = $this->get_image_url_from_path($this->get_val($params, array('troubleshooting', 'alternateURL')));
		}
		
		if(isset($params['troubleshooting']['alternateURLId'])) unset($params['troubleshooting']['alternateURLId']);
		
		$this->import_statics = true;
		
		//remap the navigations
		if(!empty($this->navigation_map)){
			$arrows	 = $this->get_val($params, array('nav', 'arrows', 'style'), false);
			$bullets = $this->get_val($params, array('nav', 'bullets', 'style'), false);
			$thumbs	 = $this->get_val($params, array('nav', 'thumbs', 'style'), false);
			$tabs	 = $this->get_val($params, array('nav', 'tabs', 'style'), false);
			
			if(isset($this->navigation_map[$arrows]))	$this->set_val($params, array('nav', 'arrows', 'style'), $this->navigation_map[$arrows]);
			if(isset($this->navigation_map[$bullets]))	$this->set_val($params, array('nav', 'bullets', 'style'), $this->navigation_map[$bullets]);
			if(isset($this->navigation_map[$thumbs]))	$this->set_val($params, array('nav', 'thumbs', 'style'), $this->navigation_map[$thumbs]);
			if(isset($this->navigation_map[$tabs]))		$this->set_val($params, array('nav', 'tabs', 'style'), $this->navigation_map[$tabs]);
		}
		
		//update slider or create new
		if($this->exists){
			$wpdb->update(
				$wpdb->prefix . RevSliderFront::TABLE_SLIDER,
				array(
					'title'	 => $title,
					'alias'	 => $alias,
					'params' => json_encode($params)
				),
				array('id' => $this->slider_id)
			);
			
			$this->title = $title;
			$this->alias = $alias;
		}else{	//new slider
			//check if Slider with title and/or alias exists, if yes change both to stay unique
			$insert = array(
				'title'	=> $title,
				'alias'	=> $alias	
			);
			
			if($this->is_template === false){ //we want to stay at the given alias if we are a template
				$talias = $insert['alias'];
				$ttitle = $insert['title'];
				$ti = 1;
				while($this->alias_exists($talias)){ //set a new alias and title if its existing in database
					$talias = $insert['alias'] . $ti;
					$ttitle = $insert['title'] . $ti;
					$ti++;
				}
				
				if($talias !== $insert['alias']){
					$params['title'] = $ttitle;
					$params['alias'] = $talias;
					$insert['title'] = $ttitle;
					$insert['alias'] = $talias;
				}
			}else{ //add that we are an template
				$params['uid']	= $this->is_template;
				$insert['title'] = $this->get_val($insert, 'title').' Template';
				$insert['type']	= 'template';
			}
			
			$insert['settings'] = $this->get_val($this->slider_data, 'settings', array());
			if($this->get_val($insert, array('settings', 'version'), false) === false){
				$this->set_val($insert, array('settings', 'version'), $this->get_val($params, 'version', '1.0.0'));
			}
			
			$insert['settings'] = json_encode($insert['settings']);
			$insert['params'] = json_encode($params);
			
			$wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_SLIDER, $insert);
			$this->slider_id = $wpdb->insert_id;
			
			$this->title = $this->get_val($insert, 'title');
			$this->alias = $this->get_val($insert, 'alias');
		}
		
		//allow for updating the slider params
		$d = array('params' => $params, 'sliderParams' => $this->slider_data, 'imported' => $this->imported);
		$d = apply_filters('revslider_importSliderFromPost_modify_slider_data', $d, $this->download_path, $this);
		
		$params				= $d['params'];
		$this->slider_data	= $d['sliderParams'];
		$this->imported		= $d['imported'];
		$wpdb->update(
			$wpdb->prefix . RevSliderFront::TABLE_SLIDER,
			array(
				'params' => json_encode($params)
			),
			array('id' => $this->slider_id)
		);
	}
	
	
	/**
	 * process the slide data, mapping and layers
	 **/
	public function process_slide_data(){
		$this->slides_data = $this->get_val($this->slider_data, 'slides');
		if(empty($this->slides_data)) return false;
		
		foreach($this->slides_data as $slide_key => $slide){
			$params	= $this->get_val($slide, 'params');
			if(version_compare($this->get_val($params, 'version', '1.0.0'), '6.0.0', '<')){
				$this->process_slide_data_pre_6();
			}else{
				$this->process_slide_data_post_6();
			}
			break;
		}
	}
	
	
	/**
	 * process Slide data, mapping and layers of a pre 6.0 slide
	 **/
	public function process_slide_data_pre_6(){
		global $wpdb;

		if(empty($this->slides_data)) return false;

		$template = new RevSliderTemplate();
		foreach($this->slides_data as $slide_key => $slide){
			
			$params		= $this->get_val($slide, 'params');
			$layers		= $this->get_val($slide, 'layers');
			$settings	= $this->get_val($slide, 'settings', '');
			$alias		= $this->get_val($this->slider_data, 'alias');
			
			//convert params images:
			if($this->import_zip === true){ //we have a zip, check if exists
				//remove image_id as it is not needed in import
				if(isset($params['image_id'])) unset($params['image_id']);
				
				if(isset($params['image'])){
					$params['image'] = $this->check_file_in_zip($this->download_path, $params['image'], $alias, $this->imported);
					$params['image'] = $this->get_image_url_from_path($params['image']);
				}
				
				if(isset($params['background_image'])){
					$params['background_image'] = $this->check_file_in_zip($this->download_path, $params['background_image'], $alias, $this->imported);
					$params['background_image'] = $this->get_image_url_from_path($params['background_image']);
				}
				
				if(isset($params['slide_thumb'])){
					$params['slide_thumb'] = $this->check_file_in_zip($this->download_path, $params['slide_thumb'], $alias, $this->imported);
					$params['slide_thumb'] = $this->get_image_url_from_path($params['slide_thumb']);
				}
				//check if we are a template slider, if yes, use template slide image
				if($this->is_template !== false && empty($params['slide_thumb'])){
					$params['slide_thumb']		= $template->get_slide_image_by_uid($this->is_template, $slide_key);
					$params['thumb_for_admin']	= 'on';
				}
				
				if(isset($params['show_alternate_image'])){
					$params['show_alternate_image'] = $this->check_file_in_zip($this->download_path, $params['show_alternate_image'], $alias, $this->imported);
					$params['show_alternate_image'] = $this->get_image_url_from_path($params['show_alternate_image']);
				}
				
				if(isset($params['background_type']) && $params['background_type'] == 'html5'){
					if(isset($params['slide_bg_html_mpeg']) && $params['slide_bg_html_mpeg'] != ''){
						$params['slide_bg_html_mpeg'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $params['slide_bg_html_mpeg'], $alias, $this->imported, true));
					}
					if(isset($params['slide_bg_html_webm']) && $params['slide_bg_html_webm'] != ''){
						$params['slide_bg_html_webm'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $params['slide_bg_html_webm'], $alias, $this->imported, true));
					}
					if(isset($params['slide_bg_html_ogv'])  && $params['slide_bg_html_ogv'] != ''){
						$params['slide_bg_html_ogv'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $params['slide_bg_html_ogv'], $alias, $this->imported, true));
					}
				}
			}
			
			//convert layers images:
			if(!empty($layers)){
				foreach($layers as $layer_key => $layer){
					//import if exists in zip folder
					if($this->import_zip === true){ //we have a zip, check if exists
						if(isset($layer['image_url'])){
							$layer['image_url'] = $this->check_file_in_zip($this->download_path, $layer['image_url'], $alias, $this->imported);
							$layer['image_url'] = $this->get_image_url_from_path($layer['image_url']);
						}
						if(isset($layer['bgimage_url'])){
							$layer['bgimage_url'] = $this->check_file_in_zip($this->download_path, $layer['bgimage_url'], $alias, $this->imported);
							$layer['bgimage_url'] = $this->get_image_url_from_path($layer['bgimage_url']);
						}
						if(isset($layer['type']) && ($layer['type'] == 'video' || $layer['type'] == 'audio')){
							$video_data = (isset($layer['video_data'])) ? (array) $layer['video_data'] : array();
							
							if(!empty($video_data) && isset($video_data['video_type']) && $video_data['video_type'] == 'html5'){
								if(isset($video_data['urlPoster']) && $video_data['urlPoster'] != ''){
									$video_data['urlPoster'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $video_data['urlPoster'], $alias, $this->imported));
								}
								if(isset($video_data['urlMp4']) && $video_data['urlMp4'] != ''){
									$video_data['urlMp4'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $video_data['urlMp4'], $alias, $this->imported, true));
								}
								if(isset($video_data['urlWebm']) && $video_data['urlWebm'] != ''){
									$video_data['urlWebm'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $video_data['urlWebm'], $alias, $this->imported, true));
								}
								if(isset($video_data['urlOgv']) && $video_data['urlOgv'] != ''){
									$video_data['urlOgv'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $video_data['urlOgv'], $alias, $this->imported, true));
								}
							}elseif(!empty($video_data) && isset($video_data['video_type']) && $video_data['video_type'] != 'html5'){ //video cover image
								if($video_data['video_type'] == 'audio'){
									if(isset($video_data['urlAudio']) && $video_data['urlAudio'] != ''){
										$video_data['urlAudio'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $video_data['urlAudio'], $alias, $this->imported, true));
									}
								}else{
									if(isset($video_data['previewimage']) && $video_data['previewimage'] != ''){
										$video_data['previewimage'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $video_data['previewimage'], $alias, $this->imported));
									}
								}
							}
							
							$layer['video_data'] = $video_data;
							
							if(isset($layer['video_image_url']) && $layer['video_image_url'] != ''){
								$layer['video_image_url'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $layer['video_image_url'], $alias, $this->imported));
							}
						}
						
						if(isset($layer['type']) && $layer['type'] == 'svg'){
							if(isset($layer['svg']) && isset($layer['svg']->src)){
								$layer['svg']->src = content_url().$layer['svg']->src;
							}
						}
					}
					
					$layer['text']		= stripslashes($this->get_val($layer, 'text'));
					$layers[$layer_key]	= $layer;
				}
			}
			
			$this->slides_data[$slide_key]['layers'] = $layers;
			
			$d = array('params' => $params, 'sliderParams' => $this->slider_data, 'layers' => $layers, 'settings' => $settings, 'imported' => $this->imported);
			$d = apply_filters('revslider_importSliderFromPost_modify_data', $d, 'normal', $this->download_path, $this);
			
			$params			= $d['params'];
			$this->slider_data = $d['sliderParams'];
			$layers			= $d['layers'];
			$settings		= $d['settings'];
			$this->imported	= $d['imported'];
			
			$my_layers		= json_encode($layers);
			$my_layers		= (empty($my_layers)) ? stripslashes(json_encode($layers)) : $my_layers;
			$my_params		= json_encode($params);
			$my_params		= (empty($my_params)) ? stripslashes(json_encode($params)) : $my_params;
			$my_settings	= json_encode($settings);
			$my_settings	= (empty($my_settings)) ? stripslashes(json_encode($settings)) : $my_settings;
			
			//create new slide
			$wpdb->insert(
				$wpdb->prefix . RevSliderFront::TABLE_SLIDES,
				array(
					'slider_id'	=> $this->slider_id,
					'slide_order' => $this->get_val($slide, 'slide_order'),
					'layers'	=> $my_layers,
					'params'	=> $my_params,
					'settings'	=> $my_settings
				)
			);
			
			if(isset($slide['id'])){
				$this->map[$slide['id']] = $wpdb->insert_id;
			}
		}
	}
	
	
	/**
	 * process Slide data, mapping and layers of a pre 6.0 slide
	 **/
	public function process_slide_data_post_6(){
		global $wpdb, $wp_filesystem;
		if(empty($this->slides_data)) return false;

		$template = new RevSliderTemplate();
		foreach($this->slides_data as $slide_key => $slide){
			$params		= $this->get_val($slide, 'params');
			$layers		= $this->get_val($slide, 'layers', array());
			$settings	= $this->get_val($slide, 'settings', '');
			$alias		= $this->get_val($this->slider_data, 'alias');
			
			//import videos/images
			if($this->import_zip === true){ //we have a zip, check if exists
				/**
				 * images/videos in slide:
				 * bg.image
				 * bg.imageId
				 * bg.mpeg
				 * bg.ogv
				 * bg.webm
				 * bg.videoId
				 * thumb.customThumbSrc
				 * thumb.customThumbSrcId
				 * thumb.customAdminThumbSrc
				 * thumb.customAdminThumbSrcId
				 **/
				//remove image_id as it is not needed in import
				if($this->get_val($params, array('bg', 'imageId'), false) !== false) unset($params['bg']['imageId']);
				//if($this->get_val($params, array('bg', 'videoId'), false) !== false) unset($params['bg']['videoId']); //TODO maybe not delete, depending on if this is a wordpress media library id (then yes) or not
				if($this->get_val($params, array('thumb', 'customThumbSrcId'), false) !== false) unset($params['thumb']['customThumbSrcId']);
				if($this->get_val($params, array('thumb', 'customAdminThumbSrcId'), false) !== false) unset($params['thumb']['customAdminThumbSrcId']);
				
				if($this->get_val($params, array('bg', 'image'), false) !== false){
					$params['bg']['image'] = $this->check_file_in_zip($this->download_path, $params['bg']['image'], $alias, $this->imported);
					$params['bg']['image'] = $this->get_image_url_from_path($params['bg']['image']);
					
					if(!empty($params['bg']['image'])){
						$imgid = $this->get_image_id_by_url($params['bg']['image']);
						if(!empty($imgid) && $imgid !== 0){
							$params['bg']['imageId'] = $imgid;
						}
					}
				}
				
				if($this->get_val($params, array('layout', 'bg', 'image'), false) !== false){
					$params['layout']['bg']['image'] = $this->check_file_in_zip($this->download_path, $this->get_val($params, array('layout', 'bg', 'image')), $alias, $this->imported);
					$params['layout']['bg']['image'] = $this->get_image_url_from_path($this->get_val($params, array('layout', 'bg', 'image')));
				}
				
				if($this->get_val($params, array('thumb', 'customThumbSrc'), false) !== false){
					$params['thumb']['customThumbSrc'] = $this->check_file_in_zip($this->download_path, $this->get_val($params, array('thumb', 'customThumbSrc')), $alias, $this->imported);
					$params['thumb']['customThumbSrc'] = $this->get_image_url_from_path($this->get_val($params, array('thumb', 'customThumbSrc')));
				}
				if($this->get_val($params, array('thumb', 'customAdminThumbSrc'), false) !== false){
					$params['thumb']['customAdminThumbSrc'] = $this->check_file_in_zip($this->download_path, $this->get_val($params, array('thumb', 'customAdminThumbSrc')), $alias, $this->imported);
					$params['thumb']['customAdminThumbSrc'] = $this->get_image_url_from_path($this->get_val($params, array('thumb', 'customAdminThumbSrc')));
				}
				
				//check if we are a template slider, if yes, use template slide image
				if($this->is_template !== false){
					if($this->get_val($params, array('thumb', 'customThumbSrc'), false) === false){
						if(!isset($params['thumb'])) $params['thumb'] = array();
						$params['thumb']['customThumbSrc'] = $template->get_slide_image_by_uid($this->is_template, $slide_key);
					}
					if($this->get_val($params, array('thumb', 'customAdminThumbSrc'), false) === false){
						if(!isset($params['thumb'])) $params['thumb'] = array();
						$params['thumb']['customAdminThumbSrc'] = $this->get_val($params, array('thumb', 'customThumbSrc'));
					}
				}
				
				if($this->get_val($params, array('troubleshooting', 'alternateURL'), false) !== false){
					$params['troubleshooting']['alternateURL'] = $this->check_file_in_zip($this->download_path, $this->get_val($params, array('troubleshooting', 'alternateURL')), $alias, $this->imported);
					$params['troubleshooting']['alternateURL'] = $this->get_image_url_from_path($this->get_val($params, array('troubleshooting', 'alternateURL')));
				}
				
				if($this->get_val($params, array('bg', 'type')) == 'html5'){
					if($this->get_val($params, array('bg', 'mpeg')) !== ''){
						$params['bg']['mpeg'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $this->get_val($params, array('bg', 'mpeg')), $alias, $this->imported, true));
					}
					if($this->get_val($params, array('bg', 'webm')) !== ''){
						$params['bg']['webm'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $this->get_val($params, array('bg', 'webm')), $alias, $this->imported, true));
					}
					if($this->get_val($params, array('bg', 'ogv')) !== ''){
						$params['bg']['ogv'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $this->get_val($params, array('bg', 'ogv')), $alias, $this->imported, true));
					}
				}
				
				$this->slides_data[$slide_key]['params'] = $params;
			}
			
			//convert layers images:
			if(!empty($layers)){
				/**
				 * media.imageUrl
				 * media.imageId
				 * media.posterUrl
				 * media.posterId
				 * media.audioUrl
				 * media.thumbs.veryBig
				 * media.thumbs.big
				 * media.thumbs.large
				 * media.thumbs.medium
				 * media.thumbs.small
				 * media.mp4Url
				 * media.ogvUrl
				 * media.webmUrl
				 * svg.source 
				 * idle.backgroundImage
				 * idle.backgroundImageId
				 **/
				foreach($layers as $layer_key => $layer){
					//import if exists in zip folder
					if($this->import_zip === true){ //we have a zip, check if exists
						$layer_type = $this->get_val($layer, 'type', 'text');
						
						if($this->get_val($layer, array('media', 'imageId'), false) !== false) unset($layer['media']['imageId']);
						if($this->get_val($layer, array('media', 'posterId'), false) !== false) unset($layer['media']['posterId']);
						if($this->get_val($layer, array('idle', 'backgroundImageId'), false) !== false) unset($layer['idle']['backgroundImageId']);
						
						$image_url	= $this->get_val($layer, array('media', 'imageUrl'), false);
						$bg_image	= $this->get_val($layer, array('idle', 'backgroundImage'), false);
						$very_big	= $this->get_val($layer, array('media', 'thumbs', 'veryBig'), false);
						$big		= $this->get_val($layer, array('media', 'thumbs', 'big'), false);
						$large		= $this->get_val($layer, array('media', 'thumbs', 'large'), false);
						$medium		= $this->get_val($layer, array('media', 'thumbs', 'medium'), false);
						$small		= $this->get_val($layer, array('media', 'thumbs', 'small'), false);
						
						$very_big	= (is_array($very_big) && isset($very_big['url'])) ? $very_big['url'] : $very_big;
						$big		= (is_array($big) && isset($big['url'])) ? $big['url'] : $big;
						$large		= (is_array($large) && isset($large['url'])) ? $large['url'] : $large;
						$medium		= (is_array($medium) && isset($medium['url'])) ? $medium['url'] : $medium;
						$small		= (is_array($small) && isset($small['url'])) ? $small['url'] : $small;
						
						if($image_url !== false)$layer['media']['imageUrl']			 = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $image_url, $alias, $this->imported));
						if($bg_image !== false) $layer['idle']['backgroundImage']	 = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $bg_image, $alias, $this->imported));
						if($very_big !== false) $layer['media']['thumbs']['veryBig'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $very_big, $alias, $this->imported));
						if($big !== false)		$layer['media']['thumbs']['big']	 = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $big, $alias, $this->imported));
						if($large !== false)	$layer['media']['thumbs']['large']	 = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $large, $alias, $this->imported));
						if($medium !== false)	$layer['media']['thumbs']['medium']	 = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $medium, $alias, $this->imported));
						if($small !== false)	$layer['media']['thumbs']['small']	 = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $small, $alias, $this->imported));
						
						if(!empty($layer['media']['imageUrl'])){
							$imgid = $this->get_image_id_by_url($layer['media']['imageUrl']);
							if(!empty($imgid) && $imgid !== 0){
								$layer['media']['imageId'] = $imgid;
							}
						}
						if(!empty($layer['idle']['backgroundImage'])){
							$imgid = $this->get_image_id_by_url($layer['idle']['backgroundImage']);
							if(!empty($imgid) && $imgid !== 0){
								$layer['idle']['backgroundImageId'] = $imgid;
							}
						}
						
						if(in_array($layer_type, array('video', 'audio'))){
							$media_type = $this->get_val($layer, array('media', 'mediaType'));
							if($media_type == 'html5'){
								$mp4	= $this->get_val($layer, array('media', 'mp4Url'), '');
								$webm	= $this->get_val($layer, array('media', 'webmUrl'), '');
								$ogv	= $this->get_val($layer, array('media', 'ogvUrl'), '');
								
								if($mp4 !== '')	 $layer['media']['mp4Url'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $mp4, $alias, $this->imported, true));
								if($webm !== '') $layer['media']['webmUrl'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $webm, $alias, $this->imported, true));
								if($ogv !== '')	 $layer['media']['ogvUrl'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, ogv, $alias, $this->imported, true));
							}elseif($media_type == 'audio'){ //video cover image
								$audio = $this->get_val($layer, array('media', 'audioUrl'));
								if($audio !== '') $layer['media']['audioUrl'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $audio, $alias, $this->imported, true));
							}
							
							if($this->get_val($layer, array('media', 'posterUrl'), '') !== ''){
								$layer['media']['posterUrl'] = $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $this->get_val($layer, array('media', 'posterUrl'), ''), $alias, $this->imported));
							}
						}
						
						if($layer_type == 'svg'){
							$svg = $this->get_val($layer, array('svg', 'source'), '');
							
							//check if we need to import it, if its available in the zip file
							$zimage	= $wp_filesystem->exists($this->download_path.'images/'.$svg);
							if(!$zimage) $zimage = $wp_filesystem->exists(str_replace('//', '/', $this->download_path.'images/'.$svg));
							$svgurl = ($zimage === true) ? $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $svg, $alias, $this->imported, true)) : content_url().$svg;
							
							if(!empty($svg)) $layer['svg']['source'] = $svgurl;
						}
					}
					
					$layer['text']		= stripslashes($this->get_val($layer, 'text'));
					$layers[$layer_key]	= $layer;
				}
			}
			
			$this->slides_data[$slide_key]['layers'] = $layers;
			
			
			$d = array('params' => $params, 'sliderParams' => $this->slider_data, 'layers' => $layers, 'settings' => $settings, 'imported' => $this->imported);
			$d = apply_filters('revslider_importSliderFromPost_modify_data', $d, 'normal', $this->download_path, $this);
			
			$this->slider_data = $d['sliderParams'];
			$this->imported	= $d['imported'];
			$params			= $d['params'];
			$layers			= $d['layers'];
			$settings		= $d['settings'];
			
			$my_layers	 = json_encode($layers);
			$my_layers	 = (empty($my_layers)) ? stripslashes(json_encode($layers)) : $my_layers;
			$my_params	 = json_encode($params);
			$my_params	 = (empty($my_params)) ? stripslashes(json_encode($params)) : $my_params;
			$my_settings = json_encode($settings);
			$my_settings = (empty($my_settings)) ? stripslashes(json_encode($settings)) : $my_settings;
			
			//create new slide
			$wpdb->insert(
				$wpdb->prefix . RevSliderFront::TABLE_SLIDES,
				array(
					'slider_id'	=> $this->slider_id,
					'slide_order' => $this->get_val($slide, 'slide_order'),
					'layers'	=> $my_layers,
					'params'	=> $my_params,
					'settings'	=> $my_settings
				)
			);
			
			if(isset($slide['id'])){
				$this->slides_data[$slide_key]['new_id'] = $wpdb->insert_id;
				$this->map[$slide['id']] = $wpdb->insert_id;
			}
		}
	}
	
	
	/**
	 * process layers, and update actions
	 **/
	public function process_layer_data(){
		if(!empty($this->map)){
			if(!empty($this->slides_data)){
				foreach($this->slides_data as $slide){
					if(version_compare($this->get_val($slide, array('params', 'version'), '1.0.0'), '6.0.0', '<')){
						$this->process_layer_data_pre_6($slide);
					}else{
						$this->process_layer_data_post_6($slide);
					}
				}
			}
		}
	}
	
	/**
	 * process layers from after 6.0
	 **/
	public function process_layer_data_post_6($slide){
		global $wpdb;
		
		$params = $this->get_val($slide, 'params', array());
		$layers = $this->get_val($slide, 'layers', array());
		
		//change for WPML the parent IDs if necessary
		$parent_id = $this->get_val($slide, array('params', 'child', 'parentId'), false);
		
		if(!in_array($parent_id, array(false, ''), true) && isset($this->map[$parent_id])){
			$create = array('params' => $params);
			
			$this->set_val($create, array('params', 'child', 'parentId'), $this->map[$parent_id]);
			
			$new_params = json_encode($create['params']);
			$new_params = (empty($new_params)) ? stripslashes(json_encode($create['params'])) : $new_params;
			$create['params'] = $new_params;
			
			$wpdb->update(
				$wpdb->prefix . RevSliderFront::TABLE_SLIDES,
				$create,
				array('id' => $this->map[$slide['id']])
			);
		}
		
		if(!empty($slide['layers'])){
			$did_change = false;
			foreach($slide['layers'] as $lk => $layer){
				$actions = $this->get_val($layer, array('actions', 'action'), array());
				if(!empty($actions)){
					foreach($actions as $a_k => $action){
						$jts = $this->get_val($action, 'jump_to_slide', '');
						if($jts !== ''){
							if(isset($this->map[$jts])){
								$this->set_val($slide['layers'][$lk], array('actions', 'action', $a_k, 'jump_to_slide'), $this->map[$jts]);
								$did_change = true;
							}
						}
						
						if(!empty($this->map)){
							$cb = $this->get_val($action, 'actioncallback', '');
							if($cb !== ''){
								$cb = str_replace('slider-'.$this->old_slider_id.'-', 'slider-'.$this->slider_id.'-', $cb);
								$cb = str_replace('slider_'.$this->old_slider_id.'_', 'slider_'.$this->slider_id.'_', $cb);
								foreach($this->map as $old_slide_id => $new_slide_id){
									$cb = str_replace('slide-'.$old_slide_id.'-', 'slide-'.$new_slide_id.'-', $cb);
									$this->set_val($slide['layers'][$lk], array('actions', 'action', $a_k, 'actioncallback'), $cb);
									$did_change = true;
								}
							}
						}
					}
				}
				
				/**
				 * check for wrong formatted false values in the reverseDirection
				 **/
				$_reverse_check = array('frame_0', 'frame_1', 'frame_999');
				foreach($_reverse_check as $rc){
					$lr = $this->get_val($layer, array('timeline', 'frames', $rc, 'reverseDirection'), array());
					if(!empty($lr)){
						foreach($lr as $lrk => $lrv){
							if($lrv === 'false'){
								$this->set_val($slide['layers'][$lk], array('timeline', 'frames', $rc, 'reverseDirection', $lrk), false);
								$did_change = true;
							}
							if($lrv === 'true'){
								$this->set_val($slide['layers'][$lk], array('timeline', 'frames', $rc, 'reverseDirection', $lrk), true);
								$did_change = true;
							}
						}
					}
				}
			}
			
			if($did_change === true){
				$my_layers	= json_encode($slide['layers']);
				$create		= array();
				$create['layers'] = (empty($my_layers)) ? stripslashes(json_encode($layers)) : $my_layers;
				
				$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDES, $create, array('id' => $this->map[$slide['id']]));
			}
		}
	}
	
	/**
	 * process layers from before 6.0
	 **/
	public function process_layer_data_pre_6($slide){
		global $wpdb;
		
		//change for WPML the parent IDs if necessary
		if(isset($slide['params']['parentid']) && isset($this->map[$slide['params']['parentid']])){
			$create		= array('params' => $this->get_val($slide, 'params'));
			$create['params']['parentid'] = $this->map[$this->get_val($create['params'], 'parentid')];
			$my_params	= json_encode($create['params']);
			$my_params	= (empty($my_params)) ? stripslashes(json_encode($create['params'])) : $my_params;
			$create['params'] = $my_params;
			
			$wpdb->update(
				$wpdb->prefix . RevSliderFront::TABLE_SLIDES,
				$create,
				array('id' => $this->map[$slide['id']])
			);
		}
		
		$did_change = false;
		if(!empty($slide['layers'])){
			foreach($slide['layers'] as $key => $value){
				if(isset($value['layer_action'])){
					if(isset($value['layer_action']->jump_to_slide) && !empty($value['layer_action']->jump_to_slide)){
						$value['layer_action']->jump_to_slide = (array)$value['layer_action']->jump_to_slide;
						foreach($value['layer_action']->jump_to_slide as $jtsk => $jtsval){
							if(isset($this->map[$jtsval])){
								$slide['layers'][$key]['layer_action']->jump_to_slide[$jtsk] = $this->map[$jtsval];
								$did_change = true;
							}
						}
					}
				}
				
				$link_slide = $this->get_val($value, 'link_slide', false);
				if($link_slide != false && $link_slide !== 'nothing'){ //link to slide/scrollunder is set, move it to actions
					if(!isset($slide['layers'][$key]['layer_action'])) $slide['layers'][$key]['layer_action'] = new stdClass();
					switch($link_slide){
						case 'link':
							$link = $this->get_val($value, 'link');
							$link_open_in = $this->get_val($value, 'link_open_in');
							$slide['layers'][$key]['layer_action']->action = array('a' => 'link');
							$slide['layers'][$key]['layer_action']->link_type = array('a' => 'a');
							$slide['layers'][$key]['layer_action']->image_link = array('a' => $link);
							$slide['layers'][$key]['layer_action']->link_open_in = array('a' => $link_open_in);
							
							unset($slide['layers'][$key]['link']);
							unset($slide['layers'][$key]['link_open_in']);
						break;
						case 'next':
							$slide['layers'][$key]['layer_action']->action = array('a' => 'next');
						break;
						case 'prev':
							$slide['layers'][$key]['layer_action']->action = array('a' => 'prev');
						break;
						case 'scroll_under':
							$scrollunder_offset = $this->get_val($value, 'scrollunder_offset');
							$slide['layers'][$key]['layer_action']->action = array('a' => 'scroll_under');
							$slide['layers'][$key]['layer_action']->scrollunder_offset = array('a' => $scrollunder_offset);
							
							unset($slide['layers'][$key]['scrollunder_offset']);
						break;
						default: //its an ID, so its a slide ID
							$slide['layers'][$key]['layer_action']->action = array('a' => 'jumpto');
							$slide['layers'][$key]['layer_action']->jump_to_slide = array('a' => $this->map[$link_slide]);
						break;
						
					}
					$slide['layers'][$key]['layer_action']->tooltip_event = array('a' => 'click');
					
					unset($slide['layers'][$key]['link_slide']);
					
					$did_change = true;
				}
			}
			
			if($did_change === true){
				$my_layers	= json_encode($slide['layers']);
				$create		= array();
				$create['layers'] = (empty($my_layers)) ? stripslashes(json_encode($slide['layers'])) : $my_layers;
				
				$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDES, $create, array('id' => $this->map[$slide['id']]));
			}
		}
	}
	
	/**
	 * process the static slide plus layers, and update actions
	 **/
	public function process_static_slide_data(){
		$static_slide = $this->get_val($this->slider_data, 'static_slides');
		if(!empty($static_slide) && $this->import_statics){
			foreach($static_slide as $slide){
				$params	= $this->get_val($slide, 'params');
				if(version_compare($this->get_val($params, 'version', '1.0.0'), '6.0.0', '<')){
					$this->process_static_slide_data_pre_6();
				}else{
					$this->process_static_slide_data_post_6();
				}
				break;
			}
		}
	}
	
	
	/**
	 * process the static slide plus layers, and update actions for Static Slides pre 6.0
	 **/
	public function process_static_slide_data_pre_6(){
		global $wpdb;
		//check if static slide exists and import
		$static_slide = $this->get_val($this->slider_data, 'static_slides');
		
		if(!empty($static_slide) && $this->import_statics){
			foreach($static_slide as $slide){
				$params		= $this->get_val($slide, 'params');
				$layers		= $this->get_val($slide, 'layers');
				$settings	= $this->get_val($slide, 'settings', '');
				
				//remove image_id as it is not needed in import
				if(isset($params['image_id'])) unset($params['image_id']);
				
				$image			 = trim($this->get_val($params, 'image', ''));
				$params['image'] = $this->import_media_from_zip($image);
				
				//convert layers images:
				if(!empty($layers)){
					foreach($layers as $layer_key => $layer){
						
						$image = trim($this->get_val($layer, 'image_url', ''));
						$layer['image_url']	= $this->import_media_from_zip($image);
						
						$image = trim($this->get_val($layer, 'bgimage_url', ''));
						$layer['bgimage_url'] = $this->import_media_from_zip($image);
						
						$layer['text'] = stripslashes($this->get_val($layer, 'text'));

						$type = $this->get_val($layer, 'type');
						if($type == 'video' || $type == 'audio'){
							$video_data = (array)$this->get_val($layer, 'video_data', array());
							if(!empty($video_data) && isset($video_data['video_type']) && $video_data['video_type'] == 'html5'){
								$video_data['urlPoster'] = (isset($video_data['urlPoster']) && $video_data['urlPoster'] != '') ? $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $video_data['urlPoster'], $this->alias, $this->imported)) : '';
								$video_data['urlMp4']	 = (isset($video_data['urlMp4']) && $video_data['urlMp4'] != '') ? $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $video_data['urlMp4'], $this->alias, $this->imported, true)) : '';
								$video_data['urlWebm']	 = (isset($video_data['urlWebm']) && $video_data['urlWebm'] != '') ? $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $video_data['urlWebm'], $this->alias, $this->imported, true)) : '';
								$video_data['urlOgv']	 = (isset($video_data['urlOgv']) && $video_data['urlOgv'] != '') ? $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $video_data['urlOgv'], $this->alias, $this->imported, true)) : '';
							}elseif(!empty($video_data) && isset($video_data['video_type']) && $video_data['video_type'] != 'html5'){ //video cover image
								if($video_data['video_type'] == 'audio'){
									$video_data['urlAudio'] = (isset($video_data['urlAudio']) && $video_data['urlAudio'] != '') ? $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $video_data['urlAudio'], $this->alias, $this->imported, true)) : '';
								}else{
									$video_data['previewimage']	= (isset($video_data['previewimage']) && $video_data['previewimage'] != '') ? $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $video_data['previewimage'], $this->alias, $this->imported)) : '';
								}
							}
							
							$layer['video_data']		= $video_data;
							$layer['video_image_url']	= (isset($layer['video_image_url']) && $layer['video_image_url'] != '') ? $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $layer['video_image_url'], $this->alias, $this->imported)) : '';
						}
						
						if(isset($layer['type']) && $layer['type'] == 'svg'){
							if(isset($layer['svg']) && isset($layer['svg']->src)){
								$layer['svg']->src = content_url().$layer['svg']->src;
							}
						}
						
						if(isset($layer['layer_action'])){
							if(isset($layer['layer_action']->jump_to_slide) && !empty($layer['layer_action']->jump_to_slide)){
								foreach($layer['layer_action']->jump_to_slide as $jtsk => $jtsval){
									if(isset($this->map[$jtsval])){
										$layer['layer_action']->jump_to_slide[$jtsk] = $this->map[$jtsval];
									}
								}
							}
						}
						
						$link_slide = $this->get_val($layer, 'link_slide', false);
						if($link_slide != false && $link_slide !== 'nothing'){ //link to slide/scrollunder is set, move it to actions
							if(!isset($layer['layer_action'])) $layer['layer_action'] = new stdClass();
							
							switch($link_slide){
								case 'link':
									$layer['layer_action']->action		 = array('a' => 'link');
									$layer['layer_action']->link_type	 = array('a' => 'a');
									$layer['layer_action']->image_link	 = array('a' => $this->get_val($layer, 'link'));
									$layer['layer_action']->link_open_in = array('a' => $this->get_val($layer, 'link_open_in'));
									
									unset($layer['link']);
									unset($layer['link_open_in']);
								break;
								case 'next':
									$layer['layer_action']->action = array('a' => 'next');
								break;
								case 'prev':
									$layer['layer_action']->action = array('a' => 'prev');
								break;
								case 'scroll_under':
									$layer['layer_action']->action = array('a' => 'scroll_under');
									$layer['layer_action']->scrollunder_offset = array('a' => $this->get_val($layer, 'scrollunder_offset'));
									
									unset($layer['scrollunder_offset']);
								break;
								default: //its an ID, so its a slide ID
									$layer['layer_action']->action = array('a' => 'jumpto');
									$layer['layer_action']->jump_to_slide = array('a' => $this->map[$link_slide]);
								break;
								
							}
							$layer['layer_action']->tooltip_event = array('a' => 'click');
							
							unset($layer['link_slide']);
						}
						
						$layers[$layer_key] = $layer;
					}
				}
				
				$d = array('params' => $params, 'layers' => $layers, 'settings' => $settings);
				$d = apply_filters('revslider_importSliderFromPost_modify_data', $d, 'static', $this->download_path, $this);
				
				$my_layers	 = json_encode($d['layers']);
				$my_layers	 = (empty($my_layers)) ? stripslashes(json_encode($d['layers'])) : $my_layers;
				$my_params	 = json_encode($d['params']);
				$my_params	 = (empty($my_params)) ? stripslashes(json_encode($d['params'])) : $my_params;
				$my_settings = json_encode($d['settings']);
				$my_settings = (empty($my_settings)) ? stripslashes(json_encode($d['settings'])) : $my_settings;
				
				if($this->exists){
					$wpdb->update(
						$wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES,
						array(
							'layers'	=> $my_layers,
							'params'	=> $my_params,
							'settings'	=> $my_settings
						),
						array('slider_id' => $this->slider_id)
					);
				}else{
					$ret = $wpdb->insert(
						$wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES,
						array(
							'slider_id' => $this->slider_id,
							'layers'	=> $my_layers,
							'params'	=> $my_params,
							'settings'	=> $my_settings
						)
					);
				}
			}
		}
	}
	
	
	/**
	 * process the static slide plus layers, and update actions for Static Slides pre 6.0
	 **/
	public function process_static_slide_data_post_6(){
		global $wpdb, $wp_filesystem;
		//check if static slide exists and import
		$static_slide = $this->get_val($this->slider_data, 'static_slides');
		
		if(!empty($static_slide) && $this->import_statics){
			foreach($static_slide as $slide){
				$params		= $this->get_val($slide, 'params');
				$layers		= $this->get_val($slide, 'layers');
				$settings	= $this->get_val($slide, 'settings', '');
				
				//remove image_id as it is not needed in import
				if($this->get_val($params, array('bg', 'imageId'), false) !== false) unset($params['bg']['imageId']);
				
				if(!isset($params['bg'])) $params['bg'] = array();
				$image = trim($this->get_val($params, array('bg', 'image'), ''));
				$params['bg']['image'] = $this->import_media_from_zip($image);
				if(!empty($params['bg']['image'])){
					$imgid = $this->get_image_id_by_url($params['bg']['image']);
					if(!empty($imgid) && $imgid !== 0){
						$params['bg']['imageId'] = $imgid;
					}
				}
				
				//convert layers images:
				if(!empty($layers)){
					foreach($layers as $layer_key => $layer){
						if($this->get_val($layer, array('media', 'imageId'), false) !== false) unset($layer['media']['imageId']);
						if($this->get_val($layer, array('media', 'posterId'), false) !== false) unset($layer['media']['posterId']);
						if($this->get_val($layer, array('idle', 'backgroundImageId'), false) !== false) unset($layer['idle']['backgroundImageId']);

						$image = trim($this->get_val($layer, array('media', 'imageUrl'), ''));
						if($image !== ''){
							$layer['media']['imageUrl'] = $this->import_media_from_zip($image);
						}
						$image = trim($this->get_val($layer, array('idle', 'backgroundImage'), ''));
						if($image !== ''){
							$layer['idle']['backgroundImage'] = $this->import_media_from_zip($image);
						}
						
						$layer['text'] = stripslashes($this->get_val($layer, 'text'));

						$type = $this->get_val($layer, 'type');
						if($type == 'video' || $type == 'audio'){
							if($this->get_val($layer, array('media', 'mediaType')) == 'html5'){
								$layer['media']['mp4Url']	= ($this->get_val($layer, array('media', 'mp4Url'), '') != '') ? $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $this->get_val($layer, array('media', 'mp4Url'), ''), $this->alias, $this->imported, true)) : '';
								$layer['media']['webmUrl']	= ($this->get_val($layer, array('media', 'webmUrl'), '') != '') ? $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $this->get_val($layer, array('media', 'webmUrl'), ''), $this->alias, $this->imported, true)) : '';
								$layer['media']['ogvUrl']	= ($this->get_val($layer, array('media', 'ogvUrl'), '') != '') ? $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $this->get_val($layer, array('media', 'ogvUrl'), ''), $this->alias, $this->imported, true)) : '';
							}elseif($this->get_val($layer, array('media', 'mediaType')) != 'html5'){ //video cover image
								if($this->get_val($layer, array('media', 'mediaType')) == 'audio'){
									$layer['media']['audioUrl']	= ($this->get_val($layer, array('media', 'audioUrl'), '') != '') ? $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $this->get_val($layer, array('media', 'audioUrl'), ''), $this->alias, $this->imported, true)) : '';
								}
							}
							
							$layer['media']['posterUrl'] = ($this->get_val($layer, array('media', 'posterUrl'), '') != '') ? $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $this->get_val($layer, array('media', 'posterUrl'), ''), $this->alias, $this->imported)) : '';
						}
						
						if($type == 'svg'){
							$svg = $this->get_val($layer, array('svg', 'source'), '');
							
							//check if we need to import it, if its available in the zip file
							$zimage	= $wp_filesystem->exists($this->download_path.'images/'.$svg);
							
							if(!$zimage) $zimage = $wp_filesystem->exists(str_replace('//', '/', $this->download_path.'images/'.$svg));
							$svgurl = ($zimage === true) ? $this->get_image_url_from_path($this->check_file_in_zip($this->download_path, $svg, $this->alias, $this->imported, true)) : content_url().$svg;
							if(!empty($svg)) $layer['svg']['source'] = $svgurl;
						}
						
						$actions = $this->get_val($layer, array('actions', 'action'), array());
						if(!empty($actions)){
							foreach($actions as $a_k => $action){
								$jts = $this->get_val($action, 'jump_to_slide', '');
								if($jts !== ''){
									if(isset($this->map[$jts])){
										$this->set_val($layer, array('actions', 'action', $a_k, 'jump_to_slide'), $this->map[$jts]);
									}
								}
								
								if(!empty($this->map)){
									$cb = $this->get_val($action, 'actioncallback', '');
									if($cb !== ''){
										$cb = str_replace('slider-'.$this->old_slider_id.'-', 'slider-'.$this->slider_id.'-', $cb);
										$cb = str_replace('slider_'.$this->old_slider_id.'_', 'slider_'.$this->slider_id.'_', $cb);
										foreach($this->map as $old_slide_id => $new_slide_id){
											$cb = str_replace('slide-'.$old_slide_id.'-', 'slide-'.$new_slide_id.'-', $cb);
											$this->set_val($slide['layers'][$layer_key], array('actions', 'action', $a_k, 'actioncallback'), $cb);
										}
									}
								}
							}
						}
						
						$layers[$layer_key] = $layer;
					}
				}
				
				$d = array('params' => $params, 'layers' => $layers, 'settings' => $settings);
				$d = apply_filters('revslider_importSliderFromPost_modify_data', $d, 'static', $this->download_path, $this);
				
				$my_layers	 = json_encode($d['layers']);
				$my_layers	 = (empty($my_layers)) ? stripslashes(json_encode($d['layers'])) : $my_layers;
				$my_params	 = json_encode($d['params']);
				$my_params	 = (empty($my_params)) ? stripslashes(json_encode($d['params'])) : $my_params;
				$my_settings = json_encode($d['settings']);
				$my_settings = (empty($my_settings)) ? stripslashes(json_encode($d['settings'])) : $my_settings;
				
				if($this->exists){
					$wpdb->update(
						$wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES,
						array(
							'layers'	=> $my_layers,
							'params'	=> $my_params,
							'settings'	=> $my_settings
						),
						array('slider_id' => $this->slider_id)
					);
				}else{
					$ret = $wpdb->insert(
						$wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES,
						array(
							'slider_id' => $this->slider_id,
							'layers'	=> $my_layers,
							'params'	=> $my_params,
							'settings'	=> $my_settings
						)
					);
				}
			}
		}
	}
	
	
	/**
	 * duplicate the template slider, if we installed a template slider. either a slide or the full slider
	 **/
	public function duplicate_template_slider($single_slide){
		if($this->is_template !== false){ //duplicate the slider now, as we just imported the "template"
			$mslider = new RevSliderSlider();
			$mslider->template_slider = true;
			if($single_slide !== false){ //add now one Slide to the current Slider
				//change slide_id to correct, as it currently is just a number beginning from 0 as we did not have a correct slide ID yet.
				$i = 0;
				$changed = false;
				if(!empty($this->map)){
					foreach($this->map as $value){
						if($i == $single_slide['slide_id']){
							$single_slide['slide_id'] = $value;
							$changed = true;
							break;
						}
						$i++;
					}
				}
				
				if($changed){
					$mslider->copy_slide_to_slider($single_slide);
				}else{
					global $wp_filesystem;
					
					$wp_filesystem->delete($this->remove_path, true);
					return array('success' => false, 'error' => __('could not find correct Slide to copy, please try again.', 'revslider'), 'sliderID' => $this->slider_id);
				}
			}else{
				$this->real_slider_id = $mslider->duplicate_slider_by_id($this->slider_id, true);
			}
		
			$map = $mslider->get_map();
			if(!empty($map)){
				$new_map = array();
				if(!empty($this->map)){
					foreach($this->map as $os => $ns){
						if(isset($map[$ns])){
							$new_map[$os] = $map[$ns];
						}
					}
					if(!empty($new_map)){ //push these into the duplicate tree
						$this->map[$this->real_slider_id] = $new_map;
					}
				}
			}
		}
		
		return true;
	}
	
	
	/**
	 * update the slide ids in the slider skins 
	 * @since: 6.2.3
	 * skins -> colors -> [] -> ref -> [] -> r & slide
	 **/
	public function update_color_ids($map){
		$skins = $this->get_param('skins', array());
		if(!empty($skins) && isset($skins['colors']) && !empty($skins['colors']) && !empty($map)){
			
			$update = false;
			foreach($skins['colors'] as $k => $v){
				if(isset($v['ref']) && !empty($v['ref'])){
					foreach($v['ref'] as $rk => $rv){
						$os = $this->get_val($rv, 'slide');
						
						if(isset($map[$os])){
							$update = true;
							$skins['colors'][$k]['ref'][$rk]['slide'] = (string)$map[$os];
							
							$r = explode('.', $this->get_val($rv, 'r'));
							if(!empty($r) && is_array($r)){
								$r[0] = $map[$os];
								$skins['colors'][$k]['ref'][$rk]['r'] = implode('.', $r);
							}
						}
					}
				}
			}
			
			if($update){
				$this->update_params(array('skins' => $skins));
			}
		}
	}
	
	
	/**
	 * update the custom javascript section by removing the old api ID with the new api ID
	 **/
	public function update_css_and_javascript_ids($old_slider_id, $new_slider_id, $map){
		$js = $this->get_param(array('codes', 'javascript'), '');
		$css = $this->get_param(array('codes', 'css'), '');
		
		$change = false;
		
		if(strpos($js, 'revapi') !== false){
			if(preg_match_all('/revapi[0-9]*/', $js, $results)){
				if(isset($results[0]) && !empty($results[0])){
					foreach($results[0] as $replace){
						$js = str_replace($replace, 'revapi'.$new_slider_id, $js);
					}
					$change = true;
				}
			}
		}
		
		if(!empty($map)){
			if($css !== ''){
				$css = str_replace(
					array(
						'slider-'.$old_slider_id.'-',
						'slider_'.$old_slider_id.'_',
						'rrzt_'.$old_slider_id,
						'rrzm_'.$old_slider_id,
						'rrzb_'.$old_slider_id,
						'.slotholder',
						'.rs-background-video-layer',
						'.tp-static-layers',
						'.tp-parallax-wrap',
						'.rev_column_bg',
						'.tp-revslider-slidesli',
						'active-revslide'
					),
					array(
						'slider-'.$new_slider_id.'-',
						'slider_'.$new_slider_id.'_',
						'rrzt_'.$new_slider_id,
						'rrzm_'.$new_slider_id,
						'rrzb_'.$new_slider_id,
						'rs-sbg-wrap',
						'rs-bgvideo',
						'rs-static-layers',
						'.rs-parallax-wrap',
						'rs-column-bg',
						'rs-slide',
						'active-rs-slide'
					),
					$css
				);
				
				foreach($map as $old_slide_id => $new_slide_id){
					$css = str_replace('slide-'.$old_slide_id.'-', 'slide-'.$new_slide_id.'-', $css);
				}
				$change = true;
			}
			if($js !== ''){
				$js = str_replace(
					array(
						'slider-'.$old_slider_id.'-',
						'slider_'.$old_slider_id.'_',
						'rrzt_'.$old_slider_id,
						'rrzm_'.$old_slider_id,
						'rrzb_'.$old_slider_id,
						'.slotholder',
						'.rs-background-video-layer',
						'.tp-static-layers',
						'if (obj.href!=undefined && obj.href.split("http").length<2 && obj.href!="#wp-toolbar")'
					),
					array(
						'slider-'.$new_slider_id.'-',
						'slider_'.$new_slider_id.'_',
						'rrzt_'.$new_slider_id,
						'rrzm_'.$new_slider_id,
						'rrzb_'.$new_slider_id,
						'rs-sbg-wrap',
						'rs-bgvideo',
						'tp-static-layers',
						'if (obj.href!=undefined && obj.href.split("http").length<2 && obj.href!="#wp-toolbar" && obj.href.split(\'./\').length<2 && obj.href.split(\'mailto:\').length<2)'
					),
					$js
				);
				
				foreach($map as $old_slide_id => $new_slide_id){
					$js = str_replace('slide-'.$old_slide_id.'-', 'slide-'.$new_slide_id.'-', $js);
				}
				$change = true;
			}
			
			//check for all slides, if seo.slideLink needs to be changed
			$this->init_layer = false;
			$slides = $this->get_slides();
			if(!empty($slides)){
				foreach($slides as $skey => $slide){
					if(version_compare($slide->get_param('version', '1.0.0'), '6.0.0', '<')){
					}else{
						$slidelink = $slide->get_param(array('seo', 'slideLink'), false);
						if($slidelink !== false && isset($map[$slidelink])){
							$slide->set_param(array('seo', 'slideLink'), $map[$slidelink]);
							$slide->save_params();
						}
					}
				}
			}
		}
		
		if($change === true){
			$this->update_params(array('codes' => array('javascript' => $js, 'css' => $css)));
		}
	}
	
	
	/**
	 * import a media and return the imported path of it
	 * @param string $image
	 * @return string
	 **/
	public function import_media_from_zip($image){
		global $wp_filesystem;
		
		$media = '';

		//import if exists in zip folder
		if($image !== '' && strpos($image, 'http') === false){
			if($this->import_zip === true){ //we have a zip, check if exists
				if($wp_filesystem->exists($this->download_path.'images/'.$image)){
					if(!isset($this->imported['images/'.$image])){
						$import_image = $this->import_media($this->download_path.'images/'.$image, $this->get_val($this->slider_data, 'alias', 'alias').'/');
						if($import_image !== false){
							$image = $import_image['path'];
							$this->imported['images/'.$image] = $image;
						}
					}else{
						$image = $this->imported['images/'.$image];
					}
				}
			}
			$media = $this->get_image_url_from_path($image);
		}
		
		return $media;
	}
	
	/**
	 * clear errors of length in string before unserializing it
	 * @param string $m
	 * @return string
	 **/
	public static function clear_error_in_string($m){
		return 's:'.strlen($m[2]).':"'.$m[2].'";';
	}

	/**
	 * depending on PHP version, use optional parameter of unserialize
	 * @since: 6.0.0
	 * @param string $string
	 * @return mixed
	 */
	public function rs_unserialize($string){
		return @unserialize($string);
	}
}