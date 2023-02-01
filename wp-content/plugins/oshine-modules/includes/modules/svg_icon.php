<?php
/**************************************
			SVG ICON
**************************************/
if (!function_exists('oshine_svg_icon')) {
    function oshine_svg_icon( $atts, $content ) {
        $atts = shortcode_atts( array (
            'size'                  => 'medium',
            'width'                 => 200,
            'height'                => 200,
            'alignment'             => '',
            'color'                 => '',
            'line_animate'          => 0,
            'path_animation_type'   => 'LINEAR',
            'svg_animation_type'    => 'LINEAR',
            'animation_duration'    => 0,
            'animation_delay'       => 0,
        	'key' => be_uniqid_base36(true),
		),$atts );		


		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'oshine_svg_icon', $key );
		$unique_class_name = 'tatsu-'.$key;

       
        $style = 'style = "';
        if( !empty( $color ) ){
            $style .= 'color : '. $color .';';
        }
        $line_animate_class = ( isset( $line_animate ) && 1 == $line_animate ) ? 'svg-line-animate' : '' ;
        if( 'custom' == $size ){
            $style .= 'width : '. $width .'px; height : '. $height .'px;';
        } else {
            $style .= '"'; //Close the style tag
        }
        $output = '';
        if( !empty($content) ) {
            $output .= '<div class="oshine-svg-icon  oshine-module align-'. $alignment .' '.$line_animate_class.' '.$size.' '.$unique_class_name .' " data-path-animation="'.$path_animation_type.'" data-svg-animation="'.$svg_animation_type.'" data-animation-delay="'.$animation_delay.'" data-animation-duration="'.$animation_duration.'" >';
        //    $output .= '<object id="oshine-svg-'.$key.'" type="image/svg+xml" class = "oshine-svg-object" data="'. shortcode_unautop( $content ) .'"></object>';
            $site_url = get_site_url();
            if( strpos( $content, $site_url ) !== false ) { 
                $output .=  file_get_contents( $content );
            } else {
                $output .= '<div class="tatsu-notification tatsu-error">Cross Domain Access of SVG is not allowed. Please upload the SVG file to your site.</div>';
            }
            $output .= $custom_style_tag;
            $output .= '</div>';
            
        }
        return $output;
	}
	add_shortcode( 'oshine_svg_icon', 'oshine_svg_icon' );
}

add_action( 'tatsu_register_modules', 'oshine_register_svg_icon');
function oshine_register_svg_icon() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#svg_icon',
	        'title' => __( 'SVG Icon Legacy', 'oshine_modules' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => true,
			'should_autop' => false,
	        'atts' => array (
				array (
	        		'att_name' => 'content',
	        		'type' => 'text',
	        		'label' => 'SVG Icon File URL',
	        		'default' => '',
	        		'tooltip' => 'Paste SVG Icon'
	        	),
	            array (
	        		'att_name' => 'size',
	        		'type' => 'button_group',
	        		'label' => __( 'Size', 'oshine-modules' ),
	        		'options' => array (
						'small' => 'Small',
						'medium' => 'Medium',
						'large' => 'Large',
						'xlarge' =>'XL',
						'custom' =>'Custom',
					),
	        		'default' => 'small',
	        		'tooltip' => ''
	        	),
				array (
	        		'att_name' => 'width',
	        		'type' => 'number',
	        		'label' => __( 'Width', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '200',
	        		'tooltip' => '',
					'visible' => array( 'size', '=', 'custom' ),
	        	),
				array (
	        		'att_name' => 'height',
	        		'type' => 'number',
	        		'label' => __( 'Height', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '200',
	        		'tooltip' => '',
					'visible' => array( 'size', '=', 'custom' ),
	        	),
	        	array (
		            'att_name' => 'color',
		            'type' => 'color',
		            'label' => __( 'SVG Color', 'oshine-modules' ),
		            'default' => '', 
		            'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.oshine-svg-icon svg, .tatsu-{UUID}.oshine-svg-icon svg path' => array(
							'property' => 'color',
						),
					),
	            ),
				array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'oshine-modules' ),
	        		'options' => array(
	        			'none' => 'None',
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
				array (
	              	'att_name' => 'line_animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable SVG Line Animation', 'oshine_modules' ),
	              	'default' => 0,
	              	'tooltip' => '',     			
	            ),
	            array (
	              	'att_name' => 'path_animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Path Animation', 'oshine_modules' ),
	              	'options' => array( 
						  'LINEAR' => 'Linear',
						  'EASE' => 'Ease',
						  'EASE_IN' => 'Ease In',
						  'EASE_OUT' => 'Ease Out',
						  'EASE_OUT_BOUNCE' => 'Ease Out Bounce'
					   ),
	              	'default' => 'EASE',
	              	'tooltip' => '',
					'visible' => array( 'line_animate', '=', '1' ),
	            ),
				array (
	              	'att_name' => 'svg_animation_type',
	              	'type' => 'select',
	              	'label' => __( 'SVG Animation', 'oshine_modules' ),
	              	'options' => array( 
						  'LINEAR' => 'Linear',
						  'EASE' => 'Ease',
						  'EASE_IN' => 'Ease In',
						  'EASE_OUT' => 'Ease Out',
						  'EASE_OUT_BOUNCE' => 'Ease Out Bounce'
					   ),
	              	'default' => 'EASE_IN',
	              	'tooltip' => '',
					'visible' => array( 'line_animate', '=', '1' ),
	            ),
				array(
	        		'att_name' => 'animation_duration',
	        		'type' => 'slider',
	        		'options' => array(
	        			'min' => '10',
	        			'max' => '500',
	        			'step' => '1',
						'unit' => '',
	        		),
					'default' => '100',	        		
	        		'label' => __( 'Animation Duration', 'oshine-modules' ),
	        		'tooltip' => '',
					'visible' => array( 'line_animate', '=', '1' ),
	        	),
				array(
	        		'att_name' => 'animation_delay',
	        		'type' => 'slider',
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '2000',
	        			'step' => '50',
						'unit' => 'ms',
	        		),
					'default' => '0',	        		
	        		'label' => __( 'Animation Delay', 'oshine-modules' ),
	        		'tooltip' => '',
					'visible' => array( 'line_animate', '=', '1' ),
	        	),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'oshine_svg_icon', $controls );
}