<?php
// Change separator to divider in parser
if ( ! function_exists( 'tatsu_shape_divider' ) ) {
	function tatsu_shape_divider( $atts , $content, $tag ) {
		$atts = shortcode_atts( array (
            'size'                  => 'medium',
            'width'                 => 200,
            'height'                => 200,
            'alignment'             => '',
            'color'                 => '',
            'line_animate'          => 0,
            'path_animation_type'   => 'LINEAR',
            'svg_animation_type'    => 'LINEAR',
            'animation_duration'    => 0,
            'animation_delay'       => 0,
        	'key' => be_uniqid_base36(true),
		),$atts );	

		// $animate = ( isset( $animate ) && 1 == $animate ) ? ' tatsu-animate' : '';
		
		extract($atts);

		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_shape_divider', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$data_animations = be_get_animation_data_atts( $atts );
		$output = '';
		$output .= '<div '.$css_id.' class="tatsu-module tatsu_shape-divider-wrap '. $animate .' '. $custom_class_name.'  '.$css_classes.' '. $visibility_classes.'" '.$data_animations.' >';
		$output .= $custom_style_tag;
		$output .= '<img class="tatsu_shape-divider" src="'.OSHINE_MODULES_PLUGIN_URL.'/img/header-shape.svg"/>'; 
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_shape_divider', 'tatsu_shape_divider' );
}

add_action('tatsu_register_modules', 'tatsu_register_shape_divider', 7);
function tatsu_register_shape_divider()
{
	$controls = array(
		'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/header-shape.svg#shape_divider',
		'title' => __('Shape Divider', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => false, 
		'group_atts'			=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					//Tab1
					array(
						'type' => 'tab',
						'title' => __('Style', 'tatsu'),
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
						'title' => __('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => 'none',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => __('Spacing', 'tatsu'),
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
				'label' => __('Thickness', 'tatsu'),
				'options' => array(
					// 'min' => '0',
					// 'max' => '500',
					// 'step' => '1',
					'unit' => 'px',
				),
				'default' => '',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu_shape-divider' => array(
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
				'label' => __('Width', 'tatsu'),
				'options' => array(
					'unit' => array('%', 'px'),
					'add_unit_to_value' => false,
				),
				'default' => '',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu_shape-divider' => array(
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
				'label' => __('Align', 'tatsu'),
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
				),
				'default' => 'left',
				//'visible' => array ( 'width', '<', '100' ),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-shape-divider-wrap' => array(
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
				'label' => __('Divider Color', 'tatsu'),
				'default' => '', //sec_border
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu_shape-divider' => array(
						'property' => 'background',
					),
				),
			),
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => __('Margin', 'tatsu'),
				'default' => '0px 0px 20px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-shape-divider-wrap' => array(
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
	tatsu_register_module('tatsu_shape_divider', $controls);
}

?>