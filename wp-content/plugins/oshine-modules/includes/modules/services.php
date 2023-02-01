<?php
/**************************************
			SERVICES
**************************************/
if ( ! function_exists( 'be_services' ) ) {
	function be_services( $atts, $content ) {
		$atts = shortcode_atts( array (
			'line_color' => '',
			'key' => be_uniqid_base36(true)
		),$atts );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'services', $key );
		$unique_class_name = 'tatsu-'.$key;

		return '<div class="services-outer-wrap oshine-module '.$unique_class_name.'"><ul class="be-services">'.do_shortcode( $content ).'</ul><span class="timeline" ></span>'.$custom_style_tag.'</div>';
	}
	add_shortcode( 'services', 'be_services' );
}

add_filter( 'services_before_css_generation', 'services_css' );
function services_css( $atts ) {
		$atts[ 'line_color' ] = (empty($atts[ 'line_color' ])) ? '#000' : $atts[ 'line_color' ] ; 
	return $atts;
}

if ( ! function_exists( 'be_service' ) ) {
	function be_service( $atts, $content ) {
		$atts = shortcode_atts( array (
			'icon' => '',
			'icon_size' => 'small',
			'icon_bg_color' => '',
			'icon_hover_bg_color' => '',
			'icon_color' => '',
			'icon_hover_color' => '',
			'content_bg_color' => '',
			'key' => be_uniqid_base36(true)
		),$atts );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'service', $key );
		$unique_class_name = 'tatsu-'.$key;
		

	    // $icon_bg_color = (empty($icon_bg_color)) ? '#000' : $icon_bg_color ; 
		// $icon_hover_bg_color = (empty($icon_hover_bg_color)) ? $icon_bg_color : $icon_hover_bg_color ; 
		// $icon_color = (empty($icon_color)) ? '#fff' : $icon_color ; 
		// $icon_hover_color = (empty($icon_hover_color)) ? $icon_color : $icon_hover_color ; 
		
		return '<li class="be-service '.$unique_class_name.'"><div class="service-wrap" ><i class="service-icon font-icon '.$icon.' icon-size-'.$icon_size.'" ></i><div class="service-content" >'.be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) ).'</div>'.$custom_style_tag.'</div></li>';
	}
	add_shortcode( 'service', 'be_service' );
}

add_filter( 'service_before_css_generation', 'service_css' );
function service_css( $atts ) {
		$atts[ 'icon_bg_color' ] = (empty($atts[ 'icon_bg_color' ])) ? '#000' : $atts[ 'icon_bg_color' ] ; 
		$atts[ 'icon_hover_bg_color' ] = (empty($atts[ 'icon_hover_bg_color' ])) ? $atts[ 'icon_bg_color' ] : $atts[ 'icon_hover_bg_color' ] ; 
		$atts[ 'icon_color' ] = (empty($atts[ 'icon_color' ])) ? '#fff' : $atts[ 'icon_color' ] ; 
		$atts[ 'icon_hover_color' ] = (empty($atts[ 'icon_hover_color' ])) ? $atts[ 'icon_color' ] : $atts[ 'icon_hover_color' ] ; 
	return $atts;
}


add_action( 'tatsu_register_modules', 'oshine_register_services');
function oshine_register_services() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#services',
	        'title' => __( 'Services', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => 'service',
	        'type' => 'multi',
	        'initial_children' => 3,
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
											'title' => __( 'Colors', 'tatsu' ),
											'group' => array (
												'line_color',
											)
										)
									)
								),
							),
						),
					),
				),
			),
	        'atts' => array (
	            array (
		            'att_name' => 'line_color',
		            'type' => 'color',
		            'label' => __( 'Timeline Color', 'oshine-modules' ),
		            'default' => '',//sec_border
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .timeline' => array(
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
	        			'line_color' => '#efefef',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'services', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_service');
function oshine_register_service() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Service', 'oshine-modules' ),
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
								'icon',
								'icon_size',
								'content',
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
												array (
													'type' => 'tabs',
													'style' => 'style1',
													'group' => array(
														array(
															'type' => 'tab',
															'title' => __('Normal' , 'tatsu'),
															'group' => array (
																'icon_color',
																'icon_bg_color',
																'content_bg_color',
															)
														),
														array(
															'type' => 'tab',
															'title' => __('Hover' , 'tatsu'),
															'group' => array (
																'icon_hover_bg_color',
																'icon_hover_color',
															)
														),
													)
												)
											)
										)
									)
								),
							),
						),
					),
				),
			),
	        'atts' => array (
	            array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Service Icon', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'icon_size',
	        		'type' => 'button_group',
	        		'label' => __( 'Service Icon Size', 'oshine-modules' ),
	        		'options' => array (
						'small'	=>	'Small',
						'medium' => 'Medium',
						'large' => 'Large'
					),
	        		'default' => 'medium',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'icon_bg_color',
		            'type' => 'color',
		            'label' => __( 'Service Icon Background Color', 'oshine-modules' ),
		            'default' => '',//sec_bg
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .service-icon' => array(
							'property' => 'background-color',
						),
					),
	            ),
	        	array (
		            'att_name' => 'icon_color',
		            'type' => 'color',
		            'label' => __( 'Service Icon Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .service-icon' => array(
							'property' => 'color',
						),
					),
	            ),
	        	array (
		            'att_name' => 'icon_hover_bg_color',
		            'type' => 'color',
		            'label' => __( 'Service Icon Hover Background Color', 'oshine-modules' ),
		            'default' => '',//color_scheme
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .service-wrap:hover .service-icon' => array(
							'property' => 'background-color',
						),
					),
	            ),
	        	array (
		            'att_name' => 'icon_hover_color',
		            'type' => 'color',
		            'label' => __( 'Service Icon Hover Color', 'oshine-modules'),
		            'default' => '',//alt_bg_text_color
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .service-wrap:hover .service-icon' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Servies Content', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	
 	        	array (
		            'att_name' => 'content_bg_color',
		            'type' => 'color',
		            'label' => __( 'Services content BG color', 'oshine-modules' ),
		            'default' => '',//sec_bg
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .service-content' => array(
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
	        			'icon' => 'icon-icon_desktop',
	        			'icon_bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'icon_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.',	        			
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'service', $controls );
}