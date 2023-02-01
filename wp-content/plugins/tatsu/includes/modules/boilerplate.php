<?php
/**
 * Replace "module_name", "module-name" and "Module Name" with module name with appropriate conventions('-','_',' ')
 * Uncomment tatsu_register_modules hook(:32) and tatsu_register_module function(:94)
 */
if ( ! function_exists( 'tatsu_module_name' ) ) {
	function tatsu_module_name( $atts , $content, $tag ) {
		$atts = shortcode_atts( array(
	        'alignment' => 'left',
			'key' => be_uniqid_base36(true),
        ),$atts , $tag );
		extract($atts);
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_module_name', $key );
		$custom_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$data_animations = be_get_animation_data_atts( $atts );

		$animate = ( 'none' != $animation_type ) ? 'tatsu-animate' : '' ;
		$output = '';
		
		$output .= '<div '.$css_id.' class="tatsu-module tatsu-module-name-wrap '. $animate .' '. $custom_class_name.'  '.$css_classes.' '. $visibility_classes.'" '.$data_animations.' >';
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_module_name', 'tatsu_module_name' );
}

//add_action('tatsu_register_modules', 'tatsu_register_module_name', 7);
function tatsu_register_module_name()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '',
		'title' => esc_html__('Module Name', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => true,
		'group_atts'			=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							'alignment',
						),
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							
						),
					),
				),
			),
		),
		'atts' => array(
			array(
				'att_name' => 'alignment',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Align', 'tatsu'),
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
				),
				'default' => 'left',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-module-name-wrap' => array(
						'property' => 'text-align'
					)
				)
            )
        ),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'alignment' => 'left',
				),
			)
		),
	);
	//tatsu_register_module('tatsu_module_name', $controls);
}

?>