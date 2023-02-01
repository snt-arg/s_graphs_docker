<?php
/**
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



if( ! class_exists( 'MSP_WP_Post' ) )
	include_once( 'class-msp-wp-post.php' );

if( ! class_exists( 'MSP_Post_Slider' ) ) :

/**
*
*/
class MSP_Post_Slider extends MSP_WP_Post{



	function get_tax_term_dictionary(){

		$tax_term_dictionary = array();
		$post_types_tax_list = array();

		$custom_post_types   = $this->get_custom_post_types();
		$default_post_types  = $this->get_default_post_types();

		$the_post_types 	 = array_merge( $default_post_types, $custom_post_types );

		$excluded_post_types = apply_filters( 'masterslider_post_slider_excluded_post_types', array( 'attachment', 'revision', 'nav_menu_item' ) );


		foreach ( $the_post_types as $post_type_name => $post_type_info ) {

			if( in_array( $post_type_name , $excluded_post_types ) )
				continue;

			$tax_term_dictionary[ 'types' ][] = array( "name" => $post_type_info->name, "label" => $post_type_info->label );

			$post_type_hierarchical_taxs = $this->get_taxonomy_name_label( $post_type_name, true );
			$post_type_hierarchical_taxs = apply_filters( "masterslider_post_slider_{$post_type_name}_hierarchical_taxs", $post_type_hierarchical_taxs );

			$post_type_non_hierarchical_taxs = $this->get_taxonomy_name_label( $post_type_name, false );
			$post_type_non_hierarchical_taxs = apply_filters( "masterslider_post_slider_{$post_type_name}_non_hierarchical_taxs", $post_type_non_hierarchical_taxs );

			$tax_term_dictionary[ 'cats' ][ $post_type_name ] = $this->get_tax_terms( $post_type_hierarchical_taxs     );
			$tax_term_dictionary[ 'tags' ][ $post_type_name ] = $this->get_tax_terms( $post_type_non_hierarchical_taxs );
		}

		return $tax_term_dictionary;
	}


	public function get_posts_result( $args ){

		$slide_image_target = isset( $args['image_from'] ) ? $args['image_from'] : 'auto';
        $exclude_posts_without_image = isset( $args['exclude_post_no_image'] ) ? $args['exclude_post_no_image'] : false;

		$th_wp_query = $this->get_query_results( $args );

		ob_start();
		if( $th_wp_query->have_posts() ):  while ( $th_wp_query->have_posts() ) : $th_wp_query->the_post();

			$the_excerpt = get_the_excerpt();
			$excerpt_length = isset( $args['excerpt_length'] ) ? $args['excerpt_length'] : '';

			if( ! empty( $excerpt_length ) )
				$the_excerpt = msp_get_trimmed_string( get_the_excerpt(), (int)$excerpt_length );

			$the_media     = '';
            // get featured on first image in post
			$the_media_src = msp_get_auto_post_thumbnail_url( $th_wp_query->post->ID, $slide_image_target );

			if( ! empty( $the_media_src ) ) {
				$the_media_tag  = msp_get_the_resized_image( $the_media_src, 80, 80, true, 85 );
                // skip this post if
                if( empty( $the_media_tag ) && $exclude_posts_without_image ){
                    continue;
                }
				$the_media  = sprintf( '<div class="msp-entry-media" ><a href="%s" target="_blank">%s</a></div>', get_the_permalink(), $the_media_tag );

            // exclude posts without image
            } elseif( $exclude_posts_without_image ){
                continue;
            }
		?>

		<article class="msp-post msp-post-<?php echo $th_wp_query->post->ID; ?> msp-post-<?php echo $th_wp_query->post->post_type; ?>">
           <figure>
           		<?php echo $the_media; ?>

                <figcaption>
                    <div class="msp-entry-header">
                        <h4 class="msp-entry-title"><a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a></h4>
                    </div>

                    <div class="msp-entry-content">
                        <time datetime="<?php the_time('Y-m-d')?>" title="<?php the_time('Y-m-d')?>" ><?php the_time('F j, Y'); ?></time>
                        ( <span class="ps-post-id">Post ID: <?php the_ID(); ?></span> )
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


}

endif;







