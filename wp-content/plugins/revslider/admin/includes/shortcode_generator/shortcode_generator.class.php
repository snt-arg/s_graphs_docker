<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderShortcodeWizard extends RevSliderFunctions {

	public static function enqueue_scripts(){
		global $pagenow;

		$f = RevSliderGlobals::instance()->get('RevSliderFunctions');
		$action = $f->get_val($_GET, 'action');
		if($action === 'elementor') return;

		// only add scripts if native WordPress editor, Gutenberg or Visual Composer
		// Elementor has its own hooks for adding scripts
		
		if($action === 'edit' || $pagenow === 'post-new.php' || $pagenow === 'widgets.php' || $f->get_val($_GET, 'vc_action', '') === 'vc_inline'){
			self::add_scripts();
		}

	}

	public static function add_styles(){
		wp_enqueue_style('revslider-material-icons', RS_PLUGIN_URL . 'public/assets/fonts/material/material-icons.css', array(), RS_REVISION);
		//wp_enqueue_style('revslider-material-icons', RS_PLUGIN_URL . 'admin/assets/icons/material-icons.css', array(), RS_REVISION);
		wp_enqueue_style('revslider-basics-css', RS_PLUGIN_URL . 'admin/assets/css/basics.css', array(), RS_REVISION);
		wp_enqueue_style('rs-color-picker-css', RS_PLUGIN_URL . 'admin/assets/css/tp-color-picker.css', array(), RS_REVISION);
		wp_enqueue_style('revbuilder-ddTP', RS_PLUGIN_URL . 'admin/assets/css/ddTP.css', array(), RS_REVISION);
		wp_enqueue_style('rs-roboto', '//fonts.googleapis.com/css?family=Roboto');
		wp_enqueue_style('tp-material-icons', '//fonts.googleapis.com/icon?family=Material+Icons');
	}

	public static function add_scripts($elementor = false, $divi = false){
		$f = RevSliderGlobals::instance()->get('RevSliderFunctions');
		$action = $f->get_val($_GET, 'action');
		if($elementor && $action !== 'elementor') return;

		require_once(RS_PLUGIN_PATH . 'admin/includes/functions-admin.class.php');
		require_once(RS_PLUGIN_PATH . 'admin/includes/template.class.php');
		require_once(RS_PLUGIN_PATH . 'admin/includes/folder.class.php');
		require_once(RS_PLUGIN_PATH . 'public/revslider-front.class.php');

		//check user permissions
		if(!current_user_can('edit_posts') && !current_user_can('edit_pages')) return;
		if(!$elementor && !$divi){
			//verify the post type
			global $typenow, $pagenow;

			$post_types = get_post_types();
			if(empty($post_types) || !is_array($post_types)) $post_types = array('post', 'page');
			if(!in_array($typenow, $post_types) && $pagenow !== 'widgets.php') return;

			$current_screen = get_current_screen();

			// checks for built-in gutenberg version
			$is_gutenberg = !empty($current_screen) && method_exists($current_screen, 'is_block_editor') && $current_screen->is_block_editor();

			// checks for old plugin version
			if(!$is_gutenberg) $is_gutenberg = function_exists('is_gutenberg_page') && is_gutenberg_page();

			// gutenberg
			if(!$is_gutenberg){
				add_filter('mce_external_plugins', array('RevSliderShortcodeWizard', 'add_tinymce_shortcode_editor_plugin'));
				add_filter('mce_buttons', array('RevSliderShortcodeWizard', 'add_tinymce_shortcode_editor_button'));
			}

			// enqueue styles
			self::add_styles();
		}

		$output_class = new RevSliderOutput();
		$output_class->add_inline_double_jquery_error(true);
		echo RevSliderFront::js_set_start_size();

		$dev_mode = (!file_exists(RS_PLUGIN_PATH.'admin/assets/js/plugins/utils.min.js') && !file_exists(RS_PLUGIN_PATH.'admin/assets/js/modules/editor.min.js')) ? true : false;

		if($dev_mode === true){
			wp_enqueue_script('revbuilder-basics', RS_PLUGIN_URL . 'admin/assets/js/modules/basics.js', array('jquery'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-ddTP', RS_PLUGIN_URL . 'admin/assets/js/plugins/ddTP.js', array('jquery'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-color-picker-js', RS_PLUGIN_URL . 'admin/assets/js/plugins/tp-color-picker.min.js', array('jquery', 'revbuilder-ddTP', 'wp-i18n', 'wp-color-picker'), RS_REVISION);
			wp_enqueue_script('revbuilder-clipboard', RS_PLUGIN_URL . 'admin/assets/js/plugins/clipboard.min.js', array('jquery'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-utils', RS_PLUGIN_URL . 'admin/assets/js/modules/objectlibrary.js', array('jquery'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-optimizer', RS_PLUGIN_URL . 'admin/assets/js/modules/optimizer.js', array('jquery'), RS_REVISION, false);					
		}else{
			wp_enqueue_script('revbuilder-utils', RS_PLUGIN_URL . 'admin/assets/js/plugins/utils.min.js', array('jquery', 'wp-i18n', 'wp-color-picker'), RS_REVISION, false);
		}

		wp_enqueue_script('tp-tools', RS_PLUGIN_URL . 'public/assets/js/rbtools.min.js', array('jquery'), RS_TP_TOOLS, true);

		// object library translations
		wp_localize_script('revbuilder-utils', 'RVS_LANG', array(			
			'sliderasmodal' => __('Use as Modal', 'revslider'),
			'noadminthumbs' => __('No Admin Thumb set', 'revslider'),
			'corejs' => __('Core JavaScript', 'revslider'),
			'corecss' => __('Core CSS', 'revslider'),
			'coretools' => __('Core Tools (GreenSock & Co)', 'revslider'),
			'enablecompression' => __('Enable Server Compression', 'revslider'),
			'noservercompression' => __('Not Available, read FAQ', 'revslider'),
			'servercompression' => __('Serverside Compression', 'revslider'),
			'sizeafteroptim' => __('Size after Optimization', 'revslider'),
			'chgimgsizesrc' => __('Change Image Size or Src', 'revslider'),
			'pickandim' => __('Pick another Dimension', 'revslider'),
			'optimize' => __('Optimize', 'revslider'),
			'applychanges' => __('Apply Changes', 'revslider'),
			'savechanges' => __('Save Changes', 'revslider'),
			'suggestion' => __('Suggestion', 'revslider'),
			'toosmall' => __('Too Small', 'revslider'),
			'standard1x' => __('Standard (1x)', 'revslider'),
			'retina2x' => __('Retina (2x)', 'revslider'),
			'oversized' => __('Oversized', 'revslider'),
			'quality' => __('Quality', 'revslider'),
			'file' => __('File', 'revslider'),
			'resize' => __('Resize', 'revslider'),
			'lowquality' => __('Optimized (Low Quality)', 'revslider'),
			'notretinaready' => __('Not Retina Ready', 'revslider'),
			'element' => __('Element', 'revslider'),
			'calculating' => __('Calculating...', 'revslider'),
			'filesize' => __('File Size', 'revslider'),
			'dimension' => __('Dimension', 'revslider'),
			'dimensions' => __('Dimensions', 'revslider'),
			'optimization' => __('Optimization', 'revslider'),
			'optimized' => __('Optimized', 'revslider'),
			'smartresize' => __('Smart Resize', 'revslider'),
			'optimal' => __('Optimal', 'revslider'),
			'recommended' => __('Recommended', 'revslider'),
			'hrecommended' => __('Highly Recommended', 'revslider'),
			'optimizertitel' => __('File Size Optimizer', 'revslider'),
			'loadedmediafiles' => __('Loaded Media Files', 'revslider'),
			'loadedmediainfo' => __('Optimize to save up to ', 'revslider'),
			'optselection' => __('Optimize Selection', 'revslider'),
			'copyrightandlicenseinfo' => __('&copy; Copyright & License Info', 'revslider'),
			'ol_images' => __('Images', 'revslider'),
			'ol_layers' => __('Layer Objects', 'revslider'),
			'ol_objects' => __('Objects', 'revslider'),
			'ol_modules' => __('Own Modules', 'revslider'),
			'ol_fonticons' => __('Font Icons', 'revslider'),
			'ol_moduletemplates' => __('Module Templates', 'revslider'),
			'ol_videos' => __('Videos', 'revslider'),
			'ol_svgs' => __('SVG\'s', 'revslider'),
			'ol_favorite' => __('Favorites', 'revslider'),
			'simproot' => __('Root', 'revslider'),
			'loading' => __('Loading', 'revslider'),
			'elements' => __('Elements', 'revslider'),
			'loadingthumbs' => __('Loading Thumbnails...', 'revslider'),
			'moduleBIG' => __('MODULE', 'revslider'),
			'packageBIG' => __('PACKAGE', 'revslider'),
			'installed' => __('Installed', 'revslider'),
			'notinstalled' => __('Not Installed', 'revslider'),
			'setupnotes' => __('Setup Notes', 'revslider'),
			'requirements' => __('Requirements', 'revslider'),
			'installedversion' => __('Installed Version', 'revslider'),
			'availableversion' => __('Available Version', 'revslider'),			
			'installpackage' => __('Installing Template Package', 'revslider'),			
			'doinstallpackage' => __('Install Template Package', 'revslider'),
			'installtemplate' => __('Install Template', 'revslider'),
			'installingaddon' => __('Installing Add-on', 'revslider'),
			'checkversion' => __('Update To Latest Version', 'revslider'),
			'installpackageandaddons' => __('Install Template Package & Addon(s)', 'revslider'),
			'installtemplateandaddons' => __('Install Template & Addon(s)', 'revslider'),
			'licencerequired' => __('Activate License', 'revslider'),
			'redownloadTemplate' => __('Re-Download Online', 'revslider'),
			'createBlankPage' => __('Create Blank Page', 'revslider'),
			'pluginsmustbeupdated' => __('Plugin Outdated. Please Update', 'revslider'),
			'please_wait_a_moment' => __('Please Wait a Moment', 'revslider'),
			'search' => __('Search', 'revslider'),
			'folderBIG' => __('FOLDER', 'revslider'),
			'objectBIG' => __('OBJECT', 'revslider'),
			'imageBIG' => __('IMAGE', 'revslider'),
			'videoBIG' => __('VIDEO', 'revslider'),
			'iconBIG' => __('ICON', 'revslider'),
			'svgBIG' => __('SVG', 'revslider'),
			'fontBIG' => __('FONT', 'revslider'),
			'show' => __('Show', 'revslider'),
			'perpage' => __('Per Page', 'revslider'),
			'updatefromserver' => __('Update List', 'revslider'),
			'imageisloading' => __('Image is Loading...', 'revslider'),
			'importinglayers' => __('Importing Layers...', 'revslider'),
			'layerwithaction' => __('Layer with Action', 'revslider'),
			'triggeredby' => __('Behavior', 'revslider'),
			'nrlayersimporting' => __('Layers Importing', 'revslider'),
			'nothingselected' => __('Nothing Selected', 'revslider'),
			'sortbycreation' => __('Sort by Creation', 'revslider'),
			'creationascending' => __('Creation Ascending', 'revslider'),
			'sortbytitle' => __('Sort by Title', 'revslider'),
			'titledescending' => __('Title Descending', 'revslider'),
			'active_sr_to_access' => __('Register Slider Revolution<br>to Unlock Premium Features', 'revslider'),				
			'addons' => __('Add-Ons', 'revslider'),
			'active_sr_tmp_obl' => __('Template & Object Library', 'revslider'),
			'active_sr_inst_upd' => __('Instant Updates', 'revslider'),
			'active_sr_one_on_one' => __('1on1 Support', 'revslider'),			
			'membersarea' => __('Members Area', 'revslider'),
			'onelicensekey' => __('1 License Key per Website!', 'revslider'),
			'onepurchasekey' => __('1 Purchase Code per Website!', 'revslider'),
			'onelicensekey_info' => __('If you want to use your license key on another domain, please<br> deregister it in the members area or use a different key.', 'revslider'),
			'onepurchasekey_info' => __('If you want to use your purchase code on<br>another domain, please deregister it first or', 'revslider'),
			'registeredlicensekey' => __('Registered License Key', 'revslider'),
			'registeredpurchasecode' => __('Registered Purchase Code', 'revslider'),
			'registerlicensekey' => __('Register License Key', 'revslider'),
			'registerpurchasecode' => __('Register Purchase Code', 'revslider'),
			'registerCode' => __('Register this Code', 'revslider'),
			'registerKey' => __('Register this License Key', 'revslider'),
			'deregisterCode' => __('Deregister this Code', 'revslider'),
			'deregisterKey' => __('Deregister this License Key', 'revslider'),
			'active_sr_plg_activ' => __('Register Purchase Code', 'revslider'),
			'active_sr_plg_activ_key' => __('Register License Key', 'revslider'),
			'getpurchasecode' => __('Get a Purchase Code', 'revslider'),
			'getlicensekey' => __('Get a License Key', 'revslider'),
			'ihavepurchasecode' => __('I have a Purchase Code', 'revslider'),
			'ihavelicensekey' => __('I have a License Key', 'revslider'),
			'enterlicensekey' => __('Enter License Key', 'revslider'),
			'enterpurchasecode' => __('Enter Purchase Code', 'revslider'),
			'premium_template' => __('PREMIUM TEMPLATE', 'revslider'),
			'rs_premium_content' => __('This is a Premium template from the Slider Revolution <a target="_blank" rel="noopener" href="https://www.sliderrevolution.com/examples/">template library</a>. It can only be used on this website with a <a target="_blank" rel="noopener" href="https://www.sliderrevolution.com/manual/quick-setup-register-your-plugin/?utm_source=admin&utm_medium=button&utm_campaign=srusers&utm_content=registermanual">registered license key</a>.', 'revslider'),
			'premium' => __('Premium', 'revslider'),
			'premiumunlock' => __('REGISTER LICENSE TO UNLOCK', 'revslider')

		));

		wp_enqueue_script('revbuildet-shortcode-generator-js', RS_PLUGIN_URL . 'admin/assets/js/shortcode_generator/shortcode_generator.js', array('jquery'), RS_REVISION, true);		

		$rsaf = new RevSliderFunctionsAdmin();
		$rsa = $rsaf->get_short_library();
		if(!empty($rsa)) $obj = $rsaf->json_encode_client_side($rsa);

		$rs_compression = $rsaf->compression_settings();
		$favs = get_option('rs_favorite', array());
		$favs = !empty($favs) ? $rsaf->json_encode_client_side($favs) : false;
		
		$rs_color_picker_presets = RSColorpicker::get_color_presets();
		
		?>
		<script>
            var ajaxurl = '<?php echo esc_js( admin_url( 'admin-ajax.php', 'relative' ) ); ?>';
			window.RVS = window.RVS === undefined ? {F:{}, C:{}, ENV:{}, LIB:{}, V:{}, S:{}} : window.RVS;
			RVS.LIB.OBJ = RVS.LIB.OBJ===undefined ? {} : RVS.LIB.OBJ;

			var RS_DEFALIAS,
				RS_SHORTCODE_FAV;

			RVS.ENV.plugin_url	= '<?php echo RS_PLUGIN_URL; ?>';
			RVS.ENV.plugin_dir	= 'revslider';
			RVS.ENV.ajax_url	= '<?php echo esc_js( admin_url( 'admin-ajax.php') ); ?>';
			RVS.ENV.admin_url	= '<?php echo admin_url('admin.php?page=revslider'); ?>';
			RVS.ENV.nonce		= '<?php echo wp_create_nonce('revslider_actions'); ?>';
			RVS.ENV.activated	= '<?php echo (get_option('revslider-valid', 'false')) == 'true' ? 'true' : 'false'; ?>';
			RVS.ENV.activated	= RVS.ENV.activated == 'true' || RVS.ENV.activated == true ? true : false;
			RVS.ENV.selling		= <?php echo ($rsaf->get_addition('selling') === true) ? 'true' : 'false'; ?>;
			RVS.LIB.COLOR_PRESETS	= <?php echo (!empty($rs_color_picker_presets)) ? 'JSON.parse('. $rsaf->json_encode_client_side($rs_color_picker_presets) .')' : '{}'; ?>;
			
			window.addEventListener('load', function(){
				RVS.ENV.output_compress	= <?php echo (!empty($rs_compression)) ? 'JSON.parse('. $rsaf->json_encode_client_side($rs_compression) .')' : '[]'; ?>;
				<?php if(!empty($rsa)){ ?>
				RVS.LIB.OBJ = {shortcode_generator: true, types: JSON.parse(<?php echo $obj; ?>)};
				<?php }else{ ?>
				RVS.LIB.OBJ = {};
				<?php }
				if(!empty($favs)){ ?>
				RS_SHORTCODE_FAV = JSON.parse(<?php echo $favs; ?>);
				<?php } ?>
			});

		</script>
		<?php
	}

	public static function enqueue_files(){
		echo '<div id="rb_modal_underlay" style="display:none"></div>';

		require_once(RS_PLUGIN_PATH . 'admin/views/modals-copyright.php');
	}


	/**
	 * add script tinymce shortcode script
	 * @since: 5.1.1
	 */
	public static function add_tinymce_shortcode_editor_plugin($plugin_array){
		$plugin_array['revslider_sc_button'] = RS_PLUGIN_URL . 'admin/assets/js/shortcode_generator/tinymce.js';

		return $plugin_array;
	}

	/**
	 * Add button to tinymce
	 * @since: 5.1.1
	 */
	public static function add_tinymce_shortcode_editor_button($buttons){
		array_push($buttons, 'revslider_sc_button');

		return $buttons;
	}

}

/**
 * old classname extends new one (old classnames will be obsolete soon)
 * @since: 5.0
 **/
class RevSlider_TinyBox extends RevSliderShortcodeWizard {}
class RevSliderTinyBox extends RevSlider_TinyBox {}