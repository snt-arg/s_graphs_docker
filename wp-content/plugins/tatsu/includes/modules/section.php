<?php
if (!function_exists('tatsu_section')) {
	function tatsu_section( $atts, $content, $tag ) {
		$atts = shortcode_atts( array(
	        'bg_color' => '',
	        'bg_image' => '',
	        'bg_repeat' => 'repeat',
	        'bg_attachment' => 'scroll',
	        'bg_position' => 'left top',
	        'bg_size' => 'initial',
			'bg_animation' => 'none',
	        'border' => '0px 0px 0px 0px',
			'border_color' => '',
	        'padding' => '0px 0px 0px 0px',
	        'margin' => '0px 0px 0px 0px',
	        'offset_section' => 'null',
			'offset_value' => '',
			'top_divider'				=> 'none',
			'bottom_divider'			=> 'none',
			'top_divider_height'		=> '100',
			'bottom_divider_height'		=> '100',
			'top_divider_color'			=> '#000',
			'bottom_divider_color'		=> '#000',
			'invert_top_divider'		=> '0',
			'invert_bottom_divider' 	=> '0',
			'flip_top_divider'			=> '0',
			'flip_bottom_divider'		=> '0',
			'top_divider_position'		=> 'over',
			'bottom_divider_position'	=> 'over',
			'bottom_divider_zindex'	=> '9999',
			'top_divider_zindex' => '9999',
			'video_preload' => 'auto',
	        'bg_video_mp4_src' => '',
	        'bg_video_ogg_src' => '',
	        'bg_video_webm_src' => '',
			'bg_overlay' => '',
			'overlay_color' => '',
			'overlay_blend_mode' => 'none',
			'overlay_opacity' => '',
			'section_id' => '',
			'section_class' => '',
			'section_title' => '',
			'box_shadow' => '',
			'full_screen' => 0,
			'enable_custom_height' => 'null',
			'section_height_type' => 'auto',
			'vertical_align' => 'center',
			'custom_height'		=> '',
			'overflow'			=> '0',
			'z_index'			=> '',
			'full_screen_header_scheme' => 'background--dark',
			'hide_in' => '',
			'key' => be_uniqid_base36(true),
        ), $atts, 'tatsu_section' );
		extract( $atts );
		
		$atts['z_index'] = !empty( $atts['z_index'] ) ? ( (int)$atts['z_index'] + 2 ) : false;
		$custom_style_tag = be_generate_css_from_atts($atts, 'tatsu_section', $key);
		$custom_class_name = 'tatsu-'.$key;
		$animate = ( isset( $animate ) && !empty( $animate ) && 'none' !== $animation_type ) ? 'tatsu-animate' : '';
		$data_animations = be_get_animation_data_atts( $atts );

		$bg_markup = '';
	    $bg_video_markup = '';
	    $bg_overlay_class = '';
	    $bg_overlay_markup = '';
	    $fullscreen_wrap_start = '';
		$fullscreen_wrap_end = '';
		$custom_height_wrap_start = '';
		$custom_height_wrap_end = '';
	    $fullscreen_class = '';
		$offset_section_class = '';
	    $offset_wrapper_start = '';
	    $offset_wrapper_end = '';
	    $parallax_markup = '';
	    $hover_3d_wrap_start = '';
		$hover_3d_wrap_end = '';
		$padding_top = ''; 
	    $classes = '';	    
		$output = '';
		
	    if( !isset($bg_animation) || empty($bg_animation) || $bg_animation == 'none' ) {
	    	$bg_animation = '';
	    } else if( 'tatsu-parallax' === $bg_animation ) {
	    	$classes .= ' '.$bg_animation;
		}
		
		if( 'tatsu-parallax' == $bg_animation ) {
			$bg_repeat = 'no-repeat';
			$bg_size = 'cover';
			$bg_attachment = 'scroll';
			$bg_position = 'center center';
		}  
		$original_padding = $padding;
		$padding_values = json_decode( $padding, true );
		if( is_array( $padding_values ) ) {
			$padding = !empty( $padding_values['m'] ) ? explode(' ', $padding_values['m'] ) : explode(' ', $padding_values['d'] );
		} else {
			$padding = explode( ' ', $padding );
		} 
		if( isset( $padding[0] ) ) {
			$padding_top = $padding[0];
		} 

		//background markup
		$bg_markup = '';
		$lazy_load_bg = get_option( 'tatsu_lazyload_bg', false );
		$bg_classes = 'tatsu-section-background';
		$bg_wrapper_classes = 'tatsu-section-background-wrap';
		$bg_attr = '';
		if( !empty($bg_image) && 'tatsu-parallax' === $bg_animation ) {
			$bg_classes .= ' tatsu-parallax-element';
			$bg_wrapper_classes .= ' tatsu-parallax-element-wrap';
		}
		$bg_markup .= '<div class="' . $bg_wrapper_classes . '">';
		if(!empty($lazy_load_bg)) {
			$bg_blur_class = 'tatsu-bg-blur';
			if( !empty($bg_animation) && 'tatsu-parallax' !== $bg_animation ) {
				$bg_blur_class .= ' ' . $bg_animation;
			}
			$bg_classes .= ' tatsu-bg-lazyload';
			$bg_attr = 'data-src = "' . $bg_image . '"';
			$image_data_uri = be_get_image_datauri( $bg_image, apply_filters( 'tatsu_bg_lazyload_blur_size', 'tatsu_lazyload_thumb' ), true );
			if( !empty( $image_data_uri ) ) {
				$bg_blur_style = 'style = "background-image : url(' . $image_data_uri . ');"';
				$bg_markup .= '<div class = "' . $bg_blur_class . '" ' . $bg_blur_style . '"></div>';
			}
		}
		if( !empty($bg_animation) && 'tatsu-parallax' !== $bg_animation ) {
			$bg_classes .= ' ' . $bg_animation;
		}
		$bg_markup .= '<div class = "' . $bg_classes . '" ' . $bg_attr . '></div>';
		$bg_markup .= '</div>'; //end tatsu-section-background-wrap
		
		//Handle Full Screen Section
		if( ((isset( $full_screen ) && 1 == $full_screen)) || ( isset($section_height_type) && 'full_screen' == $section_height_type ) ){
			$classes .= ' tatsu-fullscreen';
			$fullscreen_wrap_start = '<div class="tatsu-fullscreen-wrap">';
			$fullscreen_wrap_end = '</div>';
		}

		//custom height
		if( (empty( $full_screen ) &&( !empty($enable_custom_height) && $enable_custom_height !== 'null') ) || ( isset($section_height_type) && 'custom_height' == $section_height_type ) ) {
			$classes .= ' tatsu-section-custom-height';
			$custom_height_wrap_start = '<div class = "tatsu-custom-height-wrap">';
			$custom_height_wrap_end = '</div>';
		}

	    // Handle Section Offset
	    if( ( $offset_value !== '0px' && !empty( $offset_value ) ) || $offset_section == '1' ) {
	    	$classes .= ' tatsu-section-offset';
	    	$offset_wrapper_start = '<div class="tatsu-section-offset-wrap">';
	    	$offset_wrapper_end = '</div>';
	    }


	    // Handle BG Video
		if( !empty($bg_video_mp4_src) || !empty($bg_video_ogg_src) || !empty($bg_video_webm_src)  ) {
			$classes .= ' tatsu-video-section';
			$bg_video_markup .= '<video class="tatsu-bg-video" autoplay="autoplay" loop="loop" muted="muted" preload="'.$video_preload.'" playsinline webkit-playsinline>';
			$bg_video_markup .=  ($bg_video_mp4_src) ? '<source src="'.$bg_video_mp4_src.'" type="video/mp4">' : '' ;
			$bg_video_markup .=  ($bg_video_ogg_src) ? '<source src="'.$bg_video_ogg_src.'" type="video/ogg">' : '' ;
			$bg_video_markup .=  ($bg_video_webm_src) ? '<source src="'.$bg_video_webm_src.'" type="video/webm">' : '' ;
			$bg_video_markup .= '</video>';
		}

		//Handle BG Overlay
		if( (!empty($bg_overlay) ) || ( isset($overlay_blend_mode) && $overlay_blend_mode !== 'none' ) ) {
			$classes .= ' tatsu-bg-overlay';
			$bg_overlay_markup .= '<div class="tatsu-overlay tatsu-section-overlay"></div>';
		}

		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$classes .= ' tatsu-hide-'.$device;
			}
		}

		//section overflow
		if( !empty( $overflow ) ) {
			$classes .= ' tatsu-prevent-overflow';
		}

		//top shape divider
		$top_divider_html = '';
		if( !empty( $top_divider ) &&  strpos($top_divider, "none") === false) {
			$top_divider_location = TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/top/' . $top_divider .'.svg';
			$top_divider_svg = @file_get_contents( $top_divider_location );
			if( !empty( $top_divider_svg ) ) {
				$top_divider_classes = array( 'tatsu-shape-divider', 'tatsu-top-divider' );
				if( !empty( $invert_top_divider ) ) {
					$top_divider_classes[] = 'tatsu-invert-divider';
				}
				if( !empty( $flip_top_divider ) ) {
					$top_divider_classes[] = 'tatsu-flip-divider';
				}
				if( !empty( $top_divider_position ) && 'over' === $top_divider_position ) {
					$top_divider_classes[] = 'tatsu-shape-over';
				}
				$top_divider_classes = implode( ' ', $top_divider_classes );
				$top_divider_html =  '<div class = "' . $top_divider_classes . '">';
				$top_divider_html .= $top_divider_svg;
				$top_divider_html .= '</div>';
			}
		}

		//bottom shape divider
		$bottom_divider_html = '';
		if( !empty( $bottom_divider ) && strpos($bottom_divider, "none") === false ) {
			$bottom_divider_location = TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/bottom/' . $bottom_divider .'.svg';
			$bottom_divider_svg = file_get_contents( $bottom_divider_location );
			if( !empty( $bottom_divider_svg ) ) {
				$bottom_divider_classes = array( 'tatsu-shape-divider', 'tatsu-bottom-divider' );
				if( !empty( $invert_bottom_divider ) ) {
					$bottom_divider_classes[] = 'tatsu-invert-divider';
				}
				if( !empty( $flip_bottom_divider ) ) {
					$bottom_divider_classes[] = 'tatsu-flip-divider';
				}
				if( !empty( $bottom_divider_position ) && 'over' == $bottom_divider_position ) {
					$bottom_divider_classes[] = 'tatsu-shape-over';
				}
				$bottom_divider_classes = implode( ' ', $bottom_divider_classes );
				$bottom_divider_html = '<div class = "' . $bottom_divider_classes . '">';
				$bottom_divider_html .= $bottom_divider_svg;
				$bottom_divider_html .= '</div>';
			}
		}
					
		//Append to custom classes 
		$section_class = !empty($section_class) ? str_replace(',', ' ', $section_class) : '' ;
		$section_class = apply_filters( 'tatsu_section_classes', $section_class );
		$section_class = $classes.' '.$section_class;

		if( !empty( $section_id ) ) {
			$section_id = 'id="'.$section_id.'"';
		}

	    $output .= '<div '.$section_id.' class="'.$custom_class_name.' tatsu-section '.$section_class.' '.$animate.' tatsu-clearfix" data-title="'.$section_title.'" '.$data_animations.' data-headerscheme="'.$full_screen_header_scheme.'">';
		$output .= $top_divider_html;
		$output .= $fullscreen_wrap_start; 
		$output .= $custom_height_wrap_start;
		$output .= "<div class='tatsu-section-pad clearfix' data-padding='".$original_padding."' data-padding-top='".$padding_top."'>";
	    $output .= $offset_wrapper_start;	
	    $output .= do_shortcode( $content );
		$output .= $offset_wrapper_end;
		$output .= '</div>';
		$output .= $bg_markup;
		$output .= $bg_video_markup;				
		$output .= $bg_overlay_markup;		
		$output .= $custom_height_wrap_end;
		$output .= $fullscreen_wrap_end;
		$output .= $bottom_divider_html;

		$output .= $custom_style_tag;

	    $output .= '</div>';
	
		return $output;
	}
	add_shortcode( 'tatsu_section', 'tatsu_section' );
	add_shortcode( 'section', 'tatsu_section' );
}

if(!function_exists( 'tatsu_section_modify_bg_color' )) {
	function tatsu_section_modify_bg_color( $atts ) {
		$lazy_load_bg_color = get_option( 'tatsu_lazyload_bg_color', false );
		$lazy_load_bg = get_option( 'tatsu_lazyload_bg', false );
		$bg_color = $atts['bg_color'];
		$bg_image =  $atts['bg_image'];
		if(is_array($atts) && !empty($bg_image) && empty($bg_color) && !empty($lazy_load_bg) && !empty($lazy_load_bg_color)) {
			$atts['bg_color'] = $lazy_load_bg_color;
		}
		return $atts;
	}
	add_filter( 'tatsu_section_before_css_generation', 'tatsu_section_modify_bg_color' );
}

if( !function_exists( 'tatsu_section_remove_atts' ) ){
	function tatsu_section_remove_atts( $atts ){
		if( array_key_exists('enable_custom_height', $atts) && $atts['enable_custom_height'] == '0' ){
			$atts['custom_height'] = '';
		}

		if( empty( $atts['offset_section'] ) ){
			$atts['offset_value'] = '';
		}

		return $atts;
	}

	add_filter('tatsu_section_before_css_generation', 'tatsu_section_remove_atts');
}

add_action('tatsu_register_modules', 'tatsu_register_section');
function tatsu_register_section()
{

	$divider_options = tatsu_get_shape_dividers();
	$controls = array(
		'icon' => '',
		'title' => esc_html__('Section', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => 'tatsu_row',
		'type' => 'core',
		'label' => 'Section',
		'initial_children' => 1,
		'is_built_in' => true,
		'group_atts'			=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => array(0,1,2),
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Background', 'tatsu'),
										'group' => array(
											array(
												'type'		=> 'tabs',
												'style'		=> 'style2',
												'group'		=> array(
													array(
														'type' => 'tab',
														'title' => esc_html__('Color', 'tatsu'),
														'icon'		=> TATSU_PLUGIN_URL . '/builder/svg/modules.svg#modules_background_color',
														'group'	=> array(
															'bg_color',
														)
													),
													array(
														'type' => 'tab',
														'title' => esc_html__('Image', 'tatsu'),
														'icon'		=> TATSU_PLUGIN_URL . '/builder/svg/modules.svg#modules_background_image',
														'group'	=> array(
															'bg_image',
															'bg_repeat',
															'bg_attachment',
															'bg_position',
															'bg_size',
															'bg_animation',
														)
													),
													array(
														'type' => 'tab',
														'title' => esc_html__('Video', 'tatsu'),
														'icon'		=> TATSU_PLUGIN_URL . '/builder/svg/modules.svg#modules_background_video',
														'group'	=> array(
															'video_preload',
															'bg_video_mp4_src',
															'bg_video_ogg_src',
															'bg_video_webm_src',
														)
													),
												),
											),
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Overlay', 'tatsu'),
										'group' => array(
											'overlay_color',
											'overlay_blend_mode',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Section Height', 'tatsu'),
										'group' => array(
											'section_height_type',
											'custom_height',
											'vertical_align'
										)
									),
									array(
										'type'		=> 'panel',
										'title'		=> esc_html__('Shape Dividers', 'tatsu'),
										'group'		=> array(
											array(
												'type'  	=> 'tabs',
												'style'		=> 'style1',
												'group'		=> array(
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Top', 'tatsu'),
														'group'		=> array(
															'top_divider',
															'top_divider_color',
															'top_divider_height',
															'top_divider_position',
															'invert_top_divider',
															'flip_top_divider',
															'top_divider_zindex',
														),
													),
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Bottom', 'tatsu'),
														'group'		=> array(
															'bottom_divider',
															'bottom_divider_color',
															'bottom_divider_height',
															'bottom_divider_position',
															'invert_bottom_divider',
															'flip_bottom_divider',
															'bottom_divider_zindex',
														),
													),
												),
											)
										),
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Others', 'tatsu'),
										'group' => array(
											'offset_value',
											'overflow',
											'full_screen_header_scheme',
										)
									),
								)
							),
						)
					),
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => array(0),
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Spacing', 'tatsu'),
										'group' => array(
											'margin',
											'padding',
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Identifiers', 'tatsu'),
										'group' => array(
											'section_title',
											'section_id',
											'section_class',
											'section_title'
										)
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Visibility', 'tatsu'),
										'group' => array(
											'z_index'
										)
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
				'att_name' => 'bg_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-section' => array(
						'property' => 'background-color',
					),
				)
			),
			array(
				'att_name' => 'bg_image',
				'type' => 'single_image_picker',
				'label' => 'Image',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-section-background' => array(
						'property'		=> 'background-image',
					)
				)
			),
			array(
				'att_name' => 'bg_repeat',
				'type' => 'select',
				'label' => esc_html__('Repeat', 'tatsu'),
				'options' => array(
					'repeat' => 'Repeat Horizontally & Vertically',
					'repeat-x' => 'Repeat Horizontally',
					'repeat-y' => 'Repeat Vertically',
					'no-repeat' => 'Don\'t Repeat',
				),
				'default' => 'no-repeat',
				'tooltip' => '',
				'hidden' => array('bg_image', '=', ''),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-section-background' => array(
						'property' => 'background-repeat',
						'when' => array('bg_image', 'notempty'),
					),
					'.tatsu-{UUID} .tatsu-bg-blur' => array(
						'property' => 'background-repeat',
						'when' => array('bg_image', 'notempty'),
					)
				)
			),
			array(
				'att_name' => 'bg_attachment',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Attachment', 'tatsu'),
				'options' => array(
					'scroll' => 'Scroll',
					'fixed' => 'Fixed'
				),
				'default' => 'scroll',
				'tooltip' => '',
				'hidden' => array('bg_image', '=', ''),
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-section-background' => array(
						'property' => 'background-attachment',
						'when' => array('bg_image', 'notempty'),
					),
					'.tatsu-{UUID} .tatsu-bg-blur' => array(
						'property' => 'background-attachment',
						'when' => array('bg_image', 'notempty'),
					)
				)
			),
			array(
				'att_name' => 'bg_position',
				'type' => 'select',
				'label' => esc_html__('Position', 'tatsu'),
				'options' => array(
					'top left' => 'Top Left',
					'top right' => 'Top Right',
					'top center' => 'Top Center',
					'center left' => 'Center Left',
					'center right' => 'Center Right',
					'center center' => 'Center Center',
					'bottom left' => 'Bottom Left',
					'bottom right' => 'Bottom Right',
					'bottom center' => 'Bottom Center'
				),
				'default' => 'top left',
				'tooltip' => '',
				'hidden' => array('bg_image', '=', ''),
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-section-background' => array(
						'property' => 'background-position',
						'when' => array('bg_image', 'notempty'),
					),
					'.tatsu-{UUID} .tatsu-bg-blur' => array(
						'property' => 'background-position',
						'when' => array('bg_image', 'notempty'),
					)
				)
			),
			array(
				'att_name' => 'bg_size',
				'type' => 'select',
				'label' => esc_html__('Size', 'tatsu'),
				'options' => array(
					'cover' => 'Cover',
					'contain' => 'Contain',
					'initial' => 'Initial',
					'inherit' => 'Inherit'
				),
				'default' => 'cover',
				'tooltip' => '',
				'hidden' => array('bg_image', '=', ''),
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-section-background' => array(
						'property' => 'background-size',
						'when' => array('bg_image', 'notempty'),
					),
					'.tatsu-{UUID} .tatsu-bg-blur' => array(
						'property' => 'background-size',
						'when' => array('bg_image', 'notempty'),
					),
				)
			),
			array(
				'att_name' => 'bg_animation',
				'type' => 'select',
				'label' => esc_html__('Animation', 'tatsu'),
				'options' => array(
					'none' => 'None',
					'tatsu-parallax' => 'Parallax',
					'tatsu-bg-horizontal-animation' => 'Horizontal Loop Animation',
					'tatsu-bg-vertical-animation' => 'Vertical Loop Animation',
				),
				'default' => 'none',
				'tooltip' => '',
				'hidden' => array('bg_image', '=', ''),
			),
			array(
				'att_name' => 'padding',
				'type' => 'input_group',
				'label' => esc_html__('Padding', 'tatsu'),
				'default' => '90px 0px 90px 0px',
				'tooltip' => '',
				'options'	=> array(
					'unit'	=> array('px', '%', 'em'),
					'labels' => array('top', 'right', 'bottom', 'left'),
				),
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-section-pad' => array(
						'property' => 'padding',
						'when' => array('padding', '!=', array('d' => '0px 0px 0px 0px')),
					),
				)
			),
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '0px 0px 0px 0px',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'options'	=> array(
					'unit'	=> array('px', '%', 'em'),
					'labels' => array('top', 'right', 'bottom', 'left'),
				),
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-section' => array(
						'property' => 'margin',
						'when' => array('margin', '!=', array('d' => '0px 0px 0px 0px')),
					),
				),
			),
			array(
				'att_name' => 'video_preload',
				'type' => 'select',
				'label' => esc_html__('Video Preload', 'tatsu'),
				'options' => array(
					'auto' => 'Auto',
					'metadata' => 'Metadata',
					'none' => 'None',
				),
				'is_inline' => true,
				'default' => 'auto',
				'tooltip' => '',
			),
			array(
				'att_name' => 'bg_video_mp4_src',
				'type' => 'text',
				'label' => esc_html__('.MP4 Source', 'tatsu'),
				'default' => '',
			),
			array(
				'att_name' => 'bg_video_ogg_src',
				'type' => 'text',
				'label' => esc_html__('.OGG Source', 'tatsu'),
				'default' => '',
			),
			array(
				'att_name' => 'bg_video_webm_src',
				'type' => 'text',
				'label' => esc_html__('.WEBM Source', 'tatsu'),
				'default' => '',
			),
			array(
				'att_name' => 'overlay_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Overlay Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-section-overlay' => array(
						'property' => 'background',
						'when' => array(
							array('overlay_blend_mode', '!=', 'none'),
							array('bg_overlay', '=', '1'),
						),
						'relation' => 'or'
					),
				)
			),
			array(
				'att_name' => 'overlay_blend_mode',
				'type' => 'select',
				'label' => esc_html__('Blend Mode', 'tatsu'),
				'options' => tatsu_get_blend_modes(),
				'default' => 'normal',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-section-overlay' => array(
						'property' => 'mix-blend-mode',
						'when' => array('overlay_blend_mode', '!=', 'none'),
					),
				)
			),
			array(
				'att_name' => 'section_height_type',
				'type' => 'select',
				'label' => esc_html__('Height', 'tatsu'),
				'options' => array(
					'auto' => 'Auto',
					'full_screen' => 'Full Screen',
					'custom_height' => 'Custom Height'
				),
				'default' => 'auto',
				'tooltip' => '',
			),
			array(
				'att_name'		=> 'custom_height',
				'type'			=> 'number',
				'is_inline'     => true,
				'label'			=> esc_html__('Custom Height', 'tatsu'),
				'default'		=> '',
				'responsive'	=> true,
				'css'			=> true,
				'options'		=> array(
					'unit'		=> array('vh', 'px'),
				),
				'visible'		=> array('section_height_type', '=', 'custom_height'),
				'selectors'		=> array(
					'.tatsu-{UUID} .tatsu-custom-height-wrap'	=> array(
						'property'		=> 'min-height',
						'when'			=> array(
							array('section_height_type', '=', 'custom_height'),
							array('enable_custom_height', '=', '1')
						),
						'relation'		=> 'or'
					),
				),
				'tooltip'		=> '',
			),
			array(
				'att_name' => 'vertical_align',
				'type' => 'button_group',
				'label' => esc_html__('Vertical Alignment', 'tatsu'),
				'options' => array(
					'flex-start' => 'Top',
					'center' => 'Middle',
					'flex-end' => 'Bottom',
				),
				'default' => 'center',
				'tooltip' => '',
				'visible'	=> array(
					'condition'	=> array(
						array('section_height_type', '=', 'full_screen'),
						array('section_height_type', '=', 'custom_height')
					),
					'relation'	=> 'or'
				),
				'css'	=> true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-fullscreen-wrap' => array(
						'property'	=> 'align-items',
						'when'	=> array('section_height_type', '=', 'full_screen')
					),
					'.tatsu-{UUID} .tatsu-custom-height-wrap' => array(
						'property'	=> 'align-items',
						'when'	=> array('section_height_type', '=', 'custom_height')
					)
				)
			),
			array(
				'att_name'		=> 'top_divider',
				'type'			=> 'select',
				'label'			=> esc_html__('Separator', 'tatsu'),
				'options'		=> !empty($divider_options) ? $divider_options['top'] : array(),
				'default'		=> 'none'
			),
			array(
				'att_name' => 'top_divider_zindex',
				'type'	=> 'number',
				'is_inline' => true,
				'label'	=> esc_html__('Stack Order', 'tatsu'),
				'options' => array(
					'unit' => '',
				),
				'default' => '9999',
				'tooltip'	=> '',
				'css'	=> true,
				'selectors'	=> array(
					'.tatsu-{UUID} > .tatsu-top-divider'	=> array(
						'property'	=> 'z-index',
					),
				)
			),
			array(
				'att_name' => 'bottom_divider_zindex',
				'type'	=> 'number',
				'is_inline' => true,
				'label'	=> esc_html__('Stack Order', 'tatsu'),
				'options' => array(
					'unit' => '',
				),
				'default' => '9999',
				'tooltip'	=> '',
				'css'	=> true,
				'selectors'	=> array(
					'.tatsu-{UUID} > .tatsu-bottom-divider'	=> array(
						'property'	=> 'z-index',
					),
				),
			),
			array(
				'att_name'		=> 'bottom_divider',
				'type'			=> 'select',
				'label'			=> esc_html__('Separator', 'tatsu'),
				'options'		=> !empty($divider_options) ? $divider_options['bottom'] : array(),
				'default'		=> 'none'
			),
			array(
				'att_name'		=> 'top_divider_height',
				'type'			=> 'slider',
				'label'			=> esc_html__('Height', 'tatsu'),
				'options'		=> array(
					'min'		=> 0,
					'max'		=> 500,
					'unit'		=> 'px',
					'step'		=> 1
				),
				'default'		=> 100,
				'tooltip'		=> '',
				'visible'		=> array('top_divider', '!=', 'none'),
				'responsive'	=> true,
				'css'			=> true,
				'selectors' => array(
					'.tatsu-{UUID} > .tatsu-top-divider' => array(
						'property' => 'height',
						'when' => array('top_divider', '!=', 'none'),
						'append' => 'px'
					),
				)
			),
			array(
				'att_name'		=> 'top_divider_position',
				'type'			=> 'select',
				'label'			=> esc_html__('Position', 'tatsu'),
				'options'		=> array(
					'above'		=> 'Above Section Content',
					'over'		=> 'Over Section Content'
				),
				'default'		=> 'above',
				'visible'		=> array(
					'condition' => array(
						array('full_screen', '!=', '1'),
						array('top_divider', '!=', 'none')
					),
					'relation' => 'and'
				)
			),
			array(
				'att_name'		=> 'bottom_divider_height',
				'type'			=> 'slider',
				'label'			=> esc_html__('Height', 'tatsu'),
				'options'		=> array(
					'min'		=> 0,
					'max'		=> 500,
					'unit'		=> 'px',
					'step'		=> 1
				),
				'default'		=> 100,
				'tooltip'		=> '',
				'responsive'	=> true,
				'visible'		=> array('bottom_divider', '!=', 'none'),
				'css'			=> true,
				'selectors' => array(
					'.tatsu-{UUID} > .tatsu-bottom-divider' => array(
						'property' => 'height',
						'when' => array('bottom_divider', '!=', 'none'),
						'append' => 'px'
					),
				)
			),
			array(
				'att_name'		=> 'bottom_divider_position',
				'type'			=> 'select',
				'label'			=> esc_html__('Position', 'tatsu'),
				'options'		=> array(
					'below'		=> 'Below Section Content',
					'over'		=> 'Over Section Content'
				),
				'default' 		=> 'below',
				'visible'		=> array(
					'condition' => array(
						array('full_screen', '!=', '1'),
						array('bottom_divider', '!=', 'none')
					),
					'relation' => 'and'
				)
			),
			array(
				'att_name'		=> 'top_divider_color',
				'type'			=> 'color',
				'label'			=> esc_html__('Color', 'tatsu'),
				'default'		=> '#ffffff',
				'tooltip'		=> '',
				'visible'		=> array('top_divider', '!=', 'none'),
				'css'			=> true,
				'selectors'		=> array(
					'.tatsu-{UUID} > .tatsu-top-divider' => array(
						'property'			=> 'color',
						'when'				=> array('top_divider', '!=', 'none'),
					),
				),
			),
			array(
				'att_name'		=> 'bottom_divider_color',
				'type'			=> 'color',
				'label'			=> esc_html__('Color', 'tatsu'),
				'default'		=> '#ffffff',
				'tooltip'		=> '',
				'visible'		=> array('bottom_divider', '!=', 'none'),
				'css'			=> true,
				'selectors'		=> array(
					'.tatsu-{UUID} > .tatsu-bottom-divider' => array(
						'property'			=> 'color',
						'when'				=> array('bottom_divider', '!=', 'none'),
					),
				),
			),
			array(
				'att_name'		=> 'invert_top_divider',
				'type'			=> 'switch',
				'label'			=> esc_html__('Invert', 'tatsu'),
				'default'		=> '0',
				'visible'		=> array('top_divider', '!=', 'none'),
				'tooltip'		=> ''
			),
			array(
				'att_name'		=> 'invert_bottom_divider',
				'type'			=> 'switch',
				'label'			=> esc_html__('Invert', 'tatsu'),
				'default'		=> '0',
				'visible'		=> array('bottom_divider', '!=', 'none'),
				'tooltip'		=> ''
			),
			array(
				'att_name'		=> 'flip_top_divider',
				'type'			=> 'switch',
				'label'			=> esc_html__('Flip', 'tatsu'),
				'default'		=> '0',
				'visible'		=> array('top_divider', '!=', 'none'),
				'tooltip'		=> ''
			),
			array(
				'att_name'		=> 'flip_bottom_divider',
				'type'			=> 'switch',
				'label'			=> esc_html__('Flip', 'tatsu'),
				'default'		=> '0',
				'visible'		=> array('bottom_divider', '!=', 'none'),
				'tooltip'		=> ''
			),
			array(
				'att_name' => 'section_id',
				'type' => 'text',
				'label' => esc_html__('CSS ID', 'tatsu'),
				'default' => '',
				'tooltip' => '',
			),
			array(
				'att_name' => 'section_class',
				'type' => 'text',
				'label' => esc_html__('CSS Classes', 'tatsu'),
				'default' => '',
				'tooltip' => '',
			),
			array(
				'att_name' => 'section_title',
				'type' => 'text',
				'label' => esc_html__('Name', 'tatsu'),
				'default' => '',
				'options' => array(
					'placeholder' => 'Section Title'
				),
				'tooltip' => '',
			),
			array(
				'att_name' => 'offset_value',
				'type' => 'number',
				'is_inline' => true,
				'label' => esc_html__('Offset Top By', 'tatsu'),
				'options' => array(
					'unit' => 'px',
					'add_unit_to_value' => true,
				),
				'default' => '0',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-section-offset-wrap' => array(
						'property' => 'transformY',
						'when' => array(
							array('offset_value', '!=', '0px'),
							array('offset_value', 'notempty'),
						),
						'relation' => 'or',
						'prepend' => '-'
					),
				)
			),
			array(
				'att_name' => 'full_screen_header_scheme',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Header Color Scheme', 'tatsu'),
				'options' => array(
					'background--light' => 'Dark',
					'background--dark' => 'Light',
				),
				'default' => 'background--dark',
				'tooltip' => '',
			),
			array(
				'att_name' => 'overflow',
				'type' => 'switch',
				'label' => esc_html__('Hide Section Overflow', 'tatsu'),
				'default' => false,
				'tooltip' => '',
			),
			array (
				'att_name'	=> 'z_index',
				'type'		=> 'number',
				'is_inline' => true,
				'label'		=> esc_html__( 'Z Index', 'tatsu' ),
				'options'	=> array (
					'unit'	=> '',
					'add_unit_to_value' => false
				),
				'default'	=> 0,
				'tooltip'	=> '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-section' => array(
						'property' => 'z-index',
						'when' => array(
							array('z_index', '!=', '2' ),
							array('z_index', 'notempty'),
						),
						'relation' => 'and'
					),
				),
			),
		),
	);
	tatsu_register_module('tatsu_section', $controls);
}
?>