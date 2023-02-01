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


if( ! class_exists( 'MSP_WP_Post' ) ) :

/**
*
*/
class MSP_WP_Post {

	var $dictionary   = array();
	var $recent_query = array();


	function __construct() {}

	public function get_tax_term_dictionary(){  }


	public function get_taxonomy_name_label( $post_type, $hierarchical = true ){
		$the_taxs = $this->get_taxonomies( $post_type );

		$tax_list = array();
		foreach ( $the_taxs as $tax_name => $tax ) {
			if( ( $hierarchical && $tax->hierarchical ) || ( ! $hierarchical && ! $tax->hierarchical ) )
				$tax_list[ $tax_name ] = $tax->label;
		}

		return $tax_list;
	}


	public function get_custom_post_types(){
		$custom_post_types = get_post_types( array( '_builtin' => false ), 'objects' );
		return apply_filters( 'masterslider_get_custom_post_types', $custom_post_types );
	}


	public function get_default_post_types(){
		return get_post_types( array( '_builtin' => true ), 'objects' );
	}


	public function get_taxonomies( $post ){
		$custom_post_type_taxonomies = get_object_taxonomies( $post, 'objects' );
		return apply_filters( 'masterslider_get_custom_post_type_taxonomies', $custom_post_type_taxonomies, $post );
	}


	public function get_terms( $taxonomies ){
		$terms = get_terms( $taxonomies );
		return apply_filters( 'masterslider_get_custom_post_type_terms', $terms, $taxonomies );
	}


	public function get_tax_terms( $taxonomies ) {

		$taxs_terms_list = array();

		foreach ( $taxonomies as $tax_name => $tax_label ) {

			$tax_terms = $this->get_terms( $tax_name );

			foreach ( $tax_terms as $tax_term ) {

				if ( is_object( $tax_term ) )
					$tax_term = get_object_vars( $tax_term );

				$taxs_terms_list[] = $tax_term;
			}

		}

		return $taxs_terms_list;
	}


	public function get_posts_query(){

		$query = array();

		$query['image_from']     = isset( $_REQUEST['slideImage'] )     ? $_REQUEST['slideImage']     : 'auto';
		$query['excerpt_length'] = isset( $_REQUEST['excerpt_length'] ) ? $_REQUEST['excerpt_length'] : 100;
        $query['exclude_post_no_image'] = isset( $_REQUEST['exclude_post_no_image'] ) ? $_REQUEST['exclude_post_no_image'] : false;

		if( isset( $_REQUEST['post_type'] ) && ! empty( $_REQUEST['post_type'] ) )
			$query['post_type'] = $_REQUEST['post_type'];

		if( isset( $_REQUEST['orderby'] ) )
			$query['orderby'] = $_REQUEST['orderby'];

		if( isset( $_REQUEST['order'] ) )
			$query['order'] = $_REQUEST['order'];

		$query['posts_per_page'] = isset( $_REQUEST['limit'] )  && ! empty( $_REQUEST['limit'] ) ? (int)$_REQUEST['limit'] : 10;

		if( isset( $_REQUEST['post__not_in'] )  && ! empty( $_REQUEST['post__not_in'] ) ) {
			$posts_not_in = explode( ',', $_REQUEST['post__not_in'] );
			$query['post__not_in'] = array_filter( $posts_not_in );
		}

		if( isset( $_REQUEST['post__in'] )  && ! empty( $_REQUEST['post__in'] ) ) {
			$posts_in = explode( ',', $_REQUEST['post__in'] );
			$query['post__in'] = array_filter( $posts_in );
		}

		if( isset( $_REQUEST['offset'] ) && ! empty( $_REQUEST['offset'] ) )
			$query['offset'] = (int)$_REQUEST['offset'];


		$taxs_data = array();

		if( isset( $_REQUEST['cats'] ) && ! empty( $_REQUEST['cats'] ) ) {
			$cats = explode( ',', $_REQUEST['cats'] );
			$taxs_data = array_merge( $taxs_data, $cats );
		}

		if( isset( $_REQUEST['tags'] ) && ! empty( $_REQUEST['tags'] ) ) {
			$tags = explode( ',', $_REQUEST['tags'] );
			$taxs_data = array_merge( $taxs_data, $tags );
		}

		$query['tax_query'] = $this->get_tax_query( $taxs_data );

		$this->recent_query = $query;

		return $query;
	}

	// this method will be called by ajax handler
	public function parse_and_get_posts_result(){
		$query = $this->get_posts_query();
		return $this->get_posts_result( $query );
	}

	// this method will be called by ajax handler
	public function parse_and_get_first_post_object(){
		$query = $this->get_posts_query();
		$objects = $this->get_post_object( $query, 1 );

		return isset( $objects[0] ) ? $objects[0] : null;
	}


	public function get_first_post_template_tags_value(){
		$post = $this->parse_and_get_first_post_object();
		$args = array();
		$args['image_from'] = isset( $_REQUEST['slideImage'] ) ? $_REQUEST['slideImage'] : 'auto';

		return get_post_template_tags_value( $post, $args );
	}


	protected function get_post_object( $args, $count = -1 ){

		$th_wp_query = $this->get_query_results( $args );

		$object_list = array();

		if( $th_wp_query->have_posts() ) : while ( $th_wp_query->have_posts() ) : $th_wp_query->the_post();
			if( 0 === $count )
				break;

			$object_list[] = $th_wp_query->post;
			--$count;

			endwhile;
		endif;

		return $object_list;
	}

	/**
	 * Generate a tax_query for using in WP_Query by tax_terms_ids
	 * @param  array   $taxs_term_ids  The taxonomy_term id
	 * @return array   The tax query
	 */
	public function get_tax_query( $taxs_term_ids ){

		$tax_query     = array();
		$taxs_term_ids = array_filter( $taxs_term_ids );

		// collect terms ids for each taxonomy
		$tax_term_archive = array();

		foreach ( $taxs_term_ids as $tax_id ) {
			if( $the_tax_term_obj = $this->get_taxonomy_by_id( $tax_id ) )
    			$tax_term_archive[ $the_tax_term_obj->taxonomy ][] = $the_tax_term_obj->term_id;
		}

		// generate tax_query
		foreach ( $tax_term_archive as $taxonomy => $terms) {
			$tax_query[] = array(
				'taxonomy' 		=> $taxonomy,
				'field' 		=> 'id',
				'terms' 		=> $terms
			);
		}

		// add relationship between each inner taxonomy array when there is more than one
		if( count( $tax_query ) > 1 )
			$tax_query['relation'] = 'AND';


		return $tax_query;
	}


	public function get_taxonomy_by_id( $term_taxonomy_id ) {
	    global $wpdb;
	    $taxonomy = $wpdb->get_row( $wpdb->prepare(
	        "SELECT * FROM $wpdb->term_taxonomy wta
	            INNER JOIN $wpdb->terms wt ON (wta.term_id = wt.term_id)
	            WHERE wta.term_taxonomy_id = %d", $term_taxonomy_id
	    ) );

	    return $taxonomy;
	}



	public function get_posts_result( $args ){

		$slide_image_target = isset( $args['image_from'] ) ? $args['image_from'] : 'auto';

		$th_wp_query = $this->get_query_results( $args );

		ob_start();
		if( $th_wp_query->have_posts() ):  while ( $th_wp_query->have_posts() ) : $th_wp_query->the_post();

			$the_excerpt = get_the_excerpt();
			$excerpt_length = isset( $args['excerpt_length'] ) ? $args['excerpt_length'] : '';

			if( ! empty( $excerpt_length ) )
				$the_excerpt = msp_get_trimmed_string( get_the_excerpt(), (int)$excerpt_length );

			$the_media     = '';
			$the_media_src = msp_get_auto_post_thumbnail_url( $th_wp_query->post->ID, $slide_image_target );

			if( ! empty( $the_media_src ) ) {
				$the_media_tag  = msp_get_the_resized_image( $the_media_src, 80, 80, true, 100 );
				$the_media 		= sprintf( '<div class="msp-entry-media" ><a href="%s" target="_blank">%s</a></div>', get_the_permalink(), $the_media_tag );
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

    	return ob_get_clean();
	}


	public function get_query_results( $args ){

		// default query args
		$defaults = array(
			'orderby' 		=> 'menu_order date',
			'order' 		=> 'DESC',
			'post_status'	=> 'publish',
			'posts_per_page'=> -1,
			'offset' 		=> 0
		);

		$args = wp_parse_args( $args, $defaults );

		$th_wp_query = null;
		return new WP_Query( $args );
	}

}

endif;
