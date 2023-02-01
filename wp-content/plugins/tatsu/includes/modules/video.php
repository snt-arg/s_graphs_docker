<?php
if ( !function_exists('tatsu_video') ) {
	function tatsu_video( $atts, $content, $tag ) {
		$atts = shortcode_atts( array(
			'source'=>'youtube',
			'url'=>'',
			'placeholder' => '',
			'autoplay' => 0,
			'loop_video' => 0,
			'mute' => 0,
			'animate'=>0,
	        'animation_type'=> 'none',
			'key' => be_uniqid_base36(true),
		), $atts, $tag );
		
		extract($atts);
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_video', $key );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? 'tatsu-animate' : '' ;
		$data_animations = be_get_animation_data_atts( $atts );
		$output ='';
		$url = tatsu_parse_custom_fields( $url );

	    switch ( $source ) {
			case 'youtube':
	    
				$output .= '<div '.$css_id.' class="tatsu-module tatsu-video tatsu-youtube-wrap '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.' '.$animate.'" '.$data_animations.'>'.$custom_style_tag;
				$output .= tatsu_youtube( $url, $autoplay, $loop_video );
				$output .= '</div>';
				return $output;
				break;
			case 'vimeo':
			
				$output .= '<div '.$css_id.' class="tatsu-module tatsu-video tatsu-vimeo-wrap '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.' '.$animate.'" '.$data_animations.'>'.$custom_style_tag;
				$output .= tatsu_vimeo( $url, $autoplay, $loop_video, $mute );
				$output .= '</div>';
				return $output;
				break;
			default:
				$output .= '<div '.$css_id.' class="tatsu-module tatsu-video tatsu-hosted-wrap '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.' '.$animate.'" '.$data_animations.'>'.$custom_style_tag.'<video  width = "100%" controls controlsList="nodownload" poster = "'.$placeholder.'" '.( $loop_video ? "loop" : "") .' '. ($autoplay ? "autoplay" : "") .' '. ($mute ? "muted " : "").' ><source src="'.$url.'" type="video/mp4"></video></div>';
				
				return $output;
				break;
		}
	}
	add_shortcode( 'tatsu_video', 'tatsu_video' );
}
if ( !function_exists('tatsu_youtube') ) {
	function tatsu_youtube( $url, $autoplay, $loop_video ) {
		
		$video_id = '';
		$result = '';
		if( ! empty( $url ) ) {
			$video_id = ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match ) ) ? $match[1] : '' ;
			if( !function_exists( 'be_gdpr_privacy_ok' ) ){
				$result .= '<div class = "be-video-embed be-embed-placeholder"><div class = "be-youtube-embed" data-video-id = "' . $video_id . '" data-autoplay = "' . $autoplay . '" data-loop = "' . $loop_video . '"></div></div>';
			} else {
				if ( !empty( $_COOKIE ) ) {
					if( !( be_gdpr_privacy_ok( 'youtube' ) )  ){
						$video_details = be_get_video_details($url);
						$result .= be_gdpr_get_video_alt_content( $video_details['thumb_url'], 'youtube', false );
					} else {
						$result .= '<div class = "be-video-embed be-embed-placeholder"><div class = "be-youtube-embed" data-video-id = "' . $video_id . '" data-autoplay = "' . $autoplay . '" data-loop = "' . $loop_video . '"></div></div>';
					}
				} else {
					$result .= '<div class = "be-video-embed be-embed-placeholder"><div class = "be-youtube-embed be-gdpr-consent-replace" data-gdpr-concern="youtube" data-video-id = "' . $video_id . '"></div></div>';
					$video_details = be_get_video_details($url);
					$result .= be_gdpr_get_video_alt_content( $video_details['thumb_url'], 'youtube', true );
				}
			}
		} else {
			return '';
		}
		return $result;
	}
}

/**************************************
			VIDEO - VIMEO
**************************************/
if ( !function_exists( 'tatsu_vimeo' ) ) {
	function tatsu_vimeo( $url, $autoplay, $loop_video, $mute = 0  ) {
		$video_id = '';
		$result = '';
		if( ! empty( $url ) ) {
			sscanf(parse_url($url, PHP_URL_PATH), '/%d', $video_id);
			if( !function_exists( 'be_gdpr_privacy_ok' ) ){
				$result .= '<div class = "be-video-embed be-embed-placeholder"><div class = "be-vimeo-embed" data-video-id = "' . $video_id . '" data-autoplay = "' . $autoplay . '" data-loop = "' . $loop_video . '" data-muted = "' . $mute . '" ></div></div>';
			} else {
				if( !empty( $_COOKIE ) ){
					if( !( be_gdpr_privacy_ok( 'vimeo' ) )  ){
						$video_details = be_get_video_details($url);
						$result .= be_gdpr_get_video_alt_content( $video_details['thumb_url'], 'vimeo', false );
					} else {
						$result .= '<div class = "be-video-embed be-embed-placeholder"><div class = "be-vimeo-embed" data-video-id = "' . $video_id . '" data-autoplay = "' . $autoplay . '" data-loop = "' . $loop_video . '" data-muted = "' . $mute . '" ></div></div>';
					}
				} else {
					$result .= '<div class = "be-video-embed be-embed-placeholder"><div class = "be-vimeo-embed be-gdpr-consent-replace" data-gdpr-concern="vimeo" data-video-id = "' . $video_id . '" data-autoplay = "' . $autoplay . '" data-loop = "' . $loop_video . '" data-muted = "' . $mute . '" ></div></div>';
					$video_details = be_get_video_details($url);
					$result .= be_gdpr_get_video_alt_content( $video_details['thumb_url'], 'vimeo', true );
				}
			}
		} else {
			$result = '';
		}
		return $result;
	}
}

add_action('tatsu_register_modules', 'tatsu_register_video', 6);
function tatsu_register_video()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#video',
		'title' => esc_html__('Video', 'tatsu'),
		'is_js_dependant' => true,
		'type' => 'single',
		'is_built_in' => true,
		'drag_handle' => true,
		'hint' => 'source',
		'is_dynamic' => true,
		'group_atts'			=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					//Tab1
					array(
						'type' => 'tab',
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
							array( //Video source accordion
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => esc_html__('Video Source', 'tatsu'),
										'group' => array(
											'source',
											'url',
											'placeholder',
											'autoplay',
											'loop_video',
											'mute'
										)
									),
								),
							),
						),
					),
					//Tab2
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(),
					),
				),
			),
		),
		'atts' => array(
			array(
				'att_name' => 'source',
				'type' => 'select',
				'is_inline'=> false,
				'label' => esc_html__('Source', 'tatsu'),
				'options' => array(
					'youtube' => 'Youtube',
					'vimeo' => 'Vimeo',
					'selfhosted' => 'Self Hosted',
				),
				'default' => 'youtube',
				'tooltip' => ''
			),
			array(
				'att_name' => 'url',
				'type' => 'text',
				'label' => esc_html__('Video URL', 'tatsu'),
				'is_inline'=> false,
				'default' => '',
				'tooltip' => '',
			),
			array(
				'att_name' => 'placeholder',
				'type' => 'single_image_picker',
				'label' => esc_html__('Place Holder Image', 'tatsu'),
				'tooltip' => '',
				'visible' => array('source', '=', 'selfhosted'),
			),
			array(
				'att_name' => 'autoplay',
				'type' => 'switch',
				'label' => esc_html__('Autoplay', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
			array(
				'att_name' => 'loop_video',
				'type' => 'switch',
				'label' => esc_html__('Loop', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
			array( 
				'att_name' => 'mute',
				'type' => 'switch',
				'label' => esc_html__('Mute', 'tatsu'),
				'default' => 0,
				'tooltip' => 'Depends on Browser Settings and only work for Vimeo and Self hosted video',
			)
		),
		'presets' => array(  //Not included in category 
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'source' => 'youtube',
					'url' => 'https://www.youtube.com/watch?v=8z4FSMLtWoQ',
				)
			),
		),

	);
	tatsu_register_module('tatsu_video', $controls);
}


?>