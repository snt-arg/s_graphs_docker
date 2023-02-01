<?php
/**
 *
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2014 averta
*/

// no direct access allowed
if ( ! defined('ABSPATH') ) {
    die();
}



if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) )
	return '';

if ( ! class_exists( 'MSP_WP_Post' ) )
	include_once( 'class-msp-wp-post.php' );

if ( ! class_exists( 'MSP_WC_Product_Slider' ) ) :

/**
*
*/
class MSP_WC_Product_Slider extends MSP_WP_Post{



	function get_tax_term_dictionary(){

		$tax_term_dictionary = array();
		$post_types_tax_list = array();

		$the_post_type 	 = get_post_type_object( 'product');

		$tax_term_dictionary[ 'types' ][] = array( "name" => $the_post_type->name, "label" => $the_post_type->label );

		$post_type_hierarchical_taxs = $this->get_taxonomy_name_label( $the_post_type->name, true );
		$post_type_hierarchical_taxs = apply_filters( "masterslider_post_slider_{$the_post_type->name}_hierarchical_taxs", $post_type_hierarchical_taxs );

		$post_type_non_hierarchical_taxs = $this->get_taxonomy_name_label( $the_post_type->name, false );
		$post_type_non_hierarchical_taxs = apply_filters( "masterslider_post_slider_{$the_post_type->name}_non_hierarchical_taxs", $post_type_non_hierarchical_taxs );

		$tax_term_dictionary[ 'cats' ][ $the_post_type->name ] = $this->get_tax_terms( $post_type_hierarchical_taxs     );
		$tax_term_dictionary[ 'tags' ][ $the_post_type->name ] = $this->get_tax_terms( $post_type_non_hierarchical_taxs );

		return $tax_term_dictionary;
	}



	public function get_posts_query(){

		$query = parent::get_posts_query();

		$query['only_featured'] = isset( $_REQUEST['only_featured'] ) && 'true' == $_REQUEST['only_featured'] ? 'true' : 'false';
		$query['only_instock' ] = isset( $_REQUEST['only_instock']  ) && 'true' == $_REQUEST['only_instock']  ? 'true' : 'false';
		$query['only_onsale'  ] = isset( $_REQUEST['only_onsale']   ) && 'true' == $_REQUEST['only_onsale']   ? 'true' : 'false';
		$query['post_type']     = 'product';

		$this->recent_query = $query;

		return $query;
	}



	public function get_posts_result( $args ){

		$slide_image_target = isset( $args['image_from'] ) ? $args['image_from'] : 'auto';

		$th_wp_query = $this->get_query_results( $args );

		ob_start();

		if( $th_wp_query->have_posts() ):  while ( $th_wp_query->have_posts() ) : $th_wp_query->the_post();

			$product = get_product( $th_wp_query->post->ID );

			$the_excerpt = apply_filters( 'woocommerce_short_description', $product->get_post_data()->post_excerpt );
			$excerpt_length = isset( $args['excerpt_length'] ) ? $args['excerpt_length'] : '';

			if( ! empty( $excerpt_length ) )
				$the_excerpt = msp_get_trimmed_string( $the_excerpt, (int)$excerpt_length );

			$the_media     = '';
			$the_media_src = msp_get_auto_post_thumbnail_url( $th_wp_query->post->ID, $slide_image_target );

			$premalink = $product->get_permalink();

			if( ! empty( $the_media_src ) ) {
				$the_media_tag  = msp_get_the_resized_image( $the_media_src, 80, 80, true, 100 );
				$the_media 		= sprintf( '<div class="msp-entry-media" ><a href="%s" target="_blank">%s</a></div>', $premalink, $the_media_tag );
			}
		?>

		<article class="msp-post msp-post-<?php echo $th_wp_query->post->ID; ?> msp-post-<?php echo $th_wp_query->post->post_type; ?>">
           <figure>
           		<?php echo $the_media; ?>

                <figcaption>
                    <div class="msp-entry-header">
                        <h4 class="msp-entry-title"><a href="<?php echo $premalink; ?>" target="_blank"><?php the_title(); ?></a></h4>
                    </div>

                    <div class="msp-entry-content">
                        <time datetime="<?php the_time('Y-m-d')?>" title="<?php the_time('Y-m-d')?>" ><?php the_time('F j, Y'); ?></time>
                        ( <span class="ps-post-id">Post ID: <?php the_ID(); ?></span> )
                        <?php if ( $regular_price = wc_format_decimal( $product->get_regular_price(), 2 ) ) : ?>
							( <span class="regular-price"><?php _e( 'Regular Price', MSWP_TEXT_DOMAIN ); echo ': ' . $regular_price; ?></span> )
						<?php endif; ?>
						<?php if ( $sale_price = $product->get_sale_price() ? wc_format_decimal( $product->get_sale_price(), 2 ) : null ) : ?>
							( <span class="sale-price"><?php _e( 'Sale Price', MSWP_TEXT_DOMAIN ); echo ': ' . $sale_price; ?></span> )
						<?php endif; ?>
                        <p><?php echo $the_excerpt; ?></p>
                    </div>
                </figcaption>
           </figure>
		</article>

		<?php

			endwhile;
		endif;

		// Restore original Post Data
		wp_reset_query();

    	return ob_get_clean();
	}



	public function get_query_results( $args ){

		// default query args
		$defaults = array(
			'orderby' 		=> 'menu_order date',
			'order' 		=> 'DESC',
			'post_status'	=> 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page'=> -1,
			'offset' 		=> 0
		);

		$args = wp_parse_args( $args, $defaults );


		switch ( $args['orderby'] ) {
			case 'price' :
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'ASC';
				$args['meta_key'] = '_price';
			break;
			case 'price-desc' :
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'DESC';
				$args['meta_key'] = '_price';
			break;
			case 'popularity' :
				$args['meta_key'] = 'total_sales';

				// Sorting handled later though a hook
				add_filter( 'posts_clauses', array( WC()->query, 'order_by_popularity_post_clauses' ) );
			break;
			case 'rating' :

				// Sorting handled later though a hook
				add_filter( 'posts_clauses', array( WC()->query, 'order_by_rating_post_clauses' ) );
			break;
		}



		$meta_query   = array();
		$meta_query[] = WC()->query->visibility_meta_query();

		if( 'true' == $args['only_onsale'] ) {
			// Get products on sale
			$meta_query[] = WC()->query->stock_status_meta_query();
			$product_ids_on_sale = wc_get_product_ids_on_sale();
			if( ! isset( $args['post__in'] ) ) $args['post__in'] = array( 0 );
			$args['post__in'] = array_merge( $args['post__in'], $product_ids_on_sale );
		}
		if( 'true' == $args['only_instock'] ) {
			// Get products in stock
			$meta_query[] = WC()->query->stock_status_meta_query();
		}
		if( 'true' == $args['only_featured'] ) {
			// Get products on sale
			$meta_query[] = array( 'key' => '_featured', 'value' => 'yes' );
		}

		$args['meta_query'] = array_filter( $meta_query );


		$th_wp_query = null;
		return new WP_Query( $args );
	}


}

endif;
