<?php

/**
 * Handles Post templates added by tatsu
 * @source https://github.com/wpexplorer/page-templater/blob/master/pagetemplater.php
 */
class Tatsu_Theme_Support {

	private static $instance;
	private $current_theme;
	private $theme_template;

	public static function getInstance() {
		if (null == self::$instance) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function __construct() {
		
	}

	public function init() {
		add_filter('page_template', array(&$this, 'tatsu_blank_page_template'));
		add_filter('theme_page_templates', array(&$this, 'tatsu_add_template_to_select'), 10, 4);
		/**
		 * Add Theme Supports
		 */
		add_theme_support('tatsu-global-sections');
		if (class_exists('Spyro_Modules')) { 
		add_theme_support('tatsu-forms');
		}
		$theme = wp_get_theme();
		$this->current_theme = strtolower($theme->get('Name'));
		$this->theme_template = strtolower($theme->get('Template'));
		$hide_support = apply_filters('tatsu_remove_header_footer_theme_support', array('Oshin'));
		$hide_support = array_map('strtolower', $hide_support);
		if (!in_array($this->current_theme, $hide_support) && !in_array($this->theme_template, $hide_support)) {
			add_theme_support('tatsu-header-builder');
			add_theme_support('tatsu-footer-builder');
		}
	}

	public function tatsu_blank_page_template($page_template) {
		if (get_page_template_slug() == 'tatsu-blank-page.php') {
			$page_template = TATSU_PLUGIN_DIR . 'includes/templates/tatsu-blank-page.php';
		}
		$hide_support = apply_filters('tatsu_remove_header_footer_theme_support', array('Oshin'));
		$hide_support = array_map('strtolower', $hide_support);
		if (!in_array($this->current_theme, $hide_support) && !in_array($this->theme_template, $hide_support)) {
			if (get_page_template_slug() == 'tatsu-default.php') {
				$page_template = TATSU_PLUGIN_DIR . 'includes/templates/tatsu-default.php';
			}
		}
		return $page_template;
	}

	public function tatsu_add_template_to_select($post_templates, $wp_theme, $post, $post_type) {
		if(is_tatsu_standalone()){
		$post_templates['tatsu-blank-page.php'] = esc_html__('Tatsu Blank Page', 'tatsu');
		$post_templates['tatsu-default.php'] = esc_html__('Tatsu Page with Headers and Footers', 'tatsu');
		}
		return $post_templates;
	}

}
