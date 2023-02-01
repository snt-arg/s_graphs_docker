<?php
global $be_themes_data;
    
?>
    <div id="header-controls-left">
        <?php
            if($be_themes_data['opt-header-pos']['left']) {
                foreach ($be_themes_data['opt-header-pos']['left'] as $key => $value) {
                    be_themes_get_header_widgets($key);
                }
            }
        ?>
    </div>
    <nav id="navigation" class="clearfix">	<?php
        be_themes_get_header_navigation();?>
    </nav><!-- End Navigation -->
    <div id="header-controls-right">
        <?php
            if(isset($be_themes_data['top-menu-style']) && !empty($be_themes_data['top-menu-style']) && $be_themes_data['top-menu-style'] == 'menu-animate-fall') { ?>
                <div class="menu-controls menu-falling-animate-controller"><?php get_template_part( 'headers/header','hamburger' ); ?></div>
            <?php } 
            if($be_themes_data['opt-header-pos']['right']) {
                foreach ($be_themes_data['opt-header-pos']['right'] as $key => $value) {
                    be_themes_get_header_widgets($key);
                }
            }
            if(isset($be_themes_data['top-menu-style']) && ('top-overlay-menu' == ($be_themes_data['top-menu-style'])) && !( array_key_exists("smenu", $be_themes_data['opt-header-pos']['right'])) ) {
                be_themes_get_header_widgets('smenu');
            }
            ?>
        <div class="mobile-nav-controller-wrap">
            <div class="menu-controls mobile-nav-controller" title="Mobile Menu Controller"> <?php get_template_part( 'headers/header','hamburger' ); ?></div>
        </div>
    </div>