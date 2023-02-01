<?php
/**************************************
			BUBBLE TESTIMONIAL
**************************************/
if (!function_exists('tatsu_testimonial')) {	
	function tatsu_testimonial( $atts, $content, $tag ) {
		$atts = shortcode_atts( array (
			'description' => '',
			'content_color' => '',
			'bg_color' => '',
			'author_image' => '',
			'author' => '',
			'author_color'=> '',
			'author_role' => '',
			'author_role_color' => '',
			'alignment' => 'center',
			'box_shadow' => '',
			'key' => be_uniqid_base36(true),
			'animate' => 0,
            'animation_type' => 'fadeIn',
            'animation_delay' => 0,
		), $atts, $tag );
		
		extract($atts);
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';
		$data_animations = be_get_animation_data_atts( $atts );

		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;

		$output = '';
		
		$alt_text = $author;
		$author = (isset( $author ) && !empty( $author )) ? '<h6 class="tatsu_testimonial_author">'.$author.'</h6>' : '';
		
		$author_role = (isset( $author_role ) && !empty( $author_role )) ? '<div class="tatsu_testimonial_role">'.$author_role.'</div>' : '';
		$alignment = (isset($alignment) && !empty($alignment)) ? $alignment : 'center';

		if ( !empty( $author_image ) ) {
			$author_image =  '<div class="tatsu_testimonial_img"><img src="'.$author_image.'" alt="'.$alt_text.'" /></div>';
		}

		$output .= '<div '. $css_id . 'class="tatsu_testimonial_wrap '.$unique_class_name.' clearfix bubble_'.$alignment.' '. $css_classes.' '. $visibility_classes.$animate.'" '.$data_animations.'><div class="tatsu_testimonial_wrap"><div class="tatsu_testimonial_inner_wrap">';
		$output .= '<i class="tatsu-icon icon-quote"></i>';
		$output .= '<div class="tatsu_testimonial_content"><div class="tatsu_testimonial_description">'.$description.'</div></div>';
		$output .= '</div></div>';
		$output .= '<div class="tatsu_testimonial_info_wrap clearfix">';
		$output .= $author_image;
		$output .= '<div class="tatsu_testimonial_info">';
		$output .= $author;
		$output .= $author_role;
		$output .= '</div>';
		$output .= '</div>';
		$output .= $custom_style_tag;
		$output .= '</div>';
		
		return $output;
	}	
	add_shortcode( 'tatsu_testimonial', 'tatsu_testimonial' );
}

add_action('tatsu_register_modules', 'tatsu_register_testimonial', 8);
function tatsu_register_testimonial()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#bubble_testimonial',
		'title' => esc_html__('Bubble Testimonial', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => true,
		'hint' => 'author',

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
									'description',
									'author',
									'author_role',
									'author_image'
								)
							)
						)
					),

					//Tab2
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(

									array( //color accordion
										'type'		=> 'panel',
										'title'		=> esc_html__('Colors', 'tatsu'),
										'group'		=> array(
											'content_color',
											'author_color',
											'author_role_color',
											'bg_color',
										),
									),
									'alignment',
								)
							),
						)
					),

					array( //Tab3
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => 'none',
								'group' => array(
									array(
                                        'type'    => 'panel',
                                        'title' => 'Shadow',
                                        'group' => array (
                                            'box_shadow'
                                        )
                                    )
								)
							)
						)
					)
				)
			)
		),

		'atts' => array(
			array(
				'att_name' => 'description',
				'type' => 'text_area',
				'label' => esc_html__('Content', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'content_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Content Text Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .icon-quote, .tatsu-{UUID} .tatsu_testimonial_description' => array(
						'property' => 'color',
						'when' => array('content_color', 'notempty'),
					),
				),
			),
			array(
				'att_name' => 'bg_color',
				'type' => 'color',
				'label' => esc_html__('Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu_testimonial_inner_wrap' => array(
						'property' => 'border-color',
						'when' => array('bg_color', 'notempty'),
					),
					'.tatsu-{UUID} .tatsu_testimonial_content' => array(
						'property' => 'background-color',
						'when' => array('bg_color', 'notempty'),
					),
				),
			),
			array(
				'att_name' => 'author_image',
				'type' => 'single_image_picker',
				'options' => array(
					'size' => 'thumbnail',
				),
				'label' => esc_html__('Author Image', 'tatsu'),
				'tooltip' => '',
			),
			array(
				'att_name' => 'author',
				'type' => 'text',
				'label' => esc_html__('Author Name', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'author_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Author Name Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu_testimonial_author' => array(
						'property' => 'color',
						'when' => array('author_color', 'notempty'),
					),
				),
			),
			array(
				'att_name' => 'author_role',
				'type' => 'text',
				'label' => esc_html__('Designation', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'author_role_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Designation Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu_testimonial_role' => array(
						'property' => 'color',
						'when' => array('author_role_color', 'notempty'),
					),
				),
			),
			array(
				'att_name' => 'alignment',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Alignment', 'tatsu'),
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right'
				),
				'default' => 'left',
				'tooltip' => ''
			),
			array(
				'att_name' => 'box_shadow',
				'type' => 'input_box_shadow',
				'label' => esc_html__('Shadow', 'tatsu'),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu_testimonial_wrap' => array(
						'property' => 'box-shadow',
						'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
					),
				),
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'description' => 'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt.',
					'author' => 'Swami',
					'author_role' => 'Designer',
					'bg_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'content_color' => array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
				),
			)
		),
	);
	tatsu_register_module('tatsu_testimonial', $controls);
}

?>