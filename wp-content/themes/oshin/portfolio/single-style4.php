<?php
	$overlay = get_post_meta( get_the_ID(), 'be_themes_single_horizontal_slider_enable_overlay', true );
	$attachments = get_post_meta(get_the_ID(),'be_themes_single_portfolio_slider_images');
	$slide_height = get_post_meta( get_the_ID(), 'be_themes_portfolio_slide_height', true );
	$normal_scroll = get_post_meta( get_the_ID(), 'be_themes_single_horizontal_vertical_slider_normal_scroll', true );
	if($normal_scroll == 1) {
		$normal_scroll == 'normal-scroll';
	}
	if(!isset($slide_height) || empty($slide_height)) {
		$slide_height = 100;
	}
	global $be_themes_data;
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
?>
<?php 
	if ( post_password_required( get_the_ID() ) ) {
		$content  = get_the_password_form();
	    echo '<div class="be-wrap clearfix be-password-protect-wrap">'.$content.'</div>';
	} else { ?>	
<div id="content" class="gallery-all-container resized <?php echo $arrow_style_class .' '. $arrow_style; ?>">	
	<div id="gallery-container-wrap" class="clearfix" <?php echo be_has_vimeo( $attachments ) ? 'data-vimeo = "1"' : ''; ?>>
		<div id="gallery-container" class="vertical-carousel <?php echo esc_attr( $normal_scroll ); ?>">
			<?php
				if(!empty($attachments)) {				
					foreach ( $attachments as $attachment_id ) {					
						$attach_img = wp_get_attachment_image_src($attachment_id, 'full');					
						$video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);					
						if($video_url) {						
							if( function_exists( 'be_gdpr_privacy_ok' ) ? be_gdpr_privacy_ok('youtube') : true ){
								$data_source = 'video';
							}else{
								$video_details = be_get_video_details($video_url);
								$data_source = $video_details['thumb_url'];
							}		
						} else {						
							$data_source = $attach_img[0];					
						}					
						echo '<div class="placeholder style4_placehloder load center show-title" data-source="'.$data_source.'" style="height: '.$slide_height.'">';					
						if($video_url) {						
							echo be_carousel_video($video_url);					
						}
						if(isset($overlay) && $overlay == 1) {
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
							echo '<div class="overlay_placeholder" style="background: '.$thumb_overlay_color.';"></div>';
						}
						$attachment_details = be_wp_get_attachment($attachment_id);
						if(isset($attachment_details['description']) && !empty($attachment_details['description'])) {
							$external_link = get_post_meta( $attachment_id, 'be_themes_external_link', true );
							if(!isset($external_link) || empty($external_link)) {
								$external_link = '#';
							}
							echo '<div class="attachment-details attachment-details-custom-slider special-subtitle animated"><a href="'.$external_link.'" target="_blank">'.$attachment_details['description'].'</a></div>';
						}
						echo '</div>';				
					}			
				}
			?>
		</div>
	</div>
	<?php 
		get_template_part( 'portfolio/gallery', 'content' );
		be_slider_carousel();
	?>
</div>
<?php } ?>