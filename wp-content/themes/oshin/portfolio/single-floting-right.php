<?php
	global $be_themes_data;
	$be_pb_class = 'be-wrap page-builder';
	$be_pb_disabled = get_post_meta( $post->ID, '_be_pb_disable', true );
	if( !function_exists( 'is_edited_with_tatsu' ) || !is_edited_with_tatsu( get_the_ID() ) ) {
		$be_pb_class = 'be-wrap no-page-builder';
		get_template_part( 'page-breadcrumb' );
	}
?>
<?php 
	if ( post_password_required() ) {
				$content  = get_the_password_form();

			    echo '<div class="be-wrap clearfix be-password-protect-wrap">'.$content.'</div>';
	} else {
?>
<div id="content" class="right-sidebar-page">	
	<div id="content-wrap" class="<?php echo $be_pb_class; ?> clearfix">
		<div id="page-content" class="content-single-sidebar">
			<div class="clearfix">							
				<?php
					$attachments = get_post_meta(get_the_ID(),'be_themes_single_portfolio_slider_images');
					$image_animation = get_post_meta(get_the_ID(),'be_themes_single_portfolio_floting_images_style', true);
					if(!empty($attachments)) {
						foreach ( $attachments as $attachment_id ) {
							$attach_img = wp_get_attachment_image_src($attachment_id, 'full');
							$video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);
							$attachment_info = be_wp_get_attachment( $attachment_id );
							if($video_url) {
								$data_source = 'video';
							} else {
								$data_source = $attach_img[0];
							}
							echo '<p class="be-animate" data-animation="'.$image_animation.'">';
							if($video_url) {
								echo be_carousel_video($video_url);
							} else {
								echo '<img src="'.$data_source.'" style="display: block;" alt="'.$attachment_info['alt'].'" />';
							}
							echo '</p>';
						}
					}
				?>
			</div> <!--  End Page Content -->
		</div>
		<div id="right-sidebar" class="clearfix floting-sidebar">
			<div>
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</div>
<?php 
} //get_template_part( 'portfolio/single', 'navigation' ); 
if( $be_themes_data['portfolio_nav_bottom'] == true ){
	get_template_part( 'portfolio/portfolio', 'navigation' );
}
?>