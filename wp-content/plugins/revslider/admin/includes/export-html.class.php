<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderSliderExportHtml extends RevSliderSliderExport {
	
	public $path_fonts		= 'fonts/';
	public $path_css		= 'css/';
	public $path_js			= 'js/';
	public $path_assets		= 'assets';
	public $path_assets_raw	= 'assets';
	public $path_assets_vid	= 'assets';
	public $path_assets_raw_vid	= 'assets';
	public $export_real		= true;
	
	public $slider_output	= false;
	public $slider_html		= '';
	public $export_font		= '';
	public $export_scripts	= '';
	public $export_styles	= '';
	
	private $slider_title	= '';
	private $layouttype		= '';
	
	
	public function __construct(){
		parent::__construct();
		
		if(!$this->export_real){ //set all different file path's here
			$this->path_fonts		= '../../revolution/fonts/';
			$this->path_css			= '../../revolution/css/';
			$this->path_js			= '../../revolution/js/';
			$this->path_assets		= '../../assets/images';
			$this->path_assets_raw	= 'assets/images';
			$this->path_assets_vid	= '../../assets/videos';
			$this->path_assets_raw_vid = 'assets/videos';
		}
		
	}
	
	
	/**
	 * export slider HTML as a zip file
	 **/
	public function export_slider_html($slider_id){
		if($slider_id == 'empty_output'){
			echo __('Wrong request!', 'revslider');
			exit;
		}
		
		$this->create_export_zip();
		
		$slider = new RevSliderSlider();
		$slider->init_by_id($slider_id);
		
		//check if an update is needed
		if(version_compare($slider->get_param(array('settings', 'version')), get_option('revslider_update_version', '6.0.0'), '<')){
			$upd = new RevSliderPluginUpdate();
			$upd->upgrade_slider_to_latest($slider);
			$slider->init_by_id($slider_id);
		}
		
		if($slider->get_param('pakps', false) === true && $this->_truefalse(get_option('revslider-valid', 'false')) === false){
			echo __('Wrong request!', 'revslider');
			exit;
		}

		$this->slider_title	= $slider->get_title();
		$this->slider_alias	= $slider->get_alias();
		
		$this->layouttype	= $slider->get_param('layouttype');
		
		$this->slider_output = new RevSliderOutput();
		
		ob_start();
		$this->slider_output->set_slider_id($slider_id);
		$this->slider_output->set_markup_export(true);
		$this->slider_output->add_slider_base();

		$this->slider_html = ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		$this->create_font_html();
		$this->create_script_html();
		$this->create_style_html();
		
		ob_start();
		$this->write_header_html();
		$head = ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		ob_start();
		$this->write_body_html();
		$body = ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		ob_start();
		$this->write_footer_html();
		$footer = ob_get_contents();
		ob_clean();
		ob_end_clean();
	
		$this->slider_html = $head."\n".
							 $this->slider_html."\n".
							 $this->export_scripts."\n".
							 $body."\n".
							 $footer;
								
		$this->replace_export_html_urls();
		$this->add_export_html_to_zip();
		$this->push_zip_to_client();
		$this->delete_export_zip();
		
		exit;
	}
	
	
	/**
	 * replace the URLs in the HTML to local URLs for exporting, this will also push the files into the zip file
	 **/
	public function replace_export_html_urls(){
		$added				= array();
		$replace			= array();
		$upload_dir			= $this->get_upload_path();
		$upload_dir_multi	= wp_upload_dir();
		$cont_url			= $this->get_val($upload_dir_multi, 'baseurl');
		$cont_url_no_www	= str_replace('www.', '', $cont_url);
		$upload_dir_multi	= $this->get_val($upload_dir_multi, 'basedir').'/';
		
		$search = array($cont_url, $cont_url_no_www, RS_PLUGIN_URL);
		if(defined('WHITEBOARD_PLUGIN_URL')){
			$search[] = WHITEBOARD_PLUGIN_URL;
		}
		$search	= apply_filters('revslider_html_export_replace_urls', $search);
		$replace = apply_filters('revslider_html_export_path_replace_urls', $replace);
		
		if(!empty($search)){
			foreach($search as $s){
				$s = $this->remove_http($s);
				
				preg_match_all("/(\"|')".str_replace('/', '\/', $s)."\S+(\"|')/", $this->slider_html, $_files);

				if(!empty($_files) && isset($_files[0]) && !empty($_files[0])){
					//go through all files, check for existance and add to the zip file
					foreach($_files[0] as $_file){
						$o		= $_file;
						$_file	= str_replace(array('"', "'", $s), '', $_file);
						
						//check if video or image
						$use_path		= $this->path_assets;
						$use_path_raw	= $this->path_assets_raw;
						
						preg_match('/.*?.(?:jpg|jpeg|gif|png|svg)/i', $_file, $match);
						preg_match('/.*?.(?:ogv|webm|mp4|mp3)/i', $_file, $match2);
						
						$f = false;
						if(!empty($match) && isset($match[0]) && !empty($match[0])){
							//image
							$use_path		= $this->path_assets;
							$use_path_raw	= $this->path_assets_raw;
							$f = true;
						}
						if(!empty($match2) && isset($match2[0]) && !empty($match2[0])){
							//video
							$use_path		= $this->path_assets_vid;
							$use_path_raw	= $this->path_assets_raw_vid;
							$f = true;
						}
						
						if($f == false){ 
							//no file, just a location. So change the location accordingly by removing base and add ../../revolution
							if(strpos($o, 'public/assets/js/') !== false){ //this will be the jsFileLocation script part
								$this->slider_html = str_replace($o, '"'.$this->path_js.'"', $this->slider_html);
							}
							continue; //no correct file, nothing to add
						}
						
						if(isset($added[$_file])) continue;
						
						$add	 = '';
						$__file	 = '';
						$repl_to = explode('/', $_file);
						$repl_to = end($repl_to);
						
						$remove	 = false;
						
						if(is_file($upload_dir.$_file)){
							$mf = str_replace('//', '/', $upload_dir.$_file);
							if(!$this->usepcl){
								$this->zip->addFile($mf, $use_path_raw.'/'.$repl_to);
							}else{
								$v_list = $this->pclzip->add($mf, PCLZIP_OPT_REMOVE_PATH, str_replace(basename($mf), '', $mf), PCLZIP_OPT_ADD_PATH, $use_path_raw.'/');
							}
							$remove = true;
						}elseif(is_file($upload_dir_multi.$_file)){
							$mf = str_replace('//', '/', $upload_dir_multi.$_file);
							if(!$this->usepcl){
								$this->zip->addFile($mf, $use_path_raw.'/'.$repl_to);
							}else{
								$v_list = $this->pclzip->add($mf, PCLZIP_OPT_REMOVE_PATH, str_replace(basename($mf), '', $mf), PCLZIP_OPT_ADD_PATH, $use_path_raw.'/');
							}
							$remove = true;
						}elseif(is_file(RS_PLUGIN_PATH.$_file)){
							$mf = str_replace('//', '/', RS_PLUGIN_PATH.$_file);
							
							//we need to be special with svg files
							$__file = basename($_file);
							
							//remove admin/assets/
							//$__file = str_replace('admin/assets/images/', '', $_file);
							
							
							if(!$this->usepcl){
								$this->zip->addFile($mf, $use_path_raw.'/'.$__file);
							}else{
								$v_list = $this->pclzip->add($mf, PCLZIP_OPT_REMOVE_PATH, str_replace(basename($mf), '', $mf), PCLZIP_OPT_ADD_PATH, $use_path_raw.'/');
							}
							$remove = true;
							$add = '/';
						}else{
							if(defined('WHITEBOARD_PLUGIN_PATH')){
								if(is_file(WHITEBOARD_PLUGIN_PATH.$_file)){
									$mf = str_replace('//', '/', WHITEBOARD_PLUGIN_PATH.$_file);
							
									//we need to be special with svg files
									$__file = basename($_file);
									
									if(!$this->usepcl){
										$this->zip->addFile($mf, $use_path_raw.'/'.$__file);
									}else{
										$v_list = $this->pclzip->add($mf, PCLZIP_OPT_REMOVE_PATH, str_replace(basename($mf), '', $mf), PCLZIP_OPT_ADD_PATH, $use_path_raw.'/');
									}
									$remove = true;
									$add = '/';
								}
							}
							if(!empty($replace)){
								foreach($replace as $_path){
									if(is_file($_path.$_file)){
										$mf = str_replace('//', '/', $_path.$_file);

										//we need to be special with svg files
										$__file = basename($_file);
										
										if(!$this->usepcl){
											$this->zip->addFile($mf, $use_path_raw.'/'.$__file);
										}else{
											$v_list = $this->pclzip->add($mf, PCLZIP_OPT_REMOVE_PATH, str_replace(basename($mf), '', $mf), PCLZIP_OPT_ADD_PATH, $use_path_raw.'/');
										}
										$remove = true;
										$add = '/';
									}
								}
							}
						}

						if($remove == true){
							$added[$_file] = true; //set as added
							//replace file with new path
							if($add !== '') $_file = $__file; //set the different path here
							$re = (strpos($o, "'") !== false) ? "'" : '"';
							$this->slider_html = str_replace($o, $re.$use_path.'/'.$repl_to.$re, $this->slider_html);
						}
					}
					
				}
			}
		}
		
		if($this->export_real){ //only include if real export
			//add common files to the zip
			if(!$this->usepcl){
				if(!file_exists(RS_PLUGIN_PATH.'public/assets/js/rs6.min.js')){
					$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/js/dev/rs6.main.js', 'js/rs6.main.js');
					$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/js/dev/rs6.actions.js', 'js/rs6.actions.js');
					$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/js/dev/rs6.carousel.js', 'js/rs6.carousel.js');
					$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/js/dev/rs6.layeranimation.js', 'js/rs6.layeranimation.js');
					$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/js/dev/rs6.navigation.js', 'js/rs6.navigation.js');
					$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/js/dev/rs6.panzoom.js', 'js/rs6.panzoom.js');
					$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/js/dev/rs6.parallax.js', 'js/rs6.parallax.js');
					$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/js/dev/rs6.slideanims.js', 'js/rs6.slideanims.js');
					//$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/js/libs/three.min.js', 'js/three.min.js');
					$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/js/dev/rs6.video.js', 'js/rs6.video.js');
				}else{
					$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/js/rs6.min.js', 'js/rs6.min.js');
				}
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/js/rbtools.min.js', 'js/rbtools.min.js');
				
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/css/rs6.css', 'css/rs6.css');
				
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css', 'fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css');
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/pe-icon-7-stroke/css/helper.css', 'fonts/pe-icon-7-stroke/css/helper.css');
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.eot', 'fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.eot');
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.svg', 'fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.svg');
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.ttf', 'fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.ttf');
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.woff', 'fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.woff');
				
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/font-awesome/css/font-awesome.css', 'fonts/font-awesome/css/font-awesome.css');
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/font-awesome/fonts/FontAwesome.otf', 'fonts/font-awesome/fonts/FontAwesome.otf');
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/font-awesome/fonts/fontawesome-webfont.eot', 'fonts/font-awesome/fonts/fontawesome-webfont.eot');
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/font-awesome/fonts/fontawesome-webfont.svg', 'fonts/font-awesome/fonts/fontawesome-webfont.svg');
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/font-awesome/fonts/fontawesome-webfont.ttf', 'fonts/font-awesome/fonts/fontawesome-webfont.ttf');
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/font-awesome/fonts/fontawesome-webfont.woff', 'fonts/font-awesome/fonts/fontawesome-webfont.woff');
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/font-awesome/fonts/fontawesome-webfont.woff2', 'fonts/font-awesome/fonts/fontawesome-webfont.woff2');
				
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/revicons/revicons.eot', 'fonts/revicons/revicons.eot');
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/revicons/revicons.svg', 'fonts/revicons/revicons.svg');
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/revicons/revicons.ttf', 'fonts/revicons/revicons.ttf');
				$this->zip->addFile(RS_PLUGIN_PATH.'/public/assets/fonts/revicons/revicons.woff', 'fonts/revicons/revicons.woff');
			}else{
				if(!file_exists(RS_PLUGIN_PATH.'public/assets/js/rs6.min.js')){
					$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/js/dev/rs6.main.js', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/js/', PCLZIP_OPT_ADD_PATH, 'js/');
					$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/js/dev/rs6.actions.js', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/js/', PCLZIP_OPT_ADD_PATH, 'js/');
					$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/js/dev/rs6.carousel.js', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/js/', PCLZIP_OPT_ADD_PATH, 'js/');
					$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/js/dev/rs6.layeranimation.js', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/js/', PCLZIP_OPT_ADD_PATH, 'js/');
					$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/js/dev/rs6.navigation.js', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/js/', PCLZIP_OPT_ADD_PATH, 'js/');
					$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/js/dev/rs6.panzoom.js', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/js/', PCLZIP_OPT_ADD_PATH, 'js/');
					$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/js/dev/rs6.parallax.js', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/js/', PCLZIP_OPT_ADD_PATH, 'js/');
					$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/js/dev/rs6.slideanims.js', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/js/', PCLZIP_OPT_ADD_PATH, 'js/');
					//$this->pclzip->add(RS_PLUGIN_PATH.'/public/assets/js/libs/three.min.js', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/js/', PCLZIP_OPT_ADD_PATH, 'js/');
					$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/js/dev/rs6.video.js', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/js/', PCLZIP_OPT_ADD_PATH, 'js/');
				}else{
					$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/js/rs6.min.js', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/js/', PCLZIP_OPT_ADD_PATH, 'js/');
				}
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/js/rbtools.min.js', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/js/', PCLZIP_OPT_ADD_PATH, 'js/');
				
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/css/rs6.css', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/css/', PCLZIP_OPT_ADD_PATH, 'css/');
				
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/pe-icon-7-stroke/css/helper.css', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.eot', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.svg', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.ttf', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.woff', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
				
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/font-awesome/css/font-awesome.css', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/font-awesome/fonts/FontAwesome.otf', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/font-awesome/fonts/fontawesome-webfont.eot', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/font-awesome/fonts/fontawesome-webfont.svg', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/font-awesome/fonts/fontawesome-webfont.ttf', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/font-awesome/fonts/fontawesome-webfont.woff', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
				
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/revicons/revicons.eot', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/revicons/revicons.svg', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/revicons/revicons.ttf', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
				$this->pclzip->add(RS_PLUGIN_PATH.'public/assets/fonts/revicons/revicons.woff', PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'public/assets/');
			}

			$this->slider_html = apply_filters('revslider_export_html_file_inclusion', $this->slider_html, $this);
			
			$notice_text = __('Using this data is only allowed with a valid licence of the jQuery Slider Revolution Plugin, which can be found at: https://www.themepunch.com/links/slider_revolution_jquery', 'revslider');
			
			if(!$this->usepcl){
				$this->zip->addFromString('NOTICE.txt', $notice_text); //add slider settings
			}else{
				$this->pclzip->add(array(array(PCLZIP_ATT_FILE_NAME => 'NOTICE.txt', PCLZIP_ATT_FILE_CONTENT => $notice_text)));
			}
			
		}
	}
	
	
	/**
	 * Add the export HTML file to the zip file
	 **/
	public function add_export_html_to_zip(){
		if(!$this->usepcl){
			$this->zip->addFromString('slider.html', $this->slider_html); //add slider settings
			$this->zip->close();
		}else{
			$this->pclzip->add(array(array(PCLZIP_ATT_FILE_NAME => 'slider.html', PCLZIP_ATT_FILE_CONTENT => $this->slider_html)));
		}
	}
	
	
	/**
	 * create the Font HTML needed for the HTML Export
	 * this will also remove the part out of the slider markup
	 **/
	public function create_font_html(){
		$fonts = '';
		while(strpos($this->slider_html, '<!-- FONT -->') !== false){
			$fonts		.= substr($this->slider_html, strpos($this->slider_html, '<!-- FONT -->'), strpos($this->slider_html, '<!-- /FONT -->') + 14 - strpos($this->slider_html, '<!-- FONT -->'))."\n";
			$starthtml	 = substr($this->slider_html, 0, strpos($this->slider_html, '<!-- FONT -->'));
			$endhtml	 = substr($this->slider_html, strpos($this->slider_html, '<!-- /FONT -->') + 14);
			
			$this->slider_html = $starthtml.$endhtml; //remove from html markup
		}
		$fonts = str_replace(array('<!-- FONT -->', '<!-- /FONT -->'), '', $fonts); //remove the tags
		$fonts = str_replace('/>','/>'."\n", $fonts);
		
		$this->export_font = $fonts;
	}
	
	
	/**
	 * create the Scripts HTML needed for the HTML Export
	 * this will also remove the part out of the slider markup
	 **/
	public function create_script_html(){
		$scripts = '';
		while(strpos($this->slider_html, '<!-- SCRIPT -->') !== false){
			$scripts	.= substr($this->slider_html, strpos($this->slider_html, '<!-- SCRIPT -->'), strpos($this->slider_html, '<!-- /SCRIPT -->') + 16 - strpos($this->slider_html, '<!-- SCRIPT -->'))."\n";;
			$starthtml	 = substr($this->slider_html, 0, strpos($this->slider_html, '<!-- SCRIPT -->'));
			$endhtml	 = substr($this->slider_html, strpos($this->slider_html, '<!-- /SCRIPT -->') + 16);
			
			$this->slider_html = $starthtml.$endhtml; //remove from html markup
		}
		
		$this->export_scripts = str_replace(array('<!-- SCRIPT -->', '<!-- /SCRIPT -->'), '', $scripts); //remove the tags
	}
	
	
	/**
	 * create the Styles HTML needed for the HTML Export
	 * this will also remove the part out of the slider markup
	 **/
	public function create_style_html(){
		$styles = '';
		while(strpos($this->slider_html, '<!-- STYLE -->') !== false){
			$styles		.= substr($this->slider_html, strpos($this->slider_html, '<!-- STYLE -->'), strpos($this->slider_html, '<!-- /STYLE -->') + 15 - strpos($this->slider_html, '<!-- STYLE -->'))."\n";
			$starthtml	 = substr($this->slider_html, 0, strpos($this->slider_html, '<!-- STYLE -->'));
			$endhtml	 = substr($this->slider_html, strpos($this->slider_html, '<!-- /STYLE -->') + 15);
			
			$this->slider_html = $starthtml.$endhtml; //remove from html markup
		}
		
		$this->export_styles = str_replace(array('<!-- STYLE -->', '<!-- /STYLE -->'), '', $styles); //remove the tags
	}
	
	
	/**
	 * create Header HTML for HTML export
	 **/
	public function write_header_html(){
		?><!DOCTYPE html>
		<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
		<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
		<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
		<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<title><?php echo $this->slider_title; ?> - Slider Revolution</title>
			<meta name="description" content="Slider Revolution Example" />
			<meta name="keywords" content="fullscreen image, grid layout, flexbox grid, transition" />
			<meta name="author" content="ThemePunch" />
			<meta name="viewport" content="width=device-width, initial-scale=1">

			<!-- LOAD JQUERY LIBRARY -->
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
			
			<!-- LOADING FONTS AND ICONS -->
			<?php echo $this->export_font; ?>
			
			<link rel="stylesheet" type="text/css" href="<?php echo $this->path_fonts; ?>pe-icon-7-stroke/css/pe-icon-7-stroke.css">
			<link rel="stylesheet" type="text/css" href="<?php echo $this->path_fonts; ?>font-awesome/css/font-awesome.css">
			
			<!-- REVOLUTION STYLE SHEETS -->
			<link rel="stylesheet" type="text/css" href="<?php echo $this->path_css; ?>rs6.css">
			<!-- REVOLUTION LAYERS STYLES -->
			<?php 
			if($this->export_real){ 
				echo $this->export_styles;
			
				$static_css = $this->get_static_css();
				
				if($static_css !== ''){
					$css = RevSliderGlobals::instance()->get('RevSliderCssParser');
					echo '<style>';
					echo $css->compress_css($static_css);
					echo '</style>'."\n";
				}
			}else{
				?>
				<link rel="stylesheet" type="text/css" href="<?php echo $this->path_css; ?>layers.css">
				
				<!-- REVOLUTION NAVIGATION STYLES -->
				<link rel="stylesheet" type="text/css" href="<?php echo $this->path_css; ?>navigation.css">
				
				<!-- FONT AND STYLE FOR BASIC DOCUMENTS, NO NEED FOR FURTHER USAGE IN YOUR PROJECTS-->
				<link href="http://fonts.googleapis.com/css?family=Roboto%3A700%2C300" rel="stylesheet" property="stylesheet" type="text/css" media="all" />
				<link rel="stylesheet" type="text/css" href="../../assets/css/noneed.css">
				<?php
			}
			?>
			<!-- REVOLUTION JS FILES -->
			<?php
			RevSliderFront::add_waiting_script();
			?>
			<script src="<?php echo $this->path_js; ?>rbtools.min.js"></script>
			<?php
			if(!file_exists(RS_PLUGIN_PATH.'public/assets/js/rs6.min.js')){
				?>
				<script src="<?php echo $this->path_js; ?>rs6.main.js"></script>
				<script src="<?php echo $this->path_js; ?>rs6.actions.js"></script>
				<script src="<?php echo $this->path_js; ?>rs6.carousel.js"></script>
				<script src="<?php echo $this->path_js; ?>rs6.layeranimation.js"></script>
				<script src="<?php echo $this->path_js; ?>rs6.navigation.js"></script>
				<script src="<?php echo $this->path_js; ?>rs6.panzoom.js"></script>
				<script src="<?php echo $this->path_js; ?>rs6.parallax.js"></script>
				<script src="<?php echo $this->path_js; ?>rs6.slideanims.js"></script>
				<!--script src="<?php echo $this->path_js; ?>three.min.js"></script-->
				<script src="<?php echo $this->path_js; ?>rs6.video.js"></script>
				<?php
			}else{
				?>
				<script src="<?php echo $this->path_js; ?>rs6.min.js"></script>
				<?php
			}
			?>
			
			<?php echo RevSliderFront::js_set_start_size(); ?>

			<?php do_action('revslider_export_html_write_header', $this); ?>

		</head>
		
		<body>
		<?php
	}
	
	
	/**
	 * create Body HTML for HTML export
	 **/
	public function write_body_html(){
		if(!$this->export_real){ ?>
			<!-- HEADER -->
			<article class="content">
				<!-- Add your site or application content here -->
				<section class="header">
					<span class="logo" style="float:left"></span>
					<a class="button" style="float:right" target="_blank" rel="noopener" href="https://www.themepunch.com/revsliderjquery-doc/slider-revolution-jquery-5-x-documentation/"><i class="pe-7s-help2"></i>Online Documentation</a>
					<div class="clearfix"></div>
				</section>
			</article>
			
			<?php
			if($this->layouttype != 'fullscreen'){
			?>
			<article class="small-history"> 
				<h2 class="textaligncenter" style="margin-bottom:25px;">Your Slider Revolution jQuery Plugin</h2>
				<p>Slider Revolution is an innovative, responsive Slider Plugin that displays your content the beautiful way. Whether it's a <strong>Slider, Carousel, Hero Scene</strong> or even a whole <strong>Front Page</strong>.<br>The <a href="https://www.themepunch.com/links/slider_revolution_jquery_visual_editor" target="_blank" rel="noopener">visual drag &amp; drop editor</a> will help you to create your Sliders and tell your own stories in no time!</p>
			</article>
			<?php
			}
			?>
			<!-- SLIDER EXAMPLE -->
			<section class="example">
				<article class="content">
				<?php
		}
			
		if(!$this->export_real){ ?>
				</article>
			</section>
			<div class="bottom-history-wrap" style="margin-top:150px">
			<?php		
			if($this->layouttype == 'fullscreen'){
			?>
			<article class="small-history bottom-history" style="background:#f5f7f9;"> 
				<h2 class="textaligncenter" style="margin-bottom:25px;">Your Slider Revolution jQuery Plugin</h2>
				<p>Slider Revolution is an innovative, responsive Slider Plugin that displays your content the beautiful way. Whether it's a <strong>Slider, Carousel, Hero Scene</strong> or even a whole <strong>Front Page</strong>.<br>The <a href="https://www.themepunch.com/links/slider_revolution_jquery_visual_editor" target="_blank" rel="noopener">visual drag &amp; drop editor</a> will help you to create your Sliders and tell your own stories in no time!</p>
			</article>
				<?php
			}
			?>
			
			<article class="small-history bottom-history">
				<i class="fa-icon-question tp-headicon"></i>
				<h2 class="textaligncenter" style="margin-bottom:25px;">Find the Documentation ?</h2>
				<p>We would always recommend to use our<a target="_blank" rel="noopener" href="https://www.themepunch.com/revsliderjquery-doc/slider-revolution-jquery-5-x-documentation/"> online documentation</a> however you can find also our embeded local documentation zipped in the Documentation folder. Online Documentation and FAQ Page is regulary updated. You will find More examples, Visit us also at <a href="http://themepunch.com">http://themepunch.com</a> ! </p>
				<div class="tp-smallinfo">Learn how to build your Slider!</div>
			</article>

			<article class="small-history bottom-history" style="background:#f5f7f9;">
				<i class="fa-icon-arrows tp-headicon"></i>
				<h2 class="textaligncenter" style="margin-bottom:25px;">Navigation Examples !</h2>
				<p>You find many Examples for All Skins and Positions of Navigation examples in the <a target="_blank" rel="noopener" href="file:../Navigation">examples/Navigation folder</a>. Based on these prepared examples you can build your own navigation skins. Feel free to copy and paste the markups after your requests in your own documents.</p>
				<div class="tp-smallinfo">Customize the interaction with your visitor!</div>
			</article>

			<article class="small-history bottom-history">
				<i class="fa-icon-cog tp-headicon"></i>
				<h2 class="textaligncenter" style="margin-bottom:25px;">Layer and Slide Transitions</h2>
				<p>We prepared a small List of Transition and a light weight Markup Builder in the <a target="_blank" rel="noopener" href="file:../Transitions"> examples/Transitions folder</a>. This will help you to get an overview how the Slider and Layer Transitions works. Copy the Markups of the generated Slide and Layer Animation Examples and paste it into your own Documents.</p>
				<div class="tp-smallinfo">Eye Catching Effects!</div>

			</article>
		</div>
		<div class="clearfix"></div>
			<?php
		}
	}
	
	
	/**
	 * create Footer HTML for HTML export
	 **/
	public function write_footer_html(){
		global $rs_css_collection;
		if(!empty($rs_css_collection)){
			$custom_css = implode("\n".RS_T2, $rs_css_collection);
			$css = RevSliderGlobals::instance()->get('RevSliderCssParser');
			echo '<style>';
			echo $css->compress_css($custom_css);
			echo '</style>'."\n";
		}

		do_action('revslider_export_html_write_footer', $this);
		?>
		</body>
		<?php
		if(!$this->export_real){
			?>
			<footer>
				<div class="footer_inner">
					<div class="footerwidget">
						<h3>Slider Revolution</h3>
						<a href="https://revolution.themepunch.com/jquery/#features" target="_self">Features</a>
						<a href="https://revolution.themepunch.com/examples-jquery/" target="_self">Usage Examples</a>
						<a href="https://www.themepunch.com/revsliderjquery-doc/slider-revolution-jquery-5-x-documentation/" target="_blank" rel="noopener">Online Documentation</a>
					</div>
					<div class="footerwidget">
						<h3>Resources</h3>
						<a href="https://www.themepunch.com/support-center/" target="_blank" rel="noopener">FAQ Database</a>
						<a href="https://themepunch.com" target="_blank" rel="noopener">ThemePunch.com</a>
						<a href="https://themepunch.us9.list-manage.com/subscribe?u=a5738148e5ec630766e28de16&amp;id=3e718acc63" target="_blank" rel="noopener">Newsletter</a>
						<a href="https://www.themepunch.com/products/" target="_blank" rel="noopener">Plugins</a>
						<a href="https://www.themepunch.com/products/" target="_blank" rel="noopener">Themes</a>
					</div>
					<div class="footerwidget">
						<h3>More Versions</h3>
						<a href="https://revolution.themepunch.com" target="_blank" rel="noopener">WordPress</a>
						<a href="https://www.themepunch.com/links/slider_revolution_prestashop" target="_blank" rel="noopener">Prestashop</a>
						<a href="https://www.themepunch.com/links/slider_revolution_magento" target="_blank" rel="noopener">Magento</a>
						<a href="https://www.themepunch.com/links/slider_revolution_opencart" target="_blank" rel="noopener">OpenCart</a>
					</div>
					<div class="footerwidget social">
						<h3>Follow Us</h3>
						<ul>
							<li><a href="https://www.facebook.com/wordpress.slider.revolution" target="_blank" rel="noopener" class="so_facebook" data-rel="tooltip" data-animation="false" data-placement="bottom" data-original-title="Facebook"><i class="s_icon fa-icon-facebook "></i></a>
							</li>
							<li><a href="https://twitter.com/revslider" target="_blank" rel="noopener" class="so_twitter" data-rel="tooltip" data-animation="false" data-placement="bottom" data-original-title="Twitter"><i class="s_icon fa-icon-twitter"></i></a>
							</li>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
			</footer>
			<script src="../../assets/warning.js"></script>
			<?php
		}
		?>
		</html>
		<?php
	}
}