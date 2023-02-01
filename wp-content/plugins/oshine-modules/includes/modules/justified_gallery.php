<?php
/*****************************************************
		JUSTIFIED_GALLERY
*****************************************************/
if (!function_exists('be_justified_gallery')) {
	function be_justified_gallery( $atts, $content, $tag ) {
		global $be_themes_data;
		$atts = shortcode_atts( array (
			'gutter_width' => 40,
			'image_height' => 200,
			'initial_load_style' => 'none',
			'hover_style' => 'style1-hover',
			'default_image_style' => 'color',
			'hover_image_style' => 'color',
			'image_effect' => 'none',
            'disable_overlay' => 0,
            'lazy_load' => '0',
            'overlay_color' => '',
            'full_size' => '0',
			'gradient' => '0',
			'gradient_color' => '',
			'gradient_direction' => 'bottom',
			'overlay_opacity' => '85',
			'items_per_load' => '12',
			'gallery_paginate' => 0,
			'caption_type' => 'alt',
			'like_button' => 0,
			'adaptive_image'    => 0,
            'images' => '',
            'key' => be_uniqid_base36(true),
		) , $atts, $tag );

        extract( $atts );
        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';  		
		$data_animations = be_get_animation_data_atts( $atts );

		$output = $thumb_overlay_color = $gradient_style_color = '';
		$gutter_width = (isset($gutter_width) || $gutter_width == 0 || !empty($gutter_width)) ? intval( $gutter_width ) : intval(40);
		$image_height = (isset($image_height) || $image_height == 0 || !empty($image_height)) ? intval( $image_height ) : intval(200);
		$images = ((!isset($images)) || empty($images)) ? '' : $images;
		$initial_load_style = ((!isset($initial_load_style)) || empty($initial_load_style)) ? 'none' : $initial_load_style;
		$hover_style = ((!isset($hover_style)) || empty($hover_style)) ? 'style1-hover' : $hover_style;
		$disable_hover_icon = ((!isset($disable_hover_icon)) || empty($disable_hover_icon)) ? '' : 'hover-icon-no-show';
		$default_image_style = ((!isset($default_image_style)) || empty($default_image_style)) ? 'color' : $default_image_style;
		$hover_image_style = ((!isset($hover_image_style)) || empty($hover_image_style)) ? 'color' : $hover_image_style;
		$image_effect = ((!isset($image_effect)) || empty($image_effect)) ? 'none' : $image_effect;
		$gradient_direction = ((!isset($gradient_direction)) || empty($gradient_direction)) ? 'bottom' : $gradient_direction;
		$disable_overlay = (isset($disable_overlay) && !empty($disable_overlay) && $disable_overlay == 1) ? 1 : 0;
		$items_per_load = ((!isset($items_per_load)) || empty($items_per_load)) ? '' : $items_per_load;
		$gallery_paginate =  ((isset($gallery_paginate)) && !empty($gallery_paginate) && $gallery_paginate == 1) ? 1 : 0;
		$lazy_load = !empty($lazy_load) && !( wp_doing_ajax() || ( defined('REST_REQUEST') && REST_REQUEST ) || isset($_GET['tatsu']) );



		if($default_image_style == 'black_white') {
			if($hover_image_style == 'black_white') {
				$img_grayscale = 'bw_to_bw';
			} else {
				$img_grayscale = 'bw_to_c';
			}
		} else {
			if($hover_image_style == 'black_white') {
				$img_grayscale = 'c_to_bw';
			} else {
				$img_grayscale = 'c_to_c';
			}
		}


		
		$overlay_color = be_compute_color( $overlay_color );
		$overlay_color = $overlay_color[1];


		$overlay_opacity = ((!isset($overlay_opacity)) || empty($overlay_opacity)) ? 85 : $overlay_opacity;
		if(isset($overlay_color) && !empty($overlay_color)) {
			//$overlay_color = be_themes_hexa_to_rgb( $overlay_color );
			$thumb_overlay_color = $overlay_color;  //'rgba('.$overlay_color[0].','.$overlay_color[1].','.$overlay_color[2].','.(intval($overlay_opacity) / 100 ).')';
			if($gradient) {
				if( empty( $gradient_color ) ) {
					$gradient_color = $overlay_color;
				} else {
					//$gradient_color = be_themes_hexa_to_rgb( $gradient_color );
				}
				//$thumb_gradient_overlay_color = 'rgba('.$gradient_color[0].','.$gradient_color[1].','.$gradient_color[2].','.(intval($overlay_opacity) / 100 ).')';
				$thumb_gradient_overlay_color = $gradient_color;
				$gradient_style_color = 'background-image: -o-linear-gradient('.$gradient_direction.', '.$thumb_overlay_color.' 0%, '.$thumb_gradient_overlay_color.' 100%);background-image: -moz-linear-gradient('.$gradient_direction.', '.$thumb_overlay_color.' 0%, '.$thumb_gradient_overlay_color.' 100%);background-image: -webkit-linear-gradient('.$gradient_direction.', '.$thumb_overlay_color.' 0%, '.$thumb_gradient_overlay_color.' 100%);background-image: -ms-linear-gradient('.$gradient_direction.', '.$thumb_overlay_color.' 0%, '.$thumb_gradient_overlay_color.' 100%);background-image: linear-gradient(to '.$gradient_direction.', '.$thumb_overlay_color.' 0%, '.$thumb_gradient_overlay_color.' 100%);';
			}
		}



		$source = array (
			'source' => 'selected',
			'account_name' => '', 
			'count' => '',
			'col' => empty($full_size) ? 'two' : 'one',
			'masonry' => 1,
		);


		$paged  = '0';

		$images_arr = $images;	
		//$data_total_items = count(explode(',',$images_arr)) - $items_per_load;
		$data_total_items = count(explode(',',$images_arr)) - $items_per_load;
		if(1 == $gallery_paginate && '' != $items_per_load){
			$images_subset = array_slice(explode(',', $images), '0', $items_per_load);
		}else{
			$images_subset = explode(',', $images);
        }

		$images = get_gallery_image_from_source($source, implode(",",$images_subset), 'photoswipe');
		

		// $images = get_gallery_image_from_source($source, $images, 'photoswipe');
		
		if($images && is_array($images) && !isset($images['error']) && empty($images['error'])) {
			$output .= '<div '.$css_id.' class="justified-gallery-outer-wrap oshine-module '.$disable_hover_icon.' '.$unique_class_name.' '.$animate.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'>';
            $output .= '<div class=" justified-gallery-inner-wrap " data-action="get_be_justified_gallery_with_pagination" data-paged="1" data-source=\''.json_encode($source).'\' data-images-array="'.$images_arr.'" data-items-per-load="'.$items_per_load.'" data-hover-style="'.$hover_style.'" data-image-grayscale="'.$img_grayscale.'" data-image-effect="'.$image_effect.'" data-thumb-overlay-color="'.$thumb_overlay_color.'" data-grad-style-color="'.$gradient_style_color.'" data-like-button="'.$like_button.'" data-disable-overlay="'.$disable_overlay.'" >';
			$output .= '<div class=" justified-gallery clickable clearfix be-photoswipe-gallery '.$initial_load_style.'" data-gutter-width="'.$gutter_width.'" data-image-height="'.$image_height.'" ' . ( !empty( $lazy_load ) ? 'data-lazy-load = "1"' : '' ) . ' >';
			$output .= get_be_justified_gallery_shortcode($images, $hover_style, $img_grayscale, $image_effect, $thumb_overlay_color, $gradient_style_color, $like_button, $disable_overlay, $lazy_load, $caption_type,$adaptive_image);
			$output .= '</div>'; //end justified-gallery
			if('' != $items_per_load && (1 == $gallery_paginate) ) {
				$output .='<div class="trigger_infinite_scroll justified_gallery_infinite_scroll"></div>';  
			}
            $output .= '</div>'; //end justified-gallery-inner-wrap
            $output .= $custom_style_tag;
			$output .= '</div>'; //end justified-gallery-outer-wrap
		} else {
			if(is_array($images) && !empty($images['error'])) {
				$output .= '<p class="element-empty-message">'.$images['error'].'</p>';
			} else {
				$output .= '<p class="element-empty-message"><b>'.__('Gallery Notice : ', 'oshine-modules').'</b>'.__('Images have either not been selected or couldn\'t be found', 'oshine-modules').'</p>';
			}
		}
		return $output;
	}
	add_shortcode( 'justified_gallery' , 'be_justified_gallery' );
}

add_action( 'tatsu_register_modules', 'oshine_register_justified_gallery');
function oshine_register_justified_gallery() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#justified_gallery',
	        'title' => __( 'Justified Gallery', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
			'is_built_in' => false,
			'group_atts' => array (
				array (
					'type'	=>	'tabs',
					'style'	=>	'style1',
					'group'	=>	array (
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Content' , 'tatsu'),
							'group'	=>	array (
								'images',
								'gallery_paginate',
								'items_per_load',
								'caption_type',
								'like_button',
								'disable_overlay',
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
											'title' => __( 'Shape and Size', 'tatsu' ),
											'group' => array (
												'gutter_width',
                                                'image_height',
                                                'full_size',
												'initial_load_style',
												'hover_style',
												'default_image_style',
												'hover_image_style',
												'image_effect',
												'gradient',
                                                'gradient_direction',
                                                'lazy_load',
												'adaptive_image'
												)
											),
										array (
											'type' => 'panel',
											'title' => __( 'Colors', 'tatsu' ),
											'group' => array (																			
												'overlay_color',
												'gradient_color',
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
	              	'att_name' => 'images',
	              	'type' => 'multi_image_picker',
	              	'label' => __( 'Upload / Select Gallery Images', 'oshine-modules' ),
	              	'tooltip' => '',
	            ),
	        	array (
	        		'att_name' => 'gallery_paginate',
	        		'type' => 'switch',
	        		'label' => __( 'Enable Infinite Scroll', 'oshine-modules' ),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),	            	        	
	        	array (
	        		'att_name' => 'items_per_load',
	        		'type' => 'text',
	        		'label' => __( 'Items Per Load', 'oshine-modules' ),
	        		'default' => '9',
	        		'tooltip' => '',
	        		'hidden' => array( 'gallery_paginate', '=', '0' ),
	        	),

	        	array (
	        		'att_name' => 'gutter_width',
					'type' => 'number',
					'is_inline' => true,
	        		'label' => __('Spacing between images','oshine-modules'),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '40',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'image_height',
					'type' => 'number',
					'is_inline' => true,
	        		'label' => __( 'Image Height', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),	        		
	        		'default' => '200',
	        		'tooltip' => ''
                ),	   
                array (
                    'att_name' => 'full_size',
                    'type' => 'switch',
                    'label' => __( 'Use Full size for images', 'oshine_modules' ),
                    'default' => 0,
                    'tooltip' => ''
                ),  	
	        	array (
	        		'att_name' => 'initial_load_style',
	        		'type' => 'select',
	        		'label' => __( 'Image Load Animation', 'oshine-modules' ),
					'options' => array (
						'init-slide-left' => 'Slide Left',
						'init-slide-right' => 'Slide Right',
						'init-slide-top' => 'Slide Top',
						'init-slide-bottom' => 'Slide Bottom',
						'init-scale' => 'Scale',
						'none' => 'None',
					),
	        		'default' => 'none',
					'tooltip' => '',
					'is_inline' => false,
	        	),
	        	array (
	        		'att_name' => 'hover_style',
					'type' => 'select',
					'is_inline' => false,
					'visible' => array( 'disable_overlay', '!=', '1' ),
	        		'label' => __( 'Hover Style', 'oshine-modules' ),
					'options' => array (
						'style1-hover' => 'Style1 - Fade Toggle',
						'style2-hover' => 'Style2 - 3D FLIP Horizontal',
						'style3-hover' => 'Style3 - Direction Aware',
						'style4-hover' => 'Style4 - Direction Aware Inverse',
						'style5-hover' => 'Style5 - FadeIn & Scale',
						'style6-hover' => 'Style6 - Fall',
						'style7-hover' => 'Style7 - 3D FLIP Vertical',
						'style8-hover' => 'Style8 - 3D Rotate',
					),
	        		'default' => 'style1-hover',
	        		'tooltip' => ''
	        	),	        	
	        	array (
	        		'att_name' => 'default_image_style',
	        		'type' => 'select',
	        		'label' => __( 'Default Image Style', 'oshine-modules' ),
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
					'tooltip' => '',
					'is_inline' => false,
                ),
                array (
                    'att_name' => 'lazy_load',
                    'type' => 'switch',
                    'label' => __( 'Enable Lazy Load', 'oshine_modules' ),
                    'default' => 0,
                    'tooltip' => 'Lazy Load'
                ),
	        	array (
	        		'att_name' => 'hover_image_style',
	        		'type' => 'select',
	        		'label' => __( 'Hover Image Style', 'oshine-modules' ),
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
					'tooltip' => '',
					'is_inline' => false,
	        	),
	        	array (
	        		'att_name' => 'image_effect',
					'type' => 'select',
					'is_inline' => false,
	        		'label' => __( 'Image Effects', 'oshine-modules' ),
					'options' => array (
						'zoom-in' => 'Zoom In',
						'zoom-out' => 'Zoom Out',
						'zoom-in-rotate' => 'Zoom In Rotate',
						'zoom-out-rotate' => 'Zoom Out Rotate',
						'none' => 'None'
					),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
	            array (
	              	'att_name' => 'disable_overlay',
	              	'type' => 'switch',
	              	'label' => __( 'Disable Overlay', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
				array (
		            'att_name' => 'overlay_color',
		            'type' => 'color',
		            'label' => __( 'Thumbnail Overlay Color / Gradient Start Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'visible' => array( 'disable_overlay', '!=', '1' ),
	            ),
	            array (
	              	'att_name' => 'gradient',
	              	'type' => 'switch',
	              	'label' => __( 'Gradient Overlay', 'oshine-modules' ),
	              	'default' => 0,
					'tooltip' => '',
					'visible' => array( 'disable_overlay', '!=', '1' ),
	            ),
				array (
					'att_name' => 'gradient_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Thumbnail Overlay Gradient End Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'visible' => array (
						'condition' =>	array(
							array( 'disable_overlay', '!=', '1' ),
							array( 'gradient', '=', '1' ),
						),
						'relation' => 'and',
					)
	            ),
	        	array (
	        		'att_name' => 'gradient_direction',
					'type' => 'button_group',
					'is_inline' => true,
	        		'label' => __( 'Gradient Direction', 'oshine-modules' ),
					'options' => array (
						'right' => 'Horizontal',
						'bottom' => 'Vertical', 
					),
	        		'default' => 'right',
					'tooltip' => '',
					'visible' => array (
						'condition' =>	array(
							array( 'disable_overlay', '!=', '1' ),
							array( 'gradient', '=', '1' ),
						),
						'relation' => 'and',
					)
				),	
	        	array (
	        		'att_name' => 'caption_type',
					'type' => 'select',
					'is_inline' => true,
	        		'label' => __( 'Caption', 'oshine-modules' ),
					'options' => array (
						'alt' => 'Alt Text',
						'title' => 'Title',
						'description' => 'Description',
						'none' => 'None'
					),
	        		'default' => 'alt',
					'tooltip' => '',
	        	),
	            array (
	              	'att_name' => 'like_button',
	              	'type' => 'switch',
	              	'label' => __( 'Disable Like Button', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
				array(
					'att_name' => 'adaptive_image',
					'type' => 'switch',
					'label' => __('Use Adaptive Image sizes', 'oshine-modules'),
					'default' => 0,
					'tooltip' => '',
				),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'gutter_width' => '20',
	        			'overlay_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'justified_gallery', $controls );
}