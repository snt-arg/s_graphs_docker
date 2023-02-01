<?php
/*
	The template for displaying a Portfolio Item.
*/
get_header();
global $be_themes_data;
$portoflio_title_nav_style = $be_themes_data['portfolio_title_nav_style'];
$portfolio_title_nav = get_post_meta( get_the_ID(), 'be_themes_portfolio_title_nav', true);
$portfolio_home_page = get_post_meta( get_the_ID(), 'be_themes_portfolio_home_page', true); //Get link from Meta Options
$portfolio_home_page = ($portfolio_home_page == '' ? $be_themes_data['portfolio_home_page'] : $portfolio_home_page) ; //Get link from Options panel if not present in Meta Options is not present
$portfolio_catg_traversal = (1 == get_post_meta( get_the_ID(), 'be_themes_traverse_catg', true) ? true : false);
$single_portfolio_style = get_post_meta(get_the_ID(), 'be_themes_portfolio_single_page_style', true);

if($single_portfolio_style == 'style2' || $single_portfolio_style == 'style3' || $single_portfolio_style == 'be-ribbon-carousel' || $single_portfolio_style == 'be-center-carousel'){
	$single_portfolio_style = 'flickity';
}
if( 'fixed-overflow-left' == $single_portfolio_style || 'fixed-overflow-right' == $single_portfolio_style ) {
	$single_portfolio_style = 'fixed-overflow';
}

if ((isset($portfolio_title_nav) && 1 == $portfolio_title_nav) && ('style1' != $single_portfolio_style) && ('style4' != $single_portfolio_style)  && ('flickity' != $single_portfolio_style)) { ?>
		<div id="portfolio-title-nav-wrap" class=" <?php echo esc_attr( $portoflio_title_nav_style ) ;?> clearfix">
			<div <?php echo ($portoflio_title_nav_style != 'style2' ? "class=be-wrap" : "") ; ?> >
				<h6 class="portfolio-title-nav"><?php echo get_the_title(); ?></h6>
				<ul class="portfolio-nav">
					<!-- Previous Post Link -->
					<li>
					<?php if($portfolio_catg_traversal == true) {
						next_post_link('%link','<i class="font-icon icon-arrow_left"></i>',true,' ','portfolio_categories'); 
					}else {
						next_post_link('%link','<i class="font-icon icon-arrow_left"></i>'); 
					}?>
					</li>
					<!-- Home Page Grid -->
					<?php if ($portfolio_home_page != '') { ?>
						<li class="home-grid-wrapper"><a href="<?php echo esc_url( $portfolio_home_page ); ?>"><div class="home-grid-icon"><span></span><span></span><span></span><span></span><span></span><span></span></div></a></li><?php
					}?>
					<!-- Next Post Link -->
					<li>
					<?php if($portfolio_catg_traversal == true) {
						previous_post_link('%link','<i class="font-icon icon-arrow_right"></i>',true,' ','portfolio_categories'); 
					}else {
						previous_post_link('%link','<i class="font-icon icon-arrow_right"></i>'); 
					}?>
					</li>

				</ul>
			</div>
		</div>	<?php
}

if($single_portfolio_style == 'lightbox' ||  $single_portfolio_style == 'lightbox-gallery' ) {
	$single_portfolio_style = 'normal';
}

	while (have_posts() ) : the_post();
		get_template_part( 'portfolio/single', $single_portfolio_style );
	endwhile;
get_footer();
?>