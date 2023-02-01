<?php
    global $be_themes_data;
    if( 'top' == $be_themes_data['opt-header-type'] ){
        $hamburger_style = ( !empty( $be_themes_data['top_header_hamburger_style'] ) ) ? basename($be_themes_data['top_header_hamburger_style'], '.jpg') : '';
    } else if( 'left' == $be_themes_data['opt-header-type'] ){
        $hamburger_style = ( !empty( $be_themes_data['left_header_hamburger_style'] ) ) ?  basename($be_themes_data['left_header_hamburger_style'], '.jpg') : '';
    }
?>
<span class="be-mobile-menu-icon <?php echo $hamburger_style ?>">   
        <span class="hamburger-line-1"></span>
        <span class="hamburger-line-2"></span>
        <span class="hamburger-line-3"></span>
</span>