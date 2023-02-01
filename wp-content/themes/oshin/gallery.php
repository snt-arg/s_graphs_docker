<?php
/*
 *
 * Template Name: Gallery
 *
*/
$single_portfolio_style = get_post_meta(get_the_ID(), 'be_themes_portfolio_single_page_style', true);
if(!isset($single_portfolio_style) || empty($single_portfolio_style)) {
	$single_portfolio_style = 'style1';
}
if($single_portfolio_style == 'style2' || $single_portfolio_style == 'style3' || $single_portfolio_style == 'be-ribbon-carousel' || $single_portfolio_style == 'be-center-carousel'){
	$single_portfolio_style = 'flickity';
}
get_header();
	while (have_posts() ) : the_post();
		get_template_part( 'portfolio/single', $single_portfolio_style );
	endwhile;
get_footer();