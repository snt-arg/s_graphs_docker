<?php 
/***** For blog style10 **********/
global $be_themes_data; 
$be_themes_data['blog_show_filters']=false;
$be_themes_data['blog_items_per_page']= 3;
$be_themes_data['blog_pagination_style']="none";
$related_posts_section_title =  isset($be_themes_data['related_posts_section_title'])?$be_themes_data['related_posts_section_title']:'Industry Insights';
?>
<section id="related-posts">
        <div class="be-wrap clearfix">
            <h2><?php echo $related_posts_section_title; ?></h2>
        <?php
            get_template_part( 'blog/single','masonry');
        ?>
        </div>
</section>