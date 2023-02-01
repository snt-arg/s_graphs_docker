<?php 

function tatsu_header_links( $atts, $content, $tag ) {

    $atts = shortcode_atts( array(
        'link_text' => '',
        'url' => '',
        'new_tab' => false,
        'color' => '',
        'hover_color' => '',
        'margin' => '',
        'hide_in' => '',
        'link_typography' => '',
        'key' => be_uniqid_base36(true)
    ), $atts, $tag );

    extract( $atts );

    $output = '';
    $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key, 'Header' );
    $unique_class = 'tatsu-'.$key;
    $css_id = be_get_id_from_atts( $atts );
    $visibility_classes = be_get_visibility_classes_from_atts( $atts );

    $output =  '<div '.$css_id.' class="tatsu-header-module tatsu-link '.$unique_class.' '.$visibility_classes.' '.$css_classes.'">   
                    <a href="'.$url.'" target='.( $new_tab ? '_blank' : '' ).'>'.$link_text.'</a>
                    '.$custom_style_tag.'
                </div>';

    return $output;
}

add_shortcode( 'tatsu_header_links', 'tatsu_header_links' );

add_action( 'tatsu_register_header_modules', 'tatsu_register_header_links' );
function tatsu_register_header_links() {
	$controls = array (
		'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#header_links',
		'title' => esc_html__( 'Links', 'tatsu' ),
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
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
                            'link_text',
                            'url',
                            'new_tab',
						)
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
                            array(
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(
                                    array (
                                        'type' => 'panel',
                                        'title' => esc_html__( 'Colors', 'tatsu' ),
                                        'group' => array (
                                            'color',
                                            'hover_color',
                                        )
                                    ),
                                    array (
                                        'type' => 'panel',
                                        'title' => esc_html__( 'Typography', 'tatsu' ),
                                        'group' => array (
                                            'link_typography'
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
            ),
		),
		'atts' => array (
			array(
				'att_name' => 'link_typography',
				'type' => 'typography',
				'label' => esc_html__( 'Link Typography', 'tatsu' ),
				'responsive' => true,
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'is_inline' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-link' => array(
						'property' => 'typography',
					)
				),
			),
			array (
				'att_name' => 'link_text',
				'type' => 'text',
				'label' => esc_html__( 'Link Text', 'tatsu' ),
				'default' => 'Click Here',
				'tooltip' => ''
			),
			array (
				'att_name' => 'url',
				'type' => 'text',
				'label' => esc_html__( 'Link URL', 'tatsu' ),
				'default' => '#',
				'tooltip' => ''
			),
			array (
				'att_name' => 'new_tab',
				'type' => 'switch',
				'label' => esc_html__( 'Open in a new tab', 'tatsu' ),
				'default' => true,
				'tooltip' => '',
				'visible' => array( 'url', '!=', '' ),
			),
			array (
				'att_name' => 'color',
				'type' => 'color',
				'label' => esc_html__( 'Link Color', 'tatsu' ),
				'default' => '#212121', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-link a' => array(
						'property' => 'color',
					),
				),
			),
			array (
				'att_name' => 'hover_color',
				'type' => 'color',
				'label' => esc_html__( 'Link Hover Color', 'tatsu' ),
				'default' => '#212121', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-link a:hover' => array(
						'property' => 'color',
					),
				),
			),
			array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__( 'Margin', 'tatsu' ),
				'default' => '0px 30px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-link' => array(
						'property' => 'margin',
					),
				),
			),
		),	        
	);
	tatsu_register_header_module( 'tatsu_header_links', $controls, 'tatsu_header_links' );
}

?>