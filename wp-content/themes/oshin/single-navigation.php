<?php
/*
	The template for displaying a Portfolio Item.
*/
global $be_themes_data;
$portfolio_home_page = get_post_meta( get_the_ID(), 'be_themes_portfolio_home_page', true); //Get link from Meta Options
$portfolio_home_page = ($portfolio_home_page == '' ? $be_themes_data['portfolio_home_page'] : $portfolio_home_page) ; //Get link from Options panel if not present in Meta Options is not present
$portfolio_catg_traversal = (1 == get_post_meta( get_the_ID(), 'be_themes_traverse_catg', true) ? true : false);
    

if((!is_page_template( 'gallery.php' )) || (!is_page_template( 'portfolio.php' ))) {
    echo '<div id="nav-below" class="single-page-nav">';
        next_post_link( '%link', '<i class="font-icon icon-arrow_left" title="%title"></i>' , $portfolio_catg_traversal , '' , 'portfolio_categories');
        if ( is_singular( 'portfolio' ) ) {
            
            if(!empty($portfolio_home_page)) {
                $url = $portfolio_home_page;
            } else {
                $url = site_url();
            }
        } else {
            $url = be_get_posts_page_url();
        }
        echo '<a href="'.$url.'"><div class="home-grid-icon"><span></span><span></span><span></span><span></span><span></span><span></span></div></a>';
        previous_post_link( '%link', '<i class="font-icon icon-arrow_right" title="%title"></i>' , $portfolio_catg_traversal , '' , 'portfolio_categories' );
    echo '</div>';
}
?>