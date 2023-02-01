<?php  /***** For blog style10 : Show below the post content**********/ ?>
<div class="clearfix single-page-atts child">
    <div class="clearfix single-page-att single-post-share">
        <div class="share-links clearfix"><?php echo be_get_share_button_show_hide(get_the_permalink(), get_the_title(), get_the_ID() ); ?></div>
    </div>
    <div class="clearfix single-page-att single-post-tags">
        <?php //echo get_the_tag_list('<div class="tagcloud">','','</div>'); ?>

        <?php
            $author_name = get_the_author_meta( 'first_name' ).' '.get_the_author_meta( 'last_name' );
            //$author_description = get_the_author_meta('description');
        ?>
        <?php if( !empty( $author_name ) ) { ?>

            <div id="single-author-info" class="clearfix">
                <div id="single-author-img">
                    <?php 
                        echo get_avatar( get_the_author_meta( 'ID' ), 128 );
                    ?>
                </div>
                <div id="single-author-details">
                    <strong> Written by </strong>
                    <h4><?php echo $author_name; ?></h4>
                    
                </div>    
            </div>

        <?php } ?>
        </div>

</div>