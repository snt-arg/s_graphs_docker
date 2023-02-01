<?php 

function tatsu_navigation_menu( $atts, $content, $tag ) {
    
    $atts = shortcode_atts( array(
        'menu_name' => '',
        'disable_in_mobile' => '',
        'links_margin' => '',
        'margin' => '',
        'menu_level' => 3,
        'menu_color' => '',
        'menu_hover_color' => '',
        'transparent_menu_hover_color' => '',
        'transparent_menu_hover_color_dark' => '',
        'menu_link' => '',
        'sub_menu_bg_color' => '',
        'sub_menu_text_color' => '',
        'sub_menu_hover_color' => '',
        'sub_menu_hover_bg_color' => '',
        'submenu_width' => '',
        'submenu_padding' => '',
        'sub_menu_shadow' => '',
        'sub_menu_border' => '',
        'mega_menu'     => '',
        'sub_menu_link' => '',
        'hide_in' => '',
        'key' => be_uniqid_base36(true)
    ), $atts, $tag );
    
    extract( $atts );
    
    $unique_class = 'tatsu-'.$atts['key'];
    $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key, 'Header' );
    
    $output = '';
    $css_id = be_get_id_from_atts( $atts );
    $visibility_classes = be_get_visibility_classes_from_atts( $atts );

    //check if menu_name actually exists in db, if not add fallback menu
    $menu_obj = wp_get_nav_menu_object( $menu_name );
    if( false === $menu_obj ) {
        $menu_name = '';
    }



    if($menu_name != ''){
        $defaults = array (
            'menu'=> $menu_name,
            'depth'=> apply_filters('tatsu_horizontal_menu_depth',$menu_level),
            'container_class'=>'tatsu-menu '.$unique_class,
            'menu_id' => 'normal-menu-'.$key, 
            'menu_class' => 'clearfix ',
            'echo' => false,
            'walker' => new Tatsu_Walker_Nav_Menu()
        );
        
        $mobile_defaults = array (
            'menu'=> $menu_name,
            'depth'=> apply_filters('tatsu_horizontal_menu_depth',$menu_level),
            'container_class'=>'tatsu-mobile-menu '.$unique_class,
            'menu_id' => 'menu-'.$key,
            'menu_class' => 'clearfix ',
            'echo' => false,
            'walker' => new Tatsu_Walker_Mobile_Nav_Menu()
        );
    
        $mega_menu_class = '';
        if( !empty( $mega_menu ) ) {
            $mega_menu_class = ' tatsu-header-navigation-mega-menu';
        }
        
        $output = '<nav '.$css_id.' class="tatsu-header-module tatsu-header-navigation clearfix '.$visibility_classes. $mega_menu_class .'">'.wp_nav_menu( $defaults ).$custom_style_tag.'</nav>';
        $output .= '<div class="tatsu-header-module tatsu-mobile-navigation '.$visibility_classes.'">'.wp_nav_menu( $mobile_defaults ).'<div class="tatsu-mobile-menu-icon"><div class="expand-click-area"></div><div class="line-wrapper"><span class="line-1"></span><span class="line-2"></span><span class="line-3"></span></div></div></div>' ;
    }else{
        if( current_user_can( 'edit_theme_options' ) ) {
            $output = '<span style="margin-right: 30px;"><a href="'.esc_url(admin_url('nav-menus.php')).'">'.esc_html__('CREATE OR SET A MENU', 'tatsu').'</a></span>';
        }
    }
    return $output;

}
add_shortcode( 'tatsu_navigation_menu', 'tatsu_navigation_menu' );

if ( !class_exists('Tatsu_Walker_Nav_Menu') ) {
    class Tatsu_Walker_Nav_Menu extends Walker_Nav_Menu {
		function start_lvl(&$output, $depth=0, $args=array()) {
            $indent = str_repeat("\t", $depth);
            $sub_menu_indicator = file_get_contents( TATSU_PLUGIN_DIR . 'includes/header-builder/img/tatsu_header_arrow.svg' );

            $output .="\n$indent<span class=\"sub-menu-indicator\">$sub_menu_indicator</span><ul class=\"tatsu-sub-menu clearfix\"><span class=\"tatsu-header-pointer\"></span>\n";
		}
	}
}

if ( !class_exists('Tatsu_Walker_Mobile_Nav_Menu') ) {
    class Tatsu_Walker_Mobile_Nav_Menu extends Walker_Nav_Menu {
		function start_lvl(&$output, $depth=0, $args=array()) {
            $indent = str_repeat("\t", $depth);
            $sub_menu_indicator = file_get_contents( TATSU_PLUGIN_DIR . 'includes/header-builder/img/tatsu_header_arrow.svg' );

            $output .= "\n$indent<span class=\"sub-menu-indicator\">$sub_menu_indicator</span><ul class=\"tatsu-sub-menu clearfix\">\n";
		}
	}
}

if( !function_exists( 'tatsu_navigation_menu_prevent_autop' ) ) {
    function tatsu_navigation_menu_prevent_autop( $content_filter, $tag ) {
        if( 'tatsu_navigation_menu' === $tag ) {
            $content_filter = false;
        }
        return $content_filter;
    }
    add_filter( 'tatsu_shortcode_output_content_filter', 'tatsu_navigation_menu_prevent_autop', 10, 2 );
}

add_action( 'tatsu_register_header_modules', 'tatsu_register_navigation_menu' );
function tatsu_register_navigation_menu() {

	$controls = array (
        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#horizontal_nav_menu',
        'title' => esc_html__( 'Horizontal Menu', 'tatsu' ),
        'is_js_dependant' => true,
        'type' => 'single',
		'is_built_in' => false,
		'inline' => true,
		'builder_layout' => 'column',
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'	=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
                            'menu_name',
                            'mega_menu',
                            'menu_level'
						)
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
                            array(
								'type' => 'accordion',
								'active' => array(0),
								'group' => array(
                                    array (
                                        'type' => 'panel',
                                        'title' => esc_html__( 'Main Menu', 'tatsu' ),
                                        'group' => array (
                                            'menu_color',
                                            'menu_hover_color',
                                            'transparent_menu_hover_color',
                                            'transparent_menu_hover_color_dark',
                                            'links_margin',
                                        )
                                    ),	
                                    array (
                                        'type' => 'panel',
                                        'title' => esc_html__( 'Sub Menu', 'tatsu' ),
                                        'group' => array (
                                            'submenu_width',
                                            'submenu_padding',
											array(
												'type'  	=> 'tabs',
												'style'		=> 'style1',
												'group'		=> array(
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Links', 'tatsu'),
														'group'		=> array(
                                                            'sub_menu_text_color',
                                                            'sub_menu_hover_color',
                                                            'sub_menu_hover_bg_color',
														),
													),
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Panel', 'tatsu'),
														'group'		=> array(
                                                            'sub_menu_bg_color',
                                                            'sub_menu_border',
                                                            'sub_menu_shadow',
														),
													),
												),
											)
                                        )
                                    ),
                                    array (
                                        'type' => 'panel',
                                        'title' => esc_html__( 'Typography', 'tatsu' ),
                                        'group' => array (
                                            'menu_link',
                                            'sub_menu_link'
                                        )
                                    ),
								)
							)
						)
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => 'none',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Spacing', 'tatsu'),
										'group' => array(
											'margin',
										)
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
				'att_name' => 'menu_name',
				'type' => 'select',
				'label' => esc_html__( 'Menu Name', 'tatsu' ),
				'options' => tatsu_header_get_menu_list()[0],
				'tooltip' => '',
				'default' => tatsu_header_get_menu_list()[1]
			),
			array (
				'att_name' => 'menu_level',
				'type' => 'slider',
				'label' => esc_html__( 'Menu Level', 'tatsu' ),
				'tooltip' => 'Sub menu level 1-10',
				'options' => array(
					'min' => '1',
					'max' => '10',
					'step' => '1',
				),		        		
				'default' => '3',
			),
			array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__( 'Margin', 'tatsu' ),
				'default' => '0px 30px 0px 0px',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					  '.tatsu-{UUID}.tatsu-menu' => array(
						  'property' => 'margin',
					  ),
					  '.tatsu-{UUID}.tatsu-mobile-menu + .tatsu-mobile-menu-icon' => array(
						'property' => 'margin',
					  ),
				  ),
			  ), 
			  array (
				'att_name' => 'links_margin',
				'type' => 'input_group',
				'label' => esc_html__( 'Spacing between Links', 'tatsu' ),
				'default' => '0px 10px 0px 0px',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					  '.tatsu-{UUID}.tatsu-menu > ul > li' => array(
						  'property' => 'margin',
					  ),
				  ),
			  ), 
			//Main Menu Options
			array (
				'att_name' => 'menu_color',
				'type' => 'color',
				'label' => esc_html__( 'Menu Color', 'tatsu' ),
				'default' => '#000000',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
						'.tatsu-{UUID}.tatsu-menu a' => array(
							'property' => 'color',
						),
						'.tatsu-{UUID}.tatsu-menu li svg polyline' => array(
							'property' => 'stroke',
						),
						'.tatsu-{UUID}.tatsu-mobile-menu a' => array(
							'property' => 'color',
						),
					)
				),	
			array (
				'att_name' => 'menu_hover_color',
				'type' => 'color',
				'label' => esc_html__( 'Menu Hover Color', 'tatsu' ),
				'default' => 'rgba(34,147,215,1)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
						'.tatsu-{UUID}.tatsu-menu > ul > li:hover > a' => array(
							'property' => 'color',
						),
						'.tatsu-{UUID}.tatsu-menu > ul > li:hover > .sub-menu-indicator svg polyline' => array(
							'property' => 'stroke'
						),
						'.tatsu-{UUID}.tatsu-menu > ul > li.current-menu-item > a' => array(
							'property' => 'color',
						),
						'.tatsu-{UUID}.tatsu-menu > ul > li.current-menu-item > .sub-menu-indicator svg polyline' => array(
							'property' => 'stroke'
						),
						'.tatsu-{UUID}.tatsu-menu li.current-menu-parent > a' => array(
							'property' => 'color',
						),
						'.tatsu-{UUID}.tatsu-menu > ul > li.current-menu-parent > .sub-menu-indicator svg polyline' => array(
							'property' => 'stroke'
						),
						'.tatsu-{UUID}.tatsu-mobile-menu > ul > li:hover > a' => array(
							'property' => 'color',
						),
						'.tatsu-{UUID}.tatsu-mobile-menu > ul > li:hover > .sub-menu-indicator svg polyline' => array(
							'property' => 'stroke'
						),
						'.tatsu-{UUID}.tatsu-mobile-menu ul.tatsu-sub-menu > li:hover > a' => array(
							'property' => 'color',
						),
						'.tatsu-{UUID}.tatsu-mobile-menu ul.tatsu-sub-menu > li:hover > .sub-menu-indicator svg polyline' => array(
							'property' => 'stroke'
						),
						'.tatsu-{UUID}.tatsu-mobile-menu li.current-menu-item > a' => array(
							'property' => 'color',
						)
					)
				),	
				array (
					'att_name' => 'transparent_menu_hover_color',
					'type' => 'color',
					'label' => esc_html__( 'Light Scheme Menu hover color', 'tatsu' ),
					'default' => 'rgba(34,147,215,1)',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li:hover > a' => array(
							'property' => 'color',
						),
						'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li:hover > .sub-menu-indicator svg polyline' => array(
							'property' => 'stroke'
						),
						'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-item > a' => array(
							'property' => 'color',
						),
						'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-item > .sub-menu-indicator svg polyline' => array(
							'property' => 'stroke'
						),
						'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-parent > a' => array(
							'property' => 'color',
						),
						'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-parent > .sub-menu-indicator svg polyline' => array(
							'property' => 'stroke'
						),
					)
				),	
				array (
					'att_name' => 'transparent_menu_hover_color_dark',
					'type' => 'color',
					'label' => esc_html__( 'Dark Scheme Menu hover color', 'tatsu' ),
					'default' => 'rgba(255,255,255,0.5)',//get_colorhub_palette_color(0),
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
							'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li:hover > a' => array(
								'property' => 'color',
							),
							'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li:hover > .sub-menu-indicator svg polyline' => array(
								'property' => 'stroke'
							),
							'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-item > a' => array(
								'property' => 'color',
							),
							'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-item > .sub-menu-indicator svg polyline' => array(
								'property' => 'stroke'
							),
							'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-parent > a' => array(
								'property' => 'color',
							),
							'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-{UUID}.tatsu-menu > ul > li.current-menu-parent > .sub-menu-indicator svg polyline' => array(
								'property' => 'stroke'
							),
						)
					),	
			array(
				'att_name' => 'menu_link',
				'type' => 'typography',
				'label' => esc_html__( 'Menu', 'tatsu' ),
				'responsive' => true,
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'is_inline' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-menu > ul > li > a' => array(
						'property' => 'typography',
					),
					'.tatsu-{UUID}.tatsu-mobile-menu > ul > li > a' => array(
						'property' => 'typography',
					)
				),
			),	
			array (
				'att_name' => 'sub_menu_bg_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__( 'Panel Background', 'tatsu' ),
				'default' => '#ffffff',
				'tooltip' => '',
				'css' => true,
				'hide_in_sidebar_col' => true,
				'selectors' => array(
						'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu' => array(
							'property' => 'background-color',
						),
						'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu .tatsu-header-pointer' => array(
							'property' => 'border-bottom-color',
						)
					)
				),
			array (
				'att_name' => 'sub_menu_text_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__( 'Link Color', 'tatsu' ),
				'default' => '#1c1c1c',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
						'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu li a' => array(
							'property' => 'color',
						),
						'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu li svg polyline' => array(
							'property' => 'stroke',
						)
					)
				),	
				array (
					'att_name' => 'sub_menu_hover_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true
					),
					'label' => esc_html__( 'Link Hover Color', 'tatsu' ),
					'default' => 'rgba(34,147,215,1)',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
							'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu > li:hover > a' => array(
								'property' => 'color',
							),
							'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu > li:hover svg polyline' => array(
								'property' => 'stroke',
							),
							'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu > li.current-menu-item > a' => array(
								'property' => 'color',
							),
							'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu > li.current-menu-item svg polyline' => array(
								'property' => 'stroke',
							),
							'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu > li.current-menu-parent > a' => array(
								'property' => 'color',
							),
							'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu > li.current-menu-parent svg polyline' => array(
								'property' => 'stroke',
							)
						)
					),
				array (
					'att_name' => 'sub_menu_hover_bg_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true
					),
					'label' => esc_html__( 'Link Hover BG Color', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
							'.tatsu-{UUID}.tatsu-menu ul.tatsu-sub-menu li > a:hover' => array(
								'property' => 'background',
							),
							'.tatsu-{UUID}.tatsu-menu ul.tatsu-sub-menu > li.current-menu-item > a' => array(
								'property' => 'background'
							)
						)
					),
				array (
					'att_name' => 'submenu_width',
					'type' => 'slider',
					'label' => esc_html__( 'Width', 'tatsu' ),
					'options' => array(
						'min' => '100',
						'max' => '600',
						'step' => '10',
						'unit' => 'px',
					),		        		
					'default' => '200',
					'tooltip' => '',
					'hide_in_sidebar_col' => true,
					'responsive' => true,
					'css' => true,
					'hide_in_sidebar_col' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-menu li:not(.mega-menu) > .tatsu-sub-menu' => array(
							'property' => 'width',
							'append' => 'px',
							'when' => array('submenu_width', '!=', '200')
						),
					),
				),	
				array (
					'att_name' => 'submenu_padding',
					'type' => 'slider',
					'label' => esc_html__( 'Sub Menu Padding', 'tatsu' ),
					'options' => array(
						'min' => '0',
						'max' => '100',
						'step' => '1',
						'unit' => 'px',
					),	
					'default' => '10',
					'tooltip' => '',
					'css' => true,
					'hide_in_sidebar_col' => true,
					'responsive' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-menu > ul > li ul.tatsu-sub-menu' => array(
							'property' => 'padding',
							'when' => array('submenu_padding', '!=', '10'),
							'append' => 'px'
						),
					),
				),	
				array (
					'att_name' => 'sub_menu_shadow',
					'type' => 'input_box_shadow',
					'label' => esc_html__( 'Panel Shadow', 'tatsu' ),
					'default' => '0px 0px 24px 2px rgba(45,62,80,0.12)',
					'tooltip' => '',
					'css' => true,
					'hide_in_sidebar_col' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-menu > ul > li > ul.tatsu-sub-menu' => array(
							'property' => 'box-shadow',
							'when' => array('sub_menu_shadow', '!=', '0px 0px 24px 2px rgba(45,62,80,0.12)'),
						),
					),
				),	            	             
	            array (
					'att_name' => 'sub_menu_border',
					'type' => 'color',
					'label' => esc_html__( 'Panel Border', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'hide_in_sidebar_col' => true,
					'selectors' => array(
						  '.tatsu-{UUID}.tatsu-menu > ul > li > ul.tatsu-sub-menu' => array(
							  'property' => 'border',
							  'when' => array('sub_menu_border', 'notempty'),
							  'prepend' => '1px solid '
						  ),
						  '.tatsu-{UUID}.tatsu-menu > ul > li > ul.tatsu-sub-menu > .tatsu-header-pointer' => array(
							'property' => 'border-color',
							'when' => array('sub_menu_border', 'notempty')
						  ),
					  )
				  ),
					
				array(
					'att_name' => 'sub_menu_link',
					'type' => 'typography',
					'label' => esc_html__( 'Sub Menu', 'tatsu' ),
					'responsive' => true,
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'is_inline' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-menu .tatsu-sub-menu li a' => array(
							'property' => 'typography',
						),
						'.tatsu-{UUID}.tatsu-mobile-menu .tatsu-sub-menu li a' => array(
							'property' => 'typography',
						)
					),
				), 
				array (
					'att_name'		=> 'mega_menu',
					'type'			=> 'switch',
					'label'			=> esc_html__( 'Mega Menu', 'tatsu' ),
					'default'		=> '0',
					'tooltip'		=> '',
				),
		),
	);
	tatsu_register_header_module( 'tatsu_navigation_menu', $controls, 'tatsu_navigation_menu' );
}

?>