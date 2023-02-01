<?php
/**************************************
			CONTENT MARQUEE
**************************************/
if (!function_exists('be_content_marquee')) {	
	function be_content_marquee( $atts, $content, $tag ){
		global $be_themes_data;
		extract( shortcode_atts( array (
			'animation_duration' => '',
			'marquee_element_padding'=>'',
			'image_padding'=>'',
			'title_padding'=>'',
			'bg_color'=>'',
			'key' => be_uniqid_base36(true),
		), $atts, $tag ) );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		 		
		$data_animations = be_get_animation_data_atts( $atts );
		$style_tag = '';
		if(!empty($animation_duration)){
		$style_tag .= '<style>.oshine-module.'.$unique_class_name.' .content_marquee_module {
			animation-duration:'.$animation_duration.'s;
		}</style>';
		}
		$css_classes = isset($css_classes)?$css_classes:'';
		$marquee_element=do_shortcode( $content );
		$return = '<div '.$css_id.' class="oshine-module  content-marquee-wrap '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'>'.$style_tag.'<div class=" content-marquee clearfix"><ul class="clearfix marquee content_marquee_module clearfix">'.$marquee_element.'</ul><ul class="clearfix marquee content_marquee_module clearfix">'.$marquee_element.'</ul><ul class="clearfix marquee content_marquee_module clearfix">'.$marquee_element.'</ul></div>'.$custom_style_tag.'</div>';
		return $return;	
	}	
	add_shortcode( 'content_marquee', 'be_content_marquee' );
}

if (!function_exists('be_marquee_element')) {	
	function be_marquee_element( $atts, $content){
		extract( shortcode_atts( array (
			'image' => '',
			'image_width'=>'30',
			'element_title'=>''
		), $atts ) );
		$output = '<li class="marquee-element-container">
		<div class="marquee-element-wrapper">';
		if(!empty($image)){
			$output .= '<div class="marquee-image ">
			<img src="'.esc_url($image).'" width="'.esc_attr($image_width).'" height="auto">
			</div>';
		}
		if(!empty($element_title)){
			$output .='<p class="marquee-title">'.esc_html( $element_title ).'</p>';
		}
		$output .= '</div></li>';
		return $output;
	}	
	add_shortcode( 'marquee_element', 'be_marquee_element' );
}

if( !function_exists( 'oshine_modules_remove_common_atts_from_marquee_element' ) ) {
	add_filter( 'tatsu_default_common_atts_global_excludes', 'oshine_modules_remove_common_atts_from_marquee_element' );
	function oshine_modules_remove_common_atts_from_marquee_element( $excludes_array ) {
		$excludes_array[] = 'marquee_element';
		return $excludes_array;
	}
 }

add_action( 'tatsu_register_modules', 'oshine_register_content_marquee');
function oshine_register_content_marquee() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#content_slider',
	        'title' => __( 'Content Marquee', 'oshine-modules' ),
	        'is_js_dependant' => false, //custom implementation
	        'child_module' => 'marquee_element',
	        'type' => 'multi',
	        'initial_children' => 3,
			'is_built_in' => false,
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
											'title'	=>	__( 'Marquee Settings' , 'oshine-modules'),
											'group'	=>	array (
												'bg_color',
												'animation_duration'
											)
										),
										array(
											'type' => 'panel',
											'title' => __('Typography', 'oshine-modules'),
											'group' => array(
												'title_typography'
											)
										),
										array(
											'type' => 'panel',
											'title' => __('Spacing', 'oshine-modules'),
											'group' => array(
												'marquee_element_padding',
												'image_padding',
												'title_padding'
											)
										),
									)
								),
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
					'att_name' => 'bg_color',
					'type' => 'color',
					'label' => __( 'Background Color', 'oshine-modules' ),
					'default' => '',//sec_bg
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.content-marquee-wrap' => array(
							'property' => 'background'
						),
					),
				),
				array (
	        		'att_name' => 'animation_duration',
					'type' => 'slider',
					'options' => array(
	        			'min' => '0',
	        			'max' => '50',
	        			'step' => '5',
	        			'unit' => 's',
					),
	        		'label' => __( 'Speed', 'oshine-modules' ),
	        		'default' => '15',
	        		'tooltip' => ''
	        	), 
				array(
					'att_name' => 'title_typography',
					'type' => 'typography',
					'label' => __( 'Title Text', 'spyro-modules' ),
					'responsive' => true,
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'is_inline' => true,
					'selectors' => array(
						'.tatsu-{UUID} .marquee-element-container .marquee-element-wrapper .marquee-title' => array(
							'property' => 'typography',
						)
					),
				),
				array(
					'att_name' => 'marquee_element_padding',
					'type' => 'input_group',
					'label' => __( 'Marquee Element Padding', 'spyro-modules' ),
					'responsive' => true,
					'default' => '0px 30px 0px 0px',
					'tooltip' => '',
					'css' => true,
					'is_inline' => false,
					'selectors' => array(
						'.tatsu-{UUID} .content_marquee_module .marquee-element-container' => array(
							'property' => 'padding',
						)
					),
				),
				array(
					'att_name' => 'image_padding',
					'type' => 'input_group',
					'label' => __( 'Image Padding', 'spyro-modules' ),
					'responsive' => true,
					'default' => '10px 10px 10px 10px',
					'tooltip' => '',
					'css' => true,
					'is_inline' => false,
					'selectors' => array(
						'.tatsu-{UUID} .marquee-element-container .marquee-element-wrapper .marquee-image' => array(
							'property' => 'padding',
						)
					),
				),
				array(
					'att_name' => 'title_padding',
					'type' => 'input_group',
					'label' => __( 'Title Padding', 'spyro-modules' ),
					'responsive' => true,
					'default' => '0px 0px 0px 0px',
					'tooltip' => '',
					'css' => true,
					'is_inline' => false,
					'selectors' => array(
						'.tatsu-{UUID} .marquee-element-container .marquee-element-wrapper .marquee-title' => array(
							'property' => 'padding',
						)
					),
				),
				
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'animation_duration' => '15',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'content_marquee', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_marquee_element');
function oshine_register_marquee_element() {
	$controls = array (
		'icon' => '',
		'title' => __( 'Marquee Element', 'oshine-modules' ),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'sub_module',
		'is_built_in' => false,
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
							'image_width',
							'element_title',
						)
					),
					array (
						'type'	=>	'tab',
						'title'	=>	__( 'Style' , 'tatsu'),
						'group'	=>	array (
							
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
				  'label' => __( 'Choose a image', 'oshine-modules' ),
				  'tooltip' => '',
			),
			array (
				'att_name' => 'image_width',
				'type' => 'text',
				'label' => __( 'Image Width', 'oshine-modules' ),
				'default' => '30',
				'tooltip' => '',
				'is_inline' => false,
			),
			array (
				'att_name' => 'element_title',
				'type' => 'text',
				'label' => __( 'Title', 'oshine-modules' ),
				'default' => '',
				'tooltip' => ''
			 ),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'image' => 'https://via.placeholder.com/30x30',
					'element_title' => 'title'
				),
			)
		),
	);
	tatsu_register_module( 'marquee_element', $controls );
}