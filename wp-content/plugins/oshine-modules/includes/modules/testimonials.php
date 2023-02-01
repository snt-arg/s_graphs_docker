<?php
/**************************************
			TESTIMONIALS
**************************************/
if (!function_exists('be_testimonials')) {	
	function be_testimonials( $atts, $content, $tag ){
		global $be_themes_data;
		$atts = shortcode_atts( array (
			'testimonial_font_size' => '14',
			'author_role_font' => 'body',
			'alignment' => 'center',
			'slide_animation_type' => 'slide',
			'slide_show' => '0',
			'slide_show_speed' => 4000,
			'pagination' => 0,
			'key' => be_uniqid_base36(true),
		), $atts, $tag );
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
		$unique_class_name = 'tatsu-'.$atts['key'];

		$GLOBALS['testimonial_font_size_global'] = 	$testimonial_font_size;
		$GLOBALS['author_role_font_global'] = $author_role_font;
		$slide_animation_type = ( isset( $slide_animation_type ) && !empty($slide_animation_type) ) ? $slide_animation_type : 'slide' ;
		$slide_show = ( !empty( $slide_show ) ) ? 1 : 0;
		$slide_show_speed = ( !empty( $slide_show_speed ) ) ? $slide_show_speed : 4000 ;
		$alignment = (isset( $alignment ) && !empty( $alignment )) ? $alignment : 'center';
        $pagination = (empty($pagination) || (!empty($pagination) && $pagination == 0)) ? '0' : '1' ; 
        
        $css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
        $data_animations = be_get_animation_data_atts( $atts );
        $classes = array( $unique_class_name, 'testimonials_wrap', 'oshine-module' );
        if( !empty( $visibility_classes ) ) {
            $classes[] = $visibility_classes;
        }
        if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        if( !empty( $css_classes ) ) {
            $classes[] = $css_classes;
        }

		$return = '<div ' . $css_id . ' class="' . implode( ' ', $classes ) . '" ' . $data_animations . ' ><div class="testimonials-slides"><div class="clearfix testimonial_module slides '.$alignment.'-content" data-slide-show="'.$slide_show.'" data-slide-show-speed="'.$slide_show_speed.'" data-slide-animation-type="'.$slide_animation_type.'" data-pagination="'.$pagination.'">'.do_shortcode( $content ).'</div></div>'.$custom_style_tag.'</div>';		
		return $return;	
	}	
	add_shortcode( 'testimonials', 'be_testimonials' );
}

if (!function_exists('be_testimonial')) {	
	function be_testimonial( $atts, $content ) {
		$atts = shortcode_atts( array (
			'author_image' => '',
			'quote_color'=> '',
			'author' => '',
			'author_color'=> '',
			'author_role' => '',
			'author_role_color' => '',
			'key' => be_uniqid_base36(true),
		),$atts );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'testimonial', $key );
		$unique_class_name = 'tatsu-'.$key;
		$output = '';


		$content= do_shortcode($content);		
		extract($atts);
		if(isset($GLOBALS['author_role_font_global'])) {
			if ('h6' == $GLOBALS['author_role_font_global']){
				$author_role_font_style = 'h6-font';
			} elseif ('special' == $GLOBALS['author_role_font_global']){
				$author_role_font_style = 'special-subtitle';
			} else {
				$author_role_font_style = '';
			}
		} else {
			$author_role_font_style = '';
		}
		if(isset($GLOBALS['testimonial_font_size_global'])) {
			$global_testimonial_font_size = $GLOBALS['testimonial_font_size_global'];
		} else {
			$global_testimonial_font_size = '';
		}
		$output = '';
		$alt_text = $author;
		$author = (isset( $author ) && !empty( $author )) ? '<h6 class="testimonial-author" >'.$author.'</h6>' : '';
		$author_role = (isset( $author_role ) && !empty( $author_role )) ? '<div class="testimonial-author-role '.$author_role_font_style.'"  >'.$author_role.'</div>' : '';
		if ( !empty( $author_image ) ) {
				$author_image =  '<div class="testimonial-author-img"><img src="'.$author_image.'" alt="'.$alt_text.'" /></div>';
		}
		$output .= '<div class="testimonial_slide slide clearfix '.$unique_class_name.'"><div class="testimonial_slide_inner">';
		$output .= '<i class="font-icon icon-quote" ></i>';
		$output .= '<div class="testimonial-content">'.$content.'</div>';
		$output .= '<div class="testimonial-author-info-wrap clearfix">';
		$output .= $author_image;
		$output .= '<div class="testimonial-author-info">';
		$output .= $author;
		$output .= $author_role;
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>'.$custom_style_tag.'</div>';
		return $output;
	}	
	add_shortcode( 'testimonial', 'be_testimonial' );
}


add_action( 'tatsu_register_modules', 'oshine_register_testimonials', 11);
function oshine_register_testimonials() {
	$controls = array (
		'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#testimonials',
		'title' => __( 'Testimonials', 'oshine-modules' ),
		'is_js_dependant' => false, //custom js implementation
		'child_module' => 'testimonial',
		'type' => 'multi',
		'initial_children' => 2,
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
                            'pagination',
                            'slide_show',
                            'slide_show_speed',
                            'alignment',
                            'testimonial_font_size',
                            'author_role_font',
						),
					),
					array (
						'type'	=>	'tab',
						'title'	=>	__( 'Advanced' , 'tatsu'),
						'group'	=>	array (

						),
					),
				),
			),
		),
		'atts' => array (
			array (
				'att_name' => 'testimonial_font_size',
				'type' => 'slider',
				'label' => __( 'Testimonial Font Size', 'oshine-modules' ),
				'options' => array(
                    'unit' => 'px',
                    'min'   => '1',
                    'max' => '100'
 				),
				'default' => '14',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .testimonial-content' => array(
						'property' => 'font-size',
						'append' => 'px',
					),
				),
			),
			array (
				'att_name' => 'author_role_font',
				'type' => 'select',
				'label' => __( 'Author Role - Font Type', 'oshine-modules' ),
				'options' => array (
					'body'=> 'Body', 
					'special' => 'Special Title Font', 
					'h6' => 'Heading 6'
				),
				'default' => 'h6',
				'tooltip' => ''
			),
			array (
				'att_name' => 'alignment',
                'type' => 'button_group',
                'is_inline' => true,
				'label' => __( 'Alignment', 'oshine-modules' ),
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right'
				),
				'default' => 'center',
				'tooltip' => ''
			),
			array (
				'att_name' => 'pagination',
				'type' => 'switch',
				'label' => __( 'Pagination', 'oshine-modules' ),
				'default' => false,
				'tooltip' => '',
			),
			array (
				'att_name' => 'slide_show',
				'type' => 'switch',
				'label' => __( 'Slide Show', 'oshine-modules' ),
				'default' => 'no',
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
				'default' => '4000',
				'tooltip' => ''
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'testimonial_font_size' => '22',
				),
			)
		),
	);
	if( function_exists( 'tatsu_remap_modules' ) ) {
		tatsu_remap_modules( [ 'testimonials', 'tatsu_testimonials_carousel' ], $controls, 'be_testimonials' );
	}else {
		tatsu_register_module( 'testimonials', $controls );
	}
}


add_action( 'tatsu_register_modules', 'oshine_register_testimonial', 11);
function oshine_register_testimonial() {
	$controls = array (
		'icon' => '',
		'title' => __( 'Testimonial', 'oshine-modules' ),
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
							'author',
							'author_role',
							'author_image',
							'content',
						),
					),
					array (
						'type'	=>	'tab',
						'title'	=>	__( 'Style' , 'tatsu'),
						'group'	=>	array (
                            'quote_color',
                            'author_color',
                            'author_role_color',
						),
					),
				),
			),
		),
		'atts' => array (
			array (
				'att_name' => 'content',
				'type' => 'tinymce',
				'label' => __( 'Testimonial Content', 'oshine-modules' ),
				'default' => '',
				'tooltip' => ''
			),
			array (
				'att_name' => 'author_image',
				'type' => 'single_image_picker',
				'options' => array(
					'size' => 'thumbnail',
				),
				'label' => __( 'Testimonial Author Image', 'oshine-modules' ),
				'tooltip' => '',
			),
			array (
				'att_name' => 'quote_color',
				'type' => 'color',
				'label' => __( 'Quote Icon Color', 'oshine-modules' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .icon-quote' => array(
						'property' => 'color',
					),
				),
			),
			array (
				'att_name' => 'author',
				'type' => 'text',
				'label' => __( 'Testimonial Author', 'oshine-modules' ),
				'default' => '',
				'tooltip' => ''
			),
			array (
				'att_name' => 'author_color',
				'type' => 'color',
				'label' => __( 'Testimonial Author Text Color', 'oshine-modules' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .testimonial-author' => array(
						'property' => 'color',
					),
				),
			),
			array (
				'att_name' => 'author_role',
				'type' => 'text',
				'label' => __( 'Testimonial Author Role', 'oshine-modules' ),
				'default' => '',
				'tooltip' => ''
			),
			array (
				'att_name' => 'author_role_color',
				'type' => 'color',
				'label' => __( 'Testimonial Author Role Color', 'oshine-modules' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .testimonial-author-role' => array(
						'property' => 'color',
					),
				),
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.',
					'author_image' => 'https://via.placeholder.com/100x100',
					'author' => 'Swami',
					'author_role' => 'Designer',
				),
			)
		),
	);
	if( function_exists( 'tatsu_remap_modules' ) ) {
		tatsu_remap_modules(['testimonial', 'tatsu_testimonial_carousel'], $controls, 'be_testimonial');
	}else {
		tatsu_register_module( 'testimonial', $controls );
	}
}


if( !function_exists( 'oshine_modules_remove_common_atts_from_testimonial' ) ) {
    add_filter( 'tatsu_default_common_atts_global_excludes', 'oshine_modules_remove_common_atts_from_testimonial' );
    function oshine_modules_remove_common_atts_from_testimonial( $excludes_array ) {
        $excludes_array[] = 'testimonial';
        return $excludes_array;
    }
}