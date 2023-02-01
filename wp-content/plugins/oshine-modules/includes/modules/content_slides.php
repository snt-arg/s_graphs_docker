<?php
/**************************************
			CONTENT SLIDER
**************************************/
if (!function_exists('be_content_slides')) {	
	function be_content_slides( $atts, $content, $tag ){
		global $be_themes_data;
		extract( shortcode_atts( array (
			'slide_animation_type' => 'slide',
			'slide_show' => '0',
			'slide_show_speed' => 4000,
			'content_max_width' => 100,
			'bullets_color' => '',
			'animate' => 0,
			'animation_type' => 'fadeIn',
			'key' => be_uniqid_base36(true),
		), $atts, $tag ) );
		$GLOBALS['content_max_width'] = $content_max_width ;
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';  		
		$data_animations = be_get_animation_data_atts( $atts );
		$slide_animation_type = ( isset( $slide_animation_type ) && !empty($slide_animation_type) ) ? $slide_animation_type : 'slide' ;
		$slide_show = ( !empty( $slide_show ) ) ? 1 : 0 ;
		$slide_show_speed = ( !empty( $slide_show_speed ) ) ? $slide_show_speed : 4000 ;
		$bullets_color = ( isset( $bullets_color ) && !empty($bullets_color) ) ? $bullets_color : '#000' ;
		$return = '<div '.$css_id.' class="oshine-module '.$animate.' content-slide-wrap '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'><div class=" content-slider clearfix"><ul class="clearfix slides content_slider_module clearfix" data-slide-show="'.$slide_show.'" data-slide-show-speed="'.$slide_show_speed.'" data-slide-animation-type="'.$slide_animation_type.'">'.do_shortcode( $content ).'</ul></div>'.$custom_style_tag.'</div>';
		return $return;	
	}	
	add_shortcode( 'content_slides', 'be_content_slides' );
}

if (!function_exists('be_content_slide')) {	
	function be_content_slide( $atts, $content ) {
		$content = do_shortcode($content);
		$content_max_width = ( isset( $GLOBALS['content_max_width'] ) && !empty( $GLOBALS['content_max_width'] ) ) ? $GLOBALS['content_max_width'] : 100;
		$output = '';
		$output .= '<li class="content_slide slide clearfix"><div class="content_slide_inner" style="width: '.$content_max_width.'%">';
		$output .= '<div class="content-slide-content">'.be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) ).'</div>';
		$output .= '</div></li>';
		return $output;
	}	
	add_shortcode( 'content_slide', 'be_content_slide' );
}

if( !function_exists( 'oshine_modules_remove_common_atts_from_content_slide' ) ) {
	add_filter( 'tatsu_default_common_atts_global_excludes', 'oshine_modules_remove_common_atts_from_content_slide' );
	function oshine_modules_remove_common_atts_from_content_slide( $excludes_array ) {
		$excludes_array[] = 'content_slide';
		return $excludes_array;
	}
 }

add_action( 'tatsu_register_modules', 'oshine_register_content_slides');
function oshine_register_content_slides() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#content_slider',
	        'title' => __( 'Content Slider', 'oshine-modules' ),
	        'is_js_dependant' => false, //custom implementation
	        'child_module' => 'content_slide',
	        'type' => 'multi',
	        'initial_children' => 3,
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
									'type' => 'accordion' ,
									'active' => array(0, 1),
									'group' => array (
										'content_max_width',
										'slide_show',
										'slide_show_speed',
									)
								)
							),
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Advanced' , 'tatsu'),
							'group'	=>	array (
							)
						),
					)
				),
			),
	        'atts' => array (
	            array (
	        		'att_name' => 'slide_show',
	        		'type' => 'switch',
	        		'label' => __( 'Enable Slide Show', 'oshine-modules' ),
	        		'default' => 0,
	        		'tooltip' => ''
	        	),
	            array (
	        		'att_name' => 'slide_show_speed',
	        		'type' => 'slider',
	        		'label' => __( 'Slide Show Speed', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '10000',
	        			'step' => '1000',
	        			'unit' => 'ms',
					),
					'visible' => array ('slide_show' , '=' , '1'),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'content_max_width',
	        		'type' => 'slider',
	        		'label' => __( 'Content Max Width', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => '%',
	        		),	 	        		
	        		'default' => '100',
	        		'tooltip' => ''
	        	),
	        	// array (
		        //     'att_name' => 'bullets_color',
		        //     'type' => 'color',
		        //     'label' => __( 'Navigation Color', 'oshine-modules' ),
		        //     'default' => '',
		        //     'tooltip' => '',
	         //    ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content_max_width' => '70',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'content_slides', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_content_slide');
function oshine_register_content_slide() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Content Slide', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'sub_module',
			'is_built_in' => true,
			'hint' => 'content',
			'group_atts' => array (
				array (
					'type'	=>	'accordion',
					'style'	=>	'style1',
					'group'	=>	array (
						array (
							'type'	=>	'panel',
							'title'	=>	__( 'Content' , 'tatsu'),
							'group'	=>	array (
								'content',
							)
						),
					)
				),
			),
	        'atts' => array (
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.',
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'content_slide', $controls );
}