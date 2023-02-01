<?php 

function tatsu_header_divider( $atts, $content, $tag ) {

    $atts = shortcode_atts( array(
        'width' => '',
        'height' => '',
        'color' => '',
        'margin' => '',
        'hide_in' => '',
        'key' => be_uniqid_base36(true)
    ), $atts, $tag );

    extract( $atts );
    $output = '';
    $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key, 'Header' );
    $unique_class = 'tatsu-'.$key;
    $css_id = be_get_id_from_atts( $atts );
    $visibility_classes = be_get_visibility_classes_from_atts( $atts );

    $output =  '<div '.$css_id.' class="tatsu-header-module tatsu-header-divider-wrap '.$unique_class.' '.$visibility_classes.' '.$css_classes.'">   
                    '.$custom_style_tag.'
                </div>';

    return $output;
}

add_shortcode( 'tatsu_header_divider', 'tatsu_header_divider' );

add_action( 'tatsu_register_header_modules', 'tatsu_register_header_divider' );
function tatsu_register_header_divider() {
	$controls = array (
		'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#header_separator',
		'title' => esc_html__( 'Separator', 'tatsu' ),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
		'inline' => true,
        'is_built_in' => true,
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'	=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
                            'width',
                            'height',
                            'color',
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
										)
                                    ),
								)
							)
						)
					)
				)
			)
		),
		'atts' => array (
			array (
				'att_name' => 'width',
				'type' => 'slider',
				'label' => esc_html__( 'Divider Width', 'tatsu' ),
				'options' => array(
					'min' => '0',
					'max' => '100',
					'step' => '1',
					'unit' => 'px',
				),	        		
				'default' => '1',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-header-divider-wrap' => array(
						'property' => 'width',
						'append' => 'px'
					),
				),
			),
			array (
				'att_name' => 'height',
				'type' => 'slider',
				'label' => esc_html__( 'Divider Height', 'tatsu' ),
				'options' => array(
					'min' => '0',
					'max' => '100',
					'step' => '1',
					'unit' => 'px',
				),	        		
				'default' => '20',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-header-divider-wrap' => array(
						'property' => 'height',
						'append' => 'px',
					),
				),
			),
			array (
				'att_name' => 'color',
				'type' => 'color',
				'options' => array (
						'gradient' => true
				),
				'label' => esc_html__( 'Divider Color', 'tatsu' ),
				'default' => '#efefef', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-header-divider-wrap' => array(
						'property' => 'background',
					),
				),
			),
			array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__( 'Margin', 'tatsu' ),
				'default' => '0px 15px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-header-divider-wrap' => array(
						'property' => 'margin',
					),
				),
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'width' => '1',
					'color' => '#efefef'
				),
			)
		),	        
	);
	tatsu_register_header_module( 'tatsu_header_divider', $controls, 'tatsu_header_divider' );
}

?>