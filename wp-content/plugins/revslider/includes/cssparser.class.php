<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderCssParser extends RevSliderFunctions {
	
	public $css;
	
	/**
	 * init the parser, set css content
	 * @before: RevSliderCssParser::initContent()
	 */
	public function init_css($css){
		$this->css = $css;
	}
	
	/**
	 * get array of slide classes, between two sections.
	 * @before: RevSliderCssParser::getArrClasses()
	 */
	public function get_classes($start_text = '', $end_text = '', $explodeonspace = false){
		$content = $this->css;
		$classes = array();
		
		//trim from top
		if(!empty($start_text)){
			$pos_start	= strpos($content, $start_text);
			$content	= ($pos_start !== false) ? substr($content, $pos_start, strlen($content) - $pos_start) : $content;
		}
		
		//trim from bottom
		if(!empty($end_text)){
			$pos_end = strpos($content, $end_text);
			$content = ($pos_end !== false) ? substr($content, 0, $pos_end) : $content;
		}
		
		//get styles
		$lines = explode("\n", $content);
		
		foreach($lines as $key => $line){
			$line = trim($line);
			if(strpos($line, '{') === false || strpos($line, '.caption a') || strpos($line, '.tp-caption a') !== false)
				continue;
			
			//get style out of the line
			$class = trim(str_replace('{', '', $line));
			
			//skip captions like this: .tp-caption.imageclass img
			if(strpos($class, ' ') !== false){
				if(!$explodeonspace){
					continue;
				}else{
					$class = explode(',', $class);
					$class = $class[0];
				}
			}
			//skip captions like this: .tp-caption.imageclass:hover, :before, :after
			if(strpos($class, ':') !== false)
				continue;
			
			$class = str_replace(array('.caption.', '.tp-caption.'), '.', $class);
			$class = trim(str_replace('.', '', $class));
			$words = explode(' ', $class);
			$class = $words[count($words)-1];
			$class = trim($class);
			
			$classes[] = $class;
		}
		
		sort($classes);
		
		return $classes;
	}
	
	
	/**
	 * parse css stylesheet to an array
	 * @before: RevSliderCssParser::parseCssToArray();
	 **/
	public function css_to_array($css){
		
		while(strpos($css, '/*') !== false){
			if(strpos($css, '*/') === false) return false;
			$start	= strpos($css, '/*');
			$end	= strpos($css, '*/') + 2;
			$css	= str_replace(substr($css, $start, $end - $start), '', $css);
		}
		
		//preg_match_all('/(?ims)([a-z0-9\s\.\:#_\-@]+)\{([^\}]*)\}/', $css, $arr);
		preg_match_all('/(?ims)([a-z0-9\,\s\.\:#_\-@]+)\{([^\}]*)\}/', $css, $arr);

		$result = array();
		foreach($arr[0] as $i => $x){
			$selector = trim($arr[1][$i]);
			if(strpos($selector, '{') !== false || strpos($selector, '}') !== false) return false;
			$rules = explode(';', trim($arr[2][$i]));
			$result[$selector] = array();
			foreach($rules as $strRule){
				if(!empty($strRule)){
					$rule = explode(':', $strRule);
					//does not work if in css is another { or }
					//if(strpos($rule[0], '{') !== false || strpos($rule[0], '}') !== false || strpos($rule[1], '{') !== false || strpos($rule[1], '}') !== false) return false;
					
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
	 * parse database entry to css
	 * @before: RevSliderCssParser::parseDbArrayToCss();
	 **/
	public function parse_db_to_css($css_array, $nl = "\n\r"){
		$css = '';
		$deformations = $this->get_deformation_css_tags();
		
		$transparency = array(
			'color'				=> 'color-transparency',
			'background-color'	=> 'background-transparency',
			'border-color'		=> 'border-transparency'
		);
		
		$check_parameters = array(
			'border-width'	=> 'px',
			'border-radius'	=> 'px',
			'padding'		=> 'px',
			'font-size'		=> 'px',
			'line-height'	=> 'px'
		);
		
		foreach($css_array as $id => $attr){
			$stripped	= (strpos($attr['handle'], '.tp-caption') !== false) ? trim(str_replace('.tp-caption', '', $attr['handle'])) : '';
			$attr['advanced'] = json_decode($attr['advanced'], true);
			$styles		= json_decode(str_replace("'", '"', $attr['params']), true);
			$styles_adv	= $attr['advanced']['idle'];
			$css		.= $attr['handle'];
			$css		.= (!empty($stripped)) ? ', '.$stripped : '';
			$css		.= ' {'.$nl;
			
			if(is_array($styles) || is_array($styles_adv)){
				if(is_array($styles)){
					foreach($styles as $name => $style){
						if(in_array($name, $deformations) && $name !== 'cursor') continue;
						
						if(!is_array($name) && isset($transparency[$name])){ //the style can have transparency!
							if(isset($styles[$transparency[$name]]) && $style !== 'transparent'){
								$style = $this->hex2rgba($style, $styles[$transparency[$name]] * 100);
							}
						}
						if(!is_array($name) && isset($check_parameters[$name])){
							$style = $this->add_missing_val($style, $check_parameters[$name]);
						}
						if(is_array($style) || is_object($style)) $style = implode(' ', $style);
						
						$ret = $this->check_for_modifications($name, $style);
						if($ret['name'] == 'cursor' && $ret['style'] == 'auto') continue;
						
						$css .= $ret['name'].':'.$ret['style'].";".$nl;
					}
				}
				if(is_array($styles_adv)){
					foreach($styles_adv as $name => $style){
						if(in_array($name, $deformations) && $name !== 'cursor') continue;
						
						if(is_array($style) || is_object($style)) $style = implode(' ', $style);
						$ret = $this->check_for_modifications($name, $style);
						if($ret['name'] == 'cursor' && $ret['style'] == 'auto') continue;
						$css .= $ret['name'].':'.$ret['style'].";".$nl;
					}
				}
			}
			$css .= '}'.$nl.$nl;
			
			//add hover
			$setting = json_decode($attr['settings'], true);
			if(isset($setting['hover']) && $setting['hover'] == 'true'){
				$hover = json_decode(str_replace("'", '"', $attr['hover']), true);
				$hover_adv = $attr['advanced']['hover'];
				
				if(is_array($hover) || is_array($hover_adv)){
					$css .= $attr['handle'].':hover';
					if(!empty($stripped)) $css .= ', '.$stripped.':hover';
					$css .= ' {'.$nl;
					if(is_array($hover)){
						foreach($hover as $name => $style){
							if(in_array($name, $deformations) && $name !== 'cursor') continue;
							
							if(!is_array($name) && isset($transparency[$name])){ //the style can have transparency!
								if(isset($hover[$transparency[$name]]) && $style !== 'transparent'){
									$style = $this->hex2rgba($style, $hover[$transparency[$name]] * 100);
								}
							}
							if(!is_array($name) && isset($check_parameters[$name])){
								$style = $this->add_missing_val($style, $check_parameters[$name]);
							}
							if(is_array($style)|| is_object($style)) $style = implode(' ', $style);
							
							$ret = $this->check_for_modifications($name, $style);
							if($ret['name'] == 'cursor' && $ret['style'] == 'auto') continue;
							
							$css .= $ret['name'].':'.$ret['style'].";".$nl;
						}
					}
					if(is_array($hover_adv)){
						foreach($hover_adv as $name => $style){
							
							if(in_array($name, $deformations) && $name !== 'cursor') continue;
							if(is_array($style)|| is_object($style)) $style = implode(' ', $style);
							$ret = $this->check_for_modifications($name, $style);
							if($ret['name'] == 'cursor' && $ret['style'] == 'auto') continue;
							$css .= $ret['name'].':'.$ret['style'].";".$nl;
						}
					}
					$css .= '}'.$nl.$nl;
				}
			}
		}
		
		return $css;
	}
	
	
	/**
	 * Check for Modifications like with cursor
	 * @since: 5.1.3
	 **/
	public function check_for_modifications($name, $style){
		if($name == 'cursor'){
			$style	= ($style == 'zoom-in') ? 'zoom-in; -webkit-zoom-in; cursor: -moz-zoom-in' : $style;
			$style	= ($style == 'zoom-out') ? 'zoom-out; -webkit-zoom-out; cursor: -moz-zoom-out' : $style;
			$name	= 'cursor';
		}
		
		return array('name' => $name, 'style' => $style);
	}
	
	
	/**
	 * Check for Modifications like with cursor
	 * @before: RevSliderCssParser::parseArrayToCss();
	 **/
	public function array_to_css($css_array, $nl = "\n\r", $adv = false){
		$css			= '';
		$deformations	= $this->get_deformation_css_tags();
		
		foreach($css_array as $id => $attr){
			$setting	= (array)$attr['settings'];
			$advanced	= (array)$attr['advanced'];
			$stripped	= (strpos($attr['handle'], '.tp-caption') !== false) ? trim(str_replace('.tp-caption', '', $attr['handle'])) : '';
			$styles		= (array)$attr['params'];
			$css		.= $attr['handle'];
			$css		.= (!empty($stripped)) ? ', '.$stripped : $css;
			$css		.= ' {'.$nl;
			
			if($adv && isset($advanced['idle'])){
				$styles = array_merge($styles, (array)$advanced['idle']);
				if(isset($setting['type'])){
					$styles['type'] = $setting['type'];
				}
			}
			
			if(is_array($styles) && !empty($styles)){
				foreach($styles as $name => $style){
					if(in_array($name, $deformations) && $name !== 'cursor') continue;
					
					if($name == 'background-color' && strpos($style, 'rgba') !== false){ //rgb && rgba
						$rgb = explode(',', str_replace('rgba', 'rgb', $style));
						unset($rgb[count($rgb)-1]);
						$rgb = implode(',', $rgb).')';
						$css .= $name.':'.$rgb.';'.$nl;
					}
					
					$style	= (is_array($style) || is_object($style)) ? implode(' ', $style) : $style;
					$css	.= $name.':'.$style.';'.$nl;
				}
			}
			
			$css .= '}'.$nl.$nl;
			
			//add hover
			if(isset($setting['hover']) && $setting['hover'] == 'true'){
				$hover = (array)$attr['hover'];
				if($adv && isset($advanced['hover'])){
					$styles = array_merge($styles, (array)$advanced['hover']);
				}
				
				if(is_array($hover)){
					$css .= $attr['handle'].':hover';
					if(!empty($stripped)) $css.= ', '.$stripped.':hover';
					$css .= ' {'.$nl;
					foreach($hover as $name => $style){
						if($name == 'background-color' && strpos($style, 'rgba') !== false){ //rgb && rgba
							$rgb  = explode(',', str_replace('rgba', 'rgb', $style));
							unset($rgb[count($rgb)-1]);
							$rgb  = implode(',', $rgb).')';
							$css .= $name.':'.$rgb.';'.$nl;
						}
						$style	 = (is_array($style) || is_object($style)) ? implode(' ', $style) : $style;
						$css 	.= $name.':'.$style.';'.$nl;
					}
					$css .= '}'.$nl.$nl;
				}
			}
		}
		
		return $css;
	}
	
	
	/**
	 * parse static database to css
	 * @before: RevSliderCssParser::parseStaticArrayToCss();
	 **/
	public function static_to_css($css_array, $nl = "\n"){
		return $this->simple_array_to_css($css_array);
	}
	
	
	/**
	 * parse simple array to css
	 * @before: RevSliderCssParser::parseSimpleArrayToCss();
	 **/
	public function simple_array_to_css($css_array, $nl = "\n"){
		$css = '';
		foreach($css_array as $class => $styles){
			$css .= $class.' {'.$nl;
			if(is_array($styles) && !empty($styles)){
				foreach($styles as $name => $style){
					$style = (is_array($style) || is_object($style)) ? implode(' ', $style) : $style;
					$css  .= $name.':'.$style.';'.$nl;
				}
			}
			$css .= '}'.$nl.$nl;
		}
		
		return $css;
	}
	
	
	/**
	 * parse db array to array
	 * @before: RevSliderCssParser::parseDbArrayToArray();
	 **/
	public function db_array_to_array($css_array, $handle = false){
		
		if(!is_array($css_array) || empty($css_array)) return false;
		
		foreach($css_array as $key => $css){
			if($handle != false){
				if($this->get_val($css_array[$key], 'handle') == '.tp-caption.'.$handle){
					$css_array[$key]['params']	 = json_decode(str_replace("'", '"', $this->get_val($css, 'params')));
					$css_array[$key]['hover']	 = json_decode(str_replace("'", '"', $this->get_val($css, 'hover')));
					$css_array[$key]['advanced'] = json_decode(str_replace("'", '"', $this->get_val($css, 'advanced')));
					$css_array[$key]['settings'] = json_decode(str_replace("'", '"', $this->get_val($css, 'settings')));
					return $css_array[$key];
				}else{
					unset($css_array[$key]);
				}
			}else{
				$css_array[$key]['params']	 = json_decode(str_replace("'", '"', $this->get_val($css, 'params')));
				$css_array[$key]['hover']	 = json_decode(str_replace("'", '"', $this->get_val($css, 'hover')));
				$css_array[$key]['advanced'] = json_decode(str_replace("'", '"', $this->get_val($css, 'advanced')));
				$css_array[$key]['settings'] = json_decode(str_replace("'", '"', $this->get_val($css, 'settings')));
			}
		}
		
		return $css_array;
	}
	
	
	/**
	 * compress the css
	 **/
	public function compress_css($buffer){
		/* remove comments */
		$buffer = preg_replace("!/\*[^*]*\*+([^/][^*]*\*+)*/!", '', $buffer) ;
		/* remove tabs, spaces, newlines, etc. */
		$arr = array("\r\n", "\r", "\n", "\t", '  ', '    ', '    ');
		$rep = array('', '', '', '', ' ', ' ', ' ');
		$buffer = str_replace($arr, $rep, $buffer);
		/* remove whitespaces around {}:, */
		$buffer = preg_replace("/\s*([\{\}:,])\s*/", "$1", $buffer);
		/* remove last ; */
		$buffer = str_replace(';}', '}', $buffer);
		
		return $buffer;
	}
	
	
	/**
	 * Defines the default CSS Classes, can be given a version number to order them accordingly
	 * @since: 5.0
	 **/
	public function default_css_classes(){
		$c = '.tp-caption';
		
		$default = array(
			$c.'.medium_grey'				=> '4',
			$c.'.small_text'				=> '4',
			$c.'.medium_text'				=> '4',
			$c.'.large_text'				=> '4',
			$c.'.very_large_text'			=> '4',
			$c.'.very_big_white'			=> '4',
			$c.'.very_big_black'			=> '4',
			$c.'.modern_medium_fat'			=> '4',
			$c.'.modern_medium_fat_white'	=> '4',
			$c.'.modern_medium_light'		=> '4',
			$c.'.modern_big_bluebg'			=> '4',
			$c.'.modern_big_redbg'			=> '4',
			$c.'.modern_small_text_dark'	=> '4',
			$c.'.boxshadow'					=> '4',
			$c.'.black'						=> '4',
			$c.'.noshadow'					=> '4',
			$c.'.thinheadline_dark'			=> '4',
			$c.'.thintext_dark'				=> '4',
			$c.'.largeblackbg'				=> '4',
			$c.'.largepinkbg'				=> '4',
			$c.'.largewhitebg'				=> '4',
			$c.'.largegreenbg'				=> '4',
			$c.'.excerpt'					=> '4',
			$c.'.large_bold_grey'			=> '4',
			$c.'.medium_thin_grey'			=> '4',
			$c.'.small_thin_grey'			=> '4',
			$c.'.lightgrey_divider'			=> '4',
			$c.'.large_bold_darkblue'		=> '4',
			$c.'.medium_bg_darkblue'		=> '4',
			$c.'.medium_bold_red'			=> '4',
			$c.'.medium_light_red'			=> '4',
			$c.'.medium_bg_red'				=> '4',
			$c.'.medium_bold_orange'		=> '4',
			$c.'.medium_bg_orange'			=> '4',
			$c.'.grassfloor'				=> '4',
			$c.'.large_bold_white'			=> '4',
			$c.'.medium_light_white'		=> '4',
			$c.'.mediumlarge_light_white'	=> '4',
			$c.'.mediumlarge_light_white_center' => '4',
			$c.'.medium_bg_asbestos' 		=> '4',
			$c.'.medium_light_black' 		=> '4',
			$c.'.large_bold_black'			=> '4',
			$c.'.mediumlarge_light_darkblue'=> '4',
			$c.'.small_light_white'			=> '4',
			$c.'.roundedimage'				=> '4',
			$c.'.large_bg_black'			=> '4',
			$c.'.mediumwhitebg'				=> '4',
			$c.'.MarkerDisplay'				=> '5.0',
			$c.'.Restaurant-Display'		=> '5.0',
			$c.'.Restaurant-Cursive'		=> '5.0',
			$c.'.Restaurant-ScrollDownText'	=> '5.0',
			$c.'.Restaurant-Description'	=> '5.0',
			$c.'.Restaurant-Price'			=> '5.0',
			$c.'.Restaurant-Menuitem'		=> '5.0',
			$c.'.Furniture-LogoText'		=> '5.0',
			$c.'.Furniture-Plus'			=> '5.0',
			$c.'.Furniture-Title'			=> '5.0',
			$c.'.Furniture-Subtitle'		=> '5.0',
			$c.'.Gym-Display'				=> '5.0',
			$c.'.Gym-Subline'				=> '5.0',
			$c.'.Gym-SmallText'				=> '5.0',
			$c.'.Fashion-SmallText'			=> '5.0',
			$c.'.Fashion-BigDisplay'		=> '5.0',
			$c.'.Fashion-TextBlock'			=> '5.0',
			$c.'.Sports-Display'			=> '5.0',
			$c.'.Sports-DisplayFat'			=> '5.0',
			$c.'.Sports-Subline'			=> '5.0',
			$c.'.Instagram-Caption'			=> '5.0',
			$c.'.News-Title'				=> '5.0',
			$c.'.News-Subtitle'				=> '5.0',
			$c.'.Photography-Display'		=> '5.0',
			$c.'.Photography-Subline'		=> '5.0',
			$c.'.Photography-ImageHover'	=> '5.0',
			$c.'.Photography-Menuitem'		=> '5.0',
			$c.'.Photography-Textblock'		=> '5.0',
			$c.'.Photography-Subline-2'		=> '5.0',
			$c.'.Photography-ImageHover2'	=> '5.0',
			$c.'.WebProduct-Title'			=> '5.0',
			$c.'.WebProduct-SubTitle'		=> '5.0',
			$c.'.WebProduct-Content'		=> '5.0',
			$c.'.WebProduct-Menuitem'		=> '5.0',
			$c.'.WebProduct-Title-Light'	=> '5.0',
			$c.'.WebProduct-SubTitle-Light'	=> '5.0',
			$c.'.WebProduct-Content-Light'	=> '5.0',
			$c.'.FatRounded'				=> '5.0',
			$c.'.NotGeneric-Title'			=> '5.0',
			$c.'.NotGeneric-SubTitle'		=> '5.0',
			$c.'.NotGeneric-CallToAction'	=> '5.0',
			$c.'.NotGeneric-Icon'			=> '5.0',
			$c.'.NotGeneric-Menuitem'		=> '5.0',
			$c.'.MarkerStyle'				=> '5.0',
			$c.'.Gym-Menuitem'				=> '5.0',
			$c.'.Newspaper-Button'			=> '5.0',
			$c.'.Newspaper-Subtitle'		=> '5.0',
			$c.'.Newspaper-Title'			=> '5.0',
			$c.'.Newspaper-Title-Centered'	=> '5.0',
			$c.'.Hero-Button'				=> '5.0',
			$c.'.Video-Title'				=> '5.0',
			$c.'.Video-SubTitle'			=> '5.0',
			$c.'.NotGeneric-Button'			=> '5.0',
			$c.'.NotGeneric-BigButton'		=> '5.0',
			$c.'.WebProduct-Button'			=> '5.0',
			$c.'.Restaurant-Button'			=> '5.0',
			$c.'.Gym-Button'				=> '5.0',
			$c.'.Gym-Button-Light'			=> '5.0',
			$c.'.Sports-Button-Light'		=> '5.0',
			$c.'.Sports-Button-Red'			=> '5.0',
			$c.'.Photography-Button'		=> '5.0',
			$c.'.Newspaper-Button-2'		=> '5.0'
		);
		
		return apply_filters('revslider_mod_default_css_handles', $default);
	}
	
	
	/**
	 * Defines the deformation CSS which is not directly usable as pure CSS
	 * @since: 5.0
	 **/
	public function get_deformation_css_tags(){
		
		return array(
			'x'					 => 'x',
			'y'					 => 'y',
			'z'					 => 'z',
			'skewx'				 => 'skewx',
			'skewy'				 => 'skewy',
			'scalex'			 => 'scalex',
			'scaley'			 => 'scaley',
			'opacity'			 => 'opacity',
			'xrotate'			 => 'xrotate',
			'yrotate'			 => 'yrotate',
			'2d_rotation'		 => '2d_rotation',
			'layer_2d_origin_x'	 => 'layer_2d_origin_x',
			'layer_2d_origin_y'	 => 'layer_2d_origin_y',
			'2d_origin_x'		 => '2d_origin_x',
			'2d_origin_y'		 => '2d_origin_y',
			'pers'				 => 'pers',
			
			'color-transparency' => 'color-transparency',
			'background-transparency' => 'background-transparency',
			'border-transparency'=> 'border-transparency',
			'cursor'			 => 'cursor',
			'speed'				 => 'speed',
			'easing'			 => 'easing',
			'corner_left'		 => 'corner_left',
			'corner_right'		 => 'corner_right',
			'parallax'			 => 'parallax',
			'type'				 => 'type',
			'padding'			 => 'padding',
			'margin'			 => 'margin',
			'text-align'		 => 'text-align'
		);
		
	}
	
	
	/**
	 * return the captions sorted by handle name
	 **/
	public function get_captions_sorted(){
		global $wpdb;
		
		$styles = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix . RevSliderFront::TABLE_CSS . " ORDER BY handle ASC", ARRAY_A);
		$arr	= array('5.0' => array(), 'Custom' => array(), '4' => array());
		
		foreach($styles as $style){
			$setting = json_decode($this->get_val($style, 'settings'), true);
			
			if(!isset($setting['type'])) $setting['type'] = 'text';
			
			if(array_key_exists('version', $setting) && isset($setting['version'])) $arr[ucfirst($setting['version'])][] = array('label' => trim(str_replace('.tp-caption.', '', $style['handle'])), 'type' => $setting['type']);
		}

		$sorted = array();
		foreach($arr as $version => $class){
			foreach($class as $name){
				$sorted[] = array('label' => $this->get_val($name, 'label'), 'version' => $version, 'type' => $this->get_val($name, 'type'));
			}
		}
		
		return $sorted;
	}
	
	
	/**
	 * Handles media queries
	 * @since: 5.2.0
	 **/
	public function parse_media_blocks($css){
		$blocks	= array();
		$start	= 0;
		
		while(($start = strpos($css, '@media', $start)) !== false){
			$s = array();
			$i = strpos($css, '{', $start);
			
			if ($i !== false){
				$block = trim(substr($css, $start, $i - $start));
				array_push($s, $css[$i]);
				$i++;

				while(!empty($s)){
					if($css[$i] == '{'){
						array_push($s, '{');
					}elseif($css[$i] == '}'){
						array_pop($s);
					}else{
						//broken css?
					}
					$i++;
				}
				
				$blocks[$block] = substr($css, $start, ($i + 1) - $start);
				$start = $i;
			}
		}

		return $blocks;
	}
	
	
	/**
	 * removes @media { ... } queries from CSS
	 * @since: 5.2.0
	 **/
	public function clear_media_block($css){
		$start = 0;
		
		if(empty($css)) return $css;
		
		if(strpos($css, '@media', $start) !== false){
			$start	= strpos($css, '@media', 0);
			$i		= strpos($css, '{', $start);
			if($i === false) return $css;
			$i += 1;
			$remove	= substr($css, $start - 1, $i - $start + 1); //remove @media ... first {
			$css	= str_replace($remove, '', $css);
			$css	= preg_replace('/}$/', '', $css); //remove last }
		}
		
		return $css;
	}
	
	
	
	/**
	 * import contents of the css file
	 * @before: RevSliderOperations::importCaptionsCssContentArray()
	 */
	public function import_css_captions(){
		global $wpdb;
		
		$css	= $this->get_base_css_captions();
		$static	= array();
		
		if(is_array($css) && $css !== false && count($css) > 0){
			foreach($css as $class => $styles){
				//check if static style or dynamic style
				$class = trim($class);

				if((strpos($class, ':hover') === false && strpos($class, ':') !== false) || //before, after
					strpos($class, ' ') !== false || // .tp-caption.imageclass img or .tp-caption .imageclass or .tp-caption.imageclass .img
					strpos($class, '.tp-caption') === false || // everything that is not tp-caption
					(strpos($class, '.') === false || strpos($class, '#') !== false) || // no class -> #ID or img
					strpos($class, '>') !== false){ //.tp-caption>.imageclass or .tp-caption.imageclass>img or .tp-caption.imageclass .img

					$static[$class] = $styles;
					continue;
				}

				//is a dynamic style
				if(strpos($class, ':hover') !== false){
					$class	= trim(str_replace(':hover', '', $class));
					$add	= array(
						'hover'		=> json_encode($styles),
						'settings'	=> json_encode(array('hover' => 'true'))
					);
				}else{
					$add	= array(
						'params'	=> json_encode($styles)
					);
				}
				
				//check if class exists
				$result = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix . RevSliderFront::TABLE_CSS." WHERE handle = %s", $class), ARRAY_A);
				
				if(!empty($result)){ //update
					$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_CSS, $add, array('handle' => $class));
				}else{ //insert
					$add['handle'] = $class;
					$wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_CSS, $add);
				}
			}
		}
		
		if(!empty($static)){ //save static into static-captions.css
			$css = $this->get_static_css()."\n".$this->static_to_css($static); //get the open sans line!

			$this->update_static_css($css);
		}
	}
	
	
	/**
	 * get contents of the css file
	 * @before: RevSliderOperations::getCaptionsCssContentArray();
	 */
	public function get_base_css_captions(){
		include(RS_PLUGIN_PATH . 'includes/basic-css.php');
		
		return $this->css_to_array($css);
	}
	
	
	/**
	 * get the css raw from the database
	 */
	public function get_raw_css(){
		global $wpdb;
		
		$result = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix . RevSliderFront::TABLE_CSS, ARRAY_A);
		
		return $result;
	}
	
	
	/**
	 * get the css from the database and set it into an object structure
	 */
	public function get_database_classes($adv = false){
		$css = $this->get_raw_css();
		
		if(!empty($css)){
			foreach($css as $k => $v){
				if($adv === true){
					$css[$v['handle']]['hover']		= json_decode($this->get_val($v, 'hover', ''), true);
					$css[$v['handle']]['params']	= json_decode($this->get_val($v, 'params', ''), true);
					$css[$v['handle']]['settings']	= json_decode($this->get_val($v, 'settings', ''), true);
				}else{
					unset($css[$v['handle']]['hover']);
					unset($css[$v['handle']]['params']);
					unset($css[$v['handle']]['settings']);
				}
				$css[$v['handle']]['advanced'] = json_decode($this->get_val($v, 'advanced', ''), true);
			}
		}
		
		return $css;
	}
	
	
	/**
	 * add missing px/% to value, do also for object and array
	 * @since: 5.0
	 **/
	public function add_missing_val($obj, $set_to = 'px'){
		if(is_array($obj)){
			foreach($obj as $key => $value){
				if(strpos($value, $set_to) === false){
					$obj[$key] = $value.$set_to;
				}
			}
		}elseif(is_object($obj)){
			foreach($obj as $key => $value){
				if(is_object($value)){
					if(isset($value->v)){
						if(strpos($value->v, $set_to) === false){
							$obj->$key->v = $value->v.$set_to;
						}
					}
				}else{
					if(strpos($value, $set_to) === false){
						$obj->$key = $value.$set_to;
					}
				}
			}
		}else{
			if(strpos($obj, $set_to) === false){
				$obj .= $set_to;
			}
		}
		
		return $obj;
	}
	
	
	/**
	 * change hex to rgba
	 */
    public function hex2rgba($hex, $transparency = false, $raw = false, $do_rgb = false){
        if($transparency !== false){
			$transparency = ($transparency > 0) ? number_format(($transparency / 100), 2, '.', '') : 0;
        }else{
            $transparency = 1;
        }

        $hex = str_replace('#', '', $hex);
		
        if(strlen($hex) == 3){
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        }elseif($this->is_rgb($hex)){
			return $hex;
		}else{
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
		
		$ret = ($do_rgb) ? $r.', '.$g.', '.$b : $r.', '.$g.', '.$b.', '.$transparency;
		
		return ($raw) ? $ret : 'rgba('.$ret.')';
    }
}