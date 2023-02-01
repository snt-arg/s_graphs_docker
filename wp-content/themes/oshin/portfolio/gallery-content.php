<?php
	if(is_page_template('portfolio.php')) {
		$meta = 'be_themes_portfolio_show_info_box';
	} else {
		$meta = 'be_themes_single_show_info_box';
	}
	global $be_themes_data;
	$slider_type = get_post_meta(get_the_ID(),'be_themes_portfolio_single_page_style',true);
	$show_info_box = get_post_meta( get_the_ID(), $meta, true );
	$attachments = get_post_meta(get_the_ID(),'be_themes_single_portfolio_slider_images');
	$attachment_count = count( $attachments );
	$info_box_style = get_post_meta( get_the_ID(), 'be_themes_info_box_style', true );
	$info_box = '';
	if($show_info_box == 1){
		$info_box = 'show-info-box';
		if(($slider_type == 'be-ribbon-carousel' || $slider_type == 'be-center-carousel') && $info_box_style == 'starting_slide') {
			$info_box = 'hide-info-box';
			$attachment_count++;
		}
	}

	$portfolio_title_nav = get_post_meta( get_the_ID(), 'be_themes_portfolio_title_nav', true);
	$portfolio_home_page = get_post_meta( get_the_ID(), 'be_themes_portfolio_home_page', true); //Get link from Meta Options
	$portfolio_home_page = ($portfolio_home_page == '' ? $be_themes_data['portfolio_home_page'] : $portfolio_home_page) ; //Get link from Options panel if not present in Meta Options is not present
	$portfolio_catg_traversal = (1 == get_post_meta( get_the_ID(), 'be_themes_traverse_catg', true) ? true : false);
	$single_portfolio_style = get_post_meta(get_the_ID(), 'be_themes_portfolio_single_page_style', true);
	$show_counts = get_post_meta( get_the_ID(), 'be_themes_swiper_slide_counts', true );
	$carousel_mobile_view = get_post_meta( get_the_ID(), 'be_themes_swiper_slide_one_by_one_mobile', true );
	$nav_arrows = get_post_meta( get_the_ID(), 'be_themes_swiper_slider_nav_arrows', true);
	$bg_ckeck_on = '';
	$title_wrap_flag = 0;
	// echo $be_themes_data['portfolio_title_nav_bg']['alpha'];
	if($single_portfolio_style == 'style3' && $be_themes_data['portfolio_title_nav_bg']['alpha'] == 0){
		$bg_ckeck_on = 'transparent-nav-bar';
	}
?>
<div class="gallery-info-box-wrap <?php echo $info_box; ?>"><?php
	if(!($single_portfolio_style == 'style2' || $single_portfolio_style == 'style3' || $single_portfolio_style == 'be-ribbon-carousel' || $single_portfolio_style == 'be-center-carousel') ){
		if(!empty( $nav_arrows ) ){
		?>
			<span class="arrow_prev"><i class="font-icon icon-arrow_carrot-left"></i></span>
			<span class="arrow_next"><i class="font-icon icon-arrow_carrot-right"></i></span>
		<?php
		}
	}
		if($info_box == 'show-info-box') { ?>
			<div class="gallery_content">
				<div class="gallery_content_area_wrap">
					<div class="gallery_content_area simplebar">
						<div class="gallery_scrollable_content simplebar-content">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
				<span class="single_portfolio_info_close  <?php echo $bg_ckeck_on ; ?>"><i class="font-icon icon-icon_menu"></i></span>
			</div> <?php
		}
		if($single_portfolio_style == 'style2' || $single_portfolio_style == 'style3' || $single_portfolio_style == 'be-ribbon-carousel' || $single_portfolio_style == 'be-center-carousel'){
			if(isset($show_counts) && $show_counts == 1) {?>
				<div id="portfolio-title-nav-bottom-wrap" class="clearfix "><?php
				echo '<div class="slider-counts '.$bg_ckeck_on.'"><span class="current-slide-count">1</span> / <span class="total-slides-count">'.$attachment_count.'</span></div>';
				$title_wrap_flag = 1;
			}
		}
		if ((isset($portfolio_title_nav) && 1 == $portfolio_title_nav) && ($single_portfolio_style == 'be-ribbon-carousel' || $single_portfolio_style == 'be-center-carousel' || ('style1' == $single_portfolio_style) ||('style2' == $single_portfolio_style) ||('style3' == $single_portfolio_style) || ('style4' == $single_portfolio_style))) { 
			if($title_wrap_flag == 0) {?>
				<div id="portfolio-title-nav-bottom-wrap" class="clearfix "><?php
			}?>
		
			<h6 class="portfolio-title-nav-bottom <?php echo $bg_ckeck_on ; ?>"><?php echo get_the_title(); ?></h6>
			<ul class="portfolio-nav-bottom <?php echo $bg_ckeck_on ; ?>">
				<!-- Previous Post Link -->
				<li>
				<?php if($portfolio_catg_traversal == true) {
					next_post_link('%link','<i class="font-icon icon-arrow_left"></i>',true,' ','portfolio_categories'); 
				}else {
					next_post_link('%link','<i class="font-icon icon-arrow_left"></i>'); 
				}?>
				</li>
				<!-- Home Page Grid -->
				<?php if ($portfolio_home_page != '') { ?>
					<li><a href="<?php echo esc_url( $portfolio_home_page ); ?>"><div class="home-grid-icon"><span></span><span></span><span></span><span></span><span></span><span></span></div></a></li><?php
				}?>
				<!-- Next Post Link -->
				<li>
				<?php if($portfolio_catg_traversal == true) {
					previous_post_link('%link','<i class="font-icon icon-arrow_right"></i>',true,' ','portfolio_categories'); 
				}else {
					previous_post_link('%link','<i class="font-icon icon-arrow_right"></i>'); 
				}?>
				</li>

			</ul>
			</div>	<?php
		} 
		if($title_wrap_flag == 1) {
			echo '</div>';
		}?>
</div>