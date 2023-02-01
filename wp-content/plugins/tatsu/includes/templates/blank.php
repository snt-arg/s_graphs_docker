<?php
/*
 * Template Name: Tatsu Template
 * Description: A simple wide tatsu Template
 */
    global $post;
    get_header();
    do_action( 'tatsu_before_content' );
    while(have_posts()): the_post();
?>
    <div id = "tatsu-content">
        <?php the_content() ?>
    </div>
<?php
    endwhile;
    do_action( 'tatsu_after_content' );
    get_footer();