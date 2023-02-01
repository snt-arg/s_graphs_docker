<?php
    global $be_themes_data;
    $be_pb_class = '';
	$single_portfolio_style = get_post_meta(get_the_ID(), 'be_themes_portfolio_single_page_style', true);
	if( 'fixed-overflow-left' == $single_portfolio_style ) {
		$single_portfolio_class = 'left-overflow-page';
	}else{
		$single_portfolio_class = 'right-overflow-page';
	}
	if( !function_exists( 'is_edited_with_tatsu' ) || !is_edited_with_tatsu( get_the_ID() ) ) {
		$be_pb_class = 'no-page-builder';
		get_template_part( 'page-breadcrumb' );
	}
    if ( post_password_required() ) :
        $content  = get_the_password_form();
        echo '<div class="be-wrap clearfix be-password-protect-wrap">'.$content.'</div>';
	else :
?>
<div id="content" class="be-content-overflow fixed-sidebar-page <?php echo $single_portfolio_class;?>">	
	<div id="content-wrap" class="tatsu-wrap <?php echo $be_pb_class; ?> clearfix">
		<div class = "be-content-overflow-inner-wrap">
	        <div id = "be-overflow-image-content" class = "content-single-sidebar" >
	            <div id = "be-overflow-image-content-inner">
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
								echo '<p class="be-animate" data-animation="'.$image_animation.'">';
								if($video_url) {
									echo be_carousel_video($video_url);
								} else {
									echo '<img src="'.$data_source.'" style="display: block;" alt="'.$attachment_info['alt'].'"/>';
								}
								echo '</p>';
								$count++;
							}
						}
	                ?>
	            </div>
			</div>
			<div id = "right-sidebar-wrapper">
				<div id = "right-sidebar" class = "clearfix fixed-sidebar">
					<div class = "fixed-sidebar-content">
						<div class = "fixed-sidebar-content-inner simplebar">
							<div class = "simplebar-content">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<?php
    endif;
    if( $be_themes_data['portfolio_nav_bottom'] == true ){
        get_template_part( 'portfolio/portfolio', 'navigation' );
    }    
?>