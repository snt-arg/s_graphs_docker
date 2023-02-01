<?php 
if(is_category()) {
	echo __('Category: ','oshin').single_cat_title( '', false );
} elseif(is_tag()) {
	echo __('Articles Tagged with: ','oshin').single_tag_title( '', false );
} elseif (is_search()) {
	echo __('Search Results for: ','oshin').get_search_query();
} elseif(is_archive() && (is_tax( 'portfolio_categories' ) || is_tax( 'portfolio_tags' ))) {
	$term =	$wp_query->queried_object;
	if(is_tax( 'portfolio_categories' ))
		echo __('Portfolio Category : ','oshin').$term->name;
	elseif(is_tax( 'portfolio_tags' ))
		echo __('Portfolio Tag : ','oshin').$term->name;
	else
		echo __('Portfolio Archives','oshin');
} elseif(is_archive()) {
	if ( is_day() ) :
		printf( __( 'Daily Archives: <span>%s</span>', 'oshin' ), get_the_date() ); 
	elseif ( is_month() ) :
		printf( __( 'Monthly Archives: <span>%s</span>', 'oshin' ), get_the_date( 'F Y' ) ); 
	elseif ( is_year() ) : 
		printf( __( 'Yearly Archives: <span>%s</span>', 'oshin' ), get_the_date( 'Y' ) ); 
	else : 
		_e( 'Blog Archives', 'oshin' );
	endif;
} elseif(is_singular('post')) {
	echo __('Blog','oshin');
} elseif(is_home()){
	global $be_themes_data;
	if(!empty($be_themes_data['blog_style']) && $be_themes_data['blog_style'] == 'style10'){
		$page_title = wp_title( '|', false, 'right' );
		$page_title = explode('|',$page_title);
		echo $page_title[0];
	}else{
		echo __('Blog','oshin');
	}
	
} else {
	the_title();
}
?>