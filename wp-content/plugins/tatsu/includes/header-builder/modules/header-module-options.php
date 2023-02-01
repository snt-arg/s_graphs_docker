<?php

// add_action( 'tatsu_register_header_modules', 'tatsu_register_header_row' );
// function tatsu_register_header_row() {
// 		$controls = array (
// 	        'icon' => '',
// 	        'title' => esc_html__( 'Row', 'tatsu' ),
// 	        'is_js_dependant' => false,
// 	        'child_module' => 'tatsu_header_column',
// 	        'type' => 'core',
// 	        'builder_layout' => 'column',
// 			'label' => 'Row',
// 			'initial_children' => 2,
// 			'is_built_in' => true,
// 			'group_atts' => array(
// 				'full_width',
// 				'bg_color',
// 				'padding',
// 				'default_visibility',
// 				'sticky_visibility',
// 				'sticky_padding',
// 				'border',
// 				'border_color',
// 				'overflow_content',
// 				'box_shadow',
// 				array (
// 					'type' => 'accordion' ,
// 					'active' => 'none',
// 					'group' => array (		
// 						array (
// 							'type' => 'panel',
// 							'title' => esc_html__( 'Identifiers', 'tatsu' ),
// 							'group' => array (
// 								'row_title',
// 								'id',
// 								'class'
// 							)
// 						),
// 						array (
// 							'type' => 'panel',
// 							'title' => esc_html__( 'Transparency Settings', 'tatsu' ),
// 							'group' => array (
// 								'transparent_row_bg',
// 								'transparent_row_border',
// 								'disable_color_scheme'
// 							)
// 						),
// 					) 
// 				),
// 				'hide_in'
// 			),
// 	        'atts' => array (
//                 array (
//                     'att_name' => 'full_width',
//                     'type' => 'switch',
//                     'label' => esc_html__( 'Full Width Header ?', 'tatsu' ),
//                     'default' => false,
//                     'tooltip' => '',
//                 ),
// 	             array (
// 	              'att_name' => 'bg_color',
// 				  'type' => 'color',
// 				  'options' => array (
// 						'gradient' => true
// 				  ),
// 	              'label' => esc_html__( 'Background Color', 'tatsu' ),
// 	              'default' => '#ffffff',
// 				  'tooltip' => '',
// 				  'css' => true,
// 				  'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-header' => array(
// 							'property' => 'background-color',
// 						)
// 					)
// 	            ),
// 				array (
// 					'att_name' => 'default_visibility',
// 					'type' => 'button_group',
// 					'label' => esc_html__( 'Default Visibility', 'tatsu' ),
// 					'options' => array (
// 						'visible' => 'Visible',
// 						'hidden' => 'Hidden',	        			
// 					),
// 					'default' => 'visible',
// 					'tooltip' => '',
// 				),
// 				array (
// 					'att_name' => 'sticky_visibility',
// 					'type' => 'button_group',
// 					'label' => esc_html__( 'Visibility in Sticky Header', 'tatsu' ),
// 					'options' => array (
// 						'visible' => 'Visible',
// 						'hidden' => 'Hidden',	        			
// 					),
// 					'default' => 'visible',
// 					'tooltip' => '',
// 				),
// 				array (
// 					'att_name' => 'padding',
// 					'type' => 'input_group',
// 					'label' => esc_html__( 'Padding', 'tatsu' ),
// 					'default' => '30px 0px 30px 0px',
// 					'tooltip' => '',
// 					'responsive' => true,
// 					'css' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID} .tatsu-header-row' => array(
// 							'property' => 'padding'
// 						)
// 					),
// 				), 
// 				array (
// 					'att_name'			=> 'box_shadow',
// 					'label'				=> esc_html__( 'Box Shadow', 'tatsu' ),
// 					'type'				=> 'input_box_shadow',
// 					'default'			=> '0px 0px 0px 0px rgba(0,0,0,0)',
// 					'css'				=> true,
// 					'selectors'			=> array (
// 						'.tatsu-{UUID}.tatsu-header' => array (
// 							'property'	=> 'box-shadow',
// 						)
// 					)
	
// 				),
// 				array (
// 					'att_name' => 'sticky_padding',
// 					'type' => 'input_group',
// 					'label' => esc_html__( 'Sticky Padding', 'tatsu' ),
// 					'default' => '15px 0px 15px 0px',
// 					'tooltip' => '',
// 					'responsive' => true,
// 					'css' => true,
// 					'selectors' => array(
// 						'#tatsu-header-wrap.stuck .tatsu-{UUID} .tatsu-header-row' => array(
// 							'property' => 'padding',
// 						)
// 					),
// 				),            	             
// 	            array (
// 	              'att_name' => 'border',
// 	              'type' => 'input_group',
// 	              'label' => esc_html__( 'Border Thickness', 'tatsu' ),
// 	              'default' => '0px 0px 0px 0px',
// 	              'tooltip' => '',
// 				  'css' => true,
// 				  'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-header' => array(
// 							'property' => 'border-width',
// 							'when' => array( 'border', '!=', '0px 0px 0px 0px' ),
// 						)
// 					)
// 	            ),
// 	            array (
// 	              'att_name' => 'border_color',
// 				  'type' => 'color',
// 	              'label' => esc_html__( 'Border Color', 'tatsu' ),
// 	              'default' => '',
// 	              'tooltip' => '',
// 				  'css' => true,
// 				  'visible' => array( 'border', '!=', '0px 0px 0px 0px' ),
// 				  'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-header' => array(
// 							'property' => 'border-color',
// 							'when' => array( 'border', '!=', '0px 0px 0px 0px' ),
// 						)
// 					)
// 				),	
// 				array (
// 					'att_name' => 'transparent_row_bg',
// 					'type' => 'color',
// 					'options' => array (
// 						  'gradient' => true
// 					),
// 					'label' => esc_html__( 'Background Color when Header is Transparent', 'tatsu' ),
// 					'default' => 'rgba(0,0,0,0)',
// 					'tooltip' => '',
// 					'css' => true,
// 					'selectors' => array(
// 						  '#tatsu-header-wrap.transparent:not(.stuck) .tatsu-header.tatsu-{UUID}' => array(
// 							  'property' => 'background',
// 						  )
// 					  )
// 				  ),
// 				  array (
// 					'att_name' => 'transparent_row_border',
// 					'type' => 'color',
// 					'label' => esc_html__( 'Border Color when Header is Transparent', 'tatsu' ),
// 					'default' => 'rgba(0,0,0,0)',
// 					'tooltip' => '',
// 					'css' => true,
// 					'visible' => array( 'border', '!=', '0px 0px 0px 0px' ),
// 					'selectors' => array(
// 						  '#tatsu-header-wrap.transparent:not(.stuck) .tatsu-header.tatsu-{UUID}' => array(
// 							  'property' => 'border-color',
// 							//   'when' => array( 'border', '!=', '0px 0px 0px 0px' ),
// 						  )
// 					  )
// 				  ),	
// 				  array (
//                     'att_name' => 'disable_color_scheme',
//                     'type' => 'switch',
//                     'label' => esc_html__( 'Do Not Apply Color Scheme', 'tatsu' ),
//                     'default' => false,
//                     'tooltip' => '',
//                 ),
// 				array (
// 					'att_name' => 'row_title',
// 					'type' => 'text',
// 					'label' => esc_html__( 'Row Title', 'tatsu' ),
// 					'default' => '',
// 					'tooltip' => '',
// 				  ),
//                 array (
//                     'att_name' => 'hide_in',
//                     'type' => 'screen_visibility',
//                     'label' => esc_html__( 'Hide in', 'tatsu' ),
//                     'default' => '',
//                     'tooltip' => '',
//                 ),
// 	             array (
// 	              'att_name' => 'id',
// 	              'type' => 'text',
// 	              'label' => esc_html__( 'Custom Id', 'tatsu' ),
// 	              'default' => '',
// 	              'tooltip' => '',
// 	            ),
// 	             array (
// 	              'att_name' => 'class',
// 	              'type' => 'text',
// 	              'label' => esc_html__( 'Custom Class', 'tatsu' ),
// 	              'default' => '',
// 	              'tooltip' => '',
// 	            ),
// 	        ),
// 	    );
// 	tatsu_register_header_module( 'tatsu_header_row', $controls, 'tatsu_header_row' );
// }

// add_action( 'tatsu_register_header_modules', 'tatsu_register_header_column' );
// function tatsu_register_header_column() {
//     $controls = array (
//         'icon' => '',
//         'title' => esc_html__( 'Column', 'tatsu' ),
//         'is_js_dependant' => false,
//         'type' => 'core',
// 		'builder_layout'=> 'list',
//         'is_built_in' => true,
//         'child_module' => 'module',
//         'initial_children' => 0,
//         'atts' => array (
//             array (
//                 'att_name' => 'column_width',
//                 'type' => 'slider',
//                 'label' => esc_html__( 'Width', 'tatsu' ),
//                 'options' => array(
//                     'min' => '0',
//                     'max' => '100',
//                     'step' => '1',
//                     'unit' => '%',
//                 ),		        		
//                 'default' => '',
// 				'tooltip' => '',
// 				'hide_in_sidebar_col' => true,
//                 'responsive' => true,
//                 'css' => true,
//                 'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-header-col' => array(
// 						'property' => 'flex-basis',
// 						'append' => '%'
// 					)
//                 ),
//             ),
//             array (
//                 'att_name' => 'horizontal_alignment',
//                 'type' => 'button_group',
//                 'label' => esc_html__( 'Horizontal Alignment', 'tatsu' ),
//                 'options' => array (
//                     'flex-start' => 'Left',
//                     'center' => 'Center',	        			
//                     'flex-end' => 'Right',
//                 ),
//                 'default' => 'flex-start',
// 				'tooltip' => '',
// 				'css' => true,
// 				'responsive' => true,
// 				'hide_in_sidebar_col' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-header-col' => array(
// 						'property' => 'justify-content',
// 					)
// 				),
// 			),
//             array (
//                 'att_name' => 'vertical_alignment',
//                 'type' => 'button_group',
//                 'label' => esc_html__( 'Vertical Alignment', 'tatsu' ),
//                 'options' => array (
//                     'flex-start' => 'Top',
//                     'center' => 'Middle',	        			
//                     'flex-end' => 'Bottom',
//                 ),
//                 'default' => 'center',
// 				'tooltip' => '',
// 				'css' => true,
// 				'responsive' => true,
// 				'hide_in_sidebar_col' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-header-col' => array(
// 						'property' => 'align-items',
// 					)
// 				),
// 			),
//             array (
//               'att_name' => 'padding',
//               'type' => 'input_group',
//               'label' => esc_html__( 'Padding', 'tatsu' ),
//               'default' => '0px 0px 0px 0px',
//               'tooltip' => '',
// 			  'css' => true,
// 			  'responsive' => true,
// 			  'hide_in_sidebar_col' => true,
//               'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-header-col' => array(
// 						'property' => 'padding',
// 					)
//                 ),
//             ),
//             array (
//                 'att_name' => 'sidebar_vertical_alignment',
//                 'type' => 'button_group',
//                 'label' => esc_html__( 'Vertical Alignment', 'tatsu' ),
//                 'options' => array (
//                     'flex-start' => 'Top',
//                     'center' => 'Middle',	        			
//                     'flex-end' => 'Bottom',
//                 ),
//                 'default' => 'center',
// 				'tooltip' => '',
// 				'css' => true,
// 				'hide_in_header_col' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-slide-menu-col' => array(
// 						'property' => 'justify-content',
// 					),
// 					'.tatsu-{UUID}.tatsu-slide-menu-col' => array(
// 						'property' => 'justify-content',
// 					)
// 				),
// 			),
//             array (
//                 'att_name' => 'sidebar_horizontal_alignment',
//                 'type' => 'button_group',
//                 'label' => esc_html__( 'Horizontal Alignment', 'tatsu' ),
//                 'options' => array (
//                     'flex-start' => 'Left',
//                     'center' => 'Center',	        			
//                     'flex-end' => 'Right',
//                 ),
//                 'default' => 'flex-start',
// 				'tooltip' => '',
// 				'css' => true,
// 				'hide_in_header_col' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-slide-menu-col' => array(
// 						'property' => 'align-items',
// 					),
// 				),
// 			),
//              array (
//               'att_name' => 'hide_in',
//               'type' => 'screen_visibility',
//               'label' => esc_html__( 'Hide in', 'tatsu' ),
//               'default' => '',
//               'tooltip' => '',
//             ),
//             array (
//                 'att_name' => 'id',
//                 'type' => 'text',
//                 'label' => esc_html__( 'Custom Id', 'tatsu' ),
//                 'default' => '',
//                 'tooltip' => '',
//               ),
//                array (
//                 'att_name' => 'class',
//                 'type' => 'text',
//                 'label' => esc_html__( 'Custom Class', 'tatsu' ),
//                 'default' => '',
//                 'tooltip' => '',
//               ),
//         ),
//     );
// 	tatsu_register_header_module( 'tatsu_header_column', $controls, 'tatsu_header_column' );
// 	tatsu_register_header_module( 'tatsu_slide_menu_column', $controls, 'tatsu_header_column' );
// }

// add_action( 'tatsu_register_header_modules', 'tatsu_register_header_logo' );
// function tatsu_register_header_logo() {
//     $controls = array (
//         'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#header_logo',
//         'title' => esc_html__( 'Logo', 'tatsu' ),
//         'is_js_dependant' => false,
//         'type' => 'single',
// 		'is_built_in' => true,
// 		'inline' => true,
//         'initial_children' => 0,
// 		'atts' => array (
// 			array (
// 				'att_name' => 'height',
// 				'type' => 'slider',
// 				'label' => esc_html__( 'Logo Height', 'tatsu' ),
// 				'options' => array(
// 					'min' => '0',
// 					'max' => '500',
// 					'step' => '1',
// 					'unit' => 'px',
// 				),
// 				'default' => '30',
// 				'tooltip' => '',
// 				'css' => true,
// 				'responsive' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID} .logo-img' => array(
// 						'property' => 'max-height',
// 						'append' => 'px',
// 					),
// 				),
// 			),
// 			array (
// 				'att_name' => 'sticky_height',
// 				'type' => 'slider',
// 				'label' => esc_html__( 'Sticky Header - Logo Height', 'tatsu' ),
// 				'options' => array(
// 					'min' => '0',
// 					'max' => '500',
// 					'step' => '1',
// 					'unit' => 'px',
// 				),
// 				'default' => '30',
// 				'tooltip' => '',
// 				'responsive' => true,
// 				'css' => true,
// 				'selectors' => array(
// 					'#tatsu-header-wrap.stuck .tatsu-{UUID} .logo-img' => array(
// 						'property' => 'height',
// 						'append' => 'px',
// 					),
// 				),
// 			),
// 			array (
// 				'att_name' => 'default',
// 				'type' => 'single_image_picker',
// 				'label' => esc_html__( 'Default Logo', 'tatsu' ),
// 				'default' => TATSU_PLUGIN_URL.'/img/exponent-dark-logo.svg',
// 				'tooltip' => '',
// 			),
// 			array (
// 				'att_name' => 'dark',
// 				'type' => 'single_image_picker',
// 				'label' => esc_html__( 'Dark Logo', 'tatsu' ),
// 				'default' => TATSU_PLUGIN_URL.'/img/exponent-dark-logo.svg',
// 				'tooltip' => '',
// 			),
// 			array (
// 				'att_name' => 'light',
// 				'type' => 'single_image_picker',
// 				'label' => esc_html__( 'Light Logo', 'tatsu' ),
// 				'default' => TATSU_PLUGIN_URL.'/img/exponent-light-logo.svg',
// 				'tooltip' => '',
// 			),
// 			array (
// 			  'att_name' => 'margin',
// 			  'type' => 'input_group',
// 			  'label' => esc_html__( 'Margin', 'tatsu' ),
// 			  'default' => '0px 30px 0px 0px',
// 			  'tooltip' => '',
// 			  'css' => true,
// 			  'responsive' => true,
// 			  'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-header-logo' => array(
// 						'property' => 'margin',
// 					)
// 				),
// 			),
// 			 array (
// 			  'att_name' => 'hide_in',
// 			  'type' => 'screen_visibility',
// 			  'label' => esc_html__( 'Hide in', 'tatsu' ),
// 			  'default' => '',
// 			  'tooltip' => '',
// 			),
// 			array (
// 				'att_name' => 'id',
// 				'type' => 'text',
// 				'label' => esc_html__( 'Custom Id', 'tatsu' ),
// 				'default' => '',
// 				'tooltip' => '',
// 			  ),
// 			   array (
// 				'att_name' => 'class',
// 				'type' => 'text',
// 				'label' => esc_html__( 'Custom Class', 'tatsu' ),
// 				'default' => '',
// 				'tooltip' => '',
// 			  ),
// 			  array (
// 				  'att_name' => 'hide_in',
// 				  'type' => 'screen_visibility',
// 				  'label' => esc_html__( 'Hide in', 'tatsu' ),
// 				  'default' => '',
// 				  'tooltip' => '',
// 			  ),
// 		),
//     );
// 	tatsu_register_header_module( 'tatsu_header_logo', $controls, 'tatsu_header_logo' );
// }

// add_action( 'tatsu_register_header_modules', 'tatsu_register_hamburger_menu' );
// function tatsu_register_hamburger_menu() {
//     $controls = array (
//         'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#hamburger_menu',
//         'title' => esc_html__( 'Hamburger Menu', 'tatsu' ),
//         'is_js_dependant' => true,
//         'type' => 'multi',
// 		'is_built_in' => true,
// 		'inline' => true,
// 		'builder_layout' => 'column',
//         'child_module' => 'tatsu_slide_menu_column',
// 		'initial_children' => 3,
// 		'atts' => array (

// 			array (
// 				'att_name' => 'menu_icon_color',
// 				'type' => 'color',
// 				'options' => array (
// 					  'gradient' => true
// 				),
// 				'label' => esc_html__( 'Icon Color', 'tatsu' ),
// 				'default' => '',
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 					  '.tatsu-{UUID}.tatsu-hamburger span' => array(
// 						  'property' => 'background-color',
// 					  	)
// 				  	)
// 				 ),
// 			array (
// 				'att_name' => 'menu_icon_hover_color',
// 				'type' => 'color',
// 				'options' => array (
// 						'gradient' => true
// 				),
// 				'label' => esc_html__( 'Icon Hover Color', 'tatsu' ),
// 				'default' => '',
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-hamburger:hover span' => array(
// 							'property' => 'background-color',
// 							)
// 					)
// 				),
// 			array (
// 				'att_name' => 'icon_width',
// 				'type' => 'slider',
// 				'label' => esc_html__( 'Line Width', 'tatsu' ),
// 				'options' => array(
// 					'min' => '0',
// 					'max' => '100',
// 					'step' => '1',
// 					'unit' => 'px',
// 				),		        		
// 				'default' => '27',
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-hamburger span' => array(
// 						'property' => 'width',
// 						'when' => array ( 'icon_width' , '!=' , '27' ),
// 						'append' => 'px'
// 					),
// 				)
// 			),	
// 			array (
// 				'att_name' => 'icon_thickness',
// 				'type' => 'slider',
// 				'label' => esc_html__( 'Line Thickness', 'tatsu' ),
// 				'options' => array(
// 					'min' => '0',
// 					'max' => '10',
// 					'step' => '1',
// 					'unit' => 'px',
// 				),		        		
// 				'default' => '2',
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-hamburger span' => array(
// 						'property' => 'height' ,
// 						'when' => array ( 'icon_thickness' , '!=' , '2' ),
// 						'append' => 'px'
// 					),
// 				)
// 			),	
// 			array (
// 				'att_name' => 'icon_spacing',
// 				'type' => 'slider',
// 				'label' => esc_html__( 'Line Spacing', 'tatsu' ),
// 				'options' => array(
// 					'min' => '0',
// 					'max' => '30',
// 					'step' => '1',
// 					'unit' => 'px',
// 				),		        		
// 				'default' => '5',
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-hamburger span' => array(
// 						'property' => 'margin-bottom' ,
// 						'when' => array ( 'icon_spacing' , '!=' , '5' ),
// 						'append' => 'px'
// 					),
// 				)
// 			),		
// 			array (
// 				'att_name' => 'margin',
// 				'type' => 'input_group',
// 				'label' => esc_html__( 'Margin', 'tatsu' ),
// 				'default' => '0px 30px 0px 0px',
// 				'tooltip' => '',
// 				'css' => true,
// 				'responsive' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-hamburger' => array(
// 						'property' => 'margin',
// 					)
// 				),
// 			),
// 			array (
// 				'att_name' => 'panel_width',
// 				'type' => 'slider',
// 				'label' => esc_html__( 'Panel Width', 'tatsu' ),
// 				'options' => array(
// 					'min' => '0',
// 					'max' => '600',
// 					'step' => '20',
// 					'unit' => 'px',
// 				),		  
// 				'responsive'	=> true,      		
// 				'default' => '300',
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-slide-menu' => array(
// 						'property' => array( 'width', 'transformX'),
// 						'when' => array ( 'panel_width' , '!=' , '300' ),
// 						'append' => 'px'
// 					),
// 				)
// 			),	
// 			array (
// 				'att_name' => 'panel_background_color',
// 				'type' => 'color',
// 				'options' => array (
// 						'gradient' => true
// 				),
// 				'label' => esc_html__( 'Panel Background Color', 'tatsu' ),
// 				'default' => '',
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 						'#tatsu-{UUID}.tatsu-slide-menu' => array(
// 							'property' => 'background-color',
// 							)
// 						)
// 				),	 
//                 array (
//                     'att_name' => 'hide_in',
//                     'type' => 'screen_visibility',
//                     'label' => esc_html__( 'Hide in', 'tatsu' ),
//                     'default' => '',
//                     'tooltip' => '',
//                 ),

// 		),
//     );
// 	tatsu_register_header_module( 'tatsu_hamburger_menu', $controls, 'tatsu_hamburger_menu' );
// }

// add_action( 'tatsu_register_header_modules', 'tatsu_register_navigation_menu' );
// function tatsu_register_navigation_menu() {

// 	$controls = array (
//         'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#horizontal_nav_menu',
//         'title' => esc_html__( 'Horizontal Menu', 'tatsu' ),
//         'is_js_dependant' => true,
//         'type' => 'single',
// 		'is_built_in' => false,
// 		'inline' => true,
// 		'builder_layout' => 'column',
// 		'group_atts' => array(
// 			'menu_name',
// 			// 'disable_in_mobile',
// 			array (
// 				'type' => 'accordion' ,
// 				'active' => 'none',
// 				'group' => array (
// 					array (
// 						'type' => 'panel',
// 						'title' => esc_html__( 'Spacing', 'tatsu' ),
// 						'group' => array (
// 							'margin',
// 							'links_margin'
// 						)
// 					),
// 					array (
// 						'type' => 'panel',
// 						'title' => esc_html__( 'Colors', 'tatsu' ),
// 						'group' => array (
// 							'menu_color',
// 							'menu_hover_color',
// 							'transparent_menu_hover_color',
// 							'transparent_menu_hover_color_dark'
// 						)
// 					),	
// 					array (
// 						'type' => 'panel',
// 						'title' => esc_html__( 'Sub Menu', 'tatsu' ),
// 						'group' => array (
// 							'submenu_width',
// 							'submenu_padding',
// 							'sub_menu_bg_color',
// 							'sub_menu_text_color',
// 							'sub_menu_hover_color',
// 							'sub_menu_hover_bg_color',
// 							'sub_menu_border',
// 							'sub_menu_shadow',
// 							'mega_menu'
// 						)
// 					),
// 					array (
// 						'type' => 'panel',
// 						'title' => esc_html__( 'Typography', 'tatsu' ),
// 						'group' => array (
// 							'menu_link',
// 							'sub_menu_link'
// 						)
// 					),
// 				) 
// 			),
// 			'hide_in'
// 		),
// 		'atts' => array (
// 			array (
// 				'att_name' => 'menu_name',
// 				'type' => 'select',
// 				'label' => esc_html__( 'Menu Name', 'oshine-modules' ),
// 				'options' => tatsu_header_get_menu_list()[0],
// 				'tooltip' => '',
// 				'default' => tatsu_header_get_menu_list()[1]
// 			),
// 			// array (
// 			// 	'att_name' => 'disable_in_mobile',
// 			// 	'type' => 'switch',
// 			// 	'label' => esc_html__( 'Disable in Mobile', 'tatsu' ),
// 			// 	'default' => false,
// 			// 	'tooltip' => '',
// 			// ),
// 			array (
// 				'att_name' => 'margin',
// 				'type' => 'input_group',
// 				'label' => esc_html__( 'Margin', 'tatsu' ),
// 				'default' => '0px 30px 0px 0px',
// 				'tooltip' => '',
// 				'css' => true,
// 				'responsive' => true,
// 				'selectors' => array(
// 					  '.tatsu-{UUID}.tatsu-menu' => array(
// 						  'property' => 'margin',
// 					  ),
// 					  '.tatsu-{UUID}.tatsu-mobile-menu + .tatsu-mobile-menu-icon' => array(
// 						'property' => 'margin',
// 					  ),
// 				  ),
// 			  ), 
// 			  array (
// 				'att_name' => 'links_margin',
// 				'type' => 'input_group',
// 				'label' => esc_html__( 'Space between Links', 'tatsu' ),
// 				'default' => '0px 10px 0px 0px',
// 				'tooltip' => '',
// 				'css' => true,
// 				'responsive' => true,
// 				'selectors' => array(
// 					  '.tatsu-{UUID}.tatsu-menu > ul > li' => array(
// 						  'property' => 'margin',
// 					  ),
// 				  ),
// 			  ), 
// 			//Main Menu Options
// 			array (
// 				'att_name' => 'menu_color',
// 				'type' => 'color',
// 				'label' => esc_html__( 'Menu Color', 'tatsu' ),
// 				'default' => '#000000',
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-menu a' => array(
// 							'property' => 'color',
// 						),
// 						'.tatsu-{UUID}.tatsu-menu li svg polyline' => array(
// 							'property' => 'stroke',
// 						)
// 					)
// 				),	
// 			array (
// 				'att_name' => 'menu_hover_color',
// 				'type' => 'color',
// 				'label' => esc_html__( 'Menu Hover Color', 'tatsu' ),
// 				'default' => 'rgba(34,147,215,1)',
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-menu > ul > li:hover > a' => array(
// 							'property' => 'color',
// 						),
// 						'.tatsu-{UUID}.tatsu-menu > ul > li:hover > .sub-menu-indicator svg polyline' => array(
// 							'property' => 'stroke'
// 						),
// 						'.tatsu-{UUID}.tatsu-menu > ul > li.current-menu-item > a' => array(
// 							'property' => 'color',
// 						),
// 						'.tatsu-{UUID}.tatsu-menu > ul > li.current-menu-item > .sub-menu-indicator svg polyline' => array(
// 							'property' => 'stroke'
// 						),
// 						'.tatsu-{UUID}.tatsu-menu li.current-menu-parent > a' => array(
// 							'property' => 'color',
// 						),
// 						'.tatsu-{UUID}.tatsu-menu > ul > li.current-menu-parent > .sub-menu-indicator svg polyline' => array(
// 							'property' => 'stroke'
// 						),
// 						'.tatsu-{UUID}.tatsu-mobile-menu > ul > li:hover > a' => array(
// 							'property' => 'color',
// 						),
// 						'.tatsu-{UUID}.tatsu-mobile-menu > ul > li:hover > .sub-menu-indicator svg polyline' => array(
// 							'property' => 'stroke'
// 						),
// 						'.tatsu-{UUID}.tatsu-mobile-menu ul.tatsu-sub-menu > li:hover > a' => array(
// 							'property' => 'color',
// 						),
// 						'.tatsu-{UUID}.tatsu-mobile-menu ul.tatsu-sub-menu > li:hover > .sub-menu-indicator svg polyline' => array(
// 							'property' => 'stroke'
// 						),
// 						'.tatsu-{UUID}.tatsu-mobile-menu li.current-menu-item > a' => array(
// 							'property' => 'color',
// 						)
// 					)
// 				),	
// 				array (
// 					'att_name' => 'transparent_menu_hover_color',
// 					'type' => 'color',
// 					'label' => esc_html__( 'Menu Hover Color on Light Scheme', 'tatsu' ),
// 					'default' => 'rgba(34,147,215,1)',
// 					'tooltip' => '',
// 					'css' => true,
// 					'selectors' => array(
// 						'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li:hover > a' => array(
// 							'property' => 'color',
// 						),
// 						'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li:hover > .sub-menu-indicator svg polyline' => array(
// 							'property' => 'stroke'
// 						),
// 						'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-item > a' => array(
// 							'property' => 'color',
// 						),
// 						'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-item > .sub-menu-indicator svg polyline' => array(
// 							'property' => 'stroke'
// 						),
// 						'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-parent > a' => array(
// 							'property' => 'color',
// 						),
// 						'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-parent > .sub-menu-indicator svg polyline' => array(
// 							'property' => 'stroke'
// 						),
// 					)
// 				),	
// 				array (
// 					'att_name' => 'transparent_menu_hover_color_dark',
// 					'type' => 'color',
// 					'label' => esc_html__( 'Menu Hover Color on Dark Scheme', 'tatsu' ),
// 					'default' => 'rgba(255,255,255,0.5)',//get_colorhub_palette_color(0),
// 					'tooltip' => '',
// 					'css' => true,
// 					'selectors' => array(
// 							'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li:hover > a' => array(
// 								'property' => 'color',
// 							),
// 							'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li:hover > .sub-menu-indicator svg polyline' => array(
// 								'property' => 'stroke'
// 							),
// 							'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-item > a' => array(
// 								'property' => 'color',
// 							),
// 							'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-item > .sub-menu-indicator svg polyline' => array(
// 								'property' => 'stroke'
// 							),
// 							'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-parent > a' => array(
// 								'property' => 'color',
// 							),
// 							'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-parent > .sub-menu-indicator svg polyline' => array(
// 								'property' => 'stroke'
// 							),
// 						)
// 					),	
// 			array(
// 				'att_name' => 'menu_link',
// 				'type' => 'typography',
// 				'label' => esc_html__( 'Menu', 'tatsu' ),
// 				'responsive' => true,
// 				'default' => '',
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-menu > ul > li > a' => array(
// 						'property' => 'typography',
// 					),
// 					'.tatsu-{UUID}.tatsu-mobile-menu > ul > li > a' => array(
// 						'property' => 'typography',
// 					)
// 				),
// 			),	
// 			array (
// 				'att_name' => 'sub_menu_bg_color',
// 				'type' => 'color',
// 				'options' => array(
// 					'gradient' => true
// 				),
// 				'label' => esc_html__( 'Panel Background', 'tatsu' ),
// 				'default' => '#ffffff',
// 				'tooltip' => '',
// 				'css' => true,
// 				'hide_in_sidebar_col' => true,
// 				'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu' => array(
// 							'property' => 'background-color',
// 						),
// 						'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu .tatsu-header-pointer' => array(
// 							'property' => 'border-bottom-color',
// 						)
// 					)
// 				),
// 			array (
// 				'att_name' => 'sub_menu_text_color',
// 				'type' => 'color',
// 				'options' => array(
// 					'gradient' => true
// 				),
// 				'label' => esc_html__( 'Link Color', 'tatsu' ),
// 				'default' => '#1c1c1c',
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu li a' => array(
// 							'property' => 'color',
// 						),
// 						'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu li svg polyline' => array(
// 							'property' => 'stroke',
// 						)
// 					)
// 				),	
// 				array (
// 					'att_name' => 'sub_menu_hover_color',
// 					'type' => 'color',
// 					'options' => array(
// 						'gradient' => true
// 					),
// 					'label' => esc_html__( 'Link Hover Color', 'tatsu' ),
// 					'default' => 'rgba(34,147,215,1)',
// 					'tooltip' => '',
// 					'css' => true,
// 					'selectors' => array(
// 							'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu > li:hover > a' => array(
// 								'property' => 'color',
// 							),
// 							'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu > li:hover svg polyline' => array(
// 								'property' => 'stroke',
// 							),
// 							'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu > li.current-menu-item > a' => array(
// 								'property' => 'color',
// 							),
// 							'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu > li.current-menu-item svg polyline' => array(
// 								'property' => 'stroke',
// 							),
// 							'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu > li.current-menu-parent > a' => array(
// 								'property' => 'color',
// 							),
// 							'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu > li.current-menu-parent svg polyline' => array(
// 								'property' => 'stroke',
// 							)
// 						)
// 					),
// 				array (
// 					'att_name' => 'sub_menu_hover_bg_color',
// 					'type' => 'color',
// 					'options' => array(
// 						'gradient' => true
// 					),
// 					'label' => esc_html__( 'Link Hover BG Color', 'tatsu' ),
// 					'default' => '',
// 					'tooltip' => '',
// 					'css' => true,
// 					'selectors' => array(
// 							'.tatsu-{UUID}.tatsu-menu ul.tatsu-sub-menu li > a:hover' => array(
// 								'property' => 'background',
// 							),
// 							'.tatsu-{UUID}.tatsu-menu ul.tatsu-sub-menu > li.current-menu-item > a' => array(
// 								'property' => 'background'
// 							)
// 						)
// 					),
// 				array (
// 					'att_name' => 'submenu_width',
// 					'type' => 'slider',
// 					'label' => esc_html__( 'Width', 'tatsu' ),
// 					'options' => array(
// 						'min' => '100',
// 						'max' => '600',
// 						'step' => '10',
// 						'unit' => 'px',
// 					),		        		
// 					'default' => '200',
// 					'tooltip' => '',
// 					'hide_in_sidebar_col' => true,
// 					'responsive' => true,
// 					'css' => true,
// 					'hide_in_sidebar_col' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-menu li:not(.mega-menu) > .tatsu-sub-menu' => array(
// 							'property' => 'width',
// 							'append' => 'px',
// 							'when' => array('submenu_width', '!=', '200')
// 						),
// 					),
// 				),	
// 				array (
// 					'att_name' => 'submenu_padding',
// 					'type' => 'slider',
// 					'label' => esc_html__( 'Sub Menu Padding', 'tatsu' ),
// 					'options' => array(
// 						'min' => '0',
// 						'max' => '100',
// 						'step' => '1',
// 						'unit' => 'px',
// 					),	
// 					'default' => '10',
// 					'tooltip' => '',
// 					'css' => true,
// 					'hide_in_sidebar_col' => true,
// 					'responsive' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-menu > ul > li ul.tatsu-sub-menu' => array(
// 							'property' => 'padding',
// 							'when' => array('submenu_padding', '!=', '10'),
// 							'append' => 'px'
// 						),
// 					),
// 				),	
// 				array (
// 					'att_name' => 'sub_menu_shadow',
// 					'type' => 'input_box_shadow',
// 					'label' => esc_html__( 'Box Shadow', 'tatsu' ),
// 					'default' => '0px 0px 24px 2px rgba(45,62,80,0.12)',
// 					'tooltip' => '',
// 					'css' => true,
// 					'hide_in_sidebar_col' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-menu > ul > li > ul.tatsu-sub-menu' => array(
// 							'property' => 'box-shadow',
// 							'when' => array('sub_menu_shadow', '!=', '0px 0px 24px 2px rgba(45,62,80,0.12)'),
// 						),
// 					),
// 				),	            	             
// 	            array (
// 					'att_name' => 'sub_menu_border',
// 					'type' => 'color',
// 					'label' => esc_html__( 'Sub Menu Border', 'tatsu' ),
// 					'default' => '',
// 					'tooltip' => '',
// 					'css' => true,
// 					'hide_in_sidebar_col' => true,
// 					'selectors' => array(
// 						  '.tatsu-{UUID}.tatsu-menu > ul > li > ul.tatsu-sub-menu' => array(
// 							  'property' => 'border',
// 							  'when' => array('sub_menu_border', 'notempty'),
// 							  'prepend' => '1px solid '
// 						  ),
// 						  '.tatsu-{UUID}.tatsu-menu > ul > li > ul.tatsu-sub-menu > .tatsu-header-pointer' => array(
// 							'property' => 'border-color',
// 							'when' => array('sub_menu_border', 'notempty')
// 						  ),
// 					  )
// 				  ),
					
// 				array(
// 					'att_name' => 'sub_menu_link',
// 					'type' => 'typography',
// 					'label' => esc_html__( 'Sub Menu', 'tatsu' ),
// 					'responsive' => true,
// 					'default' => '',
// 					'tooltip' => '',
// 					'css' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu li a' => array(
// 							'property' => 'typography',
// 						),
// 						'.tatsu-{UUID}.tatsu-mobile-menu .tatsu-sub-menu li a' => array(
// 							'property' => 'typography',
// 						)
// 					),
// 				), 
// 				array (
// 					'att_name'		=> 'mega_menu',
// 					'type'			=> 'switch',
// 					'label'			=> esc_html__( 'Mega Menu', 'tatsu' ),
// 					'default'		=> '0',
// 					'tooltip'		=> '',
// 				),
// 				array (
// 					'att_name' => 'hide_in',
// 					'type' => 'screen_visibility',
// 					'label' => esc_html__( 'Hide in', 'tatsu' ),
// 					'default' => '',
// 					'tooltip' => '',
// 				),
// 		),
// 	);
// 	tatsu_register_header_module( 'tatsu_navigation_menu', $controls, 'tatsu_navigation_menu' );
// }

// add_action( 'tatsu_register_header_modules', 'tatsu_register_sidebar_navigation_menu' );
// function tatsu_register_sidebar_navigation_menu() {

// 	$controls = array (
//         'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#vertical_nav_menu',
//         'title' => esc_html__( 'Vertical Menu', 'tatsu' ),
//         'is_js_dependant' => true,
//         'type' => 'single',
// 		'is_built_in' => false,
// 		'inline' => true,
// 		'builder_layout' => 'column',
// 		'group_atts' => array(
// 			'menu_name',
// 			// 'disable_in_mobile',
// 			array (
// 				'type' => 'accordion' ,
// 				'active' => 'none',
// 				'group' => array (
// 					array (
// 						'type' => 'panel',
// 						'title' => esc_html__( 'Spacing', 'tatsu' ),
// 						'group' => array (
// 							'links_margin',
// 							'margin'
// 						)
// 					),		
// 					array (
// 						'type' => 'panel',
// 						'title' => esc_html__( 'Colors', 'tatsu' ),
// 						'group' => array (
// 							'menu_color',
// 							'menu_hover_color',
// 						)
// 					),	
// 					array (
// 						'type' => 'panel',
// 						'title' => esc_html__( 'Sub Menu', 'tatsu' ),
// 						'group' => array (
// 							'sub_menu_text_color',
// 							'sub_menu_hover_color',
// 							'sub_menu_hover_bg_color'
// 						)
// 					),
// 					array (
// 						'type' => 'panel',
// 						'title' => esc_html__( 'Typography', 'tatsu' ),
// 						'group' => array (
// 							'menu_link',
// 							'sub_menu_link'
// 						)
// 					),
// 				) 
// 			),
// 			'hide_in'					
// 		),
// 		'atts' => array (

// 			array (
// 				'att_name' => 'menu_name',
// 				'type' => 'select',
// 				'label' => esc_html__( 'Menu Name', 'oshine-modules' ),
// 				'options' => tatsu_header_get_menu_list()[0],
// 				'tooltip' => '',
// 				'default' =>  tatsu_header_get_menu_list()[1]
// 			), 
// 			array (
// 			'att_name' => 'links_margin',
// 			'type' => 'input_group',
// 			'label' => esc_html__( 'Space between Links', 'tatsu' ),
// 			'default' => '0px 0px 5px 0px',
// 			'tooltip' => '',
// 			'css' => true,
// 			'responsive' => true,
// 			'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-sidebar-menu > ul > li' => array(
// 						'property' => 'margin',
// 					),
// 				),
// 			), 
// 			array (
// 				'att_name' => 'margin',
// 				'type' => 'input_group',
// 				'label' => esc_html__( 'Margin', 'tatsu' ),
// 				'default' => '0px 30px 0px 0px',
// 				'tooltip' => '',
// 				'css' => true,
// 				'responsive' => true,
// 				'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-sidebar-menu' => array(
// 							'property' => 'margin',
// 						),
// 					),
// 				), 
// 			//Main Menu Options
// 			array (
// 				'att_name' => 'menu_color',
// 				'type' => 'color',
// 				'label' => esc_html__( 'Menu Color', 'tatsu' ),
// 				'default' => '#000000',
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-sidebar-menu a' => array(
// 							'property' => 'color',
// 						),
// 						'.tatsu-{UUID}.tatsu-sidebar-menu li svg polyline' => array(
// 							'property' => 'stroke',
// 						)
// 					)
// 				),	
// 			array(
// 				'att_name' => 'menu_link',
// 				'type' => 'typography',
// 				'label' => esc_html__( 'Menu', 'tatsu' ),
// 				'responsive' => true,
// 				'default' => '',
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-sidebar-menu > ul > li > a' => array(
// 						'property' => 'typography',
// 					),
// 					'.tatsu-{UUID}.tatsu-sidebar-menu > ul > li > span' => array(
// 						'property' => 'typography',
// 					)
// 				),
// 			),		
// 			array (
// 				'att_name' => 'menu_hover_color',
// 				'type' => 'color',
// 				'label' => esc_html__( 'Menu Hover Color', 'tatsu' ),
// 				'default' => 'rgba(34,147,215,1)',
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-sidebar-menu > ul > li:hover > a' => array(
// 							'property' => 'color',
// 						),
// 						'.tatsu-{UUID}.tatsu-sidebar-menu > ul > li:hover > .sub-menu-indicator svg polyline' => array(
// 							'property' => 'stroke'
// 						),
// 						'.tatsu-{UUID}.tatsu-sidebar-menu li.current-menu-item > a' => array(
// 							'property' => 'color',
// 						),
// 						'.tatsu-{UUID}.tatsu-sidebar-menu > ul > li.current-menu-item > .sub-menu-indicator svg polyline' => array(
// 							'property' => 'stroke'
// 						),
// 						'.tatsu-{UUID}.tatsu-sidebar-menu li.current-menu-parent > a' => array(
// 							'property' => 'color',
// 						),
// 						'.tatsu-{UUID}.tatsu-sidebar-menu > ul > li.current-menu-parent > .sub-menu-indicator svg polyline' => array(
// 							'property' => 'stroke'
// 						),

// 					)
// 				),	
// 			array (
// 				'att_name' => 'sub_menu_text_color',
// 				'type' => 'color',
// 				'options' => array(
// 					'gradient' => true
// 				),
// 				'label' => esc_html__( 'Link Color', 'tatsu' ),
// 				'default' => '#1c1c1c',
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu li a' => array(
// 							'property' => 'color',
// 						),
// 						'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu li svg polyline' => array(
// 							'property' => 'stroke',
// 						)
// 					)
// 				),	
// 				array (
// 					'att_name' => 'sub_menu_hover_color',
// 					'type' => 'color',
// 					'options' => array(
// 						'gradient' => true
// 					),
// 					'label' => esc_html__( 'Link Hover Color', 'tatsu' ),
// 					'default' => 'rgba(34,147,215,1)',
// 					'tooltip' => '',
// 					'css' => true,
// 					'selectors' => array(
// 							'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu > li:hover > a' => array(
// 								'property' => 'color',
// 							),
// 							'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu > li:hover svg polyline' => array(
// 								'property' => 'stroke',
// 							),
// 							'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu > li.current-menu-item > a' => array(
// 								'property' => 'color',
// 							),
// 							'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu > li.current-menu-item svg polyline' => array(
// 								'property' => 'stroke',
// 							),
// 							'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu > li.current-menu-parent > a' => array(
// 								'property' => 'color',
// 							),
// 							'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu > li.current-menu-parent svg polyline' => array(
// 								'property' => 'stroke',
// 							)
// 						)
// 					),
// 				array (
// 					'att_name' => 'sub_menu_hover_bg_color',
// 					'type' => 'color',
// 					'options' => array(
// 						'gradient' => true
// 					),
// 					'label' => esc_html__( 'Link Hover BG Color', 'tatsu' ),
// 					'default' => '',
// 					'tooltip' => '',
// 					'css' => true,
// 					'selectors' => array(
// 							'.tatsu-{UUID}.tatsu-sidebar-menu ul.tatsu-sub-menu > li:hover > a' => array(
// 								'property' => 'background',
// 							),
// 						)
// 					),
// 				array(
// 					'att_name' => 'sub_menu_link',
// 					'type' => 'typography',
// 					'label' => esc_html__( 'Sub Menu', 'tatsu' ),
// 					'responsive' => true,
// 					'default' => '',
// 					'tooltip' => '',
// 					'css' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu li a' => array(
// 							'property' => 'typography',
// 						)
// 					),
// 				), 					
// 				array (
// 					'att_name' => 'hide_in',
// 					'type' => 'screen_visibility',
// 					'label' => esc_html__( 'Hide in', 'tatsu' ),
// 					'default' => '',
// 					'tooltip' => '',
// 				),
// 		),
// 	);
// 	tatsu_register_header_module( 'tatsu_sidebar_navigation_menu', $controls, 'tatsu_sidebar_navigation_menu' );
// }

// add_action( 'tatsu_register_header_modules', 'tatsu_register_header_divider' );
// function tatsu_register_header_divider() {
// 	$controls = array (
// 		'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#header_separator',
// 		'title' => esc_html__( 'Separator', 'tatsu' ),
// 		'is_js_dependant' => false,
// 		'child_module' => '',
// 		'type' => 'single',
// 		'inline' => true,
// 		'is_built_in' => true,
// 		'atts' => array (
// 			array (
// 				'att_name' => 'width',
// 				'type' => 'slider',
// 				'label' => esc_html__( 'Divider Width', 'tatsu' ),
// 				'options' => array(
// 					'min' => '0',
// 					'max' => '100',
// 					'step' => '1',
// 					'unit' => 'px',
// 				),	        		
// 				'default' => '1',
// 				'tooltip' => '',
// 				'responsive' => true,
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-header-divider-wrap' => array(
// 						'property' => 'width',
// 						'append' => 'px'
// 					),
// 				),
// 			),
// 			array (
// 				'att_name' => 'height',
// 				'type' => 'slider',
// 				'label' => esc_html__( 'Divider Height', 'tatsu' ),
// 				'options' => array(
// 					'min' => '0',
// 					'max' => '100',
// 					'step' => '1',
// 					'unit' => 'px',
// 				),	        		
// 				'default' => '20',
// 				'tooltip' => '',
// 				'responsive' => true,
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-header-divider-wrap' => array(
// 						'property' => 'height',
// 						'append' => 'px',
// 					),
// 				),
// 			),
// 			array (
// 				'att_name' => 'color',
// 				'type' => 'color',
// 				'options' => array (
// 						'gradient' => true
// 				),
// 				'label' => esc_html__( 'Divider Color', 'tatsu' ),
// 				'default' => '#efefef', 
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-header-divider-wrap' => array(
// 						'property' => 'background',
// 					),
// 				),
// 			),
// 			array (
// 				'att_name' => 'margin',
// 				'type' => 'input_group',
// 				'label' => esc_html__( 'Margin', 'tatsu' ),
// 				'default' => '0px 15px 0px 0px',
// 				'tooltip' => '',
// 				'responsive' => true,
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-header-divider-wrap' => array(
// 						'property' => 'margin',
// 					),
// 				),
// 			),
// 			array (
// 				'att_name' => 'hide_in',
// 				'type' => 'screen_visibility',
// 				'label' => esc_html__( 'Hide in', 'tatsu' ),
// 				'default' => '',
// 				'tooltip' => '',
// 			),
// 		),
// 		'presets' => array(
// 			'default' => array(
// 				'title' => '',
// 				'image' => '',
// 				'preset' => array(
// 					'width' => '1',
// 					'color' => '#efefef'
// 				),
// 			)
// 		),	        
// 	);
// 	tatsu_register_header_module( 'tatsu_header_divider', $controls, 'tatsu_header_divider' );
// }

// add_action( 'tatsu_register_header_modules', 'tatsu_register_header_links' );
// function tatsu_register_header_links() {
// 	$controls = array (
// 		'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#header_links',
// 		'title' => esc_html__( 'Links', 'tatsu' ),
// 		'is_js_dependant' => false,
// 		'child_module' => '',
// 		'type' => 'single',
// 		'inline' => true,
// 		'is_built_in' => true,
// 		'atts' => array (
// 			array(
// 				'att_name' => 'link_typography',
// 				'type' => 'typography',
// 				'label' => esc_html__( 'Typography', 'tatsu' ),
// 				'responsive' => true,
// 				'default' => '',
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-link' => array(
// 						'property' => 'typography',
// 					)
// 				),
// 			),
// 			array (
// 				'att_name' => 'link_text',
// 				'type' => 'text',
// 				'label' => esc_html__( 'Link Text', 'tatsu' ),
// 				'default' => 'Click Here',
// 				'tooltip' => ''
// 			),
// 			array (
// 				'att_name' => 'url',
// 				'type' => 'text',
// 				'label' => esc_html__( 'URL', 'tatsu' ),
// 				'default' => '#',
// 				'tooltip' => ''
// 			),
// 			array (
// 				'att_name' => 'new_tab',
// 				'type' => 'switch',
// 				'label' => esc_html__( 'Open in a new tab', 'tatsu' ),
// 				'default' => true,
// 				'tooltip' => '',
// 				'visible' => array( 'url', '!=', '' ),
// 			),
// 			array (
// 				'att_name' => 'color',
// 				'type' => 'color',
// 				'label' => esc_html__( 'Link Color', 'tatsu' ),
// 				'default' => '#212121', 
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-link a' => array(
// 						'property' => 'color',
// 					),
// 				),
// 			),
// 			array (
// 				'att_name' => 'hover_color',
// 				'type' => 'color',
// 				'label' => esc_html__( 'Hover Color', 'tatsu' ),
// 				'default' => '#212121', 
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-link a:hover' => array(
// 						'property' => 'color',
// 					),
// 				),
// 			),
// 			array (
// 				'att_name' => 'margin',
// 				'type' => 'input_group',
// 				'label' => esc_html__( 'Margin', 'tatsu' ),
// 				'default' => '0px 30px 0px 0px',
// 				'tooltip' => '',
// 				'responsive' => true,
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-link' => array(
// 						'property' => 'margin',
// 					),
// 				),
// 			),
// 			array (
// 				'att_name' => 'hide_in',
// 				'type' => 'screen_visibility',
// 				'label' => esc_html__( 'Hide in', 'tatsu' ),
// 				'default' => '',
// 				'tooltip' => '',
// 			),
// 		),	        
// 	);
// 	tatsu_register_header_module( 'tatsu_header_links', $controls, 'tatsu_header_links' );
// }

// add_action( 'tatsu_register_header_modules', 'tatsu_register_search' );
// function tatsu_register_search() {
// 	$controls = array (
// 		'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#search_lens',
// 		'title' => esc_html__( 'Search', 'tatsu' ),
// 		'is_js_dependant' => true,
// 		'child_module' => '',
// 		'type' => 'single',
// 		'inline' => true,
// 		'is_built_in' => true,
// 		'atts' => array (
// 			array (
// 				'att_name' => 'icon_color',
// 				'type' => 'color',
// 				'label' => esc_html__( 'Icon Color', 'tatsu' ),
// 				'default' => '#212121', 
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-search svg g' => array(
// 						'property' => 'stroke',
// 					),
// 				),
// 			),
// 			array (
// 				'att_name' => 'margin',
// 				'type' => 'input_group',
// 				'label' => esc_html__( 'Margin', 'tatsu' ),
// 				'default' => '0px 30px 0px 0px',
// 				'tooltip' => '',
// 				'responsive' => true,
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-search' => array(
// 						'property' => 'margin',
// 					),
// 				),
// 			),
// 			array (
// 				'att_name' => 'hide_in',
// 				'type' => 'screen_visibility',
// 				'label' => esc_html__( 'Hide in', 'tatsu' ),
// 				'default' => '',
// 				'tooltip' => '',
// 			),
// 		),	        
// 	);
// 	tatsu_register_header_module( 'tatsu_search', $controls, 'tatsu_search' );
// }

// if ( in_array( 'sitepress-multilingual-cms/sitepress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
// 	add_action( 'tatsu_register_header_modules', 'tatsu_register_wpml_language_switcher' );
// }

// function tatsu_register_wpml_language_switcher() {
// 	$controls = array (
// 		'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#lang_selector',
// 		'title' => esc_html__( 'WPML Language Switcher', 'tatsu' ),
// 		'is_js_dependant' => true,
// 		'child_module' => '',
// 		'type' => 'single',
// 		'inline' => true,
// 		'is_built_in' => false,
// 		'atts' => array (
// 			array (
// 				'att_name' => 'current_lang_color',
// 				'type' => 'color',
// 				'label' => esc_html__( 'Current Language Color', 'tatsu' ),
// 				'default' => '#212121', 
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-wpml-lang-switcher' => array(
// 						'property' => 'color',
// 					),
// 					'.tatsu-{UUID}.tatsu-wpml-lang-switcher svg polyline' => array(
// 						'property' => 'stroke',
// 					),
// 				),
// 			),
// 			array (
// 				'att_name' => 'flag_visibility',
// 				'type' => 'switch',
// 				'label' => esc_html__( 'Flag', 'tatsu' ),
// 				'default' => false,
// 				'tooltip' => '',
// 			),
// 			// array (
// 			// 	'att_name' => 'native_language_visibility',
// 			// 	'type' => 'switch',
// 			// 	'label' => esc_html__( 'Native language name', 'tatsu' ),
// 			// 	'default' => true,
// 			// 	'tooltip' => '',
// 			// ),
// 			array (
// 				'att_name' => 'language_name',
// 				'type' => 'switch',
// 				'label' => esc_html__( 'Language name in current language', 'tatsu' ),
// 				'default' => false,
// 				'tooltip' => '',
// 			),
// 			array(
// 				'att_name' => 'lang_typography',
// 				'type' => 'typography',
// 				'label' => esc_html__( 'Typography', 'tatsu' ),
// 				'responsive' => true,
// 				'default' => '',
// 				'tooltip' => '',
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-wpml-lang-switcher .current-language' => array(
// 						'property' => 'typography',
// 					),
// 					'.tatsu-{UUID}.tatsu-wpml-lang-switcher .language-list li' => array(
// 						'property' => 'typography',
// 					)
// 				),
// 			),
// 			array (
// 				'att_name' => 'margin',
// 				'type' => 'input_group',
// 				'label' => esc_html__( 'Margin', 'tatsu' ),
// 				'default' => '0px 30px 0px 0px',
// 				'tooltip' => '',
// 				'responsive' => true,
// 				'css' => true,
// 				'selectors' => array(
// 					'.tatsu-{UUID}.tatsu-wpml-lang-switcher' => array(
// 						'property' => 'margin',
// 					),
// 				),
// 			),
// 			array (
// 				'att_name' => 'hide_in',
// 				'type' => 'screen_visibility',
// 				'label' => esc_html__( 'Hide in', 'tatsu' ),
// 				'default' => '',
// 				'tooltip' => '',
// 			),
// 		),	        
// 	);
// 	tatsu_register_header_module( 'tatsu_wpml_language_switcher', $controls, 'tatsu_wpml_language_switcher' );
// }

?>