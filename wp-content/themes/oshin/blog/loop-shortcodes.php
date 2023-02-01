<?php
$page_id = be_get_page_id();
global $blog_attr, $more_text;
$post_classes = get_post_class();
$post_classes = implode( ' ', $post_classes );
if($blog_attr['style'] == 'shortcodes') {
	$post_classes .= ' element not-wide';
	$article_gutter = 'style="margin-bottom: '.esc_attr( $blog_attr['gutter_width'] ).'px !important;"';
} else {
	$article_gutter = '';
}
$post_format = get_post_format();
$is_tastu_social_on = ( isset( $blog_attr['social_icons'] ) && $blog_attr['social_icons'] ) ? true : false;
$is_tastu_tags_visible = ( isset( $blog_attr['show_tags'] ) && $blog_attr['show_tags'] ) ? true : false;
?>	
<article id="post-<?php the_ID(); ?>" class="element not-wide blog-post clearfix <?php echo esc_attr( $post_classes ); ?>" <?php echo $article_gutter; ?>>
	<div class="element-inner" style="<?php echo ($blog_attr['style'] == 'shortcodes') ? 'margin-left:'.$blog_attr['gutter_width'].'px' : ''; ?>">
		<div class="post-content-wrap">
			<?php
				if( $post_format != 'quote' && $post_format != 'link' ) {
					get_template_part( 'content', $post_format ); 
				} 
			?>
			<div class="article-details clearfix">
				<header class="post-header clearfix">
					<?php
						if( $post_format == 'quote' || $post_format == 'link' ) :
							echo '<div class="post-top-details clearfix">';
								get_template_part( 'blog/post', 'top-details' );
							echo '</div>';
							get_template_part( 'content', $post_format );
						else :
							echo '<h2 class="post-title"><a href="'.get_permalink(get_the_ID()).'">'.get_the_title(get_the_ID()).'</a></h2>';
						endif;
					?>
				</header>
				<?php if( $post_format != 'quote' && $post_format != 'link' ): ?>
					<div class="post-top-details clearfix"><?php get_template_part( 'blog/post', 'top-details' ); ?></div>
					<div class="post-details clearfix">
						<div class="post-content clearfix">
							<?php
								the_excerpt();								
							?>
						</div>
					</div>
				<?php endif; ?>
				<div class="post-bottom-details clearfix"><?php get_template_part( 'blog/post', 'bottom-details' ); ?></div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</article>
<?php if ( ( is_single() && $blog_attr['style'] != 'shortcodes' ) ) { ?>
	<div class="clearfix single-page-atts">
		<div class="clearfix single-page-att">
			<h6><?php echo __('Share This : ','oshin'); ?></h6> <div class="share-links clearfix"><?php echo be_get_share_button(get_the_permalink(), get_the_title(), get_the_ID()); ?></div>
		</div>
		<div class="clearfix single-page-att">
			<h6><?php echo __('Tags : ','oshin'); ?></h6> <?php echo get_the_tag_list('<div class="tagcloud">','','</div>'); ?>
		</div>
	</div>
<?php } ?>
<?php if ( $blog_attr['style'] == 'shortcodes' && ( $is_tastu_social_on || $is_tastu_tags_visible ) ) { ?>
	<div class="clearfix single-page-atts">
		<?php if ( $is_tastu_social_on ) { ?>
			<div class="clearfix single-page-att">
				<h6><?php echo __('Share This : ','oshin'); ?></h6> <div class="share-links clearfix"><?php echo be_get_share_button(get_the_permalink(), get_the_title(), get_the_ID()); ?></div>
			</div>
		<?php } ?>
		<?php if ( $is_tastu_tags_visible ) { ?>
			<div class="clearfix single-page-att">
				<h6><?php echo __('Tags : ','oshin'); ?></h6> <?php echo get_the_tag_list('<div class="tagcloud">','','</div>'); ?>
			</div>
		<?php } ?>
	</div>
<?php } ?>