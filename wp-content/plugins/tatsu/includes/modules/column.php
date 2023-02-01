<?php
if (!function_exists('tatsu_column')) {
	function tatsu_column( $atts, $content ) {
		$atts = shortcode_atts( array (
			'column_width' => '',
			'column_mobile_spacing' => '',
			'bg_color' => '',
			'bg_image' => '',
			'layout' =>'1/1',
			'gutter' => 'medium',
			'column_spacing' => '25px',
			'bg_repeat' => 'repeat',
			'bg_attachment' => 'scroll',
			'bg_position' => 'left top',
			'bg_size' => 'initial',
			'sticky' => '0',
			'padding' => '0px 0px 0px 0px',
			'custom_margin' => 'null',
			'margin' => '',		
			'border'	=> '0 0 0 0',
			'border_color'	=> '',
			'enable_box_shadow' => 'null',
			'box_shadow_custom' => '',
			'video_preload' => 'auto',
	        'bg_video_mp4_src' => '',
	        'bg_video_ogg_src' => '',
	        'bg_video_webm_src' => '',
	        'bg_overlay' => '',
			'overlay_color' => '',
			'overlay_blend_mode' => 'none',
			'animate_overlay' => 'none',
			'link_overlay' => '',
			'top_divider'				=> 'none',
			'bottom_divider'			=> 'none',
			'top_divider_height'		=> '50',
			'bottom_divider_height'		=> '50',
			'top_divider_color'			=> '#ffffff',
			'bottom_divider_color'		=> '#ffffff',
			'flip_top_divider'			=> '0',
			'flip_bottom_divider'		=> '0',
			'left_divider'				=> 'none',
			'left_divider_width'		=> '50',
			'left_divider_color'		=> '#ffffff',
			'invert_left_divider'		=> '0',
			'right_divider'				=> 'none',
			'right_divider_width'		=> '50',
			'right_divider_color'		=> '#ffffff',
			'invert_right_divider'		=> '0',
			'top_divider_zindex' => '9999',
			'bottom_divider_zindex' => '9999',
			'left_divider_zindex' => '9999',
			'right_divider_zindex' => '9999',
			'vertical_align' => 'none',
			'column_offset' => 'null',
			'offset' 	=> '0px 0px',
			'z_index'	=> 0,
			'col_id' => '',
			'column_class' => '',
			'hide_in' => '',
			'image_hover_effect' => '',
			'column_hover_effect' => '',
			'hover_box_shadow' => '',
			'animate' => 0,
	        'animation_type' => 'fadeIn',
			'animation_delay' => 0,
			'overflow'		=> '0',
			'column_parallax' => 0,
			'border_radius' => '',
			'key' => be_uniqid_base36(true),

		),$atts );

		extract( $atts );
		$atts['z_index'] = !empty( $atts['z_index'] )? (int) $atts['z_index'] + 2 : 2; // Should be corrected to handle json data using "call back" fucntion
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_column', $key );
		$addl_style_tag = '';
		$unique_class_name = 'tatsu-'.$key;
		$data_animations = be_get_animation_data_atts( $atts );
		$column_layouts = array(
			'1/1' => 'tatsu-one-col',
			'1/2' => 'tatsu-one-half',
			'1/3' => 'tatsu-one-third',
			'1/4' => 'tatsu-one-fourth',
			'1/5' => 'tatsu-one-fifth',
			'2/3' => 'tatsu-two-third',
			'3/4' => 'tatsu-three-fourth',
		);	

		$background = '';
	    $bg_video_markup = '';
	    $bg_overlay_markup = '';
		$column_shadow_value = '';
		$custom_gutter = '';
		$column_id = '';
		$classes = '';
		$inner_classes = '';
	    $output = '';

		// Handle Custom Gutter

		if( 'custom' === $gutter ) {
			$column_spacing =  !empty( $column_spacing ) ? intval( $column_spacing ) : 0;
			$column_spacing = intval( $column_spacing / 2 );
			$custom_gutter = ' padding:0 '.$column_spacing.'px;';
		}	

		// Handle Custom Gutter in Mobile

		$column_width_arr = !empty( $column_width ) ? json_decode( $column_width ,true ) : '' ;
		if( is_array( $column_width_arr ) && array_key_exists( 'm', $column_width_arr ) && $column_width_arr['m'] < 100 && ( !empty( $column_mobile_spacing ) && $column_mobile_spacing != 0 ) ){
			$addl_style_tag = '<style>@media only screen and (max-width: 767px) {.'.$unique_class_name.'.tatsu-column{ padding:0 '.intval( $column_mobile_spacing / 2).'px !important} }</style>';
		}
		
	    // Handle BG Video
		if( !empty($bg_video_mp4_src) || !empty($bg_video_ogg_src) || !empty($bg_video_webm_src)  ) {
			$classes .= ' tatsu-video-section';
			$bg_video_markup .= '<video class="tatsu-bg-video" autoplay="autoplay" loop="loop" muted="muted" preload="'.$video_preload.'"  playsinline webkit-playsinline>';
			$bg_video_markup .=  ( !empty( $bg_video_mp4_src ) ) ? '<source src="'.$bg_video_mp4_src.'" type="video/mp4">' : '' ;
			$bg_video_markup .=  ( !empty( $bg_video_ogg_src ) ) ? '<source src="'.$bg_video_ogg_src.'" type="video/ogg">' : '' ;
			$bg_video_markup .=  ( !empty( $bg_video_webm_src ) ) ? '<source src="'.$bg_video_webm_src.'" type="video/webm">' : '' ;
			$bg_video_markup .= '</video>';
		}

		//Handle BG Overlay
		if( (!empty( $bg_overlay ) ) || ( isset($overlay_blend_mode) && $overlay_blend_mode !== 'none' ) ) {
			$classes .= ' tatsu-bg-overlay';
			if( !empty( $animate_overlay ) ) {
				$animate_overlay = 'tatsu-animate-'.$animate_overlay;
			}
			$bg_overlay_markup .= '<div class="tatsu-overlay tatsu-column-overlay '.$animate_overlay.'" ></div>';
			$bg_overlay_markup .= !empty( $link_overlay ) ? '<a href="'.$link_overlay.'" class="tatsu-col-overlay-link"></a>': ''; 
		} else {
			$overlay_color = 'transparent';
		}

		// Background Indicator

		if( empty( $bg_image  ) ) {
	    	if( ! empty( $bg_color ) ) {
	    		$background = true;
	    	}	
	    } else {
    		$background = true;    	
	    }

		if( empty( $background ) && 'transparent' === $overlay_color ) {
			$classes .= ' tatsu-column-no-bg';
		}

		if( empty( $content ) ) {
			$classes .= ' tatsu-column-empty';
		}

		if( array_key_exists( $layout , $column_layouts ) ) {
			$classes .= ' '.$column_layouts[$layout];
		}

		//Column Animation 

		if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
			$classes .= ' tatsu-animate';
		}

		//Column Alignment

		if( isset( $vertical_align ) && 'none' !== $vertical_align ) {
			$classes .= ' tatsu-column-align-'.$vertical_align;
		}

		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$classes .= ' tatsu-hide-'.$device;
			}
		}
		
		//Column Parallax
		if( isset( $column_parallax ) && 0 != $column_parallax ){
			$classes .= ' tatsu-column-parallax';
		}
		//column image hover effect
        if( isset( $image_hover_effect ) ){
            $classes .= ' tatsu-column-image-'.$image_hover_effect;
		}
		//column hover effect
		if( isset( $column_hover_effect ) ){
			$classes .= ' tatsu-column-effect-'.$column_hover_effect;
		}

		//overflow
		if( !empty( $overflow ) ) {
			$classes .= ' tatsu-prevent-overflow';
		}

		//sticky column
		if(isset($sticky) && 0 != $sticky){
			$inner_classes .= ' tatsu-column-sticky';
		}

		//Append to custom classes 
		$column_class = !empty( $column_class ) ? str_replace(',', ' ', $column_class ) : '' ;
		$column_class = $classes.' '.$column_class;

		//Column ID
		if( !empty( $col_id ) ) {
			$column_id = 'id="'.$col_id.'"';
		}

		//background markup
		$bg_markup = '';
		$lazy_load_bg = get_option( 'tatsu_lazyload_bg', false );
		$bg_attr = '';
		$bg_class = 'tatsu-column-bg-image';
		$bg_markup .= '<div class = "tatsu-column-bg-image-wrap">';
		if(!empty($lazy_load_bg)) {
			$bg_class .= ' tatsu-bg-lazyload';
			$bg_attr = 'data-src = "' . $bg_image . '"';
			$image_data_uri = be_get_image_datauri( $bg_image, apply_filters( 'tatsu_bg_lazyload_blur_size', 'tatsu_lazyload_thumb' ), true );
			if( !empty( $image_data_uri ) ) {
				$bg_blur_style = 'style = "background-image : url(' . $image_data_uri . ');"';
				$bg_markup .= '<div class = "tatsu-bg-blur" ' . $bg_blur_style . '"></div>';
			}
		}
		$bg_markup .= '<div class = "' . $bg_class . '" ' . $bg_attr . '></div>';
		$bg_markup .= '</div>'; //end tatsu-column-bg-image-wrap

		//top shape divider
		$top_divider_html = '';
		if( !empty( $top_divider ) && 'none' !== $top_divider ) {
			$top_divider_location = TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/top/' . $top_divider .'.svg';
			$top_divider_svg = @file_get_contents( $top_divider_location );
			if( !empty( $top_divider_svg ) ) {
				$top_divider_classes = array( 'tatsu-shape-divider', 'tatsu-top-divider' );
				if( !empty( $flip_top_divider ) ) {
					$top_divider_classes[] = 'tatsu-flip-divider';
				}
				$top_divider_classes[] = 'tatsu-shape-over';
				$top_divider_classes = implode( ' ', $top_divider_classes );
				$top_divider_html =  '<div class = "' . $top_divider_classes . '">';
				$top_divider_html .= $top_divider_svg;
				$top_divider_html .= '</div>';
			}
		}

		//bottom shape divider
		$bottom_divider_html = '';
		if( !empty( $bottom_divider ) && 'none' !== $bottom_divider ) {
			$bottom_divider_location = TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/bottom/' . $bottom_divider .'.svg';
			$bottom_divider_svg = file_get_contents( $bottom_divider_location );
			if( !empty( $bottom_divider_svg ) ) { 
				$bottom_divider_classes = array( 'tatsu-shape-divider', 'tatsu-bottom-divider' );
				if( !empty( $flip_bottom_divider ) ) {
					$bottom_divider_classes[] = 'tatsu-flip-divider';
				}
				$bottom_divider_classes[] = 'tatsu-shape-over';
				$bottom_divider_classes = implode( ' ', $bottom_divider_classes );
				$bottom_divider_html = '<div class = "' . $bottom_divider_classes . '">';
				$bottom_divider_html .= $bottom_divider_svg;
				$bottom_divider_html .= '</div>';
			}
		}

		//left shape divider
		$left_divider_html = '';
		if( !empty( $left_divider ) && 'none' !== $left_divider ) {
			$left_divider_location = TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/left/'.$left_divider.'.svg';
			$left_divider_svg = @file_get_contents( $left_divider_location );
			if( !empty( $left_divider_svg ) ) {
				$left_divider_classes = array( 'tatsu-shape-divider', 'tatsu-left-divider' );
				if( !empty( $invert_left_divider ) ) {
					$left_divider_classes[] = 'tatsu-invert-divider';
				}
				$left_divider_classes = implode( ' ', $left_divider_classes );
				$left_divider_html =  '<div class = "' . $left_divider_classes . '">';
				$left_divider_html .= $left_divider_svg;
				$left_divider_html .= '</div>';
			}
		}

		//right shape divider
		$right_divider_html = '';
		if( !empty( $right_divider ) && 'none' !== $right_divider ) {
			$right_divider_location = TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/right/'.$right_divider.'.svg';
			$right_divider_svg = @file_get_contents( $right_divider_location );
			if( !empty( $right_divider_svg ) ) {
				$right_divider_classes = array( 'tatsu-shape-divider', 'tatsu-right-divider' );
				if( !empty( $invert_right_divider ) ) {
					$right_divider_classes[] = 'tatsu-invert-divider';
				}
				$right_divider_classes = implode( ' ', $right_divider_classes );
				$right_divider_html =  '<div class = "' . $right_divider_classes . '">';
				$right_divider_html .= $right_divider_svg;
				$right_divider_html .= '</div>';
			}
		}

		$output .= '<div '.$column_id.' class="tatsu-column '.$column_class.' '.$unique_class_name.'" '.$data_animations.' data-parallax-speed="'.$column_parallax.'" style="'.$custom_gutter.'">';
		$output .= '<div class="tatsu-column-inner '. $inner_classes .'" >';
		$output .= $top_divider_html;
		$output .= $left_divider_html;
		$output .= '<div class="tatsu-column-pad-wrap">';
		$output .= '<div class="tatsu-column-pad" >';
		$output .= do_shortcode( $content );
		$output .= '</div>';
		$output .= '</div>';
		$output .= $bg_markup; 
		$output .= $bg_video_markup.$bg_overlay_markup;			
		$output .= $right_divider_html;
		$output .= $bottom_divider_html;
		$output .= '</div>';
		$output .= $custom_style_tag;
		$output .= $addl_style_tag;	
		$output .= '</div>';
		return $output;
	}


	add_shortcode( 'one_col', 'tatsu_column' );
	add_shortcode( 'tatsu_column', 'tatsu_column' );
	add_shortcode( 'tatsu_column1', 'tatsu_column' );
	
	add_shortcode( 'one_half', 'tatsu_column' );
	add_shortcode( 'one_third', 'tatsu_column' );
	add_shortcode( 'one_fourth', 'tatsu_column' );
	add_shortcode( 'one_fifth', 'tatsu_column' );
	add_shortcode( 'two_third', 'tatsu_column' );
	add_shortcode( 'three_fourth', 'tatsu_column' );
	add_shortcode( 'tatsu_inner_column', 'tatsu_column' );

}

if( !function_exists( 'tatsu_column_modify_bg_color' ) ) {
	function tatsu_column_modify_bg_color($atts) {
		$lazy_load_bg_color = get_option( 'tatsu_lazyload_bg_color', false );
		$lazy_load_bg = get_option( 'tatsu_lazyload_bg', false );
		$bg_color = $atts['bg_color'];
		$bg_image =  $atts['bg_image'];
		if(is_array($atts) && !empty($bg_image) && empty($bg_color) && !empty($lazy_load_bg) && !empty($lazy_load_bg_color)) {
			$atts['bg_color'] = $lazy_load_bg_color;
		}
		return $atts;
	}
	add_filter( 'tatsu_column_before_css_generation', 'tatsu_column_modify_bg_color' );
}

if( !function_exists( 'tatsu_column_remove_atts' ) ){
	function tatsu_column_remove_atts( $atts ){
		if( array_key_exists('custom_margin', $atts) && $atts['custom_margin'] == '0' ){
			$atts['margin'] = '{"d":""}';
		}
		
		if( array_key_exists( 'enable_box_shadow',$atts) && $atts['enable_box_shadow'] == '0' ){
			$atts['box_shadow_custom'] = '0px 0px 0px 0px rgba(0,0,0,0)';
		}

		if( array_key_exists( 'column_offset',$atts) && $atts['column_offset'] == '0' ){
			$atts['offset'] = '0px 0px';
		}

		if( array_key_exists( 'bg_overlay',$atts) && $atts['bg_overlay'] == '0' ){
			$atts['overlay_color'] = '';
			$atts['overlay_blend_mode'] = 'none';
		}

		return $atts;
	}

	add_filter('tatsu_column_before_css_generation', 'tatsu_column_remove_atts');
}


add_action('tatsu_register_modules', 'tatsu_register_column');
function tatsu_register_column()
{
	$column_divider_options = tatsu_get_shape_dividers();
	$controls = array(
		'icon' => '',
		'title' => esc_html__('Column', 'tatsu'),
		'is_js_dependant' => true,
		'type' => 'core',
		'is_built_in' => true,
		'child_module' => 'module',
		'initial_children' => 0,

		'group_atts' => array(
			array( //Tab1
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
									array( //BackGround Accordion
										'type' => 'panel',
										'title' => esc_html__('Background', 'tatsu'),
										'group'		=> array(
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
															'bg_video_webm_src'
														),
													),
												),
											),
										),
									),
									array(
										'type'		=> 'panel',
										'title'		=> esc_html__('Width and Alignment', 'tatsu'),
										'group'		=> array(
											'column_width',
											'column_mobile_spacing',
											'vertical_align'

										),
									),
									array( //Overlay accordion
										'type'		=> 'panel',
										'title'		=> esc_html__('Overlay', 'tatsu'),
										'group'		=> array(
											'overlay_blend_mode',
											'overlay_color',
											'animate_overlay',
											'link_overlay'

										),
									),
									array(
										'type'		=> 'panel',
										'title'		=> esc_html__('Shape Divider', 'tatsu'),
										'group'		=> array(
											array(
												'type'  	=> 'tabs',
												'group'		=> array(
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Top', 'tatsu'),
														'group'		=> array(
															'top_divider',
															'top_divider_color',
															'top_divider_height',
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
															'flip_bottom_divider',
															'bottom_divider_zindex',
														),
													),
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Left', 'tatsu'),
														'group'		=> array(
															'left_divider',
															'left_divider_color',
															'left_divider_width',
															'invert_left_divider',
															'left_divider_zindex',
														),
													),
													array(
														'type'		=> 'tab',
														'title'		=> esc_html__('Right', 'tatsu'),
														'group'		=> array(
															'right_divider',
															'right_divider_color',
															'right_divider_width',
															'invert_right_divider',
															'right_divider_zindex',
														),
													),
												),
											),
										)
									),
									array(  //Column animation accordion
										'type' => 'panel',
										'title' => esc_html__('Column Enhancements', 'tatsu'),
										'group' => array(
											'offset',
											'sticky',				
											'column_parallax',
											'overflow',
										)
									),
								),
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
									array( //BackGround Accordion
										'type' => 'panel',
										'title' => esc_html__('Spacing', 'tatsu'),
										'group'		=> array(
											'margin',
											'padding',
										),
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Border', 'tatsu'),
										'group'		=> array(
											'border_style',
											'border',
											'border_color',
											'border_radius',
										),
									),
									array( //Shadow accordion
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
															'box_shadow_custom',
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
											),
										)
									),
									array( //Identifier accordion
										'type' => 'panel',
										'title' => esc_html__('Identifiers', 'tatsu'),
										'group' => array(
											'col_id',
											'column_class'
										),
									),
									array( //Animations accordion
										'type' => 'panel',
										'title' => esc_html__('Animation', 'tatsu'),
										'group' => array(
											'column_hover_effect',						
											'image_hover_effect',
										),
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Visibility', 'tatsu'),
										'group' => array(
											'z_index'
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
				'att_name' => 'bg_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => esc_html__('Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						'property' => 'background-color',
					),
				),
			),
			array(
				'att_name' => 'bg_image',
				'type' => 'single_image_picker',
				'label' => esc_html__('Background Image', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'background-image',
						'when' => array('bg_image', 'notempty'),
					),
				),
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
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'background-repeat',
						'when' => array('bg_image', 'notempty'),
					),
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-bg-blur' => array(
						'property' => 'background-repeat',
						'when' => array('bg_image', 'notempty'),
					),
				),
			),
			array(
				'att_name' => 'bg_attachment',
				'type' => 'select',
				'label' => esc_html__('Attachment', 'tatsu'),
				'options' => array(
					'scroll' => 'Scroll',
					'fixed' => 'Fixed'
				),
				'default' => 'scroll',
				'tooltip' => '',
				'hidden' => array('bg_image', '=', ''),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'background-attachment',
						'when' => array('bg_image', 'notempty'),
					),
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-bg-blur' => array(
						'property' => 'background-attachment',
						'when' => array('bg_image', 'notempty'),
					),
				),
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
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'background-position',
						'when' => array('bg_image', 'notempty'),
					),
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-bg-blur' => array(
						'property' => 'background-position',
						'when' => array('bg_image', 'notempty'),
					),
				),
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
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'background-size',
						'when' => array('bg_image', 'notempty'),
					),
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-bg-blur' => array(
						'property' => 'background-size',
						'when' => array('bg_image', 'notempty'),
					),
				),
			),
			array(
				'att_name' => 'padding',
				'type' => 'input_group',
				'label' => esc_html__('Padding', 'tatsu'),
				'default' => '0px 0px 0px 0px',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-pad-wrap > .tatsu-column-pad' => array(
						'property' => 'padding',
						'when' => array('padding', '!=', array('d' => '0px 0px 0px 0px')),
					),
				),
			),
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column' => array(
						'property' => 'margin',
						'when' => array('margin', '!=', array('d' => '0px 0px 50px 0px')),
						'append' => ' !important',
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
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						'property' => 'border-style',
						'when' => array(
							array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', '!=', '0px 0px 0px 0px' ),
							array( 'border', 'notempty' ),
							array( 'border_style', '!=', array( 'd' => 'none', 'l' => 'none', 't' => 'none', 'm' => 'none' ) ),
						),
						'relation' => 'and',            
					),
				),
			),
			array(
				'att_name' => 'border',
				'type' => 'input_group',
				'label' => esc_html__('Border Width', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						'property' => 'border-width',
						'when' => array(
							array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', '!=', '0px 0px 0px 0px' ),
							array( 'border', 'notempty' ),
							array( 'border_style', '!=', array( 'd' => 'none', 'l' => 'none', 't' => 'none', 'm' => 'none' ) ),
                        ),
                        'relation' => 'and',
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
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						'property' => 'border-color',
						'when' => array(
							array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', '!=', '0px 0px 0px 0px' ),
							array( 'border', 'notempty' ),
							array( 'border_style', '!=', array( 'd' => 'none', 'l' => 'none', 't' => 'none', 'm' => 'none' ) ),
                        ),
                        'relation' => 'and',
					),
				),
			),
			array(
				'att_name' => 'border_radius',
				'type' => 'number',
				'is_inline' => true,
				'label' => esc_html__('Border Radius', 'tatsu'),
				'options' => array(
					'unit' => array( 'px', '%' ),
					'add_unit_to_value' => true,
				),
				'default' => '0',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						'property' => 'border-radius',
						'when' => array('border_radius', '!=', '0px'),
					),
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'border-radius',
						'when' => array('border_radius', '!=', '0px'),
					),
				),
				'tooltip' => 'Use this to give border radius',
			),
			array(
				'att_name' => 'box_shadow_custom',
				'type' => 'input_box_shadow',
				'label' => esc_html__('Box Shadow', 'tatsu'),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						'property' => 'box-shadow',
						'when' => array('box_shadow_custom', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
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
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-overlay' => array(
						'property' => 'background',
						'when' => array(
							array( 'overlay_blend_mode', '!=', 'none' ),
							array( 'bg_overlay', '=', '1' ),
						),
						'relation' => 'or',
					),
				),
			),
			array(
				'att_name' => 'overlay_blend_mode',
				'type' => 'select',
				'label' => esc_html__('Overlay Type', 'tatsu'),
				'options' => tatsu_get_blend_modes(),
				'default' => 'normal',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-overlay' => array(
						'property' => 'mix-blend-mode'
					),
				),
			),
			array(
				'att_name' => 'animate_overlay',
				'type' => 'select',
				'is_inline' => true,
				'label' => esc_html__('Interaction', 'tatsu'),
				'options' => array(
					'none' => 'None',
					'hide' => 'Show on Hover',
					'show' => 'Hide on Hover',
				),
				'default' => 'none',
				'tooltip' => '',
			),
			array(
				'att_name' => 'link_overlay',
				'type' => 'text',
				'label' => esc_html__('Overlay Link', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array('overlay_blend_mode', '!=', 'none'),
			),
			array(
				'att_name' => 'vertical_align',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Align', 'tatsu'),
				'options' => array(
					'none' => 'None',
					'top' => 'Top',
					'middle' => 'Middle',
					'bottom' => 'Bottom',
				),
				'default' => 'none',
				'tooltip' => '',
			),

			array(
				'att_name' => 'sticky',
				'type' => 'switch',
				'label' => esc_html__('Make Column Sticky', 'tatsu'),
				'default' => '0',
				'tooltip' => '',
			),
			array(
				'att_name'	=> 'offset',
				'type'		=> 'negative_number',
				'label'		=> esc_html__('Offset', 'tatsu'),
				'default'	=> '0px 0px',
				'options' => array(
					'labels' => array('X-axis', 'Y-axis'),
					'unit' => array('px', '%'),
				),
				'tooltip'	=> '',
				'visible'	=> array('sticky', '!=', '1'),
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column' => array(
						'property' => 'transform',
						'when' => array(
							array('sticky', '!=', '1'),
							array('offset', '!=', array( 'd' => '0px 0px' ) ),
						),
						'relation' => 'and'
					),
				),
			),
			array(
				'att_name' => 'column_parallax',
				'type' => 'slider',
				'label' => esc_html__('Parallax', 'tatsu'),
				'options' => array(
					'min' => '0',
					'max' => '10',
					'step' => '1',
					'unit' => '',
				),
				'default' => '0',
				'tooltip' => ''
			),
			array(
				'att_name' => 'column_width',
				'type' => 'slider',
				'label' => esc_html__('Width', 'tatsu'),
				'options' => array(
					'min' => '0',
					'max' => '100',
					'step' => '.01',
					'unit' => '%',
				),
				'default' => '',
				'tooltip' => '',
				'responsive' => true,
				'multiselect' => false, //Field disabled for editing on Multi Select
				'css' => true,
				'selectors' => array(
					'.tatsu-row > .tatsu-{UUID}.tatsu-column' => array(
						'property' => 'width',
						'append' => '%'
					)
				),
			),
			array(
				'att_name' => 'column_mobile_spacing',
				'type' => 'number',
				'label' => esc_html__('Column Spacing (In Mobile)', 'tatsu'),
				'visible' => array('column_width', '<', '100'),
				'device_visibility' => 'mobile',
				'options' => array(
					'unit' => 'px',
					'add_unit_to_value' => false,
				),
				'default' => '0',
				'tooltip' => ''
			),
			array(
				'att_name' => 'image_hover_effect',
				'type' => 'select',
				'label' => esc_html__('Image Hover Effect', 'tatsu'),
				'options' => array(
					'none' => 'None',
					'zoom' => 'Zoom',
					'slow-zoom' => 'Slow Zoom'
				),
				'default' => 'none',
				'tooltip' => '',
				'visible' => array('bg_image', '!=', ''),
			),
			array(
				'att_name' => 'column_hover_effect',
				'type' => 'select',
				'label' => esc_html__('Column Hover Effect', 'tatsu'),
				'options' => array(
					'slideup' => 'Slide Up',
					'scale' => 'Scale',
					'tilt' => 'Tilt Effect',
					'none' => 'None',
				),
				'default' => 'none',
				'tooltip' => '',
			),
			array(
				'att_name' => 'hover_box_shadow',
				'type' => 'input_box_shadow',
				'label' => esc_html__('Hover Box Shadow', 'tatsu'),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner:hover' => array(
						'property' => 'box-shadow',
						'when' => array('hover_box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
					),
				),
			),
			array(
				'att_name' => 'overflow',
				'type' => 'switch',
				'label' => esc_html__('Hide Section Overflow', 'tatsu'),
				'default' => false,
				'tooltip' => '',
			),
			array(
				'att_name' => 'column_parallax',
				'type' => 'slider',
				'label' => esc_html__('Column Parallax', 'tatsu'),
				'options' => array(
					'min' => '0',
					'max' => '10',
					'step' => '1',
					'unit' => '',
				),
				'default' => '0',
				'tooltip' => ''
			),
			array(
				'att_name' => 'col_id',
				'type' => 'text',
				'label' => esc_html__('CSS ID', 'tatsu'),
				'default' => '',
				'tooltip' => '',
			),
			array(
				'att_name' => 'column_class',
				'type' => 'text',
				'label' => esc_html__('CSS Classes', 'tatsu'),
				'default' => '',
				'tooltip' => '',
			),
			//Column Top Divider
				array(
					'att_name'		=> 'top_divider',
					'type'			=> 'select',
					'label'			=> esc_html__('Separator', 'tatsu'),
					'options'		=> !empty($column_divider_options) ? $column_divider_options['top'] : array(),
					'default'		=> 'none'
				),
				array(
					'att_name'		=> 'top_divider_height',
					'type'			=> 'slider',
					'label'			=> esc_html__('Height', 'tatsu'),
					'options'		=> array(
						'min'		=> 0,
						'max'		=> 500,
						'unit'		=> array('px'),
						'step'		=> 1
					),
					'default'		=> array('d' => '100', 'm'	=> '0'),
					'tooltip'		=> '',
					'visible'		=> array('top_divider', '!=', 'none'),
					'responsive'	=> true,
					'css'			=> true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-top-divider' => array(
							'property' => 'height',
							'when' => array('top_divider', '!=', 'none'),
							'append' => 'px'
						),
					)
				),
				array(
					'att_name'		=> 'top_divider_color',
					'type'			=> 'color',
					'label'			=> esc_html__('Color', 'tatsu'),
					'default'		=> '#ffffff',
					'tooltip'		=> '',
					'css'			=> true,
					'visible'		=> array('top_divider', '!=', 'none'),
					'selectors'		=> array(
						'.tatsu-{UUID} .tatsu-top-divider' => array(
							'property'			=> 'color',
							'when'				=> array('top_divider', '!=', 'none'),
						),
					),
				),
				array(
					'att_name'		=> 'flip_top_divider',
					'type'			=> 'switch',
					'visible'		=> array('top_divider', '!=', 'none'),
					'label'			=> esc_html__('Flip', 'tatsu'),
					'default'		=> '0',
					'tooltip'		=> ''
				),
				array(
					'att_name' => 'top_divider_zindex',
					'type'	=> 'number',
					'options' 	=> array (
						'unit'	=> ''
					),
					'label'	=> esc_html__('Stack Order', 'tatsu'),
					'default' => '9999',
					'tooltip'	=> '',
					'css'	=> true,
					'visible'		=> array('top_divider', '!=', 'none'),
					'selectors'	=> array(
						'.tatsu-{UUID} > .tatsu-column-inner > .tatsu-top-divider'	=> array(
							'property'	=> 'z-index',
						),
					)
				),
			//Column Bottom Divider	
				array(
					'att_name'		=> 'bottom_divider',
					'type'			=> 'select',
					'label'			=> esc_html__('Separator', 'tatsu'),
					'options'		=> !empty($column_divider_options) ? $column_divider_options['bottom'] : array(),
					'default'		=> 'none'
				),
				array(
					'att_name'		=> 'bottom_divider_height',
					'type'			=> 'slider',
					'label'			=> esc_html__('Height', 'tatsu'),
					'options'		=> array(
						'min'		=> 0,
						'max'		=> 500,
						'unit'		=> array('px'),
						'step'		=> 1
					),
					'default'		=> array('d' => '100', 'm'	=> '0'),
					'tooltip'		=> '',
					'responsive'	=> true,
					'css'			=> true,
					'visible'		=> array('bottom_divider', '!=', 'none'),
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-bottom-divider' => array(
							'property' => 'height',
							'when' => array('bottom_divider', '!=', 'none'),
							'append' => 'px'
						),
					)
				),
				array(
					'att_name'		=> 'bottom_divider_color',
					'type'			=> 'color',
					'label'			=> esc_html__('Color', 'tatsu'),
					'default'		=> '#ffffff',
					'tooltip'		=> '',
					'css'			=> true,
					'visible'		=> array('bottom_divider', '!=', 'none'),
					'selectors'		=> array(
						'.tatsu-{UUID} .tatsu-bottom-divider' => array(
							'property'			=> 'color',
							'when'				=> array('bottom_divider', '!=', 'none'),
						),
					),
				),
				array(
					'att_name'		=> 'flip_bottom_divider',
					'type'			=> 'switch',
					'visible'		=> array('bottom_divider', '!=', 'none'),
					'label'			=> esc_html__('Flip', 'tatsu'),
					'default'		=> '0',
					'tooltip'		=> ''
				),
				array(
					'att_name' => 'bottom_divider_zindex',
					'type'	=> 'number',
					'options' 	=> array (
						'unit'	=> ''
					),
					'label'	=> esc_html__('Stack Order', 'tatsu'),
					'default' => '9999',
					'tooltip'	=> '',
					'css'	=> true,
					'visible'		=> array('bottom_divider', '!=', 'none'),
					'selectors'	=> array(
						'.tatsu-{UUID} > .tatsu-column-inner > .tatsu-bottom-divider'	=> array(
							'property'	=> 'z-index',
						),
					)
				),

			//Left shape divider
				array(
					'att_name'		=> 'left_divider',
					'type'			=> 'select',
					'label'			=> esc_html__('Separator', 'tatsu'),
					'options'		=> !empty($column_divider_options) ? $column_divider_options['left'] : array(),
					'default'		=> 'none'

				),
				array(
					'att_name'		=> 'left_divider_width',
					'type'			=> 'slider',
					'label'			=> esc_html__('Width', 'tatsu'),
					'options'		=> array(
						'min'		=> 0,
						'max'		=> 500,
						'unit'		=> array('px'),
						'step'		=> 1
					),
					'default'		=> array('d' => '50', 'm'	=> '0'),
					'tooltip'		=> '',
					'responsive'	=> true,
					'css'			=> true,
					'visible'		=> array('left_divider', '!=', 'none'),
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-left-divider' => array(
							'property' => 'width',
							'when' => array('left_divider', '!=', 'none'),
							'append' => 'px',
						)
					)
				),
				array(
					'att_name'		=> 'left_divider_color',
					'type'			=> 'color',
					'label'			=> esc_html__('Color', 'tatsu'),
					'default'		=> '#ffffff',
					'tooltip'		=> '',
					'css'			=> true,
					'visible'		=> array('left_divider', '!=', 'none'),
					'selectors'		=> array(
						'.tatsu-{UUID} .tatsu-left-divider' => array(
							'property'			=> 'color',
							'when'				=> array('left_divider', '!=', 'none'),
						),
					),
				),
				array(
					'att_name'		=> 'invert_left_divider',
					'type'			=> 'switch',
					'label'			=> esc_html__('Invert', 'tatsu'),
					'visible'		=> array('left_divider', '!=', 'none'),
					'default'		=> '0',
					'tooltip'		=> ''
				),
				array(
					'att_name' => 'left_divider_zindex',
					'type'	=> 'number',
					'options' 	=> array (
						'unit'	=> ''
					),
					'label'	=> esc_html__('Stack Order', 'tatsu'),
					'default' => '9999',
					'tooltip'	=> '',
					'css'	=> true,
					'visible'		=> array('left_divider', '!=', 'none'),
					'selectors'	=> array(
						'.tatsu-{UUID} > .tatsu-column-inner > .tatsu-left-divider'	=> array(
							'property'	=> 'z-index',
						),
					)
				),

			//Right shape divider
				array(
					'att_name'		=> 'right_divider',
					'type'			=> 'select',
					'label'			=> esc_html__('Separator', 'tatsu'),
					'options'		=> !empty($column_divider_options) ? $column_divider_options['right'] : array(),
					'default'		=> 'none'
				),
				array(
					'att_name'		=> 'right_divider_width',
					'type'			=> 'slider',
					'label'			=> esc_html__('Width', 'tatsu'),
					'options'		=> array(
						'min'		=> 0,
						'max'		=> 500,
						'unit'		=> array('px'),
						'step'		=> 1
					),
					'default'		=> array('d' => '50', 'm'	=> '0'),
					'tooltip'		=> '',
					'responsive'	=> true,
					'css'			=> true,
					'visible'		=> array('right_divider', '!=', 'none'),
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-right-divider' => array(
							'property' => 'width',
							'when' => array('right_divider', '!=', 'none'),
							'append' => 'px',
						),
					)
				),
				array(
					'att_name'		=> 'right_divider_color',
					'type'			=> 'color',
					'label'			=> esc_html__('Color', 'tatsu'),
					'default'		=> '#ffffff',
					'tooltip'		=> '',
					'css'			=> true,
					'visible'		=> array('right_divider', '!=', 'none'),
					'selectors'		=> array(
						'.tatsu-{UUID} .tatsu-right-divider' => array(
							'property'			=> 'color',
							'when'				=> array('right_divider', '!=', 'none'),
						),
					),
				),
				array(
					'att_name'		=> 'invert_right_divider',
					'type'			=> 'switch',
					'label'			=> esc_html__('Invert', 'tatsu'),
					'visible'		=> array('right_divider', '!=', 'none'),
					'default'		=> '0',
					'tooltip'		=> ''
				),
				array(
					'att_name' => 'right_divider_zindex',
					'type'	=> 'number',
					'options' 	=> array (
						'unit'	=> ''
					),
					'label'	=> esc_html__('Stack Order', 'tatsu'),
					'default' => '9999',
					'tooltip'	=> '',
					'css'	=> true,
					'visible'		=> array('right_divider', '!=', 'none'),
					'selectors'	=> array(
						'.tatsu-{UUID} > .tatsu-column-inner > .tatsu-right-divider'	=> array(
							'property'	=> 'z-index',
						),
					)
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
					    '.tatsu-{UUID}.tatsu-column' => array(
							'property' => 'z-index',
							'when' => array(
								array('z_index', 'notempty'),
								array('z_index', '!=', '2'),
							),
							'relation' => 'and',
						),
					),
				),
		),
	);
	tatsu_register_module('tatsu_column', $controls);
}

add_action('tatsu_register_modules', 'tatsu_register_inner_column');
function tatsu_register_inner_column()
{
	$controls = array(
		'icon' => '',
		'title' => esc_html__('Inner Column', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => 'module',
		'initial_children' => 0,
		'type' => 'core',
		'builder_layout' => 'list',
		'is_built_in' => true,
		'group_atts' => array(
			array( //Tab1
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(

							array(
								'type' => 'accordion',
								'active' => array(0, 1, 2),
								'group' => array(
									array( //BackGround Accordion
										'type' => 'panel',
										'title' => esc_html__('Background', 'tatsu'),
										'group'		=> array(
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
															'bg_video_webm_src'
														),
													),
												),
											),
										),
									),
									array(
										'type'		=> 'panel',
										'title'		=> esc_html__('Width and Alignment', 'tatsu'),
										'group'		=> array(
											'column_width',
											'column_mobile_spacing',
											'vertical_align'
										),
									),
									array( //Overlay accordion
										'type'		=> 'panel',
										'title'		=> esc_html__('Overlay', 'tatsu'),
										'group'		=> array(
											'overlay_blend_mode',
											'overlay_color',
											'animate_overlay',
											'link_overlay'
										),
									),
									array(  //Column animation accordion
										'type' => 'panel',
										'title' => esc_html__('Column Enhancements', 'tatsu'),
										'group' => array(
											'offset',
											'sticky',				
											'column_parallax',
											'overflow',
										)
									),
								),
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
									array( //BackGround Accordion
										'type' => 'panel',
										'title' => esc_html__('Spacing', 'tatsu'),
										'group'		=> array(
											'margin',
											'padding',
										),
									),
									array(
										'type' => 'panel',
										'title' => esc_html__('Border', 'tatsu'),
										'group'		=> array(
											'border_style',
											'border',
											'border_color',
											'border_radius',
										),
									),
									array( //Shadow accordion
										'type' => 'panel',
										'title' => esc_html__('Shadow', 'tatsu'),
										'group' => array(
											'box_shadow_custom',
											'hover_box_shadow',
										)
									),
									array( //Identifier accordion
										'type' => 'panel',
										'title' => esc_html__('Identifiers', 'tatsu'),
										'group' => array(
											'col_id',
											'column_class'
										),
									),
									array( //Animations accordion
										'type' => 'panel',
										'title' => esc_html__('Animation', 'tatsu'),
										'group' => array(
											'column_hover_effect',						
											'image_hover_effect',
										),
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
				'att_name' => 'bg_color',
				'type' => 'color',
				'label' => esc_html__('Background Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						'property' => 'background-color',
					),
				),
			),
			array(
				'att_name' => 'bg_image',
				'type' => 'single_image_picker',
				'label' => esc_html__('Background Image', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'background-image',
						'when' => array('bg_image', 'notempty'),
					),
				),
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
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'background-repeat',
						'when' => array('bg_image', 'notempty'),
					),
				),
			),
			array(
				'att_name' => 'bg_attachment',
				'type' => 'select',
				'label' => esc_html__('Attachment', 'tatsu'),
				'options' => array(
					'scroll' => 'Scroll',
					'fixed' => 'Fixed'
				),
				'default' => 'scroll',
				'tooltip' => '',
				'hidden' => array('bg_image', '=', ''),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'background-attachment',
						'when' => array('bg_image', 'notempty'),
					),
				),
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
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'background-position',
						'when' => array('bg_image', 'notempty'),
					),
				),
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
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'background-size',
						'when' => array('bg_image', 'notempty'),
					),
				),
			),
			array(
				'att_name' => 'padding',
				'type' => 'input_group',
				'label' => esc_html__('Padding', 'tatsu'),
				'default' => '0px 0px 0px 0px',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-pad-wrap > .tatsu-column-pad' => array(
						'property' => 'padding',
						'when' => array('padding', '!=', array('d' => '0px 0px 0px 0px')),
					),
				),
			),
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => esc_html__('Margin', 'tatsu'),
				'default' => '0px 0px 50px 0px',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column' => array(
						'property' => 'margin',
						'when' => array('margin', '!=', array('d' => '0px 0px 50px 0px')),
						'append' => ' !important',
					),
				),
			),
			array(
				'att_name' => 'border_radius',
				'type' => 'number',
				'label' => esc_html__('Border Radius', 'tatsu'),
				'options' => array(
					'unit' => 'px',
					'add_unit_to_value' => true,
				),
				'default' => '0',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						'property' => 'border-radius',
						'when' => array('border_radius', '!=', '0px'),
					),
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'border-radius',
						'when' => array('border_radius', '!=', '0px'),
					),
				),
				'tooltip' => 'Use this to give border radius',
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
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						'property' => 'border-style',
						'when' => array(
							array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', '!=', '0px 0px 0px 0px' ),
							array( 'border', 'notempty' ),
							array( 'border_style', '!=', array( 'd' => 'none', 'l' => 'none', 't' => 'none', 'm' => 'none' ) ),
						),
						'relation' => 'and',            
					),
				),
			),
			array(
				'att_name' => 'border',
				'type' => 'input_group',
				'label' => esc_html__('Border Width', 'tatsu'),
				'default' => '0px 0px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						'property' => 'border-width',
						'when' => array(
							array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', '!=', '0px 0px 0px 0px' ),
							array( 'border', 'notempty' ),
							array( 'border_style', '!=', array( 'd' => 'none', 'l' => 'none', 't' => 'none', 'm' => 'none' ) ),
						),
						'relation' => 'and',
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
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						'property' => 'border-color',
						'when' => array(
							array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
							array( 'border', '!=', '0px 0px 0px 0px' ),
							array( 'border', 'notempty' ),
							array( 'border_style', '!=', array( 'd' => 'none', 'l' => 'none', 't' => 'none', 'm' => 'none' ) ),
						),
						'relation' => 'and',
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
				'att_name' => 'overlay_blend_mode',
				'type' => 'select',
				'label' => esc_html__('Overlay Type', 'tatsu'),
				'options' => tatsu_get_blend_modes(),
				'default' => 'normal',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-overlay' => array(
						'property' => 'mix-blend-mode'
					),
				),
			),
			array(
				'att_name' => 'overlay_color',
				'type' => 'color',
				'label' => esc_html__('Overlay Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-overlay' => array(
						'property' => 'background',
						'when' => array(
							array( 'overlay_blend_mode', '!=', 'none' ),
							array( 'bg_overlay', '=', '1' ),
						),
						'relation' => 'or',
					),
				),
			),
			array(
				'att_name' => 'animate_overlay',
				'type' => 'select',
				'is_inline' => true,
				'label' => esc_html__('Interaction', 'tatsu'),
				'options' => array(
					'none' => 'None',
					'hide' => 'Show on Hover',
					'show' => 'Hide on Hover',
				),
				'default' => 'none',
				'tooltip' => '',
			),
			array(
				'att_name' => 'link_overlay',
				'type' => 'text',
				'label' => esc_html__('Link Overlay', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array('overlay_blend_mode', '!=', 'none'),
			),
			array(
				'att_name' => 'vertical_align',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => esc_html__('Align', 'tatsu'),
				'options' => array(
					'none' => 'None',
					'top' => 'Top',
					'middle' => 'Middle',
					'bottom' => 'Bottom',
				),
				'default' => 'none',
				'tooltip' => '',
			),
			array(
				'att_name'	=> 'offset',
				'type'		=> 'negative_number',
				'label'		=> esc_html__('Offset', 'tatsu'),
				'default'	=> '0px 0px',
				'options' => array(
					'labels' => array('X-axis', 'Y-axis'),
					'unit' => array('px')
				),
				'tooltip'	=> '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column' => array(
						'property' => 'transform',
						'when' => array( 'offset', '!=', array( 'd' => '0px 0px' ) ),
					),
				),
			),
			array(
				'att_name' => 'column_parallax',
				'type' => 'slider',
				'label' => esc_html__('Parallax', 'tatsu'),
				'options' => array(
					'min' => '0',
					'max' => '10',
					'step' => '1',
					'unit' => '',
				),
				'default' => '0',
				'tooltip' => ''
			),
			array(
				'att_name' => 'column_width',
				'type' => 'slider',
				'label' => esc_html__('Width', 'tatsu'),
				'options' => array(
					'min' => '0',
					'max' => '100',
					'step' => '.01',
					'unit' => '',
				),
				'default' => '',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-row > .tatsu-{UUID}.tatsu-column' => array(
						'property' => 'width',
						'append' => '%'
					)
				),
			),
			array(
				'att_name' => 'column_mobile_spacing',
				'type' => 'number',
				'label' => esc_html__('Column Spacing (In Mobile)', 'tatsu'),
				'visible' => array('column_width', '<', '100'),
				'device_visibility' => 'mobile',
				'options' => array(
					'unit' => 'px',
					'add_unit_to_value' => false,
				),
				'default' => '0',
				'tooltip' => ''
			),
			array(
				'att_name' => 'col_id',
				'type' => 'text',
				'label' => esc_html__('CSS ID', 'tatsu'),
				'default' => '',
				'tooltip' => '',
			),
			array(
				'att_name' => 'column_class',
				'type' => 'text',
				'label' => esc_html__('CSS Classes', 'tatsu'),
				'default' => '',
				'tooltip' => '',
			),

			array(
				'att_name' => 'box_shadow_custom',
				'type' => 'input_box_shadow',
				'label' => esc_html__('Box Shadow', 'tatsu'),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						'property' => 'box-shadow',
						'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)' ),
					),
				),
			),
			array(
				'att_name' => 'overflow',
				'type' => 'switch',
				'label' => esc_html__('Hide Section Overflow', 'tatsu'),
				'default' => false,
				'tooltip' => '',
			),
		),
	);
	tatsu_register_module('tatsu_inner_column', $controls);
}



?>