<?php
/**************************************
			SKILlS
**************************************/
if ( ! function_exists( 'be_skills' ) ) {
	function be_skills( $atts, $content, $tag ) {
		$atts = shortcode_atts( array( 
			'direction' => 'horizontal',
			'height' => 400,
			'key' => be_uniqid_base36(true),
		),$atts, $tag );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'skills', $key );
		$custom_class_name = ' tatsu-'.$key;

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );

		global $direction_global;
		$direction = ( isset($direction) && !empty($direction) ) ? $direction : 'horizontal' ;
		$direction_global = $direction;

		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }

		return '<div '.$css_id.' class="skill_container oshine-module skill-'.$direction.' '.$custom_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.' ><div class="skill clearfix">'.do_shortcode( $content ).'</div>'.$custom_style_tag.'</div>';
	}
	add_shortcode( 'skills', 'be_skills' );
}

if ( ! function_exists( 'be_skill' ) ) {
	function be_skill( $atts, $content, $tag ) {
		global $be_themes_data;
		$atts =  shortcode_atts( array( 
			'title' => '',
			'value' => '',
			'fill_color' => '',
			'bg_color' => '',
			'title_color' => '',
			'css_classes' => '',
			'key' => be_uniqid_base36(true),
		),$atts, $tag );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'skill', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );

		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }

		global $direction_global;
		$output = '<div '.$css_id.' class="skill-wrap ' . $custom_class_name . ' '.$visibility_classes.' '.$css_classes.' " '.$data_animations.'>';
		if('horizontal' == $direction_global){
			$output .= '<span class="skill_name" >'.$title.'</span>';
			$output .= '<div class="skill-bar"><span class="be-skill expand alt-bg alt-bg-text-color" data-skill-value="'.$value.'%" ></span></div>';
		}
		if('vertical' == $direction_global){
			$output .= '<div class="skill-bar"><span class="be-skill expand alt-bg alt-bg-text-color" data-skill-value="'.$value.'%" ></span></div>';
			$output .= '<span class="skill_name" >'.$title.'</span>';
		}
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'skill', 'be_skill' );
}

add_action( 'tatsu_register_modules', 'oshine_register_skills', 11 );
function oshine_register_skills() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#skills',
	        'title' => __( 'Skills', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'child_module' => 'skill',
	        'type' => 'multi',
	        'initial_children' => 4,
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
										array (
											'type' => 'panel',
											'title' => __( 'Shape and style', 'tatsu' ),
											'group' => array (
												'direction',
												'height',
											)
										)
									)
								),
							),
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Advanced' , 'tatsu'),
							'group'	=>	array (

							),
						)
					),
				),
			),
	        'atts' => array (
	            array (
	        		'att_name' => 'direction',
	        		'type' => 'button_group',
	        		'label' => __( 'Direction', 'oshine-modules' ),
	        		'options' => array (
						'horizontal' => 'Horizontal', 
						'vertical' => 'Vertical'
					),
					'default' => 'horizontal',
					'is_inline' => true,
	        		'tooltip' => ''
	        	),
				array (
	        		'att_name' => 'height',
	        		'type' => 'number',
	        		'label' => __( 'Height', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '400',
					'tooltip' => '',
					'css' => true,
					'visible' => array( 'direction', '=', 'vertical' ),
					'selectors' => array(
						'.tatsu-{UUID}.skill-vertical .skill-bar' => array(
							'property' => 'height',
							'append' => 'px',
						),
					),
	        	),
	        ),
	    );
	tatsu_register_module( 'skills', $controls );
	if( function_exists( 'tatsu_remap_modules' ) ) {
		tatsu_remap_modules( array( 'skills', 'tatsu_skills' ), $controls, 'be_skills' );
	}
}



add_action( 'tatsu_register_modules', 'oshine_register_skill', 11 );
function oshine_register_skill() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Skill', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'child_module' => '',
	        'type' => 'sub_module',
			'hint' => 'title',
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
								'title',
								'value',
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
											'title' => __( 'Colors', 'tatsu' ),
											'group' => array (
												'title_color',
												'bg_color',
												'fill_color',
											)
										)
									)
								),
							),
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Advanced' , 'tatsu'),
							'group'	=>	array (

							),
						)
					),
				),
			),
	        'atts' => array (
	            array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Skill Name', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'title_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Title Color', 'oshine-modules' ),
		            'default' => '', //sec_color
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .skill_name' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'value',
	        		'type' => 'slider',
	        		'label' => __( 'Skill Score', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => '%',
	        		),	
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'fill_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Fill Color', 'oshine-modules' ),
		            'default' => '', //color_scheme
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .be-skill' => array(
							'property' => 'background',
						),
					),
	            ),
	        	array (
		            'att_name' => 'bg_color',
					'type' => 'color',
		            'label' => __( 'Background Color', 'oshine-modules' ),
		            'default' => '', //sec_color
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID} .skill-bar' => array(
						  'property' => 'background',
					  ),
				  ),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'title' => 'Skill',
	        			'fill_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'bg_color' => '#f2f5f8',
	        			'value' => '70',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'skill', $controls );
	if( function_exists( 'tatsu_remap_modules' ) ) {
		tatsu_remap_modules( array( 'skill', 'tatsu_skill' ), $controls, 'be_skill' );
	}
}