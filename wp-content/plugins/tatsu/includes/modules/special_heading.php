<?php
/**************************************
			SPECIAL HEADING
**************************************/
if (!function_exists('tatsu_special_heading')) {
	function tatsu_special_heading( $atts, $content, $tag ) { 

        $atts = shortcode_atts( array(
            'title_content'        => '',
            'border_style'         => 'style1',
            'font_size'            => '14px',
            'letter_spacing'       => '0em',
            'margin'               => '0px 0px 0px 0px',
            'title_color'          => '',
			'border_color'         => '',
			'outer_border_style'   => '',
			'outer_border_color'   => '',
            'title_hover_color'    => '',
            'alignment'            => 'left',
			'expand_border'        => 0,
			'animate'			   => '1',
			'key' => be_uniqid_base36(true),
        ), $atts, $tag );


        extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_special_heading', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 

        $border_style = ( isset($border_style) && !empty($border_style) ) ? $border_style : 'style1';
		$expand_border = ( isset($expand_border) && !empty($expand_border) ) ? 1 : 0;
		$data_animations = be_get_animation_data_atts( $atts );

        $output ='';
		$animate = ( isset( $animate ) && 1 == $animate && 'none' != $animation_type ) ? ' tatsu-animate"' : '"' ;
        $output .= '<div '.$css_id.' class = "tatsu-special-heading-wrap '.$custom_class_name.' ' . $animate . ' ' .$visibility_classes.' ' .$css_classes. '" '.$data_animations.' >';
        $output .= $custom_style_tag;
        $output .= '<div class = "special-heading-inner-wrap tatsu-border-' . $border_style .  ( ( 1 == $expand_border ) ? ' tatsu-expand"' : '"' ) . ' >';
        $output .= '<div class = "tatsu-border" >';
        $output .= '</div>'; //End be-border
        $output .= '<h6 class = "tatsu-title">';
        $output .= $title_content;
        $output .= '</h6>';//End be-title 
        $output .= '</div>'; // End special-heading-inner-wrap
        $output .= '</div>'; //End special-heading-wrap
        return $output;
    }
}

add_action('tatsu_register_modules', 'tatsu_register_special_heading');
if (!function_exists('tatsu_register_special_heading')) {
	function tatsu_register_special_heading()
	{
		$controls = array(
			'icon' 				=> TATSU_PLUGIN_URL . '/builder/svg/modules.svg#special_title',
			'title' 			=> esc_html__('Special Title', 'tatsu'),
			'is_js_dependant' 	=> false,
			'type' 				=> 'single',
			'is_built_in' 		=> true,
			'hint' => 'title_content',
			'group_atts' => array(
				array(
					'type'		=> 'tabs',
					'style'		=> 'style1',
					'group'		=> array(
						array(
							'type' => 'tab',
							'title' => esc_html__('Style', 'tatsu'),
							'group'	=> array(
								'title_content',
								'border_style',
								'font_size',
								'letter_spacing',
								array(
									'type' => 'accordion',
									'active' => 'all',
									'group' => array(
										array(
											'type' => 'panel',
											'title' => esc_html__('Title Styling', 'tatsu'),
											'group' => array(
												'title_color',
												'title_hover_color',
												'alignment',
											)
										),

										array(
											'type' => 'panel',
											'title' => esc_html__('Border Styling', 'tatsu'),
											'group' => array(
												'border_color',
												'expand_border',
											),
										),
									),
								),
							),
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
										array(
											'type' => 'panel',
											'title' => esc_html__('Border', 'tatsu'),
											'group' => array(
												'outer_border_style',
												'border',
												'outer_border_color',
											)
										),
									),
								),
							),
						),
					),
				),
			),



			'atts' 				=> array(
				array(
					'att_name'		=> 'title_content',
					'type'			=> 'text',
					'label'			=> esc_html__('Title', 'tatsu'),
					'default'		=> '',
					'tooltip'		=> ''
				),
				array(
					'att_name'		=> 'border_style',
					'type' 			=> 'select',
					'is_inline'     => true,
					'label'			=> esc_html__('Style', 'tatsu'),
					'options'		=> array(
						'style1'		=> 'Style 1',
						'style2'		=> 'Style 2',
						'style3'		=> 'Style 3',
						'style4'		=> 'Style 4',
					),
					'default'		=> 'style1',
					'tooltip'		=> ''
				),
				array(
					'att_name' 		=> 'font_size',
					'type'			=> 'slider',
					'label'			=> esc_html__('Font Size', 'tatsu'),
					'options'		=> array(
						'min'				=> 8,
						'max'				=> 100,
						'unit'				=> 'px',
						'add_unit_to_value'	=> true,
						'step'				=> 1
					),
					'default'		=> 13,
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-special-heading-wrap' => array(
							'property' => 'font-size',
						),
					),
				),
				array(
					'att_name'		=> 'letter_spacing',
					'type'			=> 'slider',
					'label'			=> esc_html__('Letter Spacing', 'tatsu'),
					'options'		=> array(
						'min'				=> 0,
						'max'				=> 10,
						'unit'				=> 'px',
						'add_unit_to_value'	=> true,
						'step'				=> 1
					),
					'default'		=> '2px',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-special-heading-wrap .tatsu-title' => array(
							'property' => 'letter-spacing',
						),
					),
				),
				array(
					'att_name'		=> 'margin',
					'type'			=> 'input_group',
					'label'			=> esc_html__('Margin', 'tatsu'),
					'default'		=> '0px 0px 20px 0px',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-special-heading-wrap' => array(
							'property' => 'margin'
						),
					),
				),
				array(
					'att_name'		=> 'title_color',
					'type' 			=> 'color',
					'label'			=> esc_html__('Title Color', 'tatsu'),
					'default'		=> '',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-special-heading-wrap .tatsu-title' => array(
							'property' => 'color'
						),
					),
				),
				array(
					'att_name'		=> 'border_color',
					'type'			=> 'color',
					'label'			=> esc_html__('Border/Label Color', 'tatsu'),
					'default' 		=> '',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-special-heading-wrap .tatsu-border' => array(
							'property' => 'background',
						),
					),
				),
				array(
					'att_name'		=> 'expand_border',
					'type'			=> 'switch',
					'label'			=> esc_html__('Expand on Hover', 'tatsu'),
					'default'		=> 0,
					'tooltip'		=> ''
				),
				array(
					'att_name'		=> 'title_hover_color',
					'type'			=> 'color',
					'label'			=> esc_html__('Title Hover Color', 'tatsu'),
					'default'		=> '',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-special-heading-wrap .special-heading-inner-wrap:hover .tatsu-title' => array(
							'property' => 'color'
						),
					),
				),
				array(
					'att_name'		=> 'alignment',
					'type'			=> 'button_group',
					'is_inline'     => true,
					'label'			=> esc_html__('Alignment', 'tatsu'),
					'options'		=> array(
						'left'		=> 'Left',
						'center'	=> 'Center',
						'right'		=> 'Right'
					),
					'default'		=> 'left',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-special-heading-wrap' => array(
							'property' => 'text-align',
						),
					),
				),
				array (
					'att_name' => 'outer_border_style',
					'type' => 'select',
					'label' => esc_html__( 'Border Style', 'tatsu' ),
					'options' => array(
						'none' => 'None',
						'solid' => 'Solid',
						'dashed' => 'Dashed',
						'double' => 'Double',
						'dotted' => 'Dotted',
					),
					'default' => array( 'd' => 'solid', 'l' => 'solid', 't' => 'solid', 'm' => 'solid' ),
					'exclude' => array( 'tatsu_image' ),
					'tooltip' => '',
					'css' => true,
					'responsive' => true,
					'selectors' => array(
						'.tatsu-{UUID}' => array(
							'property' => 'border-style',
							'when' => array(
								array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
								array( 'border', 'notempty' ),
								array( 'outer_border_style', '!=',  array( 'd' => 'none' ) ),
							),
							'relation' => 'and',            
						),
					),
				),
				array (
					'att_name' => 'border',
					'type' => 'input_group',
					'label' => esc_html__( 'Border Width', 'tatsu' ),
					'default' => '0px 0px 0px 0px',
					'exclude' => array( 'tatsu_image', 'tatsu_lists' ),
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}' => array(
							'property' => 'border-width',
							'when' => array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
						),
					),
				),
				array (
					'att_name' => 'outer_border_color',
					'type' => 'color',
					'label' => esc_html__( 'Border Color', 'tatsu' ),
					'default' => '',
					'exclude' => array( 'tatsu_image', 'tatsu_lists', 'tatsu_call_to_action', 'tatsu_tabs', 'tatsu_accordion' ),
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}' => array(
							'property' => 'border-color',
							'when' => array('border', '!=', '0px 0px 0px 0px'),
						),
					),
				),
			),
			'presets' => array(
				'default' => array(
					'title' => '',
					'image' => '',
					'preset' => array(
						'title_content' => esc_html__('HEADING', 'tatsu'),
						'border_style' => 'style2',
						'border_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
						'expand_border' => '1',
						'letter_spacing' => '2px',
						'font_size' => '13',
					),
				)
			),
		);
		tatsu_remap_modules(array('tatsu_special_heading', 'be_special_heading6'), $controls, 'tatsu_special_heading');
	}
}

?>