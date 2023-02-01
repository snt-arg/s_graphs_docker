<?php
/**
 * External Sources Instagram Class
 * @since: 5.0
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.sliderrevolution.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

use EspressoDev\InstagramBasicDisplay as InstagramBasicDisplay;

/**
 * Instagram
 *
 * with help of the API this class delivers all kind of Images from instagram
 *
 * @package    socialstreams
 * @subpackage socialstreams/instagram
 * @author     ThemePunch <info@themepunch.com>
 */

class RevSliderInstagram extends RevSliderFunctions {

	const QUERY_SHOW = 'ig_show';
	const QUERY_TOKEN = 'ig_token';
	const QUERY_CONNECTWITH = 'ig_user';
	const QUERY_ERROR = 'ig_error_message';

	/**
	 * Stream Array
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $stream    Stream Data Array
	 */
	private $stream;

	/**
	 * @var array of InstagramBasicDisplay objects
	 */
	private $instagram;

	/**
	 * Transient seconds
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var int  $transient_sec Transient time in seconds
	 */
	private $transient_sec;

	/**
	 * Transient for token refresh in seconds
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var int  $transient_token_sec Transient time in seconds
	 */
	private $transient_token_sec;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param int $transient_sec  Transient time in seconds
	 */
	public function __construct($transient_sec = 86400){
		$this->transient_sec = $transient_sec;
		$this->transient_token_sec = 86400 * 30; // 30 days
	}

	/**
	 * @return int
	 */
	public function getTransientSec(){
		return $this->transient_sec;
	}

	/**
	 * @param int $transient_sec
	 */
	public function setTransientSec($transient_sec){
		$this->transient_sec = $transient_sec;
	}

	/**
	 * @return int
	 */
	public function getTransientTokenSec(){
		return $this->transient_token_sec;
	}

	/**
	 * @param int $transient_token_sec
	 */
	public function setTransientTokenSec($transient_token_sec){
		$this->transient_token_sec = $transient_token_sec;
	}

	public function add_actions(){
		add_action('init', array(&$this, 'do_init'), 5);
		add_action('admin_footer', array(&$this, 'footer_js'));
	}

	/**
	 * check if we have QUERY_ARG set
	 * try to login the user
	 */
	public function do_init(){
		// are we on revslider page?
		if($this->get_val($_GET, 'page') != 'revslider') return;

		//instagram returned error
		if(isset($_GET[self::QUERY_ERROR])) return;

		//we need token and slide ID to proceed with saving token
		if(!isset($_GET[self::QUERY_TOKEN]) || !isset($_GET['id'])) return;

		$token		 = $_GET[self::QUERY_TOKEN];
		$connectwith = $_GET[self::QUERY_CONNECTWITH];
		$id			 = $this->get_val($_GET, 'id');

		$slider	= new RevSliderSlider();
		$slide	= new RevSliderSlide();

		$slide->init_by_id($id);

		$slider_id = $slide->get_slider_id();
		if(intval($slider_id) == 0){
			$_GET[self::QUERY_ERROR] = __('Slider could not be loaded', 'revslider');
			return;
		}

		$slider->init_by_id($slider_id);
		if($slider->inited === false){
			$_GET[self::QUERY_ERROR] = __('Slider could not be loaded', 'revslider');
			return;
		}

		$slider->set_param(array('source', 'instagram', 'token_source'), 'account');
		$slider->set_param(array('source', 'instagram', 'token'), $token);
		$slider->set_param(array('source', 'instagram', 'connect_with'), $connectwith);
		$slider->update_params(array());

		//redirect
		$url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		$url = add_query_arg(array(self::QUERY_TOKEN => false, self::QUERY_SHOW => 1), $url);
		wp_redirect($url);
		exit();
	}

	public function footer_js(){
		// are we on revslider page?
		if($this->get_val($_GET, 'page') != 'revslider') return;

		if(isset($_GET[self::QUERY_SHOW]) || isset($_GET[self::QUERY_ERROR])){
			echo '<script>jQuery(document).ready(function(){ RVS.DOC.one("builderInitialised", function(){RVS.F.mainMode({mode:"sliderlayout", forms:["*sliderlayout*#form_slidercontent"], set:true, uncollapse:true,slide:RVS.S.slideId});RVS.F.updateSliderObj({path:"settings.sourcetype",val:"instagram"});RVS.F.updateEasyInputs({container:jQuery("#form_slidercontent"), trigger:"init", visualUpdate:true});}); });</script>';
		}

		if(isset($_GET[self::QUERY_ERROR])){
			$err = __('Instagram Reports: ', 'revslider') . esc_html($_GET[self::QUERY_ERROR]);
			echo '<script>jQuery(document).ready(function(){ RVS.DOC.one("builderInitialised", function(){ RVS.F.showInfo({content:"' . $err . '", type:"warning", showdelay:1, hidedelay:5, hideon:"", event:"" }); });});</script>';
		}
	}

	public static function get_login_url(){
		$app_id		= '677807423170942';
		$redirect	= 'https://updates.themepunch.tools/ig/auth.php';
		$id			= (isset($_GET['id'])) ? $_GET['id'] : '';
		$state		= base64_encode(admin_url('admin.php?page=revslider&view=slide&id='.$id));
		return sprintf(
			'https://api.instagram.com/oauth/authorize?app_id=%s&redirect_uri=%s&response_type=code&scope=user_profile,user_media&state=%s',
			$app_id,
			$redirect,
			$state
		);
	}

	/**
	 * Get Instagram Users Pictures CSV list
	 *
	 * @since    3.0
	 * @param    string    $user_id 	Instagram User id (not name)
	 */
	public function get_users_photos($search_user_id, $count, $orig_image = ''){
		$search_user_array = explode(',', $search_user_id);
		if(is_array($search_user_array)){
			foreach($search_user_array as $search_user){
				$this->get_public_photos(trim($search_user), $count, $orig_image);
			}
		}else{
			$this->get_public_photos(trim($search_user_id), $count, $orig_image);
		}

		return $this->stream;
	}

	/**
	 * return instagram api object
	 *
	 * @param string $token
	 * @return InstagramBasicDisplay
	 */
	public function getInstagram($token){
		if( empty($this->instagram[$token]) ){
			$this->instagram[$token] = new InstagramBasicDisplay($token);
		}
		return $this->instagram[$token];
	}

	/**
	 * refresh Instagram token if needed
	 *
	 * @param string $token Instagram Access Token
	 * @return mixed
	 */
	protected function _refresh_token($token){
		$transient_token_name = 'revslider_insta_token_'. md5($token);
		if($this->transient_token_sec > 0 && false !== ($data = get_transient($transient_token_name))){
			return;
		}

		$instagram = $this->getInstagram($token);
		//$refresh contain new token, however old token expiry date also updated, so we could still use it
		$refresh = $instagram->refreshToken($token);
		set_transient($transient_token_name, $token, $this->transient_token_sec);
	}

	/**
	 * Get Instagram User Profile
	 *
	 * @param string $token Instagram Access Token
	 * @return mixed
	 */
	public function get_user_profile($token){
		$this->_refresh_token($token);
		$instagram = $this->getInstagram($token);
		$profile = $instagram->getUserProfile();
		if(isset($profile->id)){
			return (array)$profile;
		}
		return null;
	}

	/**
	 * Get Instagram User Pictures
	 *
	 * @since 3.0
	 * @param int $slider_id slider ID
	 * @param string $token Instagram Access Token
	 * @param string $count media count
	 * @param string $orig_image
	 * @return mixed
	 */
	public function get_public_photos($slider_id, $token, $count, $orig_image = ''){

		$this->_refresh_token($token);
		$instagram = $this->getInstagram($token);

		$cacheKey = 'instagram' . '-' . $slider_id . '-' . $token . '-' . $count;
		$transient_name = 'revslider_'. md5($cacheKey);
		if($this->transient_sec > 0 && false !== ($data = get_transient($transient_name))){
			$this->stream = $data;
			return $this->stream;
		} else {
			delete_transient($transient_name);
		}

		//Getting instagram images
		$medias = $instagram->getUserMedia('me', $count);
		if(isset($medias->data)){
			$this->instagram_output_array($medias->data, $count);
		}
		if(!empty($this->stream)){
			set_transient($transient_name, $this->stream, $this->transient_sec);
			return $this->stream;
		}else{
			$err = translate('Instagram reports: Please check the settings','revslider');
			if(isset($medias->error)){
				$err = $medias->error->message;
			}
			echo $err;
			return false;
		}
	}

	function input($name, $default = null){
		return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
	}

	public function http_request($url, $post = '', $cookies = '', $headers = '', $show_header = true){
		$ch = @curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, $show_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if($post){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		if($cookies){
			curl_setopt($ch, CURLOPT_COOKIE, $cookies);
		}
		if($headers){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		$page = curl_exec($ch);
		curl_close($ch);
		return $page;
	}



	/**
	 * Get Instagram Tags Pictures CSV list
	 *
	 * @since    3.0
	 * @param    string    $user_id 	Instagram User id (not name)
	 */
	public function get_tags_photos($search_user_id, $count, $orig_image){
		$search_user_array = explode(',', $search_user_id);
		if(is_array($search_user_array)){
			foreach($search_user_array as $search_user){
				$this->get_tag_photos(trim($search_user), $count, $orig_image);
			}
		}
		else{
			$this->get_tag_photos(trim($search_user_id), $count, $orig_image);
		}
		return $this->stream;
	}

	/**
	 * Get Instagram Tag Pictures
	 *
	 * @since    3.0
	 * @param    string    $user_id 	Instagram User id (not name)
	 */
	public function get_tag_photos($search_user_id, $count, $orig_image){
		if(!empty($search_user_id)){
			$search_user_id = str_replace("#", "", $search_user_id);

			$url = 'https://www.instagram.com/explore/tags/'.$search_user_id.'/?__a=1';

			$transient_name = 'revslider_'. md5($url."count=".$count);

			if($this->transient_sec > 0 && false !== ($data = get_transient( $transient_name))){
				$this->stream = $data;
				return $this->stream;
			}else{
				delete_transient($transient_name);
			}

			$rsp = json_decode(wp_remote_fopen($url));

			$count = $this->instagram_output_array($rsp->graphql->hashtag->edge_hashtag_to_media->edges, $count, $search_user_id, $orig_image);

			if(!$rsp->graphql->hashtag->edge_hashtag_to_media->count){
				_e('Instagram reports: Please check the settings','revslider');
				return false;
			}

			while($count){
				$url = 'https://www.instagram.com/explore/tags/'.$search_user_id.'/?__a=1&max_id='.$rsp->graphql->hashtag->edge_hashtag_to_media->page_info->end_cursor;
				$rsp = json_decode(wp_remote_fopen($url));
				$count = $this->instagram_output_array($rsp->tag->media->nodes,$count,$search_user_id,$orig_image);
			}

			if(!empty($this->stream)){
				set_transient( $transient_name, $this->stream, $this->transient_sec );
				return $this->stream;
			}else{
				_e('Instagram reports: Please check the settings','revslider');
				return false;
			}
		}else{
			_e('Instagram reports: Please check the settings','revslider');
			return false;
		}

	}

	/**
	 * Get Instagram Locations Pictures CSV list
	 *
	 * @since    3.0
	 * @param    string    $user_id 	Instagram User id (not name)
	 */
	public function get_places_photos($search_user_id, $count, $orig_image){
		$search_user_array = explode(",", $search_user_id);
		if(is_array($search_user_array)){
			foreach($search_user_array as $search_user){
				$this->get_place_photos(trim($search_user),$count,$orig_image);
			}
		}
		else {
			$this->get_place_photos(trim($search_user_id),$count,$orig_image);
		}
		return $this->stream;
	}

	/**
	 * Get Instagram Location Pictures
	 *
	 * @since    3.0
	 * @param    string    $user_id 	Instagram User id (not name)
	 */
	public function get_place_photos($search_user_id, $count, $orig_image){
		if(!empty($search_user_id)){

			$url = 'https://www.instagram.com/explore/locations/'.$search_user_id.'/?__a=1';

			$transient_name = 'revslider_'. md5($url."count=".$count);
			if($this->transient_sec > 0 && false !== ($data = get_transient( $transient_name))){
				$this->stream = $data;
				return $this->stream;
			}
			else
				delete_transient( $transient_name );

			$rsp = json_decode(wp_remote_fopen($url));

			$count = $this->instagram_output_array($rsp->graphql->location->edge_location_to_media->edges,$count,$search_user_id,$orig_image);

			if(!$rsp->graphql->location->edge_location_to_media->count){
				_e('Instagram reports: Please check the settings','revslider');
				return false;
			}

			while($count){
				$url = 'https://www.instagram.com/explore/locations/'.$search_user_id.'/?__a=1&max_id='.$rsp->graphql->location->edge_location_to_media->page_info->end_cursor;
				$rsp = json_decode(wp_remote_fopen($url));
				$count = $this->instagram_output_array($rsp->graphql->location->edge_location_to_media->edges,$count,$search_user_id,$orig_image);
			}

			if(!empty($this->stream)){
				set_transient( $transient_name, $this->stream, $this->transient_sec );
				return $this->stream;
			}
			else {
				_e('Instagram reports: Please check the settings','revslider');
				return false;
			}
		}
		else {
			_e('Instagram reports: Please check the settings','revslider');
			return false;
		}

	}


	/**
	 * Prepare output array $stream
	 *
	 * @since    3.0
	 * @param    array $photos Instagram Output Data
	 * @param    int $count resulting number of items
	 */
	private function instagram_output_array($photos, $count){
		$this->stream = array();

		foreach ($photos as $photo){
			if($count > 0){
				$count--;
				$shortcode = '';

				preg_match('/.+\/p\/(.+)?\//m', $photo->permalink, $matches);
				if(isset($matches[1])){
					$shortcode = $matches[1];
				}
				$photo->display_url = isset($photo->media_url) ? $photo->media_url : '';
				if($photo->media_type == 'VIDEO'){
					$photo->display_url = isset($photo->thumbnail_url) ? $photo->thumbnail_url : '';
					$photo->thumbnail_src = $photo->display_url;
					$photo->videos['standard_resolution']['url'] = isset($photo->media_url) ? $photo->media_url : '';
				}
				$photo->link = isset($photo->permalink) ? $photo->permalink : '';
				$photo->shortcode = $shortcode;
				$photo->taken_at_timestamp = isset($photo->timestamp) ? $photo->timestamp : '';
				$photo->edge_media_to_caption['edges'][0]['node']['text'] = isset($photo->caption) ? $photo->caption : '';
				$this->stream[] = $photo;
			}
		}

		return $count;
	}

	/**
	 * Prepare output array $stream
	 *
	 * @since    3.0
	 * @param    string    $photos 	Instagram Output Data
	 */
	private function instagram_output_array_places($photos, $count, $search_user_id, $orig_image = ''){
		foreach ($photos as $photo){
			if($count > 0){
				$count--;
				$stream = array();

				if($orig_image){
					$url = 'https://www.instagram.com/p/'.$photo->code.'/?__a=1';
					$rsp = json_decode(wp_remote_fopen($url));
					$images = end($rsp->graphql->shortcode_media->display_resources);
					$orig_image = array( $images->src, $images->config_width, $images->config_height );
				}
				else {
					$orig_image = array('', 0, 0);
				}

				$thumbnail_resources = $photo->thumbnail_resources;

				$image_url = array(
					'Low Resolution' => array(
						$thumbnail_resources[2]->src,
						320,
						320
					),
					'Thumbnail' => array(
						$thumbnail_resources[0]->src,
						150,
						150
					),
					'Standard Resolution' => array(
						$photo->thumbnail_src,
						640,
						640
					),
					'Original Resolution' => $orig_image
				);

				$text = empty($photo->caption) ? '' : $photo->caption;

				$stream['id'] = $photo->id;
				$stream['custom-image-url'] = $image_url; //image for entry

				if($photo->is_video != "true"){
					$stream['custom-type'] = 'image'; //image, vimeo, youtube, soundcloud, html
				}
				else{
					$url = 'https://www.instagram.com/p/'.$photo->code.'/?__a=1';
					$rsp = json_decode(wp_remote_fopen($url));
					$stream['custom-type'] = 'html5'; //image, vimeo, youtube, soundcloud, html
					$stream['custom-html5-mp4'] = $rsp->graphql->shortcode_media->video_url;
				}

				$stream['post-link'] = 'https://www.instagram.com/p/' . $photo->code;
				$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
				$text = preg_replace($url, '<a href="$0" target="_blank" rel="noopener" title="$0">$0</a>', $text);
				$stream['title'] = $text;
				$stream['content'] = $text;
				$stream['date'] = date_i18n( get_option( 'date_format' ), ( $photo->date ) ) ;
				$stream['date_modified'] = date_i18n( get_option( 'date_format' ), ( $photo->date ) ) ;
				$stream['author_name'] = $search_user_id;

				if(isset($photo->tags))	$stream['tags'] = implode(',', $photo->tags);

				$stream['likes'] = $photo->likes->count;
				$stream['likes_short'] = Essential_Grid_Base::thousandsViewFormat($photo->likes->count);
				$stream['num_comments'] = $photo->comments->count;


				$this->stream[] = $stream;
			}
		}
		return $count;
	}

	/**
	 * Fallback method to get 12 latest photos
	 * @param String $search_user_id (name of instagram user)
	 */
	private function getFallbackImages($search_user_id){
		//FALLBACK 12 ELEMENTS
		$page_res = $this->client_request('get', '/' . $search_user_id . '/');
		$page_data = '';

		switch ($page_res['http_code']){
			default:
			break;
			case 404:
			break;
			case 200:
				$page_data_matches = array();

				if(!preg_match('#window\._sharedData\s*=\s*(.*?)\s*;\s*</script>#', $page_res['body'], $page_data_matches)){
					_e('Instagram reports: Parse script error','revslider');
				}else{
					$page_data = json_decode($page_data_matches[1], true);

					if(!$page_data || empty($page_data['entry_data']['ProfilePage'][0]['graphql']['user'])){
						_e('Instagram reports: Content did not match expected','revslider');
					}else{
						$user_data = $page_data['entry_data']['ProfilePage'][0]['graphql']['user'];

						if($user_data['is_private']){
							_e('Instagram reports: Content is private','revslider');
						}
					}
				}
			break;
		}
		if(!$page_data) return $page_data;
		$user_data = $page_data['entry_data']['ProfilePage'][0]['graphql']['user'];

		return $user_data;
	}

	/**
	 * Cliente request to get 12 instagram photos fallback
	 * @param unknown $type
	 * @param unknown $url
	 * @param unknown $options
	 * @return number[]|string[]|NULL|number[]|string[]|number[]|unknown[]|string[]|number[]|unknown[]|unknown[][]|string[][]|number[][]|NULL[][]
	 */
	private function client_request($type, $url, $options = null){

		$this->index('client', array(
			'base_url' => 'https://www.instagram.com/',
			'cookie_jar' => array(),
			'headers' => array(
				// 'Accept-Encoding' => supports_gz () ? 'gzip' : null,
				'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.87 Safari/537.36',
				'Origin' => 'https://www.instagram.com',
				'Referer' => 'https://www.instagram.com',
				'Connection' => 'close'
			)
		));
		$client = $this->index('client');
		$type = strtoupper($type);
		$options = is_array($options) ? $options : array();

		$url = (!empty($client['base_url']) ? rtrim($client['base_url'], '/') : '') . $url;
		$url_info = parse_url($url);

		$scheme = !empty($url_info['scheme']) ? $url_info['scheme'] : '';
		$host = !empty($url_info['host']) ? $url_info['host'] : '';
		$port = !empty($url_info['port']) ? $url_info['port'] : '';
		$path = !empty($url_info['path']) ? $url_info['path'] : '';
		$query_str = !empty($url_info['query']) ? $url_info['query'] : '';

		if(!empty($options['query'])){
			$query_str = http_build_query($options['query']);
		}

		$headers = !empty($client['headers']) ? $client['headers'] : array();

		if(!empty($options['headers'])){
			$headers = $this->array_merge_assoc($headers, $options['headers']);
		}

		$headers['Host'] = $host;

		$client_cookies = $this->client_get_cookies_list($host);
		$cookies = $client_cookies;

		if(!empty($options['cookies'])){
			$cookies = $this->array_merge_assoc($cookies, $options['cookies']);
		}

		if($cookies){
			$request_cookies_raw = array();

			foreach ($cookies as $cookie_name => $cookie_value){
				$request_cookies_raw[] = $cookie_name . '=' . $cookie_value;
			}
			unset($cookie_name, $cookie_data);

			$headers['Cookie'] = implode('; ', $request_cookies_raw);
		}

		if($type === 'POST' && !empty($options['data'])){
			$data_str = http_build_query($options['data']);
			$headers['Content-Type'] = 'application/x-www-form-urlencoded';
			$headers['Content-Length'] = strlen($data_str);

		}else{
			$data_str = '';
		}

		$headers_raw_list = array();

		foreach($headers as $header_key => $header_value){
			$headers_raw_list[] = $header_key . ': ' . $header_value;
		}
		unset($header_key, $header_value);

		$transport_error = null;
		$curl_support = function_exists('curl_init');
		$sockets_support = function_exists('fsockopen');

		if(!$curl_support && !$sockets_support){
			log_error('Curl and sockets are not supported on this server');

			return array(
				'status' => 0,
				'transport_error' => 'php on web-server does not support curl and sockets'
			);
		}

		if($curl_support){
			$curl = curl_init();
			$curl_options = array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HEADER => true,
				CURLOPT_URL => $scheme . '://' . $host . $path . (!empty($query_str) ? '?' . $query_str : ''),
				CURLOPT_HTTPHEADER => $headers_raw_list,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_CONNECTTIMEOUT => 15,
				CURLOPT_TIMEOUT => 60,
			);
			if($type === 'POST'){
				$curl_options[CURLOPT_POST] = true;
				$curl_options[CURLOPT_POSTFIELDS] = $data_str;
			}

			curl_setopt_array($curl, $curl_options);

			$response_str = curl_exec($curl);
			$curl_info = curl_getinfo($curl);
			$curl_error = curl_error($curl);

			curl_close($curl);


			if($curl_info['http_code'] === 0){
				log_error('An error occurred while loading data. curl_error: ' . $curl_error);

				$transport_error = array('status' => 0, 'transport_error' => 'curl');

				if(!$sockets_support){
					return $transport_error;
				}

			}
		}

		if(!$curl_support || $transport_error){
			log_error('Trying to load data using sockets');

			$headers_str = implode("\r\n", $headers_raw_list);

			$out = sprintf("%s %s HTTP/1.1\r\n%s\r\n\r\n%s", $type, $path . (!empty($query_str) ? '?' . $query_str : ''), $headers_str, $data_str);

			if($scheme === 'https'){
				$scheme = 'ssl';
				$port = !empty($port) ? $port : 443;
			}

			$scheme = !empty($scheme) ? $scheme . '://' : '';
			$port = !empty($port) ? $port : 80;

			$sock = @fsockopen($scheme . $host, $port, $err_num, $err_str, 15);

			if(!$sock){
				log_error('An error occurred while loading data error_number: ' . $err_num . ', error_number: ' . $err_str);

				return array(
					'status' => 0,
					'error_number' => $err_num,
					'error_message' => $err_str,
					'transport_error' => $transport_error ? 'curl and sockets' : 'sockets'
				);
			}

			fwrite($sock, $out);

			$response_str = '';

			while ($line = fgets($sock, 128)){
				$response_str .= $line;
			}

			fclose($sock);
		}


		@list ($response_headers_str, $response_body_encoded, $alt_body_encoded) = explode("\r\n\r\n", $response_str);

		if($alt_body_encoded){
			$response_headers_str = $response_body_encoded;
			$response_body_encoded = $alt_body_encoded;
		}


		$response_body = $response_body_encoded;
		$response_headers_raw_list = explode("\r\n", $response_headers_str);
		$response_http = array_shift($response_headers_raw_list);

		preg_match('#^([^\s]+)\s(\d+)\s([^$]+)$#', $response_http, $response_http_matches);
		array_shift($response_http_matches);
		list ($response_http_protocol, $response_http_code, $response_http_message) = $response_http_matches;

		$response_headers = array();
		$response_cookies = array();
		foreach ($response_headers_raw_list as $header_row){
			list ($header_key, $header_value) = explode(': ', $header_row, 2);

			if(strtolower($header_key) === 'set-cookie'){
				$cookie_params = explode('; ', $header_value);

				if(empty($cookie_params[0])){
					continue;
				}

				list ($cookie_name, $cookie_value) = explode('=', $cookie_params[0]);
				$response_cookies[$cookie_name] = $cookie_value;

			} else {
				$response_headers[$header_key] = $header_value;
			}
		}
		unset($header_row, $header_key, $header_value, $cookie_name, $cookie_value);

		if($response_cookies){
			$response_cookies['ig_or'] = 'landscape-primary';
			$response_cookies['ig_pr'] = '1';
			$response_cookies['ig_vh'] = rand(500, 1000);
			$response_cookies['ig_vw'] = rand(1100, 2000);

			$client['cookie_jar'][$host] = $this->array_merge_assoc($client_cookies, $response_cookies);
			$this->index('client', $client);
		}
		return array(
			'status' => 1,
			'http_protocol' => $response_http_protocol,
			'http_code' => $response_http_code,
			'http_message' => $response_http_message,
			'headers' => $response_headers,
			'cookies' => $response_cookies,
			'body' => $response_body
		);
	}
	/**
	 * Helper function for fallback photos function
	 * @param unknown $domain
	 * @return unknown
	 */
	private function client_get_cookies_list($domain){
		$client = $this->index('client');
		$cookie_jar = $client['cookie_jar'];

		return !empty($cookie_jar[$domain]) ? $cookie_jar[$domain] : array();
	}
	/**
	 * Helper function for fallback photos function
	 * @param unknown $key
	 * @param unknown $value
	 * @param string $f
	 * @return NULL|string
	 */
	private function index($key, $value = null, $f = false){
		static $index = array();

		if($value || $f){
			$index[$key] = $value;
		}

		return !empty($index[$key]) ? $index[$key] : null;
	}
	/**
	 * Helper function for fallback photos function
	 * @return NULL
	 */
	private function array_merge_assoc(){
		$mixed = null;
		$arrays = func_get_args();

		foreach ($arrays as $k => $arr){
			if($k === 0){
				$mixed = $arr;
				continue;
			}

			$mixed = array_combine(
				array_merge(array_keys($mixed), array_keys($arr)),
				array_merge(array_values($mixed), array_values($arr))
			);
		}

		return $mixed;
	}

}	// End Class