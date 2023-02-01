<?php
$page_id = be_get_page_id();
global $blog_attr, $more_text, $be_themes_data;
$post_classes = get_post_class();
$post_classes = implode( ' ', $post_classes );
$is_wide_single = ( isset( $be_themes_data[ 'single_blog_style' ] ) && !empty( $be_themes_data[ 'single_blog_style' ] ) ) ? true : false;
if($blog_attr['style'] == 'style3') {
	$post_classes .= ' element not-wide';
	$article_gutter = 'style="margin-bottom: '.$blog_attr['gutter_width'].'px !important;"';
} else {
	$article_gutter = '';
}
$post_format = get_post_format();
?>	
<article id="post-<?php the_ID(); ?>" class="element not-wide blog-post clearfix <?php echo esc_attr( $post_classes ); ?>" <?php echo esc_attr( $article_gutter ); ?>>
	<div class="element-inner" style="<?php echo ($blog_attr['style'] == 'style3') ? 'margin-left:'.$blog_attr['gutter_width'].'px' : ''; ?>">
		<div class="post-content-wrap">
			<?php
				if( $post_format != 'quote' && $post_format != 'link' ) {
					get_template_part( 'content', $post_format ); 
				} 
			?>
			<div class="article-details clearfix">
				<?php if( !is_single() || !$is_wide_single ) : ?>
					<header class="post-header clearfix">
						<?php
							if( $post_format == 'quote' || $post_format == 'link' ) :
								echo '<div class="post-top-details clearfix">';
									get_template_part( 'blog/post', 'details' );
								echo '</div>';
								get_template_part( 'content', $post_format );
							else :
								echo '<div class="post-meta post-category post-top-meta-typo">';
								be_themes_category_list(get_the_ID());
								echo '</div>';
								if(get_the_title(get_the_ID())) {
									echo '<h2 class="post-title"><a href="'.get_permalink(get_the_ID()).'">'.get_the_title(get_the_ID()).'</a></h2>';
								}
							endif;
						?>
					</header>
				<?php endif; ?>
				<?php if( $post_format != 'quote' && $post_format != 'link' ): ?>
					<?php if( !is_single() || !$is_wide_single ) : ?>
						<div class="post-top-details clearfix"><?php get_template_part( 'blog/post', 'details' ); ?></div>
					<?php endif; ?>
					<div class="post-details clearfix">
						<div class="post-content clearfix">
							<?php
								if( !is_search() ) {
									$be_pb_disabled = get_post_meta( get_the_ID(), '_be_pb_disable', true );	
									
									if ( isset($be_themes_data['enable_pb_blog_posts']) && 1 == $be_themes_data['enable_pb_blog_posts'] && 'yes' != $be_pb_disabled && !is_single() ) {
										// the_excerpt();
										if ( post_password_required() ) {
					       	 				$content  = get_the_password_form();

					       	 			    echo '<div class="be-wrap clearfix be-section-pad">'.$content.'</div>';
					       	 			} else {
											the_excerpt();
										}
									} else {
										// the_content( __('Read More','oshin') );
										if ( post_password_required() ) {
					       	 				$content  = get_the_password_form();

					       	 			    echo '<div class="be-wrap clearfix be-section-pad">'.$content.'</div>';
					       	 			} else {
											the_content( __('Read More','oshin') );
										}
									}
								}
								if( is_single() ): 
									$args = array (
										'before'           => '<div class="pages_list margin-40">',
										'after'            => '</div>',
										'link_before'      => '',
										'link_after'       => '',
										'next_or_number'   => 'next',
										'nextpagelink'     => __('Next >','oshin'),
										'previouspagelink' => __('< Prev','oshin'),
										'pagelink'         => '%',
										'echo'             => 1 
									);
									wp_link_pages( $args );
								endif; 
							?>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<?php if( !is_single() ) { ?>
		<div class="blog-separator clearfix"><hr class="separator" /></div>
	<?php } ?>
</article>
<?php if(is_single()) { 
	get_template_part('blog/single', 'share');
} ?>