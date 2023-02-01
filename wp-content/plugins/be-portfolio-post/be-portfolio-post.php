<?php 
/*
Plugin Name: BE Portfolio Post
Plugin URI: http://www.brandexponents.com
Description: Plugin to create custom post type for Portfolios
Author: Brandexponents
Version: 1.1.1
Author URI: http://www.brandexponents.com
*/

require_once (plugin_dir_path(__FILE__).'custom-post-types/PostType.php');

if( !defined( 'BE_PORTFOLIO_POST_PLUGIN_DIR' ) ) {
	define( 'BE_PORTFOLIO_POST_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/***********************************************
					PORTFOLIO
***********************************************/	

//Create Post Type

$portfolio = Create_Custom_Post_Type( 'portfolio' );

//Add Categories Style Taxonomy
$portfolio->Add_Categories_Style_Taxonomy( 'portfolio_categories' );

//Add Tags Style Taxonomy
$portfolio->Add_Tags_Style_Taxonomy( 'portfolio_tags' );

$portfolio->args['supports'] = array( 'title', 'editor','thumbnail','excerpt' );

require BE_PORTFOLIO_POST_PLUGIN_DIR. 'plugin-update-checker/plugin-update-checker.php';
$be_portfolio_post_update_checker = new PluginUpdateChecker_3_1 (
    'https://brandexponents.com/wp/wp-content/uploads/be-portfolio-post.json',
    __FILE__,
    'be-portfolio-post'
);
?>