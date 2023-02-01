<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();
 
global $revslider_rev_start_size_loaded;

$revslider_rev_start_size_loaded = false;

class RevSliderFront extends RevSliderFunctions {

	const TABLE_SLIDER			 = 'revslider_sliders';
	const TABLE_SLIDES			 = 'revslider_slides';
	const TABLE_STATIC_SLIDES	 = 'revslider_static_slides';
	const TABLE_CSS				 = 'revslider_css';
	const TABLE_LAYER_ANIMATIONS = 'revslider_layer_animations';
	const TABLE_NAVIGATIONS		 = 'revslider_navigations';
	const TABLE_SETTINGS		 = 'revslider_settings'; //existed prior 5.0 and still needed for updating from 4.x to any version after 5.x
	const CURRENT_TABLE_VERSION	 = '1.0.12';

	const YOUTUBE_ARGUMENTS		 = 'hd=1&amp;wmode=opaque&amp;showinfo=0&amp;rel=0';
	const VIMEO_ARGUMENTS		 = 'title=0&amp;byline=0&amp;portrait=0&amp;api=1';

	public function __construct(){		
		add_action('wp_enqueue_scripts', array('RevSliderFront', 'add_actions'));
		add_filter('wp_img_tag_add_loading_attr', array('RevSliderFront', 'check_lazy_loading'), 99, 3);
	}
	
	
	/**
	 * START: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/
	 
	/**
	 * old version of add_admin_bar();
	 **/
	public static function putAdminBarMenus(){
		return RevSliderFront::add_admin_bar();
	}
	
	/**
	 * END: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/
	 
	/**
	 * Add all actions that the frontend needs here
	 **/
	public static function add_actions(){
		global $revslider_is_preview_mode;

		$func	 = RevSliderGlobals::instance()->get('RevSliderFunctions');
		$rs_ver	 = apply_filters('revslider_remove_version', RS_REVISION);
		$global	 = $func->get_global_settings();
		$inc_global = $func->_truefalse($func->get_val($global, 'allinclude', true));
		
		$inc_footer = $func->_truefalse($func->get_val($global, array('script', 'footer'), true));
		$waitfor = array('jquery');
		$widget	 = is_active_widget(false, false, 'rev-slider-widget', true);
		
		$load = false;
		$load = apply_filters('revslider_include_libraries', $load);
		$load = ($revslider_is_preview_mode === true) ? true : $load;
		$load = ($inc_global === true) ? true : $load;
		$load = (self::has_shortcode('rev_slider') === true) ? true : $load;
		$load = ($widget !== false) ? true : $load;
		
		if($inc_global === false){
			$output = new RevSliderOutput();
			$output->set_add_to($func->get_val($global, 'includeids', ''));
			$add_to = $output->check_add_to(true);
			$load	= ($add_to === true) ? true : $load;
		}

		if($load === false) return false;
		
		wp_enqueue_script(array('jquery'));
		
		/**
		 * dequeue tp-tools to make sure that always the latest is loaded
		 **/
		global $wp_scripts;
		if(version_compare($func->get_val($wp_scripts, array('registered', 'tp-tools', 'ver'), '1.0'), RS_TP_TOOLS, '<')){
			wp_deregister_script('tp-tools');
			wp_dequeue_script('tp-tools');
		}
		
		wp_enqueue_script('tp-tools', RS_PLUGIN_URL . 'public/assets/js/rbtools.min.js', $waitfor, RS_TP_TOOLS, $inc_footer);
		
		if(!file_exists(RS_PLUGIN_PATH.'public/assets/js/rs6.min.js')){
			wp_enqueue_script('revmin', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.main.js', $waitfor, $rs_ver, $inc_footer);
			//if on, load all libraries instead of dynamically loading them
			wp_enqueue_script('revmin-actions', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.actions.js', $waitfor, $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-carousel', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.carousel.js', $waitfor, $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-layeranimation', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.layeranimation.js', $waitfor, $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-navigation', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.navigation.js', $waitfor, $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-panzoom', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.panzoom.js', $waitfor, $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-parallax', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.parallax.js', $waitfor, $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-slideanims', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.slideanims.js', $waitfor, $rs_ver, $inc_footer);
		//	wp_enqueue_script('revmin-threejs', RS_PLUGIN_URL . 'public/assets/js/libs/three.min.js', $waitfor, $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-video', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.video.js', $waitfor, $rs_ver, $inc_footer);
		}else{
			wp_enqueue_script('revmin', RS_PLUGIN_URL . 'public/assets/js/rs6.min.js', 'tp-tools', $rs_ver, $inc_footer);
		}
		
		add_action('wp_head', array('RevSliderFront', 'add_meta_generator'));
		add_action('wp_head', array('RevSliderFront', 'js_set_start_size'), 99);
		add_action('admin_head', array('RevSliderFront', 'js_set_start_size'), 99);
		add_action('wp_footer', array('RevSliderFront', 'add_inline_css'), 10);
		add_action('wp_footer', array('RevSliderFront', 'load_icon_fonts'), 11);
		add_action('wp_footer', array('RevSliderFront', 'load_google_fonts'));
		add_action('wp_footer', array('RevSliderFront', 'add_waiting_script'), 1);
		add_action('wp_print_footer_scripts', array('RevSliderFront', 'add_inline_js'), 100);

		//defer JS Loading
		if($func->_truefalse($func->get_val($global, array('script', 'defer'), true)) === true){
			add_filter('script_loader_tag', array('RevSliderFront', 'add_defer_forscript'), 11, 2);
		}

		//Async JS Loading
		if($func->_truefalse($func->get_val($global, array('script', 'async'), true)) === true){
			add_filter('script_loader_tag', array('RevSliderFront', 'add_async_forscript'), 11, 2);
		}

		add_action('wp_before_admin_bar_render', array('RevSliderFront', 'add_admin_menu_nodes'));
		add_action('wp_footer', array('RevSliderFront', 'add_admin_bar'), 99);
	}
	
	/**
	 * add css to the footer
	 **/
	public static function add_inline_css(){
		global $wp_version, $rs_css_collection, $rs_revicons;
		$css	 = RevSliderGlobals::instance()->get('RevSliderCssParser');
		$rs_ver	 = apply_filters('revslider_remove_version', RS_REVISION);
		/**
		 * Fix for WordPress versions below 3.7
		 **/
		$style_pre = ($wp_version < 3.7) ? '<style id="rs-plugin-settings-inline-css">' : '';
		$style_post = ($wp_version < 3.7) ? '</style>' : '';
		$custom_css = $css->get_static_css();
		$custom_css = $css->compress_css($custom_css);
		
		if(!empty($rs_css_collection)){
			$custom_css .= RS_T2;
			$custom_css .= implode("\n".RS_T2, $rs_css_collection);
		}
		
		$custom_css = (trim($custom_css) == '') ? '#rs-demo-id {}' : $custom_css;

		if(strpos($custom_css, 'revicon') !== false) $rs_revicons = true;
		
		wp_enqueue_style('rs-plugin-settings', RS_PLUGIN_URL . 'public/assets/css/rs6.css', array(), $rs_ver);
		wp_add_inline_style('rs-plugin-settings', $style_pre . $custom_css . $style_post);
	}
	
	/**
	 * add all the JavaScript from the Sliders to the footer
	 **/
	public static function add_inline_js(){
		global $rs_js_collection;
		
		if(empty($rs_js_collection)) return true;
		if(empty($rs_js_collection['revapi'])) return true;

		echo '<script id="rs-initialisation-scripts">'."\n";
		echo RS_T2.'var	tpj = jQuery;'."\n\n";
		echo RS_T2.'var	'.implode(',', $rs_js_collection['revapi']) . ';'."\n";
		if(!empty($rs_js_collection['js'])){
			echo "\n" . implode("\n", $rs_js_collection['js']);
		}
		if(!empty($rs_js_collection['minimal'])){
			echo "\n" . $rs_js_collection['minimal'];
		}
		
		echo RS_T.'</script>'."\n";
		
	}
	
	public static function welcome_screen_activate(){
		set_transient('_revslider_welcome_screen_activation_redirect', true, 60);
	}

	/**
	 * Add Meta Generator Tag in FrontEnd
	 * @since: 5.0
	 */
	public static function add_meta_generator(){
		echo apply_filters('revslider_meta_generator', '<meta name="generator" content="Powered by Slider Revolution ' . RS_REVISION . ' - responsive, Mobile-Friendly Slider Plugin for WordPress with comfortable drag and drop interface." />' . "\n");
	}

	/**
	 * Load Used Icon Fonts
	 * @since: 5.0
	 */
	public static function load_icon_fonts(){
		global $fa_var, $fa_icon_var, $pe_7s_var, $rs_revicons;
		$func	= RevSliderGlobals::instance()->get('RevSliderFunctions');
		$global	= $func->get_global_settings();
		$ignore_fa = $func->_truefalse($func->get_val($global, 'fontawesomedisable', false));
		
		echo ($rs_revicons) ? RS_T3.'<link rel="preload" as="font" id="rs-icon-set-revicon-woff" href="' . RS_PLUGIN_URL . 'public/assets/fonts/revicons/revicons.woff?5510888" type="font/woff" crossorigin="anonymous" media="all" />'."\n" : '';
		echo ($ignore_fa === false && ($fa_icon_var == true || $fa_var == true)) ? RS_T3.'<link rel="preload" as="font" id="rs-icon-set-fa-icon-woff" type="font/woff2" crossorigin="anonymous" href="' . RS_PLUGIN_URL . 'public/assets/fonts/font-awesome/fonts/fontawesome-webfont.woff2?v=4.7.0" media="all" />'."\n" : '';
		echo ($ignore_fa === false && ($fa_icon_var == true || $fa_var == true)) ? RS_T3.'<link rel="stylesheet" property="stylesheet" id="rs-icon-set-fa-icon-css" href="' . RS_PLUGIN_URL . 'public/assets/fonts/font-awesome/css/font-awesome.css" type="text/css" media="all" />'."\n" : '';
		
		echo ($pe_7s_var) ? RS_T3.'<link rel="stylesheet" property="stylesheet" id="rs-icon-set-pe-7s-css" href="' . RS_PLUGIN_URL . 'public/assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" type="text/css" media="all" />'."\n" : '';
	}
	
	
	/**
	 * Load Used Google Fonts
	 * add google fonts of all sliders found on the page
	 * @since: 6.0
	 */
	public static function load_google_fonts(){ 
		$func	= RevSliderGlobals::instance()->get('RevSliderFunctions');
		$fonts	= $func->print_clean_font_import();
		if(!empty($fonts)){
			echo $fonts."\n";
		}
	}
	
	/**
	 * add the scripts that needs to be waited on
	 * @since: 6.4.12
	 **/
	public static function add_waiting_script(){
		$func	= RevSliderGlobals::instance()->get('RevSliderFunctions');
		$dev	= (!file_exists(RS_PLUGIN_PATH.'public/assets/js/rs6.min.js')) ? true : false;
		$global	= $func->get_global_settings();
		$wait	= array();
		$wait	= apply_filters('revslider_modify_waiting_scripts', $wait);
		?>

		<script>
			window.RS_MODULES = window.RS_MODULES || {};
			window.RS_MODULES.modules = window.RS_MODULES.modules || {};
			window.RS_MODULES.waiting = window.RS_MODULES.waiting || [];
			window.RS_MODULES.defered = <?php echo ($func->_truefalse($func->get_val($global, array('script', 'defer'), true)) === true) ? 'true' : 'false'; ?>;
			<?php if (!empty($wait)) {?> 			
			window.RS_MODULES.waiting = window.RS_MODULES.waiting.concat([ <?php echo '"'. implode('","', $wait) . '"'; ?>]);
			<?php }; ?>window.RS_MODULES.moduleWaiting = window.RS_MODULES.moduleWaiting || {};
			window.RS_MODULES.type = '<?php echo ($dev) ? "developer" : "compiled"; ?>';
		</script>
		<?php
	}

	/**
	 * add admin menu points in ToolBar Top
	 * @since: 5.0.5
	 * @before: putAdminBarMenus()
	 */
	public static function add_admin_bar(){
		if(!is_super_admin() || !is_admin_bar_showing()){
			return;
		}

		?>
		<script>
			function rs_adminBarToolBarTopFunction() {
				if(jQuery('#wp-admin-bar-revslider-default').length > 0 && jQuery('rs-module-wrap').length > 0){
					var aliases = new Array();
					jQuery('rs-module-wrap').each(function(){
						aliases.push(jQuery(this).data('alias'));
					});
					
					if(aliases.length > 0){
						jQuery('#wp-admin-bar-revslider-default li').each(function(){
							var li = jQuery(this),
								t = li.find('.ab-item .rs-label').data('alias'); //text()
							t = t!==undefined && t!==null ? t.trim() : t;
							if(jQuery.inArray(t,aliases)!=-1){
							}else{
								li.remove();
							}
						});
					}
				}else{
					jQuery('#wp-admin-bar-revslider').remove();
				}
			}
			var adminBarLoaded_once = false
			if (document.readyState === "loading") 
				document.addEventListener('readystatechange',function(){
					if ((document.readyState === "interactive" || document.readyState === "complete") && !adminBarLoaded_once) {
						adminBarLoaded_once = true;
						rs_adminBarToolBarTopFunction()
					}
				});
			else {
				adminBarLoaded_once = true;
				rs_adminBarToolBarTopFunction();
			}
		</script>
		<?php
	}
	
	/**
	 * check that loading="lazy" is not written in slider HTML
	 **/
	public static function check_lazy_loading($value, $image, $context){
		return (strpos($image, 'tp-rs-img') !== false) ? false : $value;
	}

	/**
	 * add admin nodes
	 * @since: 5.0.5
	 */
	public static function add_admin_menu_nodes(){
		if(!is_super_admin() || !is_admin_bar_showing()){
			return;
		}

		self::_add_node('<span class="rs-label">Slider Revolution</span>', false, admin_url('admin.php?page=revslider'), array('class' => 'revslider-menu'), 'revslider'); //<span class="wp-menu-image dashicons-before dashicons-update"></span>

		//add all nodes of all Slider
		$sl = new RevSliderSlider();
		$sliders = $sl->get_slider_for_admin_menu();

		if(!empty($sliders)){
			foreach ($sliders as $id => $slider){
				self::_add_node('<span class="rs-label" data-alias="' . esc_attr($slider['alias']) . '">' . esc_html($slider['title']) . '</span>', 'revslider', admin_url('admin.php?page=revslider&view=slide&id=slider-'.$id), array('class' => 'revslider-sub-menu'), esc_attr($slider['alias'])); //<span class="wp-menu-image dashicons-before dashicons-update"></span>
			}
		}
	}

	/**
	 * add admin node
	 * @since: 5.0.5
	 */
	public static function _add_node($title, $parent = false, $href = '', $custom_meta = array(), $id = ''){
		if(!is_super_admin() || !is_admin_bar_showing()){
			return;
		}

		$id = ($id == '') ? strtolower(str_replace(' ', '-', $title)) : $id;
		
		//links from the current host will open in the current window
		$meta = (strpos($href, site_url()) !== false) ? array() : array('target' => '_blank'); //external links open in new tab/window
		$meta = array_merge($meta, $custom_meta);
		
		global $wp_admin_bar;
		$wp_admin_bar->add_node(array('parent'=> $parent, 'id' => $id, 'title' => $title, 'href' => $href, 'meta' => $meta));
	}

	/**
	 * adds async loading
	 * @since: 5.0
	 * @updated: 6.4.12
	 */
	public static function add_defer_forscript($tag, $handle){
		if(strpos($tag, 'rs6') === false && strpos($tag, 'rbtools.min.js') === false && strpos($tag, 'revolution.addon.') === false && strpos($tag, 'public/assets/js/libs/') === false && (strpos($tag, 'liquideffect') === false && strpos($tag, 'pixi.min.js') === false) && strpos($tag, 'rslottie-js') === false){
			return $tag;
		}elseif(is_admin()){
			return $tag;
		}else{
			return str_replace(' id=', ' defer id=', $tag);
		}
	}

	/**
	 * adds async loading
	 * @since: 5.0
	 * @updated: 6.4.12
	 */
	public static function add_async_forscript($tag, $handle){
		if(strpos($tag, 'rs6') === false && strpos($tag, 'rbtools.min.js') === false && strpos($tag, 'revolution.addon.') === false && strpos($tag, 'public/assets/js/libs/') === false && (strpos($tag, 'liquideffect') === false && strpos($tag, 'pixi.min.js') === false) && strpos($tag, 'rslottie-js') === false){
			return $tag;
		}elseif(is_admin()){
			return $tag;
		}else{
			return str_replace(' id=', ' async id=', $tag);
		}
	}
	
	/**
	 * Add functionality to gutenberg, elementor, visual composer and so on
	 **/
	public static function add_post_editor(){
		/**
		 * Page Editor Extensions
		 **/
		if(function_exists('is_user_logged_in') && is_user_logged_in()){
			//only include gutenberg for production
			if(is_admin() && defined('ABSPATH')){
				include_once(ABSPATH . 'wp-admin/includes/plugin.php');
				if(function_exists('is_plugin_active') && !is_plugin_active('revslider-gutenberg/plugin.php')){
					require_once(RS_PLUGIN_PATH . 'admin/includes/shortcode_generator/gutenberg/gutenberg-block.php');
					new RevSliderGutenberg('gutenberg/');
				}
			}
			
			require_once(RS_PLUGIN_PATH . 'admin/includes/shortcode_generator/shortcode_generator.class.php');
			
			//Shortcode Wizard Includes
			//WPB Functionality
			require_once(RS_PLUGIN_PATH . 'admin/includes/shortcode_generator/wpbakery/wpbakery.class.php');
			add_action('vc_before_init', array('RevSliderWpbakeryShortcode', 'visual_composer_include')); //VC functionality
			add_action('admin_enqueue_scripts', array('RevSliderShortcodeWizard', 'enqueue_scripts'));
			add_action('admin_footer', array('RevSliderShortcodeWizard', 'enqueue_files'));
			//add_action('wp_footer', array('RevSliderShortcodeWizard', 'enqueue_files'));
			add_action('vc_before_init', array('RevSliderShortcodeWizard', 'add_styles')); //VC functionality
		}
		
		

		//Elementor Functionality
		require_once(RS_PLUGIN_PATH . 'admin/includes/shortcode_generator/elementor/elementor.class.php');
		add_action('init', array('RevSliderElementor', 'init'));
		add_action('elementor/editor/before_enqueue_scripts', array('RevSliderShortcodeWizard', 'enqueue_files'));
	}

	/**
	 * Add Meta Generator Tag in FrontEnd
	 * @since: 5.4.3
	 * @before: add_setREVStartSize()
		//NOT COMPRESSED VERSION
		function setREVStartSize(e){	
			//window.requestAnimationFrame(function() {	
				window.RSIW = window.RSIW===undefined ? window.innerWidth : window.RSIW;	
				window.RSIH = window.RSIH===undefined ? window.innerHeight : window.RSIH;	
				try {								
					var pw = document.getElementById(e.c).parentNode.offsetWidth,
						newh;
					pw = pw===0 || isNaN(pw) || (e.l=="fullwidth" || e.layout=="fullwidth") ? window.RSIW : pw;
					e.tabw = e.tabw===undefined ? 0 : parseInt(e.tabw);
					e.thumbw = e.thumbw===undefined ? 0 : parseInt(e.thumbw);
					e.tabh = e.tabh===undefined ? 0 : parseInt(e.tabh);
					e.thumbh = e.thumbh===undefined ? 0 : parseInt(e.thumbh);
					e.tabhide = e.tabhide===undefined ? 0 : parseInt(e.tabhide);
					e.thumbhide = e.thumbhide===undefined ? 0 : parseInt(e.thumbhide);
					e.mh = e.mh===undefined || e.mh=="" || e.mh==="auto" ? 0 : parseInt(e.mh,0);
					if(e.layout==="fullscreen" || e.l==="fullscreen")
						newh = Math.max(e.mh,window.RSIH);
					else{					
						e.gw = Array.isArray(e.gw) ? e.gw : [e.gw];
						for (var i in e.rl) if (e.gw[i]===undefined || e.gw[i]===0) e.gw[i] = e.gw[i-1];
						e.gh = e.el===undefined || e.el==="" || (Array.isArray(e.el) && e.el.length==0)? e.gh : e.el;
						e.gh = Array.isArray(e.gh) ? e.gh : [e.gh];
						for (var i in e.rl) if (e.gh[i]===undefined || e.gh[i]===0) e.gh[i] = e.gh[i-1];
											
						var nl = new Array(e.rl.length),
							ix = 0,
							sl;
						e.tabw = e.tabhide>=pw ? 0 : e.tabw;
						e.thumbw = e.thumbhide>=pw ? 0 : e.thumbw;
						e.tabh = e.tabhide>=pw ? 0 : e.tabh;
						e.thumbh = e.thumbhide>=pw ? 0 : e.thumbh;
						for (var i in e.rl) nl[i] = e.rl[i]<window.RSIW ? 0 : e.rl[i];
						sl = nl[0];									
						for (var i in nl) if (sl>nl[i] && nl[i]>0) { sl = nl[i]; ix=i;}
						var m = pw>(e.gw[ix]+e.tabw+e.thumbw) ? 1 : (pw-(e.tabw+e.thumbw)) / (e.gw[ix]);
						newh =  (e.gh[ix] * m) + (e.tabh + e.thumbh);
					}				
					var el = document.getElementById(e.c);
					if (el!==null && el) el.style.height = newh+"px";
					el = document.getElementById(e.c+"_wrapper");
					if (el!==null && el) el.style.height = newh+"px";
				} catch(e){
					console.log("Failure at Presize of Slider:" + e)
				}
			//}
		  };
	 */
	public static function js_set_start_size(){
		global $revslider_rev_start_size_loaded;
		if($revslider_rev_start_size_loaded === true) return false;
		
		$script = '<script>';
		$script .= 'function setREVStartSize(e){
			//window.requestAnimationFrame(function() {
				window.RSIW = window.RSIW===undefined ? window.innerWidth : window.RSIW;
				window.RSIH = window.RSIH===undefined ? window.innerHeight : window.RSIH;
				try {
					var pw = document.getElementById(e.c).parentNode.offsetWidth,
						newh;
					pw = pw===0 || isNaN(pw) || (e.l=="fullwidth" || e.layout=="fullwidth") ? window.RSIW : pw;
					e.tabw = e.tabw===undefined ? 0 : parseInt(e.tabw);
					e.thumbw = e.thumbw===undefined ? 0 : parseInt(e.thumbw);
					e.tabh = e.tabh===undefined ? 0 : parseInt(e.tabh);
					e.thumbh = e.thumbh===undefined ? 0 : parseInt(e.thumbh);
					e.tabhide = e.tabhide===undefined ? 0 : parseInt(e.tabhide);
					e.thumbhide = e.thumbhide===undefined ? 0 : parseInt(e.thumbhide);
					e.mh = e.mh===undefined || e.mh=="" || e.mh==="auto" ? 0 : parseInt(e.mh,0);
					if(e.layout==="fullscreen" || e.l==="fullscreen")
						newh = Math.max(e.mh,window.RSIH);
					else{
						e.gw = Array.isArray(e.gw) ? e.gw : [e.gw];
						for (var i in e.rl) if (e.gw[i]===undefined || e.gw[i]===0) e.gw[i] = e.gw[i-1];
						e.gh = e.el===undefined || e.el==="" || (Array.isArray(e.el) && e.el.length==0)? e.gh : e.el;
						e.gh = Array.isArray(e.gh) ? e.gh : [e.gh];
						for (var i in e.rl) if (e.gh[i]===undefined || e.gh[i]===0) e.gh[i] = e.gh[i-1];
											
						var nl = new Array(e.rl.length),
							ix = 0,
							sl;
						e.tabw = e.tabhide>=pw ? 0 : e.tabw;
						e.thumbw = e.thumbhide>=pw ? 0 : e.thumbw;
						e.tabh = e.tabhide>=pw ? 0 : e.tabh;
						e.thumbh = e.thumbhide>=pw ? 0 : e.thumbh;
						for (var i in e.rl) nl[i] = e.rl[i]<window.RSIW ? 0 : e.rl[i];
						sl = nl[0];
						for (var i in nl) if (sl>nl[i] && nl[i]>0) { sl = nl[i]; ix=i;}
						var m = pw>(e.gw[ix]+e.tabw+e.thumbw) ? 1 : (pw-(e.tabw+e.thumbw)) / (e.gw[ix]);
						newh =  (e.gh[ix] * m) + (e.tabh + e.thumbh);
					}
					var el = document.getElementById(e.c);
					if (el!==null && el) el.style.height = newh+"px";
					el = document.getElementById(e.c+"_wrapper");
					if (el!==null && el) {
						el.style.height = newh+"px";
						el.style.display = "block";
					}
				} catch(e){
					console.log("Failure at Presize of Slider:" + e)
				}
			//});
		  };';
		$script .= '</script>' . "\n";
		echo apply_filters('revslider_add_setREVStartSize', $script);
		
		$revslider_rev_start_size_loaded = true;
	}
	
	/**
	 * sets the post saving value to true, so that the output echo will not be done
	 **/
	public static function set_post_saving(){
		global $revslider_save_post;
		$revslider_save_post = true;
	}
	
	/**
	 * check the current post for the existence of a short code
	 * @before: hasShortcode()
	 */  
	public static function has_shortcode($shortcode = ''){  
		$found = false; 
		
		if(empty($shortcode)) return false;
		if(!is_singular()) return false;
		
		$post = get_post(get_the_ID());  
		if(stripos($post->post_content, '[' . $shortcode) !== false) $found = true;  
		
		return $found;  
	}

	/**
	 * Create Tables
	 * @only_base needs to be false
	 *  it can only be true by fixing database issues
	 *  this protects that the _bkp tables are not filled after 
	 *  we are already on version 6.0
	 **/
	public static function create_tables($only_base = false){
		$table_version = get_option('revslider_table_version', '1.0.0');
		
		if(version_compare($table_version, self::CURRENT_TABLE_VERSION, '<')){
			global $wpdb;

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			$sql = "CREATE TABLE " . $wpdb->prefix . self::TABLE_SLIDER . " (
			  id int(9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			  title tinytext NOT NULL,
			  alias tinytext,
			  params LONGTEXT NOT NULL,
			  settings text NULL,
			  type VARCHAR(191) NOT NULL DEFAULT '',
			  INDEX `type_index` (`type`(8))
			);";
			dbDelta($sql);

			$sql = "CREATE TABLE " . $wpdb->prefix . self::TABLE_SLIDES . " (
			  id int(9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			  slider_id int(9) NOT NULL,
			  slide_order int not NULL,
			  params LONGTEXT NOT NULL,
			  layers LONGTEXT NOT NULL,
			  settings text NOT NULL DEFAULT '',
			  INDEX `slider_id_index` (`slider_id`)
			);";
			dbDelta($sql);

			$sql = "CREATE TABLE " . $wpdb->prefix . self::TABLE_STATIC_SLIDES . " (
			  id int(9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			  slider_id int(9) NOT NULL,
			  params LONGTEXT NOT NULL,
			  layers LONGTEXT NOT NULL,
			  settings text NOT NULL,
			  INDEX `slider_id_index` (`slider_id`)
			);";
			dbDelta($sql);

			$sql = "CREATE TABLE " . $wpdb->prefix . self::TABLE_CSS . " (
			  id int(9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			  handle TEXT NOT NULL,
			  settings LONGTEXT,
			  hover LONGTEXT,
			  advanced LONGTEXT,
			  params LONGTEXT NOT NULL,
			  INDEX `handle_index` (`handle`(64))
			);";
			dbDelta($sql);

			$sql = "CREATE TABLE " . $wpdb->prefix . self::TABLE_LAYER_ANIMATIONS . " (
			  id int(9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			  handle TEXT NOT NULL,
			  params TEXT NOT NULL,
			  settings text NULL
			);";
			dbDelta($sql);

			$sql = "CREATE TABLE " . $wpdb->prefix . self::TABLE_NAVIGATIONS . " (
			  id int(9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			  name VARCHAR(191) NOT NULL,
			  handle VARCHAR(191) NOT NULL,
			  type VARCHAR(191) NOT NULL,
			  css LONGTEXT NOT NULL,
			  markup LONGTEXT NOT NULL,
			  settings LONGTEXT NULL
			);";
			dbDelta($sql);

			//create CSS entries
			$result = $wpdb->get_row("SELECT COUNT( DISTINCT id ) AS NumberOfEntrys FROM " . $wpdb->prefix . self::TABLE_CSS);
			if(!empty($result) && $result->NumberOfEntrys == 0){
				$css_class = RevSliderGlobals::instance()->get('RevSliderCssParser');
				$css_class->import_css_captions();
			}

			update_option('revslider_table_version', self::CURRENT_TABLE_VERSION);
			//$table_version = self::CURRENT_TABLE_VERSION;
		}
		
		/**
		 * check if table version is below 1.0.8.
		 * if yes, duplicate the tables into _bkp
		 * this way, we can revert back to v5 if any slider
		 * has issues in the v6 migration process
		 **/
		if(version_compare($table_version, '1.0.8', '<') && ($only_base === false || $only_base === '')){
			global $wpdb;
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			
			$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix . self::TABLE_SLIDER."_bkp LIKE ".$wpdb->prefix . self::TABLE_SLIDER.";";
			dbDelta($sql);
			$result = $wpdb->get_row("SELECT EXISTS (SELECT 1 FROM ".$wpdb->prefix . self::TABLE_SLIDER."_bkp) AS `exists`;", ARRAY_A);
			if(!empty($result) && isset($result['exists']) && $result['exists'] === '0'){
				$sql = "INSERT ".$wpdb->prefix . self::TABLE_SLIDER."_bkp SELECT * FROM ".$wpdb->prefix . self::TABLE_SLIDER.";";
				$wpdb->query($sql);
			}
			
			$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix . self::TABLE_SLIDES."_bkp LIKE ".$wpdb->prefix . self::TABLE_SLIDES.";";
			dbDelta($sql);
			$result = $wpdb->get_row("SELECT EXISTS (SELECT 1 FROM ".$wpdb->prefix . self::TABLE_SLIDES."_bkp) AS `exists`;", ARRAY_A);
			if(!empty($result) && isset($result['exists']) && $result['exists'] === '0'){
				$sql = "INSERT ".$wpdb->prefix . self::TABLE_SLIDES."_bkp SELECT * FROM ".$wpdb->prefix . self::TABLE_SLIDES.";";
				$wpdb->query($sql);
			}
			
			$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix . self::TABLE_STATIC_SLIDES."_bkp LIKE ".$wpdb->prefix . self::TABLE_STATIC_SLIDES.";";
			dbDelta($sql);
			$result = $wpdb->get_row("SELECT EXISTS (SELECT 1 FROM ".$wpdb->prefix . self::TABLE_STATIC_SLIDES."_bkp) AS `exists`;", ARRAY_A);
			if(!empty($result) && isset($result['exists']) && $result['exists'] === '0'){
				$sql = "INSERT ".$wpdb->prefix . self::TABLE_STATIC_SLIDES."_bkp SELECT * FROM ".$wpdb->prefix . self::TABLE_STATIC_SLIDES.";";
				$wpdb->query($sql);
			}
			
			$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix . self::TABLE_CSS."_bkp LIKE ".$wpdb->prefix . self::TABLE_CSS.";";
			dbDelta($sql);
			$result = $wpdb->get_row("SELECT EXISTS (SELECT 1 FROM ".$wpdb->prefix . self::TABLE_CSS."_bkp) AS `exists`;", ARRAY_A);
			if(!empty($result) && isset($result['exists']) && $result['exists'] === '0'){
				$sql = "INSERT ".$wpdb->prefix . self::TABLE_CSS."_bkp SELECT * FROM ".$wpdb->prefix . self::TABLE_CSS.";";
				$wpdb->query($sql);
			}
			
			$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix . self::TABLE_LAYER_ANIMATIONS."_bkp LIKE ".$wpdb->prefix . self::TABLE_LAYER_ANIMATIONS.";";
			dbDelta($sql);
			$result = $wpdb->get_row("SELECT EXISTS (SELECT 1 FROM ".$wpdb->prefix . self::TABLE_LAYER_ANIMATIONS."_bkp) AS `exists`;", ARRAY_A);
			if(!empty($result) && isset($result['exists']) && $result['exists'] === '0'){
				$sql = "INSERT ".$wpdb->prefix . self::TABLE_LAYER_ANIMATIONS."_bkp SELECT * FROM ".$wpdb->prefix . self::TABLE_LAYER_ANIMATIONS.";";
				$wpdb->query($sql);
			}
			
			$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix . self::TABLE_NAVIGATIONS."_bkp LIKE ".$wpdb->prefix . self::TABLE_NAVIGATIONS.";";
			dbDelta($sql);
			$result = $wpdb->get_row("SELECT EXISTS (SELECT 1 FROM ".$wpdb->prefix . self::TABLE_NAVIGATIONS."_bkp) AS `exists`;", ARRAY_A);
			if(!empty($result) && isset($result['exists']) && $result['exists'] === '0'){
				$sql = "INSERT ".$wpdb->prefix . self::TABLE_NAVIGATIONS."_bkp SELECT * FROM ".$wpdb->prefix . self::TABLE_NAVIGATIONS.";";
				$wpdb->query($sql);
			}
		}
	}
	
	
	/**
	 * get the images from posts/pages for yoast seo
	 **/
	public static function get_images_for_seo($url, $type, $user){
		if(in_array($type, array('user', 'term'), true)) return $url;
		if(!is_object($user) || !isset($user->ID)) return $url;
		
		$post = get_post($user->ID);
		if(is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'rev_slider')){
			preg_match_all('/\[rev_slider.*alias=.(.*)"\]/', $post->post_content, $shortcodes);
			
			if(isset($shortcodes[1]) && $shortcodes[1] !== ''){
				foreach($shortcodes[1] as $s){
					if(!RevSliderSlider::alias_exists($s)) continue;
					
					$sldr = new RevSliderSlider();
					$sldr->init_by_alias($s);
					$sldr->get_slides();
					$imgs = $sldr->get_images();
					if(!empty($imgs)){
						if(!isset($url['images'])) $url['images'] = array();
						foreach($imgs as $v){
							$url['images'][] = $v;
						}
					}
				}
			}
		}
		
		return $url;
	}
	
}