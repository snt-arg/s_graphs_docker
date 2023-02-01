<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderGlobals {
	const SLIDER_REVISION = RS_REVISION;
	const TABLE_SLIDERS_NAME = RevSliderFront::TABLE_SLIDER;
	const TABLE_SLIDES_NAME = RevSliderFront::TABLE_SLIDES;
	const TABLE_STATIC_SLIDES_NAME = RevSliderFront::TABLE_STATIC_SLIDES;
	const TABLE_SETTINGS_NAME = RevSliderFront::TABLE_SETTINGS;
	const TABLE_CSS_NAME = RevSliderFront::TABLE_CSS;
	const TABLE_LAYER_ANIMS_NAME = RevSliderFront::TABLE_LAYER_ANIMATIONS;
	const TABLE_NAVIGATION_NAME = RevSliderFront::TABLE_NAVIGATIONS;
	public static $table_sliders;
	public static $table_slides;
	public static $table_static_slides;

	/**
	 * Stores the singleton instance of the class
	 * @var RevSliderGlobals
	 */
	private static $instance;

	/**
	 * store global objects
	 * @var array
	 */
	private $storage = array();

	protected function __construct()
	{
	}

	/**
	 * Instance accessor. If instance doesn't exist, we'll initialize the class.
	 *
	 * @return RevSliderGlobals
	 */
	public static function instance()
	{
		if (!isset(self::$instance)) {
			self::$instance = new RevSliderGlobals();
		}
		return self::$instance;
	}

	/**
	 * store $object under $key in $storage
	 * @param $key
	 * @param $object
	 */
	function add($key, $object) {
		$this->storage[$key] = $object;
	}

	/**
	 * get object from storage
	 * @param $key
	 * @return mixed|null
	 */
	function get($key) {
		if (array_key_exists($key, $this->storage)) return $this->storage[$key];

		//try to create one
		if (class_exists($key)) {
			$this->add($key, new $key);;
		} else {
			//class not exists, add null to prevent further attempts
			$this->add($key, NULL);
		}

		return $this->storage[$key];
	}

	/**
	 * @return array  list of revslider DB tables
	 */
	public function get_rs_tables()
	{
		global $wpdb;

		return array(
			$wpdb->prefix . RevSliderFront::TABLE_SLIDER,
			$wpdb->prefix . RevSliderFront::TABLE_SLIDES,
			$wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES,
			$wpdb->prefix . RevSliderFront::TABLE_CSS,
			$wpdb->prefix . RevSliderFront::TABLE_LAYER_ANIMATIONS,
			$wpdb->prefix . RevSliderFront::TABLE_NAVIGATIONS,
			$wpdb->prefix . RevSliderFront::TABLE_SETTINGS,
		);
	}
}

global $wpdb;

RevSliderGlobals::$table_sliders = $wpdb->prefix.'revslider_sliders';
RevSliderGlobals::$table_slides = $wpdb->prefix.'revslider_slides';
RevSliderGlobals::$table_static_slides = $wpdb->prefix.'revslider_static_slides';
