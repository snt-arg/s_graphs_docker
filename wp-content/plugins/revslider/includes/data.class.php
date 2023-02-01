<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

define('RS_T', '	');
define('RS_T2', '		');
define('RS_T3', '			');
define('RS_T4', '				');
define('RS_T5', '					');
define('RS_T6', '						');
define('RS_T7', '							');
define('RS_T8', '								');
define('RS_T9', '									');
define('RS_T10', '										');
define('RS_T11', '											');

class RevSliderData {

	const CACHE_GROUP = 'revslider';
	const CACHE_NS_KEY = 'revslider_namespace_key';

	public $css;

	/**
	 * wp cache does not support group delete
	 * this var hold the num to generate unique keys
	 * when data changed - key increased and invalidate old data
	 * @var int
	 */
	protected $_cache_ns_key;
	/**
	 * @var array hold revslider tables names
	 */
	protected $_rs_tables;
	/**
	 * @var string
	 */
	protected $_rs_tables_pattern;
	
	public function __construct()
	{
		$this->_rs_tables = RevSliderGlobals::instance()->get_rs_tables();
		$this->_rs_tables_pattern = "/^\s*(insert|update|replace|delete).+(".implode('|', $this->_rs_tables).")/i";
		
		$this->_cache_ns_key = wp_cache_get(self::CACHE_NS_KEY, self::CACHE_GROUP);
		if (false === $this->_cache_ns_key) {
			$this->_cache_ns_key = 1;
			wp_cache_set(self::CACHE_NS_KEY, $this->_cache_ns_key, self::CACHE_GROUP);
		}

		$query_filter = RevSliderGlobals::instance()->get('rs_data_query_fiter');
		if (!$query_filter) {
			add_filter('query', array($this, 'add_query_fiter'), 10, 1);
			RevSliderGlobals::instance()->add('rs_data_query_fiter', true);
		}
	}

	/**
	 * invalidate group cache if we modify rs data
	 * @param string $sql
	 * @return string
	 */
	public function add_query_fiter($sql)
	{
		if (preg_match($this->_rs_tables_pattern, $sql)) {
			$this->invalidate_group_cache();
		}
		return $sql;
	}

	/**
	 * invalidate group keys by increase namespace key
	 */
	public function invalidate_group_cache()
	{
		$this->_cache_ns_key += 1;
		wp_cache_set(self::CACHE_NS_KEY, $this->_cache_ns_key, self::CACHE_GROUP);
	}

	/**
	 * @param string $fname  cache key name ( usually function name )
	 * @param mixed $data  additional cache key data ( usually functions parameters )
	 * @return string
	 */
	public function get_wp_cache_key($fname, $data){
		return sprintf('%s_%s_%s_%s', get_class($this), $fname, $this->_cache_ns_key, md5(serialize($data)));
	}

	/**
	 * try to load cached result
	 *
	 * @param string $method
	 * @param array $args
	 * @return mixed
	 */
	public function get_wp_cache($method, $args = array())
	{
		if (!is_array($args)) $args = array($args);
		//disable cache for admin
		if (is_admin()) return call_user_func_array(array($this, $method), $args);
		
		$cache_key = $this->get_wp_cache_key($method, $args);
		$data = wp_cache_get($cache_key, self::CACHE_GROUP);
		if (false === $data) {
			$data = call_user_func_array(array($this, $method), $args);
			wp_cache_set($cache_key, $data, self::CACHE_GROUP);
		}

		return $data;
	}

	/**
	 * clear cached value
	 *
	 * @param string $method
	 * @param array $args
	 */
	public function delete_wp_cache($method, $args = array())
	{
		if (!is_array($args)) $args = array($args);

		$cache_key = $this->get_wp_cache_key($method, $args);
		wp_cache_delete($cache_key, self::CACHE_GROUP);
	}

	/**
	 * flush all cache
	 */
	public function flush_wp_cache()
	{
		wp_cache_flush();
	}

	/**
	 * get cache attempt of _get_font_familys
	 * @return mixed
	 */
	public function get_font_familys(){
		return $this->get_wp_cache('_get_font_familys');
	}

	/**
	 * get all font family types
	 * before: RevSliderOperations::getArrFontFamilys()
	 */
	protected function _get_font_familys(){
		$fonts = array();

		//add custom added fonts
		$gs = $this->get_global_settings();
		$cfl = $this->get_val($gs, 'customFontList', array());

		if(!empty($cfl) && is_array($cfl)){
			foreach($cfl as $_cfl){
				$fonts[] = array(
					'type'		=> 'custom',
					'version'	=> __('Custom Fonts', 'revslider'),
					'url'		=> $this->get_val($_cfl, 'url'),
					'frontend'	=> $this->_truefalse($this->get_val($_cfl, 'frontend', false)),
					'backend'	=> $this->_truefalse($this->get_val($_cfl, 'backend', true)),
					'label'		=> $this->get_val($_cfl, 'family'),
					'variants'	=> explode(',', $this->get_val($_cfl, 'weights')),
				);
			}
		}

		//Web Safe Fonts
		// GOOGLE Loaded Fonts
		$fonts[] = array('type' => 'websafe', 'version' => __('Loaded Google Fonts', 'revslider'), 'label' => 'Dont Show Me');

		//Serif Fonts
		$fonts[] = array('type' => 'websafe', 'version' => __('Serif Fonts', 'revslider'), 'label' => 'Georgia, serif');
		$fonts[] = array('type' => 'websafe', 'version' => __('Serif Fonts', 'revslider'), 'label' => '\'Palatino Linotype\', \'Book Antiqua\', Palatino, serif');
		$fonts[] = array('type' => 'websafe', 'version' => __('Serif Fonts', 'revslider'), 'label' => '\'Times New Roman\', Times, serif');

		//Sans-Serif Fonts
		$fonts[] = array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'revslider'), 'label' => 'Arial, Helvetica, sans-serif');
		$fonts[] = array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'revslider'), 'label' => '\'Arial Black\', Gadget, sans-serif');
		$fonts[] = array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'revslider'), 'label' => '\'Comic Sans MS\', cursive, sans-serif');
		$fonts[] = array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'revslider'), 'label' => 'Impact, Charcoal, sans-serif');
		$fonts[] = array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'revslider'), 'label' => '\'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif');
		$fonts[] = array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'revslider'), 'label' => 'Tahoma, Geneva, sans-serif');
		$fonts[] = array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'revslider'), 'label' => '\'Trebuchet MS\', Helvetica, sans-serif');
		$fonts[] = array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'revslider'), 'label' => 'Verdana, Geneva, sans-serif');

		//Monospace Fonts
		$fonts[] = array('type' => 'websafe', 'version' => __('Monospace Fonts', 'revslider'), 'label' => '\'Courier New\', Courier, monospace');
		$fonts[] = array('type' => 'websafe', 'version' => __('Monospace Fonts', 'revslider'), 'label' => '\'Lucida Console\', Monaco, monospace');


		//push all variants to the websafe fonts
		foreach($fonts as $f => $font){
			if(!empty($cfl) && is_array($cfl) && $font['type'] === 'custom') continue; //already manually added before on these

			$font[$f]['variants'] = array('100', '100italic', '200', '200italic', '300', '300italic', '400', '400italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic');
		}

		include(RS_PLUGIN_PATH . 'includes/googlefonts.php');

		foreach($googlefonts as $f => $val){
			$fonts[] = array('type' => 'googlefont', 'version' => __('Google Fonts', 'revslider'), 'label' => $f, 'variants' => $val['variants'], 'subsets' => $val['subsets'], 'category' => $val['category']);
		}

		return apply_filters('revslider_data_get_font_familys', apply_filters('revslider_operations_getArrFontFamilys', $fonts));
	}

	/**
	 * get animations array
	 * @before: RevSliderOperations::getArrAnimations();
	 */
	public function get_animations(){
		return $this->get_custom_animations_full_pre('in');
	}

	/**
	 * get "end" animations array
	 * @before: RevSliderOperations::getArrEndAnimations();
	 */
	public function get_end_animations(){
		return $this->get_custom_animations_full_pre('out');
	}

	public function get_loop_animations(){
		return $this->get_custom_animations_full_pre('loop');
	}

	/**
	 * get the version 5 animations only, if available
	 **/
	public function get_animations_v5(){
		global $revslider_animations;
		$custom = array();
		$temp = array();
		$sort = array();

		$this->fill_animations();

		foreach($revslider_animations as $value){
			$type = $this->get_val($value, array('params', 'type'), '');
			if(!in_array($type, array('customout', 'customin'))) continue;

			$settings = $this->get_val($value, 'settings', '');
			$type = $this->get_val($value, 'type', '');
			if($type == '' && $settings == ''){
				$temp[$value['id']] = $value;
				$temp[$value['id']]['id'] = $value['id'];
				$sort[$value['id']] = $value['handle'];
			}
		}
		if(!empty($sort)){
			asort($sort);
			foreach ($sort as $k => $v){
				$custom[$k] = $temp[$k];
			}
		}

		return $custom;
	}

	/**
	 * get custom animations
	 * @before: RevSliderOperations::getCustomAnimationsFullPre()
	 */
	public function get_custom_animations_full_pre($pre = 'in'){
		global $revslider_animations;
		$custom = array();
		$temp = array();
		$sort = array();

		$this->fill_animations();

		foreach($revslider_animations as $value){
			$settings = $this->get_val($value, 'settings', '');
			$type = $this->get_val($value, 'type', '');
			if($type == '' && $settings == '' || $type == $pre){
				$temp[$value['id']] = $value;
				$temp[$value['id']]['id'] = $value['id'];
				$sort[$value['id']] = $value['handle'];
			}

			if($settings == 'in' && $pre == 'in' || $settings == 'out' && $pre == 'out' || $settings == 'loop' && $pre == 'loop'){
				$temp[$value['id']] = $value['params'];
				$temp[$value['id']]['settings'] = $settings;
				$temp[$value['id']]['id'] = $value['id'];
				$sort[$value['id']] = $value['handle'];
			}
		}
		if(!empty($sort)){
			asort($sort);
			foreach($sort as $k => $v){
				$custom[$k] = $temp[$k];
			}
		}

		return $custom;
	}

	/**
	 * Fetch all Custom Animations only one time
	 * @since: 5.2.4
	 * @before: RevSliderOperations::fillAnimations();
	 **/
	public function fill_animations(){
		global $revslider_animations;
		if(empty($revslider_animations)){
			global $wpdb;

			$result = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . RevSliderFront::TABLE_LAYER_ANIMATIONS, ARRAY_A);
			$revslider_animations = (!empty($result)) ? $result : array();

			if(!empty($revslider_animations)){
				foreach($revslider_animations as $ak => $av){
					$revslider_animations[$ak]['params'] = json_decode(str_replace("'", '"', $av['params']), true);
				}
			}

			if(!empty($revslider_animations)){
				array_walk_recursive($revslider_animations, array('RevSliderData', 'force_to_boolean'));
			}
		}
	}

	/**
	 * make sure that all false and true are really boolean
	 **/
	public static function force_to_boolean(&$a, $b){
		$a = ($a === 'false') ? false : $a;
		$a = ($a === 'true') ? true : $a;
		$b = ($b === 'false') ? false : $b;
		$b = ($b === 'true') ? true : $b;
	}

	/**
	 * get contents of the css table as an array
	 * before: RevSliderOperations::getCaptionsContentArray();
	 */
	public function get_captions_array($handle = false){
		$css = RevSliderGlobals::instance()->get('RevSliderCssParser');
		if(empty($this->css)){
			$this->fill_css();
		}

		return $css->db_array_to_array($this->css, $handle);
	}

	/**
	 * Fetch all Custom CSS only one time
	 * @since: 5.2.4
	 * before: RevSliderOperations::fillCSS();
	 **/
	public function fill_css(){
		if(empty($this->css)){
			global $wpdb;

			$css_data = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . RevSliderFront::TABLE_CSS, ARRAY_A);
			$this->css = (!empty($css_data)) ? $css_data : array();
		}
	}

	/**
	 * Get all images sizes + custom added sizes
	 * @before: RevSliderBase::get_all_image_sizes($type);
	 */
	public function get_all_image_sizes($type = 'gallery'){
		$custom_sizes = array();

		switch($type){
			case 'flickr':
				$custom_sizes = array(
					'original' => __('Original', 'revslider'),
					'large' => __('Large', 'revslider'),
					'large-square' => __('Large Square', 'revslider'),
					'medium' => __('Medium', 'revslider'),
					'medium-800' => __('Medium 800', 'revslider'),
					'medium-640' => __('Medium 640', 'revslider'),
					'small' => __('Small', 'revslider'),
					'small-320' => __('Small 320', 'revslider'),
					'thumbnail' => __('Thumbnail', 'revslider'),
					'square' => __('Square', 'revslider'),
				);
			break;
			case 'instagram':
				$custom_sizes = array(
					'standard_resolution' => __('Standard Resolution', 'revslider'),
					'thumbnail' => __('Thumbnail', 'revslider'),
					'low_resolution' => __('Low Resolution', 'revslider'),
					'original_size' => __('Original Size', 'revslider'),
					'large' => __('Large Size', 'revslider'),
				);
			break;
			case 'twitter':
				$custom_sizes = array(
					'large' => __('Standard Resolution', 'revslider'),
				);
			break;
			case 'facebook':
				$custom_sizes = array(
					'full' => __('Original Size', 'revslider'),
					'thumbnail' => __('Thumbnail', 'revslider'),
				);
			break;
			case 'youtube':
				$custom_sizes = array(
					'high' => __('High', 'revslider'),
					'medium' => __('Medium', 'revslider'),
					'default' => __('Default', 'revslider'),
					'standard' => __('Standard', 'revslider'),
					'maxres' => __('Max. Res.', 'revslider'),
				);
			break;
			case 'vimeo':
				$custom_sizes = array(
					'thumbnail_large' => __('Large', 'revslider'),
					'thumbnail_medium' => __('Medium', 'revslider'),
					'thumbnail_small' => __('Small', 'revslider'),
				);
			break;
			case 'gallery':
			default:
				$added_image_sizes = get_intermediate_image_sizes();
				if(!empty($added_image_sizes) && is_array($added_image_sizes)){
					foreach($added_image_sizes as $key => $img_size_handle){
						$custom_sizes[$img_size_handle] = ucwords(str_replace('_', ' ', $img_size_handle));
					}
				}
				$img_orig_sources = array(
					'full' => __('Original Size', 'revslider'),
					'thumbnail' => __('Thumbnail', 'revslider'),
					'medium' => __('Medium', 'revslider'),
					'large' => __('Large', 'revslider'),
				);
				$custom_sizes = array_merge($img_orig_sources, $custom_sizes);
			break;
		}

		return $custom_sizes;
	}

	/**
	 * get the default layer animations
	 **/
	public function get_layer_animations($raw = false){
		$custom_in = $this->get_animations();
		$custom_out = $this->get_end_animations();
		$custom_loop = $this->get_loop_animations();

		$in = '{
			"custom":{"group":"Custom","custom":true,"transitions":' .
		json_encode($custom_in)
			. '},
			"blck":{
				"group":"Block Transitions (SFX)",
				"transitions":{
					"blockfromleft":{"name":"Block from Left","frame_0":{"transform":{"opacity":0}},"frame_1":{"transform":{"opacity":1},"sfx":{"effect":"blocktoright","color":"#ffffff"},"timeline":{"ease":"power4.inOut","speed":1200}}},
					"blockfromright":{"name":"Block from Right","frame_0":{"transform":{"opacity":0}},"frame_1":{"transform":{"opacity":1},"sfx":{"effect":"blocktoleft","color":"#ffffff"},"timeline":{"ease":"power4.inOut","speed":1200}}},
					"blockfromtop":{"name":"Block from Top","frame_0":{"transform":{"opacity":0}},"frame_1":{"transform":{"opacity":1},"sfx":{"effect":"blocktobottom","color":"#ffffff"},"timeline":{"ease":"power4.inOut","speed":1200}}},
					"blockfrombottom":{"name":"Block from Bottom","frame_0":{"transform":{"opacity":0}},"frame_1":{"transform":{"opacity":1},"sfx":{"effect":"blocktotop","color":"#ffffff"},"timeline":{"ease":"power4.inOut","speed":1200}}}
				}
			},
			"lettran":{
				"group":"Letter Transitions",
				"transitions":{
					"LettersFlyInFromLeft":{"name":"Letters Fly In From Left","frame_0":{"transform":{"opacity":1},"chars":{"use":true,"x":"-105%","opacity":"0","rotationZ":"-90deg"},"mask":{"use":true}},"frame_1":{"timeline":{"speed":1200},"transform":{"opacity":1},"chars":{"ease":"power4.inOut","use":true,"direction":"backward","delay":10,"x":0,"opacity":1,"rotationZ":"0deg"},"mask":{"use":true}}},
					"LettersFlyInFromRight":{"name":"Letters Fly In From Right","frame_0":{"transform":{"opacity":1},"chars":{"use":true,"x":"105%","opacity":"1","rotationY":"45deg","rotationZ":"90deg"},"mask":{"use":true}},"frame_1":{"timeline":{"speed":1200},"transform":{"opacity":1},"chars":{"ease":"power4.inOut","use":true,"direction":"forward","delay":10,"x":0,"opacity":1,"rotationY":0,"rotationZ":"0deg"},"mask":{"use":true}}},
					"LettersFlyInFromTop":{"name":"Letters Fly In From Top","frame_0":{"transform":{"opacity":1},"chars":{"use":true,"y":"-100%","opacity":"0","rotationZ":"35deg"},"mask":{"use":true}},"frame_1":{"timeline":{"speed":1200},"transform":{"opacity":1},"chars":{"ease":"power4.inOut","use":true,"direction":"forward","delay":10,"y":0,"opacity":1,"rotationZ":"0deg"},"mask":{"use":true}}},
					"LettersFlyInFromBottom":{"name":"Letters Fly In From Bottom","frame_0":{"transform":{"opacity":1},"chars":{"use":true,"y":"100%","opacity":"0","rotationZ":"-35deg"},"mask":{"use":true}},"frame_1":{"timeline":{"speed":1200},"transform":{"opacity":1},"chars":{"ease":"power4.inOut","use":true,"direction":"forward","delay":10,"y":0,"opacity":1,"rotationZ":"0deg"},"mask":{"use":true}}},
					"LetterFlipFromTop":{"name":"Letter Flip From Top","frame_0":{"transform":{"opacity":1},"chars":{"use":true,"opacity":0,"rotationX":"90deg","y":"0","originZ":"-50"}},"frame_1":{"timeline":{"speed":1750},"chars":{"use":true,"opacity":1,"rotationX":0,"delay":10,"originZ":"-50","ease":"power4.inOut"}}},
					"LetterFlipFromBottom":{"name":"Letter Flip From Bottom","frame_0":{"transform":{"opacity":1},"chars":{"use":true,"opacity":0,"rotationX":"-90deg","y":"0","originZ":"-50"}},"frame_1":{"timeline":{"speed":1750},"chars":{"use":true,"opacity":1,"rotationX":0,"delay":10,"originZ":"-50","ease":"power4.inOut"}}},
					"FlipAndLetterCycle":{"name":"Letter Flip Cycle","frame_0":{"transform":{"opacity":0,"rotationX":"70deg","y":"0","originZ":"-50"},"chars":{"use":true,"opacity":0,"y":"[-100||100]"}},"frame_1":{"timeline":{"speed":1750,"ease":"power4.inOut"},"transform":{"opacity":1,"originZ":"-50","rotationX":0},"chars":{"use":true,"direction":"middletoedge","opacity":1,"y":0,"delay":10,"ease":"power4.inOut"}}}
				}
			},
			"masktrans":{
				"group":"Masked Transitions",
				"transitions":{
					"MaskedZoomOut":{"name":"Masked Zoom Out","frame_0":{"transform":{"opacity":0,"scaleX":2,"scaleY":2},"mask":{"use":true}},"frame_1":{"timeline":{"speed":1000,"ease":"power2.out"},"mask":{"use":true},"transform":{"opacity":1,"scaleX":1,"scaleY":1}}},
					"SlideMaskFromBottom":{"name":"Slide From Bottom","frame_0":{"transform":{"opacity":0,"y":"100%"},"mask":{"use":true}},"frame_1":{"timeline":{"speed":1200,"ease":"power3.inOut"},"mask":{"use":true,"y":0},"transform":{"opacity":1,"y":0}}},
					"SlideMaskFromLeft":{"name":"Slide From Left","frame_0":{"transform":{"opacity":0,"x":"-100%"},"mask":{"use":true}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"mask":{"use":true},"transform":{"opacity":1,"x":0}}},
					"SlideMaskFromRight":{"name":"Slide From Right","frame_0":{"transform":{"opacity":0,"x":"100%"},"mask":{"use":true}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"mask":{"use":true},"transform":{"opacity":1,"x":0}}},
					"SlideMaskFromTop":{"name":"Slide From Top","frame_0":{"transform":{"opacity":0,"y":"-100%"},"mask":{"use":true}},"frame_1":{"timeline":{"speed":1200,"ease":"power3.inOut"},"mask":{"use":true},"transform":{"opacity":1,"y":0}}},
					"SmoothMaskFromRight":{"name":"Smooth Mask From Right","frame_0":{"transform":{"opacity":1,"x":"-175%"},"mask":{"use":true,"x":"100%"}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.out"},"mask":{"use":true,"x":0},"transform":{"opacity":1,"x":0}}},
					"SmoothMaskFromLeft":{"name":"Smooth Mask From Left","frame_0":{"transform":{"opacity":1,"x":"175%"},"mask":{"use":true,"x":"-100%"}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.out"},"mask":{"use":true,"x":0},"transform":{"opacity":1,"x":0}}}
				}
			},
			"popup":{
				"group":"Pop Ups",
				"transitions":{
					"PopUpBack":{"name":"Pop Up Back","frame_0":{"transform":{"opacity":0,"rotationY":"360deg"}},"frame_1":{"timeline":{"speed":500,"ease":"back.out"},"transform":{"opacity":1,"rotationY":0}}},
					"PopUpSmooth":{"name":"Pop Up Smooth","frame_0":{"transform":{"opacity":0,"scaleX":0.9,"scaleY":0.9}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":1,"scaleX":1,"scaleY":1}}},
					"SmoothPopUp_One":{"name":"Smooth Pop Up v.1","frame_0":{"transform":{"opacity":0,"scaleX":0.8,"scaleY":0.8}},"frame_1":{"timeline":{"speed":1000,"ease":"power4.out"},"transform":{"opacity":1,"scaleX":1,"scaleY":1}}},
					"SmoothPopUp_Two":{"name":"Smooth Pop Up v.2","frame_0":{"transform":{"opacity":0,"scaleX":0.9,"scaleY":0.9}},"frame_1":{"timeline":{"speed":1000,"ease":"power2.inOut"},"transform":{"opacity":1,"scaleX":1,"scaleY":1}}}
				}
			},
			"rotate":{
				"group":"Rotations",
				"transitions":{
					"RotateInFromBottom":{"name":"Rotate In From Bottom","frame_0":{"transform":{"opacity":0,"rotationZ":"70deg","y":"bottom","scaleY":2,"scaleX":2}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":1,"y":0,"rotationZ":0,"scaleX":1,"scaleY":1}}},
					"RotateInFormZero":{"name":"Rotate In From Bottom v2.","frame_0":{"transform":{"opacity":1,"rotationY":"-20deg","rotationX":"-20deg","y":"200%","scaleY":2,"scaleX":2}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.out"},"transform":{"opacity":1,"y":0,"rotationZ":0,"rotationY":0,"scaleX":1,"scaleY":1}}},
					"FlipFromTop":{"name":"Flip From Top","frame_0":{"transform":{"opacity":0,"rotationX":"70deg","y":"0","originZ":"-50"}},"frame_1":{"timeline":{"speed":1750,"ease":"power4.inOut"},"transform":{"opacity":1,"originZ":"-50","rotationX":0}}},
					"FlipFromBottom":{"name":"Flip From Bottom","frame_0":{"transform":{"opacity":0,"rotationX":"-70deg","y":"0","originZ":"-50"}},"frame_1":{"timeline":{"speed":1750,"ease":"power4.inOut"},"transform":{"opacity":1,"rotationX":0,"originZ":"-50"}}}
				}
			},
			"slidetrans":{
				"group":"Slide Transitions",
				"transitions":{
					"sft":{"name":"Short Slide from Top","frame_0":{"transform":{"opacity":0,"y":-50}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":1,"y":0}}},
					"sfb":{"name":"Short Slide from Bottom","frame_0":{"transform":{"opacity":0,"y":50}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":1,"y":0}}},
					"sfl":{"name":"Short Slide from Left","frame_0":{"transform":{"opacity":0,"x":-50}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":1,"x":0}}},
					"sfr":{"name":"Short Slide from Right","frame_0":{"transform":{"opacity":0,"x":50}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":1,"x":0}}},
					"lft":{"name":"Long Slide from Top","frame_0":{"transform":{"opacity":0,"y":"top"}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":1,"y":0}}},
					"lfb":{"name":"Long Slide from Bottom","frame_0":{"transform":{"opacity":0,"y":"bottom"}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":1,"y":0}}},
					"lfl":{"name":"Long Slide from Left","frame_0":{"transform":{"opacity":0,"x":"left"}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":1,"x":0}}},
					"lfr":{"name":"Long Slide from Right","frame_0":{"transform":{"opacity":0,"x":"right"}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":1,"x":0}}},
					"SmoothSlideFromBottom":{"name":"Smooth Slide From Bottom","frame_0":{"transform":{"opacity":0,"y":"100%"}},"frame_1":{"timeline":{"speed":1200,"ease":"power4.inOut"},"transform":{"opacity":1,"y":0}}}
				}
			},
			"skewtrans":{
				"group":"Skew Transitions",
				"transitions":{
					"skewfromleft":{"name":"Skew from Left","frame_0":{"transform":{"opacity":0,"skewX":85,"x":"left"}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":1,"skewX":0,"x":0}}},
					"skewfromright":{"name":"Skew from Right","frame_0":{"transform":{"opacity":0,"skewX":-85,"x":"right"}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":1,"skewX":0,"x":0}}},
					"skewfromleftshort":{"name":"Skew from Left Short","frame_0":{"transform":{"opacity":0,"skewX":45,"x":"-100%"}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":1,"skewX":0,"x":0}}},
					"skewfromrightshort":{"name":"Skew from Right Short","frame_0":{"transform":{"opacity":0,"skewX":-45,"x":"100%"}},"frame_1":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":1,"skewX":0,"x":0}}}
				}
			},
			"simpltrans":{
				"group":"Simple Transitions",
				"transitions":{
					"noanim":{"name":"No Animation","frame_0":{"transform":{"opacity":1}},"frame_1":{"transform":{"opacity":1}}},
					"tp-fade":{"name":"Fade In","frame_0":{"transform":{"opacity":0}},"frame_1":{"timeline":{"speed":1500,"ease":"power4.inOut"},"transform":{"opacity":1}}}
				}
			},
			"randtrans":{
				"group":"Random Transitions",
				"transitions":{
					"Random":{"name":"Random","frame_0":{"transform":{"opacity":0,"y":"{-150,150}","x":"{-250,250}","scaleX":"{0,1.5}","scaleY":"{0,1.5}","rotationX":"{-90,90}","rotationY":"{-90,90}","rotationZ":"{-90,90}"}},"frame_1":{"timeline":{"speed":1500,"ease":"power4.inOut"},"transform":{"opacity":1,"x":0,"y":0,"z":0,"rotationX":0,"rotationY":0,"rotationZ":0,"scaleX":1,"scaleY":1}}},
					"RandomChars":{"name":"Random Chars","frame_0":{"transform":{"opacity":1},"chars":{"use":true,"y":"{-150,150}","x":"{-250,250}","scaleX":"{0,1.5}","scaleY":"{0,1.5}","rotationX":"{-90,90}","rotationY":"{-90,90}","rotationZ":"{-90,90}"}},"frame_1":{"timeline":{"speed":1500,"ease":"power4.inOut"},"chars":{"use":true,"direction":"random","pacity":1,"x":0,"y":0,"z":0,"rotationX":0,"rotationY":0,"rotationZ":0,"scaleX":1,"scaleY":1,"delay":10}}}
				}
			}
		}';

		$out = '{
			"custom":{"group":"Custom","custom":true,"transitions":' .
		json_encode($custom_out)
			. '},
			"blck":{
				"group":"Block Transitions (SFX)",
				"transitions":{
					"blocktoleft":{"name":"Block to Left","frame_999":{"transform":{"opacity":0},"sfx":{"effect":"blocktoright","color":"#ffffff"},"timeline":{"ease":"power4.inOut","speed":1200}}},
					"blocktoright":{"name":"Block to Right","frame_999":{"transform":{"opacity":0},"sfx":{"effect":"blocktoleft","color":"#ffffff"},"timeline":{"ease":"power4.inOut","speed":1200}}},
					"blocktotop":{"name":"Block to Top","frame_999":{"transform":{"opacity":0},"sfx":{"effect":"blocktobottom","color":"#ffffff"},"timeline":{"ease":"power4.inOut","speed":1200}}},
					"blocktobottom":{"name":"Block to Bottom","frame_999":{"transform":{"opacity":0},"sfx":{"effect":"blocktotop","color":"#ffffff"},"timeline":{"ease":"power4.inOut","speed":1200}}}
				}
			},
			"lettran":{
				"group":"Letter Transitions",
				"transitions":{
					"LettersFlyOutToLeft":{"name":"Letters Fly Out To Left","frame_999":{"transform":{"opacity":1},"chars":{"ease":"power4.inOut","direction":"forward","use":true,"x":"-105%","opacity":"0","delay":10,"rotationZ":"-90deg"},"mask":{"use":true},"timeline":{"speed":1200}}},
					"LettersFlyInFromRight":{"name":"Letters Fly In From Right","frame_999":{"transform":{"opacity":1},"chars":{"ease":"power4.inOut","delay":10,"direction":"backward","use":true,"x":"105%","opacity":"0","rotationY":"45deg","rotationZ":"90deg"},"timeline":{"speed":1200},"mask":{"use":true}}},
					"LettersFlyInFromTop":{"name":"Letters Fly In From Top","frame_999":{"transform":{"opacity":1},"chars":{"use":true,"y":"-100%","opacity":"0","rotationZ":"35deg","ease":"power4.inOut","direction":"backward","delay":10},"timeline":{"speed":1200},"mask":{"use":true}}},
					"LettersFlyInFromBottom":{"name":"Letters Fly In From Bottom","frame_999":{"transform":{"opacity":1},"chars":{"use":true,"y":"100%","opacity":"0","rotationZ":"-35deg","ease":"power4.inOut","direction":"forward","delay":10},"timeline":{"speed":1200},"mask":{"use":true}}},
					"LetterFlipFromTop":{"name":"Letter Flip From Top","frame_999":{"transform":{"opacity":1},"chars":{"use":true,"opacity":0,"rotationX":"90deg","y":"0","originZ":"-50","ease":"power4.inOut","delay":10},"timeline":{"speed":1750}}},
					"LetterFlipFromBottom":{"name":"Letter Flip From Bottom","frame_999":{"transform":{"opacity":1},"chars":{"use":true,"opacity":0,"rotationX":"-90deg","y":"0","originZ":"-50","delay":10,"ease":"power4.inOut"},"timeline":{"speed":1750}}},
					"FlipAndLetterCycle":{"name":"Letter Flip Cycle","frame_999":{"transform":{"opacity":0,"rotationX":"70deg","y":"0","originZ":"-50"},"chars":{"use":true,"direction":"middletoedge","delay":10,"ease":"power4.inOut","opacity":0,"y":"[-100||100]"},"timeline":{"speed":1750,"ease":"power4.inOut"}}}
				}
			},
			"masktrans":{
				"group":"Masked Transitions",
				"transitions":{
					"MaskedZoomOut":{"name":"Masked Zoom In","frame_999":{"transform":{"opacity":0,"scaleX":2,"scaleY":2},"mask":{"use":true},"timeline":{"speed":1000,"ease":"power2.out"}}},
					"SlideMaskToBottom":{"name":"Slide To Bottom","frame_999":{"transform":{"opacity":0,"y":"100%"},"mask":{"use":true},"timeline":{"speed":1200,"ease":"power3.inOut"}}},
					"SlideMaskToLeft":{"name":"Slide To Left","frame_999":{"transform":{"opacity":0,"x":"-100%"},"mask":{"use":true},"timeline":{"speed":1000,"ease":"power3.inOut"}}},
					"SlideMaskToRight":{"name":"Slide To Right","frame_999":{"transform":{"opacity":0,"x":"100%"},"mask":{"use":true},"timeline":{"speed":1000,"ease":"power3.inOut"}}},
					"SlideMaskToTop":{"name":"Slide To Top","frame_999":{"transform":{"opacity":0,"y":"-100%"},"mask":{"use":true},"timeline":{"speed":1200,"ease":"power3.inOut"}}},
					"SmoothMaskToRight":{"name":"Smooth Mask To Right","frame_999":{"transform":{"opacity":1,"x":"-175%"},"mask":{"use":true,"x":"100%"},"timeline":{"speed":1000,"ease":"power3.inOut"}}},
					"SmoothMaskToLeft":{"name":"Smooth Mask To Left","frame_999":{"transform":{"opacity":1,"x":"175%"},"mask":{"use":true,"x":"-100%"},"timeline":{"speed":1000,"ease":"power3.inOut"}}},
					"SmoothToBottom":{"name":"Smooth To Bottom","frame_999":{"transform":{"opacity":1,"y":"175%"},"mask":{"use":true},"timeline":{"speed":1000,"ease":"power2.inOut"}}},
					"SmoothToTop":{"name":"Smooth To Top","frame_999":{"transform":{"opacity":1,"y":"-175%"},"mask":{"use":true},"timeline":{"speed":1000,"ease":"power2.inOut"}}}
				}
			},
			"bounce":{
				"group":"Bounce and Hide",
				"transitions":{
					"BounceOut":{"name":"Bounce Out","frame_999":{"timeline":{"speed":500,"ease":"back.in"},"transform":{"opacity":0,"scaleX":0.7,"scaleY":0.7}}},
					"SlurpOut":{"name":"Slurp Out","frame_999":{"timeline":{"speed":1000,"ease":"power2.in"},"transform":{"opacity":0,"y":"100%","scaleX":0.7,"scaleY":0.7},"mask":{"use":true}}},
					"PopUpBack":{"name":"Bounce Out Rotate","frame_999":{"timeline":{"speed":500,"ease":"back.in"},"transform":{"opacity":0,"rotationY":"360deg"}}},
					"PopUpSmooth":{"name":"Hide Smooth","frame_999":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":0,"scaleX":0.9,"scaleY":0.9}}},
					"SmoothPopUp_One":{"name":"Smooth Hide v.1","frame_999":{"timeline":{"speed":1000,"ease":"power4.out"},"transform":{"opacity":0,"scaleX":0.8,"scaleY":0.8}}},
					"SmoothPopUp_Two":{"name":"Smooth Hide v.2","frame_999":{"timeline":{"speed":1000,"ease":"power2.inOut"},"transform":{"opacity":0,"scaleX":0.9,"scaleY":0.9}}}
				}
			},
			"rotate":{
				"group":"Rotations",
				"transitions":{
					"RotateOutToBottom":{"name":"Rotate Out To Bottom","frame_999":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":0,"rotationZ":"70deg","y":"bottom","scaleY":2,"scaleX":2}}},
					"RotateInFormZero":{"name":"Rotate Out To Bottom v2.","frame_999":{"timeline":{"speed":1000,"ease":"power3.out"},"transform":{"opacity":0,"rotationY":"-20deg","rotationX":"-20deg","y":"200%","scaleY":2,"scaleX":2}}},
					"FlipToTop":{"name":"Flip To Top","frame_999":{"timeline":{"speed":1750,"ease":"power4.inOut"},"transform":{"opacity":0,"rotationX":"70deg","y":"0","originZ":"-50"}}},
					"FlipToBottom":{"name":"Flip To Bottom","frame_999":{"timeline":{"speed":1750,"ease":"power4.inOut"},"transform":{"opacity":0,"rotationX":"-70deg","y":"0","originZ":"-50"}}}
				}
			},
			"slidetrans":{
				"group":"Slide Transitions",
				"transitions":{
					"stt":{"name":"Short Slide to Top","frame_999":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":0,"y":-50}}},
					"stb":{"name":"Short Slide to Bottom","frame_999":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":0,"y":50}}},
					"stl":{"name":"Short Slide to Left","frame_999":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":0,"x":-50}}},
					"str":{"name":"Short Slide to Right","frame_999":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":0,"x":50}}},
					"ltt":{"name":"Long Slide to Top","frame_999":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":0,"y":"top"}}},
					"ltb":{"name":"Long Slide to Bottom","frame_999":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":0,"y":"bottom"}}},
					"ltl":{"name":"Long Slide to Left","frame_999":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":0,"x":"left"}}},
					"ltr":{"name":"Long Slide to Right","frame_999":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":0,"x":"right"}}},
					"SmoothSlideToBottom":{"name":"Smooth Slide To Bottom","frame_999":{"timeline":{"speed":1200,"ease":"power4.inOut"},"transform":{"opacity":0,"y":"100%"}}}
				}
			},
			"skewtrans":{
				"group":"Skew Transitions",
				"transitions":{
					"skewfromleft":{"name":"Skew from Left","frame_999":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":0,"skewX":85,"x":"left"}}},
					"skewfromright":{"name":"Skew from Right","frame_999":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":0,"skewX":-85,"x":"right"}}},
					"skewfromleftshort":{"name":"Skew from Left Short","frame_999":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":0,"skewX":45,"x":"-100%"}}},
					"skewfromrightshort":{"name":"Skew from Right Short","frame_999":{"timeline":{"speed":1000,"ease":"power3.inOut"},"transform":{"opacity":0,"skewX":-45,"x":"100%"}}}
				}
			},
			"simpltrans":{
				"group":"Simple Transitions",
				"transitions":{
					"noanim":{"name":"No Animation","frame_999":{"transform":{"opacity":1}}},
					"tp-fade-out":{"name":"Fade Out","frame_999":{"timeline":{"speed":1000,"ease":"power4.inOut"},"transform":{"opacity":0}}},
					"fadeoutlong":{"name":"Fade Out Long","frame_999":{"timeline":{"speed":1000,"ease":"power2.in"},"transform":{"opacity":0}}}
				}
			},
			"randtrans":{
				"group":"Random Transitions",
				"transitions":{
					"RandomOut":{"name":"Random Out","frame_999":{"timeline":{"speed":1500,"ease":"power4.inOut"},"transform":{"opacity":0,"y":"{-150,150}","x":"{-250,250}","scaleX":"{0,1.5}","scaleY":"{0,1.5}","rotationX":"{-90,90}","rotationY":"{-90,90}","rotationZ":"{-90,90}"}}},
					"RandomCharsOut":{"name":"Random Chars Out","frame_999":{"timeline":{"speed":1500,"ease":"power4.inOut"},"transform":{"opacity":1},"chars":{"direction":"random","delay":10,"use":true,"y":"{-150,150}","x":"{-250,250}","scaleX":"{0,1.5}","scaleY":"{0,1.5}","rotationX":"{-90,90}","rotationY":"{-90,90}","rotationZ":"{-90,90}"}}}
				}
			}
		}';

		$loop = '{
			"custom":{group:"Custom",custom:true,transitions:' .
		json_encode($custom_loop)
			. '},
			"pendulum":{group:"Pendulum Loops",
				transitions: {
					"inplacependulum":{name:"In Place Pendulum", loop:{use:true, yoyo_rotate:true, speed:3000, ease:"power1.inOut", frame_0:{rotationZ:-40}, frame_999:{rotationZ:40}}},
					"pendulumbelow":{name:"Pendulum Below", loop:{use:true, yoyo_rotate:true, speed:3000, originY:"-200%", ease:"sine.inOut", frame_0:{rotationZ:-40}, frame_999:{rotationZ:40}}},
					"pendulumabove":{name:"Pendulum Above",loop:{use:true, yoyo_rotate:true, speed:3000, originY:"200%", ease:"sine.inOut", frame_0:{rotationZ:-40}, frame_999:{rotationZ:40}}},
					"pendulumleft":{name:"Pendulum Left",loop:{use:true, yoyo_rotate:true, speed:3000, originX:"150%", ease:"sine.inOut", frame_0:{rotationZ:-20}, frame_999:{rotationZ:20}}},
					"pendulumright":{name:"Pendulum Right",loop:{use:true, yoyo_rotate:true, speed:3000, originX:"-50%", ease:"sine.inOut", frame_0:{rotationZ:-20}, frame_999:{rotationZ:20}}}

			}},
			"effects":{group:"Effect Loops",
				transitions: {
					"grayscale":{name:"Grayscale",loop:{use:true, yoyo_filter:true, speed:1000,  ease:"sine.inOut", frame_0:{grayscale:0}, frame_999:{grayscale:100}}},
					"blink":{name:"Blink",loop:{use:true, yoyo_filter:true, speed:1500,  ease:"sine.inOut", frame_0:{opacity:0}, frame_999:{opacity:1}}},
					"flattern":{name:"Flattern",loop:{use:true, yoyo_filter:true, speed:100,  ease:"sine.inOut", frame_0:{opacity:0.2,blur:0}, frame_999:{opacity:1,blur:4}}},
					"lighting":{name:"Lithing",loop:{use:true, yoyo_filter:true, speed:1000,  ease:"sine.inOut", frame_0:{brightness:100}, frame_999:{brightness:1000}}}
			}},
			"wave":{group:"Wave",
				transitions: {
					"littlewaveleft":{name:"Little Wave Left", loop:{use:true, curved:true, speed:3000, ease:"none", frame_0:{xr:60,yr:60}, frame_999:{xr:60,yr:60}}},
					"littlewaveright":{name:"Little Wave Right", loop:{use:true, curved:true, speed:3000, ease:"none", frame_0:{xr:60,yr:-60}, frame_999:{xr:60,yr:-60}}},
					"Bigwaveleft":{name:"Big Wave Left", loop:{use:true, curved:true, speed:3000, ease:"none", frame_0:{xr:140,yr:140}, frame_999:{xr:140,yr:140}}},
					"Bigwaveright":{name:"Big Wave Right", loop:{use:true, curved:true, speed:3000, ease:"none", frame_0:{xr:140,yr:-140}, frame_999:{xr:140,yr:-140}}},
					"eight":{name:"Curving Wave", loop:{use:true, curved:true, speed:3000, ease:"none", curviness:8, frame_0:{xr:100,yr:100}, frame_999:{xr:100,yr:100}}}
			}},
			"wiggle":{group:"Wiggles",
				transitions: {
					"smoothwigglez":{name:"Smooth Y Axis Wiggle", loop:{use:true, yoyo_rotate:true, speed:3000, ease:"sine.inOut", frame_0:{rotationY:-40}, frame_999:{rotationY:40}}},
					"smoothwigglezii":{name:"Smooth Y Axis Wiggle II.", loop:{use:true, originZ:60, yoyo_rotate:true, speed:3000, ease:"sine.inOut", frame_0:{rotationY:-40}, frame_999:{rotationY:40}}},
					"smoothwiggleziii":{name:"Smooth Y Axis Wiggle III.", loop:{use:true, originZ:-160, yoyo_rotate:true, speed:3000, ease:"sine.inOut", frame_0:{rotationY:-40}, frame_999:{rotationY:40}}},
					"smoothwigglex":{name:"Smooth X Axis Wiggle", loop:{use:true, yoyo_rotate:true, speed:3000, ease:"sine.inOut", frame_0:{rotationX:-40}, frame_999:{rotationX:40}}},
					"smoothwigglexii":{name:"Smooth X Axis Wiggle II", loop:{use:true, originZ:60, yoyo_rotate:true, speed:3000, ease:"sine.inOut", frame_0:{rotationX:-40}, frame_999:{rotationX:40}}},
					"smoothwigglexiii":{name:"Smooth X Axis Wiggle III", loop:{use:true, originZ:-160, yoyo_rotate:true, speed:3000, ease:"sine.inOut", frame_0:{rotationX:-40}, frame_999:{rotationX:40}}},
					"crazywiggle":{name:"Funny Wiggle Path", loop:{use:true, originZ:-160, originY:"-50%", yoyo_scale:true, yoyo_move:true, yoyo_rotate:true, speed:3000, ease:"circ.inOut", frame_0:{x:100, y:-70,rotationX:-20, rotationY:-20, rotationZ:10}, frame_999:{x:0, y:70,scaleX:1.4, scaleY:1.4, rotationX:30, rotationY:10, rotationZ:-5}}}
			}},
			"rotate":{group:"Rotating",
				transitions: {
					"rotating":{name:"Rotate", loop:{use:true, speed:3000, ease:"none", frame_0:{rotationZ:0}, frame_999:{rotationZ:360}}},
					"rotatingyoyo":{name:"Rotate Forw. Backw.", loop:{use:true, yoyo_rotate:true, speed:3000, ease:"none", frame_0:{rotationZ:-100}, frame_999:{rotationZ:100}}},
					"leaf":{name:"Flying Around", loop:{use:true,  curved:true, curviness:25, yoyo_rotate:true, yoyo_filter:true, speed:6000, ease:"none", frame_0:{xr:30,yr:22,zr:40}, frame_999:{xr:40,yr:12, zr:-100, rotationZ:720,blur:5}}},
			}},
			"slide":{group:"Slide and Hover",
				transitions: {
					"slidehorizontal":{name:"Slide Horizontal", loop:{use:true, yoyo_move:true, speed:3000, ease:"sine.inOut", frame_0:{x:-100}, frame_999:{x:100}}},
					"hoover":{name:"Hover", loop:{use:true, yoyo_move:true,speed:6000, ease:"sine.inOut", frame_0:{y:-10}, frame_999:{y:10}}},
			}},
			"pulse":{group:"Pulse",
				transitions: {
					"pulse":{name:"Pulse", loop:{use:true, yoyo_scale:true, yoyo_filter:true, speed:2000, ease:"power4.inOut", frame_999:{scaleX:1.2, scaleY:1.2}}},
					"pulseminus":{name:"Pulse Minus", loop:{use:true, yoyo_scale:true, yoyo_filter:true, speed:2000, ease:"power0.inOut", frame_999:{scaleX:0.8, scaleY:0.8}}},
					"pulseandopacity":{name:"Pulse and Fade", loop:{use:true, yoyo_scale:true, yoyo_filter:true, speed:2000, ease:"power0.inOut", frame_999:{scaleX:1.2, scaleY:1.2,opacity:0.6}}},
					"pulseandopacityminus":{name:"Pulse and Fade Minus", loop:{use:true, yoyo_scale:true, yoyo_filter:true, speed:2000, ease:"power2.inOut", frame_999:{scaleX:0.8, scaleY:0.8,opacity:0.6}}},
					"pulseandopablur":{name:"Pulse and Blur", loop:{use:true, yoyo_scale:true, yoyo_filter:true, speed:2000, ease:"power1.inOut", frame_999:{scaleX:1.2, scaleY:1.2,opacity:0.8,blur:5}}},
					"pulseandopablurminus":{name:"Pulse and Blur Minus", loop:{use:true, yoyo_scale:true, yoyo_filter:true, speed:2000, ease:"power0.inOut", frame_999:{scaleX:0.8, scaleY:0.8,opacity:0.8,blur:5}}}

			}},
		}';

		$anim = array();
		$anim['in'] = ($raw) ? $in : json_decode($in, true);
		$anim['out'] = ($raw) ? $out : json_decode($out, true);
		$anim['loop'] = ($raw) ? $loop : json_decode($loop, true);

		return $anim;
	}

	/**
	 * add default icon sets of Slider Revolution
	 * @since: 5.0
	 * @before: RevSliderBase::set_icon_sets();
	 **/
	public function set_icon_sets($icon_sets){

		$icon_sets[] = 'fa-icon-';
		$icon_sets[] = 'fa-';
		$icon_sets[] = 'pe-7s-';

		return $icon_sets;
	}

	/**
	 * attempt to load cache for _get_base_transitions
	 * @return mixed
	 */
	public function get_base_transitions($raw = false){
		return $this->get_wp_cache('_get_base_transitions', array($raw));
	}

	/**
	 * get base transitions
	 **/
	protected function _get_base_transitions($raw = false){
		$transitions = '{
			"basic":{ "icon":"aspect_ratio",
				"fade":{
					"notransition":{"title":"*clear* No Transition","speed":"10","in":{"o":1},"out":{"a":false, "o":1}},
					"fade":{"title":"*opacity* Fade In","in":{"o":0},"out":{"a":false}},
					"crossfade":{"title":"*opacity* Cross Fade","in":{"o":0}},
					"fadethroughdark":{"title":"*dark_mode* Via Dark","in":{"o":0},"out":{"a":false,"o":0},"p":"dark"},
					"fadethroughlight":{"title":"*light_mode* Via Light","in":{"o":0},"out":{"a":false,"o":0},"p":"light"},
					"fadethroughtransparent":{"title":"*grain* Via Transparent", "in":{"o":0},"out":{"a":false,"o":0},"p":"transparent"},
					"slotfade-vertical":{"title":"*south* Gradient","in":{"o":0,"row":400}},
					"slotfade-horizontal":{"title":"*east* Gradient","in":{"o":0,"col":400}}
				},

				"slideover":{
					"slideoververtical":{"title":"*swap_vert* Auto Direction","in":{"y":"(100%)"},"out":{"a":false}},
					"slideoverhorizontal":{"title":"*swap_horiz* Auto Direction","in":{"x":"(100%)"},"out":{"a":false}},
					"slideoverup":{"title":"*north*","in":{"y":"100%"},"out":{"a":false}},
					"slideoverdown":{"title":"*south*","in":{"y":"-100%"},"out":{"a":false}},
					"slideoverleft":{"title":"*west*","in":{"x":"100%"},"out":{"a":false}},
					"slideoverright":{"title":"*east*","in":{"x":"-100%"},"out":{"a":false}}
				},
				"remove":{
					"slideremovevertical":{"title":"*swap_vert* Auto Direction","out":{"a":false,"y":"(-100%)"}},
					"slideremovehorizontal":{"title":"*swap_horiz* Auto Direction","out":{"a":false,"x":"(-100%)"}},
					"slideremoveup":{"title":"*north*","out":{"a":false,"y":"100%"}},
					"slideremovedown":{"title":"*south*","out":{"a":false,"y":"-100%"}},
					"slideremoveleft":{"title":"*west*","out":{"a":false,"x":"100%"}},
					"slideremoveright":{"title":"*east*","out":{"a":false,"x":"-100%"}}
				},
				"slideinout":{
					"slidevertical":{"title":"*swap_vert* Auto Direction", "in":{"y":"(100%)"}},
					"slidehorizontal":{"title":"*swap_horiz* Auto Direction","in":{"x":"(100%)"}},
					"slideup":{"title":"*north*", "in":{"y":"100%"}},
					"slidedown":{"title":"*south*", "in":{"y":"-100%"}},
					"slideleft":{"title":"*west*", "in":{"x":"100%"}},
					"slideright":{"title":"*east*", "in":{"x":"-100%"}}
				},
				"slideinoutfadein":{
					"slidefadeinvertical":{"title":"*swap_vert* Auto Direction","in":{"o":0,"y":"(100%)"},"out":{"a":false}},
					"slidefadeinhorizontal":{"title":"*swap_horiz* Auto Direction","in":{"o":0,"x":"(100%)"},"out":{"a":false}},
					"fadefrombottom":{"title":"*north*","in":{"o":0,"y":"100%"},"out":{"a":false}},
					"fadefromtop":{"title":"*south*","in":{"o":0,"y":"-100%"},"out":{"a":false}},
					"fadefromright":{"title":"*west*","in":{"o":0,"x":"100%"},"out":{"a":false}},
					"fadefromleft":{"title":"*east*","in":{"o":0,"x":"100%"},"out":{"a":false}}
				},
				"slideinoutfadeinout":{
					"slidefadeinoutvertical":{"title":"*swap_vert* Auto Direction","in":{"o":0,"y":"(100%)"}},
					"slidefadeinouthorizontal":{"title":"*swap_horiz* Auto Direction","in":{"o":0,"x":"(100%)"}},
					"fadetotopfadefrombottom":{"title":"*north*","in":{"o":0,"y":"100%"}},
					"fadetobottomfadefromtop":{"title":"*south*","in":{"o":0,"y":"-100%"}},
					"fadetoleftfadefromright":{"title":"*west*","in":{"o":0,"x":"100%"}},
					"fadetorightfadefromleft":{"title":"*east*","in":{"o":0,"x":"100%"}}
				},
				"parallax":{
					"parallaxvertical":{"title":"*swap_vert* Auto Direction", "in":{"y":"(100%)"},"out":{"a":false,"y":"(-60%)"}},
					"parallaxhorizontal":{"title":"*swap_horiz* Auto Direction", "in":{"x":"(100%)"},"out":{"a":false,"x":"(-60%)"}},
					"parallaxtotop":{"title":"*north*", "in":{"y":"100%"},"out":{"a":false,"y":"-60%"}},
					"parallaxtobottom":{"title":"*south*", "in":{"y":"-100%"},"out":{"a":false,"y":"60%"}},
					"parallaxtoleft":{"title":"*west*", "in":{"x":"100%"},"out":{"a":false,"x":"-60%"}},
					"parallaxtoright":{"title":"*east*", "in":{"x":"-100%"},"out":{"a":false,"x":"60%"}}
				},
				"double":{
					"slidingoverlayvertical":{"title":"*swap_vert* Auto Direction","speed":"2000", "in":{"y":"(100%)"},"e":"slidingoverlay"},
					"slidingoverlayhorizontal":{"title":"*swap_horiz* Auto Direction","speed":"2000","in":{"x":"(100%)"},"e":"slidingoverlay"},
					"slidingoverlayup":{"title":"*north*","in":{"y":"100%"},"speed":"2000","e":"slidingoverlay"},
					"slidingoverlaydown":{"title":"*south*","in":{"y":"-100%"},"speed":"2000","e":"slidingoverlay"},
					"slidingoverlayleft":{"title":"*west*","in":{"x":"100%"},"speed":"2000","e":"slidingoverlay"},
					"slidingoverlayright":{"title":"*east*","in":{"x":"-100%"},"speed":"2000","e":"slidingoverlay"}
				},
				"zoom":{
					"zoomin":{"title":"*add*","in":{"sx":"0.6","sy":"0.6","o":0},"out":{"a":false,"sx":"1.6","sy":"1.6","o":0}},
					"zoomout":{"title":"*remove*","in":{"sx":"1.6","sy":"1.6","o":-0.5,"e":"power0.inOut"},"out":{"a":false,"sx":"0.6","sy":"0.6","o":0}},
					"zoomind":{"title":"*add* Via Dark", "p":"dark", "in":{"sx":"0.6","sy":"0.6","o":0},"out":{"a":false,"sx":"1.6","sy":"1.6","o":0}},
					"zoomoutd":{"title":"*remove* Via Dark","p":"dark", "in":{"sx":"1.6","sy":"1.6","o":-0.5,"e":"power0.inOut"},"out":{"a":false,"sx":"0.6","sy":"0.6","o":0}},
					"zoominl":{"title":"*add* Via Light", "p":"light", "in":{"sx":"0.6","sy":"0.6","o":0},"out":{"a":false,"sx":"1.6","sy":"1.6","o":0}},
					"zoomoutl":{"title":"*remove* Via Light","p":"light", "in":{"sx":"1.6","sy":"1.6","o":-0.5,"e":"power0.inOut"},"out":{"a":false,"sx":"0.6","sy":"0.6","o":0}}
				},
				"zoomslidein":{
					"scaledownvertical":{"title":"*swap_vert* Auto Direction", "in":{"y":"(100%)"}, "out":{"a":false, "sx":"0.85", "sy":"0.85", "o":"1"}},
					"scaledownhorizontal":{"title":"*swap_horiz* Auto Direction", "in":{"x":"(100%)"}, "out":{"a":false, "sx":"0.85", "sy":"0.85", "o":"1"}},
					"scaledownfromtop":{"title":"*north*", "in":{"y":"100%"}, "out":{"a":false, "sx":"0.85", "sy":"0.85", "o":"1"}},
					"scaledownfrombottom":{"title":"*south*", "in":{"y":"-100%"}, "out":{"a":false, "sx":"0.85", "sy":"0.85", "o":"1"}},
					"scaledownfromleft":{"title":"*west*", "in":{"x":"100%"}, "out":{"a":false, "sx":"0.85", "sy":"0.85", "o":"1"}},
					"scaledownfromright":{"title":"*east*", "in":{"x":"-100%"}, "out":{"a":false, "sx":"0.85", "sy":"0.85", "o":"1"}}
				},
				"zoomslideout":{
					"scaleupvertical":{"title":"*swap_vert* Auto Direction","o":"outin", "in":{"sx":"0.85", "sy":"0.85","o":"0"}, "out":{"a":false, "y":"(100%)", "o":"1"}},
					"scaleuphorizontal":{"title":"*swap_horiz* Auto Direction","o":"outin", "in":{"sx":"0.85", "sy":"0.85","o":"0"}, "out":{"a":false,  "x":"(100%)", "o":"1"}},
					"scaleupfromtop":{"title":"*north*", "o":"outin","in":{"sx":"0.85", "sy":"0.85" ,"o":"0"}, "out":{"a":false, "y":"-100%", "o":"1"}},
					"scaleupfrombottom":{"title":"*south*","o":"outin", "in":{"sx":"0.85", "sy":"0.85","o":"0"}, "out":{"a":false,"y":"100%" , "o":"1"}},
					"scaleupfromleft":{"title":"*west*","o":"outin", "in":{"sx":"0.85", "sy":"0.85","o":"0"}, "out":{"a":false, "x":"-100%", "o":"1"}},
					"scaleupfromright":{"title":"*east*", "o":"outin","in":{"sx":"0.85", "sy":"0.85","o":"0"}, "out":{"a":false,"x":"100%" , "o":"1"}}
				},
				"filter":{
					"blurlight":{"title":"*blur_on* Blur 1x","filter":{"u":true, "b":"2", "e":"default"},"in":{"o":"0","e":"power1.in", "sx":"1.01","sy":"1.01"}},
					"blurlightcross":{"title":"*blur_on* Blur 2x","filter":{"u":true, "b":"4", "e":"late2"},"in":{"o":"0","e":"power1.in", "sx":"1.02","sy":"1.02"}},
					"blurstrong":{"title":"*blur_on* Blur 3x","filter":{"u":true, "b":"6", "e":"late"},"in":{"o":"0","e":"power1.in", "sx":"1.05","sy":"1.05"}},
					"blurstrongcross":{"title":"*blur_on* Blur 4x","filter":{"u":true, "b":"10", "e":"late3"},"in":{"o":"0","e":"power1.in", "sx":"1.1","sy":"1.1"}},
					"brightness":{"title":"*brightness_7* Bright 1x","filter":{"u":true, "h":"200", "e":"late"},"in":{"o":"0","e":"power1.in"}},
					"brightnesscross":{"title":"*brightness_7* Bright 2x","filter":{"u":true, "h":"400", "e":"late3"},"in":{"o":"0","e":"power1.in"}},
					"grayscale":{"title":"*compare* Grayscale 1x","filter":{"u":true, "g":"80", "e":"late"},"in":{"o":"0","e":"power1.in"}},
					"grayscalecross":{"title":"*compare* Grayscale 2x","filter":{"u":true, "g":"100", "e":"late2"},"in":{"o":"0","e":"power1.in"}},
					"sephia":{"title":"*camera_roll* Sephia 1x","filter":{"u":true, "s":"50", "e":"late"},"in":{"o":"0","e":"power1.in"}},
					"sephiacross":{"title":"*camera_roll* Sephia 2x","filter":{"u":true, "s":"100", "e":"late2"},"in":{"o":"0","e":"power1.in"}}
				},
				"effects":{
					"cube":{"title":"*view_in_ar* Cube Vert.","speed":"2000", "in":{"o":0},"out":{"a":false},"d3":{"f":"cube", "d":"vertical", "z":"400", "c":"#ccc", "e":"power2.inOut","su":"true", "smi":"0", "sma":"1"}},
					"cube-r":{"title":"*view_in_ar* Cube Far Vert.","speed":"2000","in":{"o":0},"out":{"a":false},"d3":{"f":"cube", "d":"vertical", "z":"600", "t":"40", "c":"#ccc", "e":"power2.inOut","su":"true"}},
					"cube-horizontal":{"title":"*view_in_ar* Cube Horiz.","speed":"2000","in":{"o":0},"out":{"a":false},"d3":{"f":"cube", "d":"horizontal", "z":"400", "c":"#ccc", "e":"power2.inOut","su":"true"}},
					"cube-r-horizontal":{"title":"*view_in_ar* Cube Far Horiz.","speed":"2000","in":{"o":0},"out":{"a":false},"d3":{"f":"cube", "d":"horizontal", "t":"-45", "z":"450", "c":"#ccc", "e":"power2.inOut","su":"true"}},
					"incube":{"title":"*3d_rotation* Cube Inside Vert.","speed":"2000","in":{"o":0},"out":{"a":false},"d3":{"f":"incube", "d":"vertical", "z":"400", "c":"#ccc", "e":"power2.inOut"}},
					"incube-horizontal":{"title":"*3d_rotation* Cube Inside Horiz.","speed":"2000","in":{"o":0},"out":{"a":false},"d3":{"f":"incube", "d":"horizontal", "z":"400", "c":"#ccc", "e":"power2.inOut"}},
					"flyin":{"title":"*send* Fly Horiz.","speed":"2000","in":{"o":0},"out":{"a":false},"d3":{"f":"fly", "d":"horizontal", "z":"400", "c":"#ccc", "e":"power2.out", "fdi":"1.5", "fdo":"1.5", "fz":"10","su":"true"}},
					"flyin-r":{"title":"*send* Fly Far Horiz.","speed":"2000","in":{"o":0},"out":{"a":false},"d3":{"f":"fly", "d":"horizontal", "z":"650", "c":"#ccc", "e":"power2.out", "t":"20", "fdi":"1.5", "fdo":"1.5", "fz":"10","su":"true"}},
					"flyin-vertical":{"title":"*send* Fly Vert.","speed":"2000","in":{"o":0},"out":{"a":false},"d3":{"f":"fly", "d":"vertical", "z":"400", "c":"#ccc", "e":"power2.out", "fdi":"1.5","fdo":"1.5", "fz":"10","su":"true"}},
					"flyin-vertical-r":{"title":"*send* Fly Far Vert.","speed":"2000","in":{"o":0},"out":{"a":false},"d3":{"f":"fly", "d":"vertical", "z":"700", "c":"#ccc", "e":"power2.out","t":"-40", "fdi":"1.5","fdo":"1.5", "fz":"10","su":"true"}},
					"turnoff":{"title":"*movie_creation* Clapper Horiz.","speed":"2000","in":{"o":0},"out":{"a":false},"d3":{"f":"turn", "d":"horizontal","su":"true"}},
					"turnoff-b":{"title":"*movie_creation* Clapper Back Horiz.","speed":"2000","in":{"o":0},"out":{"a":false},"d3":{"f":"turn", "d":"horizontal", "e":"back.out","su":"true"}},
					"turnoff-vertical":{"title":"*movie_creation* Clapper Vert.","speed":"2000","in":{"o":0},"out":{"a":false},"d3":{"f":"turn", "d":"vertical","su":"true"}},
					"turnoff-vertical-e":{"title":"*movie_creation* Clapper Bounce Vert.","speed":"2000","in":{"o":0},"out":{"a":false},"d3":{"f":"turn", "d":"vertical", "e":"BounceStrong","su":"true"}}
				}
			},
			"columns":{ "icon":"view_week",
				"slide":{
					"slotslide-horizontal":{"title":"*west* Uniform", "in":{"x":"(100%)","m":true,"col":5},"f":"nodelay"},
					"slotslide-vhf":{"title":"*west* Flow", "in":{"x":"(100%)","m":true,"col":5},"f":"slidebased"},
					"slotslide-vv":{"title":"*north* Flow", "in":{"y":"(100%)","m":true,"col":5},"f":"slidebased"},
					"slotslide-h-dark":{"title":"*west* Via Dark", "p":"dark","in":{"x":"(100%)","m":true,"col":5},"f":"nodelay"},
					"slotslide-vhfd":{"title":"*west* Flow Via Dark","p":"dark", "in":{"x":"(100%)","m":true,"col":5},"f":"slidebased"},
					"slotslide-vvd":{"title":"*north* Flow Via Dark", "p":"dark","in":{"y":"(100%)","m":true,"col":5},"f":"slidebased"},
					"slotslide-vvvd":{"title":"*swap_vert* Vary Via Dark","p":"dark", "in":{"y":"[100%,-100%]","m":true,"col":8},"f":"slidebased"},
					"slotslide-vvv":{"title":"*swap_vert* Vary", "in":{"y":"[100%,-100%]","m":true,"col":8},"f":"slidebased"}
				},
				"zoom":{
					"slotzoom-horizontal":{"title":"*blur_on* Blur", "f":"nodelay", "filter":{"u":true, "b":"2", "e":"default"}, "in":{"col":"6", "e":"power2.inOut", "m":"true", "sx":"1.5", "sy":"1.2", "o":"0"}},
					"3dcurtain-horizontal":{"title":"*west* Mini PopUp", "speed":"500", "in":{"x":"(-50%)", "sx":"0.7","sy":"0.7","o":"0","m":true,"col":6,"e":"power4.inOut"},"out":{"a":false},"f":"slidebased","d":"10"},
					"slotzoom-mixed":{"title":"*blur_on* Blur & Slide", "f":"start", "d":"50", "filter":{"u":true, "b":"2", "e":"default"}, "in":{"col":"6", "e":"power2.inOut", "m":"true", "x":"(-20%)", "y":"(-20%)","sx":"1.5", "sy":"1.5", "o":"0"}},
					"slotzoom-randomcol":{"title":"*shuffle* Random", "speed":"800", "f":"random", "d":"10", "in":{"col":"7", "e":"power2.inOut", "r":"[-5,-3,-10,-5,-2,0,3,10,8,5]", "m":"true", "sx":"2", "sy":"2", "o":"0"}}
				},
				"curtain":{
					"curtain-1":{"title":"*east*", "in":{"y":"(-100%)","col":5}},
					"curtain-2":{"title":"*west*","in":{"y":"(-100%)","col":5},"f":"end"},
					"curtain-3":{"title":"*west**east*","in":{"y":"(-100%)","col":5},"f":"center"},
					"curtain-4":{"title":"*east**west*","in":{"y":"(-100%)","col":5},"f":"edges"},
					"curtain-5":{"title":"*shuffle* Random","in":{"y":"(-100%)","col":5},"f":"random"},
					"curtain-6":{"title":"*swap_horiz* Auto Direction","in":{"y":"(-100%)","col":5},"f":"slidebased"}
				},
				"rotation":{
					"slotzoom-minrotatecol":{"title":"*rotate_left* Edge", "speed":"1500", "f":"center", "d":"100", "in":{"col":"7", "e":"power2.inOut", "r":"[10,6,3,0,-3,-6,-10]", "m":"true", "sx":"1.5", "sy":"1.2", "o":"0"}},
					"slotzoom-bigrotatecol":{"title":"*rotate_left* Strong Center", "speed":"600", "f":"center", "d":"10", "p":"light", "in":{"col":"50", "e":"power2.inOut", "r":"10", "sx":"1.5", "sy":"1.5", "o":"0"}},
					"motioncolrotatesv":{"title":"*north* Motion Blur", "speed":"600", "f":"random", "d":"10", "in":{"mou":true, "mo":"45", "col":"20", "e":"power2.inOut", "r":"{-45,45}", "sx":"0.8", "sy":"0.8", "o":"0", "y":"(100%)"}},
					"motioncolrotatesh":{"title":"*west* Motion Blur", "speed":"600", "f":"slidebased", "d":"10", "in":{"mou":true, "mo":"45", "col":"20", "e":"power2.inOut", "r":"{-45,45}", "sx":"0.8", "sy":"0.8", "o":"0", "x":"(100%)"}},
					"motioncolrotatehe":{"title":"*shuffle* Double Motion", "speed":"1300", "f":"edges", "d":"15", "in":{"mou":true, "mo":"35", "col":"100", "e":"sine.inOut", "r":"180", "o":"0", "x":"{-20,20}","y":"{-20,20}"},"out":{"a":false}}
				},
				"effects":{
					"pullcols":{"title":"*bar_chart* Flow Vert.", "speed":"900", "f":"center", "d":"20",  "in":{"col":"400", "e":"power2.inOut", "sx":"4", "sy":"3", "o":"0","y":"(100%)","m":"true"}, "out":{"a":false, "col":"400","m":"true","y":"(-150%)","sx":"3", "sy":"3","e":"power2.inOut"}},
					"papercutv":{"title":"*content_cut* Cut Horiz.","o":"outin","speed":"1500","f":"nodelay","in":{"e":"power2.out","y":"(15%)", "x":"(-10%)","r":"20","sx":"0.7","sy":"0.7"},"out":{"a":false,"col":"2","e":"power2.inOut","x":"[-90%|170%]","y":"[(60%)|(130%)]","r":"[(-30)|(60)]","sx":"1.2","sy":"1.3"}},
					"switchcol": {"title":"*view_carousel* Switch Horiz.", "speed":"1000", "f":"center", "d":"80","filter":{"u":true, "b":"3", "e":"late2"}, "in":{"col":"3","e":"power2.inOut",  "x":"[-100%|0|100%]",  "sx":"[1|0|1]", "sy":"[1|0|1]", "o":"0"}},
					"slotslide-vvv-3d":{"title":"*view_in_ar* Vary Vert.","speed":"2000", "in":{"y":"[100%,-100%]","m":true,"col":8},"f":"edges","d":"35", "d3":{"f":"cube", "d":"horizontal", "z":"450", "t":"20", "c":"#ccc", "e":"power2.inOut","su":"true", "smi":"0", "sma":"0.5","sc":"#9e9e9e"}},
					"slotslide-vvv-3d2":{"title":"*view_in_ar* Vary Horiz.","speed":"2000", "in":{"x":"[100%,-100%]","m":true,"col":8},"f":"edges","d":"35", "d3":{"f":"cube", "d":"vertical", "z":"450", "t":"20", "c":"#ccc", "e":"power2.inOut","su":"true", "smi":"0", "sma":"0.5","sc":"#9e9e9e"}},
					"switchcol3d": {"title":"*send*  Switch Horiz.", "speed":"2000", "f":"center", "d":"80","filter":{"u":true, "b":"3", "e":"late2"}, "in":{"col":"3","e":"power2.inOut",  "x":"[-100%|0|100%]",  "sx":"[1|0|1]", "sy":"[1|0|1]", "o":"0"},"d3":{"f":"fly", "d":"horizontal", "z":"450", "t":"20", "c":"#ccc", "e":"power2.inOut","su":"true", "smi":"0", "sma":"0.5","sc":"#9e9e9e"}}

				}
			},

			"rows":{ "icon":"line_weight",
				"slide":{
					"slotslide-vertical":{"title":"*north* Uniform","in":{"y":"(100%)","m":true,"row":5},"f":"nodelay"},
					"slotslide-hvf":{"title":"*north* Flow","in":{"y":"(100%)","m":true,"row":5},"f":"slidebased"},
					"slotslide-hhf":{"title":"*west* Flow","in":{"x":"(100%)","m":true,"row":5},"f":"slidebased"},
					"slotslide-hhh":{"title":"*swap_horiz* Vary","in":{"x":"[100%,-100%]","m":true,"row":8},"f":"slidebased"}
				},
				"zoom":{
					"slotzoom-vertical":{"title":"*blur_on* Blur", "f":"nodelay", "filter":{"u":true, "b":"2", "e":"default"}, "in":{"row":"6", "e":"power2.inOut", "m":"true", "sx":"1.2", "sy":"1.5", "o":"0"}},
					"slotzoom-mixedv":{"title":"*blur_on* Blur & Slide", "f":"start", "d":"50", "filter":{"u":true, "b":"2", "e":"default"}, "in":{"row":"6", "e":"power2.inOut", "m":"true", "x":"(-20%)", "y":"(-20%)","sx":"1.5", "sy":"1.5", "o":"0"}},
					"3dcurtain-vertical":{"title":"*north* Mini PopUp", "speed":"500", "in":{"y":"(-50%)", "sx":"0.7","sy":"0.7","o":"0","m":true,"row":5,"e":"power4.inOut"},"out":{"a":false},"f":"slidebased","d":"10"}
				},
				"rotation":{
					"slotzoom-minrotaterow":{"title":"*rotate_left* Edge", "speed":"1500", "f":"center", "d":"100", "in":{"row":"7", "e":"power2.inOut", "r":"[10,6,3,0,-3,-6,-10]", "m":"true", "sx":"1.2", "sy":"1.5", "o":"0"}},
					"slotzoom-randomrow":	{"title":"*shuffle* Random", "speed":"800", "f":"random", "d":"10", "in":{"row":"7", "e":"power2.inOut", "r":"[-5,-3,-10,-5,-2,0,3,10,8,5]", "m":"true", "sx":"2", "sy":"2", "o":"0"}},
					"slotzoom-bigrotaterow":{"title":"*rotate_left* Strong Center", "speed":"600", "f":"center", "d":"10", "p":"dark", "in":{"row":"50", "e":"power2.inOut", "r":"10", "sx":"1.5", "sy":"1.5", "o":"0"}},
					"motionrowrotatesh":{"title":"*west* Motion Blur", "speed":"600", "f":"random", "d":"10", "in":{"mou":true, "mo":"45", "row":"20", "e":"power2.inOut", "r":"{-45,45}", "sx":"0.8", "sy":"0.8", "o":"0", "x":"(100%)"}},
					"motionrowrotatesv":{"title":"*north* Motion Blur", "speed":"600", "f":"slidebased", "d":"10", "in":{"mou":true, "mo":"45", "row":"20", "e":"power2.inOut", "r":"{-45,45}", "sx":"0.8", "sy":"0.8", "o":"0", "y":"(100%)"}},
					"vmotion":{"title":"*shuffle* V Motion", "speed":"1000", "f":"edges", "d":"10", "in":{"mou":true, "mo":"35", "row":"25", "e":"sine.in", "r":"{-40,40}", "sx":"2", "sy":"2", "o":"0", "y":"{-20,20}","x":"{-20,20}"},"out":{"a":false}}
				},
				"effects":{
					"pullrows":{"title":"*west* Flow Horiz.", "speed":"900", "f":"center", "d":"20",  "in":{"row":"400", "e":"power2.inOut", "sx":"3", "sy":"4", "o":"0","x":"(100%)","m":"true"}, "out":{"a":false, "row":"400","m":"true","x":"(-150%)","sx":"3", "sy":"3","e":"power2.inOut"}},
					"papercut":{"title":"*content_cut* Cut Vert.","o":"outin","speed":"1500","f":"nodelay","in":{"e":"power2.out","x":"(15%)", "y":"(-10%)","r":"20","sx":"0.7","sy":"0.7"},"out":{"a":false,"row":"2","e":"power2.inOut","x":"[(60%)|(130%)]","y":"[-90%|170%]","r":"[(-30)|(60)]","sx":"1.3","sy":"1.2"}},
					"switchrow": {"title":"*view_day* Switch Vert.", "speed":"1000", "f":"center", "d":"80","filter":{"u":true, "b":"3", "e":"late2"}, "in":{"row":"3","e":"power2.inOut",  "y":"[-100%|0|100%]",  "sx":"[1|0|1]", "sy":"[1|0|1]", "o":"0"}},
					"slotslide-hhh-3d":{"title":"*view_in_ar* Vary Horiz.","speed":"2000", "in":{"x":"[100%,-100%]","m":true,"row":8},"f":"edges","d":"35", "d3":{"f":"cube", "d":"horizontal", "z":"450", "t":"20", "c":"#ccc", "e":"power2.inOut","su":"true", "smi":"0", "sma":"0.5","sc":"#9e9e9e"}},
					"slotslide-hhh-3d2":{"title":"*view_in_ar* Vary Vert.","speed":"2000", "in":{"y":"[100%,-100%]","m":true,"row":8},"f":"edges","d":"35", "d3":{"f":"cube", "d":"vertical", "z":"450", "t":"20", "c":"#ccc", "e":"power2.inOut","su":"true", "smi":"0", "sma":"0.5","sc":"#9e9e9e"}},
					"switchrow-3d": {"title":"*3d_rotation* Switch Vert.", "speed":"2000", "f":"center", "d":"80","filter":{"u":true, "b":"3", "e":"late2"}, "in":{"row":"3","e":"power2.inOut",  "y":"[-100%|0|100%]",  "sx":"[1|0|1]", "sy":"[1|0|1]", "o":"0"},"d3":{"f":"incube", "d":"vertical", "z":"450", "t":"20", "c":"#ccc", "e":"power2.inOut","su":"true", "smi":"0", "sma":"0.5","sc":"#9e9e9e"}}
				}
			},

			"boxes":{ "icon":"apps",
				"fade":{
					"boxfadedir0":{"title":"*north_west*", "d":"10","in":{"o":0,"sx":1.1,"sy":1.1,"m":true,"row":6,"col":6},"out":{"a":false},"f":"oppslidebased"},
					"boxfadedir0d":{"title":"*north_west* Via Dark", "p":"dark", "d":"20","in":{"o":0,"sx":1.1,"sy":1.1,"m":true,"row":6,"col":6},"out":{"a":false},"f":"oppslidebased"},
					"boxfadedir1":{ "title":"*zoom_out_map* Center", "d":"15","in":{"o":0,"sx":"1.1","sy":"1.1","m":true,"row":30,"col":30},"out":{"a":false},"f":"center"},
					"boxfadedir1d":{"title":"*zoom_out_map* Center Via Dark", "d":"15","p":"dark","in":{"o":0,"sx":"1.1","sy":"1.1","m":true,"row":30,"col":30},"out":{"a":false},"f":"center"},
					"boxfadedir2":{ "title":"*crop_free* Edges", "d":"15","in":{"o":0,"sx":"1.1","sy":"1.1","m":true,"row":30,"col":30},"out":{"a":false},"f":"edges"},
					"boxfadedir2d":{"title":"*crop_free* Edges Via Dark", "d":"15","p":"dark","in":{"o":0,"sx":"1.1","sy":"1.1","m":true,"row":30,"col":30},"out":{"a":false},"f":"edges"}
				},
				"slide":{
					"boxslidehnm":{"title":"*west*","d":"20","f":"slidebased", "in":{"o":"-0.5", "x":"(15%)","sy":"0.8","sx":"0.8", "row":5,"col":5},"out":{"o":"0.5",  "x":"(-15%)","sy":"0.8","sx":"0.8", "row":5,"col":5}},
					"boxslidevnm":{"title":"*north*","d":"20","f":"slidebased", "in":{"o":"-0.5", "y":"(15%)", "sy":"0.8","sx":"0.8", "row":5,"col":5},"out":{"o":"0.5", "y":"(-15%)", "sy":"0.8","sx":"0.8", "row":5,"col":5}},
					"boxslidehnmd":{"title":"*west* Via Dark","d":"20","p":"dark", "f":"slidebased", "in":{"o":"0", "x":"(15%)","sy":"0.8","sx":"0.8", "row":5,"col":5, "e":"power2.out"},"out":{"a":false,"o":"0",  "x":"(-15%)","sy":"0.8","sx":"0.8", "row":5,"col":5,"e":"power2.in"}},
					"boxslidevnml":{"title":"*north* Via Light","d":"20","p":"light","f":"slidebased", "in":{"o":"0", "y":"(15%)", "sy":"0.8","sx":"0.8", "row":5,"col":5,"e":"power2.out"},"out":{"a":false,"o":"0", "y":"(-15%)", "sy":"0.8","sx":"0.8", "row":5,"col":5,"e":"power2.in"}},
					"boxslideh":{"title":"*west* Mask","d":"20", "in":{"o":0,"m":"true", "x":"(100%)","sy":"2","sx":"2", "row":5,"col":5},"f":"center"},
					"boxslidev":{"title":"*north* Mask","d":"20", "in":{"o":0,"m":"true", "y":"(100%)","sy":"2","sx":"2", "row":5,"col":5},"f":"center"},
					"boxslidec":{"title":"*north_west* Cross","d":"20","f":"slidebased", "in":{"o":"-0.5", "y":"(15%)", "x":"(15%)","sy":"0.8","sx":"0.8", "row":5,"col":5},"out":{"a":false,"o":"0.5", "y":"(-15%)", "x":"(-15%)","sy":"0.8","sx":"0.8", "row":5,"col":5}},
					"boxslidemask":{"title":"*north_west* Cross Mask","d":"20", "in":{"o":0,"m":"true", "y":"(50%)", "x":"(50%)","sy":"2","sx":"2", "row":5,"col":5},"f":"center"},
					"boxslidemotionh":{"title":"*west* Motion Blur","speed":"1000","in":{"o":"0","mou":true,"mo":"45","r":"{-100,100}","x":"(100%)","y":"{-100,100}","sx":"{0,2}","sy":"{0,2}","row":7,"col":7,"e":"power3.out"},"out":{"a":false},"f":"slidebased","d":"10"},
					"boxslidemotionv":{"title":"*north* Motion Blur","speed":"1000","in":{"o":"0","mou":true,"mo":"45","r":"{-100,100}","y":"(100%)","x":"{-100,100}","sx":"{0,2}","sy":"{0,2}","row":7,"col":7,"e":"power3.out"},"out":{"a":false},"f":"slidebased","d":"10"}
				},
				"zoom":{
					"boxslide":{"title":"*add* Simple", "in":{"o":0,"sx":0,"sy":0,"row":5,"col":5},"out":{"a":false},"f":"nodelay"},
					"boxfade":{"title":"*shuffle* Random", "in":{"o":0,"sx":1.1,"sy":1.1,"m":true,"row":5,"col":5},"out":{"a":false},"f":"random"},
					"boxzoomoutin":{"title":"*remove**add* Out In", "d":"30", "f":"center", "in":{"o":0,"sx":1.2,"sy":1.2,"row":5,"col":5},"out":{"a":false,"o":0,"sx":0.5,"sy":0.5,"m":true,"row":5,"col":5}},
					"boxzoominout":{"title":"*add**remove* In Out", "d":"30", "f":"center", "in":{"o":"-0.3","sx":0.5,"sy":0.5,"row":5,"col":5},"out":{"a":false,"o":0,"sx":1.3,"sy":1.3,"m":true,"row":5,"col":5}}

				},
				"rotation":{
					"boxrandomrotate":{"title":"*rotate_left* Scale & Fade","in":{"o":0,"r":"{-45,45}","sx":0,"sy":0,"row":5,"col":5},"out":{"a":false},"f":"random"},
					"spiralrotate":{"title":"*wifi_protected_setup* Spiral","speed":"1300", "in":{"o":0,"r":"120","x":"{-20,20}", "y":"{-20,20}","sx":10,"sy":10,"row":5,"col":5,"e":"expo.inOut"},"out":{"a":false},"f":"slidebased","d":"20"}
				},
				"circle":{
					"edgetocenterbox":{"title":"*crop_free* Edge Big","f":"edges","d":"15","speed":"1000","in":{"o":0,"r":"[-10|10]","sx":"0.1","sy":"0.1","row":8,"col":8,"x":"[-10|10]","y":"[-10|10]"}},
					"centertoedgebox":{"title":"*zoom_out_map* Center Big","f":"center","d":"15","speed":"1000","in":{"o":0,"r":"[-10|10]","sx":"0.1","sy":"0.1","row":8,"col":8,"x":"[-10|10]","y":"[-10|10]"}},
					"edgetocenterboxst":{"title":"*crop_free* Edge Small","f":"edges","d":"15","speed":"1000","in":{"o":0,"r":"[-10|10]","sx":"0.1","sy":"0.1","row":20,"col":20,"x":"[-10|10]","y":"[-10|10]"}},
					"centertoedgeboxst":{"title":"*zoom_out_map* Center Small","f":"center","d":"15","speed":"1000","in":{"o":0,"r":"[-10|10]","sx":"0.1","sy":"0.1","row":20,"col":20,"x":"[-10|10]","y":"[-10|10]"}}
				},
				"effects":{
					"rainv":{"title":"*east* Rain", "speed":"910", "f":"start", "d":"20",  "in":{"col":"100", "row":"10", "e":"power3.Out", "sx":"2", "sy":"2", "o":"0", "y":"{-200,200}"}},
					"push":{"title":"*south* Rain", "speed":"910", "f":"start", "d":"20",   "in":{"col":"10", "row":"100", "e":"power3.Out", "sx":"2", "sy":"2", "o":"0", "x":"{-200,200}"}},
					"crystal":{"title":"*widgets* Crystal","f":"random","d":"40","p":"light", "speed":"1000","in":{"o":0,"sx":"5","r":"[(180)|(-180)|(90)|(-90)|(270)|(-270)]","sy":"5","row":30,"col":30,"x":"{-10|100}","y":"{-50|50}","e":"power2.out"}, "out":{"a":false, "e":"power2.in", "o":0,"sx":"6","r":"[(-180)|(180)|(-90)|(90)|(-270)|(270)]","sy":"6","row":30,"col":30,"x":"{-50|50}","y":"{-50|50}"}},
					"dreamin":{"title":"*cloud_queue* Dream In","f":"edges","d":"10","speed":"910","in":{"o":0,"sx":"4","sy":"4","row":20,"col":20,"x":"[-10|10]","y":"[-10|10]"}},
					"dreamout":{"title":"*cloud_queue* Dream Out","f":"center","d":"10","speed":"910","in":{"o":0,"sx":"4","sy":"4","row":20,"col":20,"x":"[-10|10]","y":"[-10|10]"}},
					"bfrot":{"title":"*window* 4 Edge Cut","f":"start", "d":"40", "filter":{"u":true, "b":"3", "e":"default"}, "in":{"o":0,"e":"power2.inOut", "x":"[-100%|-100%|100%|100%]","y":"[-20%|20%|-20%|20%]", "r":"[-20|20|-20|20]","sx":0.5,"sy":0.5,"row":2,"col":2},"out":{"a":false,"e":"power2.inOut",  "o":0,"x":"[5%|5%|-5%|-5%]","y":"[4%|-4%|4%|-4%]","sx":0.8,"sy":0.8,"row":2,"col":2}},
					"mosaic": {"title":"*view_comfy* Mosaic", "speed":"1500", "f":"edges", "d":"20", "in":{"col":"17","row":"17", "e":"power2.inOut", "r":"[20,10,8,5,2,1,2,-1,-2,-5,-8,-10,-20]", "x":"[20,10,8,5,2,1,2,-1,-2,-5,-8,-10,-20]", "y":"[20,10,8,5,2,1,2,-1,-2,-5,-8,-10,-20]", "m":"true", "sx":"[8,7,6,4,3,2,1.3,2,3,4,6,7,8]", "sy":"[8,7,6,4,3,2,1.3,2,3,4,6,7,8]", "o":"0"},"out":{"a":false,"o":"0"}},
					"switch": {"title":"*repeat* Switch", "speed":"1000", "f":"center", "d":"80","filter":{"u":true, "b":"3", "e":"late2"}, "in":{"col":"3","row":"3", "e":"power2.inOut",  "x":"[-100%|0|100%]",  "sx":"[1|0|1]", "sy":"[1|0|1]", "o":"0"}},
					"switchrot": {"title":"*repeat* Switch & Rotate", "speed":"800", "f":"start", "d":"40", "in":{"col":"3","row":"3", "r":"[(-180)|0|(180)]","e":"back.out",  "x":"[-100%|0|100%]",  "sx":"[1|0|1]", "sy":"[1|0|1]", "o":"0"},"out":{"a":false, "col":"3","row":"3", "r":"[(-180)|0|(180)]","e":"power3.inOut",  "x":"[100%|0|-100%]",  "sx":"[1|0.5|1]", "sy":"[1|0.5|1]", "o":"1"}},
					"boxslidehnm3d":{"title":"*view_in_ar* Slide Horiz.","d":"50","f":"edges", "in":{"o":"-0.5", "x":"(15%)","sy":"0.8","sx":"0.8", "row":5,"col":5},"out":{"o":"0.5",  "x":"(-15%)","sy":"0.8","sx":"0.8", "row":5,"col":5},"d3":{"f":"cube", "d":"horizontal", "z":"450", "t":"20", "c":"#ccc", "e":"power2.inOut","su":"true", "smi":"0", "sma":"0.5","sc":"#9e9e9e"}},
					"rainv3d":{"title":"*view_in_ar* Rain Vert.", "speed":"1210", "f":"start", "d":"20",  "in":{"col":"100", "row":"10", "e":"power3.Out", "sx":"2", "sy":"2", "o":"0", "y":"{-200,200}"},"d3":{"f":"cube", "d":"vertical", "z":"450", "t":"20", "c":"#ccc", "e":"power2.inOut","su":"true", "smi":"0", "sma":"0.5","sc":"#9e9e9e"}},
					"push3d":{"title":"*view_in_ar* Rain Horiz.", "speed":"1210", "f":"start", "d":"20",   "in":{"col":"10", "row":"100", "e":"power3.Out", "sx":"2", "sy":"2", "o":"0", "x":"{-200,200}"},"d3":{"f":"cube", "d":"horizontal", "z":"450", "t":"20", "c":"#ccc", "e":"power2.inOut","su":"true", "smi":"0", "sma":"0.5","sc":"#9e9e9e"}},
					"crystal3d":{"title":"*view_in_ar* Crystal","f":"random","d":"40", "speed":"1200","in":{"o":0,"sx":"5","r":"[(180)|(-180)|(90)|(-90)|(270)|(-270)]","sy":"5","row":30,"col":30,"x":"{-10|100}","y":"{-50|50}","e":"power2.out"}, "out":{"a":false, "e":"power2.in", "o":0,"sx":"6","r":"[(-180)|(180)|(-90)|(90)|(-270)|(270)]","sy":"6","row":30,"col":30,"x":"{-50|50}","y":"{-50|50}"},"d3":{"f":"cube", "d":"vertical", "z":"450", "t":"-20", "c":"#ccc", "e":"back.out","su":"true", "smi":"0", "sma":"1"}},
					"dreamin3d":{"title":"*3d_rotation* Dream In","f":"edges","d":"30","speed":"1210","in":{"o":0,"sx":"4","sy":"4","row":20,"col":20,"x":"[-10|10]","y":"[-10|10]"},"d3":{"f":"incube", "d":"vertical", "z":"450", "t":"30", "c":"#ccc", "e":"power2.inOut"}},
					"bfrot3d":{"title":"*view_in_ar* 4 Edge Cut","f":"start", "d":"40", "speed":"1200", "filter":{"u":true, "b":"3", "e":"default"}, "in":{"o":0,"e":"power2.inOut", "x":"[-100%|-100%|100%|100%]","y":"[-20%|20%|-20%|20%]", "r":"[-20|20|-20|20]","sx":0.5,"sy":0.5,"row":2,"col":2},"out":{"a":false,"e":"power2.inOut",  "o":0,"x":"[5%|5%|-5%|-5%]","y":"[4%|-4%|4%|-4%]","sx":0.8,"sy":0.8,"row":2,"col":2},"d3":{"f":"cube", "d":"horizontal", "z":"450", "t":"20", "c":"#ccc", "e":"power2.inOut","su":"true", "smi":"0", "sma":"0.5","sc":"#9e9e9e"}},
					"mosaic3d": {"title":"*view_in_ar* Mosaic", "speed":"1200", "f":"edges", "d":"20", "in":{"col":"17","row":"17", "e":"power2.inOut", "r":"[20,10,8,5,2,1,2,-1,-2,-5,-8,-10,-20]", "x":"[20,10,8,5,2,1,2,-1,-2,-5,-8,-10,-20]", "y":"[20,10,8,5,2,1,2,-1,-2,-5,-8,-10,-20]", "m":"true", "sx":"[8,7,6,4,3,2,1.3,2,3,4,6,7,8]", "sy":"[8,7,6,4,3,2,1.3,2,3,4,6,7,8]", "o":"0"},"out":{"a":false,"o":"0"},"d3":{"f":"cube", "d":"horizontal", "z":"450", "t":"20", "c":"#ccc", "e":"power2.inOut","su":"true", "smi":"0", "sma":"0.5","sc":"#9e9e9e"}},
					"switch3d": {"title":"*view_in_ar* Switch", "speed":"1200", "f":"center", "d":"80","in":{"col":"3","row":"3", "e":"power2.inOut",  "x":"[-100%|0|100%]",  "sx":"[1|0|1]", "sy":"[1|0|1]", "o":"0"},"d3":{"f":"cube", "d":"horizontal", "z":"450", "t":"20", "c":"#ccc", "e":"power2.inOut","su":"true", "smi":"0", "sma":"0.5","sc":"#9e9e9e"}},
					"switchrot3d": {"title":"*view_in_ar* Switch & Rotate", "speed":"1200", "f":"start", "d":"40",  "in":{"col":"3","row":"3", "r":"[(-180)|0|(180)]","e":"back.out",  "x":"[-100%|0|100%]",  "sx":"[1|0|1]", "sy":"[1|0|1]", "o":"0"},"out":{"a":false, "col":"3","row":"3", "r":"[(-180)|0|(180)]","e":"power3.inOut",  "x":"[100%|0|-100%]",  "sx":"[1|0.5|1]", "sy":"[1|0.5|1]", "o":"1"},"d3":{"f":"cube", "d":"horizontal", "z":"450", "t":"20", "c":"#ccc", "e":"power2.inOut","su":"true", "smi":"0", "sma":"0.5","sc":"#9e9e9e"}},
					"puzzle":{"title":"*extension* Puzzle","speed":"1000","in":{"o":"0","mou":true,"mo":"35","r":"{-100,100}","x":"{-100,100}","y":"{-100,100}","sx":"{0,2}","sy":"{0,2}","row":7,"col":7,"e":"power3.out"},"out":{"a":false},"f":"random","d":"10"},
					"cometogether":{"title":"*rotate_left* Come Together","speed":"800","in":{"o":"0","mou":true,"mo":"60","r":"{-60,60}","sx":"4","sy":"0","row":2,"col":12,"e":"back.out"},"out":{"a":false},"f":"edges","d":"12"},
					"getfocus":{"title":"*center_focus_strong* Get Focus","speed":"1000","in":{"o":"0","mou":true,"mo":"70","r":"{-40,40}","sx":"2","sy":"2","x":"{-20,20}","y":"{-20,20}","row":10,"col":10,"e":"circ.in"},"out":{"a":false},"f":"edges","d":"15"},
					"waves":{"title":"*waves* Ripples","speed":"1000","in":{"o":"0","mou":true,"mo":"70","r":"{-40,40}","sx":"2","sy":"2","x":"{-20,20}","y":"{-20,20}","row":20,"col":20,"e":"elastic.out"},"out":{"a":false},"f":"center","d":"15"},
					"wavesbig":{"title":"*waves* Double Ripples","speed":"1000","in":{"o":"0","r":"{-40,40}","sx":"2","sy":"2","x":"{-20,20}","y":"{-20,20}","row":20,"col":20,"e":"bounce.in"},"out":{"a":false},"f":"center","d":"15"},
					"wavesmiddle":{"title":"*waves* Bounced Ripples","speed":"1000","mou":true,"mo":"40","in":{"o":"0","r":"[-10|10|-20|20|-30|30]","sx":"[2|4]","sy":"[2|4]","x":"[-10|10|-20|20|-30|30]","y":"[-10|10|-20|20|-30|30]","row":20,"col":20,"e":"BounceExtrem"},"out":{"a":false},"f":"center","d":"15"}
				}
			},
			"random":{ "icon":"shuffle","noSubLevel":"true",
				"rndany":	{"title":"*done_all* Random All","random":"true","rndmain":"all"},
				"rndbasic":	{"title":"*aspect_ratio* Random Base","random":"true","rndmain":"basic"},
				"rndrow":	{"title":"*line_weight* Random Row","random":"true","rndmain":"rows"},
				"rndcolumns":	{"title":"*view_week* Random Column","random":"true","rndmain":"columns"},
				"rndboxes":	{"title":"*apps* Random Box","random":"true","rndmain":"boxes"},
				"rndfade":	{"title":"*opacity* Random Fade","random":"true","rndmain":"all","rndgrp":"fade"},
				"rndslide":	{"title":"*open_with* Random Slide","random":"true","rndmain":"all","rndgrp":"slide,curtain,slideover,remove,slideinout,slideinoutfadein,slideinoutfadeinout,parallax,double"},
				"rndzoom":	{"title":"*add* Random Zoom","random":"true","rndmain":"all","rndgrp":"zoom,zoomslidein,zoomslideout"},
				"rndrotation":	{"title":"*rotate_left* Random Rotation","random":"true","rndmain":"all","rndgrp":"rotation"},
				"rndeffects":	{"title":"*3d_rotation* Random Effects","random":"true","rndmain":"all","rndgrp":"effects,circle,filter"}
			}

		}';

		$transitions = apply_filters('revslider_data_get_base_transitions', $transitions);

		return ($raw) ? $transitions : json_decode($transitions, true);
	}
}
