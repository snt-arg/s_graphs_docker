<?php
/**************************************
			TABS
**************************************/
if (!function_exists('be_tabs')) {
	function be_tabs( $atts, $content, $tag ) {
        $atts = shortcode_atts( array (
            'key' => be_uniqid_base36(true),
        ) , $atts, $tag );
        extract($atts);
        $style_tag = be_generate_css_from_atts( $atts, $tag, $key );
        $css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
        $data_animations = be_get_animation_data_atts( $atts );
        $unique_class_name = ' tatsu-'.$atts['key'];
        $classes = array( $unique_class_name, 'tabs', 'oshine-module' );
        if( !empty( $visibility_classes ) ) {
            $classes[] = $visibility_classes;
        }
        if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        if( !empty( $css_classes ) ) {
            $classes[] = $css_classes;
        }

		$GLOBALS['tabs_cnt'] = 0;
		$tabs_cnt=0;
		$GLOBALS['tabs'] = array();
		$rand = rand();
		$content=do_shortcode( $content );
		if( is_array( $GLOBALS['tabs'] ) ) {
			foreach( $GLOBALS['tabs'] as $tab ) {
				extract($tab);			
				$tabs_cnt++;
				$class = ( ! empty($tab['icon']) && $tab['icon'] != 'none' ) ? "tab-icon ".$tab['icon'] : "" ;
				$tabs[] = '<li><a id="'.$tab['class_name'].'" class="'.$class .'" href="#fragment-'.$tabs_cnt.'-'.$rand.'">'.$tab['title'].'</a> '. $tab['custom_style_tag'] .' </li>';
				$panes[] = '<div id="fragment-'.$tabs_cnt.'-'.$rand.'" class="clearfix be-tab-content">'.$tab['content'].'</div>';
			}
			$return = ($panes || $tabs) ? "\n".'<div ' . $css_id . ' class="' . implode( ' ', $classes ) . '" ' . $data_animations . ' >' . $style_tag . '<ul class="clearfix be-tab-header">'.implode( "\n", $tabs ).'</ul>'.implode( $panes ).'</div>'."\n" : '' ; 
		}
		return $return;
	}
	add_shortcode( 'tabs', 'be_tabs' );
}

if (!function_exists('be_tab')) {
	function be_tab( $atts, $content ){
		$atts = shortcode_atts( array(
	        'icon' => '',
	        'title' => '',
			'title_color' => '',
			'key' => be_uniqid_base36(true),
		),$atts );
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tab', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];

		extract( $atts );

		$content= do_shortcode($content);
		$x = $GLOBALS['tabs_cnt'];
		$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tabs_cnt'] ), 'content' =>  $content, 'icon'=> $icon, 'class_name' => $custom_class_name, 'custom_style_tag' => $custom_style_tag );
		$GLOBALS['tabs_cnt']++;
	}
	add_shortcode( 'tab', 'be_tab' );
}

add_action( 'tatsu_register_modules', 'oshine_register_tabs', 11);
function oshine_register_tabs() {
	$controls = array (
		'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#tabs',
		'title' => __( 'Tabs', 'oshine-modules' ),
		'is_js_dependant' => true,
		'child_module' => 'tab',
		'type' => 'multi',
		'initial_children' => 2,
        'is_built_in' => true,
        'group_atts' => array (
            array(
                'type'  => 'tabs',
                'group' => array (
                    array (
                        'type'  => 'tab',
                        'title' => __( 'Advanced', 'oshine-modules' ),
                        'group' => array (
            
                        )
                    ),
                ),
            ),
        ),
		'atts' => array (),
	);
	if( function_exists( 'tatsu_remap_modules' ) ) {
		tatsu_remap_modules( ['tabs', 'tatsu_tabs'], $controls, 'be_tabs' );
	}else {
		tatsu_register_module( 'tabs', $controls );
	}
}


add_action( 'tatsu_register_modules', 'oshine_register_tab', 11);
function oshine_register_tab() {
	$controls = array (
		'icon' => '',
		'title' => __( 'Tab', 'oshine-modules' ),
		'child_module' => '',
		'type' => 'sub_module',
		'is_built_in' => true,
		'atts' => array (
				array (
				'att_name' => 'title',
				'type' => 'text',
				'label' => __( 'Tab Title', 'oshine-modules' ),
				'default' => '',
				'tooltip' => ''
			),
			array (
				'att_name' => 'icon',
				'type' => 'icon_picker',
				'label' => __( 'Choose icon', 'oshine-modules' ),
				'default' => '',
				'tooltip' => ''
			),
			array (
				'att_name' => 'content',
				'type' => 'tinymce',
				'label' => __( 'Tab Content', 'oshine-modules' ),
				'default' => '',
				'tooltip' => ''
			),	
			array (
				'att_name' => 'title_color',
				'type' => 'color',
				'label' => __('Title Color','oshine-modules'),
				'default' => '',//sec_color
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-{UUID}' => array(
						'property' => 'color',
					),
				),
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
	if( function_exists( 'tatsu_remap_modules' ) ) {
		tatsu_remap_modules( ['tab', 'tatsu_tab'], $controls, 'be_tab' );
	}else {
		tatsu_register_module( 'tab', $controls );
	}
}

if( !function_exists( 'oshine_modules_remove_common_atts_from_tab' ) ) {
    add_filter( 'tatsu_default_common_atts_global_excludes', 'oshine_modules_remove_common_atts_from_tab' );
    function oshine_modules_remove_common_atts_from_tab( $excludes_array ) {
        $excludes_array[] = 'tab';
        return $excludes_array;
    }
}