<?php 
function tatsu_header_column($atts, $content, $tag ) {
    $atts = shortcode_atts( array(
        'column_width' => '',
        'horizontal_alignment' => '',
        'vertical_alignment' => '',
        'padding' => '',
        'sidebar_vertical_alignment' => '',
        'sidebar_horizontal_alignment' => '',
        'hide_in' => '',
        'id' => '',
        'class' => '',
        'key' => be_uniqid_base36(true),
    ), $atts, $tag );

    extract( $atts );
    $output = '';
    $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key, 'Header' );
    $unique_class = 'tatsu-'.$key;
    $id = !empty( $id ) ? 'id="'.$id.'"' : '';
    $visibility_classes = be_get_visibility_classes_from_atts( $atts );

    $output .= '<div class="tatsu-header-col '.$unique_class.' '.$visibility_classes.' '.$class.'" '.$id.'>';
    $output .= $custom_style_tag;
    $output .= do_shortcode( $content );
    $output .= '</div>';  

    return $output;
}

add_shortcode( 'tatsu_header_column', 'tatsu_header_column' );

add_action( 'tatsu_register_header_modules', 'tatsu_register_header_column' );
function tatsu_register_header_column() {
    $controls = array (
        'icon' => '',
        'title' => esc_html__( 'Column', 'tatsu' ),
        'is_js_dependant' => false,
        'type' => 'core',
		'builder_layout'=> 'list',
        'is_built_in' => true,
        'child_module' => 'module',
        'initial_children' => 0,
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'	=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(
                                    'column_width',
                                    array(
										'type' => 'panel',
										'title' => esc_html__('Alignment', 'tatsu'),
										'group' => array(
                                            'horizontal_alignment',
                                            'vertical_alignment',
                                            'sidebar_vertical_alignment',
                                            'sidebar_horizontal_alignment'
										)
                                    ),
								)
							)
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
										'title' => esc_html__('Identifiers', 'tatsu'),
										'group' => array(
                                            'id',
                                            'class'
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
                'att_name' => 'column_width',
                'type' => 'slider',
                'label' => esc_html__( 'Width', 'tatsu' ),
                'options' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                    'unit' => '%',
                ),		        		
                'default' => '',
				'tooltip' => '',
				'hide_in_sidebar_col' => true,
                'responsive' => true,
                'css' => true,
                'selectors' => array(
					'.tatsu-{UUID}.tatsu-header-col' => array(
						'property' => 'flex-basis',
						'append' => '%'
					)
                ),
            ),
            array (
                'att_name' => 'horizontal_alignment',
                'type' => 'button_group',
                'is_inline' => true,
                'label' => esc_html__( 'Horizontal', 'tatsu' ),
                'options' => array (
                    'flex-start' => 'Left',
                    'center' => 'Center',	        			
                    'flex-end' => 'Right',
                ),
                'default' => 'flex-start',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'hide_in_sidebar_col' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-header-col' => array(
						'property' => 'justify-content',
					)
				),
			),
            array (
                'att_name' => 'vertical_alignment',
                'type' => 'button_group',
                'is_inline' => true,
                'label' => esc_html__( 'Vertical', 'tatsu' ),
                'options' => array (
                    'flex-start' => 'Top',
                    'center' => 'Middle',	        			
                    'flex-end' => 'Bottom',
                ),
                'default' => 'center',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'hide_in_sidebar_col' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-header-col' => array(
						'property' => 'align-items',
					)
				),
			),
            array (
                'att_name' => 'sidebar_vertical_alignment',
                'type' => 'button_group',
                'is_inline' => true,
                'label' => esc_html__( 'Vertical', 'tatsu' ),
                'options' => array (
                    'flex-start' => 'Top',
                    'center' => 'Middle',	        			
                    'flex-end' => 'Bottom',
                ),
                'default' => 'center',
				'tooltip' => '',
				'css' => true,
				'hide_in_header_col' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-slide-menu-col' => array(
						'property' => 'justify-content',
					),
					'.tatsu-{UUID}.tatsu-slide-menu-col' => array(
						'property' => 'justify-content',
					)
				),
			),
            array (
                'att_name' => 'sidebar_horizontal_alignment',
                'type' => 'button_group',
                'is_inline' => true,
                'label' => esc_html__( 'Horizontal', 'tatsu' ),
                'options' => array (
                    'flex-start' => 'Left',
                    'center' => 'Center',	        			
                    'flex-end' => 'Right',
                ),
                'default' => 'flex-start',
				'tooltip' => '',
				'css' => true,
				'hide_in_header_col' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-slide-menu-col' => array(
						'property' => 'align-items',
					),
				),
			),
            array (
                'att_name' => 'id',
                'type' => 'text',
                'label' => esc_html__( 'CSS ID', 'tatsu' ),
                'default' => '',
                'tooltip' => '',
            ),
            array (
                'att_name' => 'class',
                'type' => 'text',
                'label' => esc_html__( 'CSS Classes', 'tatsu' ),
                'default' => '',
                'tooltip' => '',
            ),
        ),
    );
	tatsu_register_header_module( 'tatsu_header_column', $controls, 'tatsu_header_column' );
	tatsu_register_header_module( 'tatsu_slide_menu_column', $controls, 'tatsu_header_column' );
}

?>