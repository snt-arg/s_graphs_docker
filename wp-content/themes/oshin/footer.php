<?php
global $be_themes_data;
// Tatsu Footer Builder
do_action( 'tatsu_footer' );
if( isset( $be_themes_data['enable_footer_builder'] ) && $be_themes_data['enable_footer_builder'] == 1 ){
	do_action( 'tatsu_print_footer' );
}else{
	$post_id = be_get_page_id();
	$fixed_footer = ( isset( $be_themes_data['fixed-footer'] ) && !empty( $be_themes_data['fixed-footer'] ) && be_is_fixed_footer_possible() ) ? true : false;
	$show_bottom_widgets = get_post_meta($post_id, 'be_themes_bottom_widgets', true);
	$show_footer_area = get_post_meta($post_id, 'be_themes_footer_area', true);
	if($show_bottom_widgets != 'no') {
		$show_widgets = true;
	} else {
		$show_widgets = false;
	}
	if((is_home() || is_search() || is_tag() || is_archive() || is_category())){
		if(isset( $be_themes_data['show_bottom_widgets'] ) && 'yes' == $be_themes_data['show_bottom_widgets']) {
			$show_widgets = true;
		} else {
			$show_widgets = false;
		}
	}
	$col_class = "one-third";
	$i = 3;
	$active_sidebar = false;
	if($be_themes_data['bottom_widgets_layout'] == 'four-col') {
		$col_class = "one-fourth";
		$i = 4;
	}
	for($j = 1; $j <= $i; $j++) {
		if ( is_active_sidebar( 'footer-widget-'.$j ) ) {
			$active_sidebar = true;
			break;
		}
	}
	if( $fixed_footer ) {?>
		<div id = "be-fixed-footer-wrap">
	<?php }
	if( $show_widgets && $active_sidebar ) { ?>
		<footer id="bottom-widgets">
			<div id="bottom-widgets-wrap" class="be-wrap be-row clearfix">
				<?php for($j = 1; $j <= $i; $j++) : ?>
					<div class="<?php echo $col_class; ?> column-block clearfix">
						<?php 
							if ( is_active_sidebar( 'footer-widget-'.$j ) ) {
								dynamic_sidebar( 'footer-widget-'.$j );
							}
						?>
					</div>
				<?php endfor; ?>	
			</div>
		</footer>
	<?php } ?>
	<?php if(('no' != $show_footer_area) && !(($be_themes_data['footer-content-pos-center'] == 'none' ) && ($be_themes_data['footer-content-pos-left'] == 'none' ) && ($be_themes_data['footer-content-pos-right'] == 'none' ))) { ?>
		<footer id="footer" class="<?php echo esc_attr( $be_themes_data['layout'] );?>">
			<span class="footer-border <?php echo (($be_themes_data['footer-border-wrap']) ? 'be-wrap ' : '' );?>"></span>
			<div id="footer-wrap" class=" <?php echo esc_attr( $be_themes_data['footer-style'] ); if(true == $be_themes_data['opt-footer-wrap']){?> be-wrap<?php } ?> clearfix">
				
				<div class="footer-left-area">
					<?php  if($be_themes_data['footer-content-pos-left'] != 'none' ) : ?>
					<div class="footer-content-inner-left">
						 <?php	be_themes_get_footer_widget($be_themes_data['footer-content-pos-left']); ?>
					</div>
					<?php endif; ?>
				</div>
								
				<div class="footer-center-area">
					<?php if ($be_themes_data['footer-content-pos-center'] != 'none' ) : ?>
					<div class="footer-content-inner-center">
						<?php be_themes_get_footer_widget($be_themes_data['footer-content-pos-center']); ?>
					</div>
					<?php endif; ?>
				</div>
						
				<div class="footer-right-area">
					<?php if($be_themes_data['footer-content-pos-right'] != 'none' ) : ?>
					<div class="footer-content-inner-right">
						<?php be_themes_get_footer_widget($be_themes_data['footer-content-pos-right']); ?>
					</div>
					<?php endif; ?>	
				</div>
			</div>
		</footer> <?php
	}
	
	if( $fixed_footer ) {?>
		</div>
		<div id = "be-fixed-footer-placeholder"></div>
	<?php
	}
	?>
<?php } ?>
	<?php do_action('be_themes_after_footer'); ?>
	</div>
	<?php get_template_part( 'page', 'loader' ); ?>

	<?php
		if(!(isset($be_themes_data['disable_back_top_btn']) && !empty($be_themes_data['disable_back_top_btn']) && $be_themes_data['disable_back_top_btn'] == 1)) {
			echo '<a href="#" id="back-to-top" class="'.$be_themes_data['layout'].'"><i class="font-icon icon-arrow_carrot-up"></i></a>';
		}
	?>
	<?php if('layout-border' == $be_themes_data['layout'] || 'layout-border-header-top' == $be_themes_data['layout']) { ?>
	<div class="layout-box-container">
		<?php if('layout-border' == $be_themes_data['layout'] || 'left' == $be_themes_data['opt-header-type']) { ?>
			<div class="layout-box-top"></div>
		<?php } ?>
		<div class="layout-box-right"></div>
		<div class="layout-box-bottom"></div>
		<div class="layout-box-left"></div>
	</div>
	<?php
	}?>
	<?php if( be_is_special_top_menu('page-stack-top') ) : ?>
		</div>
		<div class = "be-page-stack-container">
			<div class="be-page-stack be-page-stack-empty">
			</div>
		</div>
		<div class = "be-page-stack-container">
			<div class="be-page-stack be-page-stack-empty">
			</div>
		</div>
	<?php endif; ?>
	</div>



<input type="hidden" id="ajax_url" value="<?php echo admin_url( 'admin-ajax.php' ); ?>" />
<?php 
    if(is_array($be_themes_data)) :
        if( array_key_exists('all_ajax_exclude_links', $be_themes_data) ) : ?>
            <input type="hidden" id="all_ajax_exclude_links" value="<?php echo esc_attr( $be_themes_data['all_ajax_exclude_links'] ); ?>" />
<?php endif; endif; ?>
<?php wp_footer(); ?>
<!-- Option Panel Custom JavaScript -->
<script>
	//jQuery(document).ready(function(){
		<?php echo stripslashes_deep(htmlspecialchars_decode($be_themes_data['custom_js'],ENT_QUOTES));   ?>
	// });
</script>
</body>
</html>