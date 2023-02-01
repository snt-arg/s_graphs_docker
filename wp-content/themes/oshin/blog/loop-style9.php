<?php
$page_id = be_get_page_id();
global $blog_attr, $more_text, $be_themes_data;
$post_classes = get_post_class();
$post_format = get_post_format();
$post_classes = implode( ' ', $post_classes );
$double_width = get_post_meta( get_the_ID(), 'be_themes_blog_double_width', true );
$double_height = get_post_meta( get_the_ID(), 'be_themes_blog_double_height', true );
$aspect_ratio = 1; 
$blog_image_size = '2col-portfolio-masonry';
$post_thumb_img = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
$current_height = 0;

if( $post_thumb_img ) {
    if(null !== $double_width && $double_width == 1 ){
        if(null !== $double_height && $double_height == 1){
            $post_classes .= ' wide wide-width-height';
            $current_height = ( ( 2 * ($post_thumb_img[1]/$aspect_ratio) )/( 2 * $post_thumb_img[1]) ) * 100;
        }else{
            $post_classes .= ' wide wide-width';
            $current_height = ( ($post_thumb_img[1]/$aspect_ratio) / (2*$post_thumb_img[1]) ) * 100 ;
        }
    }elseif(null !== $double_height && $double_height == 1 ){    
        $post_classes .= ' wide-height';
        $current_height = ( ( 2 * ($post_thumb_img[1]/$aspect_ratio) )/$post_thumb_img[1] ) * 100;
    }else{
        $post_classes .= ' no-wide no-wide-width-height';
        $current_height = ( ( $post_thumb_img[1]/$aspect_ratio )/$post_thumb_img[1] ) * 100;
    }
}


$gutter_width = isset($be_themes_data['blog_gutter_width']) ? $be_themes_data['blog_gutter_width'] : 40;

if($blog_attr['style'] == 'style9') {
	$article_gutter = 'style="margin-bottom: '.esc_attr( $blog_attr['gutter_width'] ).'px !important;"';
} else {
	$article_gutter = '';
}
?>	

<article id="post-<?php the_ID(); ?>" class="element not-wide blog-post clearfix <?php echo esc_attr( $post_classes ); ?>" <?php echo $article_gutter; ?>>
	<div class="element-inner" style="<?php echo ($blog_attr['style'] == 'style9') ? 'margin-left:'.$blog_attr['gutter_width'].'px' : ''; ?>">
        <div class = "post-content-outer-wrap"> 
            <div class = "post-thumb-wrap" style = "padding-bottom: <?php echo "$current_height%"; ?> ;">
                <a href = "<?php echo $post_thumb_img[0]; ?>" class = "thumb-wrap">
                    <?php the_post_thumbnail( $blog_image_size ); ?>
                </a>
                <div class="post-thumb-wrap-overlay">
                </div>
            </div>
            <div class = "post-details-wrap">
                <div class = "post-meta-wrap">
                    <?php if(null !== $be_themes_data['blog_meta_category'] && $be_themes_data['blog_meta_category'] != false){?>
                        <div class = "post-meta post-category post-category-wrap">
                            <?php be_themes_category_list($id); ?>
                        </div>
                    <?php }
                    echo '<h2 class="post-title"><a href="'.get_permalink(get_the_ID()).'">'.get_the_title(get_the_ID()).'</a></h2>'; ?>
                    <?php if(null !== $be_themes_data['blog_meta_date'] && $be_themes_data['blog_meta_date'] != false){?>
                        <div class = "post-meta post-date">
                            <?php echo get_the_date(); ?>
                        </div><?php
                    }?>
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
            </div>        
        </div>
    </div>                  
</article>                        
<?php if(is_single()) { 
    get_template_part('blog/single', 'share');
} ?>

