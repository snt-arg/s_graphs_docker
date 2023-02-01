<?php
/**************************************
			SPECIAL SUB TITLE 1
**************************************/
if (!function_exists('be_special_subtitle')) {
	function be_special_subtitle( $atts, $content, $tag ) {
		global $be_themes_data;
		$atts = shortcode_atts( array(
			'title_content' => '',
			'font_size' => '18',
			'title_color' => '',
	        'title_alignment' => 'center',
			'scroll_to_animate'=> 0,
			'max_width' => 100,
			'margin_bottom' => 30,
			'animate'=> 0,
			'key' => be_uniqid_base36(true),
		),$atts, $tag );		


		extract( $atts );
		//$atts['padding'] = $padding;
		$custom_style_tag = be_generate_css_from_atts( $atts, 'special_sub_title', $key );
		$unique_class_name = 'tatsu-'.$key;

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );


		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }


	    $output ='';
	    $max_width = (isset($max_width) && !empty($max_width)) ? 'width: '.$max_width.'%' : '';
		$scroll_to_animate = ( isset( $scroll_to_animate ) && 1 == $scroll_to_animate ) ? 'scrollToFade' : $scroll_to_animate ;
		$output .='<div '.$css_id.' class="special-subtitle-wrap  '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.' ><div class="align-'.$title_alignment.'">';
		$output .= ($title_content) ? '<span class="special-subtitle" >'.$title_content.'</span>' : '' ;
		$output .='</div>'.$custom_style_tag.'</div>';
		return $output;
	}
	add_shortcode( 'special_sub_title', 'be_special_subtitle' );
}

add_action( 'tatsu_register_modules', 'oshine_register_special_sub_title');
function oshine_register_special_sub_title() {
		$controls = array (
			'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#special_subtitle',
			'title' => __( 'Sub Title Module', 'oshine-modules' ),
			'is_js_dependant' => false,
			'child_module' => '',
			'type' => 'single',
			'hint' => 'title_content',
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
								'title_content',
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
												'title_alignment',
												'max_width',
												'margin_bottom'
												)
											),
										array (
											'type' => 'panel',
											'title' => __( 'Colors', 'tatsu' ),
											'group' => array (
												'title_color',
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

							)
						),
					)
				),
			),
			'atts' => array (
				array (
					'att_name' => 'title_content',
					'type' => 'text_area',
					'label' => __( 'Sub Title Text', 'oshine-modules' ),
					'default' => '',
					'tooltip' => ''
				),
				array (
					'att_name' => 'font_size',
					'type' => 'number',
					'label' => __( 'Font Size', 'oshine-modules' ),
					'options' => array(
						'unit' => 'px',
					),
					'default' => '18',
					'tooltip' => '',
					'css' => true,
					'is_inline' => true,
					'responsive' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-subtitle' => array(
							'property' => 'font-size',
							'append' => 'px',
						),
					),
				),
				array (
					'att_name' => 'title_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
					'label' => __( 'Title Color', 'oshine-modules' ),
					'default' => '',	//color_scheme
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-subtitle' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'title_alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Title Alignment', 'oshine-modules' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'center',
					'tooltip' => '',
					'is_inline' => true,

	        	),
	        	array (
	        		'att_name' => 'max_width',
	        		'type' => 'slider',
	        		'label' => __( 'Maximum Width', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => '%',
	        		),	
	        		'default' => '60',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-subtitle' => array(
							'property' => 'width',
							'append' => '%',
						),
					),
	        	),
	        	array (
	        		'att_name' => 'margin_bottom',
	        		'type' => 'number',
	        		'label' => __( 'Margin Bottom', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '30',
					'tooltip' => '',
					'css' => true,
					'is_inline' => true,
					'responsive' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-subtitle-wrap' => array(
							'property' => 'margin-bottom',
							'append' => 'px',
						),
					),
	        	),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'title_content' => 'This is a cool subtitle',
	        			'title_alignment' => 'left',
	        			'margin_bottom' => '10',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'special_sub_title', $controls );
}