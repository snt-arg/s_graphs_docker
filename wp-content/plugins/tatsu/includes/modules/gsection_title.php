<?php
// Change separator to divider in parser
if ( ! function_exists( 'tatsu_gsection_title' ) ) {
	function tatsu_gsection_title( $atts ) {
		$atts = shortcode_atts( array(
			'alignment' => 'center',
			'title_font' => '',
			'margin'	 => '0 0 30px 0',
			'key' => be_uniqid_base36(true),
		),$atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_gsection_title', $atts['key'], 'Global' );
		$custom_class_name = 'tatsu-'.$atts['key'];


		extract( $atts );
		$output = '';
		global $post;
		$post_title = '';
		$is_others_page = tatsu_is_others_page_type();
		if( is_archive() || $is_others_page[0] ){
			if( is_search() ){
				$post_title = esc_html__( 'Search', 'tatsu' );
			} else if( is_404() ){
				$post_title = esc_html__( '404', 'tatsu' );
			} else {
				$post_title = get_the_archive_title();
			}
		} elseif( is_home() ) {
			$post_title = esc_html__('BLOG','tatsu');
		} else {
			$post_title = $post->post_title;
		}
		
		$output .= '<div class="tatsu-module tatsu-gsection-title ' . $custom_class_name . ' align-'.$alignment.'">';
		$output .= '<div class="'. $title_font .'" >'. $post_title . '</div>';
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_gsection_title', 'tatsu_gsection_title' );
}

add_action('tatsu_register_global_section', 'tatsu_register_gsection_title');
function tatsu_register_gsection_title()
{
	$controls = array(
		'icon' => '',
		'title' => esc_html__('Global Section Title', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => true,
		'atts' => array_values(array_filter(array(
			array(
				'att_name' => 'alignment',
				'type' => 'button_group',
				'label' => esc_html__('Alignment', 'tatsu'),
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
				),
				'default' => 'center',
				'tooltip' => ''
			),
			(function_exists('typehub_get_exposed_selectors') ? array(
				'att_name' => 'title_font',
				'type' => 'select',
				'label' => esc_html__('Font for Title', 'tatsu'),
				'options' => typehub_get_exposed_selectors(),
				'default' => '',
				'tooltip' => ''
			) : false),
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '0px 0px 30px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-module' => array(
						'property' => 'margin',
					),
				),
			),
		))),
		'presets' => array(
			'default' => array(
				'preset' => array(
					'height' => '1',
				),
			)
		),
	);
	tatsu_register_global_module('tatsu_gsection_title', $controls);
}

?>