<?php 
function tatsu_header_row( $atts, $content, $tag ) {
    $atts = shortcode_atts( array(
        'full_width' => 0,
        'bg_color' => '',
        'transparent_row_bg' => 0,
        'transparent_row_border' => '',
        'padding' => '',
        'sticky_padding' => '',
        'border' => '',
        'border_color' => '',
        'sticky_header' => 0,
        'default_visibility' => 'visible',
        'sticky_visibility' => 'visible',
        'hide_in' => '',
        'id' => '',
        'class' => '',
        'box_shadow' => '',
        'disable_color_scheme' => '',
        'key' => be_uniqid_base36(true),
    ), $atts, $tag );
    
    extract( $atts );

    $output = '';
    $visibility_classes = be_get_visibility_classes_from_atts( $atts );
    $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key, 'Header' );

    $unique_class = 'tatsu-'.$key;
    $id = !empty( $id ) ? 'id="'.$id.'"' : '';
    $class .= !empty( $sticky_header ) ? ' tatsu-sticky-header' : '';
    $class .= !empty( $default_visibility ) && $default_visibility === 'visible' ? ' default ' : 'default-hidden ';
    $class .= !empty( $sticky_visibility ) && $sticky_visibility === 'visible' ? ' sticky ' : 'sticky-hidden ';
    $class .= isset( $disable_color_scheme ) && !empty( $disable_color_scheme ) && ( $disable_color_scheme ) ? '' : 'apply-color-scheme' ;
    $row_wrap = empty( $full_width ) ? 'tatsu-wrap' : '';
    $output .= '<div class="tatsu-header '.$class.' '.$unique_class.' '.$visibility_classes.'" '.$id.' data-padding=\''.$padding.'\' data-sticky-padding=\''.$sticky_padding.'\' >';
    $output .= '<div class="tatsu-header-row '.$row_wrap.'">';
    $output .= do_shortcode( $content ); 
    $output .= '</div>';  // end tatsu-header
    $output .= $custom_style_tag;
    $output .= '</div>';  // end tatsu-header-row

    return $output;

}

add_shortcode( 'tatsu_header_row', 'tatsu_header_row' );

add_action( 'tatsu_register_header_modules', 'tatsu_register_header_row' );
function tatsu_register_header_row() {
		$controls = array (
	        'icon' => '',
	        'title' => esc_html__( 'Row', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => 'tatsu_header_column',
	        'type' => 'core',
	        'builder_layout' => 'column',
			'label' => 'Row',
			'initial_children' => 2,
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
                                array(
                                    'type' => 'accordion',
                                    'active' => 'all',
                                    'group' => array(
                                        'full_width',
                                        'bg_color',
                                        array(
                                            'type' => 'panel',
                                            'title' => esc_html__('Visibility', 'tatsu'),
                                            'group' => array(
                                                'default_visibility',
                                                'sticky_visibility',
                                            )
                                        ),
                                        array (
                                            'type' => 'panel',
                                            'title' => esc_html__( 'Transparency Settings', 'tatsu' ),
                                            'group' => array (
                                                'transparent_row_bg',
                                                'transparent_row_border',
                                                'disable_color_scheme'
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
                                                'padding',
                                                'sticky_padding',
                                            )
                                        ),
                                        array(
                                            'type' => 'panel',
                                            'title' => esc_html__('Identifiers', 'tatsu'),
                                            'group' => array(
                                                'row_title',
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
                    'att_name' => 'full_width',
                    'type' => 'switch',
                    'label' => esc_html__( 'Full Width Header ?', 'tatsu' ),
                    'default' => false,
                    'tooltip' => '',
                ),
	             array (
	              'att_name' => 'bg_color',
				  'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
	              'label' => esc_html__( 'Background Color', 'tatsu' ),
	              'default' => '#ffffff',
				  'tooltip' => '',
				  'css' => true,
				  'selectors' => array(
						'.tatsu-{UUID}.tatsu-header' => array(
							'property' => 'background-color',
						)
					)
	            ),
				array (
					'att_name' => 'default_visibility',
                    'type' => 'button_group',
                    'is_inline' => true,
					'label' => esc_html__( 'Default', 'tatsu' ),
					'options' => array (
						'visible' => 'Visible',
						'hidden' => 'Hidden',	        			
					),
					'default' => 'visible',
					'tooltip' => '',
				),
				array (
					'att_name' => 'sticky_visibility',
                    'type' => 'button_group',
                    'is_inline' => true,
					'label' => esc_html__( 'Sticky Header', 'tatsu' ),
					'options' => array (
						'visible' => 'Visible',
						'hidden' => 'Hidden',	        			
					),
					'default' => 'visible',
					'tooltip' => '',
                ),
                array (
                    'att_name' => 'margin',
                    'type' => 'input_group',
                    'label' => esc_html__( 'Margin', 'tatsu' ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'responsive' => true,
                    'selectors' => array(
                        '.tatsu-{UUID}' => array(
                            'property' => 'margin',
                            'when' => array( 'margin', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                        ),
                    ),
                ),
				array (
					'att_name' => 'padding',
					'type' => 'input_group',
					'label' => esc_html__( 'Padding', 'tatsu' ),
					'default' => '30px 0px 30px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-header-row' => array(
							'property' => 'padding'
						)
					),
				), 
				array (
					'att_name' => 'sticky_padding',
					'type' => 'input_group',
					'label' => esc_html__( 'Sticky Padding', 'tatsu' ),
					'default' => '15px 0px 15px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'#tatsu-header-wrap.stuck .tatsu-{UUID} .tatsu-header-row' => array(
							'property' => 'padding',
						)
					),
				),            	             
				array (
					'att_name' => 'transparent_row_bg',
					'type' => 'color',
					'options' => array (
						  'gradient' => true
					),
					'label' => esc_html__( 'Background Color when Header is Transparent', 'tatsu' ),
					'default' => 'rgba(0,0,0,0)',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						  '#tatsu-header-wrap.transparent:not(.stuck) .tatsu-header.tatsu-{UUID}' => array(
							  'property' => 'background',
						  )
					  )
				  ),
				  array (
					'att_name' => 'transparent_row_border',
					'type' => 'color',
					'label' => esc_html__( 'Border Color when Header is Transparent', 'tatsu' ),
					'default' => 'rgba(0,0,0,0)',
					'tooltip' => '',
					'css' => true,
					'visible' => array( 'border', '!=', '0px 0px 0px 0px' ),
					'selectors' => array(
						  '#tatsu-header-wrap.transparent:not(.stuck) .tatsu-header.tatsu-{UUID}' => array(
							  'property' => 'border-color',
						  )
					  )
				  ),	
				  array (
                    'att_name' => 'disable_color_scheme',
                    'type' => 'switch',
                    'label' => esc_html__( 'Do Not Apply Color Scheme', 'tatsu' ),
                    'default' => false,
                    'tooltip' => '',
                ),
				array (
					'att_name' => 'row_title',
					'type' => 'text',
					'label' => esc_html__( 'Row Title', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
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
	tatsu_register_header_module( 'tatsu_header_row', $controls, 'tatsu_header_row' );
}

?>