<?php
	global $be_themes_data;
	$slider_type = get_post_meta(get_the_ID(),'be_themes_portfolio_single_page_style',true);
	$gutter_width = get_post_meta(get_the_ID(),'be_themes_horizontal_carousel_slider_gutter_width', true);
	$slider_height = get_post_meta(get_the_ID(),'be_themes_horizontal_carousel_slider_height', true);
	$attachments = get_post_meta(get_the_ID(),'be_themes_single_portfolio_slider_images');
	$overlay = get_post_meta( get_the_ID(), 'be_themes_single_horizontal_slider_enable_overlay', true );

	$autoslide_control = get_post_meta( get_the_ID(), 'be_themes_swiper_slider_autoslide_control', true );
	$autoslide_duration = get_post_meta( get_the_ID(), 'be_themes_swiper_slider_autoslide_duration', true );
	$freeScroll_control = get_post_meta( get_the_ID(), 'be_themes_single_horizontal_vertical_slider_normal_scroll', true );
	$keyboard_control = get_post_meta( get_the_ID(), 'be_themes_swiper_slider_keyboard_control', true );
	$loop_control = get_post_meta( get_the_ID(), 'be_themes_swiper_slider_loop_control', true );
	$mobile_view = get_post_meta( get_the_ID(), 'be_themes_swiper_slide_one_by_one_mobile', true );
	$nav_arrows = get_post_meta( get_the_ID(), 'be_themes_swiper_slider_nav_arrows', true );
	$show_info_box = get_post_meta( get_the_ID(), 'be_themes_single_show_info_box', true );
	$info_box_style = get_post_meta( get_the_ID(), 'be_themes_info_box_style', true );
	$info_box = '';
	$autoslide_duration = (isset($autoslide_control) && $autoslide_control == 1 && isset($autoslide_duration) && intval($autoslide_duration) > 0) ? $autoslide_duration : 5000;
	
	// if($slider_type == 'be-fullscreen' || $slider_type == 'be-centered'){
	// 	if(!isset($nav_arrows) || (isset($nav_arrows) && $nav_arrows == 1))
	// }
	// if(isset($nav_arrows) && !empty($nav_arrows) && $nav_arrows == 1){
	// 	$nav_arrows = "data-nav-arrow = 1";
	// }else{
	// 	$nav_arrows = ""
	// }
	if( ($slider_type != 'style2') && ($slider_type != 'style3') && isset($freeScroll_control) && $freeScroll_control == 1){
		$freeScroll_control = 1 ;
		$freeScroll_attr = "data-free-scroll = 1" ; 
	}else{
		$freeScroll_control = 0 ;
		$freeScroll_attr = '';
	}
	if($slider_type == 'style2'){
		$slider_type = 'be-centered';
	}
	if($slider_type == 'style3'){
		$slider_type = 'be-fullscreen';
	}

	$keyboard_control = (isset($keyboard_control) && $keyboard_control == 1) ? "data-keyboard-crtl = 1" : '';
	$loop_control = (isset($loop_control) && $loop_control == 1) ? "data-loop-crtl = 1" : '';
	$autoslide_control = (isset($autoslide_control) && $autoslide_control == 1) ? 'data-auto-play ="'.$autoslide_duration.'"' : 'data-auto-play = 0';
	$mobile_view = (empty($mobile_view) || (!empty($mobile_view) && $mobile_view == 0)) ? 'disable-flickity-mobile' : "enable-flickity-mobile" ;
	$nav_arrows = (!isset($nav_arrows) || (isset($nav_arrows) && $nav_arrows == 1)) ? "data-nav-arrow = 1" : "" ;
	$vimeo = be_has_vimeo( $attachments ) ? 'data-vimeo = "1"' : '';

	if(isset($slider_height) && !empty($slider_height) && $slider_type != 'be-fullscreen') {
		$slider_height = 'data-height="'. esc_attr( $slider_height ) .'"';
	} else {
		$slider_height = 'data-height="100"';
	}
	if(!isset($be_themes_data['slider_navigation_style']) || empty($be_themes_data['slider_navigation_style'])) {
		$arrow_style = 'style1-arrow';
	} else {
		$arrow_style = $be_themes_data['slider_navigation_style'];
	}
	if($arrow_style == 'style1-arrow' || $arrow_style == 'style3-arrow' || $arrow_style == 'style5-arrow'){
		$arrow_style_class = 'arrow-block';
	}else{
		$arrow_style_class = 'arrow-border';
	}
	//Force Mobile View Style if Information Box is choosen to be displayed as "First Slide"
	if(($slider_type == 'be-ribbon-carousel' || $slider_type == 'be-center-carousel') && $show_info_box == 1 && $info_box_style == 'starting_slide'){
		$info_box = 'show-info-box';
		$mobile_view = 'disable-flickity-mobile';
	}

	//Overlay and Guuter Width will take effect only on Carousel Sliders
	if($slider_type == 'be-ribbon-carousel' || $slider_type == 'be-center-carousel'){
		if(isset($overlay) && $overlay == 1 && $freeScroll_control == 0) {
			$overlay_color = get_post_meta( get_the_ID(), 'be_themes_single_horizontal_slider_overlay_color', true );
			$overlay_opacity = get_post_meta( get_the_ID(), 'be_themes_single_horizontal_slider_overlay_color_opacity', true );
			if(!isset($overlay_opacity) || empty($overlay_opacity)) {
				$overlay_opacity = 85;
			}
			if(isset($overlay_color) && !empty($overlay_color)) {
				$overlay_color = be_themes_hexa_to_rgb( $overlay_color );
				$thumb_overlay_color = 'rgba('.$overlay_color[0].','.$overlay_color[1].','.$overlay_color[2].','.(intval($overlay_opacity) / 100 ).')';	
			} else {
				$thumb_overlay_color = '';
			}
			$overlay_flag = 1;
		}else{
			$overlay_flag = 0;
		}
	}else{
		$overlay_flag = 0;
		$gutter_width = 0;
	}

?>
<?php 
	if ( post_password_required( get_the_ID() ) ) {
		$content  = get_the_password_form();
	    echo '<div class="be-wrap clearfix be-password-protect-wrap">'.$content.'</div>';
	} else { ?>
	<div id="content" class="portfolio-sliders <?php echo $slider_type .' '. $arrow_style_class .' '. $arrow_style; ?>" <?php echo $slider_height ; ?> data-gutter-width="<?php echo $gutter_width; ?>" data-slider-type="<?php echo $slider_type; ?>">
		<div class="main-gallery be-flickity <?php echo $mobile_view; ?>" <?php echo $nav_arrows .' '. $autoslide_control .' '. $freeScroll_attr .' '. $keyboard_control .' '. $loop_control . ' ' . $vimeo ; ?>>
			<?php
				$count = 1;
				if(!empty($attachments)) {
					if($info_box == 'show-info-box'){?>
						<div class="gallery_content_slide simplebar">
							<div class="simplebar-content">
								<?php the_content(); ?>
							</div>
						</div>
					<?php 
					}
					foreach ( $attachments as $attachment_id ) {

						$attach_img = wp_get_attachment_image_src($attachment_id, 'full');
						$video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);
						$attachment_info = be_wp_get_attachment( $attachment_id );
						if($video_url) {
							$data_source = 'video';
							$data_img_width = 'data-image-width="16"';
							$data_img_height = 'data-image-height="9"';
							echo '<div class="img-wrap" '.$data_img_width. ' '.$data_img_height. ' style="margin-left: '.$gutter_width.'px;">';
							echo be_carousel_video($video_url);
							if($overlay_flag == 1) {
								echo '<div class="img-overlay-wrap" style="background: '.$thumb_overlay_color.';"></div>';								
							}
						} else {
							$data_source = $attach_img[0];
							$data_img_width = 'data-image-width="'.$attach_img[1].'"';
							$data_img_height = 'data-image-height="'.$attach_img[2].'"';
							echo '<div class="img-wrap" '.$data_img_width. ' '.$data_img_height. ' style="margin-left: '.$gutter_width.'px;">';
							echo '<img data-flickity-lazyload="'.$data_source.'" alt="'.$attachment_info['alt'].'" />';
							if($overlay_flag == 1) {
								echo '<div class="img-overlay-wrap" style="background: '.$thumb_overlay_color.';"></div>';								
							}
						}
						/******************************
    						Captions
						******************************/ 
						$attachment_details = be_wp_get_attachment($attachment_id);
						if(isset($attachment_details['description']) && !empty($attachment_details['description'])) {
							$external_link = get_post_meta( $attachment_id, 'be_themes_external_link', true );
							if(!isset($external_link) || empty($external_link)) {
								$external_link = '#';
							}
							echo '<div class="attachment-details attachment-details-custom-slider animated"><a href="'.$external_link.'" target="_blank">'.$attachment_details['description'].'</a></div>';
						}
						echo '</div>';
						$count++;
					}
				}
			?>
		</div>
		<?php 
			get_template_part( 'portfolio/gallery', 'content' );
			be_flickity_thumb_carousel($mobile_view);
		?>
	</div><?php
} ?>