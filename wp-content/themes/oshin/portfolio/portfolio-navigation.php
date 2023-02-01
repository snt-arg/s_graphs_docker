<?php
    global $be_themes_data;
    $portfolio_home_page = get_post_meta( get_the_ID(), 'be_themes_portfolio_home_page', true); //Get link from Meta Options
    $portfolio_home_page = ($portfolio_home_page == '' ? $be_themes_data['portfolio_home_page'] : $portfolio_home_page) ; //Get link from Options panel link is not present in Meta Options
    $portfolio_catg_traversal = (1 == get_post_meta( get_the_ID(), 'be_themes_traverse_catg', true) ? true : false);
    if ( is_singular( 'portfolio' ) ) {    
        if(!empty($portfolio_home_page)) {
            $url = $portfolio_home_page;
        } else {
            $url = site_url();
        }
    } else {
        $url = be_get_posts_page_url();
    }
    $next_post = get_previous_post($portfolio_catg_traversal, ' ', 'portfolio_categories');
    $prev_post = get_next_post($portfolio_catg_traversal, ' ', 'portfolio_categories');
    $portfolio_nav_grid_icon = pathinfo( $be_themes_data['portfolio_nav_bottom_grid_icon'], PATHINFO_FILENAME );
    if( empty( $portfolio_nav_grid_icon ) ) {
        $portfolio_nav_grid_icon = 'six-filled';
    }
?>
<div id = "portfolio-navigation-bottom-wrap">
    <div id = "portfolio-navigation-bottom" <?php if( true == $be_themes_data['portfolio_nav_bottom_wrap']) { echo "class='tatsu-wrap'"; } ?> >
        <?php 
        if( $prev_post ){
            $prev_id = get_permalink($prev_post->ID);
            $prev_title = str_replace('"', '\'', $prev_post->post_title);
        ?>
            <div class="navigation-previous" style = <?php 
                if( true == $be_themes_data['portfolio_nav_bottom_thumbnail'] ){
                    if( $prev_post ){ 
                        echo "background-image:url(". wp_get_attachment_image_src( get_post_thumbnail_id($prev_post->ID ), 'portfolio' )[0] .")"; 
                    }
                } ?>>
                <a href = "<?php echo $prev_id ?>" title = "<?php echo $prev_title ?>" class = "navigation-previous-post-link" >
                    <div class="previous-arrow">
                        <span class = "arrow-line-one"></span>
                        <span class = "arrow-line-two"></span>
                        <span class = "arrow-line-three"></span>
                    </div>
                    <div class="previous-title"><?php echo $prev_title ?></div>
                </a>
            </div>
        <?php } 
        if( $be_themes_data['portfolio_nav_bottom_grid'] == true ){ ?>
            <div class="navigation-grid">
                <a href = "<?php echo $url ?>" class = "portfolio-url">
                    <div class="home-grid-icon <?php echo esc_attr( $portfolio_nav_grid_icon ); ?>">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <?php if( $portfolio_nav_grid_icon != 'four-filled' && $portfolio_nav_grid_icon != 'four-hollow' ) {//This means definiely 6 or 9 ?>
                            <span></span>
                            <span></span>
                        <?php
                            }
                            if( $portfolio_nav_grid_icon == 'nine-filled' || $portfolio_nav_grid_icon == 'nine-hollow' ) { ?>
                            <span></span>
                            <span></span>
                            <span></span>
                        <?php
                            } 
                        ?>
                    </div>
                </a>
            </div>
        <?php } 
        if( $next_post ){
            $next_id = get_permalink($next_post->ID);
            $next_title = str_replace('"', '\'', $next_post->post_title);
        ?>
            <div class="navigation-next" style = <?php 
                if( true == $be_themes_data['portfolio_nav_bottom_thumbnail'] ){
                    if( $next_post ){ 
                        echo "background-image:url(". wp_get_attachment_image_src( get_post_thumbnail_id($next_post->ID ), 'portfolio' )[0] .")"; 
                    }
                } ?>>
                <a href = "<?php echo $next_id ?>" title = "<?php echo $next_title ?>" class = "navigation-next-post-link" >
                    <div class="next-title"><?php echo $next_title ?></div>
                    <div class="next-arrow">
                        <span class = "arrow-line-one"></span>
                        <span class = "arrow-line-two"></span>
                        <span class = "arrow-line-three"></span>
                    </div>
                </a>              
            </div>
        <?php } ?>
    </div>
</div>