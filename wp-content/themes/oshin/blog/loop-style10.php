<?php
$page_id = be_get_page_id();
global $blog_attr, $more_text, $be_themes_data;
$post_classes = get_post_class();
//print_r($post_classes);
if (($key = array_search('format-link', $post_classes)) !== false) {
    unset($post_classes[$key]);
}
if (($key = array_search('format-quote', $post_classes)) !== false) {
    unset($post_classes[$key]);
}
$post_classes = implode( ' ', $post_classes );
$is_wide_single = ( isset( $be_themes_data[ 'single_blog_style' ] ) && !empty( $be_themes_data[ 'single_blog_style' ] ) ) ? true : false;
if($blog_attr['style'] == 'style3') {
	$post_classes .= ' element not-wide';
}
$post_format = get_post_format();
$cats = get_the_category( $page_id );
?>	
<article id="post-<?php the_ID(); ?>" class="element not-wide blog-post clearfix <?php echo esc_attr( $post_classes ); ?> child">
	<div class="element-inner" style="<?php echo ($blog_attr['style'] == 'style3') ? 'margin-left:'.$blog_attr['gutter_width'].'px' : ''; ?>">
		<div class="post-content-wrap">
            <?php if( !empty( $cats ) ) : 
                echo '<header class="post-header clearfix">';
            ?>
                <div class = "hero-section-blog-categories-wrap">
                    <?php 
                        foreach( $cats as $category ) :
                    ?> 
                        <a href = "<?php echo get_category_link( $category->cat_ID ); ?>" title="<?php echo ( __('View all posts in','oshin').' '.$category->cat_name ); ?>">
                            <?php echo $category->cat_name; ?>
                        </a>
                    <?php 
                        endforeach; 
                    ?>
                </div>
            <?php  echo '</header>'; endif;  ?>  
            
            
			<div class="article-details <?php echo $post_format;?>">
				<?php
					/*if( $post_format == 'quote' || $post_format == 'link' ) :
						echo '<div class="post-top-details clearfix">';
							get_template_part( 'blog/post', 'details-style2' );
						echo '</div>';
						get_template_part( 'content', $post_format );*/
					if( !is_single() || !$is_wide_single ) : ?>
						<div class="clearfix post-title-section-wrap">
							<div class="left post-date-wrap">
								<?php 
									echo '<div>'.get_the_date( 'M' ).'</div>';
									echo '<div>'.get_the_date( 'd' ).'</div>';
								?>
							</div>
							<div class="left post-title-section">
								<h2 class="post-title">
									<a href="<?php echo get_permalink(get_the_ID()); ?>"> 
										<?php echo get_the_title(get_the_ID()); ?>
									</a>
								</h2>
								<?php $featured_image = get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>
                                <div class="flip-img-wrap img-loaded"><img src="<?php echo $featured_image;?>" /></div>
							</div>
						</div> <?php
					endif;
				?>
				<?php if( is_single() ): ?>
					<div class="post-details clearfix">
						<div class="post-content clearfix">
							<?php
								if( !is_search() ) {
									$be_pb_disabled = get_post_meta( get_the_ID(), '_be_pb_disable', true );	
									
									if ( isset($be_themes_data['enable_pb_blog_posts']) && 1 == $be_themes_data['enable_pb_blog_posts'] && 'yes' != $be_pb_disabled  && !is_single() ) {
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
</article>
<?php if(is_single()) { 
    get_template_part('blog/single', 'masonry-share');
}
?>
