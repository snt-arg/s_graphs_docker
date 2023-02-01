<?php
$page_id = be_get_page_id();
global $blog_attr, $more_text, $be_themes_data;
$post_classes = get_post_class();
$post_format = get_post_format();
$post_classes = implode( ' ', $post_classes );
$is_wide_single = ( isset( $be_themes_data[ 'single_blog_style' ] ) && !empty( $be_themes_data[ 'single_blog_style' ] ) ) ? true : false;
$blog_image_size = is_single() ? 'blog-image' : '2col-portfolio-masonry';
$post_thumb_img = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $blog_image_size );
if( $post_thumb_img ) {
    $current_height = ((($post_thumb_img[2]/$post_thumb_img[1])*100))."%";
    $aspect_ratio = round( $post_thumb_img[1]/$post_thumb_img[2], 2 );
} else {
    $current_height = 0;
    $aspect_ratio = 1;
}
$gutter_width = isset($be_themes_data['blog_gutter_width']) ? $be_themes_data['blog_gutter_width'] : 40;

if(!empty($blog_attr['style']) && $blog_attr['style'] == 'style8') {
	$post_classes .= ' element not-wide';
	$article_gutter = 'style="margin-bottom: '.esc_attr( $blog_attr['gutter_width'] ).'px !important;"';
} else {
	$article_gutter = '';
}
if($post_format == 'image'  && !is_single()){
    $post_classes .= ' be-image-post';
}
if(($post_format == 'quote' || $post_format == 'link') && !is_single() ){
    $post_card_color =  get_post_meta( get_the_ID(), 'be_themes_post_text_color', true ) ;
    $post_card_bg =  get_post_meta( get_the_ID(), 'be_themes_thumbnail_bg_color', true ) ;
    $post_card_color = ($post_card_color != '') ? 'color: ' .$post_card_color. ';' : '' ;
    $post_card_bg = ($post_card_bg != '') ? 'background-color: ' .$post_card_bg. ';' : '' ; 
    $style = 'style= "'.$post_card_bg.' '.$post_card_color.'"';
}
?>	

<article id="post-<?php the_ID(); ?>" class="element not-wide no-wide-width-height blog-post clearfix <?php echo esc_attr( $post_classes ); ?>" <?php echo $article_gutter; ?>>
	<div class="element-inner" style="<?php echo ($blog_attr['style'] == 'style8') ? ( 'margin-left:'.$blog_attr['gutter_width'].'px;' ) : '' ?>">
        <?php if(is_single() || (($post_format != 'image') && ($post_format != 'quote') && ($post_format != 'link')) ){?>
            <div class = "post-content-outer-wrap">
                <div class="post-content-wrap">
                    <?php if($post_format == 'gallery') {
                        get_template_part( 'content', $post_format ); 
                    } else if( ( !is_single() && ( ('' != $post_format ) || !empty( $post_thumb_img ) ) ) || ( ( '' != $post_format && 'image' != $post_format ) || ( !$is_wide_single && !empty( $post_thumb_img ) ) ) ) {?>
                    <div <?php echo ( ( '' == $post_format || 'image' == $post_format ) ) ? ('class = "post-thumb-wrap" style = "padding-bottom:' . $current_height .';" data-aspect-ratio = "'. $aspect_ratio . '"') : '' ?> >
                        
                        <a href = "<?php echo ( ( isset($be_themes_data['open_to_lightbox']) && 1 == $be_themes_data['open_to_lightbox'] ) ? ( $post_thumb_img[ 0 ] ) : ( is_single() ? '#' : get_permalink( get_the_ID() ) ) ); ?>" class = "thumb-wrap <?php echo ( (isset($be_themes_data['open_to_lightbox']) && 1 == $be_themes_data['open_to_lightbox'] ) ? 'image-popup-vertical-fit mfp-image' : '' ); ?>" >
                            <?php if($post_format == 'audio' || $post_format == 'video'){
                                get_template_part( 'content', $post_format ); 
                            }else if( !is_single() && !is_category() && !is_search() && !is_tag() && !is_date() ){?>
                                <img data-src = "<?php echo $post_thumb_img[0];?>"></img>
                            <?php 
                            }else{
                                the_post_thumbnail( $blog_image_size );
                            }
                            ?>
                        </a>
                        <?php if(null !== $be_themes_data['blog_meta_category'] && $be_themes_data['blog_meta_category'] != false && 'audio' != $post_format && 'video' != $post_format ){?>
                            <div class = "post-meta post-category post-category-wrap">
                                <?php be_themes_category_list($id); ?>
                            </div>
                        <?php }?>
                    </div> 
                    <?php }?>
                        <div class = "post-details-wrap">
                            <?php if( !is_single() || !$is_wide_single ) { ?>
                            <div class = "post-top-meta-wrap">
                                <?php 
                                if(null !== $be_themes_data['blog_meta_date'] && $be_themes_data['blog_meta_date'] != false){?>
                                <div class = "post-meta post-date">
                                    <?php echo get_the_date(); ?>
                                </div><?php
                                }
                                echo '<h2 class="post-title"><a href="'.get_permalink(get_the_ID()).'">'.get_the_title(get_the_ID()).'</a></h2>';
                                } ?>
                                <div class="post-content">
                                    <?php
                                        if ( post_password_required() ) {
                                            $content  = get_the_password_form();
                                            echo '<div class="be-wrap clearfix be-section-pad">'.$content.'</div>';
                                        } else {
                                            the_content();
                                    }?>
                                </div>
                            <?php if( !is_single() ) { ?></div> <?php } ?>
                            <?php if( ($be_themes_data['blog_meta_comments_count'] == true || $be_themes_data['blog_meta_author'] == true || $be_themes_data['blog_meta_share'] == true) && !is_single() ){?>
                            <div class = "post-bottom-meta-wrap">
                                <?php if(null !== $be_themes_data['blog_meta_author'] && $be_themes_data['blog_meta_author'] != false){?>
                                <div class = "post-author-wrap">
                                    <div class = "post-author-img"><?php
                                        echo get_avatar( get_the_author_meta( 'ID' ) , 120 );
                                    ?>
                                    </div>                    
                                    <div class = "post-meta post-author post-author-name">
                                        <?php echo get_the_author(); ?>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class = "post-comment-share-wrap">
                                    <?php if(null !== $be_themes_data['blog_meta_comments_count'] && $be_themes_data['blog_meta_comments_count'] != false){?>
                                    <div class = "post-comment-wrap">
                                        <a href = "<?php comments_link() ?>">
                                            <span class = "post-comment-icon">
                                                <i class="icon-comment" aria-hidden="true"></i>
                                            </span>                    
                                            <span class = "post-meta post-comments post-comment-count">
                                                <?php comments_number('0','1','%');?>
                                            </span>  
                                        </a>  
                                    </div>       
                                    <?php } ?>  
                                    <?php if(null !== $be_themes_data['blog_meta_share'] && $be_themes_data['blog_meta_share'] != false){?>      
                                    <div class = "post-share-wrap">
                                       <?php echo be_get_share_button(get_the_permalink(), get_the_title(), get_the_ID(), true, 'top', 'post-share-wrap' );?>   
                                    </div>
                                    <?php } ?>  
                                </div>    
                            </div>  
                            <?php } ?>   
                        </div>
                </div>   
            </div>
        <?php }
        else{ 
            if($post_format == 'image'){?>
                <div class = "post-content-outer-wrap be-image-post"> 
                    <div class="post-content-wrap">
                        <div class = "post-thumb">
                            <a <?php echo ( !empty( $post_thumb_img ) ? ( 'style = "background : url(' . $post_thumb_img[0] . ') 50% no-repeat; background-size: cover;"' ) : '' ) ?> href = "<?php echo ( ( isset( $be_themes_data['open_to_lightbox'] ) && 1 == $be_themes_data[ 'open_to_lightbox' ] ) ? $post_thumb_img[0] : get_permalink( get_the_ID() ) ); ?>" class = "thumb-wrap <?php echo ( ( isset($be_themes_data['open_to_lightbox']) && 1 == $be_themes_data['open_to_lightbox'] ) ? 'image-popup-vertical-fit mfp-image' : '' ); ?>">
                            </a>
                            <div class="post-thumb-wrap-overlay">
                            </div>
                        </div>
                        <div class = "post-details-wrap">
                            <?php if(null !== $be_themes_data['blog_meta_category'] && $be_themes_data['blog_meta_category'] != false){?>
                                <div class = "post-meta post-category post-category-wrap">
                                    <?php be_themes_category_list($id); ?>
                                </div>
                            <?php }?>
                            <div class = "post-top-meta-wrap">
                                <?php if(null !== $be_themes_data['blog_meta_date'] && $be_themes_data['blog_meta_date'] != false){?>
                                    <div class = "post-meta post-date">
                                        <?php echo get_the_date(); ?>
                                    </div><?php
                                }
                                echo '<h2 class="post-title"><a href="'.get_permalink(get_the_ID()).'">'.get_the_title(get_the_ID()).'</a></h2>'; ?>
                                <div class="post-content">
                                    <?php
                                        if ( post_password_required() ) {
                                            $content  = get_the_password_form();
                                            echo '<div class="be-wrap clearfix be-section-pad">'.$content.'</div>';
                                        } else {
                                            the_content();
                                    }?>
                                </div>
                            </div>
                            <?php if($be_themes_data['blog_meta_comments_count'] == true || $be_themes_data['blog_meta_author'] == true || $be_themes_data['blog_meta_share'] == true){?>
                            <div class = "post-bottom-meta-wrap">
                                <?php if(null !== $be_themes_data['blog_meta_author'] && $be_themes_data['blog_meta_author'] != false){?>
                                    <div class = "post-author-wrap">
                                        <div class = "post-author-img"><?php
                                            echo get_avatar( get_the_author_meta( 'ID' ) , 120 );
                                        ?>
                                        </div>                    
                                        <div class = "post-meta post-author post-author-name">
                                            <?php echo get_the_author(); ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class = "post-comment-share-wrap">
                                    <?php if(null !== $be_themes_data['blog_meta_comments_count'] && $be_themes_data['blog_meta_comments_count'] != false){?>
                                        <div class = "post-comment-wrap">
                                            <a href = "<?php comments_link() ?>">
                                                <span class = "post-comment-icon">
                                                    <i class="icon-comment" aria-hidden="true"></i>
                                                </span>                    
                                                <span class = "post-meta post-comments post-comment-count">
                                                <?php comments_number('0','1','%');?>
                                                </span>  
                                            </a>  
                                        </div>       
                                    <?php } ?>  
                                    <?php if(null !== $be_themes_data['blog_meta_share'] && $be_themes_data['blog_meta_share'] != false){?>      
                                        <div class = "post-share-wrap">
                                            <?php echo be_get_share_button(get_the_permalink(), get_the_title(), get_the_ID(), true, 'top', 'post-share-wrap' );?>
                                        </div>
                                    <?php } ?>  
                                </div>    
                            </div><?php
                            }?>
                        </div> 
                    </div> 
                </div>
            <?php } elseif($post_format == 'quote' || $post_format == 'link'){ ?>
                <div class = "post-content-outer-wrap">
                    <div class="post-content-wrap">
                        <div class = "post-details-wrap" <?php echo $style; ?>>   
                            <div class="post-content">
                                <?php get_template_part( 'content', $post_format ); ?>
                            </div>
                        </div>
                    </div>   
                </div>
            <?php } ?>
        <?php }?>
    </div>
</article>                        
<?php if(is_single()) { 
    get_template_part('blog/single', 'share');
} ?>

