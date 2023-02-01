<?php
/**
* The template for displaying Category Archive pages.
* 
*/
?>
<?php 
get_header(); 
global $be_themes_data;

if(!isset($be_themes_data['hide_breadcrumbs']) || empty($be_themes_data['hide_breadcrumbs']) || ( isset($be_themes_data['hide_breadcrumbs']) && (0 == $be_themes_data['hide_breadcrumbs']) ) ){
	get_template_part( 'page-breadcrumb' );	
}

$be_wrap = 'be-wrap';
$gutter_width = (!isset($be_themes_data['portfolio_grid_gutter']) && empty($be_themes_data['portfolio_grid_gutter'])) ? '30' : $be_themes_data['portfolio_grid_gutter'] ;
// Grid Style
if(isset($be_themes_data['portfolio_grid_style']) && !empty($be_themes_data['portfolio_grid_style']) && 'full' == $be_themes_data['portfolio_grid_style']){
	$be_wrap = '';
}
// Portfolio Column
if(isset($be_themes_data['portfolio_col']) && !empty($be_themes_data['portfolio_col'])) {
	$portfolio_col = $be_themes_data['portfolio_col'];
} else {
	$portfolio_col = 'three';
}
// Hover Color
if(isset($be_themes_data['portfolio_hover']) && !empty($be_themes_data['portfolio_hover'])) {
	$portfolio_hover_color = $be_themes_data['portfolio_hover']['color'];
} else {
	$portfolio_hover_color = $be_themes_data['color_scheme'];
}
// Hover Opacity
if(isset($be_themes_data['portfolio_hover']) && !empty($be_themes_data['portfolio_hover'])) {
	$portfolio_hover_opacity = $be_themes_data['portfolio_hover']['alpha'];
} else {
	$portfolio_hover_opacity = 80;
}
if(isset($be_themes_data['portfolio_style']) && !empty($be_themes_data['portfolio_style'])) {
	$portfolio_style = $be_themes_data['portfolio_style'];
} else {
	$portfolio_style = 'portfolio';
}
// For Backward Compatibility for Grid Style
if(isset($be_themes_data['portfolio_style']) && $be_themes_data['portfolio_style'] != 'portfolio'){
	$be_wrap = '';
}
?>
<section id="content" class="portfolio-archives <?php echo ($portfolio_style != 'portfolio_full_screen') ? 'no-sidebar-page' : ''; ?>">
	<div id="content-wrap" class="clearfix <?php echo ($portfolio_style == 'portfolio') ? 'be-wrap' : ''; ?>"> 
		<section id="page-content" class="content-no-sidebar">
			<div class="clearfix">
				<?php
					$term =	$wp_query->queried_object;
					if( have_posts() ) :
						// if(isset($be_themes_data['portfolio_col']) && !empty($be_themes_data['portfolio_col'])) {
						// 	$portfolio_col = $be_themes_data['portfolio_col'];
						// } else {
						// 	$portfolio_col = 'three';
						// }
						// if(isset($be_themes_data['portfolio_hover']) && !empty($be_themes_data['portfolio_hover'])) {
						// 	$portfolio_hover_color = $be_themes_data['portfolio_hover']['color'];
						// } else {
						// 	$portfolio_hover_color = $be_themes_data['color_scheme'];
						// }
						// if(isset($be_themes_data['portfolio_hover']) && !empty($be_themes_data['portfolio_hover'])) {
						// 	$portfolio_hover_opacity = $be_themes_data['portfolio_hover']['alpha'];
						// } else {
						// 	$portfolio_hover_opacity = 80;
						// }
						// if($portfolio_style == 'portfolio' && $portfolio_col == 'five') {
						// 	$portfolio_col = 'three';
						// }
						// if(($portfolio_style == 'portfolio_full_screen' || $portfolio_style == 'portfolio_full_screen_with_gutter') && $portfolio_col == 'two') {
						// 	$portfolio_col = 'three';
						// }
						// if($portfolio_style == 'portfolio_full_screen') {
						// 	$gutter_width = 0 ;
						// }else {
						// 	$gutter_width = 30 ;
						// }
						echo do_shortcode('[portfolio col= "'.$portfolio_col.'" gutter_width = "'.$gutter_width.'" show_filters= "no" filter = "categories" tax_name="portfolio_tags" tags= "'.$term->slug.'" items_per_page="-1" pagination="none" overlay_color= "'.$portfolio_hover_color.'"]');
					else:
						echo '<p class="inner-content">'.__( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'oshin' ).'</p>';
					endif;
				?>
			</div>
		</section>
	</div>
</section>

<?php get_footer(); ?>