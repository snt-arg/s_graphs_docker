<?php

if ( ! function_exists( 'tatsu_typed_text' ) ) {
	function tatsu_typed_text( $atts, $content, $tag ) {
		$atts = shortcode_atts( array(
	        'prefix_text' => '',
            'rotated_text' => '',
            'suffix_text' => '',
            'rotated_text_color' => '#dedede',
			'prefix_suffix_color' => '#dedede',
			'cursor_color'	=> '',
			'tag_to_use' => '',
			'typed_text_font' => '',
			'loop' => '1',
            'alignment' => 'left',
			'margin'	=> '0 0 30px 0',
			'animate' => '',
			'key' => be_uniqid_base36(true),
		),$atts, $tag );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_typed_text', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];
		extract($atts);

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 

		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }

		if( !empty( $prefix_text ) ) {
			$prefix_text = "$prefix_text ";
		}
		if( !empty( $suffix_text ) )  {
			$suffix_text = " $suffix_text";
		}
		$text_to_use_class = '';
		if( !empty( $typed_text_font ) ) {
			$text_to_use_class = ' ' . $typed_text_font;
		}
		if( !empty( $loop ) ){
			$loop = '1';
		}
		$output = '';
		$output .= '<'. $tag_to_use .' '.$css_id.' class=" tatsu-module tatsu-typed-text-wrap ' . $custom_class_name . $text_to_use_class . ' '.$visibility_classes.' '.$css_classes.' " data-rotate-text="'.$rotated_text.'" data-loop-text="'.$loop.'" data-typed-text-id="tatsu-typed-text'.$key.'" '.$data_animations.' >';
		$output .= $custom_style_tag;
        $output .= $prefix_text; 
		$output .= '<span id="tatsu-typed-text'.$key.'" class ="tatsu-typed-rotated-text"></span>';
		$output .= '<span class = "tatsu-typed-text-cursor">|</span>';
        $output .= $suffix_text; 
		$output .= '</'. $tag_to_use .'>';
		return $output;
	}
	add_shortcode( 'tatsu_typed_text', 'tatsu_typed_text' );
}

if (!function_exists('tatsu_register_typed_text')) {
	add_action('tatsu_register_modules', 'tatsu_register_typed_text');
	function tatsu_register_typed_text()
	{
		$controls = array(
			'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#typed_text',
			'title' => esc_html__('Typed text', 'tatsu'),
			'is_js_dependant' => false,
			'child_module' => '',
			'type' => 'single',
			'is_built_in' => true,
			'hint' => 'prefix_text',
			'group_atts' => array(
				array(
					'type'		=> 'tabs',
					'style'		=> 'style1',
					'group'		=> array(
						array(
							'type' => 'tab',
							'title' => esc_html__('Content', 'tatsu'),
							'group'	=> array(
								'rotated_text',
								'prefix_text',
								'suffix_text',
							)
						),
						array(
							'type' => 'tab',
							'title' => esc_html__('Style', 'tatsu'),
							'group'	=> array(
								'tag_to_use',
								'alignment',
								'loop',
								'typed_text_font',
								'rotated_text_color',
								'prefix_suffix_color',
								'cursor_color'
							)
						),
						array(
							'type' => 'tab',
							'title' => esc_html__('Advanced', 'tatsu'),
							'group'	=> array(
								array(
									'type' => 'accordion',
									'group' => array(
										array(
											'type' => 'panel',
											'title' => esc_html__('Spacing', 'tatsu'),
											'group' => array(
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
			'atts' => array_values(array_filter(array(
				array(
					'att_name' => 'prefix_text',
					'type' => 'text_area',
					'label' => esc_html__('Prefix Text', 'tatsu'),
					'default' => 'Prefix text',
					'tooltip' => ''
				),
				array(
					'att_name' => 'rotated_text',
					'type' => 'text_area',
					'options' => array(
						'placeholder' => 'Separate words by comma'
					),
					'label' => esc_html__('Rotating Text', 'tatsu'),
					'default' => '',
					'tooltip' => ''
				),
				array(
					'att_name' => 'suffix_text',
					'type' => 'text_area',
					'label' => esc_html__('Suffix Text', 'tatsu'),
					'default' => '',
					'tooltip' => ''
				),

				array(
					'att_name' => 'tag_to_use',
					'type' => 'select',
					'label' => esc_html__('Tag to use', 'tatsu'),
					'options' => array(
						'h1' => 'h1',
						'h2' => 'h2',
						'h3' => 'h3',
						'h4' => 'h4',
						'h5' => 'h5',
						'h6' => 'h6',
						'p' => 'p',
						'span' => 'span',
						'div' => 'div',
					),
					'default' => 'div',
					'tooltip' => '',
				),

				function_exists('typehub_get_exposed_selectors') ? array(
					'att_name'	=> 'typed_text_font',
					'type'		=> 'select',
					'label'		=> esc_html__('Font', 'tatsu'),
					'default'	=> 'h1',
					'options'	=> typehub_get_exposed_selectors()
				) : false,
				array(
					'att_name' => 'rotated_text_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true
					),
					'label' => esc_html__('Rotated Text Color', 'tatsu'),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-typed-rotated-text' => array(
							'property' => 'color',
						),
					),
				),
				array(
					'att_name' => 'prefix_suffix_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true
					),
					'label' => esc_html__('Prefix and Suffix Color', 'tatsu'),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-typed-text-wrap' => array(
							'property' => 'color',
						),
					),
				),
				array(
					'att_name' => 'cursor_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true
					),
					'label' => esc_html__('Cursor Color', 'tatsu'),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-typed-text-cursor' => array(
							'property' => 'color',
						),
					),
				),
				array(
					'att_name'		=> 'loop',
					'type'			=> 'switch',
					'label'			=> esc_html__('Loop', 'tatsu'),
					'default'		=> '1',
					'tooltip'		=> '',
				),
				array(
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => esc_html__('Margin', 'tatsu'),
					'default' => '0px 0px 30px 0px',
					'tooltip' => '',
					'css' => true,
					'responsive' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-typed-text-wrap' => array(
							'property' => 'margin',
						),
					),
				),
				array (
					'att_name'  => 'alignment',
					'label' => esc_html__('Alignment', 'tatsu'),
					'is_inline' => true,
					'type'  => 'button_group',
					'options'   => array (
						'left'  => 'Left',
						'center'  => 'Center',
						'right' => 'Right',
					),
					'default'  => 'left',
					'css'  => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-typed-text-wrap' => array(
							'property' => 'text-align',
						),
					),
				),
			))),
			'presets' => array(
				'default' => array(
					'title' => '',
					'image' => '',
					'preset' => array(
						'prefix_text'	=> 'Tatsu is a',
						'rotated_text'	=> 'Simple, Powerful, Intuitive, Fully Visual',
						'suffix_text'	=> 'Builder',
						'rotated_text_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					),
				)
			),
		);
		tatsu_register_module('tatsu_typed_text', $controls);
	}
}

?>