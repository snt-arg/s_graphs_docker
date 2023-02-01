<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2021 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderCache extends RevSliderFunctions {
	
	public $cache_enabled = false;
	
	/**
	 * holds transient additions that the slider is using
	 **/
	private $cache_additions = array('action' => array(), 'filter' => array(), 'html' => array(), 'special' => array());
	private $output_html = array();
	
	public function __construct(){
		$globals = $this->get_global_settings();
		$this->cache_enabled = ($this->_truefalse($this->get_val($globals, 'internalcaching')) === true) ? true : false;
	}
	
	
	public function is_enabled(){
		return $this->cache_enabled;
	}
	
	
	/**
	 * define which slider types are supported
	 * no social streams are supported
	 **/
	public function is_supported_type($type){
		return (in_array($type, array('post', 'posts', 'specific_posts', 'specific_post', 'current_post', 'woocommerce', 'woo', 'gallery'), true)) ? true : false;
	}
	
	public function clear_all_transients(){
		global $wpdb;
		
		$return = $wpdb->query("DELETE FROM ". $wpdb->prefix . 'options' ." WHERE `option_name` LIKE '_transient_revslider_slider_%'");
		$wpdb->query("DELETE FROM ". $wpdb->prefix . 'options' ." WHERE `option_name` LIKE '_transient_timeout_revslider_slider_%'");
		return $return;
	}
	
	
	/**
	 * clears all transients that are from a certain slider
	 * @since: 6.4.7
	 **/
	public function clear_transients_by_slider($sid){
		global $wpdb;
		
		$return = false;
		
		$sid = intval($sid);
		if($sid > 0){
			$return = $wpdb->query($wpdb->prepare("DELETE FROM ". $wpdb->prefix . 'options' ." WHERE `option_name` LIKE '_transient_revslider_slider_%d%%'", $sid));
			$wpdb->query($wpdb->prepare("DELETE FROM ". $wpdb->prefix . 'options' ." WHERE `option_name` LIKE '_transient_timeout_revslider_slider_%d%%'", $sid));
		}
		
		return $return;
	}
	
	
	public function get_additions(){
		return $this->cache_additions;
	}
	
	
	public function add_addition($type, $name = false, $output = '', $priority = 10){
		if($output === '') return;
		
		if(!isset($this->cache_additions[$type])) $this->cache_additions[$type] = array();
		
		if($name === false){
			$this->cache_additions[$type][] = $output;
		}else{
			if(!isset($this->cache_additions[$type][$name])) $this->cache_additions[$type][$name] = array();
			
			if($type === 'special'){
				$this->cache_additions[$type][$name][] = $output;
			}else{
				$this->cache_additions[$type][$name][] = array(
					'html' => $output,
					'priority' => $priority
				);
			}
		}
	}
	
	/**
	 * replace HTML placeholders with their corresponding value
	 **/
	public function do_html_changes($html){
		//$html = str_replace('##NONCE##', wp_create_nonce('RevSlider_Front'), $html);
		
		return $html;
	}
	
	/**
	 * this will push all the additions to the output that can not be cached
	 * @since: 6.4.7
	 **/
	public function do_additions($additions, $output){
		$t_actions = $this->get_val($additions, 'action', array());
		if(!empty($t_actions)){
			foreach($t_actions as $_action => $t_a){
				if(!empty($t_a)){
					
					foreach($t_a as $t_sa){
						if(!isset($this->output_html[$_action])) $this->output_html[$_action] = array();
						$this->output_html[$_action][] = $t_sa;
						add_action($_action, array($this, 'print_addition'));
					}
				}
			}
		}
		
		$t_filters = $this->get_val($additions, 'filter', array());
		if(!empty($t_filters)){
			foreach($t_filters as $_filter => $t_a){
				if(!empty($t_a)){
					foreach($t_a as $t_sa){
						if(!isset($this->output_html[$_filter])) $this->output_html[$_filter] = array();
						$this->output_html[$_filter][] = $t_sa;
						add_filter($_filter, array($this, 'print_addition'));
					}
				}
			}
		}
		
		$t_special = $this->get_val($additions, 'special', array());
		if(!empty($t_special)){
			$_rs_css_collection = $this->get_val($t_special, 'rs_css_collection', array());
			if(!empty($_rs_css_collection)){
				global $rs_css_collection;
				$rs_css_collection = $_rs_css_collection;
			}
			$_font_var = $this->get_val($t_special, 'font_var', array());
			if(!empty($_font_var)){
				foreach($_font_var as $fw){
					global $$fw;
					$$fw = true;
				}
			}
		}
		
		do_action('revslider_do_cache_additions', $additions, $output);
	}
	
	
	public function set_full_transient($transient, $sid, $content){
		$add = array(
			'html' => $content,
			'addition' => $this->get_additions()
		);
		
		$add = json_encode($add);
		set_transient($transient, $add, 60*60*24*7);
		
		$this->cache_additions = array();
	}
	
	/**
	 * prints the additions html when the filter/action is called
	 * @since: 6.4.7
	 **/
	public function print_addition(){
		$html = $this->get_val($this->output_html, current_filter());
		if(is_array($html)){
			if(!empty($html)){
				usort($html, array($this, 'sort_by_priority'));
				echo (current_filter() === 'wp_print_footer_scripts') ? '<script>'."\n" : '';
				foreach($html as $echo){
					echo $this->get_val($echo, 'html');
				}
				echo (current_filter() === 'wp_print_footer_scripts') ? RS_T.'</script>'."\n" : '';
			}
		}else{
			echo $html;
		}
	}
	
	/**
	 * check delete post based caches only!
	 **/
	public function check_for_post_transient_deletion(){
		$post_types = array('post', 'posts', 'specific_posts', 'specific_post', 'current_post', 'woocommerce', 'woo');
		foreach($post_types as $k => $pt){
			$post_types[$k] = '"sourcetype":"'.$pt.'"';
		}
		$_slider = RevSliderGlobals::instance()->get('RevSliderSlider');
		
		$slider = $_slider->get_slider_by_param_string($post_types, true);
		
		//clear cache for all of these sliders
		if(!empty($slider) && is_array($slider)){
			foreach($slider as $s){
				$this->clear_transients_by_slider($this->get_val($s, 'id'));
			}
		}
	}
	
	
	public function sort_by_priority($a, $b) {
		return $a['priority'] - $b['priority'];
	}
}