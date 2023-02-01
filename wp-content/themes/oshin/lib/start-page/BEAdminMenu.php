<?php 
/**
 * Handle adding the admin menu 
 *
 * @package be-functions
 * @author be
 **/
class BEAdminMenu
{
	public static $settings;

	public function __construct($core) {
		$this->core = $core;
		$settings = array();
		$this::$settings = wp_parse_args( $settings, array(
			'page-title' => esc_html__( 'Oshine', 'be-functions' ),
			'menu-title' => esc_html__( 'Oshine', 'be-functions' ),
			'capability' => 'edit_theme_options',
			'menu-slug' => 'be_register',
			'function' => array(&$this, 'menu_content'),
			'icon_url' => get_template_directory_uri().'/lib/admin-tpl/assets/img/oshine.png'
			) );
	}
	public function run(){
		add_action( 'admin_menu',array($this, 'menu') );
		//add_action( 'admin_menu', array($this, 'sub_menu'));
	}
	public function get_settings($setting) {
		return $this::$settings[$setting];
	}
	public function menu(){
		$page = add_menu_page( $this::$settings['page-title'], $this::$settings['menu-title'], $this::$settings['capability'], $this::$settings['menu-slug'], $this::$settings['function'], $this::$settings['icon_url'], 2 ); 
		add_action('load-'.$page, array($this,'menu_scripts'));
	}
	public function menu_content() {
		require_once get_template_directory() . '/lib/admin-tpl/start-page.php';
	}

	public function menu_scripts() {
		add_action( 'admin_enqueue_scripts', array($this,'register_scripts'), 10, 1 );
	}

	public function register_scripts($hook) {
		wp_enqueue_script( 'clipboard', get_template_directory_uri().'/lib/admin-tpl/assets/js/clipboard.min.js', array( 'jquery' ), false, false );

		wp_enqueue_script( 'image-picker', get_template_directory_uri().'/lib/admin-tpl/assets/js/image-picker.min.js', array( 'jquery' ), false, false );

		wp_enqueue_script( 'notify', get_template_directory_uri().'/lib/admin-tpl/assets/js/notify.js', array( 'jquery' ), false, false );

		wp_enqueue_script( 'be-start-scripts', get_template_directory_uri().'/lib/admin-tpl/assets/js/start-page.js', array( 'jquery' ), false, false );
		
		wp_enqueue_style( 'be-admin-tabs', get_template_directory_uri().'/lib/admin-tpl/assets/stylesheets/start-page.css', false );

		wp_enqueue_style( 'image-picker-css', get_template_directory_uri().'/lib/admin-tpl/assets/stylesheets/image-picker.css' );

		wp_enqueue_style( 'notify-metro-css', get_template_directory_uri().'/lib/admin-tpl/assets/stylesheets/notify-metro.css' );
	}

	public function sub_menu() {
	
		if( !defined('ENVATO_HOSTED_SITE') ) {
			add_theme_page( $this::$settings['menu-slug'], esc_html__( 'Prdouct License', 'be-functions' ), esc_html__( 'Prdouct License', 'be-functions' ), $this::$settings['capability'] , $this::$settings['menu-slug'].'#be-welcome', array(&$this, 'quick_start') );
			add_theme_page( $this::$settings['menu-slug'], esc_html__( 'System Status', 'be-functions' ), esc_html__( 'System Status', 'be-functions' ), $this::$settings['capability'] , admin_url('admin.php?page=be_registe#be-system-stat'), array(&$this, 'quick_start') );
		}
		add_theme_page( $this::$settings['menu-slug'], esc_html__( 'Install Plugins', 'be-functions' ), esc_html__( 'Install Plugins', 'be-functions' ), $this::$settings['capability'] , get_admin_url(null, 'admin.php?page=be_registe#be-plugins'), array(&$this, 'quick_start') );
		add_theme_page( $this::$settings['menu-slug'], esc_html__( 'Import Content', 'be-functions' ), esc_html__( 'Import Content', 'be-functions' ), $this::$settings['capability'] , admin_url().'admin.php?page=be_registe#be-import', array(&$this, 'quick_start') );
		
	}
}
?>