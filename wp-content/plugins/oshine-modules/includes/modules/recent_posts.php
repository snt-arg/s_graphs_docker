<?php
/**************************************
			RECENT POSTS
**************************************/
if ( ! function_exists( 'be_recent_posts' ) ) {
	function be_recent_posts( $atts, $content, $tag ) {
		$atts = shortcode_atts( array (
			'number'=>'three',
			'filter_by' => 'category',
			'categories' => '',
			'tags' => '',
            'hide_excerpt' => '',
			'hide_thubnail' => 0,
			'adaptive_image' => 0,
			'social_icons' => 0,
			'show_tags' => 0,
            'key' => be_uniqid_base36(true),
        ), $atts , $tag);
        extract( $atts );
		if( $number == 'three' ) {
			$posts_per_page = 3;
			$column = 'third';
		} else {
			$posts_per_page = 4;
			$column = 'fourth';
		}
		$filter_by_possible_values = array( 'post_tag', 'category' );
		$filter_by = !empty( $filter_by ) && in_array( $filter_by, $filter_by_possible_values ) ? $filter_by : 'category';
		$categories = !empty( $categories ) ? explode( ',', $categories ) : '';
		$tags = !empty( $tags ) ? explode( ',', $tags ) : '';
		$hide_excerpt = (isset($hide_excerpt) && ($hide_excerpt)) ? 'hide-excerpt' : '' ;
        $terms = 'post_tag' == $filter_by ? $tags : $categories; 
        
        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
        $css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
        $data_animations = be_get_animation_data_atts( $atts );
        $unique_class_name = ' tatsu-'.$atts['key'];
        $classes = array( $unique_class_name, 'related-items', 'oshine-recent-posts', 'style3-blog', $hide_excerpt, 'oshine-module', 'clearfix' );
        if( !empty( $visibility_classes ) ) {
            $classes[] = $visibility_classes;
        }
        if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        if( !empty( $css_classes ) ) {
            $classes[] = $css_classes;
        }

		
		$tax_query = array (
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array( 'post-format-quote' ),
				'operator' => 'NOT IN',
			),
		);
		if( !empty( $terms[0] ) ) {
			$tax_query[ 'relation' ] = 'AND';
			$tax_query[] = array (
				'taxonomy' => $filter_by,
				'field' => 'slug',
				'terms' => $terms,
				'operator' => 'IN',
			);
		}

		$args=array (
			'post_type' => 'post',
			'posts_per_page'=> $posts_per_page,
			'orderby'=>'date',
			'ignore_sticky_posts'=>1,
			'tax_query' => $tax_query
		);

		$output = '';
		global $meta_sep, $blog_attr;
		$my_query = new WP_Query( $args  );
		if( $my_query->have_posts() ) {
            $output .= '<div ' . $css_id . ' class="' . implode( ' ', $classes ).  '" ' . $data_animations . ' >';
            $output .= $custom_style_tag;
			$blog_attr['style'] = 'shortcodes';
			$blog_attr['gutter_width'] = 0;
			$blog_attr['hide_thubnail'] = $hide_thubnail;
			$blog_attr['adaptive_image'] = $adaptive_image;
			$blog_attr['social_icons'] = $social_icons;
			$blog_attr['show_tags'] = $show_tags;
			while ( $my_query->have_posts() ) : $my_query->the_post(); 
				$output .= '<div class="'.$column.'-col recent-posts-col be-hoverlay">';
				ob_start();
				get_template_part( 'blog/loop', $blog_attr['style'] );
				$post_format_content = ob_get_clean();
				$output .= $post_format_content;
				$output .= '</div>'; // end column block
			endwhile;
			$output .= '</div>';
		}
		wp_reset_query();
		return $output;
	}
	add_shortcode( 'recent_posts', 'be_recent_posts' );
}

add_action( 'tatsu_register_modules', 'oshine_register_recent_posts');
function oshine_register_recent_posts() {
		$post_categories = get_categories();
		$post_tags = get_tags();
		$category_options = array();
		$tag_options = array();
		foreach( $post_categories as $category ) {
			if( is_object( $category ) ) {
				$category_options[ $category->slug ] = $category->name;
			}
		}
		foreach( $post_tags as $tag ) {
			if( is_object( $tag ) ) {
				$tag_options[ $tag->slug ] = $tag->name;
			}
		}
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#recent_posts',
	        'title' => __( 'Recent - Blog Posts Masonry Style', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => false,
			'group_atts' => array (
				array (
					'type'	=>	'tabs',
					'style'	=>	'style1',
					'group'	=>	array (
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Content' , 'tatsu'),
							'group'	=>	array (
								'number',
								'filter_by',
								'categories',
								'tags',
								'hide_excerpt',
								'hide_thubnail',
								'adaptive_image',
								'social_icons',
								'show_tags',
							)
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Advanced' , 'tatsu'),
							'group'	=>	array (
							)
						),
					)
				),
			),
	        'atts' => array (
	            array (
	        		'att_name' => 'number',
                    'type' => 'button_group',
                    'is_inline' => true,
	        		'label' => __( 'Number of Items', 'oshine-modules' ),
	        		'options' => array (
						'three' => 'Three',
						'four' => 'Four',
					),
	        		'default' => 'three',
	        		'tooltip' => ''
				),
				array (
					'att_name' => 'filter_by',
                    'type' => 'button_group',
                    'is_inline' => true,
					'label' => __( 'Filter By', 'oshine-modules' ),
					'options' => array (
						'category' => 'Categories',
						'post_tag' => 'Tags',
					),
					'default' => 'category',
					'tooltip' => ''
				),
				array (
					'att_name' => 'categories',
					'type' => 'grouped_checkbox',
					'label' => __( 'Categories', 'oshine-modules' ),
					'options' => $category_options,
					'tooltip' => '',
					'visible' => array ( 'filter_by', '=', 'category' )
				),
				array (
					'att_name' => 'tags',
					'type' => 'grouped_checkbox',
					'label' => 'Tags',
					'options' => $tag_options,
					'tooltip' => '',
					'visible' => array ( 'filter_by', '=', 'post_tag' )
				),
	        	array (
	              	'att_name' => 'hide_excerpt',
	              	'type' => 'switch',
	              	'label' => __( 'Hide Excerpt', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
				array(
					'att_name' => 'hide_thubnail',
					'type' => 'switch',
					'label' => __('Hide Thumbnail', 'oshine-modules'),
					'default' => 0,
					'tooltip' => '',
				),
				array(
					'att_name' => 'adaptive_image',
					'type' => 'switch',
					'label' => __('Use Adaptive Image sizes', 'oshine-modules'),
					'default' => 0,
					'tooltip' => '',
					'visible' => array( 'hide_thubnail', '=', '0' )
				),
				array(
					'att_name' => 'social_icons',
					'type' => 'switch',
					'label' => __('Show Social Icons', 'oshine-modules'),
					'default' => 0,
					'tooltip' => '',
				),
				array(
					'att_name' => 'show_tags',
					'type' => 'switch',
					'label' => __('Show Available Tags', 'oshine-modules'),
					'default' => 0,
					'tooltip' => '',
				),
	        ),
	    );
	tatsu_register_module( 'recent_posts', $controls );
}