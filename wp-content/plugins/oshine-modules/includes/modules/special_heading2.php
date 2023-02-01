<?php

/**************************************
			SPECIAL TITLE 2
**************************************/
if (!function_exists('be_special_heading2')) {
	function be_special_heading2( $atts, $content, $tag ) {

		//$padding = $atts['padding'];
		$atts = shortcode_atts( array(
			'title_content' => '',
			'h_tag' => 'h3',
			'title_color' => '',
	        'border_color' => '',
	        'border_thickness' => '2',
	        'title_padding_vertical' => '20px',
			'title_padding_horizontal' => '20px',
			'padding' => '20px 30px 20px 30px',
	        'padding_value' => 'px',
			'title_alignment' => 'center',
			'border_style',
			'scroll_to_animate'=> 0,
			'key' => be_uniqid_base36(true),
		),$atts, $tag );		


		extract( $atts );
		//$atts['padding'] = $padding;
		$custom_style_tag = be_generate_css_from_atts( $atts, 'special_heading2', $key );
		$unique_class_name = 'tatsu-'.$key;

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );

		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
			$css_classes .= ' tatsu-animate ';
		}

	    $output ='';
		$output .='<div '.$css_id.' class="special-heading-wrap style2 oshine-module align-'.$title_alignment.' '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'><div class="special-heading" >';
		$output .= ($title_content) ? '<'.$h_tag.' class="special-h-tag" >'.$title_content.'</'.$h_tag.'>' : '' ;
		$output .='</div>'.$custom_style_tag.'</div>';
		return $output;
	}
	add_shortcode( 'special_heading2', 'be_special_heading2' );
}


add_action( 'tatsu_register_modules', 'oshine_register_special_heading2');
function oshine_register_special_heading2() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#special_heading2',
	        'title' => __( 'Special Title - Style 2', 'oshine_modules' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
			'hint' => 'title_content',
			'is_built_in' => true,
			'group_atts' => array (
				array (
					'type'	=> 'tabs',
					'style'	=> 'style1',
					'group'	=> array(
						array (
							'type' => 'tab',
							'title' => __( 'Content', 'tatsu' ),
							'group'	=> array (
								array (
									'type' => 'accordion' ,
									'active' => 'none',
									'group' => array (
										'title_content',
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
									'active' => array(0),
									'group' => array (
										array (
											'type'	=> 'panel',
											'title'	=> __( 'Shape and size', 'tatsu' ),
											'group'	=> array (
												'h_tag',
												'title_alignment',
												'border_thickness',
											),
										),
										array (
											'type'	=> 'panel',
											'title'	=> __( 'Colors', 'tatsu' ),
											'group'	=> array (
												'title_color',
												'border_color',
											),
										),
									)
								),
							)
						),
						array (
							'type' => 'tab',
							'title' => __( 'Advanced', 'tatsu' ),
							'group'	=> array (
								array (
									'type' => 'accordion' ,
									'active' => 'none',
									'group' => array (
										array (
											'type'	=> 'panel',
											'title'	=> __( 'Spacing', 'tatsu' ),
											'group'	=> array (
												'margin',
												'padding'
											)
										)
									)
								)
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
	        		'label' => __( 'tag to use for Title', 'oshine_modules' ),
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
					'is_inline' => true,
        			
	        	),
	        	array (
		            'att_name' => 'title_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
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
		            'att_name' => 'border_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Border Color', 'oshine_modules' ),
		            'default' => '', //color_scheme
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-heading' => array(
							'property' => 'border-color',
							'when' => array( 'border_thickness', '!=', '0' ),
						),
					),
        			
	            ),
	            array (
	        		'att_name' => 'border_thickness',
	        		'type' => 'number',
	        		'label' => __( 'Border Thickness', 'oshine_modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '2',
					'tooltip' => '',
					'css' => true,
					'is_inline' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-heading' => array(
							'property' => 'border-width',
							'append' => 'px'
						),
					),
        			
	        	),
	        	array (
	        		'att_name' => 'padding',
	        		'type' => 'input_group',
	        		'label' => __( 'Padding', 'oshine_modules' ),
	        		'default' => '20px 30px 20px 30px',
					'tooltip' => '',
					'css' => true,
					'responsive' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-heading' => array(
							'property' => 'padding',
						),
					),
				),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'oshine_modules' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'responsive' => true,
					'selectors' => array(
						'.tatsu-{UUID}' => array(
							'property' => 'margin',
							'when' => array( 'margin', '!=', array( 'd' => '0px 0px 30px 0px' ) ),
						),
					),
				),
	        	array (
	        		'att_name' => 'title_alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Title Alignment', 'oshine_modules' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'center',
	        		'tooltip' => '',
					'is_inline' => true,
        			
				),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'title_content' => 'TATSU IS AWESOME',
	        			'h_tag' => 'h3',
	        			'separator_thickness' => '1',
	        			'border_thickness' => '5',
	        			'border_color' => '#232323',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'special_heading2', $controls );
}