<?php
/**
 * External Sources Vimeo Class
 * @since: 5.0
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.sliderrevolution.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

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