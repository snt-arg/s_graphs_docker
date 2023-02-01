<?php
	global $be_themes_data;
	$be_pb_class = 'page-builder';
	$be_pb_disabled = get_post_meta( $post->ID, '_be_pb_disable', true );
	$image_width = get_post_meta(get_the_ID(),'be_themes_fixed_sidebar_image_width', true);
	$image_padding = get_post_meta(get_the_ID(),'be_themes_fixed_sidebar_image_padding', true);
	if($image_width == '0' || null == $image_width ){
		$image_width = '70';
	}
	$content_width = 100 - intval($image_width);
	if($image_padding == '0' || null == $image_padding){
		$image_padding = '30';
	}
	if( !function_exists( 'is_edited_with_tatsu' ) || !is_edited_with_tatsu( get_the_ID() ) ) {
		$be_pb_class = 'no-page-builder';
		get_template_part( 'page-breadcrumb' );
	}
?>
<?php 
	if ( post_password_required() ) {
				$content  = get_the_password_form();
			    echo '<div class="be-wrap clearfix be-password-protect-wrap">'.$content.'</div>';
	} else {
?>
<div id="content" class="left-sidebar-page fixed-sidebar-page">	
	<div id="content-wrap" class="<?php echo $be_pb_class; ?> clearfix">
		<div id="page-content" class="content-single-sidebar" style="width:<?php echo $image_width.'%' ?>; padding:<?php echo $image_padding.'px';?>;">
			<div class="clearfix">				
				<?php
					$attachments = get_post_meta(get_the_ID(),'be_themes_single_portfolio_slider_images');
					$image_animation = get_post_meta(get_the_ID(),'be_themes_single_portfolio_floting_images_style', true);
					if(!empty($attachments)) {
						$count = 1;
						foreach ( $attachments as $attachment_id ) {
							$attach_img = wp_get_attachment_image_src($attachment_id, 'full');
							$video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);
							$attachment_info = be_wp_get_attachment( $attachment_id );
							if($video_url) {
								$data_source = 'video';
							} else {
								$data_source = $attach_img[0];
							}
							if($count == count($attachments)) {
								$class = 'margin-bottom-0';
								$image_padding = '0';
							} else {
								$class = '';
							}
							echo '<p class="be-animate '.$class.'" style="margin-bottom:'.$image_padding.'px;" data-animation="'.$image_animation.'">';
							if($video_url) {
								echo be_carousel_video($video_url);
							} else {
								echo '<img src="'.$data_source.'" style="display: block;" alt="'.$attachment_info['alt'].'" />';
							}
							echo '</p>';
							$count++;
						}
					}
				?>
			</div> <!--  End Page Content -->
		</div>
		<div id="left-sidebar" class="clearfix fixed-sidebar" style="width:<?php echo $content_width.'%' ?>;" data-sidebar-width="<?php echo $content_width;?>">
			<div class="fixed-sidebar-content">
				<div class="fixed-sidebar-content-inner simplebar">
					<?php //get_template_part( 'single', 'navigation' ); ?>
					<div class="simplebar-content">
						<?php the_content(); ?>
					</div>
					<?php //get_template_part( 'portfolio/gallery', 'sidebar' ); ?>
				</div>
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