<?php
/**
 * External Sources YouTube Class
 * @since: 5.0
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.sliderrevolution.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

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
}