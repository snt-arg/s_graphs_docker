<?php 
/**
 * Blog page : single post on Top
 */
global $be_themes_data, $blog_attr;
?>
<section id="blog-single-post-content" class="no-sidebar-page" >
	<div class="clearfix be-wrap">
		<?php
		$atts =  array (
            'read_more_text'=> '',
			'post_selected' => '',
			'post_title_font_size' => '27',
			'post_title_font_weight' => 'normal',
			'post_title_color' => '',
			'post_title_line_height' => '35',
			'post_title_text_align' => 'left',
            'post_content_font_size' => '16',
			'post_content_font_weight' => 'normal',
			'post_content_color' => '',
			'post_content_line_height' => '22',
			'post_content_text_align' => 'left',
            'post_cta_font_size' => '16',
			'post_cta_font_weight' => 'normal',
			'post_cta_color' => '',
			'post_cta_hover_color' => '',
            'key' => be_uniqid_base36(true),
        );
        extract( $atts );
        
        $output = "";
        $css_id = be_get_id_from_atts( $atts );
        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
        $visibility_classes = be_get_visibility_classes_from_atts( $atts );
         $data_animations = be_get_animation_data_atts( $atts );
        $classes = array( $unique_class_name,'tatsu-single-post' );
        if( !empty( $visibility_classes ) ) {
            $classes[] = $visibility_classes;
        }
        if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        if( !empty( $css_classes ) ) {
            $classes[] = $css_classes;
        }
        $output .= '<div ' . $css_id . ' class = "' . implode( ' ', $classes ) . '" ' . $data_animations . ' > ';
        $output .= $custom_style_tag;
        $aspect_ratio = !empty( $be_themes_data['portfolio_aspect_ratio'] ) ? $be_themes_data['portfolio_aspect_ratio'] : '1.6';
		$placeholder_padding = ( 1/$aspect_ratio ) * 100;
        
        $post_title_style = "";
        if(!empty($post_title_font_size)){
            $post_title_style .= 'font-size:'.$post_title_font_size.'px;';
        }
        if(!empty($post_title_line_height)){
            $post_title_style .= 'line-height:'.$post_title_line_height.'px;';
        }
        if(!empty($post_title_color)){
            $post_title_style .= 'color:'.$post_title_color.';';
        } 
        if(!empty($post_title_font_weight)){
            $post_title_style .= 'font-weight:'.$post_title_font_weight.';';
        }
        if(!empty($post_title_text_align)){
            $post_title_style .= 'text-align:'.$post_title_text_align.';';
        }
        if( !empty( $post_title_style ) ) {
			$post_title_style = 'style="'.$post_title_style.'"'; 
		}
        $post_content_style = "";
        if(!empty($post_content_font_size)){
            $post_content_style .= 'font-size:'.$post_content_font_size.'px;';
        }
        if(!empty($post_content_line_height)){
            $post_content_style .= 'line-height:'.$post_content_line_height.'px;';
        }
        if(!empty($post_content_color)){
            $post_content_style .= 'color:'.$post_content_color.';';
        } 
        if(!empty($post_content_font_weight)){
            $post_content_style .= 'font-weight:'.$post_content_font_weight.';';
        }
        if(!empty($post_content_text_align)){
            $post_content_style .= 'text-align:'.$post_content_text_align.';';
        }
        if( !empty( $post_content_style ) ) {
			$post_content_style = 'style="'.$post_content_style.'"'; 
		}
        $post_cta_style = "";$post_cta_hover="";
        if(!empty($post_cta_font_size)){
            $post_cta_style .= 'font-size:'.$post_cta_font_size.'px;text-transform: inherit;';
        }
        if(!empty($post_cta_color)){
            $post_cta_style .= 'color:'.$post_cta_color.';';
        } 
        if(!empty($post_cta_hover_color)){
            $post_cta_hover = '<style>.tatsu-button:hover{color: '.$post_cta_hover_color.'!important;}</style>';
        } 
        if(!empty($post_cta_font_weight)){
            $post_cta_style .= 'font-weight:'.$post_cta_font_weight.';';
        }
        
        if( !empty( $post_cta_style ) ) {
			$post_cta_style = 'style="'.$post_cta_style.'"'; 
		}
         
            $post_id = $be_themes_data['blog_single_post_selected'];
        if(!empty($post_id))
        {   $read_more_text = $be_themes_data['blog_single_post_read_more_text'];
            $permalink = get_the_permalink($post_id);
            $attachment_id = get_post_thumbnail_id($post_id);
            $attachment_full = wp_get_attachment_image_src( $attachment_id, 'full');
            $attachment_full_url = $attachment_full[0];
            $categories = get_the_category($post_id);
            $cat_list = '';$separator = ' ';
            if ( ! empty( $categories ) ) {
                foreach( $categories as $category ) {
                    $cat_list .= '<a class="cats" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'tatsu' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
                    //$cat_list .= esc_html( $category->name ).$separator;
                }
            }
            //$content = substr( get_the_excerpt($post_id), 0, 400 ).'...';
            $content = get_the_excerpt($post_id);
        
        $output .= '
        <div class="tatsu-row "><div class="tatsu-column  tatsu-bg-overlay tatsu-one-half tatsu-column-image-none tatsu-column-effect-none  tatsu-17hnUzemN" data-parallax-speed="0" style=""><div class="tatsu-column-inner "><div class="tatsu-column-pad-wrap"><div class="tatsu-column-pad"><div class="tatsu-single-image- tatsu-module tatsu-animate tatsu-image-lazyload tatsu-keidh3efC   already-visible fadeIn end-animation" data-animation="fadeIn"><div class="tatsu-single-image-inner " style="width : 1000px;"><div class="tatsu-single-image-padding-wrap front_end"></div><a href="'.$permalink.'"><img class="tatsu-gradient-border" alt="" data-src="'.$attachment_full_url.'" src="'.$attachment_full_url.'" style="opacity: 1;"></a></div><style>.tatsu-keidh3efC .tatsu-single-image-inner{max-width: 100%;}.tatsu-keidh3efC.tatsu-single-image{transform: translate3d(0px,0px, 0);}</style></div></div></div><div class="tatsu-column-bg-image-wrap"><div class="tatsu-column-bg-image"></div></div><div class="tatsu-overlay tatsu-column-overlay tatsu-animate-none"></div></div></div><div class="tatsu-column  tatsu-bg-overlay tatsu-one-half tatsu-column-image-none tatsu-column-effect-none  tatsu-VkugRMMpJx" data-parallax-speed="0" style=""><div class="tatsu-column-inner "><div class="tatsu-column-pad-wrap"><div class="tatsu-column-pad"><div class="tatsu-module tatsu-text-block-wrap tatsu-Aeb3lXp39  "><div class="tatsu-text-inner tatsu-align-center  clearfix">
        <p>'.$cat_list.'</p>
        </div></div><div class="tatsu-module tatsu-text-block-wrap tatsu-qXm8DBp3a"><div class="tatsu-text-inner tatsu-align-center  clearfix">
        <h1 '.$post_title_style.'>'.get_the_title($post_id).'</h1>
        </div></div><div class="tatsu-module tatsu-text-block-wrap tatsu-ykQHFA_87  ">
            <div class="tatsu-text-inner tatsu-align-center  clearfix" '.$post_content_style.'>
            <p>'.$content.'</p>
        </div>
        </div>
        <div class="tatsu-module tatsu-normal-button tatsu-button-wrap align-block block-left  tatsu-AT4JKDmAK   ">'.$post_cta_hover.'
        <a class="tatsu-shortcode smallbtn tatsu-button right-icon    bg-animation-none  " href="'.$permalink.'" aria-label="'.$read_more_text.'" data-gdpr-atts="{}" '.$post_cta_style.' >'.$read_more_text.'<i class="tatsu-icon icon-arrow-right7"></i></a></div></div></div>
        <div class="tatsu-column-bg-image-wrap"><div class="tatsu-column-bg-image"></div></div><div class="tatsu-overlay tatsu-column-overlay tatsu-animate-none"></div></div></div></div>';
                $output .= '</div> ';
          echo $output;
        }
		?>
	</div> <!--  End Page Content -->
</section>