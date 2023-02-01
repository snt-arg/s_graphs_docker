<?php
/*
 *
 * Template Name: Split Screen Left
 *
*/
get_header(); 
global $be_themes_data; 
while(have_posts()): the_post();
	$be_pb_class = 'page-builder';
	$be_pb_disabled = get_post_meta( $post->ID, '_be_pb_disable', true );
	if( !function_exists( 'is_edited_with_tatsu' ) || !is_edited_with_tatsu( get_the_ID() ) ) {
		$be_pb_class = 'be-wrap no-page-builder';
		get_template_part( 'page-breadcrumb' );
	} ?>
	<div id="content" class="page-split-screen-left no-sidebar-page">
		<div id="content-wrap" class="<?php echo $be_pb_class; ?>">
			<section id="page-content">
				<div class="clearfix">
					<?php the_content(); ?>
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