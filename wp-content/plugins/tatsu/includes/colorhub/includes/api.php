<?php

function colorhub_register_swatch( $swatch ) {
    if( !is_array( $swatch ) ) {
        trigger_error( __( 'Arguments for registering a swatch should be an array', 'tatsu' ), E_USER_NOTICE );
    }
    Colorhub_Swatch_Config::getInstance()->register_swatch( $swatch );
}

function colorhub_deregister_swatch( $id ) {
    if( empty( $id ) ) {
        trigger_error( __( 'Arguments for registering a swatch should be an array', 'tatsu' ), E_USER_NOTICE );
    }
    Colorhub_Swatch_Config::getInstance()->deregister_swatch( $id );
}

function colorhub_register_swatches( $swatches ) {
    if( !is_array( $swatches ) ) {
        trigger_error( __( 'Arguments for registering swatches should be an array', 'tatsu' ), E_USER_NOTICE );
    }
    Colorhub_Swatch_Config::getInstance()->register_swatches( $swatches );
}

function colorhub_deregister_swatches( $ids ) {
    if( empty( $ids ) ) {
        trigger_error( __( 'Arguments for registering swatches should be an array', 'tatsu' ), E_USER_NOTICE );
    }
    Colorhub_Swatch_Config::getInstance()->deregister_swatches( $ids );
}


function colorhub_register_palettes( $palettes ) {
    if( !is_array( $palettes ) ) {
        trigger_error( __( 'Arguments for registering palettes should be an array', 'tatsu' ), E_USER_NOTICE );
    }
    Colorhub_Palette_Config::getInstance()->register_palettes( $palettes );
}

function colorhub_deregister_palettes( $ids ) {
    if( empty( $ids ) ) {
        trigger_error( __( 'Arguments for registering palettes should be an array', 'tatsu' ), E_USER_NOTICE );
    }
    Colorhub_Palette_Config::getInstance()->deregister_palettes( $ids );
}


function colorhub_register_categories( $args ) {
    if( empty( $args ) || !is_array( $args ) ) {
        trigger_error( __( 'Incorrect Arguments to register color option categories', 'tatsu' ), E_USER_NOTICE );
    }
    Colorhub_Options::getInstance()->register_categories( $args );
}

function colorhub_register_category( $id, $label ) {
    if( empty( $args['id'] ) || empty( $label ) ) {
        trigger_error( __( 'Incorrect Arguments to register a color option category', 'tatsu' ), E_USER_NOTICE );
    }
    Colorhub_Options::getInstance()->register_category( $id, $label );
}

function colorhub_deregister_category( $id ) {
    if( empty( $id ) ) {
        trigger_error( __( 'Incorrect Arguments to deregister a color option category', 'tatsu' ), E_USER_NOTICE );
    }
    Colorhub_Options::getInstance()->deregister_category( $id );
}

function colorhub_register_option( $id, $args, $category = 'uncategorized' ) {
    if( empty( $id ) || empty( $args ) || !is_array( $args ) ) {
        trigger_error( __( 'Incorrect Arguments to register a color option', 'tatsu' ), E_USER_NOTICE );
    }
    Colorhub_Options::getInstance()->register_option( $id, $args, $category );
}

function colorhub_register_options( $args, $category = 'uncategorized' ) {
    if( empty( $args ) && !is_array( $args ) ) {
        trigger_error( __( 'Incorrect Arguments to register color options', 'tatsu' ), E_USER_NOTICE );
    }
    Colorhub_Options::getInstance()->register_options( $args, $category );
}

function colorhub_deregister_option( $id ) {
    if( empty( $id ) ) {
        trigger_error( __( 'Incorrect Arguments to deregister a color option', 'tatsu' ), E_USER_NOTICE );
    }
    Colorhub_Options::getInstance()->deregister_option( $id );
}

function colorhub_deregister_options( $ids ) {
    if( empty( $ids ) || !is_array( $ids ) ) {
        trigger_error( __( 'Incorrect Arguments to deregister color options', 'tatsu' ), E_USER_NOTICE );
    }
    Colorhub_Options::getInstance()->deregister_option( $ids );
}

function colorhub_get_swatch( $id ) {
    $swatches = new Colorhub_Swatch();
    if( !empty( $id ) ) {
        return $swatches->get_swatch( $id );
    }
}

function colorhub_get_palette( $id ) {
    $palettes = new Colorhub_Palette();
    return $palettes->get_palette_color( $id );
}

function colorhub_get_values() {
    $store = new Colorhub_Store();
    return $store['values'];
}

/**
 * Import a typehub store, useful for one click importers and other plugins.  
 *
 * @since    1.0.0
 */
function colorhub_import( $data ) {
    $plugin_store = new Colorhub_Store();
    $store = $plugin_store->get_store();
    $swatches = !empty( $store['swatches'] ) ? $store['swatches'] : array();
    $palettes = !empty( $store['palettes'] ) ? $store['palettes'] : array();
    $current_palette = !empty( $palettes['currentPalette'] ) ? $palettes['currentPalette'] : 'default';
    $all_palettes = !empty( $palettes['allPalettes'] ) ? $palettes['allPalettes'] : array();

    

    $new_swatches = ( isset( $data['swatches'] ) && is_array( $data['swatches'] ) ) ? $data['swatches'] : array();
    $new_palettes = ( isset( $data['palettes'] ) && is_array( $data['palettes'] ) ) ? $data['palettes'] : array();
    $new_all_palettes = ( !empty( $new_palettes['allPalettes'] ) ) ? $new_palettes['allPalettes'] : array();

    

    // Merge Swatches
    $data['swatches'] = array_merge( $swatches, $new_swatches );

    //Merge Palettes
    $data['palettes']['currentPalette'] = ( !empty( $new_palettes['currentPalette'] ) ) ? $new_palettes['currentPalette'] : $current_palette;
    $data['palettes']['allPalettes'] = array_merge( $all_palettes, $new_all_palettes );

    return $plugin_store->save_store( $data );

}