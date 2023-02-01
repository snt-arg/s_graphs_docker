<?php
/**
 * @package   Revolution Slider
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.sliderrevolution.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderNavigation extends RevSliderFunctions {
	public $version = '6.0.0';

	public function init_by_id($nav_id){
		if(intval($nav_id) == 0) return false;

		global $wpdb;

		$row = $wpdb->get_row($wpdb->prepare("SELECT `id`, `handle`, `type`, `css`, `settings` FROM ".$wpdb->prefix.RevSliderFront::TABLE_NAVIGATIONS." WHERE `id` = %d", $nav_id), ARRAY_A);

		return $row;

	}


	/**
	 * Get all Navigations Short
	 * @since: 5.0
	 **/
	public function get_all_navigations_short(){
		global $wpdb;

		$navigations = $wpdb->get_results("SELECT `id`, `handle`, `name` FROM ".$wpdb->prefix.RevSliderFront::TABLE_NAVIGATIONS, ARRAY_A);

		return $navigations;
	}


	public function get_all_navigations_builder($defaults = true, $raw = false){
		$navs = $this->get_all_navigations($defaults, $raw);

		$real_navs = array(
			'arrows'	=> array(),
			'thumbs'	=> array(),
			'bullets'	=> array(),
			'tabs'		=> array()
		);

		if(!empty($navs)){
			foreach($navs as $nav){
				$real_navs[$this->get_val($nav, 'type')][$this->get_val($nav, 'id')] = $nav;
			}
		}

		return $real_navs;
	}

	/**
	 * get cache attempt of _get_all_navigations
	 * @return mixed
	 */
	public function get_all_navigations($defaults = true, $raw = false, $old = false){
		return $this->get_wp_cache('_get_all_navigations', array($defaults, $raw, $old));
	}

	/**
	 * Get all Navigations
	 * @since: 5.0
	 **/
	protected function _get_all_navigations($defaults = true, $raw = false, $old = false){
		global $wpdb;

		$navigations = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.RevSliderFront::TABLE_NAVIGATIONS, ARRAY_A);

		if($raw == false){
			foreach($navigations as $key => $nav){
				$navigations[$key]['factory']	= false;
				$navigations[$key]['css']		= ($old === true) ? $navigations[$key]['css'] : stripslashes($navigations[$key]['css']);
				$navigations[$key]['markup']	= ($old === true) ? $navigations[$key]['markup'] : stripslashes($navigations[$key]['markup']);

				if(isset($navigations[$key]['settings'])){
					$navigations[$key]['settings'] = RevSliderFunctions::stripslashes_deep(json_decode($navigations[$key]['settings'], true));
					if(!is_array($navigations[$key]['settings'])){
						$navigations[$key]['settings'] = json_decode($navigations[$key]['settings'], true);
					}
				}
			}
		}

		if($defaults){
			$def = self::get_default_navigations();

			$default_presets = get_option('revslider-nav-preset-default', array());

			if(!empty($def)){
				if($raw == false){
					foreach($def as $key => $nav){
						$def[$key]['factory'] = true;

						if(isset($def[$key]['settings'])){
							$def[$key]['settings'] = json_decode($def[$key]['settings'], true);
						}

						//add custom settings (placeholders) to the default navigation
						if(!empty($default_presets)){
							if(!isset($def[$key]['settings'])) $def[$key]['settings'] = array();
							if(!isset($def[$key]['settings']['presets'])) $def[$key]['settings']['presets'] = array();
							foreach($default_presets as $id => $v){
								if($id !== $def[$key]['id']) continue;

								if(!empty($v)){
									foreach($v as $pr_v){
										if($this->get_val($pr_v, 'type') !== $def[$key]['type']) continue;

										$def[$key]['settings']['presets'][$this->get_val($pr_v, 'name')] = array(
											'name' => $this->get_val($pr_v, 'name'),
											'values' => $this->get_val($pr_v, 'values')
										);
									}
								}
							}
						}
					}
				}
				$navigations = array_merge($navigations, $def);
			}
		}

		foreach($navigations as $key => $nav){
			//check if this is the v6 version
			if(version_compare($this->get_val($navigations[$key], array('settings', 'version'), false), $this->version, '>=')){
				//we are v6, push settings to root
				$navigations[$key]['dim']			= $this->get_val($navigations[$key], array('settings', 'dim'), false);
				$navigations[$key]['placeholders']	= $this->get_val($navigations[$key], array('settings', 'placeholders'), false);
				$navigations[$key]['presets']		= $this->get_val($navigations[$key], array('settings', 'presets'), false);
				$navigations[$key]['version']		= $this->get_val($navigations[$key], array('settings', 'version'), false);
				unset($navigations[$key]['settings']);
			}
		}

		return $navigations;
	}


	/**
	 * Creates / Updates Navigation skins
	 * @since: 5.0
	 **/
	public function create_update_full_navigation($data){
		global $wpdb;

		if(!empty($data) && is_array($data)){

			$navigations = $this->get_all_navigations(false);

			foreach($data as $vals){
				$found = false;

				if(!isset($vals['markup']) || !isset($vals['css'])) continue;
				if($this->get_val($vals, 'factory', false) == 'true') continue; //defaults can't be deleted

				if(isset($vals['id'])){ //new will be added temporary to navs to tell here that they are new
					foreach($navigations as $nav){
						if($vals['id'] == $nav['id']){
							$found = true;
							break;
						}
					}
				}

				if($found == true){ //update
					$this->create_update_navigation($vals, $vals['id']);
				}else{ //create
					$this->create_update_navigation($vals);
				}
			}
		}

		return true;
	}

	/**
	 * Creates / Updates Navigation skins
	 * @since: 5.0
	 **/
	public function create_update_navigation($data, $nav_id = 0){
		global $wpdb;

		if($this->get_val($data, 'factory', false) == 'true') return false;

		$data['settings'] = array(
			'dim'			=> $this->get_val($data, 'dim'),
			'placeholders'	=> $this->get_val($data, 'placeholders'),
			'presets'		=> $this->get_val($data, 'presets'),
			'version'		=> $this->version
		);

		$nav_id = intval($nav_id);

		if($nav_id > 0){
			$response = $wpdb->update(
				$wpdb->prefix.RevSliderFront::TABLE_NAVIGATIONS,
				array(
					'name'		=> $this->get_val($data, 'name'),
					'handle'	=> $this->get_val($data, 'handle'),
					'markup'	=> $this->get_val($data, 'markup'),
					'css'		=> $this->get_val($data, 'css'),
					'settings'	=> json_encode($this->get_val($data, 'settings'))
				),
				array('id' => $nav_id)
			);
		}else{
			$response = $wpdb->insert(
				$wpdb->prefix.RevSliderFront::TABLE_NAVIGATIONS,
				array(
					'name'		=> $this->get_val($data, 'name'),
					'handle'	=> $this->get_val($data, 'handle'),
					'type'		=> $this->get_val($data, 'type'),
					'css'		=> $this->get_val($data, 'css'),
					'markup'	=> $this->get_val($data, 'markup'),
					'settings'	=> json_encode($this->get_val($data, 'settings'))
				)
			);
		}

		return $response;
	}


	/**
	 * Delete Navigation
	 * @since: 5.0
	 **/
	public function delete_navigation($nav_id = 0){
		global $wpdb;

		if(!isset($nav_id) || intval($nav_id) == 0) return __('Invalid ID', 'revslider');

		$response = $wpdb->delete($wpdb->prefix.RevSliderFront::TABLE_NAVIGATIONS, array('id' => $nav_id));
		if($response === false) return __('Navigation could not be deleted', 'revslider');

		return true;

	}


	/**
	 * Get Default Navigation
	 * @since: 5.0
	 **/
	public static function get_default_navigations(){
		$navigations = array();

		include(RS_PLUGIN_PATH.'includes/navigations.php');

		return apply_filters('revslider_mod_default_navigations', $navigations);
	}


	/**
	 * Translate Navigation for backwards compatibility
	 * @since: 5.0
	 **/
	public static function translate_navigation($handle){
		$translation = array(
			'round'		 => 'hesperiden',
			'navbar'	 => 'gyges',
			'preview1'	 => 'hades',
			'preview2'	 => 'ares',
			'preview3'	 => 'hebe',
			'preview4'	 => 'hermes',
			'custom'	 => 'custom',
			'round-old'	 => 'hephaistos',
			'square-old' => 'persephone',
			'navbar-old' => 'erinyen'
		);

		return (isset($translation[$handle])) ? $translation[$handle] : $handle;
	}


	/**
	 * Check if given Navigation is custom, if yes, export it
	 * @since: 5.1.1
	 **/
	public function export_navigation($nav_handle){
		$navs = self::get_all_navigations(false, true);

		if(!is_array($nav_handle)) $nav_handle = array($nav_handle => true);

		$entries = array();
		if(!empty($nav_handle) && !empty($navs)){
			foreach($nav_handle as $nav_id => $u){
				foreach($navs as $n => $v){
					//if($v['handle'] == $nav_id){
					if($v['id'] == $nav_id){
						$entries[$nav_id] = $navs[$n];
						break;
					}
				}
			}
			if(!empty($entries)) return $entries;
		}

		return false;
	}


	/**
	 * Check the CSS for placeholders, replace them with correspinding values
	 * @since: 5.2.0
	 **/
	public function add_placeholder_modifications($def_navi, $slider, $output){
		if(!is_array($def_navi)) $def_navi = json_decode($def_navi, true);

		$css	= $this->get_val($def_navi, 'css');
		$type	= $this->get_val($def_navi, 'type');
		$handle	= $this->get_val($def_navi, 'handle');

		if(!in_array($type, array('arrows', 'bullets', 'thumbs', 'tabs'))) return $css;

		$placeholders = $this->get_val($def_navi, 'placeholders', array());

		if(is_array($placeholders) && !empty($placeholders)){
			foreach($placeholders as $phandle => $ph){
				$def = $slider->get_param(array('nav', $type, 'presets', $phandle.'-def'), false);
				$replace = ($def === true) ? $slider->get_param(array('nav', $type, 'presets', $phandle), $ph['data']) : $ph['data'];
				$css	 = str_replace('##'.$phandle.'##', $replace, $css);
			}
			$css = str_replace('.'.$handle, '#'.$output->get_html_id().'_wrapper .'.$handle, $css);
		}

		return $css;
	}


	/**
	 * change rgb, rgba and hex to rgba like 120,130,50,0.5 (no () and rgb/rgba)
	 * @since: 3.0.0
	 **/
	public static function parse_css_to_array($css){

		while(strpos($css, '/*') !== false){
			if(strpos($css, '*/') === false) return false;
			$start = strpos($css, '/*');
			$end = strpos($css, '*/') + 2;
			$css = str_replace(substr($css, $start, $end - $start), '', $css);
		}

		//preg_match_all( '/(?ims)([a-z0-9\s\.\:#_\-@]+)\{([^\}]*)\}/', $css, $arr);
		preg_match_all( '/(?ims)([a-z0-9\,\s\.\:#_\-@]+)\{([^\}]*)\}/', $css, $arr);

		$result = array();
		foreach ($arr[0] as $i => $x){
			$selector = trim($arr[1][$i]);
			if(strpos($selector, '{') !== false || strpos($selector, '}') !== false) return false;
			$rules = explode(';', trim($arr[2][$i]));
			$result[$selector] = array();
			foreach ($rules as $strRule){
				if (!empty($strRule)){
					$rule = explode(':', $strRule);
					if(strpos($rule[0], '{') !== false || strpos($rule[0], '}') !== false || strpos($rule[1], '{') !== false || strpos($rule[1], '}') !== false) return false;

					//put back everything but not $rule[0];
					$key = trim($rule[0]);
					unset($rule[0]);
					$values = implode(':', $rule);

					$result[$selector][trim($key)] = trim(str_replace("'", '"', $values));
				}
			}
		}
		return $result;
	}


	/**
	 * Check the CSS for placeholders, replace them with correspinding values
	 * @since: x.x.x
	 **/
	public function add_placeholder_sub_modifications($css, $handle, $type, $placeholders, $slide, $output){
		$css_class	= RevSliderGlobals::instance()->get('RevSliderCssParser');
		$c_css		= '';

		if(!is_array($placeholders)) $placeholders = json_decode($placeholders, true);

		if(isset($placeholders) && is_array($placeholders) && !empty($placeholders)){
			//first check for media queries, generate more than one staple
			$marr = $css_class->parse_media_blocks($css);

			if(!empty($marr)){//handle them separated
				foreach($marr as $media => $mr){
					$css = str_replace($mr, '', $css);

					//clean @media query from $mr
					$mr = $css_class->clear_media_block($mr);

					//remove media query and bracket
					$d = $css_class->css_to_array($mr);

					$ret = $this->preset_return_array_css($d, $placeholders, $slide, $handle, $type, $output);
					if(trim($ret) !== ''){
						$c_css .= "\n".$media.' {'."\n";
						$c_css .= $ret;
						$c_css .= "\n".'}'."\n";
					}
				}
			}

			$c = $css_class->css_to_array($css);

			$c_css .= $this->preset_return_array_css($c, $placeholders, $slide, $handle, $type, $output);
		}

		return $c_css;
	}


	/**
	 * Returns Array CSS modifications
	 * @since: 5.2.0
	 **/
	public function preset_return_array_css($c, $placeholders, $slide, $handle, $type, $output){
		$c_css = '';
		$array_css = array();

		if(!empty($c)){
			if(!empty($placeholders)){
				foreach($placeholders as $k => $d){
					if($slide->get_param(array('nav', $type, 'presets', $k.'-def'), false) === true){ //get from Slide
						foreach($c as $class => $styles){
							foreach($styles as $name => $val){
								if(strpos($val, '##'.$k.'##') !== false){
									$e = $slide->get_param(array('nav', $type, 'presets', $k));
									$array_css[$class][$name] = str_replace('##'.$k.'##', $e, $val);
								}
							}
						}
					}
				}
			}

			if(!empty($array_css)){
				foreach($array_css as $class => $styles){
					if(!empty($styles)){
						//class needs to get current slider and slide id
						$slide_id = $slide->get_id();
						$class = str_replace('.'.$handle, '#'.$output->get_html_id().'[data-slideactive="rs-'.$slide_id.'"] .'.$handle, $class);

						$c_css .= $class.'{'."\n";
						foreach($styles as $style => $value){
							//check if there are still defaults that needs to be replaced
							if(strpos($value, '##') !== false){
								foreach($placeholders as $k => $d){
									if(strpos($value, '##'.$k.'##') !== false){
										$value = str_replace('##'.$k.'##', $d['data'], $value);
									}
								}
							}
							$c_css .= $style.': '.$value.' !important;'."\n";
						}
						$c_css .= '}'."\n";
					}
				}
			}
		}

		return $c_css;
	}


	/**
	 * Add Navigation Preset to existing navigation
	 * @since: 5.2.0
	 **/
	public function add_preset($data){
		if(!isset($data['navigation'])) return false;

		$navs = $this->get_all_navigations();

		foreach($navs as $nav){
			if($nav['id'] == $data['navigation']){ //found the navigation, get ID and update settings

				//check if default, they cant have presets in the table
				if(isset($nav['factory']) && $nav['factory'] == true){
					//check if we are a default preset, if yes return error
					if(isset($nav['presets'])){
						foreach($nav['presets'] as $prkey => $preset){
							if($prkey == $data['handle']){
								if(!isset($preset['editable'])){
									return __("Can't modify a default preset of default navigations", 'revslider');
								}
							}
						}
					}

					//we want to add the preset somewhere
					$overwrite = false;
					$default_presets = get_option('revslider-nav-preset-default', array());

					if(!empty($default_presets) && isset($default_presets[$nav['id']])){

						foreach($default_presets[$nav['id']] as $prkey => $preset){
							if($prkey == $data['handle']){
								if($data['do_overwrite'] === false || $data['do_overwrite'] === 'false'){
									return __('Preset handle already exists, please choose a different name', 'revslider');
								}

								$default_presets[$nav['id']][$prkey] = array(
									'name'		=> esc_attr($data['name']),
									//'handle'	=> esc_attr($data['handle']),
									'type'		=> esc_attr($data['type']),
									'values'	=> $data['values'],
									'editable'	=> true
								);

								$overwrite = true;
							}
						}
					}/*else{
						$default_presets = array();
					}*/


					if($overwrite === false){
						$default_presets[$nav['id']][$data['handle']] = array(
							'name'		=> esc_attr($data['name']),
							//'handle'	=> esc_attr($data['handle']),
							'type'		=> esc_attr($data['type']),
							'values'	=> $data['values'],
							'editable'	=> true
						);
					}

					update_option('revslider-nav-preset-default', $default_presets);

					//return __('Can\'t add a preset to default navigations', 'revslider');
				}else{

					$overwrite = false;

					if(isset($nav['presets']) && is_array($nav['presets']) && !empty($nav['presets'])){
						foreach($nav['presets'] as $prkey => $preset){
							if($prkey == $data['handle']){
								if($data['do_overwrite'] === false || $data['do_overwrite'] === 'false'){
									return __('Preset handle already exists, please choose a different name', 'revslider');
								}

								$nav['presets'][$prkey] = array(
									'name'		=> esc_attr($data['name']),
									//'handle'	=> esc_attr($data['handle']),
									'type'		=> esc_attr($data['type']),
									'values'	=> $data['values']
								);

								$overwrite = true;
							}
						}
					}else{
						$nav['presets'] = array();
					}

					if($overwrite === false){
						$nav['presets'][$data['handle']] = array(
							'name'		=> esc_attr($data['name']),
							//'handle'	=> esc_attr($data['handle']),
							'type'		=> esc_attr($data['type']),
							'values'	=> $data['values']
						);
					}

					$placeholders = $this->get_val($nav, 'placeholders');
					if(!empty($placeholders)){
						foreach($placeholders as $k => $pl){
							if(isset($pl['data'])){
								$placeholders[$k]['data'] = addslashes($pl['data']);
							}
						}
					}

					global $wpdb;

					//save this navigation
					$response = $wpdb->update(
						$wpdb->prefix.RevSliderFront::TABLE_NAVIGATIONS,
						array(
							'settings' => json_encode(
								array(
									'dim'		=> $this->get_val($nav, 'dim'),
									'placeholders' => $placeholders,
									'presets'	=> $this->get_val($nav, 'presets'),
									'version'	=> $this->version
								)
							)
						),
						array('id' => $nav['id'])
					);

					if($response == 0) $response = false;
				}

				return true;
			}
		}

		return __('Navigation not found, could not add preset', 'revslider');

	}


	/**
	 * Add Navigation Preset to existing navigation
	 * @since: 5.2.0
	 **/
	public function delete_preset($data){

		if(!isset($data['style_handle']) || !isset($data['handle']) || !isset($data['type'])) return false;

		$navs = $this->get_all_navigations();

		foreach($navs as $nav){
			if($nav['id'] != $data['style_handle']) continue;
			if($nav['type'] != $data['type']) continue;

			//found the navigation, get ID and update settings
			//check if default, they cant have presets
			if(isset($nav['factory']) && $nav['factory'] == true){
				$default_presets = get_option('revslider-nav-preset-default', array());

				if(!empty($default_presets) && isset($default_presets[$nav['id']])){

					foreach($default_presets[$nav['id']] as $prkey => $preset){
						if($preset['name'] == $data['handle']){
							unset($default_presets[$nav['id']][$prkey]);

							update_option('revslider-nav-preset-default', $default_presets);

							return true;
						}
					}
					return __('Can\'t delete default preset of default navigations', 'revslider');
				}
				return __('Preset not found in default navigations', 'revslider');
			}else{
				if(isset($nav['presets'])){
					foreach($nav['presets'] as $pkey => $preset){
						if($preset['handle'] == $data['handle']){
							//delete
							unset($nav['presets'][$pkey]);

							break;
						}
					}
				}else{
					return __('Preset not found', 'revslider');
				}

				global $wpdb;

				//save this navigation
				$response = $wpdb->update(
					$wpdb->prefix.RevSliderFront::TABLE_NAVIGATIONS,
					array(
						'settings' => json_encode(
							array(
								'dim'			=> $this->get_val($nav, 'dim'),
								'placeholders'	=> $this->get_val($nav, 'placeholders'),
								'presets'		=> $this->get_val($nav, 'presets'),
								'version'		=> $this->version
							)
						)
					),
					array('id' => $nav['id'])
				);

				return $response;
			}
		}

		return __('Navigation not found, could not delete preset', 'revslider');
	}

}
