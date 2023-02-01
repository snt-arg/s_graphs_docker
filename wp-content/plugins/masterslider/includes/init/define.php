<?php

// no direct access allowed
if ( ! defined('ABSPATH') ) {
    die();
}

define( 'MSWP_AVERTA_VERSION'		, '3.6.1' );

define( 'MSWP_SLUG'					, 'masterslider' );
define( 'MSWP_TEXT_DOMAIN'			, 'masterslider' );

define( 'MSWP_AVERTA_DIR'			, dirname( dirname( plugin_dir_path( __FILE__ ) ) ) );
define( 'MSWP_AVERTA_URL'			, plugins_url( '', dirname( plugin_dir_path( __FILE__ ) ) ) );
define( 'MSWP_AVERTA_BASE_NAME'		, plugin_basename( MSWP_AVERTA_DIR ) . '/masterslider.php' ); // masterslider/masterslider.php


define( 'MSWP_AVERTA_ADMIN_DIR'		, MSWP_AVERTA_DIR . '/admin' );
define( 'MSWP_AVERTA_ADMIN_URL'		, MSWP_AVERTA_URL . '/admin' );

define( 'MSWP_AVERTA_INC_DIR'		, MSWP_AVERTA_DIR . '/includes' );
define( 'MSWP_AVERTA_INC_URL'		, MSWP_AVERTA_URL . '/includes' );

define( 'MSWP_AVERTA_PUB_DIR'		, MSWP_AVERTA_DIR . '/public' );
define( 'MSWP_AVERTA_PUB_URL'		, MSWP_AVERTA_URL . '/public' );

define( 'MSWP_BLANK_IMG' 			, MSWP_AVERTA_PUB_URL . '/assets/css/blank.gif' );

define( 'MSWP_AVERTA_FEED_URL'		, '' );

// To override origin uploads url while importing slider images
// define( 'MSWP_IMPORT_FETCH_DIR'		, '' );
