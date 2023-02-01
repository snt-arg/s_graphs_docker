<?php

function msp_get_general_post_template_tags() {

	$tags = array(

	    array( 'name'		=> 'title',
		       'label' 		=> __( 'The post title', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'title-5',
		       'label' 		=> __( 'The post title-(with length limit)', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),
		
		array( 'name'		=> 'linked_title',
		       'label' 		=> __( 'The post title with link', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

	    array( 'name'		=> 'content',
		       'label' 		=> __( 'The post content', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'content-150',
		       'label' 		=> __( 'The post content-(with length limit)', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

	    array( 'name'		=> 'excerpt',
		       'label' 		=> __( 'The post excerpt', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

	    array( 'name'		=> 'categories',
		       'label' 		=> __( 'The post categories', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'tags',
		       'label' 		=> __( 'The post tags', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'permalink',
		       'label' 		=> __( 'The post link', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'author',
		       'label' 		=> __( 'The author name', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'author-avatar',
		       'label' 		=> __( 'The author avatar', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'post_id',
		       'label' 		=> __( 'The unique ID of the post', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'image',
		       'label' 		=> __( 'Post image', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'image-150x150',
		       'label' 		=> __( 'Post image-(with custom dimensions)', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'image-url',
		       'label' 		=> __( 'Post image source', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

        array( 'name'       => 'image-alt',
               'label'      => __( 'Post image alternative text', MSWP_TEXT_DOMAIN ),
               'type'       => '_general',
               'callback'   => ''
        ),

        array( 'name'       => 'image-title',
               'label'      => __( 'Post image title', MSWP_TEXT_DOMAIN ),
               'type'       => '_general',
               'callback'   => ''
        ),

		array( 'name'		=> 'thumbnail',
		       'label' 		=> __( 'Post thumbnail', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'thumbnail-150x150',
		       'label' 		=> __( 'Post thumbnail-(with custom dimensions)', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'thumbnailurl',
		       'label' 		=> __( 'Post thumbnail source', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'year',
		       'label' 		=> __( 'The year of the post', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'monthnum',
		       'label' 		=> __( 'Numeric Month', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'month',
		       'label' 		=> __( 'Month name', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'daynum',
		       'label' 		=> __( 'Day of the month', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'day',
		       'label' 		=> __( 'Weekday name', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'time',
		       'label' 		=> __( 'Hour:Minutes', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'date-published',
		       'label' 		=> __( 'The publish date', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'date-modified',
		       'label' 		=> __( 'The last modified date', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'commentnum',
		       'label' 		=> __( 'Number of comments', MSWP_TEXT_DOMAIN ),
		       'type'		=> '_general',
		       'callback' 	=> ''
		)
	);

	return apply_filters( 'masterslider_post_slider_tags_list', $tags );
}



function msp_get_woocommerce_template_tags() {

	$tags = array(

	    array( 'name'		=> 'wc_price',
		       'label' 		=> __( 'Price', MSWP_TEXT_DOMAIN ),
		       'type'		=> 'product',
		       'callback' 	=> ''
		),

        array( 'name'       => 'wc_price-3',
               'label'      => __( 'Price (custom decimals)', MSWP_TEXT_DOMAIN ),
               'type'       => 'product',
               'callback'   => ''
        ),

	    array( 'name'		=> 'wc_regular_price',
		       'label' 		=> __( 'Regular Price', MSWP_TEXT_DOMAIN ),
		       'type'		=> 'product',
		       'callback' 	=> ''
		),

	    array( 'name'		=> 'wc_sale_price',
		       'label' 		=> __( 'Sale Price', MSWP_TEXT_DOMAIN ),
		       'type'		=> 'product',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'wc_stock_status',
		       'label' 		=> __( 'In Stock Status', MSWP_TEXT_DOMAIN ),
		       'type'		=> 'product',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'wc_stock_quantity',
		       'label' 		=> __( 'Stock Quantity', MSWP_TEXT_DOMAIN ),
		       'type'		=> 'product',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'wc_weight',
		       'label' 		=> __( 'Weight', MSWP_TEXT_DOMAIN ),
		       'type'		=> 'product',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'wc_product_cats',
		       'label' 		=> __( 'Product Categories', MSWP_TEXT_DOMAIN ),
		       'type'		=> 'product',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'wc_product_tags',
		       'label' 		=> __( 'Product Tags', MSWP_TEXT_DOMAIN ),
		       'type'		=> 'product',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'wc_total_sales',
		       'label' 		=> __( 'Total Sales', MSWP_TEXT_DOMAIN ),
		       'type'		=> 'product',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'wc_average_rating',
		       'label' 		=> __( 'Average Rating', MSWP_TEXT_DOMAIN ),
		       'type'		=> 'product',
		       'callback' 	=> ''
		),

		array( 'name'		=> 'wc_rating_count',
		       'label' 		=> __( 'Rating Count', MSWP_TEXT_DOMAIN ),
		       'type'		=> 'product',
		       'callback' 	=> ''
		),

        array( 'name'       => 'wc_add_to_cart_link',
               'label'      => __( 'Add to Cart Link', MSWP_TEXT_DOMAIN ),
               'type'       => 'product',
               'callback'   => ''
        ),

        array( 'name'       => 'wc_add_to_cart',
               'label'      => __( 'Add to Cart', MSWP_TEXT_DOMAIN ),
               'type'       => 'product',
               'callback'   => ''
        )

	);

	return apply_filters( 'masterslider_woocommerce_product_slider_tags_list', $tags );
}



function get_post_template_tags_value( $post = null, $args = null ){
	$post = get_post( $post );

	$template_tags = msp_get_general_post_template_tags();

	if ( msp_is_plugin_active( 'woocommerce/woocommerce.php' ) )
		$template_tags = array_merge( $template_tags, msp_get_woocommerce_template_tags() );

	$tags_dictionary = array();

	foreach ( $template_tags as $template_tag ) {
		$tags_dictionary[ $template_tag['name'] ] = msp_get_template_tag_value( $template_tag['name'], $post, $args );
	}

	return $tags_dictionary;
}
