<?php
function tatsu_wpml_language_switcher( $atts, $content, $tag ) {
    $atts = shortcode_atts( array(
        'current_lang_color' => '',
        'flag_visibility' => '' ,
        'language_name' => '',
        'lang_typography' => '',
        'margin' => '',
        'hide_in' => '',
        'key' => be_uniqid_base36(true),
    ), $atts, $tag );
    
    extract( $atts );

    $output = '';
    $unique_class = 'tatsu-'.$key;
    $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key, 'Header' );
    $css_id = be_get_id_from_atts( $atts );
    $visibility_classes = be_get_visibility_classes_from_atts( $atts );

    $languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0&orderby=code' );
    $my_current_lang = apply_filters( 'wpml_current_language', NULL );
    $sub_menu_indicator = file_get_contents( TATSU_PLUGIN_DIR . 'includes/header-builder/img/tatsu_header_arrow.svg' );

    if( !empty( $languages ) ){
        $output .= '<div '.$css_id.' class = "tatsu-header-module tatsu-wpml-lang-switcher '.$unique_class.' '.$visibility_classes.' '.$css_classes.'"><span class="current-language">'.$my_current_lang.'</span><span class="sub-menu-indicator">'.$sub_menu_indicator.'</span>';
        $output .= '<ul class = "language-list" ><span class="tatsu-header-pointer"></span>';
        foreach( $languages as $l ){
            if( !$l['active'] ){
                $translated_name = isset( $language_name ) && $language_name ? $l['translated_name'] : '';
                $output .= '<li>';
                if( $l['country_flag_url'] && isset( $flag_visibility ) && $flag_visibility ){
                    $output .= '<a href="'.$l['url'].'" class = "language-flag" >';
                    $output .= '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
                    $output .= '</a>';
                }
                $output .= '<a href="'.$l['url'].'" class = "language-name" >';
                $output .= apply_filters( 'wpml_display_language_names', NULL, $l['native_name'], $translated_name );
                $output .= '</a>';
                $output .= '</li>';
            }
        }
        $output .= '</ul>'.$custom_style_tag.'</div>';
    }

    return $output;
}

add_shortcode( 'tatsu_wpml_language_switcher', 'tatsu_wpml_language_switcher' );

if ( in_array( 'sitepress-multilingual-cms/sitepress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	add_action( 'tatsu_register_header_modules', 'tatsu_register_wpml_language_switcher' );
}

function tatsu_register_wpml_language_switcher() {
	$controls = array (
		'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#lang_selector',
		'title' => esc_html__( 'WPML Language Switcher', 'tatsu' ),
		'is_js_dependant' => true,
		'child_module' => '',
		'type' => 'single',
		'inline' => true,
        'is_built_in' => false,
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'	=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
                            'current_lang_color',
                            'flag_visibility',
                            'language_name',
                            'lang_typography',
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
			)
		),
		'atts' => array (
			array (
				'att_name' => 'current_lang_color',
				'type' => 'color',
				'label' => esc_html__( 'Current Language Color', 'tatsu' ),
				'default' => '#212121', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-wpml-lang-switcher' => array(
						'property' => 'color',
					),
					'.tatsu-{UUID}.tatsu-wpml-lang-switcher svg polyline' => array(
						'property' => 'stroke',
					),
				),
			),
			array (
				'att_name' => 'flag_visibility',
				'type' => 'switch',
				'label' => esc_html__( 'Flag', 'tatsu' ),
				'default' => false,
				'tooltip' => '',
			),
			array (
				'att_name' => 'language_name',
				'type' => 'switch',
				'label' => esc_html__( 'Language name in current language', 'tatsu' ),
				'default' => false,
				'tooltip' => '',
			),
			array(
				'att_name' => 'lang_typography',
				'type' => 'typography',
				'label' => esc_html__( 'Typography', 'tatsu' ),
				'responsive' => true,
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'is_inline' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-wpml-lang-switcher .current-language' => array(
						'property' => 'typography',
					),
					'.tatsu-{UUID}.tatsu-wpml-lang-switcher .language-list li' => array(
						'property' => 'typography',
					)
				),
			),
			array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__( 'Margin', 'tatsu' ),
				'default' => '0px 30px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-wpml-lang-switcher' => array(
						'property' => 'margin',
					),
				),
			),
		),	        
	);
	tatsu_register_header_module( 'tatsu_wpml_language_switcher', $controls, 'tatsu_wpml_language_switcher' );
}

?>