<?php
add_action( 'typehub_register_schemes', 'typehub_default_schemes' );
function typehub_default_schemes() {
    $schemes = array(
        array(
            'id' => 'primary',
            'font-family' => 'google:Montserrat',
            'name' => __('Primary Font', 'typehub'),
            'active' => true,
        ),
        array(
            'id' => 'secondary',
            'font-family' => 'google:Roboto',
            'name' => __('Secondary Font', 'typehub'),
            'active' => true,
        )        
    );
    typehub_register_font_schemes( $schemes );
}
?>