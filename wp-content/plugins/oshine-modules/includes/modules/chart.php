<?php
/**************************************
			ANIMATED CHARTS
**************************************/
if (!function_exists('be_chart')) {
	function be_chart( $atts, $content, $tag ) {
		$atts = shortcode_atts( array (
			'percentage' => '70',
			'caption' => '',
			'caption_size' => '',
			'percentage_color' => '',
			'percentage_font_size' => '',
			'caption_color' => '',
			'percentage_bar_color' => '',
			'percentage_track_color' => '',
			'percentage_scale_color' => '',
			'size' => 120,
			'linewidth' => 5,
			'icon' => 'none',
			'key' => be_uniqid_base36(true),
		),$atts, $tag );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'chart', $key );
		$unique_class_name = 'tatsu-'.$key;

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );


		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }


		$output = '';

		$style = '';
		$style = ($size) ? 'style="width: '.$size.'px;height: '.$size.'px;line-height: '.$size.'px;"' : $style ;
		if(isset($icon) && !empty($icon) && $icon != 'none') {
			$icon = '<icon class="font-icon '.$icon.'"></i>';
		} else {
			$icon = '<span class="percentage">0</span>%';
		}
		$output .= '<div '.$css_id.' class="chart-wrap oshine-module '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'>';
		$percentage_bar_color = be_compute_color($percentage_bar_color);
		$percentage_bar_color = $percentage_bar_color[1];
		$percentage_scale_color = be_compute_color($percentage_scale_color);
		$percentage_scale_color = $percentage_scale_color[1];
		$percentage_track_color = be_compute_color($percentage_track_color);
		$percentage_track_color = $percentage_track_color[1];
		$output .= '<div class="chart" data-percent="'.$percentage.'" data-bar-color="'.$percentage_bar_color.'" data-track-color="'.$percentage_track_color.'" data-scale-color="'.$percentage_scale_color.'" data-size="'.$size.'" data-line-width="'.$linewidth.'" '.$style.'>';
		$output .= '<span class="be-chart-percent" >';
		$output .= $icon;
		$output .= '</span>';
		$output .= '</div>';
		$output .= '<div><span class="be-chart-caption" >'.$caption.'</span></div>';
		$output .= $custom_style_tag;
		$output .= '</div>';
		
		return $output;
	}
	add_shortcode( 'chart', 'be_chart' );
}


add_action( 'tatsu_register_modules', 'oshine_register_chart');
function oshine_register_chart() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#chart',
	        'title' => __('Animated Charts','oshine-modules'),
	        'is_js_dependant' => true,
	        'type' => 'single',
			'is_built_in' => false,
			'hint' => 'caption',
			'group_atts' => array (
				array (
					'type'	=>	'tabs',
					'style'	=>	'style1',
					'group'	=>	array (
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Content' , 'tatsu'),
							'group'	=>	array (
								'percentage',
								'icon',
								'caption',
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
											'title' => __( 'Shape and size', 'tatsu' ),
											'group' => array (
												'size',
												'percentage_font_size',
												'caption_size',
												'linewidth',
											)
										),
										array (
											'type' => 'panel',
											'title' => __( 'Colors', 'tatsu' ),
											'group' => array (
												'percentage_color',
												'caption_color',
												'percentage_bar_color',
												'percentage_track_color',
												'percentage_scale_color',
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
	        		'att_name' => 'percentage',
	        		'type' => 'slider',
					'label' => __( 'Percentage', 'oshine-modules' ),
					'options' => array(
	        			'min' => '0',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => '%',
	        		),
	        		'default' => '70',
	        		'tooltip' => ''
	        	),
 	        	array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'oshine-modules' ),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'percentage_font_size',
	        		'type' => 'slider',
	        		'label' => __( 'Percentage / Icon - Font Size', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '200',
	        			'step' => '1',
	        			'unit' => 'px',
	        			'add_unit_to_value' => false,
	        		),
	        		'default' => '14',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .be-chart-percent' => array(
							'property' => 'font-size',
							'when' => array(
								array('percentage', 'notempty'),
								array('icon', 'notempty')
							),
							'relation' => 'or',
							'append' => 'px',
						),
					),
	        	),
				array (
		            'att_name' => 'percentage_color',
					'type' => 'color',
					'options' => array (
							'gradient' => true
					),
		            'label' => __( 'Percentage / Icon - Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .be-chart-percent' => array(
							'property' => 'color',
							'when' => array(
								array('percentage', 'notempty'),
								array('icon', 'notempty')
							),
							'relation' => 'or',
						),
					),
	            ),
	        	array (
	        		'att_name' => 'caption',
	        		'type' => 'text',
	        		'label' => __( 'Caption', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),	
	        	array (
	        		'att_name' => 'caption_size',
	        		'type' => 'slider',
	        		'label' => __( 'Caption Font Size', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '200',
	        			'step' => '1',
	        			'unit' => 'px',
	        		),
	        		'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .be-chart-caption' => array(
							'property' => 'font-size',
							'when' => array('caption', 'notempty'),
							'append' => 'px',
						),
					),
	        	),	
				array (
		            'att_name' => 'caption_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Caption Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .be-chart-caption' => array(
							'property' => 'color',
							'when' => array('caption', 'notempty'),
						),
					),
	            ),
				array (
		            'att_name' => 'percentage_bar_color',
					'type' => 'color',
		            'label' => __( 'Percentage Bar Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
				array (
		            'att_name' => 'percentage_track_color',
					'type' => 'color',
		            'label' => __( 'Percentage Track Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
				array (
		            'att_name' => 'percentage_scale_color',
					'type' => 'color',
		            'label' => __( 'Percentage Scale Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
	            ),	
	        	array (
	        		'att_name' => 'size',
	        		'type' => 'number',
	        		'label' => __( 'Chart Size ( Height & Width )', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '100',
					'tooltip' => '',

	        	),
	        	array (
	        		'att_name' => 'linewidth',
	        		'type' => 'slider',
	        		'label' => __( 'Bar Width', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '1',
	        			'max' => '50',
	        			'step' => '1',
	        			'unit' => 'px',
	        		),
	        		'default' => '5',
	        		'tooltip' => ''
	        	),	        		                        	            	            	        		        	        		        	
	        ),
	    );
	tatsu_register_module( 'chart', $controls );
}