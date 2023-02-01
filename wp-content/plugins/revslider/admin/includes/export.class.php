<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderSliderExport extends RevSliderSlider {
	
	private $used_captions;
	private $used_animations;
	private $used_images;
	private $used_svg;
	private $used_videos;
	private $used_navigations;
	
	private $slider_id;
	private $slider_title;
	public $slider_alias;
	private $slider_params;
	private $slider_settings;
	private $export_slides;
	private $static_slide;
	private $all_slides;
	private $export_data;
	private $navigation_data;
	private $style_data;
	private $animations_data;
	public $usepcl;
	public $zip;
	public $export_path_zip;
	public $export_url_zip;
	public $pclzip;
	
	
	public function __construct($title = 'export'){
		$this->used_captions	= array();
		$this->used_animations	= array();
		$this->used_images		= array();
		$this->used_svg			= array();
		$this->used_videos		= array();
		$this->used_navigations	= array();
		$this->all_slides		= array();
		$this->navigation_data	= false;
		$this->style_data		= '';
		$this->animations_data	= '';
		$this->usepcl			= false;
		
		$wp_upload_dir			= wp_upload_dir();
		$this->export_path_zip	= $this->get_val($wp_upload_dir, 'basedir').'/'.$title.'.zip';
		$this->export_url_zip	= $this->get_val($wp_upload_dir, 'baseurl').'/'.$title.'.zip';
	}
	
	/**
	 * return the used images, for SEO
	 */
	public function get_used_images(){
		return $this->used_images;
	}
	
	/**
	 * export slider from data, output a file for download
	 * @before: RevSliderSlider::exportSlider();
	 */
	public function export_slider($id = 0){
		//slider needs to be initialized :)
		if($id > 0){
			$this->init_by_id($id);
		}
		
		//check if an update is needed
		if(version_compare($this->get_param(array('settings', 'version')), get_option('revslider_update_version', '6.0.0'), '<')){
			$upd = new RevSliderPluginUpdate();
			$upd->upgrade_slider_to_latest($this);
			$this->init_by_id($id);
		}
		
		$this->set_parameters();
		$this->remove_image_ids();
		$this->remove_background_image();
		
		$this->add_used_images();
		$this->add_used_videos();
		//$this->add_used_captions();
		//$this->add_used_animations();
		$this->add_used_navigations();
		$this->add_used_svg();
		
		$this->modify_used_data();
		
		$this->serialize_export_data();
		$this->serialize_navigation_data();
		$this->prepare_caption_css();
		$this->serialize_animation_data();
		
		$this->create_export_zip();
		$this->add_svg_to_zip();
		$this->add_images_videos_to_zip();
		$this->add_slider_export_to_zip();
		$this->add_animations_to_zip();
		$this->add_styles_to_zip();
		$this->add_navigation_to_zip();
		$this->add_static_styles_to_zip();
		$this->add_info_to_zip();
		$this->close_export_zip();
		$this->push_zip_to_client();
		$this->delete_export_zip();
		
		exit;
	}
	
	
	/**
	 * set slides and slider parameters
	 **/
	public function set_parameters(){
		$this->slider_id		= $this->get_id();
		$this->slider_title		= $this->get_title();
		$this->slider_alias		= $this->get_alias();
		$this->slider_params	= $this->get_params();
		$this->slider_settings	= $this->get_settings();
		$this->export_slides	= $this->get_slides_for_export();
		$this->static_slide		= $this->get_static_slide_for_export();
		
		if(!empty($this->export_slides) && count($this->export_slides) > 0)	$this->all_slides = array_merge($this->all_slides, $this->export_slides);
		if(!empty($this->static_slide) && count($this->static_slide) > 0)	$this->all_slides = array_merge($this->all_slides, $this->static_slide);
	}
	
	
	/**
	 * remove the image_id as its not needed in export
	 **/
	public function remove_image_ids(){
		if($this->get_val($this->slider_params, array('troubleshooting', 'alternateURLId'), false) !== false){
			unset($this->slider_params['troubleshooting']['alternateURLId']);
		}
		
		if(!empty($this->export_slides)){
			foreach($this->export_slides as $k => $s){
				if($this->get_val($this->export_slides[$k], array('params', 'bg', 'imageId'), false) !== false){
					unset($this->export_slides[$k]['params']['bg']['imageId']);
				}
				/*if($this->get_val($this->export_slides[$k], array('params', 'bg', 'videoId'), false) !== false){ //TODO maybe not delete, depending on if this is a wordpress media library id (then yes) or not
					unset($this->export_slides[$k]['params']['bg']['videoId']);
				}*/
				if($this->get_val($this->export_slides[$k], array('params', 'thumb', 'customThumbSrcId'), false) !== false){
					unset($this->export_slides[$k]['params']['thumb']['customThumbSrcId']);
				}
				if($this->get_val($this->export_slides[$k], array('params', 'thumb', 'customAdminThumbSrcId'), false) !== false){
					unset($this->export_slides[$k]['params']['thumb']['customAdminThumbSrcId']);
				}
				if($this->get_val($this->export_slides[$k], array('params', 'bg', 'lastLoadedImage'), false) !== false){
					unset($this->export_slides[$k]['params']['bg']['lastLoadedImage']);
				}
			}
		}
		
		if(!empty($this->static_slide)){
			foreach($this->static_slide as $k => $s){
				if($this->get_val($this->static_slide[$k], array('params', 'bg', 'imageId'), false) !== false){
					unset($this->static_slide[$k]['params']['bg']['imageId']);
				}
				/*if($this->get_val($this->static_slide[$k], array('params', 'bg', 'videoId'), false) !== false){ //TODO maybe not delete, depending on if this is a wordpress media library id (then yes) or not
					unset($this->static_slide[$k]['params']['bg']['videoId']);
				}*/
				if($this->get_val($this->static_slide[$k], array('params', 'thumb', 'customThumbSrcId'), false) !== false){
					unset($this->static_slide[$k]['params']['thumb']['customThumbSrcId']);
				}
				if($this->get_val($this->static_slide[$k], array('params', 'thumb', 'customAdminThumbSrcId'), false) !== false){
					unset($this->static_slide[$k]['params']['thumb']['customAdminThumbSrcId']);
				}
				if($this->get_val($this->static_slide[$k], array('params', 'bg', 'lastLoadedImage'), false) !== false){
					unset($this->static_slide[$k]['params']['bg']['lastLoadedImage']);
				}
			}
		}
	}
	
	
	/**
	 * remove the background image on transparent or solid colored slides
	 **/
	public function remove_background_image(){
		if(!empty($this->export_slides)){
			foreach($this->export_slides as $k => $s){
				if(isset($this->export_slides[$k]['params']) && (in_array($this->get_val($this->export_slides[$k]['params'], array('bg', 'type')), array('solid', 'trans', 'transparent'), true))){
					if($this->get_val($this->export_slides[$k]['params'], array('bg', 'image'), false) !== false)
						$this->export_slides[$k]['params']['layout']['bg']['image'] = '';
				}
			}
		}
		if(!empty($this->static_slide)){
			foreach($this->static_slide as $k => $s){
				if(isset($this->static_slide[$k]['params']) && (in_array($this->get_val($this->static_slide[$k]['params'], array('bg', 'type')), array('solid', 'trans', 'transparent'), true))){
					if($this->get_val($this->static_slide[$k]['params'], array('bg', 'image'), false) !== false)
						$this->static_slide[$k]['params']['bg']['image'] = '';
				}
			}
		}
	}
	
	
	/**
	 * add all used images
	 **/
	public function add_used_images(){
		$image = $this->get_val($this->slider_params, array('layout', 'bg', 'image'));
		$a_url = $this->get_val($this->slider_params, array('troubleshooting', 'alternateURL'));
		
		if($image != '') $this->used_images[$image] = true;
		if($a_url != '') $this->used_images[$a_url] = true;
		
		if(!empty($this->all_slides) && count($this->all_slides) > 0){
			foreach($this->all_slides as $key => $slide){
				$params = $this->get_val($slide, 'params', array());
				$layers = $this->get_val($slide, 'layers', array());
				
				$image = $this->get_val($params, array('bg', 'image'));
				$thumb = $this->get_val($params, array('thumb', 'customThumbSrc'));
				$a_thumb = $this->get_val($params, array('thumb', 'customAdminThumbSrc'));
				
				if($image != '') $this->used_images[$image] = true;
				if($thumb != '') $this->used_images[$thumb] = true;
				if($a_thumb != '') $this->used_images[$a_thumb] = true;
				
				if(!empty($layers)){
					foreach($layers as $layer){
						$type		= $this->get_val($layer, 'type', 'text');
						$image		= $this->get_val($layer, array('media', 'imageUrl'));
						$bg_image	= $this->get_val($layer, array('idle', 'backgroundImage'));
						
						if($image != '') $this->used_images[$image] = true;
						if($bg_image != '')	$this->used_images[$bg_image] = true;
						
						if(in_array($type, array('video', 'audio'))){
							$poster = $this->get_val($layer, array('media', 'posterUrl'), '');
							if($poster != '') $this->used_images[$poster] = true;
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
							
							if($very_big != '') $this->used_images[$very_big] = true;
							if($big != '')		$this->used_images[$big] = true;
							if($large != '')	$this->used_images[$large] = true;
							if($medium != '')	$this->used_images[$medium] = true;
							if($small != '')	$this->used_images[$small] = true;
						}
					}
				}
			}
		}
	}
	
	
	/**
	 * add all used videos, also removing values if unneeded
	 **/
	public function add_used_videos(){
		if(!empty($this->all_slides) && count($this->all_slides) > 0){
			foreach($this->all_slides as $k => $slide){
				$params = $this->get_val($slide, 'params', array());
				$layers = $this->get_val($slide, 'layers', array());
				$static = $this->get_val($params, array('static', 'isstatic'), false);
				//html5 video
				if($this->get_val($params, array('bg', 'type')) == 'html5'){
					if($this->get_val($params, array('bg', 'mpeg')) != '')	$this->used_videos[$this->get_val($params, array('bg', 'mpeg'))] = true;
					if($this->get_val($params, array('bg', 'webm')) != '')	$this->used_videos[$this->get_val($params, array('bg', 'webm'))] = true;
					if($this->get_val($params, array('bg', 'ogv')) != '')	$this->used_videos[$this->get_val($params, array('bg', 'ogv'))] = true;
				}else{
					if($static){
						if($this->get_val($params, array('bg', 'mpeg')) != '')	$this->set_val($this->static_slide, array(0, 'params', 'bg', 'mpeg'), '');
						if($this->get_val($params, array('bg', 'webm')) != '')	$this->set_val($this->static_slide, array(0, 'params', 'bg', 'webm'), '');
						if($this->get_val($params, array('bg', 'ogv')) != '')	$this->set_val($this->static_slide, array(0, 'params', 'bg', 'ogv'), '');
					}else{
						if($this->get_val($params, array('bg', 'mpeg')) != '')	$this->set_val($this->export_slides, array($k, 'params', 'bg', 'mpeg'), '');
						if($this->get_val($params, array('bg', 'webm')) != '')	$this->set_val($this->export_slides, array($k, 'params', 'bg', 'webm'), '');
						if($this->get_val($params, array('bg', 'ogv')) != '')	$this->set_val($this->export_slides, array($k, 'params', 'bg', 'ogv'), '');
					}
				}
				
				//image thumbnail
				if(!empty($layers)){
					foreach($layers as $lk => $layer){
						if(in_array($this->get_val($layer, 'type'), array('video', 'audio'))){
							
							if($this->get_val($layer, array('media', 'mediaType')) == 'html5'){
								if($this->get_val($layer, array('media', 'mp4Url'), '') != '')	$this->used_videos[$this->get_val($layer, array('media', 'mp4Url'), '')] = true;
								if($this->get_val($layer, array('media', 'webmUrl'), '') != '')	$this->used_videos[$this->get_val($layer, array('media', 'webmUrl'), '')] = true;
								if($this->get_val($layer, array('media', 'ogvUrl'), '') != '')	$this->used_videos[$this->get_val($layer, array('media', 'ogvUrl'), '')] = true;
							}else{ //if(!in_array($this->get_val($layer, array('media', 'mediaType')), array('html5', 'audio')))
								if($this->get_val($layer, array('media', 'audioUrl')) != '') $this->used_videos[$this->get_val($layer, array('media', 'audioUrl'))] = true;
								$this->set_val($layer, array('media', 'mp4Url'), '');
								$this->set_val($layer, array('media', 'webmUrl'), '');
								$this->set_val($layer, array('media', 'ogvUrl'), '');
							}
							
							if($static){
								$this->static_slide[0]['layers'][$lk] = $layer;
							}else{
								$this->export_slides[$k]['layers'][$lk] = $layer;
							}
						}
					}
				}
			}
		}
	}
	
	
	/**
	 * add all used captions
	 * @obsolete since: 6.0
	 **/
	public function add_used_captions(){
		if(!empty($this->all_slides) && count($this->all_slides) > 0){
			foreach($this->all_slides as $key => $slide){
				$layers = $this->get_val($slide, 'layers', array());
				
				if(!empty($layers)){
					foreach($layers as $lk => $layer){
						if($this->get_val($layer, array('idle', 'style')) != '') $this->used_captions[$this->get_val($layer, array('idle', 'style'))] = true;
					}
				}
			}
		}
	}
	
	
	/**
	 * add all used animations
	 * @obsolete since: 6.0
	 **/
	public function add_used_animations(){
		if(!empty($this->all_slides) && count($this->all_slides) > 0){
			foreach($this->all_slides as $key => $slide){
				$layers = $this->get_val($slide, 'layers', array());
				
				if(!empty($layers)){
					foreach($layers as $lk => $layer){
						if(strpos($this->get_val($layer, 'animation'), 'customin') !== false)		$this->used_animations[str_replace('customin-', '', $this->get_val($layer, 'animation'))] = true;
						if(strpos($this->get_val($layer, 'endanimation'), 'customout') !== false)	$this->used_animations[str_replace('customout-', '', $this->get_val($layer, 'endanimation'))] = true;
					}
				}
			}
		}
	}
	
	
	/**
	 * add navigations if not default animation
	 **/
	public function add_used_navigations(){
		$nav = new RevSliderNavigation();
		
		$navigations = $nav->get_all_navigations(false, true);
		
		$arrows	 = $this->get_val($this->slider_params, array('nav', 'arrows', 'style'), false);
		$bullets = $this->get_val($this->slider_params, array('nav', 'bullets', 'style'), false);
		$thumbs	 = $this->get_val($this->slider_params, array('nav', 'thumbs', 'style'), false);
		$tabs	 = $this->get_val($this->slider_params, array('nav', 'tabs', 'style'), false);
		
		if($arrows !== false)	$this->used_navigations[$arrows] = true;
		if($bullets !== false)	$this->used_navigations[$bullets] = true;
		if($thumbs !== false)	$this->used_navigations[$thumbs] = true;
		if($tabs !== false)		$this->used_navigations[$tabs] = true;
	}
	
	
	/**
	 * add all used svg
	 **/
	public function add_used_svg(){
		if(!empty($this->all_slides) && count($this->all_slides) > 0){
			foreach($this->all_slides as $key => $slide){
				$layers = $this->get_val($slide, 'layers');
				
				if(!empty($layers)){
					foreach($layers as $lk => $layer){
						if($this->get_val($layer, 'type') == 'svg'){
							$svg = $this->get_val($layer, array('svg', 'source'));
							if($svg !== ''){
								$this->used_svg[$svg] = true;
							}
						}
					}
				}
			}
		}
	}
	
	
	/**
	 * modify the used stuff data
	 **/
	public function modify_used_data(){
		$d = array('used_svg' => $this->used_svg, 'used_images' => $this->used_images, 'used_videos' => $this->used_videos);
		$d = apply_filters('revslider_exportSlider_usedMedia', $d, $this->all_slides, $this->slider_params); //$this->export_slides, $this->static_slide, 
		
		$this->used_svg		= $d['used_svg'];
		$this->used_images	= $d['used_images'];
		$this->used_videos	= $d['used_videos'];
	}
	
	
	/**
	 * serialize the export data
	 **/
	public function serialize_export_data(){
		$data = array(
			'id'	 => $this->slider_id,
			'title'	 => $this->slider_title,
			'alias'	 => $this->slider_alias,
			'params' => $this->slider_params,
			'slides' => $this->export_slides,
			'settings' => $this->slider_settings
		);
		
		if(!empty($this->static_slide)) $data['static_slides'] = $this->static_slide;
		
		$data = apply_filters('revslider_exportSlider_export_data', $data, $this);
		
		$this->export_data = json_encode($data);
	}
	
	
	/**
	 * serialize the navigation data
	 **/
	public function serialize_navigation_data(){
		if(!empty($this->used_navigations)){
			$nav = new RevSliderNavigation();
			$this->navigation_data = $nav->export_navigation($this->used_navigations);
			if($this->navigation_data !== false) $this->navigation_data = json_encode($this->navigation_data);
		}
	}
	
	
	/**
	 * prepare the css for export
	 **/
	public function prepare_caption_css(){
		if(!empty($this->used_captions)){
			$captions = array();
			foreach($this->used_captions as $class => $val){
				$caption = $this->get_captions_content($class);
				if(!empty($caption)){
					unset($caption['id']);
					$captions[] = $caption;
				}
			}
			$this->style_data = json_encode($captions);
		}
	}
	
	
	/**
	 * serialize the animation data
	 **/
	public function serialize_animation_data(){
		if(!empty($this->used_animations)){
			$animations = array();
			foreach($this->used_animations as $anim => $val){
				$animation = $this->get_custom_animation_by_id($anim);
				if($animation !== false) $animations[] = $animation;
			}
			if(!empty($animations)) $this->animations_data = json_encode($animations);
		}
	}
	
	
	/**
	 * get animation params by id
	 * @before: RevSliderOperations::getFullCustomAnimationByID()
	 */
	public function get_custom_animation_by_id($id){
		global $revslider_animations;

		$this->fill_animations();
		if(empty($revslider_animations)) return false;
		
		foreach($revslider_animations as $animation){
			if($animation['id'] == $id){
				return array(
					'id'	 => $animation['id'],
					'handle' => $animation['handle'],
					'params' => $animation['params'],
					'settings' => $animation['settings']
				);
			}
		}
		
		return false;
	}
	
	
	/**
	 * create the blank zip file to be used further on
	 **/
	public function create_export_zip(){
		$this->usepcl = false;
		
		if(file_exists($this->export_path_zip)){
			@unlink($this->export_path_zip); //delete file to start with a fresh one
		}
		
		if(class_exists('ZipArchive')){
			$this->zip = new ZipArchive;
			$success = $this->zip->open($this->export_path_zip, ZIPARCHIVE::CREATE | ZipArchive::OVERWRITE);
			
			if($success !== true)
				$this->throw_error(__("Can't create zip file: ", 'revslider').$this->export_path_zip);
		}else{
			//fallback to pclzip
			require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
			
			$this->pclzip = new PclZip($this->export_path_zip);
			
			//either the function uses die() or all is cool
			$this->usepcl = true;
		}
	}
	
	
	/**
	 * add svg to the zip file, by modifying data in $export_data
	 **/
	public function add_svg_to_zip(){
		if(empty($this->used_svg)) return;
		
		$c_url	= str_replace(array('http:', 'https:'), '', content_url());
		$c_path	= ABSPATH . 'wp-content';
		$ud		= wp_upload_dir();
		$up_dir	= $this->get_val($ud, 'baseurl');
		$up_dir	= str_replace(array('http:', 'https:'), '', $up_dir);
		$cont_url			= str_replace(array('http:', 'https:'), '', $this->get_val($ud, 'baseurl'));
		$cont_url_no_www	= str_replace('www.', '', $cont_url);
		
		foreach($this->used_svg as $file => $val){
			if(strpos($file, 'http') !== false){ //remove all up to wp-content folder
				$file		= str_replace(array('http:', 'https:'), '', $file);
				$_checkpath = str_replace(array($cont_url.'/', $cont_url_no_www.'/'), '', $file);
				$checkpath = str_replace($c_url, '', $file);
				$checkpath2 = str_replace($up_dir, '', $file);
				if($checkpath2 === $file){ //we have an SVG like whiteboard, fallback to older export
					$checkpath2 = $checkpath;
				}
				
				//check if file is in the upload folder, if yes, add it to the zip file
				if(strpos($file, $up_dir) !== false){
					if(!$this->usepcl){
						$this->zip->addFile($c_path.$checkpath, 'images/'.$_checkpath);
					}else{
						$this->pclzip->add($c_path.$checkpath, PCLZIP_OPT_REMOVE_PATH, $c_path, PCLZIP_OPT_ADD_PATH, $_checkpath);
					}
				}
				$file = str_replace('/', '\/', $file);
				$checkpath2 = str_replace('/', '\/', str_replace('/revslider/assets/svg', '', $checkpath2));

				if(is_file($c_path.$checkpath)){
					$this->export_data = str_replace(array('http:'.$file, 'https:'.$file), $checkpath2, $this->export_data);
				}
			}
		}
	}
	
	
	/**
	 * push images and videos to the zip file
	 **/
	public function add_images_videos_to_zip($root = false){
		$this->used_images = array_merge($this->used_images, $this->used_videos);
		
		if(!empty($this->used_images)){
			$upload_dir			= $this->get_upload_path();
			$upload_dir_multi	= wp_upload_dir();
			$cont_url			= $this->get_val($upload_dir_multi, 'baseurl');
			$cont_url2			= (strpos($cont_url, 'http://') !== false) ? str_replace('http://', 'https://', $cont_url) : str_replace('https://', 'http://', $cont_url);
			$cont_url_no_www	= str_replace('www.', '', $cont_url);
			$cont_url2_no_www	= str_replace('www.', '', $cont_url2);
			$upload_dir_multi	= $this->get_val($upload_dir_multi, 'basedir').'/';
			
			foreach($this->used_images as $file => $val){
				//replace double // except the http:// https://
				$file = str_replace(array('http://', 'https://'), '!!!!!', $file);
				$file = str_replace('//', '/', $file);
				$file = str_replace('!!!!!', 'http://', $file);
				
				$add_path		= ($root === false) ? 'images/' : '';
				$add_structure	= ($root === false) ? 'images/'.$file : $file;
				if($root === false){
					$file_push = $file;
				}else{
					$file_expl = explode('.', $file);
					$extension = strtolower(end($file_expl));
					if(in_array($extension, array('jpg', 'jpeg', 'png', 'gif'))){
						$file_push = 'thumb.'.strtolower(end($file_expl));
					}else{
						$file_push = 'video.'.strtolower(end($file_expl));
					}
				}
				
				if(strpos($file, 'http') !== false){
					//check if we are in objects folder, if yes take the original image into the zip-
					$remove		= false;
					$checkpath	= str_replace(array($cont_url.'/', $cont_url_no_www.'/', $cont_url2.'/', $cont_url2_no_www.'/'), '', $file);
					
					$add_checkpath = ($root === false) ? 'images/'.$checkpath : $checkpath;
					if($root === true){
						$add_checkpath = explode('/', $add_checkpath);
						$add_checkpath = end($add_checkpath);
					}
					
					if(is_file($upload_dir.$checkpath)){
						if(!$this->usepcl){
							$this->zip->addFile($upload_dir.$checkpath, $add_checkpath);
						}else{
							$this->pclzip->add($upload_dir.$checkpath, PCLZIP_OPT_REMOVE_PATH, $upload_dir, PCLZIP_OPT_ADD_PATH, $add_path);
						}
						$remove = true;
					}elseif(is_file($upload_dir_multi.$checkpath)){
						if(!$this->usepcl){
							$this->zip->addFile($upload_dir_multi.$checkpath, $add_checkpath);
						}else{
							$this->pclzip->add($upload_dir_multi.$checkpath, PCLZIP_OPT_REMOVE_PATH, $upload_dir_multi, PCLZIP_OPT_ADD_PATH, $add_path);
						}
						$remove = true;
					}
					
					if($remove){ //as its http, remove this from strexport

						/*
						 * fixes an issue where external urls were not getting processed
						*/
						try {
							$unescaped = json_encode(json_decode($this->export_data), JSON_UNESCAPED_SLASHES); // only available from php 5.4
						}
						catch(Exception $e) {
							$unescaped = $this->export_data;
						}
						
						$this->export_data = str_replace(array($cont_url . '/' . $checkpath, $cont_url_no_www . '/' . $checkpath), $checkpath, $unescaped);
						// $this->export_data = str_replace(array($cont_url.$checkpath, $cont_url_no_www.$checkpath), $checkpath, $this->export_data);
					}
				}else{
					if(is_file($upload_dir.$file)){
						if(!$this->usepcl){
							$this->zip->addFile($upload_dir.$file, $add_structure);
						}else{
							$this->pclzip->add($upload_dir.$file, PCLZIP_OPT_REMOVE_PATH, $upload_dir, PCLZIP_OPT_ADD_PATH, $add_path);
						}
					}elseif(is_file($upload_dir_multi.$file)){
						if(!$this->usepcl){
							$this->zip->addFile($upload_dir_multi.$file, $add_structure);
						}else{
							$this->pclzip->add($upload_dir_multi.$file, PCLZIP_OPT_REMOVE_PATH, $upload_dir_multi, PCLZIP_OPT_ADD_PATH, $add_path);
						}
					}
				}
			}
		}

	}
	
	
	/**
	 * push the slider, slides and layer data to the zip
	 **/
	public function add_slider_export_to_zip($filename = 'slider_export.txt'){
		if(!$this->usepcl){
			$this->zip->addFromString($filename, $this->export_data);
		}else{
			$list = $this->pclzip->add(array(array(PCLZIP_ATT_FILE_NAME => $filename, PCLZIP_ATT_FILE_CONTENT => $this->export_data)));
			if($list == 0){
				die("ERROR : '".$this->pclzip->errorInfo(true)."'");
			}
		}
	}
	
	
	/**
	 * push the custom animations to the zip
	 **/
	public function add_animations_to_zip(){
		if(strlen(trim($this->animations_data)) > 0){
			if(!$this->usepcl){
				$this->zip->addFromString('custom_animations.txt', $this->animations_data); //add custom animations
			}else{
				$list = $this->pclzip->add(array(array(PCLZIP_ATT_FILE_NAME => 'custom_animations.txt', PCLZIP_ATT_FILE_CONTENT => $this->animations_data)));
				if($list == 0){
					die("ERROR : '".$this->pclzip->errorInfo(true)."'");
				}
			}
		}
	}
	
	
	/**
	 * push the custom css styles to the zip
	 **/
	public function add_styles_to_zip(){
		if(strlen(trim($this->style_data)) > 0){
			if(!$this->usepcl){
				$this->zip->addFromString('styles.txt', $this->style_data);
			}else{
				$list = $this->pclzip->add(array(array(PCLZIP_ATT_FILE_NAME => 'styles.txt', PCLZIP_ATT_FILE_CONTENT => $this->style_data)));
				if($list == 0){
					die("ERROR : '".$this->pclzip->errorInfo(true)."'");
				}
			}
		}
	}
	
	
	/**
	 * push the custom navigations to the zip
	 **/
	public function add_navigation_to_zip(){
		if(strlen(trim($this->navigation_data)) > 0){
			if(!$this->usepcl){
				$this->zip->addFromString('navigation.txt', $this->navigation_data);
			}else{
				$list = $this->pclzip->add(array(array(PCLZIP_ATT_FILE_NAME => 'navigation.txt', PCLZIP_ATT_FILE_CONTENT => $this->navigation_data)));
				if($list == 0){
					die("ERROR : '".$this->pclzip->errorInfo(true)."'");
				}
			}
		}
	}
	
	
	/**
	 * push the static styles to the zip
	 **/
	public function add_static_styles_to_zip(){
		$static_css = $this->get_static_css();
		if(trim($static_css) !== ''){
			if(!$this->usepcl){
				$this->zip->addFromString("static-captions.css", $static_css); //add slider settings
			}else{
				$list = $this->pclzip->add(array(array( PCLZIP_ATT_FILE_NAME => 'static-captions.css',PCLZIP_ATT_FILE_CONTENT => $static_css)));
				if ($list == 0) { die("ERROR : '".$this->pclzip->errorInfo(true)."'"); }
			}
		}
	}
	
	
	/**
	 * push the info.cfg to the zip
	 * allow for slider packs the automatic creation of the info.cfg
	 **/
	public function add_info_to_zip(){
		if(apply_filters('revslider_slider_pack_export', false)){
			if(!$this->usepcl){
				$this->zip->addFromString('info.cfg', md5($this->alias)); //add slider settings
			}else{
				$list = $this->pclzip->add(array(array(PCLZIP_ATT_FILE_NAME => 'info.cfg', PCLZIP_ATT_FILE_CONTENT => md5($this->alias))));
				if($list == 0){
					die("ERROR : '".$this->pclzip->errorInfo(true)."'");
				}
			}
		}
	}
	
	
	/**
	 * close the zip if we are not in pcl
	 **/
	public function close_export_zip(){
		if(!$this->usepcl){
			$this->zip->close();
		}
	}
	
	
	/**
	 * send the zip to the client browser
	 **/
	public function push_zip_to_client(){
		$exportname = (!empty($this->slider_alias)) ? $this->slider_alias.'.zip' : 'slider_export.zip';
		
		header('Content-type: application/zip');
		header('Content-Disposition: attachment; filename='.$exportname);
		header('Pragma: no-cache');
		header('Expires: 0');
		readfile($this->export_path_zip);
	}
	
	
	/**
	 * delete the export zip file, ignoring errors
	 **/
	public function delete_export_zip(){
		@unlink($this->export_path_zip);
	}
	
	
	/**
	 * Export a Zip with video, thumbnail and layergroup for import
	 * @dev function
	 **/
	public function export_layer_group($videoid, $thumbid, $layers){
		$this->create_export_zip();
		
		$this->slider_alias = 'layergroup';
		$this->used_images[$this->get_url_attachment_image($thumbid)] = true;
		$this->used_videos[$this->get_url_attachment_image($videoid)] = true;
		$this->add_images_videos_to_zip(true);
		$this->export_data = stripslashes($layers);
		$this->add_slider_export_to_zip('layers.txt');
		$this->close_export_zip();
		
		return $this->export_url_zip;
	}
}