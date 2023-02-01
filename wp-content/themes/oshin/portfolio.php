<?php
/*
 *
 * Template Name: Portfolio
 *
*/
$portfolio_style = get_post_meta(get_the_ID(), 'be_themes_portfolio_template_style', true);
if(!isset($portfolio_style) || empty($portfolio_style)) {
	$portfolio_style = 'style1';
}
if($portfolio_style == 'be-ribbon-carousel' || $portfolio_style == 'be-center-carousel'){
	$portfolio_style = 'flickity';
}
get_header();
	while (have_posts() ) : the_post();
		get_template_part( 'portfolio/single', $portfolio_style.'-portfolio' );
	endwhile;
get_footer();