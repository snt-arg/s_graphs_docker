<?php

class RevsliderDivi extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'revslider';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'revslider-divi';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $required_divi_core_version = '4.9.0';

	/**
	 * REDI_RevsliderDivi constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'revslider-divi', $args = array() ) {

		//compare divi version with required version
		if (!function_exists('_et_core_find_latest')) return;
		$divi_core_version = _et_core_find_latest('version');
		if (version_compare($divi_core_version, $this->required_divi_core_version) < 0) {
			return;
		}

		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );

        if(!current_user_can('edit_posts') && !current_user_can('edit_pages')) return;

		if (!empty($_GET['et_fb'])) {
		    //load revslider styles and scripts needed for shortcode wizard
            require_once(RS_PLUGIN_PATH . 'admin/includes/shortcode_generator/shortcode_generator.class.php');
            RevSliderShortcodeWizard::add_styles();
            wp_enqueue_style('rs-new-plugin-settings', RS_PLUGIN_URL . 'admin/assets/css/builder.css', array('revslider-basics-css'), RS_REVISION);
            add_action( 'wp_enqueue_scripts', array($this, 'add_scripts') );
        }
		//load revslider modals html via separate ajax request
        //divi move content from window to iframe, we need to load it once again
        add_filter('revslider_do_ajax', array($this, 'shortcode_enqueue_files'), 10, 3);
	}

	public function add_scripts()
    {
        RevSliderShortcodeWizard::add_scripts(false, true);
        wp_localize_script('revbuilder-utils', 'RVS_DIVI_LANG', array(
            'loading_modals' => __('Loading Settings Modals...', 'revslider'),
            'select_module' => __('Select Module', 'revslider'),
            'select_module_tip' => __('Select Revolution Slider Module', 'revslider'),
            'open_editor_tip' => __('Open Slider Editor', 'revslider'),
            'edit_settings_tip' => __('Edit Block Settings', 'revslider'),
            'optimize_tip' => __('Optimize File Sizes', 'revslider'),
            'current_module' => __('Current Module', 'revslider'),
            'slider_not_selected' => __('Slider Not Selected', 'revslider'),
            'loading_image' => __('Loading Image...', 'revslider'),
            'broken_image' => __('No Image or Loading Error!', 'revslider'),
            'error_loading_settings' => __('Error Loading Settings Modals!', 'revslider'),
            'none' => __('- None -', 'revslider'),
        ));
    }

    public function shortcode_enqueue_files($return, $action, $data)
    {
        if ($action != 'shortcode_enqueue_files') return $return;

        ob_start();
        RevSliderShortcodeWizard::enqueue_files();
        $html = ob_get_clean();

        $return = array(
            'message' => 'Load Revslider Settings Modal',
            'data' => array(
                'html' => $html,
            ),
        );
        return $return;
    }
}

new RevsliderDivi;
