<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */
 
if(!defined('ABSPATH')) exit();

class RevSliderElementor {
	
	public static function init() {
		
		$min_elementor_version = '2.0.0';
		$min_php_version = '7.0';
	
		// Check if Elementor installed and activated
		if(!did_action('elementor/loaded')) return;
		
		// Check for required Elementor version
		if(!version_compare(ELEMENTOR_VERSION, $min_elementor_version, '>=' )) return;
		
		// Check for required PHP version
		if(version_compare(PHP_VERSION, $min_php_version, '<')) return;
		
		// Add Plugin actions
		add_action('elementor/widgets/widgets_registered', array('RevSliderElementor', 'init_elementor_widgets'));	
		
		// Register Widget Styles/Scripts
		add_action('elementor/editor/after_enqueue_styles', array('RevSliderShortcodeWizard', 'add_styles'));
		add_action('elementor/editor/after_enqueue_scripts', array('RevSliderElementor', 'add_scripts'));
		
	}
	
	public static function add_scripts() {
		
		RevSliderShortcodeWizard::add_scripts(true);
		
	}
	
	public static function init_elementor_widgets() {
		
		// Include Widget files
		require_once(plugin_dir_path( __FILE__) . 'elementor-widget.class.php');

		// Register widget
		$widgets_manager = \Elementor\Plugin::instance()->widgets_manager;
		if(version_compare(ELEMENTOR_VERSION, '3.1.0', '<=')){
			$widgets_manager->register_widget_type( new RevSliderElementorWidgetPre310() );
		}else{
			$widgets_manager->register_widget_type( new RevSliderElementorWidget() );
		}

	}
	
}