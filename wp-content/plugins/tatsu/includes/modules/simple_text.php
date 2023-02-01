<?php 
if ( !function_exists( 'simple_text' ) ) {
	function simple_text( $atts, $content ) {
		extract( shortcode_atts( array (
            'margin' => '0',
            'tag_to_use' => '',
            'style' => '',
            'font_size' => '',
            'letter_spacing' => '',
            'line_height' => '',
            'text_transform' => '',
            //'margin' => '',
            'text_color' => '',
			'animate' => '0',
			'animation_type' => 'none',
			'animation_delay' => '0',
			//'max_width' => 100,
			'wrap_alignment' => 'center',
			//'border_radius' => '',
			'enable_box_shadow' => '',
			'box_shadow_custom' => '',
			'padding' =>'',
            'bg_color' => '',
            'border_width' => '',
            'border_color' => '',
			'key' => be_uniqid_base36(true),  
		),$atts ) );
		

		extract($atts);
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'simple_text', $key );
		$custom_class_name = 'tatsu-'.$key;


		$animate = ( isset( $animate ) && !empty( $animate ) ) ? 1 : 0;
		$animation_delay = ( isset( $animation_delay ) && !empty( $animation_delay ) && 1 == $animate ) ? $animation_delay : '';
		$animation_type = ( isset( $animation_type ) && !empty( $animation_type ) && 1 == $animate ) ? $animation_type : '';
		
		$output = '';
		$output .= '<div class="tatsu-module simple-text clearfix '. $custom_class_name . ( ( 1 == $animate ) ? ' tatsu-animate' : '' )  . '" ' . ( ( '' != $animation_type ) ? ( ' data-animation="'. $animation_type .'"' ) : '' ) . ( ( '' != $animation_delay ) ? ( ' data-animation-delay="'. $animation_delay .'"' ) : '' )  . ' >';
            $output .= $custom_style_tag;
            $output .= '<div class="simple-text-inner background-switcher-class">';
                $output .= '<'.$tag_to_use.' class="simple-text-tag">';
                $output .= do_shortcode( $content );
                $output .= '</'.$tag_to_use.'>';
            $output .= '</div>';
        $output .= '</div>';
        
        //background-switcher-class used coz in real page it is not taking effect
        // if not used, is not visible in tatsu
	    return $output;
	}
	add_shortcode( 'simple_text', 'simple_text' );
}

// add_action( 'tatsu_register_modules', 'tatsu_register_simple_text', 9 );
// function tatsu_register_simple_text() {
// 	$controls = array (
// 	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#inline_text',
// 	        'title' => esc_html__( 'Simple Text', 'tatsu' ),
// 	        'is_js_dependant' => false,
// 	        'type' => 'single',
// 	        'is_built_in' => true,
// 	        'drag_handle' => false,
// 			'atts' => array (
// 	            // array (
// 	        	// 	'att_name' => 'max_width',
// 	        	// 	'type' => 'slider',
// 	        	// 	'label' => esc_html__( 'Content Width', 'tatsu' ),
// 	        	// 	'options' => array(
// 	        	// 		'min' => '0',
// 	        	// 		'max' => '100',
// 	        	// 		'step' => '1',
// 	        	// 		'unit' => '%',
// 	        	// 	),		        		
// 	        	// 	'default' => '100',
// 				// 	'tooltip' => '',
// 				// 	'responsive' => true,
// 				// 	'css'=>true,
// 				// 	'selectors' => array(
// 				// 		'.tatsu-{UUID} .tatsu-inline-text-inner' => array(
// 				// 			'property' => 'width',
// 				// 			'append' => '%'
// 				// 		)
// 				// 	),
// 				// ),
// 				array (
// 					'att_name' => 'content',
// 					'type' => 'text_area',
// 					'label' => 'Content',
// 					'default' => "",
// 					'tooltip' => '',
// 				),
// 	        	array (
// 	        		'att_name' => 'tag_to_use',
// 	        		'type' => 'select',
// 	        		'label' => esc_html__( 'Tag to use for Text', 'tatsu' ),
// 	        		'options' => array (
// 						'h1' => 'h1',
// 						'h2' => 'h2',
// 						'h3' => 'h3',
// 						'h4' => 'h4',
// 						'h5' => 'h5',
// 						'h6' => 'h6',
// 						'p' => 'p',
// 						'span' => 'span',
// 						'div' => 'div',						
// 					),
// 	        		'default' => 'div',
// 	        		'tooltip' => '',
        			
// 				),
// 				array (
// 					'att_name' => 'text_color',
// 					'type' => 'color',
// 					'options' => array (
// 						'gradient' => true
// 					),
// 					'label' => esc_html__( 'Text Color', 'tatsu' ),
// 					'default' => '',
// 				   'tooltip' => '',
// 				   'css' => true,
// 				   'selectors' => array(
// 					   '.tatsu-{UUID} .background-switcher-class' => array(
// 						   'property' => 'color',
// 					//   	'when' => array(
// 					// 		   array('tag_to_use', 'h1' ),
// 					// 		   array('tag_to_use', 'h2' ),
// 					// 		   array('tag_to_use', 'h3' ),
// 					// 		   array('tag_to_use', 'h4' ),
// 					// 		   array('tag_to_use', 'h5' ),
// 					// 		   array('tag_to_use', 'h6' ),
// 					// 	   ),
// 					// 	   'relation' => 'or',
// 					//    ),
// 					//    '.tatsu-{UUID} .simple-text-tag' => array(
// 					// 		'property' => 'color',
// 					// 		'when' => array(
// 					// 			array('tag_to_use', 'p' ),
// 					// 			array('tag_to_use', 'span' ),
// 					// 			array('tag_to_use', 'div' ),
// 					// 		),
// 					// 		'relation' => 'or',
// 						),
// 					), 
// 				), 
// 				array (
// 					'att_name' => 'style',
// 					'type' => 'button_group',
// 					'label' => esc_html__( 'Text Properties',  'tatsu'  ),
// 					'options' => array (
// 						'default' => 'Default',
// 						'custom' => 'Custom',
// 					),
// 					'default' => 'default',
// 					'tooltip' => '',
// 				),
// 	            array (
// 	        		'att_name' => 'font_size',
// 	        		'type' => 'number',
// 	        		'label' => esc_html__( 'Font Size', 'tatsu' ),
// 	        		'options' => array(
// 	        			'unit' => 'px',
// 	        		),
// 	        		'default' => '14',
// 					'tooltip' => '',
// 					'visible' => array( 'style', '=', 'custom' ),
// 					'css' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID} .simple-text-tag' => array(
// 							'property' => 'font-size',
// 							'when' => array('style', '=', 'custom'),
// 							'append' => 'px'
// 						),
// 					),
//         		),
// 				array (
// 	        		'att_name' => 'line-height',
// 	        		'type' => 'number',
// 	        		'label' => esc_html__( 'Line Height', 'tatsu' ),
// 	        		'options' => array(
// 	        			'unit' => 'px',
// 	        		),
// 	        		'default' => '5',
// 					'tooltip' => '',
// 					'visible' => array( 'style', '=', 'custom' ),
// 					'css' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID} .simple-text-tag' => array(
// 							'property' => 'line-height',
// 							'when' => array('style', '=', 'custom'),
// 							'append' => 'px'
// 						),
// 					),
        			
// 				),
// 				array(
// 					'att_name' => 'letter_spacing',
// 					'type' => 'slider',
// 					'label' => esc_html__('Letter Spacing', 'tatsu'),
// 					'options' => array(
// 						'min' => 0,
// 						'max' => 25,
// 						'step' => 1,
// 						'unit' => 'px',
// 						'add_unit_to_value' => true
// 					),
// 					'visible' => array( 'style', '=', 'custom' ),
// 					'default' => '0',
// 					'css' => true,
// 					'responsive' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID} .simple-text-tag' => array(
// 							'property' => 'letter-spacing',
// 							'when' => array('style', '=', 'custom'),
// 						),
// 					),
// 				),
// 				array (
// 	        		'att_name' => 'text_transform',
// 	        		'type' => 'select',
// 	        		'label' => esc_html__( 'Text Transform', 'tatsu' ),
// 	        		'options' => array (
// 						'uppercase' => 'Uppercase',
// 						'lowercase' => 'Lowercase',
// 						'capitalize' => 'Capitalize',
// 						'inherit' => 'Inhertit',
// 						'none' => 'None',
// 					),
// 					'visible' => array( 'style', '=', 'custom' ),
// 					'css' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID} .simple-text-tag' => array(
// 							'property' => 'text-transform',
// 							'when' => array('style', '=', 'custom'),
// 						),
// 					),
// 	        		'default' => 'div',
// 	        		'tooltip' => '',
        			
// 				),
// 				array (
//                     'att_name' => 'wrap_alignment',
//                     'type' => 'button_group',
//                     'label' => esc_html__( 'Text Alignment', 'tatsu' ),
//                     'options' => array (
//                         'left' => 'Left',
//                         'center' => 'Center',                        
//                         'right' => 'Right',
//                     ),
//                     'default' => 'center',
// 					'tooltip' => '',
// 					'css' => true,
// 					'selectors'=> array(
// 						'.tatsu-{UUID} .simple-text-inner' => array(
// 							'property' => 'text-align',
// 						),
// 					),
//                     //'visible' => array( 'max_width', '<', '100' ),  // coz it has become responsive
//                 ),				
// 				array (
// 	        		'att_name' => 'margin',
// 	        		'type' => 'input_group',
// 	        		'label' => esc_html__( 'Margin', 'tatsu' ),
// 	              	'default' => '0px 0px 0px 0px',
// 					'tooltip' => '',
// 					'responsive' => true,
// 					'css' => true,
// 					'selectors'=> array(
// 						'.tatsu-{UUID}.simple-text' => array(
// 							'property' => 'margin',
// 							'when' => array('margin', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
// 						),
// 					),
// 	        	),
// 	            array (
// 	              'att_name' => 'padding',
// 	              'type' => 'input_group',
// 	              'label' => esc_html__( 'Padding', 'tatsu' ),
// 	              'default' => '0px 0px 0px 0px',
// 				  'tooltip' => '',
// 				  'css' => true,
// 				  'responsive' => true,
// 				  'selectors' => array(
// 					    '.tatsu-{UUID}.simple-text' => array(
// 							'property' => 'padding',
// 							'when' => array('padding', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
// 						),
// 					),
// 	            ),
// 	            array (
// 	        		'att_name' => 'border_thickness',
// 	        		'type' => 'number',
// 	        		'label' => esc_html__( 'Border Thickness', 'tatsu' ),
// 	        		'options' => array(
// 	        			'unit' => 'px',
// 	        		),
// 	        		'default' => '0',
// 					'tooltip' => '',
// 					'css' => true,
// 					'responsive' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID}.simple-text' => array(
// 							'property' => 'border-width',
// 							'append' => 'px'
// 						),
// 					),
        			
// 				),
// 				array (
// 					'att_name' => 'border_color',
// 					'type' => 'color',
// 					'options' => array (
// 						'gradient' => true
// 					),
// 					'label' => esc_html__( 'Border Color', 'tatsu' ),
// 					'default' => '',
// 				   'tooltip' => '',
// 				   'css' => true,
// 				   'selectors' => array(
// 					   '.tatsu-{UUID}.simple-text' => array(
// 						   'property' => 'border-color',
// 						   'when' => array('border_thickness', '!=', '0')
// 					   ),
// 				   ), 
// 				),
// 				// array(
// 				// 	'att_name' => 'border_radius',
// 				// 	'type' => 'slider',
// 				// 	'label' => esc_html__('Border Radius', 'tatsu'),
// 				// 	'options' => array(
// 				// 		'min' => 0,
// 				// 		'max' => 1000,
// 				// 		'step' => 1,
// 				// 		'unit' => 'px',
// 				// 		'add_unit_to_value' => true
// 				// 	),
// 				// 	'default' => '0',
// 				// 	'css' => true,
// 				// 	'selectors' => array(
// 				// 		'.tatsu-{UUID}.simple-text' => array(
// 				// 			'property' => 'border-radius',
// 				// 			'when' => array('border_radius', '!=', '0px'),
// 				// 		),
// 				// 	),
// 				// 	'tooltip' => 'Use this to give border radius',
// 				// ), 
// 				array (
// 					'att_name' => 'bg_color',
// 					'type' => 'color',
// 					'options' => array (
// 						'gradient' => true
// 					),
// 					'label' => esc_html__( 'Background Color', 'tatsu' ),
// 					'default' => '',
// 				   'tooltip' => '',
// 				   'css' => true,
// 				   'selectors' => array(
// 					   '.tatsu-{UUID}.simple-text' => array(
// 						   'property' => 'background-color',
// 					   ),
// 				   ), 
// 				), 
// 				array (
// 					'att_name' => 'enable_box_shadow',
// 					'type' => 'switch',
// 					'label' => esc_html__( 'Enable Box Shadow', 'tatsu' ),
// 					'default' => 0,
// 					'tooltip' => '',
// 				), 
// 				array (
// 					'att_name' => 'box_shadow_custom',
// 					'type' => 'input_box_shadow',
// 					'label' => esc_html__( 'Box Shadow Values', 'tatsu' ),
// 					'default' => '0 0 15px 0 rgba(198,202,202,0.4)',
// 					'tooltip' => '',
// 					'visible' => array( 'enable_box_shadow', '=', '1' ),
// 					'css' => true,
// 				  'selectors' => array(
// 					    '.tatsu-{UUID}.simple-text' => array(
// 							'property' => 'box-shadow',
// 							'when' => array('enable_box_shadow', '=', '1'),
// 						),
// 					),
// 	            ),
// 				array (
// 	        		'att_name' => 'animate',
// 	        		'type' => 'switch',
// 	        		'label' => esc_html__( 'Enable CSS Animation', 'tatsu' ),
// 	        		'default Value' => 0,
// 	        		'tooltip' => ''
// 	        	),
// 	             array (
// 	              'att_name' => 'animation_type',
// 	              'type' => 'select',
// 	              'label' => esc_html__( 'Animation Type', 'tatsu' ),
// 	              'options' => tatsu_css_animations(),
// 	              'default' => 'fadeIn',
// 	              'tooltip' => '',
// 	              'visible' => array( 'animate', '=', '1' ),
// 	            ),
// 				array (
// 	        		'att_name' => 'animation_delay',
// 	        		'type' => 'slider',
// 	        		'options' => array(
// 	        			'min' => '0',
// 	        			'max' => '2000',
// 	        			'step' => '50',
// 						'unit' => 'ms',
// 	        		),
// 					'default' => '0',	        		
// 	        		'label' => esc_html__( 'Animation Delay', 'tatsu' ),
// 	        		'tooltip' => '',
// 					'visible' => array( 'animate', '=', '1' ),
// 	        	),	
// 	        ),
// 	        'presets' => array(
// 	        	'default' => array(
// 	        		'title' => '',
// 	        		'image' => '',
// 	        		'preset' => array(
// 	        			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
// 						'margin' => '0px 0px 30px 0px',
// 	        		),
// 	        	)
// 	        ),					
// 	);
// 	tatsu_register_module( 'simple_text', $controls );
// }


?>