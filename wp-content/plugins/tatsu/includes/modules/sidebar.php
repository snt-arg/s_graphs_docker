<?php
// Change separator to divider in parser
if ( ! function_exists( 'tatsu_sidebar' ) ) {
	function tatsu_sidebar( $atts, $content, $tag) {

		$atts = shortcode_atts( array(
			'sidebar_id' => '',
			'animate' => 0,
      'animation_type' => 'fadeIn',
      'animation_delay' => 0,
			'key' => be_uniqid_base36( true )
						
		),$atts, $tag );
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';
		$data_animations = be_get_animation_data_atts( $atts );

		$output = '';
				$output .= '<div ' . $css_id . ' class="tatsu-module tatsu-sidebar '. $custom_class_name . ' '. $css_classes .' '. $visibility_classes .' '.$animate.'" '.$data_animations.' >';
				$output .= $custom_style_tag;
        ob_start();
        dynamic_sidebar( $sidebar_id );
        $output .= ob_get_clean();
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_sidebar', 'tatsu_sidebar' );
	add_shortcode( 'tatsu_gsection_sidebar', 'tatsu_sidebar' );
}

if( !function_exists( 'tatsu_sidebar_prevent_autop' ) ) {
	function tatsu_sidebar_prevent_autop( $content_filter, $tag ) {
		if( 'tatsu_sidebar' === $tag || 'tatsu_gsection_sidebar' === $tag ) {
			return false;
		}
		return $content_filter;
	}
}

add_action('tatsu_register_global_section', 'tatsu_register_sidebar');
add_action('tatsu_register_modules', 'tatsu_register_sidebar');
function tatsu_register_sidebar() {
	$sidebar_list = tatsu_get_sidebar_list();
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#sidebar',
		'title' => esc_html__('Sidebar', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => false,


		//Tab1
		'group_atts'			=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(

					array( //Tab1
						'type' => 'tab',
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
							'sidebar_id',
						),
					),
					array( //Tab2
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								"type" => "accordion",
								"active" => "none",
							  "group" => array(
							)
					    )
				 	 )  
				  ),
			   )
	        )
		),

		'atts' => array(
			array(
				'att_name' => 'sidebar_id',
				'type' => 'select',
				'label' => esc_html__('Sidebar', 'tatsu'),
				'options' => $sidebar_list,
				'default' => key($sidebar_list),
				'tooltip' => ''
			),
		),
		'presets' => array(
			'default' => array(
				'preset' => array(),
			)
		),
	);
	tatsu_register_global_module('tatsu_gsection_sidebar', $controls);
	tatsu_register_module('tatsu_sidebar', $controls);
}

?>