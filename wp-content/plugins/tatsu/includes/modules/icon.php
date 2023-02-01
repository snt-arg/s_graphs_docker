<?php
if (!function_exists('tatsu_icon')) {
	function tatsu_icon( $atts, $content, $tag ) {
		$atts = shortcode_atts(array(
			'name' => '',
			'icon_type' => '',
			'icon_style' => 'plain',
			'icon_image' => '',
			'size'=> 'medium',
			'custom_bg_size' => '',
			'custom_icon_size' => '',
			'style'=> 'circle',
			'bg_color'=> '',
			'hover_bg_color'=> '',
			'color'=> '',
			'hover_color'=> '',
			'border_width' => 1,
			'border_color'=> '#323232',
			'hover_border_color'=> '#323232',
			'outer_border_color' => '',
			'href'=> '#',
			'alignment' => 'none',
			'lightbox' => 0,
			'image' => '',
			'video_url' => '',
			'new_tab' => 0,
			'animate' => 0,
			'animation_type'=>'fadeIn',
			'animation_delay' => 0,
			'box_shadow' => '',
			'margin' => '',
			'hover_effect' => '',
			'hover_box_shadow' => '',
			'builder_mode' => '',
			'light_color' => '#f5f5f5',
			'light_bg_color' => 'rgba(255,255,255,0.2)',
			'light_border_color' => '#f5f5f5',
			'light_hover_color' => '',
			'ripple_effect'	=> '0',
			'ripple_color'	=> '',
			'light_hover_bg_color' => '',
			'light_hover_border_color' => '',
			'dark_color' => '#232425',
			'dark_bg_color' => 'rgba(255,255,255,0.2)',
			'dark_border_color' => '#232425',
			'dark_hover_color' => '',
			'dark_hover_bg_color' => '',
			'dark_hover_border_color' => '',
			'hide_in' => '',
			'key' => be_uniqid_base36(true),
		),$atts, $tag );

		extract( $atts );
		
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key, $builder_mode );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$data_animations = be_get_animation_data_atts( $atts );		
		$mfp_class = '';
		$output = '';
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '' ;
		$new_tab = ( isset( $new_tab ) && 1 == $new_tab ) ? 'target="_blank"' : '' ;
		
		$hover_effect_parent = $alignment === 'none' && 'none' !== $hover_effect ? $hover_effect : '';
		$hover_effect_child = $alignment !== 'none' && 'none' !== $hover_effect ? $hover_effect : '';

		$href = ( empty( $href ) ) ? '#' : tatsu_parse_custom_fields( $href );
		$video_url = tatsu_parse_custom_fields( $video_url );
		
		if( isset( $lightbox ) && 1 == $lightbox ) {
			if( !empty( $video_url ) ) {
				$mfp_class = 'mfp-iframe';
				$href = $video_url;
			} elseif ( !empty($image) ) {
				$mfp_class = 'mfp-image';
				$href = $image;
			}
		}

		//GDPR Privacy preference popup logic
		$gdpr_atts = '{}';
		$gdpr_concern_selector = '';
		if ( $mfp_class === 'mfp-iframe' ) {
			if ( function_exists( 'be_gdpr_privacy_ok' ) ) {
				$video_details = be_get_video_details( $video_url );
				if ( ! empty( $video_details ) ) {
					if ( ! empty( $_COOKIE ) ) {
						if ( ! be_gdpr_privacy_ok( $video_details['source'] ) ) {
							$mfp_class = 'mfp-popup';
							$href = '#gdpr-alt-lightbox-'.$key;
							$output .= be_gdpr_lightbox_for_video( $key, $video_details["thumb_url"], $video_details['source'] );
						}
					} else {
						$gdpr_atts = array(
							'concern' => $video_details[ 'source' ],
							'add' => array( 
								'class' => array( 'mfp-popup' ),
								'atts'	=> array( 'href' => '#gdpr-alt-lightbox-'.$key ),
							),
							'remove' => array( 
								'class' => array( $mfp_class )
							)
						);
						$gdpr_concern_selector = 'be-gdpr-consent-required';
						$gdpr_atts = json_encode( $gdpr_atts );
						$output .= be_gdpr_lightbox_for_video( $key, $video_details["thumb_url"], $video_details['source'] );
					}
				}
			}
		}
		//ripple effect
		$ripple_class = '';
		if( 'circle' === $style && !empty( $ripple_effect ) ) {
			$ripple_class = 'tatsu-icon-ripple';
		} 

		$output .= '<div '.$css_id.' class="tatsu-module tatsu-normal-icon tatsu-icon-shortcode align-'.$alignment.' '.$unique_class_name.' '.$hover_effect_parent.' '.$visibility_classes.' '.$css_classes.'">';
		$output .= $custom_style_tag; 

		$inner_attr = ' class="tatsu-icon-wrap '.$style.' '.$animate.' '.$mfp_class.' '.$hover_effect_child.' '.$gdpr_concern_selector. ' ' . $ripple_class . '" '.$data_animations.' aria-label="'.$name.'" data-gdpr-atts='.$gdpr_atts.' ';

		if( 'image' == $icon_type ) {
			$inner_icon = ( $icon_style == 'plain' ) ? '<img src="'.$icon_image.'" class="tatsu-icon-image '.$size.' '.$style.'">' : '<img src="'.$icon_image.'" class="tatsu-icon-image tatsu-icon-image-circled '.$size.' '.$style.'" data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'">' ;
		} else {
			$inner_icon = ( $style == 'plain' ) ? '<i class="tatsu-icon tatsu-custom-icon tatsu-custom-icon-class '.$name.' '.$size.' '.$style.'"></i>' : '<i class="tatsu-icon tatsu-custom-icon tatsu-custom-icon-class '.$name.' '.$size.' '.$style.'"  data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'"></i>' ;
		}
			
		if(empty($href)){
			$output .= '<div '.$inner_attr.'  >'.$inner_icon.'</div>';
		}else{
			$output .= '<a href="'.$href.'" '.$inner_attr.' '.$new_tab.' >'.$inner_icon.'</a>';
		}
		$output .= '</div>';
		
		return $output;
	}
	add_shortcode( 'tatsu_icon', 'tatsu_icon' );
	add_shortcode( 'icon', 'tatsu_icon' );
}

if( !function_exists( 'tatsu_icon_header_atts' ) ) {
	function tatsu_icon_header_atts( $atts, $tag ) {
		if( 'tatsu_icon' === $tag ) {
			// New Atts
			$atts['builder_mode'] = array (
				'type' => '',
				'default' => 'Header',
			);
				// Light Scheme Colors
			$atts['light_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Icon Color', 'tatsu' ),
				'default' => '#f5f5f5', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['light_bg_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Background Color', 'tatsu' ),
				'default' => 'rgba(255,255,255,0.2)', 
				'tooltip' => '',
				'visible' => array('style', '!=', 'plain'),
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'background-color',
						'when' => array( 
							array( 'style', '!=', 'plain' ),
							array( 'bg_color', '!=', '' )
						),
						'relation' => 'and',
					),
				),
			);
			
			$atts['light_border_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Border Color', 'tatsu' ),
				'default' => '#f5f5f5', 
				'tooltip' => '',
				'visible' => array('style', '!=', 'plain'),
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'border-color',
						'when' => array(
							array( 'border_width', '!=', '0' ),
							array( 'style', '!=', 'plain' ),
						),
						'relation' => 'and',
					),
				),
			);
			
			$atts['light_hover_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Hover Icon Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['light_hover_bg_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Hover Background Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'visible' => array('style', '!=', 'plain'),
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'background-color',
						'when' => array( 'style', '!=', 'plain' ),
					),
				),
			);
			
			$atts['light_hover_border_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Hover Border Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'visible' => array('style', '!=', 'plain'),
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'border-color',
						'when' => array(
							array( 'border_width', '!=', '0' ),
							array( 'style', '!=', 'plain' ),
						),
						'relation' => 'and',
					),
				),
			);
				// Dark Scheme Colors
			$atts['dark_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Icon Color', 'tatsu' ),
				'default' => '#232425', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['dark_bg_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Background Color', 'tatsu' ),
				'default' => 'rgba(255,255,255,0.2)', 
				'tooltip' => '',
				'visible' => array('style', '!=', 'plain'),
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'background-color',
						'when' => array( 
							array( 'style', '!=', 'plain' ),
							array( 'bg_color', '!=', '' )
						),
						'relation' => 'and',
					),
				),
			);
			
			$atts['dark_border_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Border Color', 'tatsu' ),
				'default' => '#232425', 
				'tooltip' => '',
				'visible' => array('style', '!=', 'plain'),
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'border-color',
						'when' => array(
							array( 'border_width', '!=', '0' ),
							array( 'style', '!=', 'plain' ),
						),
						'relation' => 'and',
					),
				),
			);
			
			$atts['dark_hover_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Hover Icon Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['dark_hover_bg_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Hover Background Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'visible' => array('style', '!=', 'plain'),
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'background-color',
						'when' => array( 'style', '!=', 'plain' ),
					),
				),
			);
			
			$atts['dark_hover_border_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Hover Border Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'visible' => array('style', '!=', 'plain'),
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'border-color',
						'when' => array(
							array( 'border_width', '!=', '0' ),
							array( 'style', '!=', 'plain' ),
						),
						'relation' => 'and',
					),
				),
			);
			// Modify Atts
			$atts['margin'] = 	array (
				'type' => 'input_group',
				'label' => esc_html__( 'Margin', 'tatsu' ),
				'default' => '0px 15px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-normal-icon' => array(
						'property' => 'margin',
					),
				),
			);
			// Remove Atts
			unset( $atts['alignment'] );
		}
		return $atts;
	}
	add_filter( 'tatsu_header_modify_atts', 'tatsu_icon_header_atts', 10, 2 );
}

add_action('tatsu_register_modules', 'tatsu_register_icon_module', 4);
add_action('tatsu_register_header_modules', 'tatsu_register_icon_module', 9);
function tatsu_register_icon_module()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#icon',
		'title' => esc_html__('Icon', 'tatsu'),
		'is_js_dependant' => false,
		'inline' => false,
		'type' => 'single',
		'is_built_in' => false,
		'hint' => 'name',
		'is_dynamic' => true,
		'group_atts' => array(
			array(
				'type'	=>	'tabs',
				'style'	=>	'style1',
				'group'	=>	array(
					array(
						'type'	=>	'tab',
						'title'	=>	esc_html__('Content', 'tatsu'),
						'group'	=>	array(
							'icon_type',
 							'name',
							'icon_image',
							'href',
							'new_tab',
							'lightbox',
							'image',
							'video_url',
						)
					),
					array(
						'type'	=>	'tab',
						'title'	=>	esc_html__('Style', 'tatsu'),
						'group'	=>	array(
							array(
								'type' => 'accordion',
								'active' => array(0,1,2),
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Shape and Size', 'tatsu'),
										'group' => array(
											'size',
											'style',
											'icon_style',
											'alignment',
										)
									),
									'border_width',
									array(
										'type' => 'panel',
										'title' => esc_html__('Colors', 'tatsu'),
										'group' => array(
											array(
												'type'	=>	'tabs',
												'style'	=>	'style1',
												'group'	=>	array(
													array(
														'type'	=>	'tab',
														'title'	=>	esc_html__('Normal', 'tatsu'),
														'group'	=>	array(
															'bg_color',
															'color',
															'border_color',
														),
														'visible' => array('icon_type', '=', 'icon'),
													),
													array(
														'type'	=>	'tab',
														'title'	=>	esc_html__('Hover', 'tatsu'),
														'group'	=>	array(
															'hover_bg_color',
															'hover_color',													
															'hover_border_color'
														),
														'visible' => array('icon_type', '=', 'icon'),
													),
												)
											),
										),
										'visible' => array('icon_type', '=', 'icon'),
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Light Scheme Colors', 'tatsu'),
										'group' => array(
											array(
												'type'	=>	'tabs',
												'style'	=>	'style1',
												'group'	=>	array(
													array(
														'type'	=>	'tab',
														'title'	=>	esc_html__('Normal', 'tatsu'),
														'group'	=>	array(
															'light_bg_color',
															'light_color',
															'light_border_color',
														)
													),
													array(
														'type'	=>	'tab',
														'title'	=>	esc_html__('Hover', 'tatsu'),
														'group'	=>	array(
															'light_hover_bg_color',
															'light_hover_color',
															'light_hover_border_color'
														)
													),
												)
											),
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Dark Scheme Colors', 'tatsu'),
										'group' => array(
											array(
												'type'	=>	'tabs',
												'style'	=>	'style1',
												'group'	=>	array(
													array(
														'type'	=>	'tab',
														'title'	=>	esc_html__('Normal', 'tatsu'),
														'group'	=>	array(
															'dark_bg_color',
															'dark_color',
															'dark_border_color',
														)
													),
													array(
														'type'	=>	'tab',
														'title'	=>	esc_html__('Hover', 'tatsu'),
														'group'	=>	array(
															'dark_hover_bg_color',
															'dark_hover_color',
															'dark_hover_border_color'
														)
													),
												)
											),
										)
									),
								)
							)
						),
					),

					array(
						'type'	=>	'tab',
						'title'	=>	esc_html__('Advanced', 'tatsu'),
						'group'	=>	array(
							array(
								'type' => 'accordion',
								'active' => array(0),
								'group' => array(
									array(
										'type'	=>	'panel',
										'title'	=>	esc_html__('Spacing', 'tatsu'),
										'group'	=>	array(
											'margin',
										)
									),
									array(
										'type'	=>	'panel',
										'title'	=>	esc_html__('Shadow', 'tatsu'),
										'group'	=>	array(
											'box_shadow',
											'hover_box_shadow',
										)
									),
									array(
										'type'	=>	'panel',
										'title'	=>	esc_html__('Border', 'tatsu'),
										'group'	=>	array(
											'border_style',
											'border',
											'outer_border_color',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Animation', 'tatsu'),
										'group' => array(
											'ripple_effect',
											'ripple_color',
											'hover_effect',
											'animation_type',
											'animation_delay'
										)
									),
								)
							),
						)
					),
				)
			),
		),


		'atts' => array(
			array(
				'att_name' => 'icon_type',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Type', 'tatsu'),
				'options' => array(
					'icon' => 'Icon',
					'image' => 'Image',
				),
				'default' => 'icon',
				'tooltip' => ''
			),
			array(
				'att_name' => 'name',
				'type' => 'icon_picker',
				'label' => esc_html__('Icon', 'tatsu'),
				'default' => 'icon-monitor',
				'visible' => array('icon_type', '=', 'icon'),
				'tooltip' => ''
			),
			array(
				'att_name' => 'icon_image',
				'type' => 'single_image_picker',
				'label' => esc_html__('Image', 'tatsu'),
				'visible' => array('icon_type', '=', 'image'),
				'tooltip' => '',
				'default'	=> 'http://via.placeholder.com/150x150',
				'options' => array(
					'size' => 'thumbnail',
				),
			),
			array(
				'att_name' => 'size',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Size', 'tatsu'),
				'options' => array(
					'tiny' => 'XS',
					'small' => 'S',
					'medium' => 'M',
					'large' => 'L',
					'xlarge' => 'XL',
				),
				'default' => 'small',
				'tooltip' => ''
			),
			array(
				'att_name' => 'style',
				'type' => 'select',
				'is_inline' => true,
				'label' => esc_html__('Style', 'tatsu'),
				'options' => array(
					'circle' => 'Circle',
					'plain' => 'Plain',
					'square' => 'Square',
					'diamond' => 'Diamond'
				),
				'default' => 'circle',
				'tooltip' => '',
				'visible' => array('icon_type', '=', 'icon')
			),
			array(
				'att_name' => 'icon_style',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Icon Style', 'tatsu'),
				'options' => array(
					'plain' => 'Plain',
					'circled' => 'Circled'
				),
				'default' => 'plain',
				'tooltip' => '',
				'visible' => array('icon_type', '=', 'image'),
			),
			array(
				'att_name' => 'bg_color',
				'type' => 'color',
				'label' => esc_html__('Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array(
					'condition'	=> array(
						array('style', '!=', 'plain'),
						array('icon_type', '=', 'icon')
					),
					'relation'	=> 'and',
				),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'background-color',
						'when' => array('style', '!=', 'plain'),
					),
				),
			),
			array(
				'att_name' => 'hover_bg_color',
				'type' => 'color',
				'label' => esc_html__('Hover Background Color', 'tatsu'),
				'default' => '', //color_scheme
				'tooltip' => '',
				'visible' => array(
					'condition'	=> array(
						array('style', '!=', 'plain'),
						array('icon_type', '=', 'icon')
					),
					'relation'	=> 'and',
				),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'background-color',
						'when' => array('style', '!=', 'plain'),
					),
				),
			),
			array(
				'att_name' => 'color',
				'type' => 'color',
				'label' => esc_html__('Icon Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'color',
					),
				),
				'visible' => array('icon_type', '=', 'icon'),
			),
			array(
				'att_name' => 'hover_color',
				'type' => 'color',
				'label' => esc_html__('Hover Icon Color', 'tatsu'),
				'default' => '', //alt_bg_text_color
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'color',
					),
				),
				'visible' => array('icon_type', '=', 'icon'),
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
				'exclude' => array( 'tatsu_image' ),
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
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
			array(
				'att_name' => 'border_width',
				'type' => 'number',
				'is_inline' => true,
				'label' => esc_html__('Border Width', 'tatsu'),
				'options' => array(
					'unit' => 'px',
				),
				'default' => '',
				'tooltip' => '',
				'visible' => array(
					'condition'	=> array(
						array('style', '!=', 'plain'),
						array('icon_type', '=', 'icon')
					),
					'relation'	=> 'and',
				),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'border-width',
						'when' => array('style', '!=', 'plain'),
						'append' => 'px'
					),
				),
			),
			array(
				'att_name' => 'border_color',
				'type' => 'color',
				'label' => esc_html__('Border Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array(
					'condition'	=> array(
						array('style', '!=', 'plain'),
						array('icon_type', '=', 'icon')
					),
					'relation'	=> 'and',
				),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'border-color',
						'when' => array(
							array('border_width', '!=', '0'),
							array('style', '!=', 'plain'),
						),
						'relation' => 'and',
					),
				),
			),
			array(
				'att_name' => 'hover_border_color',
				'type' => 'color',
				'label' => esc_html__('Hover Border Color', 'tatsu'),
				'default' => '', //color_scheme
				'tooltip' => '',
				'visible' => array(
					'condition'	=> array(
						array('style', '!=', 'plain'),
						array('icon_type', '=', 'icon')
					),
					'relation'	=> 'and',
				),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'border-color',
						'when' => array(
							array('border_width', '!=', '0'),
							array('style', '!=', 'plain'),
						),
						'relation' => 'and',
					),
				),
			),array (
				'att_name' => 'border',
				'type' => 'input_group',
				'label' => esc_html__( 'Border Width', 'tatsu' ),
				'default' => '0px 0px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'border-width',
						'when' => array( 'border-width', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
					),
				),
			),
			array (
				'att_name' => 'outer_border_color',
				'type' => 'color',
				'label' => esc_html__( 'Border Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'border-color',
						'when' => array('border', '!=', '0px 0px 0px 0px'),
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
				'att_name'		=> 'ripple_effect',
				'type'			=> 'switch',
				'label'			=> esc_html__('Enable Ripple Effect', 'tatsu'),
				'default'		=> '0',
				'tooltip'		=> '',
				'visible'		=> array('style', '=', 'circle'),
			),
			array(
				'att_name' => 'ripple_color',
				'type' => 'color',
				'label' => esc_html__('Ripple Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array(
					'condition'	=> array(
						array('style', '=', 'circle'),
						array('ripple_effect', '=', '1')
					),
					'relation'	=> 'and',
				),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon-ripple::before, .tatsu-{UUID} .tatsu-icon-ripple::after' => array(
						'property' => 'border-color',
						'when' => array(
							array('style', '=', 'circle'),
							array('ripple_effect', '=', '1')
						),
						'relation'	=> 'and'
					),
				),
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
				'att_name' => 'lightbox',
				'type' => 'switch',
				'default' => 0,
				'label' => esc_html__('Enable Lightbox Image / Video', 'tatsu'),
				'tooltip' => ''
			),
			array(
				'att_name' => 'image',
				'type' => 'single_image_picker',
				'label' => esc_html__('Select Lightbox image / video', 'tatsu'),
				'tooltip' => '',
				'visible' => array('lightbox', '=', '1'),
			),
			array(
				'att_name' => 'video_url',
				'type' => 'text',
				'label' => esc_html__('Youtube / Vimeo Url in lightbox', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array('lightbox', '=', '1'),
			),
			array(
				'att_name' => 'hover_effect',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Hover Effect', 'tatsu'),
				'options' => array(
					'none' => 'None',
					'icon-transform' => 'Slide up',
					'icon-scale' => 'Scale'
				),
				'default' => 'none',
				'tooltip' => ''
			),
			array(
				'att_name' => 'animation_type',
				'type' => 'select',
				'label' => esc_html__('Animation Type', 'tatsu'),
				'options' => tatsu_css_animations(),
				'default' => 'fadeIn',
				'tooltip' => '',
				'visible' => array('animate', '=', '1'),
			),
			array(
				'att_name' => 'animation_delay',
				'type' => 'slider',
				'options' => array(
					'min' => '0',
					'max' => '2000',
					'step' => '50',
					'unit' => 'ms',
				),
				'default' => '0',
				'label' => esc_html__('Animation Delay', 'tatsu'),
				'tooltip' => '',
				'visible' => array('animate', '=', '1'),
			),
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '0px 0px 20px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-normal-icon' => array(
						'property' => 'margin',
						'when' => array('margin', '!=',  '0px 0px 20px 0px'),
					),
				),
			),
			array(
				'att_name' => 'box_shadow',
				'type' => 'input_box_shadow',
				'label' => esc_html__('Box Shadow', 'tatsu'),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'tooltip' => '',
				'visible' => array('style', '!=', 'plain'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'box-shadow',
						'when' => array(
							array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
							array('style', '!=', 'plain'),
						),
						'relation' => 'and',
					),
				),
			),
			array(
				'att_name' => 'hover_box_shadow',
				'type' => 'input_box_shadow',
				'label' => esc_html__('Hover Box Shadow', 'tatsu'),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'tooltip' => '',
				'visible' => array('style', '!=', 'plain'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'box-shadow',
						'when' => array(
							array('hover_box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
							array('style', '!=', 'plain'),
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
					'name' => 'icon-icon_desktop',
					'size' => 'small',
					'style' => 'plain',
					'color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
				),
			)
		),
	);
	tatsu_remap_modules(array('tatsu_icon', 'icon'), $controls, 'tatsu_icon');
	tatsu_register_header_module('tatsu_icon', $controls, 'tatsu_header_icon');
}
?>