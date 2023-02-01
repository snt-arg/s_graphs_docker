<?php 
/***** For blog style10 **********/
    global $be_themes_data;
    $atts = array (
        'col' => 'three',
        'gutter_style' => 'style2',
        'gutter_width' => 40,
        'show_filters' => '1',
        'blog_filters_align'=>'center',
        'filter_bottom_color'=>'#33e9b9',
        'tax_name' => 'category',
        'filter' => 'category',   
        'meta_to_show' => 'category',     
        'category' => '',
        'tags' => '',
        'items_per_page' => '-1',
        'masonry' => '0',
        'maintain_order' => '0',
        'gallery' => '0',
        'pagination' => 'none',
        'initial_load_style' => 'none',
        'two_col_mobile' => '0',
        'item_parallax' => 0,
        'prebuilt_hover' => 0,
        'prebuilt_hover_style' => 'style1',
        'hover_style' => 'style1-hover',
        'title_alignment_static' => '',
        'overlay_color' => '',
        'gradient_color' => '',
        'gradient' => '0',
        'gradient_direction' => 'bottom',
        'overlay_opacity' => '85',
        'show_overlay' => '',
        'title_style' => 'style1',
        'title_color' => '',
        'cat_color' => '',
        'placeholder_color' => '',
        'cat_hide' => 0,
        'default_image_style' => 'color',
        'hover_image_style' => 'color',
        'title_animation_type' => 'none',
        'cat_animation_type' => 'none',
        'image_effect' => 'none',
        'lazy_load' => 0,
        'delay_load' => 0,
        'delay' => '200',
        'like_button' => 0,
        'key' => be_uniqid_base36(true),
    );
    extract( $atts );
    $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
    $unique_class_name = 'tatsu-'.$key;
    $lazy_load = (isset($lazy_load) && !empty($lazy_load) && intval($lazy_load) != 0) ? $lazy_load : 0;
    $prebuilt_hover_color_style1 = 'rgba(0, 0, 0, 0.5);';
    $delay_load = (isset($delay_load) && !empty($delay_load) && intval($delay_load) != 0) ? $delay_load : 0;
    $delay_load_class = ( !empty( $delay_load ) ) ? 'portfolio-delay-load ' : '';
    $init_image_load = '';
    $lazy_load_class = ( !empty( $lazy_load ) ) ? 'portfolio-lazy-load ' : '';
    $enable_data_src = ( ( !( wp_doing_ajax() || ( defined('REST_REQUEST') && REST_REQUEST ) || isset($_GET['tatsu']) ) && $lazy_load ) ) ? 1 : 0;
    $output = $global_thumb_overlay_color = $thumb_overlay_color = $global_gradient_style_color = $gradient_style_color = '';
    $col = $be_themes_data['blog_column'];
    $col = empty($col)? 'three' : $col;
    if(!empty($col) && strrpos($col, "-col") !== false){
        $col = str_ireplace("-col","",$col);
    }
    
    $gutter_style = ((!isset($gutter_style)) || empty($gutter_style)) ? 'style1' : $gutter_style;
    $gutter_width = ( isset( $gutter_width ) ) ? intval( $gutter_width ) : intval(40);
    
    $masonry = $be_themes_data['blog_masonry_enable'];
    $masonry_enable = ((!isset($masonry)) || empty($masonry)) ? 'masonry_disable' : 'masonry_enable';
    $maintain_order = ( isset( $maintain_order ) && !empty( $maintain_order ) ) ? 1 : 0;
    $prebuilt_hover = (!isset($prebuilt_hover) || empty($prebuilt_hover)) ? intval(0) : intval(1);
    if( 1 != $prebuilt_hover ) {
        $prebuilt_hover_style = '';
    }else{
        $prebuilt_hover_style = (!isset($prebuilt_hover_style) || empty($prebuilt_hover_style)) ?  'style1' : $prebuilt_hover_style;
    }

    $title_color = be_compute_color($title_color);
    $title_color = $title_color[1];
    $cat_color = be_compute_color($cat_color);
    $cat_color = $cat_color[1];
    $placeholder_color = be_compute_color($placeholder_color);
    $placeholder_color = $placeholder_color[1];
    $overlay_color = be_compute_color($overlay_color);
    $overlay_color = $overlay_color[1];
    $gradient_color = be_compute_color($gradient_color);
    $gradient_color = $gradient_color[1];
    
    $css_id = be_get_id_from_atts( $atts );
    $visibility_classes = be_get_visibility_classes_from_atts( $atts );
    $data_animations = be_get_animation_data_atts( $atts );
    $classes = array( 'portfolio-all-wrap', 'oshine-portfolio-module oshine-single-masonry-posts', $unique_class_name );
    if( !empty( $visibility_classes ) ) {
        $classes[] = $visibility_classes;
    }
    if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
        $classes[] = 'tatsu-animate';
    }
    if( !empty( $css_classes ) ) {
        $classes[] = $css_classes;
    }
    $animate_class = isset( $animate ) && 1 == $animate && 'none' !== $animation_type ? 'tatsu-animate' : '';
    $css_classes = !empty( $css_classes ) ? $css_classes : '';
    $visibility_classes = !empty( $visibility_classes ) ? $visibility_classes : '';
    $show_filters = $be_themes_data['blog_show_filters'];
    $show_filters = ( !empty( $show_filters ) ) ? 'yes' : 'no';
    $tax_name = ((!isset($tax_name)) || empty($tax_name)) ? 'portfolio_categories' : $tax_name;
    $filter_to_use = ((!isset($filter)) || empty($filter)) ? 'categories' : $filter;
    $items_per_page = $be_themes_data['blog_items_per_page'];
    $items_per_page = ((!isset($items_per_page)) || empty($items_per_page)) ? '-1' : $items_per_page;
    $pagination = $be_themes_data['blog_pagination_style'];
    $pagination = ( (!isset($pagination)) || empty($pagination) ) ? 'none' : $pagination;
    $default_image_style = ((!isset($default_image_style)) || empty($default_image_style)) ? 'color' : $default_image_style;
    $hover_image_style = ((!isset($hover_image_style)) || empty($hover_image_style)) ? 'color' : $hover_image_style;
    $title_animation_type = ((!isset($title_animation_type)) || empty($title_animation_type)) ? 'none' : $title_animation_type;
    $cat_animation_type = ((!isset($cat_animation_type)) || empty($cat_animation_type)) ? 'none' : $cat_animation_type;
    $image_effect = (!isset($image_effect) || empty($image_effect) || 1 == $prebuilt_hover) ? 'none' : $image_effect;
    $initial_load_style = ((!isset($initial_load_style)) || empty($initial_load_style)) ? 'none' : $initial_load_style;
    $gradient_direction = ((!isset($gradient_direction)) || empty($gradient_direction)) ? 'bottom' : $gradient_direction;
    $global_title_color = $title_color = (isset($title_color) && !empty($title_color)) ? $title_color : '';
    $global_cat_color = $cat_color = (isset($cat_color) && !empty($cat_color)) ? $cat_color : '';
    $placeholder_color = ( isset( $placeholder_color ) && !empty( $placeholder_color ) ) ? $placeholder_color : '';
    
    $cat_hide = $be_themes_data['blog_cat_hide'];
    $cat_hide = (isset($cat_hide) && !empty($cat_hide) && intval($cat_hide) != 0) ? $cat_hide : 0;
    $item_parallax = (isset($item_parallax) && !empty($item_parallax) && intval($item_parallax) != 0) ? 'portfolio-item-parallax' : '';
    $show_overlay = ( !empty( $show_overlay ) ) ? 'force-show-thumb-overlay' : '';
    if( 1 == $prebuilt_hover ) {
        $title_style = '';
    }
    $hover_style = ((!isset($hover_style)) || empty($hover_style) )  ? 'style1-hover' : $hover_style;
    $hover_style = (($show_overlay == 'force-show-thumb-overlay') || ($title_style == 'style5') || ($title_style == 'style6') || ($title_style == 'style7') || (1 == $prebuilt_hover)) ? '' : $hover_style;
    $filter_style = (isset($be_themes_data['portfolio_filter_style']) && !empty($be_themes_data['portfolio_filter_style']) ) ? $be_themes_data['portfolio_filter_style'] : 'border' ;
    $filter_alignment = (isset($be_themes_data['blog_filters_align']) && !empty($be_themes_data['blog_filters_align']) ) ? $be_themes_data['blog_filters_align'] : 'center' ;
    if( $lazy_load && 'none' != $pagination ) {
        $pagination = 'none';
    }
    if( '' != $delay_load_class && 'none' != $initial_load_style ) {
        if( 'init-slide-left' == $initial_load_style ) {
            $init_image_load = 'fadeInLeft';
        }else if( 'init-slide-right' == $initial_load_style ) {
            $init_image_load = 'fadeInRight';
        }else if( 'init-slide-top' == $initial_load_style ) {
            $init_image_load = 'fadeInDown';
        }else if( 'init-slide-bottom'== $initial_load_style ) {
            $init_image_load = 'fadeInUp';
        }else if( 'init-scale' == $initial_load_style ){	
            $init_image_load = 'zoomIn';
        }else{
            $init_image_load = $initial_load_style;
        }
    }else if( '' != $delay_load_class && 'none' == $initial_load_style ) {
        $init_image_load = 'fadeIn';
        $initial_load_style = 'fadeIn';
    }
    if( 1 == $prebuilt_hover || $show_overlay != ''){
        $title_animation_type = 'none';
        $cat_animation_type = 'none';
    }
    if(isset($title_alignment_static) && !empty($title_alignment_static) && ($title_style == 'style5' || $title_style == 'style6')) {
        $title_alignment_static = 'text-align: '.$title_alignment_static.';';
    } else {
        $title_alignment_static = '';
    }
    if($default_image_style == 'black_white') {
        if($hover_image_style == 'black_white') {
            $img_grayscale = 'bw_to_bw';
        } else {
            $img_grayscale = 'bw_to_c';
        }
    } else {
        if($hover_image_style == 'black_white') {
            $img_grayscale = 'c_to_bw';
        } else {
            $img_grayscale = 'c_to_c';
        }
    }
    if($gutter_style == 'style2') {
        $portfolio_wrap_style = 'style="margin-left: -'.$gutter_width.'px;"';
    } else {
        $portfolio_wrap_style = 'style="margin-right: '.$gutter_width.'px;"';
    }
    if(isset($overlay_opacity) && !empty($overlay_opacity)) {
        $global_overlay_opacity = $overlay_opacity = $overlay_opacity;
    } else {
        $global_overlay_opacity = $overlay_opacity = 85;
    }
    if(isset($overlay_color) && !empty($overlay_color)) {
        if( $gradient && 'style1' != $prebuilt_hover_style /* && 'style3' != $prebuilt_hover_style */ ) {
            if(!isset($gradient_color) && empty($gradient_color)) {
                $gradient_color = $overlay_color;
            } 
            $global_gradient_style_color = $gradient_style_color = 'background-image: -o-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: -moz-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: -webkit-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: -ms-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: linear-gradient(to '.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);';
        } else {
            $global_gradient_style_color = $gradient_style_color = 'background:'.$overlay_color;
        }
    }
    $aspect_ratio = !empty( $be_themes_data['blog_image_aspect_ratio'] ) ? $be_themes_data['blog_image_aspect_ratio'] : '1.6';
    $category1 = [];
    $custom_categories = get_terms( 'category', 'orderby=count&hide_empty=0' );
    if ( ! empty( $custom_categories ) && ! is_wp_error( $custom_categories ) ){
        foreach ( $custom_categories as $custom_category ) {
            $category1[] = $custom_category->slug;
        }
    }
    $two_col_mobile = !empty( $two_col_mobile ) ? 'portfolio-two-col-mobile ' : '';
    $placeholder_padding = ( 1/$aspect_ratio ) * 100;
    $output .= '<div ' . $css_id . ' class = "' . implode( ' ', $classes ) . '" ' . $data_animations . ' > ';
    $output .= $custom_style_tag;
    $output .= '<div class="portfolio '. $delay_load_class . $two_col_mobile .'full-screen1 '. ( ( 1 == $prebuilt_hover ) ? ( 'be-portfolio-prebuilt-hover-' . $prebuilt_hover_style . ' ' ) : ' ' ) . $lazy_load_class .'full-screen-gutter '.$masonry_enable.' '.$gutter_style.'-gutter '.$col.'-col " ' . ( '' != $init_image_load ? 'data-animation = "'.$init_image_load.'"' : '' ) . ' data-action="get_ajax_full_screen_gutter_post" data-category="'.implode(",",$category1).'" data-aspect-ratio = "'.$aspect_ratio.'" data-enable-masonry="'.$masonry.'" ' . ( $maintain_order ? 'data-maintain-order = "1" ' : '' ) . 'data-showposts="'.$items_per_page.'" data-paged="2" data-col="'.$col.'" data-gallery="'.$gallery.'" data-filter="'.$filter_to_use.'" data-show_filters="'.$show_filters.'" data-thumbnail-bg-color="'.$global_thumb_overlay_color.'" data-thumbnail-bg-gradient="'.$gradient_style_color.'"' . ( ( '' != $title_style ) ? ( ' data-title-style="'.$title_style.'"' ) : '' ) . ( ( $lazy_load || $delay_load ) ? ( ' data-placeholder-color="' . $placeholder_color . '"' ) : '' ) . ' data-cat-color="'.$cat_color.'" data-title-color="'.$title_color.'"' . ( ( 'none' != $title_animation_type ) ? ( ' data-title-animation-type="'.$title_animation_type.'"' ) : '' ) . ( ( 'none' != $cat_animation_type ) ? ( ' data-cat-animation-type="'.$cat_animation_type.'"' ) : '' ) . ( ( '' != $hover_style ) ? ( ' data-hover-style="'.$hover_style.'"' ) : '' ) . ' data-gutter-width="'.$gutter_width.'" data-img-grayscale="'.$img_grayscale.'"' . ( ( 'none' != $image_effect ) ? ( ' data-image-effect="'.$image_effect.'"' ) : '' ) . ( ( '' != $prebuilt_hover_style ) ? ( ' data-prebuilt-hover-style="' . $prebuilt_hover_style . '"' ) : '' ) . '" data-gradient-style-color="'.$global_gradient_style_color.'" data-cat-hide="'.$cat_hide.'" data-like-indicator="'.$like_button.'" '.$portfolio_wrap_style.'>';
    $category = explode(',', $category);
    $tags = explode(',',$tags);
    
    $category = [];
    $custom_categories = get_terms( 'category', 'orderby=count&hide_empty=0' );
    if ( ! empty( $custom_categories ) && ! is_wp_error( $custom_categories ) ){
        foreach ( $custom_categories as $custom_category ) {
            $category[] = $custom_category->slug;
        }
    }
    
    if( empty( $category ) ) {
        // $terms = get_terms( $filter_to_use , array( 'orderby' => 'count' , 'order' => 'DESC') );
        $terms = get_terms( $filter_to_use );
    } else if( $filter_to_use == 'post_tag' ){
        $args_tag = array( 'taxonomy' => 'post_tag' ) ;
        $stack = array();

        foreach(get_categories( $args_tag ) as $single_tag ) {
            
            if ( in_array( $single_tag->slug, $tags ) ) {
                array_push( $stack, $single_tag->cat_ID );
            }

        }
        $terms = get_terms($filter_to_use, array( 'include' => $stack) );

    } else {
          $args_cat = array( 'taxonomy' => 'category' ) ;
          
        $stack = array();
        foreach(get_categories( $args_cat ) as $single_category ) {
            if ( in_array( $single_category->slug, $category ) ) {
                array_push( $stack, $single_category->cat_ID );
            }
        }

        // $terms = get_terms($filter_to_use, array( 'orderby' => 'count' , 'order' => 'DESC', 'include' => $stack) );
        $terms = get_terms($filter_to_use, array( 'include' => $stack) );
    } 

    if (!( empty( $category[0] ) &&  empty( $tags[0] ))){
        if ( !empty( $category[0] ) && !empty( $tags[0] ) ){
            $tax_query = array (
                'relation' => 'AND',
                array (
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $category,
                    'operator' => 'IN',
                ),
                array (
                    'taxonomy' => 'post_tag',
                    'field' => 'slug',
                    'terms' => $tags,
                    'operator' => 'IN',
                ),
            );
        }else if( empty( $category[0] ) ){
            $tax_query = array (
                array (
                    'taxonomy' => 'post_tag',
                    'field' => 'slug',
                    'terms' => $tags,
                    'operator' => 'IN',
                ),
            );
        }else if( empty( $tags[0] ) ){
            $tax_query = array (
                array (
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $category,
                    'operator' => 'IN',
                ),
            );
        }
    }

    if(!empty( $terms ) && $show_filters == 'yes') {
        if( 0 < $gutter_width ) {
            $portfolio_filter_style = 'style="margin-left:'.$gutter_width.'px;"';
        }else {
            $portfolio_filter_style = '';
        } 
        $filter_bottom_color = $be_themes_data['blog_filter_bottom_color'];
        $filter_bottom_color = ( (!isset($filter_bottom_color)) || empty($filter_bottom_color) ) ? '#33e9b9' : $filter_bottom_color;

        $output .= '<div class="filters clearfix '.$filter_style.' align-'.$filter_alignment.'" ' . $portfolio_filter_style . '>';
        $output .= '<div class="filter_item"><style>.oshine-single-masonry-posts .filter_item span.sort.current_choice {border-color:'.$filter_bottom_color.' ;}</style><span class="sort current_choice" data-id="element">'.__( 'All topics', 'oshine-modules' ).'</span></div>';
        foreach ($terms as $term) {
            if( is_object( $term ) ) {
                $output .= '<div class="filter_item">';    		
                $output .= '<span class="sort" data-id="'.$term->slug.'">'.$term->name.'</span>';		
                $output .= '</div>';
            }
        }
        $output .= '</div>';
    }
    $output .= '<div class="portfolio-container clickable clearfix blog-posts-style10 '.$show_overlay.' '.$initial_load_style.' '.$item_parallax.'">';
    if( empty( $category[0] ) &&  empty( $tags[0] ) ) {
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $items_per_page,
            'orderby'=> apply_filters('be_portfolio_order_by','date'),
            'order'=> apply_filters('be_portfolio_order','DESC'),
            'post_status'=> 'publish'
        );
    } else {
        $args = array (
            'post_type' => 'post',
            'posts_per_page' => $items_per_page,
            'orderby'=> apply_filters('be_portfolio_order_by','date'),
            'order'=> apply_filters('be_portfolio_order','DESC'),
            'post_status'=> 'publish',
            'tax_query' => $tax_query
        );	
    }
    /*echo "<pre style='display:none;'>";
    print_r($args);
    echo "</pre>";*/
    $the_query = new WP_Query( $args );
    $delay = 0;
    $i = 0;
    if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) : $the_query->the_post();
            if ( has_post_thumbnail( get_the_ID() ) ) :
                $delay += 200;
                $isdwdh = false;
                $filter_classes = $permalink = '';
                $mfp_class = 'mfp-image';
                $post_terms = get_the_terms( get_the_ID(), $filter_to_use );
                if( $show_filters == 'yes' && is_array( $post_terms ) ) {
                    foreach ( $post_terms as  $term ) {
                        $filter_classes .=$term->slug." ";
                    }
                } else{
                    $filter_classes='';
                }
                $attachment_id = get_post_thumbnail_id(get_the_ID());
                $image_atts = get_portfolio_image(get_the_ID(), $col, $masonry);
                $attachment_thumb = wp_get_attachment_image_src( $attachment_id, $image_atts['size']);
                $attachment_full = wp_get_attachment_image_src( $attachment_id, 'full');
                $attachment_thumb_url = $attachment_thumb[0];
                $attachment_full_url = $attachment_full[0];
                if( !$attachment_thumb || empty( $attachment_thumb ) || ( 'masonry_enable' == $masonry_enable && ( !$attachment_full || empty( $attachment_full ) ) ) ) {
                    continue;
                }
                $video_url = get_post_meta( $attachment_id, 'be_themes_featured_video_url', true );
                $visit_site_url = get_post_meta( get_the_ID(), 'be_themes_portfolio_external_url', true );
                $link_to = get_post_meta( get_the_ID(), 'be_themes_portfolio_link_to', true );
                $open_with = get_post_meta( get_the_ID(), 'be_themes_portfolio_single_page_style', true );
                $single_overlay_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_color', true );
                $single_overlay_opacity = get_post_meta( get_the_ID(), 'be_themes_single_overlay_color_opacity', true );
                $single_title_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_title_color', true );
                $single_cat_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_cat_color', true );
                $attachment_info = be_wp_get_attachment($attachment_id);
                if(!isset($visit_site_url) || empty($visit_site_url)) {
                    $visit_site_url = '#';
                }
                $permalink = ( $link_to == 'external_url' ) ? $visit_site_url : get_permalink();
                $target = ("1" == get_post_meta( get_the_ID(), 'be_themes_portfolio_open_new_tab', true )) ? 'target="_blank"' : '';
                if(isset($single_overlay_opacity) && !empty($single_overlay_opacity)) {
                    $overlay_opacity = $single_overlay_opacity;
                } else {
                    $overlay_opacity = 85;
                }
                if( 'masonry_disable' == $masonry_enable ) {
                    if(  'wide-width-height' == $image_atts[ 'alt_class' ] ) {
                        $wide_width = ( 1300 ) + $gutter_width;
                        $wide_height = ( ( 650 / $aspect_ratio ) * 2 ) + $gutter_width;
                        $new_aspect_ratio = $wide_width/$wide_height;
                        $placeholder_padding = ( 1/$new_aspect_ratio ) * 100;
                        $current_dwdh_aspect_ratio = round( $attachment_thumb[ 1 ]/$attachment_thumb[ 2 ], 2 );
                        $isdwdh = true;
                    }else if( 'wide-width' == $image_atts[ 'alt_class' ] ){
                        $wide_width = ( 1300 ) + $gutter_width;
                        $normal_height = ( 650 / $aspect_ratio );
                        $new_aspect_ratio = $wide_width/$normal_height;

                        $placeholder_padding = ( 1/$new_aspect_ratio ) * 100;
                    }else if( 'wide-height' == $image_atts[ 'alt_class' ] ) {
                        $wide_height = ( ( 650 / $aspect_ratio ) * 2 ) + $gutter_width;
                        $new_aspect_ratio = 650/$wide_height;
                        $placeholder_padding = ( 1/$new_aspect_ratio ) * 100;
                    }else{
                        $placeholder_padding = ( 1/$aspect_ratio ) * 100;
                    }						
                }else{						
                    $masonry_aspect_ratio = round( $attachment_full[ 1 ]/$attachment_full[ 2 ], 2 );
                    $placeholder_padding = ( $attachment_full[ 2 ]/$attachment_full[ 1 ] ) * 100;
                }
                $current_flip_wrap_style = 'style = "padding-bottom:'.$placeholder_padding.'%;'.( ( $enable_data_src || $delay_load ) ?  ( 'background-color:'. $placeholder_color .';"' ) : '"' );

                if(isset($single_overlay_color) && !empty($single_overlay_color)) {
                    $single_overlay_color = be_themes_hexa_to_rgb( $single_overlay_color );
                    $gradient_style_color = 'background:rgba('.$single_overlay_color[0].','.$single_overlay_color[1].','.$single_overlay_color[2].','.(intval($overlay_opacity) / 100 ).')';
                    //$gradient_style_color = '';
                }  else {
                     $gradient_style_color = $global_gradient_style_color;
                }
                if(isset($single_title_color) && !empty($single_title_color)) {
                    $title_color = $single_title_color;
                } else {
                    $title_color = $global_title_color;
                }
                if(isset($single_cat_color) && !empty($single_cat_color)) {
                    $cat_color = $single_cat_color;
                } else {
                    $cat_color = $global_cat_color;
                }

                if(!empty( $video_url ) ) {
                    $attachment_full_url = $video_url;
                    $mfp_class = 'mfp-iframe';
                }
                if( ( $link_to != 'external_url' ) && isset($open_with) && $open_with == 'lightbox-gallery') {
                    $thumb_class = 'be-lightbox-gallery';
                } else if( ( $link_to != 'external_url' ) && isset($open_with) && $open_with == 'lightbox') {
                    $thumb_class = 'single-image';
                } else if( ( $link_to != 'external_url' ) && isset($open_with) && $open_with == 'none') {
                    $thumb_class = 'no-link';
                    $attachment_full_url = '#';
                } else {
                    $thumb_class = '';
                    $mfp_class = '';
                    $attachment_full_url = $permalink;
                }
                if($title_style == 'style5' || $title_style == 'style6') {
                    $trigger_animation  = '';
                } else {
                    $trigger_animation  = 'animation-trigger';
                }

                $thumb_bg_special_style = $thumb_bg_style = '';
                if( 'style2' !== $prebuilt_hover_style && 'style3' !== $prebuilt_hover_style ) {
                    if( 'style1' === $prebuilt_hover_style && !empty( $prebuilt_hover_color_style1 ) ) {
                        $thumb_bg_style = 'style="background-color:'.$prebuilt_hover_color_style1.'"';
                    } else if( !empty( $gradient_style_color ) ) {
                        $thumb_bg_style = 'style="'.$gradient_style_color.'"';
                    }
                } else {
                    if( !empty( $gradient_style_color ) ) {
                        $thumb_bg_special_style = 'style="'.$gradient_style_color.'"';
                    }
                }

                $thumb_title_style = '';
                if( !empty( $title_color ) ) {
                    $thumb_title_style = 'color:'.$title_color.';';
                }
                if( 0 == $prebuilt_hover ) {
                    $thumb_title_style .= $title_alignment_static;
                }
                if( !empty( $thumb_title_style ) ) {
                    $thumb_title_style = 'style="'.$thumb_title_style.'"'; 
                }

                $cat_style = '';
                if( !empty( $cat_color ) ) {
                    $cat_style = 'color:'.$cat_color.';';
                }
                if( 0 == $prebuilt_hover ) {
                    $cat_style .= $title_alignment_static;
                }
                if( !empty( $cat_style ) ) {
                    $cat_style = 'style="'.$cat_style.'"'; 
                }

                //GDPR Privacy preference popup logic
                $gdpr_atts = '{}';
                $gdpr_concern_selector = '';
                $tempModalContents = '';
                if( $mfp_class === 'mfp-iframe' ){
                    if( function_exists( 'be_gdpr_privacy_ok' ) ){
                        $video_details =  be_get_video_details($video_url);
                        $key = be_uniqid_base36(true);
                        if( !empty( $_COOKIE ) ){
                            if( !be_gdpr_privacy_ok($video_details['source'] ) ){
                                $mfp_class = 'mfp-popup';
                                $attachment_full_url = '#gdpr-alt-lightbox-'.$key;
                                $tempModalContents .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
                            }
                        } else {
                            $gdpr_atts = array(
                                'concern' => $video_details[ 'source' ],
                                'add' => array( 
                                    'class' => array( 'mfp-popup' ),
                                    'atts'	=> array( 'href' => '#gdpr-alt-lightbox-'.$key ),
                                ),
                                'remove' => array( 
                                    'class' => array( $mfp_class )
                                )
                            );
                            $gdpr_concern_selector = 'be-gdpr-consent-required';
                            $gdpr_atts = json_encode( $gdpr_atts );
                            $tempModalContents .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
                        }
                    }
                }
                   
                $output .= '<div totalposts="'.$the_query->found_posts.'" class="element be-hoverlay '.$image_atts['class'].' '.$image_atts['alt_class'].' '.$hover_style.' '.$img_grayscale . ( ( '' != $title_style ) ? ( ' '.$title_style.'-title"' ) : '"' ) . 'style="margin-bottom: '.$gutter_width.'px;" data-category-names = "'.$filter_classes.'">';
                $output .= '<div class="element-inner" style="margin-left: '.$gutter_width.'px;">';
                $output .= '<a href="'.$attachment_full_url.'" class=" thumb-wrap '.$thumb_class.' '.$mfp_class.' '.$gdpr_concern_selector.'" data-gdpr-atts='.$gdpr_atts.' title="'.$attachment_info['title'].'" '.$target.'>';
                
                $output .= '<div class="flip-wrap" ><div ' . ( "masonry_enable" == $masonry_enable ? ( 'data-aspect-ratio="'.$masonry_aspect_ratio.'"' )  : '' ) . '  style = "padding-bottom : '. $placeholder_padding .'%;'.( !empty( $placeholder_color ) ? 'background-color:'. $placeholder_color : '' ).';" class="flip-img-wrap' . ( ( 'none' != $image_effect ) ? ( ' '.$image_effect.'-effect"' ) : '"' ) .'><img '. ( $enable_data_src ? 'data-src="'.$attachment_thumb_url : 'src="'.$attachment_thumb_url ) .'" ' . ( $isdwdh ? ( 'data-aspect-ratio="'.$current_dwdh_aspect_ratio.'"' ) : '' ) . 'alt="'.$attachment_info['alt'].'"/></div></div>';
                $output .= '<div class="thumb-overlay-no "><div class="thumb-bg " '.$thumb_bg_style.'>';
                $output .= ( ( 'style2' == $prebuilt_hover_style ) ? '<div class = "be-prebuilt-overlay-wrapper" '.$thumb_bg_special_style.'></div>' : '' );
                $output .=  ( 'style3' == $prebuilt_hover_style ) ? '<div class = "thumb-shadow-wrapper"></div><div '.$thumb_bg_special_style.' class = "be-thumb-overlay-wrap"></div>' : '';
                $output .= '<div class="thumb-title-wrap ">';
                $output .= '<div class="thumb-title '. ( ( 'style5' != $title_style && 'style6' != $title_style && 0 == $prebuilt_hover ) ? ( 'animated '. $trigger_animation .'"' ) : '"'  ) .  ( ( 0 == $prebuilt_hover ) ? ( ' data-animation-type="'.$title_animation_type.'"' ) : ' ' ) .$thumb_title_style.'>';
                $output .= ( 'style2' == $prebuilt_hover_style || 'style4' == $prebuilt_hover_style ) ? ( '<div class = "thumb-title-inner-wrap">' ) : '';
                
                $terms = be_themes_get_taxonomies_by_id(get_the_ID(), isset($meta_to_show) ? $meta_to_show : 'portfolio_categories' ) ;
                if(!empty($terms) && (isset($cat_hide) && !($cat_hide) ) ) {	
                    $output .= '<div class="portfolio-item-cats '. ( ( 'style5' != $title_style && 'style6' != $title_style && 0 == $prebuilt_hover ) ? ( 'animated '. $trigger_animation .'"' ) : '"'  ) . ( ( 0 == $prebuilt_hover ) ? ( ' data-animation-type="'.$cat_animation_type.'"' ) : ' ' ) .$cat_style.'>';
                    $length = 1;
                    $output .= ( ( 'style2' == $prebuilt_hover_style || 'style4' == $prebuilt_hover_style ) ? '<div class = "portfolio-item-cats-inner-wrap">' : '' );
                    foreach ($terms as $term) {
                        if( is_object($term) ) {
                            $output .= '<span>'.$term->name.'</span>';
                            if(count($terms) != $length) {
                                $output .= '<span> &middot; </span>';
                            }
                        }
                        $length++;
                    }
                    $output .= ( ( 'style2' == $prebuilt_hover_style || 'style4' == $prebuilt_hover_style ) ? '</div></div>' : '</div>' );
                }
                
                $output .= ( 'style2' == $prebuilt_hover_style ) ? ( '</div><hr class = "be-portfolio-prebuilt-hover-separator"></hr></div>' ) :  ( ( 'style4' == $prebuilt_hover_style ) ? '</div></div>' : '</div>' );
                
                $output .= "<h6>".get_the_title()."</h6>";
                
                
                $output .= '</div>';
                $output .= '</div>'; // End Thumb Bg
                
                $output .= '<div class="read-more"><a href="'.$attachment_full_url.'">Read <i class="tatsu-icon icon-arrow-right7"></i></a></div>';
                
                $output .= ( ( 1 == $prebuilt_hover && 'style1' == $prebuilt_hover_style ) ? ( '<div class = "thumb-border-wrapper" style = "border-color:' . ( ( isset($thumb_overlay_color) && !empty($thumb_overlay_color) ) ? $thumb_overlay_color : $overlay_color ) . ';" ></div>' ) : '' ) . '</div>'; //End Thumb Bg & Thumb Overlay
                $output .= '</a>'; //End Thumb Wrap
                $output .= $tempModalContents;
                if(isset($open_with) && $open_with == 'lightbox-gallery') :
                    $output .='<div class="popup-gallery">';
                    $attachments = get_post_meta(get_the_ID(),'be_themes_single_portfolio_slider_images');
                    $tempModalContents = '';
                    if(!empty($attachments)) {
                        foreach ( $attachments as $attachment_id ) {
                            $attach_img = wp_get_attachment_image_src($attachment_id, 'full');
                            $video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);
                            $attachment_info = be_wp_get_attachment($attachment_id);
                            if($video_url) {
                                $url = $video_url;
                                $mfp_class = 'mfp-iframe';
                            } else {
                                $url = $attach_img[0];
                                $mfp_class ='mfp-image';
                            }

                            //GDPR Privacy preference popup logic
                            $gdpr_atts = '{}';
                            $gdpr_concern_selector = '';
                            if( $mfp_class === 'mfp-iframe' ){
                                if( function_exists( 'be_gdpr_privacy_ok' ) ){
                                    $video_details =  be_get_video_details($video_url);
                                    $key = be_uniqid_base36(true);
                                    if( !empty( $_COOKIE ) ){
                                        if( !be_gdpr_privacy_ok($video_details['source'] ) ){
                                            $mfp_class = 'mfp-popup';
                                            $url = '#gdpr-alt-lightbox-'.$key;
                                            $tempModalContents .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
                                        }
                                    } else {
                                        $gdpr_atts = array(
                                            'concern' => $video_details[ 'source' ],
                                            'add' => array( 
                                                'class' => array( 'mfp-popup' ),
                                                'atts'	=> array( 'href' => '#gdpr-alt-lightbox-'.$key ),
                                            ),
                                            'remove' => array( 
                                                'class' => array( $mfp_class )
                                            )
                                        );
                                        $gdpr_concern_selector = 'be-gdpr-consent-required';
                                        $gdpr_atts = json_encode( $gdpr_atts );
                                        $tempModalContents .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
                                    }
                                }
                            }

                            $output .='<a href="'.$url.'" class="'.$mfp_class.' '.$gdpr_concern_selector.'" data-gdpr-atts='.$gdpr_atts.' title="'.$attachment_info['title'].'"></a>';
                        }
                    }
                    $output .= '</div>'; //End Gallery
                    $output .= $tempModalContents;
                endif;
                //$output .= ($like_button != 1) ? '<div class="portfolio-like like-button-wrap">'.be_get_like_button(get_the_ID()).'</div>' : '';
                $output .= '</div>'; //End Element Inner
                $output .= '</div>'; //End Element
            endif;	
            $i++;
        endwhile;
    endif;
    wp_reset_postdata();
    $output .='</div>'; //end portfolio-container
    if('-1' != $items_per_page && ($the_query->found_posts-$items_per_page)>0) {
        $items_initial_load = $items_per_page;
        if( $pagination == 'infinite' ) {
            $output .='<div class="trigger_infinite_scroll portfolio_infinite_scroll" data-type="portfolio"></div>';
        } elseif( $pagination == 'loadmore' ) {
            $output .='<div class="trigger_load_more portfolio_load_more" data-total-items="'.($the_query->found_posts-$items_initial_load).'" data-type="portfolio"><a class="be-shortcode mediumbtn be-button tatsu-button alt-bg alt-bg-text-color" href="#">'.__( 'Load More', 'oshine-modules' ).'</a></div>';
        }
    }
    $output .='</div></div>'; //end portfolio
    //double height/width script

    echo $output;

?>