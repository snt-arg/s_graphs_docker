<?php
if( !function_exists( 'tatsu_img_slider' ) ) {
    function tatsu_img_slider($atts,$content,$tag) {
        
        $atts =  shortcode_atts( array (
            'type'             => 'ribbon',
            'images'            => '',
            'slide_gutter'      => '0',
            'height'            => '500',
            'full_screen'       => '',
            'full_screen_offset'=> '',
            'center_scale'      => '',
            'border_radius'     => '',
            'border' => '',
            'border_color'  => '',
            'border_style' => '',
            'box_shadow' => '',
            'destroy_slider'    => '',
            'light_box'         => '0',
            'lazy_load'         => '0',
            'adaptive_images'   => '0',
            'slides_to_show'    => '1',
            'vertical_alignment'=> 'center',
            'slide_bg_color'    => '#e5e5e5',
            'arrows'            => '0',
            'pagination'        => '0',
            'dots_color'        => '',
            'slide_show'        => '0',
            'slide_show_speed'  => '2000', 
            'infinite'          => '1',
            'swipe_to_slide'    => '0',
            'destroy_in_mobile' => '1',  
			'key' => be_uniqid_base36(true),
		),$atts, $tag );

        extract( $atts );


        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );

        $custom_class_name = ' tatsu-'.$atts['key'];

        $slider_type = !empty( $type ) ? $type : 'fixed';

        $css_id = be_get_id_from_atts( $atts );
        $visibility_classes = be_get_visibility_classes_from_atts( $atts );

        $wrapper_classes = array( 'tatsu-media-carousel', 'tatsu-module', 'clearfix', $custom_class_name );

        $classes = array( 'tatsu-media-carousel-inner', 'tatsu-carousel' );
        if( !empty( $visibility_classes ) ) {
            $wrapper_classes[] = $visibility_classes;
        }
        if( !empty( $atts['css_classes'] ) ) {
            $wrapper_classes[] = $atts['css_classes'];
        }
        if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $wrapper_classes[] = 'tatsu-animate';
        }
        $wrapper_attrs = be_get_animation_data_atts( $atts );

        if( 'fixed' === $slider_type ) {
            $classes[] = 'tatsu-fixed-carousel';
            if( !empty( $center_scale ) ) {
                $classes[] = 'tatsu-image-center-scale';
            }
        }else if( 'client_carousel' === $slider_type ) {
            $classes[] = 'tatsu-client-carousel';
        }else {
            $classes[] = 'tatsu-variable-carousel';
        }
        if( !empty( $full_screen ) ) {
            $classes[] = 'tatsu-full-screen-carousel';
        }
        if( !empty( $destroy_in_mobile ) ) {
            $classes[] = 'tatsu-carousel-destroy-in-mobile';
        }
        if( 'client_carousel' === $slider_type || 'fixed' === $slider_type ) {
            if( !empty( $slides_to_show ) ) {
                $classes[] = 'tatsu-carousel-cols-' . $slides_to_show;
            }
        }
        if( !empty( $adaptive_images ) ) {
            $classes[] = 'tatsu-carousel-adaptive-image';
        }
        
        //data-atts
        $data_attrs = array();
        if( ( 'ribbon' === $slider_type || 'centered_ribbon' === $slider_type ) ) {
            $data_attrs[] = 'data-variable-width = "1"';
            if( 'centered_ribbon' === $slider_type ) {
                $data_attrs[] = 'data-center-mode = "1"';
            }
        }
        if( !empty( $full_screen ) ) {
            $data_attrs[] = 'data-fullscreen = "1"';
            if( !empty( $full_screen_offset ) ) {
                $data_attrs[] = sprintf( 'data-fullscreen-offset = "%s"', $full_screen_offset );
            }
        }
        if( !empty( $swipe_to_slide ) ) {
            $data_attrs[] = sprintf( 'data-free-scroll = "%s"', $swipe_to_slide ); 
        }
        if( !empty( $arrows ) ) {
            $data_attrs[] = 'data-arrows = "1"';
            $data_attrs[] = 'data-outer-arrows = "1"';
        }
        if( !empty($infinite) ) {
            $data_attrs[] = 'data-infinite = "1"';
        }
        if( !empty( $pagination ) ) {
            $data_attrs[] = 'data-dots = "1"';
        }
        if( !empty( $slide_show ) ) {
            $data_attrs[] = 'data-autoplay = "1"';
        }
        if( !empty( $destroy_in_mobile ) ) {
            $data_attrs[] = 'data-destroy-in-mobile = "1"';
        }
        if( !empty( $slide_show_speed ) ) {
            $data_attrs[] = sprintf( 'data-autoplay-speed = "%s"', $slide_show_speed );
        }
        if( !empty( $lazy_load ) ) {
            $data_attrs[] = 'data-lazy-load = "1"';
        }

        $wrapper_classes = implode( ' ', $wrapper_classes );
        $classes = implode( ' ', $classes );
        $data_attrs = implode( ' ', $data_attrs );
        $images_array = !empty( $images ) ? explode( ',', $images ) : array(); 

        ob_start();
        ?>
            <div <?php echo $css_id; ?> class = "<?php echo $wrapper_classes; ?>" <?php echo $wrapper_attrs; ?>>
                <?php echo $custom_style_tag; ?>
                <div class = "<?php echo $classes; ?>" <?php echo $data_attrs; ?> >
                    <?php if( !empty( $images_array ) ) : ?>
                        <?php foreach( $images_array as $id_and_url ) : ?>
                            <?php 
                                $id_and_url_array = explode( '::', $id_and_url );
                                $id = !empty( $id_and_url_array[0] ) ? $id_and_url_array[0] : '';
                                $url = !empty( $id_and_url_array[1] ) ? $id_and_url_array[1] : '';
                                if( $id_and_url === $id ) {
                                    continue;
                                }
                                $img_attr = array();
                                $img_class = array( 'tatsu-carousel-img' );
                                if( !empty( $lazy_load ) ) {
                                    $img_class[] = 'tatsu-carousel-img-lazy-load';
                                }
                                if( !empty( $id ) ) {
                                    $attachment_details = be_wp_get_attachment( $id );
                                    $img_alt = $attachment_details[ 'alt' ];
                                    $img_attr[] = sprintf('alt = "%s"', $img_alt);
                                    if( !empty( $attachment_details ) ) {
                                        $url = $attachment_details[ 'src' ];
                                        if( 'centered_ribbon' === $slider_type || 'ribbon' === $slider_type || !empty( $destroy_in_mobile ) ) {
                                            $img_height = $attachment_details[ 'height' ];
                                            $img_width = $attachment_details[ 'width' ];
                                            $aspect_ratio = ( !empty( $img_width ) && !empty( $img_height ) ) ? $img_width/$img_height : '1';
                                            $img_attr[] = sprintf( 'data-aspect-ratio = "%s"', $aspect_ratio );
                                        }
                                    }
                                }
                                if( !empty( $adaptive_images ) ) {
									$image_id = attachment_url_to_postid($url);
									if($image_id == 0){
										if( !empty( $lazy_load ) ) {
											$img_attr[] = sprintf( 'data-src = "%s"', $url );
										}else {
											$img_attr[] = sprintf( 'src = "%s"', $url );
										}	
									}else{
										$img_srcset = wp_get_attachment_image_srcset( $image_id, 'full' );
										$sizes = wp_calculate_image_sizes( 'full', null, null, $image_id );
										if( !empty( $lazy_load ) ) {
											$img_attr[] = sprintf( 'data-srcset = "%s"', $img_srcset );
										}else {
											$img_attr[] = sprintf( 'srcset = "%s"', $img_srcset );
										}
									}
                                    $img_attr[] = sprintf( 'sizes = "%s"', $sizes );
                                }else {
                                    if( !empty( $lazy_load ) ) {
                                        $img_attr[] = sprintf( 'data-src = "%s"', $url );
                                    }else {
                                        $img_attr[] = sprintf( 'src = "%s"', $url );
                                    }
                                }
                            ?>
                                <div class = "tatsu-media-slide tatsu-carousel-col">
                                    <div class = "tatsu-media-slide-inner tatsu-carousel-col-inner">
                                        <?php  if( !empty( $light_box ) ) { ?>
                                            <a href="<?php echo $url; ?>" class = "light_box"><img class = "<?php echo implode( ' ', $img_class ) ?>" <?php echo implode( ' ', $img_attr ); ?> /></a>
                                       <?php }else{ ?>
                                                <img class = "<?php echo implode( ' ', $img_class ) ?>" <?php echo implode( ' ', $img_attr ); ?> />
                                       <?php } ?>
                                    </div>
                                </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php
        return ob_get_clean();
    }
    add_shortcode( 'tatsu_image_carousel', 'tatsu_img_slider' );
}

add_action('tatsu_register_modules', 'tatsu_register_image_carousel');
function tatsu_register_image_carousel()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#image_carousel',
		'title' => esc_html__('Image Carousel', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => true,

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
							'type',
							'images',
                            'slides_to_show',
                            'light_box',
                            'lazy_load',
                            'adaptive_images',
                            'destroy_in_mobile',
                            'center_scale',
						)
					),

					//Tab2
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
                            'full_screen',
                            'full_screen_offset',
                            'height',
                            'slide_gutter',
                            'arrows',
                            'pagination',
                            'dots_color',
                            'slide_show',
                            'slide_show_speed',
                            'swipe_to_slide',
                            'infinite',
                            'slide_bg_color',
						),
					),

					array( //Tab3
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
                            array(
                                'type'  => 'accordion',
                                'active' => '',
                                'group' => array (
                                    array (
                                        'type'  => 'panel',
                                        'title' => esc_html__( 'Border', 'tatsu' ),
                                        'group' => array (
                                            'border_style',
                                            'border',
                                            'border_color',
                                            'border_radius',
                                        )
                                    ),
                                    array (
                                        'type'  => 'panel',
                                        'title' => esc_html__( 'Shadow', 'tatsu' ),
                                        'group' => array (
                                            'box_shadow',
                                        )
                                    )
                                )
                            ),
						)
					)
				)
			)
		),


		'atts' => array(
			array(
				'att_name'		=> 'type',
				'type'			=> 'select',
				'label'			=> esc_html__('Type', 'tatsu'),
				'options'		=> array(
					'ribbon'	=> 'Ribbon Carosuel',
					'centered_ribbon'	=> 'Ribbon - Centered Carousel',
					'fixed'		=> 'Fixed Width Carousel Slider',
					'client_carousel'	=> 'Client Carousel',
				),
				'default' => 'client_carousel'
			),
			array(
				'att_name'	=> 'images',
				'type'		=> 'multi_image_picker',
				'label'		=> esc_html__('Images', 'tatsu'),
				'default'	=> '',
				'options'	=> array(
					'type'	=> 'both',
					'size'	=> 'full'
				)
			),
			array(
				'att_name'	=> 'center_scale',
				'type'		=> 'switch',
				'label'		=> esc_html__('Center Scale Images', 'tatsu'),
				'default'	=> '0',
				'visible'	=> array('type', '=', 'fixed'),
			),
            array(
                'att_name'  => 'light_box',
                'type'      => 'switch',
                'label'     => esc_html__('Open In Lightbox', 'tatsu'),
                'default'   => '0',
            ),
			array(
				'att_name'	=> 'lazy_load',
				'type'		=> 'switch',
				'label'		=> esc_html__('Lazy Load', 'tatsu'),
				'default'	=> '0',
			),
			array(
				'att_name'		=> 'adaptive_images',
				'type'			=> 'switch',
				'label'			=> esc_html__('Adaptive Images', 'tatsu'),
				'default'		=> '0',
			),
			array(
				'att_name'	 => 'slide_gutter',
				'type'		 => 'number',
				'options' => array(
					'unit' => 'px',
				),
				'label'		 => esc_html__('Gutter Width', 'tatsu'),
				'default'	 => '0',
                'css'		 => true,
                'is_inline' => true,
				'selectors'	 => array(
					'.tatsu-{UUID} .tatsu-carousel-col' => array(
						'property'	=> 'padding',
						'prepend'	=> '0 ',
						'append'	=> 'px',
						'operation'	=> array('/', 2)
					),
					'.tatsu-{UUID} .tatsu-carousel'		=> array(
						'property'		=> 'margin',
						'prepend'		=> '0 -',
						'append'		=> 'px',
						'operation'		=> array('/', 2),
					),
				),
			),
			array(
				'att_name'	 => 'height',
				'type'		 => 'number',
				'options' => array(
					'unit' => 'px',
				),
				'label'		=> esc_html__('Height', 'tatsu'),
                'default'	=> '500',
                'is_inline' => true,
				'responsive' => true,
				'css' 		=> true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-carousel-col-inner' => array(
						'property'	=> 'height',
						'append'	=> 'px',
						'when'		=> array('full_screen', '!=', '1')
					),
				),
				'visible'	=> array('full_screen', '=', '0'),
			),
			array(
				'att_name'		=> 'full_screen',
				'type'			=> 'switch',
				'label'			=> esc_html__('Full Screen Slider', 'tatsu'),
				'default'		=> '0',
			),
			array(
				'att_name'		=> 'full_screen_offset',
                'type'			=> 'text',
                'is_inline' => true,
				'label'			=> esc_html__('Full Screen Offset', 'tatsu'),
				'default'		=> '',
				'visible'	=> array('full_screen', '==', '1'),
			),
			array(
				'att_name'	=> 'slides_to_show',
				'type'		=> 'slider',
				'options'	=> array(
					'min'	=> '1',
					'max'	=> '6'
				),
				'label'		=> esc_html__('Slides Per Row', 'tatsu'),
				'default'	=> '3',
				'visible'	=> array(
					'condition' => array(
						array('type', '==', 'fixed'),
						array('type', '==', 'client_carousel')
					),
					'relation'	=> 'or'
				)
            ),
            array (
                'att_name' => 'border_style',
                'type' => 'select',
                'label' => esc_html__( 'Border Style', 'tatsu' ),
                'options' => array(
                    'none' => 'None',
                    'solid' => 'Solid',
                    'dashed' => 'Dashed',
                    'double' => 'Double',
                    'dotted' => 'Dotted',
                ),
                'default' => array( 'd' => 'solid', 'l' => 'solid', 't' => 'solid', 'm' => 'solid' ),
                'tooltip' => '',
                'css' => true,
                'responsive' => true,
                'selectors' => array(
                    '.tatsu-{UUID} .tatsu-carousel-col-inner' => array(
                        'property' => 'border-style',
                        'when' => array(
                            array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                            array( 'border', 'notempty' ),
                            array( 'border_style', '!=', array( 'd' => 'none' ) ),
                        ),
                        'relation' => 'and',             
                    ),
                ),
            ),
            array (
                'att_name' => 'box_shadow',
                'type' => 'input_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'tatsu' ),
                'tooltip' => '',
                'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
                'css' => true,
                'selectors' => array(
                    '.tatsu-{UUID} .tatsu-carousel-col-inner' => array(
                        'property' => 'box-shadow',
                        'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)' ),
                    ),
                ),
            ),
            array (
                'att_name' => 'border',
                'type' => 'input_group',
                'label' => esc_html__( 'Border Width', 'tatsu' ),
                'default' => '0px 0px 0px 0px',
                'tooltip' => '',
                'responsive' => true,
                'css' => true,
                'selectors' => array(
                    '.tatsu-{UUID} .tatsu-carousel-col-inner' => array(
                        'property' => 'border-width',
                        'when' => array(
                            array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                            array( 'border', 'notempty' ),
                            array( 'border_style', '!=', 'none' ),
                        ),
                        'relation' => 'and',
                    ),
                ),
            ),
            array (
                'att_name' => 'border_color',
                'type' => 'color',
                'label' => esc_html__( 'Border Color', 'tatsu' ),
                'default' => '',
                'tooltip' => '',
                'css' => true,
                'selectors' => array(
                    '.tatsu-{UUID} .tatsu-carousel-col-inner' => array(
                        'property' => 'border-color',
                        'when' => array(
                            array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                            array( 'border', 'notempty' ),
                            array( 'border_style', '!=', 'none' ),
                        ),
                        'relation' => 'and',
                    ),
                ),
            ),
			array(
				'att_name'	=> 'border_radius',
				'type'		=> 'number',
				'label'		=> esc_html__('Border Radius', 'tatsu'),
				'options' 	=> array(
					'unit'	=> 'px'
				),
				'default'	=> '0',
				'css'		=> true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-carousel-col-inner'		=>  array(
						'property'			=> 'border-radius',
						'append'			=> 'px'
					)
				)
			),
			array(
				'att_name'			=> 'slide_bg_color',
				'type'				=> 'color',
				'label'				=> esc_html__('Slide Background Color', 'tatsu'),
				'default'			=> '',
				'css'				=> true,
				'selectors'			=> array(
					'.tatsu-{UUID} .tatsu-carousel-col-inner' => array(
						'property'	=> 'background'
					)
				)
			),
			array(
				'att_name'	=> 'arrows',
				'type'		=> 'switch',
				'label'		=> esc_html__('Arrows', 'tatsu'),
				'default'	=> '0',
				'tooltip'	=> ''
			),
			array(
				'att_name' => 'pagination',
				'type' => 'switch',
				'label' => esc_html__( 'Dots', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
			array(
				'att_name' => 'dots_color',
				'type' => 'color',
				'label' => esc_html__('Dots Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible'	  => array('pagination', '=', '1'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .flickity-page-dots .is-selected' => array(
						'property' => 'background',
						'when'	   => array('pagination', '=', '1'),
					),
				),
			),
			array(
				'att_name' => 'infinite',
				'type' => 'switch',
				'label' => esc_html__(' Infinite Carousel', 'tatsu'),
				'default' => 1,
				'tooltip' => '',
			),
			array(
				'att_name' => 'slide_show',
				'type' => 'switch',
				'label' => esc_html__('Slide Show', 'tatsu'),
				'default' => 0,
				'tooltip' => ''
			),
			array(
				'att_name' => 'slide_show_speed',
				'type' => 'slider',
				'visible' => array('slide_show', '=', '1'),
				'label' => esc_html__('Slide Show Speed', 'tatsu'),
				'options' => array(
					'min' => '0',
					'max' => '5000',
					'step' => '1000',
					'unit' => 'ms',
				),
				'default' => '2000',
				'tooltip' => ''
			),
			array(
				'att_name'	=> 'swipe_to_slide',
				'type'		=> 'switch',
				'label'		=> esc_html__('Free Scroll', 'tatsu'),
				'default'	=> '1',
				'tooltip'	=> ''
			),
			array(
				'att_name' => 'destroy_in_mobile',
				'type' => 'switch',
				'label' => esc_html__('Stack Images in Mobile view', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'images'			=> '::http://via.placeholder.com/220x150,::http://via.placeholder.com/220x150,::http://via.placeholder.com/220x150,::http://via.placeholder.com/220x150,::http://via.placeholder.com/220x150,::http://via.placeholder.com/220x150,::http://via.placeholder.com/220x150',
					'height'			=> '150',
					'style'				=> 'client_carousel',
					'slide_gutter'		=> '20',
					'dots_color'		=> array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'slides_to_show'	=> '5',
				),
			)
		),
	);
	tatsu_register_module('tatsu_image_carousel', $controls);
}