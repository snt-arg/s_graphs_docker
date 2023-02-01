<?php
/**************************************
			Process Style
**************************************/ 
if (!function_exists('be_process_style1')) {
	function be_process_style1( $atts, $content, $tag ) {
		$atts = shortcode_atts( array (
			'column' => 1,
			'border_color' => '',
			'outer_border_color' => '',
			'key' => be_uniqid_base36(true),
		), $atts, $tag );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'process_style1', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );


		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }

		if(empty( $column )) {
			$column = 2;
		}
	    $output = "";
		$output .= '<div '.$css_id.' class="process-style1 oshine-module '.$custom_class_name.' '.$visibility_classes.' '.$css_classes.' " '.$data_animations.' data-col="'.$column.'" >';
		$output .= $custom_style_tag;
		$output .= do_shortcode( $content );
	    $output .= '</div>';
	    return $output;
	}
	add_shortcode( 'process_style1', 'be_process_style1' );
}

if (!function_exists('be_process_col')) {
	function be_process_col( $atts, $content, $tag ){
			$atts = shortcode_atts( array (
				'icon' => '',
				'icon_color' => '',
				'icon_size'	=> '60',
				'css_classes' => '',
				'key' => be_uniqid_base36(true),
			), $atts, $tag );
			
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'process_col', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );


		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }

			$output = '';
	    	$output .= '<div '.$css_id.' class="process-col '.$css_classes. $custom_class_name.' align-center '.$visibility_classes.' " '.$data_animations.'>';
			$output .= '<i class="font-icon '.$icon.'" ></i>';
			$output .= '<div class="process-info">'.do_shortcode( $content ).'</div>';
	        //$output .= '</div><div class="process-divider" style="height: '.intval($icon_size/2).'px;"></div>';
	        $output .= '<div class="process-sep" style="top: '.intval($icon_size/2).'px;"></div>';
			$output .= $custom_style_tag;
			$output .= '</div>';
	        return $output;
	}
	add_shortcode( 'process_col', 'be_process_col' );
}

//Change Module to process , instead of process_style1

add_action( 'tatsu_register_modules', 'oshine_register_process', 11 );
function oshine_register_process() {
	$controls = array (
		'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#process',
		'title' => __( 'Process', 'oshine-modules' ),
		'is_js_dependant' => false,
		'child_module' => 'process_col',
		'initial_children' => 4,
		'type' => 'multi',
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
											'border_color',
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
							array (
								'type' => 'accordion' ,
								'active' => array(0, 1),
								'group' => array (
									array (
										'type' => 'panel',
										'title' => __( 'Border', 'tatsu' ),
										'group' => array (
											'border_style',
											'border',
											'outer_border_color',
										)
									)
								)
							),
						)
					)
				),
			),
		),
		'atts' => array (
			array (
				'att_name' => 'border_color',
				'type' => 'color',
				'label' => __( 'Border Color', 'oshine-modules' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .process-sep' => array(
						'property' => 'background'
					)
				)
			),
			array (
				'att_name' => 'outer_border_color',
				'type' => 'color',
				'label' => __( 'Border Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'border-color',
						'when' => array('border', '!=', '0px 0px 0px 0px'),
					),
				),
			),
			array (
				'att_name' => 'border_style',
				'type' => 'select',
				'label' => __( 'Border Style', 'tatsu' ),
				'options' => array(
					'none' => 'None',
					'solid' => 'Solid',
					'dashed' => 'Dashed',
					'double' => 'Double',
					'dotted' => 'Dotted',
				),
				'default' => array( 'd' => 'solid', 'l' => 'solid', 't' => 'solid', 'm' => 'solid' ),
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'border-style',
						'when' => array(
							array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', 'notempty' ),
							array( 'border_style', '!=', array( 'd' => 'none' ) ),
						),
						'relation' => 'and',            
					),
				),
			),
			array (
				'att_name' => 'border',
				'type' => 'input_group',
				'label' => __( 'Border Width', 'tatsu' ),
				'default' => '0px 0px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'border-width',
						'when' => array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
					),
				),
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'border_color' => '#efefef', //sec_border
				),
			)
		),	        
	);
	if( function_exists( 'tatsu_remap_modules' ) ) {
		tatsu_remap_modules( [ 'process_style1', 'tatsu_process' ], $controls, 'be_process_style1' );
	}else {
		tatsu_register_module( 'process_style1', $controls );
	}
}



add_action( 'tatsu_register_modules', 'oshine_register_process_col', 11);
function oshine_register_process_col() {
	$controls = array (
		'icon' => '',
		'title' => __( 'Process Item', 'oshine-modules' ),
		'type' => 'sub_module',
		'hint' => 'content',
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
											'icon_color',
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
						)	
					),
				),
			),
		),
		'atts' => array (
			array (
				'att_name' => 'icon',
				'type' => 'icon_picker',
				'label' => __( 'Icon', 'oshine-modules' ),
				'default' => '',
				'tooltip' => '',
			),
			array (
				'att_name' => 'icon_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => __( 'Icon Color', 'oshine-modules' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.process-col .font-icon' => array(
						'property' => 'color',
					),
				),
			),
			array (
				'att_name' => 'icon_size',
				'type' => 'slider',
				'label' => __( 'Icon Size', 'oshine-modules' ),
				'options' => array(
					'min' => '0',
					'max' => '120',
					'step' => '1',
					'unit' => 'px',
				),		        		
				'default' => '60',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.process-col .font-icon' => array(
						'property' => 'font-size',
							'append' => 'px'
					),
				),
			),
			array (
				'att_name' => 'content',
				'type' => 'tinymce',
				'label' => __( 'Content', 'oshine-modules' ),
				'default' => '',
				'tooltip' => ''
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'icon' => 'icon-icon_desktop',
					'icon_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
					'icon_size' => '45',
					'content' => '<h6>Here is a Title</h6><p>Proin facilisis varius nunc. Curabitur eros risus, ultrices et dui ut, luctus accumsan nibh.</p>',
				),
			)
		),
	);
	if( function_exists( 'tatsu_remap_modules' ) ) {
		tatsu_remap_modules( [ 'process_col', 'tatsu_process_col' ], $controls, 'be_process_col' );
	}else {
		tatsu_register_module( 'process_col', $controls );
	}
}