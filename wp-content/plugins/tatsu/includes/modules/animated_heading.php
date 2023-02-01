<?php
if ( ! function_exists( 'tatsu_animated_heading' ) ) {
	function tatsu_animated_heading( $atts , $content, $tag ) {
		$atts = shortcode_atts( array(
            'alignment' => 'left',
            'text'      => '',
            'anime_type' => '',
			'tag_to_use'=> 'h1',
			'text_color' => '',
			'line_color' => '',
			'typography' => '',
			'anime_duration' => '25',
			'key'       => be_uniqid_base36(true),
        ),$atts , $tag );
		extract($atts);
        
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_animated_heading', $key );
		$custom_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$data_animations = be_get_animation_data_atts( $atts );
		$effect_markup = '';

		switch( $anime_type ){
			case 'anime_top_bottom_lines':
				$effect_markup  = '<div class="tatsu-animated-heading-inner-wrap" >';
				$effect_markup .= '<span class="tatsu-animated-heading-line tatsu-animated-heading-line1"></span>';
				$effect_markup .= '<'.$tag_to_use.' class="tatsu-animated-heading-inner">';
				$effect_markup .= tatsu_parse_custom_fields( $text );
				$effect_markup .= '</'.$tag_to_use.'>';
				$effect_markup .= '<span class="tatsu-animated-heading-line tatsu-animated-heading-line2"></span>';
				$effect_markup .= '</div>';
				break;
			case 'anime_slide_cursor' :
			case 'anime_slide_underline' :
				$effect_markup  = '<div class="tatsu-animated-heading-inner-wrap" >';
				$effect_markup  .= '<'.$tag_to_use.' class="tatsu-animated-heading-inner">';
				$effect_markup .= tatsu_parse_custom_fields( $text );
				$effect_markup .= '</'.$tag_to_use.'>';
				$effect_markup .= '<span class="tatsu-animated-heading-line tatsu-animated-heading-line2"></span>';
				$effect_markup .= '</div>';
				break;
			default :
				$effect_markup  = '<'.$tag_to_use.' class="tatsu-animated-heading-inner">';
				$effect_markup .= tatsu_parse_custom_fields( $text );
				$effect_markup .= '</'.$tag_to_use.'>';
				break;
		}

		$animate = ( 'none' != $animation_type ) ? 'tatsu-animate' : '' ;
		$output = '';
        $output .= '<div '.$css_id.' class="tatsu-module tatsu-animated-heading-wrap '.$anime_type.' '. $animate .' '. $custom_class_name.'  '.$css_classes.' '. $visibility_classes.'" '.$data_animations.' data-anime-type="'.$anime_type.'" data-anime-duration="'.$anime_duration.'" >';
		$output .= $effect_markup;
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_animated_heading', 'tatsu_animated_heading' );
}

add_action('tatsu_register_modules', 'tatsu_register_animated_heading', 7);
function tatsu_register_animated_heading()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#text',
		'title' => esc_html__('Animated Heading', 'tatsu'),
		'is_js_dependant' => true,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => true,
		'is_dynamic' => true,
		'group_atts'			=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
                    array(
						'type' => 'tab',
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
                            'text',
                            'tag_to_use'
						),
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
                            'alignment',
							'anime_type',
							'text_color',
							'line_color',
							'typography',
							'anime_duration'
						),
					),
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
                'att_name' => 'text',
                'type' => 'text',
                'label' => 'Text',
                'default' => 'Tatsu Is Awesome',
                'tooltip' => ''
            ),
            array(
                'att_name' => 'tag_to_use',
                'type' => 'select',
                'label' => esc_html__('Tag to use', 'tatsu'),
                'options' => array(
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'p' => 'P',
                    'span' => 'Span',
                    'div' => 'Div',
                ),
                'default' => 'h1',
                'tooltip' => '',
			),
            array(
                'att_name' => 'anime_type',
                'type' => 'select',
                'label' => esc_html__('Effect', 'tatsu'),
                'options' => array(
                    'anime_split_letter' => 'Split Letter',
					'anime_split_word' => 'Split Word',
					'anime_top_bottom_lines' => 'Top and Bottom Lines',
					'anime_zoom_enter' => 'Zoom Enter',
					'anime_from_right' => 'Letter From Right',
					'anime_flip_in' => 'Letter Flip In',
					'anime_fade_in' => 'Slow Fade In',
					'anime_slide_underline' => 'Slide with Line',
					'anime_slide_cursor' => 'Slide with Cursor',
                ),
                'default' => 'anime_split_letter',
                'tooltip' => '',
			),
			array(
				'att_name' => 'text_color',
				'type' => 'color',
				'label' => esc_html__('Text Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-animated-heading-inner' => array(
						'property' => 'color'
					),
				),
			),
			array(
				'att_name' => 'line_color',
				'type' => 'color',
				'label' => esc_html__('Line Color', 'tatsu'),
				'default' => '',
				'visible' => array(
					'condition' => array(
						array( 'anime_type', '=','anime_top_bottom_lines' ),
						array( 'anime_type','=', 'anime_slide_underline' ),
						array( 'anime_type','=', 'anime_slide_cursor' ),
					),
					'relation'	=> 'or',
				),
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-animated-heading-line' => array(
						'property' => 'background'
					),
				),
			),
			array(
				'att_name' => 'alignment',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Align', 'tatsu'),
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
				),
				'default' => 'center',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-animated-heading-wrap' => array(
						'property' => 'text-align'
					)
				)
			),
			array (
				'att_name' => 'anime_duration',
				'type' => 'slider',
				'default' => '700',
				'options' => array(
					'min' => '1',
					'max' => '100',
					'step' => '1'
				),
				'label' => esc_html__( 'Duration', 'tatsu' ),
				'tooltip' => ''
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
					'.tatsu-{UUID} .tatsu-animated-heading-inner' => array(
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
					'alignment' => 'center',
					'text_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'line_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'anime_duration' => '20',
					'alignment' => 'left',
				),
			)
		),
	);
	tatsu_register_module('tatsu_animated_heading', $controls);
}

?>