<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderObjectLibrary extends RevSliderFunctions {

	private $library_list		= 'library.php';
	private $library_download	= 'download.php';
	private $object_thumb_path	= '/revslider/objects/thumbs/';
	private $object_orig_path	= '/revslider/objects/';
	private $customsvgpath		= '/revslider/svg/objects/';
	private $sizes				= array('75', '50', '25', '10');
	private $curl_check			= null;
	private $font_icon_paths;
	public	$upload_dir;
	public	$download_path;
	public	$svg_remove_path;
	public	$allowed_types		= array('thumb', 'video', 'video_thumb');
	public	$allowed_categories	= array('svgcustom');
	
	const LIBRARY_VERSION		= '2.0.0';


	public function __construct(){
		$this->upload_dir = wp_upload_dir();

		$this->font_icon_paths = array(
			RS_PLUGIN_PATH.'public/assets/fonts/font-awesome/css/font-awesome.css',
			RS_PLUGIN_PATH.'public/assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css'
		);
		$this->font_icon_paths = apply_filters('revslider_object_library_icon_paths', $this->font_icon_paths);
	}

	/**
	 * get available sizes
	 * @since: 6.1.4
	 **/
	public function get_sizes(){
		return $this->sizes;
	}

	/**
	 * get list of objects
	 * @since: 5.3.0
	 */
	public function _get_list($force = false){
		$rslb		= RevSliderGlobals::instance()->get('RevSliderLoadBalancer');
		$last_check	= get_option('revslider-library-check');

		if($last_check == false){ //first time called
			$last_check = 1296001;
			update_option('revslider-library-check', time());
		}

		// Get latest object list
		if(time() - $last_check > 1296000 || $force == true){ //30 days
			update_option('revslider-library-check', time());

			$validated = get_option('revslider-valid', 'false');
			$code = ($validated == 'false') ? '' : get_option('revslider-code', '');
			$hash = get_option('revslider-library-hash', '');
			$rattr = array(
				'library_version' => urlencode(self::LIBRARY_VERSION),
				'hash'		=> urlencode($hash),
				'code'		=> urlencode($code),
				'version'	=> urlencode(RS_REVISION),
				'product'	=> urlencode(RS_PLUGIN_SLUG)
			);
			$request = $rslb->call_url($this->library_list, $rattr, 'library');

			if(!is_wp_error($request)){
				if($response = maybe_unserialize($request['body'])){
					if('actual' != $response){
						$library = json_decode($response, true);

						if(is_array($library)){
							if(isset($library['hash'])) update_option('revslider-library-hash', $library['hash']);
							update_option('rs-library', $library, false);
						}
					}
				}
			}
		}
	}

	/**
	 * check if given URL is an object from object library
	 * @since: 5.3.0
	 */
	public function _is_object($url){
		$url		= $this->get_correct_size_url($url, 100, true);
		$is_object	= false;
		$upload_url	= $this->upload_dir['baseurl'] . $this->object_orig_path;
		$file_name	= explode('/', $url);
		$file_name	= $file_name[count($file_name) - 1];

		if(strpos($url, $upload_url) !== false){
			//check now if handle is inside of the array of objects
			$obj	= $this->load_objects_with_svg();
			$online = $obj['online']['objects'];

			foreach($online as $object){
				if($object['handle'] == $file_name){
					$is_object = true;
					break;
				}
			}
		}

		return $is_object;
	}


	/**
	 * check if given URL is existing in the object library
	 * @since: 5.3.0
	 */
	public function _does_exist($url){
		$url = str_replace($this->upload_dir['baseurl'] . $this->object_orig_path, '', $url);
		return file_exists($this->upload_dir['basedir'] . $this->object_orig_path . $url);
	}

	/**
	 * check if certain object needs to be redownloaded
	 * @since: 5.3.0
	 */
	public function _check_object_exist($object_url){
		//then check if it is existing
		if($this->_is_object($object_url)){
			if(!$this->_does_exist($object_url)){ //if not, redownload if allowed
				$fnwe = explode('/', $object_url);
				$fnwe = $fnwe[count($fnwe) - 1];
				$this->_get_object_thumb($fnwe, 'orig');
			}
		}
	}

	/**
	 * get certain object handle by the given ID
	 * @since: 6.0
	 */
	public function get_object_handle_by_id($id){
		$handle	 = '';
		$full	 = get_option('rs-library', array());
		$objects = $this->get_val($full, 'objects', array());

		if(!empty($objects)){
			foreach($objects as $obj){
				if($obj['id'] == $id){
					$handle = $this->get_val($obj, 'handle');
					break;
				}
			}
		}

		return $handle;
	}

	/**
	 * get certain objects thumbnail, download if needed and if not, simply return path
	 * @since: 5.3.0
	 */
	public function _get_object_thumb($object_handle, $type, $download = false){
		if(intval($object_handle) > 0){
			$object_handle = $this->get_object_handle_by_id($object_handle);
		}else{ //check if we are original image and if not change it to original image
			$object_handle = $this->get_object_handle_by_downsized($object_handle);
		}

		if($type == 'video_full'){
			$object_handle = str_replace('.jpg', '.mp4', $object_handle);
		}

		$error		= '';
		$path		= (in_array($type, $this->allowed_types, true)) ? $this->object_thumb_path : $this->object_orig_path;
		$file		= $this->upload_dir['basedir'] . $path . $object_handle;
		$url_file	= $this->upload_dir['baseurl'] . $path . $object_handle;
		$validated	= get_option('revslider-valid', 'false');
		$_download	= !is_file($file); //check if object thumb is already downloaded

		if($validated == 'false' && !in_array($type, $this->allowed_types, true)){
			return array('error' => __('Plugin not activated', 'revslider'));
		}

		// Check folder permission and define file location
		if($_download && $download === true && wp_mkdir_p($this->upload_dir['basedir'].$path)){
			$curl = ($this->check_curl_connection()) ? new WP_Http_Curl() : false;
			$file = $this->upload_dir['basedir'] . $path . $object_handle;

			if(!is_file($file)){
				$image_data = false;

				if($curl !== false){
					if($validated == 'false' && !in_array($type, $this->allowed_types, true)){
						$error = __('Plugin not activated', 'revslider');
					}else{
						$rslb	= RevSliderGlobals::instance()->get('RevSliderLoadBalancer');
						$code	= ($validated == 'false') ? '' : get_option('revslider-code', '');
						$rattr	= array(
							'library_version' => urlencode(self::LIBRARY_VERSION),
							'version'	=> urlencode(RS_REVISION),
							'handle'	=> urlencode($object_handle),
							'download'	=> urlencode($type),
							'product'	=> urlencode(RS_PLUGIN_SLUG)
						);

						$http_force = false;
						if(!in_array($type, $this->allowed_types, true)){
							$rattr['code']	= urlencode($code); //push code only if needed
							$http_force		= true; //force http
						}

						$image_data = $rslb->call_url($this->library_download, $rattr, 'library', $http_force);

						if(!is_wp_error($image_data) && isset($image_data['body']) && isset($image_data['response']) && isset($image_data['response']['code']) && $image_data['response']['code'] == '200'){
							$image_data = $image_data['body'];
							//check body for errors in here
							$check = json_decode($image_data, true);
							if(!empty($check)){
								if(isset($check['error'])){
									$image_data = false;
									$error = $check['error'];
								}
							}elseif(trim($image_data) == ''){
								$error = __('No data received', 'revslider');
							}
						}else{
							$image_data = false;
							$error = __('Error downloading object', 'revslider');
						}
					}
				}

				if($image_data !== false && $image_data !== ''){
					@mkdir(dirname($file));
					@file_put_contents($file, $image_data);

					if($type == 'video' || $type == 'video_thumb'){

					}else{
						$this->create_image_dimensions($object_handle);
					}

				}else{//could not connect to server
					$error = __('Error downloading object', 'revslider');
				}
			}else{//use default image
				$error = __('Error downloading object', 'revslider');
			}
		}

		if($error !== ''){
			return array('error' => $error);
		}

		$width = false;
		$height = false;

		//get dimensions of image
		if(is_file($file)){
			$imgsize = @getimagesize($file);
			if($imgsize !== false){
				$width	= $this->get_val($imgsize, '0');
				$height	= $this->get_val($imgsize, '1');
			}
		}else{
			$url_file = $object_handle;
		}

		return array('error' => false, 'url' => $url_file, 'width' => $width, 'height' => $height);
	}

	/**
	 * gets the original image name if the given one is not the orig file
	 * -75-50x100
	 * -75
	 **/
	public function get_object_handle_by_downsized($object_handle){
		$object_handle = basename($object_handle);
		$tmp = explode('.', $object_handle);
		if(count($tmp) > 1){
			$_tmp = explode('-', $tmp[0]);
			if(count($_tmp) > 1){
				//check last if it has an x or is an integeter like 50
				$e = array_pop($_tmp);
				$x = false;
				if(strpos($e, 'x') !== false){
					$_e = str_replace('x', '', $e);
					$x = (intval($_e) > 0) ? true : $x;
				}
				$object_handle = ($x === true || in_array($e, $this->sizes)) ? str_replace('-'.$e, '', $object_handle): $object_handle;
				//check again last if it is an integeter like 50
				$e = array_pop($_tmp);
				$object_handle = (in_array($e, $this->sizes)) ? str_replace('-'.$e, '', $object_handle) : $object_handle;
			}
		}

		return $object_handle;
	}


	/**
	 * import object layer from ThemePunch Server
	 * @since: 6.0.0
	 */
	public function _get_object_layers($object_id){
		$rslb		= RevSliderGlobals::instance()->get('RevSliderLoadBalancer');
		$error		= '';

		if(intval($object_id) > 0){
			$object_handle = $this->get_object_handle_by_id($object_id);
		}else{
			$error = __('Error downloading layers', 'revslider');
			return array('error' => $error);
		}

		$curl = ($this->check_curl_connection()) ? new WP_Http_Curl() : false;

		$layers_data = false;
		if($curl !== false){
			$validated = get_option('revslider-valid', 'false');

			if($validated == 'false'){
				$error = __('Plugin not activated', 'revslider');
			}else{
				$code	= ($validated == 'false') ? '' : get_option('revslider-code', '');
				$rattr	= array(
					'code'		=> urlencode($code),
					'library_version' => urlencode(self::LIBRARY_VERSION),
					'version'	=> urlencode(RS_REVISION),
					'handle'	=> urlencode($object_handle),
					'download'	=> urlencode('layers'),
					'product'	=> urlencode(RS_PLUGIN_SLUG)
				);

				$layers_data = $rslb->call_url($this->library_download, $rattr, 'library');

				if(!is_wp_error($layers_data) && isset($layers_data['body']) && isset($layers_data['response']) && isset($layers_data['response']['code']) && $layers_data['response']['code'] == '200'){
					$layers_data = $layers_data['body'];
					//check body for errors in here
					$check = json_decode($layers_data, true);
					if(!empty($check)){
						if(isset($check['error'])){
							$layers_data = false;
							$error = $check['error'];
						}
					}elseif(trim($layers_data) == ''){
						$error = __('No data received', 'revslider');
					}
				}else{
					$layers_data = false;
					$error = __('Error downloading layers data', 'revslider');
				}
			}
		}

		//could not connect to server
		$error = ($layers_data === false && $error == '') ? __('Error downloading layers data', 'revslider') : $error;

		if($error !== '') return array('error' => $error);

		$data = json_decode($layers_data, true);
		$data = (empty($data)) ? json_decode(stripslashes($layers_data), true) : $data;

		if(!empty($data)){
			foreach($data as $k => $v){
				$svg_source = $this->get_val($data[$k], array('svg', 'source'));
				if(!empty($svg_source)){
					$t = explode('/wp-content/plugins/revslider/', $svg_source);
					if(is_array($t) && count($t) == 2){
						$this->set_val($data, array($k, 'svg', 'source'), RS_PLUGIN_URL.$t[1]);
					}
				}
			}
		}

		return array('error' => false, 'data' => $data);
	}


	/**
	 * import object to media library
	 * @since: 5.3.0
	 */
	public function _import_object($file_path){
		$obj_handle = basename($file_path);
		$file		= $this->upload_dir['basedir'] . $this->object_orig_path . $obj_handle;
		$url_file	= $this->upload_dir['baseurl'] . $this->object_orig_path . $obj_handle;

		$image_handle = @fopen($file_path, 'r');

		if($image_handle != false){
			$image_data = stream_get_contents($image_handle);
			if($image_data !== false){
				@mkdir(dirname($file));
				@file_put_contents($file, $image_data);

				$this->create_image_dimensions($obj_handle);

				return array('path' => $url_file);
			}
		}

		return false;
	}


	public function load_objects_with_svg(){
		$obj	= array('svg' => $this->get_svg_sets_full());
		$online	= get_option('rs-library', array());

		if(!empty($online)){
			$obj['online'] = $online;
		}

		return $obj;
	}


	public function get_svg_categories(){
		$svgs = $this->get_svg_sets_url();

		$svg_cat = array();
		if(!empty($svgs)){
			foreach($svgs as $cat => $svg){
				if(trim($cat) !== '' && !isset($svg_cat[$cat])) $svg_cat[$cat] = ucwords($cat);
			}
		}

		return $svg_cat;
	}


	public function load_objects($type = 'all'){
		//type 1 = object
		//type 2 = image
		//type 3 = video

		switch($type){
			case '1':
				$ftype = 'objects';
			break;
			case '2':
				$ftype = 'images';
			break;
			case '3';
				$ftype = 'videos';
			break;
			case '4';
				$ftype = 'layer';
			break;
			default:
				$ftype = 'images';
			break;
		}

		$full = get_option('rs-library', array());
		$objects = $this->get_val($full, 'objects', array());
		if(!empty($objects)){
			$favorite = RevSliderGlobals::instance()->get('RevSliderFavorite');;

			foreach($objects as $key => $obj){
				$t = 'thumb';

				if($type !== 'all'){
					if($type !== $obj['type']){
						unset($objects[$key]);
						continue;
					}
				}

				$t = ($obj['type'] == '3') ? 'video' : $t;

				$objects[$key]['title'] = $this->get_val($obj, 'name');
				unset($objects[$key]['name']);

				$img = $this->get_val($obj, 'handle');
				$objects[$key]['img'] = $this->get_val($obj, 'handle');
				if($type == '3' || $type == '4'){
					$objects[$key]['video_thumb'] = array(
						'error' => false,
						'url'	=> $this->get_val($obj, 'video'),
						'width' => false,
						'height' => false
					);
				}

				$objects[$key]['orig'] = $this->get_val($img, 'orig', '');
				unset($objects[$key]['type']);

				$tags		= $this->get_val($obj, 'tags', array());
				$new_tags	= array();
				if(!empty($tags)){
					foreach($tags as $tag){
						$new_tags[] = $this->get_val($tag, 'handle');
					}
				}
				$objects[$key]['tags'] = $new_tags;

				$objects[$key]['favorite'] = $favorite->is_favorite($ftype, $key);
			}
		}

		return $objects;
	}

	public function get_objects_categories($type = 'all'){
		//type 1 = object
		//type 2 = image

		$full		= get_option('rs-library', array());
		$tags_raw	= $this->get_val($full, 'tags');
		$objects	= $this->get_val($full, 'objects', array());
		$tags		= array();

		if(!empty($objects)){
			foreach($objects as $key => $obj){
				if($type !== 'all'){
					if($type !== $obj['type']){
						continue;
					}
				}

				$new_tags = $this->get_val($obj, 'tags', array());
				if(!empty($new_tags)){
					foreach($new_tags as $tag){
						$tag_handle = $this->get_val($tag, 'handle');
						if(!isset($tags[$tag_handle])){
							$name = $tag_handle;
							if(!empty($tags_raw)){
								foreach($tags_raw as $tags_raw_data){
									if($this->get_val($tags_raw_data, 'handle') == $tag_handle){
										$name = $this->get_val($tags_raw_data, 'name');
										break;
									}
								}
							}
							$tags[$tag_handle] = $name;
						}
					}
				}
			}
		}

		return $tags;
	}


	public function create_image_dimensions($handle, $force = false){
		$img_editor_test = wp_image_editor_supports(array('methods' => array('resize', 'save')));
		if($img_editor_test !== true){
			return false;
		}

		$upload_directory = $this->upload_dir['basedir'] . $this->object_orig_path;
		$image_path		= $upload_directory.$handle;
		$file_name_we	= explode('/', $image_path);
		$file_name_we	= $file_name_we[count($file_name_we) - 1];
		$file_name_woe	= explode('.', $file_name_we);
		$file_ending	= $file_name_woe[count($file_name_woe) - 1];
		$file_name_woe	= $file_name_woe[count($file_name_woe) - 2];
		$image			= wp_get_image_editor($image_path);

		if(is_file($image_path)){
			$imgsize = getimagesize($image_path);
		}else{
			$imgsize = false;
		}

		if(!is_wp_error($image) && $imgsize !== false) {
			$orig_width	 = $this->get_val($imgsize, '0');
			$orig_height = $this->get_val($imgsize, '1');

			foreach($this->sizes as $size){
				$modified_file_name_without_ending = $file_name_woe . '-' . $size;
				if(!file_exists($upload_directory.$modified_file_name_without_ending.'.'.$file_ending) || $force){
					$width	= round($orig_width / 100 * $size, 0);
					$height	= round($orig_height / 100 * $size, 0);

					$image->resize($width, $height);
					$image->save($upload_directory.$modified_file_name_without_ending.'.'.$file_ending);
				}
			}
		}else{ //cant create images
			return false;
		}

		return true;
	}

	/**
	 * Check if Curl can be used
	 */
	public function check_curl_connection(){
		if($this->curl_check !== null) return $this->curl_check;
		$curl = new WP_Http_Curl();
		$this->curl_check = $curl->test();
		return $this->curl_check;
	}

	/**
	 * Returns an URL if it is an object library image, depending on the choosen width/height
	 */
	public function get_correct_size_url($image_id, $size, $full = false){
		if(intval($image_id) > 0){
			$object_handle = $this->get_object_handle_by_id($image_id);
		}else{
			$object_handle = $this->get_object_handle_by_downsized($image_id);
		}

		$image_path	= $this->upload_dir['basedir'] . $this->object_orig_path . $object_handle;
		$_image_path = $this->upload_dir['basedir'] . $this->object_orig_path;
		$image_url	= $this->upload_dir['baseurl'] . $this->object_orig_path;

		if(!file_exists($image_path)) return '';
		if(!in_array($size, $this->sizes) && $full === false) return '';

		if($full === false){
			$file_split = explode('.', $object_handle);

			if(count($file_split) === 2 && file_exists($_image_path.$file_split[0].'-'.$size.'.'.$file_split[1])){
				$image_url .= $file_split[0].'-'.$size.'.'.$file_split[1];
			}else{
				$image_url .= $object_handle;
			}
		}else{
			$image_url .= $object_handle;
		}

		return $image_url;
	}

	/**
	 * get list of favorites
	 * @since: 5.3.0
	 */
	public function get_favorites(){
		return get_option('rs_obj_favorites', array());
	}


	/**
	 * save list of favorites
	 * @since: 5.3.0
	 */
	public function save_favorites($favourites){
		update_option('rs_obj_favorites', $favourites);
	}


	/**
	 * get all the svg url sets used in Slider Revolution
	 * @since: 5.1.7
	 * @before: RevSliderBase::get_svg_sets_url();
	 **/
	public function get_svg_sets_url(){
		$svg_sets = array();

		$path	= RS_PLUGIN_PATH . 'public/assets/assets/svg/';
		$url	= RS_PLUGIN_URL . 'public/assets/assets/svg/';

		if(!file_exists($path.'action/ic_3d_rotation_24px.svg')){ //the path needs to be changed to the uploads folder then
			$path	= $this->upload_dir['basedir'].'/revslider/assets/svg/';
			$url	= $this->upload_dir['baseurl'].'/revslider/assets/svg/';
		}

		//search in each folder that is in $path for subfolder

		$svg_sets['Actions']	= array('path' => $path.'action/', 'url' => $url.'action/');
		$svg_sets['Alerts']		= array('path' => $path.'alert/', 'url' => $url.'alert/');
		$svg_sets['AV']			= array('path' => $path.'av/', 'url' => $url.'av/');
		$svg_sets['Communication'] = array('path' => $path.'communication/', 'url' => $url.'communication/');
		$svg_sets['Content']	= array('path' => $path.'content/', 'url' => $url.'content/');
		$svg_sets['Device']		= array('path' => $path.'device/', 'url' => $url.'device/');
		$svg_sets['Editor']		= array('path' => $path.'editor/', 'url' => $url.'editor/');
		$svg_sets['File']		= array('path' => $path.'file/', 'url' => $url.'file/');
		$svg_sets['Hardware']	= array('path' => $path.'hardware/', 'url' => $url.'hardware/');
		$svg_sets['Images']		= array('path' => $path.'image/', 'url' => $url.'image/');
		$svg_sets['Maps']		= array('path' => $path.'maps/', 'url' => $url.'maps/');
		$svg_sets['Navigation']	= array('path' => $path.'navigation/', 'url' => $url.'navigation/');
		$svg_sets['Notifications'] = array('path' => $path.'notification/', 'url' => $url.'notification/');
		$svg_sets['Places']		= array('path' => $path.'places/', 'url' => $url.'places/');
		$svg_sets['Social']		= array('path' => $path.'social/', 'url' => $url.'social/');
		$svg_sets['Toggle']		= array('path' => $path.'toggle/', 'url' => $url.'toggle/');

		return apply_filters('revslider_get_svg_sets', $svg_sets);
	}


	/**
	 * get all the svg files for given sets used in Slider Revolution
	 * @since: 5.1.7
	 * @before: RevSliderBase::get_svg_sets_full();
	 **/
	public function get_svg_sets_full(){
		$favorite = RevSliderGlobals::instance()->get('RevSliderFavorite');;
		$svg_sets = $this->get_svg_sets_url();
		$svg	  = array();
		$id		  = 1;

		if(!empty($svg_sets)){
			foreach($svg_sets as $category => $values){
				if($dir = opendir($values['path'])) {
					while(false !== ($file = readdir($dir))){
						if($file != '.' && $file != '..') {
							$filetype = pathinfo($file);
							if(isset($filetype['extension']) && $filetype['extension'] == 'svg'){

								$title = substr($file, 3);
								$title = str_replace('_', ' ', $title);
								$title = str_replace(array('px.svg', '.svg'), '', $title);

								$title = explode(' ', $title);
								$le	   = array_pop($title);
								if(intval($le) == 0){
									$title[] = $le;
								}
								$title = implode(' ', $title);

								$svg[] = array(
									'id'		=> $id,
									'handle'	=> $file,
									'title'		=> ucwords($title),
									'tags'		=> array($category),
									'img'		=> $values['url'].$file,
									'favorite'	=> $favorite->is_favorite('svgs', $file)
								);

								$id++;
							}
						}
					}
				}
			}
		}

		return apply_filters('revslider_get_svg_sets_full', $svg);
	}
	
	/**
	 * get all custom svgs
	 **/
	public function get_custom_svgs(){
		$favorite = RevSliderGlobals::instance()->get('RevSliderFavorite');;
		$library  = get_option('rs-custom-library', array());
		$svgcustom = array();

		if(!empty($library)){
			foreach($library as $category => $values){
				if($category !== 'svgcustom') continue;
				if(!isset($values['items']) || empty($values['items'])) continue;
				
				foreach($values['items'] as $item){
					$id = $this->get_val($item, 'id');
					$item['favorite'] = $favorite->is_favorite('svgcustom', $id);
					$svgcustom[] = $item;
				}
			}
		}

		return apply_filters('revslider_get_custom_svgs', $svgcustom);
	}


	public function get_font_icons(){
		$css		= RevSliderGlobals::instance()->get('RevSliderCssParser');
		$font_icons = array();

		//check all fonts folders
		$favorite = RevSliderGlobals::instance()->get('RevSliderFavorite');

		foreach($this->font_icon_paths as $file){
			//let the fonts be read by the CSS class
			$css_content = file_get_contents($file);

			$css_arr = $css->css_to_array($css_content);

			if(!empty($css_arr)){
				foreach($css_arr as $handle => $value){
					if(substr($handle, 0, 1) != '.') continue;
					$handle	 = str_replace(PHP_EOL, '', $handle); //remove newlines
					$handles = array();
					$raw	 = explode(',', $handle); //separates if more then one exists

					if(!empty($raw)){
						if(!is_array($raw)) $raw = (array)$raw;
						foreach($raw as $raw_font){
							$fonts = explode(':', $raw_font);
							if(!empty($fonts)){
								if(!is_array($fonts)) $fonts = (array)$fonts;
								$add = false;
								foreach($fonts as $font){
									if($font == 'before'){
										$add = true;
										break;
									}
								}
								if($add === true){
									$handles[] = $this->get_val($fonts, 0);
								}
							}
							break; //break to only get the first class, to have not multiple same icons listed
						}
					}

					foreach($handles as $handle){
						$tags = array();
						if(strpos($handle, '.fa-icon') !== false || strpos($handle, '.fa.fa-icon') !== false || strpos($handle, '.fa') !== false){
							$tags[] = 'FontAwesome';
						}
						if(strpos($handle, '.pe-7s-') !== false){
							$tags[] = 'StrokeIcons7';
						}

						$title = str_replace(array('.fa-icon', '.fa', '.pe-7s-', '.'), '', $handle);
						$title = str_replace('-', ' ', $title);
						$title = ucwords($title);

						$font_icons[] = array(
							'handle'	=> $handle,
							'title'		=> $title,
							'group'		=> 'icon',
							'tags'		=> $tags,
							'type'		=> 'icon',
							'favorite'	=> $favorite->is_favorite('fonticons', $handle),
							'src'		=> $handle
						);
					}
				}
			}
		}

		$material_icons = $this->get_material_icons();
		if(!empty($material_icons)){
			foreach($material_icons as $icon){
				$font_icons[] = array(
					'handle'	=> $icon,
					'title'		=> ucwords(str_replace('_', ' ', $icon)),
					'group'		=> 'icon',
					'tags'		=> array('MaterialIcons'),
					'type'		=> 'icon',
					'favorite'	=> $favorite->is_favorite('fonticons', $icon),
					'src'		=> $icon
				);
			}
		}

		return apply_filters('revslider_get_font_icons', $font_icons);
	}


	public function get_material_icons(){
		return array(
			'360', '3d_rotation', '4k',
			'ac_unit', 'access_alarm', 'access_alarms', 'access_time', 'accessibility', 'accessibility_new', 'accessible', 'accessible_forward', 'account_balance', 'account_balance_wallet', 'account_box', 'account_circle', 'adb', 'add', 'add_a_photo', 'add_alarm', 'add_alert', 'add_box', 'add_circle', 'add_circle_outline', 'add_comment', 'add_location', 'add_photo_alternate', 'add_shopping_cart', 'add_to_home_screen', 'add_to_photos', 'add_to_queue', 'adjust', 'airline_seat_flat', 'airline_seat_flat_angled', 'airline_seat_individual_suite', 'airline_seat_legroom_extra', 'airline_seat_legroom_normal', 'airline_seat_legroom_reduced', 'airline_seat_recline_extra', 'airline_seat_recline_normal', 'airplanemode_active', 'airplanemode_inactive', 'airplay', 'airport_shuttle', 'alarm', 'alarm_add', 'alarm_off', 'alarm_on', 'album', 'all_inclusive', 'all_out', 'alternate_email', 'android', 'announcement', 'apps', 'archive', 'arrow_back', 'arrow_back_ios', 'arrow_downward', 'arrow_drop_down', 'arrow_drop_down_circle', 'arrow_drop_up', 'arrow_forward', 'arrow_forward_ios', 'arrow_left', 'arrow_right', 'arrow_right_alt', 'arrow_upward', 'art_track', 'aspect_ratio', 'assessment', 'assignment', 'assignment_ind', 'assignment_late', 'assignment_return', 'assignment_returned', 'assignment_turned_in', 'assistant', 'assistant_photo', 'atm', 'attach_file', 'attach_money', 'attachment', 'audiotrack', 'autorenew', 'av_timer',
			'backspace', 'backup', 'ballot', 'bar_chart', 'battery_alert', 'battery_charging_full', 'battery_full', 'battery_std', 'battery_unknown', 'beach_access', 'beenhere', 'block', 'bluetooth', 'bluetooth_audio', 'bluetooth_connected', 'bluetooth_disabled', 'bluetooth_searching', 'blur_circular', 'blur_linear', 'blur_off', 'blur_on', 'book', 'bookmark', 'bookmark_border', 'bookmarks', 'border_all', 'border_bottom', 'border_clear', 'border_color', 'border_horizontal', 'border_inner', 'border_left', 'border_outer', 'border_right', 'border_style', 'border_top', 'border_vertical', 'branding_watermark', 'brightness_1', 'brightness_2', 'brightness_3', 'brightness_4', 'brightness_5', 'brightness_6', 'brightness_7', 'brightness_auto', 'brightness_high', 'brightness_low', 'brightness_medium', 'broken_image', 'brush', 'bubble_chart', 'bug_report', 'build', 'burst_mode', 'business', 'business_center',
			'cached', 'cake', 'calendar_today', 'calendar_view_day', 'call', 'call_end', 'call_made', 'call_merge', 'call_missed', 'call_missed_outgoing', 'call_received', 'call_split', 'call_to_action', 'camera', 'camera_alt', 'camera_enhance', 'camera_front', 'camera_rear', 'camera_roll', 'cancel', 'cancel_presentation', 'card_giftcard', 'card_membership', 'card_travel', 'casino', 'cast', 'cast_connected', 'cast_for_education', 'category', 'cell_wifi', 'center_focus_strong', 'center_focus_weak', 'change_history', 'chat', 'chat_bubble', 'chat_bubble_outline', 'check', 'check_box', 'check_box_outline_blank', 'check_circle', 'check_circle_outline', 'chevron_left', 'chevron_right', 'child_care', 'child_friendly', 'chrome_reader_mode', 'class', 'clear', 'clear_all', 'close', 'closed_caption', 'cloud', 'cloud_circle', 'cloud_done', 'cloud_download', 'cloud_off', 'cloud_queue', 'cloud_upload', 'code', 'collections', 'collections_bookmark', 'color_lens', 'colorize', 'comment', 'commute', 'compare', 'compare_arrows', 'compass_calibration', 'computer', 'confirmation_number', 'contact_mail', 'contact_phone', 'contact_support', 'contacts', 'control_camera', 'control_point', 'control_point_duplicate', 'copyright', 'create', 'create_new_folder', 'credit_card', 'crop', 'crop_16_9', 'crop_3_2', 'crop_5_4', 'crop_7_5', 'crop_din', 'crop_free', 'crop_landscape', 'crop_original', 'crop_portrait', 'crop_rotate', 'crop_square',
			'dashboard', 'data_usage', 'date_range', 'dehaze', 'delete', 'delete_forever', 'delete_outline', 'delete_sweep', 'departure_board', 'description', 'desktop_mac', 'desktop_windows', 'details', 'developer_board', 'developer_mode', 'device_hub', 'device_unknown', 'devices', 'devices_other', 'dialer_sip', 'dialpad', 'directions', 'directions_bike', 'directions_boat', 'directions_bus', 'directions_car', 'directions_railway', 'directions_run', 'directions_subway', 'directions_transit', 'directions_walk', 'disc_full', 'dns', 'dock', 'domain', 'domain_disabled', 'done', 'done_all', 'done_outline', 'donut_large', 'donut_small', 'drafts', 'drag_handle', 'drag_indicator', 'drive_eta', 'dvr',
			'edit', 'edit_attributes', 'edit_location', 'eject', 'email', 'enhanced_encryption', 'equalizer', 'error', 'error_outline', 'euro_symbol', 'ev_station', 'event', 'event_available', 'event_busy', 'event_note', 'event_seat', 'exit_to_app', 'expand_less', 'expand_more', 'explicit', 'explore', 'explore_off', 'exposure', 'exposure_neg_1', 'exposure_neg_2', 'exposure_plus_1', 'exposure_plus_2', 'exposure_zero', 'extension',
			'face', 'fast_forward', 'fast_rewind', 'fastfood', 'favorite', 'favorite_border', 'featured_play_list', 'featured_video', 'feedback', 'fiber_dvr', 'fiber_manual_record', 'fiber_new', 'fiber_pin', 'fiber_smart_record', 'file_copy', 'filter', 'filter_1', 'filter_2', 'filter_3', 'filter_4', 'filter_5', 'filter_6', 'filter_7', 'filter_8', 'filter_9', 'filter_9_plus', 'filter_b_and_w', 'filter_center_focus', 'filter_drama', 'filter_frames', 'filter_hdr', 'filter_list', 'filter_none', 'filter_tilt_shift', 'filter_vintage', 'find_in_page', 'find_replace', 'fingerprint', 'first_page', 'fitness_center', 'flag', 'flare', 'flash_auto', 'flash_off', 'flash_on', 'flight', 'flight_land', 'flight_takeoff', 'flip', 'flip_to_back', 'flip_to_front', 'folder', 'folder_open', 'folder_shared', 'folder_special', 'font_download', 'format_align_center', 'format_align_justify', 'format_align_left', 'format_align_right', 'format_bold', 'format_clear', 'format_color_fill', 'format_color_reset', 'format_color_text', 'format_indent_decrease', 'format_indent_increase', 'format_italic', 'format_line_spacing', 'format_list_bulleted', 'format_list_numbered', 'format_list_numbered_rtl', 'format_paint', 'format_quote', 'format_shapes', 'format_size', 'format_strikethrough', 'format_textdirection_l_to_r', 'format_textdirection_r_to_l', 'format_underlined', 'forum', 'forward', 'forward_10', 'forward_30', 'forward_5', 'free_breakfast', 'fullscreen', 'fullscreen_exit', 'functions',
			'g_translate', 'gamepad', 'games', 'gavel', 'gesture', 'get_app', 'gif', 'golf_course', 'gps_fixed', 'gps_not_fixed', 'gps_off', 'grade', 'gradient', 'grain', 'graphic_eq', 'grid_off', 'grid_on', 'group', 'group_add', 'group_work',
			'hd', 'hdr_off', 'hdr_on', 'hdr_strong', 'hdr_weak', 'headset', 'headset_mic', 'healing', 'hearing', 'help', 'help_outline', 'high_quality', 'highlight', 'highlight_off', 'history', 'home', 'horizontal_split', 'hot_tub', 'hotel', 'hourglass_empty', 'hourglass_full', 'how_to_reg', 'how_to_vote', 'http', 'https',
			'image', 'image_aspect_ratio', 'image_search', 'import_contacts', 'import_export', 'important_devices', 'inbox', 'indeterminate_check_box', 'info', 'input', 'insert_chart', 'insert_chart_outlined', 'insert_comment', 'insert_drive_file', 'insert_emoticon', 'insert_invitation', 'insert_link', 'insert_photo', 'invert_colors', 'invert_colors_off', 'iso',
			'keyboard', 'keyboard_arrow_down', 'keyboard_arrow_left', 'keyboard_arrow_right', 'keyboard_arrow_up', 'keyboard_backspace', 'keyboard_capslock', 'keyboard_hide', 'keyboard_return', 'keyboard_tab', 'keyboard_voice', 'kitchen',
			'label', 'label_important', 'label_off', 'landscape', 'language', 'laptop', 'laptop_chromebook', 'laptop_mac', 'laptop_windows', 'last_page', 'launch', 'layers', 'layers_clear', 'leak_add', 'leak_remove', 'lens', 'library_add', 'library_books', 'library_music', 'line_style', 'line_weight', 'linear_scale', 'link', 'link_off', 'linked_camera', 'list', 'list_alt', 'live_help', 'live_tv', 'local_activity', 'local_airport', 'local_atm', 'local_bar', 'local_cafe', 'local_car_wash', 'local_convenience_store', 'local_dining', 'local_drink', 'local_florist', 'local_gas_station', 'local_grocery_store', 'local_hospital', 'local_hotel', 'local_laundry_service', 'local_library', 'local_mall', 'local_movies', 'local_offer', 'local_parking', 'local_pharmacy', 'local_phone', 'local_pizza', 'local_play', 'local_post_office', 'local_printshop', 'local_see', 'local_shipping', 'local_taxi', 'location_city', 'location_disabled', 'location_off', 'location_on', 'location_searching', 'lock', 'lock_open', 'looks', 'looks_3', 'looks_4', 'looks_5', 'looks_6', 'looks_one', 'looks_two', 'loop', 'loupe', 'low_priority', 'loyalty',
			'mail', 'mail_outline', 'map', 'markunread', 'markunread_mailbox', 'maximize', 'meeting_room', 'memory', 'menu', 'merge_type', 'message', 'mic', 'mic_none', 'mic_off', 'minimize', 'missed_video_call', 'mms', 'mobile_friendly', 'mobile_off', 'mobile_screen_share', 'mode_comment', 'monetization_on', 'money', 'money_off', 'monochrome_photos', 'mood', 'mood_bad', 'more', 'more_horiz', 'more_vert', 'motorcycle', 'mouse', 'move_to_inbox', 'movie', 'movie_creation', 'movie_filter', 'multiline_chart', 'music_note', 'music_off', 'music_video', 'my_location',
			'nature', 'nature_people', 'navigate_before', 'navigate_next', 'navigation', 'near_me', 'network_cell', 'network_check', 'network_locked', 'network_wifi', 'new_releases', 'next_week', 'nfc', 'no_encryption', 'no_meeting_room', 'no_sim', 'not_interested', 'not_listed_location', 'note', 'note_add', 'notes', 'notification_important', 'notifications', 'notifications_active', 'notifications_none', 'notifications_off', 'notifications_paused',
			'offline_bolt', 'offline_pin', 'ondemand_video', 'opacity', 'open_in_browser', 'open_in_new', 'open_with', 'outlined_flag',
			'pages', 'pageview', 'palette', 'pan_tool', 'panorama', 'panorama_fish_eye', 'panorama_horizontal', 'panorama_vertical', 'panorama_wide_angle', 'party_mode', 'pause', 'pause_circle_filled', 'pause_circle_outline', 'pause_presentation', 'payment', 'people', 'people_outline', 'perm_camera_mic', 'perm_contact_calendar', 'perm_data_setting', 'perm_device_information', 'perm_identity', 'perm_media', 'perm_phone_msg', 'perm_scan_wifi', 'person', 'person_add', 'person_add_disabled', 'person_outline', 'person_pin', 'person_pin_circle', 'personal_video', 'pets', 'phone', 'phone_android', 'phone_bluetooth_speaker', 'phone_callback', 'phone_forwarded', 'phone_in_talk', 'phone_iphone', 'phone_locked', 'phone_missed', 'phone_paused', 'phonelink', 'phonelink_erase', 'phonelink_lock', 'phonelink_off', 'phonelink_ring', 'phonelink_setup', 'photo', 'photo_album', 'photo_camera', 'photo_filter', 'photo_library', 'photo_size_select_actual', 'photo_size_select_large', 'photo_size_select_small', 'picture_as_pdf', 'picture_in_picture', 'picture_in_picture_alt', 'pie_chart', 'pin_drop', 'place', 'play_arrow', 'play_circle_filled', 'play_circle_filled_white', 'play_circle_outline', 'play_for_work', 'playlist_add', 'playlist_add_check', 'playlist_play', 'plus_one', 'poll', 'polymer', 'pool', 'portable_wifi_off', 'portrait', 'power', 'power_input', 'power_off', 'power_settings_new', 'pregnant_woman', 'present_to_all', 'print', 'print_disabled', 'priority_high', 'public', 'publish',
			'query_builder', 'question_answer', 'queue', 'queue_music', 'queue_play_next',
			'radio', 'radio_button_checked', 'radio_button_unchecked', 'rate_review', 'receipt', 'recent_actors', 'record_voice_over', 'redeem', 'redo', 'refresh', 'remove', 'remove_circle', 'remove_circle_outline', 'remove_from_queue', 'remove_red_eye', 'remove_shopping_cart', 'reorder', 'repeat', 'repeat_one', 'replay', 'replay_10', 'replay_30', 'replay_5', 'reply', 'reply_all', 'report', 'report_off', 'report_problem', 'restaurant', 'restaurant_menu', 'restore', 'restore_from_trash', 'restore_page', 'ring_volume', 'room', 'room_service', 'rotate_90_degrees_ccw', 'rotate_left', 'rotate_right', 'rounded_corner', 'router', 'rowing', 'rss_feed', 'rv_hookup',
			'satellite', 'save', 'save_alt', 'scanner', 'scatter_plot', 'schedule', 'school', 'score', 'screen_lock_landscape', 'screen_lock_portrait', 'screen_lock_rotation', 'screen_rotation', 'screen_share', 'sd_card', 'sd_storage', 'search', 'security', 'select_all', 'send', 'sentiment_dissatisfied', 'sentiment_satisfied', 'sentiment_satisfied_alt', 'sentiment_very_dissatisfied', 'sentiment_very_satisfied', 'settings', 'settings_applications', 'settings_backup_restore', 'settings_bluetooth', 'settings_brightness', 'settings_cell', 'settings_ethernet', 'settings_input_antenna', 'settings_input_component', 'settings_input_composite', 'settings_input_hdmi', 'settings_input_svideo', 'settings_overscan', 'settings_phone', 'settings_power', 'settings_remote', 'settings_system_daydream', 'settings_voice', 'share', 'shop', 'shop_two', 'shopping_basket', 'shopping_cart', 'short_text', 'show_chart', 'shuffle', 'shutter_speed', 'signal_cellular_4_bar', 'signal_cellular_alt', 'signal_cellular_connected_no_internet_4_bar', 'signal_cellular_no_sim', 'signal_cellular_null', 'signal_cellular_off', 'signal_wifi_4_bar', 'signal_wifi_4_bar_lock', 'signal_wifi_off', 'sim_card', 'skip_next', 'skip_previous', 'slideshow', 'slow_motion_video', 'smartphone', 'smoke_free', 'smoking_rooms', 'sms', 'sms_failed', 'snooze', 'sort', 'sort_by_alpha', 'spa', 'space_bar', 'speaker', 'speaker_group', 'speaker_notes', 'speaker_notes_off', 'speaker_phone', 'spellcheck', 'star', 'star_border', 'star_half', 'star_rate', 'stars', 'stay_current_landscape', 'stay_current_portrait', 'stay_primary_landscape', 'stay_primary_portrait', 'stop', 'stop_screen_share', 'storage', 'store', 'store_mall_directory', 'straighten', 'streetview', 'strikethrough_s', 'style', 'subdirectory_arrow_left', 'subdirectory_arrow_right', 'subject', 'subscriptions', 'subtitles', 'subway', 'supervised_user_circle', 'supervisor_account', 'surround_sound', 'swap_calls', 'swap_horiz', 'swap_horizontal_circle', 'swap_vert', 'swap_vertical_circle', 'switch_camera', 'switch_video', 'sync', 'sync_disabled', 'sync_problem', 'system_update',
			'tab', 'tab_unselected', 'table_chart', 'tablet', 'tablet_android', 'tablet_mac', 'tag_faces', 'tap_and_play', 'terrain', 'text_fields', 'text_format', 'text_rotate_up', 'text_rotate_vertical', 'text_rotation_down', 'text_rotation_none', 'textsms', 'texture', 'theaters', 'thumb_down', 'thumb_down_alt', 'thumb_up', 'thumb_up_alt', 'thumbs_up_down', 'time_to_leave', 'timelapse', 'timeline', 'timer', 'timer_10', 'timer_3', 'timer_off', 'title', 'toc', 'today', 'toll', 'tonality', 'touch_app', 'toys', 'track_changes', 'traffic', 'train', 'tram', 'transfer_within_a_station', 'transform', 'transit_enterexit', 'translate', 'trending_down', 'trending_flat', 'trending_up', 'trip_origin', 'tune', 'turned_in', 'turned_in_not', 'tv', 'tv_off',
			'unarchive', 'undo', 'unfold_less', 'unfold_more', 'unsubscribe', 'update', 'usb',
			'verified_user', 'vertical_align_bottom', 'vertical_align_center', 'vertical_align_top', 'vertical_split', 'vibration', 'video_call', 'video_label', 'video_library', 'videocam', 'videocam_off', 'videogame_asset', 'view_agenda', 'view_array', 'view_carousel', 'view_column', 'view_comfy', 'view_compact', 'view_day', 'view_headline', 'view_list', 'view_module', 'view_quilt', 'view_stream', 'view_week', 'vignette', 'visibility', 'visibility_off', 'voice_chat', 'voice_over_off', 'voicemail', 'volume_down', 'volume_mute', 'volume_off', 'volume_up', 'vpn_key', 'vpn_lock',
			'wallpaper', 'warning', 'watch', 'watch_later', 'waves', 'wb_auto', 'wb_cloudy', 'wb_incandescent', 'wb_iridescent', 'wb_sunny', 'wc', 'web', 'web_asset', 'weekend', 'whatshot', 'where_to_vote', 'widgets', 'wifi', 'wifi_lock', 'wifi_off', 'wifi_tethering', 'work', 'work_off', 'work_outline', 'wrap_text',
			'youtube_searched_for',
			'zoom_in', 'zoom_out', 'zoom_out_map'
		);
	}


	public function get_font_tags(){
		$tags = array(
			'FontAwesome'	=> 'Font Awesome',
			'StrokeIcons7'	=> 'Stroke Icons 7',
			'MaterialIcons'	=> 'Material Icons'
		);

		return apply_filters('revslider_get_font_tags', $tags);
	}


	/**
	 * get the custom tags
	 **/
	public function get_custom_tags(){
		return get_option('rs-custom-library-tags', array());
	}


	/**
	 * create a tag for custom categories
	 * category type is needed
	 **/
	public function create_custom_tag($name, $type){
		$name = $this->sanitize_tag_name($name);
		if($name === false) return __('Tagname has to be at least 3 characters long. Only a-z, A-Z and 0-9 are valid');

		$tags = get_option('rs-custom-library-tags', array());

		$lid = 0;
		if(!empty($tags)){
			foreach($tags as $t => $_v){
				if($type !== $t) continue;
				if(empty($_v)) continue;

				foreach($_v as $id => $_name){
					if($id > $lid) $lid = $id;
				}

				$c = 0;
				$orig_name = $name;

				do{
					$found = false;
					if($c > 0) $name = $orig_name . ' '.$c;
					foreach($_v as $id => $_name){
						if($_name === $name) {
							$found = true;
							break;
						}
					}
					$c++;
				}while($found);
			}
		}
		$lid++;
		if(!isset($tags[$type])) $tags[$type] = array();
		$tags[$type][$lid] = $name;
		update_option('rs-custom-library-tags', $tags);

		return array('id' => $lid, 'name' => $name);
	}


	/**
	 * edit a tag for custom categories
	 * category type is needed
	 **/
	public function edit_custom_tag($id, $name, $type){
		$name = $this->sanitize_tag_name($name);
		if($name === false) return __('Tagname has to be at least 3 characters long. Only a-z, A-Z and 0-9 are valid');

		$tags = get_option('rs-custom-library-tags', array());
		if(!empty($tags)){
			foreach($tags as $t => $_v){
				if($type !== $t) continue;
				if(empty($_v)) continue;

				foreach($_v as $_id => $_name){
					if($id !== $_id && ' '.$id !== ' '.$_id) continue;

					$tags[$t][$_id] = $name;

					update_option('rs-custom-library-tags', $tags);

					return true;
				}
			}
		}

		return __('Tag not found');
	}


	/**
	 * delete a tag for custom categories
	 * category type is needed
	 **/
	public function delete_custom_tag($id, $type){
		$tags = get_option('rs-custom-library-tags', array());
		if(!empty($tags)){
			foreach($tags as $t => $_v){
				if($type !== $t) continue;
				if(empty($_v)) continue;
				foreach($_v as $_id => $_name){
					if($id !== $_id && ' '.$id!==' '.$_id) continue;
					unset($tags[$t][$_id]);
					update_option('rs-custom-library-tags', $tags);
					return true;
				}
			}
		}

		return __('Tag not found');
	}
	
	/**
	 * upload custom library item
	 **/
	public function upload_custom_item($data){
		$return		= false;
		$customs	= json_decode(stripslashes($this->get_val($_POST, 'customs', '')), true);
		$lib_type	= $this->get_val($customs, 'type', '');
		$tag		= $this->get_val($customs, 'tag', false);
		if($lib_type === 'svgcustom'){
			if($tag !== false){
				$new = $this->create_custom_tag($tag, $lib_type);
				if(!is_array($new)){
					$customs['tag']	= 'All';
					$customs['id']	= 0;
				}else{
					$customs['tag']	= $this->get_val($new, 'name', 'All');
					$customs['id']	= $this->get_val($new, 'id', 0);
				}
				if(!is_array($customs)) $customs = array('type' => 'svgcustom');
			}
			
			$return = $this->import_custom_svg_file($data, $customs);
		}
		
		$return = apply_filters('revslider_upload_custom_library_item', $return, $data);
		
		return ($return !== false) ? $return : false;
	}
	
	
	/**
	 * edit a custom library item
	 **/
	public function edit_custom_item($id, $type, $name, $tags){
		$return = false;
		
		$library = get_option('rs-custom-library', array());
		if(isset($library[$type]) && isset($library[$type]['items']) && !empty($library[$type]['items'])){
			foreach($library[$type]['items'] as $lk => $lv){
				if(strval($this->get_val($lv, 'id', 0)) === strval($id)){
					$path = $this->get_val($lv, 'img');
					if(!empty($name)){
						$library[$type]['items'][$lk]['title'] = $this->sanitize_tag_name($name);
					}
					
					if(!empty($tags)){
						if(is_array($tags)){
							$library[$type]['items'][$lk]['tags'] = array();
							
							foreach($tags as $t){
								$library[$type]['items'][$lk]['tags'][] = strval($t);
							}
						}else{
							$library[$type]['items'][$lk]['tags'] = array(strval($tags));
						}
					}
					update_option('rs-custom-library', $library);

					$return = true;
				}
			}
		}
		
		$return = apply_filters('revslider_edit_custom_library_item', $return, $id, $type, $name, $tags);
		
		return $return === true;
	}
	
	/**
	 * delete a custom library item
	 **/
	public function delete_custom_item($id, $type){
		$return = false;
		
		$library = get_option('rs-custom-library', array());
		
		if(isset($library[$type]) && isset($library[$type]['items']) && !empty($library[$type]['items'])){
			foreach($library[$type]['items'] as $lk => $lv){
				if(strval($this->get_val($lv, 'id', 0)) === strval($id)){
					$path = $this->get_val($lv, 'img');
					if(!empty($path)){ }
					unset($library[$type]['items'][$lk]);
					
					update_option('rs-custom-library', $library);
					$return = true;
				}
			}
		}
		
		$return = apply_filters('revslider_delete_custom_library_item', $return, $id, $type);
		
		return $return === true;
	}
	
	/**
	 * import (unzip) an uploaded custom svg files
	 */
	private function import_custom_svg_file($data, $customs){
		require_once(ABSPATH . 'wp-admin/includes/file.php');
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
		}

		$path		= $this->get_val($import_file, 'tmp_name');
		$name		= $this->get_val($import_file, 'name');
		$type		= $this->get_val($import_file, 'type');
		$library	= get_option('rs-custom-library', array());
		$tag		= $this->get_val($customs, 'tag', false);
		$tagID		= $this->get_val($customs, 'id', false);
		$lib_type	= $this->get_val($customs, 'type');
		$lib_type	= $this->sanitize_tag_name($lib_type);
		
		if(!in_array($lib_type, $this->allowed_categories)) $this->throw_error(__('Category does not exist', 'revslider'));
		if(isset($path['error'])) $this->throw_error($path['error']);
		if(file_exists($path) == false) $this->throw_error(__('Import file not found', 'revslider'));

		global $wp_filesystem;
		WP_Filesystem();
		
		$import	= array();
		$finfo	= finfo_open(FILEINFO_MIME_TYPE);
		$info	= finfo_file($finfo, $path);
		$zip	= false;

		switch($info){
			case 'image/svg':
			case 'image/svg+xml':
				$import[] = $path;
			break;
			case 'application/zip':
				$zip = true;
				$this->download_path = RS_PLUGIN_PATH.'rstempsvg/';
				$this->svg_remove_path = $this->download_path;
				@$wp_filesystem->delete($this->download_path, true);
				$file	= unzip_file($path, $this->download_path);

				if(is_wp_error($file)){
					@define('FS_METHOD', 'direct'); //lets try direct.
					WP_Filesystem(); //WP_Filesystem() needs to be called again since now we use direct!
					
					$file = unzip_file($path, $this->download_path);
					if(is_wp_error($file)){
						$file = unzip_file($path, $this->download_path);
						if(is_wp_error($file)){
							$file_basename	= basename($path);
							$this->download_path = str_replace($file_basename, '', $path);
							$file = unzip_file($path, $this->download_path);
						}
					}
				}
				
				if($file){
					//check all files in download_path and add them to an array list of files
					$files = list_files($this->download_path);
					if(!empty($files)){
						foreach($files as $file){
							if(is_dir($file)) continue;
							$import[] = $file;
						}
					}
				}else{
					$wp_filesystem->delete($this->svg_remove_path, true);
					$msg = $file->get_error_message();
					$this->throw_error($msg);
				}
			break;
		}

		if(!empty($import)){
			foreach($import as $k => $v){
				$check = $wp_filesystem->exists($v) ? $wp_filesystem->get_contents($v) : '';
				if(empty($check)) unset($import[$k]);
			}
		}
		
		if(empty($import)){
			$wp_filesystem->delete($this->svg_remove_path, true);
			$this->throw_error(__('No valid file sent.', 'revslider'));
		}
		
		$tags = get_option('rs-custom-library-tags', array());
		$found = false;
		if(!empty($tags)){
			foreach($tags as $t => $_v){
				if($t !== $lib_type) continue;
				
				foreach($_v as $k => $v){
					if($tagID !== false){
						if(strval($k) === strval($tagID)){
							$found	= true;
							$tag	= $v;
							break;
						}
					}else{
						if($this->get_val($v, 'name', -1) === $tag){
							$found	= true;
							$tag	= $v;
							$tagID	= $k;
							break;
						}
					}
				}
			}
		}

		if($found !== true){
			$tag = 'All';
			$tagID = 0;
		}
		
		//push all imports to the correct folder
		//create entries in the database
		//remove files from the temp path
		//move to the upload folder
		$_id = 0;
		if(!isset($library[$lib_type])) $library[$lib_type] = array();
		if(!isset($library[$lib_type]['items'])) $library[$lib_type]['items'] = array();
		
		foreach($library[$lib_type]['items'] as $lk => $lv){
			if($_id < $this->get_val($lv, 'id', 0)) $_id = $this->get_val($lv, 'id', 0);
		}
		
		$found = false;
		foreach($import as $k => $v){
			$handle = ($zip === true) ? basename($v) : basename($name); //if zip is false, file has still a temporary name
			$new = $this->upload_dir['basedir'] . $this->customsvgpath . $lib_type . '/' . $handle;
			$url = $this->upload_dir['baseurl'] . $this->customsvgpath . $lib_type . '/' . $handle;
			$i = 1;
			$change = false;
			if(strpos($handle, '.') !== false){
				while(file_exists($new)){
					$_h = explode('.', $handle);
					$_h = implode('_'.$i.'.', $_h);
					$new = $this->upload_dir['basedir'] . $this->customsvgpath . $lib_type . '/' . $_h;
					$url = $this->upload_dir['baseurl'] . $this->customsvgpath . $lib_type . '/' . $_h;
					$change = true;
					$i++;
				}
			}
			
			$handle = ($change === true) ? $_h : $handle;
			$done = (file_exists(dirname($new))) ? true : @mkdir(dirname($new), 0777, true);
			if($done === false) $this->throw_error(dirname($new) . ' '.__('could not be created programmatically', 'revslider'));
			$done = copy($v, $new);
			if($done === false) $this->throw_error($handle . ' '.__('could not be created programmatically', 'revslider'));
			//push to library
			if(!empty($library[$lib_type]['items'])){
				$found = false;
				foreach($library[$lib_type]['items'] as $lk => $lv){
					if($lv['handle'] !== $handle) continue;
					$found	= $lk;
					break;
				}
			}
			if($found === false) $_id += 1;
			$_name = str_replace(array('.svg', '-', '_'), array('', ' ', ' '), $handle);
			$_data = array(
				'id'	 => $_id,
				'handle' => $handle,
				'title'	 => $this->sanitize_tag_name($_name),
				'img'	 => $url
			);
			
			if($tagID !== 0 && $tagID !== false){
				$_data['tags'] = array(strval($tagID));
			}
			
			if($found !== false){
				$library[$lib_type]['items'][$found]['tags'] = $this->get_val($_data, 'tags', array());
				$library[$lib_type]['items'][$found]['img'] = $_data['img'];
			}else{
				$library[$lib_type]['items'][] = $_data;
			}
		}
		
		update_option('rs-custom-library', $library);
		$wp_filesystem->delete($this->svg_remove_path, true);
		
		return $library[$lib_type];
	}

	/**
	 * sanitize a tag name, remove illegal characters
	 **/
	public function sanitize_tag_name($name){
		$name = preg_replace('/[^a-zA-Z0-9 ]/', '', trim($name));
		return (strlen($name) < 3) ? false : $name;
	}
}