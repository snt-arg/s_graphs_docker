<?php 
$post_id = be_get_page_id();
global $be_themes_data;
$blog_loop_style = '';
$background = '';
$cats_output = '';
$hero_section_custom_height = '';
$full = '';
$blog_loop_style = 'style1';
$featured_image = get_the_post_thumbnail_url( $post_id, 'full' );
$cats = get_the_category( $post_id );
$post_date = get_the_date();
$post_author = get_the_author();
$post_comments_count_obj = wp_count_comments();
if( !isset( $featured_image ) || empty( $featured_image ) ) {
    $background = '#1b1d20';
}else{
    $background = 'url(' . $featured_image . ') no-repeat scroll center center';
}
if( isset( $be_themes_data[ 'blog_style' ] ) ) {
    $blog_loop_style = $be_themes_data[ 'blog_style' ];
}
$hero_section_custom_height = ( isset( $be_themes_data[ 'blog_masonry_hero_height' ] ) ) ? $be_themes_data[ 'blog_masonry_hero_height' ] : '';
if( empty( $hero_section_custom_height ) ) {
    $full = 'full-screen-height';
}
?>
<div class = "header-hero-section be-wide-single be-blog-<?php echo $blog_loop_style; ?>" id = "hero-section">
    <div class = "header-hero-custom-section">
        <div class = "hero-section-wrap be-section be-bg-overlay be-bg-cover clearfix <?php echo $full; ?>" style = "background:<?php echo $background; ?>;<?php echo ( ( '' == $full ) ? ( 'height:' . $hero_section_custom_height . 'px;' ) : '' ); ?>">
            <div class = "section-overlay"></div>
            <div class = "be-row be-wrap">
                <div class = "hero-section-inner-wrap">
                    <div class = "hero-section-inner">
                        <?php 
                            if( !empty( $cats ) ) :
                                $cat_list = [];
                        ?>
                            <div class = "hero-section-blog-categories-wrap">
                                <?php 
                                    foreach( $cats as $category ) :
                                        if ( ! in_array( $category->cat_ID, $cat_list ) ) :
                                ?> 
                                    <a href = "<?php echo get_category_link( $category->cat_ID ); ?>" title="<?php echo ( __('View all posts in','oshin').' '.$category->cat_name ); ?>">
                                        <?php echo $category->cat_name; ?>
                                    </a>
                                <?php 
                                            $cat_list[] = $category->cat_ID;
                                        endif;
                                    endforeach; 
                                ?>
                            </div>
                        <?php   
                            endif;
                        ?>     
                        <div class = "hero-section-blog-title">
                            <h1 class = "post-title">
                                <?php echo get_the_title( $post_id ); ?>
                            </h1>
                        </div>
                        <div class = "hero-section-blog-bottom-meta-wrap">
                            <?php 
                                if( !empty( $post_date ) ) :
                            ?>
                                <span class = "post-meta-date">
                                    <?php echo $post_date; ?>
                                </span>
                            <?php
                                endif;
                                if( !empty( $post_author ) ) :
                            ?>
                                <span class = "post-meta-author">
                                    <?php echo $post_author; ?>
                                </span>
                            <?php
                                endif;
                                if( 0 < $post_comments_count_obj->approved ) :
                            ?>
                                <span class = "post-comments-wrap">
                                    <?php echo ( comments_number('0','1','%') == 1 ) ? '1 comment' : ' comments'; ?>
                                </span>
                            <?php
                                endif;
                            ?>                                
                            <?php echo be_get_share_button(get_the_permalink(), get_the_title(), get_the_ID(), true, 'left', 'post-share-wrap' ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>