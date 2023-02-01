<?php
	if (!function_exists('be_themes_add_bb_press_styles_and_scripts')) {
		function be_themes_add_bb_press_styles_and_scripts() {
			wp_register_style( 'be-themes-bb-press-css', get_template_directory_uri() . '/bb-press/bb-press.css' );
			wp_enqueue_style( 'be-themes-bb-press-css' );
		}
		add_action( 'wp_enqueue_scripts', 'be_themes_add_bb_press_styles_and_scripts' );
	}
?>