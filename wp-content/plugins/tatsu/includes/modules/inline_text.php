<?php 
if ( !function_exists( 'tatsu_inline_text' ) ) {
	function tatsu_inline_text( $atts, $content, $tag ) {
		extract( shortcode_atts( array (
            'margin' => '0',
			'animate' => '0',
			'animation_type' => 'none',
			'animation_delay' => '0',
			'max_width' => 100,
			'wrap_alignment' => 'center',
			'text_alignment' => '',
			'border_radius' => '',
			'box_shadow' => '',
			'padding' =>'',
			'bg_color' => '',
			'builder_mode' => '',
			'typography' => '',
			'key' => be_uniqid_base36(true),  
		),$atts, $tag ) );
		

		extract($atts);
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_inline_text', $key, $builder_mode );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 

		$animate = ( isset( $animate ) && !empty( $animate ) && 'none' !== $animation_type ) ? 'tatsu-animate' : '';  //1 : 0;
		$data_animations = be_get_animation_data_atts( $atts );
		$inner_margin = ''; //'margin-right:auto; margin-left:auto;';
		if(!is_numeric($max_width) || (is_numeric($max_width) &&  $max_width < 100)){
			if( $wrap_alignment == 'center' ){
				$inner_margin = 'tatsu-align-center';
			}
			if( $wrap_alignment == 'right' ){
				$inner_margin = 'tatsu-align-right';
			}
		}
			    

	    $output = '';
		$output .= '<div '.$css_id.' class="tatsu-module tatsu-inline-text clearfix '. $unique_class_name.' '.$visibility_classes.' '.$css_classes.' '.$animate.'" '.$data_animations.'>';
		$output .= $custom_style_tag;
		$output .= '<div class="tatsu-inline-text-inner '.$inner_margin.'">';
		$output .= do_shortcode( $content );
		$output .= '</div>';
		$output .= '</div>';
	    return $output;
	}
	add_shortcode( 'tatsu_inline_text', 'tatsu_inline_text' );
}

if( !function_exists( 'tatsu_inline_text_header_atts' ) ) {
	function tatsu_inline_text_header_atts( $atts, $tag ) {
		if( 'tatsu_inline_text' === $tag ) {
			// New Atts
			$atts['builder_mode'] = array (
				'type' => '',
				'default' => 'Header',
			);
			// Modify Atts
			$atts['margin'] = 	array (
				'type' => 'input_group',
				'label' => esc_html__( 'Margin', 'tatsu' ),
				'default' => '0px 30px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-inline-text' => array(
						'property' => 'margin',
					),
				),
			);
			// Remove Atts

		}
		return $atts;
	}
	add_filter( 'tatsu_header_modify_atts', 'tatsu_inline_text_header_atts', 10, 2 );
}

add_action('tatsu_register_modules', 'tatsu_register_inline_text', 2);
function tatsu_register_inline_text()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#inline_text',
		'title' => esc_html__('Inline Text', 'tatsu'),
		'is_js_dependant' => false,
		'type' => 'single',
		'is_built_in' => true,
		'drag_handle' => false,
		'hint' => 'content',
		'group_atts' => array(
			array(
				'type'	=>	'tabs',
				'style'	=>	'style1',
				'group'	=>	array(
					array(
						'type'	=>	'tab',
						'title'	=>	esc_html__('Style', 'tatsu'),
						'group'	=>	array(
							array(
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Width and Alignment', 'tatsu'),
										'group' => array(
											'max_width',
											'wrap_alignment',
											'text_alignment',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Colors', 'tatsu'),
										'group' => array(
											'bg_color',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Typography', 'tatsu'),
										'group' => array(
											'typography'
										)
									),
								)
							)
						),
					),
					array(
						'type'	=>	'tab',
						'title'	=>	esc_html__('Advanced', 'tatsu'),
						'group'	=>	array(
							array(
								'type' => 'accordion',
								'active' => array(0),
								'group' => array(
									array(
										'type'	=>	'panel',
										'title'	=>	esc_html__('Spacing', 'tatsu'),
										'group'	=>	array(
											'margin',
											'padding'
										)
									),
									array(
										'type'	=>	'panel',
										'title'	=>	esc_html__('Border', 'tatsu'),
										'group'	=>	array(
											'border_style',
											'border',
											'border_color',
											'border_radius',
										)
									),
									array(
										'type'	=>	'panel',
										'title'	=>	esc_html__('Shadow', 'tatsu'),
										'group'	=>	array(
											'box_shadow',
										)
									),
								)
							),
						)
					),
				)
			),
		),

		'atts' => array(
			array(
				'att_name' => 'max_width',
				'type' => 'slider',
				'label' => esc_html__('Content Width', 'tatsu'),
				'options' => array(
					'min' => '0',
					'max' => '100',
					'step' => '1',
					'unit' => '%',
				),
				'default' => '100',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-inline-text-inner' => array(
						'property' => 'width',
						'append' => '%'
					)
				),
			),
			array(
				'att_name' => 'content',
				'type' => 'text',
				'label' => 'Content',
				'default' => "",
				'tooltip' => '',
				'visible' => array('margin', '==', '-100')
			),
			array(
				'att_name' => 'wrap_alignment',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Wrap Align', 'tatsu'),
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
				),
				'default' => 'center',
				'tooltip' => '',
			),
			array(
				'att_name' => 'text_alignment',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Text Align', 'tatsu'),
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right'
				),
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-inline-text-inner' => array(
						'property' => 'text-align',
					),
				),
				'default' => 'left',
				'tooltip' => ''
			),
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '0px 0px 30px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-inline-text' => array(
						'property' => 'margin',
						'when' => array('margin', '!=', array('d' => '0px 0px 30px 0px')),
					),
				),
			),
			array(
				'att_name' => 'bg_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-inline-text-inner' => array(
						'property' => 'background-color',
					),
				),
			),
			array(
				'att_name' => 'typography',
				'type' => 'typography',
				'label' => esc_html__( 'Typography', 'tatsu' ),
				'responsive' => true,
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'is_inline' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-inline-text .tatsu-inline-text-inner *' => array(
						'property' => 'typography',
					)
				),
			),
			array(
				'att_name' => 'box_shadow',
				'type' => 'input_box_shadow',
				'label' => esc_html__('Shadow Value', 'tatsu'),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-inline-text-inner' => array(
						'property' => 'box-shadow',
						'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
					),
				),
			),
			array(
				'att_name' => 'padding',
				'type' => 'input_group',
				'label' => esc_html__('Padding', 'tatsu'),
				'default' => '0px 0px 0px 0px',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-inline-text-inner' => array(
						'property' => 'padding',
						'when' => array('padding', '!=', array('d' => '0px 0px 0px 0px')),
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
				'default' => array( 'd' => 'solid', 'l' => 'solid', 't' => 'solid', 'm' => 'solid' ),
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-inline-text-inner' => array(
						'property' => 'border-style',
						'when' => array(
							array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', 'notempty' ),
							array( 'border_style', '!=',  array( 'd' => 'none' ) ),
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
					'.tatsu-{UUID} .tatsu-inline-text-inner' => array(
						'property' => 'border-width',
						'when' => array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
					),
				),
			),
			array (
				'att_name' => 'border_color',
				'type' => 'color',
				'label' => esc_html__( 'Border Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-inline-text-inner' => array(
						'property' => 'border-color',
						'when' => array('border', '!=', '0px 0px 0px 0px'),
					),
				),
			),
			array(
				'att_name' => 'border_radius',
				'type' => 'number',
				'label' => esc_html__('Border Radius', 'tatsu'),
				'options' => array(
					'unit' => 'px',
					'add_unit_to_value' => true,
				),
				'default' => '0',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-inline-text-inner' => array(
						'property' => 'border-radius',
						'when' => array('border_radius', '!=', '0px')
					),
				),
				'tooltip' => 'Use this to give border radius',
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
					'max_width'	=> array('d' => '100', 'm'	=> '100'),
				),
			)
		),
	);
	tatsu_register_module('tatsu_inline_text', $controls);
}

?>