<?php
/*
 *
 * The default full width template for displaying pages.
 *
*/
get_header();

global $be_themes_data; 
while(have_posts()): the_post();
	$be_pb_class = 'page-builder';
	$be_pb_disabled = get_post_meta( $post->ID, '_be_pb_disable', true );
	$sticky_sections = get_post_meta( $post->ID, 'be_themes_sticky_sections', true );
	$sticky_scroll_type = get_post_meta( $post->ID, 'be_themes_sticky_scroll_type', true );
	$sticky_overlay = get_post_meta( $post->ID, 'be_themes_sticky_overlay', true );
	if( !function_exists( 'is_edited_with_tatsu' ) || !is_edited_with_tatsu( get_the_ID() ) ) {
		$be_pb_class = 'be-wrap no-page-builder';
		get_template_part( 'page-breadcrumb' );
	} ?>
	<div id="content" class="no-sidebar-page">
		<div id="content-wrap" class="<?php echo $be_pb_class; ?>">
			<section id="page-content">
				<div class="clearfix<?php echo ( ( isset( $sticky_sections ) && !empty( $sticky_sections ) ) ? " be-sections-wrap" : ""); ?>" <?php echo ( isset( $sticky_sections ) && !empty( $sticky_sections ) ) ? ( 'data-sticky-scroll = "' . $sticky_scroll_type . '" data-sticky-overlay = "' . $sticky_overlay . '"'  ) : ""; ?> >
					<?php 


						if ( post_password_required() ) {
	       	 				$content  = get_the_password_form();

	       	 			    echo '<div class="be-wrap clearfix be-section-pad">'.$content.'</div>';
	       	 			} else {
							the_content();
						}
					?>
				</div> <!--  End Page Content -->
				<?php if( isset($be_themes_data['comments_on_page']) && $be_themes_data['comments_on_page'] == 1 ) : ?>
					<div class="be-themes-comments be-row be-wrap">
						<?php comments_template( '', true ); ?>
					</div> <!--  End Optional Page Comments -->
				<?php endif; ?>
			</section>
		</div>
	</div>	<?php 
endwhile;
get_footer(); ?>