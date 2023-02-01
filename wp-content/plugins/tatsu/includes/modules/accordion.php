<?php
/**************************************
			ACCORDION
**************************************/
if ( !function_exists('tatsu_accordion') ) {
	function tatsu_accordion( $atts, $content, $tag ) {
		extract (
			shortcode_atts ( array ( 
                'style'     => 'style1',
                'collapsed' => 0,
                'title_color'   => '',
                'title_hover_color' => '',
                'content_bg_color' => '',
				'border_color'  => '#CACACA',
				'outer_border_color' => '',
                'title_font'    => 'h6',
                'content_font' => '',
                'margin'        => '',
                'animate' => '1',
                'key' => be_uniqid_base36(true),
			), $atts, $tag)
        );
        global $tatsu_accordion_title_font, $tatsu_accordion_content_font, $tatsu_accordion_content_bg;
        if( !empty( $title_font ) ) {
            $tatsu_accordion_title_font = $title_font;
        }else {
            $tatsu_accordion_title_font = '';
        }
        if( !empty( $content_font ) ) {
            $tatsu_accordion_content_font = $content_font;
        }else {
            $tatsu_accordion_content_font = '';
        }
        if( !empty( $content_bg_color ) ) {
            $tatsu_accordion_content_bg = $content_bg_color;
        }else {
            $tatsu_accordion_content_bg = '';
        }
        $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_accordion', $key );
        $unique_class_name = 'tatsu-' . $key;

		$data_animations = be_get_animation_data_atts( $atts );

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 

        $animate = ( isset( $animate ) && 1 == $animate  && 'none' != $animation_type ) ? ' tatsu-animate' : '';

        $style = !empty( $style ) ? $style : 'style1';
        $classes = array( 'tatsu-module', 'tatsu-accordion', 'tatsu-accordion-' . $style, $unique_class_name, $animate, $visibility_classes, $css_classes );
		return '<div '.$css_id.' class="' . implode( ' ', $classes ) . '" '.$data_animations.' >'. $custom_style_tag . '<div data-collapsed="'.$collapsed.'" class = "tatsu-accordion-inner">'. do_shortcode( tatsu_parse_custom_fields( $content ) ).'</div></div>';
	}
	add_shortcode( 'tatsu_accordion', 'tatsu_accordion' );
}

if ( !function_exists('tatsu_toggle') ) {
	function tatsu_toggle( $atts, $content ){
		$atts = shortcode_atts ( array ( 
				'title' => '',
				'field_type' => 'default'
			), $atts	
		);
        extract ( $atts );
        global $tatsu_accordion_title_font, $tatsu_accordion_content_font, $tatsu_accordion_content_bg;

		// if ( 'default' !== $field_type ) {
		// 	$image = tatsu_parse_custom_fields( $field_type );
		// 	$id = attachment_url_to_postid( $image );
		// }

		return '<h3 class="accordion-head ' . ( !empty( $tatsu_accordion_title_font ) ? $tatsu_accordion_title_font : '' ) . '">'. tatsu_parse_custom_fields( $title ) .'<span class = "tatsu-accordion-expand"></span></h3><div class = "accordion-content ' . ( !empty( $tatsu_accordion_content_font ) ? $tatsu_accordion_content_font : '' ) . '" ><div class = "accordion-content-inner ' . ( !empty( $tatsu_accordion_content_bg ) ? 'accordion-with-bg' : '' ) . '">'.do_shortcode( tatsu_parse_custom_fields( $content ) ) . '</div></div>';
	}
	add_shortcode( 'tatsu_toggle', 'tatsu_toggle' );
}

add_action('tatsu_register_modules', 'tatsu_register_accordion');
function tatsu_register_accordion()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#accordion',
		'title' => esc_html__('Accordion Toggles', 'tatsu'),
		'is_js_dependant' => true,
		'child_module' => 'tatsu_toggle',
		'allowed_sub_modules' => array('tatsu_toggle'),
		'type' => 'multi',
		'initial_children' => 3,
		'is_built_in' => true,
		'is_dynamic' => true,
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							'style',
							'collapsed',
							array(
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Colors', 'tatsu'),
										'group' => array(
											'title_color',
											'title_hover_color',
											'content_bg_color',
											'border_color',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Typography', 'tatsu'),
										'group' => array(
											'title_font',
											'content_font',
										)
									),
								),
							),
						)
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => array(0),
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Spacing', 'tatsu'),
										'group' => array(
											'margin'
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Border', 'tatsu'),
										'group' => array(
											'border_style',
											'border',
											'outer_border_color'
										)
									),
								)
							)
						)
					)
				)
			)				
		),
		'atts' => array_values(array_filter(array(
			array(
				'att_name' => 'style',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Style', 'tatsu'),
				'options'	=> array(
					'style1' => 'Style1',
					'style2' => 'Style 2',
				),
				'default' => 'style1',
				'tooltip' => '',
			),
			array(
				'att_name' => 'collapsed',
				'type' => 'switch',
				'label' => esc_html__('Collapse content', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
			array(
				'att_name' => 'title_color',
				'type' => 'color',
				'label' => esc_html__('Title Color', 'tatsu'),
				'default' => '', //sec_color
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .accordion-head' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'title_hover_color',
				'type' => 'color',
				'label' => esc_html__('Title Hover Color', 'tatsu'),
				'default' => '', //sec_color
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .accordion-head:hover' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'content_bg_color',
				'type' => 'color',
				'label' => esc_html__('Content Background Color', 'tatsu'),
				'default' => '', //sec_bg
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .accordion-content-inner' => array(
						'property' => 'background',
					),
				),
			),
			array(
				'att_name' => 'border_color',
				'type' => 'color',
				'label' => esc_html__('Border Color', 'tatsu'),
				'default' => '', //sec_bg
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .accordion-content.ui-accordion-content' => array(
						'property' => 'border-color'
					),
					'.tatsu-{UUID} .accordion-head.ui-accordion-header'	=> array(
						'property'	=> 'border-color'
					)
				),
			),
			array (
				'att_name' => 'outer_border_color',
				'type' => 'color',
				'label' => esc_html__( 'Border Color', 'tatsu' ),
				'default' => '',
				'exclude' => array( 'tatsu_image', 'tatsu_lists', 'tatsu_call_to_action' ),
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
				'label' => esc_html__( 'Border Style', 'tatsu' ),
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
				'label' => esc_html__( 'Border Width', 'tatsu' ),
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
			function_exists('typehub_get_exposed_selectors') ? array(
				'att_name'	=> 'title_font',
				'type'		=> 'select',
				'label'		=> esc_html__('Title Font', 'tatsu'),
				'options'	=> typehub_get_exposed_selectors(),
				'default'	=> 'h6',
				'tooltip'	=> ''
			) : false,
			function_exists('typehub_get_exposed_selectors') ? array(
				'att_name'	=> 'content_font',
				'type'		=> 'select',
				'label'		=> esc_html__('Content Font', 'tatsu'),
				'options'	=> typehub_get_exposed_selectors(),
				'default'	=> 'body',
				'tooltip'	=> ''
			) : false,
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '0 0 60px 0',
				'tooltip' => '',
				'css'	  => true,
				'responsive'	=> true,
				'selectors'	=> array(
					'.tatsu-{UUID}.tatsu-module'	=> array(
						'property'		=> 'margin',
					)
				)
			),
		))),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'border_color'	=> '#CACACA'
				),
			)
		),
	);
	tatsu_remap_modules(array('tatsu_accordion', 'accordion'), $controls, 'tatsu_accordion');
}

add_action('tatsu_register_modules', 'tatsu_register_toggle');
function tatsu_register_toggle()
{
	$controls = array(
		'icon' => '',
		'title' => esc_html__('Toggle', 'tatsu'),
		'child_module' => '',
		'type' => 'sub_module',
		'is_built_in' => false,
		'hint' => 'title',
		'atts' => array(
			array(
				'att_name' => 'title',
				'type' => 'text',
				'label' => esc_html__('Title', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'field_type',
				'type' => 'select',
				'label' => esc_html__('Field Type', 'tatsu'),
				'options' => tatsu_get_custom_fields_dropdown(),
				'default' => 'default',
				'tooltip' => '',
				'is_inline' => !is_tatsu_pro_active()
			),
			array(
				'att_name' => 'content',
				'type' => 'tinymce',
				'label' => esc_html__('Content', 'tatsu'),
				'visible'		=> array(
					'condition' => array(
						array( 'field_type', '=', '' ),
						array( 'field_type', '=', 'default' )
					),
					'relation'	=> 'or',
				),
				'default' => '',
				'tooltip' => ''
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
	tatsu_remap_modules(array('tatsu_toggle', 'toggle'), $controls, 'tatsu_toggle');
}

?>