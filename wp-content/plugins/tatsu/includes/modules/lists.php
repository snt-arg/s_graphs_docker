<?php
if ( !function_exists('tatsu_lists') ) {
	function tatsu_lists( $atts, $content, $tag ) {
		$atts = shortcode_atts( array (
			'margin'				=> '',
			'style'					=> 'icon',
			'timeline'				=> '',
			'timeline_color'		=> '',
			'list_item_margin'		=> '',
			'vertical_alignment' 	=> 'none',
			'custom_border'			=> '0',
			'circled'				=> '',
			'icon_bg'				=> '',
			'icon_color'			=> '',
			'border'				=> '',
			'border_color'			=> '',
			'outer_border'			=> '',
			'outer_border_color'	=> '',
			'key'					=> be_uniqid_base36(true),
		), $atts, $tag );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$animate = ( 'none' !== $animation_type ) ? 'tatsu-animate' : '' ;
		$data_animations = be_get_animation_data_atts( $atts );
		$classes = array( 'tatsu-module', 'tatsu-list', $unique_class_name, $animate, $visibility_classes, $css_classes );

		global $tatsu_lists_style;
		if( !empty( $style ) ) {
			$tatsu_lists_style = $style;
		}else {
			$tatsu_lists_style =  '';
		}

		$lists_tag = 'number' === $style ? 'ol' : 'ul' ;

		if( !empty( $vertical_alignment ) && 'none' !== $vertical_alignment ) {
			$classes[] = 'tatsu-list-vertical-align-' . $vertical_alignment;
		}
		if( !empty( $custom_border ) ) {
			$classes[] = 'tatsu-list-bordered';
		}
		if( !empty( $style ) ) {
			$classes[] = 'tatsu-lists-' . $style;
		}
		if( !empty( $circled ) && !empty( $timeline ) ) {
			$classes[] = 'tatsu-lists-timeline';
		}
		if( !empty( $circled ) ) {
			$classes[] = 'tatsu-lists-circled';
		}

		$timeline_html = '';
		if( !empty( $circled ) && !empty( $timeline ) ) {
			$timeline_html = '<span class = "tatsu-lists-timeline-element"></span>';
		}

		$classes = implode(' ', $classes);

		return '<' . $lists_tag . ' '.$css_id.' class="' . $classes . '" '.$data_animations.'>'. $custom_style_tag . do_shortcode( $content ). $timeline_html . '</' . $lists_tag . '>';
	}
	add_shortcode( 'tatsu_lists', 'tatsu_lists' );
	add_shortcode( 'lists', 'tatsu_lists' );
}
if ( !function_exists( 'tatsu_list' ) ) {
	function tatsu_list( $atts, $content, $tag ) {
		global $be_themes_data;
		$atts = shortcode_atts( array( 
			'icon' => '',
			'circled' => '',
			'icon_bg' => '', 
			'icon_color' => '',
            'border_color'	=> '',
            'margin' => '',
			'key' => be_uniqid_base36(true),
			'outer_border_color' => '',
			'margin' => '',
		), $atts, $tag );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$animate = ( 'none' !== $animation_type ) ? 'tatsu-animate' : '' ;
		$data_animations = be_get_animation_data_atts( $atts );
		$output = '';

		global $tatsu_lists_style;

		if( 'icon' === $tatsu_lists_style && $icon != 'none' ) { 
		 	if( 1 == $circled ) {
				 $circled = 'circled';
				 $icon_markup  = '<i class="tatsu-list-icon tatsu-icon '.$icon.' '.$circled.'"></i>'; 
		 	} else {
		 		$circled = '';
		 		$icon_markup  = '<i class="tatsu-icon '.$icon.' '.$circled.'"></i>';		
		 	}
		} 
		$output .= '<li '.$css_id.' class="tatsu-list-content '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.' '.$animate.'" '.$data_animations.'>';
		if( 'icon' === $tatsu_lists_style ) {
			$output .= '<div class="tatsu-list-icon-wrap" >'.$icon_markup.'</div>';
		}
		$output .= '<div class="tatsu-list-inner">'.$content.'</div>'.$custom_style_tag.'</li>';
		return $output;
	}
	add_shortcode( 'tatsu_list', 'tatsu_list' );
	add_shortcode( 'list', 'tatsu_list' );
	
}

add_action('tatsu_register_modules', 'tatsu_register_lists', 7);
function tatsu_register_lists() {
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#lists',
		'title' => esc_html__('Lists', 'tatsu'),
		'is_js_dependant' => true,
		'child_module' => 'tatsu_list',
		'initial_children' => 5,
		'type' => 'multi',
		'is_built_in' => true,
		'group_atts'			=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					//Tab1
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							'style',
							'circled',
							'icon_bg',
							'icon_color',
							'timeline',
							'timeline_color',
							'list_item_margin',
							'vertical_alignment',
							'custom_border',
							'border',
							'border_color',
						),
					),
					//Tab2
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__( 'Border', 'tatsu'),
										'group' => array(
											'outer_border',
											'outer_border_color',
										)
									)
								),
							),	
						),
					),
				),
			),
		),
		'atts' => array(
			array(
				'att_name'		=> 'style',
				'label'			=> esc_html__('Lists Style', 'tatsu'),
				'type'			=> 'button_group',
				'is_inline' => true,
				'options'		=>  array(
					'number'	=> 'Number',
					'icon'		=> 'Icon'
				),
				'default'		=> 'icon',
				'tooltip'		=> ''
			),
			array(
				'att_name' => 'circled',
				'type' => 'switch',
				'label' => esc_html__('Circle the Icon/Number', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
			array(
				'att_name' => 'icon_bg',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Background Color if circled', 'tatsu'),
				'default' => '', //color_scheme
				'tooltip' => '',
				'visible' => array('circled', '=', '1'),
				'css'	  => true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-list-content::before, .tatsu-{UUID} .tatsu-list-icon-wrap' => array(
						'property'		=> 'background',
						'when'			=> array('circled', '=', '1'),
					)
				)
			),
			array(
				'att_name' => 'icon_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Icon/Number Color', 'tatsu'),
				'default' => 'rgba(34,147,215,1)',
				'tooltip' => '',
				'css'	  => true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-list-content::before, .tatsu-{UUID} .tatsu-icon' => array(
						'property'	=> 'color'
					)
				)
			),
			array(
				'att_name'		=> 'timeline',
				'label'			=> esc_html__('Enable Timeline', 'tatsu'),
				'type'			=> 'switch',
				'default'		=> '0',
				'visible'		=> array(
					'condition'	=> array(
						array('circled', '=', '1'),
						array('icon_bg', '!=', '')
					),
					'relation'	=> 'and',
				),
			),
			array(
				'att_name'		=> 'timeline_color',
				'label'			=> esc_html__('Timeline Color', 'tatsu'),
				'type'			=> 'color',
				'default'		=> '',
				'tooltip'		=> '',
				'visible'		=> array(
					'condition'	=> array(
						array('circled', '=', '1'),
						array('icon_bg', '!=', ''),
						array('timeline', '=', '1'),
					),
					'relation'	=> 'and',
				),
				'css'			=> true,
				'selectors'		=> array(
					'.tatsu-{UUID} .tatsu-lists-timeline-element' => array(
						'property'	=> 'background',
						'when'		=> array(
							array('circled', '=', '1'),
							array('timeline', '=', '1'),
							array('timeline', '=', '1'),
						),
						'relation'	=> 'and'
					)
				)
			),
			array(
				'att_name'		=> 'list_item_margin',
				'label'			=> esc_html__('List Item Bottom Margin', 'tatsu'),
				'type'			=> 'number',
				'options'		=> array(
					'unit'		=> 'px'
				),
				'default'		=> '12',
				'css'			=> true,
				'responsive'	=> true,
				'selectors'		=> array(
					'.tatsu-{UUID} .tatsu-list-content'		=> array(
						'property'		=> 'margin',
                        'append'		=> 'px 0px',
                        'prepend'       => '0 0 ',
						'when'			=> array('custom_border', 'empty')
					),
					'.tatsu-{UUID}.tatsu-list-bordered .tatsu-list-content'		=> array(
						'property'		=> 'padding',
						'append'		=> 'px 0',
						'when'			=> array('custom_border', 'notempty')
					)
				)
			),
			array(
				'att_name'		=> 'vertical_alignment',
				'label'			=> esc_html__('Vertical Align', 'tatsu'),
				'type'			=> 'select',
				'is_inline'     => true,
				'options'		=> array(
					'none'			=> 'None',
					'top'			=> 'Top',
					'center'		=> 'Center',
					'bottom'		=> 'Bottom'
				),
				'default'		=> 'center'
			),
			array(
				'att_name'		=> 'custom_border',
				'label'			=> esc_html__('Show divider between list items', 'tatsu'),
				'type'			=> 'switch',
				'default'		=> '0',
			),
			array(
				'att_name'		=> 'border',
				'label'			=> esc_html__('Divider Width', 'tatsu'),
				'type'			=> 'number',
				'default'		=> '0',
				'options'		=> array(
					'unit'		=> 'px'
				),
				'visible'		=> array('custom_border', '=', '1'),
				'responsive'	=> true,
				'css'			=> true,
				'selectors'		=> array(
					'.tatsu-{UUID} .tatsu-list-content' => array(
						'property'	=> 'border-bottom',
						'append'	=> 'px solid',
						'when'		=> array('custom_border', '=', '1')
					)
				)
			),
			array(
				'att_name'		=> 'border_color', // divider border
				'label'			=> esc_html__('Divider Color', 'tatsu'),
				'type'			=> 'color',
				'default'		=> '',
				'visible'		=> array('custom_border', '=', '1'),
				'css'			=> true,
				'selectors'		=> array(
					'.tatsu-{UUID} .tatsu-list-content' => array(
						'property'	=> 'border-bottom-color',
						'when'		=> array('custom_border', '=', '1')
					)
				)
			),
			array (
				'att_name' => 'border_style',
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
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'border-style',
						'when' => array(
							array( 'outer_border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'outer_border', 'notempty' ),
							array( 'border_style', '!=',  array( 'd' => 'none' ) ),
						),
						'relation' => 'and',            
					),
				),
			),
			array (
				'att_name' => 'outer_border',
				'type' => 'input_group',
				'label' => esc_html__( 'Border Width', 'tatsu' ),
				'default' => '0px 0px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'border-width',
						'when' => array( 'outer_border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
					),
				),
			),
			array (
				'att_name' => 'outer_border_color',
				'type' => 'color',
				'label' => esc_html__( 'Border Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'border-color',
						'when' => array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
					),
				),
			),

		),
	);
	tatsu_remap_modules(array('tatsu_lists', 'lists'), $controls, 'tatsu_lists');
}

add_action('tatsu_register_modules', 'tatsu_register_list', 7);
function tatsu_register_list()
{
	$controls = array(
		'icon' => '',
		'title' => esc_html__('List', 'tatsu'),
		'is_js_dependant' => false,
		'type' => 'sub_module',
		'is_built_in' => true,
		'hint' => 'content',
		'group_atts'			=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					//Tab1
					array(
						'type' => 'tab',
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
							'content'
						)
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							'icon',
							'circled',
							'icon_bg',
							'icon_color',
							'border_color',
						),
					),
					//Tab2
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__( 'Spacing', 'tatsu'),
										'group' => array(
											'margin',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__( 'Border', 'tatsu'),
										'group' => array(
											'border_style',
											'border',
											'outer_border_color',
										)
									)
								),
							),	
						),
					),
				),
			),
		),
		'atts' => array(
			array(
				'att_name' => 'icon',
				'type' => 'icon_picker',
				'label' => esc_html__('Icon', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'circled',
				'type' => 'switch',
				'label' => esc_html__('Circle the Icon', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
			array(
				'att_name' => 'icon_bg',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Background Color if circled', 'tatsu'),
				'default' => '', //color_scheme
				'tooltip' => '',
				'visible' => array('circled', '=', '1'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-list-icon-wrap,.tatsu-{UUID}.tatsu-list-content::before' => array(
						'property' => 'background',
						'when' => array(
							array('circled', '=', '1'),
							array('icon', 'notempty'),
						),
						'relation' => 'and',
					),
				),
			),
			array(
				'att_name' => 'icon_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Icon/Number Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon, .tatsu-{UUID}.tatsu-list-content::before' => array(
						'property' => 'color',
						'when' => array('icon', 'notempty'),
					),
				),
			),
			array(
				'att_name' => 'content',
				'type' => 'tinymce',
				'label' => esc_html__('Content', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name'		=> 'border_color',
				'type'			=> 'color',
				'label'		=> esc_html__('List Divider Color', 'tatsu'),
				'default'		=> '',
				'tooltip'		=> '',
				'css'			=> true,
				'selectors'	=> array(
					'.tatsu-{UUID}.tatsu-list-content'		=> array(
						'property'	=> 'border-bottom-color'
					)
				)
			),
			array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__( 'Margin', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-list-content' => array(
						'property' => 'margin',
						'when' => array( 
                            array('margin', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                            array('margin', 'notempty' ) 
                        ),
                        'relation'  => 'and',
					),
				),
			),
			array (
				'att_name' => 'border_style',
				'type' => 'select',
				'label' => esc_html__( 'Border Style', 'tatsu' ),
				'options' => array(
					'none' => 'None',
					'solid' => 'Solid',
					'dashed' => 'Dashed',
					'double' => 'Double',
					'dotted' => 'Dotted',
				),
				'default' => 'solid',
				'exclude' => array( 'tatsu_image' ),
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'border-style',
						'when' => array(
							array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border_style', '!=', 'none' ),
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
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'border-color',
						'when' => array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
					),
				),
			),

		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'content' => 'Lorem Ipsum is simply dummy text.',
					'icon' => 'icon-icon_check',
				),
			)
		),
	);
	tatsu_remap_modules(array('tatsu_list', 'list'), $controls, 'tatsu_list');
}

?>