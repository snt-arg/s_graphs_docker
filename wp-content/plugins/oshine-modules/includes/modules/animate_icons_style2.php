<?php
/**************************************
			Animated Box Style2
**************************************/
if ( ! function_exists( 'be_animate_icons_style2' ) ) {
	function be_animate_icons_style2( $atts, $content, $tag ) {
		$atts = shortcode_atts( array (
			'key' => be_uniqid_base36(true),
		), $atts, $tag );


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
		$output .= '<div '.$css_id.' class="oshine-module oshine-am-vh animate-icon-module-style2-wrap clearfix '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'>'.be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) ).' '.$custom_style_tag .'</div>';
		return $output;
	}
	add_shortcode( 'animate_icons_style2', 'be_animate_icons_style2' );
}

if ( ! function_exists( 'be_animate_icon_style2' ) ) {
	function be_animate_icon_style2( $atts, $content ) {
		$atts = shortcode_atts( array (
			'icon' => 'none',
			'size' => 30,
			'icon_color' => '',
			'icon_color_hover_state' => '',
			'title' => '',
			'h_tag' => 'h6',
			'title_color' => '',
			'title_color_hover_state' => '',
			'bg_color' => '',
			'hover_bg_color' => '',
			'key' => be_uniqid_base36(true),
		),$atts );
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'animate_icon_style2', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];

		extract( $atts );

	    $h_tag = ( isset( $h_tag ) && !empty( $h_tag ) ) ? $h_tag : 'h6';
	    $title = ( isset( $title ) && !empty( $title ) ) ? '<'.$h_tag.' class="animate-icon-title" >'.$title.'</'.$h_tag.'>' : '';
	    $output = '';
	    $output .= '<div class="animate-icon-module-style2 '.$custom_class_name.'"  >';
	    $output .= '<div class="animate-icon-module-style2-inner-wrap">';
		$output .= '<div class="animate-icon-module-style2-normal-content clearfix"><i class="animate-icon-icon font-icon '.$icon.'" ></i>'.$title.'</div>';
		$output .= '<div class="animate-icon-module-style2-hover-content clearfix">'.be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) ).'</div>';
		$output .= '</div>'.$custom_style_tag.'</div>';
		return $output;
	}
	add_shortcode( 'animate_icon_style2', 'be_animate_icon_style2' );
}
add_action( 'tatsu_register_modules', 'oshine_register_animate_icons_style2');
function oshine_register_animate_icons_style2() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#animated_module',
	        'title' => __( 'Variable Height Animated Module', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'child_module' => 'animate_icon_style2',
	        'type' => 'multi',
	        'initial_children' => 3,
			'is_built_in' => true,
			'hint' => 'title',
			'group_atts' => array (
				array (
					'type'	=>	'tabs',
					'style'	=>	'style1',
					'group'	=>	array (
						
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Advanced' , 'tatsu'),
							'group'	=>	array (

							)
						),
					)
				),
			),
	        'atts' => array(),
	    );
	tatsu_register_module( 'animate_icons_style2', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_animate_icon_style2');
function oshine_register_animate_icon_style2() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Element', 'oshine-modules' ),
	        'is_js_dependant' => false,
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
								'icon',
								'title',
								'h_tag',
								'content',
							)
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Style' , 'tatsu'),
							'group'	=>	array (
								'size',
								array(
									'type' => 'accordion',
									'active' => array(0,1),
									'group' => array(
										array(
											'type' => 'panel',
											'title' => __('Colors', 'tatsu'),
											'group' => array(
												array(
													'type'	=>	'tabs',
													'style'	=>	'style1',
													'group'	=>	array(
														array(
															'type'	=>	'tab',
															'title'	=>	__('Normal', 'tatsu'),
															'group'	=>	array(
																'icon_color',
																'title_color',
																'bg_color',
															)
														),
														array(
															'type'	=>	'tab',
															'title'	=>	__('Hover', 'tatsu'),
															'group'	=>	array(
																'icon_color_hover_state',
																'title_color_hover_state',													
																'hover_bg_color'
															)
														),
													)
												),
											)
										),
									)
								),
							),
						),
					)
				),
			),
	        'atts' => array (
				array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
		            'label' => __( 'Background Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.animate-icon-module-style2' => array(
							'property' => 'background'
						),
					),
	            ),
				array (
		            'att_name' => 'hover_bg_color',
		            'type' => 'color',
		            'label' => __( 'Background Color - Hover State', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.animate-icon-module-style2:hover' => array(
							'property' => 'background'
						),
					),
	            ),
 	        	array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'oshine-modules' ),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'size',
	        		'type' => 'slider',        		
	        		'label' => __( 'Icon Size', 'oshine-modules' ),
					'options' => array(
						'min' => '0',
						'max' => '200',
						'step' => '1',
						'unit' => 'px',
					),
	        		'default' => '100',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .animate-icon-icon' => array(
							'property' => 'font-size',
							'append' => 'px',
						),
					),
	        	),
				array (
		            'att_name' => 'icon_color',
		            'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Icon Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .animate-icon-icon' => array(
							'property' => 'color',
						),
					),
	            ),
				array (
		            'att_name' => 'icon_color_hover_state',
		            'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Icon Color on Mouse over', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.animate-icon-module-style2:hover .animate-icon-icon' => array(
							'property' => 'color',
						),
					),
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
	        		'type' => 'button_group',
	        		'label' => __( 'Heading tag to use for Title', 'oshine-modules' ),
	        		'options' => array (
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6'
					),
	        		'default' => 'h5',
	        		'tooltip' => ''
	        	),
				array (
		            'att_name' => 'title_color',
		            'type' => 'color',
		            'label' => __( 'Title Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .animate-icon-title' => array(
							'property' => 'color',
						),
					),
	            ),
				array (
		            'att_name' => 'title_color_hover_state',
		            'type' => 'color',
		            'label' => __( 'Title Color - Hover State', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.animate-icon-module-style2:hover .animate-icon-title' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content on Mouse Over', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'hover_bg_color' => '#232323',
	        			'icon' => 'icon-icon_desktop',
	        			'size' => '40',
	        			'title' => 'Title Goes Here',
	        			'h_tag' => 'h6',
	        			'icon_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        			'title_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        			'icon_color_hover_state' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'title_color_hover_state' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
						'content' => '<span style="color:#fff;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.</span>'
						
						
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'animate_icon_style2', $controls );
}