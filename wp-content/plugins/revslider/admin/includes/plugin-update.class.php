<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderPluginUpdate extends RevSliderFunctions {

	public $revision;
	public $upgrade_layer_type = false; //holds the type of the layer, for the _compare function to
	public $add_to_transition_speed = array('slotslide-horizontal' => 200, 'slotslide-vertical' => 200, 'slotzoom-horizontal' => 400, 'slotfade-horizontal' => 1000, 'slotfade-vertical' => 1000, 'fade' => 300, 'crossfade' => 300, 'fadethroughdark' => 300, 'fadethroughlight' => 300, 'fadethroughtransparent' => 300, 'papercut' => 600, '3dcurtain-horizontal' => 100, '3dcurtain-vertical' => 100, 'cubic' => 600, 'cube' => 600, 'flyin' => 600, 'turnoff' => 500, 'incube' => 200, 'cubic-horizontal' => 500, 'cube-horizontal' => 500, 'incube-horizontal' => 500, 'turnoff-vertical' => 200, 'grayscale' => 300, 'grayscalecross' => 300, 'brightness' => 300, 'brightnesscross' => 300, 'blurlight' => 300, 'blurlightcross' => 300, 'blurstrong' => 300, 'blurstrongcross' => 300);
	public $_respsizesold	= array('desktop', 'notebook', 'tablet', 'mobile');
	public $_respsizes		= array('d', 'n', 't', 'm');
	public $_corners		= array('cornerLeft' => array('nothing' => 'none', 'curved' => 'rs-fcr', 'reverced' => 'rs-fcrt'), 'cornerRight' => array('nothing' => 'none', 'curved' => 'rs-bcr', 'reverced' => 'rs-bcrt'));
	public $_metas			= array('home_url', 'current_page_link', 'link', 'title', 'excerpt', 'alias', 'content', 'link', 'date', 'date_modified', 'author_name', 'author_posts', 'author_website', 'num_comments', 'catlist', 'catlist_raw', 'taglist', 'id', 'wc_full_price', 'wc_price', 'wc_price_no_cur', 'wc_stock', 'wc_rating', 'wc_star_rating', 'wc_categories', 'wc_add_to_cart', 'wc_add_to_cart_button', 'wc_sku', 'wc_stock_quantity', 'wc_rating_count', 'wc_review_count', 'wc_tags', 'link', 'title', 'excerpt', 'description', 'alias', 'content', 'link', 'date_published', 'date_modified', 'author_name', 'num_comments', 'catlist', 'catlist_raw', 'taglist', 'likes', 'retweet_count', 'favorite_count', 'views', 't_days', 't_hours', 't_minutes', 't_seconds', 'event_start_date', 'event_end_date', 'event_start_tim', 'event_end_time', 'event_event_id', 'event_location_name', 'event_location_slug', 'event_location_address', 'event_location_town', 'event_location_state', 'event_location_postcode', 'event_location_region', 'event_location_country', 'param1', 'param2', 'param3', 'param4', 'param5', 'param6', 'param7', 'param8', 'param9', 'param10', '/%meta:\w+%/', '/%content:\w+[\:]\w+%/', '/%author_avatar:\w+%/', '/%image_url_\w+%/', '/%image_\w+%/', '/%featured_image_url_\w+%/', '/%featured_image_\w+%/');
	public $z_index			= 5;
	public $navtypes		= array('arrows', 'thumbs', 'bullets', 'tabs');
	public $blank_slide		= false; //holds a blank slide to remove unneeded values in slides as a compare
	public $blank_layer		= array(); //holds a blank layer to remove unneeded values in layers as a compare, as more than one type of layer exists, it fills with keys as the type
	public $current_parent	= false; //holds the parent key for the compare function, which allows for deeper checks to remove/not remove keys depending on where in the tree we are
	public $css_navigations	= array(); //holds css navigations
	public $googlefonts		= array(); //holds googlefonts
	public $upd_animations	= array(); //holds animations
	
	/**
	 * for update to 6.0 added.
	 * These 4 are set by each Slider and depending on their setting.
	 * the layer effects are set to true/false
	 **/
	public $on_layers			= false;
	public $on_static_layers	= false;
	public $on_parallax_layers	= false;
	public $on_parallax_static_layers = false;
	public $on_counter			= 0;
	public $static_slide		= false;
	public $parallax_slider		= false;
	
	/**
	 * for update to 6.0
	 * it holds all layers that are triggered in an action
	 **/
	public $slide_action_map = array();
	
	/**
	 * holds variables needed for certain updates
	 * @since: 6.2.0
	 **/
	public $update = array(
		/**
		 * for update to 6.2.0
		 * it holds all easing names that need to be replaced whereever easings are used
		 **/
		'620' => array(
			'ease_replace_adv'	=> array('Power0' => 'power0', 'Power1' => 'power1', 'Power2' => 'power2', 'Power3' => 'power3', 'Power4' => 'power4', 'Back' => 'back', 'Bounce' => 'bounce', 'Circ' => 'circ', 'Elastic' => 'elastic', 'Expo' => 'expo', 'Sine' => 'sine'),
			'ease_adv_modifier' => array('easeIn' => 'in', 'easeOut' => 'out', 'easeInOut' => 'inOut'),
			'ease_adv_from' => array('Linear.easeNone', 'SlowMo.ease'),
			'ease_adv_to' => array('none', 'slow')
		)
	);
	
	/**
	 * @since 5.0
	 */
	public function __construct(){
		$this->revision = get_option('revslider_update_version', '6.0.0');
		
		foreach($this->update['620']['ease_replace_adv'] as $a_f => $a_t){
			foreach($this->update['620']['ease_adv_modifier'] as $a_m_f => $a_m_t){
				$this->update['620']['ease_adv_from'][] = $a_f.'.'.$a_m_f;
				$this->update['620']['ease_adv_to'][]	= $a_t.'.'.$a_m_t;
			}
		}
	}

	public function init_animations(){
		if(empty($this->upd_animations)){
			$this->upd_animations = $this->get_layer_animations();
		}
	}

	public function init_googlefonts(){
		if(empty($this->googlefonts)){
			//direct inclusion for direct searching of google font
			include(RS_PLUGIN_PATH.'includes/googlefonts.php');
			$this->googlefonts = $googlefonts;
		}
	}

	/**
	 * return version of installation
	 * @since 5.0
	 */
	public function get_version(){
		$real_version = get_option('revslider_update_version', 1.0);

		return $real_version;
	}

	/**
	 * set version of installation
	 * @since 5.0
	 */
	public function set_version($set_to){

		update_option('revslider_update_version', $set_to);

	}

	/**
	 * check for updates and proceed if needed
	 * @since 5.0
	 */
	public static function do_update_checks(){
		$upd = new RevSliderPluginUpdate();
		$version = $upd->get_version();

		if(version_compare($version, 5.0, '<')){
			$upd->update_css_styles(); //update styles to the new 5.0 way
			$upd->add_v5_styles(); //add the version 5 styles that are new!
			$upd->check_settings_table(); //remove the usage of the settings table
			$upd->move_template_slider(); //move template sliders slides to the post based sliders and delete them/move them if not used
			$upd->add_animation_settings_to_layer(); //set missing animation fields to the slides layers
			$upd->add_style_settings_to_layer(); //set missing styling fields to the slides layers
			$upd->change_settings_on_layers(); //change settings on layers, for example, add the new structure of actions
			$upd->add_general_settings(); //set general settings
			$upd->translate_navigation_to_v5(); //set the navigation from v4.** to v5

			$upd->remove_static_slides(); //remove static slides if the slider was v4 and had static slides which were not enabled

			$version = 5.0;
			$upd->set_version($version);
		}

		if(version_compare($version, '5.0.7', '<')){
			$version = '5.0.7';

			$upd->change_general_settings_5_0_7();
			$upd->set_version($version);
		}

		if(version_compare($version, '5.1.1', '<')){
			$version = '5.1.1';

			$upd->change_slide_settings_5_1_1();
			$upd->set_version($version);
		}

		if(version_compare($version, '5.2.5.5', '<')){
			$version = '5.2.5.5';
			$upd->change_layers_svg_5_2_5_5();
			$upd->set_version($version);
		}

		//with 6.0, the slider, slide, layer changes are done at a background process if possible, not automatically
		//only push global changes in here outside of slider, slides and layers
		if(version_compare($version, '6.0', '<')){
			$version = '6.0';
			$upd->change_global_settings_to_6_0();
			$upd->change_navigation_settings_to_6_0();
			$upd->change_animations_settings_to_6_0();
			
			// new addition for global addons
			$upd->change_global_addon_settings_to_6_0();
			$upd->set_version($version);
		}
		
		//with 6.1.4, we check the animations again for custom animations
		if(version_compare($version, '6.1.4', '<')){
			$version = '6.1.4';
			
			$upd->change_animations_settings_to_6_0();
			$upd->set_version($version);
		}
		
		//with 6.1.6, we only set the version and upgrade_slider_to_latest() will do the rest
		if(version_compare($version, '6.1.6', '<')){
			$version = '6.1.6';
			$upd->set_version($version);
		}
		
		//with 6.2.0, we check the animations handles again and change them to a new format
		if(version_compare($version, '6.2.0', '<')){
			$version = '6.2.0';
			
			$upd->change_animations_settings_to_6_2_0();
			$upd->change_global_settings_to_6_2_0();
			$upd->set_version($version);
		}
		
		//add this so that sliders will be updated if under 6.4.0
		if(version_compare($version, '6.4.0', '<')){
			$upd->set_version('6.4.0');
		}

		//add this so that sliders will be updated if under 6.4.10
		if(version_compare($version, '6.4.10', '<')){
			$upd->change_navigation_settings_to_6_4_10();
			$upd->set_version('6.4.10');
		}
	}
	
	/**
	 * check to convert the given Slider to latest versions
	 * @since: 6.0
	 **/
	public static function upgrade_slider_to_latest($slider){
		$upd = new RevSliderPluginUpdate();
		$version = $slider->get_setting('version', '1.0.0');
		if(version_compare($version, '6.0.0', '<')){
			//$upd->update_css_styles(); //set to version 5
			$upd->add_animation_settings_to_layer($slider); //set to version 5
			$upd->add_style_settings_to_layer($slider); //set to version 5
			$upd->change_settings_on_layers($slider); //set to version 5
			$upd->add_general_settings($slider); //set to version 5
			$upd->change_general_settings_5_0_7($slider); //set to version 5.0.7
			$upd->change_layers_svg_5_2_5_5($slider); //set to version 5.2.5.5
			$upd->change_animations_settings_to_6_0(); //check if new navigations are added through import
			$upd->upgrade_slider_to_6_0($slider);
		}
		
		if(version_compare($version, '6.1.4', '<')){
			$upd->upgrade_slider_to_6_1_4($slider);
		}
		
		if(version_compare($version, '6.1.6', '<')){
			$upd->upgrade_slider_to_6_1_6($slider);
		}
		
		if(version_compare($version, '6.2.0', '<')){
			$upd->change_animations_settings_to_6_2_0(); //check if new navigations are added through import
			$upd->upgrade_slider_to_6_2_0($slider);
		}
		
		if(version_compare($version, '6.4.0', '<')){
			$upd->upgrade_slider_to_6_4_0($slider);
		}
		
		if(version_compare($version, '6.4.10', '<')){
			$upd->change_navigation_settings_to_6_4_10();
			$upd->upgrade_slider_to_6_4_10($slider);
		}
	}
	
	/**
	 * get the CSS Navigation advanced styles, needed for 6.0
	 * @since: 6.0
	 **/
	public function get_css_navigations(){
		if(empty($this->css_navigations)){
			$css_parser = RevSliderGlobals::instance()->get('RevSliderCssParser');
			$this->css_navigations = $css_parser->get_database_classes(true);
		}
		return $this->css_navigations;
	}

	/**
	 * check if there are still Slider below latest version, if yes then add JavaScript to the header
	 * @since: 6.0.0
	 **/
	public function slider_need_update_checks(){
		$finished = get_option('revslider_update_revision_current', '1.0.0');
		
		return (version_compare($finished, $this->revision, '<')) ? true : false;
	}

	/**
	 * get the next slider that is not on the latest version and update it to the latest
	 * @since: 6.0.0
	 * @since: 6.2.0: added template sliders to the update routine
	 **/
	public function upgrade_next_slider(){
		$slr = new RevSliderSlider();

		$sliders = $slr->get_sliders();
		if(!empty($sliders)){
			foreach($sliders as $slider){
				if(version_compare($this->get_val($slider, array('settings', 'version')), $this->revision, '<')){
					$this->upgrade_slider_to_latest($slider);
					return array('status' => 'next');
				}
			}
		}
		
		//template sliders
		$sliders = $slr->get_sliders(true);
		if(!empty($sliders)){
			foreach($sliders as $slider){
				if(version_compare($this->get_val($slider, array('settings', 'version')), $this->revision, '<')){
					$this->upgrade_slider_to_latest($slider);
					return array('status' => 'next');
				}
			}
		}

		//we can only get to this point, after all Sliders have been updated to the latest revision
		update_option('revslider_update_revision_current', $this->revision);

		return array('status' => 'finished');
	}

	/**
	 * check to convert the given Slider to latest versions
	 * @since: 6.0
	 **/
	public function upgrade_slider_to_6_0($slider){
		ini_set('max_execution_time', 300);
		
		$upd = new RevSliderPluginUpdate();
		$upd->change_navigation_slider_to_6_0($slider);
		$upd->change_slider_settings_to_6_0($slider); //set to version 6.0
		$upd->change_slide_settings_to_6_0($slider); //set to version 6.0
		$upd->change_layer_settings_to_6_0($slider); //set to version 6.0
		
		$upd->remove_unneeded_slider_settings($slider);
	}
	
	/**
	 * check to convert the given Slider to latest versions
	 * @since: 6.1.4
	 * reverse the carousel.scaleDown value. If it was 85, change it to 15 and vice versa
	 **/
	public function upgrade_slider_to_6_1_4($sliders = false){
		$sr = new RevSliderSlider();
		
		$sliders = ($sliders === false) ? $sr->get_sliders() : array($sliders); //do it on all Sliders if false

		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$carousel = $slider->get_param('carousel', array());
				$scale_down = $this->get_val($carousel, 'scaleDown');
				
				if($scale_down !== false){
					$carousel['scaleDown'] = 100 - intval($scale_down);
					$slider->update_params(array('carousel' => $carousel));
				}
				
				$slider->update_settings(array('version' => '6.1.4'));
			}
		}
	}
	
	/**
	 * check to convert the given Slider to latest versions
	 * @since: 6.1.6
	 * check in the slide transitions, if we have a transition with a ","
	 * if this is the case, split it up
	 **/
	public function upgrade_slider_to_6_1_6($sliders = false){
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();
		
		$sliders = ($sliders === false) ? $sr->get_sliders() : array($sliders); //do it on all Sliders if false
		
		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$slides = $slider->get_slides(false, true);
				$static_id = $sl->get_static_slide_id($slider->get_id());
				if($static_id !== false){
					$msl = new RevSliderSlide();
					if(strpos($static_id, 'static_') === false){
						$static_id = 'static_'. $static_id; //$slider->get_id();
					}
					$msl->init_by_id($static_id);
					if($msl->get_id() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}
				
				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						$settings = $slide->get_settings();
						if(version_compare($this->get_val($settings, 'version', '1.0.0'), '6.1.6', '<')){
							$params = $slide->get_params();
							$transitions = $this->get_val($params, array('timeline', 'transition'), array());
							$new_transitions = array();
							$save = false;
							if(!empty($transitions) && is_array($transitions)){
								foreach($transitions as $t => $v){
									if(strpos($v, ',') !== false){
										$save = true;
										$_v = explode(',', $v);
										if(!empty($_v)){
											foreach($_v as $k => $__v){
												$new_transitions[] = $__v;
											}
										}
									}else{
										$new_transitions[] = $v;
									}
								}
								if($save){
									$this->set_val($params, array('timeline', 'transition'), $new_transitions);
									$slide->set_params($params);
									$slide->save_params();
								}
							}
							
							$slide->settings['version'] = '6.1.6';
							$slide->save_settings();
						}
					}
				}
				
				$slider->update_settings(array('version' => '6.1.6'));
			}
		}
	}
	
	
	/** check to convert the given Slider to latest versions
	 * @since: 6.2.0
	 * check in all layers, if we have a ease in it and convert it
	 **/
	public function upgrade_slider_to_6_2_0($sliders = false){
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();
		
		$sliders = ($sliders === false) ? $sr->get_sliders() : array($sliders); //do it on all Sliders if false
		
		if(!empty($sliders) && is_array($sliders)){
			
			foreach($sliders as $slider){
				//on slider params
				if(version_compare($slider->get_setting('version', '1.0.0'), '6.2.0', '<')){
					$params = $slider->get_params();
					$json_params	= $_json_params = json_encode($params);
					$_json_params	= str_replace($this->update['620']['ease_adv_from'], $this->update['620']['ease_adv_to'], $_json_params);
					
					if($_json_params !== $json_params){
						$params = (array)json_decode($_json_params, true);
						$params['version'] = '6.2.0';
						$slider->update_params($params, true);
					}
				}
				
				$slides = $slider->get_slides(false, true);
				$static_id = $sl->get_static_slide_id($slider->get_id());
				if($static_id !== false){
					$msl = new RevSliderSlide();
					if(strpos($static_id, 'static_') === false){
						$static_id = 'static_'. $static_id;
					}
					$msl->init_by_id($static_id);
					if($msl->get_id() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}
				
				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						$settings = $slide->get_settings();
						//on slides
						if(version_compare($this->get_val($settings, 'version', '1.0.0'), '6.2.0', '<')){
							$params			= $slide->get_params();
							$json_params	= $_json_params = json_encode($params);
							$_json_params	= str_replace($this->update['620']['ease_adv_from'], $this->update['620']['ease_adv_to'], $_json_params);
							$params			= ($_json_params !== $json_params) ? (array)json_decode($_json_params, true) : $params;
							$params['version'] = '6.2.0';
							
							$slide->set_params($params);
							$slide->save_params();
							
							$slide->settings['version'] = '6.2.0';
							$slide->save_settings();
						}
						
						//on layers
						$layers = $slide->get_layers();
						
						if(!empty($layers) && is_array($layers)){
							$save = false;
							foreach($layers as $lk => $layer){
								$version = $this->get_val($layer, 'version', '1.0.0');
								
								if(version_compare($version, '6.2.0', '<')){
									$save		 = true;
									$json_layer	 = $_json_layer = json_encode($layer);
									$_json_layer = str_replace($this->update['620']['ease_adv_from'], $this->update['620']['ease_adv_to'], $_json_layer);
									if($_json_layer !== $json_layer){
										$layers[$lk] = (array)json_decode($_json_layer, true);
									}
									$layers[$lk]['version'] = '6.2.0';
								}
							}
							
							if($save){
								$slide->set_layers_raw($layers);
								$slide->save_layers();
							}
						}
					}
				}
				
				$slider->update_settings(array('version' => '6.2.0'));
			}
		}
	}
	
	
	/** check to convert the given Slider to latest versions
	 * @since: 6.4.0
	 * check in all layers, if we have an gradient in idle and if we need to push it to the hover animation
	 **/
	public function upgrade_slider_to_6_4_0($sliders = false){
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();
		
		$sliders = ($sliders === false) ? $sr->get_sliders() : array($sliders); //do it on all Sliders if false
		
		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				if(version_compare($slider->get_setting('version', '1.0.0'), '6.4.0', '<')){
					$params = $slider->get_params();
					$params['version'] = '6.4.0';
					
					if($this->get_val($params, array('layout', 'bg'), false) !== false){
						$do = strtolower($this->get_val($params, array('layout', 'bg', 'dottedOverlay'), ''));
						if(strpos($do, 'white') !== false)		 $this->set_val($params, array('layout', 'bg', 'dottedColorB'), '#FFFFFF');
						if(strpos($do, 'twoxtwo') !== false)	 $this->set_val($params, array('layout', 'bg', 'dottedOverlay'), '1');
						if(strpos($do, 'threexthree') !== false) $this->set_val($params, array('layout', 'bg', 'dottedOverlay'), '2');
					}
					
					$slider->update_params($params, true);
				}
				
				$slides = $slider->get_slides(false, true);
				$static_id = $sl->get_static_slide_id($slider->get_id());
				if($static_id !== false){
					$msl = new RevSliderSlide();
					if(strpos($static_id, 'static_') === false){
						$static_id = 'static_'. $static_id;
					}
					$msl->init_by_id($static_id);
					if($msl->get_id() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}
				
				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						$settings = $slide->get_settings();
						//on slides
						if(version_compare($this->get_val($settings, 'version', '1.0.0'), '6.4.0', '<')){
							$params			= $slide->get_params();
							$params['version'] = '6.4.0';
							
							$do	= $this->get_val($params, array('bg', 'video', 'dottedOverlay'), 'none');
							if(strpos($do, 'white') !== false)		 $this->set_val($params, array('bg', 'video', 'dottedColorB'), '#FFFFFF');
							if(strpos($do, 'twoxtwo') !== false)	 $this->set_val($params, array('bg', 'video', 'dottedOverlay'), '1');
							if(strpos($do, 'threexthree') !== false) $this->set_val($params, array('bg', 'video', 'dottedOverlay'), '2');
							
							$slide->set_params($params);
							$slide->save_params();
							
							$slide->settings['version'] = '6.4.0';
							$slide->save_settings();
						}
						
						//on layers
						$layers = $slide->get_layers();
						
						if(!empty($layers) && is_array($layers)){
							$save = false;
							foreach($layers as $lk => $layer){
								$version = $this->get_val($layer, 'version', '1.0.0');
								
								if(version_compare($version, '6.4.0', '<')){
									$save		 = true;
									$layers[$lk]['version'] = '6.4.0';
									
									if($this->get_val($layer, 'type', 'text') === 'video'){
										$do = $this->get_val($layer, array('media', 'dotted'));
										if(strpos($do, 'white') !== false)		 $this->set_val($layers, array($lk, 'media', 'dottedColorB'), '#FFFFFF');
										if(strpos($do, 'twoxtwo') !== false)	 $this->set_val($layers, array($lk, 'media', 'dotted'), '1');
										if(strpos($do, 'threexthree') !== false) $this->set_val($layers, array($lk, 'media', 'dotted'), '2');
									}
									
									if($this->get_val($layer, 'type', 'text') === 'shape') continue;
									$idle_bg = $this->get_val($layer, array('idle', 'backgroundColor'), '');
									if(
										strpos($idle_bg, 'gradient') === false &&
										strpos($idle_bg, 'radial') === false && 
										strpos($idle_bg, 'linear') === false && 
										strpos($idle_bg, '&type') === false
									) continue;
									if($this->get_val($layer, array('hover', 'usehover'), false) === false) continue;
									
									$hover_bg = $this->get_val($layer, array('hover', 'backgroundColor'), '');
									if(
										strpos($hover_bg, 'gradient') !== false ||
										strpos($hover_bg, 'radial') !== false || 
										strpos($hover_bg, 'linear') !== false || 
										strpos($hover_bg, '&type') !== false
									) continue;
									
									$layers[$lk]['hover']['backgroundColor'] = $idle_bg;
								}
							}
							
							if($save){
								$slide->set_layers_raw($layers);
								$slide->save_layers();
							}
						}
					}
				}
				
				$slider->update_settings(array('version' => '6.4.0'));
			}
		}
	}
	
	/** check to convert the given Slider to latest versions
	 * @since: 6.4.10
	 **/
	public function upgrade_slider_to_6_4_10($sliders = false){
		$sr = new RevSliderSlider();
		
		$sliders = ($sliders === false) ? $sr->get_sliders() : array($sliders); //do it on all Sliders if false
		
		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				if(version_compare($slider->get_setting('version', '1.0.0'), '6.4.10', '<')){
					$params = $slider->get_params();
					$params['version'] = '6.4.10';
					
					$slider->update_params($params, true);
					
					$slider->update_settings(array('version' => '6.4.10'));
				}
			}
		}
	}
	
	
	/**
	 * translates removed settings from Slider Settings from version <= 4.x to 5.0
	 * before: RevSliderBase::translate_settings_to_v5()
	 * @since: 5.0
	 **/
	public function translate_navigation_to_v5($sliders = false){
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();

		if($sliders === false){
			//do it on all Sliders
			$sliders = $sr->get_sliders();
		}else{
			$sliders = array($sliders);
		}

		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$s = $slider->get_settings();

				if(isset($s['navigaion_type'])){
					switch ($s['navigaion_type']){
					case 'none': // all is off, so leave the defaults
						break;
					case 'bullet':
						$s['enable_bullets'] = 'on';
						$s['enable_thumbnails'] = 'off';
						$s['enable_tabs'] = 'off';

						break;
					case 'thumb':
						$s['enable_bullets'] = 'off';
						$s['enable_thumbnails'] = 'on';
						$s['enable_tabs'] = 'off';
						break;
					}
					unset($s['navigaion_type']);
				}

				if(isset($s['navigation_arrows'])){
					$s['enable_arrows'] = ($s['navigation_arrows'] == 'solo' || $s['navigation_arrows'] == 'nexttobullets') ? 'on' : 'off';
					unset($s['navigation_arrows']);
				}

				if(isset($s['navigation_style'])){
					$s['navigation_arrow_style'] = $s['navigation_style'];
					$s['navigation_bullets_style'] = $s['navigation_style'];
					unset($s['navigation_style']);
				}

				if(isset($s['navigaion_always_on'])){
					$s['arrows_always_on'] = $s['navigaion_always_on'];
					$s['bullets_always_on'] = $s['navigaion_always_on'];
					$s['thumbs_always_on'] = $s['navigaion_always_on'];
					unset($s['navigaion_always_on']);
				}

				if(isset($s['hide_thumbs']) && !isset($s['hide_arrows']) && !isset($s['hide_bullets'])){
					//as hide_thumbs is still existing, we need to check if the other two were already set and only translate this if they are not set yet
					$s['hide_arrows'] = $s['hide_thumbs'];
					$s['hide_bullets'] = $s['hide_thumbs'];
				}

				if(isset($s['navigaion_align_vert'])){
					$s['bullets_align_vert'] = $s['navigaion_align_vert'];
					$s['thumbnails_align_vert'] = $s['navigaion_align_vert'];
					unset($s['navigaion_align_vert']);
				}

				if(isset($s['navigaion_align_hor'])){
					$s['bullets_align_hor'] = $s['navigaion_align_hor'];
					$s['thumbnails_align_hor'] = $s['navigaion_align_hor'];
					unset($s['navigaion_align_hor']);
				}

				if(isset($s['navigaion_offset_hor'])){
					$s['bullets_offset_hor'] = $s['navigaion_offset_hor'];
					$s['thumbnails_offset_hor'] = $s['navigaion_offset_hor'];
					unset($s['navigaion_offset_hor']);
				}

				if(isset($s['navigaion_offset_hor'])){
					$s['bullets_offset_hor'] = $s['navigaion_offset_hor'];
					$s['thumbnails_offset_hor'] = $s['navigaion_offset_hor'];
					unset($s['navigaion_offset_hor']);
				}

				if(isset($s['navigaion_offset_vert'])){
					$s['bullets_offset_vert'] = $s['navigaion_offset_vert'];
					$s['thumbnails_offset_vert'] = $s['navigaion_offset_vert'];
					unset($s['navigaion_offset_vert']);
				}

				if(isset($s['show_timerbar']) && !isset($s['enable_progressbar'])){
					if($s['show_timerbar'] == 'hide'){
						$s['enable_progressbar'] = 'off';
						$s['show_timerbar'] = 'top';
					}else{
						$s['enable_progressbar'] = 'on';
					}
				}

				$slider->update_settings($s);
			}
		}
	}

	/**
	 * add new styles for version 5.0
	 * @since 5.0
	 */
	public function add_v5_styles(){
		global $wpdb;

		$v5 = array(
			array('handle' => '.tp-caption.MarkerDisplay', 'settings' => '{"translated":5,"type":"text","version":"5.0"}', 'hover' => '{"color":"#ff0000","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0px","0px","0px","0px"],"skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0"}', 'params' => '{"font-style":"normal","font-family":"Permanent Marker","padding":"0px 0px 0px 0px","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"#000000","border-style":"none","border-width":"0px","border-radius":"0px 0px 0px 0px","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"text-shadow":"none"},"hover":""}'),
			array('handle' => '.tp-caption.Restaurant-Display', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0"}', 'params' => '{"color":"#ffffff","font-size":"120px","line-height":"120px","font-weight":"700","font-style":"normal","font-family":"Roboto","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Restaurant-Cursive', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0"}', 'params' => '{"color":"#ffffff","font-size":"30px","line-height":"30px","font-weight":"400","font-style":"normal","font-family":"Nothing you could do","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Restaurant-ScrollDownText', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0"}', 'params' => '{"color":"#ffffff","font-size":"17px","line-height":"17px","font-weight":"400","font-style":"normal","font-family":"Roboto","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Restaurant-Description', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0"}', 'params' => '{"color":"#ffffff","font-size":"20px","line-height":"30px","font-weight":"300","font-style":"normal","font-family":"Roboto","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.Restaurant-Price', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0"}', 'params' => '{"color":"#ffffff","font-size":"30px","line-height":"30px","font-weight":"300","font-style":"normal","font-family":"Roboto","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.Restaurant-Menuitem', 'settings' => '{"hover":"false","type":"text","version":"5.0","translated":"5"}', 'hover' => '{"color":"#000000","color-transparency":"1","text-decoration":"none","background-color":"#ffffff","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"pointer","speed":"500","easing":"power2.inOut"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"17px","line-height":"17px","font-weight":"400","font-style":"normal","font-family":"Roboto","padding":["10px","30px","10px","30px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Furniture-LogoText', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#e6cfa3","color-transparency":"1","font-size":"160px","line-height":"150px","font-weight":"300","font-style":"normal","font-family":"\\"Raleway\\"","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"text-shadow":"none"},"hover":""}'),
			array('handle' => '.tp-caption.Furniture-Plus', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["30px","30px","30px","30px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0.5","easing":"none"}', 'params' => '{"color":"#e6cfa3","color-transparency":"1","font-size":"20","line-height":"20px","font-weight":"400","font-style":"normal","font-family":"\\"Raleway\\"","padding":["6px","7px","4px","7px"],"text-decoration":"none","background-color":"#ffffff","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["30px","30px","30px","30px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"text-shadow":"none","box-shadow":"rgba(0,0,0,0.1) 0 1px 3px"},"hover":""}'),
			array('handle' => '.tp-caption.Furniture-Title', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#000000","color-transparency":"1","font-size":"20px","line-height":"20px","font-weight":"700","font-style":"normal","font-family":"\\"Raleway\\"","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"text-shadow":"none","letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.Furniture-Subtitle', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#000000","color-transparency":"1","font-size":"17px","line-height":"20px","font-weight":"300","font-style":"normal","font-family":"\\"Raleway\\"","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"text-shadow":"none"},"hover":""}'),
			array('handle' => '.tp-caption.Gym-Display', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"80px","line-height":"70px","font-weight":"900","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Gym-Subline', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"30px","line-height":"30px","font-weight":"100","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"letter-spacing":"5px"},"hover":""}'),
			array('handle' => '.tp-caption.Gym-SmallText', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"17px","line-height":"22","font-weight":"300","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"text-shadow":"none"},"hover":""}'),
			array('handle' => '.tp-caption.Fashion-SmallText', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"12px","line-height":"20px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Fashion-BigDisplay', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#000000","color-transparency":"1","font-size":"60px","line-height":"60px","font-weight":"900","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Fashion-TextBlock', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#000000","color-transparency":"1","font-size":"20px","line-height":"40px","font-weight":"400","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Sports-Display', 'settings' => '{"translated":5,"type":"text","version":"5.0"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"130px","line-height":"130px","font-weight":"100","font-style":"normal","font-family":"\\"Raleway\\"","padding":"0 0 0 0","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":"0 0 0 0","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"letter-spacing":"13px"},"hover":""}'),
			array('handle' => '.tp-caption.Sports-DisplayFat', 'settings' => '{"translated":5,"type":"text","version":"5.0"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"130px","line-height":"130px","font-weight":"900","font-style":"normal","font-family":"\\"Raleway\\"","padding":"0 0 0 0","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":"0 0 0 0","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":[""],"hover":""}'),
			array('handle' => '.tp-caption.Sports-Subline', 'settings' => '{"translated":5,"type":"text","version":"5.0"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#000000","color-transparency":"1","font-size":"32px","line-height":"32px","font-weight":"400","font-style":"normal","font-family":"\\"Raleway\\"","padding":"0 0 0 0","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":"0 0 0 0","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"letter-spacing":"4px"},"hover":""}'),
			array('handle' => '.tp-caption.Instagram-Caption', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"20px","line-height":"20px","font-weight":"900","font-style":"normal","font-family":"Roboto","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.News-Title', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"70px","line-height":"60px","font-weight":"400","font-style":"normal","font-family":"Roboto Slab","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.News-Subtitle', 'settings' => '{"hover":"true","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"0.65","text-decoration":"none","background-color":"#ffffff","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"solid","border-width":"0px","border-radius":["0","0","0px","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"300","easing":"power3.inOut"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"15px","line-height":"24px","font-weight":"300","font-style":"normal","font-family":"Roboto Slab","padding":["0","0","0","0"],"text-decoration":"none","background-color":"#ffffff","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Photography-Display', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"80px","line-height":"70px","font-weight":"100","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"letter-spacing":"5px"},"hover":""}'),
			array('handle' => '.tp-caption.Photography-Subline', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#777777","color-transparency":"1","font-size":"20px","line-height":"30px","font-weight":"300","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.Photography-ImageHover', 'settings' => '{"hover":"true","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"0.5","scalex":"0.8","scaley":"0.8","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"1000","easing":"power3.inOut"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"20","line-height":"22","font-weight":"400","font-style":"normal","font-family":"","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"#ffffff","border-transparency":"0","border-style":"none","border-width":"0px","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Photography-Menuitem', 'settings' => '{"hover":"true","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#00ffde","background-transparency":"0.65","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"pointer","speed":"200","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"20px","line-height":"20px","font-weight":"300","font-style":"normal","font-family":"Raleway","padding":["3px","5px","3px","8px"],"text-decoration":"none","background-color":"#000000","background-transparency":"0.65","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Photography-Textblock', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"none"}', 'params' => '{"color":"#fff","color-transparency":"1","font-size":"17px","line-height":"30px","font-weight":"300","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Photography-Subline-2', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"0.35","font-size":"20px","line-height":"30px","font-weight":"300","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":{"letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.Photography-ImageHover2', 'settings' => '{"hover":"true","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"0.5","scalex":"0.8","scaley":"0.8","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"pointer","speed":"500","easing":"back.out"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"20","line-height":"22","font-weight":"400","font-style":"normal","font-family":"Arial","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"#ffffff","border-transparency":"0","border-style":"none","border-width":"0px","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.WebProduct-Title', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"0","easing":"none"}', 'params' => '{"color":"#333333","color-transparency":"1","font-size":"90px","line-height":"90px","font-weight":"100","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.WebProduct-SubTitle', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"0","easing":"none"}', 'params' => '{"color":"#999999","color-transparency":"1","font-size":"15px","line-height":"20px","font-weight":"400","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.WebProduct-Content', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"0","easing":"none"}', 'params' => '{"color":"#999999","color-transparency":"1","font-size":"16px","line-height":"24px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.WebProduct-Menuitem', 'settings' => '{"hover":"true","version":"5.0","translated":"5"}', 'hover' => '{"color":"#999999","color-transparency":"1","text-decoration":"none","background-color":"#ffffff","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"pointer","speed":"200","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"15px","line-height":"20px","font-weight":"500","font-style":"normal","font-family":"Raleway","padding":["3px","5px","3px","8px"],"text-decoration":"none","text-align":"left","background-color":"#333333","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.WebProduct-Title-Light', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"0","easing":"none"}', 'params' => '{"color":"#fff","color-transparency":"1","font-size":"90px","line-height":"90px","font-weight":"100","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","text-align":"left","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.WebProduct-SubTitle-Light', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"0.35","font-size":"15px","line-height":"20px","font-weight":"400","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","text-align":"left","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","parallax":"-"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.WebProduct-Content-Light', 'settings' => '{"hover":"false","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"0.65","font-size":"16px","line-height":"24px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","text-align":"left","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","parallax":"-"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.FatRounded', 'settings' => '{"hover":"true","type":"text","version":"5.0","translated":"5"}', 'hover' => '{"color":"#fff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"1","border-color":"#d3d3d3","border-transparency":"1","border-style":"none","border-width":"0px","border-radius":["50px","50px","50px","50px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"pointer","speed":"300","easing":"none"}', 'params' => '{"color":"#fff","color-transparency":"1","font-size":"30px","line-height":"30px","font-weight":"900","font-style":"normal","font-family":"Raleway","padding":["20px","22px","20px","25px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0.5","border-color":"#d3d3d3","border-transparency":"1","border-style":"none","border-width":"0px","border-radius":["50px","50px","50px","50px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"text-shadow":"none"},"hover":""}'),
			array('handle' => '.tp-caption.NotGeneric-Title', 'settings' => '{"translated":5,"type":"text","version":"5.0"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"70px","line-height":"70px","font-weight":"800","font-style":"normal","font-family":"Raleway","padding":"10px 0px 10px 0","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":"0 0 0 0","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":"[object Object]","hover":""}'),
			array('handle' => '.tp-caption.NotGeneric-SubTitle', 'settings' => '{"translated":5,"type":"text","version":"5.0"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"13px","line-height":"20px","font-weight":"500","font-style":"normal","font-family":"Raleway","padding":"0 0 0 0","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":"0 0 0 0","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"4px","text-align":"left"},"hover":""}'),
			array('handle' => '.tp-caption.NotGeneric-CallToAction', 'settings' => '{"hover":"true","translated":5,"type":"text","version":"5.0"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1","border-radius":"0px 0px 0px 0px","opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"pointer","speed":"300","easing":"power3.out"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"14px","line-height":"14px","font-weight":"500","font-style":"normal","font-family":"Raleway","padding":"10px 30px 10px 30px","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.5","border-style":"solid","border-width":"1","border-radius":"0px 0px 0px 0px","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"3px","text-align":"left"},"hover":""}'),
			array('handle' => '.tp-caption.NotGeneric-Icon', 'settings' => '{"translated":5,"type":"text","version":"5.0"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"default","speed":"300","easing":"power3.out"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"30px","line-height":"30px","font-weight":"400","font-style":"normal","font-family":"Raleway","padding":"0px 0px 0px 0px","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0","border-style":"solid","border-width":"0px","border-radius":"0px 0px 0px 0px","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"3px","text-align":"left"},"hover":""}'),
			array('handle' => '.tp-caption.NotGeneric-Menuitem', 'settings' => '{"hover":"true","translated":5,"type":"text","version":"5.0"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1px","border-radius":"0px 0px 0px 0px","opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"pointer","speed":"300","easing":"power1.inOut"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"14px","line-height":"14px","font-weight":"500","font-style":"normal","font-family":"Raleway","padding":"27px 30px 27px 30px","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.15","border-style":"solid","border-width":"1px","border-radius":"0px 0px 0px 0px","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"3px","text-align":"left"},"hover":""}'),
			array('handle' => '.tp-caption.MarkerStyle', 'settings' => '{"translated":5,"type":"text","version":"5.0"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"17px","line-height":"30px","font-weight":"100","font-style":"normal","font-family":"\\"Permanent Marker\\"","padding":"0 0 0 0","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":"0 0 0 0","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"text-align":"left","0":""},"hover":""}'),
			array('handle' => '.tp-caption.Gym-Menuitem', 'settings' => '{"hover":"true","type":"text","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"1","border-color":"#ffffff","border-transparency":"0.25","border-style":"solid","border-width":"2px","border-radius":["3px","3px","3px","3px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"pointer","speed":"200","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"20px","line-height":"20px","font-weight":"300","font-style":"normal","font-family":"Raleway","padding":["3px","5px","3px","8px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"1","border-color":"#ffffff","border-transparency":"0","border-style":"solid","border-width":"2px","border-radius":["3px","3px","3px","3px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Newspaper-Button', 'settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}', 'hover' => '{"color":"#000000","color-transparency":"1","text-decoration":"none","background-color":"#FFFFFF","background-transparency":"1","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1px","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"pointer","speed":"300","easing":"power1.inOut"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"13px","line-height":"17px","font-weight":"700","font-style":"normal","font-family":"Roboto","padding":["12px","35px","12px","35px"],"text-decoration":"none","text-align":"left","background-color":"#ffffff","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.25","border-style":"solid","border-width":"1px","border-radius":["0px","0px","0px","0px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Newspaper-Subtitle', 'settings' => '{"hover":"false","type":"text","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"0","easing":"none"}', 'params' => '{"color":"#a8d8ee","color-transparency":"1","font-size":"15px","line-height":"20px","font-weight":"900","font-style":"normal","font-family":"Roboto","padding":["0","0","0","0"],"text-decoration":"none","text-align":"left","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Newspaper-Title', 'settings' => '{"hover":"false","type":"text","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"0","easing":"none"}', 'params' => '{"color":"#fff","color-transparency":"1","font-size":"50px","line-height":"55px","font-weight":"400","font-style":"normal","font-family":"\\"Roboto Slab\\"","padding":["0","0","10px","0"],"text-decoration":"none","text-align":"left","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Newspaper-Title-Centered', 'settings' => '{"hover":"false","type":"text","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"0","easing":"none"}', 'params' => '{"color":"#fff","color-transparency":"1","font-size":"50px","line-height":"55px","font-weight":"400","font-style":"normal","font-family":"\\"Roboto Slab\\"","padding":["0","0","10px","0"],"text-decoration":"none","text-align":"center","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Hero-Button', 'settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}', 'hover' => '{"color":"#000000","color-transparency":"1","text-decoration":"none","background-color":"#ffffff","background-transparency":"1","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"pointer","speed":"300","easing":"power1.inOut"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"14px","line-height":"14px","font-weight":"500","font-style":"normal","font-family":"Raleway","padding":["10px","30px","10px","30px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.5","border-style":"solid","border-width":"1","border-radius":["0px","0px","0px","0px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.Video-Title', 'settings' => '{"hover":"false","type":"text","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"0","easing":"none"}', 'params' => '{"color":"#fff","color-transparency":"1","font-size":"30px","line-height":"30px","font-weight":"900","font-style":"normal","font-family":"Raleway","padding":["5px","5px","5px","5px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"-20%","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Video-SubTitle', 'settings' => '{"hover":"false","type":"text","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"0","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"12px","line-height":"12px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["5px","5px","5px","5px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0.35","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"-20%","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.NotGeneric-Button', 'settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"pointer","speed":"300","easing":"power1.inOut"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"14px","line-height":"14px","font-weight":"500","font-style":"normal","font-family":"Raleway","padding":["10px","30px","10px","30px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.5","border-style":"solid","border-width":"1","border-radius":["0px","0px","0px","0px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"3px","text-align":"left"},"hover":""}'),
			array('handle' => '.tp-caption.NotGeneric-BigButton', 'settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1px","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"pointer","speed":"300","easing":"power1.inOut"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"14px","line-height":"14px","font-weight":"500","font-style":"normal","font-family":"Raleway","padding":["27px","30px","27px","30px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.15","border-style":"solid","border-width":"1px","border-radius":["0px","0px","0px","0px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.WebProduct-Button', 'settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}', 'hover' => '{"color":"#333333","color-transparency":"1","text-decoration":"none","background-color":"#ffffff","background-transparency":"1","border-color":"#000000","border-transparency":"1","border-style":"none","border-width":"2","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"300","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"16px","line-height":"48px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["0px","40px","0px","40px"],"text-decoration":"none","text-align":"left","background-color":"#333333","background-transparency":"1","border-color":"#000000","border-transparency":"1","border-style":"none","border-width":"2","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"1px"},"hover":""}'),
			array('handle' => '.tp-caption.Restaurant-Button', 'settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffe081","border-transparency":"1","border-style":"solid","border-width":"2","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"300","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"17px","line-height":"17px","font-weight":"500","font-style":"normal","font-family":"Roboto","padding":["12px","35px","12px","35px"],"text-decoration":"none","text-align":"left","background-color":"#0a0a0a","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.5","border-style":"solid","border-width":"2","border-radius":["0px","0px","0px","0px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.Gym-Button', 'settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#72a800","background-transparency":"1","border-color":"#000000","border-transparency":"0","border-style":"solid","border-width":"0","border-radius":["30px","30px","30px","30px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"pointer","speed":"300","easing":"power1.inOut"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"15px","line-height":"15px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["13px","35px","13px","35px"],"text-decoration":"none","text-align":"left","background-color":"#8bc027","background-transparency":"1","border-color":"#000000","border-transparency":"0","border-style":"solid","border-width":"0","border-radius":["30px","30px","30px","30px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"1px"},"hover":""}'),
			array('handle' => '.tp-caption.Gym-Button-Light', 'settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#72a800","background-transparency":"0","border-color":"#8bc027","border-transparency":"1","border-style":"solid","border-width":"2px","border-radius":["30px","30px","30px","30px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"pointer","speed":"300","easing":"power2.inOut"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"15px","line-height":"15px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["12px","35px","12px","35px"],"text-decoration":"none","text-align":"left","background-color":"transparent","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.25","border-style":"solid","border-width":"2px","border-radius":["30px","30px","30px","30px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Sports-Button-Light', 'settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"2","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"500","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"17px","line-height":"17px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["12px","35px","12px","35px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.5","border-style":"solid","border-width":"2","border-radius":["0px","0px","0px","0px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Sports-Button-Red', 'settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"1","border-color":"#000000","border-transparency":"1","border-style":"solid","border-width":"2","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"500","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"17px","line-height":"17px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["12px","35px","12px","35px"],"text-decoration":"none","text-align":"left","background-color":"#db1c22","background-transparency":"1","border-color":"#db1c22","border-transparency":"0","border-style":"solid","border-width":"2px","border-radius":["0px","0px","0px","0px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Photography-Button', 'settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1px","border-radius":["30px","30px","30px","30px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"auto","speed":"300","easing":"power3.out"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"15px","line-height":"15px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["13px","35px","13px","35px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.25","border-style":"solid","border-width":"1px","border-radius":["30px","30px","30px","30px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":{"letter-spacing":"1px"},"hover":""}'),
			array('handle' => '.tp-caption.Newspaper-Button-2', 'settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}', 'hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"2","border-radius":["3px","3px","3px","3px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","pointer_events":"auto","css_cursor":"pointer","speed":"300","easing":"none"}', 'params' => '{"color":"#ffffff","color-transparency":"1","font-size":"15px","line-height":"15px","font-weight":"900","font-style":"normal","font-family":"Roboto","padding":["10px","30px","10px","30px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.5","border-style":"solid","border-width":"2","border-radius":["3px","3px","3px","3px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}', 'advanced' => '{"idle":"","hover":""}'),
		);

		foreach($v5 as $v5class){
			$result = $wpdb->get_row($wpdb->prepare("SELECT id FROM " . $wpdb->prefix . RevSliderFront::TABLE_CSS . " WHERE handle = %s", $v5class['handle']), ARRAY_A);
			if(empty($result)){
				//add v5 style
				$wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_CSS, $v5class);
			}
		}
	}

	/**
	 * update the styles to meet requirements for version 5.0
	 * @since 5.0
	 */
	public function update_css_styles(){
		global $wpdb;

		$css = RevSliderGlobals::instance()->get('RevSliderCssParser');
		$styles = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . RevSliderFront::TABLE_CSS, ARRAY_A);
		$default_classes = $css->default_css_classes();

		$cs = array(
			'background-color' => 'backgroundColor', //rgb rgba and opacity
			'border-color' => 'borderColor',
			'border-radius' => 'borderRadius',
			'border-style' => 'borderStyle',
			'border-width' => 'borderWidth',
			'color' => 'color',
			'font-family' => 'fontFamily',
			'font-size' => 'fontSize',
			'font-style' => 'fontStyle',
			'font-weight' => 'fontWeight',
			'line-height' => 'lineHeight',
			'opacity' => 'opacity',
			'padding' => 'padding',
			'text-decoration' => 'textDecoration',
			'text-align' => 'textAlign',
		);

		$cs = array_merge($cs, $css->get_deformation_css_tags());

		foreach($styles as $key => $attr){
			if(isset($attr['advanced'])){
				$adv = json_decode($attr['advanced'], true); // = array('idle' => array(), 'hover' => '');
			}else{
				$adv = array('idle' => array(), 'hover' => '');
			}

			if(!isset($adv['idle'])){
				$adv['idle'] = array();
			}

			if(!isset($adv['hover'])){
				$adv['hover'] = array();
			}

			//only do this to styles prior 5.0
			$settings = json_decode($attr['settings'], true);
			if(!empty($settings) && isset($settings['translated'])){
				if(version_compare($settings['translated'], 5.0, '>=')){
					continue;
				}

			}

			$idle = json_decode($attr['params'], true);
			$hover = json_decode($attr['hover'], true);

			//check if in styles, there is type, then change the type text to something else
			$the_type = 'text';
			if(!empty($idle)){
				foreach($idle as $style => $value){
					if($style == 'type'){
						$the_type = $value;
					}

					if(!isset($cs[$style])){
						if($style === 0){
							continue;
						}

						$adv['idle'][$style] = $value;
						unset($idle[$style]);
					}
				}
			}
			
			if(!empty($hover)){
				foreach($hover as $style => $value){
					if(!isset($cs[$style])){
						if($style == 0){
							continue;
						}

						$adv['hover'][$style] = $value;
						unset($hover[$style]);
					}
				}
			}

			$settings['translated'] = 5.0; //set the style version to 5.0
			$settings['type'] = $the_type; //set the type version to text, since 5.0 we also have buttons and shapes, so we need to differentiate from now on

			if(!isset($settings['version'])){
				if(isset($default_classes[$styles[$key]['handle']])){
					$settings['version'] = $default_classes[$styles[$key]['handle']];
				}else{
					$settings['version'] = 'custom'; //set the version to custom as its not in the defaults
				}
			}
			
			$styles[$key]['params'] = json_encode($idle);
			$styles[$key]['hover'] = json_encode($hover);
			$styles[$key]['advanced'] = json_encode($adv);
			$styles[$key]['settings'] = json_encode($settings);
		}

		//save now all styles back to database
		foreach($styles as $key => $attr){
			$ret = $wpdb->update($wpdb->prefix . RevSliderFront::TABLE_CSS, array('settings' => $styles[$key]['settings'], 'params' => $styles[$key]['params'], 'hover' => $styles[$key]['hover'], 'advanced' => $styles[$key]['advanced']), array('id' => $attr['id']));
		}

	}

	/**
	 * remove the settings from the table and use them from now on with get_option / update_option
	 * @since 5.0
	 */
	public function check_settings_table(){
		global $wpdb;

		if($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . RevSliderFront::TABLE_SETTINGS . "'") == $wpdb->prefix . RevSliderFront::TABLE_SETTINGS){
			$result = $wpdb->get_row("SELECT `general` FROM " . $wpdb->prefix . RevSliderFront::TABLE_SETTINGS, ARRAY_A);
			if(isset($result['general'])){
				update_option('revslider-global-settings', $result['general']);
			}
		}
	}

	/**
	 * move the template sliders and add the slides to corresponding post based slider or simply move them and change them to post based slider if no slider is using them
	 * @since 5.0
	 */
	public function move_template_slider(){
		global $wpdb;

		$used = array(); //will store all template IDs that are used by post based Sliders, these can be deleted after the progress.
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();
		$sliders = $sr->get_sliders(false);
		$temp_sliders = $sr->get_sliders(true);

		if(empty($temp_sliders) || !is_array($temp_sliders)){
			return true;
		}
		//as we do not have any template sliders, we do not need to run further here

		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				if($slider->get_param('source_type', 'gallery') !== 'posts'){
					continue;
				}
				//only check Slider with type of posts

				$slider_id = $slider->get_id();
				$template_id = $slider->get_param('slider_template_id', 0);

				if($template_id > 0){
					//initialize slider to see if it exists. Then copy over the Template Sliders Slides to the Post Based Slider
					foreach($temp_sliders as $t_slider){
						if($t_slider->get_id() === $template_id){
							//copy over the slides
							//get all slides from template, then copy to Slider

							$slides = $t_slider->get_slides(false, true);

							if(!empty($slides) && is_array($slides)){
								foreach($slides as $slide){
									$slide_id = $slide->get_id();
									$slider->copy_slide_to_slider(array('slider_id' => $slider_id, 'slide_id' => $slide_id));
								}
							}

							$static_id = $sl->get_static_slide_id($template_id);
							if($static_id !== false){
								$record = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES . " WHERE id = %d", $static_id), ARRAY_A);
								unset($record['id']);
								$record['slider_id'] = $slider_id;

								$wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES, $record);
							}

							$used[$template_id] = $t_slider;
							break;
						}
					}
				}

			}
		}

		if(!empty($used)){
			foreach($used as $tid => $t_slider){
				$t_slider->delete_slider();
			}
		}

		//translate all other template Sliders to normal sliders and set them to post based
		$temp_sliders = $sr->get_sliders(true);

		if(!empty($temp_sliders) && is_array($temp_sliders)){
			foreach($temp_sliders as $slider){
				$slider->update_params(array('template' => 'false', 'source_type' => 'posts'));
			}
		}

	}

	/**
	 * add missing new animation fields to the layers as all animations would be broken without this
	 * @since 5.0
	 */
	public function add_animation_settings_to_layer($sliders = false){
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();
		$sliders = ($sliders === false) ? $sr->get_sliders() : array($sliders); //false == do it on all Sliders

		$in_animations = $this->get_animations();
		$out_animations = $this->get_end_animations();
		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$slides = $slider->get_slides(false, true);
				$static_id = $sl->get_static_slide_id($slider->get_id());
				if($static_id !== false){
					$msl = new RevSliderSlide();
					if(strpos($static_id, 'static_') === false){
						$static_id = 'static_'. $static_id; //$slider->get_id();
					}
					$msl->init_by_id($static_id);
					if($msl->get_id() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}

				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						$layers = $slide->get_layers();
						if(!empty($layers) && is_array($layers)){
							foreach($layers as $lk => $layer){
								if($this->get_val($layer, 'x_start', false) === false){
									//values are not set, set them now through
									$anim_values = array();
									$animation = $this->get_val($layer, 'animation', 'tp-fade');
									$endanimation = $this->get_val($layer, 'endanimation', 'tp-fade');
									$animation = ($animation == 'fade') ? 'tp-fade' : $animation;
									$endanimation = ($endanimation == 'fade') ? 'tp-fade' : $endanimation;

									foreach($in_animations as $handle => $anim){
										if($handle == $animation){
											$anim_values = (isset($anim['params'])) ? $anim['params'] : '';
											if(!is_array($anim_values)){
												$anim_values = json_encode($anim_values);
											}

											break;
										}
									}

									$anim_endvalues = array();
									foreach($out_animations as $handle => $anim){
										if($handle == $endanimation){
											$anim_endvalues = (isset($anim['params'])) ? $anim['params'] : '';
											if(!is_array($anim_endvalues)){
												$anim_endvalues = json_encode($anim_endvalues);
											}

											break;
										}
									}

									$layers[$lk]['x_start'] = $this->get_val($anim_values, 'movex', 'inherit');
									$layers[$lk]['x_end'] = $this->get_val($anim_endvalues, 'movex', 'inherit');
									$layers[$lk]['y_start'] = $this->get_val($anim_values, 'movey', 'inherit');
									$layers[$lk]['y_end'] = $this->get_val($anim_endvalues, 'movey', 'inherit');
									$layers[$lk]['z_start'] = $this->get_val($anim_values, 'movez', 'inherit');
									$layers[$lk]['z_end'] = $this->get_val($anim_endvalues, 'movez', 'inherit');

									$layers[$lk]['x_rotate_start'] = $this->get_val($anim_values, 'rotationx', 'inherit');
									$layers[$lk]['x_rotate_end'] = $this->get_val($anim_endvalues, 'rotationx', 'inherit');
									$layers[$lk]['y_rotate_start'] = $this->get_val($anim_values, 'rotationy', 'inherit');
									$layers[$lk]['y_rotate_end'] = $this->get_val($anim_endvalues, 'rotationy', 'inherit');
									$layers[$lk]['z_rotate_start'] = $this->get_val($anim_values, 'rotationz', 'inherit');
									$layers[$lk]['z_rotate_end'] = $this->get_val($anim_endvalues, 'rotationz', 'inherit');

									$layers[$lk]['scale_x_start'] = $this->get_val($anim_values, 'scalex', 'inherit');
									if(intval($layers[$lk]['scale_x_start']) > 10){
										$layers[$lk]['scale_x_start'] /= 100;
									}

									$layers[$lk]['scale_x_end'] = $this->get_val($anim_endvalues, 'scalex', 'inherit');
									if(intval($layers[$lk]['scale_x_end']) > 10){
										$layers[$lk]['scale_x_end'] /= 100;
									}

									$layers[$lk]['scale_y_start'] = $this->get_val($anim_values, 'scaley', 'inherit');
									if(intval($layers[$lk]['scale_y_start']) > 10){
										$layers[$lk]['scale_y_start'] /= 100;
									}

									$layers[$lk]['scale_y_end'] = $this->get_val($anim_endvalues, 'scaley', 'inherit');
									if(intval($layers[$lk]['scale_y_end']) > 10){
										$layers[$lk]['scale_y_end'] /= 100;
									}

									$layers[$lk]['skew_x_start'] = $this->get_val($anim_values, 'skewx', 'inherit');
									$layers[$lk]['skew_x_end'] = $this->get_val($anim_endvalues, 'skewx', 'inherit');
									$layers[$lk]['skew_y_start'] = $this->get_val($anim_values, 'skewy', 'inherit');
									$layers[$lk]['skew_y_end'] = $this->get_val($anim_endvalues, 'skewy', 'inherit');
									$layers[$lk]['opacity_start'] = $this->get_val($anim_values, 'captionopacity', 'inherit');
									$layers[$lk]['opacity_end'] = $this->get_val($anim_endvalues, 'captionopacity', 'inherit');

								}
							}
							$slide->set_layers_raw($layers);
							$slide->save_layers();
						}
					}
				}
			}
		}
	}

	/**
	 * add/change layers options
	 * @since 5.0
	 */
	public function change_settings_on_layers($sliders = false){
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();
		$sliders = ($sliders === false) ? $sr->get_sliders() : array($sliders); //do it on all Sliders if false

		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$slides = $slider->get_slides(false, true);
				$staticID = $sl->get_static_slide_id($slider->get_id());
				if($staticID !== false){
					$msl = new RevSliderSlide();
					if(strpos($staticID, 'static_') === false){
						$staticID = 'static_'. $staticID; //$slider->get_id();
					}
					$msl->init_by_id($staticID);
					if($msl->get_id() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}
				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						$layers = $slide->get_layers();
						if(!empty($layers) && is_array($layers)){
							$do_save = false;
							foreach($layers as $lk => $layer){
								$link_slide = $this->get_val($layer, 'link_slide', false);
								if($link_slide != false && $link_slide !== 'nothing'){
									//link to slide/scrollunder is set, move it to actions
									$layers[$lk]['layer_action'] = new stdClass();
									switch($link_slide){
										case 'link':
											$link = $this->get_val($layer, 'link');
											$link_open_in = $this->get_val($layer, 'link_open_in');
											$layers[$lk]['layer_action']->action = array('a' => 'link');
											$layers[$lk]['layer_action']->link_type = array('a' => 'a');
											$layers[$lk]['layer_action']->image_link = array('a' => $link);
											$layers[$lk]['layer_action']->link_open_in = array('a' => $link_open_in);

											unset($layers[$lk]['link']);
											unset($layers[$lk]['link_open_in']);
										case 'next':
											$layers[$lk]['layer_action']->action = array('a' => 'next');
											break;
										case 'prev':
											$layers[$lk]['layer_action']->action = array('a' => 'prev');
											break;
										case 'scroll_under':
											$scrollunder_offset = $this->get_val($layer, 'scrollunder_offset');
											$layers[$lk]['layer_action']->action = array('a' => 'scroll_under');
											$layers[$lk]['layer_action']->scrollunder_offset = array('a' => $scrollunder_offset);

											unset($layers[$lk]['scrollunder_offset']);
											break;
										default: //its an ID, so its a slide ID
											$layers[$lk]['layer_action']->action = array('a' => 'jumpto');
											$layers[$lk]['layer_action']->jump_to_slide = array('a' => $link_slide);
											break;
									}
									$layers[$lk]['layer_action']->tooltip_event = array('a' => 'click');

									unset($layers[$lk]['link_slide']);

									$do_save = true;
								}
							}

							if($do_save){
								$slide->set_layers_raw($layers);
								$slide->save_layers();
							}
						}
					}
				}
			}
		}
	}

	/**
	 * add missing new style fields to the layers as all layers would be broken without this
	 * @since 5.0
	 */
	public function add_style_settings_to_layer($sliders = false){
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();
		$sliders = ($sliders === false) ? $sr->get_sliders() : array($sliders); //do it on all Sliders if false
		$styles = $this->get_captions_array();

		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$slides = $slider->get_slides(false, true);
				$staticID = $sl->get_static_slide_id($slider->get_id());
				if($staticID !== false){
					$msl = new RevSliderSlide();
					if(strpos($staticID, 'static_') === false){
						$staticID = 'static_'. $staticID; //$slider->get_id();
					}
					$msl->init_by_id($staticID);
					if($msl->get_id() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}
				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						$layers = $slide->get_layers();
						if(!empty($layers) && is_array($layers)){
							foreach($layers as $lk => $layer){
								$static_styles = (array) $this->get_val($layer, 'static_styles', array());
								$def_val = (array) $this->get_val($layer, 'deformation', array());
								$defh_val = (array) $this->get_val($layer, 'deformation-hover', array());

								if(empty($def_val)){
									//add parallax always!
									$def_val['parallax'] = $this->get_val($layer, 'parallax_level', '-');
									$layers[$lk]['deformation'] = $def_val;

									//check for selected style in styles, then add all deformations to the layer
									$cur_style = $this->get_val($layer, 'style', '');

									if(trim($cur_style) == ''){
										continue;
									}

									$wws = false;

									foreach($styles as $style){
										if($style['handle'] == '.tp-caption.'. $cur_style){
											$wws = $style;
											break;
										}
									}

									if($wws == false){
										continue;
									}

									$css_idle = '';
									$css_hover = '';

									$wws['params'] = (array) $wws['params'];
									$wws['hover'] = (array) $wws['hover'];
									$wws['advanced'] = (array) $wws['advanced'];

									if(isset($wws['params']['font-family'])){
										$def_val['font-family'] = $wws['params']['font-family'];
									}

									if(isset($wws['params']['padding'])){
										$raw_pad = $wws['params']['padding'];
										if(!is_array($raw_pad)){
											$raw_pad = explode(' ', $raw_pad);
										}

										switch(count($raw_pad)){
											case 1:
												$raw_pad = array($raw_pad[0], $raw_pad[0], $raw_pad[0], $raw_pad[0]);
												break;
											case 2:
												$raw_pad = array($raw_pad[0], $raw_pad[1], $raw_pad[0], $raw_pad[1]);
												break;
											case 3:
												$raw_pad = array($raw_pad[0], $raw_pad[1], $raw_pad[2], $raw_pad[1]);
												break;
										}

										$def_val['padding'] = $raw_pad;
									}
									if(isset($wws['params']['font-style'])){
										$def_val['font-style'] = $wws['params']['font-style'];
									}

									if(isset($wws['params']['text-decoration'])){
										$def_val['text-decoration'] = $wws['params']['text-decoration'];
									}

									if(isset($wws['params']['background-color'])){
										if($this->is_rgb($wws['params']['background-color'])){
											$def_val['background-color'] = $this->rgba2hex($wws['params']['background-color']);
										}else{
											$def_val['background-color'] = $wws['params']['background-color'];
										}
									}
									if(isset($wws['params']['background-transparency'])){
										$def_val['background-transparency'] = $wws['params']['background-transparency'];
										if($def_val['background-transparency'] > 1){
											$def_val['background-transparency'] /= 100;
										}

									}else{
										if(isset($wws['params']['background-color'])){
											$def_val['background-transparency'] = $this->get_trans_from_rgba($wws['params']['background-color'], true);
										}

									}

									if(isset($wws['params']['border-color'])){
										if($this->is_rgb($wws['params']['border-color'])){
											$def_val['border-color'] = $this->rgba2hex($wws['params']['border-color']);
										}else{
											$def_val['border-color'] = $wws['params']['border-color'];
										}
									}

									if(isset($wws['params']['border-style'])){
										$def_val['border-style'] = $wws['params']['border-style'];
									}

									if(isset($wws['params']['border-width'])){
										$def_val['border-width'] = $wws['params']['border-width'];
									}

									if(isset($wws['params']['border-radius'])){
										$raw_bor = $wws['params']['border-radius'];
										if(!is_array($raw_bor)){
											$raw_bor = explode(' ', $raw_bor);
										}

										switch (count($raw_bor)){
										case 1:
											$raw_bor = array($raw_bor[0], $raw_bor[0], $raw_bor[0], $raw_bor[0]);
											break;
										case 2:
											$raw_bor = array($raw_bor[0], $raw_bor[1], $raw_bor[0], $raw_bor[1]);
											break;
										case 3:
											$raw_bor = array($raw_bor[0], $raw_bor[1], $raw_bor[2], $raw_bor[1]);
											break;
										}

										$def_val['border-radius'] = $raw_bor;
									}
									if(isset($wws['params']['x'])){
										$def_val['x'] = $wws['params']['x'];
									}

									if(isset($wws['params']['y'])){
										$def_val['y'] = $wws['params']['y'];
									}

									if(isset($wws['params']['z'])){
										$def_val['z'] = $wws['params']['z'];
									}

									if(isset($wws['params']['skewx'])){
										$def_val['skewx'] = $wws['params']['skewx'];
									}

									if(isset($wws['params']['skewy'])){
										$def_val['skewy'] = $wws['params']['skewy'];
									}

									if(isset($wws['params']['scalex'])){
										$def_val['scalex'] = $wws['params']['scalex'];
									}

									if(isset($wws['params']['scaley'])){
										$def_val['scaley'] = $wws['params']['scaley'];
									}

									if(isset($wws['params']['opacity'])){
										$def_val['opacity'] = $wws['params']['opacity'];
									}

									if(isset($wws['params']['xrotate'])){
										$def_val['xrotate'] = $wws['params']['xrotate'];
									}

									if(isset($wws['params']['yrotate'])){
										$def_val['yrotate'] = $wws['params']['yrotate'];
									}

									if(isset($wws['params']['2d_rotation'])){
										$def_val['2d_rotation'] = $wws['params']['2d_rotation'];
									}

									if(isset($wws['params']['2d_origin_x'])){
										$def_val['2d_origin_x'] = $wws['params']['2d_origin_x'];
									}

									if(isset($wws['params']['2d_origin_y'])){
										$def_val['2d_origin_y'] = $wws['params']['2d_origin_y'];
									}

									if(isset($wws['params']['pers'])){
										$def_val['pers'] = $wws['params']['pers'];
									}

									if(isset($wws['params']['color'])){
										$static_styles['color'] = ($this->is_rgb($wws['params']['color'])) ? $this->rgba2hex($wws['params']['color']) : $static_styles['color'] = $wws['params']['color'];
									}

									if(isset($wws['params']['font-weight'])){
										$static_styles['font-weight'] = $wws['params']['font-weight'];
									}

									if(isset($wws['params']['font-size'])){
										$static_styles['font-size'] = $wws['params']['font-size'];
									}

									if(isset($wws['params']['line-height'])){
										$static_styles['line-height'] = $wws['params']['line-height'];
									}

									if(isset($wws['params']['font-family'])){
										$static_styles['font-family'] = $wws['params']['font-family'];
									}

									if(isset($wws['advanced']) && isset($wws['advanced']['idle']) && is_array($wws['advanced']['idle']) && !empty($wws['advanced']['idle'])){
										$css_idle = '{'. "\n";
										foreach($wws['advanced']['idle'] as $handle => $value){
											$value = implode(' ', $value);
											if($value !== ''){
												$css_idle .= '	'. $key .': '. $value .';'. "\n";
											}

										}
										$css_idle .= '}'. "\n";
									}

									if(isset($wws['hover']['color'])){
										if($this->is_rgb($wws['hover']['color'])){
											$defh_val['color'] = $this->rgba2hex($wws['hover']['color']);
										}else{
											$defh_val['color'] = $wws['hover']['color'];
										}
									}
									if(isset($wws['hover']['text-decoration'])){
										$defh_val['text-decoration'] = $wws['hover']['text-decoration'];
									}

									if(isset($wws['hover']['background-color'])){
										if($this->is_rgb($wws['hover']['background-color'])){
											$defh_val['background-color'] = $this->rgba2hex($wws['hover']['background-color']);
										}else{
											$defh_val['background-color'] = $wws['hover']['background-color'];
										}
									}
									if(isset($wws['hover']['background-transparency'])){
										$defh_val['background-transparency'] = $wws['hover']['background-transparency'];
										if($defh_val['background-transparency'] > 1){
											$defh_val['background-transparency'] /= 100;
										}

									}else{
										if(isset($wws['hover']['background-color'])){
											$defh_val['background-transparency'] = $this->get_trans_from_rgba($wws['hover']['background-color'], true);
										}

									}
									if(isset($wws['hover']['border-color'])){
										if($this->is_rgb($wws['hover']['border-color'])){
											$defh_val['border-color'] = $this->rgba2hex($wws['hover']['border-color']);
										}else{
											$defh_val['border-color'] = $wws['hover']['border-color'];
										}
									}
									if(isset($wws['hover']['border-style'])){
										$defh_val['border-style'] = $wws['hover']['border-style'];
									}

									if(isset($wws['hover']['border-width'])){
										$defh_val['border-width'] = $wws['hover']['border-width'];
									}

									if(isset($wws['hover']['border-radius'])){
										$raw_bor = $wws['hover']['border-radius'];
										if(!is_array($raw_bor)){
											$raw_bor = explode(' ', $raw_bor);
										}

										switch (count($raw_bor)){
										case 1:
											$raw_bor = array($raw_bor[0], $raw_bor[0], $raw_bor[0], $raw_bor[0]);
											break;
										case 2:
											$raw_bor = array($raw_bor[0], $raw_bor[1], $raw_bor[0], $raw_bor[1]);
											break;
										case 3:
											$raw_bor = array($raw_bor[0], $raw_bor[1], $raw_bor[2], $raw_bor[1]);
											break;
										}

										$defh_val['border-radius'] = $raw_bor;
									}
									if(isset($wws['hover']['x'])){
										$defh_val['x'] = $wws['hover']['x'];
									}

									if(isset($wws['hover']['y'])){
										$defh_val['y'] = $wws['hover']['y'];
									}

									if(isset($wws['hover']['z'])){
										$defh_val['z'] = $wws['hover']['z'];
									}

									if(isset($wws['hover']['skewx'])){
										$defh_val['skewx'] = $wws['hover']['skewx'];
									}

									if(isset($wws['hover']['skewy'])){
										$defh_val['skewy'] = $wws['hover']['skewy'];
									}

									if(isset($wws['hover']['scalex'])){
										$defh_val['scalex'] = $wws['hover']['scalex'];
									}

									if(isset($wws['hover']['scaley'])){
										$defh_val['scaley'] = $wws['hover']['scaley'];
									}

									if(isset($wws['hover']['opacity'])){
										$defh_val['opacity'] = $wws['hover']['opacity'];
									}

									if(isset($wws['hover']['xrotate'])){
										$defh_val['xrotate'] = $wws['hover']['xrotate'];
									}

									if(isset($wws['hover']['yrotate'])){
										$defh_val['yrotate'] = $wws['hover']['yrotate'];
									}

									if(isset($wws['hover']['2d_rotation'])){
										$defh_val['2d_rotation'] = $wws['hover']['2d_rotation'];
									}

									if(isset($wws['hover']['2d_origin_x'])){
										$defh_val['2d_origin_x'] = $wws['hover']['2d_origin_x'];
									}

									if(isset($wws['hover']['2d_origin_y'])){
										$defh_val['2d_origin_y'] = $wws['hover']['2d_origin_y'];
									}

									if(isset($wws['hover']['speed'])){
										$defh_val['speed'] = $wws['hover']['speed'];
									}

									if(isset($wws['hover']['easing'])){
										$defh_val['easing'] = $wws['hover']['easing'];
									}

									if(isset($wws['advanced']) && isset($wws['advanced']['hover']) && is_array($wws['advanced']['hover']) && !empty($wws['advanced']['hover'])){
										$css_hover = '{'. "\n";
										foreach($wws['advanced']['hover'] as $handle => $value){
											$value = implode(' ', $value);
											if($value !== ''){
												$css_hover .= '	'. $key .': '. $value .';'. "\n";
											}

										}
										$css_hover .= '}'. "\n";

									}

									if(!isset($layers[$lk]['inline'])){
										$layers[$lk]['inline'] = array();
									}

									if($css_idle !== ''){
										$layers[$lk]['inline']['idle'] = $css_idle;
									}
									if($css_hover !== ''){
										$layers[$lk]['inline']['idle'] = $css_hover;
									}

									$layers[$lk]['deformation'] = $def_val;
									$layers[$lk]['deformation-hover'] = $defh_val;
									$layers[$lk]['static_styles'] = $static_styles;
								}
							}

							$slide->set_layers_raw($layers);
							$slide->save_layers();
						}
					}
				}
			}
		}
	}

	/**
	 * add settings to layer depending on how
	 * @since 5.0
	 */
	public function add_general_settings($sliders = false){
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();
		$sliders = ($sliders === false) ? $sr->get_sliders() : $sliders = array($sliders); //do it on all Sliders if false

		if(!empty($sliders) && is_array($sliders)){
			$fonts = get_option('tp-google-fonts', array());

			foreach($sliders as $slider){
				$settings = $slider->get_settings();
				$bg_freeze = $slider->get_param('parallax_bg_freeze', 'off');
				$google_fonts = $slider->get_param('google_font', array());

				if(!isset($settings['version']) || version_compare($settings['version'], 5.0, '<')){
					if(empty($google_fonts) && !empty($fonts)){
						//add all punchfonts to the Slider
						foreach($fonts as $font){
							$google_fonts[] = $font['url'];
						}
						$slider->update_params(array('google_font' => $google_fonts));
					}
					$settings['version'] = 5.0;
					$slider->update_settings(array('version' => 5.0));
				}

				if($bg_freeze == 'on'){
					//deprecated here, moved to slides so remove check here and add on to slides
					$slider->update_params(array('parallax_bg_freeze' => 'off'));
				}

				$slides = $slider->get_slides(false, true);
				$staticID = $sl->get_static_slide_id($slider->get_id());
				if($staticID !== false){
					$msl = new RevSliderSlide();
					if(strpos($staticID, 'static_') === false){
						$staticID = 'static_'. $staticID; //$slider->get_id();
					}
					$msl->init_by_id($staticID);
					if($msl->get_id() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}
				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						if($bg_freeze == 'on'){
							//set bg_freeze to on for slide settings
							$slide->set_param('slide_parallax_level', '1');
						}

						$slide->save_params();
					}
				}

			}
		}
	}

	/**
	 * remove static slide from Sliders if the setting was set to off
	 * @since 5.0
	 */
	public function remove_static_slides($sliders = false){
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();
		$sliders = ($sliders === false) ? $sr->get_sliders() : $sliders = array($sliders); //do it on all Sliders if false

		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$settings = $slider->get_settings();
				$enable_static_layers = $slider->get_param('enable_static_layers', 'off');

				if($enable_static_layers == 'off'){
					$staticID = $sl->get_static_slide_id($slider->get_id());
					if($staticID !== false){
						$slider->delete_static_slide();
					}
				}

			}
		}
	}

	/**
	 * change general settings of all sliders to 5.0.7
	 * @since 5.0.7
	 */
	public function change_general_settings_5_0_7($sliders = false){
		//handle the new option for shuffle in combination with first alternative slide
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();
		$sliders = ($sliders === false) ? $sr->get_sliders() : $sliders = array($sliders); //do it on all Sliders if false

		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$settings = $slider->get_settings();

				if(!isset($settings['version']) || version_compare($settings['version'], '5.0.7', '<')){
					$start_with_slide = $slider->get_param('start_with_slide', '1');

					if($start_with_slide !== '1'){
						$slider->update_params(array('start_with_slide_enable' => 'on'));
					}

					$settings['version'] = '5.0.7';
					$slider->update_settings(array('version' => '5.0.7'));
				}

			}
		}
	}

	/**
	 * change image id of all slides to 5.1.1
	 * @since 5.1.1
	 */
	public function change_slide_settings_5_1_1($sliders = false){
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();
		$sliders = ($sliders === false) ? $sr->get_sliders() : $sliders = array($sliders); //do it on all Sliders if false

		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$slides = $slider->get_slides(false, true);
				$staticID = $sl->get_static_slide_id($slider->get_id());
				if($staticID !== false){
					$msl = new RevSliderSlide();
					if(strpos($staticID, 'static_') === false){
						$staticID = 'static_'. $staticID; //$slider->get_id();
					}
					$msl->init_by_id($staticID);
					if($msl->get_id() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}

				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						//get image url, then get the image id and save it in image_id

						$image_id = $slide->get_param('image_id', '');
						$image = $slide->get_param('image', '');

						$ml_id = '';
						if($image !== ''){
							$ml_id = $this->get_image_id_by_url($image);
						}
						if($image == '' && $image_id == ''){
							continue;
						}
						//if we are a video and have no cover image, do nothing

						if($ml_id !== false && $ml_id !== $image_id){
							$urlImage = wp_get_attachment_image_src($ml_id, 'full');

							$slide->set_param('image_id', $ml_id);
							$slide->save_params();
						}

					}
				}

			}
		}
	}

	/**
	 * change svg path of all layers from the upload folder if 5.2.5.3+ was installed
	 * @since 5.2.5.5
	 */
	public function change_layers_svg_5_2_5_5($sliders = false){
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();
		$upload_dir = wp_upload_dir();
		$path = $upload_dir['baseurl'] .'/revslider/assets/svg/';

		if($sliders === false){
			//do it on all Sliders
			$sliders = $sr->get_sliders();
		}else{
			$sliders = array($sliders);
		}

		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$slides = $slider->get_slides(false, true);

				$staticID = $sl->get_static_slide_id($slider->get_id());
				if($staticID !== false){
					$msl = new RevSliderSlide();
					if(strpos($staticID, 'static_') === false){
						$staticID = 'static_'. $staticID; //$slider->get_id();
					}
					$msl->init_by_id($staticID);
					if($msl->get_id() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}

				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						$layers = $slide->get_layers();
						if(!empty($layers) && is_array($layers)){
							foreach($layers as $lk => $layer){
								if(isset($layer['type']) && $layer['type'] == 'svg'){
									if(isset($layer['svg']) && isset($layer['svg']->src)){
										//change newer path to older path
										if(strpos($layers[$lk]['svg']->src, $path) !== false){
											$layers[$lk]['svg']->src = str_replace($path, RS_PLUGIN_URL .'public/assets/assets/svg/', $layers[$lk]['svg']->src);
										}
									}
								}
							}

							$slide->set_layers_raw($layers);
							$slide->save_layers();
						}
					}
				}
			}
		}
	}

	/**
	 * Change Slider Settings to version 6.0
	 * @since 6.0
	 */
	public function change_slider_settings_to_6_0($sliders = false){
		$sr = new RevSliderSlider();
		$color_picker = new RSColorpicker();
		
		$sliders = ($sliders === false) ? $sr->get_sliders() : array($sliders); //do it on all Sliders if false

		if(!empty($sliders) && is_array($sliders)){
			$nav = new RevSliderNavigation();
			$navigations = $nav->get_all_navigations_builder();

			foreach($sliders as $slider){
				$ms = array();
				$amountparams = 0;
				foreach($slider as $_slider){
					$amountparams++;
					if($amountparams > 5) break; //5 is enough
				}

				if(version_compare($slider->get_setting('version', '1.0.0'), '6.0.0', '<')){
					/* SLIDER BASICS */
					//$ms['alias']		= $slider->get_param('alias');
					$ms['id']			= $slider->get_param('slider_id');
					$ms['shortcode']	= $slider->get_param('shortcode', '');
					$ms['layouttype']	= $slider->get_param('slider_type', 'fullwidth');
					$ms['type']			= $slider->get_param('slider-type', 'standard');
					$ms['sourcetype']	= (in_array($slider->get_param('source_type'), array('post', 'posts', 'specific_posts', 'current_post'))) ? 'post' : $slider->get_param('source_type', 'gallery');
					$ms['sourcetype']	= ($ms['sourcetype'] == 'woocommerce') ? 'woo' : $ms['sourcetype'];
					
					//$ms['title']		= $slider->get_param('title');
					$ms['googleFont']	= $slider->get_param('google_font', array());
					
					$postSubType = (in_array($slider->get_param('source_type'), array('post', 'posts', 'specific_posts', 'current_post'))) ? $slider->get_param('source_type', false) : 'post';
					$postSubType = ($postSubType == 'posts') ? 'post' : $postSubType;
					
					/* ADD ON MIGRATIONS */
					$ms['addOns'] = $this->migrate_slider_AddOn($slider);

					if($amountparams > 5){
						$sldmh = $slider->get_param('min_height');
						$sldh = $slider->get_param('height', 900);
						$sldh = ($sldmh > $sldh) ? $sldmh : $sldh;
						
						$min_height = ($ms['layouttype'] === 'fullscreen') ? $slider->get_param('fullscreen_min_height') : $sldmh;
						$min_height = ($ms['layouttype'] === 'fullwidth' && $sldmh !== '') ? $sldh : $min_height;
						
						/* SLIDER SOURCE */
						$ms['source'] = array(
							'gallery' => array(),
							'post' => array(
								'excerptLimit' => $slider->get_param('excerpt_limit', 55),
								'maxPosts' => $slider->get_param('max_slider_posts', 30),
								'fetchType' => $slider->get_param('fetch_type', 'cat_tag'),
								'category' => $slider->get_param('post_category', ''),
								'sortBy' => $slider->get_param('post_sortby', 'ID'),
								'types' => $slider->get_param('post_types', 'post'),
								'list' => $slider->get_param('posts_list', ''),
								'sortDirection' => $slider->get_param('posts_sort_direction', 'DESC'),
								'subType' => ($postSubType === false) ? 'post' : $postSubType,
							),
							'woo' => array(
								'excerptLimit' => $slider->get_param('excerpt_limit_product', 55),
								'maxProducts' => $slider->get_param('max_slider_products', 30),
								'featuredOnly' => $this->_truefalse($slider->get_param('featured_only', false)),
								'inStockOnly' => $this->_truefalse($slider->get_param('instock_only', false)),
								'category' => $slider->get_param('product_category', ''),
								'sortBy' => $slider->get_param('product_sortby', 'ID'),
								'types' => $slider->get_param('product_types', 'product'),
								'sortDirection' => $slider->get_param('product_sort_direction', 'DESC'),
								'regPriceFrom' => $slider->get_param('reg_price_from', ''),
								'regPriceTo' => $slider->get_param('reg_price_to', ''),
								'salePriceFrom' => $slider->get_param('sale_price_from', ''),
								'salePriceTo' => $slider->get_param('sale_price_to', ''),
							),
							'instagram' => array(
								'count' => $slider->get_param('instagram-count', ''),
								'hashTag' => $slider->get_param('instagram-hash-tag', ''),
								'transient' => $slider->get_param('instagram-transient', 1200),
								'type' => $slider->get_param('instagram-type', 'user'),
								'userId' => $slider->get_param('instagram-user-id', ''),
							),
							'facebook' => array(
								'album' => $slider->get_param('facebook-album', ''),
								'appId' => $slider->get_param('facebook-app-id', ''),
								'appSecret' => $slider->get_param('facebook-app-secret', ''),
								'count' => $slider->get_param('facebook-count', ''),
								'transient' => $slider->get_param('facebook-transient', 1200),
								'typeSource' => $slider->get_param('facebook-type-source', 'album'),
							),
							'flickr' => array(
								'apiKey' => $slider->get_param('flickr-api-key', ''),
								'count' => $slider->get_param('flickr-count', ''),
								'galleryURL' => $slider->get_param('flickr-gallery-url', ''),
								'groupURL' => $slider->get_param('flickr-group-url', ''),
								'photoSet' => $slider->get_param('flickr-photoset', ''),
								'transient' => $slider->get_param('flickr-transient', 1200),
								'type' => $slider->get_param('flickr-type', 'publicphotos'),
								'userURL' => $slider->get_param('flickr-user-url', ''),
							),
							'twitter' => array(
								'accessSecret' => $slider->get_param('twitter-access-secret', ''),
								'accessToken' => $slider->get_param('twitter-access-token', ''),
								'consumerKey' => $slider->get_param('twitter-consumer-key', ''),
								'consumerSecret' => $slider->get_param('twitter-consumer-secret', ''),
								'count' => $slider->get_param('twitter-count', ''),
								'excludeReplies' => $this->_truefalse($slider->get_param('twitter-exclude-replies', false)),
								'imageOnly' => $this->_truefalse($slider->get_param('twitter-image-only', false)),
								'includeRetweets' => $this->_truefalse($slider->get_param('twitter-include-retweets', false)),
								'transient' => $slider->get_param('twitter-transient', 1200),
								'userId' => $slider->get_param('twitter-user-id', ''),
							),
							'vimeo' => array(
								'albumId' => $slider->get_param('vimeo-albumid', ''),
								'channelName' => $slider->get_param('vimeo-channelname', ''),
								'count' => $slider->get_param('vimeo-count', ''),
								'transient' => $slider->get_param('vimeo-transient', 1200),
								'groupName' => $slider->get_param('vimeo-groupname', ''),
								'typeSource' => $slider->get_param('vimeo-type-source', 'user'),
								'userName' => $slider->get_param('vimeo-username', ''),
							),
							'youtube' => array(
								'api' => $slider->get_param('youtube-api', ''),
								'channelId' => $slider->get_param('youtube-channel-id', ''),
								'count' => $slider->get_param('youtube-count', ''),
								'playList' => $slider->get_param('youtube-playlist', ''),
								'transient' => $slider->get_param('youtube-transient', 1200),
								'typeSource' => $slider->get_param('youtube-type-source', 'channel'),
							)
						);

						/* SLIDER DEFAULTS */
						$ms['def'] = array(
							'transition' => $slider->get_param('def-slide_transition', 'fade'),
							'transitionDuration' => $slider->get_param('def-transition_duration', 1000),
							'delay' => $slider->get_param('delay', 9000),
							'background' => array(
								'fit' => $slider->get_param('def-background_fit', 'cover'),
								'fitX' => $slider->get_param('def-bg_fit_x', 100),
								'fitY' => $slider->get_param('def-bg_fit_y', 100),
								'position' => $slider->get_param('def-bg_position', 'center center'),
								'positionX' => $slider->get_param('def-bg_position_x', 0),
								'positionY' => $slider->get_param('def-bg_position_y', 0),
								'repeat' => $slider->get_param('def-bg_repeat', 'no-repeat'),
								'imageSourceType' => $slider->get_param('def-image_source_type', 'full'),
							),
							'panZoom' => array(
								'set' => $this->_truefalse($slider->get_param('def-kenburn_effect', false)),
								'blurStart' => $slider->get_param('def-kb_blur_start', 0),
								'blurEnd' => $slider->get_param('def-kb_blur_end', 0),
								'duration' => $slider->get_param('def-kb_duration'. 10000),
								'ease' => $slider->get_param('def-kb_easing', 'none'),
								'fitEnd' => $slider->get_param('def-kb_end_fit', 100),
								'fitStart' => $slider->get_param('def-kb_start_fit', 100),
								'xEnd' => $slider->get_param('def-kb_end_offset_x', 0),
								'yEnd' => $slider->get_param('def-kb_end_offset_y', 0),
								'xStart' => $slider->get_param('def-kb_start_offset_x', 0),
								'yStart' => $slider->get_param('def-kb_start_offset_y', 0),
								'rotateStart' => $slider->get_param('def-kb_start_rotate', 0),
								'rotateEnd' => $slider->get_param('def-kb_end_rotate', 0),
							)
						);

						/* SLIDER SIZE */
						$ms['size'] = array(
							'respectAspectRatio' => $this->_truefalse($slider->get_param('auto_height', false)),
							'disableForceFullWidth' => $this->_truefalse($slider->get_param('autowidth_force', false)),
							'gridEQModule' => $this->_truefalse($slider->get_param('full_screen_align_force', false)),
							'custom' => array(
								'd' => true,
								'n' => $this->_truefalse($slider->get_param('enable_custom_size_notebook', false)),
								't' => $this->_truefalse($slider->get_param('enable_custom_size_tablet', false)),
								'm' => $this->_truefalse($slider->get_param('enable_custom_size_iphone', false)),
							),
							'minHeightFullScreen' => $slider->get_param('fullscreen_min_height', ''),
							'minHeight' => $min_height,
							'fullScreenOffsetContainer' => $slider->get_param('fullscreen_offset_container', ''),
							'fullScreenOffset' => $slider->get_param('fullscreen_offset_size', ''),
							'width' => array(
								'd' => intval($slider->get_param('width', 1240)),
								'n' => intval($slider->get_param('width_notebook', 1024)),
								't' => intval($slider->get_param('width_tablet', 778)),
								'm' => intval($slider->get_param('width_mobile', 480)),
							),
							'height' => array(
								'd' => intval($slider->get_param('height', 900)),
								'n' => intval($slider->get_param('height_notebook', 768)),
								't' => intval($slider->get_param('height_tablet', 960)),
								'm' => intval($slider->get_param('height_mobile', 720)),
							),
							'overflow' => $this->_truefalse($slider->get_param('main_overflow_hidden', false)),
							'maxWidth' => $slider->get_param('max_width', '')/*,
							'maxHeight' => $min_height*/
						);

						/* SLIDER CODES */
						$ms['codes'] = array(
							'css' => stripslashes(
								str_replace(
									array(
										'.tp-caption',
										'.tp-static-layers',
										'.tp-parallax-wrap',
										'.rev_column_bg',
										'.tp-revslider-slidesli',
										'active-revslide'
									),
									array(
										'.rs-layer',
										'rs-static-layers',
										'.rs-parallax-wrap',
										'rs-column-bg',
										'rs-slide',
										'active-rs-slide'
									),
									$slider->get_param('custom_css', '')
								)
							),
							'javascript' => stripslashes(
								str_replace(
									array(
										'.tp-caption',
										'.tp-static-layers',
										'.tp-parallax-wrap',
										'.rev_column_bg',
										'.tp-revslider-slidesli',
										'active-revslide'
									),
									array(
										'.rs-layer',
										'rs-static-layers',
										'.rs-parallax-wrap',
										'rs-column-bg',
										'rs-slide',
										'active-rs-slide'
									),
									$slider->get_param('custom_javascript', '')
								)
							),
						);

						/* CAROUSEL SETTINGS */
						$ms['carousel'] = array(
							'borderRadius' => $slider->get_param('carousel_borderr', 0),
							'borderRadiusUnit' => $slider->get_param('carousel_borderr_unit', 'px'),
							'ease' => $slider->get_param('carousel_easing', 'power3.inOut'),
							'fadeOut' => $this->_truefalse($slider->get_param('carousel_fadeout', true)),
							'scale' => $this->_truefalse($slider->get_param('carousel_scale', false)),
							'horizontal' => $slider->get_param('carousel_hposition', 'center'),
							'vertical' => $slider->get_param('carousel_vposition', 'center'),
							'infinity' => $this->_truefalse($slider->get_param('carousel_infinity', false)),
							'maxItems' => $slider->get_param('carousel_maxitems', 3),
							'maxRotation' => $slider->get_param('carousel_maxrotation', 0),
							'paddingTop' => $slider->get_param('carousel_padding_top', 0),
							'paddingBottom' => $slider->get_param('carousel_padding_bottom', 0),
							'rotation' => $this->_truefalse($slider->get_param('carousel_rotation', 0)),
							'scaleDown' => $slider->get_param('carousel_scaledown', 50),
							'space' => $slider->get_param('carousel_space', 0),
							'speed' => $slider->get_param('carousel_speed', 800),
							'stretch' => $this->_truefalse($slider->get_param('carousel_stretch', false)),
							'varyFade' => $this->_truefalse($slider->get_param('carousel_varyfade', false)),
							'varyRotate' => $this->_truefalse($slider->get_param('carousel_varyrotate', false)),
							'varyScale' => $this->_truefalse($slider->get_param('carousel_varyscale', false)),
							'showAllLayers' => $this->_truefalse($slider->get_param('showalllayers_carousel', false)),
						);

						/* HERO SETTINGS */
						$ms['hero'] = array(
							'activeSlide' => $slider->get_param('hero_active', -1),
						);

						/* SLIDER LAYOUT  - BG, LOADER, POSITION */
						$ms['layout'] = array(
							'bg' => array(
								'color' => $color_picker->correctValue($slider->get_param('background_color', 'transparent')),
								'padding' => $slider->get_param('padding', 0),
								'dottedOverlay' => $slider->get_param('background_dotted_overlay', 'none'),
								'shadow' => $slider->get_param('shadow_type', 0),
								'useImage' => $this->_truefalse($slider->get_param('show_background_image', false)),
								'image' => $slider->get_param('background_image', ''),
								'fit' => $slider->get_param('bg_fit', 'cover'),
								'position' => $slider->get_param('bg_position', 'center center'),
								'repeat' => $slider->get_param('bg_repeat', 'no-repeat'),
							),
							'spinner' => array(
								'color' => $slider->get_param('spinner_color', '#ffffff'),
								'type' => $slider->get_param('use_spinner', '5'),
							),
							'position' => array(
								'marginTop' => $slider->get_param('margin_top', 0),
								'marginBottom' => $slider->get_param('margin_bottom', 0),
								'marginLeft' => $slider->get_param('margin_left', 0),
								'marginRight' => $slider->get_param('margin_right', 0),
								'align' => $slider->get_param('position', 'center'),
							),
						);

						/* SLIDER VISIBILITY */
						$ms['visibility'] = array(
							'hideSelectedLayersUnderLimit' => $slider->get_param('hide_defined_layers_under', 0),
							'hideAllLayersUnderLimit' => $slider->get_param('hide_all_layers_under', 0),
							'hideSliderUnderLimit' => $slider->get_param('hide_slider_under', 0),
						);
						
						/* GENERAL SETTINGS */
						
						// added for progress bar color conversions
						$pbcolor = $slider->get_param('progressbar_color', '#FFFFFF');
						$pbopac = $slider->get_param('progress_opa', false);
						
						// see comment in ColorPicker class for new "correctValue" function
						$pbcolor = $color_picker->correctValue($pbcolor, $pbopac);
						
						$ms['general'] = array(
							'slideshow' => array(
								'stopOnHover' => $this->_truefalse($slider->get_param('stop_on_hover', false)),
								'stopSlider' => $this->_truefalse($slider->get_param('stop_slider', false)),
								'stopAfterLoops' => $slider->get_param('stop_after_loops', 0),
								'stopAtSlide' => $slider->get_param('stop_at_slide', 1),
								'shuffle' => $this->_truefalse($slider->get_param('shuffle', false)),
								'loopSingle' => $this->_truefalse($slider->get_param('loop_slide', false)),
								'viewPort' => $this->_truefalse($slider->get_param('label_viewport', false)),
								'viewPortStart' => $slider->get_param('viewport_start', 'wait'),
								'viewPortArea' => (100-intval($slider->get_param('viewport_area', 60)))."%",
								'presetSliderHeight' => $this->_truefalse($slider->get_param('label_presetheight', false)),
								'initDelay' => $slider->get_param('start_js_after_delay', 0),
								'waitForInit' => $this->_truefalse($slider->get_param('waitforinit', false)),
								'slideShow' => true
							),
							'progressbar' => array(
								'set' => $this->_truefalse($slider->get_param('enable_progressbar', true)),
								'height' => $slider->get_param('progress_height', 5),
								'position' => $slider->get_param('show_timerbar', 'bottom'),
								'color' => $pbcolor,
							),
							'firstSlide' => array(
								'set' => $this->_truefalse($slider->get_param('first_transition_active', false)),
								'duration' => $slider->get_param('first_transition_duration', 300),
								'slotAmount' => $slider->get_param('first_transition_slot_amount', 7),
								'type' => $slider->get_param('first_transition_type', 'fade'),
								'alternativeFirstSlideSet' => $this->_truefalse($slider->get_param('start_with_slide_enable', false)),
								'alternativeFirstSlide' => $slider->get_param('start_with_slide', 1),
							),
							'layerSelection' => $this->_truefalse($slider->get_param('def-layer_selection', false)),
							'lazyLoad' => $slider->get_param('lazy_load_type', 'none'),
							'nextSlideOnFocus' => $this->_truefalse($slider->get_param('next_slide_on_window_focus', false)),
							'disableFocusListener' => $this->_truefalse($slider->get_param('disable_focus_listener', false)),
							'disableOnMobile' => $this->_truefalse($slider->get_param('disable_on_mobile', false)),
							'autoPlayVideoOnMobile' => $this->_truefalse($slider->get_param('allow_android_html5_autoplay', true)),
							'disablePanZoomMobile' => $this->_truefalse($slider->get_param('disable_kenburns_on_mobile', false)),
							'useWPML' => $this->_truefalse($slider->get_param('use_wpml', false)),
						);

						if($ms['general']['lazyLoad'] === false){
							$ms['general']['lazyLoad'] = ($slider->get_param('lazy_load', false) == 'on') ? 'all' : 'none';
						}

						/* CHANGE HANDLE OF NAVIGATIONS TO THEIR IDS */
						$slider_navigations = array(
							'arrows' => $slider->get_param('navigation_arrow_style'),
							'thumbs' => $slider->get_param('thumbnails_style'),
							'tabs' => $slider->get_param('tabs_style'),
							'bullets' => $slider->get_param('navigation_bullets_style'),
						);

						foreach($slider_navigations as $nt => $sn){
							if($sn == ''){
								continue;
							}

							foreach($navigations[$nt] as $csnid => $csn){
								if($csn['handle'] == $sn){
									$slider_navigations[$nt] = $csnid;
									break;
								}
							}
						}
						
						
						$twc = $slider->get_param('thumbnails_wrapper_color', 'transparent');
						$two = $slider->get_param('thumbnails_wrapper_opacity', false);
						
						// see comment in ColorPicker class for new "correctValue" function
						$thumbWrapperColor = $color_picker->correctValue($twc, $two);
						
						$tawc = $slider->get_param('tabs_wrapper_color', 'transparent');
						$tawo = $slider->get_param('tabs_wrapper_opacity', false);
						
						// see comment in ColorPicker class for new "correctValue" function
						$tabsWrapperColor = $color_picker->correctValue($tawc, $tawo);
						
						/**
						 * switch these four values around, as they are the opposite in v6
						 **/
						$aao = $this->_truefalse($slider->get_param('arrows_always_on', true));
						$thao = $this->_truefalse($slider->get_param('thumbs_always_on', true));
						$taao = $this->_truefalse($slider->get_param('tabs_always_on', true));
						$bao = $this->_truefalse($slider->get_param('bullets_always_on', true));
						$aao = ($aao === true) ? false : true;
						$thao = ($thao === true) ? false : true;
						$taao = ($taao === true) ? false : true;
						$bao = ($bao === true) ? false : true;
						
						/* SLIDER NAVIGATION */
						$ms['nav'] = array(
							'preview' => array(
								'width' => $slider->get_param('previewimage_width', 100),
								'height' => $slider->get_param('previewimage_height', 50),
							),
							'swipe' => array(
								'set' => $this->_truefalse($slider->get_param('touchenabled', false)),
								'setOnDesktop' => $this->_truefalse($slider->get_param('touchenabled_desktop', false)),
								'blockDragVertical' => $this->_truefalse($slider->get_param('drag_block_vertical', false)),
								'direction' => $slider->get_param('swipe_direction', 'horizontal'),
								'minTouch' => $slider->get_param('swipe_min_touches', 1),
								'velocity' => $slider->get_param('swipe_velocity', 75),
							),
							'keyboard' => array(
								'set' => $this->_truefalse($slider->get_param('keyboard_navigation', false)),
								'direction' => $slider->get_param('keyboard_direction', 'horizontal'),
							),
							'mouse' => array(
								'set' => $this->_truefalse($slider->get_param('mousescroll_navigation', false)),
								'reverse' => $slider->get_param('mousescroll_navigation_reverse', 'default'),
							),
							'arrows' => array(
								'set' => $this->_truefalse($slider->get_param('enable_arrows', false)),
								'rtl' => $this->_truefalse($slider->get_param('rtl_arrows', false)),
								'style' => $this->get_val($slider_navigations, 'arrows', 'new-bullet-bar'),
								'preset' => $slider->get_param('navigation_arrows_preset', 'default'),
								'presets' => new stdClass(),
								'alwaysOn' => $aao,
								'hideDelay' => $slider->get_param('hide_arrows', 200),
								'hideDelayMobile' => $slider->get_param('hide_arrows_mobile', 1200),
								'hideOver' => $this->_truefalse($slider->get_param('hide_arrows_over', false)),
								'hideOverLimit' => $slider->get_param('arrows_over_hidden', 0),
								'hideUnder' => $this->_truefalse($slider->get_param('hide_arrows_on_mobile', false)),
								'hideUnderLimit' => $slider->get_param('arrows_under_hidden', 778),
								'left' => array(
									'horizontal' => $slider->get_param('leftarrow_align_hor', 'left'),
									'vertical' => $slider->get_param('leftarrow_align_vert', 'center'),
									'offsetX' => $slider->get_param('leftarrow_offset_hor', 30),
									'offsetY' => $slider->get_param('leftarrow_offset_vert', 0),
									'align' => $slider->get_param('leftarrow_position', 'slider'),
								),
								'right' => array(
									'horizontal' => $slider->get_param('rightarrow_align_hor', 'left'),
									'vertical' => $slider->get_param('rightarrow_align_vert', 'center'),
									'offsetX' => $slider->get_param('rightarrow_offset_hor', 30),
									'offsetY' => $slider->get_param('rightarrow_offset_vert', 0),
									'align' => $slider->get_param('rightarrow_position', 'slider'),
								),
							),
							'thumbs' => array(
								'set' => $this->_truefalse($slider->get_param('enable_thumbnails', false)),
								'rtl' => $this->_truefalse($slider->get_param('rtl_thumbnails', false)),
								'style' => $this->get_val($slider_navigations, 'thumbs', 'new-bullet-bar'),
								'preset' => $slider->get_param('navigation_thumbs_preset', 'default'),
								'presets' => new stdClass(),
								'alwaysOn' => $thao,
								'hideDelay' => $slider->get_param('hide_thumbs', 200),
								'hideDelayMobile' => $slider->get_param('hide_thumbs_mobile', 1200),
								'hideOver' => $this->_truefalse($slider->get_param('hide_thumbs_over', false)),
								'hideOverLimit' => $slider->get_param('thumbs_over_hidden', 0),
								'hideUnder' => $this->_truefalse($slider->get_param('hide_thumbs_on_mobile', false)),
								'hideUnderLimit' => $slider->get_param('thumbs_under_hidden', 778),
								'spanWrapper' => $this->_truefalse($slider->get_param('span_thumbnails_wrapper', false)),
								'horizontal' => $slider->get_param('thumbnails_align_hor', 'center'),
								'vertical' => $slider->get_param('thumbnails_align_vert', 'bottom'),
								'amount' => $slider->get_param('thumb_amount', 5),
								'direction' => $slider->get_param('thumbnail_direction', 'horizontal'),
								'height' => $slider->get_param('thumb_height', 50),
								'width' => $slider->get_param('thumb_width', 100),
								'widthMin' => $slider->get_param('thumb_width_min', 100),
								'innerOuter' => $slider->get_param('thumbnails_inner_outer', 'inner'),
								'offsetX' => $slider->get_param('thumbnails_offset_hor', 0),
								'offsetY' => $slider->get_param('thumbnails_offset_vert', 20),
								'space' => $slider->get_param('thumbnails_space', 5),
								'align' => $slider->get_param('thumbnails_position', 'slider'),
								'padding' => $slider->get_param('thumbnails_padding', 5),
								'wrapperColor' => $thumbWrapperColor //$slider->get_param('thumbnails_wrapper_color', 'transparent'),
							),
							'tabs' => array(
								'set' => $this->_truefalse($slider->get_param('enable_tabs', false)),
								'rtl' => $this->_truefalse($slider->get_param('rtl_tabs', false)),
								'style' => $this->get_val($slider_navigations, 'tabs', 'round'),
								'preset' => $slider->get_param('navigation_tabs_preset', 'default'),
								'presets' => new stdClass(),
								'alwaysOn' => $taao,
								'hideDelay' => $slider->get_param('hide_tabs', 200),
								'hideDelayMobile' => $slider->get_param('hide_tabs_mobile', 1200),
								'hideOver' => $this->_truefalse($slider->get_param('hide_tabs_over', false)),
								'hideOverLimit' => $slider->get_param('tabs_over_hidden', 0),
								'hideUnder' => $this->_truefalse($slider->get_param('hide_tabs_on_mobile', false)),
								'hideUnderLimit' => $slider->get_param('tabs_under_hidden', 778),
								'spanWrapper' => $this->_truefalse($slider->get_param('span_tabs_wrapper', false)),
								'horizontal' => $slider->get_param('tabs_align_hor', 'center'),
								'vertical' => $slider->get_param('tabs_align_vert', 'bottom'),
								'amount' => $slider->get_param('tabs_amount', 5),
								'direction' => $slider->get_param('tabs_direction', 'horizontal'),
								'height' => $slider->get_param('tabs_height', 50),
								'width' => $slider->get_param('tabs_width', 100),
								'widthMin' => $slider->get_param('tabs_width_min', 100),
								'innerOuter' => $slider->get_param('tabs_inner_outer', 'inner'),
								'offsetX' => $slider->get_param('tabs_offset_hor', 0),
								'offsetY' => $slider->get_param('tabs_offset_vert', 20),
								'space' => $slider->get_param('tabs_space', 5),
								'align' => $slider->get_param('tabs_position', 'slider'),
								'padding' => $slider->get_param('tabs_padding', 5),
								'wrapperColor' => $tabsWrapperColor //$slider->get_param('tabs_wrapper_color', 'transparent'),
							),
							'bullets' => array(
								'set' => $this->_truefalse($slider->get_param('enable_bullets'), false),
								'rtl' => $this->_truefalse($slider->get_param('rtl_bullets'), false),
								'style' => $this->get_val($slider_navigations, 'bullets', 'round'),
								'preset' => $slider->get_param('navigation_bullets_preset', 'default'),
								'presets' => new stdClass(),
								'alwaysOn' => $bao,
								'horizontal' => $slider->get_param('bullets_align_hor', 'center'),
								'vertical' => $slider->get_param('bullets_align_vert', 'bottom'),
								'direction' => $slider->get_param('bullets_direction', 'horizontal'),
								'offsetX' => $slider->get_param('bullets_offset_hor', 0),
								'offsetY' => $slider->get_param('bullets_offset_vert', 20),
								'align' => $slider->get_param('bullets_position', 'slider'),
								'space' => $slider->get_param('bullets_space', 5),
								'hideDelay' => $slider->get_param('hide_bullets', 200),
								'hideDelayMobile' => $slider->get_param('hide_bullets_mobile', 1200),
								'hideOver' => $this->_truefalse($slider->get_param('hide_bullets_over', false)),
								'hideOverLimit' => $slider->get_param('bullets_over_hidden', 0),
								'hideUnder' => $this->_truefalse($slider->get_param('hide_bullets_on_mobile', false)),
								'hideUnderLimit' => $slider->get_param('bullets_under_hidden', 778),
							),
						);
						
						$thumbs_io = $this->get_val($ms, array('nav', 'thumbs', 'innerOuter'), 'inner');
						if(in_array($thumbs_io, array('outer-left', 'outer-right'))){
							$ms['nav']['thumbs']['innerOuter'] = 'outer-vertical';
							$ms['nav']['thumbs']['horizontal'] = ($thumbs_io === 'outer-left') ? 'left' : 'right';
						}elseif(in_array($thumbs_io, array('outer-top', 'outer-bottom'))){
							$ms['nav']['thumbs']['innerOuter'] = 'outer-horizontal';
							$ms['nav']['thumbs']['vertical'] = ($thumbs_io === 'outer-top') ? 'top' : 'bottom';
						}
						$tabs_io = $this->get_val($ms, array('nav', 'tabs', 'innerOuter'), 'inner');
						if(in_array($tabs_io, array('outer-left', 'outer-right'))){
							$ms['nav']['tabs']['innerOuter'] = 'outer-vertical';
							$ms['nav']['tabs']['horizontal'] = ($tabs_io === 'outer-left') ? 'left' : 'right';
						}elseif(in_array($tabs_io, array('outer-top', 'outer-bottom'))){
							$ms['nav']['tabs']['innerOuter'] = 'outer-horizontal';
							$ms['nav']['tabs']['vertical'] = ($tabs_io === 'outer-top') ? 'top' : 'bottom';
						}
						
						/* TROUBLESHOOTING & FALLBACKS */
						$ms['troubleshooting'] = array(
							'ignoreHeightChanges' => $this->_truefalse($slider->get_param('ignore_height_changes')),
							'ignoreHeightChangesUnderLimit' => $slider->get_param('ignore_height_changes_px', 0),
							'alternateImageType' => $slider->get_param('show_alternative_type'),
							'alternateURL' => $slider->get_param('show_alternate_image'),
							'alternateURLId' => $this->get_image_id_by_url($slider->get_param('show_alternate_image')),
							'jsNoConflict' => $this->_truefalse($slider->get_param('jquery_noconflict')),
							'jsInBody' => $this->_truefalse($slider->get_param('js_to_body')),
							'outPutFilter' => $slider->get_param('output_type'),
							'debugMode' => $this->_truefalse($slider->get_param('jquery_debugmode')),
							'simplify_ie8_ios4' => $this->_truefalse($slider->get_param('simplify_ie8_ios4')),
						);

						/* PARALLAX SETTINGS */
						$ms['parallax'] = array(
							'set' => $this->_truefalse($slider->get_param('use_parallax', false)),
							'setDDD' => $this->_truefalse($slider->get_param('ddd_parallax', false)),
							'disableOnMobile' => $this->_truefalse($slider->get_param('disable_parallax_mobile', false)),
							'levels' => array(
								$slider->get_param('parallax_level_1', 5),
								$slider->get_param('parallax_level_2', 10),
								$slider->get_param('parallax_level_3', 15),
								$slider->get_param('parallax_level_4', 20),
								$slider->get_param('parallax_level_5', 25),
								$slider->get_param('parallax_level_6', 30),
								$slider->get_param('parallax_level_7', 35),
								$slider->get_param('parallax_level_8', 40),
								$slider->get_param('parallax_level_9', 45),
								$slider->get_param('parallax_level_10', 46),
								$slider->get_param('parallax_level_11', 47),
								$slider->get_param('parallax_level_12', 48),
								$slider->get_param('parallax_level_13', 49),
								$slider->get_param('parallax_level_14', 50),
								$slider->get_param('parallax_level_15', 51),
								$slider->get_param('parallax_level_16', 30),
							),
							'ddd' => array(
								'BGFreeze' => $this->_truefalse($slider->get_param('ddd_parallax_bgfreeze', false)),
								'layerOverflow' => $this->_truefalse($slider->get_param('ddd_parallax_layer_overflow', false)),
								'overflow' => $this->_truefalse($slider->get_param('ddd_parallax_overflow', false)),
								'shadow' => $this->_truefalse($slider->get_param('ddd_parallax_shadow', false)),
								'zCorrection' => $slider->get_param('ddd_parallax_zcorrection', 65),
							),
							'mouse' => array(
								'speed' => $slider->get_param('parallax_speed', 1000),
								'bgSpeed' => $slider->get_param('parallax_bg_speed', 0),
								'layersSpeed' => $slider->get_param('parallax_ls_speed', 0),
								'origo' => $slider->get_param('parallax_origo', 'slideCenter'),
								'type' => $slider->get_param('parallax_type', 'scroll'),
							),
						);

						$ms['parallax']['mouse']['type'] = ($ms['parallax']['mouse']['type'] === 'mouse+scroll') ? 'mousescroll' : $ms['parallax']['mouse']['type'];

						/* SCROLLEFFECTS */
						$ms['scrolleffects'] = array(
							'set' => ($this->_truefalse($slider->get_param('blur_scrolleffect', false)) === true || $this->_truefalse($slider->get_param('fade_scrolleffect', false)) === true || $this->_truefalse($slider->get_param('grayscale_scrolleffect', false)) === true) ? true : false,
							'setBlur' => $this->_truefalse($slider->get_param('blur_scrolleffect', false)),
							'setFade' => $this->_truefalse($slider->get_param('fade_scrolleffect', false)),
							'setGrayScale' => $this->_truefalse($slider->get_param('grayscale_scrolleffect', false)),
							'bg' => $this->_truefalse($slider->get_param('scrolleffect_bg', false)),
							'direction' => $slider->get_param('scrolleffect_direction', 'both'),
							'maxBlur' => $slider->get_param('scrolleffect_maxblur', 10),
							'multiplicator' => $slider->get_param('scrolleffect_multiplicator', '1.35'),
							'multiplicatorLayers' => $slider->get_param('scrolleffect_multiplicator_layers', '1.3'),
							'disableOnMobile' => $this->_truefalse($slider->get_param('scrolleffect_off_mobile', false)),
							'tilt' => $slider->get_param('scrolleffect_tilt', '30')
						);
						
						if($ms['scrolleffects']['set'] === true && $ms['type'] === 'hero'){ //existed only for hero Slider
							/**
							 * if on_layers == true && on_static_layers == false && on_parallax_layers == false && on_parallax_static_layers == false
							 * then slider.scrolleffect.layers = false
							 * then set all layer that are not static or parallax effects.effect = true
							 **/
							$this->on_layers = $this->_truefalse($slider->get_param('scrolleffect_layers', false));
							/**
							 * if on_layers == false && on_static_layers == true && on_parallax_layers == false && on_parallax_static_layers == false
							 * then slider.scrolleffect.layers = false
							 * then set all static layer that are not parallax effects.effect = true
							 **/
							$this->on_static_layers = $this->_truefalse($slider->get_param('scrolleffect_static_layers', false));
							/**
							 * if on_layers == false && on_static_layers == false && on_parallax_layers == true && on_parallax_static_layers == false
							 * then slider.scrolleffect.layers = false
							 * then set all layer that are not static and that are parallax effects.effect = true
							 **/
							$this->on_parallax_layers = $this->_truefalse($slider->get_param('scrolleffect_parallax_layers', false));
							/**
							 * if on_layers == false && on_static_layers == false && on_parallax_layers == false && on_parallax_static_layers == true
							 * then slider.scrolleffect.layers = false
							 * then set all layer that are static and parallax effects.effect = true
							 **/
							$this->on_parallax_static_layers = $this->_truefalse($slider->get_param('scrolleffect_static_parallax_layers', false));
						}else{
							$this->on_layers = false;
							$this->on_static_layers = false;
							$this->on_parallax_layers = false;
							$this->on_parallax_static_layers = false;
						}
						
						$this->on_counter = 0;
						
						if($this->on_layers === true) $this->on_counter++;
						if($this->on_static_layers === true) $this->on_counter++;
						if($this->on_parallax_layers === true) $this->on_counter++;
						if($this->on_parallax_static_layers === true) $this->on_counter++;
						
						/**
						 * if more than one is active, change the behavior by
						 * set slider.scrolleffect.layers = true
						 * set layers effects.effect = true on layers that are NOT meeting the requirements
						 **/
						$ms['scrolleffects']['layers'] = ($this->on_counter >= 2) ? true : false;
						
						//set this value so that on the layers this can be used to track if we are a parallax layer
						$this->parallax_slider = $this->_truefalse($slider->get_param('use_parallax', false));
						
						/* COLLECT CUSTOM SETTINGS FOR NAVIGATION FROM OLDER VERSION */
						$params = $slider->get_params();
						$_presets = $this->transform_preset_to_6_0_0($params, 'def');
						if(!empty($_presets)){
							foreach($_presets as $_pkey => $_preset){
								if(!empty($_preset)){
									$ms['nav'][$_pkey]['presets'] = (!isset($ms['nav'][$_pkey]['presets'])) ? new stdClass() : $ms['nav'][$_pkey]['presets'];
									foreach($_preset as $_pk => $_pv){
										$ms['nav'][$_pkey]['presets']->$_pk = $_pv;
									}
								}
							}
						}
						
						if($ms['general']['slideshow']['stopAfterLoops'] == 0 && $ms['general']['slideshow']['stopAtSlide'] == 1 && $ms['general']['slideshow']['stopSlider'] = false){
							$ms['general']['slideshow']['slideShow'] = false;
						}
						
					} // END OF MAX AMOUNT OF PARAMS

				}else{
					$ms = $slider->get_params();
				}
				$slider->update_params($ms, true);
				$slider->update_settings(array('version' => '6.0.0'));
			}
		}
	}

	/**
	 * Update the handle from ph-NAME-HANDLE-slide/def to new shorter version
	 * @since 6.0
	 * @end: slide if slide, def if slider handle
	 */
	public function transform_preset_to_6_0_0($params, $end = 'slide'){
		$types	= array('arrows', 'bullets', 'tabs', 'thumbs');
		$preset	= array('arrows' => array(), 'bullets' => array(), 'tabs' => array(), 'thumbs' => array());
		$repl	= array('color-rgba', 'custom', 'color', 'font_family'); //old existing types
		
		if(!empty($params)){
			foreach($params as $k => $v){
				if(strpos($k, 'ph-') !== 0) continue; //check if we start with 'ph-'
				foreach($types as $type){
					if(strpos($k, '-'.$type.'-') === false) continue; //check if we are -arrows- ect

					$f = false;
					$new_k = '';
					foreach($repl as $r){ //check if we end with -slide or -def
						$l = strlen('-'.$r.'-'.$end) * -1;
						if(substr($k, $l) === '-'.$r.'-'.$end){
							$f = true;
							$new_k = substr($k, 0, $l);
							break;
						} 
					}
					if($f === false) continue;

					if($this->_truefalse($v) !== true) continue; //it is set to true, so search for the counterpart
					
					//okay all passed, now check the value of the corresponding value field
					$search = substr($k, 0, strlen('-'.$end) * -1);
					$value = $this->get_val($params, $search, '');
					
					$t = explode('-'.$type.'-', $new_k);
					$handle = end($t);
					$preset[$type][$handle.'-def'] = true; //always set to -def here, -slide does not exist in 6.0.0
					$preset[$type][$handle] = $value;
				}
			}
		}
		return $preset;
	}
	
	/**
	 * Change Slide Settings to version 6.0
	 * @since 6.0
	 */
	public function change_slide_settings_to_6_0($sliders = false){
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();
		$sliders = ($sliders === false) ? $sr->get_sliders() : array($sliders); //do it on all Sliders if false

		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$slides = $slider->get_slides(false, true);

				$static_id = $sl->get_static_slide_id($slider->get_id());
				if($static_id !== false){
					$msl = new RevSliderSlide();
					if(strpos($static_id, 'static_') === false){
						$static_id = 'static_'. $static_id; //$slider->get_id();
					}
					$msl->init_by_id($static_id);
					if($msl->get_id() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}

				$slide_nr = 1;
				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						$settings = $slide->get_settings();
						$ms = array();

						if(version_compare($this->get_val($settings, 'version', '1.0.0'), '6.0.0', '<')){
							$ms = $this->migrate_slide_to_6_0($slide, $slider, $slide_nr);
							
							$ms = $this->_simplify_slides($ms);

							$slide->settings['version'] = '6.0.0';

							$slide->set_params($ms);
							$slide->save_settings();
							$slide->save_params();
						}
					}
				}
			}
		}
	}

	
	/**
	 * Change Slide Settings to version 6.0
	 * @since 6.0
	 */
	public function migrate_slide_to_6_0($slide, $slider = false, $slide_nr = false){
		if($slider === false) $slider = new RevSliderSlider();
		$color_picker = new RSColorpicker();
		$ms = array();

		$ms['addOns'] = $this->migrate_slide_AddOn($slide, $slider, $slide_nr);

		$ms['static'] = array(
			'isstatic' => $this->_truefalse($slide->get_param('static', false)),
			'overflow' => $slide->get_param('staticoverflow', 'hidden'),
			'position' => $slide->get_param('staticlayersposition', 'front'),
		);
		$ms['title'] = $slide->get_param('title', 'New Slide');
		$ms['child'] = array(
			'parentId' => $slide->get_param('parentid', ''),
			'language' => $slide->get_param('lang', ''),
		);

		//CHECK FOR STREAMS
		$streambothcover = $this->_truefalse($slide->get_param('stream_do_cover_both'));
		$streamcover	 = $this->_truefalse($slide->get_param('stream_do_cover'));
		$streamboth		 = (in_array($slide->get_param('background_type'), array('streamyoutubeboth', 'streamvimeoboth', 'streaminstagramboth', 'streamtwitterboth'))) ? true : false;
		$streamonlyvideo = (in_array($slide->get_param('background_type'), array('streamtwitter', 'streamyoutube', 'streamvimeo', 'streaminstagram'))) ? true : false;
		$streamimage	 = ($slide->get_param('background_type') === 'image' && $slider->get_param('sourcetype') !== 'gallery') ? true : false; //was 'settings', 'sourcetype'
		$streamanyvideo	 = (in_array($slide->get_param('background_type'), array('streamyoutubeboth', 'streamvimeoboth', 'streaminstagramboth', 'streamtwitterboth', 'streamtwitter', 'streamyoutube', 'streamvimeo', 'streaminstagram'))) ? true : false;

		if(strpos($slide->get_param('background_type'), 'youtube') !== false){
			$type = 'youtube';
		}elseif(strpos($slide->get_param('background_type'), 'vimeo') !== false){
			$type = 'vimeo';
		}elseif(strpos($slide->get_param('background_type'), 'instagram') !== false){
			$type = 'html5';
		}elseif(strpos($slide->get_param('background_type'), 'twitter') !== false){
			$type = 'html5';
		}else{
			$type = $slide->get_param('background_type', 'trans');
		}
		
		$img_url = $slide->get_param('image', '');
		$img_id = $slide->get_param('image_id', '');
		if(!empty($img_id)){
			$new_img_url = $this->get_url_attachment_image($img_id);
			if(!empty($new_img_url)){
				$img_url = $new_img_url;
			}
		}
		
		$ms['bg'] = array(
			'type'			=> $type,
			'color'			=> $color_picker->correctValue($slide->get_param('slide_bg_color', '#ffffff')),
			'externalSrc'	=> $slide->get_param('slide_bg_external', ''),
			'fit'			=> $slide->get_param('bg_fit', 'cover'),
			'fitX'			=> $slide->get_param('bg_fit_x', '100'),
			'fitY'			=> $slide->get_param('bg_fit_y', '100'),
			'position'		=> $slide->get_param('bg_position', 'center center'),
			'positionX'		=> $slide->get_param('bg_position_x', '0'),
			'positionY'		=> $slide->get_param('bg_position_y', '0'),
			'repeat'		=> $slide->get_param('bg_repeat', 'no-repeat'),
			'image'			=> $img_url,
			//'imageId'		=> $slide->get_param('image_id', ''),
			'imageFromStream' => ($streamboth == true || $streamimage == true) ? true : false,
			'imageSourceType' => $slide->get_param('image_source_type', 'full'),
			'galleryType'	=> $slide->get_param('rs-gallery-type', 'gallery'),
			'mpeg'			=> $slide->get_param('slide_bg_html_mpeg', ''),
			'ogv'			=> $slide->get_param('slide_bg_html_ogv', ''),
			'webm'			=> $slide->get_param('slide_bg_html_webm', ''),
			'vimeo'			=> $slide->get_param('slide_bg_vimeo', ''),
			'youtube'		=> $slide->get_param('slide_bg_youtube', ''),
			'mediaFilter'	=> $slide->get_param('media-filter-type', 'none'),
			//'width'		=> $slide->get_param('ext_width'),
			//'height'		=> $slide->get_param('ext_height'),
			'video'			=> array(
				'args'			 => $slide->get_param('video_arguments', ''),
				'argsVimeo'		 => $slide->get_param('video_arguments_vim', ''),
				'dottedOverlay'	 => $slide->get_param('video_dotted_overlay', 'none'),
				'startAt'		 => $slide->get_param('video_start_at', ''),
				'endAt'			 => $slide->get_param('video_end_at', ''),				
				'forceRewind'	 => $this->_truefalse($slide->get_param('video_force_rewind', true)),
				'loop'			 => $slide->get_param('video_loop', 'none'),
				'mute'			 => $this->_truefalse($slide->get_param('video_mute', true)),
				'nextSlideAtEnd' => $this->_truefalse($slide->get_param('video_nextslide', false)),
				'ratio'			 => $slide->get_param('video_ratio', '16:9'),
				'speed'			 => $slide->get_param('video_speed', 1),
				'volume'		 => $slide->get_param('video_volume', 0)
			),
			'videoId' => '',
			'videoFromStream' => $streamanyvideo,
		);

		$stream = false;
		//turn the image to the new stream path if it is
		if(strpos($ms['bg']['image'], '/ig.png') !== false){
			$ms['bg']['image'] = str_replace('/ig.png', '/instagram.png', $ms['bg']['image']);
			$stream = true;
		}
		if(strpos($ms['bg']['image'], '/fb.png') !== false){
			$ms['bg']['image'] = str_replace('/fb.png', '/facebook.png', $ms['bg']['image']);
			$stream = true;
		}
		if(strpos($ms['bg']['image'], '/fr.png') !== false){
			$ms['bg']['image'] = str_replace('/fr.png', '/flickr.png', $ms['bg']['image']);
			$stream = true;
		}
		if(strpos($ms['bg']['image'], '/tw.png') !== false){
			$ms['bg']['image'] = str_replace('/tw.png', '/twitter.png', $ms['bg']['image']);
			$stream = true;
		}
		if(strpos($ms['bg']['image'], '/vm.png') !== false){
			$ms['bg']['image'] = str_replace('/vm.png', '/vimeo.png', $ms['bg']['image']);
			$stream = true;
		}
		if(strpos($ms['bg']['image'], '/wc.png') !== false){
			$ms['bg']['image'] = str_replace('/wc.png', '/woo.png', $ms['bg']['image']);
			$stream = true;
		}
		if(strpos($ms['bg']['image'], '/yt.png') !== false){
			$ms['bg']['image'] = str_replace('/yt.png', '/youtube.png', $ms['bg']['image']);
			$stream = true;
		}
		
		$bg_image = ($this->_truefalse($slide->get_param('thumb_for_admin')) === true) ? $this->get_val($ms, array('bg', 'image')) : $slide->get_param('slide_thumb', $this->get_val($ms, array('bg', 'image')));
		$bg_image = ($stream === true) ? '' : $bg_image;

		$ms['thumb'] = array(
			'customThumbSrc' => $bg_image,
			'customThumbSrcId' => ($this->get_val($ms, array('thumb', 'customThumbSrc'), '') !== '') ? $this->get_image_id_by_url($this->get_val($ms, array('thumb', 'customThumbSrc'), '')) : '',
			'customAdminThumbSrc' => ($this->_truefalse($slide->get_param('thumb_for_admin')) === true) ? $slide->get_param('slide_thumb') : '',
			'customAdminThumbSrcId' => ($this->get_val($ms, array('thumb', 'customAdminThumbSrc'), '') !== '') ? $this->get_image_id_by_url($this->get_val($ms, array('thumb', 'customAdminThumbSrc'), '')) : '',
			'dimension' => $slide->get_param('thumb_dimension', 'orig'),
		);
		
		//only do if we are not a stream!
		if(!in_array($slider->get_param('sourcetype'), array('youtube', 'vimeo', 'instagram', 'twitter', 'facebook', 'flickr'), true)){
			if($this->get_val($ms, array('thumb', 'customThumbSrc'), '') == ''){
				if($this->get_val($ms, array('thumb', 'customAdminThumbSrc'), '') !== ''){
					$this->set_val($ms, array('thumb', 'customThumbSrc'), $this->get_val($ms, array('thumb', 'customAdminThumbSrc'), ''));
					$this->set_val($ms, array('thumb', 'customThumbSrcId'), $this->get_val($ms, array('thumb', 'customAdminThumbSrcId'), ''));
				}
			}
		}
		
		$ms['info'] = array(
			'params' => array(
				array(
					'v' => $slide->get_param('params_1'),
					'l' => $slide->get_param('params_1_chars', 10),
				),
				array(
					'v' => $slide->get_param('params_2'),
					'l' => $slide->get_param('params_2_chars', 10),
				),
				array(
					'v' => $slide->get_param('params_3'),
					'l' => $slide->get_param('params_3_chars', 10),
				),
				array(
					'v' => $slide->get_param('params_4'),
					'l' => $slide->get_param('params_4_chars', 10),
				),
				array(
					'v' => $slide->get_param('params_5'),
					'l' => $slide->get_param('params_5_chars', 10),
				),
				array(
					'v' => $slide->get_param('params_6'),
					'l' => $slide->get_param('params_6_chars', 10),
				),
				array(
					'v' => $slide->get_param('params_7'),
					'l' => $slide->get_param('params_7_chars', 10),
				),
				array(
					'v' => $slide->get_param('params_8'),
					'l' => $slide->get_param('params_8_chars', 10),
				),
				array(
					'v' => $slide->get_param('params_9'),
					'l' => $slide->get_param('params_9_chars', 10),
				),
				array(
					'v' => $slide->get_param('params_10'),
					'l' => $slide->get_param('params_10_chars', 10),
				),
			),
			'description' => $slide->get_param('slide_description', ''),
		);
		
		$ms['attributes'] = array(
			'alt'			=> $slide->get_param('alt_attr', ''),
			'altOption'		=> $slide->get_param('alt_option', 'media_library'),
			'title'			=> $slide->get_param('title_attr', ''),
			'titleOption'	=> 'media_library',
			'attr'			=> '',
			'class'			=> $slide->get_param('class_attr', ''),
			'data'			=> $slide->get_param('data_attr', ''),
			'id'			=> $slide->get_param('id_attr', ''),
		);
		
		$ms['publish'] = array(
			'from'	=> $slide->get_param('date_from', ''),
			'to'	=> $slide->get_param('date_to', ''),
			'state'	=> $slide->get_param('state', 'published'),
		);

		$slide_transition = $slide->get_param('slide_transition', array('fade'));
		$add_transition = $this->get_val($this->add_to_transition_speed, $slide_transition, false);
		
		$duration = $slide->get_param('transition_duration', array(1000));
		if($add_transition !== false){
			if(!empty($duration)){
				if(is_array($duration)){
					foreach($duration as $dk => $dv){
						$dv = str_replace('ms', '', $dv);
						$duration[$dk] = (!in_array($dv, array('random', 'default'), true)) ? $dv + $add_transition : $dv;
					}
				}else{
					$duration = str_replace('ms', '', $duration);
					$duration = (!in_array($duration, array('random', 'default'), true)) ? $duration + $add_transition : $duration;
				}
			}
		}
		
		$ms['timeline'] = array(
			'stopOnPurpose'	=> $this->_truefalse($slide->get_param('stoponpurpose', false)),
			'delay'			=> ($slide->get_param('delay') === 0 || $slide->get_param('delay') === '0') ? 'Default' : $slide->get_param('delay', 'Default'),
			'transition'	=> $slide_transition,
			'slots'			=> $slide->get_param('slot_amount', array(0)),
			'duration'		=> $duration,
			'easeIn'		=> $slide->get_param('transition_ease_in', array('default')),
			'easeOut'		=> $slide->get_param('transition_ease_out', array('default')),
			'rotation'		=> $slide->get_param('transition_rotation', array(0)),
		);
		
		/**
		 * fix for [{0:'a',1:'b'}] structures that can occur
		 **/
		$t_keys = array('duration', 'easeIn', 'easeOut', 'rotation', 'slots', 'transition');
		foreach($t_keys as $tk){
			$ms['timeline'][$tk] = (!is_array($ms['timeline'][$tk])) ? (array)$ms['timeline'][$tk] : $ms['timeline'][$tk];
			$tlc = $this->get_val($ms, array('timeline', $tk, 0), '');
			if(is_object($tlc) || is_array($tlc)){
				$a = array();
				if(!empty($ms['timeline'][$tk][0])){
					foreach($ms['timeline'][$tk][0] as $tkv){
						$a[] = $tkv;
					}
				}
				$ms['timeline'][$tk] = $a;
			}
		}
		
		$ms['visibility'] = array(
			'hideAfterLoop'		 => $slide->get_param('hideslideafter', 0),
			'hideOnMobile'		 => $this->_truefalse($slide->get_param('hideslideonmobile', false)),
			'hideFromNavigation' => $this->_truefalse($slide->get_param('invisibleslide', false)),
		);

		$ms['effects'] = array(
			'parallax' => $slide->get_param('slide_parallax_level', '-'),
		);
		$ms['panzoom'] = array(
			'set'		 => $this->_truefalse($slide->get_param('kenburn_effect', false)),
			'blurStart'	 => $slide->get_param('kb_blur_start', 0),
			'blurEnd'	 => $slide->get_param('kb_blur_end', 0),
			'duration'	 => $slide->get_param('kb_duration', 10000),
			'ease'		 => $slide->get_param('kb_easing', 'none'),
			'fitEnd'	 => $slide->get_param('kb_end_fit', 100),
			'fitStart'	 => $slide->get_param('kb_start_fit', 100),
			'xEnd'		 => $slide->get_param('kb_end_offset_x', 0),
			'yEnd'		 => $slide->get_param('kb_end_offset_y', 0),
			'xStart'	 => $slide->get_param('kb_start_offset_x', 0),
			'yStart'	 => $slide->get_param('kb_start_offset_y', 0),
			'rotateStart'=> $slide->get_param('kb_start_rotate', 0),
			'rotateEnd'	 => $slide->get_param('kb_end_rotate', 0),
		);
		// SLICEY OVERWRITE PAN ZOOM  (KRIKI)
		if($slider->get_param('slicey_globals', false) !== false){
			$slicey = json_decode($slider->get_param('slicey_globals'), true);
			if(empty($slicey)){
				$slicey = json_decode(str_replace('\\', '', $slider->get_param('slicey_globals')), true);
			}
			$ms['panzoom']['blurStart']	= $this->get_val($slicey, 'blurgstart', $this->get_val($ms, array('panzoom', 'blurStart'), 0));
			$ms['panzoom']['blurEnd']	= $this->get_val($slicey, 'blurgend', $this->get_val($ms, array('panzoom', 'blurEnd'), 0));
			$ms['panzoom']['fitEnd']	= $this->get_val($slicey, 'scale', $this->get_val($ms, array('panzoom', 'fitEnd')));
			$ms['panzoom']['duration']	= $this->get_val($slicey, 'time', $this->get_val($ms, array('panzoom', 'duration')));
			$ms['panzoom']['ease']		= $this->get_val($slicey, 'easing', $this->get_val($ms, array('panzoom', 'ease'), 'none'));
		}
		
		$target = $slide->get_param('link_open_in', '_self');
		$target = ($target === 'same') ? '_self' : $target;
		$target = ($target === 'new') ? '_blank' : $target;
		
		$ms['seo'] = array(
			'set'		=> $this->_truefalse($slide->get_param('enable_link', false)),
			'link'		=> $slide->get_param('link', ''),
			'slideLink'	=> $slide->get_param('slide_link', 'nothing'),
			'target'	=> $target,
			'z'			=> $slide->get_param('link_pos', 'front'),
			'type'		=> $slide->get_param('link_type', 'regular'),
		);
		$ms['nav'] = array(
			'arrows'	=> array(),
			'thumbs'	=> array(),
			'tabs'		=> array(),
			'bullets'	=> array(),
		);
		foreach($ms['nav'] as $k => $v){
			$ms['nav'][$k]['presets'] = new stdClass();
		}

		/* COLLECT CUSTOM SETTINGS FOR NAVIGATION FROM OLDER VERSION */
		$params = $slide->get_params();
		$_presets = $this->transform_preset_to_6_0_0($params, 'slide');
		if(!empty($_presets)){
			foreach($_presets as $_pkey => $_preset){
				if(!empty($_preset)){
					$ms['nav'][$_pkey]['presets'] = (!isset($ms['nav'][$_pkey]['presets'])) ? new stdClass() : $ms['nav'][$_pkey]['presets'];
					foreach($_preset as $_pk => $_pv){
						$ms['nav'][$_pkey]['presets']->$_pk = $_pv;
					}
				}
			}
		}
		
		return $ms;
	}


	/**
	 * Change Layer Settings to version 6.0
	 * @since 6.0
	 */
	public function change_layer_settings_to_6_0($sliders = false){
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();

		if($sliders === false){
			//do it on all Sliders
			$sliders = $sr->get_sliders();
		}else{
			$sliders = array($sliders);
		}
		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$slides = $slider->get_slides(false, true);
				$staticID = $sl->get_static_slide_id($slider->get_id());
				if($staticID !== false){
					$msl = new RevSliderSlide();
					if(strpos($staticID, 'static_') === false){
						$staticID = 'static_'. $staticID; //$slider->get_id();
					}
					$msl->init_by_id($staticID);
					if($msl->get_id() !== ''){
						//$slides = array_merge($slides, array($msl));
						$slides[] = $msl;
					}
				}
				
				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						$layers = $slide->get_layers();
						
						$this->static_slide = $slide->is_static_slide();
						
						$new_layers = array();
						if(!empty($layers) && is_array($layers)){
							$this->z_index = 5; //reset the zindex
							$lid = 99;
							foreach($layers as $lk => $layer){
								$ml = array();
								$version = $this->get_val($layer, 'version', '1.0.0');
								if(strpos($version, '.') === false){
									//was before 530 for example
									$version = '1.0.0';
								}
								if(version_compare($version, '6.0.0', '<')){
									$ml = $this->migrate_layer_to_6_0($layer, false, $slide, $slider);
								}else{
									$ml = $layer;
								}
								
								$ml = $this->_simplify_layers($ml, $slide, $slider);
								
								$uid = $this->get_val($ml, 'uid', $lid);
								if(isset($new_layers[$uid])){
									$uid = $lid;
									$this->set_val($ml, 'uid', $lid);
								}
								$new_layers[$uid] = $ml;
								$lid++;
								$this->z_index++;
							}
							
							//act_triggered
							/**
							 * go again through all layers
							 * check if a layer is triggered by other layers
							 * if no, set actionTriggered to false
							 **/
							if(!empty($new_layers)){
								foreach($new_layers as $nlk => $nlv){
									//($act_triggered === 'wait' || $act_triggered === 'waitout') ? true : 
									
									$nluid = $this->get_val($nlv, 'uid');
									$nluid = ($this->static_slide) ? 'static-'.$nluid : $nluid;
									
									if(in_array((string)$nluid, $this->slide_action_map, true)){
										$a_o = $this->get_val($nlv, array('actions', 'animationoverwrite'), 'default');
										
										if($a_o === 'wait'){
											$this->set_val($new_layers, array($nlk, 'timeline', 'frames', 'frame_1', 'timeline', 'actionTriggered'), true);
										}
										if(in_array($a_o, array('wait', 'waitout'), true)){
											$this->set_val($new_layers, array($nlk, 'timeline', 'frames', 'frame_999', 'timeline', 'actionTriggered'), true);
										}
									}
								}
							}
							
							$slide->set_layers_raw($new_layers);
							$slide->save_layers();
						}
					}
				}
			}
		}
	}
	
	
	/**
	 * Migrates a Layer to version 6.0.0
	 * @since: 6.0.0
	 **/
	public function migrate_layer_to_6_0($layer, $blank, $slide, $slider){ //blank default should be false!

		$this->init_googlefonts();
		$color_picker		= new RSColorpicker();
		
		$video_data			= $this->get_val($layer, 'video_data', array());
		$deformation		= (array)$this->get_val($layer, 'deformation', array());
		$deformation_hover	= (array)$this->get_val($layer, 'deformation-hover', array());
		$static_styles		= (array)$this->get_val($layer, 'static_styles', array());
		$layer_action		= $this->get_val($layer, 'layer_action', array());
		$svg				= $this->get_val($layer, 'svg', array());
		$frames				= $this->get_val($layer, 'frames', array());
		$frame_0			= $this->get_val($frames, 'frame_0', array());
		$frame_999			= $this->get_val($frames, 'frame_999', array());
		
		$ml['type']			= $this->get_val($layer, 'type'); //text, image, video, audio, svg, shape
		$ml['subtype']		= $this->get_val($layer, 'subtype', '');
		
		//need to replace weather AddOn tag format so moved this line here
		$ml['addOns']		= $this->migrate_layer_AddOn($layer, $slide);
		$ml['text']			= $this->get_val($layer, 'text', 'New layer');
		$toggleText			= $this->get_val($layer, 'texttoggle', '');
		
		//fix for margin-top issues in pe7 icons. In v5 the margin was needed.
		if(strpos($ml['text'], '<i class="pe-7s') !== false){ 
			$ml['text'] = str_replace(array('margin-top:-6px;', 'margin-top: -6px;'), '', $ml['text']);
		}
		if(strpos($toggleText, '<i class="pe-7s') !== false){ 
			$toggleText = str_replace(array('margin-top:-6px;', 'margin-top: -6px;'), '', $toggleText);
		}
		
		//REPLACE ALL FA-ICON- to FA-
		$ml['text']			= str_replace('fa-icon-', 'fa-', $ml['text']);
		$toggleText			= str_replace('fa-icon-', 'fa-', $toggleText);
		
		//REPLACE ALL META THAT ARE WITH %..% to {{..}}
		foreach($this->_metas as $r){
			if(strpos($r, '/%') !== false){
				$arrMatches = array();
				preg_match_all($r, $ml['text'], $arrMatches);

				if(!empty($arrMatches)){
					foreach($arrMatches as $matched){
						foreach($matched as $match){
							$_match = str_replace('%', '', '{{'.$match.'}}');
							$ml['text'] = str_replace($match, $_match, $ml['text']);
						}
					}
				}
				
				$arrMatches = array();
				preg_match_all($r, $toggleText, $arrMatches);

				if(!empty($arrMatches)){
					foreach($arrMatches as $matched){
						foreach($matched as $match){
							$_match = str_replace('%', '', '{{'.$match.'}}');
							$toggleText = str_replace($match, $_match, $toggleText);
						}
					}
				}
			}else{
				$ml['text'] = str_replace('%'.$r.'%', '{{'.$r.'}}', $ml['text']);
				$toggleText = str_replace('%'.$r.'%', '{{'.$r.'}}', $toggleText);
			}
		}
		
		$ml['placeholder']	= '';
		$ml['alias']		= ucfirst($this->get_val($layer, 'alias', 'New Layer'));
		$ml['uid']			= $this->get_val($layer, 'unique_id');
		$ml['version']		= '6.0.0';
		$ml['htmltag']		= $this->get_val($layer, 'html_tag', 'div');
		
		switch($ml['type']){
			case 'text':
			case 'button':
				$img_id = $this->get_image_id_by_url($this->get_val($layer, 'bgimage_url'));
				if($img_id === false) $img_id = '';
				$ml['media'] = array(
					'imageUrl' => $this->get_val($layer, 'bgimage_url', RS_PLUGIN_URL.'admin/assets/images/transparent_placeholder.png'),
					//'imageId' => $img_id,
					'imageFromStream' => false,
					'loaded' => false
				);
			break;
			case 'image':
				$img_id = $this->get_image_id_by_url($this->get_val($layer, 'image_url'));
				if($img_id === false) $img_id = '';
				$ml['media'] = array(
					'imageUrl' => $this->get_val($layer, 'image_url', RS_PLUGIN_URL.'admin/assets/images/transparent_placeholder.png'),
					'imageId' => $img_id,
					'imageFromStream' => false,
					'loaded' => false
				);
			break;
			case 'audio':
			case 'video':
				if($this->get_val($video_data, 'video_type') === 'html5'){
					$posterUrl = $this->get_val($video_data, 'urlPoster');
				}else{
					if($this->get_val($video_data, 'previewimage', false) === false || strlen($this->get_val($video_data, 'previewimage')) < 3){
						$posterUrl = '';
						//$posterUrl = $this->get_val($layer, 'video_image_url');
					}else{
						$posterUrl = $this->get_val($video_data, 'previewimage');
					}
				}

				$autoplayonlyfirsttime = ($this->_truefalse($this->get_val($video_data, 'autoplayonlyfirsttime')) == true) ? '1sttime' : 'true';				
				
				$ml['media'] = array(
					'mediaType' => $this->get_val($video_data, 'video_type'),
					'audioUrl' => $this->get_val($video_data, 'urlAudio', ''),
					'audioTitle' => $this->get_val($video_data, 'audio_title', ''),
					'posterUrl' => $posterUrl,
					'posterId' => '',
					'posterFromStream' => false,
					'thumbs' => array(
						'veryBig' => $this->get_val($video_data, 'thumb_very_big', array('width' => 640, 'height' => 480, 'url' => $posterUrl)),
						'big' => $this->get_val($video_data, 'thumb_big', array('width' => 640, 'height' => 480, 'url' => $posterUrl)),
						'large' => $this->get_val($video_data, 'thumb_large', array('width' => 640, 'height' => 360, 'url' => $posterUrl)),
						'medium' => $this->get_val($video_data, 'thumb_medium', array('width' => 320, 'height' => 240, 'url' => $posterUrl)),
						'small' => $this->get_val($video_data, 'thumb_small', array('width' => 200, 'height' => 150, 'url' => $posterUrl)),
					),
					'descSmall' => $this->get_val($video_data, 'desc_small', ''),
					'description' => $this->get_val($video_data, 'description', ''),
					'link' => $this->get_val($video_data, 'link', ''),
					'mp4Url' => $this->get_val($video_data, 'urlMp4', ''),
					'ogvUrl' => $this->get_val($video_data, 'urlOgv', ''),
					'webmUrl' => $this->get_val($video_data, 'urlWebm', ''),
					'allowFullscreen' => $this->_truefalse($this->get_val($video_data, 'allowfullscreen', false)),
					'args' => $this->get_val($video_data, 'args', $this->get_val($layer, 'video_args', '')),
					'author' => $this->get_val($video_data, 'author', ''),
					//'autoPlay' => $this->get_val($video_data, 'autoplay', $this->get_val($video_data, 'video_autoplay'), $autoplayonlyfirsttime),
					'autoPlay' => $this->get_val($video_data, 'autoplay', $this->get_val($video_data, 'video_autoplay', $autoplayonlyfirsttime)),
					'controls' => ($this->get_val($video_data, 'video_show_visibility') === true && $this->get_val($video_data, 'video_type') === 'audio') ? false : !$this->get_val($video_data, 'controls'),
					'cover' => $this->_truefalse($this->get_val($video_data, 'cover', false)),
					'disableOnMobile' => $this->_truefalse($this->get_val($video_data, 'use_poster_on_mobile', false)),
					'dotted' => $this->get_val($video_data, 'dotted', 'none'),
					'startAt' => $this->get_val($video_data, 'start_at', '00:00'),
					'endAt' => $this->get_val($video_data, 'end_at', '00:00'),
					'forceRewind' => $this->_truefalse($this->get_val($video_data, 'forcerewind', true)),
					'fullWidth' => $this->_truefalse($this->get_val($video_data, 'fullwidth', false)),
					'id' => $this->get_val($video_data, 'id', $this->get_val($layer, 'video_id', '')),
					'videoFromStream' => false,
					'largeControls' => $this->_truefalse($this->get_val($video_data, 'large_controls', true)),
					'leaveOnPause' => $this->_truefalse($this->get_val($video_data, 'leave_on_pause', true)),
					'mute' => $this->_truefalse($this->get_val($video_data, 'mute', true)),
					'nextSlideAtEnd' => $this->_truefalse($this->get_val($video_data, 'nextslide', true)),
					'preload' => $this->get_val($video_data, 'preload', 'auto'),
					'preloadAudio' => $this->get_val($video_data, 'preload_audio', 'metadata'),
					'preloadWait' => $this->get_val($video_data, 'preload_wait', '0'),
					'ratio' => $this->get_val($video_data, 'ratio', '16:9'),
					'posterOnPause' => $this->_truefalse($this->get_val($video_data, 'show_cover_pause', false)),
					'posterOnMobile' => $this->_truefalse($this->get_val($video_data, 'disable_on_mobile', false)),
					'stopAllVideo' => $this->_truefalse($this->get_val($video_data, 'stopallvideo', true)),
					'playInline' => $this->_truefalse($this->get_val($video_data, 'video_play_inline', true)),
					'hideAudio' => true,
					'speed' => $this->get_val($video_data, 'videospeed', 1),
					'loop' => $this->get_val($video_data, 'videoloop', 'loopandnoslidestop'),
					'volume' => $this->get_val($video_data, 'volume', '100'),
				);
				
			break;
			case 'svg':
			case 'object':
				$ml['svg'] = array(
					'source' => $this->get_val($svg, 'src', ''),
					'renderedData' => $this->get_val($svg, 'renderedData', ''),
				);
			break;
		}

		if($this->get_val($layer, 'type') === 'video'){
			if($this->get_val($video_data, 'fullwidth')){
				$layer['cover_mode'] = 'cover-proportional';
			}

			if($this->get_val($video_data, 'cover')){
				$layer['basealign'] = 'slide';
			}
		}
		
		// needed to make sure 'fa-icon' gets converted for toggle content
		$ml['toggle'] = array(
			'set' => $this->_truefalse($this->get_val($layer, 'toggle', false)),
			'text' => $toggleText,
			//'inverse' => $this->_truefalse($this->get_val($layer, 'toggle_inverse_content', false)),
			'useHover' => $this->_truefalse($this->get_val($layer, 'toggle_use_hover', false)),
		);

		$ww = $this->get_val($layer, 'width');
		$hh = $this->get_val($layer, 'height');
		
		$minHH = 'none';

		switch($this->get_val($layer, 'type')){
			case 'image':
				if($this->get_val($layer, 'scaleX', false) !== false){
					$ww = $this->get_val($layer, 'scaleX');
					$hh = $this->get_val($layer, 'scaleY');
					
					//check if we need to get image dimensions
					$_img_d = array($ww, $hh);
					$get_dim = false;
					foreach($_img_d as $img_d){
						if(empty($img_d)){
							$get_dim = true;
						}else{
							if(!is_array($img_d)) continue;
							foreach($img_d as $_d => $_v){
								if(!empty($_v)) continue;
								
								$get_dim = true;
								break;
							}
						}
						if($get_dim === true) break;
					}
					
					if($get_dim === true){
						$ow = '';
						$oh = '';
						$cur_img = $this->get_val($ml, array('media', 'imageUrl'));
						if($cur_img !== ''){
							$cur_id = $this->get_image_id_by_url($cur_img);
							$img_data = wp_get_attachment_metadata($cur_id);
							
							if($img_data !== false && !empty($img_data)){
								$this->set_val($ml, array('media', 'imageId'), $cur_id);
								
								$img_size = ($this->get_val($layer, 'image-size', 'auto') === 'auto') ? $slider->get_param('def-image_source_type', 'full') : 'full';
								if($img_size !== 'full'){
									if(isset($img_data['sizes']) && isset($img_data['sizes'][$img_size])){
										$ow = (isset($img_data['sizes'][$img_size]['width'])) ? $img_data['sizes'][$img_size]['width'] : '';
										$oh = (isset($img_data['sizes'][$img_size]['height'])) ? $img_data['sizes'][$img_size]['height'] : '';
									}
								}
								
								if($ow == '' || $oh == ''){
									$ow = (isset($img_data['width'])) ? $img_data['width'] : '';
									$oh = (isset($img_data['height'])) ? $img_data['height'] : '';
								}
							}else{
								$ow = $this->get_val($layer, 'width');
								$oh = $this->get_val($layer, 'height');
							}
							
							if(empty($ww)){
								$ww = $ow;
							}else{
								if(is_array($ww)){
									foreach($ww as $_d => $_v){
										if(empty($_v)){
											$ww[$_d] = $ow;
										}
									}
								}
							}
							if(empty($hh)){
								$hh = $oh;
							}else{
								if(is_array($hh)){
									foreach($hh as $_d => $_v){
										if(empty($_v)){
											$hh[$_d] = $oh;
										}
									}
								}
							}
						}
					}
				}
			break;
			case 'video':
				if($this->get_val($layer, 'video_height', false) !== false){
					$ww = $this->get_val($layer, 'video_width');
					$hh = $this->get_val($layer, 'video_height');
				}
			break;
			case 'svg':
				if($this->get_val($layer, 'max_height', false) !== false){
					$ww = $this->get_val($layer, 'max_width');
					$hh = $this->get_val($layer, 'max_height');
				}
			break;
			case 'shape':
			case 'button':
			case 'text':
			case 'group':
				if($this->get_val($layer, 'max_height', false) !== false){
					$ww = $this->get_val($layer, 'max_width');
					$hh = $this->get_val($layer, 'max_height');
				}else{
					$ww = 'auto';
					$hh = 'auto';
				}
			break;
		}
		
		//$layer['cover_mode'] = (!in_array($this->get_val($layer, 'type'), array('image', 'video'))) ? 'custom' : $this->get_val($layer, 'cover_mode'); //'shape', 
		switch($this->get_val($layer, 'cover_mode')){
			case 'cover':
			case 'cover-proportional':
				$ww = '100%';
				$hh = '100%';
			break;
			case 'fullheight':
				$hh = '100%';
			break;
			case 'fullwidth':
				$ww = '100%';
			break;
		}

		if($this->get_val($layer, 'type') === 'row'){
			if($hh !== 'auto' && $hh != '-1' && $hh !== '32'){
				$minHH = $hh;
			}

			if($this->get_val($layer, 'max_height', false) !== false){
				$minHH = $layer['max_height'];
			}
			$hh = 'auto';
		}

		$defwidth		= (!in_array($this->get_val($layer, 'type'), array('image', 'shape', 'video'))) ? 'auto' : '300';
		$defheight		= (!in_array($this->get_val($layer, 'type'), array('image', 'shape', 'video'))) ? 'auto' : '180';
		$defproportion	= (in_array($this->get_val($layer, 'type'), array('svg', 'image', 'video'))) ? true : false;
		$defaspectrat	= (!in_array($this->get_val($layer, 'type'), array('image', 'shape', 'video'))) ? 'none' : 300/180;
		
		/**
		 * width and height values should not
		 * later be replaced with the default if they are empty
		 * so we make sure that empty strings are filled here
		 **/
		if(is_array($ww)){
			$wd = $defwidth;
			foreach($ww as $wk => $wv){
				if(empty($wv)){
					$ww[$wk] = $wd;
				}
				$wd = $ww[$wk];
			}
		}
		if(is_array($hh)){
			$hd = $defwidth;
			foreach($hh as $hk => $hv){
				if(empty($hv)){
					$hh[$hk] = $hd;
				}
				$hd = $hh[$hk];
			}
		}
		
		$ml['size'] = array(
			'width' => $this->c_to_resp(array('default' => $defwidth, 'val' => $ww)),
			'height' => $this->c_to_resp(array('default' => $defheight, 'val' => $hh)),
			'maxWidth' => $this->c_to_resp(array('default' => 'none', 'val' => 'none')),
			'maxHeight' => $this->c_to_resp(array('default' => 'none', 'val' => 'none')),
			'minWidth' => $this->c_to_resp(array('default' => 'none', 'val' => 'none')),
			'minHeight' => $this->c_to_resp(array('default' => 'none', 'val' => $minHH)),
			'originalWidth' => ($this->get_val($layer, 'type') == 'video') ? $this->get_val($video_data, 'video_width', false) : $this->get_val($layer, 'originalWidth', false),
			'originalHeight' => ($this->get_val($layer, 'type') == 'video') ? $this->get_val($video_data, 'video_height', false) : $this->get_val($layer, 'originalHeight', false),
			'covermode' => $this->get_val($layer, 'cover_mode', 'custom'),
			'scaleProportional' => $this->_truefalse($this->get_val($layer, 'scaleProportional', $defproportion)),
		);

		$ml['size']['aspectRatio'] = (intval($ml['size']['originalWidth']) > 0 && intval($ml['size']['originalHeight']) > 0) ? $this->c_to_resp(array('default' => $defaspectrat, 'val' => intval($ml['size']['originalWidth']) / intval($ml['size']['originalHeight']))) : $this->c_to_resp(array('default' => $defaspectrat, 'val' => $defaspectrat));

		if($ml['size']['originalWidth'] === false){
			unset($ml['size']['originalWidth']);
		}

		if($ml['size']['originalHeight'] === false){
			unset($ml['size']['originalHeight']);
		}
		
		if($this->get_val($layer, 'type') === 'svg'){
			$ml['size']['scaleProportional'] = true;
		}
		
		if(!in_array($ml['size']['scaleProportional'], array(true, false), true)){
			if(in_array($this->get_val($layer, 'type'), array('svg', 'image', 'video'), true)){
				$ml['size']['scaleProportional'] = true;
			}else{
				$ml['size']['scaleProportional'] = false;
			}
		}
		
		if($this->get_val($ml, array('size', 'originalWidth'), 0) === 0){
			$ml['size']['originalWidth'] = $this->get_val($ml, array('size', 'width', 'd', 'v'));
		}
		if($this->get_val($ml, array('size', 'originalHeight'), 0) === 0){
			$ml['size']['originalHeight'] = $this->get_val($ml, array('size', 'height', 'd', 'v'));
		}
		
		$ml['position'] = array(
			'x' => $this->c_to_resp(array('default' => 0, 'val' => $this->get_val($layer, 'left', 0), 'unit' => 'px'), true),
			'y' => $this->c_to_resp(array('default' => 0, 'val' => $this->get_val($layer, 'top', 0), 'unit' => 'px'), true),
			'horizontal' => $this->c_to_resp(array('default' => 'left', 'val' => $this->get_val($layer, 'align_hor'))),
			'vertical' => $this->c_to_resp(array('default' => 'top', 'val' => $this->get_val($layer, 'align_vert'))),
			//'zIndex' => (trim($this->get_val($layer, 'zIndex', '')) === '') ? $this->get_val($layer, 'serial', '##') : $this->get_val($layer, 'zIndex', false),
			'zIndex' => (trim($this->get_val($layer, 'zIndex', '')) === '') ? $this->z_index : $this->get_val($layer, 'zIndex', false),
			'position' => $this->get_val($layer, 'css-position', 'absolute'),
		);
		
		$ml['attributes'] = array(
			'alt'		=> $this->get_val($layer, 'alt', ''),
			'altOption'	=> $this->get_val($layer, 'alt_option', 'media_library'),
			'id'		=> $this->get_val($layer, 'attrID', ''),
			'classes'	=> $this->get_val($layer, 'attrClasses', ''),
			'rel'		=> $this->get_val($layer, 'attrRel', ''),
			'tabIndex'	=> $this->get_val($layer, 'attrTabindex', 0),
			'title'		=> $this->get_val($layer, 'attrTitle', ''),
			'wrapperClasses' => $this->get_val($layer, 'attrWrapperClasses', ''),
			'wrapperId'	=> $this->get_val($layer, 'attrWrapperID', ''),
		);
		
		$base_align = $this->get_val($layer, 'basealign', 'grid');
		if($this->get_val($layer, 'p_uid', -1) == -1){ //only on layers that are not in row/group/column
			if(in_array($this->get_val($layer, 'type'), array('image', 'shape', 'text'), true)){
				$mmw = $this->get_val($ml, array('size', 'width'));
				if($this->get_val($mmw, array('d', 'v')) === '100%' ||
				   $this->get_val($mmw, array('n', 'v')) === '100%' ||
				   $this->get_val($mmw, array('t', 'v')) === '100%' ||
				   $this->get_val($mmw, array('m', 'v')) === '100%'
				){
					if($this->get_val($ml, array('size', 'covermode')) === 'custom'){
						$base_align = 'slide';
					}
				}
			}
		}

		$ml['behavior'] = array(
			'autoResponsive'	 => $this->_truefalse($this->get_val($layer, 'resize-full', true)),
			'intelligentInherit' => false,
			'responsiveChilds'	 => $this->_truefalse($this->get_val($layer, 'resizeme', true)),
			'baseAlign'			 => $base_align,
			'responsiveOffset'	 => $this->_truefalse($this->get_val($layer, 'responsive_offset', true)),
			'lazyLoad'			 => $this->get_val($layer, 'lazy-load', 'auto'),
			'imageSourceType'	 => $this->get_val($layer, 'image-size', 'auto'),
		);
		
		if($this->get_val($layer, 'groupOrder', -99) === -99){
			if($this->get_val($layer, 'zIndex', -99) === -99){
				$groupOrder = $this->get_val($layer, 'serial', -99);
			}else{
				$groupOrder = $this->get_val($layer, 'zIndex', -99);
			}
		}else{
			$groupOrder = $this->get_val($layer, 'groupOrder', -99);
		}
		
		$column_size = $this->get_val($layer, 'column_size', '1/3');
		$ml['group'] = array(
			'puid' => $this->get_val($layer, 'p_uid', -1),
			'groupOrder' => $groupOrder,
			'columnbreakat' => $this->get_val($layer, 'column_break_at', 'tablet'),
			'columnSize' => (in_array($column_size, array(1, '1'), true)) ? '1/1' : $column_size
		);

		$align_vert = $this->get_val($layer, 'align_vert', array());
		if($this->get_val($layer, 'type') === 'row'){
			$ml['group']['puid'] = $this->get_val($align_vert, 'desktop', 'top'); //get the deskop value
		}

		$split = ($this->get_val($layer, 'frames', false) === false) ? $this->get_val($layer, 'split', 'none') : $this->get_val($frame_0, 'split', 'none');
		$endsplit = ($this->get_val($layer, 'frames', false) === false) ? $this->get_val($layer, 'endsplit', 'none') : $this->get_val($frame_999, 'split', 'none');

		//Define an Empty Timeline Object First.
		
		/**
		 * old fix for slider under version 530
		 **/
		$end_time = trim($this->get_val($frame_999, 'time', $this->get_val($layer, 'endtime', 0)));
		$version = $this->get_val($layer, 'version', false);
		if($version === false || intval($version) < 530){ //an additional check that we may not need, as checking if frame_999 is empty is already enough
			if(empty($frame_999)){
				$ret = $this->get_val($layer, 'realEndTime', false);
				if($ret !== false){
					$end_speed = trim($this->get_val($layer, 'endspeed'));
					$end_time_relative = $this->get_val($layer, 'endtimedelay', 'none');
					if($end_time_relative !== 'none'){
						$end_time = ($end_time !== $end_time_relative) ? '+'.$end_time_relative : $end_time_relative;
					}
					
					$calc_speed	= (!empty($end_speed)) ? $end_speed : $this->get_val($frame_0, 'speed', $this->get_val($layer, 'speed', 300));
					
					if(!empty($calc_speed) && $ret - $calc_speed !== $end_time){
						$end_time = $ret - $calc_speed;
					}
				}
				
				//endtime - endspeed
				$end_speed = $this->get_val($layer, 'endspeed', 0);
				$end_time = (!empty($end_time) && $end_time - $end_speed < 0) ? 0 : $end_time - $end_speed;
			}
		}
		
		/**
		 * check if the value is inherit, if yes, take the one from deformation
		 **/
		$fr_0 = array(
			'rotationX' => ($this->get_val($layer, 'x_rotate_start') === 'inherit') ? $this->conv_perc_vals($this->get_val($deformation, 'xrotate')) :  $this->conv_perc_vals($this->get_val($layer, 'x_rotate_start')),
			'rotationY' => ($this->get_val($layer, 'y_rotate_start') === 'inherit') ? $this->conv_perc_vals($this->get_val($deformation, 'yrotate')) :  $this->conv_perc_vals($this->get_val($layer, 'y_rotate_start')),
			'rotationZ' => ($this->get_val($layer, 'z_rotate_start') === 'inherit') ? $this->conv_perc_vals($this->get_val($layer, '2d_rotation')) :  $this->conv_perc_vals($this->get_val($layer, 'z_rotate_start')),
			'scaleX'	=> ($this->get_val($layer, 'scale_x_start') === 'inherit') ? $this->conv_perc_vals($this->get_val($deformation, 'scalex')) :  $this->conv_perc_vals($this->get_val($layer, 'scale_x_start')),
			'scaleY'	=> ($this->get_val($layer, 'scale_y_start') === 'inherit') ? $this->conv_perc_vals($this->get_val($deformation, 'scaley')) :  $this->conv_perc_vals($this->get_val($layer, 'scale_y_start')),
			'skewX'		=> ($this->get_val($layer, 'skew_x_start') === 'inherit') ? $this->conv_perc_vals($this->get_val($deformation, 'skewx')) :  $this->conv_perc_vals($this->get_val($layer, 'skew_x_start')),
			'skewY'		=> ($this->get_val($layer, 'skew_y_start') === 'inherit') ? $this->conv_perc_vals($this->get_val($deformation, 'skewy')) :  $this->conv_perc_vals($this->get_val($layer, 'skew_y_start')),
			'opacity'	=> ($this->get_val($layer, 'opacity_start') === 'inherit') ? $this->conv_perc_vals($this->get_val($deformation, 'opacity')) : $this->conv_perc_vals($this->get_val($layer, 'opacity_start')),
			'z'			=> ($this->get_val($layer, 'z_start') === 'inherit') ? $this->conv_perc_vals($this->get_val($deformation, 'z')) :  $this->conv_perc_vals($this->get_val($layer, 'z_start')),
			'blur'		=> ($this->get_val($layer, 'blurfilter_start', 0) === 'inherit') ? $this->get_val($deformation, 'blurfilter') : $this->get_val($layer, 'blurfilter_start', 0),
			'grayscale'	=> ($this->get_val($layer, 'grayscalefilter_start', 0) === 'inherit') ? $this->get_val($deformation, 'grayscalefilter') : $this->get_val($layer, 'grayscalefilter_start', 0),
			'brightness'=> ($this->get_val($layer, 'brightnessfilter_start', 100) === 'inherit') ? $this->get_val($deformation, 'brightnessfilter') : $this->get_val($layer, 'brightnessfilter_start', 100)
		);
		
		$ml['timeline'] = array(
			'frameOrder' => array(
				array(
					'id' => 'frame_1',
					'start' => (empty($frames)) ? $this->get_val($layer, 'time') : $this->get_val($frame_0, 'time'),
				),
				array(
					'id' => 'frame_999',
					'start' => (empty($frames)) ? $this->get_val($layer, 'endtime') : $this->get_val($frame_999, 'time'),
				),
			),
			'frameToIdle' => 'frame_1',
			'frames' => array(
				'frame_0' => $this->default_frame(
					array(
						'fid' => 'frame_0',
						'alias' => __('Anim From', 'revslider'),
						'grayscale' => $this->get_val($fr_0, 'grayscale', 0),
						'transformPerspective' => $this->get_val($deformation, 'pers'),
						'brightness' => $this->get_val($fr_0, 'brightness', 100),
						'blur' => $this->get_val($fr_0, 'blur', 0),
						'x' => (!in_array($split, array('', 'none'))) ? 0 : $this->conv_perc_vals($this->get_val($layer, 'x_start')),
						'y' => (!in_array($split, array('', 'none'))) ? 0 : $this->conv_perc_vals($this->get_val($layer, 'y_start')),
						'z' => (!in_array($split, array('', 'none'))) ? 0 : $this->get_val($fr_0, 'z'),
						'scaleX' => (!in_array($split, array('', 'none'))) ? 1 : $this->get_val($fr_0, 'scaleX'),
						'scaleY' => (!in_array($split, array('', 'none'))) ? 1 : $this->get_val($fr_0, 'scaleY'),
						'opacity' => (!in_array($split, array('', 'none'))) ? 1 : $this->get_val($fr_0, 'opacity'),
						'rotationX' => (!in_array($split, array('', 'none'))) ? 0 : $this->get_val($fr_0, 'rotationX'),
						'rotationY' => (!in_array($split, array('', 'none'))) ? 0 : $this->get_val($fr_0, 'rotationY'),
						'rotationZ' => (!in_array($split, array('', 'none'))) ? 0 : $this->get_val($fr_0, 'rotationZ'),
						'skewX' => (!in_array($split, array('', 'none'))) ? 0 : $this->get_val($fr_0, 'skewX'),
						'skewY' => (!in_array($split, array('', 'none'))) ? 0 : $this->get_val($fr_0, 'skewY'),
						'originX' => $this->get_val($deformation, '2d_origin_x', '50%'),
						'originY' => $this->get_val($deformation, '2d_origin_y', '50%'),
						'rx' => $this->conv_perc_vals($this->get_val($layer, 'x_start_reverse', false)),
						'ry' => $this->conv_perc_vals($this->get_val($layer, 'y_start_reverse', false)),
						'rz' => $this->conv_perc_vals($this->get_val($layer, 'z_start_reverse')),
						'rscaleX' => $this->conv_perc_vals($this->get_val($layer, 'scale_x_start_reverse')),
						'rscaleY' => $this->conv_perc_vals($this->get_val($layer, 'scale_y_start_reverse')),
						'rrotationX' => $this->conv_perc_vals($this->get_val($layer, 'x_rotate_start_reverse', false)),
						'rrotationY' => $this->conv_perc_vals($this->get_val($layer, 'y_rotate_start_reverse', false)),
						'rrotationZ' => $this->conv_perc_vals($this->get_val($layer, 'z_rotate_start_reverse', false)),
						'rskewX' => $this->conv_perc_vals($this->get_val($layer, 'skew_x_start_reverse', false)),
						'rskewY' => $this->conv_perc_vals($this->get_val($layer, 'skew_y_start_reverse', false)),
						'rmaskX' => $this->conv_perc_vals($this->get_val($layer, 'mask_x_start_reverse', false)),
						'rmaskY' => $this->conv_perc_vals($this->get_val($layer, 'mask_y_start_reverse', false)),
						'color' => array(
							'color' => (empty($frame_0)) ? '' : $this->get_val($frame_0, 'text_c', '#ffffff'),
							'use' => (empty($frame_0)) ? false : $this->get_val($frame_0, 'use_text_c'),
						),
						'bgcolor' => array(
							'backgroundColor' => $this->get_val($frame_0, 'bg_c', 'transparent'),
							'use' => (empty($frame_0)) ? false : $this->get_val($frame_0, 'use_bg_c'),
						),
						//'delay'						=> (empty($frame_0)) ? 0 : $this->get_val($frame_0, 'delay'),
						'ease' => (empty($frame_0)) ? $this->get_val($layer, 'easing', 'power3.inOut') : $this->get_val($frame_0, 'easing', 'power3.inOut'),
						'speed' => (empty($frame_0)) ? $this->get_val($layer, 'speed', 300) : $this->get_val($frame_0, 'speed', 300),
						'start' => (empty($frame_0)) ? $this->get_val($layer, 'time') : $this->get_val($frame_0, 'time'),
						'startRelative' => $this->get_val($frame_0, 'time_relative', 0),
						'effect' => (empty($frame_0)) ? '' : $this->get_val($frame_0, 'sfx_effect'),
						'sfxcolor' => $color_picker->correctValue($this->get_val($frame_0, 'sfxcolor', '#ffffff')),
						'mask' => array(
							'use' => $this->_truefalse($this->get_val($layer, 'mask_start', false)),
							'x' => $this->conv_perc_vals($this->get_val($layer, 'mask_x_start', 0)),
							'y' => $this->conv_perc_vals($this->get_val($layer, 'mask_y_start', 0)),
						),
						'chars' => array(
							'use' => ($split === 'chars') ? true : false,
							'direction' => $this->get_val($frame_0, 'split_direction', 'forward'),
							'delay' => (empty($frame_0)) ? $this->get_val($layer, 'splitdelay', 5) : $this->get_val($frame_0, 'splitdelay', 5),
							'x' => ($split === 'chars') ? $this->conv_perc_vals($this->get_val($layer, 'x_start')) : 'inherit',
							'y' => ($split === 'chars') ? $this->conv_perc_vals($this->get_val($layer, 'y_start')) : 'inherit',
							'z' => ($split === 'chars') ? $this->get_val($fr_0, 'z') : 'inherit',
							'scaleX' => ($split === 'chars') ? $this->get_val($fr_0, 'scaleX') : 'inherit',
							'scaleY' => ($split === 'chars') ? $this->get_val($fr_0, 'scaleY') : 'inherit',
							'opacity' => ($split === 'chars') ? $this->get_val($fr_0, 'opacity') : 'inherit',
							'rotationX' => ($split === 'chars') ? $this->get_val($fr_0, 'rotationX') : 'inherit',
							'rotationY' => ($split === 'chars') ? $this->get_val($fr_0, 'rotationY') : 'inherit',
							'rotationZ' => ($split === 'chars') ? $this->get_val($fr_0, 'rotationZ') : 'inherit',
							'skewX' => ($split === 'chars') ? $this->get_val($fr_0, 'skewX') : 'inherit',
							'skewY' => ($split === 'chars') ? $this->get_val($fr_0, 'skewY') : 'inherit',
						),
						'words' => array(
							'use' => ($split === 'words') ? true : false,
							'direction' => $this->get_val($frame_0, 'split_direction', 'forward'),
							'delay' => (empty($frame_0)) ? $this->get_val($layer, 'splitdelay', 5) : $this->get_val($frame_0, 'splitdelay', 5),
							'x' => ($split === 'words') ? $this->conv_perc_vals($this->get_val($layer, 'x_start')) : 'inherit',
							'y' => ($split === 'words') ? $this->conv_perc_vals($this->get_val($layer, 'y_start')) : 'inherit',
							'z' => ($split === 'words') ? $this->get_val($fr_0, 'z') : 'inherit',
							'scaleX' => ($split === 'words') ? $this->get_val($fr_0, 'scaleX') : 'inherit',
							'scaleY' => ($split === 'words') ? $this->get_val($fr_0, 'scaleY') : 'inherit',
							'opacity' => ($split === 'words') ? $this->get_val($fr_0, 'opacity') : 'inherit',
							'rotationX' => ($split === 'words') ? $this->get_val($fr_0, 'rotationX') : 'inherit',
							'rotationY' => ($split === 'words') ? $this->get_val($fr_0, 'rotationY') : 'inherit',
							'rotationZ' => ($split === 'words') ? $this->get_val($fr_0, 'rotationZ') : 'inherit',
							'skewX' => ($split === 'words') ? $this->get_val($fr_0, 'skewX') : 'inherit',
							'skewY' => ($split === 'words') ? $this->get_val($fr_0, 'skewY') : 'inherit',
						),
						'lines' => array(
							'use' => ($split === 'lines') ? true : false,
							'direction' => $this->get_val($frame_0, 'split_direction', 'forward'),
							'delay' => (empty($frame_0)) ? $this->get_val($layer, 'splitdelay', 5) : $this->get_val($frame_0, 'splitdelay', 5),
							'x' => ($split === 'lines') ? $this->conv_perc_vals($this->get_val($layer, 'x_start')) : 'inherit',
							'y' => ($split === 'lines') ? $this->conv_perc_vals($this->get_val($layer, 'y_start')) : 'inherit',
							'z' => ($split === 'lines') ? $this->get_val($fr_0, 'z') : 'inherit',
							'scaleX' => ($split === 'lines') ? $this->get_val($fr_0, 'scaleX') : 'inherit',
							'scaleY' => ($split === 'lines') ? $this->get_val($fr_0, 'scaleY') : 'inherit',
							'opacity' => ($split === 'lines') ? $this->get_val($fr_0, 'opacity') : 'inherit',
							'rotationX' => ($split === 'lines') ? $this->get_val($fr_0, 'rotationX') : 'inherit',
							'rotationY' => ($split === 'lines') ? $this->get_val($fr_0, 'rotationY') : 'inherit',
							'rotationZ' => ($split === 'lines') ? $this->get_val($fr_0, 'rotationZ') : 'inherit',
							'skewX' => ($split === 'lines') ? $this->get_val($fr_0, 'skewX') : 'inherit',
							'skewY' => ($split === 'lines') ? $this->get_val($fr_0, 'skewY') : 'inherit',
						),
					)/*,
					$_f['0']*/
				),
				'frame_1' => $this->default_frame(
					array(
						'fid' => 'frame_1',
						'alias' => __('Anim To', 'revslider'),
						'actionTriggered' => false,
						'transformPerspective' => $this->get_val($deformation, 'pers'),
						'grayscale' => $this->get_val($deformation, 'grayscalefilter', 0),
						'brightness' => $this->get_val($deformation, 'brightnessfilter', 100),
						'blur' => $this->get_val($deformation, 'blurfilter', 0),
						'x' => ($split !== 'none') ? 0 : $this->get_val($deformation, 'x'),
						'y' => ($split !== 'none') ? 0 : $this->get_val($deformation, 'y'),
						'z' => ($split !== 'none') ? 0 : $this->get_val($deformation, 'z'),
						'opacity' => ($split !== 'none') ? 1 : $this->get_val($deformation, 'opacity'),
						'originX' => $this->get_val($deformation, '2d_origin_x', '50%'),
						'originY' => $this->get_val($deformation, '2d_origin_y', '50%'),
						'rotationZ' => ($split !== 'none') ? 0 : $this->get_val($layer, '2d_rotation'),
						'rotationX' => ($split !== 'none') ? 0 : $this->get_val($deformation, 'xrotate'),
						'rotationY' => ($split !== 'none') ? 0 : $this->get_val($deformation, 'yrotate'),
						'scaleX' => ($split !== 'none') ? 1 : $this->get_val($deformation, 'scalex'),
						'scaleY' => ($split !== 'none') ? 1 : $this->get_val($deformation, 'scaley'),
						'skewX' => ($split !== 'none') ? 0 : $this->get_val($deformation, 'skewx'),
						'skewY' => ($split !== 'none') ? 0 : $this->get_val($deformation, 'skewy'),
						//'delay' => (empty($frame_0)) ? 0 : $this->get_val($frame_0, 'delay'),
						'ease' => (empty($frame_0)) ? $this->get_val($layer, 'easing', 'power3.inOut') : $this->get_val($frame_0, 'easing', 'power3.inOut'),
						'speed' => (empty($frame_0)) ? $this->get_val($layer, 'speed', 300) : $this->get_val($frame_0, 'speed', 300),
						'start' => (empty($frame_0)) ? $this->get_val($layer, 'time') : $this->get_val($frame_0, 'time', 10),
						'startRelative' => $this->get_val($frame_0, 'time_relative', 0),
						'effect' => (empty($frame_0)) ? '' : $this->get_val($frame_0, 'sfx_effect'),
						'sfxcolor' => $color_picker->correctValue($this->get_val($frame_0, 'sfxcolor', '#ffffff')),
						'mask' => array(
							'use' => $this->_truefalse($this->get_val($layer, 'mask_start', false)),
							'x' => 0,
							'y' => 0,
						),
						'chars' => array(
							'use' => ($split === 'chars') ? true : false,
							'direction' => $this->get_val($frame_0, 'split_direction', 'forward'),
							'delay' => (empty($frame_0)) ? $this->get_val($layer, 'splitdelay', 5) : $this->get_val($frame_0, 'splitdelay', 5),
							'x' => 0,
							'y' => 0,
							'z' => 0,
							'opacity' => 1,
							'rotationZ' => 0,
							'rotationX' => 0,
							'rotationY' => 0,
							'scaleX' => 1,
							'scaleY' => 1,
							'skewX' => 0,
							'skewY' => 0,
						),
						'words' => array(
							'use' => ($split === 'words') ? true : false,
							'direction' => $this->get_val($frame_0, 'split_direction', 'forward'),
							'delay' => (empty($frame_0)) ? $this->get_val($layer, 'splitdelay', 5) : $this->get_val($frame_0, 'splitdelay', 5),
							'x' => 0,
							'y' => 0,
							'z' => 0,
							'opacity' => 1,
							'rotationZ' => 0,
							'rotationX' => 0,
							'rotationY' => 0,
							'scaleX' => 1,
							'scaleY' => 1,
							'skewX' => 0,
							'skewY' => 0,
						),
						'lines' => array(
							'use' => ($split === 'lines') ? true : false,
							'direction' => $this->get_val($frame_0, 'split_direction', 'forward'),
							'delay' => (empty($frame_0)) ? $this->get_val($layer, 'splitdelay', 5) : $this->get_val($frame_0, 'splitdelay', 5),
							'x' => 0,
							'y' => 0,
							'z' => 0,
							'opacity' => 1,
							'rotationZ' => 0,
							'rotationX' => 0,
							'rotationY' => 0,
							'scaleX' => 1,
							'scaleY' => 1,
							'skewX' => 0,
							'skewY' => 0,
						),
					)/*,
					$_f['1']*/
				),
				'frame_999' => $this->default_frame(
					array(
						'fid' => 'frame_999',
						'alias' => __('Anim To', 'revslider'),
						'animation' => $this->get_val($frame_999, 'animation', $this->get_val($layer, 'endanimation', false)),
						'actionTriggered' => false,
						'transformPerspective' => $this->get_val($deformation, 'pers'),
						'endWithSlide' => $this->get_val($layer, 'endWithSlide', false),
						'grayscale' => $this->get_val($layer, 'grayscalefilter_end', 0),
						'brightness' => $this->get_val($layer, 'brightnessfilter_end', 100),
						'blur' => $this->get_val($layer, 'blurfilter_end', 0),
						'x' => (!in_array($endsplit, array('', 'none'))) ? 0 : $this->conv_perc_vals($this->get_val($layer, 'x_end')),
						'y' => (!in_array($endsplit, array('', 'none'))) ? 0 : $this->conv_perc_vals($this->get_val($layer, 'y_end')),
						'z' => (!in_array($endsplit, array('', 'none'))) ? 0 : $this->conv_perc_vals($this->get_val($layer, 'z_end')),
						'scaleX' => (!in_array($endsplit, array('', 'none'))) ? 1 : $this->conv_perc_vals($this->get_val($layer, 'scale_x_end')),
						'scaleY' => (!in_array($endsplit, array('', 'none'))) ? 1 : $this->conv_perc_vals($this->get_val($layer, 'scale_y_end')),
						'opacity' => (!in_array($endsplit, array('', 'none'))) ? 1 : $this->conv_perc_vals($this->get_val($layer, 'opacity_end')),
						'rotationX' => (!in_array($endsplit, array('', 'none'))) ? 0 : $this->conv_perc_vals($this->get_val($layer, 'x_rotate_end')),
						'rotationY' => (!in_array($endsplit, array('', 'none'))) ? 0 : $this->conv_perc_vals($this->get_val($layer, 'y_rotate_end')),
						'rotationZ' => (!in_array($endsplit, array('', 'none'))) ? 0 : $this->conv_perc_vals($this->get_val($layer, 'z_rotate_end')),
						'skewX' => (!in_array($endsplit, array('', 'none'))) ? 0 : $this->conv_perc_vals($this->get_val($layer, 'skew_x_end')),
						'skewY' => (!in_array($endsplit, array('', 'none'))) ? 0 : $this->conv_perc_vals($this->get_val($layer, 'skew_y_end')),
						'rx' => $this->conv_perc_vals($this->get_val($layer, 'x_end_reverse', false)),
						'ry' => $this->conv_perc_vals($this->get_val($layer, 'y_end_reverse', false)),
						'rz' => $this->conv_perc_vals($this->get_val($layer, 'z_end_reverse')),
						'rscaleX' => $this->conv_perc_vals($this->get_val($layer, 'scale_x_end_reverse')),
						'rscaleY' => $this->conv_perc_vals($this->get_val($layer, 'scale_y_end_reverse')),
						'rrotationX' => $this->conv_perc_vals($this->get_val($layer, 'x_rotate_end_reverse', false)),
						'rrotationY' => $this->conv_perc_vals($this->get_val($layer, 'y_rotate_end_reverse', false)),
						'rrotationZ' => $this->conv_perc_vals($this->get_val($layer, 'z_rotate_end_reverse', false)),
						'rskewX' => $this->conv_perc_vals($this->get_val($layer, 'skew_x_end_reverse', false)),
						'rskewY' => $this->conv_perc_vals($this->get_val($layer, 'skew_y_end_reverse', false)),
						'rmaskX' => $this->conv_perc_vals($this->get_val($layer, 'mask_x_end_reverse', false)),
						'rmaskY' => $this->conv_perc_vals($this->get_val($layer, 'mask_y_end_reverse', false)),
						'color' => array(
							'color' => $this->get_val($frame_999, 'text_c', '#ffffff'),
							'use' => (empty($frame_999)) ? false : ($this->get_val($frame_999, 'use_text_c') === true),
						),
						'bgcolor' => array(
							'backgroundColor' => $this->get_val($frame_999, 'bg_c', 'transparent'),
							'use' => (empty($frame_999)) ? false : ($this->get_val($frame_999, 'use_bg_c') === true),
						),
						'ease' => (empty($frame_999)) ? $this->get_val($layer, 'endeasing', 'power3.inOut') : $this->get_val($frame_999, 'easing', 'power3.inOut'),
						'speed' => (empty($frame_999)) ? $this->get_val($layer, 'endspeed', 300) : $this->get_val($frame_999, 'speed', 300),
						'start' => (empty($frame_999)) ? $end_time : $this->get_val($frame_999, 'time'), //$this->get_val($layer, 'endtime') 
						'startRelative' => $this->get_val($frame_999, 'time_relative', 0),
						'effect' => (empty($frame_999)) ? '' : $this->get_val($frame_999, 'sfx_effect'),
						'sfxcolor' => $color_picker->correctValue($this->get_val($frame_999, 'sfxcolor', '#ffffff')),
						'mask' => array(
							'use' => $this->conv_perc_vals($this->get_val($layer, 'mask_end', false)),
							'x' => $this->conv_perc_vals($this->get_val($layer, 'mask_x_end', 0)),
							'y' => $this->conv_perc_vals($this->get_val($layer, 'mask_y_end', 0)),
						),
						'chars' => array(
							'use' => ($endsplit === 'chars'),
							'direction' => $this->get_val($frame_0, 'split_direction', 'forward'),
							'delay' => (empty($frame_0)) ? $this->get_val($layer, 'endsplitdelay', 5) : $this->get_val($frame_0, 'splitdelay', 5),
							'x' => ($endsplit === 'chars') ? $this->conv_perc_vals($this->get_val($layer, 'x_end')) : 'inherit',
							'y' => ($endsplit === 'chars') ? $this->conv_perc_vals($this->get_val($layer, 'y_end')) : 'inherit',
							'z' => ($endsplit === 'chars') ? $this->conv_perc_vals($this->get_val($layer, 'z_end')) : 'inherit',
							'scaleX' => ($endsplit === 'chars') ? $this->conv_perc_vals($this->get_val($layer, 'scale_x_end')) : 'inherit',
							'scaleY' => ($endsplit === 'chars') ? $this->conv_perc_vals($this->get_val($layer, 'scale_y_end')) : 'inherit',
							'opacity' => ($endsplit === 'chars') ? $this->conv_perc_vals($this->get_val($layer, 'opacity_end')) : 'inherit',
							'rotationX' => ($endsplit === 'chars') ? $this->conv_perc_vals($this->get_val($layer, 'x_rotate_end')) : 'inherit',
							'rotationY' => ($endsplit === 'chars') ? $this->conv_perc_vals($this->get_val($layer, 'y_rotate_end')) : 'inherit',
							'rotationZ' => ($endsplit === 'chars') ? $this->conv_perc_vals($this->get_val($layer, 'z_rotate_end')) : 'inherit',
							'skewX' => ($endsplit === 'chars') ? $this->conv_perc_vals($this->get_val($layer, 'skew_x_end')) : 'inherit',
							'skewY' => ($endsplit === 'chars') ? $this->conv_perc_vals($this->get_val($layer, 'skew_y_end')) : 'inherit',
						),
						'words' => array(
							'use' => ($endsplit === 'words'),
							'direction' => $this->get_val($frame_0, 'split_direction', 'forward'),
							'delay' => (empty($frame_0)) ? $this->get_val($layer, 'endsplitdelay', 5) : $this->get_val($frame_0, 'splitdelay', 5),
							'x' => ($endsplit === 'words') ? $this->conv_perc_vals($this->get_val($layer, 'x_end')) : 'inherit',
							'y' => ($endsplit === 'words') ? $this->conv_perc_vals($this->get_val($layer, 'y_end')) : 'inherit',
							'z' => ($endsplit === 'words') ? $this->conv_perc_vals($this->get_val($layer, 'z_end')) : 'inherit',
							'scaleX' => ($endsplit === 'words') ? $this->conv_perc_vals($this->get_val($layer, 'scale_x_end')) : 'inherit',
							'scaleY' => ($endsplit === 'words') ? $this->conv_perc_vals($this->get_val($layer, 'scale_y_end')) : 'inherit',
							'opacity' => ($endsplit === 'words') ? $this->conv_perc_vals($this->get_val($layer, 'opacity_end')) : 'inherit',
							'rotationX' => ($endsplit === 'words') ? $this->conv_perc_vals($this->get_val($layer, 'x_rotate_end')) : 'inherit',
							'rotationY' => ($endsplit === 'words') ? $this->conv_perc_vals($this->get_val($layer, 'y_rotate_end')) : 'inherit',
							'rotationZ' => ($endsplit === 'words') ? $this->conv_perc_vals($this->get_val($layer, 'z_rotate_end')) : 'inherit',
							'skewX' => ($endsplit === 'words') ? $this->conv_perc_vals($this->get_val($layer, 'skew_x_end')) : 'inherit',
							'skewY' => ($endsplit === 'words') ? $this->conv_perc_vals($this->get_val($layer, 'skew_y_end')) : 'inherit',
						),
						'lines' => array(
							'use' => ($endsplit === 'lines'),
							'direction' => $this->get_val($frame_0, 'split_direction', 'forward'),
							'delay' => (empty($frame_0)) ? $this->get_val($layer, 'endsplitdelay', 5) : $this->get_val($frame_0, 'splitdelay', 5),
							'x' => ($endsplit === 'lines') ? $this->conv_perc_vals($this->get_val($layer, 'x_end')) : 'inherit',
							'y' => ($endsplit === 'lines') ? $this->conv_perc_vals($this->get_val($layer, 'y_end')) : 'inherit',
							'z' => ($endsplit === 'lines') ? $this->conv_perc_vals($this->get_val($layer, 'z_end')) : 'inherit',
							'scaleX' => ($endsplit === 'lines') ? $this->conv_perc_vals($this->get_val($layer, 'scale_x_end')) : 'inherit',
							'scaleY' => ($endsplit === 'lines') ? $this->conv_perc_vals($this->get_val($layer, 'scale_y_end')) : 'inherit',
							'opacity' => ($endsplit === 'lines') ? $this->conv_perc_vals($this->get_val($layer, 'opacity_end')) : 'inherit',
							'rotationX' => ($endsplit === 'lines') ? $this->conv_perc_vals($this->get_val($layer, 'x_rotate_end')) : 'inherit',
							'rotationY' => ($endsplit === 'lines') ? $this->conv_perc_vals($this->get_val($layer, 'y_rotate_end')) : 'inherit',
							'rotationZ' => ($endsplit === 'lines') ? $this->conv_perc_vals($this->get_val($layer, 'z_rotate_end')) : 'inherit',
							'skewX' => ($endsplit === 'lines') ? $this->conv_perc_vals($this->get_val($layer, 'skew_x_end')) : 'inherit',
							'skewY' => ($endsplit === 'lines') ? $this->conv_perc_vals($this->get_val($layer, 'skew_y_end')) : 'inherit',
						),
					)/*,
					$_f['999']*/
				),
			),
			'static' => array(
				'start' => $this->get_val($layer, 'static_start', 1),
				'end' => $this->get_val($layer, 'static_end', 'last'),
			),
			'loop' => $this->default_loop_frame(
				array(
					'use' => ($this->get_val($layer, 'loop_animation', 'none') !== 'none') ? true : false,
					'ease' => ($this->get_val($layer, 'loop_animation') === 'rs-wave') ? 'none' : $this->get_val($layer, 'loop_easing', 'none'),
					'speed' => ($this->get_val($layer, 'loop_animation', 'rs-wave') === 'rs-wave') ? $this->get_val($layer, 'loop_speed', 1) * 1000 : $this->get_val($layer, 'loop_speed', 1) * 2000,
					'originX' => $this->get_val($layer, 'loop_xorigin', '50%'),
					'originY' => $this->get_val($layer, 'loop_yorigin', '50%'),
					'radiusAngle' => 0,
					'curviness' => 2,
					'curved' => ($this->get_val($layer, 'loop_animation') === 'rs-wave') ? true : false,
					'yoyo_move' => ($this->get_val($layer, 'loop_animation', 'rs-wave') === 'rs-wave') ? false : true,
					'yoyo_rotate' => ($this->get_val($layer, 'loop_animation') === 'rs-pendulum') ? true : false,
					'yoyo_scale' => ($this->get_val($layer, 'loop_animation', 'none') !== 'none') ? true : false,
					'yoyo_filter' => ($this->get_val($layer, 'loop_animation', 'none') !== 'none') ? true : false,
					'repeat' => '-1',
					'start' => 300,
					'autoRotate' => false,
					'frame_0' => array(
						'xr' => $this->get_val($layer, 'loop_radius', 0),
						'yr' => $this->get_val($layer, 'loop_radius', 0),
						'zr' => 0,
						'x' => ($this->get_val($layer, 'loop_animation') === 'rs-wave') ? 0 : $this->get_val($layer, 'loop_xstart', 0),
						'y' => ($this->get_val($layer, 'loop_animation') === 'rs-wave') ? 0 : $this->get_val($layer, 'loop_ystart', 0),
						'z' => 0,
						'scaleX' => ($this->get_val($layer, 'loop_animation') === 'rs-wave') ? 1 : $this->get_val($layer, 'loop_zoomstart', 1),
						'scaleY' => ($this->get_val($layer, 'loop_animation') === 'rs-wave') ? 1 : $this->get_val($layer, 'loop_zoomstart', 1),
						'opacity' => 1,
						'rotationX' => 0,
						'rotationY' => 0,
						'rotationZ' => ($this->get_val($layer, 'loop_animation') !== 'rs-rotate' && $this->get_val($layer, 'loop_animation') !== 'rs-pendulum') ? 0 : $this->get_val($layer, 'loop_startdeg', 0),
						'skewX' => 0,
						'skewY' => 0,
						'blur' => 0,
						'brightness' => 100,
						'grayscale' => 0
					),
					'frame_999' => array(
						'xr' => $this->get_val($layer, 'loop_radius', 0),
						'yr' => $this->get_val($layer, 'loop_radius', 0),
						'zr' => 0,
						'x' => ($this->get_val($layer, 'loop_animation') === 'rs-wave') ? 0 : $this->get_val($layer, 'loop_xend', 0),
						'y' => ($this->get_val($layer, 'loop_animation') === 'rs-wave') ? 0 : $this->get_val($layer, 'loop_yend', 0),
						'z' => 0,
						'scaleX' => ($this->get_val($layer, 'loop_animation') === 'rs-wave') ? 1 : $this->get_val($layer, 'loop_zoomend', 1),
						'scaleY' => ($this->get_val($layer, 'loop_animation') === 'rs-wave') ? 1 : $this->get_val($layer, 'loop_zoomend', 1),
						'opacity' => 1,
						'rotationX' => 0,
						'rotationY' => 0,
						'rotationZ' => ($this->get_val($layer, 'loop_animation') !== 'rs-rotate' && $this->get_val($layer, 'loop_animation') !== 'rs-pendulum') ? 0 : $this->get_val($layer, 'loop_enddeg', 0),
						'skewX' => 0,
						'blur' => 0,
						'brightness' => 100,
						'grayscale' => 0
					),
					'loop_animation' => $this->get_val($layer, 'loop_animation', 'none')
				)
			)
		);
		
		//}

		/**
		 * change timeline values of frame_1 depending on frame_0
		 **/
		/*$change = array(
			'x' => 0,
			'y' => 0,
			'z' => 0,
			'rotationX' => 0,
			'rotationY' => 0,
			'rotationZ' => 0,
			'scaleX' => 0,
			'scaleY' => 0,
			'skewX' => 0,
			'skewY' => 0,
			'opacity' => 1
		);
		
		foreach($change as $ck => $cv){
			if(isset($ml['timeline']['frames']['frame_0'][$ck])){
				if($ml['timeline']['frames']['frame_0'][$ck] !== $cv){
					$ml['timeline']['frames']['frame_1'][$ck] = $cv;
				}
			}
		}*/
		
		if($ml['timeline']['frames']['frame_0']['filter']['use'] === true){
			$ml['timeline']['frames']['frame_1']['filter']['use'] = true;
		}

		if(isset($ml['timeline']) && isset($ml['timeline']['frames']) && isset($ml['timeline']['frames']['frame_0']) && isset($ml['timeline']['frames']['frame_0']['timeline']) && isset($ml['timeline']['frames']['frame_0']['timeline']['endWithSlide'])){
			unset($ml['timeline']['frames']['frame_0']['timeline']['endWithSlide']);
		}

		$ml['effects'] = array(
			'effect' => 'default', //($this->on_counter >= 2 && $blank === false) ? true : false
			'parallax' => $this->get_val($deformation, 'parallax', '-'),
			'attachToBg' => ($this->get_val($layer, 'parallax_layer_ddd_zlevel') === 'bg') ? true : false
		);
		
		if($blank === false){ //only do this if we are not creating a blank layer
			if($this->on_counter === 1){
				if($this->on_layers === true){
					if($this->static_slide === false && ($this->parallax_slider === false || $this->parallax_slider === true && $ml['effects']['parallax'] === '-')){
						$ml['effects']['effect'] = 'true';
					}
				}
				if($this->on_static_layers === true){
					if($this->static_slide === true && ($this->parallax_slider === false || $this->parallax_slider === true && $ml['effects']['parallax'] === '-')){
						$ml['effects']['effect'] = 'true';
					}
				}
				if($this->on_parallax_layers === true){
					if($this->static_slide === false && $this->parallax_slider === true){
						if($ml['effects']['parallax'] !== '-'){
							$ml['effects']['effect'] = 'true';
						}
					}
				}
				if($this->on_parallax_static_layers === true){
					if($this->static_slide === true && $this->parallax_slider === true){
						if($ml['effects']['parallax'] !== '-'){
							$ml['effects']['effect'] = 'true';
						}
					}
				}
			}elseif($this->on_counter >= 2){
				$matches = false;
				if($this->on_layers === true){
					if($this->static_slide === false && ($this->parallax_slider === false || $this->parallax_slider === true && $ml['effects']['parallax'] === '-')){
						$matches = true;
					}
				}
				if($this->on_static_layers === true){
					if($this->static_slide === true && ($this->parallax_slider === false || $this->parallax_slider === true && $ml['effects']['parallax'] === '-')){
						$matches = true;
					}
				}
				if($this->on_parallax_layers === true){
					if($this->static_slide === false && $this->parallax_slider === true){
						if($ml['effects']['parallax'] !== '-'){
							$matches = true;
						}
					}
				}
				if($this->on_parallax_static_layers === true){
					if($this->static_slide === true && $this->parallax_slider === true){
						if($ml['effects']['parallax'] !== '-'){
							$matches = true;
						}
					}
				}
				
				if($matches === false){
					$ml['effects']['effect'] = 'false';
				}
			}
		}
		
		// see comment in ColorPicker class for new "correctValue" function
		$deformation['background-color'] = $color_picker->correctValue($this->get_val($deformation, 'background-color'), $this->get_val($deformation, 'background-transparency', false));

		if($this->get_val($deformation, 'color-transparency', false) !== false){
			$static_color = $this->get_val($static_styles, 'color', array());
			if(!empty($static_color)){
				foreach($static_color as $i => $s_color){
					$this->set_val($static_styles, array('color', $i), $color_picker->convert($s_color, $this->get_val($deformation, 'color-transparency') * 100));
				}
			}
		}
		
		// CHECK IF OLDER OBJ PADDING EXISTS (WITHOUT 4 LEVELS)
		$pdng = $this->get_val($layer, 'padding'); //done this way for older php versions
		$layer['padding'] = (!empty($pdng)) ? $pdng : $this->get_val($deformation, 'padding');

		if($this->get_val($layer, 'displaymode', false) !== false){
			if($this->get_val($layer, 'displaymode') === 'true' || $this->get_val($layer, 'displaymode') === true){
				$display = 'block';
			}else{
				$display = 'inline-block';
			}
		}else{
			$display = $this->get_val($layer, 'display', $this->get_val($layer, 'display', 'block'));
		}
		
		$bgc = $this->get_val($deformation, 'background-color', 'transparent');
		$bgt = $this->get_val($deformation, 'background-transparency', false);
		
		// see comment in ColorPicker class for new "correctValue" function
		$bgc = $color_picker->correctValue($bgc, $bgt);
		
		$cl = $this->get_val($deformation, 'corner_left', 'nothing');
		$cr = $this->get_val($deformation, 'corner_right', 'nothing');
		$cl = $this->get_val($this->_corners['cornerLeft'], $cl, 'none');
		$cr = $this->get_val($this->_corners['cornerRight'], $cr, 'none');
		
		$fs = $this->_truefalse($this->get_val($deformation, 'font-style', false));
		$fs = ($fs === 'normal') ? false : $fs;
		$fs = ($fs === 'italic') ? true : $fs;
		
		$ml['idle'] = array(
			'style' => $this->get_val($layer, 'style', ''),
			'color' => $this->c_to_resp(array('default' => '#ffffff', 'val' => $this->get_val($static_styles, 'color', '#ffffff'))),
			'margin' => $this->c_to_resp(array('default' => array(0, 0, 0, 0), 'val' => $this->get_val($layer, 'margin'))),
			'padding' => $this->c_to_resp(array('debug' => true, 'default' => array(0, 0, 0, 0), 'val' => $this->get_val($layer, 'padding'))),
			'marginLock' => false,
			'paddingLock' => false,
			'borderWidthLock' => false,
			'borderRadiusLock' => false,
			'autolinebreak' => $this->_truefalse($this->get_val($layer, 'autolinebreak', true)),
			'display' => $display,
			'fontFamily' => str_replace('"', '', $this->get_val($deformation, 'font-family', 'Roboto')),
			'fontStyle' => $fs,
			'fontSize' => $this->c_to_resp(array('default' => '20', 'val' => $this->get_val($static_styles, 'font-size'))),
			'fontWeight' => $this->c_to_resp(array('default' => '400', 'val' => $this->get_val($static_styles, 'font-weight'))),
			'letterSpacing' => $this->c_to_resp(array('default' => '0', 'val' => $this->get_val($static_styles, 'letter-spacing'))),
			'lineHeight' => $this->c_to_resp(array('default' => '25', 'val' => $this->get_val($static_styles, 'line-height'))),
			'overflow' => $this->get_val($deformation, 'overflow', 'visible'),
			'textAlign' => $this->c_to_resp(array('default' => 'left', 'val' => $this->get_val($layer, 'text-align', $this->get_val($deformation, 'text-align')))),
			'verticalAlign' => $this->get_val($deformation, 'vertical-align', 'top'),
			'cursor' => $this->get_val($deformation_hover, 'css_cursor', 'auto'),
			'backgroundColor' => $bgc,
			'backgroundPosition' => $this->get_val($layer, 'layer_bg_position', 'center center'),
			'backgroundRepeat' => $this->get_val($layer, 'layer_bg_repeat', 'no-repeat'),
			'backgroundSize' => $this->get_val($layer, 'layer_bg_size', 'cover'),
			'backgroundImage' => $this->get_val($layer, 'bgimage_url', ''),
			'backgroundImageId' => $this->get_image_id_by_url($this->get_val($layer, 'bgimage_url')),
			'borderColor' => $color_picker->correctValue($this->get_val($deformation, 'border-color', 'transparent'), $this->get_val($deformation, 'border-transparency', false)),
			'borderRadius' => $this->c_to_v_and_u(array('default' => array(0, 0, 0, 0), 'val' => $this->get_val($deformation, 'border-radius', array(0, 0, 0, 0)), 'u' => '%')),
			'borderStyle' => $this->c_to_resp(array('default' => 'none', 'val' => $this->get_val($deformation, 'border-style', 'none'))),
			'borderWidth' => $this->make_array($this->get_val($deformation, 'border-width', 0), 4),
			'textDecoration' => $this->get_val($deformation, 'text-decoration', 'none'),
			'textTransform' => $this->get_val($deformation, 'text-transform', 'none'),
			'whiteSpace' => $this->c_to_resp(array('default' => 'nowrap', 'val' => $this->get_val($layer, 'whitespace'))),
			'boxShadow' => array(
				'inuse' => false,
				'container' => 'content',
				'hoffset' => $this->c_to_resp(array('default' => 0, 'val' => 0)),
				'voffset' => $this->c_to_resp(array('default' => 0, 'val' => 0)),
				'blur' => $this->c_to_resp(array('default' => 0, 'val' => 0)),
				'spread' => $this->c_to_resp(array('default' => 0, 'val' => 0)),
				'color' => 'rgba(0,0,0,0)',
			),
			'textShadow' => array(
				'inuse' => false,
				'hoffset' => $this->c_to_resp(array('default' => 0, 'val' => 0)),
				'voffset' => $this->c_to_resp(array('default' => 0, 'val' => 0)),
				'blur' => $this->c_to_resp(array('default' => 0, 'val' => 0)),
				'color' => 'rgba(0,0,0,0)',
			),
			'filter' => array(
				'blendMode' => $this->get_val($layer, 'layer_blend_mode', 'normal'),
				'showInEditor' => true,
			),
			'cornerLeft' => $cl,
			'cornerRight' => $cr,
			'selectable' => $this->get_val($deformation, 'layer-selectable', 'default'),
			'svg' => array(
				'color' => $this->c_to_resp(array('default' => '#ffffff', 'val' => $this->get_val($static_styles, 'color', '#ffffff'))),
				'strokeColor' => $this->get_val($svg, 'svgstroke-color', 'transparent'),
				'strokeDashArray' => $this->get_val($svg, 'svgstroke-dasharray', 0),
				'strokeDashOffset' => $this->get_val($svg, 'svgstroke-dashoffset', 0),
				'strokeWidth' => $this->get_val($svg, 'svgstroke-width', 0),
			)
		);
		
		/**
		 * check if fontfamily is a google font
		 * if yes
		 * 	-> check if fontweight exists in this google font
		 * 		-> If no, reset to 400
		 **/
		$_ff = str_replace(array('"', '"'), '', $ml['idle']['fontFamily']);
		
		if(isset($this->googlefonts[$_ff])){
			$_fw = $ml['idle']['fontWeight'];
			
			if(is_array($_fw)){
				foreach($_fw as $device => $d_val){
					$_d_v = $this->get_val($d_val, 'v');
					//check if fontweight exists!
					$fw = $this->get_val($this->googlefonts, array($_ff, 'variants'), array());
					$fw_found = false;
					if(!empty($fw)){
						foreach($fw as $w){
							if($w == $_d_v){
								$fw_found = true;
								break;
							}
						}
					}
					
					if($fw_found === false){
						if(!empty($fw)){
							if($_d_v > 400) arsort($fw); //change array from high to low
							
							foreach($fw as $w){
								$w = intval($w);
								if($w === 0) continue; //remove the italic ones
								
								if($_d_v < 400){
									//get next bigger one
									if($w > $_d_v){
										$ml['idle']['fontWeight'][$device]['v'] = $w;
										break;
									}
								}else{
									//get next lower one
									if($w < $_d_v){
										$ml['idle']['fontWeight'][$device]['v'] = $w;
										break;
									}
								}
							}
							
							//if not found, jump to the first found
							if(intval($_d_v) == $ml['idle']['fontWeight'][$device]['v']){
								asort($fw); //sort back from lowest to hightest
								foreach($fw as $w){
									$w = intval($w);
									if($w === 0) continue; //remove the italic ones
									$ml['idle']['fontWeight'][$device]['v'] = $w;
									break;
								}
							}
							
							//$ml['idle']['fontWeight'] = $this->c_to_resp(array('default' => '400', 'val' => $ml['idle']['fontWeight']));
						}
					}
				}
			}
		}
		
		$colorch = $this->get_val($deformation_hover, 'color', '#ffffff');
		$colorht = $this->get_val($deformation_hover, 'color-transparency', false);
		if($colorht !== false) $colorch = $color_picker->convert($colorch, $colorht);
		
		$bghc = $this->get_val($deformation_hover, 'background-color', 'transparent');
		$bght = $this->get_val($deformation_hover, 'background-transparency', false);
		
		// see comment in ColorPicker class for new "correctValue" function
		$bghc = $color_picker->correctValue($bghc, $bght);
		
		$hover_pe = (strpos($this->get_val($layer, 'attrClasses', ''), 'nopointerevent') !== false) ? 'none' : $this->get_val($deformation_hover, 'pointer_events', 'auto');
		$hover_pe = (strpos($this->get_val($layer, 'attrClasses', ''), 'tp-nopointer') !== false) ? 'none' : $hover_pe;
		$hover_pe = (strpos($this->get_val($layer, 'attrWrapperClasses', ''), 'nopointerevent') !== false) ? 'none' : $hover_pe;
		$hover_pe = (strpos($this->get_val($layer, 'attrWrapperClasses', ''), 'tp-nopointer') !== false) ? 'none' : $hover_pe;
		
		$ml['hover'] = array(
			'usehover' => $this->_truefalse($this->get_val($layer, 'hover', false)),
			'color' => $colorch,
			'opacity' => $this->get_val($deformation_hover, 'opacity', 1),
			'backgroundColor' => $bghc,
			'borderColor' => $color_picker->correctValue($this->get_val($deformation_hover, 'border-color', 'transparent'), $this->get_val($deformation_hover, 'border-transparency', false)),
			'borderRadius' => $this->c_to_v_and_u(array('default' => array(0, 0, 0, 0), 'val' => $this->get_val($deformation_hover, 'border-radius', array(0, 0, 0, 0)), 'u' => '%')),
			'borderStyle' => $this->get_val($deformation_hover, 'border-style', 'none'),
			'borderWidth' => $this->make_array($this->get_val($deformation_hover, 'border-width', 0), 4),
			'transformPerspective' => '600',
			'originX' => $this->get_val($deformation_hover, '2d_origin_x', '50%'),
			'originY' => $this->get_val($deformation_hover, '2d_origin_y', '50%'),
			'originZ' => '0',
			'rotationZ' => $this->get_val($deformation_hover, '2d_rotation', 0),
			'rotationX' => $this->get_val($deformation_hover, 'xrotate', 0),
			'rotationY' => $this->get_val($deformation_hover, 'yrotate', 0),
			'scaleX' => $this->get_val($deformation_hover, 'scalex', 1),
			'scaleY' => $this->get_val($deformation_hover, 'scaley', 1),
			'skewX' => $this->get_val($deformation_hover, 'skewx', 0),
			'skewY' => $this->get_val($deformation_hover, 'skewy', 0),
			'textDecoration' => $this->get_val($deformation_hover, 'text-decoration', 'none'),
			'x' => $this->get_val($deformation_hover, 'x', 0),
			'y' => $this->get_val($deformation_hover, 'y', 0),
			'z' => $this->get_val($deformation_hover, 'z', 0),
			'speed' => $this->get_val($deformation_hover, 'speed', 300),
			'ease' => $this->get_val($deformation_hover, 'easing', 'none'), //power3.inOut
			'zIndex' => $this->get_val($deformation_hover, 'zindex', 'auto'),
			'pointerEvents' => $hover_pe,
			'filter' => array(
				'grayscale' => $this->get_val($deformation_hover, 'grayscalefilter', 0),
				'brightness' => $this->get_val($deformation_hover, 'brightnessfilter', 100),
				'blur' => $this->get_val($deformation_hover, 'blurfilter', 0),
			),
			'svg' => array(
				'color' => $this->get_val($deformation_hover, 'color', '#ffffff'),
				'strokeColor' => $this->get_val($svg, 'svgstroke-hover-color', 'transparent'),
				'strokeDashArray' => $this->get_val($svg, 'svgstroke-hover-dasharray', 0),
				'strokeDashOffset' => $this->get_val($svg, 'svgstroke-hover-dashoffset', 0),
				'strokeWidth' => $this->get_val($svg, 'svgstroke-hover-width', 0),
			),
		);
		
		$ml['actions'] = array(
			'action' => array(),
			'animationoverwrite' => $this->get_val($layer, 'animation_overwrite', 'default'),
			'triggerMemory' => $this->get_val($layer, 'trigger_memory', 'reset'),
		);

		if(!empty($layer_action)){
			$actions = $this->get_val($layer_action, 'action');
			foreach($actions as $i => $action){
				$ml['actions']['action'][] = array();
				
				foreach($layer_action as $attr => $l_action){
					if(isset($l_action[$i])){
						$ml['actions']['action'][$i][$attr] = $l_action[$i];
					}else{
						$ml['actions']['action'][$i][$attr] = '';
					}
				}
			}
			
			$new_actions = $this->get_val($ml, array('actions', 'action'), array());
			if(!empty($new_actions)){
				foreach($new_actions as $a_k => $n_a){
					
					if(in_array($this->get_val($n_a, 'action'), array('start_in', 'start_out', 'toggle_layer'), true)){
						$this->slide_action_map[] = ($this->static_slide) ? 'static-'.$this->get_val($n_a, 'layer_target') : $this->get_val($n_a, 'layer_target');
					}
					
					//group row column
					if(in_array($this->get_val($ml, 'type', 'text'), array('row', 'group', 'column'), true)){
						if($this->get_val($n_a, 'action') === 'link'){
							$ml['actions']['action'][$a_k]['link_type'] = 'jquery';
						}
					}
				}
			}
		}
		
		$ml['visibility'] = array(
			'visible' => ($this->get_val($layer, 'visible', 'invisible') === 'invisible') ? true : $this->_truefalse($this->get_val($layer, 'visible', true)),
			'locked' => false,
			'd' => $this->_truefalse($this->get_val($layer, 'visible-desktop', true)),
			'm' => $this->_truefalse($this->get_val($layer, 'visible-mobile', true)),
			'n' => $this->_truefalse($this->get_val($layer, 'visible-notebook', true)),
			't' => $this->_truefalse($this->get_val($layer, 'visible-tablet', true)),
			'hideunder' => $this->_truefalse($this->get_val($layer, 'hiddenunder', false)),
			'onlyOnSlideHover' => $this->_truefalse($this->get_val($layer, 'show-on-hover', false)),
		);
		$ml['runtime'] = $this->get_val($layer, 'runtime', array(
			'internalClass' => $this->get_val($layer, 'internal_class', ''),
			'isDemo' => false,
			'unavailable' => false,
		));

		$ml['customCSS'] = '';
		$ml['customHoverCSS'] = '';

		$inline = $this->get_val($layer, 'inline', array());
		$idle = $this->get_val($inline, 'idle', false);
		$hover = $this->get_val($inline, 'hover', false);
		
		if($idle !== false && (is_object($idle) || is_array($idle)) && !empty($idle)){
			foreach($idle as $key => $idl){
				$ml['customCSS'] .= $key .':'. $idl . ";\n";
			}
		}
		if($hover !== false && (is_object($hover) || is_array($hover)) && !empty($hover)){
			foreach($hover as $key => $hov){
				$ml['customHoverCSS'] .= $key .':'. $hov . ";\n";
			}
		}
		
		//add navigation advanced style idle if set into the customCSS
		//add navigation advanced style hover if set into the customHoverCSS
		$_style = $this->get_val($ml, array('idle', 'style'), '');
		if($_style !== ''){
			$css = $this->get_css_navigations();
			$_adv = $this->get_val($css, '.tp-caption.'.$_style, array());
			if(!empty($_adv)){
				$_idle = $this->get_val($_adv, array('advanced', 'idle'), array());
				$_hover = $this->get_val($_adv, array('advanced', 'hover'), array());
				if(!empty($_idle) && is_array($_idle)){
					foreach($_idle as $ik => $iv){
						$ml['customCSS'] .= $ik.':'.$iv.';'."\n";
					}
				}
				if(!empty($_hover) && is_array($_hover)){
					foreach($_hover as $hk => $hv){
						$ml['customHoverCSS'] .= $hk.':'.$hv.';'."\n";
					}
				}
				
				//check also params for css which is not default selectable
				//check also hover for css which is not default selectable
				
				//push letter-spacing if it was not available already
				if($this->get_val($static_styles, 'letter-spacing') === ''){
					$ls = $this->get_val($_adv, array('params', 'letter-spacing'));
					if($ls !== ''){
						$ml['idle']['letterSpacing'] = $this->c_to_resp(array('default' => '0', 'val' => $ls));
					}
				}
			}
		}
		
		// exploding layers migration
		$exploding = $this->get_val($layer, 'explodinglayers', false);
		if(!empty($exploding)){
			
			$frames = $this->get_val($layer, 'frames', array());
			$frame_0 = $this->get_val($frames, 'frame_0', array());
			$frame_999 = $this->get_val($frames, 'frame_999', array());
			$enabled_in = $this->get_val($frame_0, 'animation', false);
			$enabled_out = $this->get_val($frame_999, 'animation', false);
			
			// animation in enabled
			if($enabled_in === 'explodinglayers'){
				$ml['timeline']['frames']['frame_1']['explodinglayers'] = $this->write_exploding_layer($exploding, 'in');
			}
			
			// handle 'auto reverse' possibility
			if($enabled_out === 'auto') $enabled_out = $enabled_in === 'explodinglayers' ? 'explodinglayers' : false;
			
			// animation out enabled
			if($enabled_out === 'explodinglayers'){
				$ml['timeline']['frames']['frame_999']['explodinglayers'] = $this->write_exploding_layer($exploding, 'out');
			}
			
		}

		return $ml;
	}
	
	
	/**
	 * remove unneeded data from the slider settings
	 **/
	public function remove_unneeded_slider_settings($sliders){
		$sr = new RevSliderSlider();
		$sliders = ($sliders === false) ? $sr->get_sliders() : array($sliders); //do it on all Sliders if false

		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$update = false;
				$params = $slider->get_params();
				/**
				 * the particles addon data
				 * are not needed in the slider settings
				 **/
				if($this->get_val($params, array('addOns', 'revslider-particles-addon', 'enable'), false) !== false){
					$this->set_val($params, array('addOns', 'revslider-particles-addon'), array());
					$this->set_val($params, array('addOns', 'revslider-particles-addon', 'enable'), true);
					$update = true;
				}
				
				if($update === true){
					$slider->update_params($params, true);
				}
			}
		}
	}
	
	/**
	 * exploding layers migration
	 **/
	private function write_exploding_layer($exploding, $tpe){
		
		$color       = $this->get_val($exploding, 'color_'       . $tpe, array('#000000'));
		$density     = $this->get_val($exploding, 'density_'     . $tpe, array('1'));
		$direction   = $this->get_val($exploding, 'direction_'   . $tpe, array('left'));
		$padding     = $this->get_val($exploding, 'padding_'     . $tpe, array('150'));
		$power       = $this->get_val($exploding, 'power_'       . $tpe, array('2'));
		$randomsize  = $this->get_val($exploding, 'randomsize_'  . $tpe, array(false));
		$randomspeed = $this->get_val($exploding, 'randomspeed_' . $tpe, array(false));
		$size        = $this->get_val($exploding, 'size_'        . $tpe, array('5'));
		$speed       = $this->get_val($exploding, 'speed_'       . $tpe, array('1'));
		$style       = $this->get_val($exploding, 'style_'       . $tpe, array('fill'));
		$sync        = $this->get_val($exploding, 'sync_'        . $tpe, array(false));
		$type        = $this->get_val($exploding, 'type_'        . $tpe, array('circle'));
		
		$sync = is_array($sync) ? $sync[0] : $sync;
		$randomsize = is_array($randomsize) ? $randomsize[0] : $randomsize;
		$randomspeed = is_array($randomspeed) ? $randomspeed[0] : $randomspeed;
		
		// previous values used to be 4 levels, convert to 1 level via Kris suggestion
		return array(
			'type'        => is_array($type) ? $type[0] : $type,
			'color'       => is_array($color) ? $color[0] : $color,
			'density'     => is_array($density) ? $density[0] : $density,
			'direction'   => is_array($direction) ? $direction[0] : $direction,
			'padding'     => is_array($padding) ? $padding[0] : $padding,
			'power'       => is_array($power) ? $power[0] : $power,
			'size'        => is_array($size) ? $size[0] : $size,
			'speed'       => is_array($speed) ? $speed[0] : $speed,
			'style'       => is_array($style) ? $style[0] : $style,
			'sync'        => $this->_truefalse($sync),
			'randomsize'  => $this->_truefalse($randomsize),
			'randomspeed' => $this->_truefalse($randomspeed),
			'use'         => true
		);
		
	}
	
	/**
	 * If the plugin was WP activated in 5.0, it needs to be "enabled" in 6.0
	 * Only 404 and Maintenance had individual "active" options.  All others were auto-active in 5.0
	 **/
	private function change_global_addon_settings_to_6_0(){
		
		include_once(ABSPATH . 'wp-admin/includes/plugin.php');
		if(function_exists('is_plugin_active')){
			
			// 404 pages
			if(is_plugin_active('revslider-404-addon/revslider-404-addon.php')){
				
				$settings = get_option('revslider_404_addon');
				if($settings !== false){
					$options = array();
					parse_str($settings, $options);
					if(isset($options['revslider-404-addon-active']) && intval($options['revslider-404-addon-active'])){
						update_option('revslider_404_enabled', 1);
					}
				}
				
			}
			
			// maintenance & coming soon
			if(is_plugin_active('revslider-maintenance-addon/revslider-maintenance-addon.php')){
				
				$settings = get_option('revslider_maintenance_addon');
				if($settings !== false){
					$options = array();
					parse_str($settings, $options);
					if(isset($options['revslider-maintenance-addon-active']) && intval($options['revslider-maintenance-addon-active'])){
						update_option('revslider_maintenance_enabled', 1);
					}
				}
				
			}
			
			// slide backups
			// 5.0 Slide backups get converted dynamically if/when the user attempts to restore them
			// This conversion takes place inside the AddOn's "restore_slide_backup" function
			if(is_plugin_active('revslider-backup-addon/revslider-backup-addon.php')){
				update_option('revslider_backup_enabled', 1);	
			}
			
			// featured slider
			if(is_plugin_active('revslider-featured-addon/revslider-featured-addon.php')){
				update_option('revslider_featured_enabled', 1);	
			}
			
			// wp gallery
			if(is_plugin_active('revslider-gallery-addon/revslider-gallery-addon.php')){
				update_option('revslider_gallery_enabled', 1);	
			}
			
			// login
			if(is_plugin_active('revslider-login-addon/revslider-login-addon.php')){
				update_option('revslider_login_enabled', 1);	
			}
			
			// social sharing
			if(is_plugin_active('revslider-sharing-addon/revslider-sharing-addon')){
				update_option('revslider_sharing_enabled', 1);	
			}
			
			// related posts slider
			if(is_plugin_active('revslider-rel-posts-addon/revslider-rel-posts-addon.php')){
				update_option('revslider_rel_posts_enabled', 1);	
			}
			
			// prev/next slider
			if(is_plugin_active('revslider-prevnext-posts-addon/revslider-prevnext-posts-addon.php')){
				update_option('revslider_prevnext_posts_enabled', 1);	
			}	
			
		}
	}
	
	/**
	 * change the global setting to 6.2.0
	 **/
	public function change_global_settings_to_6_2_0(){
		$global = maybe_unserialize(get_option('revslider-global-settings', '')); //get the old structure as serialized
		
		$global = (!is_array($global)) ? json_decode($global, true) : $global;
		
		if(is_array($global)){ //means we are not json, so we are on 5.x
			$version = $this->get_val($global, 'version', '1.0.0');
			
			if(version_compare($version, '6.2.0', '>=')) return true; //already on 6.0
			
			$global['version'] = '6.2.0';
			
			if(isset($global['customfonts'])){
				$global['customFontList'] = array();
				
				$cfa = (!empty($global['customfonts'])) ? explode(',', $global['customfonts']) : ''; //pre 6.2.0
				
				if(!empty($cfa)){
					foreach($cfa as $font){
						$global['customFontList'][] = array(
							'family'	=> $font,
							'url'		=> '',
							'frontend'	=> false,
							'backend'	=> true,
							'weights'	=> '200,300,400,500,600,700,800,900',
						);
					}
				}
				
				unset($global['customfonts']);
			}
		
			$this->set_global_settings($global);
		}
	}

	/**
	 * change the layer animations to version 6.2.0
	 **/
	public function change_animations_settings_to_6_2_0($anims = false){
		if($anims === false){
			$custom_in	 = $this->get_animations();
			$custom_out	 = $this->get_end_animations();
			$custom_loop = $this->get_loop_animations();
			$anims = $custom_in + $custom_out + $custom_loop;
		}
		
		if(!empty($anims)){
			global $wpdb;
			
			foreach($anims as $_){
				$id = $_['id'];
				unset($_['id']);
				unset($_['settings']);
				$json_anim = $_json_anim = json_encode($_);
				
				$_json_anim = str_replace($this->update['620']['ease_adv_from'], $this->update['620']['ease_adv_to'], $_json_anim);
				
				
				if($_json_anim !== $json_anim){
					$arr['params'] = $_json_anim;
					
					$result = $wpdb->update($wpdb->prefix . RevSliderFront::TABLE_LAYER_ANIMATIONS, $arr, array('id' => $id));
				}
			}
		}
		
	}
	
	/**
	 * change the layer animations to version 6.0.0
	 **/
	public function change_animations_settings_to_6_0($anims = false){
		//do on all navigations ?
		$anims = ($anims === false) ? $this->get_animations_v5() : (array)$anims;
		
		if(!empty($anims)){
			global $wpdb;
			
			foreach($anims as $_){
				if($this->get_val($_, 'settings') === 'in' || $this->get_val($_, 'settings') === 'out'){ //ignore, as already converted to 6.0
					continue;
				}else{
					if(is_string($this->get_val($_, 'params'))){
						$_['params'] = json_decode($this->get_val($_, 'params'), true);
					}
					$gid = ($this->get_val($_, array('params', 'type')) == 'customin') ? 'in' : 'out';
					$fr = ($gid === 'in') ? 'frame_0' : 'frame_999';
					$tr = array('name' =>  $this->get_val($_, 'handle'));
					$tr[$fr] = array('transform' => array(), 'timeline' => array());
					
					if($gid === 'in'){
						$tr['frame_1'] = array('timeline' => array('speed' => $this->get_val($_, array('params', 'speed')), 'ease' => $this->get_val($_, array('params', 'easing'))));
					}else{
						$tr['frame_999']['timeline'] = array('speed' => $this->get_val($_, 'params', 'speed'), 'ease' => $this->get_val($_, array('params', 'easing')));
					}

					// CHECK IF ANIMATION HAS MASK
					if($this->_truefalse($this->get_val($_, array('params', 'mask'))) == true){
						$tr[$fr]['mask'] = array('use' => true, 'x' => $this->get_val($_, array('params', 'mask_x')), 'y' => $this->get_val($_, array('params', 'mask_y')));
						if($gid === 'in') $tr['frame_1']['mask'] = array('use' => true, 'x' => 0, 'y' => 0);
					}

					$inside = $tr[$fr]['transform'];
					$splithelp = array('use' => true, 'delay' => $this->get_val($_, array('params', 'splitdelay')));

					// SET TARGET ANIMATION TO SPLIT OR LAYER
					switch($this->get_val($_, array('params', 'split'))){
						case 'lines':
						case 'line':
							$tr[$fr]['lines'] = $splithelp;
							$inside = $tr[$fr]['lines'];
							if($gid === 'in') $tr['frame_1']['lines'] = $splithelp;
						break;
						case 'words':
						case 'word':
							$tr[$fr]['words'] = $splithelp;
							$inside = $tr[$fr]['words'];
							if($gid === 'in') $tr['frame_1']['words'] = $splithelp;
						break;
						case 'chars':
						case 'char':
							$tr[$fr]['chars'] = $splithelp;
							$inside = $tr[$fr]['chars'];
							if($gid === 'in') $tr['frame_1']['chars'] = $splithelp;
						break;
					}


					$opacity = $this->get_val($_, array('params', 'captionopacity'), '######');
					if($opacity !== '######') $inside['opacity'] = $opacity;

					// GO THROUGH THE PARAMS AND CREATE THEM IF NEEDED
					if(!empty($_['params'])){
						foreach($_['params'] as $key => $val){
							if(in_array($val, array('inherit', '0', 0, '0px'))) continue;
							switch($key){
								case 'movex':
									$inside['x'] = $val;
								break;
								case 'movey':
									$inside['y'] = $val;
								break;
								case 'movez':
									$inside['z'] = $val;
								break;
								case 'rotationx':
									$inside['rotationX'] = $val;
								break;
								case 'rotationy':
									$inside['rotationY'] = $val;
								break;
								case 'rotationz':
									$inside['rotationZ'] = $val;
								break;
								case 'skewx':
									$inside['skewX'] = $val;
								break;
								case 'skewy':
									$inside['skewY'] = $val;
								break;
							}
						}
					}
					//change the animation in the database by id
					$tr[$fr]['transform'] = $inside;
					
					$t = ($gid === 'in') ? 'in' : 'out';
					
					$arr = array(
						'handle'	=> $this->get_val($tr, 'name'),
						'params'	=> json_encode($tr),
						'settings'	=> $t
					);
					
					$result = $wpdb->update($wpdb->prefix . RevSliderFront::TABLE_LAYER_ANIMATIONS, $arr, array('id' => $_['id']));
				}
			}
		}
	}
	
	/**
	 * Migrate the Global Settings to the new 6.0 structure
	 * @since: 6.0
	 **/
	public function change_global_settings_to_6_0(){
		$global = maybe_unserialize(get_option('revslider-global-settings', '')); //get the old structure as serialized
		
		if(is_array($global)){ //means we are not json, so we are on 5.x
			$version = $this->get_val($global, 'version', '1.0.0');
			
			if(version_compare($version, '6.0.0', '>=')) return true; //already on 6.0
			
			$g = array(
				'version' => '6.0.0',
				'permission' => $this->get_val($global, 'role', 'admin'),
				//'include' => $this->_truefalse($this->get_val($global, 'includes_globally', true)),
				'includeids' => $this->get_val($global, 'pages_for_includes', ''),
				'script' => array(
					'footer' => $this->_truefalse($this->get_val($global, 'js_to_footer', true)),
					'defer' => $this->_truefalse($this->get_val($global, 'js_defer', true)),
					'full' => $this->_truefalse($this->get_val($global, 'load_all_javascript', false))
				),
				'fonturl' => $this->get_val($global, 'change_font_loading', ''),
				'size' => array(
					'desktop' => $this->get_val($global, 'width', 1240),
					'notebook' => $this->get_val($global, 'width_notebook', 1024),
					'tablet' => $this->get_val($global, 'width_tablet', 778),
					'mobile' => $this->get_val($global, 'width_mobile', 480)
				)
			);
			
			$this->set_global_settings($g);
		}
	}
	
	/**
	 * Migrate the Navigations that were existing prior to version 6.0
	 * @since: 6.0
	 **/
	public function change_navigation_settings_to_6_0($navs = false, $return = false){
		global $wpdb;

		$rs_nav = new RevSliderNavigation();
		//do on all navigations ?
		$navs = ($navs === false) ? $rs_nav->get_all_navigations(false, false, true) : (array) $navs;

		$new_navs = array();
		if(!empty($navs)){
			//clear all navigations in database and create new ones out of $new_nav
			$wpdb->query('TRUNCATE TABLE '. $wpdb->prefix . RevSliderFront::TABLE_NAVIGATIONS);

			//now push all again back in with new IDs
			foreach($navs as $nav){
				$nav['css'] = (!is_array($nav['css'])) ? json_decode($nav['css'], true) : $nav['css'];
				$nav['markup'] = (!is_array($nav['markup'])) ? json_decode($nav['markup'], true) : $nav['markup'];
				
				foreach($this->navtypes as $navtype){
					if(isset($nav['css'][$navtype]) && !empty($nav['css'][$navtype])){
						//otherwise we are already on 6.0
						$new_nav = $this->create_new_navigation_6_0($nav, $navtype);
						$wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_NAVIGATIONS,
							array(
								'name' => $this->get_val($new_nav, 'name'),
								'handle' => $this->get_val($new_nav, 'handle'),
								'type' => $navtype,
								'css' => $this->get_val($new_nav, 'css'),
								'markup' => $this->get_val($new_nav, 'markup'),
								'settings' => json_encode($this->get_val($new_nav, 'settings')),
							)
						);

						$new_navs[] = $new_nav;
					}
				}
			}
		}

		return $new_navs;
	}

	/**
	 * Change navigation css that needs to be used since 6.4.9
	 * @since: 6.4.9
	 **/
	public function change_navigation_settings_to_6_4_10($navs = false, $return = false){
		global $wpdb;
		
		/**
		 * some customers had an version inbetween, where $find was wrongly translated into this here
		 * so we need to replace $find2 also with $replace and this has to happen first!
		 **/
		$find2 = array(
			'.tp-bullets:hover.rs.touchhover',
			'.tp-bullet.rs.touchhover',
			'.tp-tab.rs.touchhover',
			'.tp-tabs.rs.touchhover',
			'.tp-thumb.rs.touchhover',
			'.tp-thumbs.rs.touchhover',
			'.tparrows.rs-touchhover',
			'.tp-rightarrow.rs.touchhover',
			'.tp-leftarrow.rs.touchhover'
		);
		$find = array(
			'.tp-bullets:hover',
			'.tp-bullet:hover',
			'.tp-tab:hover',
			'.tp-tabs:hover',
			'.tp-thumb:hover',
			'.tp-thumbs:hover',
			'.tparrows:hover',
			'.tp-rightarrow:hover',
			'.tp-leftarrow:hover'
		);
		$replace = array(
			'.tp-bullets.rs-touchhover',
			'.tp-bullet.rs-touchhover',
			'.tp-tab.rs-touchhover',
			'.tp-tabs.rs-touchhover',
			'.tp-thumb.rs-touchhover',
			'.tp-thumbs.rs-touchhover',
			'.tparrows.rs-touchhover',
			'.tp-rightarrow.rs-touchhover',
			'.tp-leftarrow.rs-touchhover'
		);
		
		$rs_nav = new RevSliderNavigation();
		//do on all navigations ?
		$navs = ($navs === false) ? $rs_nav->get_all_navigations(false, false, true) : (array) $navs;
		
		if(!empty($navs)){
			//now push all again back in with new IDs
			foreach($navs as $id => $nav){
				$css = $this->get_val($nav, 'css');
				$css = str_replace($find2, $replace, $css);
				$css = str_replace($find, $replace, $css);
				if($css !== $this->get_val($nav, 'css')){
					//update the css
					$response = $wpdb->update(
						$wpdb->prefix.RevSliderFront::TABLE_NAVIGATIONS,
						array('css' => $css),
						array('id' => $this->get_val($nav, 'id'))
					);
				}
			}
		}
	}
	
	/**
	 * Go through all Slider and change the navigations handle to id
	 **/
	public function change_navigation_slider_to_6_0($sliders = false){
		$sr = new RevSliderSlider();
		$rs_nav = new RevSliderNavigation();
		$navigations = $rs_nav->get_all_navigations_builder();

		$default = RevSliderNavigation::get_default_navigations();
		
		if($sliders === false){
			//do it on all Sliders
			$sliders = $sr->get_sliders();
		}else{
			$sliders = array($sliders);
		}

		$navs = array('arrows' => 'navigation_arrow_style', 'bullets' => 'navigation_bullets_style', 'tabs' => 'tabs_style', 'thumbs' => 'thumbnails_style');
		//$navs = array('arrows' => array('nav', 'arrows', 'style'), 'bullets' => array('nav', 'bullets', 'style'), 'tabs' => array('nav', 'tabs', 'style'), 'thumbs' => array('nav', 'thumbs', 'style'));

		if(!empty($sliders) && is_array($sliders)){
			$update = array();
			foreach($sliders as $slider){
				//$p = $slider->get_params();
				foreach($navs as $type => $n){
					$v = $slider->get_param($n, '');

					if($v !== ''){
						$found = false;
						$v = $rs_nav->translate_navigation($v); //translate $v if it was a factory one and has a certain handle
						foreach($navigations[$type] as $id => $nav){
							if($nav['handle'] != $v) continue;
							
							$update[$n] = $id;
							//$p['nav'][$type]['style'] = $id;
							$found = true;
							break;
						}
						if($found === false){
							foreach($navigations[$type] as $id => $nav){
								if($nav['handle'] != 'custom') continue;
								
								$update[$n] = $id; //set to the custom nav as no nav found
								break;
							}
						}
					}
				}
				
				$slider->update_params($update);
				
				$params = $slider->get_params();
				//$slider->update_params($p);
			}
		}
	}

	/**
	 * transform an old navigation into the 6.0.0 version
	 **/
	public function create_new_navigation_6_0($_, $t){
		$n = array(
			'id' => $this->get_val($_, 'id'),
			'handle' => $this->get_val($_, 'handle'),
			'name' => $this->get_val($_, 'name'),
			'type' => $t,
			'css' => $this->get_val($_, array('css', $t)),
			'markup' => $this->get_val($_, array('markup', $t)),
			'settings' => array(
				'dim' => array('width' => $this->get_val($_, array('settings', 'width', $t), 160), 'height' => $this->get_val($_, array('settings', 'height', $t), 160)),
				'placeholders' => new stdClass(),
				'presets' => new stdClass(),
				'version' => '6.0.0',
			),
		);

		$placeholders = $this->get_val($_, array('settings', 'placeholders'), array());
		if(!empty($placeholders)){
			foreach($placeholders as $placeholder){
				if($this->get_val($placeholder, 'nav-type') === $t){
					$n['settings']['placeholders']->{$this->get_val($placeholder, 'handle')} = array(
						'title' => $this->get_val($placeholder, 'title'),
						'type' => $this->get_val($placeholder, 'type'),
						'data' => ($this->get_val($placeholder, 'type') === 'font-family') ? $this->get_val($placeholder, array('data', 'font_family')) : $this->get_val($placeholder, array('data', $this->get_val($placeholder, 'type'))),
					);
				}
			}
		}

		$presets = $this->get_val($_, array('settings', 'presets'), array());
		if(!empty($presets)){
			foreach($presets as $preset){
				if($this->get_val($preset, 'type') === $t){
					$n['settings']['presets']->{$this->get_val($preset, 'handle')} = array(
						'name' => $this->get_val($preset, 'name'),
						'values' => array(),
					);

					$values = $this->get_val($preset, 'values', array());
					if(!empty($values)){
						foreach($values as $j => $value){
							$handle = str_replace(array('ph-'. $_['handle'] .'-'. $t .'-', '-color', '-rgba', '-custom'), '', $j);
							$n['settings']['presets']->{$this->get_val($preset, 'handle')}['values'][$handle] = $value;
						}
					}
				}
			}
		}

		return $n;
	}

	/**
	 * Migrate the Slider AddOns that were existing prior to version 6.0
	 * @since: 6.0
	 **/
	public function migrate_slider_AddOn($_){
		$obj = array();
		//WHITEBOARD MIGRATION
		if($_->get_param('wb_enable', false) !== false){
			$obj['revslider-whiteboard-addon'] = array(
				'enable' => $this->_truefalse($_->get_param('wb_enable')),
				'writehand' => array(
					'width' => $_->get_param('wb_writehand_width', 572),
					'height' => $_->get_param('wb_writehand_height', 691),
					'originX' => $_->get_param('wb_writehand_origin_x', 49),
					'originY' => $_->get_param('wb_writehand_origin_y', 50),
					'source' => ($_->get_param('wb_writehand_source') === '1') ? WP_PLUGIN_URL .'/revslider-whiteboard-addon/'.'assets/images/write_right_angle.png' : $_->get_param('wb_writehand_source_custom', WP_PLUGIN_URL .'/revslider-whiteboard-addon/'.'assets/images/write_right_angle.png'),
				),
				'movehand' => array(
					'width' => $_->get_param('wb_movehand_width', 400),
					'height' => $_->get_param('wb_movehand_height', 100),
					'originX' => $_->get_param('wb_movehand_origin_x', 185),
					'originY' => $_->get_param('wb_movehand_origin_y', 66),
					'source' => ($_->get_param('wb_movehand_source') === '1') ? WP_PLUGIN_URL .'/revslider-whiteboard-addon/'.'assets/images/hand_point_right.png' : $_->get_param('wb_movehand_source_custom', WP_PLUGIN_URL .'/revslider-whiteboard-addon/'.'assets/images/hand_point_right.png'),
				),
			);
		}
		
		// RELOAD MIGRATION 
		if($_->get_param('revslider-refresh-enabled', false) !== false){
			$obj['revslider-refresh-addon'] = array(
				'enable' => $this->_truefalse($_->get_param('revslider-refresh-enabled')),
				'type' => $_->get_param('revslider-refresh-type', 'time'),
				'minutes' => $_->get_param('revslider-refresh-min', 10),
				'slide' => $_->get_param('revslider-refresh-slide', 1),
				'loops' => $_->get_param('revslider-refresh-loops', 1),
				'url_enable' => $_->get_param('revslider-refresh-url-enable', false),
				'custom_url' => $_->get_param('revslider-refresh-custom-url', 'http://')
			);
		}

		//SLICEY MIGRATION (NO DEFAULTS NEEDED, LEAVE IT OUT !!)
		if($_->get_param('slicey_enabled', false) !== false){
			$obj['revslider-slicey-addon'] = array('enable' => $this->_truefalse($_->get_param('slicey_enabled')));
		}

		//EXPLODING LAYERS MIGRATION (NO DEFAULTS NEEDED, LEAVE IT OUT !!)
		if($_->get_param('explodinglayers_enabled', false) !== false){
			$obj['revslider-explodinglayers-addon'] = array('enable' => $this->_truefalse($_->get_param('explodinglayers_enabled')));
		}

		//PAINTBRUSH MIGRATION (NO DEFAULTS NEEDED, LEAVE IT OUT !!)
		if($_->get_param('paintbrush_enabled', false) !== false){
			$obj['revslider-paintbrush-addon'] = array('enable' => $this->_truefalse($_->get_param('paintbrush_enabled', false)));
		}

		//DISTORTION MIGRARTION (NO DEFAULTS NEEDED, LEAVE IT OUT !!)
		if($_->get_param('liquideffect_enabled', false) !== false){
			$obj['revslider-liquideffect-addon'] = array('enable' => $this->_truefalse($_->get_param('liquideffect_enabled', false)));
		}

		//PANORAMA MIGRATION (NO DEFAULTS NEEDED, LEAVE IT OUT !!)
		if($_->get_param('panorama_enabled', false) !== false){
			$obj['revslider-panorama-addon'] = array('enable' => $this->_truefalse($_->get_param('panorama_enabled', false)));
		}

		//TYPEWRITER MIGRATION (NO DEFAULTS NEEDED, LEAVE IT OUT !!)
		if($_->get_param('typewriter_defaults_enabled', false) !== false){
			$obj['revslider-typewriter-addon'] = array('enable' => $this->_truefalse($_->get_param('typewriter_defaults_enabled')));
		}

		//FILMSTRIP MIGRATION (NO DEFAULTS NEEDED, LEAVE IT OUT !!)
		if($_->get_param('filmstrip_enabled', false) !== false){
			$obj['revslider-filmstrip-addon'] = array('enable' => $this->_truefalse($_->get_param('filmstrip_enabled')));
		}

		// WEATHER MIGRATION
		if($_->get_param('revslider-weather-enabled', false) !== false){
			$obj['revslider-weather-addon'] = array(
				'enable' => $this->_truefalse($_->get_param('revslider-weather-enabled')),
				'refresh' => $_->get_param('revslider-weather-refresh', '1'),
				'location' => ($_->get_param('revslider-weather-location-type', 'name') === 'name') ? $_->get_param('revslider-weather-location-name', 'Cologne') : $_->get_param('revslider-weather-location-woeid', '667931'),
				'unit' => $_->get_param('revslider-weather-unit', 'c')
			);
		}

		//SNOW MIGRATION
		if($_->get_param('snow_enabled', false) !== false){
			$obj['revslider-snow-addon'] = array(
				'enable' => $this->_truefalse($_->get_param('snow_enabled')),
				'endSlide' => $_->get_param('snow_end_slide', 'last'),
				'startSlide' => $_->get_param('snow_start_slide', 'first'),
				'max' => array(
					'number' => $_->get_param('snow_max_num', 400),
					'opacity' => $_->get_param('snow_max_opacity', 1),
					'sinus' => $_->get_param('snow_max_sinus', 100),
					'size' => $_->get_param('snow_max_size', 6),
					'speed' => $_->get_param('snow_max_speed', 100),
				),
				'min' => array(
					'number' => $_->get_param('snow_min_num', 400),
					'opacity' => $_->get_param('snow_min_opacity', 1),
					'sinus' => $_->get_param('snow_min_sinus', 100),
					'size' => $_->get_param('snow_min_size', 6),
					'speed' => $_->get_param('snow_min_speed', 100),
				),
			);
		}

		//BEFORE AFTER MIGRATION
		if($_->get_param('beforeafter_enabled', false) !== false){
			$obj['revslider-beforeafter-addon'] = array(
				'enable' => $this->_truefalse($_->get_param('beforeafter_enabled', false)),
				'icon' => array(
					'color' => $_->get_param('beforeafter_arrow_color', '#ffffff'),
					'size' => $_->get_param('beforeafter_arrow_size', 32),
					'space' => $_->get_param('beforeafter_arrow_spacing', 5),
					'up' => str_replace('fa-icon-', 'fa-', $_->get_param('beforeafter_top_arrow', 'fa-caret-up')),
					'down' => str_replace('fa-icon-', 'fa-', $_->get_param('beforeafter_bottom_arrow', 'fa-caret-down')),
					'left' => str_replace('fa-icon-', 'fa-', $_->get_param('beforeafter_left_arrow', 'fa-caret-left')),
					'right' => str_replace('fa-icon-', 'fa-', $_->get_param('beforeafter_right_arrow', 'fa-caret-right')),
					'shadow' => array(
						'set' => $this->_truefalse($_->get_param('beforeafter_arrow_shadow', false)),
						'blur' => $_->get_param('beforeafter_arrow_shadow_blur', 10),
						'color' => $_->get_param('beforeafter_arrow_shadow_color', 'rgba(0, 0, 0, 0.35)'),
					),
				),
				'drag' => array(
					'padding' => $_->get_param('beforeafter_arrow_padding', 0),
					'radius' => $_->get_param('beforeafter_arrow_radius', 0),
					'bgcolor' => $_->get_param('beforeafter_arrow_bg_color', 'transparent'),
					'border' => array(
						'set' => $this->_truefalse($_->get_param('beforeafter_arrow_border', false)),
						'width' => $_->get_param('beforeafter_arrow_border_size', 1),
						'color' => $_->get_param('beforeafter_arrow_border_color', '#000000'),
					),
					'boxshadow' => array(
						'set' => $this->_truefalse($_->get_param('beforeafter_box_shadow', false)),
						'blur' => $_->get_param('beforeafter_box_shadow_blur', 10),
						'strength' => $_->get_param('beforeafter_box_shadow_strength', 3),
						'color' => $_->get_param('beforeafter_box_shadow_color', 'rgba(0, 0, 0, 0.35)'),
					),
				),
				'divider' => array(
					'size' => $_->get_param('beforeafter_divider_size', 1),
					'color' => $_->get_param('beforeafter_divider_color', '#ffffff'),
					'shadow' => array(
						'set' => $this->_truefalse($_->get_param('beforeafter_divider_shadow', false)),
						'blur' => $_->get_param('beforeafter_divider_shadow_blur', 10),
						'strength' => $_->get_param('beforeafter_divider_shadow_strength', 3),
						'color' => $_->get_param('beforeafter_divider_shadow_color', 'rgba(0, 0, 0, 0.35)'),
					),
				),
				'onclick' => array(
					'set' => $this->_truefalse($_->get_param('beforeafter_onclick', true)),
					'time' => $_->get_param('beforeafter_click_time', 500),
					'easing' => $_->get_param('beforeafter_click_easing', 'power2.out'),
					'cursor' => $_->get_param('beforeafter_cursor', 'pointer'),
				),
			);
		}

		//POLCYFOLD MIGRATION
		if($_->get_param('polyfold_bottom_enabled', false) !== false){
			$obj['revslider-polyfold-addon'] = array(
				'enable' => $this->_truefalse($_->get_param('polyfold_bottom_enabled', false)) || $this->_truefalse($_->get_param('polyfold_top_enabled', false)),
				'bottom' => array(
					'enabled' => $this->_truefalse($_->get_param('polyfold_bottom_enabled', false)),
					'animated' => $this->_truefalse($_->get_param('polyfold_bottom_animated', false)),
					'color' => $_->get_param('polyfold_bottom_color', '#ffffff'),
					'ease' => $_->get_param('polyfold_bottom_ease', 'ease-in-out'),
					'height' => $_->get_param('polyfold_bottom_height', 100),
					'hideOnMobile' => $this->_truefalse($_->get_param('polyfold_bottom_hide_mobile', false)),
					'inverted' => $this->_truefalse($_->get_param('polyfold_bottom_inverted', false)),
					'leftWidth' => $_->get_param('polyfold_bottom_left_width', 50),
					'rightWidth' => $_->get_param('polyfold_bottom_right_width', 50),
					'negative' => $this->_truefalse($_->get_param('polyfold_bottom_negative', false)),
					'placement' => $_->get_param('polyfold_bottom_placement', 1),
					'point' => $_->get_param('polyfold_bottom_point', 'sides'),
					'range' => $_->get_param('polyfold_bottom_range', 'slider'),
					'responsive' => $this->_truefalse($_->get_param('polyfold_bottom_responsive', true)),
					'scroll' => $this->_truefalse($_->get_param('polyfold_bottom_scroll', true)),
					'time' => $_->get_param('polyfold_bottom_time', 0.3),
				),
				'top' => array(
					'enabled' => $this->_truefalse($_->get_param('polyfold_top_enabled', false)),
					'animated' => $this->_truefalse($_->get_param('polyfold_top_animated', false)),
					'color' => $_->get_param('polyfold_top_color', '#ffffff'),
					'ease' => $_->get_param('polyfold_top_ease', 'ease-in-out'),
					'height' => $_->get_param('polyfold_top_height', 100),
					'hideOnMobile' => $this->_truefalse($_->get_param('polyfold_top_hide_mobile', false)),
					'inverted' => $this->_truefalse($_->get_param('polyfold_top_inverted', false)),
					'leftWidth' => $_->get_param('polyfold_top_left_width', 50),
					'rightWidth' => $_->get_param('polyfold_top_right_width', 50),
					'negative' => $this->_truefalse($_->get_param('polyfold_top_negative', false)),
					'placement' => $_->get_param('polyfold_top_placement', 1),
					'point' => $_->get_param('polyfold_top_point', 'sides'),
					'range' => $_->get_param('polyfold_top_range', 'slider'),
					'responsive' => $this->_truefalse($_->get_param('polyfold_top_responsive', true)),
					'scroll' => $this->_truefalse($_->get_param('polyfold_top_scroll', true)),
					'time' => $_->get_param('polyfold_top_time', 0.3),
				),
			);
		}

		//REVEALER MIGRATION
		if($_->get_param('revealer_enabled', false) !== false){
			$obj['revslider-revealer-addon'] = array(
				'enable' => $this->_truefalse($_->get_param('revealer_enabled', false)),
				'direction' => $_->get_param('revealer_direction', 'open_horizontal'),
				'color' => $_->get_param('revealer_color', '#000000'),
				'easing' => $_->get_param('revealer_easing', 'power2.out'),
				'duration' => $_->get_param('revealer_duration', 500),
				'delay' => $_->get_param('revealer_delay', 10),
				'overlay' => array(
					'enable' => $this->_truefalse($_->get_param('revealer_overlay_enabled', false)),
					'color' => $_->get_param('revealer_overlay_color', '#000000'),
					'easing' => $_->get_param('revealer_overlay_easing', 'power2.out'),
					'duration' => $_->get_param('revealer_overlay_duration', 500),
					'delay' => $_->get_param('revealer_overlay_delay', 10),
				),
				'spinner' => array(
					'type' => $_->get_param('revealer_spinner', 'default'),
					'color' => $_->get_param('revealer_spinner_color', '#FFFFFF'),
				),
			);

			$obj['revslider-revealer-addon']['delay'] = intval($obj['revslider-revealer-addon']['delay']);
			if($obj['revslider-revealer-addon']['delay'] < 10){
				$obj['revslider-revealer-addon']['delay'] = 10;
			}

			if($obj['revslider-revealer-addon']['delay'] > 10000){
				$obj['revslider-revealer-addon']['delay'] = 10000;
			}

			$obj['revslider-revealer-addon']['overlay']['delay'] = intval($obj['revslider-revealer-addon']['overlay']['delay']);
			if($obj['revslider-revealer-addon']['overlay']['delay'] < 10){
				$obj['revslider-revealer-addon']['overlay']['delay'] = 10;
			}

			if($obj['revslider-revealer-addon']['overlay']['delay'] > 10000){
				$obj['revslider-revealer-addon']['overlay']['delay'] = 10000;
			}

			$obj['revslider-revealer-addon']['duration'] = intval($obj['revslider-revealer-addon']['duration']);
			if($obj['revslider-revealer-addon']['duration'] < 10){
				$obj['revslider-revealer-addon']['duration'] = 10;
			}

			if($obj['revslider-revealer-addon']['duration'] > 10000){
				$obj['revslider-revealer-addon']['duration'] = 10000;
			}

			$obj['revslider-revealer-addon']['overlay']['duration'] = intval($obj['revslider-revealer-addon']['overlay']['duration']);
			if($obj['revslider-revealer-addon']['overlay']['duration'] < 10){
				$obj['revslider-revealer-addon']['overlay']['duration'] = 10;
			}

			if($obj['revslider-revealer-addon']['overlay']['duration'] > 10000){
				$obj['revslider-revealer-addon']['overlay']['duration'] = 10000;
			}

		}

		//BUBBLEMORPH MIGRATION (NO DEFAULTS NEEDED, LEAVE IT OUT !!)
		if($_->get_param('bubblemorph_enabled', false) !== false){
			$obj['revslider-bubblemorph-addon'] = array('enable' => $this->_truefalse($_->get_param('bubblemorph_enabled')));
		}

		//DUALTONE MIGRATION (NO DEFAULTS NEEDED, LEAVE IT OUT !!)
		if($_->get_param('duotonefilters_enabled', false) !== false){
			$obj['revslider-duotonefilters-addon'] = array(
				'enable' => $this->_truefalse($_->get_param('duotonefilters_enabled', false)),
				'simplify' => array(
					'enable' => $this->_truefalse($_->get_param('duotonefilters_simplified', false)),
					'easing' => $_->get_param('duotonefilters_easing', 'ease-in'),
					'duration' => $_->get_param('duotonefilters_timing', 750),
				),
			);
		}

		//PARTICLE EFFECTS MIGRATION
		/**
		 * even if we dont need the values in the Slider
		 * push it here so that it still exists later on for the layers
		 * otherwise it will be lost and no longer available for the layers
		 * the values will be removed later on
		 **/
		if($_->get_param('particles_enabled', false) !== false){
			
			/*
				Canvas now draws all particles as SVG's for improved overall functionality and performance
				Because of this change, the following is needed to normalize the sizes
			*/
			$partSize = $_->get_param('particles_size_value', 6);
			$partShape = $_->get_param('particles_shape_type', 'circle');
			$partSizeMin = $_->get_param('particles_size_min_value', 1);
			$partSizeAnimMin = $_->get_param('particles_size_anim_min', 1);
			
			$partOpacityRandom = $this->_truefalse($_->get_param('particles_opacity_random', false));
			$partOpacity = $_->get_param('particles_opacity_value', 100);
			$partOpacityMin = $_->get_param('particles_opacity_min_value', 25);
			
			if($partShape === 'edge' || $partShape === 'triangle'){
				$partSize = max(round(intval($partSize) * 0.75), 1);
				$partSizeMin = max(floatval($partSizeMin) * 0.75, 0.1);
				$partSizeAnimMin = max(floatval($partSizeAnimMin) * 0.75, 0.1);
			}
			else if($partShape === 'polygon'){
				$partSize = max(round(intval($partSize) * 0.85), 1);
				$partSizeMin = max(floatval($partSizeMin) * 0.85, 0.1);
				$partSizeAnimMin = max(floatval($partSizeAnimMin) * 0.85, 0.1);
			}
			else if($partShape === 'star'){
				$partSizeMin = max($partSizeMin, 1);
				$partSizeAnimMin = max(floatval($partSizeAnimMin), 0.1);
			}
			else {
				$partSize = max(round(intval($partSize) * 0.5), 1);
				$partSizeMin = max(floatval($partSizeMin) * 0.5, 0.1);
				$partSizeAnimMin = max(floatval($partSizeAnimMin) * 0.5, 0.1);
			}
			
			if($partOpacityRandom && $partShape === 'edge' || $partShape === 'triangle' || $partShape === 'polygon' || $partShape === 'star'){
				$partOpacity = min(intval($partOpacity) + 25, 100);
				$partOpacityMin = min(intval($partOpacityMin) + 25, 100);
			}
			
			$obj['revslider-particles-addon'] = array(
				'enable' => $this->_truefalse($_->get_param('particles_enabled', false)),
				'endSlide' => $_->get_param('particles_end_slide', 'last'),
				'startSlide' => $_->get_param('particles_start_slide', 'first'),
				'hideOnMobile' => $this->_truefalse($_->get_param('particles_hide_on_mobile', false)),
				'particles' => array(
					'shape' => $partShape,
					'number' => $_->get_param('particles_number_value', 80),
					'size' => $partSize,
					'sizeMin' => $partSizeMin,
					'random' => $this->_truefalse($_->get_param('particles_size_random', true)),
				),
				'styles' => array(
					'border' => array(
						'enable' => $this->_truefalse($_->get_param('particles_border_enable', false)),
						'color' => $_->get_param('particles_border_color', '#ffffff'),
						'opacity' => $_->get_param('particles_border_opacity', 100),
						'size' => $_->get_param('particles_border_size', 1),
					),
					'lines' => array(
						'enable' => $this->_truefalse($_->get_param('particles_line_enable', false)),
						'color' => $_->get_param('particles_line_color', '#ffffff'),
						'width' => $_->get_param('particles_line_width', 1),
						'opacity' => $_->get_param('particles_line_opacity', 100),
						'distance' => $_->get_param('particles_line_distance', 150),
					),
					'particle' => array(
						'color' => $_->get_param('particles_color_value', '#ffffff'),
						'opacity' => $partOpacity,
						'opacityMin' => $partOpacityMin,
						'opacityRandom' => $partOpacityRandom,
						'zIndex' => $_->get_param('particles_zindex', 'default'),
					),
				),
				'movement' => array(
					'enable' => $this->_truefalse($_->get_param('particles_move_enable', true)),
					'randomSpeed' => $this->_truefalse($_->get_param('particles_move_random', true)),
					'speed' => $_->get_param('particles_move_speed', 1),
					'speedMin' => $_->get_param('particles_move_speed_min', 1),
					'direction' => $_->get_param('particles_move_direction', 'none'),
					'straight' => $this->_truefalse($_->get_param('particles_move_straight', true)),
					'bounce' => $this->_truefalse($_->get_param('particles_move_bounce', false)),
				),
				'interactivity' => array(
					'hoverMode' => ($this->_truefalse($_->get_param('particles_onhover_enable'))) ? $_->get_param('particles_onhover_mode', 'repulse') : 'none',
					'clickMode' => ($this->_truefalse($_->get_param('particles_onclick_enable'))) ? $_->get_param('particles_onclick_mode', 'repulse') : 'none',
				),
				'bubble' => array(
					'distance' => $_->get_param('particles_modes_bubble_distance', 400),
					'size' => $_->get_param('particles_modes_bubble_size', 40),
					'opacity' => $_->get_param('particles_modes_bubble_opacity', 40),
				),
				'grab' => array(
					'distance' => $_->get_param('particles_modes_grab_distance', 400),
					'opacity' => $_->get_param('particles_modes_grab_opacity', 50),
				),
				'repulse' => array(
					'distance' => $_->get_param('particles_modes_repulse_distance', 200),
					'easing' => 100, // new option
				),
				'pulse' => array(
					'size' => array(
						'enable' => $this->_truefalse($_->get_param('particles_size_anim_enable', false)),
						'speed' => $_->get_param('particles_size_anim_speed', 40),
						'min' => $partSizeAnimMin,
						'sync' => $this->_truefalse($_->get_param('particles_size_anim_sync', false)),
					),
					'opacity' => array(
						'enable' => $this->_truefalse($_->get_param('particles_opacity_anim_enable', false)),
						'speed' => $_->get_param('particles_opacity_anim_speed', 3),
						'min' => $_->get_param('particles_opacity_anim_min', 0),
						'sync' => $this->_truefalse($_->get_param('particles_opacity_anim_sync', false)),
					),
				),
			);
		}

		return $obj;
	}

	/**
	 * Migrate the Slider AddOns that were existing prior to version 6.0
	 * @since: 6.0
	 **/
	public function migrate_slide_AddOn($_, $_s, $slide_nr = false){
		$obj = array();
		
		// WEATHER MIGRATION
		if($_->get_param('revslider-weather-location-type', false) !== false){
			$obj['revslider-weather-addon'] = array(
				'location' => ($_->get_param('revslider-weather-location-type', 'name') === 'name') ? $_->get_param('revslider-weather-location-name', 'Cologne') : $_->get_param('revslider-weather-location-woeid', '667931'),
				'unit' => $_->get_param('revslider-weather-unit', 'c')
			);
		}

		// FILMSTRIP
		if($_->get_param('filmstrip_enabled', false) !== false){
			$ftimes = explode(',', $_->get_param('filmstrip_times'));
			$filmstrip_settings = str_replace('\\', '', $_->get_param('filmstrip_settings'));
			$obj['revslider-filmstrip-addon'] = array(
				'enable' => $this->_truefalse($_->get_param('filmstrip_enabled', false)),
				'direction' => $_->get_param('filmstrip_direction', 'right-to-left'),
				'mobile' => $this->_truefalse($_->get_param('filmstrip_mobile', false)),
				'times' => $this->c_to_resp(array('default' => 40, 'val' => array('desktop' => $this->get_val($ftimes, 0), 'notebook' => $this->get_val($ftimes, 1), 'tablet' => $this->get_val($ftimes, 2), 'mobile' => $this->get_val($ftimes, 3)))),
				'settings' => json_decode($filmstrip_settings, true)
			);
		}

		//SLICEY
		if($_->get_param('slicey_globals', false) !== false){
			$slicey = json_decode(str_replace('\\', '', $_->get_param('slicey_globals')));
			$obj['revslider-slicey-addon'] = array(
				'shadow' => array(
					'blur' => $this->get_val($slicey, 'blur', 5),
					'color' => $this->get_val($slicey, 'color', 'transparent'),
					'strength' => $this->get_val($slicey, 'strength', 0)
				),
			);
		}

		// PANORAMA
		if($_->get_param('panorama_enabled', false) !== false){
			$obj['revslider-panorama-addon'] = array(
				'enable' => $this->_truefalse($_->get_param('panorama_enabled', false)),
				'mobilelock' => true,
				'autoplay' => array(
					'enable' => $this->_truefalse($_->get_param('panorama_autoplay', false)),
					'direction' => $_->get_param('panorama_direction', 'forward'),
					'speed' => $_->get_param('panorama_speed', 100),
				),
				'interaction' => array(
					'controls' => $_->get_param('panorama_controls', 'throw'),
					'speed' => $_->get_param('panorama_throw_speed', 750),
				),
				'zoom' => array(
					'enable' => $this->_truefalse($_->get_param('panorama_mousewheel_zoom', false)),
					'smooth' => $this->_truefalse($_->get_param('panorama_smooth_zoom', true)),
					'min' => $_->get_param('panorama_zoom_min', 75),
					'max' => $_->get_param('panorama_zoom_max', 150),
				),
				'camera' => array(
					'fov' => $_->get_param('panorama_camera_fov', 75),
					'far' => $_->get_param('panorama_camera_far', 1000),
				),
				'sphere' => array(
					'radius' => $_->get_param('panorama_sphere_radius', 100),
					'wsegments' => $_->get_param('panorama_sphere_wsegments', 100),
					'hsegments' => $_->get_param('panorama_sphere_hsegments', 40),
				),
			);

		}

		// PAINTBRUSH
		if($_->get_param('paintbrush_enabled', false) !== false){
			$obj['revslider-paintbrush-addon'] = array(
				'enable' => $this->_truefalse($_->get_param('paintbrush_enabled', false)),
				'image' => array(
					'source' => $_->get_param('paintbrush_source', 'local'),
					'custom' => $_->get_param('paintbrush_img', ''),
					'blur' => array(
						'enable' => $this->_truefalse($_->get_param('paintbrush_blur', false)),
						'amount' => $_->get_param('paintbrush_bluramount', 10),
						'responsive' => $this->_truefalse($_->get_param('paintbrush_scaleblur', false)),
						'fixedges' => array(
							'enable' => $this->_truefalse($_->get_param('paintbrush_fixedges', false)),
							'amount' => $_->get_param('paintbrush_edgeamount', 10),
						),
					),
				),
				'brush' => array(
					'style' => $_->get_param('paintbrush_style', 'round'),
					'size' => $_->get_param('paintbrush_size', 80),
					'responsive' => $this->_truefalse($_->get_param('paintbrush_responsive', false)),
					'disappear' => array(
						'enable' => $this->_truefalse($_->get_param('paintbrush_disappear', false)),
						'time' => $_->get_param('paintbrush_fadetime', 1000),
					),
				),
				'mobile' => array(
					'disable' => $this->_truefalse($_->get_param('paintbrush_mobile', false)),
					'fallback' => $this->_truefalse($_->get_param('paintbrush_fallback', false)),
				),

			);

			$obj['revslider-paintbrush-addon']['image']['blur']['amount'] = intval($obj['revslider-paintbrush-addon']['image']['blur']['amount']);
			if($obj['revslider-paintbrush-addon']['image']['blur']['amount'] < 1){
				$obj['revslider-paintbrush-addon']['image']['blur']['amount'] = 1;
			}

			if($obj['revslider-paintbrush-addon']['image']['blur']['amount'] > 100){
				$obj['revslider-paintbrush-addon']['image']['blur']['amount'] = 100;
			}

			$obj['revslider-paintbrush-addon']['image']['blur']['fixedges']['amount'] = intval($obj['revslider-paintbrush-addon']['image']['blur']['fixedges']['amount']);
			if($obj['revslider-paintbrush-addon']['image']['blur']['fixedges']['amount'] < 0){
				$obj['revslider-paintbrush-addon']['image']['blur']['fixedges']['amount'] = 0;
			}

			if($obj['revslider-paintbrush-addon']['image']['blur']['fixedges']['amount'] > 100){
				$obj['revslider-paintbrush-addon']['image']['blur']['fixedges']['amount'] = 100;
			}

			$obj['revslider-paintbrush-addon']['brush']['size'] = intval($obj['revslider-paintbrush-addon']['brush']['size']);
			if($obj['revslider-paintbrush-addon']['brush']['size'] < 5){
				$obj['revslider-paintbrush-addon']['brush']['size'] = 5;
			}

			if($obj['revslider-paintbrush-addon']['brush']['size'] > 500){
				$obj['revslider-paintbrush-addon']['brush']['size'] = 500;
			}

			$obj['revslider-paintbrush-addon']['brush']['disappear']['time'] = intval($obj['revslider-paintbrush-addon']['brush']['disappear']['time']);
			if($obj['revslider-paintbrush-addon']['brush']['disappear']['time'] < 100){
				$obj['revslider-paintbrush-addon']['brush']['disappear']['time'] = 100;
			}

			if($obj['revslider-paintbrush-addon']['brush']['disappear']['time'] > 10000){
				$obj['revslider-paintbrush-addon']['brush']['disappear']['time'] = 10000;
			}

		}

		// DISTORTION
		if($_->get_param('liquideffect_enabled', false) !== false){
			$obj['revslider-liquideffect-addon'] = array(
				'enable' => $this->_truefalse($_->get_param('liquideffect_enabled', false)),
				'map' => array(
					'image' => $_->get_param('liquideffect_image', 'Ripple'),
					'custom' => $_->get_param('liquideffect_custommap', ''),
					'size' => $_->get_param('liquideffect_size', 'Large'),
				),
				'animation' => array(
					'enable' => $this->_truefalse($_->get_param('liquideffect_autoplay', true)),
					'speedx' => $_->get_param('liquideffect_speedx', 2),
					'speedy' => $_->get_param('liquideffect_speedy', 20),
					'rotation' => $_->get_param('liquideffect_rotation', 0),
					'rotationx' => $_->get_param('liquideffect_rotationx', 20),
					'rotationy' => $_->get_param('liquideffect_rotationy', 0),
					'scalex' => $_->get_param('liquideffect_scalex', 20),
					'scaley' => $_->get_param('liquideffect_scaley', 20),
				),
				'transition' => array(
					'enable' => $this->_truefalse($_->get_param('liquideffect_transition', true)),
					'cross' => $this->_truefalse($_->get_param('liquideffect_transcross', true)),
					'duration' => $_->get_param('liquideffect_transtime', 1000),
					'easing' => $_->get_param('liquideffect_easing', 'power3.out'),
					'speedx' => $_->get_param('liquideffect_transpeedx', 2),
					'speedy' => $_->get_param('liquideffect_transpeedy', 100),
					'rotation' => $_->get_param('liquideffect_transrot', 0),
					'rotationx' => $_->get_param('liquideffect_transrotx', 20),
					'rotationy' => $_->get_param('liquideffect_transroty', 0),
					'scalex' => $_->get_param('liquideffect_transitionx', 2),
					'scaley' => $_->get_param('liquideffect_transitiony', 1280),
					'power' => $this->_truefalse($_->get_param('liquideffect_transpower', false)),
				),
				'interaction' => array(
					'enable' => $this->_truefalse($_->get_param('liquideffect_interactive', false)),
					'event' => $_->get_param('liquideffect_event', 'mousemove'),
					'duration' => $_->get_param('liquideffect_intertime', 500),
					'easing' => $_->get_param('liquideffect_intereasing', 'power2.out'),
					'speedx' => $_->get_param('liquideffect_interspeedx', 0),
					'speedy' => $_->get_param('liquideffect_interspeedy', 0),
					'rotation' => $_->get_param('liquideffect_interotation', 0),
					'scalex' => $_->get_param('liquideffect_interscalex', 2),
					'scaley' => $_->get_param('liquideffect_interscaley', 1280),
					'disablemobile' => $this->_truefalse($_->get_param('liquideffect_mobile', false)),
				),
			);
		}

		// DUOTONE
		if($_->get_param('duotonefilter_addon', false) !== false){
			$obj['revslider-duotonefilters-addon'] = array('filter' => $_->get_param('duotonefilter_addon', 'rs-duotone-none'));
		}

		// BEFOREAFTER
		if($_->get_param('beforeafter_enabled', false) !== false){
			$globals = json_decode(str_replace('\\', '', $_->get_param('beforeafter_globals', array('moveto' => '30%|30%|30%|30%'))), true);
			$movetos = explode('|', $this->get_val($globals, 'moveto'));

			$obj['revslider-beforeafter-addon'] = array(
				'enable' => $this->_truefalse($_->get_param('beforeafter_enabled', false)),
				'direction' => $_->get_param('beforeafter_direction', 'horizontal'),
				'delay' => $_->get_param('beforeafter_delay', 500),
				'time' => $_->get_param('beforeafter_time', 750),
				'easing' => $_->get_param('beforeafter_easing', 'power2.inOut'),
				'animateOut' => $_->get_param('beforeafter_animateout', 'fade'),
				'moveTo' => $this->c_to_resp(array('default' => 50, 'val' => array('desktop' => $this->get_val($movetos, 0), 'notebook' => $this->get_val($movetos, 1), 'tablet' => $this->get_val($movetos, 2), 'mobile' => $this->get_val($movetos, 3)))),
				'teaser' => array(
					'set' => $_->get_param('beforeafter_bouncearrows', 'none'),
					'type' => $_->get_param('beforeafter_bouncetype', 'repel'),
					'distance' => $_->get_param('beforeafter_bounceamount', 5),
					'speed' => $_->get_param('beforeafter_bouncespeed', 1500),
					'easing' => $_->get_param('beforeafter_bounceeasing', 'ease-in-out'),
					'delay' => $_->get_param('beforeafter_bouncedelay', 0),
				),
				'shift' => array(
					'set' => $this->_truefalse($_->get_param('beforeafter_shiftarrows', false)),
					'offset' => $_->get_param('beforeafter_shiftoffset', 10),
					'speed' => $_->get_param('beforeafter_shifttiming', 300),
					'easing' => $_->get_param('beforeafter_shifteasing', 'ease'),
					'delay' => $_->get_param('beforeafter_shiftdelay', 0),
				),
				'bg' => array(
					'type' => $_->get_param('background_type_beforeafter', 'trans'),
					'color' => $_->get_param('bg_color_beforeafter', '#e7e7e7'),
					'externalSrc' => $_->get_param('bg_external_beforeafter', ''),
					'fit' => $_->get_param('bg_fit_beforeafter', 'cover'),
					'fitX' => $_->get_param('bg_fit_x_beforeafter', '100'),
					'fitY' => $_->get_param('bg_fit_y_beforeafter', '100'),
					'position' => $_->get_param('bg_position_beforeafter', 'center center'),
					'positionX' => $_->get_param('bg_position_x_beforeafter', '0'),
					'positionY' => $_->get_param('bg_position_y_beforeafter', '0'),
					'repeat' => $_->get_param('bg_repeat_beforeafter', 'no-repeat'),
					'image' => $_->get_param('image_url_beforeafter', ''),
					'imageId' => $_->get_param('image_id_beforeafter', ''),
					'imageSourceType' => $_->get_param('image_source_type_beforeafter', ''),
					'mpeg' => $_->get_param('bg_mpeg_beforeafter', ''),
					'vimeo' => $_->get_param('bg_vimeo_beforeafter', ''),
					'youtube' => $_->get_param('bg_youtube_beforeafter', ''),
					'width' => '',
					'height' => '',
					'video' => array(
						'args' => $_->get_param('video_arguments_beforeafter', 'hd=1&wmode=opaque&showinfo=0&rel=0;'),
						'argsVimeo' => $_->get_param('video_arguments_vim_beforeafter', 'title=0&byline=0&portrait=0&api=1'),
						'dottedOverlay' => $_->get_param('video_dotted_overlay_beforeafter', 'none'),
						'startAt' => $_->get_param('video_start_at_beforeafter', ''),
						'endAt' => $_->get_param('video_end_at_beforeafter', ''),						
						'forceRewind' => $this->_truefalse($_->get_param('video_force_rewind_beforeafter', true)),
						'loop' => $_->get_param('video_loop_beforeafter', 'none'),
						'mute' => $this->_truefalse($_->get_param('video_mute_beforeafter', true)),
						'nextSlideAtEnd' => $this->_truefalse($_->get_param('video_nextslide_beforeafter', false)),
						'ratio' => $_->get_param('video_ratio_beforeafter', '16:9'),
						'speed' => $_->get_param('video_speed_beforeafter', '1'),
						'volume' => $_->get_param('video_volume_beforeafter', ''),
					),
					'videoId' => '',
				),
			);
		}
		
		//PARTICLE EFFECTS MIGRATION
		if($this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'enable'), false)) !== false){
			$p_start_at = $_s->get_param(array('addOns', 'revslider-particles-addon', 'startSlide'), 'first');
			$p_end_at = $_s->get_param(array('addOns', 'revslider-particles-addon', 'endSlide'), 'last');
			$add_particles = false;
			if($p_start_at === 'first' && $p_end_at === 'last'){
				$add_particles = true;
			}elseif($p_start_at === 'first' && intval($p_end_at) >= $slide_nr){
				$add_particles = true;
			}elseif($p_end_at === 'last' && intval($p_start_at) <= $slide_nr){
				$add_particles = true;
			}elseif(intval($p_start_at) <= $slide_nr && intval($p_end_at) >= $slide_nr){
				$add_particles = true;
			}
			if($add_particles === true){
				$obj['revslider-particles-addon'] = array(
					'enable' => $this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'enable'), false)),
					'hideOnMobile' => $this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'hideOnMobile'), false)),
					'particles' => array(
						'shape' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'particles', 'shape'), 'circle'),
						'number' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'particles', 'number'), 80),
						'size' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'particles', 'size'), 6),
						'sizeMin' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'particles', 'sizeMin'), 1),
						'random' => $this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'particles', 'random'), true))
					),
					'styles' => array(
						'border' => array(
							'enable' => $this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'styles', 'border', 'enable'), false)),
							'color' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'styles', 'border', 'color'), '#ffffff'),
							'opacity' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'styles', 'border', 'opacity'), 100),
							'size' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'styles', 'border', 'size'), 1)
						),
						'lines' => array(
							'enable' => $this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'styles', 'lines', 'enable'), false)),
							'color' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'styles', 'lines', 'color'), '#ffffff'),
							'width' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'styles', 'lines', 'width'), 1),
							'opacity' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'styles', 'lines', 'opacity'), 100),
							'distance' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'styles', 'lines', 'distance'), 150)
						),
						'particle' => array(
							'color' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'styles', 'particle', 'color'), '#ffffff'),
							'opacity' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'styles', 'particle', 'opacity'), 100),
							'opacityMin' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'styles', 'particle', 'opacityMin'), 25),
							'opacityRandom' => $this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'styles', 'particle', 'opacityRandom'), false)),
							'zIndex' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'styles', 'particle', 'zIndex'), 'default')
						)
					),
					'movement' => array(
						'enable' => $this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'movement', 'enable'), true)),
						'randomSpeed' => $this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'movement', 'randomSpeed'), true)),
						'speed' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'movement', 'speed'), 1),
						'speedMin' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'movement', 'speedMin'), 1),
						'direction' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'movement', 'direction'), 'none'),
						'straight' => $this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'movement', 'straight'), true)),
						'bounce' => $this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'movement', 'bounce'), false))
					),
					'interactivity' => array(
						'hoverMode' => ($this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'interactivity', 'hoverMode')))) ? $_s->get_param(array('addOns', 'revslider-particles-addon', 'interactivity', 'hoverMode'), 'repulse') : 'none',
						'clickMode' => ($this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'interactivity', 'clickMode')))) ? $_s->get_param(array('addOns', 'revslider-particles-addon', 'interactivity', 'clickMode'), 'repulse') : 'none'
					),
					'bubble' => array(
						'distance' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'bubble', 'distance'), 400),
						'size' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'bubble', 'size'), 40),
						'opacity' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'bubble', 'opacity'), 40)
					),
					'grab' => array(
						'distance' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'grab', 'distance'), 400),
						'opacity' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'grab', 'opacity'), 50)
					),
					'repulse' => array(
						'distance' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'repulse', 'distance'), 200),
						'easing' => 100 /* new option */
					),
					'pulse' => array(
						'size' => array(
							'enable' => $this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'pulse', 'size', 'enable'), false)),
							'speed' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'pulse', 'size', 'speed'), 40),
							'min' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'pulse', 'size', 'min'), 1),
							'sync' => $this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'pulse', 'size', 'sync'), false))
						),
						'opacity' => array(
							'enable' => $this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'pulse', 'opacity', 'enable'), false)),
							'speed' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'pulse', 'opacity', 'speed'), 3),
							'min' => $_s->get_param(array('addOns', 'revslider-particles-addon', 'pulse', 'opacity', 'min'), 1),
							'sync' => $this->_truefalse($_s->get_param(array('addOns', 'revslider-particles-addon', 'pulse', 'opacity', 'sync'), false))
						)
					)
				);
			}
		}

		return $obj;
	}

	/**
	 * Migrate the Slider AddOns that were existing prior to version 6.0
	 * @since: 6.0
	 **/
	public function migrate_layer_AddOn(&$_, $slide){
		$obj = array();
		//EXPLODING LAYERS SEE IN SUBMIGRATION ROUTINE !!!!

		//WHITEBOARD MIGRATION
		if($this->get_val($_, 'whiteboard', false) !== false){
			
			$wbenabled = $this->get_val($_, array('whiteboard', 'hand_function'));
			$obj['revslider-whiteboard-addon'] = array(
				'enable' => $wbenabled !== 'off' ? true : false,
				'hand' => array(
					'angle' => $this->get_val($_, array('whiteboard', 'hand_angle')),
					'angleRepeat' => $this->get_val($_, array('whiteboard', 'hand_angle_repeat')),
					'direction' => $this->get_val($_, array('whiteboard', 'hand_direction')),
					'rotation' => $this->get_val($_, array('whiteboard', 'hand_full_rotation')),
					'rotationAngle' => $this->get_val($_, array('whiteboard', 'hand_full_rotation_angle')),
					'mode' => $this->get_val($_, array('whiteboard', 'hand_function')),
					'gotoLayer' => $this->get_val($_, array('whiteboard', 'hand_gotolayer')),
					'type' => $this->get_val($_, array('whiteboard', 'hand_type')),
					'x' => $this->get_val($_, array('whiteboard', 'hand_x_offset')),
					'y' => $this->get_val($_, array('whiteboard', 'hand_y_offset')),
				),
				'jitter' => array(
					'distance' => $this->get_val($_, array('whiteboard', 'jitter_distance')),
					'distanceHorizontal' => $this->get_val($_, array('whiteboard', 'jitter_distance_horizontal')),
					'offset' => $this->get_val($_, array('whiteboard', 'jitter_offset')),
					'offsetHorizontal' => $this->get_val($_, array('whiteboard', 'jitter_offset_horizontal')),
					'repeat' => $this->get_val($_, array('whiteboard', 'jitter_repeat')),
				),
			);
		}

		//TYPEWRITER MIGRATION
		if($this->get_val($_, 'typewriter', false) !== false){
			$obj['revslider-typewriter-addon'] = array(
				'enable' => $this->_truefalse($this->get_val($_, array('typewriter', 'enabled'))),
				'blinking_speed' => $this->get_val($_, array('typewriter', 'blinking_speed')),
				'cursor_type' => $this->get_val($_, array('typewriter', 'cursor_type')),
				'blinking' => $this->_truefalse($this->get_val($_, array('typewriter', 'blinking'))),
				'delays' => $this->get_val($_, array('typewriter', 'delays')),
				'deletion_delay' => $this->get_val($_, array('typewriter', 'deletion_delay')),
				'deletion_speed' => $this->get_val($_, array('typewriter', 'deletion_speed')),
				'hide_cursor' => $this->_truefalse($this->get_val($_, array('typewriter', 'hide_cursor'))),
				'linebreak_delay' => $this->get_val($_, array('typewriter', 'linebreak_delay')),
				'lines' => $this->get_val($_, array('typewriter', 'lines')),
				'looped' => $this->_truefalse($this->get_val($_, array('typewriter', 'looped'))),
				'newline_delay' => $this->get_val($_, array('typewriter', 'newline_delay')),
				'sequenced' => $this->_truefalse($this->get_val($_, array('typewriter', 'sequenced'))),
				'speed' => $this->get_val($_, array('typewriter', 'speed')),
				'start_delay' => $this->get_val($_, array('typewriter', 'start_delay')),
				'word_delay' => $this->get_val($_, array('typewriter', 'word_delay')),
			);
		}

		//BEFORE AFTER MIGRATION
		if($this->get_val($_, 'beforeafter', false) !== false){
			$obj['revslider-beforeafter-addon'] = array(
				'position' => $this->get_val($_, array('beforeafter', 'position'), 'before'),
			);
		}

		// WEATHER ADDON MIGRATION
		$layer_text = $this->get_val($_, 'text', 'New layer');
		if(strpos($layer_text, '{{weather_') !== false || strpos($layer_text, '%weather_') !== false){
			
			$params = $slide->get_params();
			$addons = $this->get_val($params, 'addOns', array());
			$weather = $this->get_val($addons, 'revslider-weather-addon', array());
			
			// push the Slide's "weather location" onto the Layer
			$obj['revslider-weather-addon'] = array(
				'location' => $this->get_val($weather, 'location', 'Cologne'), 
				'unit' => $this->get_val($weather, 'unit', 'c')
			);
			
			// replace %weather_wildcard% with {{weather_wildcard}}
			if(strpos($layer_text, '%weather_') !== false){
				$layer_text = preg_replace_callback(
					'/%weather.*?%/', 
					array($this, 'preg_replace_callback_addon'),
					$layer_text
				);
				$this->set_val($_, 'text', $layer_text);	
			}
		}

		//SLICEY LAYER SETTINGS
		if($this->get_val($_, 'type') === 'shape' && $this->get_val($_, 'subtype') === 'slicey'){
			$obj['revslider-slicey-addon'] = array(
				'scaleOffset' => $this->get_val($_, array('slicey', 'scale_offset'), 20),
				'blurStart' => $this->get_val($_, array('slicey', 'blurlstart'), 'inherit'),
				'blurEnd' => $this->get_val($_, array('slicey', 'blurlend'), 'inherit'),
			);
		}

		//BUBBLEMORPH LAYER SETTINGS
		if($this->get_val($_, 'type') === 'shape' && $this->get_val($_, 'subtype') === 'bubblemorph'){

			// incoming structure could be a single value or an Array, and value could also be "inherit"
			$bubbleObj = array();
			$bubbleDefaults = array(
				'max' => 6,
				'speedx' => 0.25,
				'speedy' => 1,
				'bufferx' => 0,
				'buffery' => 0,
				'blurstrength' => 0,
				'blurcolor' => 'rgba(0, 0, 0, 0.35)',
				'blurx' => 0,
				'blury' => 0,
				'bordersize' => 0,
				'bordercolor' => '#000000',
			);

			// need to sanitize as incoming value could be either a single value or an Array
			$bubblemorph = $this->get_val($_, 'bubblemorph');
			foreach($bubblemorph as $prop => $bubbleVal){
				// make sure value is an Array
				if(!is_array($bubbleVal)){
					$bubbleVal = array($bubbleVal, $bubbleVal, $bubbleVal, $bubbleVal);
				}

				// make sure Array length is 4
				while (count($bubbleVal) < 4){
					$bubbleVal[count($bubbleVal)] = $bubbleVal[count($bubbleVal) - 1];
				}

				// convert possible 'inherit' values
				foreach($bubbleVal as $bk => $bv){
					if($bv == 'inherit'){
						$bubbleVal[$bk] = $bubbleDefaults[$prop];
					}
				}

				// write new values to be passed into the cToResp function
				$bubbleObj[$prop] = array('desktop' => $this->get_val($bubbleVal, 0), 'notebook' => $this->get_val($bubbleVal, 1), 'tablet' => $this->get_val($bubbleVal, 2), 'mobile' => $this->get_val($bubbleVal, 3));

			}

			$obj['revslider-bubblemorph-addon'] = array(
				'settings' => array(
					'maxmorphs' => $this->c_to_resp(array('default' => $bubbleDefaults['max'], 'val' => $this->get_val($bubbleObj, 'max'))),
					'speedx' => $this->c_to_resp(array('default' => $bubbleDefaults['speedx'], 'val' => $this->get_val($bubbleObj, 'speedx'))),
					'speedy' => $this->c_to_resp(array('default' => $bubbleDefaults['speedy'], 'val' => $this->get_val($bubbleObj, 'speedy'))),
					'bufferx' => $this->c_to_resp(array('default' => $bubbleDefaults['bufferx'], 'val' => $this->get_val($bubbleObj, 'bufferx'))),
					'buffery' => $this->c_to_resp(array('default' => $bubbleDefaults['buffery'], 'val' => $this->get_val($bubbleObj, 'buffery'))),
				),
				'shadow' => array(
					'strength' => $this->c_to_resp(array('default' => $bubbleDefaults['blurstrength'], 'val' => $this->get_val($bubbleObj, 'blurstrength'))),
					'color' => $this->c_to_resp(array('default' => $bubbleDefaults['blurcolor'], 'val' => $this->get_val($bubbleObj, 'blurcolor'))),
					'offsetx' => $this->c_to_resp(array('default' => $bubbleDefaults['blurx'], 'val' => $this->get_val($bubbleObj, 'blurx'))),
					'offsety' => $this->c_to_resp(array('default' => $bubbleDefaults['blury'], 'val' => $this->get_val($bubbleObj, 'blury'))),
				),
				'border' => array(
					'size' => $this->c_to_resp(array('default' => $bubbleDefaults['bordersize'], 'val' => $this->get_val($bubbleObj, 'bordersize'))),
					'color' => $this->c_to_resp(array('default' => $bubbleDefaults['bordercolor'], 'val' => $this->get_val($bubbleObj, 'bordercolor'))),
				),
			);
		}

		return $obj;
	}
	
	/**
	 * needed for the addons
	 **/
	public function preg_replace_callback_addon($matches){
		return '{{' . str_replace('%', '', $matches[0]) . '}}';
	}
	
	/*
		CREATE A 4 LEVEL OBJECT STRUCTURE
		(DESKTOP, NOTEBOOK, TABLET, MOBILE) WITH DEFAULT OR PREDEFINED VALUES
		VALUE, EDITED (true/false), UNIT (PX, %, EM...)
		* @before: RevSliderPluginUpdate::cToResp();
	*/
	public function c_to_resp($attr = array('default' => 0, 'unit' => '')){
		$newObj = array();
		$unit = $this->get_val($attr, 'unit', '');
		$v = $this->get_val($attr, 'default', 0);

		foreach($this->_respsizes as $i => $rv){
			$s = $this->_respsizes[$i];
			$sold = $this->_respsizesold[$i];
			$val = $this->get_val($attr, 'val', false);
			
			/**
			 * first we check if the old value exists
			 **/
			if(isset($val[$sold])){
				/**
				 * take it as it is
				 **/
				$v = $this->get_val($val, $sold, false);
			}else{
				/**
				 * does not exist
				 * 1. check if any of the four values exist
				 **/
				$is_dntm = (is_array($val) && (isset($val['desktop']) || isset($val['notebook']) || isset($val['tablet']) || isset($val['mobile']))) ? true : false;
				if(is_array($val) && $is_dntm === false){ // || is_object($val)
					/**
					 * 2. check if we are an array but not the 4 sizes
					 *	- if this is the case, take the array as it is!
					 **/
					$v = $val; //(array)
				}elseif(!is_object($val) && !is_array($val) && $val !== false){
					/**
					 * 3. check if we are just a value
					 *	- if this is the case, just take the value
					 **/
					$v = $val;
				}elseif((!is_object($val) && !is_array($val)) || $this->get_val($val, $sold, false) === false){
					// $val !== false ||   || $this->get_val($val, $sold, false) === null
					/**
					 * 4. check if not array and object, also if old value not exist
					 *	- push the default, wich is until here still in $v
					 **/
					$v = $v;
				}else{
					/**
					 * 5. as none of these fit, take the $sold value out of $val
					 **/
					$v = $this->get_val($val, $sold, false);
				}
			}
			
			/**
			 * check if the new value is an array or not
			 **/
			if(is_array($v) || is_object($v)){
				$newObj[$s] = array('v' => $v, 'e' => false);
				if($attr !== false && $val !== false && $this->get_val($val, $sold, false) !== false){
					$newObj[$s]['e'] = true;
				}
				
				/**
				 * add the corresponding units to all values in the array if needed
				 **/
				foreach($v as $vi => $vval){
					if(strlen($unit) > 0 && $v[$vi] != 'auto' && $v[$vi] != 'none'){
						$newObj[$s]['v'][$vi] = intval($v[$vi]) . $unit;
					}else{
						$newObj[$s]['v'][$vi] = $v[$vi];
					}

					if($unit == '' && !is_numeric($newObj[$s]['v'][$vi])){
						if(strpos($newObj[$s]['v'][$vi], '%') !== false){
							$newObj[$s]['v'][$vi] = intval($newObj[$s][$vi]) .'%';
						}elseif(strpos($newObj[$s]['v'][$vi], 'px') !== false){
							$newObj[$s]['v'][$vi] = intval($newObj[$s]['v'][$vi]) .'px';
						}
					}

				}
			}else{
				/**
				 * add the corresponding units to the value if needed
				 **/
				if(strlen($unit) > 0){
					if($v !== 'auto' && $v !== 'none' && $v !== ''){
						$nv = intval($v) . $unit;
					}else{
						$nv = $v;
					}
				}else{
					$nv = $v;
				}

				$newObj[$s] = array('v' => $nv, 'e' => false, 'u' => $unit);
				if($this->get_val($val, $sold, false) !== false){
					$newObj[$s]['e'] = true;
				}

				if($newObj[$s]['v'] === '' && $this->get_val($attr, 'default', '') !== ''){
					$newObj[$s]['v'] = $this->get_val($attr, 'default');
				}

				if(is_array($newObj[$s]['v']) || is_object($newObj[$s]['v'])){
					foreach($newObj[$s]['v'] as $nok => $nov){
						if($unit == '' && !is_numeric($nov) && $nov !== false && $nov !== true){
							if(strpos($nov, '%') !== false){
								if(is_object($newObj[$s]['v'])){
									$newObj[$s]['v']->$nok = intval($nov) .'%';
								}else{
									$newObj[$s]['v'][$nok] = intval($nov) .'%';
								}
							}elseif(strpos($nov, 'px') !== false){
								if(is_object($newObj[$s]['v'])){
									$newObj[$s]['v']->$nok = intval($nov) .'px';
								}else{
									$newObj[$s]['v'][$nok] = intval($nov) .'px';
								}
							}
						}
					}
				}else{
					if($unit == '' && !is_numeric($newObj[$s]['v']) && $newObj[$s]['v'] !== false && $newObj[$s]['v'] !== true){
						if(strpos($newObj[$s]['v'], '%') !== false){
							$newObj[$s]['v'] = intval($newObj[$s]['v']) .'%';
						}elseif(strpos($newObj[$s]['v'], 'px') !== false){
							$newObj[$s]['v'] = intval($newObj[$s]['v']) .'px';
						}
					}
				}
			}
		}

		return $newObj;
	}

	//Make Array of Single Elements was makeArray()
	public function make_array($a, $len){
		if(!is_array($a)){
			$_ = array();
			for ($i = 0; $i < $len; $i++){
				$_[] = $a;
			}
			$a = $_;
		}
		return $a;
	}
	
	/**
	 * CREATE A DEFAULT FRAME OBJECT
	 * @before: RevSliderPluginUpdate::defaultFrame()
	 **/
	public function default_frame($o = array(), $overwrite_with = array()){
		$f = $this->get_val($o, 'fid', 'frame_0');
		
		$_base = array(
			'grayscale'	 => array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'), //0
			'brightness' => array('frame_0' => 100, 'frame_1' => 100, 'frame_999' => 'inherit'), //100
			'blur'		 => array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'), //100
			'transformPerspective' => array('frame_0' => 600, 'frame_1' => 600, 'frame_999' => 600),
			//transform
			'x'			=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'), //0
			'y'			=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'), //0
			'z'			=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'), //0
			'scaleX'	=> array('frame_0' => 1, 'frame_1' => 1, 'frame_999' => 'inherit'), //0
			'scaleY'	=> array('frame_0' => 1, 'frame_1' => 1, 'frame_999' => 'inherit'), //0
			'opacity'	=> array('frame_0' => 0, 'frame_1' => 1, 'frame_999' => 'inherit'), //1
			'rotationX'	=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'), //0
			'rotationY'	=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'), //0
			'rotationZ'	=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'), //0
			'skewX'		=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'), //0
			'skewY'		=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'), //0
			'originX'	=> array('frame_0' => '50%', 'frame_1' => '50%', 'frame_999' => 'inherit'), //'50%'
			'originY'	=> array('frame_0' => '50%', 'frame_1' => '50%', 'frame_999' => 'inherit'), //'50%'
			'originZ'	=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'), //'0'

			//timeline
			'ease' => array('frame_0' => false, 'frame_999' => 'power3.inOut'), //'power3.inOut'
			'start' => array('frame_0' => false, 'frame_1' => 10, 'frame_999' => true), //0
			'speed' => array('frame_0' => false, 'frame_999' => 300) //300
		);
		
		$_split = array(
			'ease'		=> array('frame_0' => false, 'frame_999' => 'inherit'),
			'direction'	=> array('frame_0' => false, 'frame_999' => 'forward'), //'forward'
			'delay'		=> array('frame_0' => false, 'frame_999' => 5), //5 
			'x'			=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'),
			'y'			=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'),
			'z'			=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'),
			'scaleX'	=> array('frame_0' => 1, 'frame_1' => 1, 'frame_999' => 'inherit'),
			'scaleY'	=> array('frame_0' => 1, 'frame_1' => 1, 'frame_999' => 'inherit'),
			'rotationX'	=> array('frame_0' => 1, 'frame_1' => 1, 'frame_999' => 'inherit'),
			'rotationY'	=> array('frame_0' => 1, 'frame_1' => 1, 'frame_999' => 'inherit'),
			'rotationZ'	=> array('frame_0' => 1, 'frame_1' => 1, 'frame_999' => 'inherit'),
			'skewX'		=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'),
			'skewY'		=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'),
			'originX'	=> array('frame_0' => '50%', 'frame_1' => '50%', 'frame_999' => 'inherit'), //'50%'
			'originY'	=> array('frame_0' => '50%', 'frame_1' => '50%', 'frame_999' => 'inherit'), //'50%'
			'originZ'	=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit')
		);

		$_mask = array(
			'x'	=> array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit'),
			'y' => array('frame_0' => 0, 'frame_1' => 0, 'frame_999' => 'inherit')
		);
		
		$o['chars'] = $this->get_val($o, 'chars', array());
		$o['words'] = $this->get_val($o, 'words', array());
		$o['lines'] = $this->get_val($o, 'lines', array());
		$o['mask'] = $this->get_val($o, 'mask', array());
		$o['color'] = $this->get_val($o, 'color', array());
		$o['bgcolor'] = $this->get_val($o, 'bgcolor', array());
		
		$gs = $this->get_val($o, 'grayscale', $this->get_val($_base, array('grayscale', $f), 0));
		$bs = $this->get_val($o, 'brightness', $this->get_val($_base, array('brightness', $f), 100));
		$blr = $this->get_val($o, 'blur', $this->get_val($_base, array('blur', $f), 0));
		$fuse = (intval($gs) !== 0 || intval($bs) !== 100 || intval($blr) !== 0) ? true : false;
		
		$frame = array(
			'alias' => $this->get_val($o, 'alias', __('On Stage', 'revslider')),
			'filter' => array(
				'use' => $fuse,
				'grayscale' => $gs,
				'brightness' => $bs,
				'blur' => $blr
			),
			'transform' => array(
				'x' => $this->c_to_resp(array('default' => $this->get_val($o, 'x', $this->get_val($_base, array('x', $f), 0)))),
				'y' => $this->c_to_resp(array('default' => $this->get_val($o, 'y', $this->get_val($_base, array('y', $f), 0)))),
				'z' => $this->get_val($o, 'z', $this->get_val($_base, array('z', $f), 0)),
				'scaleX' => $this->get_val($o, 'scaleX', $this->get_val($_base, array('scaleX', $f), 1)),
				'scaleY' => $this->get_val($o, 'scaleY', $this->get_val($_base, array('scaleY', $f), 1)),
				'opacity' => $this->get_val($o, 'opacity', $this->get_val($_base, array('opacity', $f), 1)),
				'rotationX' => $this->get_val($o, 'rotationX', $this->get_val($_base, array('rotationX', $f), 0)),
				'rotationY' => $this->get_val($o, 'rotationY', $this->get_val($_base, array('rotationY', $f), 0)),
				'rotationZ' => $this->get_val($o, 'rotationZ', $this->get_val($_base, array('rotationZ', $f), 0)),
				'skewX' => $this->get_val($o, 'skewX', $this->get_val($_base, array('skewX', $f), 0)),
				'skewY' => $this->get_val($o, 'skewY', $this->get_val($_base, array('skewY', $f), 0)),
				'originX' => $this->get_val($o, 'originX', $this->get_val($_base, array('originX', $f), '50%')),
				'originY' => $this->get_val($o, 'originY', $this->get_val($_base, array('originY', $f), '50%')),
				'originZ' => $this->get_val($o, 'originY', $this->get_val($_base, array('originZ', $f), '0')),
				'transformPerspective' => $this->get_val($o, 'transformPerspective', $this->get_val($_base, array('transformPerspective', $f), '600px')),
			),
			'reverseDirection' => array(
				'x' => $this->_truefalse($this->get_val($o, 'rx', false)),
				'y' => $this->_truefalse($this->get_val($o, 'ry', false)),
				'rotationX' => $this->_truefalse($this->get_val($o, 'rrotationX', false)),
				'rotationY' => $this->_truefalse($this->get_val($o, 'rrotationY', false)),
				'rotationZ' => $this->_truefalse($this->get_val($o, 'rrotationZ', false)),
				'skewX' => $this->_truefalse($this->get_val($o, 'rskewX', false)),
				'skewY' => $this->_truefalse($this->get_val($o, 'rskewY', false)),
				'maskX' => $this->_truefalse($this->get_val($o, 'rmaskX', false)),
				'maskY' => $this->_truefalse($this->get_val($o, 'rmaskY', false)),
				'charsX' => $this->_truefalse($this->get_val($o, 'crx', false)),
				'charsY' => $this->_truefalse($this->get_val($o, 'cry', false)),
				'charsDirection' => $this->_truefalse($this->get_val($o, 'crsd', false)),
				'wordsX' => $this->_truefalse($this->get_val($o, 'wrx', false)),
				'wordsY' => $this->_truefalse($this->get_val($o, 'wry', false)),
				'wordsDirection' => $this->_truefalse($this->get_val($o, 'wrsd', false)),
				'linesX' => $this->_truefalse($this->get_val($o, 'lrx', false)),
				'linesY' => $this->_truefalse($this->get_val($o, 'lry', false)),
				'linesDirection' => $this->_truefalse($this->get_val($o, 'lrsd', false)),
				/*'z'			=> $this->get_val($o, 'rz', false),
					'scaleX'	=> $this->get_val($o, 'rscaleX', false),
				*/
			),
			'mask' => array(
				'use' => $this->_truefalse($this->get_val($o['mask'], 'use', false)),
				'x' => $this->c_to_resp(array('default' => $this->get_val($o['mask'], 'x', $this->get_val($_mask, array('x', $f), 0)))),
				'y' => $this->c_to_resp(array('default' => $this->get_val($o['mask'], 'y', $this->get_val($_mask, array('y', $f), 0))))
			),
			'color' => array(
				'color' => $this->get_val($o['color'], 'color', '#ffffff'),
				'use' => $this->get_val($o['color'], 'use', false)
			),
			'bgcolor' => array(
				'backgroundColor' => $this->get_val($o['bgcolor'], 'backgroundColor', 'transparent'),
				'use' => $this->get_val($o['bgcolor'], 'use', false)
			),
			'timeline' => array(
				//'delay' => $this->get_val($o, 'delay', 1000),
				'actionTriggered' => $this->get_val($o, 'actionTriggered', $this->get_val($_base, array('actionTriggered', $f), false)),
				'ease' => $this->get_val($o, 'ease', $this->get_val($_base, array('ease', $f), '')),
				'speed' => $this->get_val($o, 'speed', $this->get_val($_base, array('speed', $f), 300)),
				'start' => $this->get_val($o, 'start', $this->get_val($_base, array('start', $f), 0)),
				'startRelative' => $this->get_val($o, 'startRelative', 0),
				'endWithSlide' => $this->get_val($o, 'endWithSlide', false)
			),
			'chars' => array(
				'ease' => $this->get_val($o['chars'], 'ease', $this->get_val($_split, array('ease', $f), '')),
				'use' => $this->get_val($o['chars'], 'use', false),
				'direction' => $this->get_val($o['chars'], 'direction', $this->get_val($_split, array('direction', $f), '')),
				'delay' => $this->get_val($o['chars'], 'delay', $this->get_val($_split, array('delay', $f), '')),
				'x' => $this->c_to_resp(array('default' => $this->get_val($o['chars'], 'x', $this->get_val($_split, array('x', $f), 'inherit')))),
				'y' => $this->c_to_resp(array('default' => $this->get_val($o['chars'], 'y', $this->get_val($_split, array('y', $f), 'inherit')))),
				'z' => $this->get_val($o['chars'], 'z', $this->get_val($_split, array('z', $f), 'inherit')),
				'scaleX' => $this->get_val($o['chars'], 'scaleX', $this->get_val($_split, array('scaleX', $f), 'inherit')),
				'scaleY' => $this->get_val($o['chars'], 'scaleY', $this->get_val($_split, array('scaleY', $f), 'inherit')),
				'opacity' => $this->get_val($o['chars'], 'opacity', 'inherit'),
				'rotationX' => $this->get_val($o['chars'], 'rotationX', $this->get_val($_split, array('rotationX', $f), 'inherit')),
				'rotationY' => $this->get_val($o['chars'], 'rotationY', $this->get_val($_split, array('rotationY', $f), 'inherit')),
				'rotationZ' => $this->get_val($o['chars'], 'rotationZ', $this->get_val($_split, array('rotationZ', $f), 'inherit')),
				'skewX' => $this->get_val($o['chars'], 'skewX', $this->get_val($_split, array('skewX', $f), 'inherit')),
				'skewY' => $this->get_val($o['chars'], 'skewY', $this->get_val($_split, array('skewY', $f), 'inherit')),
				'originX' => $this->get_val($o['chars'], 'originX', $this->get_val($_split, array('originX', $f), '50%')),
				'originY' => $this->get_val($o['chars'], 'originY', $this->get_val($_split, array('originY', $f), '50%')),
				'originZ' => $this->get_val($o['chars'], 'originY', $this->get_val($_split, array('originZ', $f), '0')),
				'fuse' => $fuse,
				'grayscale' => $gs,
				'brightness' => $bs,
				'blur' => $blr
			),
			'words' => array(
				'ease' => $this->get_val($o['words'], 'ease', $this->get_val($_split, array('ease', $f), '')),
				'use' => $this->get_val($o['words'], 'use', false),
				'direction' => $this->get_val($o['words'], 'direction', $this->get_val($_split, array('direction', $f), '')),
				'delay' => $this->get_val($o['words'], 'delay', $this->get_val($_split, array('delay', $f), '')),
				'x' => $this->c_to_resp(array('default' => $this->get_val($o['words'], 'x', $this->get_val($_split, array('x', $f), 'inherit')))),
				'y' => $this->c_to_resp(array('default' => $this->get_val($o['words'], 'y', $this->get_val($_split, array('y', $f), 'inherit')))),
				'z' => $this->get_val($o['words'], 'z', $this->get_val($_split, array('z', $f), 'inherit')),
				'scaleX' => $this->get_val($o['words'], 'scaleX', $this->get_val($_split, array('scaleX', $f), 'inherit')),
				'scaleY' => $this->get_val($o['words'], 'scaleY', $this->get_val($_split, array('scaleY', $f), 'inherit')),
				'opacity' => $this->get_val($o['words'], 'opacity', 'inherit'),
				'rotationX' => $this->get_val($o['words'], 'rotationX', $this->get_val($_split, array('rotationX', $f), 'inherit')),
				'rotationY' => $this->get_val($o['words'], 'rotationY', $this->get_val($_split, array('rotationY', $f), 'inherit')),
				'rotationZ' => $this->get_val($o['words'], 'rotationZ', $this->get_val($_split, array('rotationZ', $f), 'inherit')),
				'skewX' => $this->get_val($o['words'], 'skewX', $this->get_val($_split, array('skewX', $f), 'inherit')),
				'skewY' => $this->get_val($o['words'], 'skewY', $this->get_val($_split, array('skewY', $f), 'inherit')),
				'originX' => $this->get_val($o['words'], 'originX', $this->get_val($_split, array('originX', $f), '50%')),
				'originY' => $this->get_val($o['words'], 'originY', $this->get_val($_split, array('originY', $f), '50%')),
				'originZ' => $this->get_val($o['words'], 'originY', $this->get_val($_split, array('originZ', $f), '0')),
				'fuse' => $fuse,
				'grayscale' => $gs,
				'brightness' => $bs,
				'blur' => $blr
			),
			'lines' => array(
				'ease' => $this->get_val($o['lines'], 'ease', $this->get_val($_split, array('ease', $f), '')),
				'use' => $this->get_val($o['lines'], 'use', false),
				'direction' => $this->get_val($o['lines'], 'direction', $this->get_val($_split, array('direction', $f), '')),
				'delay' => $this->get_val($o['lines'], 'delay', $this->get_val($_split, array('delay', $f), '')),
				'x' => $this->c_to_resp(array('default' => $this->get_val($o['lines'], 'x', $this->get_val($_split, array('x', $f), 'inherit')))),
				'y' => $this->c_to_resp(array('default' => $this->get_val($o['lines'], 'y', $this->get_val($_split, array('y', $f), 'inherit')))),
				'z' => $this->get_val($o['lines'], 'z', $this->get_val($_split, array('z', $f), 'inherit')),
				'scaleX' => $this->get_val($o['lines'], 'scaleX', $this->get_val($_split, array('scaleX', $f), 'inherit')),
				'scaleY' => $this->get_val($o['lines'], 'scaleY', $this->get_val($_split, array('scaleY', $f), 'inherit')),
				'opacity' => $this->get_val($o['lines'], 'opacity', 'inherit'),
				'rotationX' => $this->get_val($o['lines'], 'rotationX', $this->get_val($_split, array('rotationX', $f), 'inherit')),
				'rotationY' => $this->get_val($o['lines'], 'rotationY', $this->get_val($_split, array('rotationY', $f), 'inherit')),
				'rotationZ' => $this->get_val($o['lines'], 'rotationZ', $this->get_val($_split, array('rotationZ', $f), 'inherit')),
				'skewX' => $this->get_val($o['lines'], 'skewX', $this->get_val($_split, array('skewX', $f), 'inherit')),
				'skewY' => $this->get_val($o['lines'], 'skewY', $this->get_val($_split, array('skewY', $f), 'inherit')),
				'originX' => $this->get_val($o['lines'], 'originX', $this->get_val($_split, array('originX', $f), '50%')),
				'originY' => $this->get_val($o['lines'], 'originY', $this->get_val($_split, array('originY', $f), '50%')),
				'originZ' => $this->get_val($o['lines'], 'originY', $this->get_val($_split, array('originZ', $f), '0')),
				'fuse' => $fuse,
				'grayscale' => $gs,
				'brightness' => $bs,
				'blur' => $blr
			),
			'sfx' => array(
				'effect' => $this->get_val($o, 'effect', ''),
				'color' => $this->get_val($o, 'sfxcolor', '#ffffff')
			)
		);

		/*if(isset($frame['actionTriggered'])){
			$frame['timeline']['actionTriggered'] = $frame['actionTriggered'];
		}*/
		
		//only for frame_999 currently
		if($this->get_val($o, 'animation', false) === 'auto'){
			$frame['timeline']['auto'] = true;
		}
		
		if($frame['sfx']['effect'] === 'blockfrombottom'){
			$frame['sfx']['effect'] = 'blocktotop';
		}elseif($frame['sfx']['effect'] === 'blockfromtop'){
			$frame['sfx']['effect'] = 'blocktobottom';
		}elseif($frame['sfx']['effect'] === 'blockfromleft'){
			$frame['sfx']['effect'] = 'blocktoright';
		}elseif($frame['sfx']['effect'] === 'blockfromright'){
			$frame['sfx']['effect'] = 'blocktoleft';
		}else{
			$frame['sfx']['effect'] = 'none';
		}
		
		//add to all origins a % if no % or px is set
		$check = array('originX', 'originY', 'originZ');
		$path = array('transform', 'chars', 'words', 'lines');
		foreach($path as $_path){
			foreach($check as $_check){
				if(strpos($frame[$_path][$_check], '%') !== false) continue;
				if(strpos(strtolower($frame[$_path][$_check]), 'px') !== false) continue;
				
				$frame[$_path][$_check] .= '%';
			}
		}
		
		/**
		 * we need to overwrite values here once again
		 * @added because of animations, to change i.e. 'inherit' of default old to the needed value
		 **/
		if(!empty($overwrite_with)){
			$_ign = array('ease', 'speed', 'delay', 'direction', 'color'); //ignore these values and do not take them from the animation template
			
			foreach($overwrite_with as $ok => $oval){
				if(!isset($frame[$ok])) $frame[$ok] = array();
				if(is_array($oval)){
					if(!empty($oval)){
						foreach($oval as $k => $v){
							if(in_array($k, $_ign)){
								if($k == 'color'){ //ignore color only in sfx path
									if($ok == 'sfx') continue;
								}else{
									continue;
								}
							}
							$frame[$ok][$k] = $v;
						}
					}
				}else{
					if(in_array($ok, $_ign)) continue;
					
					$frame[$ok] = $oval;
				}
			}
		}
		
		return $frame;
	}

	public function conv_perc_vals($x){
		if(!is_numeric($x) && $x !== false && $x !== NULL && $x !== true && strpos($x, '%]') !== false){
			//x.split("[")[1].split("]")[0];
			$a = explode('[', $x);
			if(isset($a[1])){
				$a = explode(']', $a[1]);
				$x = $a[0];
			}
		}

		return $x;
	}

	public function c_to_v_and_u($_){
		$newObj = array('v' => $_['default'], 'u' => $_['u']);
		$newObj['v'] = (!isset($_['val'])) ? $newObj['v'] : $_['val'];

		$i = 0;
		if(is_object($newObj['v']) || is_array($newObj['v'])){
			foreach($newObj['v'] as $vi => $nov){
				if(!is_numeric($nov)){
					if($i == 0 && strpos($nov, 'px') !== false){
						$newObj['u'] = 'px';
					}elseif($i == 0 && strpos($nov, '%') !== false){
						$newObj['u'] = '%';
					}

					//$newObj['u']		= ($i == 0 && strpos($nov, 'px') !== false) ? 'px' : ($i == 0 && strpos($nov, '%') !== false) ? '%' : $newObj['u'];
					$newObj['v'][$vi] = intval(str_replace(array('%', 'px'), '', $nov)) . $newObj['u'];

					$i++;
				}
			}
		}else{
			if(!is_numeric($newObj['v'])){
				if(strpos($newObj['v'], 'px') !== false){
					$newObj['u'] = 'px';
				}elseif(strpos($newObj['v'], '%') !== false){
					$newObj['u'] = '%';
				}
				//$newObj['u'] = (strpos($newObj['v'], 'px') !== false) ? 'px' : (strpos($newObj['v'], '%') !== false) ? '%' : $newObj['u'];
				$newObj['v'] = intval(str_replace(array('%', 'px'), '', $newObj['v'])) . $newObj['u'];
			}
		}

		return $newObj;
	}

	
	/*
		CREATE A DEFAULT FRAME OBJECT
	*/
	public function default_loop_frame($o = array()){
		$o['frame_0'] = $this->get_val($o, 'frame_0', array());
		$o['frame_999'] = $this->get_val($o, 'frame_999', array());
		
		$loop = array(
			'use' => $this->get_val($o, 'use', false),
			'radiusAngle' => $this->get_val($o, 'radiusAngle', 0),
			'curviness' => $this->get_val($o, 'curviness', 2),
			'curved' => $this->get_val($o, 'curved', false),
			'yoyo_move' => $this->get_val($o, 'yoyo_move', false),
			'yoyo_rotate' => $this->get_val($o, 'yoyo_rotate', false),
			'yoyo_scale' => $this->get_val($o, 'yoyo_scale', false),
			'yoyo_filter' => $this->get_val($o, 'yoyo_filter', false),
			'repeat' => $this->get_val($o, 'repeat', '-1'),
			'start' => $this->get_val($o, 'start', 740),
			'autoRotate' => $this->get_val($o, 'autoRotate', false),
			'frame_0' => array(
				'zr' => $this->get_val($o, array('frame_0', 'zr'), 0),
				'z' => $this->get_val($o, array('frame_0', 'z'), 0),
				'opacity' => $this->get_val($o, array('frame_0', 'opacity'), 1),
				'rotationX' => $this->get_val($o, array('frame_0', 'rotationX'), 0),
				'rotationY' => $this->get_val($o, array('frame_0', 'rotationY'), 0),
				'skewX' => $this->get_val($o, array('frame_0', 'skewX'), 0),
				'skewY' => $this->get_val($o, array('frame_0', 'skewY'), 0),
				'blur' => 0,
				'brightness' => 100,
				'grayscale' => 0
			),
			'frame_999' => array(
				'zr' => $this->get_val($o, array('frame_999', 'zr'), 0),
				'z' => $this->get_val($o, array('frame_999', 'z'), 0),
				'opacity' => $this->get_val($o, array('frame_999', 'opacity'), 1),
				'rotationX' => $this->get_val($o, array('frame_999', 'rotationX'), 0),
				'rotationY' => $this->get_val($o, array('frame_999', 'rotationY'), 0),
				'skewX' => $this->get_val($o, array('frame_999', 'skewX'), 0),
				'skewY' => $this->get_val($o, array('frame_999', 'skewY'), 0),
				'blur' => 0,
				'brightness' => 100,
				'grayscale' => 0
			)
		);
		
		//add values depending on the selected animation
		$loop['speed'] = $this->get_val($o, 'speed', 1000);
		switch($this->get_val($o, 'loop_animation')){
			case 'rs-pendulum':
			case 'rs-rotate':
				$loop['ease'] = $this->get_val($o, 'ease', 'none');
				$loop['frame_0']['rotationZ'] = $this->get_val($o, array('frame_0', 'rotationZ'), 0);
				$loop['frame_999']['rotationZ'] = $this->get_val($o, array('frame_999', 'rotationZ'), 0);
				$loop['originX'] = $this->get_val($o, 'originX', '50%');
				$loop['originY'] = $this->get_val($o, 'originY', '50%');
			break;
			case 'rs-slideloop':
				$loop['ease'] = $this->get_val($o, 'ease', 'none');
				$loop['frame_0']['x'] = $this->get_val($o, array('frame_0', 'x'), 0);
				$loop['frame_999']['x'] = $this->get_val($o, array('frame_999', 'x'), 0);
				$loop['frame_0']['y'] = $this->get_val($o, array('frame_0', 'y'), 0);
				$loop['frame_999']['y'] = $this->get_val($o, array('frame_999', 'y'), 0);
			break;
			case 'rs-pulse':
				$loop['ease'] = $this->get_val($o, 'ease', 'none');
				$loop['frame_0']['scaleX'] = $this->get_val($o, array('frame_0', 'scaleX'), 1);
				$loop['frame_0']['scaleY'] = $this->get_val($o, array('frame_0', 'scaleX'), 1);
				$loop['frame_999']['scaleX'] = $this->get_val($o, array('frame_999', 'scaleX'), 1);
				$loop['frame_999']['scaleY'] = $this->get_val($o, array('frame_999', 'scaleY'), 1);
			break;
			case 'rs-wave':
				$loop['frame_0']['xr'] = $this->get_val($o, array('frame_0', 'xr'), 0);
				$loop['frame_0']['yr'] = $this->get_val($o, array('frame_0', 'yr'), 0);
				$loop['frame_999']['xr'] = $this->get_val($o, array('frame_999', 'xr'), 0);
				$loop['frame_999']['yr'] = $this->get_val($o, array('frame_999', 'yr'), 0);
			    $loop['originX'] = $this->get_val($o, 'originX', '50%');
				$loop['originY'] = $this->get_val($o, 'originY', '50%');
			break;
		}
		
		return $loop;
	}
	
	
	/**
	 * compare and remove unneeded defaults
	 **/
	public function _compare($emp, $o){
		if(!empty($o)){
			if(is_array($o) || is_object($o)){
				$o = (array)$o;
				$emp = (array)$emp;
				foreach($o as $key => $v){
					
					/**
					 * Little hacks to modify if/if not things need to be deleted
					 **/
					if($key === 'frameOrder' || $key === 'alias' || $key === 'intelligentInherit'){ //with in_array we receive unexpected results
						continue;
					}
					if($this->upgrade_layer_type === 'shape'){
						if($this->current_parent === 'idle'){
							if($key === 'backgroundColor'){ //leave it as it is
								continue;
							}
						}
						
					}
					/**
					 * END OF
					 * Little hacks to modify if/if not things need to be deleted
					 **/
					 
					if(!is_array($o[$key]) && !is_object($o[$key])){
						$check = $this->get_val($emp, $key);
						//if($check == $o[$key]){ //before the int(0) is same as '##' issue, this line was active
						if(!is_array($check) && !is_object($check) && (string)$check == (string)$o[$key]){ //int(0) is same as '##', so check by casting them to string
							//if($check === false && $o[$key] === false || $check === true && $o[$key] === true){
							//}else{
								unset($o[$key]);
							//}
						}
					}elseif($this->get_val($emp, $key, '######') !== '######'){
						if(in_array($key, array('v', 'borderWidth'), true) && is_array($o[$key])){
							if(json_encode($emp[$key]) == json_encode($o[$key])){
								unset($o[$key]);
							}
						}else{
							if($key === 'idle'){ //we check for idle, as we want to leave backgroundColor within idle 
								$this->current_parent = $key;
							}
							$o[$key] = $this->_compare($emp[$key], $o[$key]); //, $d
							if($key === 'idle'){ //we check for idle, as we want to leave backgroundColor within idle and we can set it only back to false if we are out of the idle tree
								$this->current_parent = false;
							}
						}
						
						//CHECK IF OBJECT IS EMPTY ?
						if($this->isEmptyObject($this->get_val($o, $key, ''))){
							unset($o[$key]);
						}
					}
				}
			}
		}
		
	 	return $o;
	}

	/**
	 * simplify layer, by removing all default values
	 **/
	public function _simplify_layers($_, $slide, $slider){
		if(in_array($this->get_val($_, 'uid', false), array('top', 'bottom', 'middle', 'zone'))) return $_;
		if(in_array($this->get_val($_, 'type', false), array('top', 'bottom', 'middle', 'zone'))) return $_;
		
		$type	= $this->get_val($_, 'type');
		$__		= array('type' => $type);
		if(!isset($this->blank_layer[$type])){
			$_z_index = $this->z_index;
			$this->z_index = '##'; //temporary push a none existand zindex, so that the blank layer will not delete the zindex
			
			$this->blank_layer[$type] = $this->migrate_layer_to_6_0($__, true, $slide, $slider);
			
			$this->z_index = $_z_index;
		}
		
		$this->upgrade_layer_type = $type;
		$layer = $this->_compare($this->blank_layer[$type], $_);
		
		$layer['type'] = $this->get_val($_, 'type');

		return $layer;
	}

	/**
	 * simplify layer, by removing all default values
	 **/
	public function _simplify_slides($_){
		$_slide = new RevSliderSlide();
		
		if($this->blank_slide === false){
			$this->blank_slide = $this->migrate_slide_to_6_0($_slide);
			$this->blank_slide['version'] = $this->revision;
		}
		
		if($_ instanceof RevSliderSlide){
			$params = $_->get_params();
		}else{
			$params = $_;
		}
		$slide = $this->_compare($this->blank_slide, $params);
		
		return $slide;
	}
	
	
	/**
	 * Check if it is an empty array or object
	 * @since: 6.0.0
	 **/
	public function isEmptyObject($vars){ //object	
		//$vars = get_object_vars($object);
		if(empty($vars) && $vars !== 0){ // && $vars !== false
		//if(!is_array($vars) && !is_object($vars) && trim($vars) === '' && $vars !== 0){
			return true;
		}else{
			$vars = (array)$vars;
			foreach($vars as $var){
				if(!is_array($var)){ //!is_object($var) && 
					return false;
				}else{
					return $this->isEmptyObject($var);
				}
			}
		}
	}
	
	
	/**
	 * get transparency from rgba
	 * @since: 5.0
	 */
	public function get_trans_from_rgba($rgba, $in_percent = false){
		if(strtolower($rgba) == 'transparent') return 100;
		
		$temp = explode(',', $rgba);
		if(count($temp) == 4){
			return ($in_percent) ? preg_replace('/[^\d.]/', '', $temp[3]) : preg_replace('/[^\d.]/', "", $temp[3]) * 100;
		}
		
		return 100;
	}
	
	
	/**
	 * change rgba to hex
	 * @since: 5.0
	 * @moved: 6.1.3
	 */
	public function rgba2hex($rgba){
		if(strtolower($rgba) == 'transparent') return $rgba;
		
		$temp = explode(',', $rgba);
		$rgb = array();
		if(count($temp) == 4) unset($temp[3]);
		foreach($temp as $val){
			$t = dechex(preg_replace('/[^\d.]/', '', $val));
			if(strlen($t) < 2) $t = '0'.$t;
			$rgb[] = $t;
		}
		
		return '#'.implode('', $rgb);
	}
}
