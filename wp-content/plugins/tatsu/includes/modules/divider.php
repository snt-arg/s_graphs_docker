<?php
// Change separator to divider in parser
if ( ! function_exists( 'tatsu_divider' ) ) {
	function tatsu_divider( $atts , $content, $tag ) {
		$atts = shortcode_atts( array(
	        'height' => '1',
	        'width' => '20',
	        'units' => '%',
	        'alignment' => '',
	        'color' => '#dedede',
			'margin' => '',
			'animate'                => '',
            'animation_type'         => '',
			'animation_delay'        => '',   
			'animation_duration'	 => '',
			'key' => be_uniqid_base36(true),
		),$atts , $tag );

		extract($atts);

		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_divider', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$data_animations = be_get_animation_data_atts( $atts );

		$animate = ( 'none' != $animation_type ) ? 'tatsu-animate' : '' ;
		$output = '';
		$output .= '<div '.$css_id.' class="tatsu-module tatsu-divider-wrap '. $animate .' '. $custom_class_name.'  '.$css_classes.' '. $visibility_classes.'" '.$data_animations.' >';
		$output .= $custom_style_tag;
		$output .= '<hr class="tatsu-divider"/>'; 
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_divider', 'tatsu_divider' );
}

add_action('tatsu_register_modules', 'tatsu_register_divider', 7);
function tatsu_register_divider()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#divider',
		'title' => esc_html__('Divider', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
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
							'width',
							'height',
							'alignment',
							'color',
						),
					),
					//Tab2
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
						),
					),
				),
			),
		),
		'atts' => array(
			array(
				'att_name' => 'height',
				'type' => 'number',
				'is_inline' => true,
				'label' => esc_html__('Thickness', 'tatsu'),
				'options' => array(
					'unit' => 'px',
				),
				'default' => '',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-divider' => array(
						'property' => 'height',
						'when' => array('height', 'notempty'),
						'append' => 'px',
					),
				),
			),
			array(
				'att_name' => 'width',
				'type' => 'number',
				'is_inline' => true,
				'label' => esc_html__('Width', 'tatsu'),
				'options' => array(
					'unit' => array('%', 'px'),
					'add_unit_to_value' => false,
				),
				'default' => '',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-divider' => array(
						'property' => 'width',
						'when' => array('width', 'notempty'),
						'append' => '%',
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
				'default' => 'left',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-divider-wrap' => array(
						'property' => 'text-align'
					)
				)
			),
			array(
				'att_name' => 'color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Divider Color', 'tatsu'),
				'default' => '', //sec_border
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-divider' => array(
						'property' => 'background',
					),
				),
			),
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '0px 0px 20px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-divider-wrap' => array(
						'property' => 'margin',
						'when' => array('margin', '!=', array('d' => '0px 0px 20px 0px')),
					),
				),
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'height' => '1',
					'width' => '100',
					'color' => '#efefef'
				),
			)
		),
	);
	tatsu_register_module('tatsu_divider', $controls);
}

?>