<?php
/**
 * External Sources Twitter Class
 * @since: 5.0
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.sliderrevolution.com/
 * @copyright 2019 ThemePunch
 */

if (!defined('ABSPATH')) exit();

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
}

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