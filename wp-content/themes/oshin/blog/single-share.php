<div class="clearfix single-page-atts">
    <div class="clearfix single-page-att single-post-share">
        <div class="share-links clearfix"><?php echo be_get_share_button(get_the_permalink(), get_the_title(), get_the_ID() ); ?></div>
    </div>
    <div class="clearfix single-page-att single-post-tags">
        <?php echo get_the_tag_list('<div class="tagcloud">','','</div>'); ?>
    </div>
</div>
<?php
    $author_name = get_the_author_meta( 'display_name' );
    $author_description = get_the_author_meta('description');
?>
<?php if( !empty( $author_name ) && !empty( $author_description ) ) { ?>

    <div id="single-author-info" class="clearfix">
        <div id="single-author-img">
            <?php 
                echo get_avatar( get_the_author_meta( 'ID' ), 128 );
            ?>
        </div>
        <div id="single-author-details">
            <h6><?php echo $author_name; ?></h6>
            <p><?php echo nl2br( $author_description ); ?></p>
        </div>    
    </div>

<?php } ?>