<?php

/**************************************
			ICON CARD
**************************************/
if ( ! function_exists( 'be_icon_card' ) ) {
	function be_icon_card($atts,$content, $tag) {
		global $be_themes_data;
		$atts = shortcode_atts(array(
			'icon'=>'none',
			'size' => 'small',	
			'style'=>'circled',
			'icon_bg'=> '',
			'icon_color'=> '',
			'icon_border_color'=> '',
			'title' => '',
			'title_font' => '',
			'title_color' => '',
			'caption' => '',
			'caption_font' => '',
			'caption_color' => '',
			'key' => be_uniqid_base36(true),
		),$atts, $tag);

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		$output = '';
        $css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
        $data_animations = be_get_animation_data_atts( $atts );
        $classes = array( $custom_class_name, 'be_icon_card_wrap', 'oshine-module' );
        if( !empty( $visibility_classes ) ) {
            $classes[] = $visibility_classes;
        }
        if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        if( !empty( $css_classes ) ) {
            $classes[] = $css_classes;
        }
        $classes[] = $size;
        $classes[] = $style;
		$icon_label = str_replace(array('tatsu','icon','-','_'),'',$icon);

		$caption_tag = 'div';
		if ('body' == $caption_font){
			$caption_font_style = 'body-font';
		} elseif ('special' == $caption_font){
			$caption_font_style = 'special-subtitle';
		} else {
			$caption_font_style = '';
			$caption_tag = $caption_font;
		}
		$output .= '<div ' .$css_id . ' class = "' . implode( ' ', $classes ) . '" ' . $data_animations . ' >';
		$output .= '<i class="font-icon '.$icon.'  " aria-label = "'.$icon_label.'" ></i>';
		$output .= '<div class="title-with-icon-card" >';
		$output .= !empty($title) ? '<'.$title_font.' class="title" >'.$title.'</'.$title_font.'>' : '';
		$output .= !empty($caption) ? '<'.$caption_tag.' class="caption '.$caption_font_style.'" >'.$caption.'</'.$caption_tag.'>' : '';
		$output .= '</div>';    		
		$output .= '</div>';
		$output .= $custom_style_tag;
		return $output; 
	}
	add_shortcode('icon_card','be_icon_card');
}

add_action( 'tatsu_register_modules', 'oshine_register_icon_card');
function oshine_register_icon_card() {
		$controls = array (
			'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#icon_card',
			'title' => __( 'Icon Card', 'oshine-modules' ),
			'is_js_dependant' => false,
			'child_module' => '',
			'type' => 'single',
			'is_built_in' => true,
			'group_atts' => array (
				array (
					'type'	=>	'tabs',
					'style'	=>	'style1',
					'group'	=>	array (
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Content' , 'tatsu'),
							'group'	=>	array (
								'icon',
								'title',
								'caption',
								'title_font',
								'caption_font',
							)
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Style' , 'tatsu'),
							'group'	=>	array (
								array (
									'type' => 'accordion' ,
									'active' => array(0, 1),
									'group' => array (
										array (
											'type' => 'panel',
											'title' => __( 'Style & Size', 'tatsu' ),
											'group' => array (
												'size',
												'style',
                                            )
                                        ),
										array (
											'type' => 'panel',
											'title' => __( 'Colors', 'tatsu' ),
											'group' => array (
												'title_color',
												'caption_color',
												'icon_color',
												'icon_border_color',
												'icon_bg',
											)
										)
									)
								)
							),
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Advanced' , 'tatsu'),
							'group'	=>	array (
							)
						),
					)
				),
			),
			'atts' => array (
				array (
					'att_name' => 'icon',
					'type' => 'icon_picker',
					'label' => __( 'Icon', 'oshine-modules' ),
					'default' => '',
					'tooltip' => ''
				),
				array (
					'att_name' => 'size',
                    'type' => 'button_group',
                    'is_inline' => true,
					'label' => __( 'Size', 'oshine-modules' ),
					'options' => array (
						'small'=> 'Small', 
						'large'=> 'Large'
					),
					'default' => 'small',
					'tooltip' => ''
				),
				array (
					'att_name' => 'style',
                    'type' => 'button_group',
                    'is_inline' => true,
					'label' => __( 'Style', 'oshine-modules' ),
					'options' => array (
						'circled'=> 'Circled', 
						'plain'=> 'Plain'
					),
					'default' => 'circled',
					'tooltip' => ''
				),
				array (
					'att_name' => 'icon_bg',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
					'label' => __( 'Background', 'oshine-modules' ),
					'default' => '',
					'tooltip' => '',
                    'css' => true,
                    'visible'  => array('style','=','circled'),
					'selectors' => array(
						'.tatsu-{UUID} .font-icon' => array(
							'property' => 'background',
							'when' => array('style','=','circled')
						),
					),
				),
				array (
					'att_name' => 'icon_color',
					'type' => 'color',
					'label' => __( 'Icon', 'oshine-modules' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .font-icon' => array(
							'property' => 'color',
						),
					),
				),
				array (
					'att_name' => 'icon_border_color',
					'type' => 'color',
					'label' => __( 'Icon Border', 'oshine-modules' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .font-icon' => array(
							'property' => 'border',
							'prepend' => '1px solid ',
							'when' => array('style','=','circled')
						),
					),
				),
				array (
					'att_name' => 'title',
					'type' => 'text',
					'label' => __( 'Title', 'oshine-modules' ),
					'default' => '',
					'tooltip' => ''
				),
				array (
					'att_name' => 'title_font',
					'type' => 'select',
					'label' => __( 'Font for Title', 'oshine-modules' ),
					'options' => array (
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6'
					),
					'default' => 'h3',
					'tooltip' => ''
				),
				array (
					'att_name' => 'title_color',
					'type' => 'color',
					'label' => __( 'Title', 'oshine-modules' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .title' => array(
							'property' => 'color',
						),
					),
				),
				array (
					'att_name' => 'caption',
					'type' => 'text',
					'label' => __( 'Caption', 'oshine-modules' ),
					'default' => '',
					'tooltip' => '',
				
				),
				array (
					'att_name' => 'caption_font',
					'type' => 'select',
					'label' => __( 'Font for Caption', 'oshine-modules' ),
					'options' => array (
						'body'=> 'Body', 
						'special' => 'Special Title Font',
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6'
					),
					'default' => 'special',
					'tooltip' => ''
				),
				array (
					'att_name' => 'caption_color',
					'type' => 'color',
					'label' => __( 'Caption', 'oshine-modules' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .caption' => array(
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
						'icon' => 'icon-icon_phone',
						'size' => 'small',
						'icon_bg' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
						'icon_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
						'title' => 'Call Us',
						'title_font' => 'h6',
						'caption' => '+001-987-654-3210'
					)
				),
			),
	    );
	tatsu_register_module( 'icon_card', $controls );
}
