<?php 
function tatsu_slide_menu_column( $atts, $content ) {

    $atts = shortcode_atts( array (
        'sidebar_vertical_alignment' => '',
        'sidebar_horizontal_alignment' => '',
        'hide_in' => '',
        'key' => be_uniqid_base36(true)
    ) , $atts );
    
    extract( $atts );
    $output = '';
    $visibility_classes = '';
    $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_slide_menu_column', $key, 'Header' );
    $unique_class = 'tatsu-'.$key;
    $id = !empty( $id ) ? 'id="'.$id.'"' : '';

    //Handle Resposive Visibility controls
    if( !empty( $hide_in ) ) {
        $hide_in = explode(',', $hide_in);
        foreach ( $hide_in as $device ) {
            $visibility_classes .= ' tatsu-hide-'.$device;
        }
    }

    $output .= '<div class="tatsu-slide-menu-col '.$unique_class.' '.$visibility_classes.' " '.$id.'>';
    $output .= do_shortcode( $content );
    $output .= $custom_style_tag;
    $output .= '</div>';  

    return $output;
}

add_shortcode( 'tatsu_slide_menu_column', 'tatsu_slide_menu_column' );

?>