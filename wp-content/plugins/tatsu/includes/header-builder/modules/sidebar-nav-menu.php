<?php 

function tatsu_sidebar_navigation_menu( $atts, $content, $tag ) {
    
    $atts = shortcode_atts( array(
        'menu_name' => '',
        'margin' => '',
        'menu_color' => '',
        'menu_hover_color' => '',
        'menu_link' => '',
        'sub_menu_text_color' => '',
        'sub_menu_hover_color' => '',
        'sub_menu_hover_bg_color' => '',
        'sub_menu_link' => '',
        'links_margin' => '',
        'hide_in' => '',
        'key' => be_uniqid_base36(true)
    ), $atts, $tag );
    
    extract( $atts );
    $unique_class = 'tatsu-'.$atts['key'];
    $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key, 'Header' );
    $css_id = be_get_id_from_atts( $atts );
    $visibility_classes = be_get_visibility_classes_from_atts( $atts );

    $output = '';

    //check if menu_name actually exists in db, if not add fallback menu
    $menu_obj = wp_get_nav_menu_object( $menu_name );
    if( false === $menu_obj ) {
        $menu_name = '';
    }
    
    if($menu_name != ''){
        $defaults = array (
            'menu'=> $menu_name,
            'depth'=> apply_filters('tatsu_vertical_menu_depth',3),
            'container_class'=>'tatsu-sidebar-menu '.$unique_class,
            'menu_id' => 'menu-'.$key, 
            'menu_class' => 'clearfix ',
            'echo' => false,
            'walker' => new Tatsu_Walker_Nav_Menu()
        );
        $output = '<nav '.$css_id.' class="tatsu-header-module tatsu-sidebar-navigation clearfix '.$visibility_classes.' '.$css_classes.'">'.wp_nav_menu( $defaults ).$custom_style_tag.'</nav>';
    }else{
        if( current_user_can( 'edit_theme_options' ) ) {
            $output = '<a href="'.esc_url(admin_url('nav-menus.php')).'">'.esc_html__('CREATE OR SET A MENU', 'tatsu').'</a>';
        }
    }
    return $output;

}
add_shortcode( 'tatsu_sidebar_navigation_menu', 'tatsu_sidebar_navigation_menu' );

if ( !class_exists('Tatsu_Walker_Nav_Menu') ) {
    class Tatsu_Walker_Nav_Menu extends Walker_Nav_Menu {
		function start_lvl(&$output, $depth=0, $args=array()) {
            $indent = str_repeat("\t", $depth);
            $sub_menu_indicator = file_get_contents( TATSU_PLUGIN_DIR . 'includes/header-builder/img/tatsu_header_arrow.svg' );

            $output .= "<span class=\"sub-menu-indicator\">$sub_menu_indicator</span><ul class=\"tatsu-sub-menu clearfix\">";

        }
        
	}
}

add_action( 'tatsu_register_header_modules', 'tatsu_register_sidebar_navigation_menu' );
function tatsu_register_sidebar_navigation_menu() {

	$controls = array (
        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#vertical_nav_menu',
        'title' => esc_html__( 'Vertical Menu', 'tatsu' ),
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
                        )
                    ),
                    array(
                        'type' => 'tab',
                        'title' => esc_html__('Style', 'tatsu'),
                        'group'	=> array(
                            array(
                                'type' => 'accordion',
                                'active' => array(0, 1, 2),
                                'group' => array(
                                    'links_margin',
                                    array (
                                        'type' => 'panel',
                                        'title' => esc_html__( 'Colors', 'tatsu' ),
                                        'group' => array (
                                            'menu_color',
                                            'menu_hover_color',
                                        )
                                    ),	
                                    array (
                                        'type' => 'panel',
                                        'title' => esc_html__( 'Sub Menu', 'tatsu' ),
                                        'group' => array (
                                            'sub_menu_text_color',
                                            'sub_menu_hover_color',
                                            'sub_menu_hover_bg_color'
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
				'label' => esc_html__( 'Menu Name', 'oshine-modules' ),
				'options' => tatsu_header_get_menu_list()[0],
				'tooltip' => '',
				'default' =>  tatsu_header_get_menu_list()[1]
			), 
			array (
			'att_name' => 'links_margin',
			'type' => 'input_group',
			'label' => esc_html__( 'Spacing between Links', 'tatsu' ),
			'default' => '0px 0px 5px 0px',
			'tooltip' => '',
			'css' => true,
			'responsive' => true,
			'selectors' => array(
					'.tatsu-{UUID}.tatsu-sidebar-menu > ul > li' => array(
						'property' => 'margin',
					),
				),
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
						'.tatsu-{UUID}.tatsu-sidebar-menu' => array(
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
						'.tatsu-{UUID}.tatsu-sidebar-menu a' => array(
							'property' => 'color',
						),
						'.tatsu-{UUID}.tatsu-sidebar-menu li svg polyline' => array(
							'property' => 'stroke',
						)
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
					'.tatsu-{UUID}.tatsu-sidebar-menu > ul > li > a' => array(
						'property' => 'typography',
					),
					'.tatsu-{UUID}.tatsu-sidebar-menu > ul > li > span' => array(
						'property' => 'typography',
					)
				),
			),		
			array (
				'att_name' => 'menu_hover_color',
				'type' => 'color',
				'label' => esc_html__( 'Menu Hover Color', 'tatsu' ),
				'default' => 'rgba(34,147,215,1)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
						'.tatsu-{UUID}.tatsu-sidebar-menu > ul > li:hover > a' => array(
							'property' => 'color',
						),
						'.tatsu-{UUID}.tatsu-sidebar-menu > ul > li:hover > .sub-menu-indicator svg polyline' => array(
							'property' => 'stroke'
						),
						'.tatsu-{UUID}.tatsu-sidebar-menu li.current-menu-item > a' => array(
							'property' => 'color',
						),
						'.tatsu-{UUID}.tatsu-sidebar-menu > ul > li.current-menu-item > .sub-menu-indicator svg polyline' => array(
							'property' => 'stroke'
						),
						'.tatsu-{UUID}.tatsu-sidebar-menu li.current-menu-parent > a' => array(
							'property' => 'color',
						),
						'.tatsu-{UUID}.tatsu-sidebar-menu > ul > li.current-menu-parent > .sub-menu-indicator svg polyline' => array(
							'property' => 'stroke'
						),

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
						'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu li a' => array(
							'property' => 'color',
						),
						'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu li svg polyline' => array(
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
							'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu > li:hover > a' => array(
								'property' => 'color',
							),
							'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu > li:hover svg polyline' => array(
								'property' => 'stroke',
							),
							'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu > li.current-menu-item > a' => array(
								'property' => 'color',
							),
							'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu > li.current-menu-item svg polyline' => array(
								'property' => 'stroke',
							),
							'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu > li.current-menu-parent > a' => array(
								'property' => 'color',
							),
							'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu > li.current-menu-parent svg polyline' => array(
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
							'.tatsu-{UUID}.tatsu-sidebar-menu ul.tatsu-sub-menu > li:hover > a' => array(
								'property' => 'background',
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
						'.tatsu-{UUID}.tatsu-sidebar-menu .tatsu-sub-menu li a' => array(
							'property' => 'typography',
						)
					),
				), 					
		),
	);
	tatsu_register_header_module( 'tatsu_sidebar_navigation_menu', $controls, 'tatsu_sidebar_navigation_menu' );
}
?>