<?php 
function tatsu_header_logo( $atts, $content, $tag ) {
    $atts = shortcode_atts( array(
        'default' => '',
        'light' => '',
        'dark' => '',      
        'height' => '',
        'sticky_height' => '',
        'margin' => '',
        'hide_in' => '',
        'id' => '',
        'class' => '',
        'key' => be_uniqid_base36(true),
    ), $atts, $tag );

    extract( $atts );
    $output = '';
    $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key, 'Header' );
    $unique_class = 'tatsu-'.$key;
    $id = !empty( $id ) ? 'id="'.$id.'"' : '';
    $visibility_classes = be_get_visibility_classes_from_atts( $atts );

    //Handle Resposive Visibility controls
    if( !empty( $hide_in ) ) {
        $hide_in = explode(',', $hide_in);
        foreach ( $hide_in as $device ) {
            $visibility_classes .= ' tatsu-hide-'.$device;
        }
	}
	
	$default_logo_id = attachment_url_to_postid( $default );
    $dark_logo_id = attachment_url_to_postid( $dark );
    $light_logo_id = attachment_url_to_postid( $light );

    $default_logo_alt =  !empty( $default_logo_id ) ? be_wp_get_attachment( $default_logo_id ) : '';
    $dark_logo_alt = !empty( $dark_logo_id ) ? be_wp_get_attachment( $dark_logo_id ) : '';
	$light_logo_alt = !empty( $light_logo_id ) ? be_wp_get_attachment( $light_logo_id ) : '';
	
	$default_logo_alt =  is_array( $default_logo_alt ) ? $default_logo_alt['alt'] : '';
    $dark_logo_alt = is_array( $dark_logo_alt ) ? $dark_logo_alt['alt'] : '';
	$light_logo_alt = is_array( $light_logo_alt ) ? $light_logo_alt['alt'] : '';
	
	$dark = empty($dark)?$default:$dark;
	$light = empty($light)?$default:$light;
    $output .= '<div class="tatsu-header-logo tatsu-header-module '.$unique_class.' '.$class.' '.$visibility_classes.'" '.$id.'>';
    $output .= '<a href="'.esc_url( home_url() ).'">';
    $output .= '<img src="'.esc_url( $default ).'" class="logo-img default-logo" alt="'.$default_logo_alt.'" />';
    $output .= '<img src="'.esc_url( $dark ).'" class="logo-img dark-logo" alt="'.$dark_logo_alt.'" />';
    $output .= '<img src="'.esc_url( $light ).'" class="logo-img light-logo" alt="'.$light_logo_alt.'" />';
    $output .= '</a>';
    $output .= $custom_style_tag;
    $output .= '</div>';  // end tatsu-header-logo

    return $output;
}
add_shortcode( 'tatsu_header_logo', 'tatsu_header_logo' );

add_action( 'tatsu_register_header_modules', 'tatsu_register_header_logo' );
function tatsu_register_header_logo() {
    $controls = array (
        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#header_logo',
        'title' => esc_html__( 'Logo', 'tatsu' ),
        'is_js_dependant' => false,
        'type' => 'single',
		'is_built_in' => true,
		'inline' => true,
        'initial_children' => 0,
		'group_atts' => array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'	=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
                            array(
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Images', 'tatsu'),
										'group' => array(
                                            'default',
                                            'dark',
                                            'light',
										)
                                    ),
									array(
										'type' => 'panel',
										'title' => esc_html__('Height', 'tatsu'),
										'group' => array(
                                            'height',
                                            'sticky_height',
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
									array(
										'type' => 'panel',
										'title' => esc_html__('Identifiers', 'tatsu'),
										'group' => array(
                                            'id',
                                            'class',
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
				'att_name' => 'height',
				'type' => 'slider',
				'label' => esc_html__( 'Logo Height', 'tatsu' ),
				'options' => array(
					'min' => '0',
					'max' => '500',
					'step' => '1',
					'unit' => 'px',
				),
				'default' => '30',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID} .logo-img' => array(
						'property' => 'max-height',
						'append' => 'px',
					),
				),
			),
			array (
				'att_name' => 'sticky_height',
				'type' => 'slider',
				'label' => esc_html__( 'Sticky Header - Logo Height', 'tatsu' ),
				'options' => array(
					'min' => '0',
					'max' => '500',
					'step' => '1',
					'unit' => 'px',
				),
				'default' => '30',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.stuck .tatsu-{UUID} .logo-img' => array(
						'property' => 'height',
						'append' => 'px',
					),
				),
			),
			array (
				'att_name' => 'default',
				'type' => 'single_image_picker',
				'label' => esc_html__( 'Default Logo', 'tatsu' ),
				'default' => TATSU_PLUGIN_URL.'/img/exponent-dark-logo.svg',
				'tooltip' => '',
			),
			array (
				'att_name' => 'dark',
				'type' => 'single_image_picker',
				'label' => esc_html__( 'Dark Logo', 'tatsu' ),
				'default' => TATSU_PLUGIN_URL.'/img/exponent-dark-logo.svg',
				'tooltip' => '',
			),
			array (
				'att_name' => 'light',
				'type' => 'single_image_picker',
				'label' => esc_html__( 'Light Logo', 'tatsu' ),
				'default' => TATSU_PLUGIN_URL.'/img/exponent-light-logo.svg',
				'tooltip' => '',
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
					'.tatsu-{UUID}.tatsu-header-logo' => array(
						'property' => 'margin',
					)
				),
			),
            array (
                'att_name' => 'id',
                'type' => 'text',
                'label' => esc_html__( 'CSS ID', 'tatsu' ),
                'default' => '',
                'tooltip' => '',
            ),
            array (
                'att_name' => 'class',
                'type' => 'text',
                'label' => esc_html__( 'CSS Classes', 'tatsu' ),
                'default' => '',
                'tooltip' => '',
            ),
		),
    );
	tatsu_register_header_module( 'tatsu_header_logo', $controls, 'tatsu_header_logo' );
}
?>