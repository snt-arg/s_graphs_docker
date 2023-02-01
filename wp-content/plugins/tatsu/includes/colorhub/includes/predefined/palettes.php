<?php
add_action( 'colorhub_register_palettes', 'colorhub_default_palettes' );

function colorhub_default_palettes() {
    $palettes = array(
        array(
            'id' => 'default',
            'colors' => array(
                '#e0a240',
                '#ffffff',
                '#f2f3f8',
                '#7a7a7a',
                '#000000'
            ),
        ),
    );
    colorhub_register_palettes( $palettes );
}

