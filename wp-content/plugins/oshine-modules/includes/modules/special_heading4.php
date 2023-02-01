<?php
/**************************************
			SPECIAL TITLE 4
**************************************/
if (!function_exists('be_special_heading4')) {
	function be_special_heading4( $atts, $content, $tag ) {
		$atts = shortcode_atts( array(
			'title_content' => '',
			'h_tag' => 'h3',
	        'title_color' => '',
	        'caption_content' => '',
	        'caption_font' => '',
	        'caption_color' => '',
	        'divider_style' => 'both',
	        'divider_color' => '',
			'scroll_to_animate'=> 0,
			'key' => be_uniqid_base36(true),
		),$atts, $tag );
		
		extract( $atts );

		$custom_style_tag = be_generate_css_from_atts( $atts, 'special_heading4', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );

		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }

		$output ='';
		$divider_style = ( ! empty( $divider_style ) ) ? $divider_style : 'both' ;
		$caption_tag = 'div';
		
		if ('body' == $caption_font){
			$caption_font_style = 'body-font';
		} elseif ('special' == $caption_font){
			$caption_font_style = 'special-subtitle';
		} else {
			$caption_font_style = '';
			$caption_tag = $caption_font;
		}

		$output .='<div '.$css_id.' class="special-heading-wrap style4 '. $custom_class_name.' oshine-module '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'>';
		$output .= ($divider_style == 'bottom') ? '' : '<div class="vertical-divider top"></div>' ;
		$output .= ($caption_content) ? '<'.$caption_tag.'  class="caption '. $caption_font_style .'">'.$caption_content.'</'.$caption_tag.'>' : '' ;
		$output .='<div class="special-heading "><'.$h_tag.' class="special-h-tag" >'.$title_content.'</'.$h_tag.'></div>';
		$output .= ($divider_style == 'top') ? '' : '<div class="vertical-divider bottom" ></div>' ;
		$output .= $custom_style_tag;
		$output .='</div>';
		return $output;
	}
	add_shortcode( 'special_heading4', 'be_special_heading4' );
}

add_action( 'tatsu_register_modules', 'oshine_register_special_heading4' );
function oshine_register_special_heading4() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#special_heading4',
	        'title' => __( 'Special Title - Style 4', 'oshine_modules' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
			'hint' => 'title_content',
			'is_built_in' => true,
	 		'group_atts' => array (
				array (
					'type'		=> 'tabs',
					'style'		=> 'style1',
					'group'		=> array(
						array (
							'type' => 'tab',
							'title' => __( 'Content', 'tatsu' ),
							'group'	=> array (
								array (
									'type' => 'accordion' ,
									'active' => 'none',
									'group' => array (
										'title_content',
										'caption_content',
										'caption_font',
									)
								)
							)
						),
						array (
							'type' => 'tab',
							'title' => __( 'Style', 'tatsu' ),
							'group'	=> array (
								array (
									'type' => 'accordion' ,
									'active' => 'none',
									'group' => array (
										array (
											'type' => 'panel',
											'title' => __( 'Shape and style', 'tatsu' ),
											'group' => array (
												'divider_style',
												'h_tag',
											)
										),
										array (
											'type' => 'panel',
											'title' => __( 'Colors', 'tatsu' ),
											'group' => array (
												'title_color',
												'caption_color',
												'divider_color',
											)
										),
									)
								),
							),
						),
						array (
							'type' => 'tab',
							'title' => __( 'Advanced', 'tatsu' ),
							'group'	=> array (

							),
						)
					)
				)
			),
	        'atts' => array (
	            array (
	        		'att_name' => 'title_content',
	        		'type' => 'text',
	        		'label' => __( 'Title', 'oshine_modules' ),
	        		'default' => '',
	        		'tooltip' => '',
        			
	        	),
	        	array (
	        		'att_name' => 'h_tag',
	        		'type' => 'button_group',
	        		'label' => __( 'Heading tag to use for Title', 'oshine_modules' ),
	        		'options' => array (
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6'
					),
	        		'default' => 'h5',
	        		'tooltip' => '',
        			
	        	),
	        	array (
		            'att_name' => 'title_color',
		            'type' => 'color',
		            'label' => __( 'Title Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-h-tag' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'caption_content',
	        		'type' => 'text',
	        		'label' => __( 'Caption', 'oshine_modules' ),
	        		'default' => '',
	        		'tooltip' => '',
        			
	        	),
	        	array (
	        		'att_name' => 'caption_font',
	        		'type' => 'select',
	        		'label' => __( 'Font Family to apply for caption', 'oshine_modules' ),
	        		'options' => array (
						'body'=> 'Body', 
						'special' => 'Special Title Font', 
						'h6' => 'H6', 
						'h5' => 'H5', 
						'h4' => 'H4', 
						'h3' => 'H3', 
						'h2' => 'H2', 
						'h1' => 'H1'
					),
	        		'default' => 'h6',
					'tooltip' => '',
					'is_inline' => false,
        			
	        	),
	        	array (
		            'att_name' => 'caption_color',
		            'type' => 'color',
		            'label' => __( 'Caption Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .caption' => array(
							'property' => 'color'
						)
					)	
	            ),
	            array (
	        		'att_name' => 'divider_style',
	        		'type' => 'button_group',
	        		'label' => __( 'Divider Style', 'oshine_modules' ),
	        		'options' => array(
	        			'bottom'=> 'Bottom', 
	        			'both' => ' Top and Bottom', 
	        			'top' => 'Top'
	        		),
	        		'default' => 'both',
	        		'tooltip' => '',	
	        	),
	        	array (
		            'att_name' => 'divider_color',
		            'type' => 'color',
		            'label' => __( 'Divider Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap .vertical-divider' => array(
							'property' => 'background'
						)
					),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'title_content' => 'TATSU IS AWESOME',
	        			'h_tag' => 'h3',
	        			'caption_content' => 'A Live Front End Page Builder for Wordpress',
	        			'caption_font' => 'special',
	        			'divider_color' => '#efefef',
	        			'divider_style' => 'both'
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'special_heading4', $controls );
}