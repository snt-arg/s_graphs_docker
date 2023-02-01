<?php
/**************************************
			PRICING TABLE
**************************************/
if ( ! function_exists( 'be_pricing_column' ) ) {
	function be_pricing_column( $atts, $content ) {
		global $be_themes_data;
		$atts = shortcode_atts( array(
			'title'=>'',
			'h_tag'=>'h5',
			'price'=>'',
			'duration'=>'',
			'currency'=>'$',
			'button_text'=>'',
			'button_color'=> '',
			'button_hover_color' => '',
			'button_bg_color' => '',
			'button_bg_hover_color' => '',
			'button_border_color' => '',
			'button_border_hover_color' => '',
			'button_link' => '',
			'highlight' => 'no',
			'style'=> 'style-1',
			'header_bg_color' => '',
			'header_color' => '',
			'animate' => 0,
			'animation_type' => 'fadeIn',
			'key' => be_uniqid_base36(true),
		),$atts );		


		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'pricing_column', $key );
		$unique_class_name = 'tatsu-'.$key;

		$output = '';
		$header_bg_color_cb='';
		$animate = ( isset( $animate ) && 1 == $animate ) ? 'be-animate' : '' ;
		

		$output .= '<ul class="pricing-table sec-border highlight-'.$highlight.' oshine-module '.$animate.' '.$unique_class_name.'" data-animation="'.$animation_type.'">';
	    if( ! empty( $title ) ) {
	    	$output .= ( $style == 'style-1' ) ? '<li class="pricing-title" ><'.$h_tag.' class="sec-color">'.$title.'</'.$h_tag.'></li>' : '<li class="pricing-title" ><'.$h_tag.' class="pricing-title-head-tag" >'.$title.'</'.$h_tag.'></li>' ;
	    }
	    $output .= ( ! empty( $price ) ) ? '<li class="pricing-price"><h2 class="price"><span class="currency">'.$currency.'</span>'.$price.'</h2><span class="pricing-duration special-subtitle">'.$duration.'</span></li>' : '' ; 
	    $output .= do_shortcode( $content );
		// $output .= 	( !empty( $button_text ) && !empty( $button_link ) ) ? '<li class="pricing-button">'.do_shortcode('[tatsu_button button_text= "'.$button_text.'" type= "medium" rounded= "1" icon= "" bg_color ="'.$button_bg_color.'" hover_bg_color = "'.$button_bg_hover_color.'"  border_width= "1" border_color = "'.$button_border_color.'" hover_border_color = "'.$button_border_hover_color.'" color= "'.$button_color.'" hover_color= "'.$button_hover_color.'" url="'.$button_link.'" ]'.$button_text.'[/tatsu_button]').'</li>' : '' ;
		$output .= 	( !empty( $button_text ) && !empty( $button_link ) ) ? '<li class="pricing-button">'.do_shortcode("[tatsu_button button_text= '".$button_text."' type= 'medium' rounded= '1' icon= '' bg_color ='".$button_bg_color."' hover_bg_color = '".$button_bg_hover_color."'  border_width= '1' border_color = '".$button_border_color."' hover_border_color = '".$button_border_hover_color."' color= '".$button_color."' hover_color= '".$button_hover_color."' url='".$button_link."' ]".$button_text."[/tatsu_button]").'</li>' : '' ;
	    $output .= $custom_style_tag.'</ul>';

	    return $output;

	}
	add_shortcode( 'pricing_column', 'be_pricing_column' );
}


if ( ! function_exists( 'be_pricing_feature' ) ) {
	function be_pricing_feature( $atts, $column ) {
		$atts = shortcode_atts( array(
			'feature' => '',
			'highlight' => '',
			'highlight_color' => '',
			'highlight_text_color' => '',
			'key' => be_uniqid_base36(true),
		),$atts );		

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'pricing_feature', $key );
		$unique_class_name = 'tatsu-'.$key;

		$output = '';
		if( ! empty( $feature ) ) {
			if($highlight) {
				$highlight_section = 'highlight';
			} else {
				$highlight_section = 'no-highlight';
			}
			$output .='<li class="pricing-feature '.$highlight_section.' '.$unique_class_name.'" ><span class="pricing-feature-container" >'.$feature.'</span>'.$custom_style_tag.'</li>';
		}
		return $output;
	}
	add_shortcode( 'pricing_feature', 'be_pricing_feature' );
}


add_action( 'tatsu_register_modules', 'oshine_register_pricing_column');
function oshine_register_pricing_column() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#pricing_table',
	        'title' => __( 'Pricing Table', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => 'pricing_feature',
	        'type' => 'multi',
	        'initial_children' => 5,
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
								'title',
								'price',
								'duration',
								'currency',
								'button_text',
								'button_link',
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
												'style',
												'h_tag',
												'highlight',
												)
											),
										array (
											'type' => 'panel',
											'title' => __( 'Colors', 'tatsu' ),
											'group' => array (
													'header_color',
													'header_bg_color',
													array (
													'type'	=>	'tabs',
													'style'	=>	'style1',
													'group'	=>	array (
														array (
															'type'	=>	'tab',
															'title'	=>	__( 'Normal' , 'tatsu'),
															'group'	=>	array(
																'button_color',
																'button_bg_color',
																'button_border_color',
															)
														),
														array (
															'type'	=>	'tab',
															'title'	=>	__( 'Hover' , 'tatsu'),
															'group'	=>	array(
																'button_hover_color',
																'button_bg_hover_color',
																'button_border_hover_color',
															)
														),
													)
												),
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
									array(
									'type' => 'accordion' ,
									'active' => array(0, 1),
									'group' => array (
										array (
											'type' => 'panel',
											'title' => __( 'Animation', 'tatsu' ),
											'group' => array (
												'animate',
												'animation_type',
											)
										),
									)
								),
							)
						),
					)
				),
			),
	        'atts' => array (
	            array (
	        		'att_name' => 'style',
	        		'type' => 'button_group',
	        		'label' => __( 'Style Options', 'oshine-modules' ),
	        		'options' => array (
						'style-1' => 'Normal Header', 
						'style-2' => 'Colored Header', 
					),
	        		'default' => 'style-1',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'header_bg_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Header Background Color (Applied on Colored Header)', 'oshine-modules' ),
		            'default' => '',//color_scheme global theme data
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .pricing-title' => array(
							'property' => 'background-color',
							'when' => array( 'style', '=', 'style-2' ),
						),
					),
					'visible' => array ('style' , '=' , 'style-2'),
	            ),
	        	array (
		            'att_name' => 'header_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Header Text Color (Applied on Colored Header)', 'oshine-modules' ),
		            'default' => '',//alt_bg_text_color global theme data
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .pricing-title-head-tag' => array(
							'property' => 'color',
						),
					),
					'visible' => array ('style' , '=' , 'style-2'),
	            ),
	            array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Title', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'h_tag',
	        		'type' => 'select',
	        		'label' => __( 'Title Heading Tag', 'oshine-modules' ),
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
					'is_inline' => false,
	        	),
	        	array (
	        		'att_name' => 'price',
	        		'type' => 'text',
	        		'label' => __( 'Price', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'duration',
	        		'type' => 'text',
	        		'label' => __( 'Duration', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'currency',
	        		'type' => 'text',
	        		'label' => __( 'Currency', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'button_text',
	        		'type' => 'text',
	        		'label' => __( 'Button Text', 'oshine-modules' ),
	        		'default' => __( 'Click Here', 'oshine-modules' ),
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'button_link',
	        		'type' => 'text',
	        		'label' => __( 'Url to be linked to the button', 'oshine-modules' ),
	        		'default' => '',
					'tooltip' => '',
					'is_inline' => false,
	        	),
	        	array (
		            'att_name' => 'button_color',
		            'type' => 'color',
		            'label' => __( 'Button Text Color', 'oshine-modules' ),
		            'default' => '',//color_scheme
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'button_hover_color',
		            'type' => 'color',
		            'label' => __( 'Button Text Hover Color', 'oshine-modules' ),
		            'default' => '',//alt_bg_text_color
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'button_bg_color',
		            'type' => 'color',
		            'label' => __( 'Button Background Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'button_bg_hover_color',
		            'type' => 'color',
		            'label' => __( 'Button Background Hover Color', 'oshine-modules' ),
		            'default' => '',//color_scheme
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'button_border_color',
		            'type' => 'color',
		            'label' => __( 'Button Border Color', 'oshine-modules' ),
		            'default' => '',//color_scheme
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'button_border_hover_color',
		            'type' => 'color',
		            'label' => __( 'Button Border Hover Color', 'oshine-modules' ),
		            'default' => '',//color_scheme
		            'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'highlight',
	        		'type' => 'button_group',
	        		'label' => __( 'Highlight Column', 'oshine-modules' ),
	        		'options' => array (
						'yes' => 'Yes',
						'no' => 'No',
					),
	        		'default' => 'yes',
	        		'tooltip' => ''
	        	),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine-modules' ),
	              	'options' => tatsu_css_animations(),
					'default' => 'fadeIn',
					'visible' => array ('animate' , '=' , '1'),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'style' => 'style-2', 
	        			'header_bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'header_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        			'title' => 'GOLD',
	        			'price' => '25',
	        			'duration' => 'per month',
	        			'currency' => '$',
	        			'button_bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'button_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),	        			
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'pricing_column', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_pricing_feature');
function oshine_register_pricing_feature() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Pricing Feature', 'oshine-modules' ),
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
								'feature',
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
												'highlight',
												'highlight_color',
												'highlight_text_color',
											)
										)
									)
								),
							),
						)
					),
				),
			),
	        'atts' => array (
	            array (
	        		'att_name' => 'feature',
	        		'type' => 'text',
	        		'label' => __( 'Feature', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	              	'att_name' => 'highlight',
	              	'type' => 'switch',
	              	'label' => __( 'Highlight this section ?', 'oshine-modules') ,
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
		            'att_name' => 'highlight_color',
		            'type' => 'color',
		            'label' => __( 'Highlight Color', 'oshine-modules' ),
		            'default' => '',//sec_bg
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.pricing-feature' => array(
							'property' => 'background-color',
							'when' => array( 'highlight', '=', '1' ),
						),
					),
	            ),
	            array (
		            'att_name' => 'highlight_text_color',
		            'type' => 'color',
		            'label' => __( 'Highlight Text Color', 'oshine-modules' ),
		            'default' => '',//sec_color
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .pricing-feature-container' => array(
							'property' => 'color',
							'when' => array( 'highlight', '=', '1' ),
						),
					),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'feature' => 'Cool Feature Here',
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'pricing_feature', $controls );
}