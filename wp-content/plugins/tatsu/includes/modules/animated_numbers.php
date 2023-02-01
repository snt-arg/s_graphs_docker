<?php
if (!function_exists('tatsu_animated_numbers')) {
	function tatsu_animated_numbers( $atts, $content, $tag ) {
		$atts = shortcode_atts( array(
			'number' => '',
			'prefix' => '',
			'suffix' => '',
			'prefix_size' => '30',
			'suffix_size'  => '30',
			'prefix_color'	=> '#141414',
			'suffix_color'	=> '#141414',	
			'caption' => '',
	        'number_size' => '45',
            'animate'           => 0,
	        'number_color' => '#141414',
	        'caption_size' => '13',
	        'caption_color' => '#141414',
	        'alignment' => 'center',
			'key' => be_uniqid_base36(true),
		), $atts, $tag );
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_animated_numbers', $key );
		$unique_class_name = 'tatsu-'.$key;

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '' ;
		$data_animations = be_get_animation_data_atts( $atts );

		$output = '';
		$output = '<div '.$css_id.' class="tatsu-module tatsu-an-wrap align-'.$alignment.' '.$unique_class_name.' '.$visibility_classes.' '.$animate .' " '.$data_animations.' >';
		$output .= $custom_style_tag;
		$output .= '<div class = "tatsu-an-prefix-suffix-wrap">';
		if( '' !== $prefix ) {
			$output .= '<div class = "tatsu-an-prefix">';
			$output .= tatsu_parse_custom_fields( $prefix );
			$output .= '</div>';
		}

		$output .= '<div class="tatsu-an animate" data-number="' . tatsu_parse_custom_fields( $number ) . '"></div>';
		if( '' !== $suffix ) {
			$output .= '<div class = "tatsu-an-suffix">';
			$output .= tatsu_parse_custom_fields( $suffix );
			$output .= '</div>';
		}
		$output .= '</div>';
		if( '' !== $caption ) {
			$output .= '<h6><span class="tatsu-an-caption" >' . tatsu_parse_custom_fields( $caption ) . '</span></h6>';
		}
		$output .= '</div>';
		
		return $output;
	}
	add_shortcode( 'tatsu_animated_numbers', 'tatsu_animated_numbers' );
	add_shortcode( 'animated_numbers', 'tatsu_animated_numbers' );
}


add_action('tatsu_register_modules', 'tatsu_register_animated_numbers', 9);
function tatsu_register_animated_numbers()
{
	$controls =  array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#animated_numbers',
		'title' => esc_html__('Animated Numbers', 'tatsu'),
		'is_js_dependant' => true,
		'type' => 'single',
		'is_built_in' => true,
		'hint' => 'caption',
		'should_destroy' => true,
		'is_dynamic' => true,
		//Tab1
		'group_atts'			=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
							array( //Tab1
								'type' => 'accordion',
								'active' => 'none',
								'group' => array(
									'number',
									'caption',
									'prefix',
									'suffix',
								)
							)
						)
					),
					array( //Tab2
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => 'none',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Font Sizes', 'tatsu'),
										'group' => array(
											'number_size',
											'caption_size',
											'prefix_size',
											'suffix_size',
										)
									),
									array(
										'type' => 'accordion',
										'active' => 'none',
										'group' => array(
											array(
												'type' => 'panel',
												'title' => esc_html__('Colors', 'tatsu'),
												'group' => array(
													'number_color',
													'caption_color',
													'prefix_color',
													'suffix_color',
												)
											),
										),
									),
									'alignment',
								),
							),
						),
					),
					//Tab3
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
				'att_name' => 'number',
				'type' => 'text',
				'label' => esc_html__('Number', 'tatsu'),
				'tooltip' => ''
			),
			array(
				'att_name' => 'caption',
				'type' => 'text',
				'label' => esc_html__('Caption', 'tatsu'),
				'tooltip' => ''
			),
			array(
				'att_name' => 'prefix',
				'type' => 'text',
				'label' => esc_html__('Prefix', 'tatsu'),
				'tooltip' => ''
			),
			array(
				'att_name' => 'suffix',
				'type' => 'text',
				'label' => esc_html__('Suffix', 'tatsu'),
				'tooltip' => ''
			),
			array(
				'att_name' => 'number_size',
				'type' => 'number',
				'options' => array(
					'unit' => 'px',
				),
				'label' => esc_html__('Number', 'tatsu'),
				'tooltip' => '',
				'css' => true,
				'is_inline' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-an' => array(
						'property' => 'font-size',
						'append' => 'px',
					),
				),
			),
			array(
				'att_name' => 'caption_size',
				'type' => 'number',
				'options' => array(
					'unit' => 'px',
				),
				'label' => esc_html__('Caption', 'tatsu'),
				'tooltip' => '',
				'css' => true,
				'is_inline' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-an-caption' => array(
						'property' => 'font-size',
						'append' => 'px',
					),
				),
			),
			array(
				'att_name'	=> 'prefix_size',
				'type' => 'number',
				'options' => array(
					'unit' => 'px',
				),
				'label' => esc_html__('Prefix', 'tatsu'),
				'tooltip' => '',
				'css'	=> true,
				'is_inline' => true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-an-prefix' => array(
						'property'		=> 'font-size',
						'append'		=> 'px',
					)
				)
			),
			array(
				'att_name'	=> 'suffix_size',
				'type' => 'number',
				'options' => array(
					'unit' => 'px',
				),
				'label' => esc_html__('Suffix', 'tatsu'),
				'tooltip' => '',
				'css'	=> true,
				'is_inline' => true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-an-suffix' => array(
						'property'		=> 'font-size',
						'append'		=> 'px',
					)
				)
			),
			array(
				'att_name' => 'number_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Number', 'tatsu'),
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-an' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'caption_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Caption', 'tatsu'),
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-an-caption' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'prefix_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Prefix', 'tatsu'),
				'tooltip' => '',
				'css'	=> true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-an-prefix' => array(
						'property'		=> 'color',
					),
				),
			),
			array(
				'att_name' => 'suffix_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Suffix', 'tatsu'),
				'tooltip' => '',
				'css'	=> true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-an-suffix' => array(
						'property'		=> 'color',
					),
				),
			),
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
				'is_inline' => true,
				'tooltip' => ''
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'number' => '27',
					'caption' => 'Demos',
					'number_size' => '45',
					'caption_size' => '13',
					'prefix_size' => '15',
					'suffix_size' => '15',
					'number_color' => '#141414',
					'caption_color' => '#141414',
				),
			)
		),
	);
	tatsu_register_module('tatsu_animated_numbers', $controls);
}

?>