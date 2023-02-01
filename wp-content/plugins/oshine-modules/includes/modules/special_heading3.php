<?php
/**************************************
			SPECIAL TITLE 3
**************************************/
if (!function_exists('be_special_heading3')) {
	function be_special_heading3( $atts, $content, $tag ) {
		$atts = shortcode_atts( array(
			'title_content' => '',
			'h_tag' => 'h3',
	        'title_color' => '',
	        'sub_title1' => '',
	        'sub_title2' => '',
	        'top_caption_color' => '',
	        'bottom_caption_color' => '',
	        'top_caption_size' => '14',
	        'bottom_caption_size' => '14',
	        'top_caption_font' => 'h6',
	        'bottom_caption_font' => 'h6',
	        'top_caption_separator_color' => '',
	        'bottom_caption_separator_color' => '',
			'scroll_to_animate'=> 0,
			'key' => be_uniqid_base36(true),
		),$atts, $tag );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'special_heading3', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );


		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }

		$output ='';
		if ('body' == $top_caption_font){
			$top_caption_font_style = 'body-font';
		} elseif ('special' == $top_caption_font){
			$top_caption_font_style = 'special-subtitle';
		} else {
			$top_caption_font_style = '';
		}
		if ('body' == $bottom_caption_font) {
			$bottom_caption_font_style = 'body-font';
		} elseif ('special' == $bottom_caption_font){
			$bottom_caption_font_style = 'special-subtitle';
		} else {
			$bottom_caption_font_style = '';
		}

		$output .='<div '.$css_id.' class="special-heading-wrap style3 '.$custom_class_name.' oshine-module '.$animate.' '.$visibility_classes .' '.$css_classes.' " '.$data_animations.'>';
		$output .= ($sub_title1) ? '<div class="caption-wrap top-caption"><h6 class="caption '. $top_caption_font_style .'">'.$sub_title1.'<span class="caption-inner"></span></h6></div>' : '' ;
		$output .='<div class="special-heading align-center"><'.$h_tag.' class="special-h-tag">'.$title_content.'</'.$h_tag.'></div>';
		$output .= ($sub_title2) ? '<div class="caption-wrap bottom-caption"><h6 class="caption '. $bottom_caption_font_style .'">'.$sub_title2.'<span class="caption-inner"></span></h6></div>' : '' ;
		$output .= $custom_style_tag;
		$output .='</div>';
		return $output;
	}
	add_shortcode( 'special_heading3', 'be_special_heading3' );
}

add_action( 'tatsu_register_modules', 'oshine_register_special_heading3' );
function oshine_register_special_heading3() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#special_heading3',
	        'title' => __( 'Special Title - Style 3', 'oshine_modules' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
			'is_built_in' => true,
			'hint' => 'title_content',
			'group_atts' => array (
				array (
					'type'	=>	'tabs',
					'style'	=>	'style1',
					'group'	=>	array(
						array (
							'type' => 'tab',
							'title' => __( 'Content', 'tatsu' ),
							'group'	=> array (
								array (
									'type' => 'accordion' ,
									'active' => 'none',
									'group' => array (
										'title_content',
										'sub_title1',
										'sub_title2',
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
											'title' => __( 'Shape and Size', 'tatsu' ),
											'group' => array (
												'h_tag',
												'top_caption_size',
												'bottom_caption_size',
												'top_caption_font',
												'bottom_caption_font',
											)
										),
										array (
											'type' => 'panel',
											'title' => __( 'Colors', 'tatsu' ),
											'group' => array (
												'title_color',
												'top_caption_color',
												'bottom_caption_color',
												'top_caption_separator_color',
												'bottom_caption_separator_color',
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
	        		'default' => 'h3',
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
	        		'att_name' => 'sub_title1',
	        		'type' => 'text',
	        		'label' => __( 'Top Caption', 'oshine_modules' ),
	        		'default' => '',
	        		'tooltip' => '',
        			
	        	),
	            array (
	        		'att_name' => 'sub_title2',
	        		'type' => 'text',
	        		'label' => __( 'Bottom Caption', 'oshine_modules' ),
	        		'default' => '',
					'tooltip' => '',
					'is_inline' => false, 
        			
	        	),
	        	array (
		            'att_name' => 'top_caption_color',
		            'type' => 'color',
		            'label' => __( 'Top Caption Color', 'oshine_modules' ),
		            'default' => '',
		            'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .top-caption h6' =>array(
							'property' => 'color'
						)
					),
	            ),
	        	array (
		            'att_name' => 'bottom_caption_color',
		            'type' => 'color',
		            'label' => __( 'Bottom Caption Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .bottom-caption h6' =>array(
							'property' => 'color'
						)
					),
        			
	            ),
	            array (
	        		'att_name' => 'top_caption_size',
	        		'type' => 'slider',
	        		'options' => array(
	        			'min' => '1',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => 'px',
	        		),	        		
	        		'label' => __( 'Top Caption Font Size', 'oshine_modules' ),
	        		'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .top-caption h6' =>array(
							'property' => 'font-size',
							'append' => 'px'
						)
					),
        			
	        	),
	            array (
	        		'att_name' => 'bottom_caption_size',
	        		'type' => 'slider',
	        		'options' => array(
	        			'min' => '1',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => 'px',
	        		),		        		
	        		'label' => __( 'Bottom Caption Font Size', 'oshine_modules' ),
	        		'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .bottom-caption h6' =>array(
							'property' => 'font-size',
							'append' => 'px'
						)
					),
        			
	        	),
	        	array (
	        		'att_name' => 'top_caption_font',
	        		'type' => 'button_group',
	        		'label' => __( 'Font for Top Caption', 'oshine_modules' ),
	        		'options' => array(
	        			'body'=> 'Body', 
	        			'special' => 'Special Title Font', 
	        			'h6' => 'H6'
	        		),
	        		'default' => 'h6',
	        		'tooltip' => '',
        			
	        	),
	        	array (
	        		'att_name' => 'bottom_caption_font',
	        		'type' => 'button_group',
	        		'label' => __( 'Font for Bottom Caption', 'oshine_modules' ),
	        		'options' => array(
	        			'body'=> 'Body', 
	        			'special' => 'Special Title Font', 
	        			'h6' => 'H6'
	        		),
	        		'default' => 'h6',
	        		'tooltip' => '',
        			
	        	),
	        	array (
		            'att_name' => 'top_caption_separator_color',
		            'type' => 'color',
		            'label' => __( 'Top Caption Separator Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap.style3 .top-caption .caption .caption-inner' =>array(
							'property' => 'background',
						)
					),
        			
	            ),
	        	array (
		            'att_name' => 'bottom_caption_separator_color',
		            'type' => 'color',
		            'label' => __( 'Bottom Caption Separator Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap.style3 .bottom-caption .caption .caption-inner' =>array(
							'property' => 'background',
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
	        			'sub_title1' => 'POWERFUL & ELEGANT',
	        			'sub_title2' => 'A Live Front End Page Builder for Wordpress',
	        			'top_caption_color' => '#757575',
	        			'bottom_caption_color' => '#757575',
	        			'bottom_caption_font' => 'special',
	        			'top_caption_separator_color' => '#efefef',
	        			'bottom_caption_separator_color' => '#efefef',
	        			'bottom_caption_size' => '18'
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'special_heading3', $controls );
}