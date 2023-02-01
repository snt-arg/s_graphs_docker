<?php
/**************************************
		PORTFOLIO CAROUSEL
**************************************/
if (!function_exists('be_portfolio_carousel')) {
	function be_portfolio_carousel( $atts, $content, $tag ) {
		global $be_themes_data;
		$atts = shortcode_atts( array (
	        'category'=> '',
	        'items_per_page'=> '-1',
			'number_of_cols'=>'2',
	        'hover_style' => 'style1-hover',
			'overlay_color' => '',
			'gradient_color' => '',
			'gradient' => '0',
			'gradient_direction' => 'bottom',
			'overlay_opacity' => '85',
			'title_style' => 'style1',
			'title_color' => '',
			'cat_color' => '',
			'default_image_style' => 'color',
			'hover_image_style' => 'color',
			'title_animation_type' => 'none',
			'cat_animation_type' => 'none',
			'image_effect' => 'none',
			'cat_hide' => '0',
			'like_button' => 0,
			'slide_show' => '0',
			'slide_show_speed' => 4000,
			'key' => be_uniqid_base36(true),			
		) , $atts, $tag );
		
		extract( $atts );

		$custom_style_tag = be_generate_css_from_atts( $atts, 'portfolio_carousel', $key );
		$unique_class_name = 'tatsu-'.$key;

		$output = $global_thumb_overlay_color = $thumb_overlay_color = $global_gradient_style_color = $gradient_style_color = '';
		$category = explode(',', $category);
		$hover_image_style = ((!isset($hover_image_style)) || empty($hover_image_style)) ? 'color' : $hover_image_style;
		$title_animation_type = ((!isset($title_animation_type)) || empty($title_animation_type)) ? 'none' : $title_animation_type;
		$cat_animation_type = ((!isset($cat_animation_type)) || empty($cat_animation_type)) ? 'none' : $cat_animation_type;
		$image_effect = ((!isset($image_effect)) || empty($image_effect)) ? 'none' : $image_effect;
		$hover_style = ((!isset($hover_style)) || empty($hover_style)) ? 'style1-hover' : $hover_style;
		$gradient_direction = ((!isset($gradient_direction)) || empty($gradient_direction)) ? 'bottom' : $gradient_direction;

		$title_color = be_compute_color( $title_color );
		$title_color = $title_color[1];
		$cat_color = be_compute_color( $cat_color );
		$cat_color = $cat_color[1];
		$overlay_color = be_compute_color( $overlay_color );
		$overlay_color = $overlay_color[1];
		$gradient_color = be_compute_color( $gradient_color );
		$gradient_color = $gradient_color[1];

		$global_title_color = $title_color = (isset($title_color) && !empty($title_color)) ? $title_color : '';
		$global_cat_color = $cat_color = (isset($cat_color) && !empty($cat_color)) ? $cat_color : '';
		$slide_show = ( !empty( $slide_show ) ) ? 1 : 0;
		$slide_show_speed = ( !empty( $slide_show_speed ) ) ? $slide_show_speed : 4000 ;
		$global_gradient_style_color = '';

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
		if(isset($overlay_opacity) && !empty($overlay_opacity)) {
			$global_overlay_opacity = $overlay_opacity = $overlay_opacity;
		} else {
			$global_overlay_opacity = $overlay_opacity = 85;
		}
		if( isset($overlay_color) && !empty($overlay_color) ) {
			//$overlay_color = be_themes_hexa_to_rgb( $overlay_color );
			//$global_thumb_overlay_color = $thumb_overlay_color = 'rgba('.$overlay_color[0].','.$overlay_color[1].','.$overlay_color[2].','.(intval($global_overlay_opacity) / 100 ).')';
			if($gradient) {
				if(!isset($gradient_color) && empty($gradient_color)) {
					$gradient_color = $overlay_color;
				} 
				//$global_thumb_gradient_overlay_color = $thumb_gradient_overlay_color = 'rgba('.$gradient_color[0].','.$gradient_color[1].','.$gradient_color[2].','.(intval($global_overlay_opacity) / 100 ).')';
				$global_gradient_style_color = $gradient_style_color = 'background-image: -o-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: -moz-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: -webkit-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: -ms-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: linear-gradient(to '.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);';
			} else {
				$global_gradient_style_color = $gradient_style_color = 'background:'.$overlay_color;
			}
			
		}

		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );


		$data_animations = be_get_animation_data_atts( $atts );
		if( !empty( $animation_type ) && 'none' !== $animation_type ) {
            $css_classes .= ' tatsu-animate ';
        }
		$number_of_cols = empty($number_of_cols)?'2':$number_of_cols;
		$output .= '<div '.$css_id.' class="carousel-wrap portfolio-carousel oshine-module '.$unique_class_name.' '.$css_classes.' '.$visibility_classes.'" '.$data_animations.'>';
		// $output .= '<div class="caroufredsel_wrapper clearfix"><ul class="be-carousel portfolios-carousel">';
		$output .= '<ul class="be-owl-carousel portfolio-carousel-module" data-slide-show="'.$slide_show.'" data-cols="'.$number_of_cols.'" data-slide-show-speed="'.$slide_show_speed.'">';
		$items_per_page = (empty($items_per_page)) ? -1 : $items_per_page ; 
		if( empty( $category[0] ) ) {
			$args = array(
				'post_type' => 'portfolio',
				'posts_per_page' => $items_per_page,
				'orderby'=>'date',				
			);
		} else {
			$args = array(
				'post_type' => 'portfolio',
				'posts_per_page' => $items_per_page,
				'tax_query' => array(
					array(
						'taxonomy' => 'portfolio_categories',
						'field' => 'slug',
						'terms' => $category,
						'operator' => 'IN',
					)
				),
				'orderby'=>'date',
			);	
		}
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$mfp_class = '';
				$post_terms = get_the_terms( get_the_ID(), 'portfolio_categories' );
				$attachment_id = get_post_thumbnail_id(get_the_ID());
				$attachment_thumb=wp_get_attachment_image_src( $attachment_id, 'portfolio');
				$attachment_full = wp_get_attachment_image_src( $attachment_id, 'full');
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
				if(!isset($visit_site_url) || empty($visit_site_url)) {
					$visit_site_url = '#';
				}
				$permalink = ( $link_to == 'external_url' ) ? $visit_site_url : get_permalink();
				if(isset($single_overlay_opacity) && !empty($single_overlay_opacity)) {
					$overlay_opacity = $single_overlay_opacity;
				} else {
					$overlay_opacity = 85;
				}
				if(isset($single_overlay_color) && !empty($single_overlay_color)) {
					$single_overlay_color = be_themes_hexa_to_rgb( $single_overlay_color );
					$thumb_overlay_color = 'rgba('.$single_overlay_color[0].','.$single_overlay_color[1].','.$single_overlay_color[2].','.(intval($overlay_opacity) / 100 ).')';
					$gradient_style_color = '';
				} else {
					$thumb_overlay_color = $global_thumb_overlay_color;
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
				if(isset($open_with) && $open_with == 'lightbox-gallery') {
					$thumb_class = 'be-lightbox-gallery mfp-image';
				} else if(isset($open_with) && $open_with == 'lightbox') {
					$thumb_class = 'mfp-image';
				} else if(isset($open_with) && $open_with == 'none') {
					$thumb_class = 'no-link';
					$attachment_full_url = '#';
				} else {
					$thumb_class = '';
					$attachment_full_url = $permalink;
				}
				if( !empty( $thumb_overlay_color ) || !empty( $gradient_style_color ) ) {
					$thumb_bg_style = 'style="background-color:'.$thumb_overlay_color.';'.$gradient_style_color.'"';
				} else {
					$thumb_bg_style = '';
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
								$thumb_class = '';
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
									'class' => array( $mfp_class,
													  $thumb_class )
								)
							);
							$gdpr_concern_selector = 'be-gdpr-consent-required';
							$gdpr_atts = json_encode( $gdpr_atts );
							$tempModalContents .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
						}
					}
				}

				$trigger_animation = ($hover_style == 'style9-hover' || $hover_style == 'style10-hover') ? '' : 'animation-trigger';
				$output .='<li class="carousel-item element be-hoverlay '.$hover_style.' '.$img_grayscale.' '.$title_style.'-title"><div class="element-inner">';
				$output .= '<a href="'.$attachment_full_url.'" class="thumb-wrap '.$thumb_class.' '.$mfp_class.' '.$gdpr_concern_selector.'" data-gdpr-atts='.$gdpr_atts.' title="'.$attachment_info['title'].'">';
				$output .= '<div class="flip-wrap"><div class="flip-img-wrap '.$image_effect.'-effect"><img src="'.$attachment_thumb_url.'" alt="'.$attachment_info['alt'].'" /></div></div>';
				$output .= '<div class="thumb-overlay"><div class="thumb-bg" '.$thumb_bg_style.'>';
				$output .= '<div class="thumb-title-wrap ">';
				$output .= '<div class="thumb-title be-animate animated '.$trigger_animation.'" data-animation-type="'.$title_animation_type.'" '.( !empty( $title_color ) ? 'style="color: '.$title_color.';"' : '').'>'.get_the_title().'</div>';
				$terms = be_themes_get_taxonomies_by_id(get_the_ID(), 'portfolio_categories');
				if(!empty($terms) && empty( $cat_hide ) ) {	
					$output .= '<div class="portfolio-item-cats be-animate animated '.$trigger_animation.'" data-animation-type="'.$cat_animation_type.'" '.( !empty( $cat_color ) ? 'style="color: '.$cat_color.';"' : '').'>';
					$length = 1;
					foreach ($terms as $term) {
						$output .= '<span>'.$term->name.'</span>';
						if(count($terms) != $length) {
							$output .= '<span>&middot; </span>';
						}
						$length++;
					}
					$output .= '</div>';
				}
				$output .= '</div>';
				$output .= '</div></div>'; //End Thumb Bg & Thumb Overlay
				$output .= '</a>'; //End Thumb Wrap
				$output .= $tempModalContents;
				if(isset($open_with) && $open_with == 'lightbox-gallery') :
					$output .='<div class="popup-gallery">';
					$attachments = get_post_meta(get_the_ID(),'be_themes_single_portfolio_slider_images');
					if(!empty($attachments)) {
						foreach ( $attachments as $attachment_id ) {
							$attach_img = wp_get_attachment_image_src($attachment_id, 'full');
							$video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);
							$attachment_info = be_wp_get_attachment($attachment_id);
							if($video_url) {
								$url = $video_url;
								$mfp_class = 'mfp-iframe';
							} else if(!empty($attach_img)) {
								$url = $attach_img[0];
								$mfp_class ='mfp-image';
							}
							if(!empty($url)){
								$output .='<a href="'.$url.'" class="'.$mfp_class.'" title="'.$attachment_info['title'].'"></a>';
							}
							
						}
					}
					$output .= '</div>'; //End Gallery
				endif;
				$output .= '</div>';
				$output .= ($like_button != 1) ? '<div class="portfolio-like like-button-wrap">'.be_get_like_button(get_the_ID()).'</div>' : '';
				$output .= '</li>';
			endwhile;
		endif;
		wp_reset_postdata();
		$output .='</ul>';
		// $output .='<a class="prev be-carousel-nav" href="#"><i class="font-icon icon-arrow_carrot-left"></i></a><a class="next be-carousel-nav" href="#"><i class="font-icon icon-arrow_carrot-right"></i></a>';
		// $output .='</div>'; 'Caroufredsel Wrapper Close'
		$output .= $custom_style_tag;
		$output .='</div>';
		return $output;
	}
	add_shortcode( 'portfolio_carousel' , 'be_portfolio_carousel' );
}

add_action( 'tatsu_register_modules', 'oshine_register_portfolio_carousel');
function oshine_register_portfolio_carousel() {

		$portfolio_categories = get_terms('portfolio_categories');
		$options = array();
		foreach ( $portfolio_categories as $category ) {
			if( is_object( $category ) ) {
				$options[$category->slug] = $category->name;
			}
		}

		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#portfolio',
	        'title' => __( 'Portfolio Carousel', 'oshine-modules' ),
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
								'category',
								'items_per_page',
								'number_of_cols',
								'slide_show',
								'slide_show_speed',
								'cat_hide',
								'like_button',
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
											'title' => __( 'Shape and Size', 'tatsu' ),
											'group' => array (
												'hover_style',
												'title_style',
												'default_image_style',
												'hover_image_style',
												'image_effect',
												)
											),
										array (
											'type' => 'panel',
											'title' => __( 'Colors', 'tatsu' ),
											'group' => array (
												'gradient',
												'gradient_direction',
												'gradient_color',
												'overlay_color',
												'title_color',
												'cat_color',
											)
										),
										array (
											'type' => 'panel',
											'title' => __( 'Loading options', 'tatsu' ),
											'group' => array (
												'title_animation_type',
												'cat_animation_type',
											)
										),
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
	
									)
								),
							)
						),
					)
				),
			),
	        'atts' => array (
	        	array (
	        		'att_name' => 'category',
	        		'type' => 'grouped_checkbox',
	        		'label' => __( 'Portfolio Categories', 'oshine-modules' ),
	        		'options' => $options,
	        	),	        	
	        	array (
	        		'att_name' => 'items_per_page',
					'type' => 'number',
					'options' => array(
	        			'unit' => '',
	        		),
	        		'label' => __( 'Number of Items', 'oshine-modules' ),
	        		'default' => '8',
	        		'tooltip' => ''
	        	),
				array (
	        		'att_name' => 'number_of_cols',
					'type' => 'number',
					'options' => array(
	        			'unit' => '',
	        		),
	        		'label' => __( 'Number of column(2-5)', 'oshine-modules' ),
	        		'default' => '2',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'hover_style',
	        		'type' => 'select',
	        		'label' => __( 'Hover Style', 'oshine-modules' ),
					'options' => array (
						'style1-hover' => 'Style1 - Fade Toggle',
						'style2-hover' => 'Style2 - 3D FLIP Horizontal',
						'style3-hover' => 'Style3 - Direction Aware',
						'style4-hover' => 'Style4 - Direction Aware Inverse',
						'style5-hover' => 'Style5 - FadeIn & Scale',
						'style6-hover' => 'Style6 - Fall',
						'style7-hover' => 'Style7 - 3D FLIP Vertical',
						'style8-hover' => 'Style8 - 3D Rotate',
					),
	        		'default' => 'style1-hover',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'title_style',
	        		'type' => 'select',
	        		'label' => __( 'Title Style', 'oshine-modules' ),
					'options' => array (
						'style1' => 'Boxed Title and Meta - Middle',
						'style2' => 'Title and Meta - Top',
						'style3' => 'Title and Meta - Middle',
						'style4' => 'Title and Meta - Bottom',
						'style5' => 'Title and Meta - Below Thumbnail',
						'style6' => 'Title and Meta - Below Thumbnail with no Margin',
						'style7' => 'Title and Meta - Slide Up from Bottom',
					),
					'default'=> 'style1',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'default_image_style',
	        		'type' => 'select',
	        		'label' => __( 'Default Image Style', 'oshine-modules' ),
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
					'tooltip' => '',
					'is_inline' => true,
	        	),
	        	array (
	        		'att_name' => 'hover_image_style',
	        		'type' => 'select',
	        		'label' => __( 'Hover Image Style', 'oshine-modules' ),
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
					'tooltip' => '',
					'is_inline' => true,
	        	),
	        	array (
	        		'att_name' => 'image_effect',
	        		'type' => 'select',
	        		'label' => __( 'Image Effects', 'oshine-modules' ),
					'options' => array (
						'zoom-in' => 'Zoom In',
						'zoom-out' => 'Zoom Out',
						'zoom-in-rotate' => 'Zoom In Rotate',
						'zoom-out-rotate' => 'Zoom Out Rotate',
						'none' => 'None'
					),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
				array (
		            'att_name' => 'overlay_color',
					'type' => 'color',
					'options' => array(
						'gradient' => false,
					),
		            'label' => __( 'Thumbnail Overlay Color / Gradient Start Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
	            ),	            
	            array (
	              	'att_name' => 'gradient',
	              	'type' => 'switch',
	              	'label' => __( 'Enable Gradient Overlay', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
				array (
					'att_name' => 'gradient_color',
		            'type' => 'color',
					'label' => __( 'Thumbnail Overlay Gradient End Color', 'oshine-modules' ),
					'visible' => array ('gradient' , '=' , '1'),
		            'default' => '',
		            'tooltip' => '',
	            ),
	        	array (
	        		'att_name' => 'gradient_direction',
	        		'type' => 'button_group',
	        		'label' => __( 'Gradient Direction', 'oshine-modules' ),
					'options' => array (
						'right' => 'Horizontal',
						'bottom' => 'Vertical', 
					),
					'visible' => array ('gradient' , '=' , '1'),
					'default' => 'right',
					'is_inline' => true,
	        		'tooltip' => ''
	        	),
	            array (
	              	'att_name' => 'title_color',
	              	'type' => 'color',
	              	'label' => __( 'Title Color', 'oshine-modules' ),
	              	'default' => '',
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'cat_color',
	              	'type' => 'color',
	              	'label' => __( 'Categories Color', 'oshine-modules' ),
	              	'default' => '',
	              	'tooltip' => '',
	            ),
				array (
					'att_name' => 'slide_show',
					'type' => 'switch',
					'label' => __( 'Slide show', 'oshine-modules' ),
					'default' => 0,
					'tooltip' => '',
			 	),	
				 array (
	        		'att_name' => 'slide_show_speed',
					'type' => 'number',
					'options' => array(
	        			'unit' => '',
	        		),
	        		'label' => __( 'Slide show speed', 'oshine-modules' ),
	        		'default' => '1000',
	        		'tooltip' => '',
					'visible'  => array('slide_show','=','1'),
	        	), 
	            array (
	              	'att_name' => 'cat_hide',
	              	'type' => 'switch',
	              	'label' => __( 'Hide Categories ?', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'like_button',
	              	'type' => 'switch',
	              	'label' => __( 'Disable Like Button', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
				array (
					'att_name' => 'title_animation_type',
					'type' => 'select',
					'label' => __('Portfolio Title Animation','oshine-modules'),
					'options' => tatsu_css_animations(),
					'default' => 'none',
					'is_inline' => true,
				),
				array (
					'att_name' => 'cat_animation_type',
					'type' => 'select',
					'label' => __('Portfolio Categories Animation','oshine-modules'),
					'options' => tatsu_css_animations(),
					'default' => 'none',
					'is_inline' => true,
				),
	        ),
	    );
	tatsu_register_module( 'portfolio_carousel', $controls );
}