<?php
/**************************************
			SPECIAL TITLE 6
**************************************/
if (!function_exists('be_special_heading6')) {
	function be_special_heading6( $atts, $content, $tag ) { 

        $atts = shortcode_atts( array(
            'title_content'        => '',
            'border_style'         => 'style1',
            'font_size'            => '14px',
            'letter_spacing'       => '0em',
            'margin'               => '0px 0px 0px 0px',
            'title_color'          => '',
            'border_color'         => '',
            'title_hover_color'    => '',
            'alignment'            => 'left',
            'expand_border'        => 0,
            'animate'              => 0,
            'animation_type'       => 'none',
			'key' => be_uniqid_base36(true),
			'outer_border_style' => '',
			'outer_border_color' => '',
        ), $atts, $tag );


        extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';  		
		$data_animations = be_get_animation_data_atts( $atts );

        $border_style = ( isset($border_style) && !empty($border_style) ) ? $border_style : 'style1';
        $expand_border = ( isset($expand_border) && !empty($expand_border) ) ? 1 : 0;
        $output =''; 
        $animation_type = ( isset($animation_type) && !empty($animation_type) && !empty($animate) ) ? $animation_type : 'none';
        $output .= '<div '.$css_id.' class = "oshine-module special-heading-wrap '.$custom_class_name.' style6' . $animate . ' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'>';
        $output .= $custom_style_tag;
        $output .= '<div class = "special-heading-inner-wrap be-border-' . $border_style .  ( ( 1 == $expand_border ) ? ' be-expand"' : '"' ) . ' >';
        $output .= '<div class = "be-border" >';
        $output .= '</div>'; //End be-border
        $output .= '<h6 class = "be-title">';
        $output .= $title_content;
        $output .= '</h6>';//End be-title 
        $output .= '</div>'; // End special-heading-inner-wrap
        $output .= '</div>'; //End special-heading-wrap
        return $output;
    }
    add_shortcode( 'be_special_heading6','be_special_heading6' );
}

add_action( 'tatsu_register_modules', 'oshine_register_special_heading6', 11);
if( !function_exists( 'oshine_register_special_heading6' ) ) {
	function oshine_register_special_heading6() {
		$controls = array(
			'icon' 				=> OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#special_heading3',
			'title' 			=> __( 'Special Title - Style 6', 'oshine_modules' ),
			'is_js_dependant' 	=> false,
			'type' 				=> 'single',
			'is_built_in' 		=> true,
			'hint'	=> 'title_content',
			'group_atts' => array (
				array (
					'type'	=> 'tabs',
					'style'	=> 'style1',
					'group'	=> array(
						array (
							'type' => 'tab',
							'title' => __( 'Content', 'tatsu' ),
							'group'	=> array (
								array (
									'type' => 'accordion' ,
									'active' => 'none',
									'group' => array (
										'title_content',
									)
								)
							)
						),
						array ( 
							'type' => 'tab',
							'title' => __( 'Style', 'tatsu' ),
							'group'	=> array (
								array (
									'type' => 'accordion' ,
									'active' => 'all',
									'group' => array (
										array (
											'type' => 'panel',
											'title' => __( 'Shape and style', 'tatsu' ),
											'group'	=> array (
												'font_size',
												'letter_spacing',
												'border_width',
												'border_style',
												'alignment',
												'expand_border',
											),
										),
										array (
											'type'	=> 'panel',
											'title'	=> __( 'Colors', 'tatsu' ),
											'group'	=> array (
												array (
													'type' => 'tabs',
													'style'	=> 'style1',
													'group'	=> array (
														array (
															'type'	=> 'tab',
															'title'	=> __( 'Normal', 'tatsu' ),
															'group'	=> array (
																'title_color',
																'border_color',
															),	
														),
														array (
															'type'	=> 'tab',
															'title'	=> __( 'Hover', 'tatsu' ),
															'group'	=> array (
																'title_hover_color',
															),
														),
													),
												)
											),
										),
									)
								),
							)
						),
						array (
							'type' => 'tab',
							'title' => __( 'Advanced', 'tatsu' ),
							'group'	=> array (
								array (
									'type' => 'accordion' ,
									'active' => 'none',
									'group' => array (
										array (
											'type' => 'panel',
											'title' => __( 'Spacing', 'tatsu' ),
											'group' => array (
												'margin',
											)
										),
										array(
											'type' => 'panel',
											'title' => __('Border', 'tatsu'),
											'group' => array(
												'outer_border_style',
												'border',
												'outer_border_color',
											)
										),
									)
								),	
							),
						)
					)
				)
			),
			'atts' 				=> array(
				array(
					'att_name'		=> 'title_content',
					'type'			=> 'text_area',
					'label'			=> __( 'Title', 'oshine_modules' ),
					'default'		=> '',
					'tooltip'		=> ''
				),
				array(
					'att_name'		=> 'border_style',
					'type' 			=> 'button_group',
					'is_inline' => true,
					'label'			=> __('Border Style', 'oshine_modules'),
					'options'		=> array(
						'style1'		=> 'Style 1',
						'style2'		=> 'Style 2'
					),
					'default'		=> 'style1',
					'tooltip'		=> ''		
				),
				array(
					'att_name' 		=> 'font_size',
					'type'			=> 'slider',
					'label'			=> __( 'Font Size', 'oshine_modules' ),
					'options'		=> array(
						'min'				=> 8,
						'max'				=> 100,
						'unit'				=> 'px',
						'add_unit_to_value'	=> true,
						'step'				=> 1
					),
					'default'		=> '13px',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap.style6' => array(
							'property' => 'font-size',	
						),
					),
				),
				array(
					'att_name'		=> 'letter_spacing',
					'type'			=> 'slider',
					'label'			=> __('Letter Spacing', 'oshine_modules'),
					'options'		=> array (
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
						'.tatsu-{UUID}.special-heading-wrap.style6 .be-title' =>array(
							'property' => 'letter-spacing',
						),
					),
				),
				array(
					'att_name'		=> 'margin',
					'type'			=> 'input_group',
					'label'			=> __( 'Margin', 'oshine_modules' ),
					'default'		=> '0px 0px 20px 0px',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap.style6' =>array(
							'property' => 'margin'
						),
					),
				),
				array(
					'att_name'		=> 'title_color',
					'type' 			=> 'color',
					'label'			=> __( 'Title Color', 'oshine_modules' ),
					'default'		=> '',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap.style6 .be-title' =>array(
							'property' => 'color'
						),
					),

				),
				array(
					'att_name'		=> 'border_color',
					'type'			=> 'color',
					'label'			=> __( 'Border Color', 'oshine_modules' ),
					'default' 		=> '',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap.style6 .be-border ' =>array(
							'property' => 'background'
						),
					),
				),
				array(
					'att_name'		=> 'expand_border',
					'type'			=> 'switch',
					'label'			=> __('Expand Border on Hover', 'oshine_modules'),
					'default'		=> 0,
					'tooltip'		=> ''
				),
				array(
					'att_name'		=> 'title_hover_color',
					'type'			=> 'color',
					'label'			=> __( 'Title Hover Color', 'oshine_modules' ),
					'default'		=> '',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.style6 .special-heading-inner-wrap:hover .be-title' =>array(
							'property' => 'color'
						),
					),
				),
				array(
					'att_name'		=> 'alignment',
					'type'			=> 'button_group',
					'is_inline' => true,
					'label'			=> __( 'Alignment', 'oshine_modules' ),
					'options'		=> array(
						'left'		=> 'Left',
						'center'	=> 'Center',
						'right'		=> 'Right'
					),
					'default'		=> 'left',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap.style6' =>array(
							'property' => 'text-align',
						),
					),
				),
				array (
					'att_name' => 'outer_border_style',
					'type' => 'select',
					'label' => __( 'Border Style', 'tatsu' ),
					'options' => array(
						'none' => 'None',
						'solid' => 'Solid',
						'dashed' => 'Dashed',
						'double' => 'Double',
						'dotted' => 'Dotted',
					),
					'default' => array( 'd' => 'solid', 'l' => 'solid', 't' => 'solid', 'm' => 'solid' ),
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
					'label' => __( 'Border Width', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}' => array(
							'property' => 'border-width',
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
					'att_name' => 'outer_border_color',
					'type' => 'color',
					'label' => __( 'Border Color', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}' => array(
							'property' => 'border-color',
							'when' => array(
								array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
								array( 'border', 'notempty' ),
								array( 'outer_border_style', '!=',  array( 'd' => 'none' ) ),
							),
							'relation' => 'and', 
						),
					),
				),	
			),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
						'title_content' => __('HEADING', 'oshine_modules' ),
						'border_style' => 'style2',
						'border_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
						'expand_border' => '1',
						'letter_spacing' => '2px',
						'font_size' => '13px',	        			
	        		),
	        	)
	        ),			
		);
		if( function_exists( 'tatsu_remap_modules' ) ) {
			tatsu_remap_modules(['be_special_heading6', 'tatsu_special_heading'], $controls, 'be_special_heading6');
		}else {
			tatsu_register_module( 'be_special_heading6', $controls );
		}
	} 
}