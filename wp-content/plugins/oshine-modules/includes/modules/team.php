<?php

/**************************************
			TEAM
**************************************/
if ( ! function_exists( 'be_team' ) ) {
	function be_team( $atts, $content, $tag ) {
		global $be_themes_data;
		$atts = shortcode_atts( array( 
			'title'=>'',
			'h_tag'=>'h6',
			'description'=>'',
			'designation'=>'',
			'image'=>'',
			'title_color'=> '',
			'description_color'=> '',
			'designation_color'=> '',			
			'facebook'=>'',
			'twitter'=>'',
			'dribbble'=>'',
			'behance'=>'',
			'yelp'=>'',
			'linkedin'=>'',
			'youtube'=>'',
			'vimeo'=>'',
            'email'=> '',
            'instagram' => '',
			'icon_color'=> '',
			'icon_hover_color'=> '',
			'icon_bg_color'=> '',
			'icon_hover_bg_color'=> '',
			'hover_style' => 'style1-hover',
			'title_style' => 'style3',
			'smedia_icon_position' => 'over',
			'title_alignment_static' => '',
			'default_image_style' => 'color',
			'hover_image_style' => 'color',
			'image_effect' => 'none',
			'overlay_color' => '',
			//'overlay_opacity' => '85',
			//'overlay_transparent' => 0,
			'key' => be_uniqid_base36(true),
		),$atts, $tag );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
		$output = '';

		//$url = wp_get_attachment_image_src( $image, 'portfolio-masonry' );
		$hover_style = ((!isset($hover_style)) || empty($hover_style)) ? 'style1-hover' : $hover_style;
		$title_style = ((!isset($title_style)) || empty($title_style)) ? 'style3' : $title_style;
		$image_effect = ((!isset($image_effect)) || empty($image_effect)) ? 'none' : $image_effect;
		$smedia_icon_position = ($title_style == 'style3') ? 'over' : $smedia_icon_position;
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
		$thumb_overlay_color = '';
		if(isset($overlay_color) && !empty($overlay_color)) {
			//$overlay_color = be_themes_hexa_to_rgb( $overlay_color );
			$thumb_overlay_color =  $overlay_color; //'rgba('.$overlay_color[0].','.$overlay_color[1].','.$overlay_color[2].','.(intval($overlay_opacity) / 100 ).')';
		}
		//$thumb_overlay_color = ( isset( $overlay_transparent ) && 1 == $overlay_transparent ) ? 'transparent' : $thumb_overlay_color ;
		$thumb_img_overlay = ($title_style == 'style3') ? 'style="background: '.$thumb_overlay_color.'"' : '' ;
		$icon_overlay_bg = ($smedia_icon_position == 'over' && $title_style != 'style3') ? 'style="background: '.$thumb_overlay_color.'"' : '';
		$icon = '';
		if( ! empty( $facebook ) || ! empty( $twitter ) || ! empty( $dribbble ) || ! empty( $behance ) || ! empty( $yelp ) || ! empty( $linkedin ) || ! empty( $youtube ) || ! empty( $vimeo ) || ! empty( $email ) || !empty( $instagram ) ){
			$icon ='<ul class="team-social clearfix '.$smedia_icon_position.'" '.$icon_overlay_bg.'>';
			$icon .= ( ! empty( $facebook ) ) ? '<li class="icon-shortcode"><a href="'.$facebook.'" class="font-icon tatsu-icon team_icons" target="_blank"><i class="icon-facebook"></i></a></li>' : '' ;
			$icon .= ( ! empty( $twitter ) ) ? '<li class="icon-shortcode"><a href="'.$twitter.'" class="font-icon tatsu-icon team_icons" target="_blank"><i class="icon-twitter"></i></a></li>' : '' ;
			$icon .= ( ! empty( $behance ) ) ? '<li class="icon-shortcode"><a href="'.$behance.'" class="font-icon tatsu-icon team_icons" target="_blank"><i class="icon-behance"></i></a></li>' : '' ;
			$icon .= ( ! empty( $yelp ) ) ? '<li class="icon-shortcode"><a href="'.$yelp.'" class="font-icon tatsu-icon team_icons" target="_blank"><i class="icon-yelp"></i></a></li>' : '' ;

			$icon .= ( ! empty( $linkedin ) ) ? '<li class="icon-shortcode"><a href="'.$linkedin.'" class="font-icon tatsu-icon team_icons" target="_blank"><i class="icon-linkedin"></i></a></li>' : '' ;
			$icon .= ( ! empty( $youtube ) ) ? '<li class="icon-shortcode"><a href="'.$youtube.'" class="font-icon tatsu-icon team_icons" target="_blank"><i class="icon-youtube"></i></a></li>' : '' ;
			$icon .= ( ! empty( $dribbble ) ) ? '<li class="icon-shortcode"><a href="'.$dribbble.'" class="font-icon tatsu-icon team_icons" target="_blank"><i class="icon-dribbble"></i></a></li>' : '';
			$icon .= ( ! empty( $vimeo ) ) ? '<li class="icon-shortcode"><a href="'.$vimeo.'" class="font-icon tatsu-icon team_icons" target="_blank"><i class="icon-vimeo"></i></a></li>' : '';				
            $icon .= ( ! empty( $email ) ) ? '<li class="icon-shortcode"><a href="mailto:'.$email.'" class="font-icon tatsu-icon team_icons" target="_top"><i class="icon-email"></i></a></li>' : '';				
            $icon .= ( ! empty( $instagram ) ) ? '<li class="icon-shortcode"><a href="'.$instagram.'" class="font-icon tatsu-icon team_icons" target="_blank"><i class="icon-instagram"></i></a></li>' : '';
			$icon .='</ul>';
		}
		if($title_style == 'style5') {
			$hover_style = '';
		}
		if(isset($title_alignment_static) && !empty($title_alignment_static) && ($title_style == 'style5')) {
			$title_alignment_static = 'text-align: '.$title_alignment_static.';';
		} else {
			$title_alignment_static = '';
        }
        
        $css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
        $data_animations = be_get_animation_data_atts( $atts );
        $classes = array( $unique_class_name, 'team-shortcode-wrap', 'oshine-module' );
        if( !empty( $visibility_classes ) ) {
            $classes[] = $visibility_classes;
        }
        if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        if( !empty( $css_classes ) ) {
            $classes[] = $css_classes;
        }

		$output .= '<div ' . $css_id . ' class="' . implode( ' ', $classes ) . '" ' . $data_animations . ' >';
			$output .= '<div class="element '.$hover_style.' '.$img_grayscale.' '.$title_style.'-title">';
				$output .= '<div class="element-inner">';
					$output .= '<div class="flip-wrap">';
						$output .= '<div class="flip-img-wrap '.$image_effect.'-effect">';
							if( !empty( $image ) ) {
								$output .= '<img src="'.$image.'" alt="'.$title.'" />';
							}
							if($smedia_icon_position == 'over' && $title_style != 'style3') {
								$output .= $icon;
							}
						$output .= '</div>';
					$output .= '</div>';
					$output .= '<div class="thumb-overlay">';
						$output .= '<div class="thumb-bg" >';
							$output .= '<div class="display-table"><div class="display-table-cell vertical-align-middle">';
								$output .= '<div class="team-wrap clearfix" >';
									$output .= '<'.$h_tag.' class="team-title" >'.$title.'</'.$h_tag.'>';
									$output .= '<p class="designation" >'.$designation.'</p>';
									$output .= '<p class="team-description" >'.$description.'</p>';
									if($smedia_icon_position == 'below' || $title_style == 'style3') {
										$output .= $icon;
									}
								$output .= '</div>';
							$output .= '</div></div>';
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
			$output .= $custom_style_tag;							
		$output .= '</div>';
					
		return $output;		
	}
	add_shortcode( 'team', 'be_team' );
}

add_action( 'tatsu_register_modules', 'oshine_register_team', 11);
function oshine_register_team() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#team',
	        'title' => __( 'Team','oshine-modules' ),
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
								'title',
								'designation',
								'description',
								'image',
								array (
                                    'type'  => 'accordion',
                                    'active'  => 'none',
                                    'group' => array (
                                        array (
                                            'type'  => 'panel',
                                            'title' => __( 'Social Icons', 'oshine-modules' ),
                                            'group' => array (
                                                'facebook',
                                                'twitter',
                                                'behance',
                                                'yelp',
                                                'linkedin',
                                                'youtube',
                                                'vimeo',
                                                'dribbble',
                                                'email',
                                                'instagram'
                                            )
                                        )
                                    )
                                )
							)
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Style' , 'tatsu'),
							'group'	=>	array (
                                'title_style',												
                                'hover_style',
                                'h_tag',
                                'smedia_icon_position',
                                'title_alignment_static',
                                'default_image_style',
                                'hover_image_style',
                                'image_effect',
								array (
									'type' => 'accordion' ,
									'active' => array(0),
									'group' => array (
										array (
											'type' => 'panel',
											'title' => __( 'Colors', 'tatsu' ),
											'group' => array (
												array (
													'type' => 'tabs',
													'style' => 'style1',
													'group'	=> array (
														array (
															'type'		=> 'tab',
															'title'		=> __( 'Normal', 'tatsu' ),
															'group'		=> array (
																'title_color',
																'designation_color',
																'description_color',
																'icon_color',
																'icon_bg_color',
																'overlay_color',
															),	
														),
														array (
															'type'		=> 'tab',
															'title'		=> __( 'Hover', 'tatsu' ),
															'group'		=> array (
																'icon_hover_color',
																'icon_hover_bg_color',
															),
														),
													),			
												)
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
									array(
									'type' => 'accordion' ,
									'active' => array(0, 1),
									'group' => array (
										array (
											'type' => 'panel',
											'title' => __( 'Animation', 'tatsu' ),
											'group' => array (
												'animate',
												'animation_type',
											)
										),
									)
								),
							)
						),
					)
				),
			),
	        'atts' => array (
	        	array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => 'Title',
	        		'default' => '',
	        		'tooltip' => 'Name or Title for the Team Member'
	        	),
	        	array (
	        		'att_name' => 'h_tag',
	        		'type' => 'select',
	        		'label' => __('Tag for Title','oshine-modules'),
	        		'options' => array (
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6'
					),
	        		'default' => 'h5',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'designation',
	        		'type' => 'text',
	        		'label' => 'Designation',
	        		'default' => '',
	        		'tooltip' => 'Designation of the Team Member'
	        	),
	        	array (
	        		'att_name' => 'description',
	        		'type' => 'text',
	        		'label' => 'Description',
	        		'default' => '',
	        		'tooltip' => 'A brief Description about the Team Member'
	        	),
	        	array (
	              	'att_name' => 'image',
	              	'type' => 'single_image_picker',
	              	'label' => 'Upload Team Member Image',
	              	'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'title_color',
					'type' => 'color',
					'options' => array(
						'gradient' => false,
					),
		            'label' => 'Title',
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .team-title' => array(
							'property' => 'color',
						),
					),
	            ),
	        	array (
		            'att_name' => 'designation_color',
					'type' => 'color',
					'options' => array(
						'gradient' => false,
					),
		            'label' => 'Designation',
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .designation' => array(
							'property' => 'color',
						),
					),
	            ),
	        	array (
		            'att_name' => 'description_color',
					'type' => 'color',
					'options' => array(
						'gradient' => false,
					),
		            'label' => 'Description',
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .team-description' => array(
							'property' => 'color',
						),
					),
	            ),
	        	array (
	        		'att_name' => 'facebook',
	        		'type' => 'text',
	        		'label' => 'Facebook',
	        		'default' => '',
					'tooltip' => '',
	        	),
	        	array (
	        		'att_name' => 'twitter',
	        		'type' => 'text',
	        		'label' => 'Twitter',
	        		'default' => '',
					'tooltip' => '',
	        	),
	        	array (
	        		'att_name' => 'behance',
	        		'type' => 'text',
	        		'label' => 'Behance',
	        		'default' => '',
					'tooltip' => '',
	        	),
	        	array (
	        		'att_name' => 'yelp',
	        		'type' => 'text',
	        		'label' => 'Yelp',
	        		'default' => '',
					'tooltip' => '',
	        	),
	        	array (
	        		'att_name' => 'linkedin',
	        		'type' => 'text',
	        		'label' => 'LinkedIn',
	        		'default' => '',
					'tooltip' => '',
	        	),
	        	array (
	        		'att_name' => 'youtube',
	        		'type' => 'text',
	        		'label' => 'Youtube',
	        		'default' => '',
					'tooltip' => '',
	        	),
	        	array (
	        		'att_name' => 'vimeo',
	        		'type' => 'text',
	        		'label' => 'Vimeo',
	        		'default' => '',
					'tooltip' => '',
	        	),
	        	array (
	        		'att_name' => 'dribbble',
	        		'type' => 'text',
	        		'label' => 'Dribbble',
	        		'default' => '',
					'tooltip' => '',
	        	),
	        	array (
	        		'att_name' => 'email',
	        		'type' => 'text',
	        		'label' => 'Email ID',
	        		'default' => '',
					'tooltip' => '',
	        	),
	        	array (
	        		'att_name' => 'instagram',
	        		'type' => 'text',
	        		'label' => 'Instagram',
	        		'default' => '',
					'tooltip' => '',
	        	),
	        	array (
		            'att_name' => 'icon_color',
		            'type' => 'color',
		            'label' => 'Share Icons',
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} i' => array(
							'property' => 'color',
							'when' => array('icon_color', 'notempty'),
						),
					),
	            ),
	        	array (
		            'att_name' => 'icon_hover_color',
		            'type' => 'color',
		            'label' => 'Share Icons',
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} i:hover' => array(
							'property' => 'color',
							'when' => array('icon_hover_color', 'notempty'),
						),
					),
	            ),
	        	array (
		            'att_name' => 'icon_bg_color',
		            'type' => 'color',
		            'label' => 'Share Icons Background',
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .team_icons' => array(
							'property' => 'background-color',
							'when' => array('icon_bg_color', 'notempty'),
						),
					),
	            ),
	        	array (
		            'att_name' => 'icon_hover_bg_color',
		            'type' => 'color',
		            'label' => 'Share Icons Background',
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .team_icons:hover' => array(
							'property' => 'background-color',
							'when' => array('icon_hover_bg_color', 'notempty'),
						),
					),
	            ),
	            array (
	        		'att_name' => 'hover_style',
	        		'type' => 'select',
	        		'label' => __( 'Hover Style', 'oshine-modules' ),
	        		'options' => array (
						'style1-hover' => 'Style1 - FadeToggle',
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
	        		'att_name' => 'title_style',
	        		'type' => 'select',
	        		'label' => __( 'Title & Meta', 'oshine-modules' ),
	        		'options' => array (
						'style3' => 'Over Image',
						'style5' => 'Below Image',
					),
	        		'default' => 'style3',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'smedia_icon_position',
	        		'type' => 'select',
	        		'label' => __( 'Social Media Icons Position', 'oshine-modules' ),
	        		'options' => array (
	        			'none' => 'None',
						'over' => 'Over Image',
						'below' => 'Below Image'
					),
	        		'default' => 'none',
	        		'visible' => array( 'title_style', '=', 'style5' ),
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'title_alignment_static',
	        		'type' => 'select',
	        		'label' => __( 'Title alignment', 'oshine-modules' ),
	        		'options' => array(
	        			'none' => 'None',
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
                    ),
                    'visible' => array ( 'title_style', '=', 'style5' ),
	        		'default' => 'none',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .team-wrap' => array(
							'property' => 'text-align',
							'when' => array('title_style', '=', 'style5'),
						),
					),
	        	),
	            array (
	        		'att_name' => 'default_image_style',
	        		'type' => 'select',
                    'label' => 'Default Image Style',
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
	        		'tooltip' => ''
	        	),
	            array (
	        		'att_name' => 'hover_image_style',
                    'type' => 'select',
	        		'label' => 'Hover Image Style',
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'image_effect',
	        		'type' => 'select',
	        		'label' => 'Image Hover Effects',
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
		            'att_name' => 'overlay_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => 'Overlay',
		            'default' => '',	//color_scheme
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .thumb-bg' => array(
							'property' => 'background',
							'when' => array('title_style', '=', 'style3'),
						),
						'.tatsu-{UUID} .team-social' => array(
							'property' => 'background',
							'when' => array(
								array('title_style', '!=', 'style3'),
								array('smedia_icon_position', '=', 'over'),
							),
							'relation' => 'and',
						),
					),
	            ),
	        ),
			'presets' => array(
				'default' => array(
					'title' => '',
					'image' => '',
					'preset' => array(
						'title' => 'Swami',
						'h_tag' => 'h6',
						'designation' => 'Designer',
						'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque.',
						'image' => 'https://via.placeholder.com/400x400',
						'title_style' => 'style5',
						'smedia_icon_position' => 'over',
						'title_alignment_static' => 'left',
						'facebook' => '#',
						'twitter' => '#',
						'instagram' => '#',
						'linkedin' => '#',
						'overlay_color' => 'rgba( 255, 255, 255, 0.8 )',

					)
				),
			),
	    );
	if( function_exists( 'tatsu_remap_modules' ) ) {
		tatsu_remap_modules( [ 'team', 'tatsu_team' ], $controls, 'be_team' );
	}else {
		tatsu_register_module( 'team', $controls );
	}
}