<?php

$selected_categorey = wp_get_post_terms( get_the_ID(), 'portfolio_categories' );
$terms = wp_list_pluck( $selected_categorey, 'term_id' );
$order = get_post_meta( get_the_ID(), 'be_themes_portfolio_template_item_order', true );
$start_from_center = get_post_meta( get_the_ID(), 'be_themes_title_carousel_start_from_center', true );
$mousewheel_nav = get_post_meta( get_the_ID(), 'be_themes_title_carousel_mousewheel_nav', true );

if($terms) {
    $args = array (
        'post_type' => 'portfolio',
        'tax_query' => array (
            array (
                'taxonomy' => 'portfolio_categories',
                'field' => 'term_id',
                'terms' => $terms,
                'operator' => 'IN'
            )
        ),
        'posts_per_page' => '-1',
        'orderby'=> 'date',
        'order'=> $order,
        'status'=> 'publish'
    );
} else {
    $args = array (
        'post_type' => 'portfolio',
        'posts_per_page' => '-1',
        'orderby'=> 'date',
        'order'=> $order,
        'status'=> 'publish'
    );
}
$the_query = new WP_Query( $args );
$posts = $the_query->posts;

$data_attrs = array();
if( !empty( $start_from_center ) ) {
    $data_attrs[] = 'data-start-from-center = "1"';
}
if( !empty( $mousewheel_nav ) ) {
    $data_attrs[] = 'data-mousewheel-nav = "1"';
}

?>
<div class = "ps-fade-horizontal" <?php echo implode( ' ', $data_attrs ); ?> >
    <div class = "ps-fade-horizontal-inner">
        <ul class = "ps-fade-horizontal-nav">
            <?php foreach( $posts as $post ) : ?>
            <li class = "ps-fade-horizontal-nav-item" data-bg-color = "<?php echo esc_attr( get_post_meta( $post->ID, 'be_themes_single_overlay_color', true ) ); ?>">
                <a class = "ps-fade-horizontal-nav-item-inner" href = "<?php echo esc_url(get_permalink($post->ID)); ?>">
                    <?php echo esc_html($post->post_title); ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class = "ps-fade-horizontal-gallery">
            <div class = "ps-fade-horizontal-gallery-inner">
            <?php foreach( $posts as $post ) : 
                $attachment_id = get_post_thumbnail_id($post->ID);
                $video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);
                $slide_class = array("ps-fade-slide");
                if( !empty( $video_url ) ) {
                    $slide_class[] = "ps-fade-slide-video";
                    $video_details = be_get_video_details_with_selfhosted_support($video_url);
                    if( !empty($video_details['source']) ) {
                        $slide_class[] = "ps-fade-slide-video-" . $video_details['source'];
                    }
                }
            ?>
            <div class = "<?php echo implode(' ', $slide_class); ?>">
                <?php
                    if(empty($video_url)) :
                ?>
                <img class = "ps-fade-slide-img" data-src = "<?php echo esc_url(get_the_post_thumbnail_url($post->ID, 'full')); ?>" >
                <?php else: ?>
                <?php if( 'selfhosted' !== $video_details['source'] ) : ?>
                <div class = "ps-fade-slide-video-inner">
                <?php endif; ?>
                <?php echo be_carousel_video_with_selfhosted_support( $video_url ); ?>
                <?php if( 'selfhosted' !== $video_details['source'] ) : ?>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php
    wp_reset_postdata();