<?php
/**************************************
			SPECIAL TITLE 5
**************************************/
if (!function_exists('be_special_heading5')) {
	function be_special_heading5( $atts, $content, $tag ) {
		$atts = shortcode_atts( array(
			'title_content' => '',
			'h_tag' => 'h3',
	        'title_color' => '',
	        'title_opacity' => '20',
	        'caption_content' => '',
	        'caption_font' => '',
	        'caption_color' => '',
	        'title_alignment' => 'center',
			'scroll_to_animate'=> 0,
			'key' => be_uniqid_base36(true),
		),$atts, $tag );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

        $css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
        $data_animations = be_get_animation_data_atts( $atts );
        $classes = array( $custom_class_name, 'special-heading-wrap', 'style5', 'oshine-module', 'align-' . $title_alignment );
        if( !empty( $visibility_classes ) ) {
            $classes[] = $visibility_classes;
        }
        if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        if( !empty( $css_classes ) ) {
            $classes[] = $css_classes;
        }

		$output ='';
		
		$caption_tag = 'div';
		if ('body' == $caption_font){
			$caption_font_style = 'body-font';
		} elseif ('special' == $caption_font){
			$caption_font_style = 'special-subtitle';
		} else {
			$caption_font_style = '';
			$caption_tag = $caption_font;
		}

		$output .='<div ' . $css_id . ' class="' . implode( ' ', $classes ) . '" ' . $data_animations . ' >';		
		$output .='<div class="special-heading "><'.$h_tag.' class="special-h-tag">'.$title_content.'</'.$h_tag.'></div>';
		$output .= ($caption_content) ? '<div class="caption-wrap"><'.$caption_tag.' class="caption '. $caption_font_style .'">'.$caption_content.'</'.$caption_tag.'></div>' : '' ;
		$output .= $custom_style_tag;
		$output .='</div>';
		return $output;
	}
	add_shortcode( 'special_heading5', 'be_special_heading5' );
}

add_action( 'tatsu_register_modules', 'oshine_register_special_heading5');
function oshine_register_special_heading5() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#special_heading5',
	        'title' => __( 'Special Title - Style 5', 'oshine_modules' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
			'is_built_in' => true,
			'group_atts' => array (
				array ( 
					'type' => 'tabs',
					'style' => 'style1',
					'group' => array(
						array (
							'type' => 'tab',
							'title' => __( 'Content', 'tatsu' ),
							'group'	=> array (
                                'title_content',
                                'caption_content',
                                'h_tag',
                                'caption_font',
							)
						),
						array (
							'type' => 'tab',
							'title' => __( 'Style', 'tatsu' ),
							'group'	=> array (
                                'title_alignment',
                                'title_color',
                                'caption_color',
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
	        		'type' => 'select',
	        		'label' => __( 'Tag for Title', 'oshine_modules' ),
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
							'property' => 'color'
						)
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
	        		'label' => __( 'Tag for Caption', 'oshine_modules' ),
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
						),
					),
				),
				array (
					'att_name' => 'title_alignment',
                    'type' => 'button_group',
                    'is_inline' => true,
					'label' => __( 'Alignment', 'oshine_modules' ),
					'options' => array(
						'left' => 'Left',
						'center' => 'Center',
						'right' => 'Right'
					),
					'default' => 'center',
					'tooltip' => '',
				),
			),
			'presets' => array(
					'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'title_content' => 'TATSU',
	        			'h_tag' => 'h1',
	        			'title_color' => 'rgba(0,0,0,0.1)',
	        			'caption_content' => 'A Live Front End Page Builder for Wordpress',
	        			'caption_font' => 'special',
	        			'divider_color' => '#efefef',
	        			'divider_style' => 'both'
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'special_heading5', $controls );
}