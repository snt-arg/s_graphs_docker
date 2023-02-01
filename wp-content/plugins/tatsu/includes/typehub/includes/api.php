<?php
/**
 * API's exposed by the plugin.
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Typehub
 * @subpackage Typehub/public
 */

/**
 * Register multiple categories. 
 *
 * @since    1.0.0
 */
function typehub_register_categories( $args ) {
    if( empty( $args ) || !is_array( $args ) ) {
        trigger_error( __( 'Incorrect Arguments to register font option categories', 'tatsu' ), E_USER_NOTICE );
    }
    Typehub_Options::getInstance()->register_categories( $args );
}

/**
 * Register a single category. 
 *
 * @since    1.0.0
 */
function typehub_register_category( $id, $label ) {
    if( empty( $args['id'] ) || empty( $label ) ) {
        trigger_error( __( 'Incorrect Arguments to register a font option category', 'tatsu' ), E_USER_NOTICE );
    }
    Typehub_Options::getInstance()->register_category( $id, $label );
}

/**
 * De-register a category. 
 *
 * @since    1.0.0
 */
function typehub_deregister_category( $id ) {
    if( empty( $id ) ) {
        trigger_error( __( 'Incorrect Arguments to deregister a font option category', 'tatsu' ), E_USER_NOTICE );
    }
    Typehub_Options::getInstance()->deregister_category( $id );
}

/**
 * Register a single typography option. 
 *
 * @since    1.0.0
 */
function typehub_register_option( $id, $args, $category = 'uncategorized' ) {
    if( empty( $id ) || empty( $args ) || !is_array( $args ) ) {
        trigger_error( __( 'Incorrect Arguments to register a font option', 'tatsu' ), E_USER_NOTICE );
    }
    Typehub_Options::getInstance()->register_option( $id, $args, $category );
}

/**
 * Register multiple typography options. 
 *
 * @since    1.0.0
 */
function typehub_register_options( $args, $category = 'uncategorized' ) {
    if( empty( $args ) && !is_array( $args ) ) {
        trigger_error( __( 'Incorrect Arguments to register font options', 'tatsu' ), E_USER_NOTICE );
    }
    Typehub_Options::getInstance()->register_options( $args, $category );
}

/**
 * De-register a single typography option. 
 *
 * @since    1.0.0
 */
function typehub_deregister_option( $id ) {
    if( empty( $id ) ) {
        trigger_error( __( 'Incorrect Arguments to deregister a font option', 'tatsu' ), E_USER_NOTICE );
    }
    Typehub_Options::getInstance()->deregister_option( $id );
}

/**
 * De-register multiple typography options.
 *
 * @since    1.0.0
 */
function typehub_deregister_options( $ids ) {
    if( empty( $ids ) || !is_array( $ids ) ) {
        trigger_error( __( 'Incorrect Arguments to deregister font options', 'tatsu' ), E_USER_NOTICE );
    }
    Typehub_Options::getInstance()->deregister_option( $ids );
}

/**
 * Register a single font scheme.
 *
 * @since    1.0.0
 */
function typehub_register_font_scheme( $scheme ) {
    if( !is_array( $scheme ) ) {
        trigger_error( __( 'Incorrect Arguments to register a font scheme', 'tatsu' ), E_USER_NOTICE );
    }
    Typehub_Font_Schemes::getInstance()->register_scheme( $scheme );
}

/**
 * De-register a single font scheme.
 *
 * @since    1.0.0
 */
function typehub_deregister_font_scheme( $id ) {
    if( empty( $id ) ) {
        trigger_error( __( 'Incorrect Arguments to deregister a font scheme', 'tatsu' ), E_USER_NOTICE );
    }
    Typehub_Font_Schemes::getInstance()->deregister_scheme( $id );
}

/**
 * Register multiple schemes.
 *
 * @since    1.0.0
 */
function typehub_register_font_schemes( $schemes ) {
    if( !is_array( $schemes ) ) {
        trigger_error( __( 'Incorrect Arguments to register font schemes', 'tatsu' ), E_USER_NOTICE );
    }
    Typehub_Font_Schemes::getInstance()->register_schemes( $schemes );
}

/**
 * De-register multiple schemes.
 *
 * @since    1.0.0
 */
function typehub_deregister_font_schemes( $ids ) {
    if( !is_array( $ids ) ) {
        trigger_error( __( 'Incorrect Arguments to deregister font schemes', 'tatsu' ), E_USER_NOTICE );
    }
    Typehub_Font_Schemes::getInstance()->deregister_schemes( $ids );
}

/**
 * Register a single custom font.
 *
 * @since    1.0.0
 */
function typehub_register_font( $font ) {
    if( !is_array( $font ) ) {
        trigger_error( __( 'Incorrect Arguments to register a custom font', 'tatsu' ), E_USER_NOTICE );
    }
    Typehub_Custom_Fonts::getInstance()->register_font( $font );
}

/**
 * De-register a single custom font.
 *
 * @since    1.0.0
 */
function typehub_deregister_font( $font ) {
    if( !is_string( $font ) ) {
        trigger_error( __( 'Incorrect Arguments to deregister a custom font', 'tatsu' ), E_USER_NOTICE );
    }
    Typehub_Custom_Fonts::getInstance()->deregister_font( $font );
}

/**
 * Register multiple custom fonts.
 *
 * @since    1.0.0
 */
function typehub_register_fonts( $fonts ) {
    if( !is_array( $fonts ) ) {
        trigger_error( __( 'Incorrect Arguments to register custom fonts', 'tatsu' ), E_USER_NOTICE );
    }
    Typehub_Custom_Fonts::getInstance()->register_fonts( $fonts );
}

/**
 * De-register multiple custom fonts.
 *
 * @since    1.0.0
 */
function typehub_deregister_fonts( $fonts ) {
    if( !is_array( $fonts ) ) {
        trigger_error( __( 'Incorrect Arguments to deregister custom fonts', 'tatsu' ), E_USER_NOTICE );
    }
    Typehub_Custom_Fonts::getInstance()->deregister_fonts( $fonts );
}

/**
 * Get font source of a custom font.
 *
 * @since    1.0.0
 */
function typehub_get_custom_font_source( $font ) {
    if( !is_string( $font ) ) {
        return $false;
    }
    $font_data = Typehub_Custom_Fonts::getInstance()->get_font( $font );
    if( !empty( $font_data['src'] ) ) {
        return $font_data['src'];
    } else {
        return false;
    }
}

/**
 * Get the typehub store.
 *
 * @since    1.0.0
 */
function typehub_get_store() {
    $plugin_store = new Typehub_Store();
    return $plugin_store->get_store();
}

/**
 * To separate font source part from the font family value and retrieve the font name.  
 *
 * @since    1.0.0
 */
function typehub_get_font_family( $font ) {
    $store = typehub_get_store();
    $font = explode( ':', $font );
    if( !empty( $font[1] ) ) {
        $family = $font[1];
    } else {
        $family = $font[0];
    }
    $font_schemes = !empty( $store['fontSchemes'] ) ? $store['fontSchemes'] : array();
    if( !empty( $font_schemes[$family] ) ) {
        $scheme_family = explode( ':', $font_schemes[$family]['fontFamily'] );
        if( !empty( $scheme_family[1] ) ) {
            $family = $scheme_family[1];
        } else {
            $family = $scheme_family[0];
        }
    }
    return $family;  
}

/**
 * Import a typehub store, useful for one click importers and other plugins.  
 *
 * @since    1.0.0
 */
function typehub_import( $data ) {
    $plugin_store = new Typehub_Store();
    $store = $plugin_store->get_store();
    $saved_values = !empty( $store['savedValues'] ) ? $store['savedValues'] : array();
    $font_schemes = !empty( $store['fontSchemes'] ) ? $store['fontSchemes'] : array();
    $settings_value = !empty( $store['settings'] ) ? $store['settings'] : array();
    $custom_value = !empty( $store['custom'] ) ? $store['custom'] : array();

    $new_values = ( isset( $data['savedValues'] ) && is_array( $data['savedValues'] ) ) ? $data['savedValues'] : array();
    $new_schemes = ( isset( $data['fontSchemes'] ) && is_array( $data['fontSchemes'] ) ) ? $data['fontSchemes'] : array();
    $new_settings = ( isset( $data['settings'] ) && is_array( $data['settings'] ) ) ? $data['settings'] : array();
    $new_custom = ( isset( $data['custom'] ) && is_array( $data['custom'] ) ) ? $data['custom'] : array();

    // Merge Saved Values
    $data['savedValues'] = array_merge( $saved_values, $new_values );

    //Merge Font Schemes
    $data['fontSchemes'] = array_merge( $font_schemes, $new_schemes );

    //Merge settings values
    $data['settings'] = array_merge( $settings_value, $new_settings );

    //Merge custom values
    $data['custom'] = array_merge( $custom_value, $new_custom );

    return $plugin_store->save_store( $data );

}

/**
 * Get Exposed Fonts
 */
function typehub_get_exposed_selectors() {
    $plugin_store = new Typehub_Store();
    $store = $plugin_store->get_store();
    $options = !empty( $store['optionConfig'] ) && is_array( $store['optionConfig'] ) ? $store['optionConfig'] : array();
    $exposed_selectors = array();
    foreach( $options as $option => $config ) {
        if( ( array_key_exists( 'expose', $config ) && !empty( $config[ 'expose' ] ) ) || ( array_key_exists( 'category', $config ) && $config[ 'category' ] == 'Custom' ) )  {
            $exposed_selectors[ $option ] = $config[ 'label' ];
        }
    }     
    return $exposed_selectors;
}

function typehub_get_font_options(){
    $plugin_store = new Typehub_Store();
    $store = $plugin_store->get_store();
    
    $font_schemes = $store['fontSchemes'];
    $typekit_fonts = '';
    $google_fonts = include TYPEHUB_PLUGIN_DIR.'includes/fonts/google-fonts.php';
    $standard_fonts = be_standard_fonts();
    $custom_fonts = Typehub_Custom_Fonts::getInstance()->get_fonts();
    $typekit_fonts = array();
    if( !empty( $store['settings']['typekitId'] ) ) {
        $typekit_fonts = typehub_get_typekit_data($store['settings']['typekitId']);
    }

    $font_options = array(
        'typekit' => $typekit_fonts,
        'google' => $google_fonts,
        'custom' => $custom_fonts,
        'standard' => $standard_fonts,
        'schemes' => $font_schemes,
        'typekit_id' => !empty($store['settings']['typekitId']) ? $store['settings']['typekitId'] : ''
    );

    return $font_options;
    
}