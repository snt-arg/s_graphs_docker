<?php
/**************************************
			GRID
**************************************/ 
if (!function_exists('be_grids')) {
	function be_grids( $atts, $content, $tag ) {
		$atts = shortcode_atts( array (
			'column' => 1,
			'border_color' => '',
            'alignment' => 'center',
            'border_style'  => '',
            'border' => '',
            'outer_border_color'  => '',
            'border_radius' => '',
			'key' => be_uniqid_base36(true),
		), $atts, $tag );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

        $css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
        $data_animations = be_get_animation_data_atts( $atts );
        $classes = array( $custom_class_name, 'grid-wrap', 'oshine-module', 'align-' . $alignment );
        if( !empty( $visibility_classes ) ) {
            $classes[] = $visibility_classes;
        }
        if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        if( !empty( $css_classes ) ) {
            $classes[] = $css_classes;
        }

		if(empty( $column )) {
			$column = 2;
		}
		$GLOBALS['be_grid_alignment'] = isset($alignment) ? 'align-'.$alignment : 'align-center';
	    $output = "";
		$output .= '<div ' . $css_id . ' class="' . implode(' ', $classes ) . '" ' . $data_animations . ' data-col="'.$column.'">';
		$output .= $custom_style_tag;
		$output .= do_shortcode( $content );
	    $output .= '</div>';
	    return $output;
	}
	add_shortcode( 'grids', 'be_grids' );
}

if (!function_exists('be_grid_content')) {
	function be_grid_content( $atts, $content ){
			$atts = shortcode_atts( array (
				'icon' => '',
				'icon_size' => 'medium',
				'icon_color' => '',
		        'animate' => 0,
				'animation_type'=>'fadeIn',
				'key' => be_uniqid_base36(true),
			), $atts );
			
			extract( $atts );
			$custom_style_tag = be_generate_css_from_atts( $atts, 'grid_content', $atts['key'] );
			$custom_class_name = ' tatsu-'.$atts['key'];

	    	$animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : 0 ;
			$output = '';
	    	$output .= '<div class="'.$custom_class_name.' grid-col '.$animate.' '.$GLOBALS['be_grid_alignment'].'" data-animation="'.$animation_type.'">';
			$output .= ($icon != '') ? '<i class="font-icon '.$icon.' '.$icon_size.' "></i>' : '' ;
			$output .= ($content != '') ? '<div class="grid-info">'.be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) ).'</div>' : '';
			$output .= $custom_style_tag;
			$output .= '</div>';
	        return $output;
	}
	add_shortcode( 'grid_content', 'be_grid_content' );
}

add_action( 'tatsu_register_modules', 'oshine_register_grids');
function oshine_register_grids() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#grids',
	        'title' => __( 'Icon/Image Grid', 'oshine-modules' ),
			'is_js_dependant' => true,
			'child_module' => 'grid_content',
	        'type' => 'multi',
	        'initial_children' => 4,
			'is_built_in' => false,
			'group_atts' => array (
				array (
					'type'	=>	'tabs',
					'style'	=>	'style1',
					'group'	=>	array (
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Style' , 'tatsu'),
							'group'	=>	array (
                                'column',
                                'alignment',
                                'border_color',
							),
                        ),
                        array (
							'type'	=>	'tab',
							'title'	=>	__( 'Advanced' , 'tatsu'),
							'group'	=>	array (
                                array(
                                    'type'  => 'accordion',
                                    'group' => array (
                                        array (
                                            'type' => 'panel',
                                            'title' => __( 'Border', 'tatsu' ),
                                            'group' => array (
                                                'border_style',
                                                'border',
                                                'outer_border_color',
                                                'border_radius',
                                            ),
                                        ),
                                    )
                                )
                            )
                        )
					)
				),
			),
	        'atts' => array (
	            array (
	        		'att_name' => 'column',
	        		'type' => 'slider',
	        		'label' => __( 'Columns', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '1',
	        			'max' => '12',
	        			'step' => '1'
	        		),
	        		'default' => '1',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'border_color',
		            'type' => 'color',
		            'label' => __( 'Border Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .grid-col' => array(
							'property' => 'border-color'
						)
					)
	            ),
	            array (
	        		'att_name' => 'alignment',
                    'type' => 'button_group',
                    'is_inline' => true,
	        		'label' => __( 'Alignment', 'oshine-modules' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'center',
	        		'tooltip' => ''
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
                                array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                                array( 'border', '!=', '0px 0px 0px 0px' ),
                                array( 'border', 'notempty' ),
                                array( 'border_style', '!=', array( 'd' => 'none', 'l' => 'none', 't' => 'none', 'm' => 'none' ) ),
                            ),
                            'relation' => 'and',            
                        ),
                    ),
                ),
                array (
                    'att_name' => 'border',
                    'type' => 'input_group',
                    'exclude' => array('tatsu_empty_space'),
                    'label' => __( 'Border Width', 'tatsu' ),
                    'default' => '',
                    'tooltip' => '',
                    'responsive' => true,
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID}' => array(
                            'property' => 'border-width',
                            'when' => array(
                                array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                                array( 'border', '!=', '0px 0px 0px 0px' ),
                                array( 'border', 'notempty' ),
                                array( 'border_style', '!=', array( 'd' => 'none', 'l' => 'none', 't' => 'none', 'm' => 'none' ) ),
                            ),
                            'relation' => 'and',
                        ),
                    ),
                ),
                array (
                    'att_name' => 'outer_border_color',
                    'type' => 'color',
                    'exclude' => array('tatsu_empty_space'),
                    'label' => __( 'Border Color', 'tatsu' ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID}' => array(
                            'property' => 'border-color',
                            'when' => array(
                                array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                                array( 'border', '!=', '0px 0px 0px 0px' ),
                                array( 'border', 'notempty' ),
                                array( 'border_style', '!=', array( 'd' => 'none', 'l' => 'none', 't' => 'none', 'm' => 'none' ) ),
                            ),
                            'relation' => 'and',
                        ),
                    ),
                ),
                array (
                    'att_name'	=> 'border_radius',
                    'type'		=> 'number',
                    'is_inline' => true,
                    'label'		=> __( 'Border Radius', 'tatsu' ),
                    'options' 	=> array (
                        'unit'	=> array( 'px', '%' ),
                    ),
                    'default'	=> '',
                    'css'		=> true,
                    'selectors'	=> array (
                        '.tatsu-{UUID}'	=>  array (
                            'property' => 'border-radius',
                            'append' => 'px'
                        )
                    )
                ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'column' => '2',
	        			'border_color' => '#efefef',
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'grids', $controls );
}

add_action( 'tatsu_register_modules', 'oshine_register_grid_content');
function oshine_register_grid_content() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Grid Content', 'oshine-modules' ),
	        'is_js_dependant' => true,
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
								'icon',
								'content',
							),
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Style' , 'tatsu'),
							'group'	=>	array (
                                'icon_size',
                                'icon_color',
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
										'title' => __( 'Animation', 'tatsu' ),
										'group' => array (
											'animate',
											'animation_type',
											)
										),
									)
								)
							),
						),
					)
				),
			),
	        'atts' => array (
	            array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'icon_size',
                    'type' => 'button_group',
                    'is_inline' => true,
	        		'label' => __( 'Icon Size', 'oshine-modules' ),
	        		'options' => array (
						'tiny' => 'XS',
						'small' => 'S',
						'medium' => 'M', 
						'large' => 'L',
						'xlarge' => 'XL'
					),
	        		'default' => 'medium',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'icon_color',
		            'type' => 'color',
		            'label' => __( 'Icon Color', 'oshine-modules' ),
		            'default' => '', //color_scheme
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .font-icon' => array(
							'property' => 'color'
						)
					)
	            ),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content', 'oshine-modules' ),
	        		'default' => '',
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
					'tooltip' => '',
					'visible' => array ('animate' , '=' , '1'), 
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'icon' => 'icon-icon_desktop',
	        			'icon_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'content' => '<h6>Title goes here</h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',

	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'grid_content', $controls );
}

if( !function_exists( 'oshine_modules_remove_common_atts_from_grid_content' ) ) {
    add_filter( 'tatsu_default_common_atts_global_excludes', 'oshine_modules_remove_common_atts_from_grid_content' );
    function oshine_modules_remove_common_atts_from_grid_content( $excludes_array ) {
        $excludes_array[] = 'grid_content';
        return $excludes_array;
    }
}