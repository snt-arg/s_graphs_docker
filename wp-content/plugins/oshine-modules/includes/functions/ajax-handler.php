<?php
/*
 * Ajax Request handler
 */

/* ---------------------------------------------  */
// Function for processing contact form submission
/* ---------------------------------------------  */

if ( ! function_exists( 'be_themes_contact_authentication' ) ) :
	function be_themes_contact_authentication() {
		global $be_themes_data;
		$contact_name = $_POST['contact_name'];
		$contact_email = $_POST['contact_email'];
		$contact_style = $_POST['contact_style'];
		$contact_comment = $_POST['contact_comment'];
		$contact_subject = $_POST['contact_subject'];
		if(empty($contact_name) || empty($contact_email) || empty($contact_comment) || ( ( 'style1' == $contact_style ) && empty($contact_subject) ) ) {
			$result['status']="error";
			$result['data']= __('All fields are required','oshine-modules');
		}
		else if(!preg_match ('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/', $contact_email)) {
			$result['status']="error";
			$result['data']=__('Please enter a valid email address','oshine-modules');
		}
		else {
			$contact_comment = "Name: ".$contact_name."\n\nMessage:\n".$_POST['contact_comment'];
			if ( !empty( $be_themes_data['mail_id'] ) ) {
				$to = $be_themes_data['mail_id'];
			} else {
				$to = get_option('admin_email');
			}		
			$subject= $contact_subject;
			$from = $contact_name." <".$contact_email.">";
			$headers = "From:" . $from . "\r\n" . 'Reply-To: '.$from;
			$mail = wp_mail($to,$subject,$contact_comment,$headers);
			if( $mail ) {
				$result['status']="success";
				$result['data']=__('Your message was sent successfully','oshine-modules');
			} else {
				$result['status']="error";
				$result['data']=__('Unable to send the message. Please try again later','oshine-modules');
			}
		}
		header('Content-type: application/json');
		echo json_encode($result);
		die();
	}
	add_action( 'wp_ajax_nopriv_contact_authentication', 'be_themes_contact_authentication' );
	add_action( 'wp_ajax_contact_authentication', 'be_themes_contact_authentication' );
endif; 

/* ---------------------------------------------------*/
// Function for Portfolio Load More / Infinite scroll
/* ---------------------------------------------------*/
//mymark
if ( ! function_exists( 'be_themes_get_ajax_full_screen_gutter_portfolio' ) ) :
	function be_themes_get_ajax_full_screen_gutter_portfolio() {
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
		$aspect_ratio = !empty( $be_themes_data['portfolio_aspect_ratio'] ) ? $be_themes_data['portfolio_aspect_ratio'] : '1.6';
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
				'post_type' => 'portfolio',
				'posts_per_page' => intval($showposts),
				'offset' => intval($offset),
				'tax_query' => array (
					array (
						'taxonomy' => 'portfolio_categories',
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
				'post_type' => 'portfolio',
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
				
				$terms = be_themes_get_taxonomies_by_id(get_the_ID(), isset($meta_to_show) ? $meta_to_show : 'portfolio_categories' ) ;
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
				$output .= '<div class="thumb-overlay"><div class="thumb-bg " '.$thumb_bg_style.'>';
				$output .= ( ( 'style2' == $prebuilt_hover_style ) ? '<div class = "be-prebuilt-overlay-wrapper" '.$thumb_bg_special_style.'></div>' : '' );
				$output .=  ( 'style3' == $prebuilt_hover_style ) ? '<div class = "thumb-shadow-wrapper"></div><div '.$thumb_bg_special_style.' class = "be-thumb-overlay-wrap"></div>' : '';
				$output .= '<div class="thumb-title-wrap ">';
				$output .= '<div class="thumb-title '. ( ( 'style5' != $title_style && 'style6' != $title_style && '' == $prebuilt_hover_style ) ? ( 'animated '. $trigger_animation .'"' ) : '"'  ) . ( ( '' == $prebuilt_hover_style ) ? ( ' data-animation-type="'.$title_animation_type.'"' ) : ' ' ) . ( !empty( $title_color ) ? 'style="color: '.$title_color.';"' : '').'>';
				$output .= ( 'style2' == $prebuilt_hover_style || 'style4' == $prebuilt_hover_style ) ? ( '<div class = "thumb-title-inner-wrap">' ) : '';
				$output .= get_the_title();
				$output .= ( 'style2' == $prebuilt_hover_style ) ? ( '</div><hr class = "be-portfolio-prebuilt-hover-separator"></hr></div>' ) : ( ( 'style4' == $prebuilt_hover_style ) ? '</div></div>' : '</div>' );				
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
				$output .= ($global_like_button != 1) ? '<div class="portfolio-like like-button-wrap">'.be_get_like_button(get_the_ID()).'</div>' : '';
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
	add_action( 'wp_ajax_nopriv_get_ajax_full_screen_gutter_portfolio', 'be_themes_get_ajax_full_screen_gutter_portfolio' );
	add_action( 'wp_ajax_get_ajax_full_screen_gutter_portfolio', 'be_themes_get_ajax_full_screen_gutter_portfolio' );
endif;

/* ---------------------------------------------  */
// Function for processing Like Button
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_post_like' ) ) :
	function be_themes_post_like() {
		extract($_POST);
		$post_like_count = get_post_meta( $post_id, "_post_like_count", true );
		if (be_AlreadyLiked_post($post_id)) {
			$post_like_count = $post_like_count - 1; 
			unset($_COOKIE[$post_id."_liked"]);
    		setcookie($post_id."_liked", '', time() - 3600, '/'); // empty value and old timestamp
			update_post_meta( $post_id, "_post_like_count", $post_like_count );
			$result['status'] = "success";
			$result['type'] = "unlike";
			$result['data'] = "You Already Liked This Item";
			$result['count'] = $post_like_count;
		} else {
			$post_like_count = $post_like_count + 1;
			unset($_COOKIE[$post_id."_liked"]);
			setcookie( $post_id."_liked", $post_id, time() + 31536000, "/");
			update_post_meta( $post_id, "_post_like_count", $post_like_count );
			$result['status'] = "success";
			$result['type'] = "like";
			$result['data'] = "You Liked Successfully";
			$result['count'] = $post_like_count;
		}
		// var_dump($result);
		header('Content-type: application/json');
		echo json_encode($result);
		die();
	}
	add_action( 'wp_ajax_nopriv_post_like', 'be_themes_post_like' );
	add_action( 'wp_ajax_post_like', 'be_themes_post_like' );
endif;

/* ---------------------------------------------  */
// Function for processing Gallery module Pagination
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_get_be_gallery_with_pagination' ) ) :
	function be_themes_get_be_gallery_with_pagination(){

		extract($_POST);
		
		if($paged != 0){
			$images_offset = $paged * $items_per_load;
		}else{
			$images_offset = $paged;
		}

		$images_arr = explode(',', $images_arr);
		if($images_offset >= count($images_arr) ) {
			return 0;
			die();
		}
		
		$images_subset = array_slice($images_arr, $images_offset, $items_per_load);
		$images = get_gallery_image_from_source(json_decode(stripslashes($source),true), implode(",",$images_subset), $lightbox_type);

		echo get_be_gallery_shortcode($images, $col, $masonry, $hover_style, $img_grayscale, $gutter_width, $lightbox_type, $image_source, $image_effect, $thumb_overlay_color, $gradient_style_color, $like_button, $hover_content_option, $hover_content_color,$lazy_load,$delay_load,$placeholder_color);
	}
	add_action( 'wp_ajax_nopriv_get_be_gallery_with_pagination', 'be_themes_get_be_gallery_with_pagination' );
	add_action( 'wp_ajax_get_be_gallery_with_pagination', 'be_themes_get_be_gallery_with_pagination' );
endif;

if ( ! function_exists( 'get_be_gallery_shortcode' ) ) :
	function get_be_gallery_shortcode($images, $col, $masonry, $hover_style, $img_grayscale, $gutter_width, $lightbox_type, $image_source, $image_effect, $thumb_overlay_color, $gradient_style_color, $like_button, $hover_content_option, $hover_content_color,$lazy_load,$delay_load,$placeholder_color,$adaptive_image=null){
		
		global $be_themes_data;
		$isdwdh = false;
		$output = '';
		$tempModalContents = '';
		$aspect_ratio = !empty( $be_themes_data['portfolio_aspect_ratio'] ) ? $be_themes_data['portfolio_aspect_ratio'] : '1.6';
		$masonry_enable = ((!isset($masonry)) || empty($masonry)) ? 'masonry_disable' : 'masonry_enable';
		$output_hover_content = '<div class="thumb-title" style="color:'.$hover_content_color.';"><i class="portfolio-overlay-icon"></i></div>';
		if( 'instagram' == $image_source ) {
			$aspect_ratio = 1;
		}
		if(!empty($images)){
			foreach($images as $image) {
				$image_atts = get_portfolio_image($image['id'], $col, $masonry);
				$attachment_info = be_wp_get_attachment( $image['id'] );
				if(('flickr' != $image_source && 'instagram' != $image_source ) && (!$attachment_info || empty( $attachment_info )) ) {
					continue;
				} 
				if($hover_content_option == 'title'){
					$output_hover_content = '<div class="thumb-title" style="color:'.$hover_content_color.';">'.$image['caption'].'</div>';
				}
				if( 'instagram' == $image_source ) {
					$placeholder_padding = 100;
				}else if( 'flickr' == $image_source ) {
					$masonry_aspect_ratio = round( $image[ 'width' ]/$image[ 'height' ], 2 );
					$placeholder_padding = ( $image[ 'height' ]/$image[ 'width' ] ) * 100;
				}else if( 'masonry_disable' == $masonry_enable ) {
					if( 'wide-width-height' == $image_atts[ 'alt_class' ] ) {
						$wide_width = ( 1300 ) + $gutter_width;
						$wide_height = ( ( 650 / $aspect_ratio ) * 2 ) + $gutter_width;
						$new_aspect_ratio = $wide_width/$wide_height;
						$placeholder_padding = ( 1/$new_aspect_ratio ) * 100;
						$current_dwdh_aspect_ratio = round( $image[ 'thumb_width' ]/$image[ 'thumb_height' ], 2 );
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
					$masonry_aspect_ratio = round( $attachment_info[ 'width' ]/$attachment_info[ 'height' ], 2 );
					$placeholder_padding = ( $attachment_info[ 'height' ]/$attachment_info[ 'width' ] ) * 100;
				}
				$output .= '<div class="element be-hoverlay '.$image_atts['class'].' '.$image_atts['alt_class'].' '.$hover_style.' '.$img_grayscale.'" style="margin-bottom: '.$gutter_width.'px;">';
				$output .= '<div class="element-inner" style="margin-left: '.$gutter_width.'px;">';
				
				// Changes for PhotoSwipe Gallery
				if('photoswipe' == $lightbox_type && 'pintrest' != $image_source){
					$output .= '<a href="'.$image['full_image_url'].'" data-size="'.$image['width'].'x'.$image['height'].'" data-href="'.$image['full_image_url'].'" class="thumb-wrap" title="'.$image['description'].'">';
				}else{
					
					//GDPR Privacy preference popup logic
					$gdpr_atts = '{}';
					$gdpr_concern_selector = '';
					if( $image['mfp_class'] === 'mfp-iframe' ){
						if( function_exists( 'be_gdpr_privacy_ok' ) ){
							$video_details =  be_get_video_details($image['full_image_url']);
							$key = be_uniqid_base36(true);
							if( !empty( $_COOKIE ) ){
								if( !be_gdpr_privacy_ok($video_details['source'] ) ){
									$image['mfp_class'] = 'mfp-popup';
									$image['full_image_url'] = '#gdpr-alt-lightbox-'.$key;
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
										'class' => array( $image['mfp_class'] )
									)
								);
								$gdpr_concern_selector = 'be-gdpr-consent-required';
								$gdpr_atts = json_encode( $gdpr_atts );
								$tempModalContents .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
							}
						}
					}

					$output .= '<a href="'.$image['full_image_url'].'" data-href="'.$image['full_image_url'].'" class="thumb-wrap '.$image['mfp_class'].' '.$gdpr_concern_selector.'" data-gdpr-atts='.$gdpr_atts.' title="'.$image['description'].'">';
					
				}

				if( !empty( $thumb_overlay_color ) || !empty( $thumb_overlay_color ) ) {
					$thumb_bg_style = 'style="background-color:'.$thumb_overlay_color.';'.$gradient_style_color.'"';
				} else {
					$thumb_bg_style = '';
				}
				//End
				$output .= '<div class="flip-wrap"><div ' . ( ( "masonry_enable" == $masonry_enable || 'flickr' == $image_source ) ? ( 'data-aspect-ratio="'.$masonry_aspect_ratio.'"' )  : '' ) . ' style = "padding-bottom : '. $placeholder_padding .'%;'.( !empty( $placeholder_color ) ? 'background-color:'. $placeholder_color : '' ).';" class="flip-img-wrap '.$image_effect.'-effect">';
				if( isset( $adaptive_image ) && $adaptive_image == 1 ) {
					$img_srcset = wp_get_attachment_image_srcset( $image['id'], 'full');
					$output .= '<img '. ( $lazy_load ? 'data-srcset="'.$img_srcset : 'srcset="'.$img_srcset ) .'"' . ( $isdwdh ? ( ' data-aspect-ratio="'.$current_dwdh_aspect_ratio.'"' ) : '' ) . ' alt="'.$attachment_info['alt'].'" data-attr="'.$adaptive_image.'" data-id="'.$image['id'].'"/>';
				}else{
				$output .= '<img '. ( $lazy_load ? 'data-src="'.$image['thumbnail'] : 'src="'.$image['thumbnail'] ) .'"' . ( $isdwdh ? ( ' data-aspect-ratio="'.$current_dwdh_aspect_ratio.'"' ) : '' ) . ' alt="'.$attachment_info['alt'].'" data-attr="'.$adaptive_image.'"/>';
				}
				$output .= '</div></div>';
				$output .= '<div class="thumb-overlay"><div class="thumb-bg" '.$thumb_bg_style.'>';
				$output .= '<div class="thumb-title-wrap display-table-cell vertical-align-middle align-center fadeIn animated">';
				$output .= $output_hover_content;
				$output .= '</div>';
				$output .= '</div></div>'; //End Thumb Bg & Thumb Overlay
				$output .= '</a>'; //End Thumb Wrap
				$output .= $tempModalContents;
				$output .= ($like_button != 1 && !empty($image['id'])) ? '<div class="gallery-like like-button-wrap">'.be_get_like_button($image['id']).'</div>' : '';
				$output .= '</div>'; //End Element Inner
				$output .= '</div>'; //End Element
			}	
		}
		return $output;
	}
endif;

/* ---------------------------------------------  */
// Function for processing Justified Gallery module Pagination
/* ---------------------------------------------  */

if ( ! function_exists( 'be_themes_get_be_justified_gallery_with_pagination' ) ) :
	function be_themes_get_be_justified_gallery_with_pagination(){
		
		extract($_POST);

		if($paged != 0){
			$images_offset = $paged * $items_per_load;
		}else{
			$images_offset = $paged;
        }
        

		$images_arr = explode(',', $images_arr);
		if($images_offset >= count($images_arr) ) {
			return 0;
			die();
        }

        
		
        $images_subset = array_slice($images_arr, $images_offset, $items_per_load);
        $source = array (
			'source' => 'selected',
			'account_name' => '', 
			'count' => '',
			'col' => 'two',
			'masonry' => 1,
		);
		$images = get_gallery_image_from_source( $source, implode(",",$images_subset), 'photoswipe');

		echo get_be_justified_gallery_shortcode($images, $hover_style, $img_grayscale, $image_effect, $thumb_overlay_color, $gradient_style_color, $like_button, $disable_overlay, $lazy_load, $caption_type);
	}
	add_action( 'wp_ajax_nopriv_get_be_justified_gallery_with_pagination', 'be_themes_get_be_justified_gallery_with_pagination' );
	add_action( 'wp_ajax_get_be_justified_gallery_with_pagination', 'be_themes_get_be_justified_gallery_with_pagination' );
endif;

if ( ! function_exists( 'get_be_justified_gallery_shortcode' ) ) :
	function get_be_justified_gallery_shortcode($images, $hover_style, $img_grayscale, $image_effect, $thumb_overlay_color, $gradient_style_color, $like_button, $disable_overlay, $lazy_load, $caption_type,$adaptive_image=null){
		
		$output = '';

		if( !empty( $thumb_overlay_color ) || !empty( $thumb_overlay_color ) ) {
			$thumb_bg_style = 'style="background-color:'.$thumb_overlay_color.';'.$gradient_style_color.'"';
		} else {
			$thumb_bg_style = '';
		}

		if(!empty($images)){
			foreach($images as $image) {
				$image_atts = get_portfolio_image($image['id'], 'three', '1');
                $attachment_info = be_wp_get_attachment( $image['id'] );
                $placeholder_padding = 100;
                $cur_image_attr = array();
                $cur_image_class = array( 'thumb-img' );
                if( !empty( $image['width'] ) && !empty( $image['height'] ) ) {
                    $placeholder_padding = ($image['height']/$image['width'])*100;
                    $cur_image_attr[] = 'height = "' . $image['height'] . '"';
                    $cur_image_attr[] = 'width = "' . $image['width'] . '"';
                }
				if( isset( $adaptive_image ) && $adaptive_image == 1 ) {
					$img_srcset = wp_get_attachment_image_srcset( $image['id'], 'full');
					if( !empty( $lazy_load ) ) {
						$cur_image_attr[] = 'data-srcset = "' . $img_srcset . '"';
					}else {
						$cur_image_attr[] = 'srcset = "' . $img_srcset . '"';
					}
				}else{
					if( !empty( $lazy_load ) ) {
						$cur_image_attr[] = 'data-src = "' . $image['thumbnail'] . '"';
					}else {
						$cur_image_attr[] = 'src = "' . $image['thumbnail'] . '"';
					}
				}
                if( !empty( $attachment_info['alt'] ) ) {
                    $cur_image_attr[] = 'alt = "' . $attachment_info['alt'] . '"';
				}
				if( !empty( $attachment_info['title'] ) ) {
                    $cur_image_attr[] = 'title = "' . $attachment_info['title'] . '"';
				}
				if(isset($caption_type)){
					if( $caption_type === 'none'){
						$caption = '';
					}else{
						$caption = $attachment_info[$caption_type];
					}
				}else{
					$caption = $attachment_info['alt'];
				}
				$laz_class = '';
				if(empty($lazy_load)){
					$laz_class = 'jg-entry-visible';	
				}
				$output .= '<div class="element be-hoverlay '.$image_atts['class'].' '.$hover_style.' '.$img_grayscale.' '.$laz_class.'">';
				$output .= '<div class="element-inner ' .$image_effect.'-effect">';
				$output .= '<a href="'.$image['full_image_url'].'" data-size="'.$image['width'].'x'.$image['height'].'" data-href="'.$image['full_image_url'].'" class="thumb-wrap" title="'.$image['description'].'">';
                $output .= '<div class="flip-img-wrap">';
                $output .= '<img class = "thumb-img" ' . implode( ' ', $cur_image_attr ) . ' />';
                $output .= '</div>'; //End flip img wrap
				if($disable_overlay == 0){
					$output .= '<div class="thumb-overlay"><div class="thumb-bg" '.$thumb_bg_style.'>';
					$output .= '<div class="thumb-title-wrap display-table-cell vertical-align-middle align-center fadeIn animated">';
					$output .= '</div>';
					$output .= '</div></div>'; //End Thumb Bg & Thumb Overlay
				}
				
				$output .= '</a>'; //End Thumb Wrap
				$output .= ($like_button != 1 && !empty($image['id'])) ? '<div class="gallery-like  like-button-wrap">'.be_get_like_button($image['id']).'</div>' : '';
				$output .= '</div>'; //End Element Inner
				$output .= '<div class="caption">'.$caption.'</div>';
				$output .= '</div>'; //End Element
			}
		}
		return $output;
	}
endif;

/* ---------------------------------------------  */
// Mail Chimp 
/* ---------------------------------------------  */


if ( ! function_exists( 'be_themes_mailchimp_subscription' ) ) :
	function be_themes_mailchimp_subscription() {
		global $be_themes_data;
		$result = array();
		if( empty($_POST['api_key']) || empty( $_POST['list_id'] ) || empty( $_POST['email'] ) ) {
			$result['status'] = 'error';
			$result['data'] = __( 'Api Key / List Id / Email Address is missing', 'oshine-modules');
			echo json_encode($result);
			exit;
		}
		$MailChimp = new MailChimp($_POST['api_key']);
		$result = $MailChimp->call('lists/subscribe', array (
	        'id'                => $_POST['list_id'],
	        'email'             => array('email'=> $_POST['email']),
	        'merge_vars'        => array('FNAME'=>'', 'LNAME'=>''),
	        'double_optin'      => false,
	        'update_existing'   => true,
	        'replace_interests' => false,
	        'send_welcome'      => false,
	    ));
	    if( !isset($result['status']) ) {
	    	$result['status'] = 'success';
	    	$result['data'] = __('Thank you, you have been added to our mailing list.','oshine-modules');
	    } else {
	    	$result['data'] =  $result['error'];
	    }
		header('Content-type: application/json');
		echo json_encode($result);
		die();
	}
	add_action( 'wp_ajax_nopriv_mailchimp_subscription', 'be_themes_mailchimp_subscription' );
	add_action( 'wp_ajax_mailchimp_subscription', 'be_themes_mailchimp_subscription' );
endif;

/* ---------------------------------------------  */
// Mail Chimp API Class
/* ---------------------------------------------  */

if( ! class_exists( 'MailChimp' ) ) :
	class MailChimp {
    	private $api_key;
    	private $api_endpoint = 'https://<dc>.api.mailchimp.com/2.0';
    	private $verify_ssl   = false;

    	/**
    	* Create a new instance
     	* @param string $api_key Your MailChimp API key
     	*/
    	function __construct($api_key) {
        	$this->api_key = $api_key;
        	list(, $datacentre) = explode('-', $this->api_key);
        	$this->api_endpoint = str_replace('<dc>', $datacentre, $this->api_endpoint);
    	}

	    /**
	     * Call an API method. Every request needs the API key, so that is added automatically -- you don't need to pass it in.
	     * @param  string $method The API method to call, e.g. 'lists/list'
	     * @param  array  $args   An array of arguments to pass to the method. Will be json-encoded for you.
	     * @return array          Associative array of json decoded API response.
	     */
	    public function call($method, $args=array(), $timeout = 10) {
	        return $this->makeRequest($method, $args, $timeout);
	    }

	    /**
	     * Performs the underlying HTTP request. Not very exciting
	     * @param  string $method The API method to be called
	     * @param  array  $args   Assoc array of parameters to be passed
	     * @return array          Assoc array of decoded result
	     */
    	private function makeRequest($method, $args=array(), $timeout = 10) {      
        	$args['apikey'] = $this->api_key;
        	$url = $this->api_endpoint.'/'.$method.'.json';
	        if (function_exists('curl_init') && function_exists('curl_setopt')){
	            $ch = curl_init();
	            curl_setopt($ch, CURLOPT_URL, $url);
	            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	            curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');       
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	            curl_setopt($ch, CURLOPT_POST, true);
	            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl);
	            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
	            $result = curl_exec($ch);
	            curl_close($ch);
	        } else {
	            $json_data = json_encode($args);
	            $result    = file_get_contents($url, null, stream_context_create(array(
	                'http' => array(
	                    'protocol_version' => 1.1,
	                    'user_agent'       => 'PHP-MCAPI/2.0',
	                    'method'           => 'POST',
	                    'header'           => "Content-type: application/json\r\n".
	                                          "Connection: close\r\n" .
	                                          "Content-length: " . strlen($json_data) . "\r\n",
	                    'content'          => $json_data,
	                ),
	            )));
	        }
        	return $result ? json_decode($result, true) : false;
    	}
	}
endif;
?>