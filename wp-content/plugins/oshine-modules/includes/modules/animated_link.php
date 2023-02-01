<?php
/**************************************
			ANIMATED LINK
**************************************/
if (!function_exists('oshine_animated_link')) {
    function oshine_animated_link( $atts, $content, $tag ) {
        $atts = shortcode_atts( array (
			'link_text' => '',
			'url' => '',
			'new_tab' => '',
            'font_size' => '13',
            'link_style' => 'style1',
			'alignment' => '',
			'color'=> '',
			'hover_color'=> '',
			'line_color'=> '',
			'line_hover_color' => '',
			'animate' => 0,
			'animation_type' => 'fadeIn',
			'animation_delay' => 0,
			'key' => be_uniqid_base36(true),
		), $atts, $tag );
		
		extract( $atts );

		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';  		
		$data_animations = be_get_animation_data_atts( $atts );
		$new_tab = !empty( $new_tab ) ? 'target = "_blank"' : '';
		$output = '';
		
		$output .= '<div '.$css_id.' class="oshine-animated-link '.$custom_class_name.' oshine-module align-'. $alignment .' '.$animate.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'><a class = "animated-link animated-link-'. $link_style .'" ' . $new_tab . ' href = "'. $url .'" aria-label = "'.$link_text.'">';
		$output .= '<span class = "link-text"  >'.$link_text.'</span>';
        if( $link_style == 'style4' || $link_style == 'style5' ){
            $output .= '<div class = "next-arrow"><span class="arrow-line-one" ></span><span class="arrow-line-two" ></span><span class="arrow-line-three"></span></div>';
        }
		$output .= '</a>';
		$output .= $custom_style_tag;
		$output .= '</div>';
		
		return $output;
	}
	add_shortcode( 'oshine_animated_link', 'oshine_animated_link' );
}
add_filter( 'oshine_animated_link_before_css_generation', 'oshine_animated_link_css'  );
function oshine_animated_link_css($atts) {
	if( empty( $atts['hover_color'] ) ) {
		$atts['hover_color'] = $atts['color'];
	}
	if( empty( $atts['line_color'] ) ) {
		$atts['line_color'] = $atts['color'];
	}
	if( empty( $atts['line_hover_color'] ) ) {
		$atts['line_hover_color'] = $atts['hover_color'];
	}
	return $atts;
}


add_action( 'tatsu_register_modules', 'oshine_register_animated_link', 11 );
function oshine_register_animated_link() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#svg_icon',
	        'title' => __( 'Animated Link', 'oshine_modules' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
	        'is_built_in' => true,
			'should_autop' => false,
			'hint' => 'link_text',
			'group_atts' => array (
				array (
					'type'	=>	'tabs',
					'style'	=>	'style1',
					'group'	=>	array (
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Content' , 'tatsu'),
							'group'	=>	array (
								'link_text',
								'url',
								'new_tab',
							)
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Style' , 'tatsu'),
							'group'	=>	array (
								array (
									'type' => 'accordion' ,
									'active' => array(0, 1),
									'group' => array (
										array (
											'type' => 'panel',
											'title' => __( 'Shape and Size', 'tatsu' ),
											'group' => array (
												'font_size',
												'link_style',
												'alignment',
												)
											),
										array (
											'type' => 'panel',
											'title' => __( 'Colors', 'tatsu' ),
											'group' => array (
													array (
													'type'	=>	'tabs',
													'style'	=>	'style1',
													'group'	=>	array (
														array (
															'type'	=>	'tab',
															'title'	=>	__( 'Normal' , 'tatsu'),
															'group'	=>	array(
																'color',
																'line_color'
															)
														),
														array (
															'type'	=>	'tab',
															'title'	=>	__( 'Hover' , 'tatsu'),
															'group'	=>	array(
																'hover_color',
																'line_hover_color',
															)
														),
													)
												),
											)
										)
									)
								)
							),
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Advanced' , 'tatsu'),
							'group'	=>	array (
									array(
									'type' => 'accordion' ,
									'active' => array(0, 1),
									'group' => array (
										array (
											'type' => 'panel',
											'title' => __( 'Animation', 'tatsu' ),
											'group' => array (
											)
										),
									)
								),
							)
						),
					)
				),
			),
			'atts' => array (
				array (
					'att_name' => 'link_text',
					'type' => 'text',
					'label' => __( 'Link Text', 'tatsu' ),
					'default' => 'Link Text',
					'tooltip' => '',
					'is_inline' => false,
				),
				array (
					'att_name' => 'url',
					'type' => 'text',
					'label' => __( 'Link URL', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'is_inline' => false,
 				),
				array(
					'att_name' => 'new_tab',
					'type' => 'switch',
					'label' => __('Open in a new tab', 'tatsu'),
					'default' => '0',
					'tooltip' => '',
					'visible' => array('url', '!=', ''),
				),
				array (
					'att_name' => 'font_size',
					'type' => 'number',
					'is_inline' => true,
					'label' => __( 'Font Size', 'tatsu' ),
					'options' => array(
	        			'unit' => 'px',
	        		),
					'default' => '13',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} a' => array(
							'property' => 'font-size',
							'append' => 'px'
						),
					),
				),
 				array (
 					'att_name' => 'link_style',
 					'type' => 'button_group',
 					'label' => __( 'Link Style', 'tatsu' ),
 					'options' => array (
 						'style1' => 'Style 1',
 						'style2' => 'Style 2',
 						'style3' => 'Style 3',
						'style4' => 'Style 4',
						//'style5' => 'Style 5'
 					),
 					'default' => 'style1',
 					'tooltip' => ''
 				), 	        	 								
 				array (
 					'att_name' => 'alignment',
 					'type' => 'button_group',
 					'label' => __( 'Alignment', 'tatsu' ),
 					'options' => array (
 						'none' => 'None',
 						'left' => 'Left',
 						'center' => 'Center',
 						'right' => 'Right',
 					),
 					'default' => 'none',
 					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'color',
 					'type' => 'color',
 					'label' => __( 'Text Color', 'tatsu' ),
 					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .link-text, .tatsu-{UUID} .animated-link' => array(
							'property' => 'color'
						),
					),
 				),
  				array (
 					'att_name' => 'hover_color',
 					'type' => 'color',
 					'label' => __( 'Text Hover Color', 'tatsu' ),
 					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .animated-link:hover .link-text, .tatsu-{UUID} .animated-link:hover' => array(
							'property' => 'color'
						),
					),
 				),
				array (
 					'att_name' => 'line_color',
 					'type' => 'color',
 					'label' => __( 'Line/Arrow Color', 'tatsu' ),
 					'default' => '',
					 'tooltip' => '',
					 'css' => true,
					 'selectors' => array(
						'.tatsu-{UUID} .animated-link:before' => array(
							'property' => 'color'
						),
						'.tatsu-{UUID} .animated-link .next-arrow span' => array(
							'property' => 'background'
						),
					),
 				),
  				array (
 					'att_name' => 'line_hover_color',
 					'type' => 'color',
 					'label' => __( 'Line/Arrow Hover Color', 'tatsu' ),
 					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .animated-link:hover:before' => array(
							'property' => 'color'
						),
						'.tatsu-{UUID} .animated-link:hover .next-arrow span' => array(
							'property' => 'background'
						),
					),
 				),
 				// array (
 				// 	'att_name' => 'border_width',
 				// 	'type' => 'number',
 				// 	'label' => __( 'Border Size', 'tatsu' ),
 				// 	'options' => array(
 				// 		'unit' => 'px',
 				// 		'add_unit_to_value' => false,
 				// 	),
 				// 	'default' => '0',
 				// 	'tooltip' => ''
 				// ),
 				// array (
 				// 	'att_name' => 'border_color',
 				// 	'type' => 'color',
 				// 	'label' => __( 'Border Color', 'tatsu' ),
 				// 	'default' => '',
 				// 	'tooltip' => '',
 				// 	'visible' => array( 'border_width', '>', '0' ),
 				// ),
 				// array ( 
 				// 	'att_name' => 'hover_border_color',
 				// 	'type' => 'color',
 				// 	'label' => __( 'Hover Border Color', 'tatsu' ),
 				// 	'default' => '',
 				// 	'tooltip' => '',
 				// 	'visible' => array( 'border_width', '>', '0' ),
 				// ),
			),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
						'link_text' => 'Click Here',
						'hover_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
						'line_hover_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),       			
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'oshine_animated_link', $controls );
	if( function_exists( 'tatsu_remap_modules' ) ) {
		tatsu_remap_modules( array( 'oshine_animated_link', 'tatsu_animated_link' ), $controls, 'oshine_animated_link' );
	}
}