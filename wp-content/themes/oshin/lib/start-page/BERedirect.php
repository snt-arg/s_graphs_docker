<?php
/**
 * Take users to the start page after theme activate or update
 *
 * @package be-functions
 * @author be
 **/
class BERedirect
{
	
	function __construct($core)
	{
		$this->core = $core;
	}
	public function run() {
		add_action( 'after_switch_theme', array($this, 'activate_theme')  );
		add_action( 'admin_enqueue_scripts', array($this, 'update_redirect'));
	}
	public function get_menu_slug() {
		$menu = new BEAdminMenu($this->core);
		return $menu->get_settings('menu-slug');
	}
	public function activate_theme() {
		global $pagenow;
		
		if(is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
			wp_redirect( admin_url('admin.php?page='.$this->get_menu_slug().''), 302 );
			die();
		}
	}
	public function update_redirect() {
		wp_enqueue_script('be-update-redirect', get_template_directory_uri().'/lib/admin-tpl/assets/js/update-redirect.js', array('jquery'), OSHIN_THEME_VERSION, false);
		wp_localize_script( 'be-update-redirect', 'be_redirect', array(
			'url' => admin_url('admin.php?page='.$this->get_menu_slug().''),
			'theme_url'=>admin_url('themes.php?page=be_register&beerrormsg=no-pc-plugin-update#be-welcome'),
			'be_is_theme_valid'=>be_is_theme_valid()?"1":"0"
		) );
	}
}
?>