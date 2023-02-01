<?php 

function tatsu_search( $atts, $content, $tag ) {

    $atts = shortcode_atts( array(
        'icon_color' => '',
        'margin' => '',
        'hide_in' => '',
        'key' => be_uniqid_base36(true)
    ), $atts, $tag );

    extract( $atts );

    $output = '';
    $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key, 'Header' );
    $unique_class = 'tatsu-'.$key;
    $css_id = be_get_id_from_atts( $atts );
    $visibility_classes = be_get_visibility_classes_from_atts( $atts );
    $search_icon = file_get_contents( TATSU_PLUGIN_DIR . 'includes/header-builder/img/tatsu_header_search.svg' );

    $output =  '<div '.$css_id.' class="tatsu-header-module tatsu-search '.$unique_class.' '.$visibility_classes.' '.$css_classes.'">   
                    '.$search_icon
                    .$custom_style_tag.'
                    <div class = "search-bar">
                        <span class="tatsu-header-pointer"></span>
                        <form role="search" method="get" class="tatsu-search-form" action="' . home_url( '/' ) . '" >
                            <input type="text" placeholder="'.esc_attr__( 'Search ...' , 'tatsu' ).'" value="' . get_search_query() . '" name="s" />
                        </form>
                    </div>
                    <div class = "tatsu-search-bar-overlay">
                    </div>
                </div>';

    return $output;
}

add_shortcode( 'tatsu_search', 'tatsu_search' );

add_action( 'tatsu_register_header_modules', 'tatsu_register_search' );
function tatsu_register_search() {
	$controls = array (
		'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#search_lens',
		'title' => esc_html__( 'Search', 'tatsu' ),
		'is_js_dependant' => true,
		'child_module' => '',
		'type' => 'single',
		'inline' => true,
        'is_built_in' => true,
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'	=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
                            'icon_color',
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
				'att_name' => 'icon_color',
				'type' => 'color',
				'label' => esc_html__( 'Icon Color', 'tatsu' ),
				'default' => '#212121', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-search svg g' => array(
						'property' => 'stroke',
					),
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
					'.tatsu-{UUID}.tatsu-search' => array(
						'property' => 'margin',
					),
				),
			),
		),	        
	);
	tatsu_register_header_module( 'tatsu_search', $controls, 'tatsu_search' );
}

?>