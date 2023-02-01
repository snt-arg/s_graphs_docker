<?php

/*----------------------------------------------------------------------------*
 * Members Plugin
 *----------------------------------------------------------------------------*/

add_action( 'plugins_loaded', 'msp_on_all_plugins_loaded' );

function msp_on_all_plugins_loaded() {
	// Add master slider custom capabilities to members plugin if it's installed
	if ( function_exists( 'members_get_capabilities' ) )
		add_filter( 'members_get_capabilities', 'msp_add_custom_cap_to_members_plugin' );
}


/**
 * Add master slider custom capabilities to Members plugin if it's installed
 *
 * @since    1.0.0
 */
function msp_add_custom_cap_to_members_plugin( $caps ) {
	$caps[] = 'access_masterslider' ;
	$caps[] = 'publish_masterslider';
	$caps[] = 'delete_masterslider' ;
	$caps[] = 'create_masterslider' ;
	$caps[] = 'export_masterslider' ;
	$caps[] = 'duplicate_masterslider' ;
	return $caps;
}

/*----------------------------------------------------------------------------*/