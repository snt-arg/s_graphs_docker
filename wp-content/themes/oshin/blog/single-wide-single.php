<?php 
/****FOR BLOG STYLE 10 : Show above the post Content*****/
$post_id = be_get_page_id();
global $be_themes_data;
$blog_loop_style = '';
$background = '';
$cats_output = '';
$hero_section_custom_height = '';
$full = '';
$blog_loop_style = 'style1';
$featured_image = get_the_post_thumbnail_url( $post_id, 'full' );
//$cats = get_the_category( $post_id );
$post_date = get_the_date();
$post_author = get_the_author();
$post_comments_count_obj = wp_count_comments();
if( !isset( $featured_image ) || empty( $featured_image ) ) {
    $background = '#1b1d20';
}else{
    $background = 'url(' . $featured_image . ') no-repeat scroll top center';
}
if( isset( $be_themes_data[ 'blog_style' ] ) ) {
    $blog_loop_style = $be_themes_data[ 'blog_style' ];
}
$hero_section_custom_height = ( isset( $be_themes_data[ 'blog_masonry_hero_height' ] ) ) ? $be_themes_data[ 'blog_masonry_hero_height' ] : '';
if( empty( $hero_section_custom_height ) ) {
    $full = 'full-screen-height';
}
?>
<div class = "header-hero-section be-wide-single be-blog-<?php echo $blog_loop_style; ?> be-wrap- child" id = "hero-section">
    <div class = "header-hero-custom-section">
        <div class = "hero-section-wrap be-section be-bg-overlay be-bg-cover clearfix <?php echo $full; ?>" style = "background:<?php echo $background; ?>;<?php echo ( ( '' == $full ) ? ( 'height:' . $hero_section_custom_height . 'px;' ) : '' ); ?>">
            <div class = "section-overlay"></div>
            <div class = "be-row be-wrap">
                <div class = "hero-section-inner-wrap">
                    <div class = "hero-section-inner">
                        
                         <?php if( !empty( $post_date ) ) : ?>
                                <span class = "post-meta-date">
                                    <?php echo $post_date; ?>
                                </span>
                          <?php endif;   ?>
                        <div class = "hero-section-blog-title">
                            <h1 class = "post-title">
                                <?php echo get_the_title( $post_id ); ?>
                            </h1>
                        </div>
                        <div class = "hero-section-blog-bottom-meta-wrap">
                            <?php
                                $author_name = get_the_author_meta( 'first_name' ).' '.get_the_author_meta( 'last_name' );
                                if( !empty( $author_name ) ) :
                            ?>
                                <div id="hero-author-info" class="clearfix">
                                        <div id="hero-author-img">
                                            <?php 
                                                echo get_avatar( get_the_author_meta( 'ID' ), 128 );
                                            ?>
                                        </div>
                                        <div id="hero-author-details">
                                            <strong> Written by </strong>
                                            <h4><?php echo $author_name; ?></h4>
                                            
                                        </div>    
                                  </div>
                            <?php
                                endif;
                            ?>     
                            <div class="share-posts">    
                                <?php echo be_get_share_button_show_hide(get_the_permalink(), get_the_title(), get_the_ID(), false, 'right', 'post-share-wrap' ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>