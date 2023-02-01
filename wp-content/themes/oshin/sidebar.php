<?php
/**
 * The Sidebar containing the main (right) widget area.
 *
 * @package WordPress
 * 
 * 
 */  ?>
<div class="sidebar-widgets-wrap">
	<?php
		global $wp_registered_sidebars; 
		$sidebar_array = array();
		foreach ( $wp_registered_sidebars as $key => $value ) {
			$sidebar_array[] = $key;
		}
		if( is_single() || is_page()) {
			$sidebar = get_post_meta(get_the_ID(),'be_themes_sidebar',true);
		}
		if( empty( $sidebar ) || !in_array( $sidebar, $sidebar_array ) ) {
			$sidebar = 'default-sidebar';
		}
		if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && function_exists('is_shop') && function_exists('is_product_category') && function_exists('is_product_tag') && (is_shop() || is_product_category() || is_product_tag()) ) {
			$sidebar = get_post_meta(wc_get_page_id( 'shop' ),'be_themes_sidebar',true);
		}
		if (is_active_sidebar( $sidebar ) ) {
			dynamic_sidebar( $sidebar );
		}
	?>
</div>