<?php
/*
 *
 * Template Name: Page With Sidebar
 *
*/
get_header();
global $be_themes_options; 
while(have_posts()): the_post(); 
	$sidebar = get_post_meta( get_the_ID(), 'be_themes_page_layout', true );
	if(empty( $sidebar) ) {
		$sidebar = 'right';
	} ?>
	<section id="content" class="<?php echo esc_attr( $sidebar ); ?>-sidebar-page">
		<div id="content-wrap" class="be-wrap clearfix">
			<section id="page-content" class="content-single-sidebar">
				<div class="clearfix">
					<?php the_content(); ?>
				</div> <!--  End Page Content -->
				<?php if( isset($be_themes_data['comments_on_page']) && $be_themes_data['comments_on_page'] == 1 ) : ?>
					<div class="be-themes-comments be-row be-wrap">
						<?php comments_template( '', true ); ?>
					</div> <!--  End Optional Page Comments -->
				<?php endif; ?>						
			</section>
			<section id="<?php echo esc_attr( $sidebar ); ?>-sidebar" class="sidebar-widgets">
				<?php get_sidebar(); ?>
			</section>
		</div>
	</section> <?php 
endwhile;
get_footer(); ?>