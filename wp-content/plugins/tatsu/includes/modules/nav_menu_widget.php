<?php 

function tatsu_wp_menu_links( $atts, $content, $tag ) {
    
    $atts = shortcode_atts( array(
        'menu_name' => '',
        'menu_style' => '',
        'wrap_alignment' => '',
        'menu_spacing' => '',
        'menu_color' => '',
        'menu_hover_color' => '',
        'show_arrow' => '',
        'link_font' => '',	
        'margin'    => '0 0 30px 0',
		'hide_in' => '',
		'animate' => 0,
        'animation_type' => 'fadeIn',
        'animation_delay' => 0,
        'key' => be_uniqid_base36(true)
    ), $atts, $tag );
    
    extract( $atts );
    $unique_class = 'tatsu-'.$atts['key'];
	$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key, '' );
	$css_id = be_get_id_from_atts( $atts );
	$visibility_classes = be_get_visibility_classes_from_atts( $atts );
	$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : ''; 
	$data_animations = be_get_animation_data_atts( $atts );

    $output = '';

    //check if menu_name actually exists in db, if not add fallback menu
    $menu_obj = wp_get_nav_menu_object( $menu_name );
    if( false === $menu_obj ) {
        $menu_name = '';
    }

    $arrow_class = isset( $show_arrow ) && ( $show_arrow ) ? 'show-arrow' : '' ;
    $menu_style = isset( $menu_style ) && ( $menu_style === 'horizontal' ) ? 'horizontal-menu' : '' ;
    
    if($menu_name != ''){
        $defaults = array (
            'menu'=> $menu_name,
            'depth'=> 3,
            'container_class'=>'tatsu-menu-widget ',
            'menu_id' => 'menu-'.$key, 
            'menu_class' => 'clearfix ',
            'echo' => false,
            'walker' => new Tatsu_Walker_Menu_Widget()
        );
        $output = '<nav '.$css_id.' class="tatsu-menu-widget-wrap tatsu-module clearfix '.$css_classes.' '.$visibility_classes.' '.$unique_class.' '.$link_font.' '.$arrow_class.' '.$menu_style.' '.$animate.'" '.$data_animations.' >'.wp_nav_menu( $defaults ).$custom_style_tag.'</nav>';
    }else{
        if( current_user_can( 'edit_theme_options' ) ) {
            $output = '<a href="' . esc_url(admin_url('nav-menus.php')).'">'.esc_html__('CREATE OR SET A MENU', 'tatsu').'</a>';
        }
    }
    return $output;

}
add_shortcode( 'tatsu_wp_menu_links', 'tatsu_wp_menu_links' );

if ( !class_exists('Tatsu_Walker_Menu_Widget') ) {
    class Tatsu_Walker_Menu_Widget extends Walker_Nav_Menu {
		function start_lvl(&$output, $depth=0, $args=array()) {
            $indent = str_repeat("\t", $depth);
            $sub_menu_indicator = file_get_contents( TATSU_PLUGIN_DIR . 'includes/header-builder/img/tatsu_header_arrow.svg' );

            $output .= "<ul class=\"tatsu-sub-menu clearfix\">";

        }
        
	}
}

add_action('tatsu_register_modules', 'tatsu_register_wp_menu_links');
function tatsu_register_wp_menu_links()
{

	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#vertical_nav_menu',
		'title' => esc_html__('Navigation Menu', 'tatsu'),
		'is_js_dependant' => false,
		'type' => 'single',
		'is_built_in' => false,
		'inline' => false,
		'builder_layout' => 'column',


		//Tab1
		'group_atts'			=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => 'none',
								'group' => array(
									'menu_name',
									'menu_style',
								)
							)
						)
					),

					//Tab2
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(
									array( //color accordion
										'type'		=> 'panel',
										'title'		=> esc_html__('Colors', 'tatsu'),
										'group'		=> array(
											'border_width', //border property
											array(
												'type'  	=> 'tabs',
												'style'		=> 'style1',
												'group'		=> array(
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Normal', 'tatsu'),
														'group'		=> array(
															'menu_color',
														),
													),
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Hover', 'tatsu'),
														'group'		=> array(
															'menu_hover_color'
														),
													),
												),
											)
										),
									),

									'wrap_alignment',
									'show_arrow',
									'link_font',

								)
							),
						)
					),
					//Tab3
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array( //spacing and styling accordion
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
								),
							),
						),
					),
				)
			)
		),

		'atts' => array(
			array(
				'att_name' => 'menu_name',
				'type' => 'select',
				'label' => esc_html__('Menu Name', 'oshine-modules'),
				'options' => tatsu_header_get_menu_list()[0],
				'tooltip' => '',
				'default' =>  tatsu_header_get_menu_list()[1]
			),
			array(
				'att_name' => 'menu_style',
				'type' => 'select',
				'label' => esc_html__('Orientation', 'oshine-modules'),
				'options' => array(
					'vertical' => 'Vertical',
					'horizontal' => 'Horizontal'
				),
				'tooltip' => '',
				'default' =>  'vertical'
			),
			array(
				'att_name' => 'wrap_alignment',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Alignment', 'tatsu'),
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
				),
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-menu-widget' => array(
						'property' => 'text-align'
					),
				),
				'default' => 'left',
				'tooltip' => '',
			),
			array(
				'att_name' => 'menu_color',
				'type' => 'color',
				'label' => esc_html__('Menu Color', 'tatsu'),
				'default' => 'rgba(34,147,215,1)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-menu-widget a' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'menu_hover_color',
				'type' => 'color',
				'label' => esc_html__('Menu Hover Color', 'tatsu'),
				'default' => 'rgba(34,147,215,1)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-menu-widget a:hover' => array(
						'property' => 'color',
					),
				)
			),
			array(
				'att_name' => 'show_arrow',
				'type' => 'switch',
				'default' => 1,
				'label' => esc_html__('Show Arrow', 'tatsu'),
				'tooltip' => ''
			),
			function_exists('typehub_get_exposed_selectors') ? array(
				'att_name'	=> 'link_font',
				'type'		=> 'select',
				'label'		=> esc_html__('Title Font', 'tatsu'),
				'default'	=> 'body',
				'options'	=> typehub_get_exposed_selectors()
			) : false,
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '0 0 30px 0',
				'tooltip' => '',
				'css'	  => true,
				'responsive'	=> true,
				'selectors'	=> array(
					'.tatsu-{UUID}.tatsu-module'	=> array(
						'property'		=> 'margin',
					)
				)
			),
		),
	);
	tatsu_register_module('tatsu_wp_menu_links', $controls);
}

?>