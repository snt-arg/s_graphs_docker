<?php
add_action( 'colorhub_register_swatches', 'colorhub_default_swatches' );

function colorhub_default_swatches() {
    $swatches = array(
        array(
            'id' => 'red',
            'label' => 'Red',
            'color' => '#f44336',
        ),
        array(
            'id' => 'pink',
            'label' => 'Pink',
            'color' => '#E91E63',
        ),
        array(
            'id' => 'purple',
            'label' => 'Purple',
            'color' => '#9C27B0',
        ),
        array(
            'id' => 'deep-purple',
            'label' => 'Deep Purple',
            'color' => '#673AB7',
        ),
        array(
            'id' => 'indigo',
            'label' => 'Indigo',
            'color' => '#3F51B5',
        ),
        array(
            'id' => 'red',
            'label' => 'Red',
            'color' => '#f44336',
        ),
        array(
            'id' => 'blue',
            'label' => 'Blue',
            'color' => '#2196F3',
        ),
        array(
            'id' => 'light-blue',
            'label' => 'Light Blue',
            'color' => '#03A9F4',
        ),
        array(
            'id' => 'cyan',
            'label' => 'Cyan',
            'color' => '#00BCD4',
        ),
        array(
            'id' => 'teal',
            'label' => 'Teal',
            'color' => '#009688',
        ),
        array(
            'id' => 'green',
            'label' => 'Green',
            'color' => '#4CAF50',
        ),
        array(
            'id' => 'light-green',
            'label' => 'Light Green',
            'color' => '#8BC34A',
        ),
        array(
            'id' => 'lime',
            'label' => 'Lime',
            'color' => '#CDDC39',
        ),
        array(
            'id' => 'yellow',
            'label' => 'Yellow',
            'color' => '#FFEB3B',
        ),
        array(
            'id' => 'amber',
            'label' => 'Amber',
            'color' => '#FFC107',
        ),
        array(
            'id' => 'orange',
            'label' => 'Orange',
            'color' => '#FF9800',
        ),
        array(
            'id' => 'deep-orange',
            'label' => 'Deep Orange',
            'color' => '#FF5722',
        ),
        array(
            'id' => 'brown',
            'label' => 'Brown',
            'color' => '#795548',
        ),
        array(
            'id' => 'grey',
            'label' => 'Grey',
            'color' => '#9E9E9E',
        ),
        array(
            'id' => 'blue-grey',
            'label' => 'Blue Grey',
            'color' => '#607D8B',
        ),
        array(
            'id' => 'white',
            'label' => 'White',
            'color' => '#ffffff',
        ),
        array(
            'id' => 'black',
            'label' => 'Black',
            'color' => '#000000',
        ),                                  
    );
    colorhub_register_swatches( $swatches );
}
