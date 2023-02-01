<?php
	$post_id = be_get_page_id();
	global $be_themes_data;
	$single_blog_style = ( isset( $be_themes_data[ 'single_blog_style' ] ) && !empty( $be_themes_data[ 'single_blog_style' ] ) ) ? true : false;	//Identify the Source of Hero Section - 
	if(is_singular( 'post' ) && is_single($post_id) && isset($be_themes_data['single_blog_hero_section_from']) && $be_themes_data['single_blog_hero_section_from'] == 'inherit_option_panel') {
		$hero_section_pfx = "single_blog" ; 
		$hero_source = "op" ;
	}
	else if ((in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_product($post_id)) && isset($be_themes_data['single_shop_hero_section_from']) && $be_themes_data['single_shop_hero_section_from'] == 'inherit_option_panel') {
		$hero_section_pfx = "single_shop" ; 
		$hero_source = "op" ;
	}
	else {
		$hero_section_pfx = "";
		$hero_source = "page" ;	
	}

	if ('op' == $hero_source) {
		$hero_section = $be_themes_data[$hero_section_pfx.'_hero_section'];
		if( $single_blog_style && is_singular( 'post' ) ) {
			$hero_section = 'none';
		}
		if($hero_section && !empty($hero_section) && $hero_section != 'none') {
			echo '<div class="header-hero-section" id="hero-section">';
			if($hero_section == 'slider') {
				$hero_section_slider = $be_themes_data[$hero_section_pfx.'_hero_section_slider_shortcode'];
					if($hero_section_slider) {
						echo do_shortcode($hero_section_slider);
					}
			}
			if($hero_section == 'custom') {
				echo '<div class="header-hero-custom-section">';
				$hero_section_position = $be_themes_data[$hero_section_pfx.'_hero_section_position'];
				if($hero_section_position == 'before'){
					$hero_section_with_header = 'full-'.$be_themes_data[$hero_section_pfx.'_hero_section_with_header'];	
				}else{
					$hero_section_with_header = '';
				}
				$hero_section_custom_height = $be_themes_data[$hero_section_pfx.'_hero_section_custom_height'];
				if( !empty( $hero_section_custom_height ) ) {
					$full = '';
				} else {
					$full = 'full-screen-height';
				}
				$bg_color = $be_themes_data[$hero_section_pfx.'_hero_section_bg_color'];
				$bg_image = $be_themes_data[$hero_section_pfx.'_hero_section_bg_image']['background-image'];
				$bg_repeat = $be_themes_data[$hero_section_pfx.'_hero_section_bg_image']['background-repeat'];
				$bg_attachment = $be_themes_data[$hero_section_pfx.'_hero_section_bg_image']['background-attachment'];
				$bg_position = $be_themes_data[$hero_section_pfx.'_hero_section_bg_image']['background-position'];
				if(!empty($be_themes_data[$hero_section_pfx.'_hero_section_bg_image']) && isset($be_themes_data[$hero_section_pfx.'_hero_section_bg_image']) && $be_themes_data[$hero_section_pfx.'_hero_section_bg_image'] ) {
					$bg_stretch = $be_themes_data[$hero_section_pfx.'_hero_section_bg_image']['background-size'];
				} else {
					$bg_stretch = 0;
				}
				if(!empty($be_themes_data[$hero_section_pfx.'_hero_section_bg_animation']) && isset($be_themes_data[$hero_section_pfx.'_hero_section_bg_animation']) && $be_themes_data[$hero_section_pfx.'_hero_section_bg_animation'] ) {
					$bg_animation = $be_themes_data[$hero_section_pfx.'_hero_section_bg_animation'];
				} else {
					$bg_animation = '';
				}
				if(!empty($be_themes_data[$hero_section_pfx.'_hero_section_bg_video']) && isset($be_themes_data[$hero_section_pfx.'_hero_section_bg_video']) && $be_themes_data[$hero_section_pfx.'_hero_section_bg_video'] ) {
					$bg_video = $be_themes_data[$hero_section_pfx.'_hero_section_bg_video'];
				} else {
					$bg_video = 0;
				}
				$bg_video_format = $be_themes_data[$hero_section_pfx.'_hero_section_bg_video_format'];
				$bg_video_src = $be_themes_data[$hero_section_pfx.'_hero_section_bg_video_url'];
				$bg_video_mute = ($be_themes_data[$hero_section_pfx.'_hero_section_video_mute']) ? "unmuted" : "muted" ;
				if(!empty($be_themes_data[$hero_section_pfx.'_hero_section_overlay']) && isset($be_themes_data[$hero_section_pfx.'_hero_section_overlay']) && $be_themes_data[$hero_section_pfx.'_hero_section_overlay'] ) {
					$bg_overlay = $be_themes_data[$hero_section_pfx.'_hero_section_overlay'];
				} else {
					$bg_overlay = 0;
				}
				$overlay_color = $be_themes_data[$hero_section_pfx.'_hero_section_bg_overlay']['color'];
				$overlay_opacity = $be_themes_data[$hero_section_pfx.'_hero_section_bg_overlay']['alpha'];
				$content = stripslashes_deep(htmlspecialchars_decode( $be_themes_data[$hero_section_pfx.'_hero_section_content'], ENT_QUOTES ) );
				if(!empty($be_themes_data[$hero_section_pfx.'_hero_section_container_wrap']) && isset($be_themes_data[$hero_section_pfx.'_hero_section_container_wrap']) && 'yes' == $be_themes_data[$hero_section_pfx.'_hero_section_container_wrap'] ) {
					$section_container_wrap = $be_themes_data[$hero_section_pfx.'_hero_section_container_wrap'];
					$be_wrap = 'be-wrap';
				} else {
					$section_container_wrap = 0;
					$be_wrap = '';
				}
				if((isset( $bg_stretch ) && 'cover' == $bg_stretch) || (isset( $bg_animation ) && $bg_animation == 'be-bg-parallax')) {
					$bg_stretch = 'be-bg-cover';
				} else {
					$bg_stretch = '';
				}
				$background = '';
				if(empty( $bg_image  ) ) {
					if( ! empty( $bg_color ) )
						$background = 'background-color: '.$bg_color.';';	
				} else {
					$attachment_url = $bg_image;
					if( ! empty( $attachment_url ) ) {
						if((isset( $bg_animation ) && $bg_animation == 'be-bg-parallax') || (isset( $bg_animation ) && $bg_animation == 'be-bg-mousemove-parallax')) {
							$bg_position = 'center center';
						}
						if(isset( $bg_animation ) && $bg_animation == 'be-bg-parallax') {
							$bg_repeat = 'no-repeat';
						}
						$background = 'background:'.$bg_color.' url('.$attachment_url.') '.$bg_repeat.' '.$bg_attachment.' '.$bg_position.';';
					}
				}
				$bg_overlay_class = '';
				$bg_video_class = '';
				if( isset( $bg_overlay ) && 1 == $bg_overlay ) {
					$bg_overlay_class = 'be-bg-overlay';
				}    
				if( isset( $bg_video ) && 1 == $bg_video ) {
					$bg_video_class = 'be-video-section';
				}
				$output = '';
				$output .= '<div class="hero-section-wrap be-section '.$full.' '.$hero_section_with_header.' '.$bg_stretch.' '.$bg_animation.' '.$bg_overlay_class.' '.$bg_video_class.' clearfix" style="'.$background.'; height: '.$hero_section_custom_height.'px !important;">';
				if( isset( $bg_video ) && 1 == $bg_video ) {
					$output .= '<video class="be-bg-video" autoplay="autoplay" loop="loop" muted="'.$bg_video_mute.'" preload="auto">';
					if('mp4' == $bg_video_format) {
						$output .= '<source src="'.$bg_video_src.'" type="video/mp4">';
					}
					else if('ogg' == $bg_video_format) {
						$output .= '<source src="'.$bg_video_src.'" type="video/ogg">';
					}
					if('webm' == $bg_video_format) {
						$output .= '<source src="'.$bg_video_src.'" type="video/webm">';
					}
					$output .= '</video>';
				}	   
				if( isset( $bg_overlay ) && 1 == $bg_overlay ) {
					$opacity = '';
					if($overlay_opacity) {
						$opacity .= '-ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity='.floatval($overlay_opacity).');';
						$opacity .= 'filter: alpha(opacity='.floatval($overlay_opacity).');';
						$opacity .= '-moz-opacity: '.floatval($overlay_opacity/100).';';
						$opacity .= '-khtml-opacity: '.floatval($overlay_opacity/100).';';
						$opacity .= 'opacity: '.floatval($overlay_opacity/100).';';
					}
					$output .= '<div class="section-overlay" style="background: '.$overlay_color.'; '.$opacity.'"></div>';
				}
				$output .= '<div class="be-row '.$be_wrap.'">';
				$output .= '<div class="hero-section-inner-wrap">';
				$output .= '<div class="hero-section-inner">'.be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) ).'</div>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
				echo $output;
				echo '</div>';
			}
			echo '</div>';
		} 
		// else {
		// 	echo '<div class="header-hero-section"></div>';
		// }
	} 
	else {
		$hero_section = get_post_meta($post_id, 'be_themes_hero_section', true);
		$sticky_sections = get_post_meta($post_id, 'be_themes_sticky_sections', true);
		if( ( $single_blog_style && is_singular( 'post' ) ) || ( isset( $sticky_sections ) && !empty( $sticky_sections ) ) ) {
			$hero_section = 'none';
		}
		if($hero_section && !empty($hero_section) && $hero_section != 'none') {
			echo '<div class="header-hero-section" id="hero-section">';
			if($hero_section == 'slider') {
				$hero_section_slider = get_post_meta($post_id, 'be_themes_hero_section_slider_shortcode', true);
					if($hero_section_slider) {
						echo do_shortcode($hero_section_slider);
					}
			}
			if($hero_section == 'custom') {
				echo '<div class="header-hero-custom-section">';
				$hero_section_position = get_post_meta($post_id, 'be_themes_hero_section_position', true);
				if($hero_section_position == 'before'){
					$hero_section_with_header = 'full-'.get_post_meta($post_id, 'be_themes_hero_section_with_header', true);
				}else{
					$hero_section_with_header = '';
				}
				$hero_section_custom_height = get_post_meta($post_id, 'be_themes_hero_section_custom_height', true);
				if( !empty( $hero_section_custom_height ) ) {
					$full = '';
				} else {
					$full = 'full-screen-height';
				}

				$bg_color = get_post_meta($post_id, 'be_themes_hero_section_bg_color', true);
				$bg_image = get_post_meta($post_id, 'be_themes_hero_section_bg_image', true);
				$bg_repeat = get_post_meta($post_id, 'be_themes_hero_section_bg_repeat', true);
				$bg_attachment = get_post_meta($post_id, 'be_themes_hero_section_bg_attachment', true);
				$bg_position = get_post_meta($post_id, 'be_themes_hero_section_bg_position', true);
				$bg_stretch = get_post_meta($post_id, 'be_themes_hero_section_bg_scale', true);
				$bg_animation = get_post_meta($post_id, 'be_themes_hero_section_bg_animation', true);
				$bg_canvas_type = get_post_meta($post_id,'be_themes_hero_section_bg_animation_canvas',true);
				$bg_video = get_post_meta($post_id, 'be_themes_hero_section_bg_video', true);
				$bg_video_mp4_src = get_post_meta($post_id, 'be_themes_hero_section_bg_video_mp4', true);
				$bg_video_mp4_src_ogg = get_post_meta($post_id, 'be_themes_hero_section_bg_video_ogg', true);
				$bg_video_mp4_src_webm = get_post_meta($post_id, 'be_themes_hero_section_bg_video_webm', true);
				$bg_overlay = get_post_meta($post_id, 'be_themes_hero_section_overlay', true);
				$overlay_color = get_post_meta($post_id, 'be_themes_hero_section_bg_overlay_color', true);
				$overlay_opacity = get_post_meta($post_id, 'be_themes_hero_section_bg_overlay_opacity', true);
				$content = get_post_meta($post_id, 'be_themes_hero_section_content', true);
				$section_container_wrap = get_post_meta($post_id, 'be_themes_hero_section_container_wrap', true);
				$bg_canvas_color1 = get_post_meta($post_id,'be_themes_hero_section_canvas_color1',true);
				$bg_canvas_color2 = get_post_meta($post_id,'be_themes_hero_section_canvas_color2',true);
				$bg_canvas_color3 = get_post_meta($post_id,'be_themes_hero_section_canvas_color3',true);
				$bg_canvas_color4 = get_post_meta($post_id,'be_themes_hero_section_canvas_color4',true);
				$bg_canvas_color5 = get_post_meta($post_id,'be_themes_hero_section_canvas_color5',true);

				if($section_container_wrap == 'yes') {
					$be_wrap = 'be-wrap';
				} else {
					$be_wrap = '';
				}
				
				if(is_page_template('page-splitscreen-left.php') || is_page_template('page-splitscreen-right.php')){
					$bg_animation = '';
					$bg_attachment = '';
					$hero_section_custom_height = '';
					$full = 'full-screen-height';
				}

				$background = '';
				if( !isset($bg_animation) || empty($bg_animation) || $bg_animation == 'none' ) {
	    			$bg_animation = '';
	    		}
	    		if((isset( $bg_stretch ) && 1 == $bg_stretch) || (isset( $bg_animation ) && $bg_animation == 'be-bg-parallax')) {
					$bg_stretch = 'be-bg-cover';
				} else {
					$bg_stretch = '';
				}
				if(empty( $bg_image  ) ){
					if( ! empty( $bg_color ) )
						$background = 'background-color: '.$bg_color.';';	
				} else{
					$attachment_info=wp_get_attachment_image_src($bg_image,'full');
					$attachment_url = $attachment_info[0];
					if( ! empty( $attachment_url ) ) {
						if((isset( $bg_animation ) && $bg_animation == 'be-bg-parallax') || (isset( $bg_animation ) && $bg_animation == 'be-bg-mousemove-parallax')) {
							$bg_position = 'center center';
						}
						if(isset( $bg_animation ) && $bg_animation == 'be-bg-parallax') {
							$bg_repeat = 'no-repeat';
						}
						$background = 'background:'.$bg_color.' url('.$attachment_url.') '.$bg_repeat.' '.$bg_attachment.' '.$bg_position.';';
					}
				}
				$bg_overlay_class = '';
				$bg_video_class = '';
				if( isset( $bg_overlay ) && 1 == $bg_overlay ) {
					$bg_overlay_class = 'be-bg-overlay';
				}    
				if( isset( $bg_video ) && 1 == $bg_video ) {
					$bg_video_class = 'be-video-section';
				}

				$output = '';
				$output .= '<div class="hero-section-wrap be-section '.$full.' '.$hero_section_with_header.' '.$bg_stretch.' '.$bg_animation.' '.$bg_overlay_class.' '.$bg_video_class.' clearfix" style="'.$background.'; height: '.$hero_section_custom_height.'px;">';
				if( isset( $bg_video ) && 1 == $bg_video ) {
					$output .= '<video class="be-bg-video" autoplay="autoplay" loop="loop" muted="muted" preload="auto">';
					if($bg_video_mp4_src) {
						$output .= '<source src="'.$bg_video_mp4_src.'" type="video/mp4">';
					}
					if($bg_video_mp4_src_ogg) {
						$output .= '<source src="'.$bg_video_mp4_src_ogg.'" type="video/ogg">';
					}
					if($bg_video_mp4_src_webm) {
						$output .= '<source src="'.$bg_video_mp4_src_webm.'" type="video/webm">';
					}
					$output .= '</video>';
				}	   
				if( isset( $bg_overlay ) && 1 == $bg_overlay ) {
					$opacity = '';
					if($overlay_opacity) {
						$opacity .= '-ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity='.floatval($overlay_opacity).');';
						$opacity .= 'filter: alpha(opacity='.floatval($overlay_opacity).');';
						$opacity .= '-moz-opacity: '.floatval($overlay_opacity/100).';';
						$opacity .= '-khtml-opacity: '.floatval($overlay_opacity/100).';';
						$opacity .= 'opacity: '.floatval($overlay_opacity/100).';';
					}
					$output .= '<div class="section-overlay" style="background: '.$overlay_color.'; '.$opacity.'"></div>';
				}
				if( isset( $bg_canvas_type ) && !empty($bg_canvas_type) && 'none' != $bg_canvas_type ) {
					$output .= '<canvas id="'.$bg_canvas_type.'" data-color1="'.$bg_canvas_color1.'" data-color2="'.$bg_canvas_color2.'" data-color3="'.$bg_canvas_color3.'" data-color4="'.$bg_canvas_color4.'" data-color5="'.$bg_canvas_color5.'"></canvas>';
				}  
				$output .= '<div class="be-row '.$be_wrap.'">';
				$output .= '<div class="hero-section-inner-wrap">';
				$output .= '<div class="hero-section-inner">'.be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) ).'</div>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
				echo $output;
				echo '</div>';
			}
			$section_nav = get_post_meta($post_id, 'be_themes_section_nav_id', true);
			$section_nav_icon_color = get_post_meta($post_id, 'be_themes_section_nav_icon_color', true);
			$section_nav_icon = get_post_meta($post_id, 'be_themes_section_nav_icon', true);
			if(isset( $section_nav ) && !empty($section_nav)) {
				if( 'icon-mouse-wheel' == $section_nav_icon ) {
					echo '<a href="#'.$section_nav.'" class="section-navigation"><span class="mouse-icon" style="border-color: '.$section_nav_icon_color.'"><span class="wheel" style="background-color: '.$section_nav_icon_color.'"></span></span></a>';
				} else {
					echo '<a href="#'.$section_nav.'" class="section-navigation"><i class="font-icon '.$section_nav_icon.'" style="color: '.$section_nav_icon_color.'"></i></a>';
				}
			}
			echo '</div>';
		} 
		// else {
		// 	echo '<div class="header-hero-section"></div>';
		// }
	}
?>