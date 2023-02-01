<?php
get_header();
$page_id = be_get_page_id();
global $be_themes_data, $blog_attr;
$blog_attr = array();
$items_per_page = get_option( 'posts_per_page' );
$blog_attr['gutter_style'] = ((!isset($be_themes_data['blog_gutter_style'])) || empty($be_themes_data['blog_gutter_style'])) ? 'style1' : $be_themes_data['blog_gutter_style'];
$blog_attr['gutter_width'] = ((!isset($be_themes_data['blog_gutter_width'])) || empty($be_themes_data['blog_gutter_width'])) ? intval(40) : intval( $be_themes_data['blog_gutter_width'] );
$blog_attr['pagination_style'] = ((!isset($be_themes_data['blog_pagination_style'])) || empty($be_themes_data['blog_pagination_style'])) ? 'normal' : $be_themes_data['blog_pagination_style'];
$blog_attr['style'] = ((!isset($be_themes_data['blog_style'])) || empty($be_themes_data['blog_style'])) ? 'style1' : $be_themes_data['blog_style'];
$blog_column = ((!isset($be_themes_data['blog_column'])) || empty($be_themes_data['blog_column'])) ? 'three-col' : $be_themes_data['blog_column'];
$col = explode('-', $blog_column);
$sidebar = ((!isset($be_themes_data['blog_sidebar'])) || empty($be_themes_data['blog_sidebar'])) ? 'right' : $be_themes_data['blog_sidebar'];
$be_wrap = 'be-wrap';
if( $blog_attr['style'] == 'style3' ) {
	$sidebar = 'no';
	$blog_style_class = $blog_attr['style'].'-blog portfolio-container clickable clearfix';
	$be_wrap = (isset($be_themes_data['blog_grid_style']) && !empty($be_themes_data['blog_grid_style']) && 'full' == $be_themes_data['blog_grid_style'] ) ? '' : 'be-wrap' ;
} else {
	$blog_style_class = $blog_attr['style'].'-blog';
}
if($blog_attr['style'] == 'style3' && $blog_attr['gutter_style'] == 'style2') {
	$portfolio_wrap_style = 'style="margin-left: -'.$blog_attr['gutter_width'].'px;"';
	$portfolio_pagination_style = 'style="margin-left: '.$blog_attr['gutter_width'].'px; margin-top: '.(40-(intval($blog_attr['gutter_width']) > 40) ? 0 : intval($blog_attr['gutter_width'])).'px;"';
} else {
	$portfolio_pagination_style = $portfolio_wrap_style = 'style="margin-left: 0px;"';
}
?>
<section id="blog-content" class="no-sidebar-page">
	<div class="clearfix">
		<?php
			if(isset($be_themes_data['blog_page_show_page_title_module']) && !empty($be_themes_data['blog_page_show_page_title_module']) && $be_themes_data['blog_page_show_page_title_module'] == 1) {
				get_template_part( 'page-breadcrumb' );
			}
		?>
	</div> <!--  End Page Content -->
</section>
<section id="content" class="<?php echo esc_attr( $sidebar ); ?>-sidebar-page">
	<div id="content-wrap" class="<?php echo $be_wrap; ?> clearfix"> 
		<section id="page-content" class="<?php echo ($blog_attr['style'] == 'style3' || $sidebar == 'no') ? 'content-no-sidebar' : 'content-single-sidebar'; ?>">
			<div class="portfolio-all-wrap">
				<div class="<?php echo ($blog_attr['style'] == 'style3') ? 'portfolio full-screen full-screen-gutter '.$blog_attr['gutter_style'].'-gutter '.$blog_column : ''; ?>" data-col="<?php echo $col[0]; ?>" data-gutter-width="<?php echo esc_attr( $blog_attr['gutter_width'] ); ?>" data-showposts="<?php echo esc_attr( $items_per_page ); ?>" data-paged="2" data-action="get_blog" <?php echo $portfolio_wrap_style; ?> >
					<div class="clearfix <?php echo esc_attr( $blog_style_class ); ?>">
						<?php 			
						if( have_posts() ) : 
							while ( have_posts() ) : the_post();
								$blog_style = be_get_blog_loop_style( $blog_attr['style'] );
								get_template_part( 'blog/loop', $blog_style );
							endwhile;
						else:
							echo '<p class="element element-empty-message inner-content">'.__( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'oshin' ).'</p>';
						endif;
						?>
					</div>
					<?php get_blog_pagination($blog_attr, $portfolio_pagination_style); ?>
				</div>
			</div>
		</section> <?php
		if($blog_attr['style'] != 'style3' && $sidebar != 'no') { ?>
			<section id="<?php echo esc_attr( $sidebar ); ?>-sidebar" class="sidebar-widgets">
				<?php get_sidebar(); ?>
			</section> <?php 
		} ?>
	</div>
</section>					
<?php get_footer(); ?>