<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * Uninstalling MasterSlider deletes tables(sliders), user roles and options.
 *
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2014 averta
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit( 'No Naughty Business Please !' );
}

// To uninstall the plugin completely you need to define MS_UNINSTALL_PLUGIN constant in wp-config.php file
// before deleting it from plugins page
if ( defined( 'MSWP_UNINSTALL_PLUGIN' ) ) {

	global $wpdb;

	// MasterSlider Tables
	$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "masterslider_sliders" );
	$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "masterslider_options" );

	// MasterSlider user roles
	$roles = array( 'administrator', 'editor' );

	foreach ( $roles as $role ) {
		$role = get_role( $role );
		$role->remove_cap( 'access_masterslider'  ); 
		$role->remove_cap( 'publish_masterslider' ); 
		$role->remove_cap( 'delete_masterslider'  ); 
		$role->remove_cap( 'create_masterslider'  );
		$role->remove_cap( 'export_masterslider'  );
		$role->remove_cap( 'duplicate_masterslider'  );
	}

	// Delete Masterslider related options
	$wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'masterslider_%';");

	// Delete custom css directory
	$uploads   = wp_upload_dir();
	$css_dir   = $uploads['basedir'] . '/masterslider' ;
	rmdir( $css_dir );
}