<?php
/**************************************
			COUNTDOWN
**************************************/
if (!function_exists('be_countdown')) {
	function be_countdown( $atts, $content, $tag ) {
			 $atts = shortcode_atts( array (
				'date_time' => '',
				'text_color' =>'',
				'key' => be_uniqid_base36(true),
			), $atts, $tag);
			
			extract( $atts );
			$custom_style_tag = be_generate_css_from_atts( $atts, 'be_countdown', $atts['key'] );
			$custom_class_name = ' tatsu-'.$atts['key'];

			$css_id = be_get_id_from_atts( $atts );
			$visibility_classes = be_get_visibility_classes_from_atts( $atts );
	
	
			$data_animations = be_get_animation_data_atts( $atts );
			if( !empty( $animation_type ) && 'none' !== $animation_type ) {
				$css_classes .= ' tatsu-animate ';
			}
	

			$output = '';
	    	$output .= '<div '.$css_id.' class="be-countdown-wrap '.$custom_class_name.' oshine-module clearfix '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'>';
	    	$output .= '<div class="be-countdown clearfix" data-time="'.$date_time.'"></div>';
			$output .= $custom_style_tag;
			$output .= '</div>';
	        return $output;
	}
	add_shortcode( 'be_countdown', 'be_countdown' );
}

add_action( 'tatsu_register_modules', 'oshine_register_be_countdown');
function oshine_register_be_countdown() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#countdown',
	        'title' => __( 'Countdown', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
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
								'date_time',
							)
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Style' , 'tatsu'),
							'group'	=>	array (
								'text_color'
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
	        		'att_name' => 'date_time',
	        		'type' => 'text',
					'label' => __( 'Countdown End Date and Time', 'oshine-modules' ),
					'options' => array(
						'placeholder' => 'YYYY-MM-DD HH:MM:SS',
					),
	        		'default' => '',
					'tooltip' => '',
					'is_inline' => false,
	        	),
				array (
		            'att_name' => 'text_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Text Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .countdown-section' => array(
							'property' => 'color'
						)
					),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'date_time' => '2018-01-01 00:00:00',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'be_countdown', $controls );
}