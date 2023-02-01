<?php
if (!function_exists('tatsu_gradient_icon')) {
	function tatsu_gradient_icon( $atts, $content, $tag ) {
		$atts = (shortcode_atts(array(
			'name' => '',
			'size'=> 'medium',
			'custom_bg_size' => '',
			'custom_icon_size' => '',
			'style'=> 'square',
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
			'key' => be_uniqid_base36(true),
		),$atts, $tag));
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$data_animations = be_get_animation_data_atts( $atts );
	
        $mfp_class = '';
        $transparent_bg = '';
		$output = '';
		$hover_effect_parent = $alignment === 'none' && 'none' !== $hover_effect ? $hover_effect : '';
		$hover_effect_child = $alignment !== 'none' && 'none' !== $hover_effect ? $hover_effect : '';
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '' ;
		$new_tab = ( isset( $new_tab ) && 1 == $new_tab ) ? 'target="_blank"' : '' ;
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
        
        if( empty( $bg_color ) || empty( $hover_bg_color ) ) {
            $transparent_bg = 'transparent-bg';
		}
		
		//GDPR Privacy preference popup logic
		$gdpr_atts = '{}';
		$gdpr_concern_selector = '';
		if( 1 == $lightbox && !empty( $video_url ) ){
			if( function_exists( 'be_gdpr_privacy_ok' ) ){
				$video_details = be_get_video_details( $video_url );
				if( !empty( $_COOKIE ) ){
					if( !be_gdpr_privacy_ok($video_details['source'] ) ){
						$mfp_class = 'mfp-popup';
						$href = '#gdpr-alt-lightbox-'.$key;
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
        
		$output .= 
		'<div '.$css_id.' class="tatsu-module tatsu-gradient-icon tatsu-icon-shortcode align-'.$alignment.' '.$unique_class_name.' '. $transparent_bg.' '.$hover_effect_parent.' '.$visibility_classes.' '.$css_classes.'">
				<a href="'.$href.'" class="tatsu-icon-bg tatsu-custom-icon-bg '.$size.' '.$style.' '.$animate.' '.$mfp_class.' '.$hover_effect_child.' '.$gdpr_concern_selector.'" '.$data_animations.' data-gdpr-atts='.$gdpr_atts.' '.$new_tab.'>
					<i class="tatsu-icon '.$name.' default"></i>
					<i class="tatsu-icon '.$name.' hover"></i>
				</a>
            '.$custom_style_tag.'
		</div>';    
		return $output;
	}
	add_shortcode( 'tatsu_gradient_icon', 'tatsu_gradient_icon' );
}
add_filter( 'tatsu_gradient_icon_before_css_generation', 'tatsu_gradient_icon_css' );
function tatsu_gradient_icon_css( $atts ) {
	if( empty( $atts['hover_color'] ) ) {
		$atts['hover_color'] = $atts['color'];
	}
	return $atts;
}


add_action('tatsu_register_modules', 'tatsu_register_gradient_icon_module', 5);
function tatsu_register_gradient_icon_module()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#icon',
		'title' => esc_html__('Gradient Icon', 'tatsu'),
		'is_js_dependant' => false,
		'inline' => true,
		'type' => 'single',
		'is_built_in' => true,
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
							'name',
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
								'active' => 'all',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Style and Alignment', 'tatsu'),
										'group' => array(
											'size',
											'style',
											'custom_icon_size',
											'custom_bg_size',
											'alignment',
											'border_width',
										)
									),
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
														)
													),
													array(
														'type'	=>	'tab',
														'title'	=>	esc_html__('Hover', 'tatsu'),
														'group'	=>	array(
															'hover_bg_color',
															'hover_color',
															'hover_border_color',
														)
													),
												)
											),
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
							)
						),
					),
					array(
						'type'	=>	'tab',
						'title'	=>	esc_html__('Advanced', 'tatsu'),
						'group'	=>	array(
							array(
								'type' => 'accordion',
								'active' => '',
								'group' => array(
									array(
										'type'	=>	'panel',
										'title'	=>	esc_html__('Spacing', 'tatsu'),
										'group'	=>	array(
											'margin',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Shadow', 'tatsu'),
										'group' => array(
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
											'hover_effect',
											'animate',
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
				'att_name' => 'name',
				'type' => 'icon_picker',
				'label' => esc_html__('Icon', 'tatsu'),
				'default' => '',
				'tooltip' => ''
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
					'custom' => 'Custom',
				),
				'default' => 'small',
				'tooltip' => ''
			),
			array(
				'att_name' => 'custom_bg_size',
				'type' => 'slider',
				'label' => esc_html__('Icon Wrapper Size', 'tatsu'),
				'options' => array(
					'min' => 20,
					'max' => 500,
					'step' => 1,
					'unit' => 'px',
					'add_unit_to_value' => true
				),
				'visible' => array('size', '=', 'custom'),
				'default' => '200',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon-bg' => array(
						'property' => 'height',
						'when' => array(
							array('size', '=', 'custom'),
							array('style', '!=', 'plain'),
						),
						'relation' => 'and',
					),
					'.tatsu-{UUID} .tatsu-custom-icon-bg' => array(
						'property' => 'width',
						'when' => array(
							array('size', '=', 'custom'),
							array('style', '!=', 'plain'),
						),
						'relation' => 'and',
					),
				),
			),
			array(
				'att_name' => 'custom_icon_size',
				'type' => 'slider',
				'label' => esc_html__('Icon Size', 'tatsu'),
				'options' => array(
					'min' => 5,
					'max' => 500,
					'step' => 1,
					'unit' => 'px',
					'add_unit_to_value' => true
				),
				'visible' => array('size', '=', 'custom'),
				'default' => '100',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon.hover' => array(
						'property' => 'font-size',
						'when' => array('size', '=', 'custom'),
					),
					'.tatsu-{UUID} .tatsu-icon.default' => array(
						'property' => 'font-size',
						'when' => array('size', '=', 'custom'),
					),
					'.tatsu-{UUID} .tatsu-icon-bg' => array(
						'property' => 'height',
						'when' => array(
							array('size', '=', 'custom'),
							array('style', '=', 'plain'),
						),
						'relation' => 'and',
					),
					'.tatsu-{UUID} .tatsu-custom-icon-bg' => array(
						'property' => 'width',
						'when' => array(
							array('size', '=', 'custom'),
							array('style', '=', 'plain'),
						),
						'relation' => 'and',
					),

				),
			),
			array(
				'att_name' => 'style',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Style', 'tatsu'),
				'options' => array(
					'plain' => 'Plain',
					'square' => 'Square',
				),
				'default' => 'square',
				'tooltip' => ''
			),
			array(
				'att_name' => 'bg_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array('style', '!=', 'plain'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon-bg:after' => array(
						'property' => 'background-color',
						'when' => array('style', '!=', 'plain'),
					),
				),
			),
			array(
				'att_name' => 'hover_bg_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Hover Background Color', 'tatsu'),
				'default' => '', //color_scheme
				'tooltip' => '',
				'visible' => array('style', '!=', 'plain'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon-bg:before' => array(
						'property' => 'background-color',
						'when' => array('style', '!=', 'plain'),
					),
				),
			),
			array(
				'att_name' => 'color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Icon Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon.default' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'hover_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Hover Icon Color', 'tatsu'),
				'default' => '', //alt_bg_text_color
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon.hover' => array(
						'property' => 'color',
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
			array (
				'att_name' => 'outer_border_color',
				'type' => 'color',
				'label' => esc_html__( 'Border Color', 'tatsu' ),
				'default' => '',
				'exclude' => array( 'tatsu_image', 'tatsu_lists', 'tatsu_call_to_action', 'tatsu_icon'),
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
				'att_name' => 'border_width',
				'type' => 'number',
				'is_inline' => true,
				'label' => esc_html__('Border Width', 'tatsu'),
				'options' => array(
					'unit' => 'px',
				),
				'default' => '',
				'tooltip' => '',
				'visible' => array('style', '!=', 'plain'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon-bg:after, .tatsu-{UUID} .tatsu-icon-bg:before' => array(
						'property' => 'border-width',
						'when' => array('style', '!=', 'plain'),
						'append' => 'px',
					),
				),
			),
			array(
				'att_name' => 'border_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Border Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array('style', '!=', 'plain'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon-bg:after' => array(
						'property' => 'border-color',
						'when' => array('border_width', '!=', '0px'),
					),
				),
			),
			array(
				'att_name' => 'hover_border_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Hover Border Color', 'tatsu'),
				'default' => '', //color_scheme
				'tooltip' => '',
				'visible' => array('style', '!=', 'plain'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon-bg:before' => array(
						'property' => 'border-color',
						'when' => array('border_width', '!=', '0px'),
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
				'att_name' => 'animate',
				'type' => 'switch',
				'label' => esc_html__('Enable CSS Animation', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
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
					'.tatsu-{UUID}.tatsu-gradient-icon' => array(
						'property' => 'margin',
						'when' => array('margin', '!=', array('d' => '0px 0px 20px 0px')),
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
					'.tatsu-{UUID} .tatsu-icon-bg' => array(
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
					'.tatsu-{UUID} .tatsu-icon-bg:hover' => array(
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
					'size' => 'medium',
					'style' => 'plain',
					'color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
				),
			)
		),
	);
	tatsu_register_module('tatsu_gradient_icon', $controls);
}
?>