<?php
/**************************************
			ACCORDION
**************************************/
if (!function_exists('be_accordion')) {
	function be_accordion( $atts, $content, $tag ) {
		$atts = shortcode_atts ( array ( 
            'collapsed' => 0,
            'key' => be_uniqid_base36(true),
        ), $atts, $tag );
        extract( $atts );

        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
        $css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
        $data_animations = be_get_animation_data_atts( $atts );
        $unique_class_name = ' tatsu-'.$atts['key'];
        $classes = array( $unique_class_name, 'accordion-wrap', 'oshine-module' );
        if( !empty( $visibility_classes ) ) {
            $classes[] = $visibility_classes;
        }
        if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        if( !empty( $css_classes ) ) {
            $classes[] = $css_classes;
        }

		return '<div ' . $css_id . ' class = "' . implode( ' ', $classes ) . '" ' . $data_animations . '>' . $custom_style_tag . '<div class = "accordion" data-collapsed="'.$collapsed.'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode( 'accordion', 'be_accordion' );
}

if (!function_exists('be_toggle')) {
	function be_toggle( $atts, $content ){
		$atts = shortcode_atts ( array ( 
				'title' => '',
				'title_color' => '',
				'title_bg_color' => '',
				'key' => be_uniqid_base36(true)
			), $atts	
		);

		extract ( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'toggle', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		$style = 'no-bg';
		$background_color = '';
		$title_padding = '';
		if (isset($title_bg_color) && !empty($title_bg_color) && '' != $title_bg_color){
			$background_color = 'background-color:'.$title_bg_color ;
			$title_padding = 'padding: 12px;';
			$style = 'with-bg';
		}
		return '<h3 class="accordion-head '.$style. $custom_class_name.'" style="'.$title_padding.'">'.$title. $custom_style_tag.'</h3><div>'.do_shortcode($content) . '</div>';
	}
	add_shortcode( 'toggle', 'be_toggle' );
}


add_action( 'tatsu_register_modules', 'oshine_register_accordion', 11);
function oshine_register_accordion() {
	$controls = array (
		'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#accordion',
		'title' => __( 'Accordion Toggles', 'oshine-modules' ),
		'is_js_dependant' => true,
		'child_module' => 'toggle',
		'allowed_sub_modules' => array( 'toggle' ),
		'type' => 'multi',
		'initial_children' => 2,
        'is_built_in' => true,
        'group_atts' => array (
            array(
                'type'  => 'tabs',
                'group' => array (
                    array (
                        'type'  => 'tab',
                        'title' => __( 'Content', 'oshine-modules' ),
                        'group' => array (
                            'collapsed'
                        )
                    ),
                    array (
                        'type'  => 'tab',
                        'title' => __( 'Advanced', 'oshine-modules' ),
                        'group' => array (
            
                        )
                    ),
                ),
            ),
        ),
		'atts' => array (
			array (
				'att_name' => 'collapsed',
				'type' => 'switch',
				'label' => __( 'Collapse content', 'oshine-modules' ),
				'default' => 0,
				'tooltip' => '',
			),
		),
	);
	if( function_exists( 'tatsu_remap_modules' ) ) {
		tatsu_remap_modules( [ 'accordion', 'tatsu_accordion' ], $controls, 'be_accordion' );
	}else {
		tatsu_register_module( 'accordion', $controls );
	}
}


add_action( 'tatsu_register_modules', 'oshine_register_toggle', 11);
function oshine_register_toggle() {
	$controls = array (
		'icon' => '',
		'title' => __( 'Toggle', 'oshine-modules' ),
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
							'title',
							'content',
						),
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
											'title_color',
											'title_bg_color',
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
				'att_name' => 'title',
				'type' => 'text',
				'label' => __( 'Accordian Title', 'oshine-modules' ),
				'default' => '',
				'tooltip' => ''
			),
			array (
				'att_name' => 'content',
				'type' => 'tinymce',
				'label' => __( 'Accordian Content', 'oshine-modules' ),
				'default' => '',
				'tooltip' => ''
			),	
			array (
				'att_name' => 'title_color',
				'type' => 'color',
				'label' => __( 'Title Color', 'oshine-modules' ),
				'default' => '',//sec_color
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.accordion-head' => array(
						'property' => 'color',
					),
				),
				
			),
			array (
				'att_name' => 'title_bg_color',
				'type' => 'color',
				'label' => __( 'Title Background Color', 'oshine-modules' ),
				'default' => '',//sec_bg
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.accordion-head' => array(
						'property' => 'background'
					),
				),
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'title' => 'Here goes your title',
					'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.'
				),
			)
		),  
	);
	if( function_exists( 'tatsu_remap_modules' ) ) {
		tatsu_remap_modules( [ 'toggle', 'tatsu_toggle' ], $controls, 'be_toggle' );
	}else {
		tatsu_register_module( 'toggle', $controls );
	}
}

if( !function_exists( 'oshine_modules_remove_common_atts_from_toggle' ) ) {
    add_filter( 'tatsu_default_common_atts_global_excludes', 'oshine_modules_remove_common_atts_from_toggle' );
    function oshine_modules_remove_common_atts_from_toggle( $excludes_array ) {
        $excludes_array[] = 'toggle';
        return $excludes_array;
    }
}