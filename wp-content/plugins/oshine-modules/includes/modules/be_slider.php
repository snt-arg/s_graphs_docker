<?php
/**************************************
			CUSTOM SLIDER
**************************************/
if (!function_exists('be_custom_slider')) {
	function be_custom_slider( $atts, $content, $tag ) {
		$atts = shortcode_atts( array (
				'animation_type' => 'fxSoftScale',
				'slider_height' => '',
				'module_animation_type' => '',
				'slider_mobile_height' => '',
				'load' => 'yes',
				'key' => be_uniqid_base36(true),
			), $atts, $tag );
		
		extract( $atts );

		$custom_style_tag = be_generate_css_from_atts( $atts, 'be_countdown', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );


		$data_animations ='';
		if( !empty( $module_animation_type ) && 'none' !== $module_animation_type ) {
			$css_classes .= ' tatsu-animate ';
			$data_atts[] = 'data-animation="'.$atts['module_animation_type'].'"';
			$data_atts[] = !empty( $atts['animation_delay'] ) ? 'data-animation-delay="'.$atts['animation_delay'].'"' : '' ;
			$data_atts[] = !empty( $atts['animation_duration'] ) && '300' != $atts['animation_duration'] ? 'data-animation-duration="'.$atts['animation_duration'].'"' : '' ;

			$data_animations = implode( ' ', $data_atts );
		}

		$load = ( isset( $load ) && !empty( $load ) && $load == 'no' ) ? 'no-load' : 'loaded';
		$slider_height_style = ( isset( $slider_height ) && !empty( $slider_height ) ) ? 'style="height: '.$slider_height.'px;"' : 'style="height: 100%;"';
		$slider_height = ( isset( $slider_height ) && !empty( $slider_height ) ) ? $slider_height : '100%';
		$slider_mobile_height = ( isset( $slider_mobile_height ) && !empty( $slider_mobile_height ) ) ? $slider_mobile_height : $slider_height;
	    $output = "";
	    $output .= '<div '.$css_id.' class="component component-fullwidth '.$load.' ' . $animation_type . ' ' .$custom_class_name.' '.$visibility_classes.' '.$css_classes.' " '.$data_animations.' data-height="'.$slider_height.'" data-mobile-height="'.$slider_mobile_height.'" data-current="0" '.$slider_height_style.'>';
	    $output .= '<ul class="itemwrap">';
		$output .= do_shortcode( $content );
	    $output .= '</ul>';
	    $output .= '<nav class="component-nav">';
		$output .= '<a class="prev be-slider-prev" href="#"><i class="font-icon icon-arrow_carrot-left"></i></a>';
		$output .= '<a class="next be-slider-next" href="#"><i class="font-icon icon-arrow_carrot-right"></i></a>';
		$output .= '</nav>';
		$output .= $custom_style_tag;
	    $output .= '</div>';
	    return $output;
	}
	add_shortcode( 'be_slider', 'be_custom_slider' );
}

if (!function_exists('be_custom_slide')) {
	function be_custom_slide( $atts, $content ){
			extract( shortcode_atts( array (
				'image' => '',
				'bg_video' => 0,
		        'bg_video_mp4_src' => '',
		        'bg_video_mp4_src_ogg' => '',
		        'bg_video_mp4_src_webm' => '',
		        'content_width' => '',
		        'left' => '',
		        'right' => '',
		        'top' => '',
		        'bottom' => '',
	        	'content_animation_type'=>'fadeIn',
	    	), $atts ) );
	    	$animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : 0 ;
	    	$bg_video_slide = ( isset( $bg_video ) && 1 == $bg_video ) ? ' be-slider-video' : '' ;
			$output = '';
	    	$output .= '<li>';
			if ( !empty( $image ) || $bg_video ) {
				//$attachment_info = wp_get_attachment_image_src( $image, 'full' );
				$attachment_url = $image; //$attachment_info[0];
				$output .=  '<div class="be-slide-bg-holder">
								<div class="be-slide-bg be-bg-cover be-bg-parallax '.$bg_video_slide.'" data-image="'.$attachment_url.'">';
									if( isset( $bg_video ) && 1 == $bg_video ) {
										$output .= '<video class="be-bg-video" autoplay="autoplay" loop="loop" muted="muted" preload="auto">';
										$output .=  ($bg_video_mp4_src) ? '<source src="'.$bg_video_mp4_src.'" type="video/mp4">' : '' ;
										$output .=  ($bg_video_mp4_src_ogg) ? '<source src="'.$bg_video_mp4_src_ogg.'" type="video/ogg">' : '' ;
										$output .=  ($bg_video_mp4_src_webm) ? '<source src="'.$bg_video_mp4_src_webm.'" type="video/webm">' : '' ;
										$output .= '</video>';
									} else {
										$output .= '<i class="font-icon loader-style4-wrap loader-icon"></i>';
									}
									if(!empty($left) || ($left == '0') || !empty($right) || ($right == '0') || !empty($top) || ($top == '0') || !empty($bottom) || ($bottom == '0')) {
										$style = 'margin: 0px;';
										if(!empty($left) || ($left == '0')) {
											$style .= 'left: '.$left.'%;';
										}
										if(!empty($right) || ($right == '0')) {
											$style .= 'right: '.$right.'%;';
										}
										if(!empty($top) || ($top == '0')) {
											$style .= 'top: '.$top.'%;';
										}
										if(!empty($bottom) || ($bottom == '0')) {
											$style .= 'bottom: '.$bottom.'%;';
										}
										if(!empty($top) || ($top == '0') || !empty($bottom) || ($bottom == '0')) {
											$style .= 'position: absolute;';
										} else {
											$style .= 'position: relative;';
											if(!empty($right) || ($right == '0')) {
												$style .= 'float: right;';
											} else {
												$style .= 'float: none;';
											}
										}
									} else {
										$style = '';
									}
								$output .=  '</div>
								<div class="be-wrap">
									<div class="be-slider-content-wrap">
										<div class="be-slider-content clearfix">
											<div class="be-slider-content-inner-wrap" style="width: '.$content_width.'%;'.$style.'">';
											if( $content ) {
												$output .=  '<div class="be-animate '.$content_animation_type.' animated be-slider-content-inner">'.do_shortcode( $content ).'</div>';
											}
											$output .=  '</div>
										</div>
									</div>
								</div>
							</div>';
			}
	        $output .='</li>';
	        return $output;
	}
	add_shortcode( 'be_slide', 'be_custom_slide' );
}

add_action( 'tatsu_register_modules', 'oshine_register_be_slider');
function oshine_register_be_slider() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#be_slider',
	        'title' => __( 'BE Slider', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'child_module' => 'be_slide',
	        'type' => 'multi',
	        'initial_children' => 3,
			'is_built_in' => false,
			'group_atts' => array (
				array (
					'type'	=>	'tabs',
					'style'	=>	'style1',
					'group'	=>	array (
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Style' , 'tatsu'),
							'group'	=>	array (
								'animation_type',
								'slider_height',
								'slider_mobile_height'
							)
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Advanced' , 'tatsu'),
							'group'	=>	array (
								array (
									'type' => 'accordion',
									'active' => array(0, 1),
									'group' => array (
										array (
											'type' => 'panel',
											'title' => __( 'Animation', 'tatsu' ),
											'group' => array (
												'module_animation_type'
											)
										)
									)
								)
							)
						)
					)
				)
			),
	        'atts' => array (
	        	array (
	        		'att_name' => 'animation_type',
	        		'type' => 'select',
	        		'label' => __('Slider Transition','oshine-modules'),
	        		'options' => array(
	        			'fxSoftScale' => 'Soft Scale', 
	        			'fxPressAway' => 'Press Away', 
	        			'fxSideSwing' => 'Side Swing', 
	        			'fxFortuneWheel' => 'Fortune Wheel', 
	        			'fxSwipe' => 'Swipe', 
	        			'fxPushReveal' => 'Push Reveal', 
	        			'fxSnapIn' => 'Snap In', 
	        			'fxLetMeIn' => 'Let Me In', 
	        			'fxStickIt' => 'Stick It', 
	        			'fxArchiveMe' => 'Archive Me', 
	        			'fxVGrowth' => 'VGrowth', 
	        			'fxSlideBehind' => 'Slide Behind', 
	        			'fxSoftPulse' => 'Soft Pulse', 
	        			'fxEarthquake' => 'Earthquake', 
	        			'fxCliffDiving' => 'Cliff Diving',
	        		),
	        		'default' => 'fxSoftScale',
					'tooltip' => '',
					'is_inline' => true,
	        	),
	        	array (
	        		'att_name' => 'slider_height',
	        		'type' => 'number',
	        		'label' => __('Slider Height','oshine-modules'),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '360',
	        		'tooltip' => '',
					'is_inline' => true,
	        	),
	        	array (
	        		'att_name' => 'slider_mobile_height',
	        		'type' => 'number',
	        		'label' => __('Slider Height in Mobile Devices','oshine-modules'),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '360',
					'tooltip' => '',
					'is_inline' => true,
				),	
				array (
					'att_name' => 'module_animation_type',
					'type' => 'select',
					'exclude' => array( 'tatsu_testimonial_carousel', 'tatsu_empty_space', 'tatsu_svg_icon' ),
					'options' => tatsu_css_animations(),
					'label' => __( 'Animation Type', 'tatsu' ),
					'default' => 'none',
					'tooltip' => '',
				),        		        
	        ),
	    );
	tatsu_register_module( 'be_slider', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_be_slide');
function oshine_register_be_slide() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'BE Slide', 'oshine-modules' ),
	        'type' => 'sub_module',
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
								'image',
								'bg_video',
								'bg_video_mp4_src',
								'bg_video_ogg_src',
								'bg_video_webm_src',
								'content',
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
											'title' => __( 'Shape and Style', 'tatsu' ),
											'group' => array (
												'content_width',
												'position',
												'content_animation_type',
											)
										)
									)
								),
							),
						)
					),
				),
			),
	        'atts' => array (
				array (
	              	'att_name' => 'image',
	              	'type' => 'single_image_picker',
	              	'label' => __( 'Slider image', 'oshine-modules' ),
	              	'default' => '',
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'bg_video',
	              	'type' => 'switch',
	              	'label' => __( 'Enable Background Video', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	        	array (
	        		'att_name' => 'bg_video_mp4_src',
	        		'type' => 'text',
	        		'label' => __( '.MP4 Video File', 'oshine-modules' ),
					'default' => '',
					'visible' => array('bg_video' , '=' , '1'),
					'tooltip' => '',
					'is_inline' => false,
	        	),
	        	array (
	        		'att_name' => 'bg_video_ogg_src',
	        		'type' => 'text',
	        		'label' => __( '.OGG Video File', 'oshine-modules' ),
					'default' => '',
					'visible' => array('bg_video' , '=' , '1'),
					'tooltip' => '',
					'is_inline' => false,
	        	),
	        	array (
	        		'att_name' => 'bg_video_webm_src',
	        		'type' => 'text',
	        		'label' => __( '.Webm Video File', 'oshine-modules' ),
					'default' => '',
					'visible' => array('bg_video' , '=' , '1'),
					'tooltip' => '',
					'is_inline' => false,
	        	),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	        	
	        	array (
	        		'att_name' => 'content_width',
	        		'type' => 'slider',
	        		'label' => __( 'Content Width', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => '%',
	        			'min' => '1',
	        			'max' => '100',
	        			'step' => '1',
	        		),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	            array (
	              'att_name' => 'position',
	              'type' => 'input_group',
	              'label' => __( 'Content Position', 'oshine-modules' ),
	              'default' => '10% 10% 10% 10%',
	              'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'content_animation_type',
	              	'type' => 'select',
	              	'label' => __('Content Animation','oshine-modules'),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
					'tooltip' => '',
					'is_inline' => true,
	            ), 	        			        		        		        		        		        		        		        		        		           
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'image' => 'https://via.placeholder.com/1160x600',
	        			'content' => '<h5>Here is a Title</h5>Proin facilisis varius nunc. Curabitur eros risus, ultrices et dui ut, luctus accumsan nibh.',
	        			'content_width' => '80'
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'be_slide', $controls );
}