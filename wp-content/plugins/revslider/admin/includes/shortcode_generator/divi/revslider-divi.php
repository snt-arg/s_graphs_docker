<?php

if ( ! function_exists( 'revslider_initialize_divi_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 1.0.0
 */
function revslider_initialize_divi_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/RevsliderDivi.php';
}
add_action( 'divi_extensions_init', 'revslider_initialize_divi_extension' );
endif;
