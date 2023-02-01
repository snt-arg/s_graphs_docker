<?php

// load class files
include_once( 'classes/class-msp-db.php' );
include_once( 'classes/class-msp-core-widget.php' );
include_once( 'classes/class-msp-main-widget.php' );
include_once( 'classes/class-msp-gallery-extention.php' );

// load libs
include_once( 'lib/aq-resizer.php' );

do_action( 'masterslider_classes_loaded' );

// commeon functions
include_once( 'msp-functions.php' );
include_once( 'msp-hooks.php' );
include_once( 'msp-template-tags.php' );
// load shortcode files
include_once( 'msp-shortcodes.php' );
// load
include_once( 'lib/vcomposer.php' );

include_once( 'modules/elementor/class-msp-elementor.php' );
