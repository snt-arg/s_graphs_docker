<?php
	global $be_themes_data;
	$gutter_width = get_post_meta(get_the_ID(),'be_themes_portfolio_carousel_slider_gutter_width', true);
	$slider_height = get_post_meta(get_the_ID(),'be_themes_portfolio_carousel_slider_height', true);
	$overlay = get_post_meta( get_the_ID(), 'be_themes_portfolio_horizontal_slider_enable_overlay', true );
	$overlay_color = get_post_meta( get_the_ID(), 'be_themes_portfolio_horizontal_slider_overlay_color', true );
	$overlay_opacity = get_post_meta( get_the_ID(), 'be_themes_portfolio_horizontal_slider_overlay_color_opacity', true );
	$normal_scroll = get_post_meta( get_the_ID(), 'be_themes_portfolio_horizontal_vertical_slider_normal_scroll', true );
	$selected_categorey = wp_get_post_terms( get_the_ID(), 'portfolio_categories' );
	$items_order = get_post_meta( get_the_ID(), 'be_themes_portfolio_template_item_order', true );
	$meta = wp_list_pluck( $selected_categorey, 'term_id' );
	$items_order_value = 'ASC';
	if($normal_scroll == 1) {
		$normal_scroll = 'normal-scroll';
	}
	if(isset($items_order) && !empty($items_order)){
		$items_order_value = $items_order;
	}
	if(!isset($be_themes_data['slider_navigation_style']) || empty($be_themes_data['slider_navigation_style'])) {
		$arrow_style = 'style1-arrow';
	} else {
		$arrow_style = $be_themes_data['slider_navigation_style'];
	}
	if($arrow_style == 'style1-arrow' || $arrow_style == 'style3-arrow' || $arrow_style == 'style5-arrow'){
		$arrow_style_class = 'arrow-block';
	}else{
		$arrow_style_class = 'arrow-border';
	}
	if(isset($overlay) && $overlay == 1) {
		if(!isset($overlay_opacity) || empty($overlay_opacity)) {
			$overlay_opacity = 85;
		}
		if(isset($overlay_color) && !empty($overlay_color)) {
			$overlay_color = be_themes_hexa_to_rgb( $overlay_color );
			$thumb_overlay_color = 'rgba('.$overlay_color[0].','.$overlay_color[1].','.$overlay_color[2].','.(intval($overlay_opacity) / 100 ).')';	
		} else {
			$thumb_overlay_color = '';
		}
	}
	if(isset($slider_height) && !empty($slider_height)) {
		$slider_height = 'data-height="'.esc_attr( $slider_height ).'"';
	} else {
		$slider_height = 'data-height="100"';
	}
?>
<?php 
	if ( post_password_required() ) {
		$content  = get_the_password_form();
	    echo '<div class="be-wrap clearfix be-password-protect-wrap">'.$content.'</div>';
	} else {  ?>
<div id="content" class="gallery-all-container resized <?php echo $arrow_style_class.' '. $arrow_style.' '.$normal_scroll; ?>">	
	<div id="gallery-container-wrap" class="clearfix" <?php echo $slider_height; ?>>
		<div id="gallery-container" class="inline-wrap" style="padding-left: <?php echo esc_attr( $gutter_width ); ?>px;">
			<?php
				$count = 1;
				if($meta) {
					$args = array (
						'post_type' => 'portfolio',
						'tax_query' => array (
							array (
								'taxonomy' => 'portfolio_categories',
								'field' => 'term_id',
								'terms' => $meta,
								'operator' => 'IN'
							)
						),
						'posts_per_page' => '-1',
						'orderby'=> 'date',
						'order'=> $items_order_value,
						'status'=> 'publish'
					);
				} else {
					$args = array (
						'post_type' => 'portfolio',
						'posts_per_page' => '-1',
						'orderby'=> 'date',
						'order'=> $items_order_value,
						'status'=> 'publish'
					);
				}
				$the_query = new WP_Query( $args );
				if($the_query) {
					while ( $the_query->have_posts() ) : $the_query->the_post();
						$attachment_id = get_post_thumbnail_id(get_the_ID());
						$attach_img = wp_get_attachment_image_src($attachment_id, 'full');
						$video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);
						$target = get_post_meta( get_the_ID(), 'be_themes_portfolio_open_new_tab', true);
						$data_target = ($target == 1) ? '_blank' : '_self';
						$link_to = get_post_meta( get_the_ID(), 'be_themes_portfolio_link_to', true );
						$visit_site_url = get_post_meta( get_the_ID(), 'be_themes_portfolio_external_url', true );
						$permalink = ( $link_to == 'external_url' ) ? $visit_site_url : get_permalink();
						
						if($video_url) {
							$video_details = be_get_video_details($video_url);
							$data_source = $video_details['thumb_url'];
						} else {
							$data_source = $attach_img[0];
						}
						echo '<div class="placeholder style1_placehloder load show-title" data-target = "'.$data_target.'" data-source="'.$data_source.'" data-href="'.$permalink.'" style="margin-right: '.$gutter_width.'px">';
						if($video_url) {
							echo be_carousel_video($video_url);
						} else {
							echo '<img src="" style="opacity: 0; display: block;" alt="" />';
						}
						if(isset($overlay) && $overlay == 1 && $normal_scroll != 'normal-scroll') {
							echo '<div class="overlay_placeholder" style="background: '.$thumb_overlay_color.';"></div>';
						}
						if( get_the_title(get_the_ID())) {
							echo '<div class="attachment-details attachment-details-custom-slider animated">';
							echo '<a href="'.$permalink.'" target="_blank">'.get_the_title(get_the_ID()).'</a>';
							echo get_be_themes_portfolio_category_list(get_the_ID(), true);
							echo '</div>';
						}
						echo '</div>';
						$count++;
					endwhile;
					wp_reset_postdata();
				}
			?>
		</div>
	</div>
	<?php 
		get_template_part( 'portfolio/gallery', 'content' );
		$show_carousel_bar = get_post_meta( get_the_ID(), 'be_themes_portfolio_show_carousel_bar', true );
		if($show_carousel_bar == 1) { ?>
			<div class="single-portfolio-slider carousel_bar_area clearfix">
				<div class="carousel_bar_dots"></div>
				<div class="be-carousel-thumb carousel_bar_wrap <?php echo $carousel_bar_style;?>">
							<?php
							$count = 0;
							$the_query = new WP_Query( $args );
							if($the_query) {
								while ( $the_query->have_posts() ) : $the_query->the_post();
									$attachment_id = get_post_thumbnail_id(get_the_ID());
									$attach_img = wp_get_attachment_image_src($attachment_id, 'carousel-thumb');
									$video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);
									if($video_url && $video) {
										$data_source = '<img width="75" height="50" src="'.get_template_directory_uri().'/img/video-placeholder.jpg" class="attachment-carousel-thumb" alt="">';
									} else {
										$data_source = '<img width="75" height="50" src="'.$attach_img[0].'" class="attachment-carousel-thumb" alt="">';
									}
									echo '<a href="#" class="gallery-thumb" data-target="'.$count.'">'.$data_source.'</a>';
									$count++;
								endwhile;
							}
							wp_reset_postdata();
							?>
					</div>
			</div> <?php
		}	
	?>
</div>
<?php } ?>