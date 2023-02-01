<?php
/**************************************
			MULTI LAYER IMAGE
**************************************/
if ( !function_exists('tatsu_multi_layer_images') ) {
    function tatsu_multi_layer_images( $atts, $content, $tag ) {
            $atts = shortcode_atts ( array ( 
                'lazy_load' => 0,
				'placeholder_bg' => '',
				'animate' => 0,
          	    'animation_type' => 'fadeIn',
            	'animation_delay' => 0,
                'key' => be_uniqid_base36(true),
            ), $atts, $tag);
            
			extract($atts);
			$css_id = be_get_id_from_atts( $atts );
			$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
			$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';
            $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
            $custom_class_name = ' tatsu-'.$atts['key'];
			$output = '';
			$data_animations = be_get_animation_data_atts( $atts );

            global $tatsu_multi_layer_image_lazy_load;
            if( !empty( $lazy_load ) ) {
                $tatsu_multi_layer_image_lazy_load = true;
            }else {
                $tatsu_multi_layer_image_lazy_load = false;
			}

			$output .= '<div '.$css_id.' class = "tatsu-module tatsu-multi-layer-images '.$custom_class_name.' '. $css_classes .' '. $visibility_classes .$animate.'"  '.$data_animations.'>' .do_shortcode( $content ) . $custom_style_tag . '</div>';
            return $output;
        }
        add_shortcode( 'tatsu_multi_layer_images', 'tatsu_multi_layer_images' );
}

if ( !function_exists('tatsu_multi_layer_image') ) {
	function tatsu_multi_layer_image( $atts, $content, $tag ){
		$atts = shortcode_atts ( array ( 
                    'image' => '',
                    'id' => '',
                    'offset' => '0px 0px',
                    'shadow_type' => 'box',
                    'box_shadow' => '',
                    'drop_shadow' => '',
                    'max_width'=> '50',
                    'alignment' => '',
                    'image_overflow' => '',
                    'width' => '',
                    'placeholder_bg' => '',
					'stack_order' => '1',
					'animate' => 0,
   				    'animation_type' => 'fadeIn',
     				'animation_delay' => 0,
                    'key' => be_uniqid_base36(true),	
            ), $atts, $tag );

		extract ( $atts );
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';
        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
        $custom_class_name = ' tatsu-'.$atts['key'];
	
        global $tatsu_multi_layer_image_lazy_load;
        $id = ( isset( $id ) ) ? $id : '';
        $lazy_load = !( wp_doing_ajax() || ( defined('REST_REQUEST') && REST_REQUEST ) ) && !empty($tatsu_multi_layer_image_lazy_load) ? true : false ;
        if( $lazy_load ) {
            $lazy_load_class = ' tatsu-image-lazyload';
        }else{
            $lazy_load_class = '';
        } 

        $id = (int)$id;
        $size = 'full';
        $image_atts = array();
        $image_src = '';
        $alt_text = '';
        $image_width;
        $inner_width_style = '';
        $is_external_image = true;
        $external_image_class='';
        $padding_bottom = '';              
		$data_animations = be_get_animation_data_atts( $atts );

        $upload_dir_paths = wp_upload_dir(); //upload current directory and its path
        if ( false !== strpos( $image, $upload_dir_paths['baseurl'] ) ) {
                $image_details = wp_get_attachment_image_src( $id, $size );
                if( $image_details ) {
                    if( 0 == $image_details[2] || 0 ==  $image_details[1] ) {
                        $image_src = $image_details[0];
                        $image_atts[] = sprintf( 'src = "%s"', $image_src );
                    }else {
                        $image_src = $image_details[0]; 
                        $image_width = $image_details[1];                       
                        $image_atts[] = sprintf( 'alt = "%s"', get_post_meta( $id, '_wp_attachment_image_alt', true) );
                        $padding_bottom = 'style = "padding-bottom : '. be_get_placeholder_padding( $id ) .'%;"'; //set padding value                            
                        $image_atts[] = $lazy_load ? sprintf( 'data-src = "%s"', $image_src ) : sprintf( 'src = "%s"', $image_src );
                        $is_external_image = false;
                    } 
                }else {
                    $image_atts[] = $lazy_load ? sprintf( 'data-src = "%s"', $image ) : sprintf( 'src = "%s"', $image );       
                }
        }else {
            $image_atts[] = $lazy_load ? sprintf( 'data-src = "%s"', $image ) : sprintf( 'src = "%s"', $image );       
        }
        if( $is_external_image ) {
            $external_image_class = ' tatsu-external-image';
        }else if( !empty( $image_width ) && empty( $image_overflow ) ) {
            $inner_width_style = "width : {$image_width}px;";
        }

        $output = '';
        if( !empty( $image_atts ) ) {
             $output = '<div '. $css_id .' class = "tatsu-multi-layer-image '. $custom_class_name .' '. $lazy_load_class .' '.$external_image_class . ' ' . $css_classes .' ' . $visibility_classes . $animate.'" '.$data_animations.' style = "' . $inner_width_style . '">';
             $output .= '<div class = "tatsu-multi-layer-image-inner">'; 
           if( !empty( $padding ) ) {
            $output .= '<div class = "tatsu-multi-image-padding" ' . $padding_bottom . '></div>';
           }
           $output .= '<img class = "img-class" ' . implode(  ' ', $image_atts ) . ' />';
           $output .= '</div>';
           $output .= $custom_style_tag;
           $output .=  '</div>'; 
        }
        return $output;
    }
    add_shortcode( 'tatsu_multi_layer_image', 'tatsu_multi_layer_image' );
    
	function tatsu_multi_layer_image_prevent_autop( $content_filter, $tag ) { //Discard unnecessary br/p tag in WP

        if( 'tatsu_multi_layer_images' === $tag || 'tatsu_multi_layer_image' === $tag ) {
            $content_filter = false;
        }
        return $content_filter;
    }
    add_filter( 'tatsu_shortcode_output_content_filter', 'tatsu_multi_layer_image_prevent_autop', 9, 2 );


}

if (!function_exists('tatsu_register_multi_layer_images')) {
	add_action('tatsu_register_modules', 'tatsu_register_multi_layer_images', 9);
	function tatsu_register_multi_layer_images()
	{
		$controls = array(
			'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#multi_layer_image',
			'title' => esc_html__('Multi Layer Images', 'tatsu'),
			'is_js_dependant' => false,
			'child_module' => 'tatsu_multi_layer_image',
			'type' => 'multi',
			'should_autop' => false,
			'is_built_in' => true,
			'initial_children' => 2,

			'group_atts'			=> array(
				array(
					'type'		=> 'tabs',
					'style'		=> 'style1',
					'group'		=> array(
	
						array( //Tab1
							'type' => 'tab',
							'title' => esc_html__('Style', 'tatsu'),
							'group'	=> array(
								'lazy_load',
								'placeholder_bg',
							),
						),
						array( //Tab2
							'type' => 'tab',
							'title' => esc_html__('Advanced', 'tatsu'),
							'group'	=> array(
								array(
									"type" => "accordion",
									"active" => "none",
								  "group" => array(
								)
							)
						  )  
					  ),
				   )
				)
			),

			'atts' => array(
				array(
					'att_name' => 'lazy_load',
					'type' => 'switch',
					'label' => esc_html__('Lazy Load Images', 'tatsu'),
					'default' => '0',
					'tooltip' => ''
				),
				array(
					'att_name' => 'placeholder_bg',
					'type' => 'color',
					'label' => esc_html__('Placeholder Background', 'tatsu'),
					'default' => '',
					'tooltip' => '',
					'visible' => array('lazy_load', '=', '1'),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-multi-layer-image-inner' => array(
							'property' => 'background-color',
							'when' => array('lazy_load', '=', '1'),
						),
					),
                ),
			),
		);
		tatsu_register_module('tatsu_multi_layer_images', $controls);
	}
}

if (!function_exists('tatsu_register_multi_layer_image')) {
	add_action('tatsu_register_modules', 'tatsu_register_multi_layer_image', 9);
	function tatsu_register_multi_layer_image()
	{
		$controls = array(
			'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#image',
			'title' => esc_html__('Multi Layer Image', 'tatsu'),
			'is_js_dependant' => false,
			'type' => 'sub_module',
			'is_built_in' => true,
			'group_atts'			=> array(
				array(
					'type'		=> 'tabs',
					'style'		=> 'style1',
					'group'		=> array(
	
						array( //Tab1
							'type' => 'tab',
							'title' => esc_html__('Content', 'tatsu'),
							'group'	=> array(
								'image',
							),
						),

						array( //Tab2
							'type' => 'tab',
							'title' => esc_html__('Style', 'tatsu'),
							'group'	=> array(
								'offset',
                                'max_width',
                                'alignment',
                                'image_overflow',
                                'width',
                                'placeholder_bg',
								'stack_order'
							),
						),

						array( //Tab3
							'type' => 'tab',
							'title' => esc_html__('Advanced', 'tatsu'),
							'group'	=> array(
								array(
									"type" => "accordion",
									"active" => "none",
								  "group" => array(	
									array( 
										'type' => 'panel',
										'title' => esc_html__('Shadow', 'tatsu'),
										'group'		=> array(
											'shadow_type',
											'box_shadow',
											'drop_shadow',
											
										),
									),
								)
							)
						  )  
					  ),
				   )
				)
			),
	
			'atts' => array(
				array(
					'att_name' => 'image',
					'type' => 'single_image_picker',
					'label' => esc_html__('Image', 'tatsu'),
					'tooltip' => '',
					'default' => TATSU_PLUGIN_URL . '/img/image-placeholder.jpg',
				),
				array(
					'att_name'	=> 'shadow_type',
					'type'	=> 'button_group',
					'label'	=> esc_html__('Shadow Type', 'tatsu'),
					'tooltip'	=> '',
					'options'	=> array(
						'box' => 'Box Shadow',
						'drop'	=> 'Drop Shadow',
					),
					'default'	=> 'box',
				),
				array(
					'att_name' => 'box_shadow',
					'type' => 'input_box_shadow',
					'label' => esc_html__('Box Shadow', 'tatsu'),
					'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					'tooltip' => 'Box Shadow for your image',
					'visible' => array('shadow_type', '=', 'box'),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} img' => array(
							'property' => 'box-shadow',
							'when' => array('shadow_type', '=', 'box'),
						),
					)
				),
				array(
					'att_name' => 'drop_shadow',
					'type' => 'input_drop_shadow',
					'label' => esc_html__('Drop Shadow', 'tatsu'),
					'default' => 'drop-shadow(0px 0px 0px rgba(0,0,0,0))',
					'tooltip' => 'Box Shadow for your image',
					'visible' => array('shadow_type', '=', 'drop'),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} img' => array(
							'property' => 'filter',
							'when' => array('shadow_type', '=', 'drop'),
						),
					)
				),
				array(
					'att_name'	=> 'offset',
					'type'		=> 'negative_number',
					'label'		=> esc_html__('Image Offsets', 'tatsu'),
					'default'	=> '0px 0px',
					'options' => array(
						'labels' => array('X-axis', 'Y-axis'),
						'unit' => array('px')
					),
					'tooltip'	=> '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-multi-layer-image' => array(
							'property' => 'transform',
						),
					),
				),
				array(
					'att_name' => 'max_width',
					'type' => 'slider',
					'label' => esc_html__('Width', 'tatsu'),
					'options' => array(
						'min' => '0',
						'max' => '100',
						'step' => '1',
						'unit' => '%',
                    ),
                    'visible' => array ( 'image_overflow', '=', '0' ),
					'default' => '50',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-multi-layer-image' => array(
							'property' => 'max-width',
                            'append' => '%',
                            'when'  => array ( 'image_overflow', 'empty' )
						)
					),
                ),
                array(
                    'att_name' => 'alignment',
                    'type' => 'button_group',
                    'label' => esc_html__('Align', 'tatsu'),
                    'options' => array(
                        'none' => 'None',
                        'left' => 'Left',
                        'center' => 'Center',
                        'right' => 'Right',
                    ),
                    'default' => 'none',
                    'tooltip' => ''
                ),
                array(
                    'att_name'	=> 'image_overflow',
                    'type' 		=> 'switch',
                    'label'		=> esc_html__('Enable Image Overflow', 'tatsu'),
                    'default'	=> 0,
                    'tooltip'	=> '',
                ),
                array(
                    'att_name' => 'width',
                    'type' => 'slider',
                    'label' => esc_html__('Overflow Width', 'tatsu'),
                    'options' => array(
                        'min' => 100,
                        'max' => 250,
                        'step' => 1,
                        'unit' => '%',
                    ),
                    'default' => '100%',
                    'visible' => array('image_overflow', '==', '1'),
                    'responsive' => true,
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .tatsu-multi-layer-image-inner' => array(
                            'property' => 'width',
                            'when' => array('image_overflow', '=', '1'),
                            'append' => '%',
                        ),
                        '.tatsu-{UUID} .tatsu-multi-layer-image-inner ' => array( //added white space after the selector to make 'Key' of array unique
                            'property' => 'transformX',
                            'when' => array(
                                array('image_overflow', '=', '1'),
                                array('alignment', '=', 'right'),
                            ),
                            'relation' => 'and',
                            'prepend' => '-',
                            'append' => '%',
                            'callback' => 'single_image_overflow_callback',
                        ),
    
                    ),
                ),
                array(
					'att_name' => 'placeholder_bg',
					'type' => 'color',
					'label' => esc_html__('Placeholder Background', 'tatsu'),
					'default' => '',
					'tooltip' => "Works only when Lazy Load is enabled in parent module's settings",
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-multi-layer-image .tatsu-multi-layer-image-inner' => array(
							'property' => 'background-color',
						),
					),
                ),
				array(
					'att_name' => 'stack_order',
					'type' => 'slider',
					'label' => esc_html__('Stack Order', 'tatsu'),
					'options' => array(
						'min' => '1',
						'max' => '20',
						'step' => '1',
						'unit' => '',
					),
					'default' => '1',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-multi-layer-image' => array(
							'property' => 'z-index',
						)
					),
				),
				array(
					'att_name' => 'id',
					'type' => 'number',
					'label' => esc_html__('Id', 'tatsu'),
					'visible' => array('max_width', '=', '-1000')
				),
			),
		);
		tatsu_register_module('tatsu_multi_layer_image', $controls);
	}
}