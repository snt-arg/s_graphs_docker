<?php
add_action( 'colorhub_register_options', 'colorhub_default_options' );

function colorhub_default_options() {
    $options = array(
        'h1' => array(
            'label' => __( 'Heading 1', 'colorhub' ),
            'selector' => 'h1',
            'options' => array( 'text' ),
        ),
        'h2' => array(
            'label' => __( 'Heading 2', 'colorhub' ),
            'selector' => 'h2',
            'options' => array( 'text' ),
        ),
        'h3' => array(
            'label' => __( 'Heading 3', 'colorhub' ),
            'selector' => 'h3',
            'options' => array( 'text' ),
        ),
        'h4' => array(
            'label' => __( 'Heading 4', 'colorhub' ),
            'selector' => 'h4',
            'options' => array( 'text' ),
        ),
        'h5' => array(
            'label' => __( 'Heading 5', 'colorhub' ),
            'selector' => 'h5',
            'options' => array( 'text' ),
        ),
        'h6' => array(
            'label' => __( 'Heading 6', 'colorhub' ),
            'selector' => 'h6',
            'options' => array( 'text' ),
        ),
        'body' => array(
            'label' => __( 'Body', 'colorhub' ),
            'selector' => 'body',
            'options' => array( 'text' ),
        ),
        'anchor' => array(
            'label' => __( 'Links', 'colorhub' ),
            'selector' => 'a',
            'states' => array( 'default', 'hover', 'visited' ),
            'options' => array('text'),
        )
    );
    colorhub_register_options( $options );

}


