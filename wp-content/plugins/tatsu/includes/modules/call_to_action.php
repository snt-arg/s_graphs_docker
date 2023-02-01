<?php
if ( ! function_exists( 'tatsu_call_to_action' ) ) {
	function tatsu_call_to_action( $atts, $content, $tag ) {
		$atts = shortcode_atts( array(
			'field_type' => 'default',
			'bg_color'=> '',
			'title' => '',
			'h_tag' => 'h5',
			'title_color' => '',
			'button_text'=>'Click Here',
			'button_link'=> '',			
			'new_tab'=> 'no',
			'button_bg_color'=> '',
			'hover_bg_color'=> '',
			'color'=> '',
			'hover_color'=> '',
			'border_width' => 0, // button border			
			'border_color'=> '', // button border color,
			'hover_border_color'=> '',
			'lightbox' => 0,
			'image' => '',
			'video_url' => '',
			'animate'=> 0,
			'animation_type'=> 'fadeIn',
			'box_shadow' => '',
			'margin' => '',
			'outer_border_color' => '',
			'key' => be_uniqid_base36(true),
	    ), $atts, $tag );


		$output = '';
		$mfp_class = '';

		extract( $atts );

		if ( 'default' !== $field_type && '' !== $field_type ) {
			$title = tatsu_parse_custom_fields( $field_type );
		}
		$button_text = tatsu_parse_custom_fields( $button_text );
		$button_link = tatsu_parse_custom_fields( $button_link );
		$video_url = tatsu_parse_custom_fields( $video_url );

		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '' ;
		$data_animations = be_get_animation_data_atts( $atts );
		$new_tab = ( isset( $new_tab ) && 1 == $new_tab ) ? 'target="_blank"' : '' ;

		if( $lightbox && 1 == $lightbox ) {
			if( !empty( $video_url ) ) {
				$mfp_class = 'mfp-iframe';
				$button_link = $video_url;
			} elseif ( !empty($image) ) {
				$mfp_class = 'mfp-image';
				$button_link = $image;
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
						$button_link = '#gdpr-alt-lightbox-'.$key;
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

		 
		$output .= '<div '.$css_id.' class="tatsu-module tatsu-call-to-action tatsu-clearfix '.$animate.' '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'>';
		$output .= '<div class="tatsu-cta-inner">';
		$output .= '<'.$h_tag.' class="tatsu-action-content" >'.$title.'</'.$h_tag.'>';
		$output .= ( !empty( $button_link )  ) ? '<a class="mediumbtn tatsu-button rounded tatsu-action-button '.$mfp_class.' '. $gdpr_concern_selector .' " href="'.$button_link.'" data-gdpr-atts='.$gdpr_atts.' '.$new_tab.'><span>'.$button_text.'</span></a>' : '' ;
		$output .= $custom_style_tag;
		$output .= '</div>';
		$output .= '</div>';
		return $output;	
	}
	add_shortcode( 'tatsu_call_to_action', 'tatsu_call_to_action' );
	add_shortcode( 'call_to_action', 'tatsu_call_to_action' );
}

add_filter( 'tatsu_call_to_action_before_css_generation', 'tatsu_call_to_action_css' );
function tatsu_call_to_action_css( $atts ) {
	if( empty( $atts['border_color'] ) ) {
		$atts['border_color'] = 'transparent';
	}
	return $atts;
}

add_action('tatsu_register_modules', 'tatsu_register_call_to_action', 9);
function tatsu_register_call_to_action()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#call_to_action',
		'title' => esc_html__('Call to Action', 'tatsu'),
		'is_js_dependant' => false,
		'type' => 'single',
		'is_built_in' => true,
		'hint' => 'title',
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
							'field_type',
							'title',
							'button_text',
							'button_link',
							'new_tab',
							'lightbox',
						)
					),

					//Tab2
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
										'title' => esc_html__('Title', 'tatsu'),
										'group' => array(
											'h_tag',
											'bg_color',
											'title_color',
										)
									),

									array( //color accordion
										'type'		=> 'panel',
										'title'		=> esc_html__('Button', 'tatsu'),
										'group'		=> array(
											array(
												'type'  	=> 'tabs',
												'style'		=> 'style1',
												'group'		=> array(
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Normal', 'tatsu'),
														'group'		=> array(
															'button_bg_color',
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
											'border_width',
										),
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
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__( 'Border', 'tatsu' ),
										'group' => array(
											'border',
											'outer_border_color',
										)
									)
								)
							)
						)
					)
				)
			)
		),

		'atts' => array(
			array(
				'att_name' => 'bg_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Background Color', 'tatsu'),
				'default' => '', //color_scheme
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-call-to-action' => array(
						'property' => 'background-color',
					),
				),
			),
			array(
				'att_name' => 'field_type',
				'type' => 'select',
				'label' => esc_html__('Field Type', 'tatsu'),
				'options' => tatsu_get_custom_fields_dropdown(),
				'default' => 'default',
				'tooltip' => '',
				'is_inline' => !is_tatsu_pro_active()
			),
			array(
				'att_name' => 'title',
				'type' => 'text_area',
				'label' => esc_html__('Title', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible'		=> array(
					'condition' => array(
						array( 'field_type', '=', '' ),
						array( 'field_type', '=', 'default' )
					),
					'relation'	=> 'or',
				),
			),
			array(
				'att_name' => 'h_tag',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Tag', 'tatsu'),
				'options' => array(
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
			array(
				'att_name' => 'title_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Title Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-action-content' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'button_text',
				'type' => 'text',
				'label' => esc_html__('Button Text', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'is_inline' => false,
			),
			array(
				'att_name' => 'button_link',
				'type' => 'text',
				'label' => esc_html__('Link URL', 'tatsu'),
				'options' => array(
					'placeholder' => 'https://example.com',
				),
				'is_inline' => false,
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'new_tab',
				'type' => 'switch',
				'label' => esc_html__('Open Link in New Tab', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
				'visible' => array('button_link', '!=', ''),
			),
			array(
				'att_name' => 'button_bg_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Button Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-action-button' => array(
						'property' => 'background',
						'when' => array(
							array('button_bg_color', 'notempty'),
							array('button_link', 'notempty')
						),
						'relation' => 'and',
					),
				),
			),
			array(
				'att_name' => 'hover_bg_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Button Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-action-button:hover' => array(
						'property' => 'background',
						'when' => array(
							array('hover_bg_color', 'notempty'),
							array('button_link', 'notempty')
						),
						'relation' => 'and',
					),
				),
			),
			array(
				'att_name' => 'color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Button Text Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-action-button span' => array(
						'property' => 'color',
						'when' => array(
							array('color', 'notempty'),
							array('button_link', 'notempty')
						),
						'relation' => 'and',
					),
				),
			),
			array(
				'att_name' => 'hover_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Button Text Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-action-button:hover span' => array(
						'property' => 'color',
						'when' => array(
							array('hover_color', 'notempty'),
							array('button_link', 'notempty')
						),
						'relation' => 'and',
					),
				),
			),
			array(
				'att_name' => 'border_width',
				'type' => 'number',
				'label' => esc_html__('Button Border Size', 'tatsu'),
				'options' => array(
					'unit' => 'px',
				),
				'default' => '1',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-action-button' => array(
						'property' => 'border-width',
						'when' => array(
							array('border_width', 'notempty'),
							array('button_link', 'notempty')
						),
						'relation' => 'and',
						'append' => 'px'
					),
				),
				'is_inline' => true,
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
				'visible' => array('border_width', '>', '0'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-action-button' => array(
						'property' => 'border-color',
						'when' => array(
							array('border_color', 'notempty'),
							array('button_link', 'notempty')
						),
						'relation' => 'and',
					),
				),
			),
			array(
				'att_name' => 'hover_border_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Border Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array('border_width', '>', '0'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-action-button:hover' => array(
						'property' => 'border-color',
						'when' => array(
							array('hover_border_color', 'notempty'),
							array('button_link', 'notempty')
						),
						'relation' => 'and',
					),
				),
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
				'att_name' => 'border',
				'type' => 'input_group',
				'label' => esc_html__('Border', 'tatsu'),
				'default' => '0px 0px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-call-to-action' => array(
						'property' => 'border-width',
						'when' => array('border', '!=', array('d' => '0px 0px 0px 0px')),
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
					'.tatsu-{UUID}.tatsu-call-to-action' => array(
						'property' => 'border-color',
						'when' => array('border', '!=', array('d' => '0px 0px 0px 0px')),
					),
				),
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'bg_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'title' => 'Have a project ? Call us Now ',
					'h_tag' => 'h5',
					'title_color' => array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
					'button_text' => 'Get In Touch',
					'button_link' => '#',
					'hover_bg_color' => array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
					'color' => array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
					'hover_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'border_width' => '1',
					'border_color' => array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
					'hover_border_color' => array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
				),
			)
		),
	);
	tatsu_remap_modules(array('tatsu_call_to_action', 'call_to_action'), $controls, 'tatsu_call_to_action');
}

?>