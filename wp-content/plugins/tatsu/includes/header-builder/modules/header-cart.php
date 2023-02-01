<?php 

function tatsu_cart( $atts, $content ) {

    $atts = shortcode_atts( array(
        'icon_color' => '',
        'margin' => '',
        'hide_in' => '',
        'key' => be_uniqid_base36(true)
    ), $atts );

    extract( $atts );

    $output = '';
    $visibility_classes = '';
    $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_cart', $key, 'Header' );
    $unique_class = 'tatsu-'.$key;
    $cart_icon = file_get_contents( TATSU_PLUGIN_DIR . 'includes/header-builder/img/tatsu_header_cart.svg' );

    //Handle Resposive Visibility controls
    if( !empty( $hide_in ) ) {
        $hide_in = explode(',', $hide_in);
        foreach ( $hide_in as $device ) {
            $visibility_classes .= ' tatsu-hide-'.$device;
        }
    }

    $output =  '<div class="tatsu-header-module tatsu-cart '.$unique_class.' '.$visibility_classes.'">   
                    '.$cart_icon
                    .$custom_style_tag.'
                </div>';

    return $output;
}

add_shortcode( 'tatsu_cart', 'tatsu_cart' );

?>