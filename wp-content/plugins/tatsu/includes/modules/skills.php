<?php
/**************************************
			SKILlS
**************************************/
if ( ! function_exists( 'tatsu_skills' ) ) {
	function tatsu_skills( $atts, $content, $tag ) {
		$atts = shortcode_atts( array( 
			'direction' => 'horizontal',
			'style'		=> 'rect',
            'height' => 400,
            'title_color'   => '',
			'fill_color'    => '',
            'bg_color'      => '',
			'key' => be_uniqid_base36(true),
		),$atts, $tag );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_skills', $key );
		$custom_class_name = ' tatsu-'.$key;

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );

		$style = !empty( $style ) ? 'tatsu-skill-' . $style : '';

		global $direction_global;
		$direction = ( isset($direction) && !empty($direction) ) ? $direction : 'horizontal' ;
		$direction_global = $direction;

		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }

		return '<div '.$css_id.' class="skill_container tatsu-module skill-'.$direction.' '.$custom_class_name.' ' . $style . ' '.$visibility_classes.' ' . $css_classes .' "'.$data_animations.' ><div class="skill clearfix">'.do_shortcode( $content ).'</div>'.$custom_style_tag.'</div>';
	}
}

if ( ! function_exists( 'tatsu_skill' ) ) {
	function tatsu_skill( $atts, $content, $tag ) {
		$atts =  shortcode_atts( array( 
			'title' => '',
			'value' => '',
			'fill_color' => '',
			'bg_color' => '',
			'title_color' => '',
			'css_classes' => '',
			'key' => be_uniqid_base36(true),
		),$atts, $tag );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_skill', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );

		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }

		global $direction_global;
		$output = '<div '.$css_id.' class="skill-wrap ' . $custom_class_name . ' '.$visibility_classes.' '.$css_classes.' " '.$data_animations.'>';
		if('horizontal' == $direction_global){
			$output .= '<h6 class="skill_name" >'.$title.'</h6>';
			$output .= '<div class="skill-bar"><span class="be-skill expand alt-bg alt-bg-text-color" data-skill-value="'.$value.'%" ></span></div>';
		}
		if('vertical' == $direction_global){
			$output .= '<div class="skill-bar"><span class="be-skill expand alt-bg alt-bg-text-color" data-skill-value="'.$value.'%" ></span></div>';
			$output .= '<h6 class="skill_name" >'.$title.'</h6>';
		}
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;
	}
}

add_action('tatsu_register_modules', 'tatsu_register_skills');
function tatsu_register_skills()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#skills',
		'title' => esc_html__('Skills', 'tatsu'),
		'is_js_dependant' => true,
		'child_module' => 'tatsu_skill',
		'type' => 'multi',
		'initial_children' => 4,
		'is_built_in' => true,
		'group_atts'	=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							'direction',
							'style',
							'height',
							'title_color',
							'fill_color',
							'bg_color',
						)
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
						)
					)
				)
			),
		),
		'atts' => array(
			array(
				'att_name' => 'direction',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Direction', 'tatsu'),
				'options' => array(
					'horizontal' => 'Horizontal',
					'vertical' => 'Vertical'
				),
				'default' => 'horizontal',
				'tooltip' => ''
			),
			array(
				'att_name'		=> 'style',
				'type'			=> 'button_group',
				'is_inline'     => true,
				'label'			=> esc_html__('Style', 'tatsu'),
				'options'		=> array(
					'rect'		=> 'Rectangular',
					'pill'		=> 'Pill',
				),
				'default'		=> 'rect',
				'tooltip'		=> ''
			),
			array(
				'att_name' => 'height',
				'type' => 'number',
				'label' => esc_html__('Skill Height', 'tatsu'),
				'options' => array(
					'unit' => 'px',
				),
				'default' => '400',
				'visible'	=> array('direction', '=', 'vertical'),
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .skill-bar' => array(
						'property' => 'height',
						'append' => 'px',
						'when'	=> array('direction', '=', 'vertical'),
					),
				),
			),
			array(
				'att_name' => 'title_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true,
				),
				'label' => esc_html__('Title Color', 'tatsu'),
				'default' => '', //sec_color
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .skill_name' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'fill_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true,
				),
				'label' => esc_html__('Fill Color', 'tatsu'),
				'default' => '', //color_scheme
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .be-skill' => array(
						'property' => 'background',
					),
				),
			),
			array(
				'att_name' => 'bg_color',
				'type' => 'color',
				'label' => esc_html__('Background Color', 'tatsu'),
				'default' => '', //sec_color
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .skill-bar' => array(
						'property' => 'background',
					),
				),
			)
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'fill_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'bg_color' => '#f2f5f8',
				),
			)
		),
	);
	tatsu_remap_modules(array('tatsu_skills', 'skills'), $controls, 'tatsu_skills');
}

add_action('tatsu_register_modules', 'tatsu_register_skill');
function tatsu_register_skill()
{
	$controls = array(
		'icon' => '',
		'title' => esc_html__('Skill', 'tatsu'),
		'is_js_dependant' => true,
		'child_module' => '',
		'type' => 'sub_module',
		'is_built_in' => true,
		'hint' => 'title',
		'group_atts'	=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							'title',
							'value',
							'title_color',
							'fill_color',
							'bg_color',
						)
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => 'none',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Spacing', 'tatsu'),
										'group' => array(
											'margin',
										)
									),
								),
							),
						)
					)
				)
			),
		),
		'atts' => array(
			array(
				'att_name' => 'title',
				'type' => 'text',
				'label' => esc_html__('Title', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'title_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true,
				),
				'label' => esc_html__('Title Color', 'tatsu'),
				'default' => '', //sec_color
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.skill-wrap .skill_name' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'value',
				'type' => 'slider',
				'label' => esc_html__('Percentage', 'tatsu'),
				'options' => array(
					'min' => '0',
					'max' => '100',
					'step' => '1',
					'unit' => '%',
				),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'fill_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true,
				),
				'label' => esc_html__('Fill Color', 'tatsu'),
				'default' => '', //color_scheme
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.skill-wrap .be-skill' => array(
						'property' => 'background',
					),
				),
			),
			array(
				'att_name' => 'bg_color',
				'type' => 'color',
				'label' => esc_html__('Background Color', 'tatsu'),
				'default' => '', //sec_color
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.skill-wrap .skill-bar' => array(
						'property' => 'background',
					),
				),
			),
			array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__( 'Margin', 'tatsu' ),
				'default' => '0px 0px 20px 0px',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'margin',
						'when' => array( 'margin', '!=', array( 'd' => '0px 0px 20px 0px' ) ),
					),
				),
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'title' => 'Skill',
					'value' => '70',
				),
			)
		),
	);
	tatsu_remap_modules(array('tatsu_skill', 'skill'), $controls, 'tatsu_skill');
}

?>