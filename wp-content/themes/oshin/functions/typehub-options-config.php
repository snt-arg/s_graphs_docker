<?php
add_action( 'typehub_register_options', 'oshine_typehub_options' );
function oshine_typehub_options() {

    $typography_options = include get_template_directory().'/functions/typography-options.php';

    if( $typography_options ) {
        foreach( $typography_options as $category => $options ) {
            typehub_register_options( $options, $category );
        }
    }
}
?>