<?php
/**************************************
		BLOG MASONRY
**************************************/
if (!function_exists('be_blog')) {
	function be_blog( $atts, $content, $tag ) {
        global $be_themes_data;
		$atts = shortcode_atts( array (
			'col' => 'three',
			'number_of_posts' => '-1',
			'masonry_style' => 'style3',
			'filter_by' => 'category',
			'categories' => '',
			'tags' => '',
			'gutter_style' => 'style1',
            'gutter_width' => 40,
            'key' => be_uniqid_base36(true),
        ) , $atts, $tag );
        extract( $atts );
		$output = '';
		global $paged, $blog_attr;
		$col = ((!isset($col)) || empty($col)) ? 'three' : $col;
		$blog_attr['gutter_style'] = ((!isset($gutter_style)) || empty($gutter_style)) ? 'style1' : $gutter_style;
		$blog_attr['gutter_width'] = ((!isset($gutter_width)) || empty($gutter_width)) ? intval(40) : intval( $gutter_width );
        $blog_attr['style'] = 'shortcodes';
        
        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
        $unique_class_name = ' tatsu-'.$atts['key'];
        $css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
        $data_animations = be_get_animation_data_atts( $atts );
        $classes = array($unique_class_name, 'tatsu-module');
        if( !empty( $visibility_classes ) ) {
            $classes[] = $visibility_classes;
        }
        if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        if( !empty( $css_classes ) ) {
            $classes[] = $css_classes;
        }

		if( empty( $masonry_style ) || $masonry_style == 'style3' ){
			$masonry_style = 'style3';
			$template = 'shortcodes';
			$template_class = '';
			$animation = '';
			$enable_masonry = '';
		} else {
			$masonry_style = 'style8';
			$template = 'style8';
			$template_class = 'portfolio-delay-load portfolio-lazy-load';
			$animation = 'data-animation="fadeInUp"';
			$enable_masonry = 'data-enable-masonry = 1';
		}

		$filter_by = !empty( $filter_by ) ? $filter_by : 'category';
		$categories = !empty( $categories ) ? explode( ',', $categories ) : '';
		$tags = !empty( $tags ) ? explode( ',', $tags ) : '';
		$terms = '';
		$terms = 'post_tag' == $filter_by ? $tags : $categories; 
		$posts_per_page = !empty($number_of_posts) ? $number_of_posts : get_option( 'posts_per_page' );;

		if($blog_attr['gutter_style'] == 'style2') {
			$portfolio_wrap_style = 'style="margin-left: -'.$blog_attr['gutter_width'].'px;"';
		} else {
			$portfolio_wrap_style = 'style="margin-right: '.$blog_attr['gutter_width'].'px;"';
		}
        $output .= '<div ' . $css_id . ' class="portfolio-all-wrap ' . implode( ' ', $classes ) . '" ' . $data_animations . ' >';
        $output .= $custom_style_tag;
		$output .= '<div class="portfolio full-screen full-screen-gutter '.$gutter_style.'-gutter '.$col.'-col '.$template_class.'" data-gutter-width="'.$blog_attr['gutter_width'].'" '.$portfolio_wrap_style.' data-col="'.$col.'" '.$animation.' '.$enable_masonry.' >';
		$output .= '<div class="'.$masonry_style.'-blog portfolio-container clickable clearfix">';
		$blog_attr['gutter_width'] = $gutter_width;

		if( !empty( $terms[0] ) ){
			$args = array( 
				'post_type' => 'post', 
				'paged' => $paged,
				'posts_per_page' => $posts_per_page,
				'tax_query' => array (
					array (
						'taxonomy' => $filter_by,
						'field' => 'slug',
						'terms' => $terms,
						'operator' => 'IN',
					)
				)
			);
		}else{
			$args = array ( 
				'post_type' => 'post', 
				'paged' => $paged,
				'posts_per_page' => $posts_per_page,
			);
		}

		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) : 
			while ( $the_query->have_posts() ) : $the_query->the_post();
				ob_start();  
				get_template_part( 'blog/loop', $template );
				$output .= ob_get_contents();  
				ob_end_clean();
			endwhile;
		else:
			$output .= '<p class="inner-content">'.__( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'oshine-modules' ).'</p>';
		endif;
		$output .= '</div>'; //end portfolio-container
		$output .= ( $the_query->max_num_pages > 1 && empty( $number_of_posts ) ) ? '<div class="pagination_parent" style="margin-left: '.$blog_attr['gutter_width'].'px">'.get_be_themes_pagination($the_query->max_num_pages).'</div>' : '' ;
		$output .= '</div>';
		$output .= '</div>'; //end portfolio
		wp_reset_postdata();
		return $output;
	}
	add_shortcode( 'blog' , 'be_blog' );
}

add_action( 'tatsu_register_modules', 'oshine_register_blog');
function oshine_register_blog() {
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
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#blog',
	        'title' => __('Blog','oshine-modules'),
	        'is_js_dependant' => true,
	        'child_module' => '',
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
								'number_of_posts',
                                'filter_by',
                                'categories',
                                'tags'
							)
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Style' , 'tatsu'),
							'group'	=>	array (
								array (
									'type' => 'accordion' ,
									'active' => array(0, 1),
									'group' => array (
										array (
											'type' => 'panel',
											'title' => __( 'Style', 'tatsu' ),
											'group' => array (
                                                'col',
												'gutter_style',
												'gutter_width'
											)
										)
									)
								)
							),
						),
						array (
							'type'	=>	'tab',
							'title'	=>	__( 'Advanced' , 'tatsu'),
							'group'	=>	array (
									array(
									'type' => 'accordion' ,
									'active' => array(0, 1),
									'group' => array (
										array (
											'type' => 'panel',
											'title' => __( 'Animation', 'tatsu' ),
											'group' => array (
											)
										),
									)
								),
							)
						),
					)
				),
			),
	        'atts' => array (
	            array (
	        		'att_name' => 'col',
	        		'type' => 'select',
	        		'label' => __('Blog Masonry Columns','oshine-modules'),
	        		'options'=> array (
						'three' => __( 'Three', 'oshine-modules' ),
						'four' => __( 'Four', 'oshine-modules' ),
						'five' => __( 'Five', 'oshine-modules' ),
					),
	        		'default' => 'three',
	        		'tooltip' => ''
				),
				array (
                    'att_name' => 'number_of_posts',
	        		'type' => 'text',
	        		'label' => __( 'Number of Posts', 'oshine-modules' ),
	        		'default' => '',
					'tooltip' => '',
	        	),
				array (
                    'att_name' => 'filter_by',
                    'is_inline' => true,
					'type' => 'button_group',
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
				// array (
	        	// 	'att_name' => 'masonry_style',
	        	// 	'type' => 'button_group',
	        	// 	'label' => __('Grid Style','oshine-modules'),
	        	// 	'options' => array (
				// 		'style3' => 'Style 1',
				// 		'style8' => 'Style 2',
				// 	),
	        	// 	'default' => 'style3',
	        	// 	'tooltip' => ''
	        	// ),
	        	array (
	        		'att_name' => 'gutter_style',
	        		'type' => 'select',
	        		'label' => __('Gutter Style','oshine-modules'),
	        		'options' => array (
						'style1' => 'Without Margin',
						'style2' => 'With Margin',
					),
	        		'default' => 'style1',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'gutter_width',
                    'type' => 'number',
                    'is_inline' => true,
	        		'label' => __('Gutter Width','oshine-modules'),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '40',
	        		'tooltip' => ''
				),
	        ),
	    );
	tatsu_register_module( 'blog', $controls );
}