<?php global $be_themes_data; ?>
    <div id="header-controls-left">
        <div class="hamburger-nav-controller-wrap">
            <div class="menu-controls hamburger-nav-controller" title="Hamburger Menu Controller">
                <?php get_template_part( 'headers/header','hamburger' ); ?>
            </div>
        </div>
        <?php
            if($be_themes_data['opt-header-pos']['left']) {
                foreach ($be_themes_data['opt-header-pos']['left'] as $key => $value) {
                    if( !( ($key == 'smenu') && ( be_is_special_top_menu() || be_is_special_top_menu( 'menu-animate-fall' ) ) ) ){
                        be_themes_get_header_widgets($key);
                    }
                }
            }
        ?>
    </div>
    <?php
        if((!isset($be_themes_data['disable_logo']) || empty($be_themes_data['disable_logo'])) || (isset($be_themes_data['disable_logo']) && (0 == $be_themes_data['disable_logo'])) ){?>
        <div class="logo">
            <?php be_themes_get_header_logo_image(); ?>
        </div>
        <?php } ?>
        <div id="header-controls-right">
            <?php 
                if($be_themes_data['opt-header-pos']['right']) {
                    foreach ($be_themes_data['opt-header-pos']['right'] as $key => $value) {
                        if( !( ($key == 'smenu') && ( be_is_special_top_menu() || be_is_special_top_menu( 'menu-animate-fall' ) ) ) ){
                            be_themes_get_header_widgets($key);
                        }
                    }
                }?>
            <div class="mobile-nav-controller-wrap">
                <div class="menu-controls mobile-nav-controller" title="Mobile Menu Controller"> <?php get_template_part( 'headers/header','hamburger' ); ?></div>
            </div>
        </div>