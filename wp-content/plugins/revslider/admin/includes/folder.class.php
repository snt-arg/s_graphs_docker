<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 * @since	  6.0
 */

if(!defined('ABSPATH')) exit();

class RevSliderFolder extends RevSliderSlider {
	
	public $folder = false;
	
	/**
	 * Initialize A slider as a Folder
	 **/
	public function init_folder_by_id($id){
		global $wpdb;
		
		$folder = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." WHERE `id` = %s AND `type` = 'folder'", $id), ARRAY_A);
		
		if(!empty($folder)){
			$this->id		= $this->get_val($folder, 'id');
			$this->title	= $this->get_val($folder, 'title');
			$this->alias	= $this->get_val($folder, 'alias');
			$this->settings = (array)json_decode($this->get_val($folder, 'settings', ''));
			$this->params	= (array)json_decode($this->get_val($folder, 'params', ''));
			$this->folder	= true;
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 * Get all Folders from the Slider Table
	 **/
	public function get_folders(){
		global $wpdb;
		
		$folders = array();
		$entries = $wpdb->get_results("SELECT `id` FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." WHERE `type` = 'folder'", ARRAY_A);
		
		if(!empty($entries)){
			foreach($entries as $folder){
				$slider		= new RevSliderFolder();
				$folder_id	= $this->get_val($folder, 'id');
				$slider->init_folder_by_id($folder_id);
				
				$folders[] = $slider;
			}
		}
		
		return $folders;
	}
	
	
	/**
	 * Get all Folders from the Slider Table
	 **/
	public function get_folder_by_id($id){
		global $wpdb;
		
		$folder = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." WHERE `type` = 'folder' AND `id` = %s", $id), ARRAY_A);
		
		return $folder;
	}
	
	
	/**
	 * Create a new Slider as a Folder
	 **/
	public function create_folder($alias = 'New Folder', $parent = 0){
		global $wpdb;
		
		$title  = esc_html($alias);
		$alias  = sanitize_title($title);
		$temp	= $title;
		$folder = false;
		$ti		= 1;
		while($this->alias_exists($alias)){ //set a new alias and title if its existing in database
			$title = $temp . ' ' . $ti;
			$alias = sanitize_title($title);
			$ti++;
		}
		
		//check if Slider with title and/or alias exists, if yes change both to stay unique
		$done = $wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_SLIDER, array('title' => $title, 'alias' => $alias, 'type' => 'folder'));
		if($done !== false){
			$this->init_folder_by_id($wpdb->insert_id);
			$folder = $this;
			if(intval($parent) > 0){
				$slider		= new RevSliderFolder();
				$slider->init_folder_by_id($parent);
				$children	= $slider->get_children();
				$children	= (!is_array($children)) ? array() : $children;
				$children[] = $this->get_id();
				$slider->add_slider_to_folder($children, $parent);
			}
		}
		
		return $folder;
	}
	
	
	/**
	 * Add a Slider ID to a Folder
	 **/
	public function add_slider_to_folder($children, $folder_id, $replace_all = true){
		global $wpdb;
		$response	= false;
		$folder		= $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER ." WHERE `id` = %s AND `type` = 'folder'", $folder_id), ARRAY_A);
		
		if(!empty($folder)){
			$settings = json_decode($this->get_val($folder, 'settings'), true);
			if(!isset($settings['children'])){
				$settings['children'] = array();
			}
			
			if($replace_all){
				$settings['children'] = $children;
			}else{
				$children = (array)$children;
				if(!empty($children)){
					foreach($children as $child){
						if(!in_array($child, $settings['children'])){
							$settings['children'][] = $child;
						}
					}
				}
			}
			$response = $wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDER, array('settings' => json_encode($settings)), array('id' => $folder_id));
			$response = ($response == false && empty($wpdb->last_error)) ? true : $response;
		}
		
		return $response;
	}
	
	
	/**
	 * Get the Children of the folder (if any exist)
	 **/
	public function get_children(){
		return $this->get_val($this->settings, 'children', array());
	}
	
	/**
	 * Get the Children of the folder (if any exist)
	 * @since: 6.1.4
	 **/
	public function set_children($children){
		return $this->set_val($this->settings, 'children', $children);
	}
}