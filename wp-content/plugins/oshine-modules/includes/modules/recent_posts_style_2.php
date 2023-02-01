<?php
if ( ! function_exists( 'be_recent_posts_style2' ) ) {
	function be_recent_posts_style2( $atts, $content ) {
		extract( shortcode_atts( array (
			'number' => 3,
	    ), $atts ) );
		$posts_per_page = (isset($number) && !empty($number)) ? $number : 3;
		$args=array (
			'post_type' => 'post',
			'posts_per_page' => $posts_per_page,
			'orderby' => 'date',
			'ignore_sticky_posts' => 1,
			'tax_query' => array (
				array (
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array( 'post-format-quote' ),
					'operator' => 'NOT IN',
				)
			),
		);
		$output = '';
		global $meta_sep, $blog_attr;
		$my_query = new WP_Query( $args  );
		if( $my_query->have_posts() ) {
			$output .= '<div class="related-items bar-style-related-posts oshine-module clearfix">';
			$blog_attr['style'] = 'shortcodes';
			$blog_attr['gutter_width'] = 0;
			while ( $my_query->have_posts() ) : $my_query->the_post();
				$style = '';
				if( has_post_thumbnail() ) :
					$blog_image_size = 'blog-image';
				    $thumb_full = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
					$attachment_full_url = $thumb_full[0];
					$style = 'background: url('.$attachment_full_url.') center center no-repeat;';
				endif;
				$output .= '<div class="clearfix bar-style-related-posts-list be-bg-cover" style="'.$style.'">';
				$output .= '<div class="background-content">';
				$output .= '<div class="special-subtitle post-date">'.get_the_date( 'F d Y' ).'</div>';
				if(get_the_title(get_the_ID())) {
					$output .= '<a href="'.get_the_permalink().'"><h5 class="post-title">'.get_the_title(get_the_ID()).'</h5></a>';
				}
				$output .= '<nav class="post-nav meta-font secondary_text">';
				$output .= '<div class="sep-with-icon-wrap margin-bottom"><span class="sep-with-icon" style="height:2px; width:20px;"></span><i class="sep-icon font-icon icon-dimond"></i><span class="sep-with-icon" style="height:2px; width:20px;"></span></div>';
				$output .= '<ul class="clearfix cal-list">';
				$output .= '<li class="post-meta post-author">'.__('Posted By :','oshine-modules').' '.get_the_author().'<span class="post-meta-sep"> / </span></li>';
				$output .= '<li class="post-meta post-comments"><a href="'.get_comments_link().'">'.get_comments_number('0','1','%').' '.__(' comments','oshine-modules').'</a> <span class="post-meta-sep">/</span></li>';
				$output .= '<li class="post-meta post-category">'.__('Under :','oshine-modules');
				$output .= be_themes_get_category_list(get_the_ID());
				$output .= '</li>';
				$output .= '</ul></nav>';
				$output .= '</div>';
				$output .= '<div class="background-overlay"></div>';
				$output .= '</div>'; // end column block
			endwhile;
			$output .= '</div>';
		}
		wp_reset_query();
		return $output;
	}
	add_shortcode( 'recent_posts_style_2', 'be_recent_posts_style2' );
}
?>