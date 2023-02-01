<?php
$animation_type = get_post_meta(get_the_ID(), 'be_themes_dual_carousel_posrtfolio_animation_style', true);
$selected_categorey = wp_get_post_terms( get_the_ID(), 'portfolio_categories' );
$meta = wp_list_pluck( $selected_categorey, 'term_id' );
$animation_type = (!isset($animation_type) || empty($animation_type)) ? 'fxSoftScale' : $animation_type;
?>
<div class="ps-container-wrap">
	<section id="dual-carousel-container" class="dual-carousel-container">
		<div class="ps-contentwrapper">
			<?php
				if($meta) {
					// Image Query
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
						'order'=> 'ASC',
						'status'=> 'publish'
					);
					// Content Query
					$args_content = array (
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
						'order'=> 'DESC',
						'status'=> 'publish'
					);
				} else {
					$args = array (
						'post_type' => 'portfolio',
						'posts_per_page' => '-1',
						'orderby'=> 'date',
						'order'=> 'ASC',
						'status'=> 'publish'
					);
					$args_content = array (
						'post_type' => 'portfolio',
						'posts_per_page' => '-1',
						'orderby'=> 'date',
						'order'=> 'DESC',
						'status'=> 'publish'
					);
				}

				$the_query = new WP_Query( $args );
				$the_query_content = new WP_Query( $args_content );
				
				if($the_query_content) {
					while ( $the_query_content->have_posts() ) : $the_query_content->the_post();

						echo '<div class="ps-content"><div class="ps-content-inner">';
						echo '<div class="ps-content-thumbnail">';
						$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
						$attach_img = wp_get_attachment_image_src($thumbnail_id, 'portfolio');
						if( $attach_img ) {
							echo '<a href="'.get_permalink().'"><img src="'.$attach_img[0].'"></a>';
						}
						echo '</div>';
						$body_classes = get_body_class();
						if( !in_array( 'tatsu-frame', $body_classes ) ) {
							echo the_content();
						}
						echo '</div></div>';
					endwhile;
					wp_reset_query();
				}
			?>
		</div><!-- /ps-contentwrapper -->
		<div class="ps-slidewrapper">
			<div class="ps-slides" data-id="<?php echo get_the_ID() ?>">
				<?php
					
					if($the_query) {

						while ( $the_query->have_posts() ) : $the_query->the_post();
							echo '<div class="pa-slides-inner-slide-container">';
							echo '<div class="ps-slides-inner-slide-wrap">';
							$attachments = get_post_meta(get_the_ID(),'be_themes_single_portfolio_slider_images');
							$slider = '[be_slider animation_type= "'.$animation_type.'" load="no"]';
							if(!empty($attachments)) {
								foreach ( $attachments as $attachment_id ) {
									$image = wp_get_attachment_image_src( $attachment_id, 'full' );
									if( $image ) {
										$slider .= '[be_slide image= "'.$image[0].'"][/be_slide]';
									}
								}
							} else {
								$slider .= '[be_slide image= "'.get_the_post_thumbnail( get_the_ID(), 'full' ).'"][/be_slide]';
							}
							$slider .= '[/be_slider]';
							echo do_shortcode($slider);
							echo '</div>';
							echo '<div class="ps-content"><div class="ps-content-inner">';
								echo the_content();
							echo '</div></div>';
							echo '</div>';
						endwhile;
						wp_reset_postdata();
					}
				?>
			</div>		
		</div><!-- /ps-slidewrapper -->
		<a href="#" class="ps-prev" ><i class="font-icon icon-arrow_carrot-down"></i></a>
		<a href="#" class="ps-next" ><i class="font-icon icon-arrow_carrot-up"></i></a>
	</section><!-- /ps-container -->
</div>