<?php
/**************************************
			TABS
**************************************/
if (!function_exists('tatsu_tabs')) {
	function tatsu_tabs( $atts, $content, $tag ) {
        $atts = shortcode_atts( array (
            'title_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
            'background_color'=> array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
            'active_title_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
            'active_background_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
			'style' => 'style1',
			'border_color'	=> '',
			'outer_border_color' => '',
            'margin'        => '',
			'animate' => '1',
        	'key' => be_uniqid_base36(true),
        ),$atts, $tag );
        
        extract( $atts );

		$GLOBALS['tabs_cnt'] = 0;
		$tabs_cnt=0;
        $GLOBALS['tabs'] = array();
		$rand = rand();
        $content=do_shortcode( $content );
        $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_tabs', $key );
		$custom_class_name = 'tatsu-'.$atts['key'];
		$data_animations = be_get_animation_data_atts( $atts );

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		
		$animate = ( isset( $animate ) && 1 == $animate  && 'none' != $animation_type ) ? ' tatsu-animate ' : '';

		if( is_array( $GLOBALS['tabs'] ) ) {
			foreach( $GLOBALS['tabs'] as $tab ) {
				$tabs_cnt++;
				$icon_tag = ( ! empty($tab['icon']) && $tab['icon'] != 'none' ) ? '<i class="tab-icon '.$tab['icon'].'"></i>' : "" ;
				$tabs[] = '<li><a class="h6" id="'.$tab['class_name'].'" href="#fragment-'.$tabs_cnt.'-'.$rand.'">'.  $icon_tag . $tab['title'].'</a> '. $tab['custom_style_tag'] .' </li>';
				$panes[] = '<div id="fragment-'.$tabs_cnt.'-'.$rand.'" class="clearfix be-tab-content">'.$tab['content'].'</div>';
			}
			$return = ($panes || $tabs) ? "\n".'<div '.$css_id.' class="tatsu-tabs '.$animate.' tatsu-module tatsu-tabs-'. $style . ' ' . $custom_class_name. ' '. $visibility_classes . '  '. $css_classes. '" '. $data_animations .' ><div class="tatsu-tabs-inner  "><ul class="clearfix be-tab-header">'.implode( "\n", $tabs ).'</ul>'.implode( $panes ) .''. $custom_style_tag .'</div></div>'."\n" : '' ; 
		}
		return $return;
	}
}

if (!function_exists('tatsu_tab')) {
	function tatsu_tab( $atts, $content ){
		$atts = shortcode_atts( array(
	        'icon' => '',
	        'title' => '',
			'title_color' => '',
			'key' => be_uniqid_base36(true),
		),$atts );
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_tab', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];

		extract( $atts );

		$content= do_shortcode($content);
		$x = $GLOBALS['tabs_cnt'];
		$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tabs_cnt'] ), 'content' =>  $content, 'icon'=> $icon, 'class_name' => $custom_class_name, 'custom_style_tag' => $custom_style_tag );
		$GLOBALS['tabs_cnt']++;
	}
}

add_action('tatsu_register_modules', 'tatsu_register_tabs');
function tatsu_register_tabs()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#tabs',
		'title' => esc_html__('Tabs', 'tatsu'),
		'is_js_dependant' => true,
		'child_module' => 'tatsu_tab',
		'type' => 'multi',
		'initial_children' => 2,
		'is_built_in' => true,
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
							array(
								'type' => 'accordion',
								'active' => array(0),
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Colors', 'tatsu'),
										'group' => array(
											array(
												'type'  	=> 'tabs',
												'style'		=> 'style1',
												'group'		=> array(
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Normal', 'tatsu'),
														'group'		=> array(
															'title_color',
															'background_color',
															'border_color',
														),
													),
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Active', 'tatsu'),
														'group'		=> array(
															'active_title_color',
															'active_background_color',
														),
													),
												),
											),
										)
									),
								),
							),
						),
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
				'type' => 'select',
				'is_inline' => true,
				'label' => esc_html__('Style', 'tatsu'),
				'options' => array(
					'style1' 	=> 'Style 1',
					'style2' 	=> 'Style 2',
					'style3' 	=> 'Style 3',
					'style4' 	=> 'Style 4',
				),
				'default' => 'style1',
				'tooltip' => ''
			),
			array(
				'att_name' => 'title_color',
				'type' => 'color',
				'label' => esc_html__('Title Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .ui-state-default' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'background_color',
				'type' => 'color',
				'label' => esc_html__('Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array(
					'condition' => array(
						array('style', '!=', 'style1'),
						array('style', '!=', 'style3')
					),
					'relation'	=> 'and',
				),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .ui-state-default' => array(
						'property' => 'background',
						'when' => array(
							array('style', '=', 'style2'),
							array('style', '=', 'style4'),
						),
						'relation' => 'or',
					)
				),
			),
			array(
				'att_name' => 'active_title_color',
				'type' => 'color',
				'label' => esc_html__('Active Title Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .ui-state-default.ui-tabs-active' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'active_background_color',
				'type' => 'color',
				'label' => esc_html__('Active Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array('style', '!=', 'style1'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .ui-state-default.ui-tabs-active' => array(
						'property' => 'background',
						'when' => array('style', '!=', 'style1')
					),
				),
			),
			array(
				'att_name' => 'border_color',
				'type'	   => 'color',
				'label'		=> esc_html__('Border Color', 'tatsu'),
				'default'	=> '#d8d8d8',
				'tooltip'	=> '',
				'visible'	=> array(
					'style', '=', 'style1'
				),
				'css'	=> true,
				'selectors'	=> array(
					'.tatsu-{UUID} .ui-tabs .ui-tabs-nav' => array(
						'property'	=> 'border-color',
						'when'		=> array(
							'style', '=', 'style1'
						),
					),
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
		))),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'style'		=> 'style2',
					'title_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'background_color' => array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
					'active_title_color' => array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
					'active_background_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
				),
			)
		),


	);
	tatsu_remap_modules(array('tatsu_tabs', 'tabs'), $controls, 'tatsu_tabs');
}

add_action('tatsu_register_modules', 'tatsu_register_tab');
function tatsu_register_tab()
{
	$controls = array(
		'icon' => '',
		'title' => esc_html__('Tab', 'tatsu'),
		'child_module' => '',
		'type' => 'sub_module',
		'is_built_in' => true,
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
				'att_name' => 'icon',
				'type' => 'icon_picker',
				'label' => esc_html__('Icon', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'content',
				'type' => 'tinymce',
				'label' => esc_html__('Content', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'title' => 'Tab Title',
					'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.'
				),
			)
		),
	);
	tatsu_remap_modules(array('tatsu_tab', 'tab'), $controls, 'tatsu_tab');
}

?>