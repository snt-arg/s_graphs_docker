<?php
if (!function_exists('tatsu_notifications')) {
	function tatsu_notifications( $atts, $content , $tag ) {
		$atts = shortcode_atts( array(
			'bg_color'=>'',
			'margin' => '',
			'animate'=>0,
			'animation_type'=>'fadeIn',
			'key' => be_uniqid_base36(true),
			'color' => '',
		), $atts , $tag );
		
		extract($atts);
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '' ;
		$data_animations = be_get_animation_data_atts( $atts );

		$output = '';
		$output .= '<div '.$css_id.' class="tatsu-module tatsu-notification '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.' '.$animate.'" '.$data_animations.' ><div class="tatsu-notification-inner">'.$custom_style_tag.'<span class="close"><i class="tatsu-icon icon-icon_close"></i></span>'.do_shortcode( $content ).'</div></div>';
		
		return $output;
	}
	add_shortcode( 'tatsu_notifications', 'tatsu_notifications' );
	add_shortcode( 'notifications', 'tatsu_notifications' );
}

add_action('tatsu_register_modules', 'tatsu_register_notifications', 9);
function tatsu_register_notifications()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#notifications',
		'title' => esc_html__('Notifications', 'tatsu'),
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
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
							'content',
							'class',
						),
					),
					//Tab2
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							'bg_color',
							'color',
						),
					),

					//Tab3
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array( //spacing and styling accordion
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
				'att_name' => 'bg_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Background Color', 'tatsu'),
				'default' => '', //alt_bg
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'background-color',
						'when' => array('bg_color', 'notempty'),
					),
				)
			),
			array(
				'att_name' => 'color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Text Color', 'tatsu'),
				'default' => '', //alt_text
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'color',
						'when' => array('color', 'notempty'),
					),
				)
			),
			array(
				'att_name' => 'content',
				'type' => 'tinymce',
				'label' => esc_html__('Notification Content', 'tatsu'),
				'default' => '',
				'tooltip' => ''
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
					'.tatsu-{UUID}.tatsu-notification' => array(
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
					'content' => '<span>This is a Cool Notice</span>',
					'bg_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'color' => array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
				),
			)
		),
	);
	tatsu_register_module('tatsu_notifications', $controls);
}

?>