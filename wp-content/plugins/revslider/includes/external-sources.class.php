<?php
/**
 * External Sources Input Classes for Back and Front End
 * @since: 5.0
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.sliderrevolution.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

use EspressoDev\InstagramBasicDisplay as InstagramBasicDisplay;

/**
 * Facebook
 *
 * with help of the API this class delivers album images from Facebook
 *
 * @package    socialstreams
 * @subpackage socialstreams/facebook
 * @author     ThemePunch <info@themepunch.com>
 */

class RevSliderFacebook extends RevSliderFunctions {

	const URL_FB_AUTH = 'https://updates.themepunch.tools/fb/login.php';
	const URL_FB_API = 'https://updates.themepunch.tools/fb/api.php';

	const QUERY_SHOW = 'fb_show';
	const QUERY_TOKEN = 'fb_token';
	const QUERY_PAGE_ID = 'fb_page_id';
	const QUERY_CONNECTWITH = 'fb_page_name';
	const QUERY_ERROR = 'fb_error_message';

	/**
	* @var number  Transient time in seconds
	*/
	private $transient_sec;

	public function __construct($transient_sec = 1200){
		$this->transient_sec = 	$transient_sec;
	}

	public function add_actions()
	{
		add_action('init', array(&$this, 'do_init'), 5);
		add_action('admin_footer', array(&$this, 'footer_js'));
	}

	/**
	 * check if we have QUERY_ARG set
	 * try to login the user
	 */
	public function do_init()
	{
		// are we on revslider page?
		if(!isset($_GET['page']) || $_GET['page'] != 'revslider') return;

		//fb returned error
		if(isset($_GET[self::QUERY_ERROR])) return;

		//we need token and slide ID to proceed with saving token
		if(!isset($_GET[self::QUERY_TOKEN]) || !isset($_GET['id'])) return;

		$token = $_GET[self::QUERY_TOKEN];
		$connectwith = isset($_GET[self::QUERY_CONNECTWITH]) ? $_GET[self::QUERY_CONNECTWITH] : '';
		$page_id = isset($_GET[self::QUERY_PAGE_ID]) ? $_GET[self::QUERY_PAGE_ID] : '';
		$id = $_GET['id'];

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

		$slider->set_param(array('source', 'facebook', 'token_source'), 'account');
		$slider->set_param(array('source', 'facebook', 'appId'), $token);
		$slider->set_param(array('source', 'facebook', 'page_id'), $page_id);
		$slider->set_param(array('source', 'facebook', 'connect_with'), $connectwith);
		$slider->update_params(array());

		//redirect
		$url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		$url = add_query_arg(array(self::QUERY_TOKEN => false, self::QUERY_PAGE_ID => false, self::QUERY_CONNECTWITH => false, self::QUERY_SHOW => 1), $url);
		wp_redirect($url);
		exit();
	}

	public function footer_js(){
		// are we on revslider page?
		if(!isset($_GET['page']) || $_GET['page'] != 'revslider') return;

		if(isset($_GET[self::QUERY_SHOW]) || isset($_GET[self::QUERY_ERROR])){
			echo '<script>jQuery(document).ready(function(){ RVS.DOC.one("builderInitialised", function(){RVS.F.mainMode({mode:"sliderlayout", forms:["*sliderlayout*#form_slidercontent"], set:true, uncollapse:true,slide:RVS.S.slideId});RVS.F.updateSliderObj({path:"settings.sourcetype",val:"facebook"});RVS.F.updateEasyInputs({container:jQuery("#form_slidercontent"), trigger:"init", visualUpdate:true});}); });</script>';
		}

		if(isset($_GET[self::QUERY_ERROR])){
			$err = __('Facebook API error: ', 'revslider') . esc_html($_GET[self::QUERY_ERROR]);
			echo '<script>jQuery(document).ready(function(){ RVS.DOC.one("builderInitialised", function(){ RVS.F.showInfo({content:"' . $err . '", type:"warning", showdelay:1, hidedelay:5, hideon:"", event:"" }); });});</script>';
		}
	}

	public static function get_login_url(){
		$state = base64_encode(admin_url('admin.php?page=revslider&view=slide&id='.$_GET['id']));
		return self::URL_FB_AUTH . '?state=' . $state;
	}

	protected function _make_api_call($args = array()){
		global $wp_version;

		$response = wp_remote_post(self::URL_FB_API, array(
			'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
			'body'		 => $args,
			'timeout'	 => 45
		));

		if(is_wp_error($response)){
			return array(
				'error' => true,
				'message' => 'Facebook API error: ' . $response->get_error_message(),
			);
		}

		$responseData = json_decode($response['body'], true);
		if(empty($responseData)){
			return array(
				'error' => true,
				'message' => 'Facebook API error: Empty response body or wrong data format',
			);
		}

		return $responseData;
	}

	protected function _get_transient_fb_data($requestData){
		$transient_name = 'revslider_' . md5(json_encode($requestData));
		if($this->transient_sec > 0 && false !== ($data = get_transient($transient_name))){
			return $data;
		}

		$responseData = $this->_make_api_call($requestData);
		//code that use this function do not process errors
		//return empty array
		if($responseData['error']){
			return array();
		}

		if(isset($responseData['data'])){
			set_transient($transient_name, $responseData['data'], $this->transient_sec);
			return $responseData['data'];
		}

		return array();
	}

	/**
	 * Get Photosets List from User
	 *
	 * @param	string	$access_token 	page access token
	 * @param	string	$page_id 	page id
	 * @return	mixed
	 */
	public function get_photo_sets($access_token, $page_id){
		return $this->_make_api_call(array(
			'token' => $access_token,
			'page_id' => $page_id,
			'action' => 'albums',
		));
	}

	/**
	 * Get Photosets List from User as Options for Selectbox
	 *
	 * @param	string	$access_token 	page access token
	 * @param	string	$page_id 	page id
	 * @return	mixed	options html string | array('error' => true, 'message' => '...');
	 */
	public function get_photo_set_photos_options($access_token, $page_id){
		$photo_sets = $this->get_photo_sets($access_token, $page_id);

		if($photo_sets['error']){
			return $photo_sets;
		}

		$return = array();
		if(is_array($photo_sets['data'])){
			foreach($photo_sets['data'] as $photo_set){
				$return[] = '<option title="'.$photo_set['name'].'" value="'.$photo_set['id'].'">'.$photo_set['name'].'</option>"';
			}
		}
		return $return;
	}

	/**
	 * Get Photoset Photos
	 *
	 * @param	string	$access_token 	page access token
	 * @param	string	$album_id 	Album ID
	 * @param	int 	$item_count 	items count
	 * @return	array
	 */
	public function get_photo_set_photos($access_token, $album_id, $item_count = 8){
		$requestData = array(
			'token' => $access_token,
			'action' => 'photos',
			'album_id' => $album_id,
			'limit' => $item_count,
		);
		return $this->_get_transient_fb_data($requestData);
	}

	/**
	 * Get Feed
	 *
	 * @param	string	$access_token 	page access token
	 * @param	string	$page_id 	page id
	 * @param	int 	$item_count 	items count
	 * @return	array
	 */
	public function get_photo_feed($access_token, $page_id, $item_count = 8){
		$requestData = array(
			'token' => $access_token,
			'page_id' => $page_id,
			'action' => 'feed',
			'limit' => $item_count,
		);
		return $this->_get_transient_fb_data($requestData);
	}

}  // End Class

/**
 * Twitter
 *
 * with help of the API this class delivers all kind of tweeted images from twitter
 *
 * @package		socialstreams
 * @subpackage	socialstreams/twitter
 * @author		ThemePunch <info@themepunch.com>
 */

class RevSliderTwitter extends RevSliderFunctions {

	/**
	* Consumer Key
	*
	* @since	1.0.0
	* @access	private
	* @var		string	$consumer_key    Consumer Key
	*/
	private $consumer_key;

	/**
	* Consumer Secret
	*
	* @since	1.0.0
	* @access	private
	* @var		string	$consumer_secret    Consumer Secret
	*/
	private $consumer_secret;

	/**
	* Access Token
	*
	* @since	1.0.0
	* @access	private
	* @var		string	$access_token	Access Token
	*/
	private $access_token;

	/**
	* Access Token Secret
	*
	* @since	1.0.0
	* @access	private
	* @var		string	$access_token_secret	Access Token Secret
	*/
	private $access_token_secret;

	/**
	* Twitter Account
	*
	* @since	1.0.0
	* @access	private
	* @var		string	$twitter_account	Account User Name
	*/
	private $twitter_account;

	/**
	* Transient seconds
	*
	* @since	1.0.0
	* @access	private
	* @var		number	$transient Transient time in seconds
	*/
	private $transient_sec;

	/**
	* Stream Array
	*
	* @since	1.0.0
	* @access	private
	* @var		array	$stream	Stream Data Array
	*/
	private $stream;

	/**
	* Initialize the class and set its properties.
	*
	* @since	1.0.0
	* @param	string	$consumer_key Twitter App Registration Consomer Key
	* @param	string	$consumer_secret Twitter App Registration Consomer Secret
	* @param	string	$access_token Twitter App Registration Access Token
	* @param	string	$access_token_secret Twitter App Registration Access Token Secret
	*/
	public function __construct($consumer_key, $consumer_secret, $access_token, $access_token_secret, $transient_sec = 1200){
		$this->consumer_key			= $consumer_key;
		$this->consumer_secret		= $consumer_secret;
		$this->access_token			= $access_token;
		$this->access_token_secret  = $access_token_secret;
		$this->transient_sec		= $transient_sec;
	}

	/**
	* Get Tweets
	*
	* @since	1.0.0
	* @param	string	$twitter_account	Twitter account without trailing @ char
	*/
	public function get_public_photos($twitter_account, $include_rts, $exclude_replies, $count, $imageonly){

		//require_once( 'class-wp-twitter-api.php');
		//Set your personal data retrieved at https://dev.twitter.com/apps
		$credentials = array(
			'consumer_key'		=> $this->consumer_key,
			'consumer_secret'	=> $this->consumer_secret
		);
		// Let's instantiate our class with our credentials
		$twitter_api = new RevSliderTwitterApi($credentials, $this->transient_sec);

		$include_rts = ($include_rts == 'on') ? 'true' : 'false';
		$exclude_replies = ($include_rts == 'on') ? 'false' : 'true';

		$query = '&tweet_mode=extended&count=500&include_entities=true&include_rts='.$include_rts.'&exclude_replies='.$exclude_replies.'&screen_name='.$twitter_account;

		$tweets = $twitter_api->query($query);

		return (!empty($tweets)) ? $tweets : '';
	}


	/**
	* Find Key in array and return value (multidim array possible)
	*
	* @since	1.0.0
	* @param	string	$key	Needle
	* @param	array	$form	Haystack
	*/
	public function array_find_element_by_key($key, $form){
		if(is_array($form) && array_key_exists($key, $form)){
			$ret = $form[$key];

			return $ret;
		}

		if(is_array($form)){
			foreach($form as $k => $v){
				if(is_array($v)){
					$ret = $this->array_find_element_by_key($key, $form[$k]);
					if($ret){
						return $ret;
					}
				}
			}
		}

		return false;
	}
} // End Class

/**
* Class WordPress Twitter API
*
* https://github.com/micc83/Twitter-API-1.1-Client-for-Wordpress/blob/master/class-wp-twitter-api.php
* @version 1.0.0
*/
class RevSliderTwitterApi extends RevSliderFunctions {
	public $bearer_token;
	// Default credentials
	public $args = array(
		'consumer_key'		=> 'default_consumer_key',
		'consumer_secret'	=> 'default_consumer_secret'
	);
	// Default type of the resource and cache duration
	public $query_args = array(
		'type'	=> 'statuses/user_timeline',
		'cache'	=> 1800
	);

	public $has_error = false;

	/**
	* WordPress Twitter API Constructor
	*
	* @param array $args
	*/
	public function __construct($args = array(), $transient_sec = 1200){

		if(is_array($args) && !empty($args))
			$this->args = array_merge($this->args, $args);

		if(!$this->bearer_token = get_option('twitter_bearer_token'))
			$this->bearer_token = $this->get_bearer_token();

		$this->query_args['cache'] = $transient_sec;
	}

	/**
	* Get the token from oauth Twitter API
	*
	* @return string Oauth Token
	*/
	private function get_bearer_token(){

		$bearer_token_credentials = $this->get_val($this->args, 'consumer_key') . ':' . $this->get_val($this->args, 'consumer_secret');
		$bearer_token_credentials_64 = base64_encode($bearer_token_credentials);

		$args = array(
			'method'		=> 'POST',
			'timeout'		=> 5,
			'redirection'	=> 5,
			'httpversion'	=> '1.0',
			'blocking'		=> true,
			'headers'		=> array(
				'Authorization'		=> 'Basic ' . $bearer_token_credentials_64,
				'Content-Type'		=> 'application/x-www-form-urlencoded;charset=UTF-8',
				'Accept-Encoding'	=> 'gzip'
			),
			'body'		=> array('grant_type' => 'client_credentials'),
			'cookies'	=> array()
		);

		$response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);

		if(is_wp_error($response) || 200 != $response['response']['code'])
			return $this->bail(__( 'Can\'t get the bearer token, check your credentials', 'revslider'), $response);

		$result = json_decode($this->get_val($response, 'body'));

		update_option('twitter_bearer_token', $this->get_val($result, 'access_token'));

		return $this->get_val($result, 'access_token');
	}

	/**
	* Query twitter's API
	*
	* @uses $this->get_bearer_token() to retrieve token if not working
	*
	* @param string $query Insert the query in the format "count=1&include_entities=true&include_rts=true&screen_name=micc1983!
	* @param array $query_args Array of arguments: Resource type (string) and cache duration (int)
	* @param bool $stop Stop the query to avoid infinite loop
	*
	* @return bool|object Return an object containing the result
	*/
	public function query($query, $query_args = array(), $stop = false){
		if($this->has_error)
			return false;

		if(is_array($query_args) && !empty($query_args)){
			$this->query_args = array_merge($this->query_args, $query_args);
		}

		$transient_name = 'wta_' . md5($query);

		if($this->get_val($this->query_args, 'cache', 0) > 0 && false !== ($data = get_transient($transient_name)))
			return json_decode($data);

		$args = array(
			'method'		=> 'GET',
			'timeout'		=> 5,
			'redirection'	=> 5,
			'httpversion'	=> '1.0',
			'blocking'		=> true,
			'headers'		=> array(
				'Authorization'		=> 'Bearer ' . $this->bearer_token,
				'Accept-Encoding'	=> 'gzip'
			),
			'body'		=> null,
			'cookies'	=> array()
		);

		$response = wp_remote_get('https://api.twitter.com/1.1/'. $this->get_val($this->query_args, 'type') . '.json?' . $query, $args);
		if(is_wp_error($response) || 200 != $response['response']['code']){
			if(!$stop){
				$this->bearer_token = $this->get_bearer_token();
				return $this->query($query, $this->query_args, true);
			}else{
				return $this->bail(__('Bearer Token is good, check your query', 'revslider'), $response);
			}
		}
		set_transient($transient_name, $response['body'], $this->query_args['cache']);

		return json_decode($response['body']);
	}

	/**
	* Let's manage errors
	*
	* WP_DEBUG has to be set to true to show errors
	*
	* @param string $error_text Error message
	* @param string $error_object Server response or wp_error
	*/
	private function bail($error_text, $error_object = ''){

		$this->has_error = true;

		if(is_wp_error($error_object)){
			$error_text .= ' - Wp Error: ' . $error_object->get_error_message();
		}elseif(!empty($error_object) && isset($error_object['response']['message'])){
			$error_text .= ' ( Response: ' . $error_object['response']['message'] . ')';
		}

		trigger_error($error_text , E_USER_NOTICE);
	}
}


/**
 * Instagram
 *
 * with help of the API this class delivers all kind of Images from instagram
 *
 * @package    socialstreams
 * @subpackage socialstreams/instagram
 * @author     ThemePunch <info@themepunch.com>
 */


if(!function_exists('rev_instagram_autoloader')){
	function rev_instagram_autoloader($class)
	{
		if(strpos($class, 'InstagramBasicDisplay') !== false){
			$filename = realpath(dirname(__FILE__)) .'/'. str_replace('\\', '/', $class) . '.php';
			include_once ($filename);
		}
	}
}

class RevSliderInstagram extends RevSliderFunctions {

    const QUERY_SHOW = 'ig_show';
    const QUERY_TOKEN = 'ig_token';
    const QUERY_CONNECTWITH = 'ig_user';
    const QUERY_ERROR = 'ig_error_message';

	/**
	 * API key
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $api_key    Instagram API key
	 */
	private $api_key;

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
	 * @var      number    $transient_sec Transient time in seconds
	*/
	private $transient_sec;
	/**
	 * Transient for token refresh in seconds
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      number    $transient_token_sec Transient time in seconds
	*/
	private $transient_token_sec;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $api_key	Instagram API key.
	 */
	public function __construct($transient_sec = 86400){
		spl_autoload_register('rev_instagram_autoloader');
		$this->transient_sec = $transient_sec;
		$this->transient_token_sec = 86400 * 30; // 30 days
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
	    if(!isset($_GET['page']) || $_GET['page'] != 'revslider') return;

	    //instagram returned error
	    if(isset($_GET[self::QUERY_ERROR])) return;

	    //we need token and slide ID to proceed with saving token
	    if(!isset($_GET[self::QUERY_TOKEN]) || !isset($_GET['id'])) return;

        $token = $_GET[self::QUERY_TOKEN];
        $connectwith = $_GET[self::QUERY_CONNECTWITH];
        $id = $_GET['id'];

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
	    if(!isset($_GET['page']) || $_GET['page'] != 'revslider') return;

	    if(isset($_GET[self::QUERY_SHOW]) || isset($_GET[self::QUERY_ERROR])){
            echo '<script>jQuery(document).ready(function(){ RVS.DOC.one("builderInitialised", function(){RVS.F.mainMode({mode:"sliderlayout", forms:["*sliderlayout*#form_slidercontent"], set:true, uncollapse:true,slide:RVS.S.slideId});RVS.F.updateSliderObj({path:"settings.sourcetype",val:"instagram"});RVS.F.updateEasyInputs({container:jQuery("#form_slidercontent"), trigger:"init", visualUpdate:true});}); });</script>';
        }

        if(isset($_GET[self::QUERY_ERROR])){
            $err = __('Instagram Reports: ', 'revslider') . esc_html($_GET[self::QUERY_ERROR]);
            echo '<script>jQuery(document).ready(function(){ RVS.DOC.one("builderInitialised", function(){ RVS.F.showInfo({content:"' . $err . '", type:"warning", showdelay:1, hidedelay:5, hideon:"", event:"" }); });});</script>';
        }
    }

	public static function get_login_url(){
        $app_id = '677807423170942';
        $redirect = 'https://updates.themepunch.tools/ig/auth.php';
        $state = base64_encode(admin_url('admin.php?page=revslider&view=slide&id='.$_GET['id']));
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
	public function get_tag_photos($search_user_id,$count,$orig_image){
		if(!empty($search_user_id)){

			$search_user_id = str_replace("#", "", $search_user_id);

			$url = 'https://www.instagram.com/explore/tags/'.$search_user_id.'/?__a=1';

			$transient_name = 'revslider_'. md5($url."count=".$count);

			if($this->transient_sec > 0 && false !== ($data = get_transient( $transient_name))){
				$this->stream = $data;
				return $this->stream;
			}
			else
				delete_transient( $transient_name );

				$rsp = json_decode(wp_remote_fopen($url));

				$count = $this->instagram_output_array($rsp->graphql->hashtag->edge_hashtag_to_media->edges,$count,$search_user_id,$orig_image);

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
	public function get_places_photos($search_user_id,$count,$orig_image){
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
	public function get_place_photos($search_user_id,$count,$orig_image){
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
	private function instagram_output_array_places($photos,$count,$search_user_id,$orig_image=""){
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
					$orig_image = array('',0,0);
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
		$page_data = "";

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

		} else {
			$data_str = '';
		}

		$headers_raw_list = array();

		foreach ($headers as $header_key => $header_value){
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

/**
 * Flickr
 *
 * with help of the API this class delivers all kind of Images from flickr
 *
 * @package    socialstreams
 * @subpackage socialstreams/flickr
 * @author     ThemePunch <info@themepunch.com>
 */

class RevSliderFlickr extends RevSliderFunctions {

	/**
	 * API key
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $api_key    flickr API key
	 */
	private $api_key;

	/**
	 * API params
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $api_param_defaults    Basic params to call with API
	 */
	private $api_param_defaults;

	/**
	 * Stream Array
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $stream    Stream Data Array
	 */
	private $stream;

	/**
	 * Basic URL
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $url    Url to fetch user from
	 */
	private $flickr_url;

	/**
	* Transient seconds
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      number    $transient Transient time in seconds
	*/
	private $transient_sec;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $api_key	flickr API key.
	 */
	public function __construct($api_key, $transient_sec = 1200){
		$this->api_key = $api_key;
		$this->api_param_defaults = array(
			'api_key' => $this->api_key,
			'format' => 'json',
			'nojsoncallback' => 1,
		);

		$this->transient_sec = $transient_sec;
	}

	/**
	 * Calls Flicker API with set of params, returns json
	 *
	 * @since    1.0.0
	 * @param    array    $params 	Parameter build for API request
	 */
	private function call_flickr_api($params){
		//build url
		$encoded_params = array();
		foreach($params as $k => $v){
			$encoded_params[] = urlencode($k).'='.urlencode($v);
		}

		//call the API and decode the response
		$url = 'https://api.flickr.com/services/rest/?'.implode('&', $encoded_params);
		$transient_name = 'revslider_' . md5($url);

		if($this->transient_sec > 0 && false !== ($data = get_transient($transient_name)))
			return ($data);

		$rsp = json_decode(file_get_contents($url));
		if(isset($rsp)){
			set_transient($transient_name, $rsp, $this->transient_sec);
			return $rsp;
		}else{
			return '';
		}
	}

	/**
	 * Get User ID from its URL
	 *
	 * @since    1.0.0
	 * @param    string    $user_url URL of the Gallery
	 */
	public function get_user_from_url($user_url){
		//gallery params
		$user_params = $this->api_param_defaults + array(
			'method'  => 'flickr.urls.lookupUser',
			'url' => $user_url,
		);

		//set User Url
		$this->flickr_url = $user_url;

		//get gallery info
		$user_info = $this->call_flickr_api($user_params);

		return $this->get_val($user_info, array('user', 'id'), '');
	}

	/**
	 * Get Group ID from its URL
	 *
	 * @since    1.0.0
	 * @param    string    $group_url URL of the Gallery
	*/
	public function get_group_from_url($group_url){
		//gallery params
		$group_params = $this->api_param_defaults + array(
			'method'  => 'flickr.urls.lookupGroup',
			'url' => $group_url,
		);

		//set User Url
		$this->flickr_url = $group_url;

		//get gallery info
		$group_info = $this->call_flickr_api($group_params);

		return $this->get_val($group_info, array('group', 'id'), '');
	}

	/**
	 * Get Public Photos
	 *
	 * @since    1.0.0
	 * @param    string    $user_id 	flicker User id (not name)
	 * @param    int       $item_count 	number of photos to pull
	 */
	public function get_public_photos($user_id, $item_count = 10){
		//public photos params
		$public_photo_params = $this->api_param_defaults + array(
			'method'  => 'flickr.people.getPublicPhotos',
			'user_id' => $user_id,
			'extras'  => 'description, license, date_upload, date_taken, owner_name, icon_server, original_format, last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o',
			'per_page'=> $item_count,
			'page' => 1
		);

		//get photo list
		$public_photos_list = $this->call_flickr_api($public_photo_params);

		return $this->get_val($public_photos_list, array('photos', 'photo'), '');
	}

	/**
	 * Get Photosets List from User
	 *
	 * @since    1.0.0
	 * @param    string    $user_id 	flicker User id (not name)
	 * @param    int       $item_count 	number of photos to pull
	*/
	public function get_photo_sets($user_id, $item_count, $current_photoset){ //item count default is 10
		//photoset params
		$photo_set_params = $this->api_param_defaults + array(
			'method'  => 'flickr.photosets.getList',
			'user_id' => $user_id,
			'per_page'=> $item_count,
			'page'    => 1
		);

		//get photoset list
		$photo_sets_list = $this->call_flickr_api($photo_set_params);

		$return = array();
		foreach($photo_sets_list->photosets->photoset as $photo_set){
			if(empty($photo_set->title->_content)) $photo_set->title->_content = "";
			if(empty($photo_set->photos))  $photo_set->photos = 0;
			$return[] = '<option title="'.$photo_set->description->_content.'" '.selected($photo_set->id , $current_photoset , false).' value="'.$photo_set->id.'">'.$photo_set->title->_content.' ('.$photo_set->photos.' photos)</option>"';
		}
		return $return;
	}

	/**
	 * Get Photoset Photos
	 *
	 * @since    1.0.0
	 * @param    string    $photo_set_id 	Photoset ID
	 * @param    int       $item_count 	number of photos to pull
	 */
	public function get_photo_set_photos($photo_set_id,$item_count=10){
		//photoset photos params
		$this->stream = array();
		$photo_set_params = $this->api_param_defaults + array(
			'method'  		=> 'flickr.photosets.getPhotos',
			'photoset_id' 	=> $photo_set_id,
			'per_page'		=> $item_count,
			'page'    		=> 1,
			'extras'		=> 'license, date_upload, date_taken, owner_name, icon_server, original_format, last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o'
		);

		//get photo list
		$photo_set_photos = $this->call_flickr_api($photo_set_params);

		return $this->get_val($photo_set_photos, array('photoset', 'photo'), '');
	}

	/**
	 * Get Groop Pool Photos
	 *
	 * @since    1.0.0
	 * @param    string    $group_id 	Photoset ID
	 * @param    int       $item_count 	number of photos to pull
	 */
	public function get_group_photos($group_id,$item_count=10){
		//photoset photos params
		$group_pool_params = $this->api_param_defaults + array(
			'method'  		=> 'flickr.groups.pools.getPhotos',
			'group_id' 	=> $group_id,
			'per_page'		=> $item_count,
			'page'    		=> 1,
			'extras'		=> 'license, date_upload, date_taken, owner_name, icon_server, original_format, last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o'
		);

		//get photo list
		$group_pool_photos = $this->call_flickr_api($group_pool_params);

		return $this->get_val($group_pool_photos, array('photos', 'photo'), '');
	}

	/**
	 * Get Gallery ID from its URL
	 *
	 * @since    1.0.0
	 * @param    string    $gallery_url URL of the Gallery
	 * @param    int       $item_count 	number of photos to pull
	 */
	public function get_gallery_from_url($gallery_url){
		//gallery params
		$gallery_params = $this->api_param_defaults + array(
			'method'  => 'flickr.urls.lookupGallery',
			'url' => $gallery_url,
		);

		//get gallery info
		$gallery_info = $this->call_flickr_api($gallery_params);

		return $this->get_val($gallery_info, array('gallery', 'id'), '');
	}

	/**
	 * Get Gallery Photos
	 *
	 * @since    1.0.0
	 * @param    string    $gallery_id 	flicker Gallery id (not name)
	 * @param    int       $item_count 	number of photos to pull
	 */
	public function get_gallery_photos($gallery_id,$item_count=10){
		//gallery photos params
		$gallery_photo_params = $this->api_param_defaults + array(
			'method'  => 'flickr.galleries.getPhotos',
			'gallery_id' => $gallery_id,
			'extras'  => 'description, license, date_upload, date_taken, owner_name, icon_server, original_format, last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o',
			'per_page'=> $item_count,
			'page' => 1
		);

		//get photo list
		$gallery_photos_list = $this->call_flickr_api($gallery_photo_params);

		return $this->get_val($gallery_photos_list, array('photos', 'photo'), '');
	}
}	// End Class


/**
 * Youtube
 *
 * with help of the API this class delivers all kind of Images/Videos from youtube
 *
 * @package    socialstreams
 * @subpackage socialstreams/youtube
 * @author     ThemePunch <info@themepunch.com>
 */

class RevSliderYoutube extends RevSliderFunctions {

	/**
	 * API key
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $api_key    Youtube API key
	 */
	private $api_key;

	/**
	 * Channel ID
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $channel_id    Youtube Channel ID
	 */
	private $channel_id;

	/**
	 * Stream Array
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $stream    Stream Data Array
	 */
	private $stream;

	/**
	* Transient seconds
	*
	* @since    1.0.0
	* @access   private
	* @var      number    $transient Transient time in seconds
	*/
	private $transient_sec;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $api_key	Youtube API key.
	 */
	public function __construct($api_key, $channel_id, $transient_sec = 1200){
		$this->api_key = $api_key;
		$this->channel_id = $channel_id;
		$this->transient_sec = $transient_sec;
	}


	/**
	 * Get Youtube Playlists
	 *
	 * @since    1.0.0
	 */
	public function get_playlists(){
		//call the API and decode the response
		$url = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&maxResults=50&channelId=".$this->channel_id."&key=".$this->api_key;
		$rsp = json_decode(wp_remote_fopen($url));

		return $this->get_val($rsp, 'items', false);
	}

	/**
	 * Get Youtube Playlist Items
	 *
	 * @since    1.0.0
	 * @param    string    $playlist_id 	Youtube Playlist ID
	 * @param    integer    $count 	Max videos count
	 */
	public function show_playlist_videos($playlist_id, $count = 50){
		//call the API and decode the response
		if(empty($count)) $count = 50;

		$url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=".$playlist_id."&maxResults=".$count."&fields=items%2Fsnippet&key=".$this->api_key;

		$transient_name = 'revslider_' . md5($url);

		if($this->transient_sec > 0 && false !== ($data = get_transient($transient_name)))
			return($data);

		$rsp = json_decode(wp_remote_fopen($url));

		if(!isset($rsp->items)) return array();

		set_transient($transient_name, $rsp->items, $this->transient_sec);

		return $rsp->items;
	}

	/**
	 * Get Youtube Channel Items
	 *
	 * @since    1.0.0
	 * @param    integer    $count 	Max videos count
	 */
	public function show_channel_videos($count = 50){
		if(empty($count)) $count = 50;
		//call the API and decode the response
		$url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId='.$this->channel_id.'&maxResults='.$count.'&key='.$this->api_key.'&order=date';

		$transient_name = 'revslider_' . md5($url);
		if($this->transient_sec > 0 && false !== ($data = get_transient($transient_name)))
			return ($data);

		$rsp = json_decode(wp_remote_fopen($url));

		if(!isset($rsp->items)) return array();

		set_transient($transient_name, $rsp->items, $this->transient_sec);

		return $rsp->items;
	}

	/**
	 * Get Playlists from Channel as Options for Selectbox
	 *
	 * @since    1.0.0
	 */
	public function get_playlist_options($current_playlist){
		$return = array();
		$playlists = $this->get_playlists();
		if(!empty($playlists)){
			foreach($playlists as $playlist){
				$return[] = '<option title="'.$playlist->snippet->description.'" '.selected($playlist->id , $current_playlist , false).' value="'.$playlist->id.'">'.$playlist->snippet->title.'</option>"';
			}
		}
		return $return;
	}
}	// End Class

/**
 * Vimeo
 *
 * with help of the API this class delivers all kind of Images/Videos from Vimeo
 *
 * @package    socialstreams
 * @subpackage socialstreams/vimeo
 * @author     ThemePunch <info@themepunch.com>
 */

class RevSliderVimeo extends RevSliderFunctions {
	/**
	 * Stream Array
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $stream    Stream Data Array
	 */
	private $stream;

	/**
	* Transient seconds
	*
	* @since    1.0.0
	* @access   private
	* @var      number    $transient Transient time in seconds
	*/
	private $transient_sec;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $api_key	Youtube API key.
	 */
	public function __construct($transient_sec = 1200){
		$this->transient_sec = $transient_sec;
	}

	/**
	 * Get Vimeo User Videos
	 *
	 * @since    1.0.0
	 */
	public function get_vimeo_videos($type, $value, $elements = 20){
		//call the API and decode the response
		$url = 'https://vimeo.com/api/v2/';
		$url .= ($type == 'user') ? $value.'/videos.json' : $type.'/'.$value.'/videos.json';

		$transient_name = 'revslider_' . md5($url.$elements);
		if($this->transient_sec > 0 && false !== ($data = get_transient($transient_name)))
			return ($data);

		$elements = intval($elements);
		$page = 1;
		$rsp = array();
		do {
			$_rsp = json_decode(wp_remote_fopen($url.'?page='.$page));
			if(!empty($_rsp) && is_array($_rsp)) $rsp = array_merge($rsp, $_rsp);
			$page++;
			$elements -= 20;
		} while($elements > 0);
		
		set_transient($transient_name, $rsp, $this->transient_sec);

		return $rsp;
	}
}	// End Class