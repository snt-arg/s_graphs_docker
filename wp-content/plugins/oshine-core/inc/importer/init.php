<?php
	/**
 	* Plugin Name: BE one click import
 	* Plugin URI: http://www.brandexponents.com/
 	* Description: One click import
 	* Version: 3.0.1
 	* Author: BrandExponents
 	* Author URI: http://www.brandexponents.com/
 	* License: GPL2
 	*/
global $core;
//load admin theme data importer
class BEThemeDemoImporter extends BEThemeImporter {
    /**
     * Holds a copy of the object for easy reference.
     *
     * @since 0.0.1
     *
     * @var object
     */
    private static $instance;
    
    /**
     * Set the key to be used to store theme options
     *
     * @since 0.0.2
     *
     * @var object
     */
    public $theme_option_name = 'be_themes_data'; //set theme options name here
		
	public $theme_options_file_name = 'theme_options.json';

	public $colorhub_options_file_name = 'colorhub-data.json';

	public $typehub_options_file_name = 'typehub.json';
	
	public $widgets_file_name 		=  'widgets.json';
	
	public $content_demo_file_name  =  'content.xml';
	public $customizer_data_name = 'customizer_data.dat';

	public $demo_settings_name = 'demo_settings.json';

	public $tatsu_global_sections_file_name = 'tatsu-global-sections.json';

	/**
	 * Store the selected options from the dashboard
	 *
	 * @since 0.0.1
	 * @var object
	 */
	public $selected_demo_folder;



	/**
	 * Holds a copy of the widget settings 
	 *
	 * @since 0.0.2
	 *
	 * @var object
	 */
	public $widget_import_results;
	
    /**
     * Constructor. Hooks all interactions to initialize the class.
     *
     * @since 0.0.1
     */
    public function __construct() {
		$this->demo_files_path = BE_PATH . '/inc/importer/demo-files/';
        self::$instance = $this;
        
		parent::__construct();
    }

    public function run() {
    	add_action( 'wp_ajax_be_import_form', array($this, 'ajax_import'), 10, 1 );
    	add_action( 'wp_ajax_be_import_theme_options', array($this, 'ajax_import_theme_options'), 10, 1 );
    	add_action( 'wp_ajax_be_import_theme_widgets', array($this, 'ajax_import_theme_widgets'), 10, 1 );
    	add_action( 'wp_ajax_be_set_home_page', array($this, 'ajax_set_home_page'), 10, 1 );
    	add_action('wp_ajax_be_import_slider', array($this, 'import_slider'));
    	add_action('wp_ajax_be_set_demo_content', array($this, 'ajax_set_demo_content'));
		add_action('wp_ajax_be_require_plugins', array($this, 'ajax_get_require_plugins'));
		add_action( 'wp_ajax_be_import_typehub_options', array($this, 'ajax_import_typehub_options'), 10, 1 );
		add_action( 'wp_ajax_be_import_tatsu_global_sections', array($this, 'ajax_import_tatsu_global_sections'), 10 );
    }

    public function ajax_import_theme_options(){
    	$demo = $_POST['demo'];
    	$this->selected_demo_folder = $demo;
    	$this->set_demo_theme_options();
    	wp_die();
	}
	
    public function ajax_import_typehub_options(){
    	$demo = $_POST['demo'];
    	$this->selected_demo_folder = $demo;
    	$this->set_typehub_options();
    	wp_die();
	}

	public function ajax_import_tatsu_global_sections() {
		$demo = $_POST['demo'];
		$this->selected_demo_folder = $demo;
		$this->set_global_section_options();
		wp_die();
	}

    public function import_master_slider($data = '') {
    	if($data == '' || !file_exists($data)) {
    		return;
    		wp_die();
    	}
    	if(!class_exists('MSP_Importer')) {
    		require_once BE_PATH.'/inc/importer/class-msp-importer.php';
    	}
			$data_content = @file_get_contents($data);
			$import_class = new MSP_Importer;
			
			$slider_status = $import_class->import_data($data_content);
			if(function_exists('msp_update_preset_css')) {
				msp_update_preset_css();
			} 
	    	if(function_exists('msp_update_buttons_css')) {
	    		msp_update_buttons_css();
			}			
			if(function_exists('msp_save_custom_styles')) {
				msp_save_custom_styles();
			}
			
		
    }

    public function import_revslider($data = ''){
    	$demo = $_POST['demo'];
    	if(class_exists('RevSliderSlider')) {
    		$slider = new RevSlider();
    		return $slider->importSliderFromPost(true, true, $data);
    	} else {
    		echo 'Failed to import slider data, Please make sure to install and activate Slider Revolution plugin first';
    	}
    	wp_die();
    }

    public function import_slider() {
    	$demo = $_POST['demo'];
  
    	$sliders = self::get_settings($demo)['sliders'];
    	foreach ($sliders as $type => $file) {
    		$data = $this->demo_files_path.'/'.$file;
    		if($type == 'masterslider' && file_exists($data)) {
    			echo $this->import_master_slider($data);
    		} elseif ($type == 'revslider' && file_exists($data)) {
    			echo $this->import_revslider($data);
    		}
    	}
    }

    public function ajax_import_theme_widgets(){
    	$demo = $_POST['demo'];
    	$this->selected_demo_folder = $demo;
    	$this->process_widget_import_file();
    }

    public function ajax_set_demo_content() {
		if($_POST['demo']=='v1' || $_POST['demo']=='v4'){
			if(empty($_SESSION)) {
				session_start();
				$_SESSION['oshine_core_demo'] = $_POST['demo'];
			}
			if(!empty($_SESSION) && empty($_POST['attempt']) && !empty($_SESSION['oshine_core_import_data'])){
				unset($_SESSION['oshine_core_import_data']);
				$_SESSION['oshine_core_demo'] = $_POST['demo'];
			}
			
		}
		
		$demo = $_POST['demo'];
		if( isset( $_POST['data'] ) ) {
			$data = $_POST['data'];
		}
	    parent::set_demo_data();
	    $this->set_demo_menus($demo);
		
		if(isset($_SESSION)) {
			session_destroy();
		}
	    wp_die();
    }

	public function ajax_import() {

	  $demo = $_POST['demo'];
	  $data = $_POST['data'];
	  $this->selected_demo_folder = $demo;
	  $customize_data = $this->demo_files_path.$this->customizer_data_name;

	  if(isset($data)) {
	  	
	  	foreach ($data as $key) {
	  		if(method_exists($this, $key)) {
	  			call_user_func(array($this, $key));
	  		}
	  	}
	  	$this->import_master_slider();
	  	$this->set_demo_menus();
	  	
	  }
      //parent::_import_customizer($customize_data);
      
    }
	/**
	 * Add menus
	 *
	 * @since 0.0.1
	 */
	public function set_demo_menus($demo) {
		// Menus to Import and assign - you can remove or add as many as you want
		$locations = array();
		$menus = self::get_settings($demo)['menus'];
		foreach ($menus as $location => $name) {
			$menu = wp_get_nav_menu_object($name);
			$locations[$location] = $menu->term_id; 
		}
		var_dump( $locations );
		set_theme_mod( 'nav_menu_locations', $locations);
		
	}

	public function check_settings($demo = '') {
		
		$available = [];
		$path = $this->demo_files_path.'/'.$demo.'/';
		$content = @file_get_contents($path.$this->demo_settings_name);
		$settings_file = json_decode($content, true);
		
		if(isset($settings_file['home_page_title']) ){
			$available['home_page'] = 1;
		} else {
			$available['home_page'] = 0;
		}
		
		if(isset($settings_file['sliders'])) {
			$available['slider_data'] = 1;
		} else {
			$available['slider_data'] = 0;
		}

		if(file_exists($path.$this->widgets_file_name)) {
			$available['widgets'] = 1;
		} else {
			$available['widgets'] = 0;
		}
		if(file_exists($path.$this->theme_options_file_name) && class_exists('Colorhub') ) {
			$available['theme_option'] = 1;
		} else {
			$available['theme_option'] = 0;
		}
		if(file_exists($path.$this->typehub_options_file_name) && class_exists('Typehub') ) {
			$available['typehub_option'] = 1;
		} else {
			$available['typehub_option'] = 0;
		}
		if(file_exists($path.$this->tatsu_global_sections_file_name) && function_exists('tatsu_register_global_module') ) {
			$available['tatsu_global_section_option'] = 1;
		} else {
			$available['tatsu_global_section_option'] = 0;
		}
		if(file_exists($path.$this->content_demo_file_name)) {
			$available['content'] = 1;
		} else {
			$available['content'] = 0;
		}
		return "data-settings='".json_encode($available)."'";

	}

	public function get_settings($selected_demo = '') {
		if($selected_demo == '') {
			return;
		}
		$path = $this->demo_files_path.$this->demo_settings_name;
		
		$content = @file_get_contents($path);

		return json_decode($content, true);
	}

	public function ajax_set_home_page() {
		require( ABSPATH . '/wp-load.php' );
		$demo = $_POST['demo'];
		$page_title = self::get_settings($demo)['home_page_title'];
		$blog_page_title = self::get_settings($demo)['blog_page_title'];
		$page = get_page_by_title(esc_html( $page_title ));
		$blog_page = get_page_by_title( $blog_page_title );
		if($page->ID) {
			update_option( 'show_on_front', 'page', true);
			$is_home_page_updated = update_option( 'page_on_front', $page->ID );
		//	printf('%s page has been set as front page', $page_title);
		} 
		if( $blog_page->ID ) {
			update_option( 'show_on_front', 'page', true);
			$is_blog_page_updated = update_option( 'page_for_posts', $blog_page->ID );
		}
		if( !$is_home_page_updated && !$is_blog_page_updated ) {
			printf('Faild to set %s as home page & %s as blog page please make sure to import the content first', $page_title, $blog_page_title );
		} elseif ( $is_home_page_update && !$is_blog_page_updated ) {
			printf('%s has been set as home page however failed to set %s as blog page', $page_title, $blog_page_title );
		} elseif ( !$is_home_page_update && $is_blog_page_updated ) {
			printf('Failed to set %s as home page however %s has been set as blog page', $page_title, $blog_page_title );
		} else {
			printf('%s page has been set as front page & %s has been set as blog page', $page_title, $blog_page_title);
		}

		//Set woocommerce shop page
		$shop_page_title = self::get_settings($demo)['shop_page_title']; 
		if(!empty($shop_page_title)){ 
			$shop_page = get_page_by_title(esc_html( $shop_page_title ));
			if(!empty($shop_page->ID)){
				if(update_option( 'woocommerce_shop_page_id', $shop_page->ID )){
					printf('%s page has been set as shop page', $shop_page_title);
					$my_account_page_title = self::get_settings($demo)['my_account_page_title']; 
					$cart_page_title = self::get_settings($demo)['cart_page_title']; 
					$checkout_page_title = self::get_settings($demo)['checkout_page_title'];
					//My account page
					$myaccount_page = get_page_by_title(esc_html( $my_account_page_title ));
					if(!empty($myaccount_page->ID)){
						if(update_option( 'woocommerce_myaccount_page_id', $myaccount_page->ID )){
							printf('%s page has been set as my account page', $my_account_page_title);
						}else{
							printf('Faild to set %s as my account page', $my_account_page_title);
						}
					}
					///Cart page
					$cart_page = get_page_by_title(esc_html( $cart_page_title ));
					if(!empty($cart_page->ID)){
						if(update_option( 'woocommerce_cart_page_id', $cart_page->ID )){
							printf('%s page has been set as cart page', $cart_page_title);
						}else{
							printf('Faild to set %s as cart page', $cart_page_title);
						}
					}
					//checkout page
					$checkout_page = get_page_by_title(esc_html( $checkout_page_title ));
					if(!empty($checkout_page->ID)){
						if(update_option( 'woocommerce_checkout_page_id', $checkout_page->ID )){
							printf('%s page has been set as checkout page', $checkout_page_title);
						}else{
							printf('Faild to set %s as checkout page', $checkout_page_title);
						}
					}
				
				//SET woocommerce_settings options if provided
				$woocommerce_settings = self::get_settings($demo)['woocommerce_settings']; 
				if(!empty($woocommerce_settings)){ 
					foreach ($woocommerce_settings as $option_name => $option_value) {
						update_option( $option_name, $option_value );
					}
				}

				}else{
					printf('Faild to set %s as shop page', $shop_page_title);
				}
			}
		}

		//Nav menu widget settings if provided
		$widget_nav_menu_settings = self::get_settings($demo)['widget_nav_menu_settings'];
		if(!empty($widget_nav_menu_settings)){
			$widget_nav_menu = get_option('widget_nav_menu');
			if(!empty($widget_nav_menu) && is_array($widget_nav_menu)){
				$nav_menu = $widget_nav_menu_settings['nav_menu'];
				$nav_title = $widget_nav_menu_settings['title'];
				$term = get_term_by('name',$nav_menu, 'nav_menu');
		
				if(!empty($term) && !empty($term->term_id)){
					foreach ($widget_nav_menu as $key => $widget_nav) {
						if(is_array($widget_nav) && $widget_nav['title'] == $nav_title   && (empty($widget_nav['nav_menu']) || $widget_nav['nav_menu']!=$term->term_id)){
							$widget_nav_menu[$key]['nav_menu']= $term->term_id;
						}
					}
				}
				if(update_option('widget_nav_menu', $widget_nav_menu )){
					printf('%s navigation menu widget has been updated', $nav_title);
				}else{
					printf('Failed to update %s navigation menu widget', $nav_title);
				}
				
			}
		}
		wp_die();
	}
	public function ajax_get_require_plugins(){
		$demo = $_POST['demo'];
		$ret = '';
		$require_plugins = self::get_settings($demo)['content_plugins'];
		$plugins = [];
		if(is_array($require_plugins) && sizeof($require_plugins) >= 1) {
			foreach ($require_plugins as $plugin => $pluginName) {
				if(!is_plugin_active( $plugin.'/'.$plugin.'.php' )) {
					$plugins[] = $pluginName;
				}
			}
			if(sizeof($plugins) >= 1) {
				$ret = '{"stat":"0", "plugins":'.json_encode(array_values($plugins)).'}';
			} else {
				$ret = '{"stat":"1"}';
			}
			
		} else {
			$ret = '{"stat":"1"}';
		}
		wp_send_json( $ret, null );		
		wp_die();
	}
}
function Be_importer_tpl() {
	$radium = new BEThemeDemoImporter();
	echo $radium->demo_installer();
}
add_action( 'be_import_tpl', 'Be_importer_tpl', 30, 1 );
?>