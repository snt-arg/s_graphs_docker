<?php
if (!function_exists('tatsu_animated_link')) {
    function tatsu_animated_link( $atts, $content, $tag ) {
        $atts = shortcode_atts( array (
            'link_text' => '',
			'url' => '',
			'new_tab' => '',
            'custom_font_size'  => '0',
            'font_size' => '13',
            'link_style' => 'style1',
			'alignment' => '',
			'color'=> '',
			'hover_color'=> '',
			'line_color'=> '',
            'line_hover_color' => '',
            'margin'        => '',
			'animate' => 0,
			'animation_type' => 'none',
			'animation_delay' => 0,
			'key' => be_uniqid_base36(true),
		), $atts, $tag );
        
		extract( $atts );

		$custom_style_tag  = be_generate_css_from_atts( $atts, 'tatsu_animated_link', $atts['key'] );
		$unique_class_name = ' tatsu-'.$atts['key'];
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : ''; 
		$data_animations = be_get_animation_data_atts( $atts );
        $link_text_font = !empty( $link_text_font ) ? ( ' ' . $link_text_font ) : '';

		$output = '';
		
		$new_tab = !empty( $new_tab ) ? 'target = "_blank"' : '';
		
		$output .= '<div '.$css_id.' class="tatsu-animated-link tatsu-animated-link-'. $link_style . ' ' .$unique_class_name. ' tatsu-module tatsu-animated-link-align-'. $alignment .' '.$css_classes.' '.$visibility_classes.'"><a class = "tatsu-animated-link-inner '. $animate . $link_text_font . '" href = "'. tatsu_parse_custom_fields( $url ) .'" ' . $new_tab . ' '.$data_animations.' aria-label = "'.$link_text.'">';
		$output .= '<span class = "tatsu-animated-link-text"  >'.tatsu_parse_custom_fields( $link_text ) .'</span>';
        if( $link_style == 'style4' ){
			$output .= '<span class = "tatsu-animated-link-arrow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25px" height="15px" viewBox="0 0 30 18" enable-background="new 0 0 30 18" xml:space="preserve">
			<path class="tatsu-svg-arrow-head" d="M20.305,16.212c-0.407,0.409-0.407,1.071,0,1.479s1.068,0.408,1.476,0l7.914-7.952c0.408-0.409,0.408-1.071,0-1.481
				l-7.914-7.952c-0.407-0.409-1.068-0.409-1.476,0s-0.407,1.071,0,1.48l7.185,7.221L20.305,16.212z"></path>
			<path class="tatsu-svg-arrow-bar" fill-rule="evenodd" clip-rule="evenodd" d="M1,8h28.001c0.551,0,1,0.448,1,1c0,0.553-0.449,1-1,1H1c-0.553,0-1-0.447-1-1
				C0,8.448,0.447,8,1,8z"></path>
			</svg></span>';
		}
		$output .= '</a>';
		$output .= $custom_style_tag;
		$output .= '</div>';
		
		return $output;
	}
}

add_filter( 'exp_animated_link_before_css_generation', 'exp_animated_link_css1' );
function exp_animated_link_css1($atts) {
	if( empty( $atts['hover_color'] ) ) {
		$atts['hover_color'] = $atts['color'];
	}
	if( empty( $atts['line_color'] ) ) {
		$atts['line_color'] = $atts['color'];
	}
	if( empty( $atts['line_hover_color'] ) ) {
		$atts['line_hover_color'] = $atts['hover_color'];
	}
	return $atts;
}

add_action('tatsu_register_modules', 'tatsu_register_animated_link', 6);
function tatsu_register_animated_link()
{
	$controls  =  array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#animated_link',
		'title' => esc_html__('Animated Link', 'tatsu'),
		'is_js_dependant' => false,
		'type' => 'single',
		'is_built_in' => true,
		'hint' => 'link_text',
		'is_dynamic' => true,
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
							'link_text',
							'url',
							'new_tab',
						),
					),

					//Tab2
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							'link_style',
							'alignment',
							array(
								'type' => 'accordion',
								'active' => array(0),
								'group' => array(
									array(
										'type'  => 'panel',
										'title' => esc_html__('Colors', 'tatsu'),
										'group' => array(
											array(
												'type' => 'tabs',
												'style' => 'style1',
												'group'	=> array(
													array (
														'type' => 'tab',
														'title' => esc_html__('Normal', 'tatsu'),
														'group' => array(
															'color',
															'line_color',
														)
													),
													array (
														'type' => 'tab',
														'title' => esc_html__('Hover', 'tatsu'),
														'group' => array(
															'hover_color',
															'line_hover_color',
														)
													)		
												)
											),
										)
									),
									'custom_font_size',
									'font_size',
								)
							)
						)
					),

					array( //Tab3
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'group' => array(
									array(
										'type'  => 'panel',
										'title' => esc_html__('Spacing', 'tatsu'),
										'group'	=> array(
											'margin',
										)
									),
								)
							)
						)
					)
				)
			)
		),


		'atts' => array(
			array(
				'att_name' => 'link_text',
				'type' => 'text',
				'label' => esc_html__('Link Text', 'tatsu'),
				'is_inline' => false,
				'default' => 'Learn More',
				'tooltip' => ''
			),
			array(
				'att_name' => 'link_style',
				'type' => 'select',
				'is_inline' => true,
				'label' => esc_html__('Style', 'tatsu'),
				'options' => array(
					'style1' => 'Style 1',
					'style2' => 'Style 2',
					'style3' => 'Style 3',
					'style4' => 'Style 4',
				),
				'default' => 'style4',
				'tooltip' => ''
			),
			array(
				'att_name' => 'url',
				'type' => 'text',
				'label' => esc_html__('Link URL', 'tatsu'),
				'is_inline' => false,
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'new_tab',
				'type' => 'switch',
				'label' => esc_html__('Open in a new tab', 'tatsu'),
				'default' => '0',
				'tooltip' => '',
				'visible' => array('url', '!=', ''),
			),
			array(
				'att_name' => 'custom_font_size',
				'type' => 'switch',
				'label' => esc_html__('Custom Font Size', 'tatsu'),
				'default' => '0',
				'tooltip' => ''
			),
			array(
				'att_name' => 'font_size',
				'type' => 'number',
				'is_inline' => true,
				'label' => esc_html__('Font Size', 'tatsu'),
				'options' => array(
					'unit' => 'px',
				),
				'default' => '13',
				'tooltip' => '',
				'css' => true,
				'visible'	=> array('custom_font_size', '=', '1'),
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-animated-link-inner' => array(
						'property' => 'font-size',
						'append' => 'px',
						'when'	 => array('custom_font_size', '=', '1')
					),
				),
			),
			array(
				'att_name' => 'alignment',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Align', 'tatsu'),
				'options' => array(
					'none' 	=> 'None',
					'left' 	=> 'Left',
					'center' 	=> 'Center',
					'right' 	=> 'Right'
				),
				'default' => 'none',
				'tooltip' => ''
			),
			array(
				'att_name' => 'color',
				'type' => 'color',
				'label' => esc_html__('Text Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-animated-link-inner' => array(
						'property' => 'color'
					),
				),
			),
			array(
				'att_name' => 'hover_color',
				'type' => 'color',
				'label' => esc_html__('Hover Text Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-animated-link-inner:hover' => array(
						'property' => 'color',
						'when'	   => array('link_style', '!=', 'style2')
					),
					'.tatsu-{UUID} .tatsu-animated-link-inner::after' => array(
						'property'	=> 'color',
						'when'		=> array('link_style', '=', 'style2')
					),
					'.tatsu-{UUID} .tatsu-animated-link-inner:hover .tatsu-animated-link-text' => array(
						'property'	=> 'color',
						'when'		=> array('link_style', '=', 'style2')
					)
				),
			),
			array(
				'att_name' => 'line_color',
				'type' => 'color',
				'label' => esc_html__('Line/Arrow Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-animated-link-arrow' => array(
						'property' => 'color',
						'when'	  => array('link_style', '=', 'style4')
					),
					'.tatsu-{UUID} .tatsu-animated-link-inner::before' => array(
						'property'	=> 'color',
						'when'	  => array('link_style', '!=', 'style4')
					),
				),
			),
			array(
				'att_name' => 'line_hover_color',
				'type' => 'color',
				'label' => esc_html__('Line/Arrow Hover Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-animated-link-inner:hover .tatsu-animated-link-arrow' => array(
						'property' => 'color',
						'when'	  => array('link_style', '=', 'style4')
					),
					'.tatsu-{UUID} .tatsu-animated-link-inner:hover::before' => array(
						'property'	=> 'color',
						'when'	  => array(
							array('link_style', '=', 'style3'),
							array('link_style', '=', 'style1')
						),
						'relation'	=> 'or',
					),
					'.tatsu-{UUID} .tatsu-animated-link-inner::after' => array(
						'property'	=> 'color',
						'when'		=> array('link_style', '=', 'style2')
					)
				),
			),
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '0px 0px 40px 0px',
				'tooltip' => '',
				'css'	  => true,
				'responsive'	=> true,
				'selectors'	=> array(
					'.tatsu-{UUID}.tatsu-module'	=> array(
						'property'		=> 'margin',
					)
				)
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'link_text' => 'Learn More',
					'color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'hover_color' => array('id' => 'palette:2', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
					'line_hover_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
				),
			)
		),
	);
	tatsu_remap_modules(array('tatsu_animated_link', 'oshine_animated_link'), $controls, 'tatsu_animated_link');
}

?>