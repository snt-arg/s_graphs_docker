<?php
/**************************************
			CLIENTS
**************************************/
if ( ! function_exists( 'be_clients' ) ) {
	function be_clients($atts, $content, $tag) {
		global $be_themes_data;
		$atts = shortcode_atts( array(
			'slide_show' => '1',
			'slide_show_speed' => 4000,
			'show_dots' => '0',
			'key' => be_uniqid_base36(true),
	    ), $atts, $tag );

		extract( $atts );
		
		$slide_show = ( !empty( $slide_show ) ) ? 1 : 0;
		$custom_style_tag = be_generate_css_from_atts( $atts, 'clients', $key );
		$custom_class_name = ' tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );

		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
    	}

		$slide_show_speed = ( !empty( $slide_show_speed ) ) ? $slide_show_speed : 4000 ;
		$output = '<div '.$css_id.' class="carousel-wrap oshine-module clearfix '.$custom_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.' >';
		// $output .='<ul class="be-carousel client-carousel" data-slide-show="'.$slide_show.'" data-slide-show-speed="'.$slide_show_speed.'">';
		$output .= '<ul class="be-owl-carousel client-carousel-module" data-slide-show="'.$slide_show.'" data-slide-navigation-dots="'.$show_dots.'" data-slide-show-speed="'.$slide_show_speed.'">';
		$output .= do_shortcode($content);
		$output .= '</ul>';
		// $output .='<a class="prev be-carousel-nav" href="#"><i class="font-icon icon-arrow_carrot-left"></i></a><a class="next be-carousel-nav" href="#"><i class="font-icon icon-arrow_carrot-right"></i></a>';
		$output .= $custom_style_tag;
		$output .='</div>';
		return $output;
	}
	add_shortcode('clients','be_clients');
}

if ( ! function_exists( 'be_client' ) ) {
	function be_client( $atts, $content, $tag ) {
		extract( shortcode_atts( array(
			'image' => '',
			'link' => '',
			'new_tab'=> 1,
			'default_image_style' => 'color',
			'hover_image_style' => 'color',
			'css_classes' => '',
			'key' => be_uniqid_base36(true),
	    ), $atts, $tag ) );

		$custom_style_tag = be_generate_css_from_atts( $atts, 'client', $key );
		$custom_class_name = ' tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );

		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
			$css_classes .= ' tatsu-animate ';
		}

	  	$output =  '';
		if($default_image_style == 'black_white') {
			if($hover_image_style == 'black_white') {
				$img_grayscale = 'bw_to_bw';
			} else {
				$img_grayscale = 'bw_to_c';
			}
		} else {
			if($hover_image_style == 'black_white') {
				$img_grayscale = 'c_to_bw';
			} else {
				$img_grayscale = 'c_to_c';
			}
		}

		$new_tab = ( isset( $new_tab ) && 1 == $new_tab ) ? 'target="_blank"' : '' ;
	    $link = ( !empty( $link ) ) ? $link : '#' ; 
	   // $attachment = wp_get_attachment_image_src( $image , 'full');
	   // $url = $attachment[0];
	    $output .= ( !empty( $image ) ) ? '<li '.$css_id.' class="carousel-item client-carousel-item '.$img_grayscale.' '.$custom_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.' ><a href="'.$link.'" '.$new_tab.'><img src="'.$image.'" alt="" /></a>'.$custom_style_tag.'</li>' : '' ;
	   // $output .= ( $url ) ? '<li class="carousel-item client-carousel-item '.$img_grayscale.'"><img src="'.$url.'" alt="" /></li>' : '' ;
	    return $output;
	}
	add_shortcode( 'client', 'be_client' );
}

add_action( 'tatsu_register_modules', 'oshine_register_clients');
function oshine_register_clients() {
	$controls = array (
		'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#clients',
		'title' => __( 'Clients', 'oshine-modules' ),
		'is_js_dependant' => false, //custom implementation
		'child_module' => 'client',
		'type' => 'multi',
		'initial_children' => 5,
		'is_built_in' => true,
		'group_atts' => array (
			array (
				'type'	=>	'tabs',
				'style'	=>	'style1',
				'group'	=>	array (
					array (
						'type'	=>	'tab',
						'title'	=>	__( 'Style' , 'tatsu'),
						'group'	=>	array (
							array (
								'type'	=>	'accordion',
								'style'	=>	'style1',
								'group'	=>	array (
									array (
										'type'	=>	'panel',
										'title'	=>	__( 'Slideshow' , 'tatsu'),
										'group'	=>	array (
											'slide_show',
											'slide_show_speed',
											'show_dots'
										)
									),
								)
							),
						)
					),
					array (
						'type'	=>	'tab',
						'title'	=>	__( 'Advanced' , 'tatsu'),
						'group'	=>	array (

						),
					)
				)
			),
		),
		'atts' => array (
			array(
				'att_name' => 'slide_show',
				'type' => 'switch',
				'label' => __( 'Enable Slide Show', 'oshine-modules' ),
				'default' => '0',
				'tooltip' => ''
			),
			array(
				'att_name' => 'slide_show_speed',
				'type' => 'slider',
				'label' => __( 'Slide Show Speed', 'oshine-modules' ),
				'options' => array(
					'min' => '0',
					'max' => '10000',
					'step' => '1000',
					'unit' => 'ms',
				),		        		
				'default' => '4000',
				'tooltip' => ''
			),
			array(
				'att_name' => 'show_dots',
				'type' => 'switch',
				'label' => __( 'Show Navigation Dots', 'oshine-modules' ),
				'default' => '0',
				'tooltip' => ''
			),
		),
	);
	tatsu_register_module( 'clients', $controls );
}

add_action( 'tatsu_register_modules', 'oshine_register_client' );
function oshine_register_client() {
	$controls = array (
		'icon' => '',
		'title' => __( 'Client', 'oshine-modules' ),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'sub_module',
		'is_built_in' => true,
		'group_atts' => array (
			array (
				'type'	=>	'tabs',
				'style'	=>	'style1',
				'group'	=>	array (
					array (
						'type'	=>	'tab',
						'title'	=>	__( 'Content' , 'tatsu'),
						'group'	=>	array (
							'image',
							'link',
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
											'default_image_style',
											'hover_image_style',
										)
									),
								)
							)
						),
					),
					array (
						'type'	=>	'tab',
						'title'	=>	__( 'Advanced' , 'tatsu'),
						'group'	=>	array (

						),
					)
				)
			),
		),
		'atts' => array (
			array (
				'att_name' => 'image',
				'type' => 'single_image_picker',
				'label' => __( 'Choose a Client image', 'oshine-modules' ),
				'tooltip' => '',
			),
			array (
				'att_name' => 'link',
				'type' => 'text',
				'label' => __( 'URL to be linked to Client Website', 'oshine-modules' ),
				'default' => '',
				'tooltip' => '',
				'is_inline' => false,
			),
			array (
				'att_name' => 'new_tab',
				'type' => 'switch',
				'label' => __( 'Open Link in New tab', 'oshine-modules' ),
				'default' => '1',
				'tooltip' => ''
			),
			array (
				'att_name' => 'default_image_style',
				'type' => 'button_group',
				'label' => __( 'Default Image Style', 'oshine-modules' ),
				'options' => array (
					'black_white' => 'Black And White', 
					'color' => 'Color',
				),
				'default' => 'color',
				'tooltip' => ''
			),
			array (
				'att_name' => 'hover_image_style',
				'type' => 'button_group',
				'label' => __( 'Hover Image Style', 'oshine-modules' ),
				'options' => array (
					'black_white' => 'Black And White', 
					'color' => 'Color',
				),
				'default' => 'color',
				'tooltip' => ''
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'image' => 'https://via.placeholder.com/300x100',
				),
			)
		),
	);
	tatsu_register_module( 'client', $controls );
}
