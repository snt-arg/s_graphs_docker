<?php
    global $be_themes_data;
    extract( be_themes_header_details() );
?>
<header id="header">
    <div id="header-inner-wrap" class="<?php echo $header_class; echo ' '.$header_style; ?>" <?php echo ' '.$full_screen_header_scheme; ?>>
        <?php
            extract(be_themes_calculate_logo_height());
            if((!empty($header_transparent) && isset($header_transparent) && 'none' != $header_transparent)) {
                $default_header_height = $logo_transparent_height;
            } else {
                $default_header_height = $logo_height;
            }
        ?>
        <div id = "left-header-mobile" class="clearfix"><?php
            if((!isset($be_themes_data['disable_logo']) || empty($be_themes_data['disable_logo'])) || (isset($be_themes_data['disable_logo']) && (0 == $be_themes_data['disable_logo'])) ){
            ?>
            <div class="logo">
                <?php be_themes_get_header_logo_image(); ?>
            </div>
            <?php 
            }?>
            <div class="mobile-nav-controller-wrap">
                <div class="menu-controls mobile-nav-controller" title="Mobile Menu Controller"><?php get_template_part( 'headers/header','hamburger' ); ?></div>
            </div>
            <?php 
            be_themes_get_header_woocommerce_cart_widget();?>
        </div>
        <?php
            be_themes_get_header_mobile_navigation();
        ?>
    </div>
</header> <!-- END HEADER -->