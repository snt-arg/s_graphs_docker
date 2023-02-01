<?php 
function tatsu_hamburger_menu( $atts, $content, $tag ) {

    $atts = shortcode_atts( array(
        'menu_icon_color' => '',
        'menu_icon_hover_color' => '',
        'icon_width' => '',
        'icon_thickness' => '',
        'icon_spacing' => '',
        'panel_background_color' => '',
        'margin' => '',
        'panel_width' => '',
        'hide_in' => '',
        'key' => be_uniqid_base36(true),
    ), $atts, $tag );

    extract( $atts );
    $output = '';
    $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key, 'Header' );
    $unique_class = 'tatsu-'.$key;
    $css_id = be_get_id_from_atts( $atts );
    $visibility_classes = be_get_visibility_classes_from_atts( $atts );

    $output .= '<div '.$css_id.' class="tatsu-header-module tatsu-hamburger '.$unique_class.' '.$visibility_classes.' '.$css_classes.'" data-slide-menu="'.$unique_class.'">   
                    '.$custom_style_tag.'
                    <div class="line-wrapper">
                        <span class="line-1"></span>
                        <span class="line-2"></span>
                        <span class="line-3"></span>   
                    </div>
                </div>';

    return $output;
}

add_shortcode( 'tatsu_hamburger_menu', 'tatsu_hamburger_menu' );

add_action( 'tatsu_register_header_modules', 'tatsu_register_hamburger_menu' );
function tatsu_register_hamburger_menu() {
    $controls = array (
        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#hamburger_menu',
        'title' => esc_html__( 'Hamburger Menu', 'tatsu' ),
        'is_js_dependant' => true,
        'type' => 'multi',
		'is_built_in' => true,
		'inline' => true,
		'builder_layout' => 'column',
        'child_module' => 'tatsu_slide_menu_column',
        'initial_children' => 3,
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
									array(
										'type' => 'panel',
										'title' => esc_html__('Hamburger', 'tatsu'),
										'group' => array(
                                            'menu_icon_color',
                                            'menu_icon_hover_color',
                                            'icon_width',
                                            'icon_thickness',
                                            'icon_spacing',
										)
                                    ),
									array(
										'type' => 'panel',
										'title' => esc_html__('Panel', 'tatsu'),
										'group' => array(
                                            'panel_width',
                                            'panel_background_color',
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
				'att_name' => 'menu_icon_color',
				'type' => 'color',
				'options' => array (
					  'gradient' => true
				),
				'label' => esc_html__( 'Icon Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					  '.tatsu-{UUID}.tatsu-hamburger span' => array(
						  'property' => 'background-color',
					  	)
				  	)
				 ),
			array (
				'att_name' => 'menu_icon_hover_color',
				'type' => 'color',
				'options' => array (
						'gradient' => true
				),
				'label' => esc_html__( 'Icon Hover Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
						'.tatsu-{UUID}.tatsu-hamburger:hover span' => array(
							'property' => 'background-color',
							)
					)
				),
			array (
				'att_name' => 'icon_width',
				'type' => 'slider',
				'label' => esc_html__( 'Line Width', 'tatsu' ),
				'options' => array(
					'min' => '0',
					'max' => '100',
					'step' => '1',
					'unit' => 'px',
				),		        		
				'default' => '27',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-hamburger span' => array(
						'property' => 'width',
						'when' => array ( 'icon_width' , '!=' , '27' ),
						'append' => 'px'
					),
				)
			),	
			array (
				'att_name' => 'icon_thickness',
				'type' => 'slider',
				'label' => esc_html__( 'Line Thickness', 'tatsu' ),
				'options' => array(
					'min' => '0',
					'max' => '10',
					'step' => '1',
					'unit' => 'px',
				),		        		
				'default' => '2',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-hamburger span' => array(
						'property' => 'height' ,
						'when' => array ( 'icon_thickness' , '!=' , '2' ),
						'append' => 'px'
					),
				)
			),	
			array (
				'att_name' => 'icon_spacing',
				'type' => 'slider',
				'label' => esc_html__( 'Line Spacing', 'tatsu' ),
				'options' => array(
					'min' => '0',
					'max' => '30',
					'step' => '1',
					'unit' => 'px',
				),		        		
				'default' => '5',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-hamburger span' => array(
						'property' => 'margin-bottom' ,
						'when' => array ( 'icon_spacing' , '!=' , '5' ),
						'append' => 'px'
					),
				)
			),		
			array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__( 'Margin', 'tatsu' ),
				'default' => '0px 30px 0px 0px',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-hamburger' => array(
						'property' => 'margin',
					)
				),
			),
			array (
				'att_name' => 'panel_width',
				'type' => 'slider',
				'label' => esc_html__( 'Panel Width', 'tatsu' ),
				'options' => array(
					'min' => '0',
					'max' => '600',
					'step' => '20',
					'unit' => 'px',
				),		  
				'responsive'	=> true,      		
				'default' => '300',
				'css' => true,
				'selectors' => array(
					'#tatsu-{UUID}.tatsu-slide-menu' => array(
						'property' => array( 'width', 'transformX'),
						'when' => array ( 'panel_width' , '!=' , '300' ),
						'append' => 'px'
					),
				)
			),	
			array (
				'att_name' => 'panel_background_color',
				'type' => 'color',
				'options' => array (
						'gradient' => true
				),
				'label' => esc_html__( 'Panel Background Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
                    '#tatsu-{UUID}.tatsu-slide-menu' => array(
                        'property' => 'background-color',
                    )
				)
			),	 
		),
    );
	tatsu_register_header_module( 'tatsu_hamburger_menu', $controls, 'tatsu_hamburger_menu' );
}

?>