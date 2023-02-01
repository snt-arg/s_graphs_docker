<?php
/**
 * Default Header Builder Template
 */
if(function_exists('is_tatsu_standalone') && is_tatsu_standalone()){
    do_action( 'get_header',null,array());
    if(file_exists(TATSU_PLUGIN_DIR . "includes/header-builder/single-tatsu_header-standalone.php")){
        load_template( TATSU_PLUGIN_DIR . "includes/header-builder/single-tatsu_header-standalone.php",true, array());
    }

    do_action( 'get_footer',null,array());
    if(file_exists(TATSU_PLUGIN_DIR . "includes/footer-builder/single-tatsu_footer-standalone.php")){
        load_template( TATSU_PLUGIN_DIR . "includes/footer-builder/single-tatsu_footer-standalone.php",true, array());
    }
}else{
get_header(); 
get_footer(); 
}
?>