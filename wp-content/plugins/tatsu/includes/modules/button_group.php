<?php
if ( !function_exists('tatsu_button_group') ) {	
	function tatsu_button_group( $atts, $content, $tag ){
		$atts = shortcode_atts( array (
			'alignment' => 'center',
			'margin' => '',
			'css_classes' => '',
			'key' => be_uniqid_base36(true),
		), $atts, $tag );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_button_group', $key );
		$custom_class_name = 'tatsu-'.$key;

		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }


		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 

		$output = '<div '.$css_id.' class="tatsu-module tatsu-button-group align-'.$alignment.' '.$custom_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.' >'.do_shortcode( $content ).'</div>'.$custom_style_tag;	
			
		return $output;	
	}	
	add_shortcode( 'tatsu_button_group', 'tatsu_button_group' );
}

add_action('tatsu_register_modules', 'tatsu_register_button_group', 5);
function tatsu_register_button_group()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#button_group',
		'title' => esc_html__('Button Group', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => 'tatsu_button',
		'allowed_sub_modules' => array('tatsu_button'),
		'type' => 'multi',
		'initial_children' => 2,
		'is_built_in' => true,
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							'alignment'
						)
					),
					array(
						'type'	=> 'tab',
						'title'	=> esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active'=> 'none',
								'group' => array(
									array(
										'type' => 'panel',
										'title'=> esc_html__('Spacing', 'tatsu'),
										'group'=> array(
											'margin'
										)
									)
								)
							)
						)
					)
				)
			)
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
					'right' => 'Right'
				),
				'default' => 'center',
				'tooltip' => ''
			),
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '0px 0px 20px 0px',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-button-group' => array(
						'property' => 'margin'
					),
				),
			),
		),
	);
	tatsu_register_module('tatsu_button_group', $controls);
}

?>