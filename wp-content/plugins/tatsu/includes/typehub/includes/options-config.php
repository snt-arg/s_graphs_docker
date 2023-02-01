<?php

add_action( 'typehub_register_options', 'typehub_default_options' );
function typehub_default_options() {
    $options = array(
        'h1' => array(
            'label' => __( 'Heading 1', 'typehub' ),
            'selector' => 'h1',
            'responsive' => true,
            'options' => array(
                'font-family' => 'scheme:primary',
                'font-variant' => 'Bold 700',
                'font-size' => '50px',
                'text-transform' => 'none',
                'letter-spacing' => '-1px',
                'line-height' => '1.5'
            )
        ),
        'h2' => array(
            'label' => __( 'Heading 2', 'typehub' ),
            'selector' => 'h2',
            'responsive' => true,
            'options' => array(
                'font-family' => 'scheme:primary',
                'font-variant' => 'Bold 700',
                'font-size' => '44px',
                'text-transform' => 'none',
                'letter-spacing' => '-1px',
                'line-height' => '1.5'
            )
        ),
        'h3' => array(
            'label' => __( 'Heading 3', 'typehub' ),
            'selector' => 'h3',
            'responsive' => true,
            'options' => array(
                'font-family' => 'scheme:primary',
                'font-variant' => 'Bold 700',
                'font-size' => '36px',
                'text-transform' => 'none',
                'letter-spacing' => '-1px',
                'line-height' => '1.5'
            )
        ),
        'h4' => array(
            'label' => __( 'Heading 4', 'typehub' ),
            'selector' => 'h4',
            'responsive' => true,
            'options' => array(
                'font-family' => 'scheme:primary',
                'font-variant' => 'Semi-Bold 600',
                'font-size' => '28px',
                'text-transform' => 'none',
                'letter-spacing' => '-1px',
                'line-height' => '1.6'
            )
        ),
        'h5' => array(
            'label' => __( 'Heading 5', 'typehub' ),
            'selector' => 'h5',
            'responsive' => true,
            'options' => array(
                'font-family' => 'scheme:primary',
                'font-variant' => 'Medium 500',
                'font-size' => '20px',
                'text-transform' => 'none',
                'letter-spacing' => '0px',
                'line-height' => '1.6'
            )
        ),
        'h6' => array(
            'label' => __( 'Heading 6', 'typehub' ),
            'selector' => 'h6',
            'responsive' => true,
            'options' => array(
                'font-family' => 'scheme:primary',
                'font-variant' => 'Medium 500',
                'font-size' => '16px',
                'text-transform' => 'none',
                'letter-spacing' => '0px',
                'line-height' => '1.6'
            )
        ),
        'body' => array(
            'label' => __( 'Body', 'typehub' ),
            'selector' => 'body',
            'responsive' => true,
            'options' => array(
                'font-family' => 'scheme:secondary',
                'font-variant' => 'Normal 400',
                'font-size' => '16px',
                'text-transform' => 'none',
                'letter-spacing' => '0px',
                'line-height' => '1.7'
            )
        )
    );
    typehub_register_options( $options, 'General' );
}
?>