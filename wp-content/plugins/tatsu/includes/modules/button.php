<?php
if (!function_exists('tatsu_button')) {
	function tatsu_button( $atts, $content, $tag ) {
		$atts = ( shortcode_atts( array (
			'button_text' => '',
			'icon' => 'none',
			'icon_alignment' => '',
			'url' => '',
			'new_tab'=> 'no',
			'type' => 'small',
			'alignment' => '',							 
			'bg_color' => '',
			'hover_bg_color' => '',
			'color'=> '',
			'hover_color'=> '',
			'border_width' => 0,			
			'border_color'=> '',
			'hover_border_color'=> '',
			'button_style' => 'none',
			'lightbox' => 0,	
			'image' => '',
			'video_url' => '',
			'background_animation' => 'none',
			'animate' => 0,
			'animation_type' => 'fadeIn',
			'animation_delay' => 0,
			'enable_box_shadow' => 0,
			'box_shadow' => '',
			'typography' => '',
			'enable_margin' => 'null',
			'margin' => '',
			'hover_effect' => '',
			'hover_box_shadow' => '',
			'builder_mode' => '',
			'light_color' => '#f5f5f5',
			'light_bg_color' => 'rgba(255,255,255,0.2)',
			'light_border_color' => '#f5f5f5',
			'light_hover_color' => '',
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
			'outer_border_color' => '',
		), $atts, $tag ) );
		
		extract( $atts );

		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key , $builder_mode );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '';  		
		$data_animations = be_get_animation_data_atts( $atts );
		$mfp_class = '';
		$output = '';
		$new_tab = ( isset( $new_tab ) && 1 == $new_tab ) ? 'target="_blank"' : '' ;
		
		$background_animation = ( !empty( $background_animation ) && 'none' != $background_animation ) ? $background_animation : 'bg-animation-none';

		$alignment = ( "block" === $type ) ? 'center' : $alignment;
		if( isset( $alignment ) ){
			if( $alignment != 'none' ){
				$alignment = 'align-block block-'.$alignment;
			} else {
				$alignment = '';
			}
		}
		
		$button_style = ( isset( $button_style ) && !empty( $button_style ) ) ? $button_style : '';

		$hover_effect = !empty( $hover_effect ) && 'none' !== $hover_effect ? $hover_effect : '';
		
		$url = ( empty( $url ) ) ? '#' : tatsu_parse_custom_fields( $url );
		$video_url = tatsu_parse_custom_fields( $video_url );
		
		$image_wrap_class = '';

		if( $lightbox && 1 == $lightbox ) {
			if( !empty( $video_url ) ) {
				$mfp_class = 'mfp-iframe';
				$url = $video_url;
			} elseif ( !empty($image) ) {
				$mfp_class = 'mfp-image';
				$url = $image;
			}
		}
		
		if( 'none' === $button_style ) {
			$button_style = '';
		}

		$bg_color = !empty( $bg_color[1] )? be_compute_color( $bg_color )[1] : 'transparent';

		$hover_bg_color = be_compute_color( $hover_bg_color );
		$hover_bg_color = !empty( $hover_bg_color[1] )? $hover_bg_color[1] : 'transparent';

		$bg_animation_css = '';
		if($background_animation != 'bg-animation-none') {
			if($background_animation == 'bg-animation-slide-top' || $background_animation == 'bg-animation-slide-bottom') {
				$bg_animation_css = 'background-image: linear-gradient(to bottom, '.$bg_color.' 50%, '.$hover_bg_color.' 50%);';
			}
			if($background_animation == 'bg-animation-slide-left' || $background_animation == 'bg-animation-slide-right') {
				$bg_animation_css = 'background-image: linear-gradient(to right, '.$bg_color.' 50%, '.$hover_bg_color.' 50%);';
			}
		}

		//GDPR Privacy preference popup logic
		$gdpr_atts = '{}';
		$gdpr_concern_selector = '';
		if( $mfp_class === 'mfp-iframe' ){
			if( function_exists( 'be_gdpr_privacy_ok' ) ){
				$video_details =  be_get_video_details($video_url);
				if( !empty( $_COOKIE ) ){
					if( !be_gdpr_privacy_ok($video_details['source'] ) ){
						$mfp_class = 'mfp-popup';
						$url = '#gdpr-alt-lightbox-'.$key;
						$output .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
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
					$output .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
				}
			}
		}
		
		$icon = ( isset($icon) && !empty($icon) && ($icon != 'none') ) ? '<i class="tatsu-icon '.$icon.'"></i>' : '' ;
		$icon_alignment = ( isset($icon_alignment) && !empty($icon_alignment) ) ? $icon_alignment : 'left' ;
		$button_text_label = tatsu_parse_custom_fields( $button_text );
		$button_text = tatsu_parse_custom_fields( $button_text );
		$button_text = ( $icon_alignment == 'right' ) ? $button_text . $icon : $icon . $button_text;

		$output .= '<div '.$css_id.' class="tatsu-module tatsu-normal-button tatsu-button-wrap '.$alignment.' '.$image_wrap_class.' '.$unique_class_name.' '.$hover_effect.' '.$visibility_classes.' '.$css_classes.'">';
		$output .= '<a class="tatsu-shortcode '.$type.'btn tatsu-button '.$icon_alignment.'-icon '.$button_style.' '.$animate.' '.$mfp_class.' '.$background_animation.' ' . $gdpr_concern_selector .' " href="'.$url.'" style= "'.$bg_animation_css.'" '.$data_animations.' aria-label="'.$button_text_label.'" data-gdpr-atts='.$gdpr_atts.' '.$new_tab.'>'.$button_text.'</a>' ; 
		$output .= $custom_style_tag;
		$output .= '</div>'; 
		return $output;
	}
	add_shortcode( 'tatsu_button', 'tatsu_button' );
	add_shortcode( 'button', 'tatsu_button' );
}

if( !function_exists( 'tatsu_button_remove_atts' ) ){
	function tatsu_button_remove_atts( $atts ){
		if( array_key_exists('enable_margin', $atts) && $atts['enable_margin'] == '0' ){
			if( $atts['alignment'] === 'none' ){
				$atts['margin'] = '{"d":"0px 0px 10px 0px"}';
			} else {
				$atts['margin'] = '{"d":"0px 0px 40px 0px"}';
			}
		}
		return $atts;
	}

	add_filter('tatsu_button_before_css_generation', 'tatsu_button_remove_atts');
}

if( !function_exists( 'tatsu_button_header_atts' ) ) {
	function tatsu_button_header_atts( $atts, $tag ) {
		if( 'tatsu_button' === $tag ) {
			// New Atts
			$atts['builder_mode'] = 	array (
				'type' => '',
				'default' => 'Header',
			);
				// Light Scheme Colors
			$atts['light_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Text Color', 'tatsu' ),
				'default' => '#f5f5f5', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['light_bg_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Background Color', 'tatsu' ),
				'default' => 'rgba(255,255,255,0.2)', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button' => array(
						'property' => 'background-color',
						'when' => array( 'bg_color', '!=', '' )
					),
				),
			);
			
			$atts['light_border_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Border Color', 'tatsu' ),
				'default' => '#f5f5f5', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button' => array(
						'property' => 'border-color',
						'when' => array( 'border_width', '!=', '0px' ),
					),
				),
			);
			
			$atts['light_hover_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Hover Text Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:hover' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['light_hover_bg_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Hover Background Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:hover' => array(
						'property' => 'background-color',
						'when' => array( 'bg_color', '!=', '' )
					),
				),
			);
			
			$atts['light_hover_border_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Hover Border Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:hover' => array(
						'property' => 'border-color',
						'when' => array( 'border_width', '!=', '0px' ),
					),
				),
			);
				// Dark Scheme Colors
			$atts['dark_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Text Color', 'tatsu' ),
				'default' => '#232425', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['dark_bg_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Background Color', 'tatsu' ),
				'default' => 'rgba(255,255,255,0.2)', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button' => array(
						'property' => 'background-color',
						'when' => array( 'bg_color', '!=', '' )
					),
				),
			);
			
			$atts['dark_border_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Border Color', 'tatsu' ),
				'default' => '#232425', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button' => array(
						'property' => 'border-color',
						'when' => array( 'border_width', '!=', '0px' ),
					),
				),
			);
			
			$atts['dark_hover_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Hover Text Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:hover' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['dark_hover_bg_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Hover Background Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:hover' => array(
						'property' => 'background-color',
						'when' => array( 'bg_color', '!=', '' )
					),
				),
			);
			
			$atts['dark_hover_border_color'] = array (
				'type' => 'color',
				'label' => esc_html__( 'Hover Border Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:hover' => array(
						'property' => 'border-color',
						'when' => array( 'border_width', '!=', '0px' ),
					),
				),
			);
			// Modify Atts
			$atts['margin'] = 	array (
				'type' => 'input_group',
				'label' => esc_html__( 'Margin', 'tatsu' ),
				'default' => '0px 30px 0px 0px',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-normal-button' => array(
						'property' => 'margin',
					)
				),
			);
			// Remove Atts
			unset( $atts['enable_margin'] );
			unset( $atts['alignment'] );
			unset( $atts['background_animation'] );
		}
		return $atts;
	}
	add_filter( 'tatsu_header_modify_atts', 'tatsu_button_header_atts', 10, 2 );
}


add_action('tatsu_register_modules', 'tatsu_register_button', 3);
add_action('tatsu_register_header_modules', 'tatsu_register_button', 9);
function tatsu_register_button()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#button',
		'title' => esc_html__('Button', 'tatsu'),
		'is_js_dependant' => false,
		'hint'	=> 'button_text',
		'child_module' => '',
		'inline' => true,
		'type' => 'single',
		'is_built_in' => true,
		'is_dynamic' => true,
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
                            'button_text',
                            'icon',
							'url',
							'new_tab',
							'lightbox',
							'image',
							'video_url',
						)
					),
					//Tab2
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => array(0, 1, 2),
								'group' => array(
									array( //Shape and Size Accordion
										'type' => 'panel',
										'title' => esc_html__('Style and Alignment', 'tatsu'),
										'group'		=> array(
											'type',
											'button_style',
                                            'alignment',
                                            'icon_alignment',
										),
									),
									'border_width', //button's border property
									array( //color accordion
										'type'		=> 'panel',
										'title'		=> esc_html__('Colors', 'tatsu'),
										'group'		=> array(
											array(
												'type'  	=> 'tabs',
												'style'		=> 'style1',
												'group'		=> array(
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Normal', 'tatsu'),
														'group'		=> array(
															'bg_color',
															'color',
															'border_color',
														),
													),
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Hover', 'tatsu'),
														'group'		=> array(
															'hover_bg_color',
															'hover_color',
															'hover_border_color',
														),
													),
												),
											),
										),
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Light Scheme Colors', 'tatsu'),
										'group' => array(
											array(
												'type'  	=> 'tabs',
												'style'		=> 'style1',
												'group'		=> array(
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Normal', 'tatsu'),
														'group'		=> array(
															'light_bg_color',
															'light_color',
															'light_border_color',
														),
													),
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Hover', 'tatsu'),
														'group'		=> array(
															'light_hover_bg_color',
															'light_hover_color',
															'light_hover_border_color'
														),
													),
												),
											),
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Dark Scheme Colors', 'tatsu'),
										'group' => array(
											array(
												'type'  	=> 'tabs',
												'style'		=> 'style1',
												'group'		=> array(
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Normal', 'tatsu'),
														'group'		=> array(
															'dark_bg_color',
															'dark_color',
															'dark_border_color',
														),
													),
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Hover', 'tatsu'),
														'group'		=> array(
															'dark_hover_bg_color',
															'dark_hover_color',
															'dark_hover_border_color'
														),
													),
												),
											),
										)
									),
								)
							),
						)
					),

					array( //Tab3
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
										'title' => esc_html__('Border', 'tatsu'),
										'group' => array(
											'border_style',
											'border',
											'outer_border_color',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Animation', 'tatsu'),
										'group' => array(
											'background_animation',
											'hover_effect',
										)
									),
									array(  //Shadow accordion
										'type' => 'panel',
										'title' => esc_html__('Shadow', 'tatsu'),
										'group' => array(
											array(
												'type'  	=> 'tabs',
												'style'		=> 'style1',
												'group'		=> array(
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Normal', 'tatsu'),
														'group'		=> array(
															'box_shadow',

														),
													),
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Hover', 'tatsu'),
														'group'		=> array(
															'hover_box_shadow',
														),
													),
												),
											)
										),
									),
								)
							)
						)
					)
				)
			)
		),
		'atts' => array(
			array(
				'att_name' => 'button_text',
				'type' => 'text',
				'label' => esc_html__('Text', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'url',
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
				'label' => esc_html__('Open in a new tab', 'tatsu'),
				'default' => '0',
				'tooltip' => '',
				'visible' => array('url', '!=', ''),
			),
			array(
				'att_name' => 'type',
				'is_inline' => true,
				'type' => 'button_group',
				'label' => esc_html__('Size', 'tatsu'),
				'options' => array(
					'small' => 'S',
					'medium' => 'M',
					'large' => 'L',
					'x-large' => 'XL',
					'block' => 'Block',
				),
				'default' => 'medium',
				'tooltip' => ''
			),
			array(
				'att_name' => 'button_style',
				'is_inline' => true,
				'type' => 'button_group',
				'label' => esc_html__('Shape', 'tatsu'),
				'options' => array(
					'none' => 'Rectangular',
					'rounded' => 'Rounded',
					'circular' => 'Pill'
				),
				'default' => 'none',
				'tooltip' => ''
			),
			array(
				'att_name' => 'alignment',
				'is_inline' => true,
				'type' => 'button_group',
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
				'att_name' => 'bg_color',
				'type' => 'color',
				'label' => esc_html__('Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-button' => array(
						'property' => 'background-color',
						'when' => array(
							array('background_animation', '!=', 'bg-animation-slide-left'), // set this way to overcome a wierd issue where the bg animation value of none was set differently for some buttons
							array('background_animation', '!=', 'bg-animation-slide-right'),
							array('background_animation', '!=', 'bg-animation-slide-top'),
							array('background_animation', '!=', 'bg-animation-slide-bottom'),
						),
						'relation' => 'and'
					),
				),
			),
			array(
				'att_name' => 'hover_bg_color',
				'type' => 'color',
				'label' => esc_html__('Hover Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-button:hover' => array(
						'property' => 'background-color',
						'when' => array(
							array('background_animation', '!=', 'bg-animation-slide-left'),
							array('background_animation', '!=', 'bg-animation-slide-right'),
							array('background_animation', '!=', 'bg-animation-slide-top'),
							array('background_animation', '!=', 'bg-animation-slide-bottom'),
						),
						'relation' => 'and'
					),
				),
			),
			array(
				'att_name' => 'color',
				'type' => 'color',
				'label' => esc_html__('Text Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-button' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'hover_color',
				'type' => 'color',
				'label' => esc_html__('Hover Text Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-button:hover' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'border_width',
				'type' => 'number',
				'is_inline' => true,
				'label' => esc_html__('Border Size', 'tatsu'),
				'options' => array(
					'unit' => 'px',
					'add_unit_to_value' => false,
				),
				'default' => '0',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-button' => array(
						'property' => 'border-width',
						'when' => array('border_width', '!=', '0px'),
						'append' => 'px',
					),
				),
			),
			array(
				'att_name' => 'border_color',
				'type' => 'color',
				'label' => esc_html__('Border Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-button' => array(
						'property' => 'border-color',
						'when' => array('border_width', '!=', '0px'),
					),
				),
			),
			array(
				'att_name' => 'hover_border_color',
				'type' => 'color',
				'label' => esc_html__('Hover Border Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-button:hover' => array(
						'property' => 'border-color',
						'when' => array('border_width', '!=', '0px'),
					),
				),
			),
			array(
				'att_name' => 'icon',
				'type' => 'icon_picker',
				'label' => esc_html__('Icon', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
                'att_name' => 'icon_alignment',
                'is_inline' => true,
				'type' => 'button_group',
				'label' => esc_html__('Icon Alignment', 'tatsu'),
				'options' => array(
					'left' => 'Left',
					'right' => 'Right',
				),
				'default' => 'left',
				'tooltip' => '',
				'visible' => array('icon', '!=', ''),
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
				'label' => esc_html__('Background Image', 'tatsu'),
				'default' => '',
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
				'is_inline' => true,
				'type' => 'button_group',
				'label' => esc_html__('Hover Effect', 'tatsu'),
				'options' => array(
					'none' => 'None',
					'button-transform' => 'Slide up',
					'button-scale' => 'Scale'
				),
				'default' => 'none',
				'tooltip' => ''
			),
			array(
				'att_name' => 'background_animation',
				'type' => 'select',
				'label' => esc_html__('Background Animation', 'tatsu'),
				'options' => array(
					'none' => 'None',
					'bg-animation-slide-left' => 'Slide Left',
					'bg-animation-slide-right' => 'Slide Right',
					'bg-animation-slide-top' => 'Slide Top',
					'bg-animation-slide-bottom' => 'Slide Bottom',
				),
				'default' => 'none',
				'tooltip' => ''
			),
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,   // in js attsfromdisplay device is empty
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-button-wrap' => array(
						'property' => 'margin',
						'when' => array(
							array('alignment', '=', 'none'),
							array('margin', '!=', '0px 0px 10px 0px'),
						),
						'relation' => 'and',
					),
					'.tatsu-{UUID}.tatsu-normal-button' => array(
						'property' => 'margin',
						'when' => array(
							array('alignment', '!=', 'none'),
							array('margin', '!=', '0px 0px 40px 0px'),
						),
						'relation' => 'and',
					)
				),
			),
			array(
				'att_name' => 'box_shadow',
				'type' => 'input_box_shadow',
				'label' => esc_html__('Shadow', 'tatsu'),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-button' => array(
						'property' => 'box-shadow',
						'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
					),
				),
			),
			array(
				'att_name' => 'hover_box_shadow',
				'type' => 'input_box_shadow',
				'label' => esc_html__('Shadow on hover', 'tatsu'),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-button:hover' => array(
						'property' => 'box-shadow',
						'when' => array('hover_box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
					),
				),
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
					'.tatsu-{UUID}' => array(
						'property' => 'border-style',
						'when' => array(
							array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', 'notempty' ),
							array( 'border_style', '!=',  array( 'd' => 'none' ) ),
						),
						'relation' => 'and',            
					),
				),
			),
			array (
				'att_name' => 'border',
				'type' => 'input_group',
				'label' => esc_html__( 'Border Width', 'tatsu' ),
				'default' => '0px 0px 0px 0px',
				'exclude' => array( 'tatsu_image', 'tatsu_lists' ),
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'border-width',
						'when' => array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
					),
				),
			),
			array(
				'att_name' => 'outer_border_color',
				'type' => 'color',
				'label' => esc_html__('Border Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'border-color',
						'when' => array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
					),
				),
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'button_text' => 'Click Here',
					'bg_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'color' => array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
					'button_style' => 'circular',
				),
			)
		),
	);
	tatsu_remap_modules(array('tatsu_button', 'button'), $controls, 'tatsu_button');
	tatsu_register_header_module('tatsu_button', $controls, 'tatsu_header_button');
}


?>