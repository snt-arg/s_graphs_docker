<?php
/**************************************
			SVG ICON
**************************************/
if (!function_exists('tatsu_svg_icon')) {
    function tatsu_svg_icon( $atts, $content, $tag ) {
        $atts = shortcode_atts( array (
            'svg_icon'              => '',
            'custom_icon'           => '',
            'svg_url'               => '',
            'style'                 => 'plain',
            'size'                  => 'medium',
            'width'                 => 200,
            'height'                => 200,
            'stroke_width'          => '',
            'alignment'             => '',
            'color'                 => '',
            'bg_color'              => '',
            'margin'                => '0 0 60px 0',
            'line_animate'          => 0,
            'path_animation_type'   => 'LINEAR',
			'svg_animation_type'    => 'LINEAR',
			'module_animation_duration' => '',
			'animation_type' => '',
			'animation_delay' => '',
            'animate'               => '',
			'href'=> '#',
			'new_tab' => 0,
        	'key' => be_uniqid_base36(true),
		),$atts, $tag );		

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_svg_icon', $key );
		$unique_class_name = 'tatsu-' . $key;

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		
		$line_animate_class = ( !empty( $line_animate ) ) ? 'tatsu-line-animate' : '' ;

        $svg_icon_style = !empty( $style ) ? ( 'tatsu-svg-icon-' . $style ) : '';

        
        $data_animation_type = '';
        if( !empty( $animation_type ) ) {
            $data_animation_type = 'data-animation = "' . $animation_type . '"';
		}
		$css_animate_class = 'none' !== $animation_type ? 'tatsu-animate' : '';
        $data_animation_delay = '';
        if( !empty( $animation_delay ) ) {
            $data_animation_delay = 'data-animation-delay = "' . $animation_delay . '"';
		}
		$data_module_animation_duration = '';
        if( !empty( $module_animation_duration ) ) {
            $data_module_animation_duration = 'data-animation-duration = "' . $module_animation_duration . '"';
		}
		$data_animation_duration = '';
        if( !empty( $animation_duration ) ) {
            $data_animation_duration = 'data-line-animation-duration = "' . $animation_duration . '"';
        }

        $icon_type_class = '';
        if( !empty( $custom_icon ) ) {
            $icon_type_class = 'tatsu-svg-icon-custom';
        }else {
            $icon_type_class = 'tatsu-svg-icon-default';
        }

		$new_tab = ( isset( $new_tab ) && 1 == $new_tab ) ? 'target="_blank"' : '' ;
        $output = '';
        if( !empty($svg_url) || !empty( $svg_icon ) ) {
            $output .= '<div '.$css_id.' class="tatsu-svg-icon tatsu-module align-'. $alignment . ' ' . $css_animate_class . ' '. $line_animate_class.' '.$size.' '.$unique_class_name . ' ' . $icon_type_class . ' ' . $svg_icon_style . ' '.$visibility_classes.' '.$css_classes.'" data-path-animation="'.$path_animation_type.'" data-svg-animation="'.$svg_animation_type.'" '.$data_module_animation_duration.'  ' . $data_animation_type . ' ' . $data_animation_delay . ' '. $data_animation_duration .' >';
            $output .= '<div class = "tatsu-svg-icon-inner">';
            if( empty( $custom_icon ) ) {
                $svg_icon_html = function_exists( 'tatsu_get_svg_icon' ) ? tatsu_get_svg_icon( $svg_icon ) : '';
                if( !empty( $svg_icon_html ) ) {
					if(!empty($href)){
						$output .= '<a href="'.$href.'" class="tatsu-icon-wrap" '.$new_tab.'>'.$svg_icon_html.'</a>';
					}else{
						$output .= $svg_icon_html;
					}
                    
                }
            }else {
                $site_url = get_site_url();
                if( strpos( $svg_url, $site_url ) !== false ) { 
					$svg_icon_from_url = be_curl_file_get_contents($svg_url);
					if(!empty($href)){
						$output .= '<a href="'.$href.'" class="tatsu-icon-wrap" '.$new_tab.'>'.$svg_icon_from_url.'</a>';
					}else{
						$output .= $svg_icon_from_url;
					}
                    
                } else {
                    $output .= '<div class="tatsu-notification tatsu-error">Cross Domain Access of SVG is not allowed. Please upload the SVG file to your site.</div>';
                }
            }
            $output .= '</div>';
            $output .= $custom_style_tag;
            $output .= '</div>';
        }
        return $output;
	}
	add_shortcode( 'tatsu_svg_icon', 'tatsu_svg_icon' );
}

add_action('tatsu_register_modules', 'tatsu_register_svg_icon');
function tatsu_register_svg_icon()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#svg_icon',
		'title' => esc_html__('SVG Icon', 'tatsu'),
		'is_js_dependant' => false,
		'type' => 'single',
		'is_built_in' => true,
		'group_atts'			=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
							'svg_icon',
							'custom_icon',
							'svg_url',
							'href',
							'new_tab',
						),
					),
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
										'title' => esc_html__('Styling', 'tatsu'),
										'group' => array(
											'color',
											'bg_color',
											'size',
											'width',
											'height',
											'alignment',
											'style',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Line Animation', 'tatsu'),
										'group' => array(
											'line_animate',
											'stroke_width',
											'path_animation_type',
											'svg_animation_type',
											'animation_duration',	
										)
									)
								)
							),
						),
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
										),
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Animation', 'tatsu'),
										'group' => array(
											'animation_type',
											'animation_delay',
											'module_animation_duration',
										)
									),
								),
							),
						),
					),
				),
			),
		),

		'atts' => array(
			array(
				'att_name'	=> 'svg_icon',
				'type'		=> 'svg_icon_picker',
				'label'		=> esc_html__('SVG Icon', 'tatsu'),
				'default'	=> 'linea:basic_paperplane',
				'tooltip'	=> '',
				'visible'	=> array('custom_icon', '=', '0'),
			),
			array(
				'att_name'		=> 'custom_icon',
				'type'			=> 'switch',
				'default'		=> '0',
				'label'			=> esc_html__('Upload Custom Icon', 'tatsu'),
				'tooltip'		=> '',
			),
			array(
				'att_name' => 'svg_url',
				'type' => 'single_image_picker',
				'options' => array(
					'modal_title'	=> 'Select a SVG',
					'button_text'	=> 'Add SVG',
					'mime_type'		=> 'image/svg+xml',
				),
				'label' => 'SVG Icon File URL',
				'default' => '',
				'tooltip' => 'Paste SVG Icon',
				'visible'	=> array('custom_icon', '=', '1'),
			),
			array(
				'att_name' => 'href',
				'type' => 'text',
				'is_inline' => false,
				'options' => array(
					'placeholder' => 'https://example.com',
				),
				'label' => esc_html__('Link URL', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'new_tab',
				'type' => 'switch',
				'label' => esc_html__('Open as new tab', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
				'visible' => array('href', '!=', ''),
			),
			array(
				'att_name' => 'style',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Style', 'tatsu'),
				'options' => array(
					'circled'	=> 'Circled',
					'plain'		=> 'Plain',
				),
				'default' => 'plain',
				'tooltip' => ''
			),
			array(
				'att_name' => 'size',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Size', 'tatsu'),
				'options' => array(
					'small' => 'S',
					'medium' => 'M',
					'large' => 'L',
					'xlarge' => 'XL',
					'custom' => 'Custom',
				),
				'default' => 'small',
				'tooltip' => ''
			),
			array(
				'att_name' => 'width',
				'type' => 'number',
				'is_inline'     => true,
				'label' => esc_html__('Width', 'tatsu'),
				'options' => array(
					'unit' => 'px',
				),
				'default' => '200',
				'tooltip' => '',
				'visible' => array('size', '=', 'custom'),
				'css'	  => true,
				'selectors'	=> array(
					'.tatsu-{UUID} svg'	=> array(
						'property'	=> 'width',
						'when'		=> array('size', '=', 'custom'),
						'append'	=> 'px',
					),
					'.tatsu-{UUID} .tatsu-svg-icon-inner'		=> array(
						'property'		=> 'padding',
						'when'			=> array(
							array('style', '=', 'circled'),
							array('size', '=', 'custom'),
						),
						'relation'	=> 'and',
						'operation'		=> array('/', 2),
						'append'		=> 'px',
					),
				),
			),
			array(
				'att_name' => 'height',
				'type' => 'number',
				'is_inline'     => true,
				'label' => esc_html__('Height', 'tatsu'),
				'options' => array(
					'unit' => 'px',
				),
				'default' => '200',
				'tooltip' => '',
				'visible' => array('size', '=', 'custom'),
				'css'	  => true,
				'selectors'	=> array(
					'.tatsu-{UUID} svg'	=> array(
						'property'	=> 'height',
						'when'		=> array('size', '=', 'custom'),
						'append'	=> 'px',
					),
				),
			),
			array(
				'att_name'		=> 'stroke_width',
				'type'			=> 'number',
				'is_inline'     => true,
				'label'			=> esc_html__('Stroke Width', 'tatsu'),
				'options' => array(
					'unit' => 'px',
				),
				'default' => '2',
				'tooltip' => '',
				'css'	  => true,
				'visible'	=> array('line_animate', '=', '1'),
				'selectors'	=> array(
					'.tatsu-{UUID} svg'		=> array(
						'property'		=> 'stroke-width',
						'append'		=> 'px',
						'when'			=> array('line_animate', '=', '1'),
					),
				),
			),
			array(
				'att_name' => 'bg_color',
				'type' => 'color',
				'label' => esc_html__('SVG Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'visible'	=> array('style', '=', 'circled'),
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-svg-icon-inner' => array(
						'property' => 'background',
						'when'	   => array(
							'style', '=', 'circled'
						)
					),
				),
			),
			array(
				'att_name' => 'color',
				'type' => 'color',
				'label' => esc_html__('SVG Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} svg' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'alignment',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Align', 'tatsu'),
				'options' => array(
					'none' => 'None',
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right'
				),
				'default' => 'none',
				'tooltip' => ''
			),
			array(
				'att_name' => 'line_animate',
				'type' => 'switch',
				'label' => esc_html__('Enable SVG Line Animation', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
			array(
				'att_name' => 'path_animation_type',
				'type' => 'select',
				'label' => esc_html__('Path Animation', 'tatsu'),
				'options' => array(
					'LINEAR' => 'Linear',
					'EASE' => 'Ease',
					'EASE_IN' => 'Ease In',
					'EASE_OUT' => 'Ease Out',
					'EASE_OUT_BOUNCE' => 'Ease Out Bounce'
				),
				'default' => 'EASE',
				'tooltip' => '',
				'visible' => array('line_animate', '=', '1'),
			),
			array(
				'att_name' => 'svg_animation_type',
				'type' => 'select',
				'label' => esc_html__('SVG Animation', 'tatsu'),
				'options' => array(
					'LINEAR' => 'Linear',
					'EASE' => 'Ease',
					'EASE_IN' => 'Ease In',
					'EASE_OUT' => 'Ease Out',
					'EASE_OUT_BOUNCE' => 'Ease Out Bounce'
				),
				'default' => 'EASE_IN',
				'tooltip' => '',
				'visible' => array('line_animate', '=', '1'),
			),
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
			array(
				'att_name' => 'animation_duration',
				'type' => 'slider',
				'options' => array(
					'min' => '10',
					'max' => '500',
					'step' => '1',
					'unit' => '',
				),
				'default' => '100',
				'label' => esc_html__('Animation Duration', 'tatsu'),
				'tooltip' => '',
				'visible' => array('line_animate', '=', '1'),
			),
			array (
				'att_name' => 'module_animation_duration',
				'type' => 'slider',
				'exclude' => array('tatsu_testimonial_carousel'),
				'default' => '300',
				'options' => array(
					'min' => '100',
					'max' => '2000',
					'step' => '50',
					'unit' => 'ms',
				),
				'label' => esc_html__( 'Animation Duration', 'tatsu' ),
				'visible' => array( 'animation_type', '!=', 'none' ),
				'tooltip' => ''
			),
			array (
				'att_name' => 'animation_type',
				'type' => 'select',
				'exclude' => array( 'tatsu_testimonial_carousel', 'tatsu_empty_space' ),
				'options' => tatsu_css_animations(),
				'label' => esc_html__( 'Animation Type', 'tatsu' ),
				'default' => 'none',
				'tooltip' => '',
			),
			array(
			   'att_name' => 'animation_delay',
			   'type' => 'slider',
			   'exclude' => array( 'tatsu_testimonial_carousel', 'tatsu_empty_space' ),
			   'options' => array(
				   'min' => '0',
				   'max' => '2000',
				   'step' => '50',
				   'unit' => 'ms',
			   ),
			   'default' => '0',	        		
			   'label' => esc_html__( 'Animation Delay', 'tatsu' ),
			   'tooltip' => '',
			   'visible' => array( 'animation_type', '!=', 'none' ),
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'svg_icon'  => 'linea:basic_paperplane',
					'color'		=> array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
				),
			)
		),
	);
	tatsu_register_module('tatsu_svg_icon', $controls);
}

?>