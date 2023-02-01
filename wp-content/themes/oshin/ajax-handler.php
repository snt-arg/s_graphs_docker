<?php
/*
 * Ajax Request handler
 */
/* ---------------------------------------------------*/
// Function for Post Load More / Infinite scroll
/* ---------------------------------------------------*/
if ( ! function_exists( 'be_themes_get_ajax_full_screen_gutter_post' ) ) :
	function be_themes_get_ajax_full_screen_gutter_post() {
		extract($_POST);
		$output='';
		$overlay_color = '';
		$prebuilt_hover_color_style1 = 'rgba(0, 0, 0, 0.5);';
		$global_thumb_overlay_color = $thumb_overlay_color;
		$global_gradient_style_color = $gradient_style_color;
		$global_like_button  = $like_button;
		if( 'style1' == $prebuilt_hover_style || 'style3' == $prebuilt_hover_style ) {
			$temp = explode( ':', $global_gradient_style_color );
			if( !empty($temp[1]) ) {
				$overlay_color = $temp[1];
			}
		}		
		$aspect_ratio = !empty( $be_themes_data['blog_image_aspect_ratio'] ) ? $be_themes_data['blog_image_aspect_ratio'] : '1.6';
		if(isset($title_color) && !empty($title_color)) {
			$global_title_color = $title_color = $title_color;
		} else {
			$global_title_color = $title_color = '';
		}
		if(isset($cat_color) && !empty($cat_color)) {
			$global_cat_color = $cat_color = $cat_color;
		} else {
			$global_cat_color = $cat_color = '';
		}
		$placeholder_color = ( isset( $placeholder_color ) && !empty( $placeholder_color ) ) ? $placeholder_color : '';
		if($filter == 'categories'){
			$filter_to_use = 'portfolio_'.$filter;
		} else{
			$filter_to_use = $filter;
		}
		$offset = ( ( $showposts * $paged ) - $showposts );
		if( $paged == 0 ) {
			$offset = 0; 
		} else {
			$offset = ( ( $showposts * $paged ) - $showposts ); 
		}
		$selected_categorey = explode(',', $category);
		$masonry_enable = ((!isset($masonry)) || empty($masonry)) ? 'masonry_disable' : 'masonry_enable';
		if($category) {
			$args = array (
				'post_type' => 'post',
				'posts_per_page' => intval($showposts),
				'offset' => intval($offset),
				'tax_query' => array (
					array (
						'taxonomy' => 'category',
						'field' => 'slug',
						'terms' => $selected_categorey,
						'operator' => 'IN'
					)
				),
				'orderby'=> apply_filters('be_portfolio_order_by','date'),
				'order'=> apply_filters('be_portfolio_order','DESC'),
				'post_status'=> 'publish'
			);
		}
		else {
			$args = array (
				'post_type' => 'post',
				'posts_per_page' => intval($showposts),
				'offset' => intval($offset),
				'orderby'=> apply_filters('be_portfolio_order_by','date'),
				'order'=> apply_filters('be_portfolio_order','DESC'),
				'post_status'=> 'publish'
			);
		}
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$filter_classes = $permalink = '';
				$mfp_class = 'mfp-image';
				$isdwdh = false;
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
				if( !$attachment_thumb || empty( $attachment_thumb ) || ( 'masonry_enable' == $masonry_enable && ( !$attachment_full || empty( $attachment_full ) ) ) ) {
					continue;
				}					
				$attachment_thumb_url = $attachment_thumb[0];
				$attachment_full_url = $attachment_full[0];
				$video_url = get_post_meta( $attachment_id, 'be_themes_featured_video_url', true );
				$visit_site_url = get_post_meta( get_the_ID(), 'be_themes_portfolio_external_url', true );
				$link_to = get_post_meta( get_the_ID(), 'be_themes_portfolio_link_to', true );
				$open_with = get_post_meta( get_the_ID(), 'be_themes_portfolio_single_page_style', true );
				$single_overlay_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_color', true );
				$single_overlay_opacity = get_post_meta( get_the_ID(), 'be_themes_single_overlay_color_opacity', true );
				$single_title_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_title_color', true );
				$single_cat_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_cat_color', true );
				$attachment_info = be_wp_get_attachment($attachment_id);
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
				if(isset($single_overlay_color) && !empty($single_overlay_color)) {
					$single_overlay_color = be_themes_hexa_to_rgb( $single_overlay_color );
					$gradient_style_color = 'background:rgba('.$single_overlay_color[0].','.$single_overlay_color[1].','.$single_overlay_color[2].','.(intval($overlay_opacity) / 100 ).')';
				} else {
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
					$thumb_class = 'image-popup-vertical-fit';
				} else if( ( $link_to != 'external_url' ) && isset($open_with) && $open_with == 'none') {
					$thumb_class = 'no-link';
					$attachment_full_url = '#';
				} else {
					$thumb_class = ( $link_to == 'external_url' || !empty( $target )  ) ? '' : 'dJAX_internal';
					$mfp_class = '';
					$attachment_full_url = $permalink;
				}
				if($hover_style == 'style9-hover') {
					$trigger_animation  = '';
				} else {
					$trigger_animation  = 'animation-trigger';
				}
				$link_to_thumbnail = $attachment_full_url;
				$terms = be_themes_get_taxonomies_by_id(get_the_ID(), 'category');
				$element_classes = '';
				foreach ($terms as $term) {
					$element_classes .= $term->slug.' ';
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
								$link_to_thumbnail = '#gdpr-alt-lightbox-'.$key;
								$attachment_full_url = $link_to_thumbnail;
								$tempModalContents .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
							}
						} else {
							$gdpr_atts = array(
								'concern' => $video_details[ 'source' ],
								'add' => array( 
									'class' => array( 'mfp-popup' ),
									'atts'	=> array( 'href' => '#gdpr-alt-lightbox-'.$key,
													  'data-href' => '#gdpr-alt-lightbox-'.$key ),
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

				//' style="background-color:'. ( ('style1' == $prebuilt_hover_style) ? $prebuilt_hover_color_style1 : ( $thumb_overlay_color.';'.$gradient_style_color ) ) .'"' ) : '' )

				$output .= '<div class="check-class element be-hoverlay '.$image_atts['class'].' '.$image_atts['alt_class'].' '.$hover_style.' '.$img_grayscale  .( ( '' != $title_style ) ? ( ' '.$title_style.'-title"' ) : '"' ) .  ' id="'.be_get_the_slug(get_the_ID()).'" style="margin-bottom: '.$gutter_width.'px !important;" data-category-names="' . $filter_classes . '" >';
				$output .= '<div class="element-inner" style="margin-left: '.$gutter_width.'px;">';
				$output .= '<a href="'.$link_to_thumbnail.'" data-href="'.$attachment_full_url.'" class="thumb-wrap '.$thumb_class.' '.$mfp_class.' '.$gdpr_concern_selector.'" data-gdpr-atts='.$gdpr_atts.'  title="'.$attachment_info['title'].'" '.$target.'>';
				$output .= '<div class="flip-wrap"><div ' . ( "masonry_enable" == $masonry_enable ? ( 'data-aspect-ratio="'.$masonry_aspect_ratio.'"' )  : '' ) . ' style = "padding-bottom : '. $placeholder_padding .'%;'.( !empty( $placeholder_color ) ? 'background-color:'. $placeholder_color : '' ).';" class="flip-img-wrap' . ( ( '' != $image_effect ) ? ( ' '.$image_effect.'-effect"' ) : '"' ) .'><img src="'.$attachment_thumb_url.'" ' . ( $isdwdh ? ( 'data-aspect-ratio="'.$current_dwdh_aspect_ratio.'"' ) : '' ) . ' alt /></div></div>';
				$output .= '<div class="thumb-overlay-no"><div class="thumb-bg " '.$thumb_bg_style.'>';
				$output .= ( ( 'style2' == $prebuilt_hover_style ) ? '<div class = "be-prebuilt-overlay-wrapper" '.$thumb_bg_special_style.'></div>' : '' );
				$output .=  ( 'style3' == $prebuilt_hover_style ) ? '<div class = "thumb-shadow-wrapper"></div><div '.$thumb_bg_special_style.' class = "be-thumb-overlay-wrap"></div>' : '';
				$output .= '<div class="thumb-title-wrap ">';
				$output .= '<div class="thumb-title '. ( ( 'style5' != $title_style && 'style6' != $title_style && '' == $prebuilt_hover_style ) ? ( 'animated '. $trigger_animation .'"' ) : '"'  ) . ( ( '' == $prebuilt_hover_style ) ? ( ' data-animation-type="'.$title_animation_type.'"' ) : ' ' ) . ( !empty( $title_color ) ? 'style="color: '.$title_color.';"' : '').'>';
				$output .= ( 'style2' == $prebuilt_hover_style || 'style4' == $prebuilt_hover_style ) ? ( '<div class = "thumb-title-inner-wrap">' ) : '';
							
				if(!empty($terms) && (isset($cat_hide) && !($cat_hide) ) ) {
					$output .= '<div class="portfolio-item-cats '. ( ( 'style5' != $title_style && 'style6' != $title_style && '' == $prebuilt_hover_style ) ? ( 'animated '. $trigger_animation .'"' ) : '"'  ) . ( ( '' == $prebuilt_hover_style ) ? ( ' data-animation-type="'.$cat_animation_type.'"' ) : ' ' ) . ( !empty( $cat_color ) ? 'style="color: '.$cat_color.';"' : '').'>';
					$length = 1;
					$output .= ( ( 'style2' == $prebuilt_hover_style || 'style4' == $prebuilt_hover_style ) ? '<div class = "portfolio-item-cats-inner-wrap">' : '' );
					foreach ($terms as $term) {
						$output .= '<span>'.$term->name.'</span>';
						if(count($terms) != $length) {
							$output .= '<span> &middot; </span>';
						}
						$length++;
					}
					$output .= ( ( 'style2' == $prebuilt_hover_style || 'style4' == $prebuilt_hover_style ) ? '</div></div>' : '</div>' );
				}		

				$output .= ( 'style2' == $prebuilt_hover_style ) ? ( '</div><hr class = "be-portfolio-prebuilt-hover-separator"></hr></div>' ) : ( ( 'style4' == $prebuilt_hover_style ) ? '</div></div>' : '</div>' );

                $output .= "<h6>".get_the_title()."</h6>";

                $output .= '<div class="read-more"><a href="'.$attachment_full_url.'">Read <i class="tatsu-icon icon-arrow-right7"></i></a></div>';    
                
				$output .= '</div>';
				$output .= '</div>';
				$output .= ( ( 'style1' == $prebuilt_hover_style ) ? ( '<div class = "thumb-border-wrapper" style = "border-color:' . ( ( isset($thumb_overlay_color) && !empty($thumb_overlay_color) ) ? $thumb_overlay_color : $overlay_color ) . ';" ></div>' ) : '' ) . '</div>'; //End Thumb Bg & Thumb Overlay
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

							$output .='<a href="'.$url.'" class="'.$mfp_class.' '. $gdpr_concern_selector .'" title="'.$attachment_info['title'].'" data-gdpr-atts='.$gdpr_atts.' ></a>';
						}
					}
					$output .= '</div>'; //End Gallery
					$output .= $tempModalContents;
				endif;
				//$output .= ($global_like_button != 1) ? '<div class="portfolio-like like-button-wrap">'.be_get_like_button(get_the_ID()).'</div>' : '';
				$output .= '</div>'; //End Element Inner
				$output .= '</div>'; //End Element
			endwhile;
			wp_reset_postdata();
			echo $output;
		else :
			return 0;
		endif;
		die();
	}
	add_action( 'wp_ajax_nopriv_get_ajax_full_screen_gutter_post', 'be_themes_get_ajax_full_screen_gutter_post' );
	add_action( 'wp_ajax_get_ajax_full_screen_gutter_post', 'be_themes_get_ajax_full_screen_gutter_post' );
endif;

/* ---------------------------------------------  */
// Function for processing Blog Pagination
/* ---------------------------------------------  */
add_action( 'wp_ajax_nopriv_get_blog', 'be_themes_get_blog' );
add_action( 'wp_ajax_get_blog', 'be_themes_get_blog' );
function be_themes_get_blog() {
	extract($_POST);
	global $blog_attr;
	$blog_attr['gutter_width'] = ((!isset($_POST['gutter_width'])) || empty($_POST['gutter_width'])) ? intval(40) : intval( $_POST['gutter_width'] );
	$blog_attr['style'] = ( isset( $blog_style ) && !empty( $blog_style ) ) ? $blog_style : 'style3';
		global $wp_query;
	// alert($showposts * ( $paged - 1 ));
	// if( ( $showposts * ( $paged - 1 ) ) > $total_items ) {
	// 	return 0;
	// 	die();
	// } else {
		if(!(is_category() || is_archive() || is_tag() || is_search())) {
			// var_dump($wp_query);
			$args = array (
				'paged' => $paged,
				'post_status'=> 'publish',
				'ignore_sticky_posts'=> true
			);
			query_posts($args);
		}
		if( have_posts() ) :
			while ( have_posts() ) : the_post();
				$blog_style = be_get_blog_loop_style( $blog_attr['style'] );
				get_template_part( 'blog/loop', $blog_style );
			endwhile;
		else :
			return 0;
		endif;
		wp_reset_postdata();
		wp_reset_query();
		die();
	// }
}

?>