<?php 

if (!function_exists('tatsu_text')) {
	function tatsu_text( $atts, $content, $tag ) {
		$atts = shortcode_atts( array(
			'typography' => '',
			'max_width' => 100,
			'wrap_alignment' => 'center',
			'text_alignment' => '',
	        'scroll_to_animate' => 0,
			'animate' => 0,
	        'animation_type' => 'none',
			'animation_delay' => 0,
			'margin' => '',
			'bg_color' => '',
			'border_radius' => '',
			'box_shadow' => '',
			'padding' =>'',
			'builder_mode' => '',
			'typography' => '',
			'color' => '',
			'light_color' => '',
			'dark_color' => '',
			'hide_in' => '',
			'text_typography' => '',
			'key' => be_uniqid_base36( true ),
		), $atts, $tag );
		
		extract( $atts );
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_text', $key, $builder_mode );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( isset( $animate ) && !empty( $animate ) && 'none' !== $animation_type ) ? 'tatsu-animate' : '';
		$data_animations = be_get_animation_data_atts( $atts );
	    $output = '';
		

		$margin = '';
		if(!is_numeric($max_width) || (is_numeric($max_width) &&  $max_width < 100)){
			if($wrap_alignment == 'center'){
				$margin = 'tatsu-align-center';
			}
			if($wrap_alignment == 'right'){
				$margin = 'tatsu-align-right';
			}
		}
		//rolling back Rinkesh's update. next update should be carefully checked.
		$output .= '<div '.$css_id.' class="tatsu-module tatsu-text-block-wrap '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.'"><div class="tatsu-text-inner '.$margin.' '.$animate.' clearfix" '.$data_animations.'>';
		$output .= $custom_style_tag;
		$output .= do_shortcode( $content );
		$output .= '</div></div>';
		
	    return $output;
	}
	add_shortcode( 'tatsu_text', 'tatsu_text' );
	add_shortcode( 'text', 'tatsu_text' );
}

if( !function_exists( 'tatsu_text_header_atts' ) ) {
	function tatsu_text_header_atts( $atts, $tag ) {
		if( 'tatsu_text' === $tag ) {
			// New Atts
			$atts['builder_mode'] = array (
				'type' => '',
				'default' => 'Header',
			);
			$atts['hide_in'] = array (
				'type' => 'screen_visibility',
				'label' => esc_html__( 'Hide in', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
			);
			// Light Scheme Colors
			$atts['light_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Color', 'tatsu' ),
				'default' => '#f5f5f5', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-text-inner' => array(
						'property' => 'color',
						'append' => ' !important'
					),
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-text-inner *' => array(
						'property' => 'color',
						'append' => ' !important'
					),
				),
			);
			// Dark Scheme Colors
			$atts['dark_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Color', 'tatsu' ),
				'default' => '#232425', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-text-inner' => array(
						'property' => 'color',
						'append' => ' !important'
					),
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-text-inner *' => array(
						'property' => 'color',
						'append' => ' !important'
					),
				),
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
					'.tatsu-{UUID}.tatsu-text-block-wrap' => array(
						'property' => 'margin',
					),
				),
			);
			// Remove Atts
		}
		return $atts;
	}
	add_filter( 'tatsu_header_modify_atts', 'tatsu_text_header_atts', 10, 2 );
}


add_action('tatsu_register_header_modules', 'tatsu_register_text', 9);
add_action('tatsu_register_modules', 'tatsu_register_text', 1);
function tatsu_register_text()
{
	$controls =  array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#text',
		'title' => esc_html__('Text Block', 'tatsu'),
		'is_js_dependant' => true,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => true,
		'hint' => 'content',
		'is_dynamic' => true,
		//Tab1
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
							array(
								'type' => 'accordion',
								'active' => 'none',
								'group' => array(
									'content',
								)
							)
						)
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(
									array(
										'type'		=> 'panel',
										'title'		=> esc_html__('Width and Alignment', 'tatsu'),
										'group'		=> array(
											'max_width',
											array(
												'type'		=> 'tab',
												'title'		=> esc_html__('Wrap Alignment', 'tatsu'),
												'group'		=> array(
													'wrap_alignment',
												),
											),
											array(
												'type'		=> 'tab',
												'title'		=> esc_html__('Text Alignment', 'tatsu'),
												'group'		=> array(
													'text_alignment',
												),
											),
										),
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Colors', 'tatsu'),
										'group' => array(
											'color',
											'bg_color',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Light Scheme Colors', 'tatsu'),
										'group' => array(
											'light_color'
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Dark Scheme Colors', 'tatsu'),
										'group' => array(
											'dark_color'
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Typography', 'tatsu'),
										'group' => array(
											'text_typography'
										)
									),
								)
							),
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
											'padding',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Border', 'tatsu'),
										'group' => array(
											'border_style',
											'border',
											'border_color',
											'border_radius',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Shadow', 'tatsu'),
										'group' => array(
											'box_shadow',
										)
									),

								)
							),
							'hide_in'
						)
					)
				)
			)
		),
		'atts' => array(
			array(
				'att_name' => 'content',
				'type' => 'tinymce',
				'label' => esc_html__('Content', 'tatsu'),
				'default' => '',
				'tooltip' => ''
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
					'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
						'property' => 'background-color',
					),
				),
			),
			array(
				'att_name' => 'color',
				'type' => 'color',
				'label' => esc_html__( 'Text Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-text-inner *' => array(
						'property' => 'color'
					),					
					'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
						'property' => 'color'
					),
				),
			),
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
					'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
						'property' => 'width',
						'append' => '%'
					)
				),

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
					'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
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
					'.tatsu-{UUID}.tatsu-text-block-wrap' => array(
						'property' => 'margin',
						'when' => array('margin', '!=', array('d' => '0px 0px 30px 0px')),
					),
				),
			),
			array(
				'att_name' => 'box_shadow',
				'type' => 'input_box_shadow',
				'label' => esc_html__('Shadow', 'tatsu'),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
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
					'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
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
					'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
						'property' => 'border-style',
						'when' => array(
							array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', 'notempty' ),
							array( 'border_style', '!=', array( 'd' => 'none' ) ),
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
					'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
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
					'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
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
					'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
						'property' => 'border-radius',
						'when' => array('border_radius', '!=', '0px'),
					),
				),
				'tooltip' => 'Use this to give border radius',
			),
			array(
				'att_name' => 'text_typography',
				'type' => 'typography',
				'label' => esc_html__( 'Typography', 'tatsu' ),
				'responsive' => true,
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'is_inline' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner *' => array(
						'property' => 'typography',
					)
				),
			),	
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'content' => '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>',
				),
			)
		),
	);
	tatsu_remap_modules(array('tatsu_text', 'text'), $controls, 'tatsu_text');
	tatsu_register_header_module('tatsu_text', $controls, 'tatsu_text');
}

?>